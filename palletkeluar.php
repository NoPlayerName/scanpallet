<?php
$partnoa="";
$partnamea="";
$nopalla="";
$mark="";
$sin="REPAIR PALLET";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */
require_once("koneksi.php");

if(isset($_POST['nopall'])){
   $nopall =htmlspecialchars($_POST["nopall"]);
}
if(isset($_POST['nopall'])){
  $mysql = "SELECT * FROM pallet WHERE nopallet='$_POST[nopall]' and masuk=1 and aktif=1";
  $myresult = $mysqlconn->query($mysql);

  $sql3 = "SELECT * FROM tblmasuk where idpallet='$_POST[nopall]' and mark ='o'";
  $result3 = sqlsrv_query($conn, $sql3); 
  
  $sql2 = "SELECT nama from subcontbaritori where nama='$_POST[opt]'";
  $result2 = sqlsrv_query($conn, $sql2);
  
  while ($row = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC)) 
	{
	$mark=$row['mark'];
	}
	
  while ($row3 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) 
	{
	$sin=$row3['nama'];
	}
  
  if ($myresult->num_rows == 0) {
	$msgmy="<h1 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
  	echo $msgmy;
	$_POST['partno'] = "";
	$_POST['cust'] = "";
	$_POST['opt'] = "";
  }else if ($mark != "") {
	$msgmx="<h1 style='color:red;'>No Pallet Sudah Terisi!</h2>";
  	echo $msgmx;
	$_POST['partno'] = "";
	$_POST['cust'] = "";
	$_POST['opt'] = "";
  }else{
	$mysql1 = "UPDATE pallet set masuk=0,keluar=1,balance=0,cust='$_POST[opt]',produk=null WHERE nopallet='$_POST[nopall]' and aktif=1";
	$mysqlconn->query($mysql1);
	$msg="<h2 style='color:blue;'>Berhasil Tersimpan $sin</h2>";
  	echo $msg;
	$_POST['partno'] = "";
	$_POST['cust'] = "";
	$_POST['opt'] = "";
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
<!-- <div class="container"> -->
<style>
h1 {
    color: red;
}
h2 {
	color: blue;
}
</style>

	<title>
	<?php echo "Pallet Keluar"; ?>
	</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
   <link href="css/bootstrap.min.css" rel="stylesheet"></link>
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
	<!-- <a href="http://10.63.96.242:8080/fgbs/indexpallet.php?" style='color:blue'><b>Kembali</b></a> -->
	<a href="index.php" style='color:blue'hidden ><b>Kembali</b></a>
	<form action="index.php">
		<input type="submit" value="Kembali"/>
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
	<div class='container'>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset style="width:100%">
	<legend><b>Pallet Keluar Baritori</b></legend>
		&nbsp;&nbsp;&nbsp;	
		<label><b>Subcount :</b></label>
		</br>&nbsp;&nbsp;&nbsp;
		<select name="cust" id="cust" style="font-size:24pt;height:45px;width:90%" onchange="myFunction()">
				<option value="" disabled="disabled" selected="true"></option>
			<?php            
				$sql = "SELECT nama from subcontbaritori where nama <> 'REPAIR' order by nama asc";
				$result = sqlsrv_query( $conn, $sql); 
				//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
               { ?>
			   
              <option value="<?php echo $row['nama'];?>" <?php if(isset($_POST['cust']) && $_POST['cust'] ==$row['nama']) echo 'selected';?>>
			  <?php echo $row['nama'] ?>
				</option>           
              <?php
               }

              ?>
			  <option value="REPAIR PALLET">REPAIR PALLET</option>
      </select>
	  <input type="text" id="opt" name="opt" style="display: none;">
	  <p>&nbsp;&nbsp;&nbsp;&nbsp;<label><b>No Pallet :</b></label>
	  </br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nopall" id="nopall" autocomplete="off" autofocus required maxlength="10" style="font-size:24pt;height:45px;width:90%"/></p>
		<script>
 		   if (!("autofocus" in document.createElement("input"))) {
   			   document.getElementById("nopall").focus();
  			}
 		</script>
	<p>
	</fieldset>	
	<input type="submit" style="height:0;line-height:0;border:0;width:0" hidden>
	</form>
	</div>
	<script src="js/jquery-1.12.0.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
	</body>
	</html>