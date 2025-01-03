<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE name = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();


if ($user && password_verify($password, $user['password'])) {
    header('Location: dashboard.php');
} else {
    $_SESSION['login-error'] = 'Invalid username or password.';
    header('Location: index.php');
    exit();
}
