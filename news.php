<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/News.php";

$user = currentUser();

$db = new Database();
$conn = $db->getConnection();

$newsModel = new News($conn);
$items = $newsModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lajme - AutoMarket</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="index.php">AutoMarket</a></div>
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

<main class="container" style="padding:30px 0; max-width:1000px;">
    <h2>Lajme</h2>

    <?php if (empty($items)): ?>
        <p>Nuk ka ende lajme.</p>
    <?php else: ?>
        <?php foreach ($items as $n): ?>
            <?php
                $preview = trim((string)$n["content"]);
                if (mb_strlen($preview) > 180) $preview = mb_substr($preview, 0, 180) . "...";
                $img = trim((string)($n["image"] ?? ""));
                $imgSrc = $img !== "" ? ("uploads/news/" . $img) : null;
            ?>
            <div style="padding:16px; border:1px solid #ddd; border-radius:12px; margin:12px 0;">
                <h3 style="margin:0 0 8px 0;">
                    <a href="news-detail.php?id=<?php echo (int)$n["id"]; ?>">
                        <?php echo htmlspecialchars($n["title"]); ?>
                    </a>
                </h3>

                <?php if ($imgSrc): ?>
                    <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" style="max-width:100%; border-radius:12px; margin:10px 0;">
                <?php endif; ?>

                <p style="margin:0 0 8px 0;"><?php echo htmlspecialchars($preview); ?></p>
                <small><?php echo htmlspecialchars($n["created_at"]); ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<footer class="site-footer">
    <div class="container footer-bottom">
        <p>&copy; 2025 AutoMarket.</p>
    </div>
</footer>

</body>
</html>
