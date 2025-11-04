<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['reply_email']);
    $message = trim($_POST['reply_message']);
    $message_id = intval($_POST['message_id']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.'); window.history.back();</script>";
        exit();
    }

    if (empty($message)) {
        echo "<script>alert('Reply message cannot be empty.'); window.history.back();</script>";
        exit();
    }

    // Here you could send email or save reply to a replies table.
    // For now, just display a success message and redirect.
    
    // Example: send email (simple)
    $subject = "Reply from GreenLife Therapist";
    $headers = "From: no-reply@greenlife.com\r\nReply-To: no-reply@greenlife.com\r\n";
    if (mail($email, $subject, $message, $headers)) {
        echo "<script>alert('Reply sent successfully to $email'); window.location.href='../dashboard/therapist_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to send reply email.'); window.history.back();</script>";
    }
} else {
    header("Location: ../dashboard/therapist_dashboard.php");
    exit();
}
