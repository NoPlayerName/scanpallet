<?php
$partno = '8944552852';
$norak = '';
$norak1 = '';
$norak2 = '';
$norak3 = '';
$norak4 = '';
$norak5 = '';
$norak6 = '';
$norak7 = '';
$norak8 = '';

require_once("../koneksi.php");

$sql1 = "select norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref
		from tblrak
		where partno = '$partno'
		group by norak, partno, kodeproduk, ket
		order by norak desc";
$resultsql1 = sqlsrv_query( $conn, $sql1); 
  
while ($sql1 = sqlsrv_fetch_array($resultsql1, SQLSRV_FETCH_ASSOC)) 
{
	$norak=$sql1['norak'];
	$partno=$sql1['partno'];
	$kodeproduk=$sql1['kodeproduk'];
	$norakref=$sql1['norakref'];
	$ket=$sql1['ket'];
}
	
$def1 = "if exists(select * from tblrak 
		 where left(norak, 2) = (select golrak.def1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
			  and ket = '0')
		 begin
			 select norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+5) as norakref
			 from tblrak 
			 where left(norak, 2) = (select golrak.def1
									from tblproduk
									left join golrak on tblproduk.gol = golrak.gol
									where tblproduk.partno = '$partno')
				  and ket = '0'
			group by norak, partno, kodeproduk, ket
			order by norak asc
		 end";
$resultdef1 = sqlsrv_query( $conn, $def1); 
  
while ($def1 = sqlsrv_fetch_array($resultdef1, SQLSRV_FETCH_ASSOC)) 
{
	$norak1=$def1['norak'];
	$partno1=$def1['partno'];
	$kodeproduk1=$def1['kodeproduk'];
	$ket1=$def1['ket'];
}

$def2 = "select * from tblrak 
		where left(norak, 2) = (select golrak.def2
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')order by norak desc";
$resultdef2 = sqlsrv_query( $conn, $def2); 
  
while ($def2 = sqlsrv_fetch_array($resultdef2, SQLSRV_FETCH_ASSOC)) 
{
	$norak2=$def2['norak'];
	$partno2=$def2['partno'];
	$kodeproduk2=$def2['kodeproduk'];
	$ket2=$def2['ket'];
}

$def3 = "select * from tblrak 
		where left(norak, 2) = (select golrak.def3
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')order by norak desc";
$resultdef3 = sqlsrv_query( $conn, $def3); 
  
while ($def3 = sqlsrv_fetch_array($resultdef3, SQLSRV_FETCH_ASSOC)) 
{
	$norak3=$def3['norak'];
	$partno3=$def3['partno'];
	$kodeproduk3=$def3['kodeproduk'];
	$ket3=$def3['ket'];
}

$def4 = "select * from tblrak 
		where left(norak, 2) = (select golrak.def4
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')order by norak desc";
$resultdef4 = sqlsrv_query( $conn, $def4); 
  
while ($def4 = sqlsrv_fetch_array($resultdef4, SQLSRV_FETCH_ASSOC)) 
{
	$norak4=$def4['norak'];
	$partno4=$def4['partno'];
	$kodeproduk4=$def4['kodeproduk'];
	$ket4=$def4['ket'];
}

$def5 = "select * from tblrak 
		where left(norak, 2) = (select golrak.def5
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
				and ket = '1'
				order by norak desc";
$resultdef5 = sqlsrv_query( $conn, $def5); 
  
while ($def5 = sqlsrv_fetch_array($resultdef5, SQLSRV_FETCH_ASSOC)) 
{
	$norak5=$def5['norak'];
	$partno5=$def5['partno'];
	$kodeproduk5=$def5['kodeproduk'];
	$ket5=$def5['ket'];
}

$def6 = "select * from tblrak 
		where left(norak, 2) = (select golrak.def6
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')order by norak desc";
$resultdef6 = sqlsrv_query( $conn, $def6); 
  
while ($def6 = sqlsrv_fetch_array($resultdef6, SQLSRV_FETCH_ASSOC)) 
{
	$norak6=$def6['norak'];
	$partno6=$def6['partno'];
	$kodeproduk6=$def6['kodeproduk'];
	$ket6=$def6['ket'];
}

$opsi1 = "select * from tblrak 
		where left(norak, 2) = (select golrak.opsi1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')order by norak desc";
$resultopsi1 = sqlsrv_query( $conn, $opsi1); 
  
while ($opsi1 = sqlsrv_fetch_array($resultopsi1, SQLSRV_FETCH_ASSOC)) 
{
	$norak7=$opsi1['norak'];
	$partno7=$opsi1['partno'];
	$kodeproduk7=$opsi1['kodeproduk'];
	$ket7=$opsi1['ket'];
}

$opsi2 = "select * from tblrak 
		where left(norak, 2) = (select golrak.opsi2
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '8981034503')order by norak desc";
$resultdef1 = sqlsrv_query( $conn, $opsi2); 
  
while ($opsi2 = sqlsrv_fetch_array($resultdef1, SQLSRV_FETCH_ASSOC)) 
{
	$norak8=$opsi2['norak'];
	$partno8=$opsi2['partno'];
	$kodeproduk8=$opsi2['kodeproduk'];
	$ket8=$opsi2['ket'];
}

if ($norak != ''){
	echo $norak;
}elseif ($norak1 != ''){
	echo $norak1;
	echo $partno1;
	
	$refrak = "select count(partno)total, partno,5-count(partno)tambah from tblrak where left(norak,2) = (select golrak.def1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno') and ket = '0'
								group by partno";
	$resultrefrak = sqlsrv_query( $conn, $refrak); 
	  
	while ($refrak = sqlsrv_fetch_array($resultrefrak, SQLSRV_FETCH_ASSOC)) 
	{
		$total=$refrak['total'];
		$partnor=$refrak['partno'];
		$tambah=$refrak['tambah'];
	}
	
	$refrak2 = "select * from tblrak where partno = '$partnor' order by id asc";
	$resultrefrak2 = sqlsrv_query( $conn, $refrak2); 
	  
	while ($refrak2 = sqlsrv_fetch_array($resultrefrak2, SQLSRV_FETCH_ASSOC)) 
	{
		$norakr2=$refrak2['norak'];
		$partnor2=$refrak2['partno'];
		$kodeprodukr2=$refrak2['kodeproduk'];
		$ketr2=$refrak2['ket'];
	}
	
	echo "</br>";
	echo $total.'; '.$partnor.'; '.$tambah.'; '.$norakr2;
	echo "</br>";echo "</br>";
	if ($tambah == 0){
		echo substr($norakr2,0,1).(5+substr($norakr2,1)+$tambah);
	}elseif ($total > $tambah){
		echo substr($norakr2,0,1).(substr($norakr2,1)+$tambah);
	}
}elseif ($norak2 != ''){
	echo $norak2;
}elseif ($norak3 != ''){
	echo $norak3;
}elseif ($norak4 != ''){
	echo $norak4;
}elseif ($norak5 != ''){
	echo $norak5;
}elseif ($norak6 != ''){
	echo $norak6;
}elseif ($norak7 != ''){
	echo $norak7;
}elseif ($norak8 != ''){
	echo $norak8;
}
?>