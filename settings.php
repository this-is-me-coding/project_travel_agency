<?php
    include_once('includes/header.php');
    if(!isset($_SESSION["userId_Email"])) {
    ?>
    <main class="big_box_flex">
        <h3>You need to sign in to access this page</h3>
    </main>
    <?php
    } else {
?>
<script src="js/signUpPage.js" defer></script>
    <main class="big_box_flex">
        <div class="size_box_flex sbf_left settings_box">
            <h3>Settings</h3>
            <?php if(!(isset($_GET["type"]))) { ?>
                <a href="settings.php?type=password">Change password</a>
                <a href="settings.php?type=address">Address</a>
            <?php } ?>
            <?php if(isset($_GET["type"]) && $_GET["type"]==="password") { 
                echo $_SESSION["userId_Email"]; ?>
                <h3>Change password</h3>
                <form action="act/act_change_password.php" method="post">
                    <input type="password" name="chpwd_old_password" id="chpwd_old_password" autocomplete="current-password">
                    <input type="password" name="chpwd_new_password" id="chpwd_new_password" autocomplete="new-password">
                    <input type="password" name="chpwd_new_password_repeat" id="chpwd_new_password_repeat" autocomplete="new-password">
                    <button name="explore_form_password_change">Button</button>
                </form>
            <?php } ?>
        </div>
    </main>
<?php
    } 
    include_once('includes/footer.php');
?>