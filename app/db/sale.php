<?php
//William Dalian
//sale.php: Uses the stablished database.php connection. Provides functionality to
//get all sales, sale by sale id, sale by seller id, as well as posting
//a new sale by sell_id, and updating an existing sale by sale_id.


//use this to get the database connection
require_once __DIR__ . '/database.php';

$sale_id;
$seller_id;
$sale_street_address;
$sale_municipality;

 
//get all sales: prepares a select all statement, and the quereies 
// the database and retuns a list of all sales.
function getAllSales(){
    global $conn;
    $sales_list = [];

    $query = 
        'SELECT *
        FROM sale';
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $sales_list[] = $row;
    }

    return $sales_list;
}

//get sale by sale id. Prepares a statment and Queries the database for a sale with a given sale id,
//returns the sale if a matching sale is found
function getSale($id)
{
    global $conn;
    $query =  $conn->prepare(
        'SELECT *
        FROM sale
        WHERE sale_id = ? '
    );
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    return $result->fetch_assoc();
}

//get sales by seller_id. Prepares a statement and Queries the database for a sale associated with a given user id
//returns them all as a list
function getSalesBySeller($s_id)
{
    global $conn;
    $sales_list = [];

    $query = $conn->prepare('SELECT *
        FROM sale
        WHERE seller_id = ?');
    $query->bind_param("i", $s_id); 
    $query->execute();

    $result = $query->get_result();


    while ($row =  $result->fetch_assoc()) {
        $sales_list[] = $row;
    }

    return $sales_list;
}

//inserts a sale into the database. Retrieves user id, and prepares and executes and insertion statement
//to add a sale to the database.
//returns the newly created sale's id to inditcate a success, -2 if the user is not logged in, or is not the user associated
//with the sale, or -1 if there is another fault.
function postSale($streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type){
    if (isset($_SESSION['user'])) {
        $u_id = $_SESSION['user'];

        global $conn;
        $stmt = $conn ->prepare(
            'INSERT INTO sale (seller_id, street_address, municipality, s_date, e_date, open_time, close_time, sale_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $stmt -> bind_param("isssssss", $u_id, $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type);

        if ($stmt -> execute()){
            $created_id = mysqli_insert_id($conn);
            return $created_id;
        }
        else{
            return -1;
        }
    }
    else{
        return -2;
    }
}

//backend function to update a sale with a given sale_id. Prepares an sql statement to update a sale with a given id
//returns 0 if the update is successful, otherwise returns 1 to indicate a fault
function updateSale($sale_id, $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type){
    global $conn;

    $stmt = $conn -> prepare('UPDATE sale
                                    SET street_address = ?,
                                    municipality = ?,
                                    s_date = ?,
                                    e_date = ?,
                                    open_time = ?,
                                    close_time = ?,
                                    sale_type = ?
                                    WHERE sale_id = ?');
    $stmt -> bind_param("sssssssi", $streetAddress, $municipality, $s_date, $e_date, $open_time, $close_time, $sale_type, $sale_id);


    if($stmt -> execute()){
        return 0;
    }
    else {
        return 1;
    }
}
?>
