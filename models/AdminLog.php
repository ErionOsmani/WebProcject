<?php

class AdminLog
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function add(int $adminId, string $action, string $details = ""): bool
    {
        if ($adminId <= 0) return false;

        $action = trim($action);
        $details = trim($details);

        if ($action === "") return false;

        $stmt = $this->db->prepare("
            INSERT INTO admin_logs (admin_id, action, details)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$adminId, $action, $details]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT
              l.id, l.action, l.details, l.created_at,
              u.full_name AS admin_name, u.email AS admin_email
            FROM admin_logs l
            INNER JOIN users u ON u.id = l.admin_id
            ORDER BY l.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
