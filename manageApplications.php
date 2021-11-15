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
    <link rel="stylesheet" href="css/manageApplications.css">
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
    //User isn't "Admin"
    $user = $db_handle->findUserByID($_SESSION["userID"]);
    if (strcasecmp($user[0]["userType"], "Admin") != 0) {
        $error = "It seems like your account isn\'t an admin account.\\nSowwy you shouldn\'t be here :<";
        echo "<script type='text/javascript'>
                        window.alert('$error');
                        window.location.href='index.php';
                    </script>";
    }
    //Checking GET
    if(!empty($_GET["action"])) {
        //If ID is in URL
        if (!empty($_GET["id"])) {
            //ID is a developer
            $developerID = $_GET["id"];
            $developer = $db_handle->findDeveloper($developerID);
            if(!empty($developer[0])){
                switch ($_GET["action"]) {
                    case "accept":
                        if($db_handle->updateDevVerification($developerID, 1)){
                            $msg = "Developer application accepted :D";
                            echo "<script type='text/javascript'>
                                    window.alert('$msg');
                                    window.location.href='manageApplications.php';
                                </script>";
                        }
                        else{
                            $error = "There was a problem when updating the verification status :C ";
                            echo "<script type='text/javascript'>
                                        window.alert('$error');
                                        window.location.href='manageApplications.php';
                                    </script>";
                        }
                    break;
                    case "reject":
                        if ($db_handle->updateDevVerification($developerID, -1)) {
                            $msg = "Developer application rejected :D";
                            echo "<script type='text/javascript'>
                                        window.alert('$msg');
                                        window.location.href='manageApplications.php';
                                    </script>";
                        } else {
                            $error = "There was a problem when updating the verification status :C ";
                            echo "<script type='text/javascript'>
                                            window.alert('$error');
                                            window.location.href='manageApplications.php';
                                        </script>";
                        }
                    break;
                }   
            } 
            else {
                $error = "Incorrect user ID!";
                echo "<script type='text/javascript'>
                    alert('$error');
                    window.location.href='index.php';
                    </script>";
            }
            
        } 
        //No ID in URL
        else {
            $error = "User ID not found! Check the URL.";
            echo "<script type='text/javascript'>
                alert('$error');
                window.location.href='index.php';
                </script>";
        }
    }
    $list = $db_handle->getDeveloperApplications();
    //Display the applcations list
?>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <div class="container-fluid application_body">
        <?php
        //If not empty
        if (!is_null($list)) {
            foreach ($list as $key => $value) {
                $ssn    = $list[$key]["companySSN"];
                $id     = $list[$key]["developerID"];
                $user   = $db_handle->findUserByID($id);
                $name   = $user[0]["name"];
                echo <<<_END
                    
                <!-- Each idividual application -->
                <div class="d-flex application_row p-4 mt-4 mx-4">
                    <div class="d-flex flex-column left_div">
                        <!-- Name -->
                        <div class="row">
                            <div class="col left_col">
                                <div class="application_text_medium fw-bold text-end">Name&colon;</div>
                            </div>
                            <div class="col">
                                <div class="application_text_medium">$name</div>
                            </div>
                        </div>
                        <!-- SSN -->
                        <div class="row">
                            <div class="col left_col">
                                <div class="application_text_medium fw-bold text-end">Company SSN&colon;</div>
                            </div>
                            <div class="col">
                                <div class="application_text_medium">$ssn</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center ms-auto">
                        <!-- Accept Button -->
                        <button type="submit" class="application_invi_button d-inline-flex align-items-center" onclick="window.location.href='manageApplications.php?action=accept&id=$id';">
                            <i class="bi bi-check-lg application_links"></i>
                            <div class="application_text_large application_links ms-2">Accept</div>
                        </button>
                        <!-- Reject Button -->
                        <button type="submit" class="application_invi_button d-inline-flex align-items-center" onclick="window.location.href='manageApplications.php?action=reject&id=$id';">
                            <i class="bi bi-x-lg application_links"></i>
                            <div class="application_text_large application_links ms-2">Reject</div>
                        </button>
                    </div>
                </div>
                
_END;
            }
        } else {
            echo <<<_END
                <div class="h2 title text-center">There are no developers pending verification :/</div>
_END;
        } ?>
    </div>

    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>


