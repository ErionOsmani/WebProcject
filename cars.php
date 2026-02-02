<?php
require_once __DIR__ . "/config/session.php";
$user = currentUser();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Makina në shitje - AutoMarket</title>
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
        <h1>Makina në shitje</h1>
        <p>Zgjidh nga ofertat tona më të fundit:</p>

        <div class="cars-grid">
            <article class="card">
                <img src="./assets/bmw3series2018.jpg" alt="BMW 3 Series">
                <div class="card-body">
                    <h3>BMW 320d 2018</h3>
                    <p>Automatik · Dizel · 120 000 km</p>
                    <p class="price">€18,500</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>

            <article class="card">
                <img src="./assets/GolfMk7.avif" alt="VW Golf 7">
                <div class="card-body">
                    <h3>VW Golf 7 2017</h3>
                    <p>Manual · Dizel · 140 000 km</p>
                    <p class="price">€10,900</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>


            <article class="card">
                <img src="./assets/Used-2019-Audi-A4-20T-quattro-Premium.jpg" alt="Audi A4">
                <div class="card-body">
                    <h3>Audi A4 2019</h3>
                    <p>Automatik · Benzinë · 90 000 km</p>
                    <p class="price">€21,300</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>
            

            <article class="card">
                <img src="./assets/mercedesC.jpg" alt="Mercedes C">
                <div class="card-body">
                    <h3>Mercedes C 2016</h3>
                    <p>Automatik · Benzinë · 110 000 km</p>
                    <p class="price">€15,800</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>


            <article class="card">
                <img src="./assets/ToyotaCorolla.jpg" alt="Toyota Corolla">
                <div class="card-body">
                    <h3>Toyota Corolla 2015</h3>
                    <p>Manual · Benzinë · 130 000 km</p>
                    <p class="price">€9,500</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>


            <article class="card">
                <img src="./assets/FordFocus.jpg" alt="Ford Focus">
                <div class="card-body">
                    <h3>Ford Focus 2018</h3>
                    <p>Manual · Benzinë · 95 000 km</p>
                    <p class="price">€11,200</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>


            <article class="card">
                <img src="./assets/2023-hyundai-ioniq-5-sel-awd-4dr-crossover.jpg" alt="Hyundai Ioniq">
                <div class="card-body">
                    <h3>Hyundai Ioniq 2020</h3>
                    <p>Automatik · Hibrid · 60 000 km</p>
                    <p class="price">€17,900</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>

            <article class="card">
                <img src="./assets/Skoda.jpg" alt="Skoda Octavia">
                <div class="card-body">
                    <h3>Skoda Octavia 2017</h3>
                    <p>Manual · Dizel · 150 000 km</p>
                    <p class="price">€10,400</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>


            <article class="card">
                <img src="./assets/RenoClio.jpg" alt="Renault Clio">
                <div class="card-body">
                    <h3>Renault Clio 2019</h3>
                    <p>Manual · Benzinë · 55 000 km</p>
                    <p class="price">€8,700</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>
                        <article class="card">
                <img src="./assets/xc90.jpg" alt="Volvo XC90">
                <div class="card-body">
                    <h3>Volvo XC90 2020</h3>
                    <p>Automatik · Hibrid · 32 000 km</p>
                    <p class="price">€32,900</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>
                        <article class="card">
                <img src="./assets/Trock.jpg" alt="T-Rock">
                <div class="card-body">
                    <h3>Voltswagen T-Rock 2020</h3>
                    <p>Automatik · Diesel · 88 000 km</p>
                    <p class="price">€28,000</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>
                        <article class="card">
                <img src="./assets/e30.jpg" alt="BMW KOCK">
                <div class="card-body">
                    <h3>BMW Kock E30</h3>
                    <p>Automatik · Benzin · 210 000 km</p>
                    <p class="price">€14,700</p>
                    <a href="car-detail.php" class="btn">Shiko detajet</a>
                </div>
            </article>
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
