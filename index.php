<!--Purose: Home page for the website. Displays all apps and allows user to search all apps based on
Title, Publisher, Category, or description-->
<?php

session_start();


include 'db_connect.php';

// Initializes query
$searchQuery = "";

// Checks if query is provided
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Query to select apps from the Apps table with search filter
$sqlSelectApps = "SELECT * FROM Apps
                  WHERE Name LIKE '%$searchQuery%'
                     OR Publisher LIKE '%$searchQuery%'
                     OR Category LIKE '%$searchQuery%'
                     OR Description LIKE '%$searchQuery%'";

// Executes the query
$result = $conn->query($sqlSelectApps);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App Oasis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <!--Navbar-->
    <?php include 'navbar.php'; ?>

    <!--Search Card-->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card mb-3" id="app-search-card">
                    <div class="card-body">
                        <h1 class="card-title" id="searchAppsTitle">Search for Apps</h1>
                        <form action="index.php" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." aria-label="Search for Apps" value="<?php echo $searchQuery; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- App Cards-->
    <div class="container mt-4">
        <div class="row">
            <?php
            // Checks if there are rows in the result
            if ($result->num_rows > 0) {
                // Get each row and display app information
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <a href="app_details.php?app_id=<?php echo $row['AppID']; ?>">
                                <img src="<?php echo $row['AppIcon']; ?>" class="card-img-top" alt="App Icon">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="app_details.php?app_id=<?php echo $row['AppID']; ?>">
                                        <?php echo $row['Name']; ?>
                                    </a>
                                </h5>
                                <p class="card-text">Publisher: <?php echo $row['Publisher']; ?></p>
                                <p class="card-text">Category: <?php echo $row['Category']; ?></p>
                                <p class="card-text">Description: <?php echo $row['Description']; ?></p>
                                <p class="card-text">Size: <?php echo $row['Size']; ?> MB</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No apps found.";
            }
            ?>

        </div>
    </div>


    <script src="main.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    
</body>
</html>
