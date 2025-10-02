<?php
$partnoa="";
$partnamea="";
$kodeproduka="";
$stdpacka="";

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

if(isset($_POST['partno'])){
   $partno =htmlspecialchars($_POST["partno"]);
}
if(isset($_POST['partno'])){
  $sql = "SELECT partno, partname, kodeproduk, stdpacking, tanpanopallet from tblproduk where partno='$partno' and ket = 'active'";
  $result = sqlsrv_query($conn, $sql); 
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partnoa=$row['partno'];
	$partnamea=$row['partname'];
	$kodeproduka=$row['kodeproduk'];
	$stdpacka=$row['stdpacking'];
	$tnp=$row['tanpanopallet'];		
}
if ($partnoa == "" ) {
	$msgs="<h2 style='color:red;'>Partno Tidak Aktif!</h2>";
	echo $msgs;
}else if ($tnp != 1 ) {
	$msgs="<h2 style='color:red;'>Bukan Produk Iseki!</h2>";
	echo $msgs;
}else{
	$query="INSERT INTO tblmasuk (partno,partname,qty,createdatetime,mark) VALUES('$partnoa','$partnamea','$stdpacka',getdate(),'o')";
	$stmt = sqlsrv_query( $conn, $query); 
	$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan $kodeproduka</h3>";
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
   <link href="css/bootstrap.min.css" rel="stylesheet"></link>
   <?php $stda=isset($_POST["stdpack"]); ?>
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

function setFocusToTextBox(){
    var textbox = document.getElementById("partno");
    textbox.select();
    textbox.scrollIntoView();
}

 function scroll()
  {  
    window.scrollBy(0,50);
  }
  
function OnButton1()
{
  alert("Button code executed.");
  return true;
}
</script>
	<body onload="form1.partno.focus()">
	<form action="indexiseki.php">
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