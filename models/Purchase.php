<?php

class Purchase
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
    }

    public function create(array $data): bool
    {
        $carId = (int)($data["car_id"] ?? 0);
        $carName = trim($data["car_name"] ?? "");
        $carPrice = $data["car_price"] ?? null;
        $buyerId = (int)($data["buyer_id"] ?? 0);

        $bankInfo = trim($data["bank_info"] ?? "");
        $phone = trim($data["phone"] ?? "");
        $address = trim($data["address"] ?? "");
        $idCardText = trim($data["id_card_text"] ?? "");

        if ($carId <= 0 || $buyerId <= 0) return false;
        if ($carName === "" || !is_numeric($carPrice)) return false;
        if ($bankInfo === "" || $phone === "" || $address === "" || $idCardText === "") return false;

        $stmt = $this->db->prepare("
            INSERT INTO purchases
            (car_id, car_name, car_price, buyer_id, bank_info, phone, address, id_card_text)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $carId,
            $carName,
            (float)$carPrice,
            $buyerId,
            $bankInfo,
            $phone,
            $address,
            $idCardText
        ]);
    }
    public function getAllWithBuyer(): array
{
    $stmt = $this->db->query("
        SELECT
            p.id,
            p.car_id,
            p.car_name,
            p.car_price,
            p.bank_info,
            p.phone,
            p.address,
            p.id_card_text,
            p.purchased_at,
            u.full_name AS buyer_name,
            u.email AS buyer_email
        FROM purchases p
        INNER JOIN users u ON u.id = p.buyer_id
        ORDER BY p.purchased_at DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

