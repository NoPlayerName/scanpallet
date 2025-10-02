<?php
include('koneksi.php');

$sql = "select tblmasuk.id, tblmasuk.idpallet, tblmasuk.partno, tblmasuk.partname, tblproduk.kodeproduk, tblmasuk.qty
                            from tblmasuk
							inner join tblproduk on tblmasuk.partno = tblproduk.partno
							where mark = 'o'
                            group by tblmasuk.id, tblmasuk.idpallet, tblmasuk.partno, tblmasuk.partname, tblproduk.kodeproduk, tblmasuk.qty
                            order by tblmasuk.partname asc";
$result = sqlsrv_query( $conn, $sql); 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stock Finished Goods</title>
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
  <!-- responsive -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="stok.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>FG</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Stock</b>&nbsp;FG</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class='active'><a href="index2.php"><i class="fa fa-circle-o"></i>Data Stock</a></li>
			<!-- <li><a href="index.php"><i class="fa fa-circle-o"></i> PRS</a></li>
            <li><a href="mon.php"><i class="fa fa-circle-o"></i> Monitoring PRS</a></li> -->
          </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		Data Stock
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
	<section class="content">
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
				<table id="example" class="table table-bordered table-striped display">
					<thead bgcolor="#E8EAE9">
							<th style='width:5%'>No.</th>
							<th>No Pallet</th>
							<th>Part No</th>
							<th>Part Name</th>
							<th>Kode Produk</th>
							<th>Qty</th>
							<th>Delete</th>
					</thead>
					<tbody>
							<?php
							$no = 1;
							while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
							?>
							<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $data["idpallet"]; ?></td>
							<td><?php echo $data["partno"]; ?></td>
							<td><?php echo $data["partname"]; ?></td>
							<td><?php echo $data["kodeproduk"]; ?></td>
							<td><?php echo $data["qty"]; ?></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs button del_data" id='<?php echo $data["id"];?>'><span class="glyphicon glyphicon-trash"></span></button></td>
							</tr>
							<?php $no++; } ?>
					</tbody> 	
				</table>
			</div>
		</div>
		</div>
		</div>
    </section>
    <!-- /.content -->
  </div>


<!-- jQuery 3 -->
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
<!-- Responsive -->
<script language="JavaScript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script language="JavaScript" src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js" type="text/javascript"></script>
<!-- bootbox -->
<script src='bootbox/bootbox.min.js'></script>
<!-- page script -->
</body>
</html>

<script type="text/javascript" language="javascript" >
$(document).ready(function() {
	 $('#example').DataTable()
  });
  
  	  // Delete 
  $('.del_data').click(function(){
    var el = this;
    var id = this.id;
  
    // Confirm box
    bootbox.confirm("Are you sure want to delete?", function(result) {
 
       if(result){
         // AJAX Request
         $.ajax({
           url: 'pages/del_index.php',
           type: 'POST',
           data: { id:id },
           success: function(response){

             // Removing row from HTML Table
             $(el).closest('tr').css('background','tomato');
             $(el).closest('tr').fadeOut(800, function(){ 
               $(this).remove();
             });

           }
         });
       }
 
    });
 
  });
</script>