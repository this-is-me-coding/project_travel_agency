<?php
//Including Database configuration file.
include "db.php";
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_POST['search'];
//Search query.
   $Query = "SELECT offer_name FROM Offers WHERE offer_name LIKE '%$Name%' ORDER BY offer_name ASC
   OFFSET 0 ROWS 
   FETCH NEXT 5 ROWS ONLY";
//Query execution
   $ExecQuery = sqlsrv_query($con, $Query);
//Creating unordered list to display result.
   echo '
<ul>
   ';
   //Fetching result from database.
   while ($Result = sqlsrv_fetch_array($ExecQuery, SQLSRV_FETCH_ASSOC)) {
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick="fill('<?php echo $Result['offer_name']; ?>')">
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
       <?php echo $Result['offer_name']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>