<?php
if (!isset($_SESSION)) session_start();
//Check which session variables to expire
function expireSessionKeys()
{
    foreach ($_SESSION["expiries"] as $key => $value) {
        if (time() > $value) {
            unset($_SESSION[$key]);
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
    <link rel="stylesheet" href="css/game.css">
    <title>E.GG</title>
</head>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <?php
    // Check that URL has id
    if (!empty($_GET["id"])) {
        $game_id = (int)$_GET["id"];

        // Check if the id exists in the game table
        $game_info = $db_handle->findGame($game_id);
        if ($game_id == $game_info[0]["gameID"]) {

    ?>
            <!-- Game Title -->
            <div class="game_name h1" id=game_name><?php echo $game_info[0]["name"]; ?></div>

            <!-- Game Body Div -->
            <div class="d-flex game_content_flexbox">
                <!-- Left Div (30vw) -->
                <div class="d-flex text-center flex-column game_left_content">
                    <!-- Game Image -->
                    <img src=<?php echo $game_info[0]["image"]; ?> alt="An image of the game" class="game_img" id="game_img">
                    <div class="textbox mt-4">
                        <!-- Game Price -->
                        <div class="d-inline-flex">
                            <div class="game_text_large">RM&nbsp;</div>
                            <div class="game_text_large" id=game_price><?php echo number_format($game_info[0]["price"], 2); ?></div>
                        </div>
                    </div>

                </div>
                <!-- Right Div (70vw) -->
                <div class="d-flex flex-column game_right_content">
                    <!-- Game Description -->
                    <div class="game_text_small" id="game_description"> <?php echo $game_info[0]["description"]; ?> </div>
                    <div class="game_bottom_right">
                        <!-- First row (Developer & Age Rating) -->
                        <div class="row  mt-4">
                            <!-- Game Description -->
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="game_text_medium">Developer&colon;&nbsp;</div>
                                    <div class="game_text_medium" id=game_developer>
                                        <?php
                                        $developerID = $game_info[0]["developerID"];
                                        $developer_info = $db_handle->findUserByID($developerID);
                                        echo $developer_info[0]["name"];
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Game Age Rating -->
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="game_text_medium">Age Rating&colon;&nbsp;</div>
                                    <div class="game_text_medium" id=game_age_rating><?php echo $game_info[0]["ageRating"]; ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Second row (Min & Recommended Requirements) -->
                        <div class="row">
                            <!-- Game Min Requirements -->
                            <div class="col-md mt-4">
                                <div class="d-flex flex-column">
                                    <div class="game_text_medium">Minimum Requirements&colon;&nbsp;</div>
                                    <div id="game_min_req"><?php echo $game_info[0]["min_requirements"]; ?></div>
                                </div>
                            </div>
                            <!-- Game Recommended Requirements -->
                            <div class="col-md mt-4">
                                <div class="d-flex flex-column">
                                    <div class="game_text_medium">Recommended Requirements&colon;&nbsp;</div>
                                    <div id="game_rec_req"><?php echo $game_info[0]["rec_requirements"]; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <?php
        } else {
            $error = "Game ID not found!";
            echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='index.php';
                </script>";
        }
    } else {
        $error = "Game ID not found!";
        echo "<script type='text/javascript'>
            alert('$error');
            window.location.href='index.php';
            </script>";
    } ?>

    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>