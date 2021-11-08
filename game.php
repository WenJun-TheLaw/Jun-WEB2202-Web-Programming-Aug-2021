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
    <link rel="stylesheet" href="css/game.css">
    <title>E.GG</title>
</head>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <?php 
        if(!empty($_GET["id"])){
            $game_id = $_GET["id"];
        }
        else{
            $error = "Game ID not found!";
            echo "<script type='text/javascript'>
            alert('$error');
            window.location.href='index.php';
            </script>";
        }
    ?>
    <!-- Game Title -->
    <div class="game_name h1" id=game_name>If you see this, the page failed to load... :c</div>

    <!-- Game Body Div -->
    <div class="d-flex game_content_flexbox">
        <!-- Left Div (30vw) -->
        <div class="d-flex text-center flex-column game_left_content">
            <!-- Game Image -->
            <img src="https://via.placeholder.com/400" alt="Picture of the game" class="game_img" id="game_img">
            <div class="textbox mt-4">
                <!-- Game Price -->
                <div class="d-inline-flex">
                    <div class="game_text_large">RM&nbsp;</div>
                    <div class="game_text_large" id=game_price>00.00</div>
                </div>
            </div>

        </div>
        <!-- Right Div (70vw) -->
        <div class="d-flex flex-column game_right_content">
            <!-- Game Description -->
            <div class="game_text_small" id="game_description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt vel facilis, assumenda quibusdam accusantium quos pariatur quaerat, obcaecati porro repellendus repudiandae aut. Sapiente officiis omnis at. Maiores aspernatur tenetur ducimus.
            </div>
            <div class="game_bottom_right">
                <!-- First row (Developer & Age Rating) -->
                <div class="row  mt-4">
                    <!-- Game Description -->
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="game_text_medium">Developer&colon;&nbsp;</div>
                            <div class="game_text_medium" id=game_developer>Test Developer</div>
                        </div>
                    </div>
                    <!-- Game Age Rating -->
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="game_text_medium">Age Rating&colon;&nbsp;</div>
                            <div class="game_text_medium" id=game_age_rating>PEGI 3</div>
                        </div>
                    </div>
                </div>
                <!-- Second row (Min & Recommended Requirements) -->
                <div class="row  mt-4">
                    <!-- Game Min Requirements -->
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="game_text_medium">Minimum Requirements&colon;&nbsp;</div>
                            <div class="game_text_medium" id=game_developer>Test Minimum Requirements</div>
                        </div>
                    </div>
                    <!-- Game Recommended Requirements -->
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="game_text_medium">Recommended Requirements&colon;&nbsp;</div>
                            <div class="game_text_medium" id=game_age_rating>Test Recommended Requirements</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>