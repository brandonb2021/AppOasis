<!-- Page for signing up users, handles some client side validation and the form-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - App Oasis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <header class="page-header header container-fluid">
        <div class="card mx-auto" id="signupCard">
            <div class="card-body">
              <!-- Sign-up form -->
      <form action="signup.php" method="post" enctype="application/x-www-form-urlencoded">
      <div class="mb-3">
            <label for="FirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="FirstName" name="FirstName" aria-describedby="FirstNameHelp">
      </div>
      <div class="mb-3">
            <label for="LastName" class="form-label" id="FormLastNameLabel">Last Name</label>
            <input type="text" class="form-control" id="LastName" name="LastName" aria-describedby="LastNameHelp">
      </div>
      <div class="mb-3">
            <label for="InputEmail2" class="form-label" id="FormEmailLabel">Email address</label>
            <input type="email" class="form-control" id="InputEmail" name="InputEmail" aria-describedby="emailHelp">
            <div class="form-text" id="FormDisclaimer">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
            <label for="Username" class="form-label" id="FormUsernameLabel">Username</label>
            <input type="text" class="form-control" id="username" name="username">
      </div>
      <div class="mb-3">
            <label for="Password" class="form-label" id="FormPasswordLabel">Password</label>
            <input type="password" class="form-control" id="Password" name="Password">
      </div>
      <div class="mb-3">
            <label for="ConfirmPassword" class="form-label" id="FormConfirmPasswordLabel">Confirm Password</label>
            <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword">
      </div>
      <button type="submit" class="btn btn-primary" id="signupSubmit">Sign Up</button>
      </form>

            </div>
        </div>
    </header>
    <script src="main.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
