<?php
// Get the arguments passed to the script
$arguments = $argv;
// Remove the script name from the arguments array
array_shift($arguments);
// Print the arguments
echo "Arguments passed to the script:\n";
foreach ($arguments as $argument) {
  echo "- $argument\n";
}


// Connect to the database
echo "\n\nConnecting to the db main.sqlite\n\n\n";
$db = new PDO('sqlite:main.sqlite');


// Function to print table information
function printTableInfo($db, $tableName) {
    echo "Table: $tableName\n";
    echo "--------------------\n";
    // Get table schema
    $schemaQuery = "PRAGMA table_info($tableName)";
    $schemaResult = $db->query($schemaQuery);
    // Print column names
    echo "Columns:\n";
    while ($row = $schemaResult->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . " (" . $row['type'] . ")\n";
    }
    // Get data from the table
    $dataQuery = "SELECT * FROM $tableName";
    $dataResult = $db->query($dataQuery);
    // Print table data
    echo "Data:\n";
    while ($row = $dataResult->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . implode(", ", $row) . "\n";
    }
    echo "\n";
}


// Print table information for each table in the database


// Create the users table (if it doesn't exist)
echo "Checking users table\n";
$query = "SELECT CASE 
  WHEN EXISTS (SELECT 1 FROM sqlite_master WHERE type='table' AND name='users') 
  THEN 1 
  ELSE 0 
END AS table_exists;";
$stmt = $db->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result['table_exists'] == 1) {
  echo "The 'users' table exists!\n";
  echo "Printing table info for 'users' table\n";
  printTableInfo($db, 'users');
} else {
  echo "The 'users' table does not exist.\nCreating...\n";
  $db->exec("CREATE TABLE IF NOT EXISTS users (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      username VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL
  )");
  echo "The 'users' table has been created!\n";
}


// Create the messages table (if it doesn't exist)
echo "\n\nChecking Messages Table\n";
$query2 = "SELECT CASE 
  WHEN EXISTS (SELECT 1 FROM sqlite_master WHERE type='table' AND name='messages') 
  THEN 1 
  ELSE 0 
END AS table_exists1;";
$stmt2 = $db->query($query2);
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
if ($result2['table_exists1'] == 1) {
  echo "The 'messages' table exists!\n";
  echo "Printing table info for 'messages' table\n";
  printTableInfo($db, 'messages');
} else {
  echo "The 'messages' table does not exist.\nCreating...\n";
  $db->exec("CREATE TABLE IF NOT EXISTS messages (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      sender_id INTEGER NOT NULL,
      recipient_id INTEGER NOT NULL,
      message VARCHAR(255) NOT NULL,
      FOREIGN KEY (sender_id) REFERENCES users(id),
      FOREIGN KEY (recipient_id) REFERENCES users(id)
  )");
  echo "The 'messages' table has been created!\n";
}

?>