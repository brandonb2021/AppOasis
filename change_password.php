<!--Purpose: PHP Script to Handle Password Change-->

<?php

require_once 'db_connect.php';
require_once 'User.php';

// Checkds if the user ID and new password are provided
if (isset($_POST['userId'], $_POST['newPassword'])) {
    $userId = $_POST['userId'];
    $newPassword = $_POST['newPassword'];

    // Update the users password
    $user = new User($conn);
    $updated = $user->updatePassword($userId, $newPassword);

    // Checks if successful
    if ($updated) {
        echo "Password updated successfully";
    } else {
        echo "Failed to update password";
    }
} else {
    echo "User ID or new password not provided";
}
?>
