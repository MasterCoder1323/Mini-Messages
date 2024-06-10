<?php
//require
require_once 'messageControle.php';
// Connect to the database
$db = new PDO('sqlite:main.sqlite');
// Get the arguments passed to the script
$arguments = $argv;
// Remove the script name from the arguments array
array_shift($arguments);
// Check if all required arguments are present
if (count($arguments) != 3) {
    echo "Usage: php sendM.php [sender_id] [recipient_id] [message]\n";
    exit;
}
// Extract arguments
$senderId = $arguments[0];
$recipientId = $arguments[1];
$message = $arguments[2];
// Execute functions
$output = sendMessage($db, $senderId, $recipientId, $message);
echo $output;
?>