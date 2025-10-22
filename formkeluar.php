<?php
$partnoa = "";
$partnamea = "";
$nopalla = "";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
//$partno =htmlspecialchars($_POST["partno"]);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */

require_once("koneksi.php");

if (isset($_POST['nopall'])) {
	$nopall = htmlspecialchars($_POST["nopall"]);
}
if (isset($_POST['nopall'])) {
	$sql = "SELECT p.pallet_no, p.part_no, v.part_name, p.rack_no, p.qty from tb_stock_in p left join v_products v on v.part_no = p.part_no where p.pallet_no='$nopall' and p.`status` =1";
	$result = $mysqlconn->query($sql);
	$sql2 = "SELECT t.part_no,t.part_name, t.rack_no
                                FROM tb_stock_in t
                                INNER JOIN tb_product p ON p.part_no = t.part_no
								where t.pallet_no = '$nopall' and t.`status` = 1
                                order by t.part_name asc";
	$result2 = $mysqlconn->query($sql2);
	//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
	$sql3 = "SELECT initial, customer_name from tb_customer where id='$_POST[opt]'";
	$result3 = $mysqlconnM->query($sql3);
	while ($row = $result->fetch_assoc()) {
		$nopalla = $row['pallet_no'];
		$partnoa = $row['part_no'];
		$partnamea = $row['part_name'];
		$stdpacka = $row['qty'];
		$norak = $row['rack_no'];
	}
	while ($row2 = $result2->fetch_assoc()) {
		$kop = $row2['part_name'];
	}
	while ($row3 = $result3->fetch_assoc()) {
		$sin = $row3['initial'];
		$custName = $row3['customer_name'];
	}
}


if (isset($_POST['nopall'])) { //check if form was submitted
	$dt = date('Y-m-d');
	if ($nopalla == "") {
		$msg = "<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk!</h2>";
		echo $msg;
		$_POST['cust'] = "";
	} else if ($_POST['opt'] == null) {
		$msgk = "<h2 style='color:red;'>Customer Tidak Boleh Kosong!</h2>";
		echo $msgk;
	} else if ($partnoa == "MC075509") {
		try {
			$queryb = "INSERT INTO tb_stock_out (part_no,part_name,pallet_no,qty,rack_no,customer, created_at) VALUES('MC075508','DIFF CASE M001','$nopalla',30,'$norak','$custName',NOW())";
			$stmtb = $mysqlconn->query($queryb);
			$sqls = "UPDATE tb_stock_in set `status`=0 where pallet_no='$nopalla' and part_no='MC075508' and `status`=1";
			$rests = $mysqlconn->query($sqls);
			// $sqlt = "update transaksi set tglkeluar = GETDATE(), produkkeluar = 'DIFF CASE M001', keluar = '30', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
			// $restt = sqlsrv_query($conn, $sqlt);

			$sqla = "UPDATE tb_stock_in set `status`=0 where pallet_no='$nopalla' and part_no='$partnoa' and `status`=1";
			$resta = $mysqlconn->query($sqla);
			$query = "INSERT INTO tb_stock_out (part_no,part_name,pallet_no,qty,rack_no,customer, created_at) VALUES('$partnoa','$partnamea','$nopalla','$stdpacka','$norak','$custName',NOW())";
			$stmt = $mysqlconn->query($query);
			// $sql1 = "update transaksi set tglkeluar = GETDATE(), produkkeluar = '$kop', keluar = '$stdpacka', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
			// $restt1 = sqlsrv_query($conn, $sql1);

			$rak = "UPDATE tb_rack set `status` = 0, part_no = 0, product_code = 0 where rack_no = '$norak'";
			$queryrak = $mysqlconn->query($rak);
			/* $rakopt="Update tblrakopt set ket = 1 where norak = '$norak'";
	$queryrakopt = sqlsrv_query($conn, $rakopt); */

			$mysql = "INSERT INTO tb_transaction (pallet_no,`location`,`status`,product,created_at)
	VALUES ('$_POST[nopall]','AICC',0,'DIFF CASE M001+$kop', NOW())";
			$mysqlconn->query($mysql);
			$mysql2 = "INSERT INTO transaksi (pallet_no,`location`,`status`,product,created_at)
	VALUES ('$_POST[nopall]','$sin,'1','DIFF CASE M001+$kop', NOW())";
			$mysqlconn->query($mysql2);

			$mysql1 = "UPDATE tb_pallet set `status`=0,customer='$sin',product='DIFF CASE M001+$kop' WHERE pallet_no='$_POST[nopall]' and is_active=1";
			$mysqlconn->query($mysql1);


			$msgs = "<h2 style='color:blue;'>Berhasil Tersimpan $sin, DIFF CASE M001+$kop</h2>";
			echo $msgs;
			echo "<br />";
			$_POST['cust'] = "";
		} catch (Exception $e) {
			echo $e;
		}
	} else {
		try {
			$sqla = "UPDATE tb_stock_in set `status`=0 where pallet_no='$nopalla' and part_no='$partnoa' and `status`=1";
			$resta = $mysqlconn->query($sqla);
			$query = "INSERT INTO tb_stock_out (part_no, part_name, pallet_no, qty, rack_no, customer, created_at)
						SELECT '$partnoa', '$partnamea', '$nopalla', '$stdpacka', '$norak', '$custName', NOW()
						WHERE NOT EXISTS (
							SELECT 1 
							FROM tb_stock_out 
							WHERE part_no   = '$partnoa'
							AND pallet_no = '$nopalla'
							AND DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') = DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i')
						)";
			$stmt = $mysqlconn->query($query);
			// $sql1 = "update transaksi set tglkeluar = GETDATE(), produkkeluar = '$kop', keluar = '$stdpacka', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
			// $restt1 = sqlsrv_query($conn, $sql1);
			$rak = "UPDATE tb_rack set `status` = 0, part_no = 0, product_code = 0 where rack_no = '$norak'";
			$queryrak = $mysqlconn->query($rak);
			/* $rakopt="Update tblrakopt set ket = 1 where norak = '$norak'";
	$queryrakopt = sqlsrv_query($conn, $rakopt); */


			$mysql = "INSERT INTO tb_transaction (pallet_no,`location`,`status`,product,created_at)
	VALUES ('$_POST[nopall]','AICC',0,'$kop', NOW())";
			$mysqlconn->query($mysql);
			$mysql2 = "INSERT INTO tb_transaction (pallet_no,`location`,`status`,product,created_at)
	VALUES ('$_POST[nopall]','$sin',1,'$kop', NOW())";
			$mysqlconn->query($mysql2);

			$mysql1 = "UPDATE tb_pallet set `status`=0,customer='$sin',product='$kop' WHERE pallet_no='$_POST[nopall]' and is_active=1";
			$mysqlconn->query($mysql1);
			$msgx = "<h2 style='color:blue;'>Berhasil Tersimpan $sin, $kop</h2>";
			echo $msgx;
			echo "<br />";
			$_POST['cust'] = "";
		} catch (Exception $e) {
			echo $e;
		}
	}
}
?>

