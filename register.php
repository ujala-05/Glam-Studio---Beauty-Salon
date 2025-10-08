<?php session_start(); include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = md5($_POST['password']);

    $sql = "INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$pass','customer')";
    if ($conn->query($sql)) {
        $_SESSION['success_message'] = "✅ Registration successful! Please log in below.";
        header("Location: login.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error: ".$conn->error."</p>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Customer Registration</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="form-table">
       <div class="login-container"> 
            <h1>Glam Studio</h1>
            <h2>Customer Registration</h2>
                <form method="POST" class="login-form">
                    <input type="text" name="name" placeholder="Full Name" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <button type="submit">Register</button>
                </form>
        </div>
    </body>
</html>
