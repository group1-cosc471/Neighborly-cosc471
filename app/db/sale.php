<?php
//William Dalian

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
        'SELECT sale_id, seller_id, street_address, municipality
        FROM sale';
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
        FROM sale
        WHERE sale_id = $id' //not sure if this syntax will work for prepared statements
    );
    $query ->bind_param("i", $id)
    $result = $conn->query($query);

    return $result->fetch_assoc();
}

//get sales by seller_id
function getSalesBySeller($s_id){
    //syntax for prepared statements is correct in this function. apply to other functions
    global $conn;
    $sales_list = [];
    //table name is case sensitive
    $query = $conn->prepare('SELECT *
        FROM sale
        WHERE seller_id = ?');
    $query->bind_param("i", $s_id); //this is how to add variables to prepared statements
    $query->execute();

    $result = $query->get_result();
    

    while ($row =  $result->fetch_assoc()){
        $sales_list[] = $row;
    }

    return $sales_list;
}
?>