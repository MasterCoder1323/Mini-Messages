<?php

function sendMessage($db, $senderId, $recipientId, $message) {
    // Validate sender and recipient IDs
    if (!is_numeric($senderId) || !is_numeric($recipientId)) {
        return "Invalid sender or recipient ID.\n";
    }
    // Insert the message into the database
    $stmt = $db->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (:sender_id, :recipient_id, :message)");
    $stmt->bindParam(':sender_id', $senderId);
    $stmt->bindParam(':recipient_id', $recipientId);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    return "Message sent successfully!\n";
}
function readMessages($db, $userId, $messageType) {
    // Validate user ID
    if (!is_numeric($userId)) {
        return "Invalid user ID.\n";
    }
    // Validate message type
    if (!in_array($messageType, ['sent', 'received'])) {
        return "Invalid message type. Valid types: sent, received\n";
    }
    // Retrieve messages for the user based on the message type
    if ($messageType === 'sent'){
        $stmt = $db->prepare("SELECT * FROM messages WHERE sender_id = :user_id");
    } else {
        $stmt = $db->prepare("SELECT * FROM messages WHERE recipient_id = :user_id");
    }
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Display messages
    if (count($messages) > 0) {
        return array_reverse($messages);
    } else {
        return "No $messageType messages found for user ID $userId.\n";
    }
}
function deleteMessage($db, $messageId){
    // Validate message ID
    if (!is_numeric($messageId)) {
        return "Invalid message ID.\n";
    }
    // Delete the message from the database
    $stmt = $db->prepare("DELETE FROM messages WHERE id = :message_id");
    $stmt->bindParam(':message_id', $messageId);
    $stmt->execute();
    return "Message deleted successfully!\n";
}

?>