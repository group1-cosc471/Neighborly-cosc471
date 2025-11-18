<?php
require_once 'app/db/database.php';

global $conn;

// Get all users with their plain text passwords
$query = $conn->prepare("SELECT u_id, user_password FROM user");
$query->execute();
$result = $query->get_result();

while ($row = $result->fetch_assoc()) {
    $id = $row['u_id'];
    $plain_password = $row['user_password'];

    // Hash the password
    $hashed = password_hash($plain_password, PASSWORD_DEFAULT);

    // Update the database
    $update = $conn->prepare("UPDATE user SET user_password = ? WHERE u_id = ?");
    $update->bind_param("si", $hashed, $id);
    $update->execute();

    echo "Updated user ID $id: $plain_password => $hashed<br>";
}

echo "All passwords hashed!";
