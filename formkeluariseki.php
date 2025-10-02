<?php
$ida="";
$partnoa="";
$partnamea="";
$qtya="";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */
require_once("koneksi.php");

if(isset($_POST['partno'])){
   $partno =htmlspecialchars($_POST["partno"]);
}
if(isset($_POST['partno'])){
  $sql = "SELECT min(id)id from tblmasuk where partno='$partno' and mark ='o'";
  $result = sqlsrv_query($conn, $sql); 
  
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$ida=$row['id'];
		
	$sqli = "SELECT partno, partname, qty from tblmasuk where id='$ida'";
	$resulti = sqlsrv_query($conn, $sqli); 
	while ($rowi = sqlsrv_fetch_array($resulti, SQLSRV_FETCH_ASSOC)) 
	{
		$partnoa=$rowi['partno'];
		$partnamea=$rowi['partname'];
		$qtya=$rowi['qty'];
	}
}

if ($ida == "" ) {
	$msgs="<h2 style='color:red;'>Part No tidak ditemukan..Pastikan Part No sudah masuk!</h2>";
	echo $msgs;
}else if ($_POST['opt'] == "" ) {
	$msgs="<h2 style='color:red;'>Cutblmasukmer Tidak Boleh Kosong!</h2>";
	echo $msgs;
}else{
	$query="update tblmasuk set mark = 'x' where id='$ida'";
	$stmt = sqlsrv_query( $conn, $query);
	$query2="INSERT INTO tblkeluar (partno,partname,qty,createdatetime,Customer) VALUES('$partnoa','$partnamea','$qtya',getdate(),'$_POST[opt]')";
	$stmt2 = sqlsrv_query( $conn, $query2); 
	
	$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan $_POST[opt]</h3>";
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
	document.getElementById('partno').focus();
}
</script>
   
	<body>
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
		<input type="text" name="partno" id="partno" autocomplete="off" autofocus required style="font-size:15pt;height:35px;width:100%"/></p>
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