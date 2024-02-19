<?php
include 'akses.php';
@$fitur_id = 36;
include '../library/lock-menu.php';
@include '../library/tgl-indo.php';
$Page = 'PengajuanOnline';
// $SubPage = 'LapTeraDinas';
$TanggalTransaksi = date("Y-m-d H:i:s");

if(@$_GET['id']!=null){
	// $Edit = mysqli_query($koneksi,"SELECT * FROM trpermohonan WHERE KodeTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."'");
	// $RowData = mysqli_fetch_assoc($Edit);

	$id = base64_decode($_GET['id']);

	$query = "SELECT * FROM trpermohonan WHERE KodeTransaksi = ?";

	$stmt = mysqli_prepare($koneksi, $query);

    mysqli_stmt_bind_param($stmt, "s", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $RowData = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
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
	<style>
	label{
		font-weight: bold;
	}
	
	</style>
	<script type="text/javascript">
		function confirmation() {
			var answer = confirm("Apakah Anda yakin menghapus data ini ?")
			if (answer == true){
				window.location = "PengajuanOnline.php";
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
              <h2 class="no-margin-bottom">Layanan Pengajuan Tera Ulang</h2>
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
							  <h3 class="h4">Pengajuan Tera Ulang</h3>
							</div>
							<div class="card-body">							  
								<div class="col-lg-4 offset-lg-8">
									<form method="post" action="">
										<div class="form-group input-group">						
											<input type="text" name="keyword" class="form-control" placeholder="NIK..." value="<?php echo @$_REQUEST['keyword']; ?>">
											<span class="input-group-btn">
												<button class="btn btn-info" type="submit">Cari</button>
											</span>
										</div>
									</form>
								</div>
							  <div class="table-responsive">  
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>No</th>
									  <th>Nama Pengirim</th>
									  <th>Tanggal dikirim</th>
									  <th>Status</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
									<?php
										include '../library/pagination1.php';
										// mengatur variabel reload dan sql
										@$keyword  = $_REQUEST['keyword'];
										$reload = "PengajuanOnline.php?pagination=true&keyword=$keyword";
										$sql =  "SELECT * FROM trpermohonan WHERE 1 ";
										
										if(@$_REQUEST['keyword']!=null){
											$sql .= " AND NIK LIKE '%".$_REQUEST['keyword']."%'  ";
										}
										
										$sql .=" ORDER BY TglTransaksi DESC";
										$result = mysqli_query($koneksi,$sql);
										
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
												
												<?php echo $data ['NIK']; ?><br>
												<strong><?php echo $data ['NoTelp']; ?></strong><br>
												<?php echo NamaPerson($koneksi, $data['NIK']); ?>
											</td>
											<td>
												<?php echo TanggalIndo($data['TglTransaksi']); ?>
											</td>
											<td align="center">
												<?php 
												if($data ['Status']!='Belum Dibaca'){
													echo '<i class="btn btn-primary btn-sm">Terbaca</i>';
												}else{
														echo '<i class="btn btn-success btn-sm">Baru</i>';
												} ?>
											</td>
											<td width="100px" align="center">
												<?php if ($cek_fitur['ViewData'] =='1'){ ?>
													<a href="PengajuanOnline.php?id=<?php echo base64_encode($data['KodeTransaksi']);?>" title='Baca Pesan'><i class='btn btn-warning btn-sm' style="border-radius:2px;"><span class='fa fa-eye'></span> </i></a> 
												<?php } ?>
												<?php if ($cek_fitur['DeleteData'] =='1'){ ?>
													<!-- Hapus Data-->
													<a href="PengajuanOnline.php?tr=<?php echo base64_encode($data['KodeTransaksi']);?>&aksi=<?php echo base64_encode('Hapus');?>" title='Hapus' onclick="return confirmation()"><i class='btn btn-danger btn-sm' style="border-radius:2px;"><span class='fa fa-trash'></span> </i></a> 
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
							  <h3 class="h4">Detil Pesan Pengaduan Masyarakat</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12" >
									<?php 
										if($RowData['Status']=='Belum Dibaca'){
											// mysqli_query($koneksi,"UPDATE trpermohonan SET Status='Terbaca' WHERE KodeTransaksi='".$RowData['KodeTransaksi']."'");
											$query = "UPDATE trpermohonan SET Status='Terbaca' WHERE KodeTransaksi=?";
											$stmt = mysqli_prepare($koneksi, $query);
											mysqli_stmt_bind_param($stmt, "s", $RowData['KodeTransaksi']);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_close($stmt);
										}
									?>
										<label>Pengirim</label><br>
										<?php echo $RowData['NIK']; ?>
										<p><?php echo NamaPerson($koneksi,$RowData['NIK']); ?> </p>
										
										<label>Tanggal Pengiriman</label>
										<p><?php echo TanggalIndo($RowData['TglTransaksi']); ?> | <?php echo substr($RowData['TglTransaksi'],11,19); ?></p>
										
										<label>No Telephone</label>
										<p><?php echo $RowData['NoTelp']; ?></p>

										<label>File Dokumen</label>
										<br>
										<a href="../images/Permohonan/<?=$RowData['Dokumen']?>" target="_BLANK"><span class="btn btn-primary">Download</span></a>&nbsp;
										<!-- <p><?php echo $RowData['NoTelp']; ?></p> -->
										<hr/>
										<label>Detil UTTP</label>
										<div>  
										<table class="table table-striped">
										  <thead>
											<tr>
											  <th style="border: 2px solid #dee2e6; text-align: center;" align="center">ID Timbangan</th>
											  <th style="border: 2px solid #dee2e6; text-align: center;" align="center">Nama Timbangan</th>
											</tr>
										  </thead>
										  <tbody>
											<?php 
												$uttp = mysqli_query($koneksi, "SELECT IDTimbangan FROM detiluttp WHERE KodeTransaksi='".$RowData['KodeTransaksi']."'");
												$jumlah = mysqli_num_rows($uttp);
												if($jumlah == null OR $jumlah === 0){
													echo '<tr><td colspan="2" align="center" style="border: 2px solid #dee2e6"><strong>Tidak ada data</strong></td></tr>';
												}else{
													while($hasil = mysqli_fetch_array($uttp)) { ?>
														<tr>
															<td style="border: 2px solid #dee2e6"><?php echo $hasil['IDTimbangan']; ?></td>
															<td style="border: 2px solid #dee2e6"><?php echo NamaTimbangan($koneksi, $hasil['IDTimbangan']); ?></td>
														</tr>	
											<?php 
													}
												} 
											?>
										  </tbody>
										</table>
										</div>
										  
										<hr/>
										<div class="text-right">
											<!--<a href="mailto:<?php echo $RowData['Email'];?>" target="_BLANK"><button class="btn btn-success" style="border-radius:2px;">Balas</button></a>-->
											<a href="PengajuanOnline.php"><button class="btn btn-danger" style="border-radius:2px;">Kembali</button></a>
										</div>
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
	
	<?php 
		
	if(base64_decode(@$_GET['aksi'])=='Hapus'){
		// mysqli_query($koneksi,"delete from detiluttp WHERE  KodeTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."'");
		// $query = mysqli_query($koneksi,"delete from trpermohonan WHERE  KodeTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."'");
		
		$decoded_id = base64_decode($_GET['tr']);

		$query_detiluttp = "DELETE FROM detiluttp WHERE KodeTransaksi = ?";
		$stmt_detiluttp = mysqli_prepare($koneksi, $query_detiluttp);
		mysqli_stmt_bind_param($stmt_detiluttp, "s", $decoded_id);
		mysqli_stmt_execute($stmt_detiluttp);
		mysqli_stmt_close($stmt_detiluttp);

		$query_trpermohonan = "DELETE FROM trpermohonan WHERE KodeTransaksi = ?";
		$stmt_trpermohonan = mysqli_prepare($koneksi, $query_trpermohonan);
		mysqli_stmt_bind_param($stmt_trpermohonan, "s", $decoded_id);
		$cek = mysqli_stmt_execute($stmt_trpermohonan);
		mysqli_stmt_close($stmt_trpermohonan);
		
		if($cek){
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Pengajuan Tera Ulang', $login_id, base64_decode(@$_GET['tr']), 'Layanan Pengajuan Tera Ulang');
			echo '<script language="javascript">document.location="PengajuanOnline.php"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " ",
						type: "error"
					  },
					  function () {
						window.location.href = "PengajuanOnline.php";
					  });
					  </script>';
		}
	}
	
	function NamaPerson($koneksi, $NIK){
		// $query = "SELECT NamaPerson FROM mstperson where NIK='$NIK'";
		// $conn = mysqli_query($koneksi, $query);
		// $result = mysqli_fetch_array($conn);
		// $NamaPerson = $result['NamaPerson'];
		$query = "SELECT NamaPerson FROM mstperson WHERE NIK = ?";
		$stmt = mysqli_prepare($koneksi, $query);
		mysqli_stmt_bind_param($stmt, "s", $NIK);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $NamaPerson);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		
		return $NamaPerson;
	}
	function NamaTimbangan($koneksi, $IDTimbangan){
		// $query = "SELECT NamaTimbangan FROM timbanganperson where IDTimbangan='$IDTimbangan'";
		// $conn = mysqli_query($koneksi, $query);
		// $result = mysqli_fetch_array($conn);
		// $NamaPerson = $result['NamaTimbangan'];
		$query = "SELECT NamaTimbangan FROM timbanganperson WHERE IDTimbangan = ?";
		$stmt = mysqli_prepare($koneksi, $query);
		mysqli_stmt_bind_param($stmt, "s", $IDTimbangan);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $NamaTimbangan);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		
		return $NamaTimbangan;
	}
	
	?>
  </body>
</html>
