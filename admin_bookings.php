<?php
include 'config.php';
// ---------------- Update Booking Status ----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {
    $booking_id = intval($_POST['booking_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();

    $msg = "✅ Status updated successfully";
}

// ---------------- Fetch Bookings ----------------
$bookingsResult = $conn->query("
    SELECT 
        b.id, 
        b.booking_date, 
        b.booking_time, 
        b.status, 
        s.name AS service_name, 
        u.name AS customer_name, 
        u.email AS customer_email
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    JOIN users u ON b.user_id = u.id
    ORDER BY b.booking_date DESC
");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <style>
            table { border-collapse: collapse; width: 90%; margin: 20px auto; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
            th { background: #e91e63; }
            select, button { padding: 4px 8px; }
            .msg { text-align: center; color: #e91e63; font-weight: bold; margin-top: 10px; }
        </style>
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
           
           <!-- Bookings Section -->
            <!-- Success Message -->
            <?php if(isset($msg)) echo '<p class="msg">'.htmlspecialchars($msg).'</p>'; ?>

            <!-- Bookings Table -->
            <section>
                <h3 style="padding-top: 40px; padding-bottom: 20px;">All Bookings</h3>
                <?php if ($bookingsResult->num_rows > 0): ?>
                    <table>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Change Status</th>
                        </tr>
                        <?php while ($row = $bookingsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['customer_email']); ?></td>
                                <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                <td><?php echo $row['booking_date']; ?></td>
                                <td><?php echo $row['booking_time']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                        <select name="status" required>
                                            <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="Confirmed" <?php if($row['status']=='Confirmed') echo 'selected'; ?>>Confirmed</option>
                                            <option value="Completed" <?php if($row['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                        </select>
                                        <button type="submit" class="button">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
               <p style="text-align:center;">No bookings found.</p>
                <?php endif; ?>
            </section>
        </div>
    </body>
</html>

    