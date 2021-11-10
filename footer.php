<style>
    .footer_bg {
        background-color: #435055;
        height: 30vh;
        width: 100%;
        padding: 3vh 0 2vh 0;
        margin-top: 5vh;
    }

    .footer_egg_logo {
        height: 5vh;
    }

    .footer_logo {
        font-size: 1.5em;
        color: #A3F7BF;
        font-family: 'Lobster', cursive;
    }

    .footer_links {
        font-family: 'Red Hat Display', sans-serif;
        list-style-type: none;
        text-decoration: none;
        color: #A3F7BF;
    }

    .footer_links li {
        margin: 5px 20px;
        padding: 0 20px 0 5px;
        font-size: 1.3em;
    }

    .footer_links a:hover {
        color: #29A19C;
    }

    .bottom_border {
        border-bottom: solid 2px #A3F7BF;
    }

    .footer_copyright {
        font-family: 'Red Hat Display', sans-serif;
        color: #A3F7BF;
        font-size: 1.3em;
    }
</style>

<footer>
    <div class="d-flex justify-content-start align-items-center footer_bg">
        <a href="index.php" class="text-decoration-none text-dark ms-2">
            <div class="footer_logo ms-2">
                <img src="resources\e.gg_icon.png" alt="Icon of E.GG" class="footer_egg_logo">
                E.gg Game Store
            </div>
        </a>

        <div class="d-flex footer_links">
            <ul class="footer_links">
                <li class="pb-1">
                    Links:
                </li>
                <li class="bottom_border">
                    <a href="index.php" class="footer_links">Home</a>
                </li>
                <li class="bottom_border">
                    <a href="dev_registration.php" class="footer_links">Developers</a>
                </li>
                <li>
                    <a href="#" class="footer_links" id="contact_link">Contact</a>
                </li>
            </ul>
        </div>

        <div class="footer_copyright ms-auto me-2">E.GG &copy; | 2021</div>
    </div>
</footer>

<script type="text/javascript">
    var contactLink = document.getElementById('contact_link');
    contactLink.addEventListener("click", function() {
        window.alert("Please do not hesitate to contact us :D\nOur working hours are from 10:00 - 17:00\nPhone: 03-0000 0000\nEmail: e.gg@test.com");
    });
</script>