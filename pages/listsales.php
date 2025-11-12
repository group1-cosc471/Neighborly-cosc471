<?php
//Patrick Martus
//listsales.php



function init()
{
    $acknowlegement = '';
    require_once '../app/db/sale.php';
    require_once '../app/db/user.php';
    require_once '../app/db/items.php';

    $sales = getAllSales();

    //start the list with the titles
    $list = <<<HTML
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
         <h1>All Sales</h1>
         <table class="table">
            <tr>
                <th>Location</th>
                <th>Host</th>
                <th>Number of items</th>
            </tr>
    HTML;

    //append each sale from the database into the table
    foreach ($sales as $sale) {
        $host = getFirstAndLastName($sale['seller_id']);
        $numItems = itemsInSale($sale['sale_id']);
        $list .= "<tr>
                    <td>
                        <button class='btn btn-primary sale-button' onclick=\"window.location.href='index.php?page=viewsale&id={$sale['sale_id']}'\">
                        {$sale['street_address']}, {$sale['municipality']}
                        </button>
                    </td>
                    <td>{$host['f_name']}, {$host['l_name']}</td>
                    <td>{$numItems}</td>
                </tr>"; //todo add seller and number of items, make sale location a link to the sale page
    }

    $list .= "</table>";

    return [$acknowlegement, $list];
}
