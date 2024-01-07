<!--Purpose: To allow a user to logout of the website and destroy the session.-->
<?php
session_start();

// Delete all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page
header("Location: index.php");
exit();
?>
