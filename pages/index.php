<?php
//index.php

require_once('routes.php');

?>

<html>
    <head>
        <title>neighborly</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/assets/css/neighborly.css">
        <link rel="stylesheet" href="../public/styles/main.css">
    </head>
<body class="container">
   <header class="site-header">
    <img src="../images/logo1.png" alt="Neighborly Logo" class="logo" style="height:60px !important; width:auto !important;"">
        <h1>Neighborly</h1>
        <nav>
            <a class="btn btn-secondary" href="index.php?page=login">Login</a> |
            <a class="btn btn-secondary" href="index.php?page=listsales">List Sales</a> |
            <a class="btn btn-secondary" href="index.php?page=createsale">Create Sale</a>
        </nav>
        <hr>
    </header>
    <?php
    echo ($result[1]);
    ?>

    <!-- FOOTER -->
    <footer>
        <hr>
        <p>&copy; 2025 Neighborly</p>
    </footer>
</body>
</html>