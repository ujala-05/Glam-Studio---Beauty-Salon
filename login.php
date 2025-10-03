<?php
session_start();
$conn = new mysqli("localhost", "root", "", "salon_gs");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass  = md5($_POST['password']);

    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];

        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: booking.php");
        }
        exit;
    } else {
        echo "<p style='color:red;'>❌ Invalid login</p>";
    }
}
?>
<h2>Login</h2>
<form method="POST">
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login</button>
</form>
<p>No account? <a href="register.php">Register here</a></p>
