<?php
session_start();
include 'db.php';  // DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $service = mysqli_real_escape_string($conn, trim($_POST['service']));
    $date = mysqli_real_escape_string($conn, trim($_POST['date']));
    $time = mysqli_real_escape_string($conn, trim($_POST['time']));

    // Get user_id if logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Validate all fields
    if (empty($name) || empty($email) || empty($service) || empty($date) || empty($time)) {
        $_SESSION['appointment_error'] = "Please fill all required fields.";
        header("Location: ../appointment/appointment.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['appointment_error'] = "Invalid email format.";
        header("Location: ../appointment/appointment.php");
        exit();
    }

    // Prepare SQL (with user_id if available)
    if ($user_id) {
        $stmt = $conn->prepare("INSERT INTO appointments (user_id, name, email, service, date, time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $name, $email, $service, $date, $time);
    } else {
        // If user not logged in, save without user_id (optional)
        $stmt = $conn->prepare("INSERT INTO appointments (name, email, service, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $service, $date, $time);
    }

    if (!$stmt) {
        $_SESSION['appointment_error'] = "Database error: " . $conn->error;
        header("Location: ../appointment/appointment.php");
        exit();
    }

    if ($stmt->execute()) {
        $_SESSION['appointment_success'] = "Your appointment has been booked successfully!";
    } else {
        $_SESSION['appointment_error'] = "Failed to book appointment: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../appointment/appointment.php");
    exit();
} else {
    header("Location: ../appointment/appointment.php");
    exit();
}
