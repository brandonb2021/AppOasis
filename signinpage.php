<!-- Page to handle the sign in form-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In - App Oasis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <header class="page-header header container-fluid">
        <!--Sign In form-->
        <div class="card mx-auto" id="signupCard">
            <div class="card-body">
                <form action="signin.php" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="username" class="form-label" id="FormUsernameLabel">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" id="FormPasswordLabel">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" id="signinSubmit">Sign In</button>
                </form>
            </div>
        </div>
    </header>

    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