<html>

<head>
	<script>
		function myFunction() {
			var x = document.getElementById("cust").value;
			document.getElementById('opt').value = x;
			document.getElementById('nopall').focus();
		}
	</script>
	<div class="container">
		<style>
			h2 {
				color: red;
			}

			h3 {
				color: blue;
			}
		</style>

	</div>
	<title>
		<?php echo "Form Keluar"; ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	</link>
</head>
<script>
	function tab(field, event) {
		if (event.which == 13 /* IE9/Firefox/Chrome/Opera/Safari */ || event.keyCode == 13 /* IE8 and earlier */ ) {
			for (i = 0; i < field.form.elements.length; i++) {
				if (field.form.elements[i].tabIndex == field.tabIndex + 1) {
					field.form.elements[i].focus();
					if (field.form.elements[i].type == "text") {
						field.form.elements[i].select();
						break;
					}
				}
			}
			return false;
		}
		return true;
	}
</script>

<script>
	function myFunction() {
		var x = document.getElementById("cust").value;
		document.getElementById('opt').value = x;
		document.getElementById('nopall').focus();
	}
</script>

<body>
	<form action="index.php">
		<input type="submit" value="Kembali" />
	</form>
	<br>
	<p></p>
	<style type='text/css'>
		fieldset.fsStyle {
			font-family: Verdana, Arial, sans-serif;
			font-size: small;
			font-weight: normal;
			border: 1px solid #999999;
			padding: 4px;
			margin: 20px;
		}
	</style>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset class="fsstyle">
			<div class="container">
				<legend class="legendstyle">
					<label style="font-size:20pt">Form Keluar</label>
				</legend>
			</div>
			<div class="container">
				<div class="form-group">
					<label>Customer :</label>
					<select name="cust" id="cust" style="font-size:15pt;height:35px;width:100%" onchange="myFunction()">
						<option value="" disabled="disabled" selected="true"></option>
						<?php
						$sql = "SELECT id, customer_name from tb_customer order by customer_name asc";
						$result = $mysqlconnM->query($sql);
						//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

						while ($row = $result->fetch_assoc()) { ?>

							<option value="<?php echo $row['id']; ?>" <?php if (isset($_POST['cust']) && $_POST['cust'] == $row['customer_name']) echo 'selected'; ?>>
								<?php echo $row['customer_name'] ?>
							</option>
						<?php
						}

						?>
					</select>
					<input type="text" id="opt" name="opt" style="display: none;">
				</div>
				<div class="form-group">
					<label>No Pallet :</label>
					<input type="text" name="nopall" id="nopall" autocomplete="off" autofocus required maxlength="10" style="font-size:15pt;height:35px;width:100%" /></p>
					<script>
						if (!("autofocus" in document.createElement("input"))) {
							document.getElementById("nopall").focus();
						}
					</script>
				</div>
			</div>
		</fieldset>
		<input type="submit" style="display: none;" tabIndex="3">
	</form>
	<script src="js/jquery-1.12.0.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</body>

</html>