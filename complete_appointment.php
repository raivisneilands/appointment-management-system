<?php
$appointment_id = $_POST['complete-appointment-id'];
include 'db.php';
$sql = "UPDATE appointments SET status = 'completed' WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $appointment_id, PDO::PARAM_INT);
$stmt->execute();
header('Location: appointments.php');
