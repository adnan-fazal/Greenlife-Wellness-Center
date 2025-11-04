<?php
session_start();
include '../backend/db.php';

// Ensure therapist is logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'therapist') {
    header("Location: ../login/login.php");
    exit();
}

// Show login success alert once
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . addslashes($_SESSION['login_success']) . "');</script>";
    unset($_SESSION['login_success']);
}

$therapistEmail = $_SESSION['email'];
$therapistName = $_SESSION['name'];

// Handle cancel appointment from therapist dashboard
if (isset($_GET['cancel_appointment_id'])) {
    $cancelId = intval($_GET['cancel_appointment_id']);
    // Delete appointment by id
    $conn->query("DELETE FROM appointments WHERE id = $cancelId");
    $_SESSION['appointment_message'] = "Appointment cancelled successfully.";
    header("Location: therapist_dashboard.php");
    exit();
}

// Fetch therapist profile
$stmt = $conn->prepare("SELECT name, email, phone, bio FROM users WHERE email = ?");
$stmt->bind_param("s", $therapistEmail);
$stmt->execute();
$stmt->bind_result($name, $email, $phone, $bio);
$stmt->fetch();
$stmt->close();

// Handle profile update POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $updName = trim($_POST['name']);
    $updPhone = trim($_POST['phone']);
    $updBio = trim($_POST['bio']);
    // Update in DB
    $updateStmt = $conn->prepare("UPDATE users SET name=?, phone=?, bio=? WHERE email=?");
    $updateStmt->bind_param("ssss", $updName, $updPhone, $updBio, $therapistEmail);
    if ($updateStmt->execute()) {
        $_SESSION['profile_message'] = "Profile updated successfully.";
        $_SESSION['name'] = $updName; // Update session name
        $name = $updName; $phone = $updPhone; $bio = $updBio;
    } else {
        $_SESSION['profile_message'] = "Failed to update profile.";
    }
    $updateStmt->close();
    header("Location: therapist_dashboard.php");
    exit();
}

// Handle reply POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'])) {
    $messageId = intval($_POST['message_id']);
    $replyText = trim($_POST['reply']);
    if ($replyText !== '') {
        $replyStmt = $conn->prepare("UPDATE messages SET reply=?, replied_at=NOW() WHERE id=?");
        $replyStmt->bind_param("si", $replyText, $messageId);
        $replyStmt->execute();
        $replyStmt->close();
        $_SESSION['reply_message'] = "Reply sent.";
    }
    header("Location: therapist_dashboard.php");
    exit();
}

// Fetch all client messages with user names
$msgResult = $conn->query("
  SELECT messages.*, users.name 
  FROM messages 
  LEFT JOIN users ON messages.email = users.email
  ORDER BY messages.sent_at DESC
");

// Fetch all appointments for all clients
$apptResult = $conn->query("
  SELECT appointments.*, users.name AS client_name 
  FROM appointments 
  LEFT JOIN users ON appointments.email = users.email
  ORDER BY appointments.date, appointments.time
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Therapist Dashboard - GreenLife</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0; padding: 20px;
    }
    .dashboard {
      max-width: 1100px;
      margin: auto;
      background: white;
      padding: 20px 30px;
      box-shadow: 0 0 10px #aaa;
    }
    h1, h2 {
      color: #2e7d32;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      vertical-align: top;
    }
    th {
      background: #c8e6c9;
    }
    textarea {
      width: 100%;
      height: 80px;
      resize: vertical;
    }
    input[type=text], input[type=email], textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      background: #2e7d32;
      color: white;
      border: none;
      padding: 8px 16px;
      cursor: pointer;
      border-radius: 4px;
      font-weight: bold;
    }
    button:hover {
      background: #1b4d1b;
    }
    .btn-cancel {
      background: #e74c3c;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
    }
    .logout {
      float: right;
      background: crimson;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      margin-bottom: 20px;
      display: inline-block;
    }
    .message-success {
      color: green;
      margin-bottom: 15px;
    }
    form.reply-form {
      margin-top: 10px;
    }
    .profile-section {
      margin-bottom: 50px;
    }
    label {
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="dashboard">
  <a href="../logout.php" class="logout">Logout</a>
  <h1>Welcome, <?php echo htmlspecialchars($therapistName); ?> (Therapist)</h1>

  <div class="profile-section">
    <h2>Your Profile</h2>
    <?php if (isset($_SESSION['profile_message'])): ?>
      <p class="message-success"><?php echo htmlspecialchars($_SESSION['profile_message']); unset($_SESSION['profile_message']); ?></p>
    <?php endif; ?>
    <form method="POST" action="therapist_dashboard.php">
      <input type="hidden" name="update_profile" value="1" />
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
      
      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" placeholder="Optional">
      
      <label for="bio">Bio</label>
      <textarea name="bio" id="bio" placeholder="Write something about yourself..."><?php echo htmlspecialchars($bio ?? ''); ?></textarea>
      
      <button type="submit">Update Profile</button>
    </form>
  </div>

  <h2>Client Messages</h2>
  <?php if (isset($_SESSION['reply_message'])): ?>
      <p class="message-success"><?php echo htmlspecialchars($_SESSION['reply_message']); unset($_SESSION['reply_message']); ?></p>
  <?php endif; ?>
  
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Your Reply</th>
        <th>Sent At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($msg = $msgResult->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($msg['name'] ?? $msg['email']); ?></td>
        <td><?php echo htmlspecialchars($msg['email']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
        <td><?php echo nl2br(htmlspecialchars($msg['reply'] ?? '')); ?></td>
        <td><?php echo htmlspecialchars($msg['sent_at']); ?></td>
        <td>
          <form class="reply-form" method="POST" action="therapist_dashboard.php">
            <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
            <textarea name="reply" placeholder="Write your reply here..." required></textarea>
            <button type="submit" name="reply_message">Send Reply</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <h2>All Appointments</h2>
  <?php if (isset($_SESSION['appointment_message'])): ?>
    <p class="message-success"><?php echo htmlspecialchars($_SESSION['appointment_message']); unset($_SESSION['appointment_message']); ?></p>
  <?php endif; ?>
  <?php if ($apptResult->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Client Name</th>
          <th>Email</th>
          <th>Service</th>
          <th>Date</th>
          <th>Time</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($appt = $apptResult->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($appt['client_name'] ?? $appt['name']); ?></td>
            <td><?php echo htmlspecialchars($appt['email']); ?></td>
            <td><?php echo htmlspecialchars($appt['service']); ?></td>
            <td><?php echo htmlspecialchars($appt['date']); ?></td>
            <td><?php echo htmlspecialchars($appt['time']); ?></td>
            <td>
              <a href="therapist_dashboard.php?cancel_appointment_id=<?php echo $appt['id']; ?>" class="btn-cancel" onclick="return confirm('Cancel this appointment?')">Cancel</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No appointments found.</p>
  <?php endif; ?>

</div>

</body>
</html>
