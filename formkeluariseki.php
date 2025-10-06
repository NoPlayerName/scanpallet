<?php
$id = "";
$partnoa = "";
$partnamea = "";
$qtya = "";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */
require_once("koneksi.php");

if (isset($_POST['partno'])) {
	$partno = htmlspecialchars($_POST["partno"]);
}
if (isset($_POST['partno'])) {
	// $sql = "SELECT min(id)id from tblmasuk where partno='$partno' and mark ='o'";
	// $result = sqlsrv_query($conn, $sql);
	$query = "SELECT id, part_no, part_name, qty FROM tb_stock_in WHERE part_no ='$partno' AND `status` = 1 ORDER BY id ASC LIMIT 1";
	$result = $mysqlconn->query($query);

	if ($row = $result->fetch_assoc()) {
		$partnoa   = $row['part_no'];
		$partnamea = $row['part_name'];
		$qtya      = $row['qty'];
		$id 	= $row['id'];
	} else {
		echo "<h2 style='color:red;'>Part No tidak ditemukan.. Pastikan Part No sudah masuk!</h2>";
	}

	if ($_POST['opt'] == "") {
		$msgs = "<h2 style='color:red;'>Cutblmasukmer Tidak Boleh Kosong!</h2>";
		echo $msgs;
	} else {
		$query = "UPDATE tb_stock_in SET `status` = 0 where id='$id'";
		$stmt = $mysqlconn->query($query);
		$query2 = "INSERT INTO tb_stock_out (part_no,part_name,qty,customer,created_at) VALUES('$partnoa','$partnamea','$qtya','$_POST[opt]',NOW())";
		$stmt2 = $mysqlconn->query($query2);

		$msgs = "<h3 style='color:blue;'>Data Berhasil Di Simpan $_POST[opt]</h3>";
		echo $msgs;
	}
	$_POST['partno'] = "";
}

?>

<html>

<head>
	<script>
		function myFunction() {
			var x = document.getElementById("cust").value;
			document.getElementById('opt').value = x;
			document.getElementById('partno').focus();
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
		<?php echo "Form Keluar Iseki"; ?>
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
		document.getElementById('partno').focus();
	}
</script>

<body>
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
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset class="fsstyle">
			<div class="container">
				<legend class="legendstyle">
					<label style="font-size:20pt">Form Keluar Iseki</label>
				</legend>
			</div>
			<div class="container">
				<div class="form-group">
					<label>Customer :</label>
					<select name="cust" id="cust" style="font-size:15pt;height:35px;width:100%" onchange="myFunction()">
						<option value="" disabled="disabled" selected="true"></option>
						<option value="ISEKI">ISEKI</option>
						<option value="JIBUHIN THAILAND">JIBUHIN THAILAND</option>
					</select>
					<input type="text" id="opt" name="opt" style="display: none;">
				</div>
				<div class="form-group">
					<label>Part No :</label>
					<input type="text" name="partno" id="partno" autocomplete="off" autofocus required style="font-size:15pt;height:35px;width:100%" /></p>
					<script>
						if (!("autofocus" in document.createElement("input"))) {
							document.getElementById("partno").focus();
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