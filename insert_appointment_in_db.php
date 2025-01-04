<?php
include 'db.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $date_time = $_POST['date-time'];
    $id = $_POST['id'];

    // Insert appointment into database
    $sql = "INSERT INTO appointments (title, description, time, user_id) VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$title, $description, $date_time, $id])) {
        echo "Appointment added successfully!";
    } else {
        echo "Error adding appointment: " . $stmt->errorInfo()[2];
    }

    header('Location: appointments.php');
}
