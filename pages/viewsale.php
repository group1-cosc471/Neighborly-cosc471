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
    $items = getItemsbySale($id);

    // Build item cards
    $itemList = "";
    if ($items && count($items) > 0) {
        foreach ($items as $item) {

            $itemList .= <<<HTML
            <div>
                <div>
                    <h5>{$item['item_name']}</h5>
                    <p>{$item['item_dec']}</p>
                    <p><strong>Price:</strong> \${$item['price']}</p>
                    <a class="btn btn-primary" href="index.php?page=viewitem&item_id={$item['item_id']}">
                        View Item
                    </a>
                
            HTML;

            //if user is the seller allow to edit or delete
            if (isset($_SESSION['user'])) {
            if($_SESSION['user'] == $sale['seller_id'])
                $itemList .= "<button class='btn btn-primary' onclick=\"window.location.href='index.php?page=updateitem&item_id={$item['item_id']}'\">
                                Edit
                          </button>"; //todo implement delete or mark as sold?
        }

            $itemList .= '</div>
            </div>';
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

    if (isset($_SESSION['user'])) {
            if($_SESSION['user'] == $sale['seller_id'])
                $form .= "<button class='btn btn-primary' onclick=\"window.location.href='index.php?page=createitem&sale_id={$sale['sale_id']}'\">
                                New Item
                            </button>";
        }


    return [$message, $form];
}
?>