<?php
//Patrick Martus

//login page
//calls the get user function from the user file to get the password from the database and compares to the entered password.
//if successful sets the  session user_id and email.
function init()
{
    $acknowledgement = null;
    require_once '../app/db/user.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //if the loggin button is pressed
    if (!empty($_REQUEST['login'])) {

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        if (empty($email) || empty($password)) {
            $acknowledgement = 'Please enter both email and password';
        } else {
            // //create bindings
            // $credentials = [[':email', $email, 'str']];

            //execute the statement
            $user = getUserLogin($email);

            //if a password and a status are returned from the database
            if ($user && !empty($user['password'])) {
                //check if the password is a match
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user['item_id'];
                    $_SESSION['name'] = $user['email']; //todo set to first and last name

                    header("location: index.php?page=listsales");
                    exit();
                } else {
                    $acknowledgement = 'Invalid password';
                }
            } else {
                $acknowledgement = 'Invalid email';
            }
        }
    }

    // Build error message HTML outside heredoc
    $errorMessage = '';
    if (!empty($_REQUEST['login']) && $acknowledgement != null) {
        $errorMessage = <<<HTML
        <div class="alert alert-danger" role="alert">
            {$acknowledgement}
        </div>
HTML;
    }

    $form = <<<HTML
    <head>
            <title>Login</title>
        </head>
        <body class="container">
            <form method="post">
                <h1>Login</h1>
                <div class="form-group">
                    <label for="email" class="space">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="">
                </div>
                <div class="form-group">
                    <label for="password" class="space">Password</label>
                    <input type="password" class="form-control" name="password" id="password" value="">
                </div>
                <input type="submit" name="login" class="btn btn-primary">&nbsp;&nbsp;
            </form>
             {$errorMessage}
        </body> 
    HTML;

    return [$acknowledgement, $form];
}
