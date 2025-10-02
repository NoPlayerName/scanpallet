<?php

$servername = "10.63.0.3";
$username = "aicc-db";
$password = "31041CcP@ssw0rd#";
$dbname = "palletdb";


if(isset($_POST['no'])){
   $no =htmlspecialchars($_POST["no"]);
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(isset($_POST['no'])){
  $msg="<h1 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah keluar!</h1>";
  $sql = "SELECT * FROM pallet WHERE nopallet='$no' and keluar=1";
  $result = $conn->query($sql);
if (!$result) {
  die($conn->error);
}

if ($result->num_rows == 0) {
   echo $msg;
  
} else {
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);	
	$cust=$row['cust'];
    $product=$row['produk'];
	echo $cust;
	

	$sql = "INSERT INTO transaksi (tgl,nopallet,lokasi,keluar,produk,createdatetime)
		VALUES (DATE(NOW()),'$no','$cust',1,'', NOW())";
	if ($conn->query($sql) === TRUE) {
		
	}else
	{
				 echo '<div class="alert alert-warning">';
		echo '<strong>Error</Strong>';echo $sql; echo "<br>"; echo $conn->error;
		echo '</div>';
	}
	
	$sql = "INSERT INTO transaksi (tgl,nopallet,lokasi,masuk,produk,createdatetime)
	VALUES (DATE(NOW()),'$no','AICC',1,'', NOW())";

	if ($conn->query($sql) === TRUE) {
		$sql = "UPDATE pallet set masuk=1,keluar=0,balance=1,cust='AICC', produk = '' WHERE nopallet='$no' and aktif=1";
		$conn->query($sql);
	  
		echo '<div class="alert alert-success">';
		echo '<strong>Sukses</Strong> Memproses : ' .$no;
		echo '</div>';
		
	} else {
		 echo '<div class="alert alert-warning">';
		echo '<strong>Error</Strong>';echo $sql; echo "<br>"; echo $conn->error;
		echo '</div>';
		
	}
}
}

$conn->close();
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
   <link href="css/bootstrap.min.css" rel="stylesheet"></link>
<body> 
<form action="index.php">
    <input type="submit" value="Kembali"/>
</form>
 <br>
 <p></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset class="fsStyle">
	<div class="container">
	<div class="form-group">
	<legend class="legendstyle"><label style="font-size:20pt">Pallet Masuk</label></legend>
		
		
		<label>No Pallet :</label> <input type="text" name="no" id="no" autofocus required maxlength="5" autocomplete="off" style="font-size:15pt;height:35px;width:100%"/>
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