<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/Car.php";

$user = currentUser();

$db = new Database();
$conn = $db->getConnection();

$carModel = new Car($conn);
$cars = $carModel->getAll();
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
                <li><a href="news.php">Lajme</a></li>

                <?php if ($user): ?> 
                    <li style="font-weight:600;"><?php echo htmlspecialchars($user["full_name"]); ?></li>
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
                    $imgSrc = $img !== "" ? ("uploads/" . $img) : "assets/no-image.png";

                    $shortDesc = trim((string)($car["description"] ?? ""));
                    if (mb_strlen($shortDesc) > 120) $shortDesc = mb_substr($shortDesc, 0, 120) . "...";

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
    <div class="container footer-bottom">
        <p>&copy; 2025 AutoMarket. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

</body>
</html>
