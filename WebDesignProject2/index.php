<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>AutoMarket - Shitje Makinash</title>
    <link rel="stylesheet" href="css/styles.css">
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
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">

    <!-- FILLIMI -->
    <section class="makina">
        <div class="makina-text">
            <h1>Gjej makinën tënde të ëndrrave</h1>
            <p>AutoMarket ofron makina të reja dhe të përdorura me çmime reale dhe transparencë maksimale.</p>
            <a href="cars.php" class="btn">Shfleto makinat</a>
        </div>
    </section>

    <!-- SLIDER -->
     
    <section class="home-slider">
                <h2>Disa nga veturat më të kërkuara</h2>

        <div class="slider" id="homeSlider">
            <img src="./assets/e30.jpg" class="slide active" alt="">
            <img src="./assets/Trock.jpg" class="slide" alt="">
            <img src="./assets/xc90.jpg" class="slide" alt="">
        </div>
    </section>

    <!-- FEATURES -->
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

<footer>
    <div class="container">
        <p>&copy; 2025 AutoMarket. Të gjitha të drejtat e rezervuara.</p>
        <p>
            <a href="contact.php" style="color:#9ca3af; text-decoration:none;">Kontakt</a>
        </p>
    </div>
</footer>

<!-- SLIDER  -->

<script>
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll("#homeSlider .slide");
    if (slides.length === 0) return;

    let index = 0;
    const intervalTime = 4000; 

    function nextSlide() {
        slides[index].classList.remove("active");
        index = (index + 1) % slides.length;
        slides[index].classList.add("active");
    }
    setInterval(nextSlide, intervalTime);
});
</script>


</body>
</html>
