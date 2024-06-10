<?php
//REQUIRE
require_once 'messageControle.php';
// Connect to the database
$db = new PDO('sqlite:main.sqlite');
// Get the arguments passed to the script
$arguments = $argv;
// Remove the script name from the arguments array
array_shift($arguments);
// Check if the user ID and message type are provided
if (count($arguments) != 2) {
    echo "Usage: php readM.php [user_id] [message_type]\n";
    echo "Message types: sent, received\n";
    exit;
}
// Extract the user ID and message type
$userId = $arguments[0];
$messageType = $arguments[1];
// Retrieve messages for the user based on the message type
$messages = readMessages($db, $userId, $messageType);
// Display messages
if (!is_string($messages)) {
    echo "Messages for user ID $userId ($messageType):\n";
    foreach ($messages as $message) {
        echo "--------------------\n";
        echo "Sender ID: " . $message['sender_id'] . "\n";
        echo "Recipient ID: " . $message['recipient_id'] . "\n";
        echo "Message: " . $message['message'] . "\n";
    }
} else {
    echo $messages;
}
?>