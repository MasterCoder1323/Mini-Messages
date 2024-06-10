<?php
session_start();
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
    <h1>Mini Messages!</h1>
    <p>Login or Signup today!!!</p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-oi9jS+lZlPk09C$FD3SNvMkq8lfRDmWBQWrIYgU89yJGFBsllJb6/wrvjNGAz0yW" crossorigin="anonymous"></script>
</body>
</html>
<?php
$HTML = ob_get_clean(); // Get the buffered output
echo $HTML; // Output the HTML
?>