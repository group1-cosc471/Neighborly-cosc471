<?php
//William Dalian
//sale.php: Uses the stablished database.php connection. Provides functionality to
//get all sales, sale by sale id, sale by seller id, as well as posting
//a new sale, and updating an existsing sale.


//use this to get the database connection
require_once __DIR__ . '/database.php';

$sale_id;
$seller_id;
$sale_street_address;
$sale_municipality;

 
//get all sales
function getAllSales(){
    //I guess this is required for use inside php functions, my last project just used individual files so my bad
    global $conn;
    $sales_list = [];

    //syntax for defining query requires the connecttion to the database
    $query = 
        'SELECT *
        FROM sale';
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) { //use to get row from result
        //append to an array like this othe
        $sales_list[] = $row; //append row to list
    }

    return $sales_list;
}

//get sale by sale id
function getSale($id)
{
    global $conn;
    $query =  $conn->prepare(
        'SELECT *
        FROM sale
        WHERE sale_id = ? '
    );
    $query->bind_param("i", $id);
    $result = $query->get_result();

    return $result->fetch_assoc();
}

//get sales by seller_id
function getSalesBySeller($s_id)
{
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


    while ($row =  $result->fetch_assoc()) {
        $sales_list[] = $row;
    }

    return $sales_list;
}

//inserts a sale into the database. Retrieves user id, and prepeares and executes and insertion statement
//to add a sale to the database.
//returns 0 to inditcate a success, 2 if the user is not logged in, or is not the user associated
//with the sale, or 1 if there is another fault.
function postSale($streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type){
    if (isset($_SESSION['user'])) {
        $u_id = $_SESSION['user'];

        global $conn;
        $stmt = $conn ->prepare(
            'INSERT INTO sale (seller_id, street_address, municipality, s_date, e_date, open_time, close_time, sale_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $stmt -> bind_param("isssssss", $u_id, $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type);


        if ($stmt -> execute()){
            return 0;
        }
        else{
            return 1;
        }
    }
    else{
        return 2;
    }
}

//backend function to update a sale with a given sale_id.
//returns 0 if the update is successful, otherwise returns 1 to indicate a fault
function updateSale($sale_id, $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type){
    global $conn;

    $stmt = $conn -> prepare('UPDATE sale SET street_address = ?, municipality = ?, s_date = ?, e_date = ?, open_time = ?, close_time = ? sale_type = ?
                                WHERE sale_id = ?');
    $stmt -> bind_param("ssssssi", $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_id);


    if($stmt -> execute()){
        return 0;
    }

    else {
        return 1;
    }
}
?>
