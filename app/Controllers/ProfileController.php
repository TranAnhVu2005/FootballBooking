<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Lớp ProfileController quản lý thông tin hồ sơ của người dùng.
 * Bao gồm việc hiển thị trang cá nhân và cập nhật thông tin (tên, số điện thoại, avatar).
 */
class ProfileController extends Controller
{
    /**
     * Hàm khởi tạo (constructor).
     * Kiểm tra trạng thái đăng nhập: Nếu chưa đăng nhập thì buộc chuyển hướng về trang login.
     */
    public function __construct()
    {
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }
        parent::__construct();
    }

    /**
     * Phương thức index() hiển thị trang hồ sơ cá nhân.
     */
    public function index()
    {
        // Lấy thông tin người dùng hiện tại từ AUTHGUARD
        $user = AUTHGUARD()->user();

        // Chuẩn bị dữ liệu để gửi sang View, bao gồm cả các thông báo lỗi hoặc thành công từ Session
        $data = [
            'user'     => $user,
            'messages' => session_get_once('messages'),
            'errors'   => session_get_once('errors'),
        ];

        // Gửi dữ liệu và hiển thị trang 'profile'
        $this->sendPage('profile', $data);
    }

    /**
     * Phương thức update() xử lý việc cập nhật thông tin cá nhân khi người dùng nhấn "Lưu".
     */
    public function update()
    {
        // Kiểm tra mã CSRF để đảm bảo yêu cầu là hợp lệ từ trang web của mình
        verify_csrf_token();

        $user   = AUTHGUARD()->user();
        $errors = [];

        // Lấy và làm sạch dữ liệu từ form POST
        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');

        // Kiểm tra hợp lệ (Validation) cho Họ tên
        if (empty($fullname)) {
            $errors['fullname'] = 'Họ tên không được để trống.';
        } elseif (mb_strlen($fullname) > 100) {
            $errors['fullname'] = 'Họ tên không được quá 100 ký tự.';
        }

        // Kiểm tra hợp lệ (Validation) cho Số điện thoại
        if (empty($phone)) {
            $errors['phone'] = 'Số điện thoại không được để trống.';
        } elseif (!preg_match('/^(0[35789])[0-9]{8}$/', $phone)) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        /**
         * Xử lý tải ảnh đại diện (avatar).
         * Chỉ thực hiện khi không có lỗi nhập liệu và file được tải lên thành công (UPLOAD_ERR_OK).
         */
        if (empty($errors) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarPath = $this->handleAvatarUpload($_FILES['avatar'], $errors);
            if ($avatarPath) {
                // Nếu tải lên thành công, cập nhật đường dẫn ảnh mới vào model người dùng
                $user->avatar = $avatarPath;
            }
        }

        // Nếu có bất kỳ lỗi nào, chuyển hướng về lại trang profile kèm theo danh sách lỗi
        if (!empty($errors)) {
            redirect('/profile', ['errors' => $errors]);
        }

        // Cập nhật thông tin vào đối tượng model $user
        $user->fullname = $fullname;
        $user->phone    = $phone;

        // Lưu thông tin vào Cơ sở dữ liệu
        if ($user->save()) {
            redirect('/profile', ['messages' => ['success' => 'Cập nhật thông tin thành công!']]);
        } else {
            redirect('/profile', ['errors' => ['db' => 'Lỗi khi cập nhật cơ sở dữ liệu.']]);
        }
    }

    /**
     * Phương thức handleAvatarUpload() xử lý kỹ thuật việc upload tệp tin ảnh.
     * Kiểm tra MIME thực tế, kích thước file và đặt tên file ngẫu nhiên để bảo mật.
     */
    private function handleAvatarUpload(array $file, array &$errors): ?string
    {
        // Các loại tệp cho phép và giới hạn dung lượng (3MB)
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        $maxBytes     = 3 * 1024 * 1024; // 3 MB

        // Kiểm tra loại nội dung thật của file (Dùng mime_content_type để tránh bị giả mạo đuôi file)
        $realMime = mime_content_type($file['tmp_name']);
        if (!in_array($realMime, $allowedMimes, true)) {
            $errors['avatar'] = 'Ảnh đại diện phải là JPG, PNG, WebP hoặc GIF.';
            return null;
        }

        // Kiểm tra kích thước file
        if ($file['size'] > $maxBytes) {
            $errors['avatar'] = 'Ảnh đại diện không được vượt quá 3MB.';
            return null;
        }

        // Bản đồ ánh xạ từ MIME type sang phần mở rộng file
        $extMap = [
            'image/jpeg' => 'jpg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        //Gán lại đuôi file
        $ext       = $extMap[$realMime];
        // Đường dẫn tuyệt đối đến thư mục lưu trữ avatar
        $uploadDir = ROOTDIR . 'public/assets/uploads/avatars/';

        // Tự động tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        /**
         * Tạo tên file ngẫu nhiên bằng uniqid().
         * Việc đặt tên ngẫu nhiên giúp tránh lộ tên gốc của người dùng và ngăn chặn ghi đè file cũ.
         */
        $fileName = uniqid('avatar_', true) . '.' . $ext;
        $dest     = $uploadDir . $fileName;

        // Di chuyển file từ thư mục tạm sang thư mục đích chính thức
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $errors['avatar'] = 'Không thể lưu ảnh lên server. Thử lại sau.';
            return null;
        }

        // Trả về đường dẫn tương đối để lưu vào Database và hiển thị trên Web
        return '/assets/uploads/avatars/' . $fileName;
    }
}
