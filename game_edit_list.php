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
    <link rel="stylesheet" href="css//game_edit_list.css">
    <title>E.GG</title>
</head>

<body>
    <?php
    //If user not logged in
    if (!isset($_SESSION["userID"])) {
        $error = "You are not logged in! Please log in first.";
        echo "<script type='text/javascript'>
                            alert('$error');
                            window.location.href='login.php';
                            </script>";
    }
    //User isn't "Developer" or "Admin"
    $user = $db_handle->findUserByID($_SESSION["userID"]); 
    if (strcasecmp($user[0]["userType"], "Gamer") == 0) {
        $error = "It seems like your account isn\'t a developer account.\\nSowwy you shouldn\'t be here :<";
        echo "<script type='text/javascript'>
                window.alert('$error');
                window.location.href='index.php';
            </script>";
    }
    //Developer
    elseif (strcasecmp($user[0]["userType"], "Developer") == 0){
        $list = $db_handle->getDeveloperGames($_SESSION["userID"]);
    }
    //Admin
    elseif (strcasecmp($user[0]["userType"], "Admin") == 0){
        $list = $db_handle->getAllGames();
    }

    //Display the game list
    ?>

    <!-- Header -->
    <?php include("header.php"); ?>
    <div class="h1 title text-center">Games published by&nbsp;<?php echo $user[0]["name"]; ?></div>


    <div class="container-fluid library_body">
        <div class="d-flex flex-column">
            <!-- Display library items -->
            <?php
            //If not empty
            if (!is_null($list)) {
                foreach ($list as $key => $value) {
                    $img    = $list[$key]["image"];
                    $name   = $list[$key]["name"];
                    $id     = $list[$key]["gameID"];
                    echo <<<_END
                    
                    <!-- Each idividual Game -->
                    <div class="d-flex library_item p-4">
                        <!-- Image -->
                        <img src="$img" class="library_image" alt="Image of library item">

                        <!-- Name -->
                        <div class="library_item_mid_col d-flex flex-column align-items-center ms-4">
                            <div class="library_text_medium" id=library_name>$name</div>
                        </div>
                        <!-- Edit Button -->
                        <div class="library_item_right_col d-flex flex-column justify-content-center ms-auto">
                            <button type="submit" class="library_invi_button d-inline-flex align-items-center" id="edit_button" onclick="window.location.href='game_edit.php?id=$id';">
                                <i class="bi bi-pencil-square library_links"></i>
                                <div class="library_text_medium library_links ms-2">Edit</div>
                            </button>
                        </div>
                    </div>
                
_END;
                }
            } else {
                echo <<<_END
                <div class="h2 title text-center">You have not published any games yet!</div>
_END;
            } ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>