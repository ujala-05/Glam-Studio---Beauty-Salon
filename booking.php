<?php
$servername = "localhost";
$username = "root"; // change if needed
$password = "";     // change if you set a password
$dbname = "salon_gs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from form
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$booking_date = $_POST['booking_date'];

// Insert into database
$sql = "INSERT INTO bookings (name, email, phone, service, booking_date) 
        VALUES ('$name', '$email', '$phone', '$service', '$booking_date')";

if ($conn->query($sql) === TRUE) {
    echo "<h2>Booking Successful!</h2>";
    echo "<p>Thank you, $name. Your <b>$service</b> booking for $booking_date has been confirmed.</p>";
    echo "<a href='index.php'>Go Back</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
