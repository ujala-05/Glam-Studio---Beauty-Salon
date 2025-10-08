<?php include 'header.php'; ?>

<main>
    <div class="container">
      <h2>Contact Us</h2>
      <p>We'd love to hear from you. Send us a message and our team will get back to you shortly.</p>

        <!-- CONTACT INFO + FORM -->
      <section class="contact-grid">
          <div class="contact-info">
            <h3>Salon Details</h3>
            <ul>
              <li><strong>Phone:</strong> <a href="tel:02 5487 2546">(02) 5487 2546</a></li>
              <li><strong>Email:</strong> <a href="mailto:info@glambeauty.com">info@glambeauty.com</a></li>
              <li><strong>Address:</strong> Level 1-5/302-306 Elizabeth St, Surry Hills NSW 2010</li>
              <li><strong>Hours:</strong> Mon–Fri 9:00–17:00</li>
            </ul>
            <div class="map-wrap" aria-label="Map placeholder">
              <!-- Google maps embeded -->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d828.0583511960646!2d151.20785876959224!3d-33.8836421849792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae22215cffff%3A0x38563d51c37fa1c2!2sLevel%201-5%2F302-306%20Elizabeth%20St%2C%20Surry%20Hills%20NSW%202010!5e0!3m2!1sen!2sau!4v1759458714975!5m2!1sen!2sau" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div> 
      </section>
      <!-- Contact form-->
      <h2 class="center-text">Contact Form</h2>
      <form name="contactForm" onsubmit="return validateForm()">
        <label>Name:<br><input type="text" name="name"></label><br><br>
        <label>Email Address:<br><input type="email" name="email"></label><br><br>
        <label>Message:<br><textarea name="message" rows="4"></textarea></label><br><br>
        <input type="submit" value="Send Message" class="button">
      </form>
    </div>
</main>
<script src="script.js"></script>

<?php include 'footer.php'; ?>
