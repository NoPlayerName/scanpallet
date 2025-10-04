<?php
$norak = '';
$tbl = '';
//memasukkan koneksi database
require_once("../koneksi.php");

//jika berhasil/ada post['noprs']

if (isset($_POST['partno'])) {

	$mysql = "SELECT p.part_no, v.part_name, p.std_packing
			FROM tb_product p
			LEFT JOIN v_products v ON v.part_no = p.part_no
			WHERE p.part_no = '$_POST[partno]' AND p.is_active = 1;";
	$result = $mysqlconn->query($mysql);

	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$partnoa   = $row['part_no'];
			$partnamea = $row['part_name'];
			$snp       = $row['std_packing'];

			echo "<body onload='form2.nopall.focus()'>";

			if ($partnoa == "MC075508") {
				echo "<h3 style='color:blue;'>$partnamea dan DIFF CASE M002</h3>";
			} else {
				echo "<h3 style='color:blue;'>$partnamea</h3>";
			}

			echo "<script>$('#nopall').focus();</script>";
		}
	} else {
		echo "<h2 style='color:red;'>Part No tidak Aktif/Terdaftar.. Pastikan Part No sudah diaktifkan!</h2>";
		$_POST['partno'] = "";
		echo "<script>
            $('#partno').focus();
            document.getElementById('partno').value = '';
          </script>";
	}
}



