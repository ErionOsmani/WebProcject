<?php
require_once __DIR__ . "/../config/session.php";


requireAdmin();

$user = currentUser();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo">
            <a href="../index.php">AutoMarket</a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../index.php">Faqja kryesore</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:40px 0;">
    <h2>Admin Dashboard</h2>

    <p>Mirësevjen, <strong><?php echo htmlspecialchars($user["full_name"]); ?></strong></p>

    <ul style="margin-top:20px;">
        <li><a href="#">Menaxho Veturat</a></li>
        <li><a href="#">Menaxho Lajmet</a></li>
        <li><a href="#">Mesazhet e Kontaktit</a></li>
    </ul>
</main>

</body>
</html>
