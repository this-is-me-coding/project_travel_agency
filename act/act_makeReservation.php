<?php
if(isset($_POST["explore_form_make_reservation"])) { 
    require_once 'act_dbh.php';
    session_start();
    $offer_id = $_POST["offer_booking_offer_id"];
    $client_is_participating = $_POST["client_participant"];
    $payment_handler_id = $_POST["offer_booking_payment_method"];
    
    $other_participants_number = 0;
    if(!empty($_POST["offer_booking_other_participants_number"]) && $_POST["offer_booking_other_participants_number"]>=1) {
        $other_participants_number = $_POST["offer_booking_other_participants_number"];
    
        for($i = 1; $i <= $other_participants_number; $i++) {
            ${"op_dr_p".$i."_first_name"} = $_POST["op_dr_p".$i."_first_name"];
            ${"op_dr_p".$i."_last_name"} = $_POST["op_dr_p".$i."_last_name"];
            ${"op_dr_p".$i."_DOB"} = $_POST["op_dr_p".$i."_DOB"];
            ${"op_dr_p".$i."_phone"} = $_POST["op_dr_p".$i."_phone"];
            ${"op_dr_p".$i."_email"} = $_POST["op_dr_p".$i."_email"];
        }
    }
    
    $myparams_agreement = array (
        "mail" => $_SESSION["userId_Email"],
        "offer" => intval($offer_id),
        "other_participants" => $other_participants_number,
        "payment" => intval($payment_handler_id),
        "participant" => intval($client_is_participating)
    );
    
    $procedure_params_agreement = array(
        array(&$myparams_agreement['mail'], SQLSRV_PARAM_IN),
        array(&$myparams_agreement['offer'], SQLSRV_PARAM_IN),
        array(&$myparams_agreement['other_participants'], SQLSRV_PARAM_IN),
        array(&$myparams_agreement['payment'], SQLSRV_PARAM_IN),
        array(&$myparams_agreement['participant'], SQLSRV_PARAM_IN)
    );
    
    $sql = "EXEC dbo.newAgreement @mail = ?, @offer = ?, @op = ?, @pay_handler = ?, @is_a_participant = ?;";
    $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_agreement);
    
    if(!$stmt) {
        $cookievalue = true;
        setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured1'); 
        exit();
    }
    
    $query_result = sqlsrv_execute($stmt);
    
    if (!$query_result) {  
        $cookievalue = true."execAGREEMENT";
        setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
        header('location: ../index.php?error=occured2'); 
        exit();  
    }
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $created_agreement = $row["agreement_id"];
    }

    sqlsrv_free_stmt($stmt);

    if($other_participants_number>=1) {
        for($i = 1; $i <= $other_participants_number; $i++) {
            $myparams_participants = array (
                "agreement" => $created_agreement,
                "fname" => ${"op_dr_p".$i."_first_name"},
                "lname" => ${"op_dr_p".$i."_last_name"},
                "DOB" => ${"op_dr_p".$i."_DOB"},
                "phone" => ${"op_dr_p".$i."_phone"},
                "pmail" => ${"op_dr_p".$i."_email"}
            );
            
            $procedure_params_participants = array(
                array(&$myparams_participants['fname'], SQLSRV_PARAM_IN),
                array(&$myparams_participants['lname'], SQLSRV_PARAM_IN),
                array(&$myparams_participants['DOB'], SQLSRV_PARAM_IN),
                array(&$myparams_participants['phone'], SQLSRV_PARAM_IN),
                array(&$myparams_participants['pmail'], SQLSRV_PARAM_IN)
            );
            
            $sql = "EXEC dbo.AddParticipants @fname = ?, @lname = ?, @DOB = ?, @phone = ?, @pmail = ?;";
            $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_participants);
            
            if(!$stmt) {
                $cookievalue = true;
                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured1'); 
                exit();
            }
            
            $query_result = sqlsrv_execute($stmt);
            
            if (!$query_result) {  
                $cookievalue = true."execPART";
                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured2'); 
                exit();  
            }
            
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $created_participants[$i] = $row["participant_id"];
            }
        
            sqlsrv_free_stmt($stmt);

            $myparams_axp = array (
                "a_id" => $created_agreement,
                "p_id" => $created_participants[$i]
            );
            
            $procedure_params_axp = array(
                array(&$myparams_axp['a_id'], SQLSRV_PARAM_IN),
                array(&$myparams_axp['p_id'], SQLSRV_PARAM_IN)
            );
            
            $sql = "EXEC dbo.MatchAgreementAndParticipant @agreement = ?, @participant = ?;";
            $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_axp);
            
            if(!$stmt) {
                $cookievalue = true;
                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured1'); 
                exit();
            }
            
            $query_result = sqlsrv_execute($stmt);
            
            if (!$query_result) {  
                $cookievalue = true."execAGXPART";
                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured2'); 
                exit();  
            }
        
            sqlsrv_free_stmt($stmt);
        }
    }

    $cookievalue = true;
    setcookie("explore_travel_ReservationSuccess", $cookievalue, time()+1, "/");
    header('location: ../index.php');

} else {
    header('location: ../index.php');
    exit();
}