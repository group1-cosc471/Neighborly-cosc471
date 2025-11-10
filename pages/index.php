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
} else{
   $result = ["Home", "
    <!doctype html>
    <html lang='en'>
    <head>
        <meta charset='utf-8'>
        <title>Neighborly — Home</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                margin:0; 
                background:#0e1116; 
                color:#e6edf3; 
                text-align:center; 
            }
            header { 
                padding:16px; 
                background:#97B357; 
                border-bottom:1px solid #9ec1ff; 
                font-weight:bold; 
            }
            main { 
                padding:40px 20px; 
                max-width:700px; 
                margin:auto; 
            }
            a.btn { 
                display:inline-block; 
                margin:10px; 
                padding:12px 20px; 
                background:#1c2230; 
                border:1px solid #2a3240; 
                border-radius:8px; 
                color:#9ec1ff; 
                text-decoration:none; 
            }
            a.btn:hover { 
                background: #7389AE; 
            }
            p { 
                color:#babad0; 
            }
        </style>
    </head>
    <body>
        <header>Neighborly</header>
        <main>
            <h1>Welcome to Neighborly</h1>
            <p>An app to help people organize, find, and participate in local garage sales.</p>
            <div>
                <a href='index.php?page=login' class='btn'>Login</a>
                <a href='index.php?page=sales' class='btn'>View Sales</a>
            </div>
            
        </main>
    </body>
    </html>
    "];
}


echo($result[1]);

?>