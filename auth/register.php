<?php
require('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely get username with fallback
   $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if (!$username || !$email || !$password || !$confirm) {
        die("Please fill in all required fields.");
    }

    if ($password !== $confirm) {
        die("Passwords do not match.");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert username as well
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed]);
        echo "Registration successful. <a href='../auth/login.php'>Login Now</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Email or username already registered.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
