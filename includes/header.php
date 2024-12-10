<?php
    require_once('act/act_dbh.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/particular.css" type="text/css">
    <link rel="stylesheet" href="css/popup.css" type="text/css">
    <link rel="stylesheet" href="css/signup.css" type="text/css">
    <link rel="stylesheet" href="css/offers.css" type="text/css">
    <link rel="stylesheet" href="css/offers_all.css" type="text/css">
    <link rel="stylesheet" href="css/trips.css" type="text/css">
    <link rel="stylesheet" href="css/settings.css" type="text/css">
    <title>Explore - Travel made easy</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/loginPopUp.js" defer></script>
    <script src="js/menuResponsive.js" defer></script>
</head>
<body>
    <header class="big_box_flex navbar">
        <div class="size_box_flex">
            <div class="navbar_left flexbox">
                <i class="fa solid fa-bars nav_toggle_open" aria-controls="navbar_items"></i>
                <a href="/"><img class="logo" src="images/logo/logo.png"></a>
            </div>
            <div class="navbar_right flexbox">
                <div class="navbar_items" data-visible="false">
                    <ul class="navigation_buttons">
                        <a href="offers.php?page=1"><li>Offers</li></a>
                        <a href="about_us.php"><li>About us</li></a>
                        <a href="contact.php"><li>Contact</li></a>
                        <i class="fa solid fa-close nav_toggle_close"></i>
                    </ul>
                </div>
                <span class="nav_menu_user_divider"></span>
                <?php
                    if(isset($_SESSION["userId_Email"])) {
                       ?>
                        <span class="nav_menu_user_info user_icon">
                            <i class="fa solid fa-user user_icon_logged_in"></i>
                            <p class="logged_in_name">
                                <?php
                                    echo $_SESSION["userId_FName"];
                                ?>
                            </p>
                        </span>
                       <?php
                    } else {
                        ?>
                        <i class="fa solid fa-user user_icon"></i>
                        <?php
                    }
                    ?>
            </div>
            <div class="popup_window popup_user_login_or_options flexbox">
                <h2 class="flexbox">
                    <?php
                    if(isset($_SESSION["userId_Email"])) {
                        echo $_SESSION["userId_FName"]." ".$_SESSION["userId_LName"];
                    } else {
                        echo "Login";
                    }
                    ?>
                    <i class="fa-solid fa-xmark login_popup_close flexbox"></i></h2>
                <?php
                if(isset($_SESSION["userId_Email"])) {
                ?>
                <div class="user_options_box flexbox">
                    <a href="my_trips.php">
                        <div class="user_options_row flexbox">
                            <i class="fa-solid fa-suitcase-rolling"></i>
                            My trips
                        </div>
                    </a>
                    <a href="settings.php">
                        <div class="user_options_row flexbox">
                            <i class="fa-solid fa-sliders"></i>
                            Settings
                        </div>
                    </a>
                    <a href="act/act_logout.php" id="explore_data_logout_button">
                        <div class="user_options_row flexbox">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </div>
                    </a>
                </div>
                <?php
                } else {
                ?>
                <form action="act/act_login.php" method="POST" name="login_form" class="form_login flexbox">
                    <div class="flexbox">
                        <label for="explore_login_email">E-Mail</label>
                        <input type="email" name="explore_login_email" id="explore_login_email" autocomplete="email">
                    </div>
                    <div class="flexbox">
                        <label for="explore_login_password">Password</label>
                        <input type="password" name="explore_login_password" id="explore_login_password">
                    </div>
                    <button name="explore_form_signin_user">Sign in</button>
                </form>
                <a href="#" class="popup_question_link">Forgotten password?</a>
                If you don't have an account
                <button type="button" class="signup">Sign up</button>
                <?php
                }
                ?>
            </div>
        </div>
    </header>
    <noscript>
    <div class="big_box_flex no_script_big_box">
        <div class="size_box_flex no_script_size_box">
            WARNING: You may not be able to perform some actions when JavaScript is disabled.<br>
            If you want to enjoy full functionality of our site, please enable JavaScript.
        </div>
    </div>
    </noscript>