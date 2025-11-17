<?php
//Patrick Martus

//form page for updating an existing item in the database. 
// gets the current values from the database and prefills the form with those values
//on sumbmit calls the update form method from the item class and attempts to add the item to the database
function init($id)
{
    

    require_once '../app/db/item.php';
    require_once '../app/db/sale.php';
    $message = "";
  
    $name =  "";
    $description =  "";
    $price =  "";

    //check if the user is logged in
    if (isset($_SESSION['user'])) {
        $seller_id = $_SESSION['user'];
        $item_id = $id;

        //retrieve the current values
        $item = getItem($sale_id);
        $name = $item['item_name'];
        $description = $item['item_dec'];
        $price = $item['price'];

        //build the form with those values
        $form = <<<HTML
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <head>
                <Title> Update Sale </Title>
            </head>

            <body>
                <form method=post>
                    <h2>Update Sale</h2>
                    <div class="form-group">
                        <label for="item-name" class="space">Name</label>
                        <input type="text" class="form-control" name="item-name" id="item-name" value="{$name}">
                    </div>
                    <div class="form-group">
                        <label for="description" class="space">Description</label>
                        <input type="text" class="form-control" name="description" id="description" value="{$description}">
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="space">Price</label>
                        <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" placeholder="$0.00" name="price" id="price" value="{$price}">
                    </div>
                    <input type="submit" name="update-item" class="btn btn-primary" value="Update Item">&nbsp;&nbsp;
                    </form>

                <?php if (!empty($message)): ?>
                    <div class="user-message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </body>
            HTML;

        //if the form was submitted and the user is correct, call the function and attempt to update the item in the database
        if (isset($_POST['update-item']) && getSale($item['sale_id'])['seller_id'] == $_SESSION['user']) {

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $result = updateItem($item_id, $name, $description, $price);

            if ($result == 0) {
                $message = "Succesfully updated item. Thank you.";
            }

            if ($result == 1) {
                $message = "Error updating item. Please try again.";
            } else {
                $message = "Please login to the correct account before updating an item.";
            }
        }
    }
    return [$message, $form];
}
