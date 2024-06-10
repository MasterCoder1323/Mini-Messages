<?php
session_start();
// Connect to the database
$db = new PDO('sqlite:main.sqlite');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the username already exists in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Username already exists, display an error message
        $error = "Username already exists.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Add the new user to the database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        // Redirect to the login page
        header('Location: login.php');
        exit;
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
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Mini Messages: Create Your Account!</h1>
        <div class="container mt-5">
            <div class="card mx-auto" style="max-width: 300px;">
                <div class="card-header">
                    <h5 class="card-title text-center">Register</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
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