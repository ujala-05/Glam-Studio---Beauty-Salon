<?php include 'header.php'; include 'config.php';

// Define certain time slots to choose from
$time_slots = ["10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];

// Fetch services name through id
$sql = "SELECT id, name FROM services";
$result = $conn->query($sql);

// Restore prefilled data if user was redirected from login
$prefill = $_SESSION['pending_booking'] ?? [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // If user is not logged in, save data and redirect to login
    if (!isset($_SESSION['user'])) {
        $_SESSION['pending_booking'] = $_POST;
        $_SESSION['login_message'] = "⚠️ Please login or register to complete your booking.";
        header("Location: login.php");
        exit();
    }

    // User is logged in → insert booking
    $user_id = $_SESSION['user']['id'];
    $service_id = $_POST['service_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $status = 'Pending'; // default status

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, booking_date, booking_time, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $service_id, $booking_date, $booking_time, $status);
    $stmt->execute();

    // Get the last inserted booking ID
    $booking_id = $conn->insert_id;
    $stmt->close();

    unset($_SESSION['pending_booking']); // clear saved data

    $_SESSION['success_message'] = "✅ Your booking was successful! Your Booking ID : " . $booking_id;
    header("Location: book-appointment.php");
    exit();
}

// block already booked slots for the selected date
$booked_slots = [];
if (isset($prefill['booking_date'])) {
    $date = $prefill['booking_date'];
    $res = $conn->query("SELECT booking_time FROM bookings WHERE booking_date='$date'");
    while ($row = $res->fetch_assoc()) {
        $booked_slots[] = $row['booking_time'];
    }
}
?>

<main>
    <div class="container">
      <h2 class="center-text">Book Your Appointment</h2>
      <!-- Success message -->
      <?php if (isset($_SESSION['success_message'])): ?>
      <p style="color:#e91e63; text-align: center;"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
      <!-- Booking appointment form-->
      <?php endif; ?>
        <form action="book-appointment.php" method="POST">
          <label for="name">Full Name</label>
          <input type="text" name="name" id="name" required
          value="<?php echo htmlspecialchars($prefill['name'] ?? ''); ?>">

          <label for="email">Email</label>
          <input type="email" name="email" id="email" required
          value="<?php echo htmlspecialchars($prefill['email'] ?? ''); ?>">

          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone"
          value="<?php echo htmlspecialchars($prefill['phone'] ?? ''); ?>">

          <label for="service">Select Service</label>
          <select name="service_id" id="service" required>
            <option value="">-- Choose a Service --</option>
              <?php
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                $selected = (isset($prefill['service_id']) && $prefill['service_id'] == $row['id']) ? 'selected' : '';
                echo '<option value="' . $row['id'] . '" ' . $selected . '>'. htmlspecialchars($row['name']) . '</option>';
                } 
                } else {
                echo '<option disabled>No services available</option>';
                }
              ?>
          </select>

          <label for="date">Booking Date</label>
          <input type="date" name="booking_date" id="date" required
          value="<?php echo htmlspecialchars($prefill['booking_date'] ?? ''); ?>">

          <label for="time">Booking Time</label>
            <select name="booking_time" id="time" required>
              <option value="">-- Choose a Time --</option>
              <?php foreach ($time_slots as $slot):
              $selected = (isset($prefill['booking_time']) && $prefill['booking_time'] == $slot) ? 'selected' : '';
              $disabled = in_array($slot, $booked_slots) ? 'disabled' : '';
              ?>
              <option value="<?php echo $slot; ?>" <?php echo $selected . ' ' . $disabled; ?>>
                <?php echo $slot . ($disabled ? " (Booked)" : ""); ?>
              </option>
              <?php endforeach; ?>
            </select>

            <button type="submit" class="button">Book Now</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
