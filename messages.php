<?php
session_start();
//Impoer userfunc
require_once "messageControle.php";
require_once "userFunc.php";
// Connect to the database
$db = new PDO("sqlite:main.sqlite");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["message"])) {
        // Get the message text from the form
        $message = $_POST["message"];
        $recipientUsername = $_POST["recipient"];

        // Get recipient info using getUserInfo from userFunc.php
        $recipient = getUserInfo($db, $recipientUsername);

        // Check if recipient is found
        if (!$recipient) {
            // Handle recipient not found error
            echo $recipientUsername . " not found.\n";
            echo $recipient;
            echo "\n" . getUserInfo($db, "test");
            echo "\nRecipient not found!";
            exit();
        }
        // Get the user ID from the session
        $user_id = $_SESSION["user_id"];
        // Prepare and execute the SQL statement to insert the message
        sendMessage($db, $user_id, $recipient["id"], $message);
        header("Location: messages.php");
        exit();
    } else {
        $keys = array_keys($_POST);
        $key = $keys[0];
        $id = $key * 1;
        deleteMessage($db, $id);
    }
}
// Get all messages from the database
$messages = readMessages($db, $_SESSION["user_id"], "received");
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Messages App</title>
    <?php include "bootstrap_import.html"; ?>
</head>
<body>
  <?php require "navbar.php"; ?>
    <div class="container">
        <h1>Mini Messages</h1>
        <?php if (isset($_SESSION["username"])): ?>
            <div class="card mt-3">
                <div class="card-header">
                    Send a Message
                </div>
                <div class="card-body">
                    <form action="messages.php" method="post">
                        <div class="form-group">
                            <label for="recipient">Recipient:</label>
                            <input type="text" class="form-control" id="recipient" name="recipient" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <div class="mt-3">

            <h2>Messages</h2>
            <?php if (is_array($messages)): ?>
            <ul class="list-group">
                <form method="post">
                <?php foreach ($messages as $message): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span></span>
                                <span style="font-weight: bold;">
                                    <?php
                                    // Get the username for the message
                                    $sender = getUserInfoFromId(
                                        $db,
                                        $message["sender_id"]
                                    );
                                    echo "From " . $sender["username"] . ":";
                                    ?>
                                </span>
                                <br>
                                <?php echo $message["message"]; ?>
                                </span>
                                <span >
                                    <input type="submit" name="<?php echo $message[
                                        "id"
                                    ]; ?>" 
                                        class="btn btn-danger" value="Delete?" /> 
                                </span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                </form>
            </ul>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-oi9jS+lZlPk09C$FD3SNvMkq8lfRDmWBQWrIYgU89yJGFBsllJb6/wrvjNGAz0yW" crossorigin="anonymous"></script>
<br><br><br>
</body>
</html>
<?php
$HTML = ob_get_clean(); // Get the buffered output
echo $HTML; // Output the HTML

?>
