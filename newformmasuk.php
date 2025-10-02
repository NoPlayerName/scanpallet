<?php
$partnoa="";
$partnamea="";
$nopalla="";
$snp="";
$kett="";
$snpa="";
$kp="";
$partno2="";

include('koneksi.php');
if(isset($_POST['partno'])){
switch ($_REQUEST['btn_submit'])
{
case "submit1":
  $sql = "SELECT partno, partname, stdpacking, kodeproduk, ket from produkaktif where partno = '$_POST[partno]'";
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
$msgc="<h3 style='color:blue;'>$kp dan DIFF CASE M002</h3>";
echo $msgc;
}else{
$msgc="<h3 style='color:blue;'>$kp</h3>";
echo $msgc;
}
}
if ($result) {
   $rowsa = sqlsrv_has_rows( $result );
   if ($rowsa === false){
        $msgmy="<h2 style='color:red;'>Part No tidak Aktif/Terdaftar..Pastikan Part No sudah diaktifkan!</h2>";
		echo $msgmy;
		$_POST['partno'] = "";
	echo "<body onload='form1.partno.focus()'>";
	}
}
break;
}
}




if(isset($_POST['nopall'])){
switch ($_REQUEST['btn_submit'])
{
case "submit2":

	$no = $_POST['nopall'];
	$hasil = substr("$no",0,1);
	
  $mysql = "SELECT * FROM cekpallet WHERE nopallet='$_POST[nopall]'";
  $myresult = $mysqlconn->query($mysql);
  $rowcount=mysqli_num_rows($myresult);
  
  $sqla = "select idpallet from viewmasuk where idpallet='$_POST[nopall]'";
  $resulta = sqlsrv_query( $conn, $sqla); 
  $rowsa = sqlsrv_has_rows( $resulta );
	

  $sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$_POST[partno2]'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno2=$row['partno'];
		$partname2=$row['partname'];
		$snp2=$row['stdpacking'];
		$kett2=$row['ket'];
		$kop=$row['kodeproduk'];
	/* echo $partno2;
	echo "<br />";
	echo $partname2;
	echo "<br />";
	echo $snp2;
	echo "<br />";
	echo $kett2;
	echo "<br />";
	echo $kop;
	echo "<br />"; */
	echo "<body onload='form1.partno.focus()';scroll()>";
	}
	
  
	if(($_POST['partno2'])==""){
		$msg3="<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}else if (strlen($_POST['nopall']) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	}else if ($rowsa === true){
		$msgmy="<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	}else if ($hasil == 9 && $_POST['partno2'] == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o'),('MC075509','DIFF CASE RH','$snp2','$_POST[nopall]',getdate(),'o')";
		$stmta = sqlsrv_query( $conn, $querya);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($hasil == 9 && $_POST['partno2'] !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$_POST[nopall]')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($rowcount === 0) {
		$msgmy="<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	}else if ($rowcount !== 0 && $_POST['partno2'] == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o'),('MC075509','DIFF CASE RH','$snp2','$_POST[nopall]',getdate(),'o')";
		$stmta = sqlsrv_query( $conn, $querya);
		
		$mysql = "UPDATE pallet set produk = '$kop+DIFF CASE M002' WHERE nopallet='$_POST[nopall]' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($rowcount !== 0 && $_POST['partno2'] !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$_POST[nopall]')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark) VALUES('$partno2','$partname2','$snp2','$_POST[nopall]',getdate(),'o')
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		
		$mysql = "UPDATE pallet set produk = '$kop' WHERE nopallet='$_POST[nopall]' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
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
	<?php echo "Form Masuk"; ?>
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

function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
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
	<input type="text" name="kp" id="kp" hidden style="font-size:15pt;height:35px;width:100%" value="<?php echo isset($kp) ? $kp : '' ?>" autocomplete="off"></p>
	<fieldset class="fsStyle">
	<div class="container">
	<legend class="legendstyle">
	<label style="font-size:20pt">Form Masuk</label>
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