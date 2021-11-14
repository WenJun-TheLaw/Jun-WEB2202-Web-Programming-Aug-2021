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
    <link rel="stylesheet" href="css/dev_index.css">

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

//If user isn't "Developer"
$user = $db_handle->findUserByID($_SESSION["userID"]);
if (strcasecmp($user[0]["userType"], "Developer") != 0) {
    $error = "It seems like your account isn\'t a developer account.\\nSowwy you shouldn\'t be here :<";
    echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='index.php';
        </script>";
}

$dev = $db_handle->findDeveloper($_SESSION["userID"]);
$accountStatus = $dev[0]["verified"];
if ($accountStatus == 1) {
    $accountStatusText = "Verified";
} else {
    $accountStatusText = "Pending verification...";
}
?>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <div class="container-fluid dev_index_main">
        <!-- Top status bar -->
        <div class="d-flex flex-md-row flex-column justify-content-md-evenly align-items-center dev_top_status">
            <div class="d-inline-flex py-4">
                <div class="dev_text_large fw-bold">Revenue&colon;&nbsp;</div>
                <div class="dev_text_large">RM&nbsp;<?php echo number_format($dev[0]["revenue"], 2); ?></div>
            </div>
            <div class="d-inline-flex py-4">
                <div class="dev_text_large fw-bold">Account status&colon;&nbsp;</div>
                <div class="dev_text_large">&nbsp;<?php echo $accountStatusText ?></div>
            </div>
        </div>

        <!-- Big Mean Buttons :>-->
        <div class="d-flex mt-4 flex-md-row flex-column justify-content-md-evenly align-items-center dev_buttons_div">
            <!-- Create a new game-->
            <?php
            if ($accountStatus == 1) {
                $newlink  = "game_edit.php?id=new";
            } else {
                $newlink  = "formhandler.php?source=dev_index&action=unverified";
            }
            ?>
            <a href="<?php echo $newlink ?>">
                <button class="dev_big_buttons mt-4">
                    <i class="bi bi-plus-lg dev_text_large" style="font-size:5em;"></i>
                    <div class="dev_text_large">Add New Game</div>
                </button>
            </a>
            <!-- Bring dev to list of games they published -->
            <a href="game_edit_list.php">
                <button class="dev_big_buttons mt-4">
                    <i class="bi bi-pencil-square dev_text_large" style="font-size:5em;"></i>
                    <div class="dev_text_large">Edit Existing Game</div>
                </button>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>