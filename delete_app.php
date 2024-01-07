<!--Purpose: PHP script to the deletion of an App from the database-->
<?php

include('db_connect.php');

// Checks if the form is submitted and if the app_id is set
if (isset($_POST['delete']) && isset($_POST['app_id'])) {
    $appId = $_POST['app_id'];

    $conn->begin_transaction();

    try {
        // Deletes associated comments first
        $deleteCommentsQuery = "DELETE FROM Comments WHERE AppID = $appId";
        $conn->query($deleteCommentsQuery);

        // Deletes the app
        $deleteAppQuery = "DELETE FROM Apps WHERE AppID = $appId";
        $conn->query($deleteAppQuery);

        // Executes the transaction
        $conn->commit();

        // Redirect back to the requests page with a success message
        header("Location: request.php?success=App and associated comments deleted successfully");
        exit();
    } catch (Exception $e) {
        // Reverses the transaction in case of an error
        $conn->rollback();

        // Redirect back to the requests page with an error message
        header("Location: request.php?error=Error deleting app and comments: " . $e->getMessage());
        exit();
    }
} else {
    // Redirects back to the requests page with an error message
    header("Location: requests.php?error=Invalid request");
    exit();
}
?>
