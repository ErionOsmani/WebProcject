<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../models/AdminLog.php";

requireAdmin();

$db = new Database();
$conn = $db->getConnection();

$logModel = new AdminLog($conn);
$logs = $logModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Logs</title>
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
    <a href="news.php">Menaxho News</a>
    <a href="logs.php" class="active">Shiko Logs</a>
  </aside>

  <main class="admin-content">
  <h2>Log-et e Adminit</h2>

  <?php if (empty($logs)): ?>
    <p>Nuk ka ende log-e.</p>
  <?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Admin</th>
          <th>Veprimi</th>
          <th>Detaje</th>
          <th>Koha</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $l): ?>
          <tr>
            <td><?php echo (int)$l["id"]; ?></td>
            <td>
              <?php echo htmlspecialchars($l["admin_name"]); ?><br>
              <small><?php echo htmlspecialchars($l["admin_email"]); ?></small>
            </td>
            <td><?php echo htmlspecialchars($l["action"]); ?></td>
            <td style="max-width:520px;"><?php echo nl2br(htmlspecialchars($l["details"])); ?></td>
            <td><?php echo htmlspecialchars($l["created_at"]); ?></td>
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
