<?php
    $serverName = "localhost";
    $connectionOptions = array(
        "database" => "travel_agency_explore",
        "uid" => "sa",
        "pwd" => "zaq1@WSX",
        "CharacterSet" => "UTF-8",
        "TrustServerCertificate" => "Yes",
        'ReturnDatesAsStrings'=>true
    );
    $conn = sqlsrv_connect( $serverName, $connectionOptions);