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
  $msg="<h1>No Pallet Sudah Di AICC!</h1>";
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
	  
		//echo '<div class="alert alert-success">';
		//echo '<strong>Sukses</Strong> Sukses Memproses : ' .$no;
		//echo '</div>';
		$msgs="<h2>$cust</br>Sukses Memproses : $no</h2>";
		echo $msgs;
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
<link href="style.css" rel="stylesheet" media="screen">

<title>Pallet Masuk</title> 
</head>
<style>

h1 {
    color: red;
}

h2 {
    color: blue;
}

fieldset.fsStyle {
    font-family: Verdana, Arial, sans-serif;
    font-size: small;
    font-weight: normal;
    border: 1px solid #999999;
    padding: 4px;
    margin: 20px;
  }
</style>
<body> 
<a href="indexpallet.php" style='color:blue'><b>Kembali</b></a>
<br>
<p></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div>
	<fieldset style="width:80%">
	<legend><b>Pallet Masuk</b></legend>
		
		
	<p>&nbsp;&nbsp;&nbsp;&nbsp;<label><b>No Pallet :</b></label>
	</br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="no" id="no" autofocus required maxlength="4" style="font-size:24pt;height:45px;width:90%"/></p>
		<script>
 		   if (!("autofocus" in document.createElement("input"))) {
   			   document.getElementById("no").focus();
  			}
 		</script>
	<p>
	</fieldset>	
</form>
</body> 
</head>
</html> 