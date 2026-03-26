<?php

namespace App\Models;

use PDO;

class Booking
{
    private PDO $db;

    public string $bookingId;
    public int $userId;
    public string $fieldId;
    public string $slotId;
    public string $bookingDate;
    public float $totalPrice = 0;
    public string $paymentMethod = 'Tiền mặt';
    public string $paymentStatus = 'Chưa thanh toán';
    public string $status = 'Đã đặt';
    public ?string $note = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    // Các trường JOIN từ bảng khác (dùng để hiển thị)
    public ?string $fieldName = null;
    public ?string $fieldAddress = null;
    public ?string $startTime = null;
    public ?string $endTime = null;
    public ?string $slotLabel = null;
    public ?string $fieldImage = null;

    public ?string $fullname = null;
    public ?string $phone = null;
    public ?string $email = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Lấy danh sách các khung giờ (slot_id) đã được đặt của một sân trong một ngày cụ thể.
     * Trạng thái đơn đặt không bao gồm 'Đã hủy'.
     * [Sử dụng ở]: 
     *  - FieldDetailController::index (Hiển thị các slot đã bị đặt trên trang chi tiết sân)
     *  - BookingController::create (Kiểm tra lại slot trước khi hiện form đặt sân)
     *  - BookingController::store (Kiểm tra lần cuối trước khi tạo hóa đơn mới)
     */
    public function getBookedSlotIds(string $fieldId, string $date): array
    {
        $stmt = $this->db->prepare("
            SELECT slot_id 
            FROM bookings 
            WHERE field_id = :field_id 
              AND booking_date = :date 
              AND status != 'Đã hủy'
        ");
        $stmt->execute([
            'field_id' => $fieldId,
            'date' => $date
        ]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Lấy danh sách các đơn đặt sân của một người dùng cụ thể.
     * [Sử dụng ở]: 
     *  - BookingController::index (Hiển thị lịch sử đặt sân của người dùng)
     */
    public function findByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, 
                   f.field_name, f.address, f.image,
                   st.start_time, st.end_time, st.label
            FROM bookings b
            JOIN fields f ON b.field_id = f.field_id
            JOIN field_slots fs ON b.slot_id = fs.field_slot_id
            JOIN slot_templates st ON fs.template_id = st.template_id
            WHERE b.user_id = :user_id
            ORDER BY b.booking_date DESC, st.start_time DESC
        ");
        $stmt->execute(['user_id' => $userId]);

        return array_map(
            fn($row) => $this->hydrate(new Booking($this->db), $row),
            $stmt->fetchAll()
        );
    }

    /**
     * Lấy tất cả các đơn đặt sân của tất cả các sân thuộc về một Chủ sân (Owner).
     * [Sử dụng ở]: 
     *  - OwnerController::allBookings (Trang quản lý đơn hàng trung tâm của Chủ sân)
     */
    public function findByOwnerId(int $ownerId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, 
                   u.full_name as user_fullname, u.phone as user_phone, u.email as user_email,
                   f.field_name, f.address, f.image,
                   st.start_time, st.end_time, st.label
            FROM bookings b
            JOIN users u ON b.user_id = u.user_id
            JOIN fields f ON b.field_id = f.field_id
            JOIN field_slots fs ON b.slot_id = fs.field_slot_id
            JOIN slot_templates st ON fs.template_id = st.template_id
            WHERE f.user_id = :owner_id
            ORDER BY b.booking_date DESC, st.start_time ASC
        ");
        $stmt->execute(['owner_id' => $ownerId]);

        $results = [];
        while ($row = $stmt->fetch()) {
            $b = $this->hydrate(new Booking($this->db), $row);
            $b->fullname = $row['user_fullname'] ?? null;
            $b->phone = $row['user_phone'] ?? null;
            $b->email = $row['user_email'] ?? null;
            $results[] = $b;
        }
        return $results;
    }

    /**
     * Tìm chi tiết một đơn đặt sân theo ID.
     * [Sử dụng ở]: 
     *  - OwnerController::updatePaymentStatus (Xác định đơn hàng cần cập nhật thanh toán)
     *  - BookingController::cancel (Xác định đơn hàng cần hủy)
     */
    public function findById(string $id): ?Booking
    {
        $stmt = $this->db->prepare("
            SELECT b.*, 
                   f.field_name, f.address, f.image,
                   st.start_time, st.end_time, st.label
            FROM bookings b
            JOIN fields f ON b.field_id = f.field_id
            JOIN field_slots fs ON b.slot_id = fs.field_slot_id
            JOIN slot_templates st ON fs.template_id = st.template_id
            WHERE b.booking_id = :id
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate(new Booking($this->db), $row) : null;
    }

    /**
     * Lưu thông tin đơn đặt sân (INSERT nếu mới, UPDATE nếu đã có ID).
     * [Sử dụng ở]: 
     *  - BookingController::store (Tạo mới đơn đặt sân)
     *  - BookingController::cancel (Cập nhật trạng thái thành 'Đã hủy')
     *  - OwnerController::updatePaymentStatus (Cập nhật trạng thái thanh toán)
     */
    public function save(): bool
    {
        if (empty($this->bookingId)) {
            $this->bookingId = $this->generateUUID();

            // on conflict xử lý cho trường hợp đã hủy muốn đặt lại có thể đặt được
            $sql = "INSERT INTO bookings
                    (booking_id, user_id, field_id, slot_id, booking_date,
                     total_price, payment_method, payment_status, status, note,
                     created_at, updated_at)
                VALUES
                    (:booking_id, :user_id, :field_id, :slot_id, :booking_date,
                     :total_price, :payment_method, :payment_status, :status, :note,
                     CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
                ON CONFLICT (field_id, slot_id, booking_date)
                DO UPDATE SET
                    booking_id     = EXCLUDED.booking_id,
                    user_id        = EXCLUDED.user_id,
                    total_price    = EXCLUDED.total_price,
                    payment_method = EXCLUDED.payment_method,
                    payment_status = EXCLUDED.payment_status,
                    status         = EXCLUDED.status,
                    note           = EXCLUDED.note,
                    updated_at     = CURRENT_TIMESTAMP
                WHERE bookings.status = 'Đã hủy'";

            $params = [
                'booking_id'     => $this->bookingId,
                'user_id'        => $this->userId,
                'field_id'       => $this->fieldId,
                'slot_id'        => $this->slotId,
                'booking_date'   => $this->bookingDate,
                'total_price'    => $this->totalPrice,
                'payment_method' => $this->paymentMethod,
                'payment_status' => $this->paymentStatus,
                'status'         => $this->status,
                'note'           => $this->note,
            ];
        } else {
            $sql = "UPDATE bookings
                SET status         = :status,
                    payment_status = :payment_status,
                    updated_at     = CURRENT_TIMESTAMP
                WHERE booking_id = :booking_id";

            $params = [
                'booking_id'     => $this->bookingId,
                'status'         => $this->status,
                'payment_status' => $this->paymentStatus,
            ];
        }

        return $this->db->prepare($sql)->execute($params);
    }

    private function hydrate(Booking $obj, array $row): Booking
    {
        $obj->bookingId = $row['booking_id'];
        $obj->userId = (int) $row['user_id'];
        $obj->fieldId = $row['field_id'];
        $obj->slotId = $row['slot_id'];
        $obj->bookingDate = $row['booking_date'];
        $obj->totalPrice = (float) $row['total_price'];
        $obj->paymentMethod = $row['payment_method'] ?? 'Tiền mặt';
        $obj->paymentStatus = $row['payment_status'] ?? 'Chưa thanh toán';
        $obj->status = $row['status'] ?? 'Đã đặt';
        $obj->note = $row['note'] ?? null;
        $obj->createdAt = $row['created_at'] ?? null;
        $obj->updatedAt = $row['updated_at'] ?? null;

        // Joined fields
        $obj->fieldName = $row['field_name'] ?? null;
        $obj->fieldAddress = $row['address'] ?? null;
        $obj->startTime = $row['start_time'] ?? null;
        $obj->endTime = $row['end_time'] ?? null;
        $obj->slotLabel = $row['label'] ?? null;
        $obj->fieldImage = $row['image'] ?? null;

        return $obj;
    }

    private function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
