<!--Purpose: Page for admins to manage apps and requests.-->

<?php

include('db_connect.php');

// Get all requests from the Requests table
$selectRequestsQuery = "SELECT * FROM Requests";
$resultRequests = $conn->query($selectRequestsQuery);

// Get all apps from the Apps table
$selectAppsQuery = "SELECT * FROM Apps";
$resultApps = $conn->query($selectAppsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Requests - App Oasis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>App Requests</h2>

        <?php
        // Checks if there are requests
        if ($resultRequests->num_rows > 0) {
            while ($row = $resultRequests->fetch_assoc()) {
                  // Displays Requests
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['Name']; ?></h5>
                        <p class="card-text">Publisher: <?php echo $row['Publisher']; ?></p>
                        <p class="card-text">Category: <?php echo $row['Category']; ?></p>
                        <p class="card-text">Description: <?php echo $row['Description']; ?></p>
                        <p class="card-text">Size: <?php echo $row['Size']; ?> MB</p>
                        <form action="process_request.php" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $row['RequestID']; ?>">
                            <button type="submit" name="approve" class="btn btn-success">Approve</button>
                            <button type="submit" name="deny" class="btn btn-danger">Deny</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No requests found.";
        }
        ?>

        <!-- Manage Apps -->
        <hr>
        <h2>All Apps</h2>

        <?php
        // Check if there are apps
        if ($resultApps->num_rows > 0) {
            while ($row = $resultApps->fetch_assoc()) {
                  // Display apps
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['Name']; ?></h5>
                        <p class="card-text">Publisher: <?php echo $row['Publisher']; ?></p>
                        <p class="card-text">Category: <?php echo $row['Category']; ?></p>
                        <p class="card-text">Description: <?php echo $row['Description']; ?></p>
                        <p class="card-text">Size: <?php echo $row['Size']; ?> MB</p>
                        <form action="delete_app.php" method="post">
                            <input type="hidden" name="app_id" value="<?php echo $row['AppID']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No apps found.";
        }
        ?>
    </div>

    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
