<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - GreenLife</title>
  <link rel="stylesheet" href="login.css" />
  <style>
    .login-container {
      max-width: 400px;
      margin: auto;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
      font-family: Arial, sans-serif;
    }
    input[type="email"], input[type="password"], button {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      font-size: 16px;
    }
    button {
      background-color: #2e7d32;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #1b4d1b;
    }
    .btn-back {
      background-color: crimson;
      margin-top: 10px;
      border: none;
      color: white;
      cursor: pointer;
      font-weight: bold;
    }
    p.error-message {
      color: red;
      margin: 10px 0;
      font-weight: bold;
    }
    p.success-message {
      color: green;
      font-weight: bold;
    }
    .register-link {
      margin-top: 15px;
      font-size: 14px;
    }
    label {
      display: block;
      margin-bottom: 10px;
      padding-top: 10px;
      font-weight: lighter;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="login-container">

    <!-- Show error or success messages -->
    <?php if (isset($_SESSION['login_error'])): ?>
      <p class="error-message"><?php echo htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['login_success'])): ?>
      <p class="success-message"><?php echo htmlspecialchars($_SESSION['login_success']); unset($_SESSION['login_success']); ?></p>
    <?php endif; ?>

    <h2>Login</h2>
    <form action="../backend/login.php" method="POST">
      <label for="email">Enter your email</label>
      <input type="email" name="email" id="email" placeholder="Email" required />

      <label for="password">Enter your password</label>
      <input type="password" name="password" id="password" placeholder="Password" required />

      <button type="submit">Login</button>
    </form>

    <button class="btn-back" onclick="window.location.href='../index/index.html'">Back</button>

    <p class="register-link">Don't have an account? <a href="../register/register.php">Register here</a></p>

  </div>
</body>
</html>
