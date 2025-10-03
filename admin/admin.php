<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "salon_gs");

// --- HANDLE SERVICES CRUD ---
if (isset($_POST['add_service'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO services (name, description, price) VALUES ('$name','$desc','$price')");
}

if (isset($_GET['delete_service'])) {
    $id = $_GET['delete_service'];
    $conn->query("DELETE FROM services WHERE id=$id");
}

if (isset($_POST['update_service'])) {
    $id = $_POST['service_id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $conn->query("UPDATE services SET name='$name', description='$desc', price='$price' WHERE id=$id");
}



// --- FETCH DATA ---
$bookings = $conn->query("SELECT b.id, u.name as customer, s.name as service, b.booking_date, b.status 
                          FROM bookings b
                          JOIN users u ON b.user_id=u.id
                          JOIN services s ON b.service_id=s.id");
$services = $conn->query("SELECT * FROM services");
$feedbacks = $conn->query("SELECT f.id, u.name as customer, f.message, f.rating, f.created_at
                           FROM feedback f
                           JOIN users u ON f.user_id=u.id ORDER BY f.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<style>
body { font-family: Arial; margin:20px; }
nav a { margin-right:15px; cursor:pointer; color:blue; text-decoration:underline; }
.tab { display:none; margin-top:20px; }
table { border-collapse: collapse; width:100%; margin-top:10px; }
table, th, td { border:1px solid #ccc; padding:8px; }
th { background:#eee; }
form { margin-bottom:20px; }
</style>
<script>
function openTab(tabName){ let tabs=document.getElementsByClassName('tab'); for(let t of tabs)t.style.display='none'; document.getElementById(tabName).style.display='block'; }
function editService(id,name,desc,price){ document.getElementById('service_id').value=id; document.getElementById('name').value=name; document.getElementById('description').value=desc; document.getElementById('price').value=price; document.getElementById('addBtn').style.display='none'; document.getElementById('updateBtn').style.display='inline'; }
function editPromo(id,title,details,valid_until){ document.getElementById('promo_id').value=id; document.getElementById('title').value=title; document.getElementById('details').value=details; document.getElementById('valid_until').value=valid_until; document.getElementById('addPromoBtn').style.display='none'; document.getElementById('updatePromoBtn').style.display='inline'; }
</script>
</head>
<body>
<h1>Admin Panel</h1>
<p>Welcome, <?= $_SESSION['name'] ?> | <a href="logout.php">Logout</a></p>
<nav>
  <a onclick="openTab('bookings')">Bookings</a>
  <a onclick="openTab('services')">Services</a>
  <a onclick="openTab('feedback')">Feedback</a>
</nav>

<!-- BOOKINGS -->
<div id="bookings" class="tab" style="display:block;">
<h2>Bookings</h2>
<table>
<tr><th>ID</th><th>Customer</th><th>Service</th><th>Date</th><th>Status</th></tr>
<?php while($b=$bookings->fetch_assoc()): ?>
<tr>
<td><?= $b['id'] ?></td>
<td><?= $b['customer'] ?></td>
<td><?= $b['service'] ?></td>
<td><?= $b['booking_date'] ?></td>
<td><?= $b['status'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

<!-- SERVICES -->
<div id="services" class="tab">
<h2>Manage Services</h2>
<form method="POST">
<input type="hidden" id="service_id" name="service_id">
<input type="text" id="name" name="name" placeholder="Service Name" required><br>
<input type="text" id="description" name="description" placeholder="Description"><br>
<input type="number" step="0.01" id="price" name="price" placeholder="Price" required><br>
<button type="submit" name="add_service" id="addBtn">Add Service</button>
<button type="submit" name="update_service" id="updateBtn" style="display:none;">Update Service</button>
</form>

<h3>Existing Services</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th></tr>
<?php while($s=$services->fetch_assoc()): ?>
<tr>
<td><?= $s['id'] ?></td>
<td><?= $s['name'] ?></td>
<td><?= $s['description'] ?></td>
<td><?= $s['price'] ?></td>
<td>
<a href="#" onclick="editService('<?= $s['id'] ?>','<?= $s['name'] ?>','<?= $s['description'] ?>','<?= $s['price'] ?>')">Edit</a> |
<a href="admin_panel.php?delete_service=<?= $s['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

<!-- FEEDBACK -->
<div id="feedback" class="tab">
<h2>Customer Feedback</h2>
<table>
<tr><th>ID</th><th>Customer</th><th>Message</th><th>Rating</th><th>Date</th></tr>
<?php while($f=$feedbacks->fetch_assoc()): ?>
<tr>
<td><?= $f['id'] ?></td>
<td><?= $f['customer'] ?></td>
<td><?= $f['message'] ?></td>
<td><?= $f['rating'] ?></td>
<td><?= $f['created_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>

