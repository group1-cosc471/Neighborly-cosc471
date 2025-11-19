<?php
// Sadman Khan
// viewsale.php

function init($id)
{
    require_once '../app/db/sale.php';
    require_once '../app/db/items.php';

    $message = "";

    // Make sure ID exists
    if (!isset($id)) {
        return ["Invalid sale ID", "<p>Sale not found.</p>"];
    }

    // Fetch sale
    $sale = getSale($id);
    if (!$sale) {
        return ["Sale not found", "<p>Invalid sale.</p>"];
    }

    // Get items for this sale
    $items = getItemsForSale($id);

    // Build item cards
    $itemList = "";
    if ($items && count($items) > 0) {
        foreach ($items as $item) {

            $itemList .= <<<HTML
            <div class="card mt-3">
                <div class="card-body">
                    <h5>{$item['itemname']}</h5>
                    <p>{$item['itemDesc']}</p>
                    <p><strong>Price:</strong> \${$item['price']}</p>
                    <a class="btn btn-primary" href="index.php?page=viewitem&id={$item['item_id']}">
                        View Item
                    </a>
                </div>
            </div>
            HTML;
        }
    } else {
        $itemList = "<p>No items listed for this sale yet.</p>";
    }

    // Build final HTML page
    $form = <<<HTML
        <h2>{$sale['street_address']}, {$sale['municipality']}</h2>
        <hr>

        <h3>Items in this Sale</h3>
        {$itemList}

        <br>
        <a class="btn btn-secondary" href="index.php?page=listsales">Back to Sales</a>
    HTML;

    return [$message, $form];
}
?>