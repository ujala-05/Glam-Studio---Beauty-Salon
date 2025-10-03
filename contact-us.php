<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Our Services | Glam Studio</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"/>
</head>
<body>
  <?php include 'header.php'; ?>

  <main>
  <h2>Contact Us</h2>
  <form name="contactForm" onsubmit="return validateForm()">
    <label>Name:<br><input type="text" name="name"></label><br><br>
    <label>Email Address:<br><input type="email" name="email"></label><br><br>
    <label>Message:<br><textarea name="message" rows="4"></textarea></label><br><br>
    <input type="submit" value="Send Message">
  </form>
</main>
<script src="script.js"></script>

<?php include 'footer.php'; ?>
</body>
</html>
