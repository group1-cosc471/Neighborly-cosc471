<?php
//Patrick Martus
//This page allows a user to view an item's details, if the logged in user is the seller of that item, the user will be able
//to edit the item as well


function init($item_id)
{

    require_once '../app/db/items.php';
    require_once '../app/db/sale.php';

    $message = '';
    $item = getItem($item_id);
    $sale = getSale($item['sale_id']);
    $page = <<<HTML
        <head>
            <title>{$item['item_name']}</title>
        </head>

        <body>
            Description:
            <div>{$item['item_dec']}</div>
            Sale:
            <button class='btn btn-primary sale-button' onclick="window.location.href='index.php?page=viewsale&sale_id={$sale['sale_id']}'">
                {$sale['street_address']}, {$sale['municipality']}
            </button>
            <br>
            Available:
            <div>{$sale['s_date']} - {$sale['e_date']}</div>
        </body>
    HTML;

    if (isset($_SESSION['user'])) {
            if($_SESSION['user'] == $sale['seller_id'])
                $page .= "<button class='btn btn-primary item-button' onclick=\"window.location.href='index.php?page=updateitem&item_id={$item['item_id']}'\">
                                Edit
                            </button>";
    }
    return [$message, $page];
}
