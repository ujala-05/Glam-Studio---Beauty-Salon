<?php
session_start();
include 'config.php'; // Make sure this file has $conn connection

// ---------------- ADD SERVICE ----------------
if (isset($_POST['add_service'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

     // Handling image upload feature
    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "images/"; // used 'images' folder to store the images of the services
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // create folder if not found
        }

        // To prevent overwriting: add timestamp before filename
        $filename = time() . "_" . basename($_FILES['image']['name']);
        $image = $targetDir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            die("❌ Error uploading image.");
        }
    }
// ---------statements------------
    $stmt = $conn->prepare("INSERT INTO services (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_services.php?msg= ✅Service added successfully");
    exit();
}

// ---------------- DELETE SERVICE ----------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT image FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        // Delete image file if it exists
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete record of the services from database
        $delStmt = $conn->prepare("DELETE FROM services WHERE id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
        $delStmt->close();

        header("Location: admin_services.php?msg=Service+deleted+successfully👍");
        exit();
    } else {
        echo "❌Service not found.";
    }

    $stmt->close();
}

// ---------------- FETCH SERVICES ----------------
$result = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 10px;
                text-align: center;
                border: 1px solid black;
            }

            img {
                width: 70px;
                height: 70px;
                object-fit: cover;
                border-radius: 8px;
            }
    
        </style>
    </head>
    <body class="admin-table">
       <div class="admin-container">
           <h1>Glam Studio</h1>
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
           
           
            <!-- Managing Services Section -->
            <section>
                <h2 style="padding-top: 10px;">Manage Services</h2>
                <!-- gives messages on successfully adding services or deletion of the services-->
                <?php if (isset($_GET['msg'])): ?>
                    <p class="msg"><?= htmlspecialchars($_GET['msg']) ?></p>
                <?php endif; ?>
   
                <h3 style="color: black; padding-top: 10px; padding-bottom: 30px;">Add New Service</h3>
                <!-- form for adding more services-->
                    <form method="POST" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Service Name" required>
                        <textarea name="description" placeholder="Description" required></textarea>
                        <input type="number" step="0.01" name="price" placeholder="Price ($)" required>
                        <input type="file" name="image" accept="image/*" required>
                        <button type="submit" name="add_service" class="button">Add Service</button>
                    </form>

                <h3 style="color: #e91e63; padding-top: 60px; padding-bottom: 30px;">Existing Services</h3>
                
                <!-- table details of services extracting from the database with delete action-->
                 <?php if ($result->num_rows > 0): ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Price ($)</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="Service"></td>
                            <td><a href="admin_services.php?delete=<?= $row['id'] ?>" class="button" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                        <?php else: ?>
                        <p>No services found.</p>
                        <?php endif; ?>
            </section>
        </div>
    </body>
</html>


