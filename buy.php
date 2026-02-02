<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/models/Car.php";
require_once __DIR__ . "/models/Purchase.php";

requireLogin();

$user = currentUser();

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("Location: cars.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$carModel = new Car($conn);
$car = $carModel->findById($id);

if (!$car) {
    header("Location: cars.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bankInfo = trim($_POST["bank_info"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $idCardText = trim($_POST["id_card_text"] ?? "");

    if ($bankInfo === "" || $phone === "" || $address === "" || $idCardText === "") {
        $error = "Plotëso të gjitha fushat.";
    } else {
        try {
            $conn->beginTransaction();

            $purchaseModel = new Purchase($conn);

            $ok = $purchaseModel->create([
                "car_id" => (int)$car["id"],
                "car_name" => $car["name"],
                "car_price" => $car["price"],
                "buyer_id" => (int)$user["id"],
                "bank_info" => $bankInfo,
                "phone" => $phone,
                "address" => $address,
                "id_card_text" => $idCardText
            ]);

            if (!$ok) {
                throw new Exception("Nuk u ruajt blerja.");
            }


            if (!$carModel->delete((int)$car["id"])) {
                throw new Exception("Nuk u fshi makina pas blerjes.");
            }

            $conn->commit();

            header("Location: cars.php");
            exit;
        } catch (Exception $e) {
            if ($conn->inTransaction()) $conn->rollBack();
            $error = "Blerja dështoi. Provo përsëri.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bli makinën</title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="index.php">AutoMarket</a></div>
        <nav>
            <ul>
                <li><a href="cars.php">Makina</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:30px 0; max-width:900px;">
    <h2>Bli: <?php echo htmlspecialchars($car["name"]); ?></h2>
    <p><strong>Çmimi:</strong> €<?php echo number_format((float)$car["price"], 0, ",", "."); ?></p>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin:10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" style="margin-top:15px;">
        <div class="form-group">
            <label>Informacioni i bankës</label>
            <input type="text" name="bank_info" required value="<?php echo htmlspecialchars($_POST["bank_info"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Numri i telefonit</label>
            <input type="text" name="phone" required value="<?php echo htmlspecialchars($_POST["phone"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>Adresa</label>
            <input type="text" name="address" required value="<?php echo htmlspecialchars($_POST["address"] ?? ""); ?>">
        </div>

        <div class="form-group">
            <label>ID Card (text)</label>
            <input type="text" name="id_card_text" required value="<?php echo htmlspecialchars($_POST["id_card_text"] ?? ""); ?>">
        </div>

        <button type="submit" class="btn btn-block">Proceed Purchase</button>
    </form>

    <p style="margin-top:15px;">
        <a href="car-detail.php?id=<?php echo (int)$car["id"]; ?>">Kthehu te detajet</a>
    </p>
</main>

</body>
</html>
