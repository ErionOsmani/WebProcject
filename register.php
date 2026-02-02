<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/models/User.php";
require_once __DIR__ . "/config/session.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $pass = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($pass !== $confirm) {
        $error = "Fjalëkalimet nuk përputhen";
    } else {
        $db = new Database();
        $conn = $db->getConnection();

        $userModel = new User($conn);
        $ok = $userModel->register($fullName, $email, $pass);

        if ($ok) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Regjistrimi dështoi. Kontrollo të dhënat ose email-in";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body class="register-page">

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
        <h2>Krijo llogari</h2>

        <?php if ($error !== ""): ?>
            <p style="color:red; margin-bottom:10px;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form action="#" method="post" onsubmit="return ValidimiRegister()">
            <div class="form-group">
                <label for="reg-name">Emri i plotë</label>
                <input type="text" id="reg-name" name="name" required>
            </div>

            <div class="form-group">
                <label for="reg-email">Email</label>
                <input type="email" id="reg-email" name="email" required>
            </div>

            <div class="form-group">
                <label for="reg-password">Fjalëkalimi</label>
                <input type="password" id="reg-password" name="password" required>
            </div>

            <div class="form-group">
                <label for="reg-confirm">Përsërit fjalëkalimin</label>
                <input type="password" id="reg-confirm" name="confirm_password" required>
            </div>

            <p id="mesazhi-register"></p>

            <button type="submit" class="btn">Regjistrohu</button>
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

<script>
function ValidimiRegister() {
    const pass = document.getElementById('reg-password').value;
    const confirm = document.getElementById('reg-confirm').value;
    const msg = document.getElementById('mesazhi-register');
    msg.style.color = 'red';
    if (pass !== confirm) {
        msg.textContent = 'Fjalëkalimet nuk përputhen.';
        return false;
    }
    msg.textContent = '';
    return true;
}
</script>

</body>
</html>
