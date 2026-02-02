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
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="add-car.php">Shto Veturë</a>
        <a href="cars.php">Menaxho Veturat</a>
        <a href="users.php">Menaxho Përdoruesit</a>
        <a href="sold-cars.php">Veturat e shitura</a>
        <a href="messages.php">Mesazhet e kontaktit</a>
        <a href="news.php">Menaxho News</a>
        <a href="logs.php">Shiko Logs</a>
    </aside>

    <main class="admin-content">
        <h1>Admin Dashboard</h1>
        <p>Mirësevjen, <strong><?php echo htmlspecialchars($user["full_name"]); ?></strong>. Zgjidh një seksion për menaxhim.</p>

        <div class="stats-grid">
            <div class="stat-card">
                <h3> Veturat</h3>
                <p>Shto, edito dhe fshi vetura.</p>
                <a href="cars.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> Shto Veturë</h3>
                <p>Shto një veturë të re në databazë.</p>
                <a href="add-car.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> Përdoruesit</h3>
                <p>Ndrysho role dhe fshi përdorues.</p>
                <a href="users.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> Veturat e shitura</h3>
                <p>Shiko veturat që janë blerë.</p>
                <a href="sold-cars.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> Mesazhet</h3>
                <p>Mesazhet nga Contact form.</p>
                <a href="messages.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> News</h3>
                <p>Shto, edito dhe fshi lajme.</p>
                <a href="news.php">Hap</a>
            </div>

            <div class="stat-card">
                <h3> Logs</h3>
                <p>Shiko veprimet e adminit.</p>
                <a href="logs.php">Hap</a>
            </div>
        </div>
    </main>

</div>

</body>
</html>
