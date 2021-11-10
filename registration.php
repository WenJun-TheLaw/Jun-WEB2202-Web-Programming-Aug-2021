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
    <link rel="stylesheet" href="css/registration.css">
    <title>E.GG</title>
</head>

<?php
//Sanitizing input
function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

//If user is logged in
if (isset($_SESSION["userID"])) {
    $error = "You are already logged in! Redirecting you back to the store.";
    echo "<script type='text/javascript'>
                    alert('$error');
                    window.location.href='index.php';
                    </script>";
}

//Sanitizing input
if (isset($_POST['name'])) {
    $name = sanitizeString($_POST['name']);
    if (isset($_POST['email'])) {
        $email = sanitizeString($_POST['email']);
        if (isset($_POST['password'])) {
            $password = sanitizeString($_POST['password']);
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Adding user
            if ($db_handle->addGamer($email, $password, $name)) {
                $log = "Account registered successfully! You may log in now.";
                echo "<script type='text/javascript'>
                    alert('$log');
                    window.location.href='login.php';
                    </script>";
            } else {
                $error = "Account cannot be registered, are you sure the email has not been registered before?";
                echo "<script type='text/javascript'>
                    alert('$error');
                    window.location.href='registration.php';
                    </script>";
            }
        }
    }
}

//Unsetting form variables
unset($_POST['name']);
unset($_POST['email']);
unset($_POST['password']);
?>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <div class="h1 title text-center">REGISTRATION</div>

    <div class="d-flex lex-column align-tems-center justify-content-center registration_form">
        <form method="post" action="" class="d-flex flex-column">
            <label for="email" class="form-labels form_labels">NAME</label>
            <input type="name" class="form_inputs" name="name" required aria-required="true" aria-describedby="name">
            <label for="email" class="form-labels form_labels">EMAIL</label>
            <input type="email" class="form_inputs" name="email" required aria-required="true" aria-describedby="email">
            <label for="password" class="form-labels form_labels">PASSWORD</label>
            <input type="password" class="form_inputs" name="password" required aria-required="true" aria-describedby="password">
            <input type="submit" class="btn btn-success buttons submit_button" id="submit" aria-describedby="submit" value="SIGN ME UP!">
        </form>
    </div>


    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>