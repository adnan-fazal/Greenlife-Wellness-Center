<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $user_id = $_SESSION['user_id'];

    // Only allow deletion if the appointment belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $appointment_id, $user_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Appointment cancelled successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to cancel appointment.";
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
}

header("Location: ../dashboard/client_dashboard.php");
exit();
