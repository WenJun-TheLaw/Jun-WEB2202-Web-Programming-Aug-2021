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
    <link rel="stylesheet" href="css/cart.css">
    <title>E.GG Store</title>
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

    //Display the cart
    $cart = $db_handle->getUserCart($_SESSION['userID']);
    $user = $db_handle->findUserByID($_SESSION["userID"]);
    $cartTotal = 0;
    ?>

    <!-- Header -->
    <?php include("header.php"); ?>

    <div class="h1 title text-center"><?php echo $user[0]["name"]; ?>&apos;s Cart</div>
    <div class="container-fluid full_height">
        <div class="d-flex flex-column cart_body">

            <!-- Display cart items -->
            <?php
            //If not empty
            if (!is_null($cart)) {
                foreach ($cart as $key => $value) {
                    $img    = $cart[$key]["image"];
                    $name   = $cart[$key]["name"];
                    $price  = number_format($cart[$key]["price"], 2);
                    $cartTotal += $price;
                    $id     = $cart[$key]["gameID"];
                    echo <<<_END
                    
                    <!-- Each idividual Cart Item -->
                    <div class="d-flex cart_item p-4">
                        <!-- Image -->
                        <a href="game.php?id=$id">
                            <img src="$img" class="cart_image" alt="Image of cart item">
                        </a>
                        
                        <!-- Name -->           
                        <div class="cart_item_mid_col d-flex flex-column align-items-center ms-4">
                            <a href="game.php?id=$id">
                                <div class="cart_text_medium cart_links" id=cart_name>$name</div>
                            </a>
                        </div>
                       

                        <!-- Controls & Price -->
                        <div class="cart_item_right_col d-flex flex-column justify-content-center align-items-center ms-auto">
                            <!-- Price Text -->
                            <div class="d-flex">
                                <div class="cart_text_medium">Price&colon;&nbsp;</div>
                                <div class="cart_text_medium">RM&nbsp;</div>
                                <div class="cart_text_medium" id=cart_price>$price</div>
                            </div>
                            <!-- Delete Button -->
                            <div class="cart_delete d-flex justify-content-center mt-2">
                                <form action="formhandler.php" method="POST">
                                    <input type="hidden" name="source" value="cart">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="gameID" value="$id">
                                    <button type="submit" class="cart_invi_button">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                
_END;
                }
                $cartTotal = number_format($cartTotal, 2);
                echo <<<_END
                <div class="d-inline-flex align-items-end cart_total_div ms-auto mt-4">
                    <div class="cart_text_large h1">Total&colon;&nbsp;</div>
                    <div class="cart_text_large h1">RM&nbsp;$cartTotal</div>
                </div>
                <div class="d-flex align-items-end cart_buttons_div">
                    <!-- Empty Cart Button -->
                    <form action="formhandler.php" method="POST" class="ms-auto">
                        <input type="hidden" name="action" value="empty">
                        <input type="hidden" name="source" value="cart">
                        <button type="submit" class="cart_invi_button btn btn-danger buttons cart_empty_button">
                            <i class="bi bi-x-lg cart_text_medium text-decoration-none fst-normal cart_empty_text">&nbsp;Empty cart</i>
                        </button>
                    </form>
                    <!-- Checkout Button -->
                    <form action="formhandler.php" method="POST" class="ms-2">
                        <input type="hidden" name="action" value="checkout">
                        <input type="hidden" name="source" value="cart">
                        <button type="submit" class="cart_invi_button btn btn-success buttons cart_checkout_button">
                            <i class="bi bi-check-lg cart_text_medium text-decoration-none fst-normal cart_checkout_text">&nbsp;Checkout</i>
                        </button>
                    </form>
                </div>
_END;
            } else {
                echo <<<_END
                <div class="h2 title text-center">Your cart is empty!</div>
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
