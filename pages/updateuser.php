<?php
// updateuser.php - Jason R.

/**
 * Form page for updating an existing user's account details in the
 * neighborly_lol MySQL database. Retrieves the current values in the
 * database and prefills the form for editing/updating. Upon submission 
 * of the form, the updateUser function in user.php is called, which 
 * creates and executes the SQL query that updates the values for the 
 * user.
 */
function init($id)
{
    require_once '../app/db/user.php';

    $f_name = "";
    $l_name = "";
    $email = "";
    $phone = "";
    $password = "";
    $form = "";
    $message = "";

    // Check if the user is logged in to the webpage
    if (isset($_SESSION['user'])) {
        // Retrieve the current values
        $user = getUserById($id);
        $f_name = $user['f_name'];
        $l_name = $user['l_name'];
        $email = $user['email'];
        $phone = $user['phone_number'];
        $password = $user['password'];
        // Output passwords as censored strings (e.g. pwd123 --> ******)
        $password = str_repeat("*", strlen($password));

        // Build the form
        $form = <<<HTML
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <head>
                <title>Update Account Details</title>
            </head>

            <body>
                <form method=post>
                    <h1>Update Account Details</h1>
                    <div class="form-group">
                        <label for="f-name" class="space">First Name</label>
                        <input type="text" class="form-control" name="f-name" id="f-name" value="{$f_name}">
                    </div>
                    <div class="form-group">
                        <label for="l-name" class="space">Last Name</label>
                        <input type="text" class="form-control" name="l-name" id="l-name" value="{$l_name}">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="space">Username/Email</label>
                        <input type="text" $pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/" name="email" id="email" value="{$email}">
                    </div>
                    <div class="form-group">
                        <label for="password" class="space">Password</label>
                        <input type="text" class="form-control" name="password" id="password" value="{$passowrd}">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="space">Phone Number</label>
                        <input type="text" $pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/" name="phone" id="phone" value="{$phone}">
                    </div>
                    <input type="submit" name="update-user" class="btn btn-primary" value="Update Account Details">&nbsp;&nbsp;
                </form>
                
                <?php if (!empty($message)): ?>
                    <div class="user-message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </body>
            HTML;
        if (isset($_POST['update-user']) && getUserById($id)['u_id'] == $_SESSION['user']) {
            $f_name = $_POST['f_name'];
            $l_name = $_POST['l_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone_number'];
            $password = $_POST['password'];

            $result = updateUser($id, $f_name, $l_name, $email, $password, $phone);

            if ($result == 1) {
                $message = "Successfully updated account details.";
                header("location: index.php?page=updateuser&id={$id}");
            } else if ($result == 0) {
                $message = "Error updating account details. Please try again.";
            } else {
                $message = "Please login to the correct account before updating account details.";
            }
        }
    }
    return [$message, $form];
}
