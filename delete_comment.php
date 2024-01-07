<?php

echo "Received comment_id: " . $_POST['comment_id'] . ", app_id: " . $_POST['app_id'];

include('db_connect.php');

// Checks if the form is submitted correctly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $commentId = $_POST['comment_id'];

    
    $appId = $_POST['app_id'];

    try {
        // Prepared Statement
        $deleteCommentQuery = "DELETE FROM Comments WHERE CommentID = ?";

        
        $stmt = $conn->prepare($deleteCommentQuery);
        $stmt->bind_param("i", $commentId);

        // Executes
        $stmt->execute();

        
        $stmt->close();

        // Redirects back to the app details page
        header("Location: app_details.php?app_id=$appId");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Handles the exception
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Invalid request.";
}
?>
