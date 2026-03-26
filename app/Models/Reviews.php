<?php

namespace App\Models;

use PDO;

class Reviews
{
    private PDO $db;

    public string $reviewId;
    public int $userId;
    public string $fieldId;
    public ?string $content = null;
    public ?string $createdAt = null;
    public ?string $fullName = null;
    public ?string $avatar = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function findByField(string $fieldId): array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, u.full_name as fullname, u.avatar as avatar
            FROM   reviews r
            JOIN   users u ON u.user_id = r.user_id
            WHERE  r.field_id = :fid
            ORDER  BY r.created_at DESC
        ");
        $stmt->execute(['fid' => $fieldId]);

        $results = [];
        foreach ($stmt->fetchAll() as $row) {
            $results[] = $this->toObject($row);
        }
        return $results;
    }

    public function save(): bool
    {
        $this->reviewId = $this->generateUUID();
        $stmt = $this->db->prepare("
            INSERT INTO reviews (review_id, user_id, field_id, content)
            VALUES (:review_id, :user_id, :field_id, :content)
        ");
        return $stmt->execute([
            'review_id' => $this->reviewId,
            'user_id' => $this->userId,
            'field_id' => $this->fieldId,
            'content' => $this->content,
        ]);
    }

    public function update(int $userId, string $reviewId, string $content): bool
    {
        $stmt = $this->db->prepare("
            UPDATE reviews
            SET content = :content
            WHERE review_id = :review_id AND user_id = :user_id
        ");
        return $stmt->execute([
            'content' => $content,
            'review_id' => $reviewId,
            'user_id' => $userId,
        ]);
    }

    public function delete(int $userId, string $reviewId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM reviews
            WHERE user_id = :user_id
              AND review_id = :review_id
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'review_id' => $reviewId,
        ]);
    }

    private function toObject(array $data): Reviews
    {
        $review = new Reviews($this->db);
        $review->reviewId = $data['review_id'];
        $review->userId = (int)$data['user_id'];
        $review->fieldId = $data['field_id'];
        $review->content = $data['content'] ?? null;
        $review->createdAt = $data['created_at'] ?? null;
        $review->fullName = $data['fullname'] ?? null;
        $review->avatar = $data['avatar'] ?? null;
        return $review;
    }

    private function generateUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
