<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";

requireAdmin();

$user = currentUser();
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $year = trim($_POST["year"] ?? "");
    $fuel = trim($_POST["fuel"] ?? "");
    $transmission = trim($_POST["transmission"] ?? "");
    $mileage = trim($_POST["mileage"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($name === "" || $price === "" || $year === "" || $fuel === "" || $transmission === "" || $mileage === "") {
        $error = "Plotëso të gjitha fushat kryesore.";
    } else {
        $imageNameInDb = null;

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
                $error = "Foto nuk u ngarkua. Provo përsëri.";
            } else {
                $allowed = ["image/jpeg", "image/png", "image/webp"];
                $mime = mime_content_type($_FILES["image"]["tmp_name"]);
                $size = (int)$_FILES["image"]["size"];

                if (!in_array($mime, $allowed, true)) {
                    $error = "Lejohen vetëm JPG, PNG, WEBP.";
                } elseif ($size > 2 * 1024 * 1024) {
                    $error = "Foto është shumë e madhe (max 2MB).";
                } else {
                    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $newName = "car_" . time() . "_" . mt_rand(1000, 9999) . "." . strtolower($ext);

                    $uploadDir = __DIR__ . "/../uploads";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $dest = $uploadDir . "/" . $newName;

                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $dest)) {
                        $error = "Nuk u arrit ruajtja e fotos.";
                    } else {
                        $imageNameInDb = $newName;
                    }
                }
            }
        }

        if ($error === "") {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("
                INSERT INTO cars (name, price, year, fuel, transmission, mileage, description, image, admin_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $ok = $stmt->execute([
                $name,
                (float)$price,
                (int)$year,
                $fuel,
                $transmission,
                (int)$mileage,
                $description,
                $imageNameInDb,
                (int)$user["id"]
            ]);

            if ($ok) {
                $success = "Vetura u shtua me sukses.";
            } else {
                $error = "Shtimi dështoi. Provo përsëri.";
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
    <title>Shto Veturë - Admin</title>
    <link rel="stylesheet" href="../css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo">
            <a href="../index.php">AutoMarket</a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../cars.php">Makina</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding: 30px 0; max-width: 900px;">
    <h2>Shto Veturë</h2>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin: 10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color:green; margin: 10px 0;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" style="margin-top: 15px;">
        <div class="form-group">
            <label>Emri i veturës</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST["name"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Çmimi (€)</label>
            <input type="number" step="0.01" name="price" required value="<?php echo htmlspecialchars($_POST["price"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Viti</label>
            <input type="number" name="year" required value="<?php echo htmlspecialchars($_POST["year"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Karburanti</label>
            <input type="text" name="fuel" required value="<?php echo htmlspecialchars($_POST["fuel"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Transmisioni</label>
            <input type="text" name="transmission" required value="<?php echo htmlspecialchars($_POST["transmission"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Kilometrazhi (km)</label>
            <input type="number" name="mileage" required value="<?php echo htmlspecialchars($_POST["mileage"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Përshkrimi</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($_POST["description"] ?? ""); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto (JPG/PNG/WEBP, max 2MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <button type="submit" class="btn btn-block">Ruaj</button>
    </form>

    <p style="margin-top: 15px;">
        <a href="../cars.php">Shiko listën e veturave</a>
    </p>
</main>

</body>
</html>
