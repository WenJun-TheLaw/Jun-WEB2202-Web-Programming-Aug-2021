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

    .dropdown {
        width: max-content;
    }

    .header_invi_button {
        width: max-content;
        background: transparent no-repeat;
        border: none;
        cursor: pointer;
        overflow: hidden;
        outline: none;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
    }

    .dropdown-menu-end {
        right: 0;
        left: auto;
        padding: 10px;
        background-color: #435055;
    }

    .header_link {
        color: white;
    }

    .header_link:hover {
        color: #29A19C;
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

            //User type = "Gamer"
            //Dropdown menu shows "Cart" , "Library" & "Logout"
            if(strcasecmp($user[0]["userType"], "Gamer") == 0){
                echo <<<_END
                <div class="dropdown ms-auto">
                    <button class="dropdown-toggle header_invi_button d-inline-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="header_text ">Welcome,&nbsp;</div>
                        <div class="header_text me-2">$username</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item header_link p-2" href="cart.php">Cart</a></li>
                        <li><a class="dropdown-item header_link p-2" href="library.php">Library</a></li>
                        <li><a class="dropdown-item header_link p-2" href="formhandler.php?source=header&action=logout">Logout</a></li>
                    </ul>
                </div>
_END;
            }
            //User type == "Developer"
            //Dropdown menu shows "Manage Games" & "Logout"
            elseif(strcasecmp($user[0]["userType"], "Developer") == 0){
                echo <<<_END
                <div class="dropdown ms-auto">
                    <button class="dropdown-toggle header_invi_button d-inline-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="header_text ">Welcome,&nbsp;</div>
                        <div class="header_text me-2">$username</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item header_link p-2" href="game_edit_list.php">Manage Games</a></li>
                        <li><a class="dropdown-item header_link p-2" href="formhandler.php?source=header&action=logout">Logout</a></li>
                    </ul>
                </div>
_END;
            }
            //User type == "Admin"
            //Dropdown menu shows "Manage Games", "Manage Applications" & "Logout"
            elseif (strcasecmp($user[0]["userType"], "Admin") == 0) {
                echo <<<_END
                <div class="dropdown ms-auto">
                    <button class="dropdown-toggle header_invi_button d-inline-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="header_text ">Welcome,&nbsp;</div>
                        <div class="header_text me-2">$username</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item header_link p-2" href="game_edit_list.php">Manage Games</a></li>
                        <li><a class="dropdown-item header_link p-2" href="manageApplications.php">Manage Applications</a></li>
                        <li><a class="dropdown-item header_link p-2" href="formhandler.php?source=header&action=logout">Logout</a></li>
                    </ul>
                </div>
_END;
            }

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