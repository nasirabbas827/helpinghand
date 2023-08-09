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

// Handle donation submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $center_id = $_POST['center_id'];
    $donation_amount = $_POST['donation_amount'];
    $donation_type = $_POST['donation_type'];

    // Insert donation record into the database
    $sql_insert_donation = "INSERT INTO Donations (User_ID, Center_ID, Donation_Amount, Donation_Type, Donation_Date)
                            VALUES (?, ?, ?, ?, NOW())";
    $stmt_insert_donation = mysqli_prepare($conn, $sql_insert_donation);
    mysqli_stmt_bind_param($stmt_insert_donation, "iiis", $user_id, $center_id, $donation_amount, $donation_type);
    mysqli_stmt_execute($stmt_insert_donation);
    mysqli_stmt_close($stmt_insert_donation);

    // Redirect to payments page if online donation
    if ($donation_type === 'Online Payment') {
        header("location: payment.php?donation_amount=$donation_amount");
        exit;
    }

    // Redirect to thank you page
    header("location: thank_you.php");
    exit;
}

// Retrieve center ID from query parameter
if (isset($_GET['center_id'])) {
    $center_id = $_GET['center_id'];

    // Fetch center details from the database
    $sql_center = "SELECT dc.*, cat.name AS category_name FROM Donation_Centers dc
                   JOIN categories cat ON dc.Category_ID = cat.id
                   WHERE dc.Center_ID = ?";
    $stmt_center = mysqli_prepare($conn, $sql_center);
    mysqli_stmt_bind_param($stmt_center, "i", $center_id);
    mysqli_stmt_execute($stmt_center);
    mysqli_stmt_bind_result($stmt_center, $center_id, $center_name, $category_id, $location, $contact_number, $description, $picture, $category_name);
    mysqli_stmt_fetch($stmt_center);
    mysqli_stmt_close($stmt_center);
} else {
    // Redirect back to search page if center ID is not provided
    header("location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donate to <?php echo $center_name; ?></title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container mb-5">
        <h2 class="mt-4">Donate to <?php echo $center_name; ?></h2>
        
        <div class="row">
            <div class="col-md-6">
                <h3>User Information:</h3>
                <p>Username: <?php echo $username; ?></p>
                <p>Email: <?php echo $email; ?></p>
                <p>Age: <?php echo $age; ?></p>
            </div>
            <div class="col-md-6">
                <h3>Donation Center Information:</h3>
                <p>Center Name: <?php echo $center_name; ?></p>
                <p>Category: <?php echo $category_name; ?></p>
                <p>Address: <?php echo $location; ?></p>
                <p>Contact Number: <?php echo $contact_number; ?></p>
                <p>Description: <?php echo $description; ?></p>
            </div>
        </div>

        <form action="" method="post">
            <input type="hidden" name="center_id" value="<?php echo $center_id; ?>">
            
            <div class="form-group">
                <label for="donation_amount">Donation Amount:</label>
                <input type="number" class="form-control" id="donation_amount" name="donation_amount" required>
            </div>

            <div class="form-group">
                <label for="donation_type">Donation Type:</label>
                <select class="form-control" id="donation_type" name="donation_type" required>
                    <option value="Online Payment">Online Payment</option>
                    <option value="Hand">Hand</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Donate</button>
        </form>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
