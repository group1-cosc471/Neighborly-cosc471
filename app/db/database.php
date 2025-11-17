<?php
//database.php

//set credentials
$servername = "localhost";
$username = "neighborly";
$password = "123pwd456";
$dbname = "neighborly_lol";

//create the connection to the database
global $conn;

// Try connecting to MySQL database via localhost
try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if db connection via localhost failed
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    // Handle exception connecting to db via localhost
} catch (Exception $e) {
    // Upon failure connecting to db via localhost, try connecting via 
    // 127.0.0.1
    try {
        $servername = "127.0.0.1";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check if connection via 127.0.0.1 failed
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        // Handle exception connecting to db via 127.0.0.1
    } catch (Exception $e2) {
        die("Connection failed: " . $e2->getMessage());
    }
}
