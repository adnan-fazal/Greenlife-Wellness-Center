<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$new_password = $_POST['new_password'] ?? '';

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format'); window.history.back();</script>";
    exit();
}

// Update password hash if new password provided
if (!empty($new_password)) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $password_hash, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    echo "<script>alert('Profile updated successfully.'); window.location.href='../dashboard/therapist_dashboard.php';</script>";
} else {
    echo "<script>alert('Profile update failed. Please try again.'); window.history.back();</script>";
}
