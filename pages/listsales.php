<?php
//Patrick Martus
//listsales.php

function init()
{
    $acknowlegement = '';
    require_once '../app/db/sale.php';

    $list = <<<HTML
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
         <h1>All Sales</h1>
    HTML;

    return [$acknowlegement, $list];
}

?>