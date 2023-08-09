<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Fetch user details from the database
$sql_user = "SELECT id, username, email, age FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
mysqli_stmt_bind_result($stmt_user, $fetched_id, $username, $email, $age);
mysqli_stmt_fetch($stmt_user);
mysqli_stmt_close($stmt_user);

// Fetch user's reviews
$user_reviews = [];
$sql_reviews = "SELECT r.Review_ID, dc.Name AS center_name, r.Rating, r.Review_Date, r.Review_Text
                FROM Reviews r
                JOIN Donation_Centers dc ON r.Center_ID = dc.Center_ID
                WHERE r.User_ID = ?";
$stmt_reviews = mysqli_prepare($conn, $sql_reviews);
mysqli_stmt_bind_param($stmt_reviews, "i", $user_id);
mysqli_stmt_execute($stmt_reviews);
$result_reviews = mysqli_stmt_get_result($stmt_reviews);

if ($result_reviews) {
    while ($row = mysqli_fetch_assoc($result_reviews)) {
        $user_reviews[] = $row;
    }
}

mysqli_stmt_close($stmt_reviews);

// Handle review deletion
if (isset($_GET['delete_review'])) {
    $review_id = $_GET['delete_review'];

    // Delete review from the database
    $sql_delete_review = "DELETE FROM Reviews WHERE Review_ID = ? AND User_ID = ?";
    $stmt_delete_review = mysqli_prepare($conn, $sql_delete_review);
    mysqli_stmt_bind_param($stmt_delete_review, "ii", $review_id, $user_id);
    mysqli_stmt_execute($stmt_delete_review);
    mysqli_stmt_close($stmt_delete_review);

    // Redirect back to user_reviews.php
    header("location: user_reviews.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Reviews</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Your Reviews, <?php echo $username; ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Center Name</th>
                    <th>Rating</th>
                    <th>Review Date</th>
                    <th>Review Text</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_reviews as $review): ?>
                <tr>
                    <td><?php echo $review['center_name']; ?></td>
                    <td><?php echo $review['Rating']; ?></td>
                    <td><?php echo $review['Review_Date']; ?></td>
                    <td><?php echo $review['Review_Text']; ?></td>
                    <td><a class="btn btn-danger" href="?delete_review=<?php echo $review['Review_ID']; ?>">Delete</a></td>
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
