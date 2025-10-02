<?php
$partnoa="";
$partnamea="";
$nopalla="";

/* $mysqlservername = "localhost";
$mysqlusername = "root";
$mysqlpassword = "";
$mysqldbname = "palletdb";
$mysqlconn = new mysqli($mysqlservername, $mysqlusername, $mysqlpassword, $mysqldbname);
//$partno =htmlspecialchars($_POST["partno"]);
$serverName = "HCG0001\HCG0001";
$connectionInfo = array( "Database"=>"fg", "UID"=>"sa", "PWD"=>"P@ssw0rd");
$conn = sqlsrv_connect( $serverName, $connectionInfo ); */

require_once("koneksi.php");

if(isset($_POST['nopall'])){
   $nopall =htmlspecialchars($_POST["nopall"]);
}
if(isset($_POST['nopall'])){
  $sql = "SELECT idpallet,partno, partname,norak, qty from tblmasuk where idpallet='$nopall' and mark ='o'";
  $result = sqlsrv_query($conn, $sql); 
  $sql2 = "SELECT tblmasuk.partno,tblmasuk.partname, tblproduk.kodeproduk,tblmasuk.norak
                                FROM tblmasuk
                                INNER JOIN tblproduk ON tblmasuk.partno = tblproduk.partno
								where tblmasuk.idpallet = '$nopall' and mark = 'o'
                                order by partname asc";
  $result2 = sqlsrv_query($conn, $sql2); 
  //$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  $sql3 = "SELECT singkat from tblcustomer where name='$_POST[opt]'";
  $result3 = sqlsrv_query($conn, $sql3); 
  
  
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
{
	$nopalla=$row['idpallet'];
	$partnoa=$row['partno'];
	$partnamea=$row['partname'];
	$stdpacka=$row['qty'];
	$norak=$row['norak'];
		
}
while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) 
{
	$kop=$row2['kodeproduk'];
		
}
while ($row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC)) 
{
	$sin=$row3['singkat'];
		
}
}

   
if(isset($_POST['nopall'])){ //check if form was submitted
	$dt = date('Y-m-d');
	 if ($nopalla == "" ) {
   $msg="<h2 style='color:red;'>No Pallet tidak ditemukan..Pastikan pallet sudah masuk!</h2>";
   echo $msg;
   $_POST['cust'] = "";
	}else if ($_POST['opt'] == "") {
	$msgk="<h2 style='color:red;'>Customer Tidak Boleh Kosong!</h2>";
	echo $msgk;
	}else if ($partnoa == "MC075509" ) {
	 try{  
	$queryb="INSERT INTO tblkeluar (partno,partname,qty,idpallet,createdatetime,customer,norak) VALUES('MC075508','DIFF CASE LH',30,'$nopalla',getdate(),'$_POST[cust]','$norak')";
	$stmtb = sqlsrv_query($conn, $queryb); 
	$sqls="update tblmasuk set mark='x' where idpallet='$nopalla' and partno='MC075508' and partname='DIFF CASE LH' and qty=30";
	$rests = sqlsrv_query($conn, $sqls);
	$sqlt="update transaksi set tglkeluar = GETDATE(), produkkeluar = 'DIFF CASE M001', keluar = '30', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
	$restt = sqlsrv_query($conn, $sqlt);	
	 	
	$sqla="update tblmasuk set mark='x' where idpallet='$nopalla' and partno='$partnoa' and partname='$partnamea' and qty='$stdpacka'";
	$resta = sqlsrv_query($conn, $sqla);
	$query="INSERT INTO tblkeluar (partno,partname,qty,idpallet,createdatetime,customer,norak) VALUES('$partnoa','$partnamea','$stdpacka','$nopalla',getdate(),'$_POST[cust]','$norak')";
	$stmt = sqlsrv_query($conn, $query);
    $sql1="update transaksi set tglkeluar = GETDATE(), produkkeluar = '$kop', keluar = '$stdpacka', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
	$restt1 = sqlsrv_query($conn, $sql1);	
	
	$rak="Update tblrak set ket = 1, partno = 0, kodeproduk = 0 where norak = '$norak'";
	$queryrak = sqlsrv_query($conn, $rak);
	/* $rakopt="Update tblrakopt set ket = 1 where norak = '$norak'";
	$queryrakopt = sqlsrv_query($conn, $rakopt); */
	
	$mysql = "INSERT INTO transaksi (tgl,nopallet,lokasi,keluar,produk,createdatetime)
	VALUES ('$dt','$_POST[nopall]','AICC',1,'DIFF CASE M001+$kop', NOW())";
	$mysqlconn->query($mysql);
	$mysql2 = "INSERT INTO transaksi (tgl,nopallet,lokasi,masuk,produk,createdatetime)
	VALUES (DATE(NOW()),'$_POST[nopall]','$sin,'1','DIFF CASE M001+$kop', NOW())";
	$mysqlconn->query($mysql2);
	
	$mysql1 = "UPDATE pallet set masuk=0,keluar=1,balance=0,cust='$sin',produk='DIFF CASE M001+$kop' WHERE nopallet='$_POST[nopall]' and aktif=1";
	$mysqlconn->query($mysql1);
	 
	
	$msgs="<h2 style='color:blue;'>Berhasil Tersimpan $sin, DIFF CASE M001+$kop</h2>";
	echo $msgs;
	echo "<br />";
	$_POST['cust'] = "";
	 }
  catch  (Exception $e) {
  echo $e;
  }
  }else {
	try{
	$sqla="update tblmasuk set mark='x' where idpallet='$nopalla' and partno='$partnoa' and partname='$partnamea' and qty='$stdpacka'";
	$resta = sqlsrv_query($conn, $sqla);
	$query="If Not Exists(select * from tblkeluar where idpallet='$nopalla' and left(createdatetime, 16)= left(getdate(), 16)) 
				Begin
				INSERT INTO tblkeluar (partno,partname,qty,idpallet,createdatetime,customer,norak) VALUES('$partnoa','$partnamea','$stdpacka','$nopalla',getdate(),'$_POST[cust]','$norak')
			End";
	$stmt = sqlsrv_query($conn, $query); 
	$sql1="update transaksi set tglkeluar = GETDATE(), produkkeluar = '$kop', keluar = '$stdpacka', balance = 0, cust = '$sin' WHERE idpallet = '$nopalla' and balance = 1";
	$restt1 = sqlsrv_query($conn, $sql1);
	$rak="Update tblrak set ket = 1, partno = 0, kodeproduk = 0 where norak = '$norak'";
	$queryrak = sqlsrv_query($conn, $rak);
	/* $rakopt="Update tblrakopt set ket = 1 where norak = '$norak'";
	$queryrakopt = sqlsrv_query($conn, $rakopt); */
	
	
	$mysql = "INSERT INTO transaksi (tgl,nopallet,lokasi,keluar,produk,createdatetime)
	VALUES ('$dt','$_POST[nopall]','AICC',1,'$kop', NOW())";
	$mysqlconn->query($mysql);
	$mysql2 = "INSERT INTO transaksi (tgl,nopallet,lokasi,masuk,produk,createdatetime)
	VALUES (DATE(NOW()),'$_POST[nopall]','$sin','1','$kop', NOW())";
	$mysqlconn->query($mysql2);
	
	$mysql1 = "UPDATE pallet set masuk=0,keluar=1,balance=0,cust='$sin',produk='$kop' WHERE nopallet='$_POST[nopall]' and aktif=1";
	$mysqlconn->query($mysql1);
	$msgx="<h2 style='color:blue;'>Berhasil Tersimpan $sin, $kop</h2>";
	echo $msgx;
	echo "<br />";
	$_POST['cust'] = "";
}
  catch  (Exception $e) {
  echo $e;
  }
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
	<?php echo "Form Keluar"; ?>
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
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset class="fsstyle">
	<div class="container">
	<legend class="legendstyle">
	<label style="font-size:20pt">Form Keluar</label>
	</legend>
	</div>
	<div class="container">
	<div class="form-group">
		<label>Customer :</label>
		<select name="cust" id="cust" style="font-size:15pt;height:35px;width:100%" onchange="myFunction()">
				<option value="" disabled="disabled" selected="true"></option>
          <?php            
				$sql = "SELECT name from tblcustomer order by name asc";
				$result = sqlsrv_query( $conn, $sql); 
				//$resulta = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)
  
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) 
               { ?>
			   
              <option value="<?php echo $row['name'];?>" <?php if(isset($_POST['cust']) && $_POST['cust'] ==$row['name']) echo 'selected';?>>
			  <?php echo $row['name'] ?>
				</option>           
              <?php
               }

              ?>
      </select>
	  <input type="text" id="opt" name="opt" style="display: none;">
	  </div>
	<div class="form-group">
			<label>No Pallet :</label>
		<input type="text" name="nopall" id="nopall" autocomplete="off" autofocus required maxlength="10" style="font-size:15pt;height:35px;width:100%"/></p>
		<script>
 		   if (!("autofocus" in document.createElement("input"))) {
   			   document.getElementById("nopall").focus();
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