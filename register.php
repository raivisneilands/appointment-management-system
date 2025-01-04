<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$retype_password = password_hash($_POST['retype-password'], PASSWORD_DEFAULT);
$current_date = date('y-m-d');

// Check if username or email already exists
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
$stmt->execute([$username, $email]);
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
    $stmt = $pdo->prepare('INSERT INTO users (username, name, email, password, date_registered) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $name, $email, $password, $current_date]);
    echo 'User registered successfully.';
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user_id = $stmt->fetch();
    $_SESSION['user-id'] = $user_id['id'];
    $_SESSION['name'] = $_POST['name'];
    header('Location: dashboard.php');
}