if (isset($_POST['nopall'])) {
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
	$result = sqlsrv_query($conn, $sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$partnoa = $row['partno'];
		$norak = $row['norak'];
		$tbl = $row['tbl'];
	}
	echo $norak;
	echo "<script language='javascript'>document.getElementById('tbl').value = '$tbl';</script>";
	echo "<script language='javascript'>document.getElementById('refrak').value = '$norak';</script>";
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
	
	$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',NOW(),'o'),('MC075509','DIFF CASE RH','$snp2','$nopall',NOW(),'o','$norak')";
	echo "<br>".$querya;
} */
if (isset($_POST['lr'])) {

	$partnoa = $_POST['partlr'];
	$nopall = $_POST['pall'];
	$norak = $_POST['rak'];
	$tbl = $_POST['tbl'];

	$nopall = $_POST['pall'];
	$hasil = substr("$nopall", 0, 1);

	$mysql = "SELECT * FROM cekpallet WHERE nopallet='$nopall'";
	$myresult = $mysqlconn->query($mysql);
	$rowcount = mysqli_num_rows($myresult);

	$sqla = "select idpallet from viewmasuk where idpallet='$nopall'";
	$resulta = sqlsrv_query($conn, $sqla);
	$rowsa = sqlsrv_has_rows($resulta);


	$sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$partnoa'";
	$result = sqlsrv_query($conn, $sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$partno2 = $row['partno'];
		$partname2 = $row['partname'];
		$snp2 = $row['stdpacking'];
		$kett2 = $row['ket'];
		$kop = $row['kodeproduk'];

		echo "<body onload='form1.partno.focus()';scroll()>";
	}


	if (($partnoa) == "") {
		$msg3 = "<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}/* else if (strlen($nopall) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	} */ else if ($rowsa === true) {
		$msgmy = "<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	} else if ($hasil == 9 && $partnoa == "MC075508") {
		$querya = "INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',NOW(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',NOW(),'o','$norak')";
		$stmta = sqlsrv_query($conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		//echo $querya;

	} else if ($hasil == 9 && $partnoa !== "MC075508") {
		$querya = "If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',NOW(),'o','$norak')
				End";
		$stmta = sqlsrv_query($conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
	} else if ($rowcount === 0) {
		$msgmy = "<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	} else if ($rowcount !== 0 && $partnoa == "MC075508") {
		$querya = "INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',NOW(),'o','$norak'),('MC075509','DIFF CASE RH','$snp2','$nopall',NOW(),'o','$norak')";
		$stmta = sqlsrv_query($conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */

		$mysql = "UPDATE pallet set produk = '$kop+DIFF CASE M002' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		/* echo "<br \>"; */
	} else if ($rowcount !== 0 && $partnoa !== "MC075508") {
		$querya = "If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',NOW(),'o','$norak')
				End";
		$stmta = sqlsrv_query($conn, $querya);
		/* $queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */

		$mysql = "UPDATE pallet set produk = '$kop' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
	}
}

if (isset($_POST['part'])) {

	$partnoa = $_POST['part'];
	$nopall = $_POST['pall'];
	$norak = $_POST['rak'];
	$tbl = $_POST['tbl'];

	$nopall = $_POST['pall'];
	$hasil = substr("$nopall", 0, 1);

	$mysql = "SELECT * FROM tb_pallet WHERE pallet_no='$nopall' AND `status`=1 AND is_active=1";
	$myresult = $mysqlconn->query($mysql);
	$rowcount = mysqli_num_rows($myresult);

	$sqla = "SELECT pallet_no FROM tb_stock_in WHERE pallet_no='$nopall' AND `status` =1";
	$resulta = $mysqlconn->query($sqla);
	$rowsa = mysqli_num_rows($resulta);


	$sql = "SELECT p.part_no, v.part_name, p.std_packing from tb_product p left join v_products v on v.part_no = p.part_no where p.part_no = '$partnoa'";
	$result = $mysqlconn->query($sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = $result->fetch_assoc()) {
		$partno2 = $row['part_no'];
		$partname2 = $row['part_name'];
		$snp2 = $row['std_packing'];
		// $kett2 = $row['ket'];
		// $kop = $row['kodeproduk'];

		echo "<body onload='form1.partno.focus()';scroll()>";
	}


	if (($partnoa) == "") {
		$msg3 = "<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}/* else if (strlen($nopall) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	} */ else if ($rowsa > 0) {
		$msgmy = "<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	} else if ($hasil == 9 && $partnoa == "MC075508") {
		$querya = "INSERT INTO tb_stock_in (part_no,part_name,pallet_no,qty,rack_no,`status`,created_at) VALUES('$partno2','$partname2','$nopall','$snp2','$norak', 1 ,NOW()),('MC075509','DIFF CASE RH','$nopall','$snp2','$norak', 1,NOW())";
		$stmta = $mysqlconn->query($querya);
		$queryr = "UPDATE tb_rack set `status` = 1, part_no = '$partno2', product_code = '$partname2+DIFF CASE M002'
				 where rack_no = '$norak'";
		$stmtr = $mysqlconn->query($queryr);
		/* $queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		//echo $querya;

	} else if ($hasil == 9 && $partnoa !== "MC075508") {
		$querya = "INSERT INTO tb_stock_in (part_no, part_name, pallet_no, qty, rack_no, `status`, created_at)
				SELECT '$partno2', '$partname2', '$nopall', '$snp2', '$norak', 1, NOW()
				FROM DUAL
				WHERE NOT EXISTS (
					SELECT 1 
					FROM tb_stock_in 
					WHERE pallet_no = '$nopall' 
					AND `status` = 1
				)";
		$stmta = $mysqlconn->query($querya);
		$queryr = "update tb_rack set `status` = 1, part_no = '$partno2', product_code = (select part_name from v_products where part_no = '$partno2')
				 where rack_no = '$norak'";
		$stmtr = $mysqlconn->query($queryr);
		/* $queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2); */
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
	} else if ($rowcount === 0) {
		$msgmy = "<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	} else if ($rowcount !== 0 && $partnoa == "MC075508") {
		$querya = "INSERT INTO tb_stock_in (part_no,part_name,pallet_no,qty,rack_no,`status`,created_at) VALUES('$partno2','$partname2','$nopall','$snp2','$norak', 1 ,NOW()),('MC075509','DIFF CASE RH','$nopall','$snp2','$norak', 1,NOW())";
		$stmta = $mysqlconn->query($querya);
		$queryr = "update tb_rack set `status` = 1, part_no = '$partno2', product_code = '$partname2+DIFF CASE M002'
				 where rack_no = '$norak'";
		$stmtr = $mysqlconn->query($queryr);

		$mysql = "UPDATE tb_pallet set product = '$partname2+DIFF CASE M002' WHERE pallet_no='$nopall' and is_active=1";
		$mysqlconn->query($mysql);
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		/* echo "<br \>"; */
	} else if ($rowcount !== 0 && $partnoa !== "MC075508") {
		$querya = "INSERT INTO tb_stock_in (part_no, part_name, pallet_no, qty, rack_no, `status`, created_at)
				SELECT '$partno2', '$partname2', '$nopall', '$snp2', '$norak', 1, NOW()
				FROM DUAL
				WHERE NOT EXISTS (
					SELECT 1 
					FROM tb_stock_in 
					WHERE pallet_no = '$nopall' 
					AND `status` = 1
				)";
		$stmta = $mysqlconn->query($querya);
		$queryr = "UPDATE tb_rack set `status` = 1, part_no = '$partno2', product_code = (select part_name from v_products where part_no = '$partno2')
				 where norak = '$norak'";
		$stmtr =  $mysqlconn->query($queryr);

		$mysql = "UPDATE tb_pallet set product = '$partname2' WHERE pallet_no='$nopall' and is_active=1";
		$mysqlconn->query($mysql);
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
	}
}

if (isset($_POST['partnocari'])) {
	$partnocari = $_POST['partnocari'];
	// $sql = "SELECT kodeproduk from tblproduk where partno = '$partnocari'";
	// $result = sqlsrv_query($conn, $sql);
	$query = "SELECT p.part_no, v.part_name 
				FROM tb_product p 
				LEFT JOIN v_products v ON v.part_no = p.part_no
				WHERE p.part_no = '$partnocari' AND p.is_active = 1";
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
	$result =  $mysqlconn->query($query);
	while ($row = $result->fetch_assoc()) {
		$kp = $row['part_name'];
	}

	$query = "TRUNCATE TABLE tb_search_rack";
	$stmt = $mysqlconn->query($query);
	$query2 = "INSERT INTO tb_search_rack (part_no) values ('$partnocari')";
	$stmt2 = $mysqlconn->query($query2);
	$msg = "<h3 style='color:blue;'>$kp</h3>";
	echo $msg;
}



if (isset($_POST['nopallco'])) {
	$partno = '';
	$kp = '';
	$norak = '';

	$nopall = $_POST['nopallco'];
	$sql = "select tblmasuk.partno,tblproduk.kodeproduk,tblmasuk.norak
		  from tblmasuk
		  inner join tblproduk on tblmasuk.partno = tblproduk.partno
	      where idpallet = '$nopall' and mark = 'o'";
	$result = sqlsrv_query($conn, $sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$partno = $row['partno'];
		$kp = $row['kodeproduk'];
		$norak = $row['norak'];
	}

	if ($norak != '') {
		$msgc = "<h3 style='color:red;'>Sudah Berada Di Dalam Rak</h3>";
		echo $msgc;
	} else if ($partno == 'MC075509') {
		$msgc = "<h3 style='color:blue;'>DIFF CASE M001 + $kp</h3>";
		echo $msgc;
	} else {
		$msgc = "<h3 style='color:blue;'>$kp</h3>";
		echo $msgc;
	}

	if ($norak != '') {
		echo "<script language='javascript'>$('#nopall').focus();</script>";
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	} else if ($kp == '') {
		echo "<script language='javascript'>$('#nopall').focus();</script>";
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	} else {
		echo "<script language='javascript'>$('#norak').focus();</script>";
	}
}

if (isset($_POST['norakco'])) {

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
	$result = sqlsrv_query($conn, $sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		//$noraks=$row['norak'];
		//$ket=$row['ket'];
		$hasil = $row['hasil'];
	}

	$sql2 = "select tblmasuk.partno, tblproduk.kodeproduk
			from tblmasuk 
			inner join tblproduk on tblmasuk.partno = tblproduk.partno
			where tblmasuk.idpallet = '$nopall' and mark = 'o'";
	$result2 = sqlsrv_query($conn, $sql2);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {
		//$noraks=$row['norak'];
		//$ket=$row['ket'];
		$partno = $row2['partno'];
		$kp = $row2['kodeproduk'];
	}

	if ($hasil == 0) {
		$msgc = "<h3 style='color:red;'>Rak Sudah Terisi</h3>";
		echo $msgc;
		echo "<script language='javascript'>document.getElementById('norak').value = '';</script>";
	} else if ($partno == 'MC075509') {
		$query1 = "update tblmasuk set norak = '$norak' where idpallet = '$nopall' and mark = 'o'";
		$stmt1 = sqlsrv_query($conn, $query1);
		$query2 = "update tblrak set partno = '$partno', kodeproduk = 'DIFF CASE M001 + $kp', ket = '0' where norak = '$norak'";
		$stmt2 = sqlsrv_query($conn, $query2);
		$msgc = "<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
		echo $msgc;
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
		echo "<script language='javascript'>document.getElementById('norak').value = '';</script>";
		echo "<script language='javascript'>$('#nopall').focus();</script>";
	} else {
		$query1 = "update tblmasuk set norak = '$norak' where idpallet = '$nopall' and mark = 'o'";
		$stmt1 = sqlsrv_query($conn, $query1);
		$query2 = "update tblrak set partno = '$partno', kodeproduk = '$kp', ket = '0' where norak = '$norak'";
		$stmt2 = sqlsrv_query($conn, $query2);
		$msgc = "<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
		echo $msgc;
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
		echo "<script language='javascript'>document.getElementById('norak').value = '';</script>";
		echo "<script language='javascript'>$('#nopall').focus();</script>";
	}
	//$msgc="<h3 style='color:blue;'>$noraks $ket</h3>";
	//echo $msgc;
}




if (isset($_POST['pallmp'])) {

	$nopall = $_POST['pallmp'];
	$norak = $_POST['rak'];

	// $sql = "select tblproduk.partno, tblproduk.kodeproduk
	// 		from tblmasuk
	// 		inner join tblproduk on tblproduk.partno = tblmasuk.partno
	// 		where idpallet = '$nopall' and mark = 'o'";
	// $result = sqlsrv_query($conn, $sql);
	$query = "SELECT part_no, part_name FROM tb_stock_in WHERE pallet_no = '$nopall' and `status` = 1";
	$result = $mysqlconn->query($query);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = $result->fetch_assoc()) {
		$partno = $row['part_no'];
		$kodeproduk = $row['part_name'];
	}

	if ($partno == 'MC075509') {
		$kp = 'DIFF CASE M001 + ' . $kodeproduk;
	} else {
		$kp = $kodeproduk;
	}


	$query1 = "UPDATE tb_stock_in SET rack_no = '$norak' WHERE pallet_no = '$nopall' and `status` = 1";
	$stmt1 = $mysqlconn->query($query1);
	$query2 = "UPDATE tb_rack set part_no = '$partno', product_code = '$kp', `status` = 1 where rack_no = '$norak'";
	$stmt2 = $mysqlconn->query($query2);

	$msgc = "<h3 style='color:blue;'>Data Berhasil Disimpan</h3>";
	echo $msgc;
	echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	echo "<script language='javascript'>document.getElementById('norak').value = '';</script>";
	echo "<script language='javascript'>document.getElementById('refrak').value = '';</script>";
	echo "<script language='javascript'>$('#nopall').focus();</script>";
}


?>
<script type="text/javascript" language="javascript">
	/* document.getElementById('tblrak').value = '<?php echo $tbl; ?>'; */
</script>