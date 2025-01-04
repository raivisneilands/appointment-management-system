<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Database connection
include 'db.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="display-6 my-5">Add Appointment</h1>
        <form name="add_appointment" method="post" action="insert_appointment_in_db.php">
            <table class="table" border="3">
                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea cols="70" rows="5" name="description" id="new-description"></textarea></td>
                <tr>
                    <td>Date and Time</td>
                    <td><input type="datetime-local" name="date-time"></td>
                    <td><input type="hidden" name="id" value="<?php echo $_SESSION['user-id'] ?>"></td>
                </tr>
            </table>
            <input type="submit" name="update" value="Add" class="btn btn-secondary mx-3">
            <input type="button" value="Cancel" onclick="window.location.href='appointments.php';" class="btn btn-danger">
        </form>
    </div>
</body>

</html>