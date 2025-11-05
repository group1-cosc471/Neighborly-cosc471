<?php
//* Final Homework - Routing
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
    } elseif ($_GET['page'] === "sales")
    {
        //option for if sales page was used
    } else {
        header('location:' . $path); //if no page is set set the page to login
    }
} else 
{
    header('location:' . $path); //if the page variable isn't set at all set page to login
}

echo($result[1]);

?>