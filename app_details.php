<?php


include('db_connect.php');

// Getting app details from the database
if (isset($_GET['app_id'])) {
    $appId = $_GET['app_id']; // Passes app_id through URL
    $selectQuery = "SELECT * FROM Apps WHERE AppID = $appId";

    try {

        $result = mysqli_query($conn, $selectQuery);

        // Check if the query was successful
        if ($result) {
            
            if (mysqli_num_rows($result) > 0) {
                // Gets the app details
                $appDetails = mysqli_fetch_assoc($result);

                // Gets comments for the app
                $selectCommentsQuery = "SELECT Comments.*, users.username FROM Comments JOIN users ON Comments.user_id = users.user_id WHERE AppID = $appId";
                $resultComments = mysqli_query($conn, $selectCommentsQuery);

                
                include('navbar.php');

                // HTML PAGE
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title><?php echo $appDetails['Name']; ?> - App Oasis</title>

                    <!-- Bootstrap-->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

                    <!--JQuery-->
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                    
                    <link rel="stylesheet" type="text/css" href="index.css">
                </head>

                <body>
                  <!--Displays App details-->
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo $appDetails['Name']; ?></h2>

                                <p class="card-text"><strong>Publisher:</strong> <?php echo $appDetails['Publisher']; ?></p>

                                
                                <img src="<?php echo $appDetails['AppIcon']; ?>" alt="App Icon" class="card-img-top" style="max-width: 150px; max-height: 150px;">

                                <p class="card-text"><strong>Category:</strong> <?php echo $appDetails['Category']; ?></p>
                                <p class="card-text"><strong>Description:</strong> <?php echo $appDetails['Description']; ?></p>
                                <p class="card-text"><strong>Size:</strong> <?php echo $appDetails['Size']; ?> MB</p>
                            </div>
                        </div>
                  

                  <!-- Add Comment Form-->
                  <?php
                  if (isset($_SESSION['user_id'])) {
                        ?>
                        <div class="mt-4">
                        <h3>Add a Comment</h3>
                        <form action="add_comment.php" method="post"> <!--Links to PHP Script-->
                              <input type="hidden" name="app_id" value="<?php echo $appId; ?>">
                              <div class="mb-3">
                                    <label for="comment" class="form-label">Your Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary">Add Comment</button>
                        </form>
                        </div>
                        <?php
                  } else {
                        echo '<div class="mt-4"><p>Login to add comments.</p></div>';
                  }
                  ?>

                  <!--Display Comments Section-->
                  <div class="mt-4">
                        <h3>Comments</h3>
                        <?php
                        // Checks if there are comments
                        if ($resultComments) {
                        while ($comment = mysqli_fetch_assoc($resultComments)) {
                              ?>
                              <div class="card mb-2">
                                    <div class="card-body">
                                    <p class="card-text"><strong>User:</strong> <?php echo $comment['username']; ?></p>
                                    <p class="card-text"><strong>Date:</strong> <?php echo $comment['CommentDate']; ?></p>
                                    <p class="card-text"><strong>Comment:</strong> <?php echo $comment['CommentText']; ?></p>

                                    <!--Display Delete button if the user is an admin or moderator-->
                                    <?php
                                    if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Moderator')) {
                                          echo '<button class="btn btn-danger" onclick="deleteComment(' . $comment['CommentID'] . ')">Delete Comment</button>';
                                    }
                                    ?>
                                    </div>
                              </div>
                              <?php
                        }
                        } else {
                        echo "No comments found.";
                        }
                        ?>
                  </div>



                    
                    <script src="main.js"></script>

                    
                    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

                    
                    <script>
                        function deleteComment(commentId) {
                            if (confirm("Are you sure you want to delete this comment?")) {
                                // AJAX CALL
                                $.ajax({
                                    type: 'POST',
                                    url: 'delete_comment.php',
                                    data: { comment_id: commentId },
                                    success: function () {
                                        // Reload the page after sucessful deletion the comment
                                        location.reload();
                                    },
                                    error: function () {
                                        alert("Error deleting the comment.");
                                    }
                                });
                            }
                        }
                    </script>
                </body>
                </html>
                <?php
            } else {
                echo "Error: No data found for the specified app ID.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Display error message
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Missing app ID parameter.";
}
?>
