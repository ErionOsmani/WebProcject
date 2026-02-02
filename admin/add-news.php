<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/News.php";
require_once __DIR__ . "/../models/AdminLog.php";

requireAdmin();

$user = currentUser();

$db = new Database();
$conn = $db->getConnection();

$newsModel = new News($conn);
$logModel  = new AdminLog($conn);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {
        $error = "Titulli dhe përmbajtja janë të detyrueshme.";
    } else {
        $imageName = null;

        if (!empty($_FILES["image"]["name"])) {
            $tmp = $_FILES["image"]["tmp_name"];
            $size = (int)$_FILES["image"]["size"];
            $mime = mime_content_type($tmp);

            if (!in_array($mime, ["image/jpeg","image/png","image/webp"], true)) {
                $error = "Lejohen vetëm JPG, PNG ose WEBP.";
            } elseif ($size > 3 * 1024 * 1024) {
                $error = "Foto shumë e madhe (max 3MB).";
            } else {
                $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $imageName = "news_" . time() . "_" . mt_rand(1000,9999) . "." . $ext;

                $dir = __DIR__ . "/../uploads/news";
                if (!is_dir($dir)) mkdir($dir, 0777, true);

                move_uploaded_file($tmp, $dir . "/" . $imageName);
            }
        }

        if ($error === "") {
            if ($newsModel->create($title, $content, $imageName, (int)$user["id"])) {

                $details = "Title: $title";
                if ($imageName) $details .= " | Image: $imageName";
                $logModel->add((int)$user["id"], "CREATE_NEWS", $details);

                header("Location: news.php");
                exit;
            } else {
                $error = "Shtimi dështoi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shto lajm</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<header class="admin-header">
    <div class="container admin-nav">
        <div class="admin-logo">
            <a href="../index.php" style="color:#fff; text-decoration:none;">AutoMarket Admin</a>
        </div>

        <div class="admin-user">
            <?php echo htmlspecialchars($user["full_name"]); ?>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
</header>

<div class="admin-layout">

    <aside class="admin-sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="add-car.php">Shto Veturë</a>
        <a href="cars.php">Menaxho Veturat</a>
        <a href="users.php">Menaxho Përdoruesit</a>
        <a href="sold-cars.php">Veturat e shitura</a>
        <a href="messages.php">Mesazhet e kontaktit</a>
        <a href="news.php" class="active">Menaxho News</a>
        <a href="logs.php">Shiko Logs</a>
    </aside>

    <main class="admin-content">
    <h2>Shto lajm</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Titulli</label>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($_POST["title"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Përmbajtja</label>
            <textarea name="content" rows="6" required><?php echo htmlspecialchars($_POST["content"] ?? ""); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto (opsionale)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <button type="submit" class="btn btn-block">Ruaj</button>
    </form>
</main>

</div>

</body>
</html>
