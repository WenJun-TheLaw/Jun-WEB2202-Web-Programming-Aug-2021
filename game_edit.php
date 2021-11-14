<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
//Check which session variables to expire
function expireSessionKeys()
{
    if (!is_null($_SESSION["expiries"])) {
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
    <link rel="stylesheet" href="css/game_edit.css">
    <title>E.GG</title>
</head>

<?php
//If user not logged in
if (!isset($_SESSION["userID"])) {
    $error = "You are not logged in! Please log in first.";
    echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='login.php';
            </script>";
}

//If user isn't "Developer" or "Admin"
$user = $db_handle->findUserByID($_SESSION["userID"]);
if (strcasecmp($user[0]["userType"], "Developer") != 0 && strcasecmp($user[0]["userType"], "Admin") != 0) {
    $error = "It seems like your account isn\'t a developer account.\\nSowwy you shouldn\'t be here :<";
    echo "<script type='text/javascript'>
                            alert('$error');
                            window.location.href='index.php';
                    </script>";
}

// Check that URL has id
if (!empty($_GET["id"])) {
    $game_id = $_GET["id"];

    $developerID = $_SESSION["userID"];
    $developerName = $user[0]["name"];
    //If id="new" then set default values
    if (strcasecmp($game_id, "new") == 0) {
        $name           = "";
        $image          = null;
        $price          = "0.00";
        $description    = null;
        $ageRating      = "";
        $min_req        = null;
        $rec_req        = null;
        //Developer ID here is from session variable
        $developerID = $_SESSION["userID"];
    }
    // Check if the gameID exists in the game table
    elseif (strcasecmp($game_id, $db_handle->findGame($game_id)[0]["gameID"]) == 0) {
        // Get the game's info
        $game_info = $db_handle->findGame($game_id);

        // User is developer
        // Check whether the game belongs to this developer
        if (strcasecmp($user[0]["userType"], "Developer") == 0) {
            $editable = $game_info[0]["developerID"] == $_SESSION["userID"];
            // The game does not belong to this developer
            if (!$editable) {
                $error = "It seems like this game isn\'t published by you.\\nSowwy you can\'t edit this :<";
                echo "<script type='text/javascript'>
                                    alert('$error');
                                    window.location.href='index.php';
                            </script>";
            }
        }

        // User is allowed to edit the game, display details
        $name        = $game_info[0]["name"];
        $image       = $game_info[0]["image"];
        $price       = $game_info[0]["price"];
        $description = $game_info[0]["description"];
        $ageRating   = $game_info[0]["ageRating"];
        $min_req     = $game_info[0]["min_requirements"];
        $rec_req     = $game_info[0]["rec_requirements"];
        //Developer ID here is from DB because in the case an admin edits the info,
        //The game still belogns to the developer and not the admin
        $developerID = $game_info[0]["developerID"];
    }
    // gameID does not exist in the game table
    else {
        $error = "Incorrect game ID!";
        echo "<script type='text/javascript'>
                    alert('$error');
                    window.location.href='index.php';
                    </script>";
    }
?>

    <body>
        <!-- Header -->
        <?php include("header.php"); ?>

        <!-- Game Body Div -->
        <form enctype="multipart/form-data" action="formhandler.php" method="POST" class="container-fluid">
            <!-- Game Title -->
            <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Enter game name" required class="game_name h1" onkeydown="return event.key != 'Enter';">

            <div class="d-flex game_content_flexbox">
                <!-- Left Div (30vw) -->
                <div class="d-flex text-center flex-column align-items-center game_left_content">
                    <!-- Game Image -->
                    <?php
                    if (!is_null($image)) {
                        echo <<<_END
                            <img src="$image" alt="An image of the game" class="game_img" id="game_img">
_END;
                    } else {
                        echo <<<_END
                            <div class="game_text_medium game_image text-center">No image available</div>
_END;
                    }
                    ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                    <input type="file" name="image_file" <?php if (empty($image)) {
                                                                echo "required";
                                                            } ?> >
                    <input type="hidden" name="image" value="<?php if (!empty($image)) {
                                                                    echo $image;
                                                                } ?>">


                    <!-- Game Price -->
                    <div class="d-inline-flex justify-content-center mt-4">
                        <div class="game_text_large">RM&nbsp;</div>
                        <input type="number" name="price" value="<?php echo number_format($price, 2); ?>" required class="game_text_large game_price" step="0.01" min="0" pattern="[0-9]+(\.[0-9][0-9]?)?" onkeydown="return event.key != 'Enter';">
                    </div>
                </div>

                <!-- Right Div (70vw) -->
                <div class="d-flex flex-column game_right_content">
                    <!-- Game Description -->
                    <textarea name="description" class="game_text_small game_text_area" required placeholder="Give your game a description"><?php if (!is_null($description)) echo $description; ?></textarea>
                    <!-- First row (Developer & Age Rating) -->
                    <div class="row mt-4">
                        <!-- Developer -->
                        <div class="col">
                            <div class="d-flex flex-column">
                                <div class="game_text_medium">Developer&colon;&nbsp;</div>
                                <input type="text" name="developerName" readonly value="<?php echo $developerName; ?>" required class="game_text_medium game_developer" onkeydown="return event.key != 'Enter';">
                                <input type="hidden" name="developerID" value="<?php echo $developerID; ?>">
                            </div>
                        </div>
                        <!-- Game Age Rating -->
                        <div class="col">
                            <div class="d-flex flex-column">
                                <div class="game_text_medium">Age Rating&colon;&nbsp;</div>
                                <input type="text" name="ageRating" value="<?php echo $ageRating; ?>" placeholder="Check https://pegi.info/" required class="game_text_medium game_rating" onkeydown="return event.key != 'Enter';">
                            </div>
                        </div>
                    </div>
                    <!-- Second row (Min & Recommended Requirements) -->
                    <div class="row">
                        <!-- Game Min Requirements -->
                        <div class="col-md mt-4">
                            <div class="d-flex flex-column">
                                <div class="game_text_medium">Minimum Requirements&colon;&nbsp;</div>
                                <textarea name="min_req" class="game_text_area" required placeholder="Minimum system requirements to run the game"><?php if (!is_null($min_req)) echo $min_req; ?></textarea>
                            </div>
                        </div>
                        <!-- Game Recommended Requirements -->
                        <div class="col-md mt-4">
                            <div class="d-flex flex-column">
                                <div class="game_text_medium">Recommended Requirements&colon;&nbsp;</div>
                                <textarea name="rec_req" class="game_text_area" required placeholder="Recommended system requirements to run the game"><?php if (!is_null($rec_req)) echo $rec_req; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex bottom_div">
                <!-- Discard Changes Button -->
                <button type="submit" class="btn btn-danger buttons game_edit_red_button ms-2" onclick="if (confirm('Are you sure you want to discard these changes?')){ window.location.href='index.php';}">
                    Discard changes
                </button>
                <!-- Save Changes Button -->
                <input type="hidden" name="source" value="edit">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="gameID" value="<?php echo $game_id ?>">
                <button type="submit" class="btn btn-success buttons game_edit_green_button ms-2" onkeydown="return event.key != 'Enter';">
                    Save changes
                </button>

            </div>
        </form>






    <?php
} else {
    $error = "Game ID not found! Check the URL.";
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