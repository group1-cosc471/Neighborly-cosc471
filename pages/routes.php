<?php
//Patrick Martus
//routes.php

//required within the index file, the routes file manages the user's ability to see pages
//if no user is logged in, the default page will be set to login and the user will be redirected there
//otherwise the correct page will return its init function and the index will echo that page.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//todo fix so that user cannot access pages unless logged in

//sets default page to login
$path = "index.php?page=login";

//routing keeps everything under index
if(isset($_GET['page']))
{
    if($_GET['page'] === "login") {
        require_once 'login.php';
        $result = init();
    } elseif($_GET['page'] === "createitem") {
        require_once 'createitem.php';
        $result = init($_GET['sale_id']); //todo change pages to use more specific id's
    } elseif($_GET['page'] === "createsale") {
        require_once 'createsales.php';
        $result = init($_GET['user_id']);
    } elseif($_GET['page'] === "createuser") {
        require_once 'createuser.php';
        $result = init();
    } elseif ($_GET['page'] === "listsales") {
        require_once 'listsales.php';
        $result = init();
    } elseif($_GET['page'] === "updateitem") {
        require_once 'updateitem.php';
        $result = init($_GET['item_id']);
    } elseif($_GET['page'] === "updatesale") {
        require_once 'updatesale.php';
        $result = init($_GET['sale_id']);
    } elseif ($_GET['page'] === "updateuser") {
        require_once 'updateuser.php';
        $result = init($_GET['user_id']); //viewsale shouldn't be called without an id
    } elseif ($_GET['page'] === "viewitem") {
        require_once 'viewitem.php';
        $result = init($_GET['item_id']); //viewsale shouldn't be called without an id
    } elseif ($_GET['page'] === "viewsale") {
        require_once 'viewsale.php';
        $result = init($_GET['sale_id']); //viewsale shouldn't be called without an id
    } else {
        header('location:' . $path); //if no page is set set the page to login
    }
} else {
    header('location:' . $path); //if the page variable isn't set at all set page to login
}