<?php include 'config.php';

// Fetch services
$sql = "SELECT name, description, price, image FROM services";
$result = $conn->query($sql);
?>

<?php include 'header.php'; ?>

  <main>
    <div class="container">
      <h2 class="center-text">Our Services</h2>
      <p>
        We offer a wide range of beauty services to help you look and feel your best.
        At <strong>Glam Studio</strong>, every service is tailored to your unique style
        and preferences.
      </p>
      <!-- services updated directly from the database-->
      <div class="services-container">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '
            <div class="services-card">
              <a href="book-appointment.php">
                <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
              </a>
                <h2>' . htmlspecialchars($row['name']) . ' - $' . htmlspecialchars($row['price']) . '</h2>
              <p>' . htmlspecialchars($row['description']) . '</p>
            </div>';
          }
        } else {
          echo "<p>No services available at the moment.</p>";
        }
        $conn->close();
        ?>
      </div>
    </div>
  </main>

<?php include 'footer.php'; ?>


   

