<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/News.php";

$user = currentUser();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { header("Location: news.php"); exit; }

$db = new Database();
$conn = $db->getConnection();

$newsModel = new News($conn);
$item = $newsModel->findById($id);

if (!$item) { header("Location: news.php"); exit; }

$img = trim((string)($item["image"] ?? ""));
$imgSrc = $img !== "" ? ("uploads/news/" . $img) : null;
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($item["title"]); ?></title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="index.php">AutoMarket</a></div>
        <nav>
            <ul>
                <li><a href="news.php">Lajme</a></li>
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

<main class="container" style="padding:30px 0; max-width:1000px;">
    <a class="btn" href="news.php" style="display:inline-block; margin-bottom:12px;">Kthehu</a>

    <h2><?php echo htmlspecialchars($item["title"]); ?></h2>
    <small><?php echo htmlspecialchars($item["created_at"]); ?></small>

    <?php if ($imgSrc): ?>
        <div style="margin:15px 0;">
            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" style="max-width:100%; border-radius:12px;">
        </div>
    <?php endif; ?>

    <p style="margin-top:15px;">
        <?php echo nl2br(htmlspecialchars($item["content"])); ?>
    </p>
</main>

</body>
</html>
