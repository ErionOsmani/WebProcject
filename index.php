<?php
require_once __DIR__ . "/config/session.php";
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoMarket - Shitje Makinash</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
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

    <section class="makina">
        <div class="makina-text">
            <h1>Gjej makinën tënde të ëndrrave</h1>
            <p>AutoMarket ofron makina të reja dhe të përdorura me çmime reale dhe transparencë maksimale.</p>
            <a href="cars.php" class="btn">Shfleto makinat</a>
        </div>
    </section>

    <section class="home-slider">
        <h2>Disa nga veturat më të kërkuara</h2>

        <div class="slider" id="homeSlider">
            <img src="assets/e30.jpg" class="slide active" alt="">
            <img src="assets/Trock.jpg" class="slide" alt="">
            <img src="assets/xc90.jpg" class="slide" alt="">
        </div>
    </section>

    <section>
        <h2>Pse të zgjidhni AutoMarket?</h2>

        <div class="features-grid">
            <div class="feature-box">
                <img src="assets/search-removebg-preview.png" class="feature-img" alt="">
                <h3>Transparencë në çdo hap</h3>
                <ul>
                    <li>Historia e veturës shpjegohet qartë</li>
                    <li>Çmime pa tarifa të fshehura</li>
                    <li>Marrëveshje e thjeshtë dhe e kuptueshme</li>
                </ul>
            </div>

            <div class="feature-box">
                <img src="assets/tool-removebg-preview.png" class="feature-img" alt="">
                <h3>Veturë e kontrolluar</h3>
                <ul>
                    <li>Kontroll teknik profesional</li>
                    <li>Servis bazë sipas nevojës</li>
                    <li>Testim real para shitjes</li>
                </ul>
            </div>

            <div class="feature-box">
                <img src="assets/budget-removebg-preview.png" class="feature-img" alt="">
                <h3>Për çdo buxhet</h3>
                <ul>
                    <li>Makina ekonomike</li>
                    <li>Familjare dhe SUV</li>
                    <li>Modele premium</li>
                </ul>
            </div>

            <div class="feature-box">
                <img src="assets/counseling-removebg-preview.png" class="feature-img" alt="">
                <h3>Këshillim i sinqertë</h3>
                <ul>
                    <li>Krahasim real i modeleve</li>
                    <li>Pa shtytje për shitje</li>
                    <li>Vendim i informuar</li>
                </ul>
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll("#homeSlider .slide");
    if (slides.length === 0) return;

    let index = 0;

    setInterval(() => {
        slides[index].classList.remove("active");
        index = (index + 1) % slides.length;
        slides[index].classList.add("active");
    }, 4000);
});
</script>

</body>
</html>
