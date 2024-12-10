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
        <div class="size_box_flex sbf_left my_trips_box">
            <h3>My trips</h3>
            <h3>Upcoming trips</h3>
            <?php
            $procedure_params_offers = array(
                array(&$_SESSION["userId_Email"], SQLSRV_PARAM_IN),
                array("upcoming", SQLSRV_PARAM_IN),
            );
            
            $sql = "EXEC dbo.AllOffersBookedByCurrentUser @mail = ?, @set_in_time = ?;";
            $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_offers);
            
            if(!$stmt) {
                $cookievalue = true;
                setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured1'); 
                exit();
            }
            
            $query_result = sqlsrv_execute($stmt);
            
            if (!$query_result) {  
                $cookievalue = true."execAGREEMENT";
                setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured2'); 
                exit();  
            }
            
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
               <div class="my_trips_card flexbox">
                   <div class="my_trips_card_basic_info flexbox">
                       <h2 class="my_trips_card_trip_name"><?php echo $row["offer_name"]; ?> <a href="offer_page.php?o=<?php echo $row["offer_id"]; ?>"><i class="fa-solid fa-up-right-from-square"></i></a></h2>
                       <span><?php echo $row["date_start"]; ?> - <?php echo $row["date_end"]; ?></span>
                       <span class="my_trips_location_info flexbox">
                            <span>
                            <?php if($row["offer_continent_iso"] === "EU") {?>
                                <i class="fa-solid fa-earth-europe"></i>
                            <?php } else if($row["offer_continent_iso"] === "NA" || $row["offer_continent_iso"] === "SA") { ?>
                                <i class="fa-solid fa-earth-americas"></i>
                            <?php } else if($row["offer_continent_iso"] === "AF") { ?>
                                <i class="fa-solid fa-earth-africa"></i>
                            <?php } else if($row["offer_continent_iso"] === "AS") { ?>
                                <i class="fa-solid fa-earth-asia"></i>
                            <?php } else if($row["offer_continent_iso"] === "OC") { ?>
                                <i class="fa-solid fa-earth-oceania"></i>
                            <?php } else { ?>
                                <i class="fa-solid fa-earth-europe"></i>
                            <?php } ?>
                            <?php echo $row["continent_name"]; ?>
                            </span>
                            <span><i class="fa-solid fa-map-location"></i><?php echo $row["country_full_name"]; ?></span>  
                        </span>
                        <h2>Total &euro;<?php echo $row["deposit"]; ?></h2>
                    </div>
                    <div class="my_trips_card_info_2 flexbox">
                        <span>Reservation id: <span><?php echo $row["agreement_id"]; ?></span></span>
                        <span>Are you participating? <span><?php echo $row["client_is_a_participant_x"]; ?></span></span>
                        <span>Other particpants: <span><?php echo $row["counted"]; ?></span></span>
                        <span>Payment method: <span><?php echo $row["handler_name"]; ?></span></span>
                   </div>
               </div>
            <?php }
        
            sqlsrv_free_stmt($stmt);
            ?>
            <h3>Past trips</h3>
            <?php
            $procedure_params_offers = array(
                array(&$_SESSION["userId_Email"], SQLSRV_PARAM_IN),
                array("past", SQLSRV_PARAM_IN),
            );
            
            $sql = "EXEC dbo.AllOffersBookedByCurrentUser @mail = ?, @set_in_time = ?;";
            $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_offers);
            
            if(!$stmt) {
                $cookievalue = true;
                setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured1'); 
                exit();
            }
            
            $query_result = sqlsrv_execute($stmt);
            
            if (!$query_result) {  
                $cookievalue = true."execAGREEMENT";
                setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                header('location: ../index.php?error=occured2'); 
                exit();  
            }
            
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
               <div class="my_trips_card flexbox">
               <div class="my_trips_card_basic_info flexbox">
                       <h2 class="my_trips_card_trip_name"><?php echo $row["offer_name"]; ?> <a href="offer_page.php?o=<?php echo $row["offer_id"]; ?>"><i class="fa-solid fa-up-right-from-square"></i></a></h2>
                       <span><?php echo $row["date_start"]; ?> - <?php echo $row["date_end"]; ?></span>
                       <span class="my_trips_location_info flexbox">
                            <span>
                            <?php if($row["offer_continent_iso"] === "EU") {?>
                                <i class="fa-solid fa-earth-europe"></i>
                            <?php } else if($row["offer_continent_iso"] === "NA" || $row["offer_continent_iso"] === "SA") { ?>
                                <i class="fa-solid fa-earth-americas"></i>
                            <?php } else if($row["offer_continent_iso"] === "AF") { ?>
                                <i class="fa-solid fa-earth-africa"></i>
                            <?php } else if($row["offer_continent_iso"] === "AS") { ?>
                                <i class="fa-solid fa-earth-asia"></i>
                            <?php } else if($row["offer_continent_iso"] === "OC") { ?>
                                <i class="fa-solid fa-earth-oceania"></i>
                            <?php } else { ?>
                                <i class="fa-solid fa-earth-europe"></i>
                            <?php } ?>
                            <?php echo $row["continent_name"]; ?>
                            </span>
                            <span><i class="fa-solid fa-map-location"></i><?php echo $row["country_full_name"]; ?></span>  
                        </span>
                        <h2>Total &euro;<?php echo $row["deposit"]; ?></h2>
                    </div>
                    <div class="my_trips_card_info_2 flexbox">
                        <span>Reservation id: <span><?php echo $row["agreement_id"]; ?></span></span>
                        <span>Are you participating? <span><?php echo $row["client_is_a_participant_x"]; ?></span></span>
                        <span>Other particpants: <span><?php echo $row["counted"]; ?></span></span>
                        <span>Payment method: <span><?php echo $row["handler_name"]; ?></span></span>
                   </div>
               </div>
            <?php }
        
            sqlsrv_free_stmt($stmt);
            ?>
        </div>
    </main>
<?php
    } 
    include_once('includes/footer.php');
?>