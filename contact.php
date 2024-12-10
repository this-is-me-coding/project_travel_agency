<?php
    include_once('includes/header.php');
?>
    <main class="big_box_flex">
        <div class="size_box_flex sbf_left">
            <h2>Contact</h2>
            <div class="contact flexbox">
                <div class="contact_content flexbox">
                    <?php
                        $sql = "SELECT * FROM Company_info_full_view";
                        $stmt = sqlsrv_query($conn, $sql);

                        while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
                    ?>
                    <?php echo $row['company_info_name']; ?>
                    <span class="flexbox">
                        <i class="fa-solid fa-location-dot"></i>
                        <?php echo $row['company_info_address']."<br>".$row['country_full_name']."<br />"; ?>
                    </span>
                    <span class="flexbox">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:<?php echo $row['company_info_full_phone']; ?>"><?php echo $row['company_info_full_phone']; ?></a>
                    </span>
                    <span class="flexbox">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:<?php echo $row['company_info_email']; ?>"><?php echo $row['company_info_email']; ?></a>
                    </span>
                </div>
                <div class="contact_right">
                    <iframe src="<?php echo $row["company_info_maps_link"];?>"
                    class="embeded_map" allowfullscreen=""></iframe>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </main>
<?php include_once('includes/footer.php'); ?>