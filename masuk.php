<?php

require_once("koneksi.php");

// $servername = "10.63.0.3";
// $username = "aicc-db";
// $password = "31041CcP@ssw0rd#";
// $dbname = "palletdb";


if (isset($_POST['no'])) {
	$no = htmlspecialchars($_POST["no"]);
}

// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// }
if (isset($_POST['no'])) {
	$msg = "<h1 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah keluar!</h1>";
	$sql1 = "SELECT * FROM tb_pallet WHERE pallet_no='$no' and `status`=0";
	$result = $mysqlconn->query($sql1);
	if (!$result) {
		die($mysqlconn->error);
	}

	if ($result->num_rows == 0) {
		echo $msg;
	} else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$cust = $row['customer'];
		$product = $row['product'];
		echo $cust;


		$sql2 = "INSERT INTO tb_transaction (pallet_no,`location`,product,`status`,created_at)
		VALUES ('$no','$cust',null,0, NOW())";
		if ($mysqlconn->query($sql2) === TRUE) {
		} else {
			echo '<div class="alert alert-warning">';
			echo '<strong>Error</Strong>';
			echo $sql2;
			echo "<br>";
			echo $mysqlconn->error;
			echo '</div>';
		}

		$sql3 = "INSERT INTO tb_transaction (pallet_no,`location`,product,`status`,created_at)
	VALUES ('$no','AICC',null,1, NOW())";

		if ($mysqlconn->query($sql3) === TRUE) {
			$sql4 = "UPDATE tb_pallet set `status`=1,customer='AICC', product = null WHERE pallet_no='$no' and is_active=1";
			$mysqlconn->query($sql4);

			echo '<div class="alert alert-success">';
			echo '<strong>Sukses</Strong> Memproses : ' . $no;
			echo '</div>';
		} else {
			echo '<div class="alert alert-warning">';
			echo '<strong>Error</Strong>';
			echo $sql3;
			echo "<br>";
			echo $mysqlconn->error;
			echo '</div>';
		}
	}
}

$mysqlconn->close();
?>
<html lang="en">

<head>
	<div class="container">
		<link href="style.css" rel="stylesheet" media="screen">

		<title>Pallet Masuk</title>
</head>

<style>
	h1 {
		color: red;
	}
</style>
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
</div>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
</link>

<body>
	<form action="index.php">
		<input type="submit" value="Kembali" />
	</form>
	<br>
	<p></p>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset class="fsStyle">
			<div class="container">
				<div class="form-group">
					<legend class="legendstyle"><label style="font-size:20pt">Pallet Masuk</label></legend>


					<label>No Pallet :</label> <input type="text" name="no" id="no" autofocus required maxlength="5" autocomplete="off" style="font-size:15pt;height:35px;width:100%" />
					<script>
						if (!("autofocus" in document.createElement("input"))) {
							document.getElementById("no").focus();
						}
					</script>

		</fieldset>
		</div>
	</form>
	</div>
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</head>

</html>