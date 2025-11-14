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
            <h2>Update Sale</h2>
            <div class="form-group">
                <label for="streetAddr" class="space">Street Address</label>
                <input type="text" class="form-control" name="streetAddr" id="streetAddr" value="<?php echo htmlspecialchars($street); ?>">
            </div>
            <div class="form-group">
                <label for="municipality" class="space">City/Town</label>
                <input type="text" class="form-control" name="municipality" id="municipality" value="<?php echo htmlspecialchars($municipality); ?>">
            </div>
            <div class="form-group">
                <label for="start_date" class="space">Start date</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($s_date); ?>">
            </div>
            <div class="form-group">
                <label for="end_date" class="space">End date</label>
                <input type="date" name="end_date" id="start_date" value="<?php echo htmlspecialchars($e_date); ?>">
            </div>
            <div class="form-group">
                <label for="open_time" class="space">Open Time</label>
                <input type="time" name="open_time" id="open_time" value="<?php echo htmlspecialchars($open_time); ?>">
            </div>
            <div class="form-group">
                <label for="end_date" class="space">Open Time</label>
                <input type="time" name="close_time" id="close_time" value="<?php echo htmlspecialchars($close_time); ?>">
            </div>
            <div class="form-group">
                <label for="sale_type" class="space">Type of Sale</label>
                <input type="text" class="form-control" name="sale_type" id="sale_type" value="<?php echo htmlspecialchars($sale_type); ?>">
            </div>
        <input type="submit" name="post-sale" class="btn btn-primary" value ="Post Sale">&nbsp;&nbsp;
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
if (isset($_POST['post-sale'])){
    $street = $_POST['streetAddr'];
    $municipality = $_POST['municipality'];
    $s_date = $_POST['start_date'];
    $e_date = $_POST['end_date'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $sale_type = $_POST['sale_type'];

    $result = postSale($street, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type);

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

