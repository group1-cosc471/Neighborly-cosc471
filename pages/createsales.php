<?php
//William Dalian

function init()
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

    $form = <<<HTML
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <head>
            <Title> Create New Sale </Title>
        </head>
        <body>
            <form method=post>
                <h2>Create Sale</h2>
                <div class="form-group">
                    <label for="streetAddr" class="space">Street Address</label>
                    <input type="text" class="form-control" name="streetAddr" id="streetAddr" value="{$street}">
                </div>
                <div class="form-group">
                    <label for="municipality" class="space">City/Town</label>
                    <input type="text" class="form-control" name="municipality" id="municipality" value="{$municipality}">
                </div>
                <div class="form-group">
                    <label for="start_date" class="space">Start date</label>
                    <input type="date" name="start_date" id="start_date" value="{$s_date}">
                </div>
                <div class="form-group">
                    <label for="end_date" class="space">End date</label>
                    <input type="date" name="end_date" id="start_date" value="{$e_date}">
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


    if (isset($_POST['post-sale'])) {
        $street =  htmlspecialchars($_POST['streetAddr'] ?? "");
        $municipality =  htmlspecialchars($_POST['municipality'] ?? "");
        $s_date =  htmlspecialchars($_POST['start_date'] ?? "");
        $e_date =  htmlspecialchars($_POST['end_date'] ?? "");
        $open_time =  htmlspecialchars($_POST['open_time'] ?? "");
        $close_time =  htmlspecialchars($_POST['close_time'] ?? "");
        $sale_type =  htmlspecialchars($_POST['sale_type'] ?? "");

        //call to postSale function, pass user submitted values, and get result
        $result = postSale($street, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type);

        //if success, display a message stating such
        if ($result > 0) {
            $message = "Succesfully posted sale. Thank you.";
            header("location: index.php?page=viewsale&id={$result}");
        }

        //if theres an error creating the sale, show a message stating such.
        //todo change method to return id if true, 0 if error and -1 if not logged in
        if ($result == 0) {
            $message = "Error creating sale. Please try again.";
        }

        //if the user is not logged it, state that the user must login.
        if ($result == -1) {
            $message = "Error: you must be logged in to create a sale.";
        }
        return [$message, $form];
    }
}
