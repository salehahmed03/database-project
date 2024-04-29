<?php
$serverName = "DESKTOP-HN84Q47";
$connectionInfo = array( "Database"=>"ZooDBMS", "TrustServerCertificate"=>"true");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>