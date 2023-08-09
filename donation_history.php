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

// Fetch user's donated payments
$donation_history = [];
$sql_donations = "SELECT dc.Center_ID, dc.Name AS center_name, d.Donation_Amount, d.Donation_Type, d.Donation_Date
                  FROM Donations d
                  JOIN Donation_Centers dc ON d.Center_ID = dc.Center_ID
                  WHERE d.User_ID = ?";
$stmt_donations = mysqli_prepare($conn, $sql_donations);
mysqli_stmt_bind_param($stmt_donations, "i", $user_id);
mysqli_stmt_execute($stmt_donations);
$result_donations = mysqli_stmt_get_result($stmt_donations);

if ($result_donations) {
    while ($row = mysqli_fetch_assoc($result_donations)) {
        $donation_history[] = $row;
    }
}

mysqli_stmt_close($stmt_donations);

// Handle submitting reviews
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $center_id = $_POST['center_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Insert review into the database
    $sql_insert_review = "INSERT INTO Reviews (User_ID, Center_ID, Rating, Review_Date, Review_Text)
                          VALUES (?, ?, ?, NOW(), ?)";
    $stmt_insert_review = mysqli_prepare($conn, $sql_insert_review);
    mysqli_stmt_bind_param($stmt_insert_review, "iiis", $user_id, $center_id, $rating, $review);
    mysqli_stmt_execute($stmt_insert_review);
    mysqli_stmt_close($stmt_insert_review);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donation History</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Donation History for <?php echo $username; ?></h2>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Center Name</th>
                    <th>Donation Amount</th>
                    <th>Donation Type</th>
                    <th>Donation Date</th>
                    <th>Review</th>
                    <th>Share</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donation_history as $donation): ?>
                <tr>
                    <td><?php echo $donation['center_name']; ?></td>
                    <td>$<?php echo $donation['Donation_Amount']; ?></td>
                    <td><?php echo $donation['Donation_Type']; ?></td>
                    <td><?php echo $donation['Donation_Date']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="center_id" value="<?php echo $donation['Center_ID']; ?>">
                            <input class="mt-2 form-control" type="number" name="rating" placeholder="Rating" min="1" max="5" required>
                            <textarea class="mt-2 form-control" name="review" placeholder="Write a review" required></textarea>
                            <button class="mt-2 btn btn-primary" type="submit">Submit Review</button>
                        </form>
                    </td>
                    <td>
                        <a class="btn btn-success" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://yourwebsite.com"); ?>&quote=Check out this amazing donation center!" target="_blank">Share on Facebook</a>
                        <!-- You can add more social media sharing links here -->
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
