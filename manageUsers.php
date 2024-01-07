<!-- Purpose: Page to manage users and perform actions on a user. Actions are Change
Password, delete their account, and promote or demote them.-->
<?php
session_start();

// Checks if the user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'Admin') {
    // If not it redirects to the homepage
    header("Location: index.php");
    exit();
}


require_once 'db_connect.php';
require_once 'User.php';


$users = User::getAllUsers($conn); // Calls a function in the User class to get all users as an array.


include 'navbar.php';
?>

<!--HTML PAGE-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users - App Oasis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

    <!--Body Section-->
    <div class="container mt-5">
        <h1>Manage Users</h1>

        <?php
        // Displays a table of users with action buttons
        if ($users) {
            echo '<table class="table">';
            echo '<thead><tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>';
            echo '<tbody>';
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . $user->getUserId() . '</td>';
                echo '<td>' . $user->getFirstName() . '</td>';
                echo '<td>' . $user->getLastName() . '</td>';
                echo '<td>' . $user->getEmail() . '</td>';
                echo '<td>' . $user->getRole() . '</td>';
                echo '<td>';
                echo '<button class="btn btn-danger" onclick="deleteUser(' . $user->getUserId() . ')">Delete</button>';
                echo '<button class="btn btn-primary" onclick="changePassword(' . $user->getUserId() . ')">Change Password</button>';
                echo '<button class="btn btn-warning" onclick="promoteDemoteUser(' . $user->getUserId() . ')">Promote/Demote</button>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No users found.</p>';
        }
        ?>

    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tT8HShJRb7cLfi5o6OjqIAl2m+MfT+zE/N6t8=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!--JavaScript for user actions-->
    <script>
    function deleteUser(userId) {
if (confirm("Are you sure you want to delete this user?")) {
    $.ajax({
        type: "POST",
        url: "delete_user.php",
        data: { userId: userId },
        success: function (response) {
            // Handle the response
            console.log(response);
            // Reload the page
            location.reload();
        },
        error: function (error) {
            // Handle the error
            console.error(error);
        }
    });
}
}

function changePassword(userId) {
// Implement logic to prompt the admin for a new password
var newPassword = prompt("Enter the new password for the user:");

if (newPassword !== null) {
// Implement AJAX logic to change the user's password
$.ajax({
    type: "POST",
    url: "change_password.php",
    data: { userId: userId, newPassword: newPassword },
    success: function (response) {
        // Handle the response (e.g., show a success message)a
        console.log(response);
    },
    error: function (error) {
        // Handle the error (e.g., show an error message)
        console.error(error);
    }
});
}
}

function promoteDemoteUser(userId) {
var newRole = prompt("Enter the new role for the user:");

if (newRole !== null) {
$.ajax({
    type: "POST",
    url: "promote_demote_user.php",
    data: { userId: userId, newRole: newRole },
    success: function (response) {
        // Handle the response
        console.log(response);
    },
    error: function (error) {
        // Handle the error
        console.error(error);
    }
});
}
}
    </script>
</body>
</html>
