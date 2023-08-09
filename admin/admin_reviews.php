<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all reviews
$reviews = [];
$sql_reviews = "SELECT r.Review_ID, u.username, dc.Name AS center_name, r.Rating, r.Review_Date, r.Review_Text
                FROM Reviews r
                JOIN users u ON r.User_ID = u.id
                JOIN Donation_Centers dc ON r.Center_ID = dc.Center_ID
                ORDER BY r.Review_Date DESC";
$result_reviews = $conn->query($sql_reviews);

if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Handle review deletion
if (isset($_GET['delete_review'])) {
    $review_id = $_GET['delete_review'];

    // Delete review from the database
    $sql_delete_review = "DELETE FROM Reviews WHERE Review_ID = ?";
    $stmt_delete_review = mysqli_prepare($conn, $sql_delete_review);
    mysqli_stmt_bind_param($stmt_delete_review, "i", $review_id);
    mysqli_stmt_execute($stmt_delete_review);
    mysqli_stmt_close($stmt_delete_review);

    // Redirect back to admin_reviews.php
    header("location: admin_reviews.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Reviews</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php include('admin_navbar.php'); ?>
    
    <div class="container">
        <h2 class="mt-4">Admin - Reviews</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Center Name</th>
                    <th>Rating</th>
                    <th>Review Date</th>
                    <th>Review Text</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?php echo $review['username']; ?></td>
                    <td><?php echo $review['center_name']; ?></td>
                    <td><?php echo $review['Rating']; ?></td>
                    <td><?php echo $review['Review_Date']; ?></td>
                    <td><?php echo $review['Review_Text']; ?></td>
                    <td><a href="?delete_review=<?php echo $review['Review_ID']; ?>" class="btn btn-danger">Delete</a></td>
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
