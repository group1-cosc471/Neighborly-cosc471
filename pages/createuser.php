<?php
// Sadman Khan
// createuser.php

require_once '../app/db/user.php';

function init() {
    $acknowlegement = '';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_REQUEST['create'])) {

        $f_name = $_REQUEST['f_name'] ?? '';
        $l_name = $_REQUEST['l_name'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone_number'] ?? '';
        $password = $_REQUEST['user_password'] ?? '';

        // check fields
        if ($f_name === "" || $l_name === "" || $email === "" || $phone === "" || $password === "") {
            $acknowlegement = "All fields are required.";
        } else {
            // try to create user (function from user.php)
            $result = createUser($email, $password, $f_name, $l_name, $phone);

            if ($result == -1) {
                $acknowlegement = "A user with that email already exists.";
            } elseif ($result > 0) {
                // success -> go to login
                header("Location: index.php?page=login");
                exit();
            } else {
                $acknowlegement = "There was a problem creating the account.";
            }
        }
    }

$form = <<<HTML
<head>
    <title>Create User</title>
</head>

<body class="container">
    <form method="post">
        <h1>Create Account</h1>

        <div class="form-group">
            <label for="f_name">First Name</label>
            <input type="text" class="form-control" name="f_name" id="f_name">
        </div>

        <div class="form-group">
            <label for="l_name">Last Name</label>
            <input type="text" class="form-control" name="l_name" id="l_name">
        </div>

        <div class="form-group">
            <label for="email" class="space">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>

        <div class="form-group">
            <label for="phone_number" class="space">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number">
        </div>

        <div class="form-group">
            <label for="user_password" class="space">Password</label>
            <input type="password" class="form-control" name="user_password" id="user_password">
        </div>

        <input type="submit" name="create" class="btn btn-primary" value="Create Account">
    </form>
</body>
HTML;

    return [$acknowlegement, $form];
}

?>
