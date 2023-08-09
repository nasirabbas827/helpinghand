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

// Retrieve donation amount from query parameter
if (isset($_GET['donation_amount'])) {
    $donation_amount = $_GET['donation_amount'];
} else {
    // Redirect to search page if donation amount is not provided
    header("location: search_centers.php");
    exit;
}

$payment_success = true; 

if ($payment_success) {
    // Update donation status in the database
    $sql_update_donation = "UPDATE Donations SET Payment_Status = 'Paid' WHERE User_ID = ? AND Donation_Amount = ?";
    $stmt_update_donation = mysqli_prepare($conn, $sql_update_donation);
} else {

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Payment Status</h2>
        <?php if ($payment_success): ?>
            <div class="alert alert-success" role="alert">
                <p>Your donation of $<?php echo $donation_amount; ?>  has been successfully processed.</p>
                <p>Thank you for your generosity! Your support will make a difference.</p>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <p>Sorry, there was a problem processing your payment for the donation.</p>
                <p>Please check your payment information and try again later. If the issue persists, feel free to contact us for assistance.</p>
            </div>
        <?php endif; ?>
        <p>For any inquiries or further assistance, please contact our support team at support@example.com.</p>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
