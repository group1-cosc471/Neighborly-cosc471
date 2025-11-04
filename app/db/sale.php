//William Dalian
<?php
$sale_id
$seller_id
$sale_street_address
$sale_municipality

 
//get sales
function getAllSales(){
    $sales_list = []
    $query -> (
        'SELECT Sale_id, seller_id, Sale_street_address, Sale_municipality
        FROM SALE'
    ) ;

    while ($result -> $query.fetchRow()){
        sales_list[] = [$result];
    }

    return $sales_list;
}

//get sale by sale id
function getSale($id){
    $query -> (
        'SELECT *
        FROM SALE
        WHERE Sale_id = $id'
    ) ;

    return $result - >$query.fetchRow();
}

//get sales by seller_id
function getSalesBySeller($s_id){
    $sales_lst = []
    $query -> (
        'SELECT *
        FROM SALE
        WHERE Seller_id = $s_id'
    );

    while ($result -> $query.fetchRow()){
        sales_list[] = [$result];
    }

    return $sales_list;
}
?>