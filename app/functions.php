<?php

if (!function_exists('PDO')) {
    function PDO(): PDO
    {
        global $PDO;
        return $PDO;
    }
}

if (!function_exists('AUTHGUARD')) {
    function AUTHGUARD(): App\SessionGuard
    {
        global $AUTHGUARD;
        return $AUTHGUARD;
    }
}

if (!function_exists('dd')) {
    function dd($var)
    {
        var_dump($var);
        exit();
    }
}

if (!function_exists('redirect')) {
    function redirect($location, array $data = [])
    {
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
        header('Location: ' . $location, true, 302);
        exit();
    }
}

if (!function_exists('session_get_once')) {
    function session_get_once($name, $default = null)
    {
        $value = $default;
        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name];
            unset($_SESSION[$name]);
        }
        return $value;
    }
}

// Tạo CSRF token, lưu vào session (dùng cho mọi form POST)
if (!function_exists('generate_csrf_token')) {
    function generate_csrf_token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

// In thẻ hidden chứa CSRF token — gọi trong mọi form
if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = generate_csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}

// Kiểm tra CSRF token từ form POST — gọi đầu mỗi handler
if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token(): void
    {
        $posted = $_POST['csrf_token'] ?? '';
        $stored = $_SESSION['csrf_token'] ?? '';

        if (empty($posted) || empty($stored) || !hash_equals($stored, $posted)) {
            http_response_code(403);
            exit('Yêu cầu không hợp lệ (CSRF token không khớp). Vui lòng tải lại trang và thử lại.');
        }
    }
}
