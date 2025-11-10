<?php
//Patrick Martus
function init() {
    $acknowlegement = '';
    require_once '../app/db/user.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //if the loggin button is pressed
    if (!empty($_REQUEST['login'])) {

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        
        // //create bindings
        // $credentials = [[':email', $email, 'str']];
        
        //execute the statement
        $user = getUserLogin( $email);
        
        //if a password and a status are returned from the database
        if (!empty($user['password'])) {
            
            //check if the password is a match
            if($user['password']===$password) {
                $_SESSION['user']= $user['u_id'];
                $_SESSION['name']=$user['email']; //todo set to first and last name

                header("location: index.php?page=listsales");
                exit();
            } else { $aknowlegement = 'invalid password'; }
        } else {
            $acknowlegement = 'invalid email';
        }
    }


    
    $form = <<<HTML
    <head>
            <title>Login</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
        </body> 
    HTML;

    return [$acknowlegement, $form];
}

?>