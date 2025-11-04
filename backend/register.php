<?php
session_start();
include 'db.php';

function redirectWithMessage($location, $message, $type = 'error') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $location");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';  // <-- read role from form

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        redirectWithMessage('../register/register.php', 'Please fill in all fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithMessage('../register/register.php', 'Invalid email format.');
    }

    if ($password !== $confirm_password) {
        redirectWithMessage('../register/register.php', 'Passwords do not match.');
    }

    // Optionally validate role values strictly:
    $allowed_roles = ['client', 'therapist'];
    if (!in_array($role, $allowed_roles)) {
        redirectWithMessage('../register/register.php', 'Invalid user role selected.');
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        redirectWithMessage('../register/register.php', 'Email already registered.');
    }
    $stmt->close();

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password_hash, $role);

    if ($stmt->execute()) {
        $stmt->close();
        redirectWithMessage('../login/login.php', 'Registration successful! Please log in.', 'success');
    } else {
        redirectWithMessage('../register/register.php', 'Registration failed. Please try again.');
    }

} else {
    header("Location: ../register/register.php");
    exit();
}
?>
