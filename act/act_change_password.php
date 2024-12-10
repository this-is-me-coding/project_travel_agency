<?php

if(isset($_POST["explore_form_password_change"])) {
    require_once 'act_dbh.php';
    require_once 'act_functions.php';
    session_start();

    $user_email = $_SESSION["userId_Email"];
    $old_password = $_POST["chpwd_old_password"];
    $new_password = $_POST["chpwd_new_password"];
    $new_password_re = $_POST["chpwd_new_password_repeat"];

    if (checkPassword($conn, $user_email, $old_password) !== false){
        $cookievalue = true;
        setcookie("explore_travel_PasswordChange[wrongCurrentPassword]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured');
        exit();
    }

    if (doPasswordsMatch($new_password, $new_password_re) !== false){
        $cookievalue = true;
        setcookie("explore_travel_PasswordChange[passwordsDoNotMatch]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured');
        exit();
    }

    changePassword($conn, $user_email, $new_password);

} else {
    header('location: ../index.php');
    exit();
}