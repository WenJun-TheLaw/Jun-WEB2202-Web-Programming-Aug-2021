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
    <link rel="stylesheet" href="css/login.css">
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

    //Salting passwords
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    //Verifying passwords
    if (password_verify($password, $password_hashed)) {
        // echo 'ok';
    }

    //Checking if the user is already logged in
    if (isset($_SESSION['userID'])) {
        $error = "You are already logged in! Redirecting you back to the store.";
        echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='index.php';
                </script>";
    } 
    else {
        //Checking if the form submission occured
        if (isset($_POST['email'])) {
            //Verifiying credentials [EMAIL]
            $clean_email = sanitizeString($_POST['email']);
            $user_result = $db_handle->findUserByEmail($clean_email);

            //If the email exists
            if(!is_null($user_result)){

                //Verifiying credentials [PASSWORD]
                $password = (string)$_POST['password'];
                $password_hashed = $user_result[0]['password'];

                //If passwords match
                if(password_verify($password, $password_hashed)){
                    //Setting session userID and expiry, then redirect user
                    $_SESSION['userID'] = $user_result[0]['userID'];
                    $_SESSION['expiries']['userID'] = time() + 5*60; //5 mins expiry
                    $log = "Logged in successfully! Bringing you to the store.";
                    echo "<script type='text/javascript'>
                                alert('$log');
                                window.location.href='index.php';
                                </script>";
                }
                //Invalid Password
                else{
                    $error = "Invalid email or password!";
                    echo "<script type='text/javascript'>
                            alert('$error');
                            window.location.href='login.php';
                            </script>";
                }
            }
            //Invalid Email
            else{
                $error = "Invalid email or password!";
                echo "<script type='text/javascript'>
                        alert('$error');
                        window.location.href='login.php';
                        </script>";
            }
        }
        //Else display page
        else {
?>

    <body>
        <!-- Header -->
        <?php include("header.php"); ?>
        <div class="h1 title text-center">LOGIN</div>

        <div class="container-fluid">
            <!-- Just one row -->
            <div class="row login_row">
                <!-- Left column (Login info) -->
                <div class="col-md left_column">
                    <form method="post" action="" class="d-flex flex-column">
                        <label for="email" class="form-labels form_labels">EMAIL</label>
                        <input type="email" class="form_inputs" name="email" aria-describedby="email" required aria-required="true">
                        <label for="password" class="form-labels form_labels">PASSWORD</label>
                        <input type="password" class="form_inputs" name="password" aria-describedby="password" required aria-required="true">
                        <input type="submit" class="btn btn-success buttons submit_button" id="submit" aria-describedby="submit" value="LOGIN">
                    </form>
                </div>
                <!-- Right column (Links) -->
                <div class="col-md right_column flex-column d-flex align-items-center justify-content-center">
                    <a href="registration.php">
                        <div class="login_links">
                            NO ACCOUNT YET? SIGN UP HERE!
                        </div>
                    </a>
                    <a href="dev_registration.php">
                        <div class="login_links">
                            ARE YOU A GAME DEVELOPER? JOIN US HERE!
                        </div>
                    </a>
                    <div class="login_links" id="forget_password">
                        FORGOT YOUR PASSWORD?
                    </div>
                </div>
            </div>
        </div>
        <!-- Forgot Password Script -->
        <script type="text/javascript">
            var contactLink = document.getElementById('forget_password');
            contactLink.addEventListener("click", function() {
                window.alert("Forgotten your credentials? Fret Not! Feel free to contact us for further assistance.\nOur working hours are from 10:00 - 17:00\nPhone: 03-0000 0000\nEmail: e.gg@test.com");
            });
        </script>

        <!-- Footer -->
        <?php include("footer.php"); ?>
        <!-- Bootstrap JS CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <?php }} ?>
    </body>

</html>