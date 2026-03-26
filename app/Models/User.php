<?php

namespace App\Models;

use PDO;

class User
{
    private PDO $db;

    public int $userId = -1;
    public string $fullname;
    public string $email;
    public string $password;
    public string $phone;
    public string $role;
    public string $status;
    public ?string $avatar = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }
    public function where(string $column, string $value): User
    {
        $allowedColumns = ['user_id', 'full_name', 'email', 'phone', 'role', 'status'];
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Invalid column name: $column");
        }
        $statement = $this->db->prepare("select * from users where $column = :value");
        $statement->execute(['value' => $value]);
        $row = $statement->fetch();
        if ($row) {
            $this->fillFromDbRow($row);
        }
        return $this;
    }

    public function save(): bool
    {
        $result = false;

        if ($this->userId !== -1) {
            $statement = $this->db->prepare(
                'update users set full_name = :full_name, email = :email, password = :password, phone = :phone, role = :role, status = :status, avatar = :avatar, updated_at = now() where user_id = :user_id'
            );
            $result = $statement->execute([
                'user_id' => $this->userId,
                'full_name' => $this->fullname,
                'email' => $this->email,
                'password' => $this->password,
                'phone' => $this->phone,
                'role' => $this->role,
                'status' => $this->status,
                'avatar' => $this->avatar
            ]);
        } else {
            $statement = $this->db->prepare(
                'insert into users (full_name, email, password, phone, role, status, avatar, created_at, updated_at)
                values (:full_name, :email, :password, :phone, :role, :status, :avatar, now(), now())'
            );
            $result = $statement->execute([
                'full_name' => $this->fullname,
                'email' => $this->email,
                'password' => $this->password,
                'phone' => $this->phone,
                'role' => $this->role ?? 'USER',
                'status' => $this->status ?? 'ACTIVE',
                'avatar' => $this->avatar
            ]);
            if ($result) {
                $this->userId = (int)$this->db->lastInsertId();
            }
        }

        return $result;
    }

    public function fill(array $data): User // Điền dữ liệu từ form

    {
        $this->fullname = $data['fullname'];
        $this->email = $data['email'];
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->phone = $data['phone'];
        $this->role = $data['role'] ?? 'USER';
        $this->status = $data['status'] ?? 'ACTIVE';
        return $this;
    }

    private function fillFromDbRow(array $row) // Kéo dữ liệu tạo thành obj

    {
        $this->userId = (int)$row['user_id'];
        $this->fullname = $row['full_name'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->phone = $row['phone'];
        $this->role = $row['role'];
        $this->status = $row['status'];
        $this->avatar = $row['avatar'] ?? null;
    }

    private function isEmailInUse(string $email): bool
    {
        $statement = $this->db->prepare('select count(*) from users where email = :email');
        $statement->execute(['email' => $email]);
        return $statement->fetchColumn() > 0;
    }
    private function isPhoneInUse(string $phone): bool
    {
        $statement = $this->db->prepare('select count(*) from users where phone = :phone');
        $statement->execute(['phone' => $phone]);
        return $statement->fetchColumn() > 0;
    }


    public function validate(array $data): array
    {
        $errors = [];

        // Họ tên
        if (empty(trim($data['fullname'] ?? ''))) {
            $errors['fullname'] = 'Họ tên không được để trống.';
        } elseif (mb_strlen($data['fullname']) > 100) {
            $errors['fullname'] = 'Họ tên không được quá 100 ký tự.';
        }

        // Email
        if (!$data['email']) {
            $errors['email'] = 'Định dạng email không hợp lệ.';
        } elseif ($this->isEmailInUse($data['email'])) {
            $errors['email'] = 'Email này đã được sử dụng.';
        }

        // Số điện thoại
        if (empty($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không được để trống.';
        } elseif (!preg_match('/^(0[35789])[0-9]{8}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ (VD: 0912345678).';
        } elseif ($this->isPhoneInUse($data['phone'])) {
            $errors['phone'] = 'Số điện thoại này đã được sử dụng.';
        }

        // Mật khẩu
        if (strlen($data['password'] ?? '') < 8) {
            $errors['password'] = 'Mật khẩu phải chứa ít nhất 8 ký tự.';
        } elseif ($data['password'] != $data['password_confirmation']) {
            $errors['password'] = 'Mật khẩu xác nhận không khớp.';
        }

        return $errors;
    }
    public function findAll(): array
    {
        $statement = $this->db->prepare('select * from users order by created_at desc');
        $statement->execute();
        $users = [];
        foreach ($statement->fetchAll() as $row) {
            $user = new User($this->db);
            $user->fillFromDbRow($row);
            $users[] = $user;
        }
        return $users;
    }
}
