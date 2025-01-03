<?php
session_start();
include 'db.php';

$name = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$retype_password = password_hash($_POST['retype-password'], PASSWORD_DEFAULT);
$current_date = date('y-m-d');

// Check if username or email already exists
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE name = ? OR email = ?');
$stmt->execute([$name, $email]);
$userExists = $stmt->fetchColumn();
if ($userExists) {
    $register_error = 'Username or email already exists.';
    $_SESSION['register-error'] = $register_error;
    header('Location: index.php');
} elseif ($_POST['password'] !== $_POST['retype-password']) {
    $register_error = 'Passwords do not match.';
    $_SESSION['register-error'] = $register_error;
    header('Location: index.php');
} else {
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, date_registered) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $password, $current_date]);
    echo 'User registered successfully.';
    $_SESSION['username'] = $_POST['username'];
    header('Location: dashboard.php');
}
