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

// Fetch All Donation Centers
$all_centers = [];
$sql_select_all = "SELECT dc.*, cat.name FROM Donation_Centers dc
                   JOIN categories cat ON dc.Category_ID = cat.id";
$result_all = $conn->query($sql_select_all);

if ($result_all->num_rows > 0) {
    while ($row = $result_all->fetch_assoc()) {
        $all_centers[] = $row;
    }
}

// Process Search
$search_results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $location = $_POST['location'];

    // Fetch Donation Centers with Category Names based on search criteria
    $sql_select = "SELECT dc.*, cat.name FROM Donation_Centers dc
                   JOIN categories cat ON dc.Category_ID = cat.id
                   WHERE cat.id = $category AND dc.Location LIKE '%$location%'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}

// Fetch Categories
$categories = [];
$sql_select_categories = "SELECT id, name FROM categories";
$result_categories = $conn->query($sql_select_categories);

if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Donation Centers</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    
    <div class="container">
        <h2 class="mt-4">Search Donation Centers</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if (!empty($all_centers)): ?>
            <h3 class="mt-4">All Donation Centers:</h3>
            <div class="row">
                <?php foreach ($all_centers as $center): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./admin/<?php echo $center['Picture']; ?>" class="card-img-top" alt="Center Picture">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $center['Name']; ?></h5>
                            <p class="card-text">Address: <?php echo $center['Location']; ?></p>
                            <p class="card-text">Phone: <?php echo $center['Contact_Number']; ?></p>
                            <p class="card-text"><?php echo $center['Description']; ?></p>
                            <a href="donate.php?center_id=<?php echo $center['Center_ID']; ?>" class="btn btn-primary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($search_results)): ?>
            <h3 class="mt-4">Search Results:</h3>
            <div class="row">
                <?php foreach ($search_results as $center): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./admin/<?php echo $center['Picture']; ?>" class="card-img-top" alt="Center Picture">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $center['Name']; ?></h5>
                            <p class="card-text"><?php echo $center['Description']; ?></p>
                            <a href="donate.php?center_id=<?php echo $center['Center_ID']; ?>" class="btn btn-primary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p class="mt-4">No donation centers found based on your search criteria.</p>
        <?php endif; ?>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
