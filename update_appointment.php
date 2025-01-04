<?php
// Database configuration
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $appointment_id = $_POST['id'];
    $date_time = $_POST['date-time'];
    $description = $_POST['new-description'];
    $title = $_POST['new-title'];

    // Update the appointment
    $sql = "UPDATE appointments SET time = :time, title = :title, description = :description WHERE id = :appointment_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['time' => $date_time, 'title' => $title, 'description' => $description, 'appointment_id' => $appointment_id]);

    echo "Appointment updated successfully!";
    header('Location: appointments.php');
}
