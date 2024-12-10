<?php
    include_once('includes/header.php');
    if(isset($_SESSION["userId_Email"])) {
    ?>
    <main class="big_box_flex">
        <h3>You already have an account, you cannot create a new one</h3>
    </main>
    <?php
    } else {
?>
<script src="js/signUpPage.js" defer></script>
    <main class="big_box_flex">
        <div class="size_box_flex sbf_left">
            <h2>Sign Up</h2>
            <form action="act/act_signup.php" method="POST" name="register_form" class="register_form">
                <h3>Personal information</h3>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_first_name" class="label_required">First Name</label>
                        <input type="text" name="reg_first_name" id="reg_first_name" autocomplete="given-name">
                    </div>
                    <div class="flexbox register_input_description reg_first_name_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_last_name" class="label_required">Last Name</label>
                        <input type="text" name="reg_last_name" id="reg_last_name" autocomplete="family-name">
                    </div>
                    <div class="flexbox register_input_description reg_last_name_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_DOB" class="label_required">Date of birth</label>
                        <input type="date" name="reg_DOB" id="reg_DOB" autocomplete="bday">
                    </div>
                    <div class="flexbox register_input_description reg_DOB_i_d">
                        You need to be at least 18 years old to sign up with us
                    </div>
                </div>
                <h3>Address</h3>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_street_address">Street</label>
                        <input type="text" name="reg_street_address" id="reg_street_address" autocomplete="street-address">
                    </div>
                    <div class="flexbox register_input_description reg_street_address_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_zip_code">Zip Code</label>
                        <input type="text" name="reg_zip_code" id="reg_zip_code" autocomplete="postal-code">
                    </div>
                    <div class="flexbox register_input_description reg_zip_code_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_city">Town</label>
                        <input type="text" name="reg_city" id="reg_city" autocomplete="address-level2">
                    </div>
                    <div class="flexbox register_input_description reg_city_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section register_input_select">
                        <label for="reg_country">Country</label>
                        <select name="reg_country" id="reg_country">
                        <?php
                        $sql = "SELECT country_id, country_full_name FROM Countries ORDER BY country_full_name ASC";
                        $stmt = sqlsrv_query($conn, $sql);

                        while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
                            ?>
                            <option value="<?php echo $row["country_id"]; ?>"><?php echo $row["country_full_name"]; ?></option>
                            <?php
                            } ?>
                        </select>
                        <div class="select_arrow"><i class="fa-solid fa-angle-down"></i></div>
                    </div>
                    <div class="flexbox register_input_description reg_country_i_d">
                        
                    </div>
                    <?php
                        sqlsrv_free_stmt($stmt);
                    ?>
                </div>
                <h3>Contact</h3>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_email" class="label_required">E-mail</label>
                        <input type="email" name="reg_email" id="reg_email" autocomplete="email">
                    </div>
                    <div class="flexbox register_input_description reg_email_i_d">
                    
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section register_input_select">
                        <label for="reg_phone_prefix" class="label_required">Phone number prefix</label>
                        <select name="reg_phone_prefix" id="reg_phone_prefix">
                        <?php
                        $sql = "SELECT country_id, country_full_name, country_dial FROM Countries WHERE country_dial IS NOT NULL ORDER BY country_dial ASC";
                        $stmt = sqlsrv_query($conn, $sql);

                        while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
                            ?>
                            <option value="<?php echo $row["country_id"]; ?>" data-explore-dial-country="<?php echo $row["country_id"]; ?>">+<?php echo $row["country_dial"]; ?> (<?php echo $row["country_full_name"]; ?>)</option>
                            <?php
                            } ?>
                        </select>
                        <div class="select_arrow"><i class="fa-solid fa-angle-down"></i></div>
                    </div>
                    <div class="flexbox register_input_description reg_phone_prefix_i_d">
                        Your country dial code, list is arranged by dial code in ascending order
                    </div>
                    <?php
                        sqlsrv_free_stmt($stmt);
                    ?>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_phone" class="label_required">Phone number</label>
                        <input type="tel" name="reg_phone" id="reg_phone" autocomplete="tel">
                    </div>
                    <div class="flexbox register_input_description reg_phone_id">
                        Please enter your phone number without spaces and special characters
                    </div>
                </div>
                <h3>Password</h3>
                <div class="flexbox register_row reg_password_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_password" class="label_required">Password</label>
                        <input type="password" name="reg_password" id="reg_password">
                    </div>
                    <div class="flexbox register_input_description reg_password_i_d">
                        Create a strong password:
                        <ul role="list">
                            <li>it should consists of 8 to 56 characters</li>
                            <li>include at least one digit</li>
                            <li>include at least one lowercase letter</li>
                            <li>include at least one uppercase letter</li>
                            <li>include at least one special character (!&nbsp;-&nbsp;@&nbsp;#&nbsp;$&nbsp;%&nbsp;^&nbsp;&&nbsp;(&nbsp;)&nbsp;*)</li>
                        </ul>
                    </div>
                </div>
                <div class="flexbox register_row">
                    <div class="flexbox register_input_section">
                        <label for="reg_password_repeat" class="label_required">Repeat password</label>
                        <input type="password" name="reg_password_repeat" id="reg_password_repeat">
                    </div>
                    <div class="flexbox register_input_description reg_password_repeat_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row register_checkbox_row">
                    <div class="flexbox register_input_section">
                        <input type="checkbox" name="reg_terms" id="reg_terms">
                        <label for="reg_terms" class="label_required">I have read, understand and agree to Explore's <a href="#">Privacy Policy</a> and <a href="#">Terms of Use</a></label>
                    </div>
                    <div class="flexbox register_input_description reg_password_repeat_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row register_checkbox_row">
                    <div class="flexbox register_input_section register_required_note">
                        <ul>
                            <li>- required</li>
                        </ul>
                    </div>
                    <div class="flexbox register_input_description reg_password_repeat_i_d">
                        
                    </div>
                </div>
                <div class="flexbox register_row register_button_row">
                    <button name="explore_form_register_new">Join Explore Club</button>
                </div>
            </form>
        </div>
    </main>
<?php
    } 
    include_once('includes/footer.php');
?>