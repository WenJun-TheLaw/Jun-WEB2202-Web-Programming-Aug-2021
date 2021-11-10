<style>
    .header_bg {
        background-color: #435055;
        height: 10vh;
        width: auto;
    }

    .header_egg_logo {
        height: 8vh;
    }

    .header_logo {
        font-size: 2em;
        color: #A3F7BF;
        font-family: 'Lobster', cursive;
    }

    .header_text {
        font-size: 1.5em;
        color: #a3f7bf;
        font-family: 'Red Hat Display', sans-serif;
    }
</style>

<header>
    <!-- The logo and header BG -->
    <div class="d-flex justify-content-end align-items-center header_bg">
        <a href="index.php" class="text-decoration-none text-dark ms-2">
            <div class="header_logo ms-2">
                <img src="resources\e.gg_icon.png" alt="Icon of E.GG" class="header_egg_logo">
                E.gg Game Store
            </div>
        </a>
        <?php
        //If user is logged in
        if (isset($_SESSION["userID"])) {
            //Find user name
            $user = $db_handle->findUserByID($_SESSION["userID"]);
            $username = $user[0]['name'];
            echo <<<_END
                <div class="header_text ms-auto">Welcome,&nbsp;</div>
                <div class="header_text me-2">$username</div>
            _END;
        }
        //User isn't logged in
        else {
            echo <<<_END
                 <!-- Login Button -->
                <a href="login.php" type="button" class="text-decoration-none ms-auto me-2">
                    <button class="btn btn-success buttons">
                        Login
                    </button>
                </a>
                <!-- Sign up Button -->
                <a href="registration.php" type="button" class="text-decoration-none me-2">
                    <button class="btn btn-success buttons">
                        Sign Up
                    </button>
                </a>
            _END;

        } ?>
        
    </div>
</header>