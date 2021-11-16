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
    <link rel="stylesheet" href="css/ads.css">

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
//User isn't "Gamer"
$user = $db_handle->findUserByID($_SESSION["userID"]);
if (strcasecmp($user[0]["userType"], "Gamer") != 0) {
    $error = "It seems like your account isn\'t a gamer account.\\nSowwy you shouldn\'t be here :<";
    echo "<script type='text/javascript'>
                                alert('$error');
                                window.location.href='index.php';
                            </script>";
}

//Get the gamer
$gamer = $db_handle->findGamer($_SESSION["userID"]);
//Check if earning time is <24 hours
//IMPORTANT: SET TIMEZONE TO MALAYSIA OR ELSE $now WILL NOT BE ACCURATE
date_default_timezone_set("Asia/Kuala_Lumpur");
//Last time the user earned currency
$lastEarning  = new DateTime($gamer[0]["lastEarning"]);
//Current time
$now = new DateTime('NOW');
$elapsed = $now->diff($lastEarning);
//Convert time elapsed to day format, if >=1 means 24 hours have passed
$elapsed = $elapsed->format('%d');
$maxEarning = 600;
//See if user exceeded quota, if so check cooldown
if ($gamer[0]["earnings"] >= $maxEarning) {
    if ($elapsed >= 1) {
        $cooldown = "true";
        $quotaLimit = "true";
        $db_handle->resetGamerEarnings($_SESSION["userID"]);
    } else {
        $cooldown = "false";
        $quotaLimit = "false";
        $error = "You have exceeded your earning quota today, you can still watch but you will not earn any credits.";
        echo "<script type='text/javascript'>
        alert('$error');
        </script>";
    }
} else {
    $cooldown = "true";
    $quotaLimit = "true";
}
//Get ads into array
$ads = $db_handle->getAds();
foreach ($ads as $key => $value) {
    $adsLength++;
}
//Current ad index
$db_handle->setGamerAdIndex($_SESSION["userID"], mt_rand(0, $adsLength - 1));
//Update gamer list
$gamer = $db_handle->findGamer($_SESSION["userID"]);
$adIndex = $gamer[0]["currentAdIndex"];

