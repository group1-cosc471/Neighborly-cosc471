<?php
//user.php
// Jason R.

// Establish the database connection
require_once __DIR__ . '/database.php';

// Declare variables for relevant user data
$user_id;
$email;
$password;
$first_name;
$last_name;
$phone_number;

// Returns a list containing the associated id, username, and password 
// given a user's credentials
function getUserLogin($email)
{
   global $conn;

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

//retrieve the user by id number
function getFirstAndLastName($id) {
   global $conn;

   //prepare the query
   $query = $conn->prepare(
      "SELECT f_name, l_name
      FROM user
      WHERE u_id = ?"
   );

   //bind parameters
   $query->bind_param("i", $id);

   //run the query
   $query->execute();

   //get the result
   $result = $query->get_result();

  if($row = $result->fetch_assoc())
      return $row;
   else
      return 0;
}
