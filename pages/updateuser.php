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
    $form = "";
    $message = "";

    // Check if the user is logged in to the webpage
    if (isset($_SESSION['user'])) {
        // Retrieve the current values
        $user = getUserById($id);
        $f_name = $user['f_name'] ??  "";
        $l_name = $user['l_name'] ?? "";
        $email = $user['email'] ?? "";
        $phone_number = $user['phone_number'] ?? "";
        $user['user_password'] = getUserLogin($email)['password'];
        $password = $user['user_password'] ?? "";
        // Output passwords as censored strings (e.g. pwd123 --> ******)
        $censored_password = str_repeat("*", 8);

        // Build the form
        $form = <<<HTML
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <head>
                <title>Update Account Details</title>
            </head>

            <body>
                <form method="post">
                    <h2>Update Account Details</h2>
                    <div class="form-group">
                        <label for="f_name" class="space">First Name</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" value="{$f_name}">
                    </div>
                    <div class="form-group">
                        <label for="l_name" class="space">Last Name</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" value="{$l_name}">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="space">Username/Email</label>
                        <input type="email" class="form-control" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" name="email" id="email" value="{$email}">
                    </div>
                    <div class="form-group">
                        <label for="password" class="space">Password</label>
                        <input type="text" class="form-control" name="password" id="password" placeholder="{$censored_password}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="space">Phone Number</label>
                        <input type="tel" class="form-control" pattern="^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$" name="phone_number" id="phone_number" value="{$phone_number}">
                    </div>
                    <div class="form-group">
                        <label for="password_verify" class="space">Enter Current Password to Verify *</label>
                        <input type="password" class="form-control" name="password_verify" id="password_verify" value="" required>
                    </div>
                    <input type="submit" name="update_user" class="btn btn-primary" value="Update Account Details">&nbsp;&nbsp;
                </form>
                
                <?php if (!empty($message)): ?>
                    <div class="user-message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </body>
        HTML;

        $user = getUserById($id);

        if (isset($_POST['update_user']) && $user && $user['u_id'] == $_SESSION['user']) {
            $f_name = $_POST['f_name'];
            $l_name = $_POST['l_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $password = $_POST['password'];
            $verification = $_POST['password_verify'] ?? "";

            // Check to make sure the user entered their password
            // correctly for security

            $stored_email = $user['email'];
            $login_user = getUserLogin($stored_email);
            if ($login_user['password']) {
                if (password_verify($verification, $login_user['password'])) {
                    $result = updateUser($id, $f_name, $l_name, $email, $password, $phone_number);

                    if ($result == 0) {
                        $message = "Successfully updated account details.";
                        header("location: index.php?page=updateuser&user_id={$id}");
                        exit();
                    } else if ($result == 1) {
                        $message = "Error updating account details. Please try again.";
                    } else {
                        $message = "Please login to the correct account before updating account details.";
                    }
                }
            }
        }
    }
    return [$message, $form];
}
