<?php
    include_once('includes/header.php');
    if(!isset($_GET["page"])) {
        header('location: offers.php?page=1');
    } else if (isset($_GET["page"])) {
        $page_displaying = $_GET["page"];
    }

    if(!isset($_GET["date_start"])) {
        $date_start = "NOT_SET";
    } else if (isset($_GET["date_start"])) {
        $date_start = $_GET["date_start"];
    }

    if(!isset($_GET["date_end"])) {
        $date_end = "NOT_SET";
    } else if (isset($_GET["date_end"])) {
        $date_end = $_GET["date_end"];
    }

    $limit = 20;
    
    $procedure_params_offers = array(
        array(&$limit, SQLSRV_PARAM_IN),
    );
    
    $sql = "EXEC dbo.HowManyPagesForOffers @limit = ?;";
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
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $max_pages = $row["max_pages"];
    }

    sqlsrv_free_stmt($stmt);

    if($page_displaying>$max_pages) {
        header('location: offers.php?page='.$max_pages);
    } else if ($page_displaying<=0) {
        header('location: offers.php?page=1');
    }
?>
<script src="js/offers_all.js" defer></script>
    <main class="big_box_flex">
        <div class="size_box_flex offers_all_box">
            <div class="offers_all_left_pane_filters flexbox">
                <h3>Filters</h3>
                <form action="" method="GET" class="flexbox">
                    <span class="flexbox">
                        <span>Start date: </span>
                        <input type="date" name="start_date" id="f_start_date">
                    </span>
                    <span class="flexbox">
                        <span>End date: </span>
                        <input type="date" name="end_date" id="f_end_date">
                    </span>
                    <span class="flexbox">
                        <button>Filter</button>
                    </span>
                </form>
            </div>
            <div class="offers_all_right_pane_offers flexbox">
                <h3>Offers</h3>
                <?php
                $procedure_params_offers_by_page = array(
                    array(&$page_displaying, SQLSRV_PARAM_IN),
                    array(&$limit, SQLSRV_PARAM_IN)
                );

                $sql = "EXEC dbo.LoadOffersByPage @page = ?, @limit = ?;";
                $stmt = sqlsrv_prepare($conn, $sql, $procedure_params_offers_by_page);
            
                if(!$stmt) {
                    $cookievalue = true."prepAllOffers";
                    setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                    header('location: ../index.php?error=occured'); 
                    exit();
                }
                
                $query_result = sqlsrv_execute($stmt);
            
                if (!$query_result) {  
                    $cookievalue = true."execEmail";
                    setcookie("explore_travel_Offers[dbFailure]", $cookievalue, time()+1, "/");
                    header('location: ../index.php?error=occured'); 
                    exit();  
                }
                
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                    <a class="offers_all_single_offer_box flexbox" href="offer_page.php?o=<?php echo $row["offer_id"]; ?>">
                        <div class="offers_all_single_offer_left_image" style="background-image: url('images/assets/offers/<?php echo $row["main_photo"]; ?>');">
                        </div>
                        <div class="offers_all_single_offer_right_pane flexbox">
                            <div class="offers_all_single_offer_right_pane_name flexbox">
                                <h2><?php echo $row["offer_name"]; ?></h2>
                            </div>
                            <div class="offers_all_single_offer_right_pane_location_info_row flexbox">
                                <span><i class="fa-solid fa-map-location"></i><?php echo $row["offer_country"]; ?></span>
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
                                <?php echo $row["offer_continent"]; ?>
                                </span>
                            </div>
                            <div class="offers_all_single_offer_right_pane_description_row">
                                <?php echo $row["offer_description"]; ?>
                            </div>
                            <div class="offers_all_single_offer_right_pane_cost flexbox">
                                <h2>&euro;<?php echo $row["cost"]; ?></h2>
                            </div>
                        </div>
                    </a>
                <?php
                ?>
                <?php
                }

                sqlsrv_free_stmt($stmt);
                ?>
                <div class="pages_nav_offers flexbox">
                    <div>
                        Page <?php echo $page_displaying; ?> of <span data-explore-max-pages><?php echo $max_pages; ?></span>
                    </div>
                    <div class="offers_all_arrows flexbox">
                        <i class="fa-solid fa-chevron-left offers_all_arrow_left"></i>
                        <i class="fa-solid fa-chevron-right offers_all_arrow_right"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include_once('includes/footer.php'); ?>