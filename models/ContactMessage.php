<?php

class ContactMessage
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function create(string $name, string $email, string $message): bool
    {
        $name = trim($name);
        $email = trim($email);
        $message = trim($message);

        if ($name === "" || $email === "" || $message === "") return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        $stmt = $this->db->prepare("
            INSERT INTO contact_messages (name, email, message)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$name, $email, $message]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT id, name, email, message, created_at
            FROM contact_messages
            ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
