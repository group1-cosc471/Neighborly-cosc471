<?php
//Patrick Martus
//routes.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//sets default page to login
$path = "index.php?page=login";

//routing keeps everything under index
if(isset($_GET['page']))
{
    if($_GET['page'] === "login")
    {
        require_once 'login.php';
        $result = init();
    } elseif ($_GET['page'] === "listsales")
    {
        require_once 'listsales.php';
        $result = init();
    } elseif ($_GET['page'] === "viewsale") {
        require_once 'viewsale.php';
        $result = init($_GET['id']); //viewsale shouldn't be called without an id
    } elseif($_GET['page'] === "updatesale") {
        require_once 'updatesale.php';
        $result = init($_GET['id']);
    } elseif($_GET['page'] === "createsale") {
        require_once 'createsales.php';
        $result = init($_GET['id']);
    } else {
        header('location:' . $path); //if no page is set set the page to login
    }
} else 
{
    header('location:' . $path); //if the page variable isn't set at all set page to login
}