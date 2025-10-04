<?php
// $mysqlservername = "10.63.0.3";
// $mysqlusername = "aicc-db";
// $mysqlpassword = "31041CcP@ssw0rd#";
// $mysqldbname = "palletdb";
// $mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
// $serverName = "10.63.0.3\LMA0003"; //serverName\instanceName
// $connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"RTO33*ap");
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $mysqlconn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }


// $mysqlservername = "localhost";
// $mysqlusername = "aicc-db";
// $mysqlpassword = "C0mbr0P3d45!";
// $mysqldbname = "palletdb";
// $mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
// $serverName = "GPG0100\SQLEXPRESS,1433";
// $connectionOptions = array(
//      "Database" => "fg",
//      "Uid"      => "sa",
//      "PWD"      => "C0mbr0P3d45!",
//      "encrypt"  => false,
//      "TrustServerCertificate" => true
// );

// $conn = sqlsrv_connect($serverName, $connectionOptions);
// if (!$conn) {
//      die("koneksi gagal:" . print_r(sqlsrv_errors(), true));
// }

// === Koneksi ke MySQL ===
$mysqlservername = "localhost";
$mysqlusername   = "aicc-fgms";
$mysqlpassword   = "C0mbr0P3d45!";
$mysqldbname     = "aicc-ppic";

$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);

if ($mysqlconn->connect_error) {
     die("Koneksi MySQL gagal: " . $mysqlconn->connect_error);
}
// echo "Koneksi MySQL berhasil<br>";


// === Koneksi ke SQL Server ===
$serverName = "GPG0217\SQLEXPRESS,1433";
$connectionOptions = array(
     "Database" => "fg",
     "Uid"      => "sa",
     "PWD"      => "C0mbr0P3d45!",
     "encrypt"  => false,
     "TrustServerCertificate" => true
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
     die("Koneksi SQL Server gagal:" . print_r(sqlsrv_errors(), true));
}
// echo "Koneksi SQL Server berhasil<br>";
