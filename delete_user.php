<?php

require_once 'db_connect.php';
require_once 'User.php';

// Checks if the user ID is provided
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Delete the user using function in User Class
    $user = new User($conn);
    $deleted = $user->deleteAccount($userId);

    if ($deleted) {
        echo "User deleted successfully";
    } else {
        echo "Failed to delete user";
    }
} else {
    echo "User ID not provided";
}
?>
