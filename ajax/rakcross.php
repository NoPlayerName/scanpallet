<?php
$norak = '';
/* $partno = '42411EW011'; */
require_once("../koneksi.php");

if (isset($_POST['nopall'])) {
	$partNo = $_POST['nopall'] ?? null;


	// 1. Ambil group_rack sesuai product
	$rackQuery = "
        SELECT r.*
        FROM tb_rack r
        JOIN tb_rack_group rg ON r.rack_no LIKE CONCAT(rg.group_rack, '%')
        JOIN tb_product p ON p.`group` = rg.`group`
        WHERE r.status = 0
          AND p.part_no = ?
        ORDER BY rg.priority ASC, RAND()
        LIMIT 1
    ";

	// Prepared statement
	$stmt = $mysqlconn->prepare($rackQuery);
	$stmt->bind_param("s", $partNo);
	$stmt->execute();
	$rackResult = $stmt->get_result();
	$rack = $rackResult->fetch_assoc();

	// Ambil hasil
	$norak = $rack['rack_no'] ?? '';

	if ($norak === '') {
		echo "LR"; // LR = tidak ada rak kosong
	} else {
		echo $norak;
	}
}


if (isset($_POST['nopallco'])) {
	$partno = '';
	$kp = '';
	$norak = '';
	$rak = '';

	$nopall = $_POST['nopallco'];
	$sql = "select tblmasuk.partno,tblproduk.kodeproduk,tblmasuk.norak,left(tblmasuk.norak,2) rak
		  from tblmasuk
		  inner join tblproduk on tblmasuk.partno = tblproduk.partno
	      where idpallet = '$nopall' and mark = 'o'";
	$result = sqlsrv_query($conn, $sql);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		$partno = $row['partno'];
		$kp = $row['kodeproduk'];
		$norak = $row['norak'];
		$rak = $row['rak'];
	}

	if ($rak == '') {
		$msgc = "<h3 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk!</h3>";
		echo $msgc;
		echo "<script language='javascript'>$('#nopall').focus();</script>";
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	} else if ($rak != 'LR') {
		$msgc = "<h3 style='color:red;'>Sudah Berada Di Dalam Rak</h3>";
		echo $msgc;
		echo "<script language='javascript'>$('#nopall').focus();</script>";
		echo "<script language='javascript'>document.getElementById('nopall').value = '';</script>";
	} else if ($partno == 'MC075509') {
		$norak = '';
		$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
		 where left(norak, 2) = (select golrak.def1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
		and ket = '1'
		group by norak, partno, kodeproduk, ket
		order by norak asc";
		$resultdef = sqlsrv_query($conn, $def);

		while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
			$norak = $def['norak'];
			$partno = $def['partno'];
			$kodeproduk = $def['kodeproduk'];
			$norakref = $def['kodeproduk'];
			$ket = $def['ket'];
		}

		$deo = 2;
		while ($norak == '' and $deo < 8) {
			$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
			 where left(norak, 2) = (select golrak.def$deo
									from tblproduk
									left join golrak on tblproduk.gol = golrak.gol
									where tblproduk.partno = '$partno')
			and ket = '1'
			group by norak, partno, kodeproduk, ket
			order by norak asc";
			$resultdef = sqlsrv_query($conn, $def);

			while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
				$norak = $def['norak'];
				$partno = $def['partno'];
				$kodeproduk = $def['kodeproduk'];
				$norakref = $def['kodeproduk'];
				$ket = $def['ket'];
			}
			$deo = $deo + 1;
		}

		while ($norak == '' and $deo > 7 and $deo < 10) {
			$opsi = $deo - 7;
			$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
			 where left(norak, 2) = (select golrak.opsi$opsi
									from tblproduk
									left join golrak on tblproduk.gol = golrak.gol
									where tblproduk.partno = '$partno')
			and ket = '1'
			group by norak, partno, kodeproduk, ket
			order by norak asc";
			$resultdef = sqlsrv_query($conn, $def);

			while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
				$norak = $def['norak'];
				$partno = $def['partno'];
				$kodeproduk = $def['kodeproduk'];
				$norakref = $def['kodeproduk'];
				$ket = $def['ket'];
			}
			$deo = $deo + 1;
		}


		if ($norak == '') {
			echo "LR";
		} else {
			$msgc = "<h3 style='color:blue;'>DIFF CASE M001 + $kp</h3>";
			echo $msgc;
			echo "</p>";
			echo $norak;
			echo "<script language='javascript'>document.getElementById('refrak').value = '$norak';</script>";
		}
	} else {
		$norak = '';
		$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
		 where left(norak, 2) = (select golrak.def1
								from tblproduk
								left join golrak on tblproduk.gol = golrak.gol
								where tblproduk.partno = '$partno')
		and ket = '1'
		group by norak, partno, kodeproduk, ket
		order by norak asc";
		$resultdef = sqlsrv_query($conn, $def);

		while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
			$norak = $def['norak'];
			$partno = $def['partno'];
			$kodeproduk = $def['kodeproduk'];
			$norakref = $def['kodeproduk'];
			$ket = $def['ket'];
		}

		$deo = 2;
		while ($norak == '' and $deo < 8) {
			$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
			 where left(norak, 2) = (select golrak.def$deo
									from tblproduk
									left join golrak on tblproduk.gol = golrak.gol
									where tblproduk.partno = '$partno')
			and ket = '1'
			group by norak, partno, kodeproduk, ket
			order by norak asc";
			$resultdef = sqlsrv_query($conn, $def);

			while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
				$norak = $def['norak'];
				$partno = $def['partno'];
				$kodeproduk = $def['kodeproduk'];
				$norakref = $def['kodeproduk'];
				$ket = $def['ket'];
			}
			$deo = $deo + 1;
		}

		while ($norak == '' and $deo > 7 and $deo < 10) {
			$opsi = $deo - 7;
			$def = "select top(1)norak, partno, kodeproduk, ket, concat((left(norak,1)),sum(convert(decimal(10),right(norak,3)))+1) as norakref from tblrak 
			 where left(norak, 2) = (select golrak.opsi$opsi
									from tblproduk
									left join golrak on tblproduk.gol = golrak.gol
									where tblproduk.partno = '$partno')
			and ket = '1'
			group by norak, partno, kodeproduk, ket
			order by norak asc";
			$resultdef = sqlsrv_query($conn, $def);

			while ($def = sqlsrv_fetch_array($resultdef, SQLSRV_FETCH_ASSOC)) {
				$norak = $def['norak'];
				$partno = $def['partno'];
				$kodeproduk = $def['kodeproduk'];
				$norakref = $def['kodeproduk'];
				$ket = $def['ket'];
			}
			$deo = $deo + 1;
		}


		if ($norak == '') {
			echo "LR";
		} else {
			$msgc = "<h3 style='color:blue;'>$kp</h3>";
			echo $msgc;
			echo "</p>";
			echo $norak;
			echo "<script language='javascript'>document.getElementById('refrak').value = '$norak';</script>";
		}


		/* echo"<script language='javascript'>$('#norak').focus();</script>"; */
	}
}
