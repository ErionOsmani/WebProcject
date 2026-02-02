<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/Car.php";

requireAdmin();

$user = currentUser();
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

        $imageName = null;

        if (!empty($_FILES["image"]["name"])) {
            $tmp = $_FILES["image"]["tmp_name"];
            $size = $_FILES["image"]["size"];
            $type = mime_content_type($tmp);

            if (!in_array($type, ["image/jpeg", "image/png", "image/webp"])) {
                $error = "Lejohen vetëm JPG, PNG ose WEBP.";
            } elseif ($size > 2 * 1024 * 1024) {
                $error = "Foto është shumë e madhe (max 2MB).";
            } else {
                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $imageName = "car_" . time() . "." . $ext;

                move_uploaded_file($tmp, __DIR__ . "/../uploads/" . $imageName);
            }
        }

        if ($error === "") {
            $db = new Database();
            $conn = $db->getConnection();

            $carModel = new Car($conn);

            $data = [
                "name" => $name,
                "price" => $price,
                "year" => $year,
                "fuel" => $fuel,
                "transmission" => $transmission,
                "mileage" => $mileage,
                "description" => $description,
                "image" => $imageName,
                "admin_id" => $user["id"]
            ];

            if ($carModel->create($data)) {
                $success = "Vetura u shtua me sukses.";
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
    <title>Shto Veturë</title>
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
    <h2>Shto Veturë</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Emri</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Çmimi (€)</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Viti</label>
            <input type="number" name="year" required>
        </div>

        <div class="form-group">
            <label>Karburanti</label>
            <input type="text" name="fuel" required>
        </div>

        <div class="form-group">
            <label>Transmisioni</label>
            <input type="text" name="transmission" required>
        </div>

        <div class="form-group">
            <label>Kilometrazhi</label>
            <input type="number" name="mileage" required>
        </div>

        <div class="form-group">
            <label>Përshkrimi</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-block">Ruaj</button>
    </form>
</main>

</body>
</html>
