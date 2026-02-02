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

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) { header("Location: news.php"); exit; }

$item = $newsModel->findById($id);
if (!$item) { header("Location: news.php"); exit; }

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {
        $error = "Titulli dhe përmbajtja janë të detyrueshme.";
    } else {
        $newImage = null;
        $hasNew = !empty($_FILES["image"]["name"]);

        if ($hasNew) {
            $tmp = $_FILES["image"]["tmp_name"];
            $size = (int)$_FILES["image"]["size"];
            $mime = mime_content_type($tmp);

            if (!in_array($mime, ["image/jpeg","image/png","image/webp"], true)) {
                $error = "Lejohen vetëm JPG, PNG ose WEBP.";
            } elseif ($size > 3 * 1024 * 1024) {
                $error = "Foto shumë e madhe (max 3MB).";
            } else {
                $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $newImage = "news_" . time() . "_" . mt_rand(1000,9999) . "." . $ext;

                $dir = __DIR__ . "/../uploads/news";
                if (!is_dir($dir)) mkdir($dir, 0777, true);

                move_uploaded_file($tmp, $dir . "/" . $newImage);
            }
        }

        if ($error === "") {

            $old = $item;

            if ($newsModel->update($id, $title, $content, $hasNew ? $newImage : null)) {

                $item = $newsModel->findById($id);

                $details = "News ID: $id";
                $details .= " | Old title: " . ($old["title"] ?? "");
                $details .= " | New title: " . ($item["title"] ?? "");
                if ($hasNew) {
                    $details .= " | Image updated";
                }

                $logModel->add(
                    (int)$user["id"],
                    "UPDATE_NEWS",
                    $details
                );

                header("Location: news.php");
                exit;

            } else {
                $error = "Editimi dështoi.";
            }
        }
    }
}

$img = trim((string)($item["image"] ?? ""));
$imgSrc = $img !== "" ? ("../uploads/news/" . $img) : null;
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit News</title>
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
    <h2>Edit lajm</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($imgSrc): ?>
        <div style="margin:10px 0;">
            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" style="max-width:260px; border-radius:12px;">
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Titulli</label>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($item["title"]); ?>">
        </div>

        <div class="form-group">
            <label>Përmbajtja</label>
            <textarea name="content" rows="6" required><?php echo htmlspecialchars($item["content"]); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto e re (opsionale)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <button type="submit" class="btn btn-block">Ruaj</button>
    </form>
</main>

</div>

</body>
</html>
