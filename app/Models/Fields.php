<?php

namespace App\Models;

use PDO;

class Fields
{
    private PDO $db;

    public string $fieldId;
    public int $userId;
    public string $typeId;
    public string $fieldName;
    public string $address;
    public ?string $description = null;
    public ?string $image = null;
    public string $status;
    public ?string $typeName = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    // Lấy tất cả sân đang ACTIVE, kèm tên loại
    public function findAll(): array
    {
        $sql = "SELECT f.*, ft.type_name
                FROM fields f
                LEFT JOIN field_types ft ON f.type_id = ft.type_id
                WHERE UPPER(f.status) = 'ACTIVE'
                ORDER BY f.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $fields = [];
        foreach ($stmt->fetchAll() as $row) {
            $obj = new Fields($this->db);
            $obj->fillFromDbRow($row);
            $fields[] = $obj;
        }
        return $fields;
    }

    // Lấy N sân nổi bật dùng cho trang chủ
    public function findFeatured(int $limit = 4): array
    {
        $sql = "SELECT f.*, ft.type_name
                FROM fields f
                LEFT JOIN field_types ft ON f.type_id = ft.type_id
                WHERE UPPER(f.status) = 'ACTIVE'
                ORDER BY f.created_at DESC
                LIMIT :lim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $fields = [];
        foreach ($stmt->fetchAll() as $row) {
            $obj = new Fields($this->db);
            $obj->fillFromDbRow($row);
            $fields[] = $obj;
        }
        return $fields;
    }

    // Tìm 1 sân theo ID
    public function findById(string $id): ?Fields
    {
        $sql = "SELECT f.*, ft.type_name
                FROM fields f
                LEFT JOIN field_types ft ON f.type_id = ft.type_id
                WHERE f.field_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row)
            return null;

        $obj = new Fields($this->db);
        $obj->fillFromDbRow($row);
        return $obj;
    }

    // Lấy sân theo chủ sân (dùng trong trang owner)
    public function findByOwner(int $userId): array
    {
        $sql = "SELECT f.*, ft.type_name
                FROM fields f
                LEFT JOIN field_types ft ON f.type_id = ft.type_id
                WHERE f.user_id = :uid
                ORDER BY f.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);

        $fields = [];
        foreach ($stmt->fetchAll() as $row) {
            $obj = new Fields($this->db);
            $obj->fillFromDbRow($row);
            $fields[] = $obj;
        }
        return $fields;
    }

    // Tìm kiếm sân theo tên, địa chỉ hoặc loại sân (dùng trong trang List)
    public function searchFields(string $keyword = '', string $typeId = '', int $limit = 12, int $offset = 0): array
    {
        $sql = "SELECT f.*, ft.type_name
                FROM fields f
                LEFT JOIN field_types ft ON f.type_id = ft.type_id
                WHERE UPPER(f.status) = 'ACTIVE'";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (f.field_name ILIKE :kw OR f.address ILIKE :kw)";
            $params['kw'] = '%' . $keyword . '%';
        }

        if ($typeId !== '') {
            $sql .= " AND f.type_id = :typeId";
            $params['typeId'] = $typeId;
        }

        $sql .= " ORDER BY f.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $fields = [];
        foreach ($stmt->fetchAll() as $row) {
            $obj = new Fields($this->db);
            $obj->fillFromDbRow($row);
            $fields[] = $obj;
        }
        return $fields;
    }

    // Đếm tổng số lượng sân (dùng cho phân trang)
    public function countSearchFields(string $keyword = '', string $typeId = ''): int
    {
        $sql = "SELECT COUNT(f.field_id) as total
                FROM fields f
                WHERE UPPER(f.status) = 'ACTIVE'";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (f.field_name ILIKE :kw OR f.address ILIKE :kw)";
            $params['kw'] = '%' . $keyword . '%';
        }

        if ($typeId !== '') {
            $sql .= " AND f.type_id = :typeId";
            $params['typeId'] = $typeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    // Lưu sân — INSERT hoặc UPDATE tùy fieldId có rỗng không
    public function save(): bool
    {
        if (empty($this->fieldId)) {
            $this->fieldId = $this->generateUUID();
            $sql = "INSERT INTO fields (field_id, user_id, type_id, field_name, address, description, image, status, created_at)
                    VALUES (:field_id, :user_id, :type_id, :field_name, :address, :description, :image, :status, now())";
        } else {
            $sql = "UPDATE fields SET
                        type_id     = :type_id,
                        field_name  = :field_name,
                        address     = :address,
                        description = :description,
                        image       = :image,
                        status      = :status
                    WHERE field_id = :field_id AND user_id = :user_id";
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'field_id' => $this->fieldId,
            'user_id' => $this->userId,
            'type_id' => $this->typeId,
            'field_name' => $this->fieldName,
            'address' => $this->address,
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status ?? 'ACTIVE',
        ]);
    }

    // Xóa sân — xóa toàn bộ dữ liệu liên quan và file ảnh
    public function delete(): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Xóa Reviews liên quan
            $stmt1 = $this->db->prepare("DELETE FROM reviews WHERE field_id = :id");
            $stmt1->execute(['id' => $this->fieldId]);

            // 2. Xóa Bookings liên quan
            $stmt2 = $this->db->prepare("DELETE FROM bookings WHERE field_id = :id");
            $stmt2->execute(['id' => $this->fieldId]);

            // 3. Xóa Field Slots liên quan
            $stmt3 = $this->db->prepare("DELETE FROM field_slots WHERE field_id = :id");
            $stmt3->execute(['id' => $this->fieldId]);

            // 4. Xóa chính bản ghi Sân
            $stmt4 = $this->db->prepare("DELETE FROM fields WHERE field_id = :id AND user_id = :uid");
            $stmt4->execute(['id' => $this->fieldId, 'uid' => $this->userId]);

            // 5. Xóa file ảnh vật lý trên server nếu có
            if (!empty($this->image)) {
                // $this->image chứa đường dẫn dạng '/assets/uploads/fields/abc.jpg'
                $filePath = ROOTDIR . 'public' . $this->image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Lấy danh sách loại sân từ DB; nếu bảng trống thì trả về dữ liệu mặc định
    public function allTypes(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM field_types ORDER BY type_name");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if (!empty($rows)) {
            return $rows;
        }
        return [];
    }

    public function fillFromDbRow(array $row): void
    {
        $this->fieldId = $row['field_id'];
        $this->userId = (int)$row['user_id'];
        $this->typeId = $row['type_id'];
        $this->fieldName = $row['field_name'] ?? '';
        $this->address = $row['address'] ?? '';
        $this->description = $row['description'] ?? null;
        $this->image = $row['image'] ?? null;
        $this->status = $row['status'] ?? 'ACTIVE';
        $this->typeName = $row['type_name'] ?? null;
    }

    private function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
