<?php include_once('includes/header.php'); ?>
    <main class="big_box_flex">
        <div class="size_box_flex">
            <div class="offers_homepage flexbox">
                <?php
                    $sql = "EXEC dbo.HomepageOffers";
                    $stmt = sqlsrv_prepare($conn, $sql);
                
                    if(!$stmt) {
                        $cookievalue = true."prepHomePageOffers";
                        setcookie("explore_travel_HomePageOffers[dbFailure]", $cookievalue, time()+1, "/");
                        header('location: ../index.php?error=occured1'); 
                        exit();
                    }
                    
                    $query_result = sqlsrv_execute($stmt);
                
                    if (!$query_result) {  
                        $cookievalue = true."execEmail";
                        setcookie("explore_travel_HomePageOffers[dbFailure]", $cookievalue, time()+1, "/");
                        header('location: ../index.php?error=occured2'); 
                        exit();  
                    }
                    
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <a href="offer_page.php?o=<?php echo $row["offer_id"]; ?>" class="single_offer_show_link flexbox" style="background-image: url('images/assets/offers/<?php echo $row["main_photo"]; ?>');">
                    <div class="single_offer_show flexbox">
                        <h2 class="single_offer_name"><?php echo $row["offer_name"]; ?></h2>
                        <h2 class="single_offer_price">&euro;<?php echo $row["cost"]; ?></h2>
                    </div>
                    </a>
                    <?php
                    }
                    sqlsrv_free_stmt($stmt);
                ?>
            </div>
        </div>
    </main>
<?php include_once('includes/footer.php'); ?>