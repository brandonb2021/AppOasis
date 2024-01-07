<!-- Purpose: To display user account details, links to basic account management, and allows admins to access admin pages.-->

<?php

session_start();

// Checks if the user is logged in, if not redirect to sign in page
if (!isset($_SESSION["user_id"])) {
    header("Location: signinpage.php");
    exit();
}


require_once 'db_connect.php';
require_once 'User.php';

// RGets user details from the database based on the userId in the session
$user_id = $_SESSION["user_id"];
$user = User::getUserDetailsById($conn, $user_id);
?>

<!-- HTML PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Details - App Oasis</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="index.css">
    <?php
    
    include 'navbar.php';
    ?>
</head>
<body>

    <!-- Body Section -->
    <div class="container mt-5">
        <h1>Account Details</h1>
        <?php
        // Check if user exists
        if ($user) {
            // Displays user details
            echo '<p><strong>First Name:</strong> ' . $user->getFirstName() . '</p>';
            echo '<p><strong>Last Name:</strong> ' . $user->getLastName() . '</p>';
            echo '<p><strong>Email:</strong> ' . $user->getEmail() . '</p>';
            echo '<p><strong>Role:</strong> ' . $user->getRole() . '</p>';
            echo '<button class="btn btn-primary" onclick="window.location.href=\'changePasswordPage.php\'">Change Password</button>';
            echo '<button class="btn btn-primary" onclick="window.location.href=\'deleteAccountPage.php\'">Delete Account</button>';

            //Only displays if user is an Admin
            if ($user->getRole() === 'Admin') {
            echo '<button class="btn btn-primary" onclick="window.location.href=\'request.php\'">Manage Apps and Requets</button>';
            echo '<button class="btn btn-primary" onclick="window.location.href=\'manageUsers.php\'">Manage Users</button>';
            }
        } else {
            echo '<p>User not found</p>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
