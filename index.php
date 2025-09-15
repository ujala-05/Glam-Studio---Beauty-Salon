<?php
// Database connection
$servername = "localhost";
$username   = "root";   // your MySQL username
$password   = "";       // your MySQL password
$dbname     = "demo_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Page with SQL</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>User List (Dynamic from Database)</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th></tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["name"]."</td>
                        <td>".$row["email"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>

