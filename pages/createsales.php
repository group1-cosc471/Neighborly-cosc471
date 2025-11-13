<?php 
//William Dalian
?>

<!DOCTYPE html>
<html>
    <head>
        <Title> Create New Sale </Title>
    </head>

    <body>
        <form method = post>
            <h2>Create a Sale</h2>
            <div class="form-group">
                <label for="streetAddr" class="space">Street Address</label>
                <input type="text" class="form-control" name="streetAddr" id="streetAddr" value="">
            </div>
            <div class="form-group">
                <label for="municipality" class="space">City/Town</label>
                <input type="text" class="form-control" name="municipality" id="municipality" value="">
            </div>
        </form>

        <?php if (!empty($message)):?>
            <div class = "user-message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </body>
</html>

<?php
require_once '../app/db/sale.php';
$message = "";

//get data from form post, pass it to the backend post sale function
if (isset($_POST['submit'])){
    $street = $_POST['streetAddr'];
    $municipality = $_POST['municipality'];

    $result = postSale($street, $municipality);

    if ($result = 0){
        $message = "Succesfully posted sale. Thank you.";
    }

    if ($result = 1){
        $message = "Error creating sale. Please try again.";
    }

    if ($result = 2){
        $message = "Error: you must be logged in to create a sale.";
    }
}

?>

