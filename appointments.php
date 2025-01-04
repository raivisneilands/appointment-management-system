<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['user-id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user-id'];

$sql = "SELECT * FROM appointments WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="display-6 my-5">My Appointments</h1>
        <a href="add_appointment.php"><button class="btn btn-primary my-4">Add Appointment</button></a>
        <table class="table" border="3">
            <thead class="table-light">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date and Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td class="d-flex">
                        <form action="complete_appointment.php" method="post">
                            <input type="hidden" name="complete-appointment-id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-success btn-sm mx-3">Complete</button>
                        </form>
                        <form action="edit_appointment.php" method="post">
                            <input type="hidden" name="edit-appointment-id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-secondary btn-sm mx-3">Edit</button>
                        </form>
                        <form action="cancel_appointment.php" method="post">
                            <input type="hidden" name="cancel-appointment-id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm mx-3">Cancel appointment</button>
                        </form>
                        <form action="delete_appointment.php" method="post">
                            <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm mx-3">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <br>
</body>

</html>