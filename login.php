<?php session_start(); include 'config.php';

$error = "";
$success_message = "";
$login_message= "";

//Showing and clearing the success message if set
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // remove it after showing once
}
// Showing and clearing the login message if set
if (isset($_SESSION['login_message'])) {
    $login_message = $_SESSION['login_message'];
    unset($_SESSION['login_message']); // remove it after showing once
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']); 
    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if ($result && $result->num_rows == 1) {
        $_SESSION['user'] = $result->fetch_assoc();

        // Redirect based on role
        if ($_SESSION['user']['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: book-appointment.php");
        }
        exit();
    } else {
        $error = "❌ Invalid email or password!";
    }
    // Check if booking data was saved
    if (isset($_SESSION['pending_booking'])) {
        header("Location: book-appointment.php");
        exit();
    }

    // Default redirect (no booking in progress)
    header("Location: book-appointment.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="form-table">
       <div class="login-container">
           <h1>Glam Studio</h1>
           <h2>Login</h2>
           <!-- Success message (from registration redirect) -->
           <?php if (!empty($success_message)): ?>
              <p style="color:#e91e63;"><?php echo $success_message; ?></p>
           <?php endif; ?>
            <!-- login message (from booking redirect) -->
           <?php if (!empty($login_message)): ?>
              <p style="color:#e91e63;"><?php echo $login_message; ?></p>
           <?php endif; ?>

           <!-- ❌ Error Message -->
           <?php if (!empty($error)): ?>
              <p style="color:red;"><?php echo $error; ?></p>
           <?php endif; ?>

            <!-- Login form -->
            <form method="POST" class="login-form">
               <input type="email" name="email" placeholder="Email" required><br>
               <input type="password" name="password" placeholder="Password" required><br>
               <button type="submit">Login</button>
            </form>
            <p class="register-link">No account? <a href="register.php">Register here</a></p>
        </div>
    </body>
</html>
