<?php
session_start();
$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
// Clear message after showing once
unset($_SESSION['message'], $_SESSION['message_type']);
?>

<style>
    .btn-back {
      background-color: crimson;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 4px;
      font-weight: bold;
      margin-top: 15px;
      display: inline-block;
    }
</style>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - GreenLife</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>

<?php if ($message): ?>
    <div class="alert <?php echo $message_type; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

  <div class="register-container">
    <h2>Create an Account</h2>
    <form method="POST" action="/GreenLife/backend/register.php">
  <input type="text" name="name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="password" name="confirm_password" placeholder="Confirm Password" required>
  <select name="role" required>
    <option value="" disabled selected>Select Role</option>
    <option value="client">Client</option>
    <option value="therapist">Therapist</option>
  </select>
  <button type="submit">Register</button>
  <button type="button" class="btn-back" onclick="window.location.href='../index/index.html'">Back</button>

  <p>Already have an account? <a href="../login/login.php">Login here</a></p>
</form>
  </div>
</body>
</html>
