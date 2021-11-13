<?php
if (session_status() != PHP_SESSION_ACTIVE){session_start();}
//Check which session variables to expire
function expireSessionKeys()
{
    if(!is_null($_SESSION["expiries"])){
        foreach ($_SESSION["expiries"] as $key => $value) {
            if (time() > $value) {
                unset($_SESSION[$key]);
            }
        }
    }
}
expireSessionKeys();
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

<?
    //Redirect "Developers" to dev_index.php
    if (isset($_SESSION["userID"])) {
        $user = $db_handle->findUserByID($_SESSION["userID"]);
        if(strcasecmp($user[0]["userType"], "Developer") == 0){
            header("Location: dev_index.php");
            die();
        }
    }
?>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <?php
    // Get all games from the game table
    $games_info = $db_handle->getAllGames();
    $counter = 0;
    ?>

    <div class="container-fluid">
        <!-- New Releases Title -->
        <div class="row mt-4">
            <div class="col">
                <div class="text-center title fw-bold">New Releases</div>
            </div>
        </div>
        <!-- New Releases Game Row -->
        <div class="row mt-4 d-flex justify-content-center">
            <?php
            for ($counter = 1; $counter < 5; $counter++) {
                $img = $games_info[$counter]["image"];
                $name = $games_info[$counter]["name"];
                $id = $counter + 1;
                print('
                    <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                        <a href="game.php?id=' . $id . '">
                            <img src="' . $img . '" alt="image of a game" class="game_img">
                            <div class="game_name">' . $name . '</div>
                        </a>
                    </div>
                    ');
                $total_games_displayed++;
            }
            ?>
        </div>
        <!-- Top Sellers Title-->
        <div class="row mt-4">
            <div class="col">
                <div class="text-center title fw-bold">Top Sellers</div>
            </div>
        </div>
        <!-- Top Sellers Game Row -->
        <div class="row mt-4 d-flex justify-content-center">
            <?php
                for ($counter = 5; $counter < 9; $counter++) {
                    $img = $games_info[$counter]["image"];
                    $name = $games_info[$counter]["name"];
                    $id = $counter + 1;
                    print('
                        <div class="col-md d-flex justify-content-center text-center align-items-center flex-column game_card">
                            <a href="game.php?id=' . $id . '">
                                <img src="' . $img . '" alt="image of a game" class="game_img">
                                <div class="game_name">' . $name . '</div>
                            </a>
                        </div>
                        ');
                    $total_games_displayed++;
                }
            ?>
        </div>
    </div>


    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>