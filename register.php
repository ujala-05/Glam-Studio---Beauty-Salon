<?php
$conn = new mysqli("localhost", "root", "", "salon_gs");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = md5($_POST['password']);

    $sql = "INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$pass','customer')";
    if ($conn->query($sql)) {
        echo "<p>✅ Registration successful. <a href='login.php'>Login</a></p>";
    } else {
        echo "<p style='color:red;'>Error: ".$conn->error."</p>";
    }
}
?>
<h2>Customer Registration</h2>
<form method="POST">
  <input type="text" name="name" placeholder="Full Name" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Register</button>
</form>
