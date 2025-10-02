<?php
$norak='';
/* $partno = '42411EW011'; */
require_once("../koneksi.php");

if (isset($_POST['nopall'])){
$partno = $_POST['nopall'];
$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
		 where left(norak, 2) = (select golrak.def1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
		and ket = '1'
		group by norak, partno, kodeproduk, ket
		order by norak asc";
$resultdef = sqlsrv_query( $conn, $def); 
  
while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) 
{
	$norak=$def['norak'];
	$partno=$def['partno'];
	$kodeproduk=$def['kodeproduk'];
	$norakref=$def['kodeproduk'];
	$ket=$def['ket'];
}

$deo=2;
while ($norak=='' and $deo<8)
{
	$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
		 where left(norak, 2) = (select golrak.def$deo
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
		and ket = '1'
		group by norak, partno, kodeproduk, ket
		order by norak asc";
	$resultdef = sqlsrv_query( $conn, $def); 
	  
	while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) 
	{
		$norak=$def['norak'];
		$partno=$def['partno'];
		$kodeproduk=$def['kodeproduk'];
		$norakref=$def['kodeproduk'];
		$ket=$def['ket'];
	}
	$deo=$deo+1;
}

while ($norak=='' and $deo>7 and $deo<10)
{
	$opsi=$deo-7;
	$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
		 where left(norak, 2) = (select golrak.opsi$opsi
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
		and ket = '1'
		group by norak, partno, kodeproduk, ket
		order by norak asc";
	$resultdef = sqlsrv_query( $conn, $def); 
	  
	while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) 
	{
		$norak=$def['norak'];
		$partno=$def['partno'];
		$kodeproduk=$def['kodeproduk'];
		$norakref=$def['kodeproduk'];
		$ket=$def['ket'];
	}
	$deo=$deo+1;
}


/* $x1=1;
while ($x1<5)
{
echo "Increment Number : $x1 <br />";
echo "Hello World <br />";
$x1=$x1+1;
} */

//echo $norak;
/* echo"<script language='javascript'>document.getElementById('tbl').value = '$tbl';</script>"; */

//final
/* if ($norak == ''){
	echo"<script language='javascript'>document.getElementById('refrak').value = 'LR';</script>";
}
else{
	echo"<script language='javascript'>document.getElementById('refrak').value = '$norak';</script>";
} */

if ($norak == ''){
	echo "LR";
}
else{
	echo $norak;
}
}
?>