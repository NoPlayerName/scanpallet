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
	$query = "SELECT part_no, part_name, rack_no, LEFT(rack_no, 2) AS rak 
				FROM tb_stock_in  
				WHERE pallet_no = '$nopall' AND `status` = 1";
	$result = $mysqlconn->query($query);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

	while ($row = $result->fetch_assoc()) {
		$partno = $row['part_no'];
		$kp = $row['part_name'];
		$norak = $row['rack_no'];
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
		$stmt->bind_param("s", $partno);
		$stmt->execute();
		$rackResult = $stmt->get_result();
		$rack = $rackResult->fetch_assoc();

		// Ambil hasil
		$norak = $rack['rack_no'] ?? '';


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
		$stmt->bind_param("s", $partno);
		$stmt->execute();
		$rackResult = $stmt->get_result();
		$rack = $rackResult->fetch_assoc();

		// Ambil hasil
		$norak = $rack['rack_no'] ?? '';


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
