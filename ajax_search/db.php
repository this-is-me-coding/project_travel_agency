<?php
$serverName = "192.168.0.199";
$connectionOptions = array(
    "database" => "travel_agency",
    "uid" => "sa",
    "pwd" => "zaq1@WSX",
    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => "Yes",
    'ReturnDatesAsStrings'=>true
);
$con = sqlsrv_connect( $serverName, $connectionOptions);
//Database connection.
// $con = MySQLi_connect(
//    "localhost", //Server host name.
//    "root", //Database username.
//    "", //Database password.
//    "autocomplete" //Database name or anything you would like to call it.
// );
// //Check connection
// if (MySQLi_connect_errno()) {
//    echo "Failed to connect to MySQL: " . MySQLi_connect_error();
// }
?>