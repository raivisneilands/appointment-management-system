<?php
include 'db.php';
$appointment_id = $_POST['cancel-appointment-id'];
$sql = "UPDATE appointments SET status = 'cancelled' WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $appointment_id, PDO::PARAM_INT);
$stmt->execute();
header('Location: appointments.php');
