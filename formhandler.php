<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E.GG</title>
</head>

<body>
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

    //If user not logged in, redirect them
    if (!isset($_SESSION["userID"])) {
        $error = "You are not logged in! Please log in first.";
        echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='login.php';
                </script>";
    }

    //Checking for source
    if (!empty($_POST["source"])) {
        switch ($_POST["source"]) {
            //Cart form handling
            case "cart":
                if (!empty($_POST["action"])) {
                    switch ($_POST["action"]) {
                        //Delete item from cart
                        case "delete":
                            if (!empty($_POST["gameID"])) {
                                $deleteSuccess = $db_handle->deleteCartItem($_SESSION["userID"], $_POST["gameID"]);
                                $msg = $deleteSuccess ? "Game removed." : "Operation unsuccessful.";
                                echo "<script type='application/javascript'>
                                    alert('$msg');
                                    window.location.href='cart.php';
                                </script>";
                            }
                            break;
                        //Empty the cart
                        case "empty":
                            $emptySuccess = $db_handle->emptyCart($_SESSION["userID"]);
                            $msg = $emptySuccess ? "Cart emptied." : "User has nothing in cart to remove :/";
                            echo "<script type='application/javascript'>
                                    window.alert('$msg');
                                    window.location.href='cart.php';
                                </script>";
                            break;
                        //Checkout the cart
                        case "checkout":                            
                            $checkoutSuccess = $db_handle->checkOut($_SESSION["userID"]);
                            echo "Just pretend you paid :P";
                            if($checkoutSuccess){
                                //Redirect user
                                $msg = "Checkout completed, enjoy!";
                                echo "<script type='application/javascript'>
                                    window.alert('$msg');
                                    window.location.href='library.php';
                                </script>";
                            }
                            else{
                                $msg = "Oops, operation failed :/";
                                echo "<script type='application/javascript'>
                                    window.alert('$msg');
                                    window.location.href='cart.php';
                                </script>";
                            }
                            sleep(5); //wait 5 seconds
                            
                        break;

                        unset($_POST["action"]);
                        unset($_POST["gameID"]);
                        header("Refresh:0");
                    }
                }
                break;
            //Game form handling
            case "game":
                if (!empty($_POST["action"])) {
                    switch ($_POST["action"]) {
                        //Add item to cart
                        case "add":
                            if (!empty($_POST["gameID"])) {
                                //User doesn't already own the game
                                if(is_null($db_handle->findGameinLibrary($_SESSION["userID"], $_POST["gameID"]))){
                                    //Game is not already in cart
                                    if(is_null($db_handle->findGameinCart($_SESSION["userID"], $_POST["gameID"]))){
                                        //User is a "Gamer"
                                        $user = $db_handle->findUserByID($_SESSION["userID"]);
                                        if(strcasecmp($user[0]["userType"], "Gamer") == 0){
                                            $addSuccess = $db_handle->addToCart($_SESSION["userID"], $_POST["gameID"]);
                                            $msg = $addSuccess ? "Game added." : "Operation unsuccessful :<\\nPlease note \"Developers and Admins cannot add games to cart!\"";
                                            echo "<script type='application/javascript'> 
                                            window.alert('$msg');
                                                window.location.href='cart.php';
                                            </script>";
                                        }
                                        else{
                                            $msg = "Operation unsuccessful :<\\nPlease note \"Developers and Admins cannot add games to cart!\"";
                                            echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                                window.location.href='index.php';
                                            </script>";
                                        }                                        
                                    }
                                    else{
                                        $msg = "Operation unsuccessful :<\\nIt seems like the game is already in your cart!";
                                            echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                            window.location.href='index.php';
                                        </script>";
                                    }
                                }
                                else{
                                    $msg = "Operation unsuccessful :<\\nIt seems like you already own this game!";
                                    echo "<script type='application/javascript'>
                                        window.alert('$msg');
                                        window.location.href='index.php';
                                    </script>";
                                }
                            }
                        break;
                    }
                }
            break;
            //Game Edit form handling
            case "edit":
                if (!empty($_POST["action"])) {
                    switch ($_POST["action"]) {
                        //Save game edits into database
                        case "save":
                            if (!empty($_POST["gameID"])) {
                                //Image upload processing
                                if(array_key_exists('image_file', $_FILES)){
                                    //Setting up directories
                                    $uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'games';
                                    $baseName = basename($_FILES['image_file']['name']);
                                    $baseName = preg_replace('/\s+/', '_', $baseName);
                                    $targetFilename = $uploadsDir . DIRECTORY_SEPARATOR . $baseName;
                                    $relativeFilename = substr($targetFilename, (strlen(__DIR__ )+ 1));
                                    $uploadImg = $_FILES['image_file'];


                                    
                                    switch ($uploadImg['error']) {
                                        case UPLOAD_ERR_OK: 
                                            //Expect 'image/png'
                                            mime_content_type($uploadImg['tmp_name']);
                                            move_uploaded_file($uploadImg['tmp_name'], $targetFilename);
                                            $gameImg = $relativeFilename;
                                        break;
                                        case UPLOAD_ERR_INI_SIZE:
                                            $error = sprintf('Failed to upload [%s]: the file is too big.', $uploadInfo['name']);
                                            echo "<script type='text/javascript'>
                                                alert('$error');
                                                history.go(-1);
                                                </script>";
                                            break;
                                        case UPLOAD_ERR_NO_FILE:
                                            //If no file and there isn't already a picture
                                            if(empty($_POST["image"])){
                                                $error = "There is no image attached!";
                                                echo "<script type='text/javascript'>
                                                alert('$error');
                                                history.go(-1);
                                                </script>";
                                                die();
                                            }
                                            $gameImg = $_POST["image"];
                                            break; 
                                    }
                                }

                                //Adding arguments to associative array
                                $gameArgs["name"]        = $_POST["name"];
                                $gameArgs["description"] = $_POST["description"];
                                $gameArgs["ageRating"]   = $_POST["ageRating"];
                                $gameArgs["price"]       = $_POST["price"];
                                $gameArgs["image"]       = $gameImg;
                                $gameArgs["min_req"]     = $_POST["min_req"];
                                $gameArgs["rec_req"]     = $_POST["rec_req"];

                                //Game is new
                                if(strcasecmp($_POST["gameID"], "new") == 0){
                                    $gameArgs["developerID"] = $_POST["developerID"];

                                    //New game
                                    $result = $db_handle->addNewGame($gameArgs);
                                   if($result[0] == 1){
                                        $msg = "Operation successful!";
                                        echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                            window.location.href='game.php?id=$result[1]';
                                        </script>";
                                    } 
                                    else {
                                        $msg = "Operation failed!";
                                        echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                            window.location.href='index.php';
                                        </script>";
                                    }
                                }
                                //Game is not new (edit)
                                else{
                                    //Edit game
                                    $gameID = $_POST["gameID"];
                                    if($db_handle->editGame($gameID, $gameArgs)){
                                        $msg = "Operation successful!";
                                        echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                            window.location.href='game.php?id=$gameID';
                                        </script>";
                                    }
                                    else{
                                        $msg = "Operation failed!";
                                        echo "<script type='application/javascript'>
                                            window.alert('$msg');
                                            window.location.href='index.php';
                                        </script>";
                                    }
                                }

                                
                            }
                        break;
                    }
                }
            break;
        }
    } elseif (!empty($_GET["source"])) {
        switch ($_GET["source"]) {
            case "header":
                switch ($_GET["action"]) {
                    case "logout":
                        session_unset();
                        session_destroy();
                        $msg = "Successfully logged out, hope to see you soon!";
                        echo "<script type='application/javascript'>
                            window.alert('$msg');
                            window.location.href='index.php';
                        </script>";
                        break;
                }
            break;
            case "dev_index":
                switch ($_GET["action"]) {
                    case "unverified":
                        $error = "Your account has not been verified yet!";
                        echo "<script type='application/javascript'>
                            window.alert('$error');
                            window.location.href='index.php';
                        </script>";
                        break;
                }
                break;
        }
    } else {
        $msg = "How did you get here? It's alright, sending you back to safety (the store) now!";
        echo "
            <script type='application/javascript'>
                window.alert('$msg');
                window.location.href = 'index.php';
            </script>";
    }
    ?>
</body>

</html>