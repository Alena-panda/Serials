<?php
// https://localhost/Serials/
//include_once ('pages/createdb.php');
include_once ('pages/classes.php');
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Serial searcher!</title>
    <link rel="stylesheet" href="../Serials/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Serials/css/1.css">
</head>

<body id="bodystyle"> 
<div class="container">
        <div class="row">
            <div class="col-sm-2 col-md-2 col-lg-2">
                <?php
                include_once ('pages/navigation.php');
                ?>
            </header>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-8">
            <header class="col-12">
            <?php
            if (isset($_GET['page']))
            {
                if ($_GET['page']==1)
                {
                    include_once ('pages/home.php');
                }
                if ($_GET['page']==2)
                {
                    include_once ('pages/registration.php');
                }
                if ($_GET['page']==3)
                {
                    include_once ('pages/product.php');
                }
                if ($_GET['page']==4)
                {
                    include_once ('pages/entry.php');
                }
                if ($_GET['page']==5)
                {
                    include_once ('pages/cart.php');
                }
            }
            ?>
            </header>
        </div>
    </div>    
</body>
</html>