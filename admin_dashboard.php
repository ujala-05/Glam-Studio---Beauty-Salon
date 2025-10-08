<?php
include 'config.php';

// Fetch total counts of bookings, feedbacks and services
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$totalFeedbacks = $conn->query("SELECT COUNT(*) AS total FROM feedback")->fetch_assoc()['total'];
$totalServices = $conn->query("SELECT COUNT(*) AS total FROM services")->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body class="admin-table">
       <div class="admin-container">
           <h1>Glam Studio</h1>
                <!-- navigation of admin site -->
                <nav>
                    <ul style="display: flex;
                        justify-content: right;
                        gap: 15px;">
                        <li><a href="admin_dashboard.php" style="color: #e91e63; font-size:25px;">Dashboard</a></li>
                        <li><a href="admin_bookings.php" style="color: #e91e63; font-size:25px;">Bookings</a></li>
                        <li><a href="admin_feedbacks.php" style="color: #e91e63; font-size:25px;">Feedbacks</a></li>
                        <li><a href="admin_services.php" style="color: #e91e63; font-size:25px;">Services</a></li>
                        <li><a href="logout.php" style="color: #e91e63; font-size:25px;">Logout</a></li>
                    </ul>
                </nav>
                    <h3 style="text-align: left;">Welcome Admin!</h3>
                <!-- card structure for total bookings, feedbacks and services -->
                <div class="dashboard-container">
                    <div class="card">
                        <h2>Total Bookings</h2>
                        <p><?php echo $totalBookings; ?></p>
                    </div>
                    <div class="card">
                        <h2>Total Feedbacks</h2>
                        <p><?php echo $totalFeedbacks; ?></p>
                    </div>
                    <div class="card">
                        <h2>Total Services</h2>
                        <p><?php echo $totalServices; ?></p>
                    </div>
                </div>
        </div>
    </body>
</html>

    