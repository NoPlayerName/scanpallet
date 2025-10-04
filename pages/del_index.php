<?php 

include('../koneksi.php');

$id = $_POST['id'];

$sql2 = "select idpallet FROM tblmasuk WHERE id=".$id;
  $result2 = sqlsrv_query($conn, $sql2); 
  
  while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) 
{
	$pallet=$row2['idpallet'];
		
}
$mysql = "UPDATE pallet set produk = null WHERE nopallet=".$pallet." and aktif=1";
$mysqlconn->query($mysql);

// Delete record
$query = "DELETE FROM tblmasuk WHERE id=".$id;
sqlsrv_query( $conn, $query); 


echo 1;