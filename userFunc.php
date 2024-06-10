<?php
//Validate User
function validateUser($db, $username, $password){
  // Check if the username exists in the database
  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  // Check if the password matches the hashed password in the database
  if ($user && password_verify($password, $user['password'])) {
      return $user;
  } else {
    return false;
  }
}
//Get User Info from Username
function getUserInfo($db, $username){
  $stmt = $db->prepare("SELECT * FROM users WHERE username = :user");
  $stmt->bindParam(':user', $username);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getUserInfoFromId($db, $user_id){
  $stmt = $db->prepare("SELECT * FROM users WHERE id = :user_id");
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Function to add a new user
function addUser($db, $username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();
    echo "User added successfully.\n";
}
// Function to update a user
function updateUser($db, $id, $username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the new password
    $stmt = $db->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();
    echo "User updated successfully.\n";
}
// Function to delete a user
function deleteUser($db, $id) {
    $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    echo "User deleted successfully.\n";
}
?>