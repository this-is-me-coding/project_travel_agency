<?php

if(isset($_POST["explore_form_register_new"])) {
    $first_name = trim($_POST["reg_first_name"]);
    $last_name = trim($_POST["reg_last_name"]);
    $DOB = $_POST["reg_DOB"];
    $street_address = trim($_POST["reg_street_address"]);
    $zip_code = trim($_POST["reg_zip_code"]);
    $town = trim($_POST["reg_city"]);
    $country = trim($_POST["reg_country"]);
    $email = trim($_POST["reg_email"]);
    $phone_prefix = trim($_POST["reg_phone_prefix"]);
    $phone = trim($_POST["reg_phone"]);
    $password = trim($_POST["reg_password"]);
    $password_repeat = trim($_POST["reg_password_repeat"]);
    $terms = trim($_POST["reg_terms"]);

    require_once 'act_dbh.php';
    require_once 'act_functions.php';

    if (emptyInputSignup($first_name, $last_name, $DOB, $email, $phone_prefix, $phone, $password, $password_repeat) !== false) {
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[emptyInput]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }

    if (invalidEmail($email) !== false){
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[invalidEmail]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }

    if (emailExists($conn, $email) !== false){
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[emailExists]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }

    if (phoneExists($conn, $email) !== false){
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[phoneExists]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }

    if (doPasswordsMatch($password, $password_repeat) !== false){
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[passwordsDoNotMatch]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }

    if (termsNotAgreed($terms) !== false) {
        $cookievalue = true;
        setcookie("explore_travel_SignUpErrors[terms]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured');
        exit();
    }
    
    createUser($conn, $first_name, $last_name, $DOB, $country, $zip_code, $town, $street_address, $phone_prefix, $phone, $email, $password);

} else {
    header('location: ../signup.php');
    exit();
}