<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct()
    {
        if (AUTHGUARD()->isUserLoggedIn()) {
            redirect('/');
        }
        parent::__construct();
    }

    public function showRegisterForm()
    {
        $this->create();
    }

    public function create()
    {
        $data = [
            'old' => $this->getSavedFormValues(),
            'errors' => session_get_once('errors'),
        ];
        $this->sendPage('auth/register', $data);
    }

    public function store()
    {
        verify_csrf_token();
        $this->saveFormValues($_POST, ['password', 'confirm_password']);

        $data = $this->filterUserData($_POST);
        $newUser = new User(PDO());
        $errors = $newUser->validate($data); // Hàm validate đưa vào model để xử lý giúp gọn nhẹ hơn, trả về mảng errors

        if (!empty($errors)) {
            redirect('/register', ['errors' => $errors]);
        }

        $newUser->fill($data)->save();
        redirect('/login', ['messages' => ['success' => 'Đăng ký thành công! Vui lòng đăng nhập.']]);
    }

    protected function filterUserData(array $data): array
    {
        return [
            // strip_tags để xóa thẻ html
            'fullname' => strip_tags(trim($data['fullname'] ?? '')),
            // check thật sự có đúng là email không
            'email' => filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL),
            // biểu thức chính quy /\D/ tìm tất cả các ký tự không phải là số, xóa hết chỉ giữ lại số
            'phone' => preg_replace('/\D/', '', $data['phone'] ?? ''),
            'password' => $data['password'] ?? null,
            'password_confirmation' => $data['confirm_password'] ?? null,
        ];
    }
}
