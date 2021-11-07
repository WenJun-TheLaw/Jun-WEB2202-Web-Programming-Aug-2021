<?php
session_start();
require_once("shoppingCart.php");
$db_handle = new ShoppingCart();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/universal.css">
    <link rel="stylesheet" href="css/index.css">
    <title>E.GG</title>
</head>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <div class="container-fluid">
        <!-- New Releases Title -->
        <div class="row mt-4">
            <div class="col">
                <div class="text-center title fw-bold">New Releases</div>
            </div>
        </div>
        <!-- New Releases Game Row -->
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=1">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">LOREM</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=2">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">IPSUM</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=3">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">DOLOR</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=4">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">SIT EMET</div>
                </a>
            </div>
        </div>
        <!-- Top Sellers Title-->
        <div class="row mt-4">
            <div class="col">
                <div class="text-center title fw-bold">Top Sellers</div>
            </div>
        </div>
        <!-- Top Sellers Game Row -->
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=5">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">LOREM 5</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=6">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">IPSUM 6</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=7">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">DOLOR 7</div>
                </a>
            </div>
            <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                <a href="game.php?id=8">
                    <img src="https://via.placeholder.com/400" alt="image of a game" class="game_img">
                    <div class="game_name">SIT EMET 8</div>
                </a>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>