<?php include_once('includes/header.php'); ?>
<script src="js/offer_page.js" defer></script>
    <main class="big_box_flex">
        <div class="size_box_flex">
            <?php
            if (isset($_GET["o"]) && (!empty($_GET["o"]))) {
                $oid = $_GET["o"];
                $sql = "SELECT * FROM LoadOffer($oid);";
                    $stmt = sqlsrv_prepare($conn, $sql);
                
                    if(!$stmt) {
                        $cookievalue = true;
                        setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                        header('location: ../index.php?error=occured'); 
                        exit();
                    }
                    
                    $query_result = sqlsrv_execute($stmt);
                
                    if (!$query_result) {  
                        $cookievalue = true."execEmail";
                        setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                        header('location: ../index.php?error=occured'); 
                        exit();  
                    }
                    
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <div class="offer_page_intro flexbox" style="background-image: url('images/assets/offers/<?php echo $row["main_photo"]; ?>');">
                        <div class="offer_page_intro_info flexbox">
                            <h2 class="offer_page_offer_big_text"><?php echo $row["offer_name"]; ?></h2>
                            <h2 class="offer_page_offer_big_text offer_page_cost">&euro;<?php echo $row["cost"]; ?></h2>
                        </div>
                    </div>
                    <div class="offer_page_description flexbox">
                        <p><?php echo $row["offer_description"]; ?></p>
                    </div>
                    <div class="offer_page_details flexbox">
                        <div class="offer_page_destination_info flexbox">
                            <div class="offer_page_dest_one flexbox">
                                <i class="fa-solid fa-tree-city"></i>
                                <div class="flexbox">
                                    <span>Town/city</span>
                                    <span><?php echo $row["town"]; ?></span>
                                </div>
                            </div>
                            <div class="offer_page_dest_one flexbox">
                                <i class="fa-solid fa-map-location"></i>
                                <div class="flexbox">
                                    <span>Country</span>
                                    <span><?php echo $row["offer_country"]; ?></span>
                                </div>
                            </div>
                            <div class="offer_page_dest_one flexbox">
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
                                <div class="flexbox">
                                    <span>Continent</span>
                                    <span><?php echo $row["offer_continent"]; ?></span>
                                </div>
                            </div>
                            <div class="offer_page_dest_one flexbox">
                                <i class="fa-solid fa-mask-face"></i>
                                <div class="flexbox">
                                    <span>Check current coronavirus restrictions in <?php echo $row["offer_country"]; ?></span>
                                    <span><a href="<?php echo $row["COVID_info"]; ?>" target="_blank">Link <i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="offer_page_flights_x_duration_info flexbox">
                            <div class="offer_page_some_info flexbox">
                                <div class="offer_page_some_left flexbox">
                                    <h2>Time</h2>
                                    <?php echo $row["date_start"]; ?> - <?php echo $row["date_end"]; ?>
                                </div>
                                <div class="offer_page_some_right flexbox">
                                    <?php echo $row["duration"]." ".$row["duration_unit"]; ?>
                                </div>
                            </div>
                            <div class="offer_page_some_info flexbox">
                                <div class="offer_page_some_left flexbox">
                                    <h2>Flights</h2>
                                    <h3>To <?php echo $row["town"]; ?></h3>
                                    <div class="offer_page_row_info flexbox">
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-up"></i>
                                            <div class="flexbox">
                                                <span>Airlines</span>
                                                <span><?php echo $row["airline_start"]; ?></span>
                                            </div>
                                        </div>
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-departure"></i>
                                            <div class="flexbox">
                                                <span>Departure</span>
                                                <span><?php echo $row["airport_start"]; ?></span>
                                            </div>
                                        </div>
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-arrival"></i>
                                            <div class="flexbox">
                                                <span>Arrival</span>
                                                <span><?php echo $row["airport_dest"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>From <?php echo $row["town"]; ?></h3>
                                    <div class="offer_page_row_info flexbox">
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-up"></i>
                                            <div class="flexbox">
                                                <span>Airlines</span>
                                                <span><?php echo $row["airline_back"]; ?></span>
                                            </div>
                                        </div>
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-departure"></i>
                                            <div class="flexbox">
                                                <span>Departure</span>
                                                <span><?php echo $row["airport_back_start"]; ?></span>
                                            </div>
                                        </div>
                                        <div class="offer_page_one_elem flexbox">
                                            <i class="fa-solid fa-plane-arrival"></i>
                                            <div class="flexbox">
                                                <span>Arrival</span>
                                                <span><?php echo $row["airport_back_dest"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offer_page_booking_part <?php if(isset($_SESSION["userId_Email"])) { echo "booking_showing"; } else { echo "booking_message"; }?> flexbox">
                    <?php if(isset($_SESSION["userId_Email"])) { ?>
                        <h2>Book your visit</h2>
                        <div class="offer_booking_ui flexbox">
                            <div class="offer_booking_ui_left flexbox">
                                <div class="offer_booking_ui_left_item flexbox"><i class="fa solid fa-user"></i>You</div>
                                <div class="offer_booking_ui_left_item flexbox"><i class="fa-solid fa-users"></i>Other participants</div>
                                <div class="offer_booking_ui_left_item flexbox"><i class="fa-solid fa-circle-check"></i>Finalizing</div>
                            </div>
                            <div class="offer_booking_ui_right flexbox">
                                <form action="act/act_makeReservation.php" method="post">
                                    <?php
                                    if (isset($_GET["o"]) && (!empty($_GET["o"]))) {
                                        $oid = $_GET["o"];
                                    ?>
                                    <input type="text" name="offer_booking_offer_id" style="display: none;" value="<?php echo $oid; ?>">
                                    <?php
                                    }
                                    ?>
                                    <div class="offer_booking_ui_r_you" style="display: block;">
                                        <?php
                                        $sql = "EXEC dbo.CurrentUserInfo @mail='".$_SESSION["userId_Email"]."'";
                                        $stmt = sqlsrv_prepare($conn, $sql);
                                    
                                        if(!$stmt) {
                                            $cookievalue = true;
                                            setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                                            header('location: ../index.php?error=occured'); 
                                            exit();
                                        }
                                        
                                        $query_result = sqlsrv_execute($stmt);
                                    
                                        if (!$query_result) {  
                                            $cookievalue = true."execEmail";
                                            setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                                            header('location: ../index.php?error=occured'); 
                                            exit();  
                                        }
                                        
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <h3>Personal Data</h3>
                                        <div class="offer_page_booking_display_data_row flexbox">
                                            <span>First name: <span><?php echo $row["first_name"]; ?></span></span>
                                            <span>Last name: <span><?php echo $row["last_name"]; ?></span></span>
                                            <span>Date of Birth: <span><?php echo $row["DOB"]; ?></span></span>
                                        </div> 
                                        <h3>Contact</h3>
                                        <div class="offer_page_booking_display_data_row flexbox">
                                            <span>Phone: <span><?php echo $row["full_phone_number"]; ?></span></span>
                                            <span>E-mail: <span><?php echo $row["acc_email"]; ?></span></span>
                                            <span></span>
                                        </div>
                                        <h3>Address</h3>
                                        <div class="offer_page_booking_display_data_row flexbox">
                                        <?php if($row["is_address_null"] === "NOT") {?>
                                            <span>Country: <span><?php echo $row["country_full_name"]; ?></span></span>
                                            <span>Town: <span><?php echo $row["zip_town"]; ?></span></span>
                                            <span>Street: <span><?php echo $row["street_address"]; ?></span></span>
                                        <?php } ?>
                                        </div>
                                        <?php } ?>
                                        <h3>Are you also a participant?</h3>
                                        <div class="offer_page_booking_display_data_row flexbox">
                                            <span class="q_cp">Will you be participating in this trip?
                                                <span class="q_cp_inputs">
                                                    <input type="radio" name="client_participant" id="client_participant_yes" class="cp_yes" value="1">
                                                    <label for="client_participant_yes">Yes</label>
                                                    <span>/</span>
                                                    <input type="radio" name="client_participant" id="client_participant_no" class="cp_no" value="0">
                                                    <label for="client_participant_no">No</label>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="offer_booking_ui_r_other_participants" style="display: none;">
                                    <h3 class="opq_num">How many participants will attend?</h3>
                                    <div class="offer_page_booking_display_data_row flexbox participants_number_row">
                                        <div class="flexbox ob_op_counter_box">
                                            <button type="button" class="ob_cp_minus"><i class="fa-solid fa-minus"></i></button>
                                            <input type="number" name="offer_booking_other_participants_number" id="offer_booking_other_participants_number" value="0">
                                            <button type="button" class="ob_cp_plus"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <h3 class="other_participatns_data_row">Fill in information about other participants</h3>
                                    <div class="flexbox op_dr_p_any op_dr_p0"></div>
                                    </div>
                                    <div class="offer_booking_ui_r_finalize" style="display: none;">
                                        <h3>Summary</h3>
                                        <div class="offer_page_booking_display_data_row offer_page_booking_display_summary flexbox">
                                            <span class="opb_sum_ayap">Are you a participant? <span class="opb_sum_ayap_answer">YES</span></span>
                                            <span class="opb_sum_hmop">How many other participants will take part in the trip? <span class="opb_sum_hmop_answer">0</span></span>
                                        </div>
                                        <h3>Total</h3>
                                        <div class="offer_page_booking_display_data_row offer_page_booking_display_summary flexbox">
                                            <span class="opb_sum_total">Your total is &euro;<span class="opb_sum_total_answer"></span></span>
                                        </div>
                                        <h3>Choose payment method</h3>
                                        <div class="offer_page_booking_display_data_row offer_page_booking_payments_box flexbox">
                                            <?php
                                            $sql = "SELECT * FROM Payment_handlers;";
                                            $stmt = sqlsrv_prepare($conn, $sql);
                                        
                                            if(!$stmt) {
                                                $cookievalue = true;
                                                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                                                header('location: ../index.php?error=occured'); 
                                                exit();
                                            }
                                            
                                            $query_result = sqlsrv_execute($stmt);
                                        
                                            if (!$query_result) {  
                                                $cookievalue = true."execEmail";
                                                setcookie("explore_travel_OfferPage[dbFailure]", $cookievalue, time()+1, "/");
                                                header('location: ../index.php?error=occured'); 
                                                exit();  
                                            }
                                            
                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                                <label for="offer_booking_payment_method_<?php echo $row["handler_short"]; ?>">
                                                    <div class="offer_booking_payment_left">
                                                        <input type="radio" id="offer_booking_payment_method_<?php echo $row["handler_short"]; ?>" name="offer_booking_payment_method" value="<?php echo $row["payment_handler_id"];?>" required>
                                                        <span class="offer_page_booking_payment_image">
                                                            <?php if($row["handler_logo"] != null) { ?>
                                                                <img src="images/payments/<?php echo $row["handler_logo"]; ?>" alt="<?php echo $row["handler_name"]; ?> - logo">
                                                            <?php } else if($row["handler_logo"] == null) {  ?>
                                                                <i class="<?php echo $row["handler_font_awesome"]; ?>"></i>
                                                            <?php } ?>
                                                        </span>
                                                        <span class="offer_page_booking_payment_name"><?php echo $row["handler_name"]; ?></span>
                                                    </div>
                                                    <div class="offer_booking_payment_right"></div>
                                                </label>
                                            <?php } ?>
                                        </div>
                                        <div class="offer_page_booking_display_data_row offer_page_booking_display_button_row flexbox">
                                            <button name="explore_form_make_reservation">Make a reservation</button>
                                        </div>
                                    </div>
                                    <div class="offer_booking_ui_arrows flexbox">
                                        <i class="fa-solid fa-chevron-left offer_booking_ui_arrow__left"></i>
                                        <i class="fa-solid fa-chevron-right offer_booking_ui_arrow__right"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h2>In order to book this offer you need to log in or sign up with us, you can do this at the very top of this page</h2>
                    <?php } ?>
                    </div>
                    <?php
                    }
                    sqlsrv_free_stmt($stmt);
            ?>
            <?php
            } else {
                header('location: 404.php');
            }
            ?>
        </div>
    </main>
<?php include_once('includes/footer.php'); ?>