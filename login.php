<?php
//Import User Tools
require_once 'userFunc.php';
// Connect to the database
$db = new PDO('sqlite:main.sqlite');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Validate User
    $result = validateUser($db, $username, $password);
    // Check if the password matches the hashed password in the database
    if ($result) {
        // Set session variables
        session_start();
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        // Redirect to the homepage
        header('Location: index.php');
        exit;
    } else {
        // Display an error message
        $error = "Invalid username or password.";
    }
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Messages App</title>
    <?php include 'bootstrap_import.html'; ?>
</head>
<body>
  <?php require 'navbar.php'; ?>
    <div class="container">
        <h1>Mini Messages: Log Into Your Account!</h1>
        <div class="container mt-5">
            <div class="card mx-auto" style="max-width: 300px;">
                <div class="card-header">
                    <h5 class="card-title text-center">Login</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-oi9jS+lZlPk09C$FD3SNvMkq8lfRDmWBQWrIYgU89yJGFBsllJb6/wrvjNGAz0yW" crossorigin="anonymous"></script>
</body>
</html>
<?php
$HTML = ob_get_clean(); // Get the buffered output
echo $HTML; // Output the HTML
?>