<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Process Delete
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql_delete = "DELETE FROM Donation_Centers WHERE Center_ID = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Donation center deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch Donation Centers with Category Names
$centers = [];
$sql_select = "SELECT dc.*, cat.name FROM Donation_Centers dc
               JOIN categories cat ON dc.Category_ID = cat.id";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $centers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Donation Centers</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php include('admin_navbar.php'); ?>
    
    <div class="container">
        <h2 class="mt-4">Manage Donation Centers</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Contact Number</th>
                    <th>Description</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($centers as $center): ?>
                <tr>
                    <td><?php echo $center['Name']; ?></td>
                    <td><?php echo $center['name']; ?></td>
                    <td><?php echo $center['Location']; ?></td>
                    <td><?php echo $center['Contact_Number']; ?></td>
                    <td><?php echo $center['Description']; ?></td>
                    <td><img src="<?php echo $center['Picture']; ?>" alt="Center Picture" width="100"></td>
                    <td>
                        <a href="edit_center.php?id=<?php echo $center['Center_ID']; ?>" class="btn btn-primary">Edit</a>
                        <a href="?delete=<?php echo $center['Center_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this center?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
