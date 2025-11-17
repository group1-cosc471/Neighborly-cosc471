<?php
//index.php

require_once('routes.php');

?>

<html>
    <head>
        <title>neighborly</title>
        <link rel="stylesheet" href="../public/assets/css/neighborly.css">
        <link rel="stylesheet" href="../public/styles/main.css">
    </head>
<body class="container">
   <header class="site-header">
    <img src="../images/logo1.png" alt="Neighborly Logo" class="logo" style="height:60px !important; width:auto !important;"">
        <h1>Neighborly</h1>
        <nav>
            <a href="index.php?page=login">Login</a> |
            <a href="index.php?page=listsales">List Sales</a> |
            <a href="index.php?page=createsale">Create Sale</a>
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