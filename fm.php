<?php
$partnoa="";
$partnamea="";
$nopalla="";
$snp="";
$kett="";
$snpa="";
$kp="";
$partno2="";
$modals="";

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
$modals = '1';
}

if(isset($_POST['nopall'])){
switch ($_REQUEST['btn_submit'])
{
case "submit2":

	$sql = "IF EXISTS (SELECT * FROM tblrak WHERE partno = '$_POST[partno2]' and ket = 1) 
				BEGIN
				   SELECT id, partno, kodeproduk, norak, ket, tbl='tblrak'
				   FROM tblrak WHERE partno = '$_POST[partno2]' and ket = 1 
				   order by norak desc
				END
			ELSE
				BEGIN
				   SELECT id, partno, kodeproduk, norak, ket, tbl='tblrakopt'
				   FROM tblrakopt WHERE partno = '$_POST[partno2]' and ket = 1
				   order by norak desc
			END";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$partnoa=$row['partno'];
	$norak=$row['norak'];
	$tbl=$row['tbl'];
	
}
	echo $partnoa.', '.$norak.', '.$tbl;
	echo "<body onload='form3.norak.focus()'>";
}
}


if(isset($_POST['norak'])){
switch ($_REQUEST['btn_submit'])
{
case "submit3":
	
	$partnoa = $_POST['partno3'];
	$nopall = $_POST['nopall3'];
	$norak = $_POST['norak'];
	$tbl = $_POST['tblrak'];
	/* echo $partnoa.' / '.$nopall.' / '.$norak; */
	
	$nopall = $_POST['nopall3'];
	$hasil = substr("$nopall",0,1);
	
  $mysql = "SELECT * FROM cekpallet WHERE nopallet='$nopall'";
  $myresult = $mysqlconn->query($mysql);
  $rowcount=mysqli_num_rows($myresult);
  
  $sqla = "select idpallet from viewmasuk where idpallet='$nopall'";
  $resulta = sqlsrv_query( $conn, $sqla); 
  $rowsa = sqlsrv_has_rows( $resulta );
	

  $sql = "SELECT partno, partname, stdpacking, ket, kodeproduk from tblproduk where partno = '$partnoa'";
  $result = sqlsrv_query( $conn, $sql); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
   
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
	{
		$partno2=$row['partno'];
		$partname2=$row['partname'];
		$snp2=$row['stdpacking'];
		$kett2=$row['ket'];
		$kop=$row['kodeproduk'];
	
	echo "<body onload='form1.partno.focus()';scroll()>";
	}
	
  
	if(($partnoa)==""){
		$msg3="<h2 style='color:red;'>Part No Tidak Boleh Kosong!</h2>";
		echo $msg3;
	}else if (strlen($nopall) != 4 ) {
		$msg3="<h2 style='color:red;'>No Pallet Salah!</h2>";
		echo $msg3;
	}else if ($rowsa === true){
		$msgmy="<h2 style='color:red;'>No Pallet tidak bisa masuk jika belum transaksi keluar!</h2>";
		echo $msgmy;
	}else if ($hasil == 9 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o'),('MC075509','DIFF CASE RH','$snp2','$_POST[nopall]',getdate(),'o','$norak')";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update $tbl set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($hasil == 9 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
					update tblrak set ket = 0 where norak = '$norak'
					update tblrakopt set ket = 0 where norak = '$norak'
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($rowcount === 0) {
		$msgmy="<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk di Pallet Navigation!</h2>";
		echo $msgmy;
	}else if ($rowcount !== 0 && $partnoa == "MC075508") {
		$querya="INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o'),('MC075509','DIFF CASE RH','$snp2','$nopall',getdate(),'o','$norak')";
		$stmta = sqlsrv_query( $conn, $querya);
		$queryr="update tblrak set ket = 0 where norak = '$norak'";
		$stmtr = sqlsrv_query( $conn, $queryr);
		$queryr2="update tblrakopt set ket = 0 where norak = '$norak'";
		$stmtr2 = sqlsrv_query( $conn, $queryr2);
		
		$mysql = "UPDATE pallet set produk = '$kop+DIFF CASE M002' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}else if ($rowcount !== 0 && $partnoa !== "MC075508") {
		$querya="If Not Exists(select * from viewmasuk where idpallet='$nopall')
					Begin
					INSERT INTO tblmasuk (partno,partname,qty,idpallet,createdatetime,mark,norak) VALUES('$partno2','$partname2','$snp2','$nopall',getdate(),'o','$norak')
					update tblrak set ket = 0 where norak = '$norak'
					update tblrakopt set ket = 0 where norak = '$norak'
				End";
		$stmta = sqlsrv_query( $conn, $querya);
		
		$mysql = "UPDATE pallet set produk = '$kop' WHERE nopallet='$nopall' and aktif=1";
		$mysqlconn->query($mysql);
		$msgs="<h3 style='color:blue;'>Data Berhasil Di Simpan</h3>";
		echo $msgs;
		echo "<br \>";
		$_POST['partno'] = "";
	}
}
}


/* if(isset($_POST['nopall'])){
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
} */

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
   
   <link rel="shortcut icon" href="image/images.png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  
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
<h2 id='h2' style='color: red'></h2>
<h3 id='h3' style='color: blue'></h3>
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
  
  .vertical-alignment-helper {
    display:table;
    height: 100%;
    width: 100%;
}
  
  .vertical-align-center {
    /* To center vertically */
    display: table-cell;
    vertical-align: topmiddle;
	
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
		<input type="text" name="nopall" id="nopall" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="<?php echo isset($_GET['nopall']) ? $_GET['nopall'] : '' ?>" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('<?php echo $partnoa ?>').click()">
		</div>
		<!-- <input type="submit" name="btn_submit" id="submit2" value="submit2" tabIndex="4" style="display:none;"> -->
	 <input type="text" name="partno2" id="partno2" value="<?php echo $partnoa ?>" style="display: none;">
	
	</form>  
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form3" id="form3">
		<div class="form-group">
		<label>No Rak :</label>
		<input type="text" name="norak" id="norak" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="<?php echo isset($_GET['norak']) ? $_GET['norak'] : '' ?>" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('submit3').click()">
		</div>
		<input type="submit" name="btn_submit" id="submit3" value="submit3" tabIndex="4" style="display:none;">
		<input type="text" name="partno3" id="partno3" value="<?php echo $partnoa ?>" style="display: none;">
		<input type="text" name="nopall3" id="nopall3" style="display: none;">
		<input type="text" name="tblrak" id="tblrak" style="display: none;">
	</form>
 </div>
 </fieldset>
 <button type="button" name="infoax" class="btn btn-primary btn-xs button info_data" id="<?php echo $partnoa ?>" style='display:none'><span class="glyphicon glyphicon-info-sign"></span></button>
 <button type="button" name="infoview" class="btn btn-primary btn-xs button infoview" id="viewpartno" style='display:yes'><span class="glyphicon glyphicon-info-sign"></span></button>
<input type="text" name="modals" id="modals" style="display: yes;" value='<?php echo $modals; ?>'>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- bootbox -->
<script src='bootbox/bootbox.min.js'></script>
</body>	
</html>

<div class="container">
<div class="modal fade container vertical-alignment-helper" id="modalitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog vertical-align-center" role="document" style='width:70%'>
	<br><br><br><br><br>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">No Rak</h4>
			</div>
			<div class="modal-body" id="dataitem" style='font-size:30px' align='center'>
			</div>
			<!-- selesai konten dinamis -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style='font-size:12px'>Close</button>
			</div>
		</div>
	</div>
</div>
</div>




<script type="text/javascript" language="javascript" >
$(document).on('click', '.info_data', function () {
	var id = $(this).attr("id");
			
		$.ajax({
			url: 'ajax/view.php',	
			method: 'post',		
			data: {id:id},		
			success:function(data){		
			$('#dataitem').html(data);
			$('#modalitem').modal("show");	
			
			}
			});
		});

$(document).on('click', '.infoview', function () {
	var header = $(this).attr("id");
			
		$.ajax({
			url: 'ajax/view.php',	
			method: 'post',		
			data: {header:header},		
			success:function(data){		
			$('#h2').html(data);
			$('#h3').html(data);
			}
			});
		});

 
 if (document.getElementById('modals').value = '') {
  $('#modalitem').on('hidden.bs.modal', function (e) {
     $("#partno").focus();
	});
	
	$(window).on('load',function(){
        $('#modalitem').modal('show');
        $('#modalitem').modal('hide');
    }); 
} else {
  $('#modalitem').on('hidden.bs.modal', function (e) {
     $("#norak").focus();
	 document.getElementById('nopall3').value = document.getElementById('nopall').value;
 });
}
 
 /* $('#modalitem').on('hidden.bs.modal', function (e) {
     $("#norak").focus();
	 document.getElementById('nopall3').value = document.getElementById('nopall').value;
 }); */
 
 $('#modalbody').on('hidden.bs.modal', function (e) {
     $("#partno").focus();
});

 $(window).on('load',function(){
        $('#modalbody').modal('show');
        $('#modalbody').modal('hide');
 });

function back() {
  location.replace("index.php")
}
</script>