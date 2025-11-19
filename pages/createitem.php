<?php
// Zinet Hyssen
// createitem.php


function init($id)
{
    require_once '../app/db/sale.php';
    require_once '../app/db/items.php';

    $message = "";

    // login check
    if (!isset($_SESSION['user'])) {
        $message = "Please log in first.";
        $form = "<p><a href='index.php?page=login'>Login</a></p>";
        return [$message, $form];
    }

    $sale_id = $id;
    $user_id = $_SESSION['user'];

    // Get sale info (to show location)
    $sale = getSale($sale_id);
    $location = $sale['street_address'] . ", " . $sale['municipality'];

    // Default form values
    $name = "";
    $desc = "";
    $price = "";

    // Handle submission
    if (isset($_POST['create-item'])) {

        $name  = $_POST['itemName'];
        $desc  = $_POST['itemDesc'];
        $price = $_POST['price'];

        if ($name == "" || $desc == "" || $price == "") {
            $message = "All fields are required.";
        } else {
            $result = createItem($sale_id, $name, $desc, $price);
            //create item will return the item id so that we can redirect to item
            if ($result > 0) {
                $message = "Item created successfully.";
                $name = "";
                $desc = "";
                $price = "";
                header("location: index.php?page=viewitem&id={$result}");
            } else {
                $message = "Error creating item.";
            }
        }
    }

    $form = <<<HTML
        <h2>Create Item for Sale at {$location}</h2>

        <form method="post">
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" class="form-control" name="itemName" value="{$name}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="itemDesc" rows="4">{$desc}</textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="price" step="0.01" value="{$price}">
            </div>

            <input type="submit" name="create-item" class="btn btn-primary" value="Create Item">
            &nbsp;&nbsp;
            <button type="button" class="btn btn-secondary"
                onclick="window.location.href='index.php?page=viewsale&id={$sale_id}'">
                Back to Sale
            </button>
        </form>

        <div class="user-message">{$message}</div>
    HTML;

    return [$message, $form];
}
