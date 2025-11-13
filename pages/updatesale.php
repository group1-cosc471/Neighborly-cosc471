<?php 
//William Dalian
?>

<!DOCTYPE html>
<html>
    <head>
        <Title> Update Sale </Title>
    </head>

    <body>
        <form method = post>
            <h2>Update Sale</h2>
            <div class="form-group">
                <label for="streetAddr" class="space">Street Address</label>
                <input type="text" class="form-control" name="streetAddr" id="streetAddr" value="">
            </div>
            <div class="form-group">
                <label for="municipality" class="space">City/Town</label>
                <input type="text" class="form-control" name="municipality" id="municipality" value="">
            </div>
        <input type="submit" name="update-sale" class="btn btn-primary" value ="Submit">&nbsp;&nbsp;
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

$seller_id;
$sale_id;

//check if a session id is set (user logged in)
if (isset($_SESSION['user'])){
    $seller_id = $_SESSION['user']
    $sale_id = ;

    $sale = getSale($sale_id);
    $street = $sale['street_address'];
    $municipality = $sale['municipality'];



if (isset($_POST['submit'])){

    $street = $_POST['streetAddr'];
    $municipality = $_POST['municipality'];

    $result = updateSale($sale_id, $street, $municipality);

    if ($result = 0){
        $message = "Succesfully updated sale. Thank you.";
    }

    if ($result = 1){
        $message = "Error creating sale. Please try again.";
    }

    if ($result = 2){
        $message = "Error: you must be logged in to create a sale.";
    }

}


?>