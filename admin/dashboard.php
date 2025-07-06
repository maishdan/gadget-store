<?php
session_start();
require_once '../db.php';

// Auto-login from cookie if session is not set
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    $cookie_data = json_decode(base64_decode($_COOKIE['remember_user']), true);
    $_SESSION['user_id'] = $cookie_data['id'];
    $_SESSION['role'] = $cookie_data['role'];

    // Optional: validate against DB here again for security
}

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Redirect if role mismatch
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../user/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Gadget Store</title>
  <link rel="stylesheet" href="../css/dashboard.css" />
</head>
<body>
  <header>
    <h1>Admin Dashboard - Gadget Store</h1>
    <form method="post" action="../auth/logout.php" style="text-align: right; margin-right: 20px;">
      <button type="submit">Logout</button>
    </form>
  </header>

  <nav>
    <a href="#products">Products</a>
    <a href="#users">Users</a>
    <a href="#orders">Orders</a>
    <a href="../index.html">Back to Store</a>
  </nav>

  <div class="dashboard-container">
    <!-- Dashboard content -->
  </div>
</body>
</html>
