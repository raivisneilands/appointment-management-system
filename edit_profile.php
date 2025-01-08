<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['user-id'];

// Connect to the database
include_once 'db.php';

// Get user data from database
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $user['username'];
$name = $user['name'];
$email = $user['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <form method="post" action="update_profile.php" class="form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username ?>" required><br><br>
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email ?>" required><br><br>
        <input type="submit" value="Submit" class="btn btn-primary">
        <input type="hidden" name="id" value="<?php echo $user_id ?>">
        <a href="profile.php" class="btn btn-danger">Cancel</a>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger"">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }

    ?>
</body>

</html>