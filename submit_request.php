<!-- Purpose: PHP Script to handle the submitting of requests to the database-->
<?php

include 'db_connect.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirects to the login page
    header("Location: signin.php");
    exit();
}

// Get user ID from the session
$userID = $_SESSION['user_id'];

// Get form data
$appName = $_POST['name'];
$publisher = $_POST['publisher'];
$appImageURL = $_POST['url'];
$category = $_POST['category'];
$description = $_POST['description'];
$size = $_POST['size'];

// Add Request to Requests Table
$sqlInsertRequest = "INSERT INTO Requests (user_id, Name, Publisher, AppIcon, Category, Description, Size, RequestedDate)
                     VALUES ($userID, '$appName', '$publisher', '$appImageURL', '$category', '$description', $size, NOW())";

if ($conn->query($sqlInsertRequest) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sqlInsertRequest . "<br>" . $conn->error;
}

$conn->close();
?>
