<?php

function emptyInputSignup($first_name, $last_name, $DOB, $email, $phone_prefix, $phone, $password, $password_repeat) {
    $result;
    if(empty($first_name)
        || empty($last_name)
        || empty($DOB)
        || empty($email)
        || empty($phone_prefix)
        || empty($phone)
        || empty($password)
        || empty($password_repeat)
        ) {
            $result = true;
        } else {
            $result = false;
        }
    return $result;
}

function termsNotAgreed($terms) {
    $result;
    if(empty($terms)) {
            $result = true;
        } else {
            $result = false;
        }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExists($conn, $email) {
    $sql = "SELECT *  FROM Accounts WHERE acc_email = ?;";
    $params = array (&$email);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if(!$stmt) {
        $cookievalue = true."prepEmail";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();
    }
    
    $query_result = sqlsrv_execute($stmt);

    if (!$query_result) {  
        $cookievalue = true."execEmail";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();  
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    sqlsrv_free_stmt($stmt);
}

function phoneExists($conn, $phone_number) {
    $sql = "SELECT phone_number FROM Accounts WHERE phone_number = ?;";
    $params = array (&$phone_number);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if(!$stmt) {
        $cookievalue = true."prepPhone";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();
    }
    
    $query_result = sqlsrv_execute($stmt);

    if (!$query_result) {  
        $cookievalue = true."execPhone";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    sqlsrv_free_stmt($stmt);
}

function doPasswordsMatch($password, $password_repeat) {
    $result;
    if ($password !== $password_repeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $first_name, $last_name, $DOB, $country, $zip_code, $town, $street_address, $phone_prefix, $phone_number, $acc_email, $user_password) {
    $sql = "INSERT INTO Accounts(first_name, last_name, DOB, country, zip_code, town, street_address, phone_prefix, phone_number, acc_email, user_password) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $hashedPassword = password_hash($_POST["reg_password"], PASSWORD_DEFAULT);

    if($zip_code === "") {
        $zip_code = NULL;
    }

    if($town === "") {
        $town = NULL;
    }

    if($street_address === "") {
        $town = NULL;
    }

    $params = array (
        &$first_name,
        &$last_name,
        &$DOB,
        &$country,
        &$zip_code,
        &$town,
        &$street_address,
        &$phone_prefix,
        &$phone_number,
        &$acc_email,
        &$hashedPassword
    );

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if (!$stmt) {
        $cookievalue = true."prepCreate";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();
    }
    
    $query_result = sqlsrv_execute($stmt);

    if (!$query_result) {  
        $cookievalue = true."execCreate";
        setcookie("explore_travel_SignUpErrors[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../signup.php?error=occured'); 
        exit();
    }

    sqlsrv_free_stmt($stmt);

    $cookievalue = true;
    setcookie("explore_travel_SignUpSuccess", $cookievalue, time()+1, "/");
    header('location: ../index.php');
}

function emptyInputLogin($email, $password) {
    $result;
    if(empty($email)
        || empty($password)
        ) {
            $result = true;
        } else {
            $result = false;
        }
    return $result;
}

function signIn($conn, $email, $password){
    $loginUserExists = emailExists($conn, $email);

    if ($loginUserExists === false) {
        $cookievalue = true;
        setcookie("explore_travel_LoginErrors[nonExistentUser]", $cookievalue, time()+1, "/");
        header('location: ../index.php');
        exit();
    }

    $passHashed = $loginUserExists["user_password"];
    $checkPass = password_verify($password, $passHashed);

    if ($checkPass === false) {
        $cookievalue = true;
        setcookie("explore_travel_LoginErrors[wrongCredentials]", $cookievalue, time()+1, "/");
        header('location: ../index.php');
        exit();
    } else if ($checkPass === true) {
        session_start();
        $_SESSION["userId_Email"] = $loginUserExists["acc_email"];
        $_SESSION["userId_FName"] = $loginUserExists["first_name"];
        $_SESSION["userId_LName"] = $loginUserExists["last_name"];

        header('location: ../index.php');
        exit();
    }
}

// PASSWORD CHANGE
function checkPassword($conn, $email, $password) {
    $uExists = emailExists($conn, $email);

    if ($uExists === false) {
        $cookievalue = true;
        setcookie("explore_travel_PasswordIntegrity[failed]", $cookievalue, time()+1, "/");
        header('location: ../index.php');
        exit();
    }

    $passHashed = $uExists["user_password"];
    $checkPass = password_verify($password, $passHashed);

    return $checkPass;
}

function changePassword($conn, $email, $new_password) {
    $pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE Accounts SET user_password = ? WHERE acc_email = ?";
    $params = array (
        &$pass_hash,
        &$email
    );
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if(!$stmt) {
        $cookievalue = true."prepCHP";
        setcookie("explore_travel_[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured'); 
        exit();
    }
    
    $query_result = sqlsrv_execute($stmt);

    if (!$query_result) {  
        $cookievalue = true."execCHP";
        setcookie("explore_travel_[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured'); 
        exit();  
    }

    sqlsrv_free_stmt($stmt);

    header('location: act_logout.php');
}