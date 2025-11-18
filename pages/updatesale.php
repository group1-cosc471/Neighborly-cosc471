<?php
 //William Dalian
 //Updates the selected sale.
 //updatesale.php
 //Retrieves the current values for the attributes for the selected sale. Prefills a form with those values,
 //and allows the user to change the values. On submission, gets the values from
 // the form post, and calls updateSale() in sale.php with the posted values and the sale id
 //to make an SQL request to the database to update the values for this sale.
 //Also redirects to the view sale page  for this sale on successful creation,
 //displays a success or error message as appropriate for the result
function init($id)
{
   

    require_once '../app/db/sale.php';
    $message = "";

    $street =  "";
    $municipality =  "";
    $s_date =  "";
    $e_date = "";
    $open_time =  "";
    $close_time =  "";
    $sale_type =  "";

    $seller_id;
    $sale_id;

    //check if a session id is set (user logged in), f it is, get the current values
    //for this sales, attributes, so the values can be filled in as default form
    //values for the update form.
    if (isset($_SESSION['user'])) {
        $seller_id = $_SESSION['user'];
        $sale_id = $id;

        $sale = getSale($sale_id);
        $street = $sale['street_address'];
        $municipality = $sale['municipality'];
        $s_date = $sale['s_date'];
        $e_date = $sale['e_date'];
        $open_time = $sale['open_time'];
        $close_time = $sale['close_time'];
        $sale_type = $sale['sale_type'];


        $form = <<<HTML
            <head>
                <Title> Update Sale </Title>
            </head>

            <body>
                <form method=post>
                    <h2>Update Sale</h2>
                    <div class="form-group">
                        <label for="streetAddr" class="space">Street Address</label>
                        <input type="text" class="form-control" name="streetAddr" id="streetAddr" value="{$street}">
                    </div>
                    <div class="form-group">
                        <label for="municipality" class="space">City/Town</label>
                        <input type="text" class="form-control" name="municipality" id="municipality" value="{$municipality}">
                    </div>
                    <div class="form-group">
                        <label for="s_date" class="space">Start date</label>
                        <input type="date" name="s_date" id="s_date" value="{$s_date}">
                    </div>
                    <div class="form-group">
                        <label for="e_date" class="space">End date</label>
                        <input type="date" name="e_date" id="e_date" value="{$e_date}">
                    </div>
                    <div class="form-group">
                        <label for="open_time" class="space">Open Time</label>
                        <input type="time" name="open_time" id="open_time" value="{$open_time}">
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="space">Open Time</label>
                        <input type="time" name="close_time" id="close_time" value="{$close_time}">
                    </div>
                    <div class="form-group">
                        <label for="sale_type" class="space">Type of Sale</label>
                        <input type="text" class="form-control" name="sale_type" id="sale_type" value="{$sale_type}">
                    </div>
                    <input type="submit" name="update-sale" class="btn btn-primary" value="Update Sale">&nbsp;&nbsp;
                    </form>

                <?php if (!empty($message)): ?>
                    <div class="user-message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </body>
            HTML;


        //when a user selects the submit button, get the user's values from the form, and
        //call the function (update sale) in sale.php to send an update request to the database
        //check to confirm that the sale does belong to the user first.
        if (isset($_POST['update-sale']) && $sale['seller_id'] == $_SESSION['user']) {

            $street = $_POST['streetAddr'];
            $municipality = $_POST['municipality'];
            $s_date = $_POST['s_date'];
            $e_date = $_POST['e_date'];
            $open_time = $_POST['open_time'];
            $close_time = $_POST['close_time'];
            $sale_type = $_POST['sale_type'];

            $result = updateSale((int)$sale_id, $street, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type);

            //display to the user the result of the update submission
            //and redirect if successful
            if ($result == 0) {
                $message = "Succesfully updated sale. Thank you.";
                header("location: index.php?page=viewsale&sale_id={$sale_id}");
            }

            if ($result == 1) {
                $message = "Error creating sale. Please try again.";
            } else {
                $message = "Please login to the correct account before updating a sale.";
            }
        }
    }
    return [$message, $form];
}
