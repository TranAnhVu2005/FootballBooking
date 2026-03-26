<?php

namespace App\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }

        if (AUTHGUARD()->user()->role !== 'ADMIN') {
            http_response_code(403);
            exit('Bạn không có quyền truy cập trang này (403 Forbidden).');
        }

        parent::__construct();
    }

    public function index()
    {
        $users = (new User(PDO()))->findAll();
        $this->sendPage('admin/dashboard', [
            'users'    => $users,
            'messages' => session_get_once('messages'),
        ]);
    }

    // Khóa tài khoản người dùng
    public function deactivate()
    {
        verify_csrf_token();

        $targetId = (int) ($_POST['user_id'] ?? 0);
        $this->toggleStatus($targetId, 'INACTIVE');
        redirect('/admin', ['messages' => ['success' => 'Đã khóa tài khoản thành công.']]);
    }

    // Mở khóa tài khoản người dùng
    public function activate()
    {
        verify_csrf_token();

        $targetId = (int) ($_POST['user_id'] ?? 0);
        $this->toggleStatus($targetId, 'ACTIVE');
        redirect('/admin', ['messages' => ['success' => 'Đã mở khóa tài khoản thành công.']]);
    }

    // Logic dùng chung để chuyển trạng thái user, không cho Admin tự thay đổi mình
    private function toggleStatus(int $targetId, string $newStatus): void
    {
        if ($targetId <= 0) {
            return;
        }

        $selfId = AUTHGUARD()->user()->userId;

        // Không cho phép admin tự thay đổi trạng thái của chính mình
        if ($targetId === $selfId) {
            return;
        }

        $target = (new User(PDO()))->where('user_id', (string) $targetId);

        if ($target->userId !== -1) {
            $target->status = $newStatus;
            $target->save();
        }
    }
    // Đặt vai trò OWNER cho người dùng
    public function setOwner()
    {
        verify_csrf_token();

        $targetId = (int) ($_POST['user_id'] ?? 0);
        $this->toggleRole($targetId, 'OWNER');
        redirect('/admin', ['messages' => ['success' => 'Đã cấp quyền Chủ sân thành công.']]);
    }

    // Thu hồi quyền OWNER, trả về USER
    public function revokeOwner()
    {
        verify_csrf_token();

        $targetId = (int) ($_POST['user_id'] ?? 0);
        $this->toggleRole($targetId, 'USER');
        redirect('/admin', ['messages' => ['success' => 'Đã thu hồi quyền Chủ sân.']]);
    }

    // Logic chung để thay đổi role của user, không cho Admin tự thay đổi mình
    private function toggleRole(int $targetId, string $newRole): void
    {
        if ($targetId <= 0) {
            return;
        }

        $selfId = AUTHGUARD()->user()->userId;

        // Không cho phép admin thay đổi role của chính mình
        if ($targetId === $selfId) {
            return;
        }

        $target = (new User(PDO()))->where('user_id', (string) $targetId);

        // Chỉ thay đổi nếu user tồn tại và không phải ADMIN
        if ($target->userId !== -1 && $target->role !== 'ADMIN') {
            $target->role = $newRole;
            $target->save();
        }
    }
}
