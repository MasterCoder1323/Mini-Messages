<?php
//Require user functions
require_once 'userFunc.php';
// Connect to the database
$db = new PDO('sqlite:main.sqlite');
// Get the arguments passed to the script
$arguments = $argv;
// Remove the script name from the arguments array
array_shift($arguments);
// Handle arguments
if (count($arguments) < 2) {
    echo "Usage: php userC.php [command] [data]\n";
    echo "Commands: add, update, delete\n";
    exit;
}
$command = $arguments[0];
$data = array_slice($arguments, 1);
switch ($command) {
    case 'add':
        if (count($data) != 2) {
            echo "Usage: php userC.php add_user [username] [password]\n";
            exit;
        }
        $username = $data[0];
        $password = $data[1];
        addUser($db, $username, $password);
        break;
    case 'update':
        if (count($data) != 3) {
            echo "Usage: php userC.php update_user [id] [username] [password]\n";
            exit;
        }
        $id = $data[0];
        $username = $data[1];
        $password = $data[2];
        updateUser($db, $id, $username, $password);
        break;
    case 'delete':
        if (count($data) != 1) {
            echo "Usage: php userC.php delete_user [id]\n";
            exit;
        }
        $id = $data[0];
        deleteUser($db, $id);
        break;
    default:
        echo "Invalid command. Available commands: add, update, delete\n";
        exit;
}

?>