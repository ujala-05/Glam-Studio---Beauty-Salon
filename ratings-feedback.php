<?php include 'header.php'; include 'config.php';
//controls feedback form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $comments = $_POST['comments'];
    $rating = $_POST['rating'];
//This enters feedback data into the database
    $stmt = $conn->prepare("INSERT INTO feedback (fullname, email, comments, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $fullname, $email, $comments, $rating);
    $stmt->execute();
    $stmt->close();

    $success_message = "✅ Thank you for your feedback!";
}
?>

<main>
<div class="container">
    <?php if(isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <h2>Feedback Form</h2> 
        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" id="fullname" placeholder="Your full name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Your email" required>

        <label for="rating">Rating</label>
        <select name="rating" id="rating" required>
            <option value="">-- Select Rating --</option>
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Fair</option>
            <option value="1">1 - Poor</option>
        </select>

        <label for="comments">Comments</label>
        <textarea name="comments" id="comments" rows="5" placeholder="Your feedback..." required></textarea>

        <button type="submit" class="button">Submit Feedback</button>
    </form>
</div>
</main>

<?php include 'footer.php';
?>
