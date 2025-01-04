<?php

include 'db.php';

if (isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    // Ask user for confirmation
    echo "<script>
        var confirmDeletion = confirm('Are you sure you want to cancel this appointment?');
        if (confirmDeletion) {
            window.location.href = 'delete_appointment.php?confirm=true&appointment_id=' + $appointment_id;
        } else {
            window.location.href = 'appointments.php';
        }
    </script>";
}

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true' && isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Delete appointment from database
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$appointment_id])) {
        echo "Appointment cancelled successfully.";
    } else {
        echo "Error cancelling appointment: " . $stmt->errorInfo()[2];
    }

    // Redirect to appointments page
    header("Location: appointments.php");
    exit();
}
