<?php
// models/Car.php

class Car
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT id, name, price, year, fuel, transmission, mileage, description, image
            FROM cars
            ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, price, year, fuel, transmission, mileage, description, image
            FROM cars
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        return $car ?: null;
    }

    public function create(array $data): bool
    {
        $name = trim($data["name"] ?? "");
        $price = $data["price"] ?? null;
        $year = $data["year"] ?? null;
        $fuel = trim($data["fuel"] ?? "");
        $transmission = trim($data["transmission"] ?? "");
        $mileage = $data["mileage"] ?? null;
        $description = trim($data["description"] ?? "");
        $image = $data["image"] ?? null;
        $adminId = (int)($data["admin_id"] ?? 0);

        if ($name === "" || $fuel === "" || $transmission === "" || $adminId <= 0) return false;
        if (!is_numeric($price) || !is_numeric($year) || !is_numeric($mileage)) return false;

        $stmt = $this->db->prepare("
            INSERT INTO cars (name, price, year, fuel, transmission, mileage, description, image, admin_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $name,
            (float)$price,
            (int)$year,
            $fuel,
            $transmission,
            (int)$mileage,
            $description,
            $image,
            $adminId
        ]);
    }

    public function update(int $id, array $data): bool
{
    $name = trim($data["name"] ?? "");
    $price = $data["price"] ?? null;
    $year = $data["year"] ?? null;
    $fuel = trim($data["fuel"] ?? "");
    $transmission = trim($data["transmission"] ?? "");
    $mileage = $data["mileage"] ?? null;
    $description = trim($data["description"] ?? "");
    $image = $data["image"] ?? null;

    if ($id <= 0) return false;
    if ($name === "" || $fuel === "" || $transmission === "") return false;
    if (!is_numeric($price) || !is_numeric($year) || !is_numeric($mileage)) return false;

    // nëse s’ka foto të re, mos e ndrysho kolonën image
    if ($image === null) {
        $stmt = $this->db->prepare("
            UPDATE cars
            SET name=?, price=?, year=?, fuel=?, transmission=?, mileage=?, description=?
            WHERE id=?
        ");
        return $stmt->execute([
            $name,
            (float)$price,
            (int)$year,
            $fuel,
            $transmission,
            (int)$mileage,
            $description,
            $id
        ]);
    }

    $stmt = $this->db->prepare("
        UPDATE cars
        SET name=?, price=?, year=?, fuel=?, transmission=?, mileage=?, description=?, image=?
        WHERE id=?
    ");
    return $stmt->execute([
        $name,
        (float)$price,
        (int)$year,
        $fuel,
        $transmission,
        (int)$mileage,
        $description,
        $image,
        $id
    ]);
}

public function delete(int $id): bool
{
    if ($id <= 0) return false;
    $stmt = $this->db->prepare("DELETE FROM cars WHERE id = ?");
    return $stmt->execute([$id]);
}
}
