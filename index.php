<?php
include('config.php');

// Fetch donation center categories
$categories = [];
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch donation centers
$centers = [];
$sql_centers = "SELECT * FROM Donation_Centers";
$result_centers = $conn->query($sql_centers);

if ($result_centers->num_rows > 0) {
    while ($row = $result_centers->fetch_assoc()) {
        $centers[] = $row;
    }
}

// Fetch user reviews
$reviews = [];
$sql_reviews = "SELECT r.Review_ID, u.username, dc.Name AS center_name, r.Rating, r.Review_Text
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .rating {
            color: gold;
        }
        .jumbotron {
            height: 650px;
            background: linear-gradient(to bottom, rgba(0,0,0, 0.5), rgba(0,0,0, 0.2)), url('./images/bg_image.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
        }
        .jumbotron h1{
            font-size: 80px;
        }
        .jumbotron p{
            font-size: 20px;
        }
    </style>
</head>
<body>
<?php
include('navbar.php');
?>
    <div class="jumbotron text-center mb-5">
        <h1>Welcome to Helping Hand</h1>
        <p>Make a difference in the lives of others through your donations!</p>
    </div>

    <div class="container">
        <h2>Donation Center Categories</h2>
        <div class="row">
            <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $category['name']; ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <h2>Donation Centers</h2>
        <div class="row">
            <?php foreach ($centers as $center): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="admin/<?php echo $center['Picture']; ?>" class="card-img-top" alt="Center Picture">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $center['Name']; ?></h5>
                        <p class="card-text">Address: <?php echo $center['Location']; ?></p>
                            <p class="card-text">Phone: <?php echo $center['Contact_Number']; ?></p>
                            <p class="card-text"><?php echo $center['Description']; ?></p>
                        <a href="login.php" class="btn btn-primary">Donate</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <h2>User Reviews</h2>
        <div class="row">
            <?php foreach ($reviews as $review): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $review['username']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $review['center_name']; ?></h6>
                        <p class="card-text"><?php echo $review['Review_Text']; ?></p>
                        <p class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $review['Rating']): ?>
                                    &#9733;
                                <?php else: ?>
                                    &#9734;
                                <?php endif; ?>
                            <?php endfor; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
