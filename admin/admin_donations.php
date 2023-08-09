<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all donations made by users
$donation_history = [];
$sql_donations = "SELECT u.username, dc.Name AS center_name, d.Donation_Amount, d.Donation_Type, d.Donation_Date
                  FROM Donations d
                  JOIN users u ON d.User_ID = u.id
                  JOIN Donation_Centers dc ON d.Center_ID = dc.Center_ID
                  ORDER BY d.Donation_Date DESC";
$result_donations = $conn->query($sql_donations);

if ($result_donations->num_rows > 0) {
    while ($row = $result_donations->fetch_assoc()) {
        $donation_history[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Donations</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php include('admin_navbar.php'); ?>
    
    <div class="container">
        <h2 class="mt-4">Admin - Donations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Center Name</th>
                    <th>Donation Amount</th>
                    <th>Donation Type</th>
                    <th>Donation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donation_history as $donation): ?>
                <tr>
                    <td><?php echo $donation['username']; ?></td>
                    <td><?php echo $donation['center_name']; ?></td>
                    <td>$<?php echo $donation['Donation_Amount']; ?></td>
                    <td><?php echo $donation['Donation_Type']; ?></td>
                    <td><?php echo $donation['Donation_Date']; ?></td>
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
