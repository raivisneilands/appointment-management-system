<?php
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Check if username or email already exists

$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
$stmt->execute([$username]);
$userExists = $stmt->fetchColumn();

if ($userExists) {
    $_SESSION['error'] = 'Username already exists.';
    header('Location: edit_profile.php');
} else {
    $sql = "UPDATE users SET username = :username, name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':id', $_SESSION['user-id'], PDO::PARAM_INT);
    $stmt->execute();
    header('Location: profile.php');
}
