<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();


if ($user && password_verify($password, $user['password'])) {
    $stmt = $pdo->prepare('SELECT id, name FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    $_SESSION['user-id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['loggedin'] = true;
    header('Location: dashboard.php');
} else {
    $_SESSION['login-error'] = 'Invalid username or password.';
    header('Location: index.php');
    exit();
}
