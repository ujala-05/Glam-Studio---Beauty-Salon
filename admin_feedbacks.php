<?php
include 'config.php';
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
           
           
    
                    <!-- Feedback Section -->
                <section>
                    <h3 style= "padding-top: 60px; padding-bottom: 30px;">All Feedbacks</h3>
                    <?php
                        $feedbackResult = $conn->query("
                            SELECT f.id, f.fullname, f.email, f.comments, f.rating, f.created_at
                            FROM feedback f
                            ORDER BY f.created_at DESC
                            ");

                        if ($feedbackResult->num_rows > 0) {
                            echo '<div style="display: flex; justify-content: center; margin-top: 20px;">';
                            echo '<table border="1" cellpadding="8" cellspacing="0">';
                            echo '<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Comments</th><th>Rating</th><th>Submitted At</th></tr>';
                            while ($row = $feedbackResult->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo '<td>'.$row['fullname'].'</td>';
                            echo '<td>'.$row['email'].'</td>';
                            echo '<td>'.$row['comments'].'</td>';
                            echo '<td>'.$row['rating'].'</td>';
                            echo '<td>'.$row['created_at'].'</td>';
                            echo '</tr>';
                            }
                            echo '</table>';
                            echo '</div>';
                            } else {
                            echo '<p style="text-align:center;">No feedback submitted yet.</p>';
                            }
                    ?>
                </section>
        </div>
    </body>
</html>

    