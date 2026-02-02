<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/Car.php";

requireAdmin();

$db = new Database();
$conn = $db->getConnection();

$carModel = new Car($conn);

$error = "";
$success = "";

// DELETE me POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $deleteId = (int)$_POST["delete_id"];

    if ($carModel->delete($deleteId)) {
        $success = "Vetura u fshi me sukses.";
    } else {
        $error = "Fshirja dështoi.";
    }
}

$cars = $carModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menaxho Veturat</title>
    <link rel="stylesheet" href="../css/common.css">
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="dashboard.php">Admin Dashboard</a></div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add-car.php">Shto Veturë</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:30px 0;">
    <h2>Lista e Veturave</h2>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin:10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color:green; margin:10px 0;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if (empty($cars)): ?>
        <p>Nuk ka ende vetura.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Çmimi (€)</th>
                    <th>Viti</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?php echo (int)$car["id"]; ?></td>
                        <td><?php echo htmlspecialchars($car["name"]); ?></td>
                        <td><?php echo number_format((float)$car["price"], 0, ",", "."); ?></td>
                        <td><?php echo htmlspecialchars($car["year"]); ?></td>
                        <td style="white-space:nowrap;">
                            <a href="edit-car.php?id=<?php echo (int)$car["id"]; ?>">Edit</a>

                            <form method="post" style="display:inline;"
                                onsubmit="return confirm('A je i sigurt që do ta fshish këtë veturë?');">
                                <input type="hidden" name="delete_id" value="<?php echo (int)$car["id"]; ?>">
                                <button type="submit" style="margin-left:10px; cursor:pointer; color:#c0392b; background:none; border:none;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top:15px;">
        <a href="dashboard.php">Kthehu në Dashboard</a>
    </p>
</main>

</body>
</html>
