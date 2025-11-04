<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email   = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['message_error'] = "All fields are required.";
        header("Location: ../contactus/contactus.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message_error'] = "Invalid email address.";
        header("Location: ../contactus/contactus.php");
        exit();
    }

    // Prepare and execute INSERT with name
    $stmt = $conn->prepare("
        INSERT INTO messages (name, email, message, sent_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['message_success'] = "Message sent successfully!";
    } else {
        $_SESSION['message_error'] = "Failed to send message: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../contactus/contactus.php");
    exit();
} else {
    header("Location: ../contactus/contactus.php");
    exit();
}
