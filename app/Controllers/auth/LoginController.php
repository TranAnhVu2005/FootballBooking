<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $this->create();
    }

    public function create()
    {
        if (AUTHGUARD()->isUserLoggedIn()) {
            redirect('/');
        }

        $data = [
            'messages' => session_get_once('messages'),
            'old' => $this->getSavedFormValues(),
            'errors' => session_get_once('errors'),
        ];

        $this->sendPage('auth/login', $data);
    }

    public function store()
    {
        // Chặn CSRF
        verify_csrf_token();

        $credentials = $this->filterUserCredentials($_POST);
        $errors = [];
        $loginId = $credentials['login_id'];

        // Xác định đăng nhập bằng email hay số điện thoại
        $column = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = (new User(PDO()))->where($column, $loginId);

        if ($user->userId === -1) {
            $errors['login_id'] = 'Sai email, số điện thoại hoặc mật khẩu.';
        }
        elseif ($user->role !== 'ADMIN' && $user->status === 'INACTIVE') {
            $errors['login_id'] = 'Tài khoản của bạn đã bị khóa.';
        }
        elseif (AUTHGUARD()->login($user, $credentials)) {
            // Đăng nhập thành công
            if (AUTHGUARD()->user()->role === 'ADMIN') {
                redirect('/admin');
            }
            else {
                redirect('/');
            }
        }
        else {
            $errors['password'] = 'Sai email, số điện thoại hoặc mật khẩu.';
        }

        // Đăng nhập thất bại: giữ lại giá trị form (không giữ password)
        $this->saveFormValues($_POST, ['password']);
        redirect('/login', ['errors' => $errors]);
    }

    public function destroy()
    {
        AUTHGUARD()->logout();
        redirect('/login');
    }

    protected function filterUserCredentials(array $data): array
    {
        return [
            'login_id' => trim($data['login_id'] ?? ''),
            'password' => $data['password'] ?? null,
        ];
    }
}
