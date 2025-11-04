<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - GreenLife Wellness Center</title>
  <link rel="icon" type="image/x-icon" href="images/greenlife.png">
  <link rel="stylesheet" href="contactus.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="logo">
        <img src="images/greenlife.png" alt="GreenLife Logo">
        <span>GreenLife <span>Wellness Center</span></span>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="../index/index.html">HOME</a></li>
        <li><a href="../services/services.html">SERVICES</a></li>
        <li><a href="../aboutus/aboutus.html">ABOUT US</a></li>
        <li><a href="../blog/blog.html">BLOG</a></li>
        <li><a href="contactus.php">CONTACT</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
    <button class="login" onclick="window.location.href='../login/login.php'">Login</button>
    <button class="register" onclick="window.location.href='../register/register.php'">Register</button>
    </div>
  </header>

  <!-- CONTACT SECTION -->
  <section class="contact-section">
    <h1>CONTACT US !</h1>
    <img src="images/greenlifeCenter.webp" alt="GreenLife Center Image" class="contact-image"/>

    <div class="contact-wrapper">
      <!-- PHP SESSION MESSAGES -->
      <?php
if (isset($_SESSION['message_success'])) {
    echo "<script>alert('" . $_SESSION['message_success'] . "');</script>";
    unset($_SESSION['message_success']);
}
if (isset($_SESSION['message_error'])) {
    echo "<script>alert('" . $_SESSION['message_error'] . "');</script>";
    unset($_SESSION['message_error']);
}
?>

      <!-- FORM -->
      <form class="contact-form" method="POST" action="../backend/message.php">
        <h2>Send Us a Message</h2>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">CONTACT US</button>
      </form>

      <!-- HOURS -->
      <div class="business-hours">
        <h2>Business Hours</h2>
        <ul>
          <li>Monday: 8:00 AM – 6:00 PM</li>
          <li>Tuesday: 8:00 AM – 6:00 PM</li>
          <li>Wednesday: 8:00 AM – 6:00 PM</li>
          <li>Thursday: 8:00 AM – 6:00 PM</li>
          <li>Friday: 8:00 AM – 6:00 PM</li>
          <li>Saturday: 9:00 AM – 4:00 PM</li>
          <li>Sunday: Closed</li>
        </ul>
        <img src="images/greenlife.png" alt="GreenLife Logo" class="mini-logo">
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS SECTION -->
  <section class="response-section">
    <h2>Response of Our Clients</h2>
    <div class="testimonial-boxes">
      <div class="testimonial">
        <p>"Amazing service! Felt totally rejuvenated!"</p>
        <span>- John D. ★★★★★</span>
        <p>"The staff are so caring."</p>
        <span>- Lisa M. ★★★★☆</span>
        <p>"Highly recommend to anyone seeking wellness."</p>
        <span>- Raj S. ★★★★★</span>
      </div>
      <div class="testimonial">
        <p>"My pain relief was immediate."</p>
        <span>- Fatima A. ★★★★★</span>
        <p>"Excellent atmosphere and professional team."</p>
        <span>- Kevin P. ★★★★☆</span>
        <p>"Loved the yoga session."</p>
        <span>- Angela R. ★★★★★</span>
      </div>
      <div class="testimonial">
        <p>"The nutrition tips changed my life!"</p>
        <span>- Dan H. ★★★★☆</span>
        <p>"Massage therapy was heavenly."</p>
        <span>- Nisha W. ★★★★★</span>
        <p>"Great center for holistic care."</p>
        <span>- Saman K. ★★★★★</span>
      </div>
    </div>
  </section>

  <!-- IMAGE + MAP SECTION -->
  <section class="location-section">
    <div class="map-box">
      <div class="image-wrapper">
        <img src="images/happy.avif" alt="Happy Customer">
      </div>
      <div class="map-info">
        <iframe src="https://www.google.com/maps?q=Colombo&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        <p>Colombo, Sri Lanka</p>
        <p>Phone: 076-354-9339</p>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-grid">
      <div>
        <h3>JOIN US ON</h3>
        <div class="social">
          <a href="#"><i class="fa fa-whatsapp"></i></a>
          <a href="#"><i class="fa fa-instagram"></i></a>
          <a href="#"><i class="fa fa-facebook"></i></a>
          <a href="#"><i class="fa fa-youtube"></i></a>
        </div>
      </div>
      <div>
        <h4>Quick Links</h4>
        <ul>
          <li><a href="../index/index.html">Home</a></li>
          <li><a href="../services/services.html">Services</a></li>
          <li><a href="../aboutus/aboutus.html">About Us</a></li>
          <li><a href="../blog/blog.html">Blog</a></li>
          <li><a href="contactus.php">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Services</h4>
        <ul>
          <li>Ayurvedic Therapy</li>
          <li>Yoga & Meditation</li>
          <li>Nutrition & Diet</li>
          <li>Physiotherapy</li>
          <li>Massage Therapy</li>
          <li>Aromatherapy</li>
          <li>Acupuncture</li>
          <li>Wellness Coaching</li>
        </ul>
      </div>
      <div class="footer-newsletter">
        <h4>Newsletter</h4>
        <p>Subscribe to our newsletter for wellness tips and updates.</p>
        <input type="email" placeholder="Your email">
        <button>&rarr;</button>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 GreenLife Wellness Center. All rights reserved.</p>
      <div>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
      </div>
    </div>
  </footer>

</body>
</html>
