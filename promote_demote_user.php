<!--Purpose: PHP Script to hand the promotion and
demotion of a user given user Id-->
<?php

require_once 'db_connect.php';
require_once 'User.php';

// Check if the user ID and new role are provided
if (isset($_POST['userId'], $_POST['newRole'])) {
    $userId = $_POST['userId'];
    $newRole = $_POST['newRole'];

    // Update user role
    $user = new User($conn);
    $updated = $user->promoteToRole($userId, $newRole);

    if ($updated) {
        echo "Role updated successfully";
    } else {
        echo "Failed to update role";
    }
} else {
    echo "User ID or new role not provided";
}
?>
