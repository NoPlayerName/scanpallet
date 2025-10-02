<?php
$norak='';
$tbl='';
//memasukkan koneksi database
require_once("../koneksi.php");

//jika berhasil/ada post['noprs']

if (isset($_POST['partno'])){
	
  $sql = "SELECT partno, partname, stdpacking, kodeproduk, ket from produkaktif where partno = '$_POST[partno]'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partnoa=$row['partno'];
	$partnamea=$row['partname'];
	$snp=$row['stdpacking'];
	$kett=$row['ket'];
	$kp=$row['kodeproduk'];
//echo $partnoa;
//echo "<br />";
echo "<body onload='form2.nopall.focus()'>";
if ($partnoa == "MC075508" ) {
$msgc="<h3 style='color:blue;'>$kp dan DIFF CASE M002</h3>";
echo $msgc;
echo"<script language='javascript'>$('#nopall').focus();</script>";
}else{
$msgc="<h3 style='color:blue;'>$kp</h3>";
echo $msgc;
echo"<script language='javascript'>$('#nopall').focus();</script>";
}
}
if ($result) {
   $rowsa = sqlsrv_has_rows( $result );
   if ($rowsa === false){
        $msgmy="<h2 style='color:red;'>Part No tidak Aktif/Terdaftar..Pastikan Part No sudah diaktifkan!</h2>";
		echo $msgmy;
		$_POST['partno'] = "";
	echo"<script language='javascript'>$('#partno').focus();document.getElementById('partno').value = '';</script>";
	}
}
}



if (isset($_POST['nopall'])){
$partno = $_POST['nopall'];
$sql = "IF EXISTS (SELECT * FROM tblrak WHERE partno = '$partno' and ket = 1) 
				BEGIN
				   SELECT id, partno, kodeproduk, norak, ket, tbl='tblrak'
				   FROM tblrak WHERE partno = '$partno' and ket = 1 
				   order by norak desc
				END
			ELSE
				BEGIN
				   SELECT id, partno, kodeproduk, norak, ket, tbl='tblrakopt'
				   FROM tblrakopt WHERE partno = '$partno' and ket = 1
				   order by norak desc
			END";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partnoa=$row['partno'];
	$norak=$row['norak'];
	$tbl=$row['tbl'];
}
	echo $norak;
	echo"<script language='javascript'>document.getElementById('tbl').value = '$tbl';</script>";
	echo"<script language='javascript'>document.getElementById('refrak').value = '$norak';</script>";
	/* echo $norak; */
}

