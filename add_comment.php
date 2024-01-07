<!-- PHP Script to handle adding comments to the database-->

<?php

session_start();


include('db_connect.php');

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    
    $appId = $_POST['app_id'];
    $userId = $_SESSION['user_id'];
    $commentText = $_POST['comment'];

    // Prepared Statement to improve security
    $sqlInsertComment = "INSERT INTO Comments (AppID, user_id, CommentText) VALUES (?, ?, ?)";

    try {

        $stmt = $conn->prepare($sqlInsertComment);
        $stmt->bind_param("iis", $appId, $userId, $commentText);
        $stmt->execute();

        // Check if the add was successful
        if ($stmt->affected_rows > 0) {
            // Redirect to app details page upon sucessful add
            header("Location: app_details.php?app_id=" . $appId);
        } else {
            echo "Error: Failed to insert comment.";
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {

        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: User not logged in.";
}
?>
