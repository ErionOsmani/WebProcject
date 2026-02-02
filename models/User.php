<?php

class User
{
    public function getAll(): array
{
    $stmt = $this->db->query("SELECT id, full_name, email, role, created_at FROM users ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateRole(int $id, string $role): bool
{
    if ($id <= 0) return false;
    if (!in_array($role, ["admin", "user"], true)) return false;

    $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
    return $stmt->execute([$role, $id]);
}


public function delete(int $id): bool
{
    if ($id <= 0) return false;
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}

    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function register(string $fullName, string $email, string $password): bool
    {
        $fullName = trim($fullName);
        $email = trim($email);

        if ($fullName === "" || $email === "" || $password === "") {
            return false;
        }

        if ($this->findByEmail($email)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'user')");
        return $stmt->execute([$fullName, $email, $hash]);
    }

    public function login(string $email, string $password): ?array
    {
        $email = trim($email);
        if ($email === "" || $password === "") {
            return null;
        }

        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user["password"])) {
            return null;
        }

        return [
            "id" => (int)$user["id"],
            "full_name" => $user["full_name"],
            "email" => $user["email"],
            "role" => $user["role"]
        ];
    }

    public function findById(int $id): ?array
{
    $stmt = $this->db->prepare("SELECT id, full_name, email, role FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    return $u ?: null;
}

}