/* if (isset($_POST['part'])){
	$partnoa = $_POST['part'];
	$nopall = $_POST['pall'];
	$norak = $_POST['rak'];
	$tbl = $_POST['tbl'];
	
	echo $partnoa.', '.$nopall.', '.$norak.', '.$tbl;
	
	$sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$partnoa'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno2=$row['partno'];
		$partname2=$row['partname'];
		$snp2=$row['stdpacking'];
		$kett2=$row['ket'];
		$kop=$row['kodeproduk'];
	}
	echo $kop;
	
	$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
	echo "<br>".$querya;
} */
if (isset($_POST['lr'])){
		
	$partnoa = $_POST['partlr'];
	$nopall = $_POST['pall'];
	$norak = $_POST['rak'];
	$tbl = $_POST['tbl'];
	
	$nopall = $_POST['pall'];
	$hasil = substr("$nopall",0,1);
	
  $mysql = "SELECT * FROM cekpallet WHERE nopallet='$nopall'";
  $myresult = $mysqlconn->query($mysql);
  $rowcount=mysqli_num_rows($myresult);
  
  $sqla = "select idpallet from viewmasuk where idpallet='$nopall'";
  $resulta = sqlsrv_query( $conn, $sqla); 
  $rowsa = sqlsrv_has_rows( $resulta );
	

  $sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$partnoa'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno2=$row['partno'];
		$partname2=$row['partname'];
		$snp2=$row['stdpacking'];
		$kett2=$row['ket'];
		$kop=$row['kodeproduk'];
	
	echo "<body onload='form1.partno.focus()';scroll()>";
	}
	
  
	if(($partnoa)==""){
		$msg3="<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}else if (strlen($nopall) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	}else if ($rowsa === true){
		$msgmy="<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	}else if ($hasil == 9 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
		$stmta = sqlsrv_query( $conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		//echo $querya;
		
	}else if ($hasil == 9 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		
	}else if ($rowcount === 0) {
		$msgmy="<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	}else if ($rowcount !== 0 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
		/* $stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'"; */
		$stmtr2 = sqlsrv_query( $conn, $queryr2);
		
		$mysql = "UPDATE pallet set produk = '$kop+DIFF CASE M002' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		/* echo "<br \>"; */
		
	}else if ($rowcount !== 0 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
				End";
		/* $stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		
		$mysql = "UPDATE pallet set produk = '$kop' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		
	}
}

if (isset($_POST['part'])){
		
	$partnoa = $_POST['part'];
	$nopall = $_POST['pall'];
	$norak = $_POST['rak'];
	$tbl = $_POST['tbl'];
	
	$nopall = $_POST['pall'];
	$hasil = substr("$nopall",0,1);
	
  $mysql = "SELECT * FROM cekpallet WHERE nopallet='$nopall'";
  $myresult = $mysqlconn->query($mysql);
  $rowcount=mysqli_num_rows($myresult);
  
  $sqla = "select idpallet from viewmasuk where idpallet='$nopall'";
  $resulta = sqlsrv_query( $conn, $sqla); 
  $rowsa = sqlsrv_has_rows( $resulta );
	

  $sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$partnoa'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno2=$row['partno'];
		$partname2=$row['partname'];
		$snp2=$row['stdpacking'];
		$kett2=$row['ket'];
		$kop=$row['kodeproduk'];
	
	echo "<body onload='form1.partno.focus()';scroll()>";
	}
	
  
	if(($partnoa)==""){
		$msg3="<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}else if (strlen($nopall) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	}else if ($rowsa === true){
		$msgmy="<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	}else if ($hasil == 9 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0, partno = '$partno2', kodeproduk = '$kop+DIFF CASE M002'
				 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		/* $queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		//echo $querya;
		
	}else if ($hasil == 9 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
					update tblrak set ket = 0 where norak = '$norak'
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0, partno = '$partno2', kodeproduk = (select kodeproduk from tblproduk where partno = '$partno2')
				 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		/* $queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		
	}else if ($rowcount === 0) {
		$msgmy="<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	}else if ($rowcount !== 0 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0, partno = '$partno2', kodeproduk = '$kop+DIFF CASE M002'
				 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		
		$mysql = "UPDATE pallet set produk = '$kop+DIFF CASE M002' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		/* echo "<br \>"; */
		
	}else if ($rowcount !== 0 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0, partno = '$partno2', kodeproduk = (select kodeproduk from tblproduk where partno = '$partno2')
				 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		
		$mysql = "UPDATE pallet set produk = '$kop' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		
	}
}

if (isset($_POST['partnocari'])){
	$partnocari = $_POST['partnocari'];
	$sql = "SELECT kodeproduk from tblproduk where partno = '$partnocari'";
	$result = sqlsrv_query( $conn, $sql); 
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$kp=$row['kodeproduk'];
	}
	
	$query="truncate table tblcarirak";
	$stmt = sqlsrv_query( $conn, $query);
	$query2="insert into tblcarirak (partno) values ('$partnocari')";
	$stmt2 = sqlsrv_query( $conn, $query2);
	$msg="<h3 style='color:blue;'>$kp</h3>";
	echo $msg;
}



if (isset($_POST['nopallco'])){
  $partno = '';
  $kp = '';
  $norak = '';
  
  $nopall = $_POST['nopallco'];
  $sql = "select tblmasuk.partno,tblproduk.kodeproduk,tblmasuk.norak
		  from tblmasuk
		  inner join tblproduk on tblmasuk.partno = tblproduk.partno
	      where idpallet = '$nopall' and mark = 'o'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partno=$row['partno'];
	$kp=$row['kodeproduk'];
	$norak=$row['norak'];
}

if ($norak != ''){
	$msgc="<h3 style='color:red;'>Sudah Berada Di Dalam Rak</h3>";
	echo $msgc;
}else if ($partno == 'MC075509'){
	$msgc="<h3 style='color:blue;'>DIFF CASE M001 + $kp</h3>";
	echo $msgc;
}else{
	$msgc="<h3 style='color:blue;'>$kp</h3>";
	echo $msgc;
}

if ($norak != ''){
	echo"<script language='javascript'>$('#nopall').focus();</script>";
	echo"<script language='javascript'>document.getElementById('nopall').value = '';</script>";
}else if ($kp == ''){
	echo"<script language='javascript'>$('#nopall').focus();</script>";
	echo"<script language='javascript'>document.getElementById('nopall').value = '';</script>";
}else{
	echo"<script language='javascript'>$('#norak').focus();</script>";
}
}

