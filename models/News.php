<?php

class News
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT id, title, content, image, admin_id, created_at
            FROM news
            ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, title, content, image, admin_id, created_at
            FROM news
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $title, string $content, ?string $image, int $adminId): bool
    {
        $title = trim($title);
        $content = trim($content);

        if ($title === "" || $content === "" || $adminId <= 0) return false;

        $stmt = $this->db->prepare("
            INSERT INTO news (title, content, image, admin_id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$title, $content, $image, $adminId]);
    }

    public function update(int $id, string $title, string $content, ?string $newImage = null): bool
    {
        if ($id <= 0) return false;

        $title = trim($title);
        $content = trim($content);

        if ($title === "" || $content === "") return false;


        if ($newImage === null) {
            $stmt = $this->db->prepare("UPDATE news SET title=?, content=? WHERE id=?");
            return $stmt->execute([$title, $content, $id]);
        }

        $stmt = $this->db->prepare("UPDATE news SET title=?, content=?, image=? WHERE id=?");
        return $stmt->execute([$title, $content, $newImage, $id]);
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) return false;
        $stmt = $this->db->prepare("DELETE FROM news WHERE id=?");
        return $stmt->execute([$id]);
    }
}
