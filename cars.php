<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";

$user = currentUser();

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT id, name, price, year, fuel, transmission, mileage, description, image FROM cars ORDER BY id DESC");
$cars = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Makina - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/cars.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo">
            <a href="index.php">AutoMarket</a>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Kryefaqja</a></li>
                <li><a href="about.php">Rreth nesh</a></li>
                <li><a href="cars.php">Makina</a></li>

                <?php if ($user): ?>
                    <li style="font-weight:600;">
                        <?php echo htmlspecialchars($user["full_name"]); ?>
                    </li>

                    <?php if (($user["role"] ?? "") === "admin"): ?>
                        <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>

                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding: 30px 0;">
    <h2>Lista e makinave</h2>

    <?php if (empty($cars)): ?>
        <p>Nuk ka ende vetura të regjistruara.</p>
    <?php else: ?>
        <div class="cars-grid">
            <?php foreach ($cars as $car): ?>
                <?php
                    $img = trim((string)($car["image"] ?? ""));
                    // Nëse ruan vetëm emrin e fotos në DB, zakonisht e mban te: uploads/
                    // Ndrysho path-in nëse ti i mban diku tjetër.
                    $imgSrc = $img !== "" ? ("uploads/" . $img) : "assets/no-image.png";

                    $shortDesc = trim((string)($car["description"] ?? ""));
                    if (mb_strlen($shortDesc) > 120) {
                        $shortDesc = mb_substr($shortDesc, 0, 120) . "...";
                    }

                    // Formatim i thjeshtë i çmimit
                    $price = number_format((float)$car["price"], 0, ",", ".");
                ?>

                <div class="car-card">
                    <div class="car-image">
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="">
                    </div>

                    <div class="car-content">
                        <h3><?php echo htmlspecialchars($car["name"]); ?></h3>

                        <p><strong>Çmimi:</strong> €<?php echo $price; ?></p>
                        <p><strong>Viti:</strong> <?php echo htmlspecialchars($car["year"]); ?></p>
                        <p><strong>Karburanti:</strong> <?php echo htmlspecialchars($car["fuel"]); ?></p>
                        <p><strong>Transmisioni:</strong> <?php echo htmlspecialchars($car["transmission"]); ?></p>
                        <p><strong>Kilometrazhi:</strong> <?php echo number_format((int)$car["mileage"], 0, " ", " "); ?> km</p>

                        <a class="btn" href="car-detail.php?id=<?php echo (int)$car["id"]; ?>">Shiko detajet</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col">
            <a href="index.php" class="footer-logo">AutoMarket</a>
            <p>Shitje dhe blerje makinash me transparencë dhe shërbim të besueshëm.</p>
        </div>

        <div class="footer-col">
            <h4>Lidhje</h4>
            <ul>
                <li><a href="index.php">Kryefaqja</a></li>
                <li><a href="cars.php">Makina</a></li>
                <li><a href="about.php">Rreth nesh</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Ndihmë</h4>
            <ul>
                <li><a href="contact.php">Kontakt</a></li>
                <?php if (!$user): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Kontakt</h4>
            <p>Email: <a href="mailto:info@automarket.example">info@automarket.example</a></p>
            <p>Tel: +355 69 000 0000</p>
        </div>
    </div>

    <div class="container footer-bottom">
        <p>&copy; 2025 AutoMarket. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

</body>
</html>