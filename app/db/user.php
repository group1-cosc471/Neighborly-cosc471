<?php
//user.php - Jason R.

// Establish the database connection
require_once __DIR__ . '/database.php';

/**
 * createUser is called whenever a user decides to sign up and create
 * an account on the website. The fields entered by the user are
 * inserted into the neighborly_lol MySQL database upon success, and an 
 * auto-incremented user ID is also assigned.
 */
function createUser($username, $password, $f_name, $l_name, $phone_number)
{
   global $conn;

   // Use the default PHP one-way hashing algorithm (bcrypt) to create a 
   // hashed password.
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   // Prepare the query for execution
   $query = $conn->prepare(
      "INSERT INTO user (email, user_password, f_name, l_name, phone_number)
         VALUES (?, ?, ?, ?, ?)"
   );

   // Bind query parameters
   $query->bind_param("sssss", $username, $hashed_password, $f_name, $l_name, $phone_number);

   // Execute the query
   if ($query->execute()) {
      // Upon the successful creation of an account, insert the auto
      // incremented ID of the newly inserted user.
      $id = $conn->insert_id;
      echo "New user was created successfully with ID: " . $id;
      return $id;
   } else {
      echo "An error was encountered while creating a new user: " . $query->error;
      return false;
   }
}

/**
 * updateUser updates the user's account details in the neighborly_lol
 * MySQL database when the user makes a post request on the update user 
 * page. 
 */
function updateUser($id, $f_name, $l_name, $username, $password, $phone_number)
{
   global $conn;

   // SQL query to update all of the user account details upon form submission
   $stmt = $conn->prepare('UPDATE user
                              SET f_name = ?,
                              l_name = ?,
                              email = ?,
                              password = ?,
                              phone_number = ?
                              WHERE u_id = ?');

   // Bind parameters to user attributes
   $stmt->bind_param("sssssi", $f_name, $l_name, $username, $password, $phone_number, $id);

   // Return 0 upon success and 1 upon failure of executing the SQL statement
   if ($stmt->execute()) {
      return 0;
   }
   return 1;
}

/**
 * getUserFullName retrieves the user's first and last name given their 
 * auto-incremented user ID.
 */
function getUserFullName($id)
{
   global $conn;

   // Prepare the query
   $query = $conn->prepare(
      "SELECT f_name, l_name
         FROM user
         WHERE u_id = ?"
   );

   // Bind id parameter to u_id user attribute
   $query->bind_param("i", $id);

   // Run the query
   if (!$query->execute()) {
      echo "Error retrieving user name with ID: " . $id;
      return null;
   }

   // Get the result
   $result = $query->get_result();
   $row = $result->fetch_assoc();

   // Check to make sure the results exist and return accordingly
   if ($row) {
      return $row;
   } else {
      return null;
   }
}

/**
 * getUserById returns a user's information given their auto-incremented 
 * user ID.
 */
function getUserById($id)
{
   global $conn;

   // Prepare the query for execution
   $query = $conn->prepare(
      "SELECT u_id, email, f_name, l_name, phone_number FROM user WHERE u_id = ?"
   );

   // Bind query parameters
   $query->bind_param("i", $id);

   // Check to ensure that the query executed without any errors
   if (!$query->execute()) {
      echo "Error retrieving user with ID: " . $id;
      return null;
   }

   // Get the result of the query if it executed
   $result = $query->get_result();
   $row = $result->fetch_assoc();

   // Check to make sure the results exist and handle accordingly
   if ($row) {
      echo "Successfully retrieved user with ID: " . $id;
      return $row;
   } else {
      echo "No user found with ID: " . $id;
      return null;
   }
}

/**
 * getUserLogin returns a list containing the associated ID, username,
 * and password given a user's login credentials.
 */
function getUserLogin($email)
{
   global $conn;

   // Array containing the user's username (email), password, and user id
   $user = ['username' => $email, 'password' => null, 'id' => null];

   $query = $conn->prepare(
      "SELECT u_id, user_password
         FROM user
         WHERE email = ?"
   );

   // Bind the email parameter to the ? placeholder for email in the query/statement
   $query->bind_param("s", $email);

   // Execute the query/statement
   if (!$query->execute()) {
      echo "Error executing login query for email: " . $email;
      return null;
   }

   // Get the result of the executed query/statement
   $result = $query->get_result();

   // Store the username, user id, and password if the user exists
   if ($row = $result->fetch_assoc()) {
      $user['password'] = $row['user_password'];
      $user['id'] = $row['u_id'];
   } else {
      // No user found
      echo "No user found with email: " . $email;
      return null;
   }

   // Return the user's credentials
   return $user;
}
