<?php
require_once __DIR__ . "/config/session.php";
$user = currentUser();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BMW 320d 2018 - Detaje - AutoMarket</title>
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
                    <li style="font-weight:600;">
                        <?php echo htmlspecialchars($user["full_name"]); ?>
                    </li>

                    <?php if ($user["role"] === "admin"): ?>
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

<main class="container">
    <section>
        <h1>BMW 320d 2018</h1>

        <div class="details">
            <div>
                <img src="./assets/bmw3series2018.jpg" alt="BMW 320d" class="detail-img">
            </div>
            <div>
                <p><strong>Çmimi:</strong> €18,500</p>
                <p><strong>Viti:</strong> 2018</p>
                <p><strong>Karburanti:</strong> Dizel</p>
                <p><strong>Transmisioni:</strong> Automatik</p>
                <p><strong>Kilometrazhi:</strong> 120 000 km</p>

                <h3>Përshkrimi</h3>
                <p>
                    BMW 320d i mirëmbajtur, servis i plotë, gjendje shumë e mirë teknike dhe vizuale.
                    Ideale për udhëtime të gjata dhe përdorim ditor.
                </p>

                <a href="cars.php" class="back-link">&larr; Kthehu te makinat</a>
            </div>
        </div>
    </section>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
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
