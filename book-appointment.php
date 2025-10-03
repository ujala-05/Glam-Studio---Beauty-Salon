<?php include 'header.php'; ?>

<main>
  <div class="container">
    <h2>Book Your Appointment</h2>
    <form action="booking.php" method="POST">
      <label for="name">Full Name</label>
      <input type="text" name="name" id="name" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone">

      <label for="service">Select Service</label>
      <select name="service" id="service" required>
        <option value="">-- Choose a Service --</option>
        <option value="Hair Coloring">Hair Coloring</option>
        <option value="Hair Styling">Hair Styling</option>
        <option value="Nail Extension">Nail Extension</option>
        <option value="Eye Extension">Eye Extension</option>
      </select>

      <label for="date">Booking Date</label>
      <input type="date" name="booking_date" id="date" required>

      <button type="submit" class="button">Book Now</button>
    </form>
  </div>
     
</main>

  <!-- Footer -->
<?php include 'footer.php'; ?>




