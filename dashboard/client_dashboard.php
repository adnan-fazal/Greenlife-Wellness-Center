<?php
session_start();
include '../backend/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name    = $_SESSION['name'];
$email   = $_SESSION['email'];

// Show login success alert once
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . addslashes($_SESSION['login_success']) . "');</script>";
    unset($_SESSION['login_success']);
}

// Handle cancel appointment
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    $conn->query("DELETE FROM appointments WHERE id = $cancel_id AND email = '$email'");
    $_SESSION['message'] = "Appointment cancelled successfully.";
    header("Location: client_dashboard.php");
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_name     = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email    = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['password'];

    $update_query = "UPDATE users SET name='$new_name', email='$new_email'";
    if (!empty($new_password)) {
        $hashed        = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query .= ", password='$hashed'";
    }
    $update_query .= " WHERE id = $user_id";

    if ($conn->query($update_query)) {
        $_SESSION['name']  = $new_name;
        $_SESSION['email'] = $new_email;
        $_SESSION['message'] = "Profile updated successfully.";
        header("Location: client_dashboard.php");
        exit();
    } else {
        $error = "Failed to update profile.";
    }
}

// Fetch client appointments
$appointments = $conn->query("SELECT * FROM appointments WHERE email = '$email' ORDER BY date, time");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f4f4f4;
        }
        h1, h2 {
            color: #008060;
        }
        .section {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 0 8px #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        .btn-cancel {
            background: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-update {
            background: #2ecc71;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 8px;
            width: 100%;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .message {
            padding: 10px;
            color: green;
            background: #dff0d8;
            border: 1px solid green;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .logout {
            float: right;
            padding: 8px 12px;
            background: #555;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        /* ↓ Custom empty-appointments box ↓ */
        .empty-appointments {
            text-align: center;
            padding: 40px 20px;
            background: #fcfcfc;
            border: 2px dashed #ccc;
            border-radius: 8px;
            margin-top: 20px;
        }
        .empty-appointments .empty-icon {
            font-size: 48px;
            color: #bbb;
            margin-bottom: 20px;
        }
        .empty-appointments h3 {
            font-size: 1.5rem;
            color: #555;
            margin-bottom: 10px;
        }
        .empty-appointments p {
            color: #777;
            margin-bottom: 20px;
        }
        .empty-appointments .btn-book {
            display: inline-block;
            padding: 10px 20px;
            background: #2e7d32;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .empty-appointments .btn-book:hover {
            background: #276a27;
        }
    </style>
    <!-- Optionally include FontAwesome for calendar icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>

    <a href="../logout.php" class="logout">Logout</a>
    <h1>Welcome, <?php echo htmlspecialchars($name); ?></h1>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <!-- Appointments Section -->
    <div class="section">
        <h2>Your Appointments</h2>
        <?php if ($appointments->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                <?php while($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                    <td><a href="?cancel_id=<?php echo $row['id']; ?>" class="btn-cancel" onclick="return confirm('Cancel this appointment?')">Cancel</a></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <div class="empty-appointments">
                <i class="fa fa-calendar-o empty-icon" aria-hidden="true"></i>
                <h3>No appointments booked</h3>
                <p>Looks like you haven’t scheduled anything yet. Stay on track—book your first wellness session now!</p>
                <a href="../appointment/appointment.php" class="btn-book">Book Now</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Profile Update Section -->
    <div class="section">
        <h2>Update Profile</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
            <button type="submit" name="update_profile" class="btn-update">Update Profile</button>
        </form>
    </div>

</body>
</html>
