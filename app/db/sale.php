//William Dalian
<?php
//use this to get the database connection
require_once 'database.php';

$sale_id;
$seller_id;
$sale_street_address;
$sale_municipality;

 
//get sales
function getAllSales(){
    //I guess this is required for use inside php functions, my last project just used individual files so my bad
    global $conn;
    $sales_list = [];

    //syntax for defining query requires the connecttion to the database
    $query = 
        'SELECT Sale_id, seller_id, Sale_street_address, Sale_municipality
        FROM SALE';
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()){ //use to get row from result
        //append to an array like this othe
        $sales_list[] = $row; //append row to list
    }

    return $sales_list;
}

//get sale by sale id
function getSale($id){
    global $conn;
    $query =  $conn->prepare(
        'SELECT *
        FROM SALE
        WHERE Sale_id = $id' //not sure if this syntax will work for prepared statements
    );
    $result = $conn->query($query);

    return $result->fetch_assoc();
}

//get sales by seller_id
function getSalesBySeller($s_id){
    global $conn;
    $sales_list = [];
    $query = 'SELECT *
        FROM SALE
        WHERE Seller_id = $s_id';
    $result = $conn->query($query);
    

    while ($row =  $result->fetch_assoc()){
        $sales_list[] = $row;
    }

    return $sales_list;
}
?>