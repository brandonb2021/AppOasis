<?php
session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: signin.html");
    exit();
}


require_once 'db_connect.php';
require_once 'User.php';

// Gets user details from the database based on the userId stored in the session
$user = new User($conn);
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and the input data
    $confirmation = htmlspecialchars(trim($_POST["confirmation"]));

    if ($confirmation === "DELETE") {
        // Deletes Account based on function in user class
        $success = $user->deleteAccount($user_id);

        if ($success) {
            // Redirect to the home page
            header("Location: index.php?accountdeleted=true");
            exit();
        } else {
            // Handles account deletion failure
            header("Location: deleteAccount.php?error=deletefailed");
            exit();
        }
    } else {
        // Handle cancel
        header("Location: deleteAccount.php?error=confirmationfailed");
        exit();
    }
}
?>

<!-- HTML PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Account - App Oasis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <!-- Body Section -->
    <div class="container mt-5">
        <h1>Delete Account</h1>

        <?php
        // Display error messages
        if (isset($_GET["error"]) && $_GET["error"] === "deletefailed") {
            echo '<p class="text-danger">Failed to delete the account. Please try again.</p>';
        } elseif (isset($_GET["error"]) && $_GET["error"] === "confirmationfailed") {
            echo '<p class="text-danger">Confirmation value is incorrect.</p>';
        }
        ?>

        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <p>To confirm, type "DELETE" in the box below:</p>

        <!-- Account Deletion Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <input type="text" class="form-control" name="confirmation" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
