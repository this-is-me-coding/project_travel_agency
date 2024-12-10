<?php

if(isset($_POST["explore_form_signin_user"])) {
    $email = $_POST["explore_login_email"];
    $password = $_POST["explore_login_password"];
    
    require_once 'act_dbh.php';
    require_once 'act_functions.php';

    if (emptyInputLogin($email, $password) !== false) {
        $cookievalue = true;
        setcookie("explore_travel_LoginErrors[emptyInput]", $cookievalue, time()+1, "/");
        header('location: ../index.php');
        exit();
    }

    if (invalidEmail($email) !== false){
        $cookievalue = true;
        setcookie("explore_travel_LoginErrors[invalidEmail]", $cookievalue, time()+1, "/");
        header('location: ../index.php');
        exit();
    }

    signIn($conn, $email, $password);

} else {
    header('location: ../index.php');
    exit();
}