?>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <div class="text-center title">Advertisements</div>

    <div class="container-fluid ads_body">
        <div class="d-flex row">
            <!-- Left container (Video Player) -->
            <div class="d-flex left_col justify-content-center col-md mt-4">
                <div id="player"></div>
            </div>
            <!-- Right container (Stats) -->
            <div class="d-flex flex-column col-md mt-4">
                <div class="ad_text_large">
                    Current balance:
                </div>
                <div class="ad_text_medium" id="balance">
                    <?php echo $gamer[0]["currency"] ?>&nbsp;coins
                </div>
                <div class="ad_text_large mt-4">
                    Daily quota:
                </div>
                <div class="ad_text_medium" id="quota">
                    <?php echo $gamer[0]["earnings"] . "/" . $maxEarning ?>&nbsp;coins
                </div>
                <div class="ad_text_small">
                    *If the current payout exceeds the quota, you will still get the remainder
                </div>
                <div class="ad_text_large mt-4">
                    Current video payout:
                </div>
                <div class="ad_text_medium" id="payout">
                    <?php echo $ads[$adIndex]["adsPayout"] ?>&nbsp;coins
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php include("footer.php"); ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- JQuery JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Youtube IFrame Player API -->
    <script>
        //This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // This function creates an <iframe> (and YouTube player) after the API code downloads.
        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '506',
                width: '900',
                videoId: '<?php echo $ads[$adIndex]["adsLink"] ?>',
                playerVars: {
                    'playsinline': 1,
                    'modestbranding': 1,
                    'enablejsapi': 1,
                    'iv_load_policy': 3
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        var startTime;
        // The inital params of lastWatched and withinQuota               
        var lastWatched = <?php echo $cooldown; ?>;
        var withinQuota = <?php echo $quotaLimit; ?>;

        //When the player is ready, play the video and start timer
        function onPlayerReady(event) {
            event.target.setVolume(30);
            event.target.playVideo();
            startTime = new Date();
        }

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
                //See how long the user have watched
                var endTime = new Date();
                var watchDuration = (endTime.getTime() - startTime.getTime()) / 1000;
                //How long is the video
                var videoLength = player.getCurrentTime();
                console.log("Time watched:" + watchDuration);
                console.log("Video length:" + videoLength);
                //Watch ratio
                var watchRatio = (watchDuration / videoLength) * 100;
                console.log("Watch Ratio:" + watchRatio);

                //If watch ratio >=90%, give payout
                if (watchRatio >= 90 && lastWatched && withinQuota) {
                    $.ajax({
                        type: "POST",
                        url: 'formhandler.php',
                        dataType: 'json',
                        data: {
                            source: 'ads',
                            action: 'payout',
                            payout: 'true',
                            userID: '<?php echo $_SESSION["userID"] ?>',
                            quota: `<?php
                                    //Update gamer list
                                    $gamer = $db_handle->findGamer($_SESSION["userID"]);
                                    $adIndex = $gamer[0]["currentAdIndex"];
                                    //If earning exceeds quota
                                    if (($gamer[0]["earnings"] + $ads[$adIndex]["adsPayout"]) > $maxEarning) {
                                        echo 'true';
                                    } else {
                                        echo 'false';
                                    }
                                    ?>`,
                            amount: `<?php //Update gamer list
                                        $gamer = $db_handle->findGamer($_SESSION["userID"]);
                                        $adIndex = $gamer[0]["currentAdIndex"];
                                        echo $ads[$adIndex]["adsPayout"]
                                        ?>`
                        },
                        statusCode: {
                            200: function(obj) {
                                console.log(JSON.stringify(obj));

                                console.log(obj.link);
                                if (!('error' in obj)) {
                                    console.log(obj.log);
                                    if (obj.payout == true) {
                                        window.alert("The payout is completed, loading next ad in 5 seconds");
                                    } else {
                                        window.alert("There was no payout, please ensure you watch >90% of the video!\nLoading next ad in 5 seconds");
                                    }

                                    //Load next video
                                    setTimeout(function() {
                                        player.loadVideoById(obj.link);
                                    }, 5000);

                                    //Update UI stats
                                    var balanceDiv = document.getElementById("balance");
                                    balanceDiv.innerHTML = obj.balanceDiv;
                                    var quotaDiv = document.getElementById("quota");
                                    quotaDiv.innerHTML = obj.quotaDiv + "<?php echo "/" . $maxEarning ?>&nbsp;coins";
                                    var payoutDiv = document.getElementById("payout");
                                    payoutDiv.innerHTML = obj.payoutDiv;
                                    withinQuota = (obj.quotaLimit === 'true');
                                } else {
                                    console.log(obj.error);
                                }
                            }
                        }

                    });
                }
                //Watch ratio <90%, no payout
                else {
                    $.ajax({
                        type: "POST",
                        url: 'formhandler.php',
                        dataType: 'json',
                        data: {
                            source: 'ads',
                            action: 'payout',
                            payout: 'false',
                            userID: '<?php echo $_SESSION["userID"] ?>',
                            quota: `<?php
                                    //Update gamer list
                                    $gamer = $db_handle->findGamer($_SESSION["userID"]);
                                    $adIndex = $gamer[0]["currentAdIndex"];
                                    //If earning exceeds quota
                                    //If earning exceeds quota
                                    if (($gamer[0]["earnings"] + $ads[$adIndex]["adsPayout"]) > $maxEarning) {
                                        echo 'true';
                                    } else {
                                        echo 'false';
                                    }
                                    ?>`,
                            amount: `<?php //Update gamer list
                                        $gamer = $db_handle->findGamer($_SESSION["userID"]);
                                        $adIndex = $gamer[0]["currentAdIndex"];
                                        echo $ads[$adIndex]["adsPayout"]
                                        ?>`
                        },
                        statusCode: {
                            200: function(obj) {
                                console.log(JSON.stringify(obj));

                                console.log(obj.link);
                                if (!('error' in obj)) {
                                    console.log(obj.log);
                                    if (obj.payout == true) {
                                        window.alert("The payout is completed, loading next ad in 5 seconds");
                                    } else {
                                        window.alert("There was no payout, please ensure you watch >90% of the video!\nLoading next ad in 5 seconds");
                                    }

                                    //Load next video
                                    setTimeout(function() {
                                        player.loadVideoById(obj.link);
                                    }, 5000);

                                    //Update UI stats
                                    var balanceDiv = document.getElementById("balance");
                                    balanceDiv.innerHTML = obj.balanceDiv;
                                    var quotaDiv = document.getElementById("quota");
                                    quotaDiv.innerHTML = obj.quotaDiv + "<?php echo "/" . $maxEarning ?>&nbsp;coins";
                                    var payoutDiv = document.getElementById("payout");
                                    payoutDiv.innerHTML = obj.payoutDiv;
                                    withinQuota = (obj.quotaLimit === 'true');

                                }

                            }
                        }
                    });
                }
            }

            function stopVideo() {
                player.stopVideo();
            }
        }
    </script>

</body>

</html>