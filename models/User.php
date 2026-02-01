<?php
// models/User.php

class User
{
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
}
