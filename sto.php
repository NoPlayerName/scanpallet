<?php
$partnoa="";
$partnamea="";
$nopalla="";
$snp="";
$kett="";
$snpa="";
$kp="";
$partno2="";

/* $serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"timepro");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */
require_once("koneksi.php");
if(isset($_POST['partno'])){
switch ($_REQUEST['btn_submit'])
{
case "submit1":
  $sql = "SELECT partno, partname, stdpacking, kodeproduk, ket from tblproduk where partno = '$_POST[partno]'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partnoa=$row['partno'];
	$partnamea=$row['partname'];
	$snp=$row['stdpacking'];
	$kett=$row['ket'];
	$kp=$row['kodeproduk'];
//echo $partnoa;
//echo "<br />";
echo "<body onload='form2.nopall.focus()'>";
if ($partnoa == "MC075508" ) {
$msgc="<h3 style='color:blue;'>$kp dan DIFF CASE RH</h3>";
echo $msgc;
}else{
$msgc="<h3 style='color:blue;'>$kp</h3>";
echo $msgc;
}
}
echo "<body onload='form2.nopall.focus()'>";
break;
}
}
if(isset($_POST['nopall'])){
switch ($_REQUEST['btn_submit'])
{
case "submit2":

 $sql = "SELECT partno, partname, stdpacking, ket from tblproduk where partno = '$_POST[partno2]'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partno2=$row['partno'];
	$partname2=$row['partname'];
	$snp2=$row['stdpacking'];
	$kett2=$row['ket'];
//echo $partnoa;
//echo "<br />";
echo "<body onload='form1.partno.focus()';scroll()>";
}

$no = $_POST['nopall'];
$hasil = substr("$no",0,1);

$sql2 = "SELECT sto.partno,sto.partname, tblproduk.kodeproduk
                                FROM sto
                                INNER JOIN tblproduk ON sto.partno = tblproduk.partno
								where sto.partno = '$partno2'
                                order by partname asc";
  $result2 = sqlsrv_query($conn, $sql2); 
  
  while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) 
{
	$kop=$row2['kodeproduk'];
		
}

$sqla = "select idpallet from sto where idpallet='$_POST[nopall]' and mark='o'";
  $resulta = sqlsrv_query( $conn, $sqla); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($rowa = sqlsrv_fetch_array($resulta, SQLSRV_FETCH_ASSOC)) 
{
	$nopalla=$rowa['idpallet'];
//echo $partnoa;
//echo "<br />";
}	if ($_POST['partno2'] == "" ) {
   $msg="<h2 style='color:red;'>Part No tidak ditemukan..Pastikan Part No sudah terdaftar!</h2>";
   echo $msg;
   $_POST['partno'] = "";
	}else if (strlen($_POST['nopall']) != 4 ) {
	$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
	echo $msg3;
	$_POST['partno'] = "";
	}else if ($nopalla != "" ) {
	$msga="<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
	echo $msga;
	$_POST['partno'] = "";
	}else if ($_POST['nopall'] == "" ) {
	$msg3="<h2 style='color:red;'>No Pallet Tidak Boleh Kosong!</h2>";
	echo $msg3;
	$_POST['partno'] = "";
	}else if ($hasil == 9) {
		if ($_POST['partno2'] == "MC075508" ) {
	 try{
	$querya="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')";
	$stmta = sqlsrv_query( $conn, $querya);  
	$queryb="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('MC075509','DIFF CASE RH','30','$_POST[nopall]',getdate(),'o')";
	$stmtb = sqlsrv_query( $conn, $queryb);
	
	$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
	echo $msgs;
	echo "<br \>";
	$_POST['partno'] = "";
	}
  catch  (Exception $e) {
  echo $e;
  }
  }
	else {
	 try{
	$query="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')";
	$stmt = sqlsrv_query( $conn, $query); 
	
	$msgx="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
	echo $msgx;
	echo "<br \>";
	$_POST['partno'] = "";
	}
  catch  (Exception $e) {
  echo $e;
  }
  }
}else if ($kett2 == "Inactive" ) {
	$msgk="<h2 style='color:red;'>Part No tidak Aktif..Pastikan Part No sudah diaktifkan!</h2>";
	echo $msgk;
	$_POST['partno'] = "";
	}else if ($snp2 == "" or $snp2 == 0) {
	$msg4="<h2 style='color:red;'>Tidak ada Standart Packing!</h2>";
	echo $msg4;
	$_POST['partno'] = "";
	}else if ($_POST['partno2'] == "MC075508" ) {
	 try{
	$querya="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')";
	$stmta = sqlsrv_query( $conn, $querya);  
	$queryb="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('MC075509','DIFF CASE RH','30','$_POST[nopall]',getdate(),'o')";
	$stmtb = sqlsrv_query( $conn, $queryb);
	
	$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
	echo $msgs;
	echo "<br \>";
	$_POST['partno'] = "";
	}
  catch  (Exception $e) {
  echo $e;
  }
  }
	else {
	 try{
	$query="INSERT INTO sto (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')";
	$stmt = sqlsrv_query( $conn, $query); 
	
	$msgx="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
	echo $msgx;
	echo "<br \>";
	$_POST['partno'] = "";
	}
  catch  (Exception $e) {
  echo $e;
  }
  }
}
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
	<?php echo "Stock Opname"; ?>
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
    var textbox = document.getElementById("nopall");
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
	<fieldset class="fsStyle">
	<div class="container">
	<legend class="legendstyle">
	<label style="font-size:20pt">Stock Opname</label>
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
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form2" id="form2">
		<div class="form-group">
		<label>No Pallet :</label>
		<input type="text" name="nopall" id="nopall" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="<?php echo isset($_GET['nopall']) ? $_GET['nopall'] : '' ?>" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('submit2').click()">
		</div>
		<input type="submit" name="btn_submit" id="submit2" value="submit2" tabIndex="4" style="display:none;">
	  </div>
	</fieldset>	
	<input type="text" name="partno2" id="partno2" value="<?php echo $partnoa ?>" style="display: none;">
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
 <form>
 </form>  
</body>	
</html>