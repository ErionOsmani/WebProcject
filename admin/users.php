<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/User.php";

requireAdmin();

$current = currentUser();

$db = new Database();
$conn = $db->getConnection();

$userModel = new User($conn);

$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $deleteId = (int)$_POST["delete_id"];

    if ($deleteId === (int)$current["id"]) {
        $error = "Nuk mund ta fshish llogarinë tënde.";
    } else {
        if ($userModel->delete($deleteId)) {
            $success = "Përdoruesi u fshi me sukses.";
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
        if ($userModel->updateRole($roleId, $newRole)) {
            $success = "Roli u përditësua me sukses.";
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
</head>
<body>

<header>
    <div class="container navbar">
        <div class="logo"><a href="dashboard.php">Admin Dashboard</a></div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cars.php">Veturat</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container" style="padding:30px 0;">
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

</body>
</html>
