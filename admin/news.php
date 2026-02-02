<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/News.php";
require_once __DIR__ . "/../models/AdminLog.php";

requireAdmin();

$current = currentUser();

$db = new Database();
$conn = $db->getConnection();

$newsModel = new News($conn);
$logModel  = new AdminLog($conn);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $deleteId = (int)$_POST["delete_id"]; 

    $newsToDelete = $newsModel->findById($deleteId);

    if ($newsModel->delete($deleteId)) { 
        $success = "Lajmi u fshi me sukses.";

        $details = "News ID: $deleteId";
        if ($newsToDelete) {
            $details .= " | Title: " . ($newsToDelete["title"] ?? "");
        }

        $logModel->add(
            (int)$current["id"],
            "DELETE_NEWS",
            $details
        );

    } else {
        $error = "Fshirja dështoi.";
    }
}

$items = $newsModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menaxho News</title>
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
            <?php echo htmlspecialchars($current["full_name"]); ?>
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
    <h2>News</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <p>Nuk ka lajme.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulli</th>
                    <th>Data</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $n): ?>
                <tr>
                    <td><?php echo (int)$n["id"]; ?></td>
                    <td><?php echo htmlspecialchars($n["title"]); ?></td>
                    <td><?php echo htmlspecialchars($n["created_at"]); ?></td>
                    <td style="white-space:nowrap;">
                        <a href="edit-news.php?id=<?php echo (int)$n["id"]; ?>">Edit</a>

                        <form method="post" style="display:inline;"
                              onsubmit="return confirm('A je i sigurt që do ta fshish këtë lajm?');">
                            <input type="hidden" name="delete_id" value="<?php echo (int)$n["id"]; ?>">
                            <button type="submit"
                                    style="margin-left:10px; color:#c0392b; background:none; border:none; cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

</div>

</body>
</html>
