<?php

namespace App;

use App\Models\User;

class SessionGuard
{
    protected $user;

    public function login(User $user, array $credentials): bool
    {
        $verified = password_verify($credentials['password'], $user->password);

        if ($verified) {
            // Chống session fixation: regenerate ID ngay sau xác thực thành công
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->userId;
        }

        return $verified;
    }

    public function user(): ?User
    {
        if (!$this->user && $this->isUserLoggedIn()) {
            $this->user = (new User(PDO()))->where('user_id', $_SESSION['user_id']);
            // Nếu user không tìm thấy (đã xóa), logout luôn
            if ($this->user->userId === -1) {
                $this->logout();
                return null;
            }
        }
        return $this->user;
    }

    public function logout(): void
    {
        $this->user = null;
        session_unset();
        session_regenerate_id(true);
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}
