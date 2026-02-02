<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/Car.php";

$user = currentUser();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("Location: cars.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$carModel = new Car($conn);
$car = $carModel->findById($id);

if (!$car) {
    header("Location: cars.php");
    exit;
}

$img = trim((string)($car["image"] ?? ""));
$imgSrc = $img !== "" ? ("uploads/" . $img) : "assets/no-image.png";


$price = number_format((float)$car["price"], 0, ",", ".");
$mileage = number_format((int)$car["mileage"], 0, " ", " ");
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($car["name"]); ?> - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/car-detail.css">
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
    <a href="cars.php" class="btn back-link">Kthehu te lista</a>

    <div class="car-detail-wrapper">
        <div class="car-detail-image">
            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="">
        </div>

        <div class="car-detail-content">
            <h2><?php echo htmlspecialchars($car["name"]); ?></h2>

            <p><strong>Çmimi:</strong> €<?php echo $price; ?></p>
            <p><strong>Viti:</strong> <?php echo htmlspecialchars($car["year"]); ?></p>
            <p><strong>Karburanti:</strong> <?php echo htmlspecialchars($car["fuel"]); ?></p>
            <p><strong>Transmisioni:</strong> <?php echo htmlspecialchars($car["transmission"]); ?></p>
            <p><strong>Kilometrazhi:</strong> <?php echo $mileage; ?> km</p>

            <?php if (!empty($car["description"])): ?>
                <h3>Përshkrimi</h3>
                <p><?php echo nl2br(htmlspecialchars($car["description"])); ?></p>
            <?php endif; ?>

        <a class="btn" href="buy.php?id=<?php echo (int)$car["id"]; ?>" style="margin-top:10px; display:inline-block;">
    Buy
</a>
        </div>
    </div>
</main>

<footer class="site-footer">
    <div class="container footer-bottom">
        <p>&copy; 2025 AutoMarket. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

</body>
</html>
