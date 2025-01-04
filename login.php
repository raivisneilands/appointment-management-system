<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();


if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $username;
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user_id = $stmt->fetch();
    $_SESSION['user-id'] = $user_id['id'];
    header('Location: dashboard.php');
} else {
    $_SESSION['login-error'] = 'Invalid username or password.';
    header('Location: index.php');
    exit();
}
