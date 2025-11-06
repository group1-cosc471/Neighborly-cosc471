<?php
// Jason R.

// Establish the database connection
require_once 'database.php';

// This function is called when a user decides to create an account on
// the website.
function createUser($conn, $username, $password, $first_name, $last_name, $phone_number)
{
   // Use the default PHP one-way hashing algorithm (bcrypt) to create a 
   // hashed password.
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   // Prepare the query for execution
   $query = $conn->prepare(
      "INSERT INTO user (email, user_password, first_name, last_name, phone_number)
      VALUES (?, ?, ?, ?, ?, ?)"
   );

   // Bind query parameters
   $query->bind_param("ssssss", $username, $hashed_password, $first_name, $last_name, $phone_number);

   // Execute the query
   if ($query->execute()) {
      // Upon the successful creation of an account, insert the auto
      // incremented ID of the newly inserted user.
      $user_id = $conn->insert_id;
      echo "New user was created successfully with ID: " . $user_id;
      return $user_id;
   } else {
      echo "An error was encountered while creating a new user: " . $query->error;
      return false;
   }
}

// Returns a list containing the associated ID, username, and password 
// given a user's credentials.
function getUserLogin($conn, $email)
{
   # Array containing the user's username (email), password, and user id
   $user = ['username' => $email, 'password' => '', 'u_id' => ''];

   $query = $conn->prepare(
      "SELECT u_id, user_password
      FROM user
      WHERE email = ?"
   );

   // Bind the email parameter to the ? placeholder for email in the
   // query/statement
   $query->bind_param("s", $email);

   // Execute the query/statement
   $query->execute();

   // Get the result of the executed query/statement
   $result = $query->get_result();

   // Store the username, user id, and password if the user exists (user
   // entered a valid email)
   if ($row = $result->fetch_assoc()) {
      $user['password'] = $row['user_password'];
      $user['u_id'] = $row['u_id'];
   } else {
      // No user found
      echo ("No user found with email: " . $email);
      return null;
   }

   // Return the user's credentials
   return $user;
}
