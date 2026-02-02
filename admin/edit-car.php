<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/Car.php";

requireAdmin();

$user = currentUser();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("Location: dashboard.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$carModel = new Car($conn);

$car = $carModel->findById($id);
if (!$car) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $price = $_POST["price"] ?? "";
    $year = $_POST["year"] ?? "";
    $fuel = trim($_POST["fuel"] ?? "");
    $transmission = trim($_POST["transmission"] ?? "");
    $mileage = $_POST["mileage"] ?? "";
    $description = trim($_POST["description"] ?? "");

    if ($name === "" || $price === "" || $year === "" || $fuel === "" || $transmission === "" || $mileage === "") {
        $error = "Plotëso të gjitha fushat kryesore.";
    } else {
        // foto e re (opsionale)
        $newImageName = null;
        $hasNewImage = !empty($_FILES["image"]["name"]);

        if ($hasNewImage) {
            $tmp = $_FILES["image"]["tmp_name"];
            $size = (int)$_FILES["image"]["size"];
            $type = mime_content_type($tmp);

            if (!in_array($type, ["image/jpeg", "image/png", "image/webp"], true)) {
                $error = "Lejohen vetëm JPG, PNG ose WEBP.";
            } elseif ($size > 2 * 1024 * 1024) {
                $error = "Foto është shumë e madhe (max 2MB).";
            } else {
                $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $newImageName = "car_" . time() . "_" . mt_rand(1000, 9999) . "." . $ext;

                $uploadDir = __DIR__ . "/../uploads";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $dest = $uploadDir . "/" . $newImageName;
                if (!move_uploaded_file($tmp, $dest)) {
                    $error = "Nuk u arrit ruajtja e fotos.";
                }
            }
        }

        if ($error === "") {
            $data = [
                "name" => $name,
                "price" => $price,
                "year" => $year,
                "fuel" => $fuel,
                "transmission" => $transmission,
                "mileage" => $mileage,
                "description" => $description,
                // nëse nuk ka foto të re, e lëmë null që të mos ndryshohet
                "image" => $hasNewImage ? $newImageName : null
            ];

            if ($carModel->update($id, $data)) {
                $success = "Vetura u përditësua me sukses.";
                $car = $carModel->findById($id); // rifresko të dhënat
            } else {
                $error = "Përditësimi dështoi.";
            }
        }
    }
}

$img = trim((string)($car["image"] ?? ""));
$imgSrc = $img !== "" ? ("../uploads/" . $img) : "../assets/no-image.png";
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Car - Admin</title>
    <link rel="stylesheet" href="../css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="../index.php">AutoMarket</a></div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../cars.php">Makina</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:30px 0; max-width:900px;">
    <h2>Edito Veturën</h2>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin:10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color:green; margin:10px 0;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <div style="margin: 10px 0;">
        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" style="max-width: 260px; border-radius: 10px;">
    </div>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Emri</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($car["name"]); ?>">
        </div>

        <div class="form-group">
            <label>Çmimi (€)</label>
            <input type="number" step="0.01" name="price" required value="<?php echo htmlspecialchars($car["price"]); ?>">
        </div>

        <div class="form-group">
            <label>Viti</label>
            <input type="number" name="year" required value="<?php echo htmlspecialchars($car["year"]); ?>">
        </div>

        <div class="form-group">
            <label>Karburanti</label>
            <input type="text" name="fuel" required value="<?php echo htmlspecialchars($car["fuel"]); ?>">
        </div>

        <div class="form-group">
            <label>Transmisioni</label>
            <input type="text" name="transmission" required value="<?php echo htmlspecialchars($car["transmission"]); ?>">
        </div>

        <div class="form-group">
            <label>Kilometrazhi</label>
            <input type="number" name="mileage" required value="<?php echo htmlspecialchars($car["mileage"]); ?>">
        </div>

        <div class="form-group">
            <label>Përshkrimi</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($car["description"] ?? ""); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto e re (opsionale)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <button type="submit" class="btn btn-block">Ruaj ndryshimet</button>
    </form>

    <p style="margin-top:15px;">
        <a href="dashboard.php">Kthehu në Dashboard</a>
    </p>
</main>

</body>
</html>
