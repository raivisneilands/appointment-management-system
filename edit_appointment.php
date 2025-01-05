<?php
// Include database connection file
include "db.php";
if (!isset($_SESSION['user-id'])) {
    $_SESSION['login-error'] = 'You neded to login first!';
    header('Location: index.php');
    exit();
}
// Fetch appointment data based on ID
try {
    if (isset($_POST['edit-appointment-id'])) {
        $appointment_id = $_POST['edit-appointment-id'];
    } else {
        echo "Appointment ID is not set.";
        exit;
    }
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
    $stmt->bindParam(':id', $appointment_id, PDO::PARAM_INT);
    $stmt->execute();

    $appointment_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment_data) {
        $title = $appointment_data['title'];
        $description = $appointment_data['description'];
        $time = $appointment_data['time'];
    } else {
        echo "No appointment found with ID: $appointment_id";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="display-6 my-5">Edit Appointment</h1>
        <form name="update_appointment" method="post" action="update_appointment.php">
            <table class="table" border="3">
                <tr>
                    <td>New Title</td>
                    <td><input type="text" name="new-title" value="<?php echo htmlspecialchars($title); ?>"></td>
                </tr>
                <tr>
                    <td>New Description</td>
                    <td><textarea cols="70" rows="5" name="new-description" id="new-description"><?php echo htmlspecialchars($description) ?></textarea></td>
                <tr>
                    <td>New Date and Time</td>
                    <td><input type="datetime-local" name="date-time" value="<?php echo htmlspecialchars($time); ?>"></td>
                    <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment_id); ?>"></td>
                </tr>
            </table>
            <input type="submit" name="update" value="Update" class="btn btn-secondary mx-3">
            <input type="button" value="Cancel" onclick="window.location.href='appointments.php';" class="btn btn-danger">
        </form>
    </div>
</body>

</html>