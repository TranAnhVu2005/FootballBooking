<?php

namespace App\Models;

use PDO;

class SlotTemplate
{
    private PDO $db;

    public string  $templateId;
    public string  $startTime;
    public string  $endTime;
    public ?string $label = null;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    // Lấy tất cả template, sắp theo giờ
    public function findAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM slot_templates ORDER BY start_time"
        );
        return array_map(
            fn($row) => $this->hydrate(new SlotTemplate($this->db), $row),
            $stmt->fetchAll()
        );
    }

    public function findById(string $id): ?SlotTemplate
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM slot_templates WHERE template_id = :id"
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate(new SlotTemplate($this->db), $row) : null;
    }

    public function save(): bool
    {
        if (empty($this->templateId)) {
            $this->templateId = $this->generateUUID();
            $sql = "INSERT INTO slot_templates (template_id, start_time, end_time, label)
                    VALUES (:template_id, :start_time, :end_time, :label)";
        } else {
            $sql = "UPDATE slot_templates
                    SET start_time = :start_time,
                        end_time   = :end_time,
                        label      = :label
                    WHERE template_id = :template_id";
        }

        return $this->db->prepare($sql)->execute([
            'template_id' => $this->templateId,
            'start_time'  => $this->startTime,
            'end_time'    => $this->endTime,
            'label'       => $this->label,
        ]);
    }

    public function delete(): bool
    {
        return $this->db->prepare(
            "DELETE FROM slot_templates WHERE template_id = :id"
        )->execute(['id' => $this->templateId]);
    }

    private function hydrate(SlotTemplate $obj, array $row): SlotTemplate
    {
        $obj->templateId = $row['template_id'];
        $obj->startTime  = $row['start_time'];
        $obj->endTime    = $row['end_time'];
        $obj->label      = $row['label'] ?? null;
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
