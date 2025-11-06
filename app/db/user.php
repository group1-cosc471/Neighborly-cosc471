<?php
// Jason R.

// Establish the database connection
require_once 'database.php';

/**
 * createUser is called whenever a user decides to sign up and create
 * an account on the website. The fields entered by the user are
 * inserted into the database upon success, and an auto-incremented user
 * ID is also assigned.
 */
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

/***
 * updateUser updates changed user account information and returns the
 * user's ID.
 */
function updateUser($conn, $u_id, $fields) {}

/***
 * getUserById returns a user's information given their auto-incremented ID.
 */
function getUserById($conn, $user_id)
{
   // Prepare the query for execution
   $query = $conn->prepare(
      "SELECT u_id, email, first_name, last_name, phone_number FROM user WHERE u_id = ?"
   );

   // Bind query parameters
   $query->bind_param("i", $user_id);

   // Check to ensure that the query executed without any errors
   if ($query->execute()) {
      echo "Successfully retrieved user with ID" . $user_id;
   } else {
      echo "Error retrieving user with ID: " . $user_id;
      return null;
   }

   // Get the result of the query if it executed
   $result = $query->get_result();

   // Return the results of the query
   return $result->fetch_assoc();
}

/***
 * getUserLogin returns a list containing the associated ID, username,
 * and password given a user's login credentials.
 */
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
