<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<h2 class="display-4 fs-1 m-3 text-center">Appointment Management System</h2>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3 class="display-6 my-3">Register</h3>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group my-4">
                    <label for="name">Name: </label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group my-4">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group my-4">
                    <label for="birthdate">Birthdate: </label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                </div>
                <div class="form-group my-4">
                    <label for="password">Password: </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group my-4">
                    <label for="retype-password">Retype Password: </label>
                    <input type="password" class="form-control" id="retype-password" name="retype-password" required>
                </div>
                <div class="form-group my-4">
                    <input type="submit" value="Register" class="btn btn-primary">
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['password']) && isset($_POST['retype-password'])) {
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $birthdate = htmlspecialchars(strip_tags($_POST['birthdate']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $retypePassword = htmlspecialchars(strip_tags($_POST['retype-password']));

                if ($password !== $retypePassword) {
                    echo "<div class='alert alert-danger'>Passwords do not match</div>";
                } else {
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO users (name, email, birthdate, password) VALUES (:name, :email, :birthdate, :password)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':password', $password);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                New record created successfully
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $stmt->errorInfo()[2] . "</div>";
                    }
                }
            }
            ?>
        </div>
        <div class="col-md-6">
            <h3 class="display-6 my-3">Login</h3>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group my-4">
                    <label for="login-email">Email: </label>
                    <input type="email" class="form-control" id="login-email" name="login-email" required>
                </div>
                <div class="form-group my-4">
                    <label for="login-password">Password: </label>
                    <input type="password" class="form-control" id="login-password" name="login-password" required>
                </div>
                <div class="form-group my-4 d-flex justify-content-end">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login-email']) && isset($_POST['login-password'])) {
                $loginEmail = filter_var($_POST['login-email'], FILTER_SANITIZE_EMAIL);
                $loginPassword = htmlspecialchars(strip_tags($_POST['login-password']));

                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $loginEmail);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($loginPassword, $user['password'])) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Login successful
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            Invalid email or password
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                }
            }
            ?>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>