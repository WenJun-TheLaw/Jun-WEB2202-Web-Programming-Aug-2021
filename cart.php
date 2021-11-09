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
    else {
        $cart = $db_handle->getUserCart($_SESSION['userID']);
    ?>
        <!-- Header -->
        <?php include("header.php"); ?>

        <div class="h1 title text-center">SHOPPING CART</div>

        <!-- ?php
        foreach ($cart as $key => $value) {
        }
        ?> -->

        <div class="d-flex cart_body">
            <div class="cart_item">
                <!-- TODO: img, name, price-->
            </div>
        </div>

        <!-- Footer -->
        <?php include("footer.php"); ?>
        <!-- Bootstrap JS CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <?php } ?>
</body>

</html>