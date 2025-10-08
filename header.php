<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Glam Studio | beauty salon information system </title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <h1>Glam Studio</h1>
    <p>Beauty Salon Services</p>
    <nav>
      <ul style="display: flex;
      justify-content: center;
      gap: 15px;">
        <li><a href="index.php">Home</a></li>
        <li><a href="about-us.php">About Us</a></li>
        <li><a href="our-services.php">Our services</a></li>
        <li><a href="book-appointment.php">Book Appointment</a></li>
        <li><a href="booking-Status.php">Booking Status</a></li>
        <li><a href="ratings-feedback.php">Ratings & Feedback</a></li>
        <li><a href="contact-us.php">Contact Us</a></li>
        <?php if(isset($_SESSION['user'])): ?>
           <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
           <li><a href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
</header>