<?php
include 'akses.php';
@$fitur_id = 16;
include '../library/lock-menu.php';
@include '../library/tgl-indo.php';
$Page = 'Register';
$SubPage = 'TrRiwayatTera';
$TanggalTransaksi = date("Y-m-d H:i:s");

if(@$_GET['id']!=null){
	$Sebutan = 'Terima Pembayaran';	
	$Readonly = 'readonly';

	$query = mysqli_prepare($koneksi, "SELECT a.NamaPerson, b.IDPerson, b.NoTransaksi, c.IDTimbangan, b.TglTransaksi, b.NoRefDibayar, b.TglAmbil, b.NoSKRD FROM mstperson a JOIN tractiontimbangan b ON a.IDPerson = b.IDPerson LEFT JOIN trtimbanganitem c ON b.NoTransaksi = c.NoTransaksi WHERE b.NoTransaksi = ?");

	mysqli_stmt_bind_param($query, "s", $decodedID);

	$decodedID = base64_decode($_GET['id']);

	mysqli_stmt_execute($query);

	mysqli_stmt_bind_result($query, $NamaPerson, $IDPerson, $NoTransaksi, $IDTimbangan, $TglTransaksi, $NoRefDibayar, $TglAmbil, $NoSKRD);

	mysqli_stmt_fetch($query);

	$RowData = [
		'NamaPerson' => $NamaPerson,
		'IDPerson' => $IDPerson,
		'NoTransaksi' => $NoTransaksi,
		'IDTimbangan' => $IDTimbangan,
		'TglTransaksi' => $TglTransaksi,
		'NoRefDibayar' => $NoRefDibayar,
		'TglAmbil' => $TglAmbil,
		'NoSKRD' => $NoSKRD
	];

	mysqli_stmt_close($query);
	
	// @$Edit = mysqli_query($koneksi,"SELECT a.NamaPerson,b.IDPerson,b.NoTransaksi,c.IDTimbangan,b.TglTransaksi,b.NoRefDibayar,b.TglAmbil,b.NoSKRD	 FROM mstperson a join tractiontimbangan b on a.IDPerson=b.IDPerson left join trtimbanganitem c on b.NoTransaksi=c.NoTransaksi WHERE b.NoTransaksi='".base64_decode($_GET['id'])."'");
	// @$RowData = mysqli_fetch_assoc($Edit);
}else{
	$Sebutan = 'Tambah Data';	
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include 'title.php';?>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="../komponen/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="../komponen/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="../komponen/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
	<?php include 'style.php';?>
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../komponen/css/custom.css">
	<!-- Sweet Alerts -->
    <link rel="stylesheet" href="../library/sweetalert/sweetalert.css" rel="stylesheet">
	<!-- Datepcker -->
	<link rel="stylesheet" href="../library/Datepicker/dist/css/default/zebra_datepicker.min.css" type="text/css">
	<style>
	th {
		text-align: center;
	}
	.Zebra_DatePicker_Icon_Wrapper {
			width:100% !important;
	}
		
	.Zebra_DatePicker_Icon {
		top: 11px !important;
		right: 12px;
	}
	
	</style>
	<script type="text/javascript">
		function confirmation() {
			var answer = confirm("Apakah Anda yakin menghapus data ini ?")
			if (answer == true){
				window.location = "TrRiwayatTera.php";
				}
			else{
			alert("Terima Kasih !");	return false; 	
				}
			}
	</script>
  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
      <?php include 'header.php';?>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <?php include 'menu.php';?>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Riwayat Tera Timbangan</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
         <section class="tables"> 
            <div class="container-fluid">
                <div class="col-lg-12">
					<ul class="nav nav-pills">
						<li <?php if(@$id==null){echo 'class="active"';} ?>>
							<a href="#home-pills" data-toggle="tab"></a>&nbsp;
						</li>
						<li>
							<a href="#tambah-user" data-toggle="tab"></a>&nbsp;
						</li>
					</ul>
				  <div class="card">
					<div class="tab-content">
						<div class="tab-pane fade <?php if(@$_GET['id']==null){ echo 'in active show'; }?>" id="home-pills">
							<div class="card-header d-flex align-items-center">
							  <h3 class="h4">Tera Timbangan</h3>
							</div>
							<div class="card-body">							  
								<div class="col-lg-4 offset-lg-8">
									<form method="post" action="">
										<div class="form-group input-group">						
											<input type="text" name="keyword" class="form-control" placeholder="Nama..." value="<?php echo @$_REQUEST['keyword']; ?>">
											<span class="input-group-btn">
												<button class="btn btn-warning" type="submit">Cari</button>
											</span>
										</div>
									</form>
								</div>
							  <div class="table-responsive">  
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>No</th>
									  <th>Nama</th>
									  <th>Alamat</th>
									  <th>Jumlah Retribusi</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
									<?php
										include '../library/pagination1.php';
										// mengatur variabel reload dan sql
										@$keyword  = $_REQUEST['keyword'];
										$reload = "TrRiwayatTera.php?pagination=true&keyword=$keyword";
										// $sql =  "SELECT a.NoTransaksi,b.NamaPerson,b.AlamatLengkapPerson,b.IDPerson,a.TotalRetribusi,a.TglTransaksi FROM tractiontimbangan a join mstperson b on a.IDPerson=b.IDPerson Where b.JenisPerson LIKE '%Timbangan%' AND a.IsDibayar=b'1' AND a.IsDiambil=b'1' AND a.StatusTransaksi='SELESAI' AND b.UserName !='dinas' ";
										
										// if(@$_REQUEST['keyword']!=null){
										// 	$sql .= " AND b.NamaPerson LIKE '%".$_REQUEST['keyword']."%'  ";
										// }
										
										// $sql .=" ORDER BY a.TglTransaksi DESC";
										// $result = mysqli_query($koneksi,$sql);

										$sql = "SELECT a.NoTransaksi, b.NamaPerson, b.AlamatLengkapPerson, b.IDPerson, a.TotalRetribusi, a.TglTransaksi 
												FROM tractiontimbangan a 
												JOIN mstperson b ON a.IDPerson = b.IDPerson 
												WHERE b.JenisPerson LIKE '%Timbangan%' AND a.IsDibayar = b'1' AND a.IsDiambil = b'1' AND a.StatusTransaksi = 'SELESAI' AND b.UserName != 'dinas'";

										if (!empty($_REQUEST['keyword'])) {
											$sql .= " AND b.NamaPerson LIKE ?";
										}

										$sql .= " ORDER BY a.TglTransaksi DESC";

										$stmt = mysqli_prepare($koneksi, $sql);

										if (!empty($_REQUEST['keyword'])) {
											// Bind the parameter for the keyword search
											$keywordParam = '%' . $_REQUEST['keyword'] . '%';
											mysqli_stmt_bind_param($stmt, "s", $keywordParam);
										}

										mysqli_stmt_execute($stmt);

										$result = mysqli_stmt_get_result($stmt);
										
										//pagination config start
										$rpp = 15; // jumlah record per halaman
										$page = intval(@$_GET["page"]);
										if($page<=0) $page = 1;  
										@$tcount = mysqli_num_rows($result);
										$tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
										$count = 0;
										$i = ($page-1)*$rpp;
										$no_urut = ($page-1)*$rpp;
										//pagination config end				
									?>
									<tbody>
										<?php
										if($tcount == null OR $tcount === 0){
											echo '<tr class="odd gradeX"><td colspan="9" align="center"><strong>Tidak ada data</strong></td></tr>';
										} else {
											while(($count<$rpp) && ($i<$tcount)) {
												mysqli_data_seek($result,$i);
												@$data = mysqli_fetch_array($result);
											
										?>
										<tr class="odd gradeX">
											<td width="50px">
												<?php echo ++$no_urut;?> 
											</td>
											<td>
												<strong><?php echo $data ['NamaPerson']; ?></strong><br>
												<?php echo $data['NoTransaksi']."<br>"; ?>
												<?php echo 'Pada : '.@TanggalIndo($data['TglTransaksi']); ?>
											</td>
											<td>
												<?php echo $data ['AlamatLengkapPerson']; ?>
											</td>
											<td align="center">
												<?php echo "Rp ".number_format($data['TotalRetribusi']); ?>
											</td>
											<td width="100px" align="center">
												<?php if ($cek_fitur['ViewData'] =='1'){ ?>
													<a href="TrRiwayatTera.php?id=<?php echo base64_encode($data['NoTransaksi']);?>" title='Detil Riwayat Transaksi'><i class='btn btn-success btn-sm'><span class='fa fa-history '></span></i></a> 
												<?php } ?>
											</td>
										</tr>
										<?php
											$i++; 
											$count++;
											} 
										}
										
										?>
									</tbody>
								</table>
								<div><?php echo paginate_one($reload, $page, $tpages); ?></div>
							  </div>
							</div>
						</div>
						<div class="tab-pane fade <?php if(@$_GET['id'] != null ){ echo 'in active show'; }?>" id="tambah-user">
							<div class="card-header d-flex align-items-center">
							  <h3 class="h4"><?php echo $Sebutan; ?></h3>
							</div>
							<div class="card-body">
								<div class="row">
								  <div class="col-lg-12">
									<h5>Informasi Transaksi</h5>
									<div class="table-responsive">  
									<table class="table table-striped">
									  <tbody>
										<tr><td width="35%">Nama Lengkap</td><td width="1%">:</td><td><?php echo strtoupper($RowData['NamaPerson']);?></td></tr>
										<tr><td width="35%">No Transaksi</td><td width="1%">:</td><td><?php echo $RowData['NoTransaksi'];?></td></tr>
										<tr><td>Tanggal Transaksi</td><td>:</td><td><?php echo TanggalIndo($RowData['TglTransaksi']);?></td></tr>
										<tr><td>No SKRD</td><td>:</td><td><?php echo $RowData['NoSKRD'];?></td></tr>
										<tr><td>Tanggal Selesai</td><td>:</td><td><?php echo TanggalIndo($RowData['TglAmbil']);?></td></tr>
									  </tbody>
									</table>
									</div><hr>
									
									<h5>Detil Timbangan</h5>
										<div class="table-responsive">  
										<table class="table table-striped">
										  <thead>
											<tr>
											  <th></th>
											  <th>No</th>
											  <th>Nama Timbangan</th>
											  <th>Alamat</th>
											  <th>Hasil Tera</th>
											  <th>Tarif Retribusi</th>
											</tr>
										  </thead>
										  <tbody>
											<?php
												$sql =mysqli_query($koneksi, "SELECT a.NominalRetribusi,b.NamaTimbangan,d.NamaKelas,e.NamaUkuran,c.JenisTimbangan,f.NamaLokasi,a.NoUrutTrans,a.NoTransaksi,a.IDPerson,a.HasilAction1 
												FROM trtimbanganitem a 
												join timbanganperson b on  (a.IDTimbangan,a.KodeLokasi,a.IDPerson)=(b.IDTimbangan,b.KodeLokasi,b.IDPerson)  join msttimbangan c on c.KodeTimbangan=b.KodeTimbangan 
												join kelas d on (b.KodeTimbangan,b.KodeKelas)=(d.KodeTimbangan,d.KodeKelas) 
												join detilukuran e on (e.KodeTimbangan,e.KodeKelas,e.KodeUkuran)=(b.KodeTimbangan,b.KodeKelas,b.KodeUkuran) join lokasimilikperson f on (b.KodeLokasi,b.IDPerson)=(f.KodeLokasi,f.IDPerson) WHERE a.NoTransaksi='".$RowData['NoTransaksi']."' GROUP BY b.IDTimbangan,a.NoUrutTrans order by a.NoUrutTrans");
												$no_urut = 0;
												$count = mysqli_num_rows($sql);
												if($count == null OR $count === 0){
													echo '<tr class="odd gradeX"><td colspan="9" align="center"><b>Tidak Ada Data</b></td></tr>';
												} else {
													while($res = mysqli_fetch_array($sql)){
											?>
											<tr class="odd gradeX">
												<td>
													<?php if ($res['HasilAction1'] != 'TERA BATAL') { ?>	
														<a href="../library/html2pdf/cetak/SKHP.php?id=<?php echo $res['NoTransaksi']; ?>&itm=<?php echo $res['NoUrutTrans']?>"  target="_BLANK" title="Cetak SKHP" ><i class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></i></a>	
													<?php } ?>
												</td>
												<td width="50px">
													<?php echo ++$no_urut;?> 
												</td>
												<td>
													<?php echo "<strong>".$res['NamaTimbangan']."</strong> ".$res['NamaKelas']." ".$res['NamaUkuran']; ?>
												</td>
												<td>
													<?php echo $res['NamaLokasi']; ?>
												</td>
												<td>
													<?php echo $res['HasilAction1']; ?>
												</td>
												<td align="right">
													<?php 
														echo "<strong>".number_format($res ['NominalRetribusi'])."</strong>"; 
														$jumlah[] = $res['NominalRetribusi'];
													?>
												</td>
											</tr>
												<?php } ?>
											<tr style="background-color:#f0f0f0;">
												<td colspan="5" align="center">
													<strong>Total Retribusi</strong>
												</td>
												<td align="right">
													<?php echo number_format(array_sum(@$jumlah)); ?>
												</td>
											</tr>	
											<?php } ?>
										  </tbody>
										</table>
									</div><hr>	
									</div>
									<div class="col-lg-12">
										<a href="TrRiwayatTera.php"><span class="btn btn-danger">Kembali</span></a>
										<a href="../library/html2pdf/cetak/PrintSKRD.php?id=<?php echo base64_encode($RowData['NoTransaksi']); ?>"  target="_BLANK" title="Cetak SKRD" ><i class="btn btn-secondary"><span>View SKRD</span></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
                  </div>
                </div>
            </div>
          </section>
        </div>
      </div>
    </div>
	<!-- Modal Popup untuk Edit--> 
	<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	</div>
    <!-- JavaScript files-->
    <script src="../komponen/vendor/jquery/jquery.min.js"></script>
    <script src="../komponen/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../komponen/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../komponen/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../komponen/vendor/chart.js/Chart.min.js"></script>
    <script src="../komponen/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../komponen/js/charts-home.js"></script>
	<!-- Sweet Alerts -->
	<script src="../library/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- Main File-->
    <script src="../komponen/js/front.js"></script>	
	<!-- DatePicker -->
	<script type="text/javascript" src="../library/Datepicker/dist/zebra_datepicker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#time1').Zebra_DatePicker({format: 'Y-m-d'});
		});
	</script>
	<script type="text/javascript">
		// open modal lihat progress
	   $(document).ready(function () {
	   $(".open_modal_item").click(function(e) {
		  var no_trans = $(this).data("notransaksi");
		
		  var user = $(this).data("user");
		  var no_urut = $(this).data("nourut");
		  var aksi = $(this).data("aksi");
		  	   $.ajax({
					   url: "Modal/AddTeraTimbangan.php",
					   type: "GET",
					   data : {NoTransaksi: no_trans,login_id: user,NoUrutTrans: no_urut,Aksi: aksi},
					   success: function (ajaxData){
					   $("#ModalEdit").html(ajaxData);
					   $("#ModalEdit").modal('show',{backdrop: 'true'});
				   }
				});
			});
		});
		// open modal lihat progress
	   $(document).ready(function () {
	   $(".open_modal_edit").click(function(e) {
		  var no_trans = $(this).data("notransaksi");
		  var user = $(this).data("user");
		  var no_urut = $(this).data("nourut");
		  var aksi = $(this).data("aksi");
		  	   $.ajax({
					   url: "Modal/EditTeraTimbangan.php",
					   type: "GET",
					   data : {NoTransaksi: no_trans,login_id: user,NoUrutTrans: no_urut,Aksi: aksi},
					   success: function (ajaxData){
					   $("#ModalEdit").html(ajaxData);
					   $("#ModalEdit").modal('show',{backdrop: 'true'});
				   }
				});
			});
		});
	</script>

	<?php 
		
		@$NoTransaksi	= htmlspecialchars($_POST['NoTransaksi']);
		@$NoRefDibayar	= htmlspecialchars($_POST['NoRefDibayar']);
		@$Keterangan	= htmlspecialchars($_POST['Keterangan']);
		@$IsDibayar		= htmlspecialchars($_POST['IsDibayar']);
	
	//Simpan Transaksi Sidang Tera
	if(isset($_POST['SimpanTransaksi'])){
		//update 
		// $query = mysqli_query($koneksi,"UPDATE tractiontimbangan SET TglDibayar='$TanggalTransaksi', NoRefDibayar='$NoRefDibayar', KeteranganBayar='$Keterangan', IsDibayar='$IsDibayar' WHERE NoTransaksi='$NoTransaksi'");
		$query = "UPDATE tractiontimbangan SET TglDibayar=?, NoRefDibayar=?, KeteranganBayar=?, IsDibayar=? WHERE NoTransaksi=?";

		$stmt = mysqli_prepare($koneksi, $query);
		mysqli_stmt_bind_param($stmt, "ssssi", $TanggalTransaksi, $NoRefDibayar, $Keterangan, $IsDibayar, $NoTransaksi);

		$exe = mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);

		if ($exe){
			InsertLog($koneksi, 'Tambah Data', 'Transaksi Terima Pembayaran ', $login_id, $NoTransaksi, 'Transaksi Terima Pembayaran');
			echo '<script language="javascript">document.location="TrTerimaPembayaran.php";</script>';
		}else{
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Simpan Data Gagal!",
				text: " ",
				type: "error"
			  },
			  function () {
				window.location.href = "TrTerimaPembayaran.php";
			  });
			  </script>';
		}
	}
	
	//Hapus Transaksi Penerimaan
	if(base64_decode(@$_GET['aksi'])=='HapusTransaksi'){
		// mysqli_query($koneksi,"UPDATE tractiontimbangan SET TglTera=NULL, NoRefTera=NULL, KeteranganTera=NULL, IsDibayar=NULL, StatusTransaksi='PENERIMAAN' WHERE NoTransaksi='".htmlspecialchars(base64_decode(@$_GET['tr']))."'");
		
		// $HapusGambar = mysqli_query($koneksi,"SELECT FotoAction1,FotoAction2,FotoAction3 FROM trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."'");
		// $data=mysqli_fetch_array($HapusGambar);	
		
		// unlink("../images/TeraTimbangan/".$data['FotoAction1']."");
		// unlink("../images/TeraTimbangan/thumb_".$data['FotoAction1']."");
		// unlink("../images/TeraTimbangan/".$data['FotoAction2']."");
		// unlink("../images/TeraTimbangan/thumb_".$data['FotoAction2']."");
		// unlink("../images/TeraTimbangan/".$data['FotoAction3']."");
		// unlink("../images/TeraTimbangan/thumb_".$data['FotoAction3']."");
		$queryUpdate = "UPDATE tractiontimbangan SET TglTera=NULL, NoRefTera=NULL, KeteranganTera=NULL, IsDibayar=NULL, StatusTransaksi='PENERIMAAN' WHERE NoTransaksi=?";

		$stmtUpdate = mysqli_prepare($koneksi, $queryUpdate);

		mysqli_stmt_bind_param($stmtUpdate, "s", $decodedNoTransaksi);

		$decodedNoTransaksi = htmlspecialchars(base64_decode(@$_GET['tr']));

		mysqli_stmt_execute($stmtUpdate);

		mysqli_stmt_close($stmtUpdate);

		$querySelect = "SELECT FotoAction1, FotoAction2, FotoAction3 FROM trtimbanganitem WHERE NoTransaksi=?";
		
		$stmtSelect = mysqli_prepare($koneksi, $querySelect);
		if (!$stmtSelect) {
			die('Error in preparing the select statement: ' . mysqli_error($koneksi));
		}

		mysqli_stmt_bind_param($stmtSelect, "s", $decodedNoTransaksi);

		mysqli_stmt_execute($stmtSelect);

		mysqli_stmt_bind_result($stmtSelect, $fotoAction1, $fotoAction2, $fotoAction3);

		mysqli_stmt_fetch($stmtSelect);

		unlink("../images/TeraTimbangan/".$fotoAction1);
		unlink("../images/TeraTimbangan/".$fotoAction2);
		unlink("../images/TeraTimbangan/".$fotoAction3);

		unlink("../images/TeraTimbangan/thumb_".$fotoAction1);
		unlink("../images/TeraTimbangan/thumb_".$fotoAction2);
		unlink("../images/TeraTimbangan/thumb_".$fotoAction3);

		mysqli_stmt_close($stmtSelect);
		
		//update 
		// $edit = mysqli_query($koneksi,"UPDATE trtimbanganitem SET  FotoAction1=NULL, FotoAction2=NULL, FotoAction3=NULL, HasilAction1=NULL, HasilAction2=NULL, HasilAction3=NULL WHERE NoTransaksi='".htmlspecialchars(base64_decode(@$_GET['tr']))."'");
		$query = "UPDATE trtimbanganitem SET  FotoAction1=NULL, FotoAction2=NULL, FotoAction3=NULL, HasilAction1=NULL, HasilAction2=NULL, HasilAction3=NULL WHERE NoTransaksi=?";

		$stmt = mysqli_prepare($koneksi, $query);

		$noTransaksi = htmlspecialchars(base64_decode(@$_GET['tr']));
		mysqli_stmt_bind_param($stmt, "s", $noTransaksi);

		$edit = mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);	

		if($edit){
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Data Transaksi Penerimaan Timbangan', $login_id, base64_decode(@$_GET['tr']), 'Transaksi Proses Sidang Tera');
			echo '<script language="javascript">document.location="TrSidangTera.php"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
						type: "error"
					  },
					  function () {
						window.location.href = "TrSidangTera.php";
					  });
					  </script>';
		}
		
	}
	
	if(base64_decode(@$_GET['aksi'])=='Hapus'){
		// $HapusGambar = mysqli_query($koneksi,"SELECT FotoAction1,FotoAction2,FotoAction3 FROM trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."' and NoUrutTrans='".htmlspecialchars(base64_decode($_GET['nm']))."'");
		// $data=mysqli_fetch_array($HapusGambar);
		
		// $query = mysqli_query($koneksi,"update trtimbanganitem set FotoAction1=NULL, FotoAction2=NULL, FotoAction3=NULL, HasilAction1=NULL, HasilAction2=NULL, HasilAction3=NULL  WHERE  NoTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."' and NoUrutTrans='".htmlspecialchars(base64_decode($_GET['nm']))."'");
		
		$selectQuery = "SELECT FotoAction1, FotoAction2, FotoAction3 FROM trtimbanganitem WHERE NoTransaksi = ? AND NoUrutTrans = ?";
		$selectStmt = mysqli_prepare($koneksi, $selectQuery);

		$id = htmlspecialchars(base64_decode($_GET['id']));
		$nm = htmlspecialchars(base64_decode($_GET['nm']));
		mysqli_stmt_bind_param($selectStmt, "ss", $id, $nm);

		mysqli_stmt_execute($selectStmt);

		$result = mysqli_stmt_get_result($selectStmt);

		mysqli_stmt_bind_result($selectStmt, $fotoAction1, $fotoAction2, $fotoAction3);

		$data = mysqli_fetch_array($result);

		mysqli_stmt_close($selectStmt);

		$updateQuery = "UPDATE trtimbanganitem SET FotoAction1=NULL, FotoAction2=NULL, FotoAction3=NULL, HasilAction1=NULL, HasilAction2=NULL, HasilAction3=NULL WHERE NoTransaksi = ? AND NoUrutTrans = ?";
		$updateStmt = mysqli_prepare($koneksi, $updateQuery);

		mysqli_stmt_bind_param($updateStmt, "ss", $id, $nm);

		$cek = mysqli_stmt_execute($updateStmt);

		mysqli_stmt_close($updateStmt);
		
		if($cek){
			//hapus gambar terlebih dahulu
			unlink("../images/TeraTimbangan/".$fotoAction1);
			unlink("../images/TeraTimbangan/".$fotoAction2);
			unlink("../images/TeraTimbangan/".$fotoAction3);
			//hapus gambar terlebih dahulu
			unlink("../images/TeraTimbangan/thumb_".$fotoAction1);
			unlink("../images/TeraTimbangan/thumb_".$fotoAction2);
			unlink("../images/TeraTimbangan/thumb_".$fotoAction3);

			
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Hasil Sidang Tera Timbangan ', $login_id, base64_decode(@$_GET['id']), 'Transaksi Proses Sidang Tera');
				
			echo '<script language="javascript">document.location="TrSidangTera.php?NoTransaksi='.base64_decode($_GET['id']).'"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
						type: "error"
					  },
					  function () {
						window.location.href = "TrSidangTera.php?user='.base64_decode($_GET['id']).'";
					  });
					  </script>';
		}
	}
	
	//Simpan Edit Item Timbangan
	if(isset($_POST['SimpanEdit'])){
		//update 
		// $query = mysqli_query($koneksi,"UPDATE trtimbanganitem SET HasilAction1='$HasilAction1', HasilAction2='$HasilAction2', HasilAction3='$HasilAction3' WHERE NoTransaksi='$NoTransaksi' and NoUrutTrans='$NoUrutTrans'");
		$query = "UPDATE trtimbanganitem SET HasilAction1=?, HasilAction2=?, HasilAction3=? WHERE NoTransaksi=? AND NoUrutTrans=?";
		$stmt = mysqli_prepare($koneksi, $query);

		// Bind parameters to the prepared statement
		mysqli_stmt_bind_param($stmt, "ssssi", $HasilAction1, $HasilAction2, $HasilAction3, $NoTransaksi, $NoUrutTrans);

		
		if (mysqli_stmt_execute($stmt)){
			InsertLog($koneksi, 'Edit Data', 'Mengubah Transaksi Hasil Sidang Tera ', $login_id, $NoTransaksi, 'Transaksi Proses Sidang Tera');
			echo '<script language="javascript">document.location="TrSidangTera.php?NoTransaksi='.$NoTransaksi.'";</script>';
		}else{
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Simpan Data Gagal!",
				text: " ",
				type: "error"
			  },
			  function () {
				window.location.href = "TrSidangTera.php";
			  });
			  </script>';
		}
		mysqli_stmt_close($stmt);
	}
	
	?>
  </body>
</html>
