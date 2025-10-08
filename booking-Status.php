<?php include 'header.php'; include 'config.php'; ?>
<main>
    <div class="container">
        <h2 class="center-text">View Booking</h2>
           <form method="post"><input name="id" placeholder="Booking ID" required><button class="button">View</button>
           </form>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = intval($_POST['id']);

                // Prepare the SQL query
                $stmt = $conn->prepare("
                    SELECT b.*, s.name 
                    FROM bookings b 
                    JOIN services s ON b.service_id = s.id 
                    WHERE b.id = ?
                ");
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $result = $stmt->get_result();
                $booking = $result->fetch_assoc();

                $stmt->close();
                    // displaying the details of the booking
                if ($booking) {
                    echo '<h2 class="center-text">Booking Details</h2>';
                    echo '<p class="booking-details"><strong>Booking ID:</strong> ' . htmlspecialchars($booking['id']) . '</p>';
                    echo '<p class="booking-details"><strong>Service:</strong> ' . htmlspecialchars($booking['name']) . '</p>';
                    echo '<p class="booking-details"><strong>Date:</strong> ' . htmlspecialchars($booking['booking_date']) . '</p>';
                    echo '<p class="booking-details"><strong>Time:</strong> ' . htmlspecialchars($booking['booking_time'] ?? '-') . '</p>';
                    echo '<p class="booking-details"><strong>Status:</strong> ' . htmlspecialchars($booking['status']) . '</p>';
                    } else {
                    echo '<p style="color:#e91e63; text-align:center;">Booking not found</p>';
                    }
                }
            ?>
    </div>
</main>

<?php include 'footer.php';
?>
