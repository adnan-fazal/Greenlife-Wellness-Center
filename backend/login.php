<?php
session_start();
include 'db.php';

// Sanitize input
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic validation for empty fields
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Invalid form submission: Email and password are required.";
    header("Location: ../login/login.php");
    exit();
}

// Fetch user from DB
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        // Optional: Flash success message
        $_SESSION['login_success'] = "Successfully logged in as " . ucfirst($row['role']) . ".";

        // Redirect based on role
        if ($row['role'] === 'client') {
            header("Location: ../dashboard/client_dashboard.php");
        } elseif ($row['role'] === 'therapist') {
            header("Location: ../dashboard/therapist_dashboard.php");
        } elseif ($row['role'] === 'admin') {
            header("Location: ../dashboard/admin_dashboard.php");
        } else {
            $_SESSION['login_error'] = "Unknown user role.";
            header("Location: ../login/login.php");
        }
    } else {
        $_SESSION['login_error'] = "Incorrect password.";
        header("Location: ../login/login.php");
    }
} else {
    $_SESSION['login_error'] = "User not found.";
    header("Location: ../login/login.php");
}
?>
