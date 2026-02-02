<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/Purchase.php";

requireAdmin();

$db = new Database();
$conn = $db->getConnection();

$purchaseModel = new Purchase($conn);
$sales = $purchaseModel->getAllWithBuyer();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Veturat e Shitura</title>
    <link rel="stylesheet" href="../css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="dashboard.php">Admin Dashboard</a></div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cars.php">Veturat</a></li>
                <li><a href="users.php">Përdoruesit</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:30px 0;">
    <h2>Veturat e Shitura</h2>

    <?php if (empty($sales)): ?>
        <p>Nuk ka ende vetura të shitura.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Makina</th>
                    <th>Çmimi (€)</th>
                    <th>Blerësi</th>
                    <th>Email</th>
                    <th>Telefoni</th>
                    <th>Adresa</th>
                    <th>ID Card</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sales as $s): ?>
                <tr>
                    <td><?php echo (int)$s["id"]; ?></td>
                    <td><?php echo htmlspecialchars($s["car_name"]); ?></td>
                    <td><?php echo number_format((float)$s["car_price"], 0, ",", "."); ?></td>
                    <td><?php echo htmlspecialchars($s["buyer_name"]); ?></td>
                    <td><?php echo htmlspecialchars($s["buyer_email"]); ?></td>
                    <td><?php echo htmlspecialchars($s["phone"]); ?></td>
                    <td><?php echo htmlspecialchars($s["address"]); ?></td>
                    <td><?php echo htmlspecialchars($s["id_card_text"]); ?></td>
                    <td><?php echo htmlspecialchars($s["purchased_at"]); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top:15px;">
        <a href="dashboard.php">Kthehu në Dashboard</a>
    </p>
</main>

</body>
</html>
