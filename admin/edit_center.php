<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];

    // Fetch Center Details
    $sql_select = "SELECT * FROM Donation_Centers WHERE Center_ID = $edit_id";
    $result = $conn->query($sql_select);

    if ($result->num_rows == 1) {
        $center = $result->fetch_assoc();
    } else {
        echo "Center not found.";
        exit;
    }

    // Process Update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $location = $_POST['location'];
        $contact = $_POST['contact'];
        $description = $_POST['description'];

        $sql_update = "UPDATE Donation_Centers SET Name='$name', Category_ID='$category', Location='$location', Contact_Number='$contact', Description='$description' WHERE Center_ID=$edit_id";

        if ($conn->query($sql_update) === TRUE) {
            echo "Donation center updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Fetch Categories
    $categories = [];
    $sql_categories = "SELECT id, name FROM categories";
    $result_categories = $conn->query($sql_categories);

    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }
    }
} else {
    echo "Center ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donation Center</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php include('admin_navbar.php'); ?>
    
    <div class="container mb-5">
        <h2 class="mt-4">Edit Donation Center</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $center['Name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <?php $selected = ($category['Category_ID'] == $center['Category_ID']) ? 'selected' : ''; ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $selected; ?>><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $center['Location']; ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="number" class="form-control" id="contact" name="contact" value="<?php echo $center['Contact_Number']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $center['Description']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Center</button>
        </form>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

