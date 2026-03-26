<?php

namespace App\Controllers;

use App\Models\Fields;
use App\Models\FieldSlot;

//Các string $id được lấy động từ thư viện  Bramus\Router
class OwnerController extends Controller
{
    public function __construct()
    {
        // Chỉ OWNER mới được vào đây
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }
        if (AUTHGUARD()->user()->role !== 'OWNER') {
            redirect('/');
        }
        parent::__construct();
    }

    // Trang chủ dashboard: liệt kê sân của owner hiện tại
    public function index()
    {
        $userId = AUTHGUARD()->user()->userId;
        $fieldModel = new Fields(PDO());
        $myFields = $fieldModel->findByOwner($userId);

        $this->sendPage('owner/dashboard', [
            'fields' => $myFields,
            'messages' => session_get_once('messages'),
            'errors' => session_get_once('errors'),
        ]);
    }

    // Hiện form tạo sân mới
    public function createField()
    {
        $fieldModel = new Fields(PDO());
        $types = $fieldModel->allTypes();

        $this->sendPage('owner/field_form', [
            'field' => null,
            'types' => $types,
            'errors' => session_get_once('errors'),
            'old' => session_get_once('old'),
        ]);
    }

    // Lưu sân mới vào DB
    public function storeField()
    {
        verify_csrf_token();

        $userId = AUTHGUARD()->user()->userId;
        $errors = $this->validateFieldForm($_POST);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect('/owner/fields/create');
        }

        $field = new Fields(PDO());
        $field->userId = $userId;
        $field->typeId = $_POST['type_id'];
        $field->fieldName = trim($_POST['field_name']);
        $field->address = trim($_POST['address']);
        $field->description = trim($_POST['description'] ?? '');
        $field->status = 'ACTIVE';
        $field->image = null;

        // Xử lý upload ảnh nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($_FILES['image'], $errors);
            if ($imagePath) {
                $field->image = $imagePath;
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            redirect('/owner/fields/create');
        }

        if ($field->save()) {
            // Tự động khởi tạo toàn bộ slot template cho sân mới
            $this->initializeFieldSlots($field->fieldId, $field->typeId);
            redirect('/owner', ['messages' => ['success' => 'Đã thêm sân và khởi tạo các khung giờ thành công!']]);
        }
        else {
            redirect('/owner/fields/create', ['errors' => ['db' => 'Lỗi khi lưu vào cơ sở dữ liệu.']]);
        }
    }

    // Hiện form sửa sân đã có
    public function editField(string $id)
    {
        $field = (new Fields(PDO()))->findById($id);

        if (!$field || $field->userId !== AUTHGUARD()->user()->userId) {
            redirect('/owner');
        }

        $types = (new Fields(PDO()))->allTypes();

        $this->sendPage('owner/field_form', [
            'field' => $field,
            'types' => $types,
            'errors' => session_get_once('errors'),
            'old' => null,
        ]);
    }

    // Cập nhật thông tin sân
    public function updateField(string $id)
    {
        verify_csrf_token();

        $userId = AUTHGUARD()->user()->userId;
        $field = (new Fields(PDO()))->findById($id);

        if (!$field || $field->userId !== $userId) {
            redirect('/owner');
        }

        $errors = $this->validateFieldForm($_POST);
        if (!empty($errors)) {
            redirect('/owner/fields/' . $id . '/edit', ['errors' => $errors]);
        }

        $field->typeId = $_POST['type_id'];
        $field->fieldName = trim($_POST['field_name']);
        $field->address = trim($_POST['address']);
        $field->description = trim($_POST['description'] ?? '');
        $field->status = $_POST['status'] ?? 'ACTIVE';

        // Xử lý upload ảnh mới nếu người dùng chọn file
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($_FILES['image'], $errors);
            if ($imagePath) {
                $field->image = $imagePath;
            }
        }

        if (!empty($errors)) {
            redirect('/owner/fields/' . $id . '/edit', ['errors' => $errors]);
        }

        if ($field->save()) {
            redirect('/owner', ['messages' => ['success' => 'Cập nhật sân thành công!']]);
        }
        else {
            redirect('/owner/fields/' . $id . '/edit', ['errors' => ['db' => 'Lỗi khi cập nhật.']]);
        }
    }

    // Xóa sân
    public function deleteField(string $id)
    {
        verify_csrf_token();

        $userId = AUTHGUARD()->user()->userId;
        $field = (new Fields(PDO()))->findById($id);

        if ($field && $field->userId === $userId) {
            $field->delete();
            redirect('/owner', ['messages' => ['success' => 'Đã xóa sân.']]);
        }
        redirect('/owner');
    }

    // Quản lý Đơn đặt sân của tất cả các sân
    public function allBookings()
    {
        $userId = AUTHGUARD()->user()->userId;

        $bookings = (new \App\Models\Booking(PDO()))->findByOwnerId($userId);

        $this->sendPage('owner/all_bookings', [
            'bookings' => $bookings,
            'messages' => session_get_once('messages'),
            'errors' => session_get_once('errors'),
        ]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus(string $bookingId)
    {
        verify_csrf_token();
        $userId = AUTHGUARD()->user()->userId;

        $booking = (new \App\Models\Booking(PDO()))->findById($bookingId);
        if (!$booking) {
            redirect('/owner', ['errors' => ['system' => 'Không tìm thấy hóa đơn.']]);
        }

        // Kiểm tra sân này có phải của User hiện tại (Owner) hay không
        $field = (new Fields(PDO()))->findById($booking->fieldId);
        if (!$field || $field->userId !== $userId) {
            redirect('/owner', ['errors' => ['system' => 'Không có quyền thực hiện.']]);
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/owner/bookings/';

        $newStatus = trim($_POST['payment_status'] ?? '');
        if ($newStatus === 'Đã thanh toán' || $newStatus === 'Chưa thanh toán') {
            $booking->paymentStatus = $newStatus;

            // (Tuỳ nghiệp vụ, ở đây chỉ đổi trạng thái thanh toán)
            if ($booking->save()) {
                redirect($referer, ['messages' => ['success' => 'Cập nhật thanh toán thành công.']]);
            }
        }
        redirect($referer, ['errors' => ['system' => 'Có lỗi xảy ra, vui lòng thử lại.']]);
    }

    // Tự động khởi tạo toàn bộ slot từ template cho 1 sân mới
    private function initializeFieldSlots(string $fieldId, string $typeId): void
    {
        $templateModel = new \App\Models\SlotTemplate(PDO());
        $templates = $templateModel->findAll();

        foreach ($templates as $st) {
            $fieldSlot = new FieldSlot(PDO());
            $fieldSlot->fieldId = $fieldId;
            $fieldSlot->templateId = $st->templateId;
            $fieldSlot->price = FieldSlot::calculateDefaultPrice($typeId, $st->templateId);
            $fieldSlot->isActive = true;
            $fieldSlot->save();
        }
    }

    // Validate form thêm/sửa sân
    private function validateFieldForm(array $data): array
    {
        $err = [];
        if (empty(trim($data['field_name'] ?? '')))
            $err['field_name'] = 'Tên sân không được để trống.';
        if (empty(trim($data['address'] ?? '')))
            $err['address'] = 'Địa chỉ không được để trống.';
        if (empty($data['type_id'] ?? ''))
            $err['type_id'] = 'Vui lòng chọn loại sân.';
        return $err;
    }

    // Xử lý upload ảnh sân, trả về đường dẫn web nếu thành công
    private function handleImageUpload(array $file, array &$errors): ?string
    {
        $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $allowed, true)) {
            $errors['image'] = 'Ảnh phải là định dạng JPG, PNG hoặc WebP.';
            return null;
        }

        if ($file['size'] > $maxSize) {
            $errors['image'] = 'Ảnh không được vượt quá 5MB.';
            return null;
        }

        $uploadDir = ROOTDIR . 'public/assets/uploads/fields/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('field_', true) . '.' . strtolower($ext);
        $dest = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $errors['image'] = 'Không thể lưu ảnh. Vui lòng thử lại.';
            return null;
        }

        return '/assets/uploads/fields/' . $fileName;
    }
}
