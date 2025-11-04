<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// Validate inputs
if (empty($name) || empty($email)) {
    $_SESSION['message'] = "Name and email cannot be empty.";
    $_SESSION['message_type'] = "error";
    header("Location: ../dashboard/client_dashboard.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Invalid email format.";
    $_SESSION['message_type'] = "error";
    header("Location: ../dashboard/client_dashboard.php");
    exit();
}

// Update password only if provided
if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $password_hash, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['message'] = "Profile updated successfully.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Update failed.";
    $_SESSION['message_type'] = "error";
}

header("Location: ../dashboard/client_dashboard.php");
exit();