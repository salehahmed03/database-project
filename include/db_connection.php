<?php
$serverName = "DESKTOP-BUS0U02";
$connectionInfo = array( "Database"=>"ZooDBMS");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>