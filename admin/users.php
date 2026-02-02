<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/AdminLog.php";

requireAdmin();

$current = currentUser();

$db = new Database();
$conn = $db->getConnection();

$userModel = new User($conn);
$logModel  = new AdminLog($conn);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $deleteId = (int)$_POST["delete_id"]; 

    if ($deleteId === (int)$current["id"]) {
        $error = "Nuk mund ta fshish llogarinë tënde.";
    } else {

        $userToDelete = $userModel->findById($deleteId);

        if ($userModel->delete($deleteId)) {
            $success = "Përdoruesi u fshi me sukses.";

            $details = "User ID: $deleteId";
            if ($userToDelete) {
                $details .= " | Name: " . ($userToDelete["full_name"] ?? "");
                $details .= " | Email: " . ($userToDelete["email"] ?? "");
                $details .= " | Role: " . ($userToDelete["role"] ?? "");
            }

            $logModel->add((int)$current["id"], "DELETE_USER", $details);

        } else {
            $error = "Fshirja dështoi.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["role_id"], $_POST["role"])) {
    $roleId = (int)$_POST["role_id"]; 
    $newRole = $_POST["role"];

    if ($roleId === (int)$current["id"]) {
        $error = "Nuk mund ta ndryshosh rolin tënd.";
    } else {

        $oldUser = $userModel->findById($roleId);
        $oldRole = $oldUser["role"] ?? "";

        if ($userModel->updateRole($roleId, $newRole)) {
            $success = "Roli u përditësua me sukses.";

            $details = "User ID: $roleId";
            if ($oldUser) {
                $details .= " | Name: " . ($oldUser["full_name"] ?? "");
                $details .= " | Email: " . ($oldUser["email"] ?? "");
                $details .= " | Old role: $oldRole | New role: $newRole";
            } else {
                $details .= " | Old role: $oldRole | New role: $newRole";
            }

            $logModel->add((int)$current["id"], "UPDATE_USER_ROLE", $details);

        } else {
            $error = "Ndryshimi i rolit dështoi.";
        }
    }
}

$users = $userModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menaxho Përdoruesit</title>
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
        <a href="users.php" class="active">Menaxho Përdoruesit</a>
        <a href="sold-cars.php">Veturat e shitura</a>
        <a href="messages.php">Mesazhet e kontaktit</a>
        <a href="news.php">Menaxho News</a>
        <a href="logs.php">Shiko Logs</a>
    </aside>

    <main class="admin-content">
    <h2>Menaxho Përdoruesit</h2>

    <?php if ($error !== ""): ?>
        <p style="color:red; margin:10px 0;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p style="color:green; margin:10px 0;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <p>Nuk ka përdorues.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Email</th>
                    <th>Roli</th>
                    <th>Ndrysho rolin</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <?php $isMe = ((int)$u["id"] === (int)$current["id"]); ?>
                <tr>
                    <td><?php echo (int)$u["id"]; ?></td>
                    <td><?php echo htmlspecialchars($u["full_name"]); ?></td>
                    <td><?php echo htmlspecialchars($u["email"]); ?></td>
                    <td><?php echo htmlspecialchars($u["role"]); ?></td>

                    <td>
                        <?php if ($isMe): ?>
                            <span style="color:#777;">Nuk lejohet</span>
                        <?php else: ?>
                            <form method="post" style="display:flex; gap:8px; align-items:center;">
                                <input type="hidden" name="role_id" value="<?php echo (int)$u["id"]; ?>">

                                <select name="role">
                                    <option value="user"  <?php echo ($u["role"] === "user") ? "selected" : ""; ?>>user</option>
                                    <option value="admin" <?php echo ($u["role"] === "admin") ? "selected" : ""; ?>>admin</option>
                                </select>

                                <button type="submit" style="cursor:pointer;">Ruaj</button>
                            </form>
                        <?php endif; ?>
                    </td>

                    <td style="white-space:nowrap;">
                        <?php if ($isMe): ?>
                            <span style="color:#777;">(Ti)</span>
                        <?php else: ?>
                            <form method="post" style="display:inline;"
                                  onsubmit="return confirm('A je i sigurt që do ta fshish këtë përdorues?');">
                                <input type="hidden" name="delete_id" value="<?php echo (int)$u["id"]; ?>">
                                <button type="submit"
                                        style="cursor:pointer; color:#c0392b; background:none; border:none;">
                                    Delete
                                </button>
                            </form>
                        <?php endif; ?>
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

</div>

</body>
</html>
