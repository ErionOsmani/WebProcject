<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/ContactMessage.php";

$user = currentUser();

$error = "";
$success = "";

$nameDefault = $user["full_name"] ?? "";
$emailDefault = $user["email"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $message = $_POST["message"] ?? "";

    $db = new Database();
    $conn = $db->getConnection();

    $cm = new ContactMessage($conn);

    if ($cm->create($name, $email, $message)) {
        $success = "Mesazhi u dërgua me sukses.";
        $nameDefault = "";
        $emailDefault = "";
    } else {
        $error = "Plotëso të dhënat saktë (email valid) dhe shkruaj mesazhin.";
        $nameDefault = $name;
        $emailDefault = $email;
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
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
                <li><a href="contact.php">Kontakt</a></li>

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

<main class="container" style="padding:30px 0; max-width:900px;">
    <h2>Na Kontakto</h2>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin:10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color:green; margin:10px 0;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post" style="margin-top:15px;">
        <div class="form-group">
            <label>Emri</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($nameDefault); ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($emailDefault); ?>">
        </div>

        <div class="form-group">
            <label>Mesazhi</label>
            <textarea name="message" rows="5" required><?php echo htmlspecialchars($_POST["message"] ?? ""); ?></textarea>
        </div>

        <button type="submit" class="btn btn-block">Dërgo</button>
    </form>
</main>

<footer class="site-footer">
    <div class="container footer-bottom">
        <p>&copy; 2025 AutoMarket. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

</body>
</html>
