<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/config/session.php";


$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $pass  = $_POST["password"] ?? "";

    $db = new Database();
    $conn = $db->getConnection();

    $userModel = new User($conn);
    $user = $userModel->login($email, $pass);

    if ($user) {
        $_SESSION["user"] = $user;

        if ($user["role"] === "admin") {
            header("Location: admin/dashboard.php");
            exit;
        }

        header("Location: index.php");
        exit;
    } else {
        $error = "Email ose fjalëkalimi gabim";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
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
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="form-wrapper">
        <h2>Kyçu në llogarinë tënde</h2>

        <?php if ($error !== ""): ?>
            <p style="color:red; margin-bottom:10px;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form action="#" method="post" onsubmit="return ValidimiLogin()">
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required>
            </div>

            <div class="form-group">
                <label for="login-password">Fjalëkalimi</label>
                <input type="password" id="login-password" name="password" required>
            </div>

            <p id="mesazhi-login"></p>

            <button type="submit" class="btn btn-block">Login</button>
        </form>
    </div>
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
            <h4>Ndihme</h4>
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

<script>
function ValidimiLogin() {
    var email = document.getElementById("login-email").value;
    var pass  = document.getElementById("login-password").value;

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var passRegex  = /^.{6,}$/;

    if (emailRegex.test(email) && passRegex.test(pass)) {
        document.getElementById("mesazhi-login").innerText = "";
        return true;
    } else {
        document.getElementById("mesazhi-login").innerText = "Email ose fjalëkalimi gabim";
        return false;
    }
}
</script>

</body>
</html>
