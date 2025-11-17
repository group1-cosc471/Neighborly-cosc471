<?php
//Patrick Martus
//listsales.php

//gets all the sales from the databse via sale.php
//presents the sales in a table and allows users to select the sale they wish to view taking them to the viewsale page
//if the logged in user is the seller of that sale, also presents an edit button which will take the user to the updatesale page
//additionally the new sale button found here will take the user to the createsale page

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
        
        $host = getUserFullName($sale['seller_id']);
        $numItems = itemsInSale($sale['sale_id']);
        $list .= "<tr>
                    <td>
                        <button class='btn btn-primary sale-button' onclick=\"window.location.href='index.php?page=viewsale&id={$sale['sale_id']}'\">
                        {$sale['street_address']}, {$sale['municipality']}
                        </button>
                    </td>
                    <td>{$host['f_name']}, {$host['l_name']}</td>
                    <td>{$numItems}</td>";
        if (isset($_SESSION['user'])) {
            if($_SESSION['user'] == $sale['seller_id'])
                $list .= "<td>
                            <button class='btn btn-primary sale-button' onclick=\"window.location.href='index.php?page=updatesale&id={$sale['sale_id']}'\">
                                Edit
                            </button>
                         </td>";
        }

        $list .= "</tr>";
    }

    $list .= "</table>
        <button class='btn btn-primary new-sale-button' onclick=\"window.location.href='index.php?page=createsale&user_id={$_SESSION['user']}'\">New Sale</button>";

    return [$acknowlegement, $list];
}
