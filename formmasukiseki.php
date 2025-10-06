<?php
$partnoa = "";
$partnamea = "";
$kodeproduka = "";
$stdpacka = "";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */
require_once("koneksi.php");

//$serverName = "asakai-nb";
//$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"p@ssw0rd");
//$conn = sqlsrv_connect( $serverName, $connectionInfo );

if (isset($_POST['partno'])) {
	$partno = htmlspecialchars($_POST["partno"]);
}
if (isset($_POST['partno'])) {
	// $sql = "SELECT partno, partname, kodeproduk, stdpacking, tanpanopallet from tblproduk where partno='$partno' and ket = 'active'";
	// $result = sqlsrv_query($conn, $sql);
	$query = "SELECT p.part_no, v.part_name, p.std_packing, p.without_pallet 
				FROM tb_product p 
				LEFT JOIN v_products v ON v.part_no = p.part_no 
				WHERE p.part_no = '$partno' AND p.is_active = 1";
	$result = $mysqlconn->query($query);

	while ($row = $result->fetch_assoc()) {
		$partnoa = $row['part_no'];
		$partnamea = $row['part_name'];
		$kodeproduka = $row['part_name'];
		$stdpacka = $row['std_packing'];
		$tnp = $row['without_pallet'];
	}
	if ($partnoa == "") {
		$msgs = "<h2 style='color:red;'>Partno Tidak Aktif!</h2>";
		echo $msgs;
	} else if ($tnp != 1) {
		$msgs = "<h2 style='color:red;'>Bukan Produk Iseki!</h2>";
		echo $msgs;
	} else {
		$query = "INSERT INTO tb_stock_in (part_no,part_name,qty,`status`,created_at) VALUES('$partnoa','$partnamea','$stdpacka',1, NOW())";
		$stmt = $mysqlconn->query($query);
		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan $kodeproduka</h3>";
		echo $msgs;
	}
	$_POST['partno'] = "";
}
?>

<html>

<head>
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
		<?php echo "Form Masuk Iseki"; ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	</link>
	<?php $stda = isset($_POST["stdpack"]); ?>
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

	function setFocusToTextBox() {
		var textbox = document.getElementById("partno");
		textbox.select();
		textbox.scrollIntoView();
	}

	function scroll() {
		window.scrollBy(0, 50);
	}

	function OnButton1() {
		alert("Button code executed.");
		return true;
	}
</script>

<body onload="form1.partno.focus()">
	<form action="indexiseki.php">
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
	<fieldset class="fsStyle">
		<div class="container">
			<legend class="legendstyle">
				<label style="font-size:20pt">Form Masuk Iseki</label>
			</legend>
		</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
			<div class="container">
				<div class="form-group">
					<label>Part No :</label>
					<input type="text" name="partno" id="partno" style="font-size:15pt;height:35px;width:100%" tabIndex="1" value="<?php echo isset($_POST['partno']) ? $_POST['partno'] : '' ?>" autocomplete="off"></p>
				</div>
				<input type="submit" name="btn_submit" value="submit1" style="display: none;">
		</form>
</body>

</html>