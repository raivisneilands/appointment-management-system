<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['login-error'] = 'You must be logged in to view this page.';
    header("location: index.php");
    exit;
}

// Include database connection file
require_once "db.php";

// Fetch user details from the database
$user_id = $_SESSION['user-id'];
try {
    $sql = "SELECT username, email, date_registered FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $username = $user['username'];
        $email = $user['email'];
        $created_at = $user['date_registered'];
    } else {
        // Handle case where user is not found
        echo "User not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="profile-container my-5">
            <h1>Profile</h1>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Member Since:</strong> <?php echo htmlspecialchars($created_at); ?></p>
        </div>
    </div>
</body>

</html>