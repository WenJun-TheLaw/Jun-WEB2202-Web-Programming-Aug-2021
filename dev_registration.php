<?php
if (!isset($_SESSION)) session_start();
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

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <?php
    //Sanitizing input
    function sanitizeString($var)
    {
        $var = stripslashes($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
        return $var;
    }

    //Salting passwords
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    //Verifying passwords
    if (password_verify($password, $password_hashed)) {
        // echo 'ok';
    }
    ?>




    <div class="h1 title text-center">DEVELOPER REGISTRATION</div>

    <div class="d-flex lex-column align-tems-center justify-content-center registration_form">
        <form method="post" action="" class="d-flex flex-column">
            <label for="name" class="form-labels form_labels">NAME</label>
            <input type="name" class="form_inputs" id="name" aria-describedby="name">
            <label for="email" class="form-labels form_labels">EMAIL</label>
            <input type="email" class="form_inputs" id="email" aria-describedby="email">
            <label for="ssn" class="form-labels form_labels">COMPANY REG NO.</label>
            <input type="ssn" class="form_inputs" id="ssn" aria-describedby="ssn">
            <label for="password" class="form-labels form_labels">PASSWORD</label>
            <input type="password" class="form_inputs" id="password" aria-describedby="password">
            <input type="submit" class="btn btn-success buttons submit_button" id="submit" aria-describedby="submit" value="SIGN ME UP!">
        </form>
    </div>


    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>