if (isset($_POST['norakco'])){
	
  $partno = '';
  $kp = '';
  $nopall = $_POST['nopallco2'];
  $norak = $_POST['norakco'];
  //$sql = "select norak, ket from tblrak where norak = '$norak'";
  $sql = "if exists(select * from tblrak where norak = '$norak' and ket = 0)
			begin
				select '0' hasil
			end
		  else
			begin
				select '1' hasil
			end";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		//$noraks=$row['norak'];
		//$ket=$row['ket'];
		$hasil=$row['hasil'];
	}
	
	$sql2 = "select tblmasuk.partno, tblproduk.kodeproduk
			from tblmasuk 
			inner join tblproduk on tblmasuk.partno = tblproduk.partno
			where tblmasuk.idpallet = '$nopall' and mark = 'o'";
  $result2 = sqlsrv_query( $conn, $sql2); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
	while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) 
	{
		//$noraks=$row['norak'];
		//$ket=$row['ket'];
		$partno=$row2['partno'];
		$kp=$row2['kodeproduk'];
	}
	
	if ($hasil == 0){
		$msgc="<h3 style='color:red;'>Rak Sudah Terisi</h3>";
		echo $msgc;
		echo"<script language='javascript'>document.getElementById('norak').value = '';</script>";
	}else if ($partno == 'MC075509'){
		$query1="update tblmasuk set norak = '$norak' where idpallet = '$nopall' and mark = 'o'";
		$stmt1 = sqlsrv_query( $conn, $query1);
		$query2="update tblrak set partno = '$partno', kodeproduk = 'DIFF CASE M001 + $kp', ket = '0' where norak = '$norak'";
		$stmt2 = sqlsrv_query( $conn, $query2);
		$msgc="<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
		echo $msgc;
		echo"<script language='javascript'>document.getElementById('nopall').value = '';</script>";
		echo"<script language='javascript'>document.getElementById('norak').value = '';</script>";
		echo"<script language='javascript'>$('#nopall').focus();</script>";
	}else{
		$query1="update tblmasuk set norak = '$norak' where idpallet = '$nopall' and mark = 'o'";
		$stmt1 = sqlsrv_query( $conn, $query1);
		$query2="update tblrak set partno = '$partno', kodeproduk = '$kp', ket = '0' where norak = '$norak'";
		$stmt2 = sqlsrv_query( $conn, $query2);
		$msgc="<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
		echo $msgc;
		echo"<script language='javascript'>document.getElementById('nopall').value = '';</script>";
		echo"<script language='javascript'>document.getElementById('norak').value = '';</script>";
		echo"<script language='javascript'>$('#nopall').focus();</script>";
	}
//$msgc="<h3 style='color:blue;'>$noraks $ket</h3>";
//echo $msgc;
}




if (isset($_POST['pallmp'])){
		
	$nopall = $_POST['pallmp'];
	$norak = $_POST['rak'];
	
	$sql = "select tblproduk.partno, tblproduk.kodeproduk
			from tblmasuk
			inner join tblproduk on tblproduk.partno = tblmasuk.partno
			where idpallet = '$nopall' and mark = 'o'";
    $result = sqlsrv_query( $conn, $sql); 
    //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno=$row['partno'];
		$kodeproduk=$row['kodeproduk'];
	}	

	if ($partno == 'MC075509'){
		$kp = 'DIFF CASE M001 + '.$kodeproduk;
	}else{
		$kp = $kodeproduk;
	}
	
	
	$query1="update tblmasuk set norak = '$norak' where idpallet = '$nopall' and mark = 'o'";
	$stmt1 = sqlsrv_query( $conn, $query1);
	$query2="update tblrak set partno = '$partno', kodeproduk = '$kp', ket = '0' where norak = '$norak'";
	$stmt2 = sqlsrv_query( $conn, $query2);

	$msgc="<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
	echo $msgc;
	echo"<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	echo"<script language='javascript'>document.getElementById('norak').value = '';</script>";
	echo"<script language='javascript'>document.getElementById('refrak').value = '';</script>";
	echo"<script language='javascript'>$('#nopall').focus();</script>";
}


?>
<script type="text/javascript" language="javascript" >
/* document.getElementById('tblrak').value = '<?php echo $tbl; ?>'; */
</script>