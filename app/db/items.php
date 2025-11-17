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
    $items = 5;
    return $items;
}

function getItem($item_id) {
    $item = [];
    return $item;
}

function updateItem($id, $name, $description, $price){
    return 0;
}

function createItem($sale_id, $name, $description, $price) {
    //return the new item's id
    return 1;
}
?>

