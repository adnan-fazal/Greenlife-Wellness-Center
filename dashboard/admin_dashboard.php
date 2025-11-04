<?php
session_start();
include '../backend/db.php';

// Show login success alert once
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . addslashes($_SESSION['login_success']) . "');</script>";
    unset($_SESSION['login_success']);
}

// Ensure admin is logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Handle deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $uid = intval($_POST['user_id']);
        $conn->query("DELETE FROM users WHERE id = $uid");
        $_SESSION['admin_message'] = "User deleted.";
    }
    if (isset($_POST['cancel_appointment'])) {
        $aid = intval($_POST['appointment_id']);
        $conn->query("DELETE FROM appointments WHERE id = $aid");
        $_SESSION['admin_message'] = "Appointment cancelled.";
    }
    if (isset($_POST['delete_message'])) {
        $mid = intval($_POST['message_id']);
        $conn->query("DELETE FROM messages WHERE id = $mid");
        $_SESSION['admin_message'] = "Message deleted.";
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch users and messages as before
$users    = $conn->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
$messages = $conn->query("SELECT id, name, email, message, sent_at FROM messages ORDER BY sent_at DESC");

// Fetch all appointments (no filter)
$appointments = $conn->query("SELECT id, name, email, service, date, time FROM appointments ORDER BY date, time");

// === New: Get filters from GET parameters for filtered appointments ===
$search = $_GET['search'] ?? '';
$filter_service = $_GET['service'] ?? '';
$filter_date = $_GET['date'] ?? '';

// Prepare SQL with filters for filtered appointments
$whereClauses = [];
$params = [];
$types = '';

if ($search !== '') {
    $whereClauses[] = "(name LIKE ? OR email LIKE ?)";
    $like_search = "%$search%";
    $params[] = $like_search;
    $params[] = $like_search;
    $types .= 'ss';
}
if ($filter_service !== '') {
    $whereClauses[] = "service = ?";
    $params[] = $filter_service;
    $types .= 's';
}
if ($filter_date !== '') {
    $whereClauses[] = "date = ?";
    $params[] = $filter_date;
    $types .= 's';
}

$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

$sqlFilteredAppointments = "SELECT id, name, email, service, date, time FROM appointments $whereSQL ORDER BY date, time";

if ($stmt = $conn->prepare($sqlFilteredAppointments)) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $filtered_appointments = $stmt->get_result();
} else {
    // fallback if prepare fails
    $filtered_appointments = $conn->query("SELECT id, name, email, service, date, time FROM appointments ORDER BY date, time");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - GreenLife</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; margin:0; padding:20px; }
    .dashboard { max-width:1200px; margin:auto; background:white; padding:20px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    h1 { color:#c0392b; }
    section { margin-bottom:40px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #ddd; padding:8px; text-align:left; }
    th { background:#e74c3c; color:white; }
    button { background:#c0392b; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; }
    button:hover { background:#a93226; }
    .logout { float:right; background:#555; }
    .message { padding:10px; background:#dff0d8; color:#3c763d; margin-bottom:20px; border:1px solid #d6e9c6; border-radius:4px; }
    form { display:inline; }

    .logout.button {
      display: inline-block;
      background-color: crimson;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      border: none;
      cursor: pointer;
      text-align: center;
      transition: background-color 0.3s ease;
    }
    .logout.button:hover {
      background-color: darkred;
    }

    /* Filter form styling */
    .filter-form {
      margin-bottom: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
      justify-content: flex-start;
    }
    .filter-form input[type="text"],
    .filter-form select,
    .filter-form input[type="date"] {
      padding: 7px 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      min-width: 180px;
    }
    .filter-form button {
      padding: 8px 16px;
      background: #0aae62;
      border: none;
      color: white;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .filter-form button:hover {
      background: #087a3e;
    }

    @media (max-width: 700px) {
      .filter-form {
        flex-direction: column;
        align-items: stretch;
      }
      .filter-form input[type="text"],
      .filter-form select,
      .filter-form input[type="date"],
      .filter-form button {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>
<div class="dashboard">
  <a href="../logout.php" class="logout button">Logout</a>
  <h1>Admin Dashboard</h1>

  <?php if (isset($_SESSION['admin_message'])): ?>
    <p class="message"><?php echo $_SESSION['admin_message']; unset($_SESSION['admin_message']); ?></p>
  <?php endif; ?>

  <!-- Users Section -->
  <section>
    <h2>Registered Users</h2>
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Action</th></tr>
      <?php while($u = $users->fetch_assoc()): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['name']); ?></td>
        <td><?php echo htmlspecialchars($u['email']); ?></td>
        <td><?php echo htmlspecialchars($u['role']); ?></td>
        <td><?php echo $u['created_at']; ?></td>
        <td>
          <form method="POST">
            <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
            <button type="submit" name="delete_user" onclick="return confirm('Delete this user?')">Delete</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>

  <!-- New Search Appointments Section -->
  <section>
    <h2>Search Appointments</h2>

    <form method="GET" class="filter-form" action="admin_dashboard.php">
      <input type="text" name="search" placeholder="Search by client name or email" value="<?php echo htmlspecialchars($search); ?>" />
      <select name="service">
        <option value="">All Services</option>
        <option value="Ayurvedic Therapy" <?php if($filter_service==='Ayurvedic Therapy') echo 'selected'; ?>>Ayurvedic Therapy</option>
        <option value="Yoga & Meditation" <?php if($filter_service==='Yoga & Meditation') echo 'selected'; ?>>Yoga & Meditation</option>
        <option value="Nutrition & Diet" <?php if($filter_service==='Nutrition & Diet') echo 'selected'; ?>>Nutrition & Diet</option>
        <option value="Massage Therapy" <?php if($filter_service==='Massage Therapy') echo 'selected'; ?>>Massage Therapy</option>
        <option value="Aromatherapy" <?php if($filter_service==='Aromatherapy') echo 'selected'; ?>>Aromatherapy</option>
        <option value="Acupuncture" <?php if($filter_service==='Acupuncture') echo 'selected'; ?>>Acupuncture</option>
        <option value="Wellness Coaching" <?php if($filter_service==='Wellness Coaching') echo 'selected'; ?>>Wellness Coaching</option>
      </select>
      <input type="date" name="date" value="<?php echo htmlspecialchars($filter_date); ?>" />
      <button type="submit">Filter</button>
    </form>

    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Service</th><th>Date</th><th>Time</th><th>Action</th></tr>
      <?php if ($filtered_appointments && $filtered_appointments->num_rows > 0): ?>
        <?php while($a = $filtered_appointments->fetch_assoc()): ?>
        <tr>
          <td><?php echo $a['id']; ?></td>
          <td><?php echo htmlspecialchars($a['name']); ?></td>
          <td><?php echo htmlspecialchars($a['email']); ?></td>
          <td><?php echo htmlspecialchars($a['service']); ?></td>
          <td><?php echo $a['date']; ?></td>
          <td><?php echo $a['time']; ?></td>
          <td>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="appointment_id" value="<?php echo $a['id']; ?>">
              <button type="submit" name="cancel_appointment" onclick="return confirm('Cancel this appointment?')">Cancel</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">No appointments found.</td></tr>
      <?php endif; ?>
    </table>
  </section>

  <!-- Existing All Appointments Section (unchanged) -->
  <section>
    <h2>All Appointments</h2>
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Service</th><th>Date</th><th>Time</th><th>Action</th></tr>
      <?php while($a = $appointments->fetch_assoc()): ?>
      <tr>
        <td><?php echo $a['id']; ?></td>
        <td><?php echo htmlspecialchars($a['name']); ?></td>
        <td><?php echo htmlspecialchars($a['email']); ?></td>
        <td><?php echo htmlspecialchars($a['service']); ?></td>
        <td><?php echo $a['date']; ?></td>
        <td><?php echo $a['time']; ?></td>
        <td>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="appointment_id" value="<?php echo $a['id']; ?>">
            <button type="submit" name="cancel_appointment" onclick="return confirm('Cancel this appointment?')">Cancel</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>

  <!-- Messages Section -->
  <section>
    <h2>Client Messages</h2>
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Sent At</th><th>Action</th></tr>
      <?php while($m = $messages->fetch_assoc()): ?>
      <tr>
        <td><?php echo $m['id']; ?></td>
        <td><?php echo htmlspecialchars($m['name'] ?? ''); ?></td>
        <td><?php echo htmlspecialchars($m['email']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($m['message'])); ?></td>
        <td><?php echo $m['sent_at']; ?></td>
        <td>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="message_id" value="<?php echo $m['id']; ?>">
            <button type="submit" name="delete_message" onclick="return confirm('Delete this message?')">Delete</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>

</div>
</body>
</html>
