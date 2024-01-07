<!-- PHP Script to handle signing in to the website and start a session-->
<?php
include 'db_connect.php';
include 'User.php';

// Create a new User instance and pass the database connection
$user = new User($conn);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    echo "Username: $username<br>";
    echo "Password: $password<br>";


    // Use the signin function of the User class
    $user->signin($username, $password);

} else {
    // If someone tries to access this file without submitting the form it redirects them to the sign-in page
    header("Location: signinpage.php");
    exit();
}
?>
