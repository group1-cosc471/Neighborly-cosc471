<?php
//Darius Robinson

require_once __DIR__ . '/database.php';

//get the items
function getAllItems(){
    global $conn;
    $items_list = [];
    $query = $conn->prepare('SELECT * FROM item');
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()){
        $items_list[] = $row;
    }
    return $items_list;
}
//get an item by id
//
function getItem($id){
    global $conn;
    $item = [];
    $query = $conn->prepare('SELECT * FROM item WHERE item_id = ?');
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $item = $result->fetch_assoc();
    return $item;
}
//get items by sale id
function getItemsBySale($sale_id){
    global $conn;
    $items_list = [];
    $query = $conn->prepare('SELECT * FROM item WHERE sale_id = ?');
    $query->bind_param("i", $sale_id);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()){
        $items_list[] = $row;
    }
    return $items_list;
}
//get items by user id
function getItemsByUser($user_id){
    global $conn;
    $items_list = [];
    $query = $conn->prepare('SELECT * FROM item WHERE reserved_by = ?');
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()){
        $items_list[] = $row;
    }
    return $items_list;
}

//return the number of items in a sale based on sale id
function itemsInSale($saleID) {
    global $conn;
    $query = $conn->prepare('SELECT count(*) as num_items FROM item WHERE sale_id = ?');
    $query->bind_param("i", $saleID);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    return $row['num_items'];
}

//update an item based on it's id
function updateItem($id, $name, $description, $price){
    global $conn;

    //prepare statement
    $stmt = $conn -> prepare('UPDATE item SET item_name = ?, item_dec = ?, price = ? WHERE item_id = ?');
    $stmt -> bind_param("ssii", $name, $description, $price, $id);

    //return result
    if($stmt -> execute()){
        return 1;
    }
    else {
        return 0;
    }
}

//create a new item, if successful return the id
function createItem($sale_id, $name, $description, $price) {
    if (isset($_SESSION['user'])) {
        $u_id = $_SESSION['user'];

        global $conn;
        $stmt = $conn ->prepare(
            'INSERT INTO item (sale_id, item_name, item_dec, price)
            VALUES (?, ?, ?, ?)');

        $stmt -> bind_param("issi", $sale_id, $name, $description, $price);

        if ($stmt -> execute()){
            $item_id = $conn->insert_id;
            return $item_id;
        }
        else{
            return 0;
        }
    }
    else{
        return -1;
    }
}
?>

