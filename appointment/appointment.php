<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Book Appointment - GreenLife</title>
  <link rel="stylesheet" href="appointment.css" />
</head>
<body>
  <div class="appointment-container">

    <?php
    if (isset($_SESSION['appointment_success'])) {
        echo '<p style="color: green; font-weight: bold;">' . $_SESSION['appointment_success'] . '</p>';
        echo '<a href="../index/index.html" style="display: inline-block; margin-top: 10px; padding: 8px 15px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">Back to Home</a>';
        unset($_SESSION['appointment_success']);
    }

    if (isset($_SESSION['appointment_error'])) {
        echo '<p style="color: red; font-weight: bold;">' . $_SESSION['appointment_error'] . '</p>';
        unset($_SESSION['appointment_error']);
    }
    ?>

    <h2>Book an Appointment</h2>
    <form action="../backend/appointment.php" method="POST">
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <select name="service" required>
        <option value="" disabled selected>Select Service</option>
        <option value="Ayurvedic Therapy">Ayurvedic Therapy</option>
        <option value="Yoga & Meditation">Yoga & Meditation</option>
        <option value="Nutrition & Diet">Nutrition & Diet</option>
        <option value="Massage Therapy">Massage Therapy</option>
        <option value="Aromatherapy">Aromatherapy</option>
        <option value="Acupuncture">Acupuncture</option>
        <option value="Wellness Coaching">Wellness Coaching</option>
      </select>
      <input type="date" name="date" required />
      <input type="time" name="time" required />
      <button type="submit">Submit Appointment</button>
      <a href="../index/index.html" class="btn-back-red">Back to Home</a>
    </form>
  </div>
</body>
</html>