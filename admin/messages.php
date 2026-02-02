<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/ContactMessage.php";

requireAdmin();

$db = new Database();
$conn = $db->getConnection();

$cm = new ContactMessage($conn);
$messages = $cm->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mesazhet e Kontaktit</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<header class="admin-header">
    <div class="container admin-nav">
        <div class="admin-logo">
            <a href="../index.php" style="color:#fff; text-decoration:none;">AutoMarket Admin</a>
        </div>

        <div class="admin-user">
            <?php echo htmlspecialchars($user["full_name"]); ?>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
</header>

<div class="admin-layout">

    <aside class="admin-sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="add-car.php">Shto Veturë</a>
        <a href="cars.php">Menaxho Veturat</a>
        <a href="users.php">Menaxho Përdoruesit</a>
        <a href="sold-cars.php">Veturat e shitura</a>
        <a href="messages.php" class="active">Mesazhet e kontaktit</a>
        <a href="news.php">Menaxho News</a>
        <a href="logs.php">Shiko Logs</a>
    </aside>

    <main class="admin-content">
    <h2>Mesazhet nga Contact</h2>

    <?php if (empty($messages)): ?>
        <p>Nuk ka ende mesazhe.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Email</th>
                    <th>Mesazhi</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($messages as $m): ?>
                <tr>
                    <td><?php echo (int)$m["id"]; ?></td>
                    <td><?php echo htmlspecialchars($m["name"]); ?></td>
                    <td><?php echo htmlspecialchars($m["email"]); ?></td>
                    <td style="max-width:520px;">
                        <?php echo nl2br(htmlspecialchars($m["message"])); ?>
                    </td>
                    <td><?php echo htmlspecialchars($m["created_at"]); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top:15px;">
        <a href="dashboard.php">Kthehu në Dashboard</a>
    </p>
</main>

</div>

</body>
</html>
