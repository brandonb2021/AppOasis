<!-- Purpose: Page for any logged in user to request an app to be added-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request Page - App Oasis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="page-header header container-fluid">
        
        <div class="card mx-auto" id="requestCard">
            <div class="card-body">
                <!-- Request form -->
                <form action="submit_request.php" method="post" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="name" class="form-label">App Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" class="form-control" id="publisher" name="publisher" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">App Image URL</label>
                        <input type="url" class="form-control" id="url" name="url" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Size (in MB)</label>
                        <input type="number" class="form-control" id="size" name="size" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="requestSubmit">Submit Request</button>
                </form>
            </div>
        </div>
    </header>
    <script src="main.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
