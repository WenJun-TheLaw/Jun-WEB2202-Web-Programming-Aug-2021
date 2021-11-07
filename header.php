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
</style>

<header>
    <div class="d-flex justify-content-end align-items-center header_bg">
        <a href="index.php" class="text-decoration-none text-dark ms-2">
            <div class="header_logo ms-2">
                <img src="resources\e.gg_icon.png" alt="Icon of E.GG" class="header_egg_logo">
                E.gg Game Store
            </div>
        </a>

        <a href="login.php" type="button" class="text-decoration-none ms-auto me-2">
            <button class="btn btn-success buttons">
                Login
            </button>
        </a>

        <a href="registration.php" type="button" class="text-decoration-none me-2">
            <button class="btn btn-success buttons">
                Sign Up
            </button>
        </a>
    </div>
</header>