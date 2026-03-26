<?php

namespace App\Models;

use PDO;

class FieldSlot
{
    private PDO $db;

    public string  $fieldSlotId;
    public string  $fieldId;
    public string  $templateId;
    public float   $price       = 0;
    public bool    $isActive    = true;

    // Từ JOIN với slot_templates (đọc thêm, không ghi)
    public ?string $startTime   = null;
    public ?string $endTime     = null;
    public ?string $label       = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    // Lấy tất cả slot của 1 sân (JOIN với template để có giờ + label)
    public function findByField(string $fieldId): array
    {
        $stmt = $this->db->prepare("
            SELECT fs.*,
                   st.start_time,
                   st.end_time,
                   st.label
            FROM   field_slots fs
            JOIN   slot_templates st ON st.template_id = fs.template_id
            WHERE  fs.field_id = :fid
            ORDER  BY st.start_time
        ");
        $stmt->execute(['fid' => $fieldId]);

        return array_map(
            fn($row) => $this->hydrate(new FieldSlot($this->db), $row),
            $stmt->fetchAll()
        );
    }

    // Lấy slot đang active của 1 sân (dùng cho trang đặt sân)
    public function findActiveByField(string $fieldId): array
    {
        $stmt = $this->db->prepare("
            SELECT fs.*,
                   st.start_time,
                   st.end_time,
                   st.label
            FROM   field_slots fs
            JOIN   slot_templates st ON st.template_id = fs.template_id
            WHERE  fs.field_id = :fid
              AND  fs.is_active = TRUE
            ORDER  BY st.start_time
        ");
        $stmt->execute(['fid' => $fieldId]);

        return array_map(
            fn($row) => $this->hydrate(new FieldSlot($this->db), $row),
            $stmt->fetchAll()
        );
    }

    public function findById(string $id): ?FieldSlot
    {
        $stmt = $this->db->prepare("
            SELECT fs.*,
                   st.start_time,
                   st.end_time,
                   st.label
            FROM   field_slots fs
            JOIN   slot_templates st ON st.template_id = fs.template_id
            WHERE  fs.field_slot_id = :id
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate(new FieldSlot($this->db), $row) : null;
    }

    // Lưu slot — INSERT nếu chưa có, UPDATE nếu đã tồn tại
    public function save(): bool
    {
        if (empty($this->fieldSlotId)) {
            $this->fieldSlotId = $this->generateUUID();
            $sql = "INSERT INTO field_slots
                        (field_slot_id, field_id, template_id, price, is_active)
                    VALUES
                        (:field_slot_id, :field_id, :template_id, :price, :is_active)";
        } else {
            $sql = "UPDATE field_slots
                    SET price     = :price,
                        is_active = :is_active
                    WHERE field_slot_id = :field_slot_id
                      AND field_id      = :field_id";
        }

        return $this->db->prepare($sql)->execute([
            'field_slot_id' => $this->fieldSlotId,
            'field_id'      => $this->fieldId,
            'template_id'   => $this->templateId,
            'price'         => $this->price,
            'is_active'     => $this->isActive ? 1 : 0,
        ]);
    }

    public function delete(): bool
    {
        return $this->db->prepare(
            "DELETE FROM field_slots WHERE field_slot_id = :id"
        )->execute(['id' => $this->fieldSlotId]);
    }

    // Kiểm tra slot đã bị đặt chưa trong 1 ngày cụ thể
    public function isBooked(string $date): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM bookings
            WHERE  slot_id      = :slot_id
              AND  booking_date = :date
              AND  status NOT IN ('cancelled')
        ");
        $stmt->execute([
            'slot_id' => $this->fieldSlotId,
            'date'    => $date,
        ]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function hydrate(FieldSlot $obj, array $row): FieldSlot
    {
        $obj->fieldSlotId = $row['field_slot_id'];
        $obj->fieldId     = $row['field_id'];
        $obj->templateId  = $row['template_id'];
        $obj->price       = (float) $row['price'];
        $obj->isActive    = (bool)  $row['is_active'];
        $obj->startTime   = $row['start_time'] ?? null;
        $obj->endTime     = $row['end_time']   ?? null;
        $obj->label       = $row['label']      ?? null;
        return $obj;
    }

    public static function calculateDefaultPrice(string $typeId, string $templateId): float
    {
        // Nhóm khung giờ ST01-04 (Sáng), ST05-08 (Chiều), ST09-12 (Tối)
        $early   = ['ST01', 'ST02', 'ST03', 'ST04'];
        $mid     = ['ST05', 'ST06', 'ST07', 'ST08'];
        $late    = ['ST09', 'ST10', 'ST11', 'ST12'];

        switch ($typeId) {
            case 'FT001': // Sân 5
                if (in_array($templateId, $early)) return 120000;
                if (in_array($templateId, $mid))   return 160000;
                if (in_array($templateId, $late))  return 200000;
                break;
            case 'FT002': // Sân 7
                if (in_array($templateId, $early)) return 150000;
                if (in_array($templateId, $mid))   return 200000;
                if (in_array($templateId, $late))  return 250000;
                break;
            case 'FT003': // Sân 11
                if (in_array($templateId, $early)) return 300000;
                if (in_array($templateId, $mid))   return 400000;
                if (in_array($templateId, $late))  return 500000;
                break;
            case 'FT004': // Sân Futsal
                if (in_array($templateId, $early)) return 170000;
                if (in_array($templateId, $mid))   return 220000;
                if (in_array($templateId, $late))  return 270000;
                break;
            case 'FT007': // Sân cỏ nhân tạo
                if (in_array($templateId, $early)) return 130000;
                if (in_array($templateId, $mid))   return 170000;
                if (in_array($templateId, $late))  return 210000;
                break;
        }

        return 150000; // Giá mặc định nếu không khớp loại nào
    }

    private function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
