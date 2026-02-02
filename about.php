<?php
require_once __DIR__ . "/config/session.php";
$user = currentUser();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rreth nesh - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/about.css">
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
<br>

<main class="container">
    <section class="about-section">

        <div class="about-hero">
            <div class="hero-content">
                <h1>Rreth Nesh</h1>
                <p>Mirë se vini në AutoOsi – vendi ku makina e duhur takon pronarin e duhur. Misioni ynë është i thjeshtë: të të ndihmojmë të gjesh veturën që të përfaqëson ty — në stil, siguri dhe buxhet.</p>

                <div class="about-cards">
                    <div class="about-card">
                        <h3>Transparencë</h3>
                        <p>Historiku, inspektimet dhe informacioni i plotë për secilën veturë.</p>
                    </div>

                    <div class="about-card">
                        <h3>Siguri & Kontroll</h3>
                        <p>Çdo veturë kontrollohet teknikisht dhe përgatitet për shfrytëzim të sigurt.</p>
                    </div>

                    <div class="about-card">
                        <h3>Këshillim i Sinqertë</h3>
                        <p>Qasja jonë është e thjeshtë: të dëgjojmë dhe të gjejmë zgjidhjen më të mirë për ty.</p>
                    </div>
                </div>

                <div class="cta">
                    <a class="btn" href="contact.php">Na Kontakto</a>
                </div>
            </div>

            <div class="hero-image">
                <img src="assets/team.jpg" alt="AutoOsi showroom">
            </div>
        </div>

        <div class="about-content">
            <div class="separator">⸻</div>

            <h2>Kë Shërbejmë</h2>
            <p>Ne i mirëpresim të gjithë – nga blerësi i ri që ka shumë pyetje, te profesionisti që e di saktësisht çfarë kërkon.</p>

            <ul>
                <li>Individë që kërkojnë veturën e parë ose një përditësim më modern</li>
                <li>Familje që kanë nevojë për siguri, komoditet dhe hapësirë</li>
                <li>Biznese që duan flotë të besueshme për stafin e tyre</li>
            </ul>

            <div class="separator">⸻</div>

            <h2>Si Operojmë</h2>
            <p>Transparenca dhe besimi janë baza e mënyrës sonë të punës.</p>
            <ul>
                <li>Çdo veturë kontrollohet teknikisht përpara se të dalë në shitje</li>
                <li>Ofron histori sa më të plotë të veturës (kilometrazhi, servisimet, aksidentet)</li>
                <li>Ndihmojmë në procedurat e dokumentacionit, regjistrimit dhe sigurimit</li>
                <li>Japim këshilla të sinqerta – edhe nëse kjo do të thotë të të themi “prit pak, mos nxitohu sot”</li>
            </ul>

            <div class="separator">⸻</div>

            <h2>Fytyra e Biznesit</h2>
            <p>Ekipi ynë përbëhet nga konsulentë të shitjes, mekanikë dhe staf mbështetës që e duan punën e tyre dhe respektojnë çdo klient.</p>

            <div class="team-grid">
                <div class="team-member">
                    <img src="assets/keshill.jpg" alt="">
                    <h4>Arben - Menaxher</h4>
                    <p>Këshillim & shitje</p>
                </div>

                <div class="team-member">
                    <img src="assets/mekaniku (2).jpg" alt="Elira - Teknike" class="team-photo">
                    <h4>Agoni - Teknike</h4>
                    <p>Inspektime & servis</p>
                </div>

                <div class="team-member">
                    <img src="assets/suit.jpg" alt="">
                    <h4>Joni - Support</h4>
                    <p>Dokumentacion & klientela</p>
                </div>
            </div>
<br>
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
