<?php
//set credentials
$servername = "localhost";
$username = "neighborly";
$password = "123pwd456";
$dbname = "neighborly_lol";

//create the connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
//check db connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>