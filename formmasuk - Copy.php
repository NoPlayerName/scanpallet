<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
   <link href="css/bootstrap.min.css" rel="stylesheet"></link>
   
   <!-- <link rel="shortcut icon" href="image/images.png" />
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
<body>
<h2 id='h2' style='color: red'></h2>
<form action="index.php">
    <input type="submit" value="Kembali"/>
</form>
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
<form id='myform'>
<div class="container">
	<div class="form-group">
		<label>Part No :</label>
		<input type="text" name="partno" id="partno" style="font-size:15pt;height:35px;width:100%" tabIndex="1" value="" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('button1').click()">
		</p>
		<label>No Pallet :</label>
		<input type="text" name="nopall" id="nopall" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('button2').click()">
		</p>
		<label>No Rak :</label>
		<input type="text" name="norak" id="norak" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="" autocomplete="off" onkeypress="if(event.keyCode==13) document.getElementById('button3').click()">
	</div>	
 </div>
 </fieldset>
 <input type="text" name="refrak" id="refrak" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="" autocomplete="off" hidden>
 <input type="text" name="tbl" id="tbl" style="font-size:15pt;height:35px;width:100%" tabIndex="3" value="" autocomplete="off" hidden>
 
 <button type="button" name="button1" class="btn btn-primary btn-xs button button1" id="button1" style='display:none'>Part No</button>
 <button type="button" name="button2" class="btn btn-primary btn-xs button button2" id="button2" style='display:none'>No Pallet</button>
 <button type="button" name="button3" class="btn btn-primary btn-xs button button3" id="button3" style='display:none'>Save</button>
 </form>
 
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

<div class="container" id='divmodal' hidden>
<div class="modal fade container vertical-alignment-helper" id="modalitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog vertical-align-center" role="document" style='width:70%'>
	<br><br><br><br><br>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<!-- <h4 class="modal-title" id="myModalLabel">No Rak</h4> -->
			</div>
			<div class="modal-body" id="dataitem" style='font-size:30px' align='center'>
			</div>
			<div class="modal-body" id="datarak" style='font-size:20px;color:red' align='center'>
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
$(document).ready(function() {
	/* $('#modalitem').modal('show');
    $('#modalitem').modal('hide'); */
	$("#partno").focus();
});	

$(document).on('click', '.button1', function () {
	var partno = document.getElementById('partno').value;
			
		$.ajax({
			url: 'ajax/view.php',	
			method: 'post',		
			data: {partno:partno},		
			success:function(data){		
			$('#h2').html(data);
			}
		});
});

$(document).on('click', '.button2', function () {
	var nopall = document.getElementById('partno').value;
			
		$.ajax({
			url: 'ajax/view.php',	
			method: 'post',		
			data: {nopall:nopall},		
			success:function(data){		
			$('#divmodal').modal("show");	
			$('#datarak').hide();
			$('#dataitem').show();
			$('#dataitem').html(data);
			$('#modalitem').modal("show");	
			}
		});
});

$('#modalitem').on('hidden.bs.modal', function (e) {
     $("#norak").focus();
 });
 
 $(document).on('click', '.button3', function () {
	var war = 'No Rak harus sesuai dengan referensi No Rak !';
	 
	var part = document.getElementById('partno').value;
	var pall = document.getElementById('nopall').value;
	var rak = document.getElementById('norak').value;
	var tbl = document.getElementById('tbl').value;
	
	var refrak = document.getElementById('refrak').value;
			
	if (rak == refrak){
		$.ajax({
			url: 'ajax/view.php',	
			method: 'post',		
			data: {part:part,pall:pall,rak:rak,tbl:tbl},		
			success:function(data){		
			$('#h2').html(data);
			document.getElementById("myform").reset();
			$("#partno").focus();
			}
		});
	}else{
		$('#divmodal').modal("show");	
		$('#dataitem').hide();
		$('#datarak').html(war);
		$('#datarak').show();
		$('#modalitem').modal("show");
		document.getElementById("norak").value = '';
	}
});
</script>