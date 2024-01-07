<!-- Purpose: PHP Script for the processing of app requests, once an
Admin appoves a request the request details are added as a record in the 
apps table and then the request is deleted from the request table. -->

<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestId = $_POST['request_id'];

    // If request is approved or denied
    if (isset($_POST['approve'])) {
        // Gets the request details
        $selectRequestQuery = "SELECT * FROM Requests WHERE RequestID = $requestId";
        $resultRequest = $conn->query($selectRequestQuery);

        if ($resultRequest->num_rows > 0) {
            $requestDetails = $resultRequest->fetch_assoc();

            // Requested App is added to the Apps table
            $insertAppQuery = "INSERT INTO Apps (Name, Publisher, AppIcon, Category, Description, Size)
                               VALUES ('{$requestDetails['Name']}', '{$requestDetails['Publisher']}', '{$requestDetails['AppIcon']}', '{$requestDetails['Category']}', '{$requestDetails['Description']}', '{$requestDetails['Size']}')";

            if ($conn->query($insertAppQuery) === TRUE) {
                // Deletes the request from the Requests table
                $deleteRequestQuery = "DELETE FROM Requests WHERE RequestID = $requestId";
                $conn->query($deleteRequestQuery);

                // Provide a message and redirect to home page
                echo '<script>alert("Request approved and added to Apps table.");</script>';
                echo '<script>window.location.href = "index.php";</script>';
            } else {
                echo "Error approving request: " . $conn->error;
            }
        }
      // If request is denied
    } elseif (isset($_POST['deny'])) {
        // Delete the request from the Requests table
        $deleteRequestQuery = "DELETE FROM Requests WHERE RequestID = $requestId";
        if ($conn->query($deleteRequestQuery) === TRUE) {
            // Provide a message and redirect to the home page
            echo '<script>alert("Request denied and deleted.");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "Error denying request: " . $conn->error;
        }
    }
}
?>
