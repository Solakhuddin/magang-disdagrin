<?php
include '../admin/akses.php';
$Page = 'MasterData';
$SubPage='MasterPedagang';
$fitur_id = 21;
include '../library/lock-menu.php';
include '../library/tgl-indo.php';

$KodePasar = '';
$KodeBarang = '';
$KodePasar = isset($_GET['psr']) ? mysqli_real_escape_string($koneksi,base64_decode($_GET['psr'])) : '';


if(isset($_GET['k']) && $_GET['k'] != ''){
	$KodePasar = mysqli_escape_string($koneksi, base64_decode($_GET['k']));
	$KodeBarang = mysqli_escape_string($koneksi, base64_decode($_GET['b']));
	$sql = "SELECT KodePasar,KodeBarang,JumlahPedagang FROM masterpedagang WHERE KodeBarang = '$KodeBarang' AND KodePasar='$KodePasar'";
	$res_select = $koneksi->query($sql);
	$RowData = array();
	if($res_select){
		if(mysqli_num_rows($res_select) < 1){
			?>
			<script type="text/javascript">
				swal({
					title: "Error", 
					text: "Data tidak ditemukan", 
					icon: "error", 
					allowOutsideClick: false
				}).then(function() {
					location.href="MasterPedagang.php";
				});
			</script>
			<?php
		}else{
			$RowData = mysqli_fetch_assoc($res_select);
		}
	}else{
		?>
		<script type="text/javascript">
			swal({
				title: "Error", 
				text: "Terjadi kesalahan", 
				icon: "error", 
				allowOutsideClick: false
			}).then(function() {
				location.href="MasterPedagang.php";
			});
		</script>
		<?php
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php include '../admin/title.php';?>
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
	<?php include '../admin/style.php';?>
	<!-- Custom stylesheet - for your changes-->
	<link rel="stylesheet" href="../komponen/css/custom.css">
	<!-- Maps -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBqH_ctOCgwu5RLMrH6VdhCBLorpJXaDk&libraries=places"></script>
	<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js"></script>
	
	<style>
		th {
			text-align: center;
		}

		.hidden {
			display: none;
			visibility: hidden;
		}
		#pacinput,#pacinputpengambilan {
			background-color: #fff;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			margin: 10px 12px;
			padding: 5px;
			text-overflow: ellipsis;
			width: 250px;
		}
	</style>
</head>
<body>
</body>
<div class="page">
	<!-- Main Navbar-->
	<?php 
	include 'header.php'; ?>
	<div class="page-content d-flex align-items-stretch"> 
		<!-- Side Navbar -->
		<?php include 'menu.php';?>
		<div class="content-inner">
			<!-- Page Header-->
			<header class="page-header">
				<div class="container-fluid">
					<h2 class="no-margin-bottom">Master Pedagang</h2>
				</div>
			</header>

			<section class="dashboard-counts no-padding-bottom">
				<div class="container-fluid">
					<div class="col-lg-12">
						<ul class="nav nav-pills">
							<?php if ($cek_fitur['ViewData'] =='1'){ ?>
								<li>
									<a href="#home-pills" data-toggle="tab"><span class="btn btn-primary">Data Pedagang</span></a>&nbsp;
								</li>
								<li>
									<a href="#home-sub" data-toggle="tab"><span class="btn btn-primary">Tambah Data</span></a>&nbsp;
								</li>
							<?php } ?>
							
						</div>
						<br>
						<div class="tab-content">
							<div class="tab-pane fade <?php if(!isset($_GET['view']) || @$_GET['view']==1){ echo 'in active show'; }?>" id="home-pills">
								<div class="card">
									<div class="card-header d-flex align-items-center">
										<h3 class="h4">Data Jumlah Pedagang</h3>
									</div>
									<div class="card-body">
										<form action="">			
											<div class="row">
												<div class="col-md-4">
			                                        <select class="form-control" name="psr">
														<option class="form-control" value="" selected>Semua Pasar</option>
														<?php 
														// $Pasar = isset($_GET['psr']) ? base64_decode($_GET['psr']) : '';
														// $sql_p = "SELECT * FROM mstpasar ORDER BY NamaPasar ASC";
														// $res_p = $koneksi->query($sql_p);
														// while ($row_p = $res_p->fetch_assoc()) {
														// 	if(isset($KodePasar) && $KodePasar === $row_p['KodePasar']){
														// 		echo '<option class="form-control" value="'.base64_encode($row_p['KodePasar']).'" selected>'.$row_p['NamaPasar'].'</option>';
														// 	}else{
																
														// 		echo '<option class="form-control" value="'.base64_encode($row_p['KodePasar']).'">'.$row_p['NamaPasar'].'</option>';
														// 	}
														// }
														$sql_p = "SELECT * FROM mstpasar ORDER BY NamaPasar ASC";

														$stmt = mysqli_prepare($koneksi, $sql_p);
														mysqli_stmt_execute($stmt);
														
														mysqli_stmt_bind_result($stmt, $KodePasar, $NamaPasar);

														while (mysqli_stmt_fetch($stmt)) {
															$selected = isset($KodePasar) && $KodePasar === $row_p['KodePasar'] ? 'selected' : '';
															$encodedKodePasar = base64_encode($KodePasar);
															echo "<option class='form-control' value='$encodedKodePasar' $selected>{$NamaPasar}</option>";
														}

														mysqli_stmt_close($stmt);
														?>
													</select>
			                                    </div>
												<div class="col-md-5">
													<div class="input-group ">
														<input name="v" type="text" class="form-control" placeholder="Cari" value="<?php echo isset($_GET['v']) ? $_GET['v'] : '' ?>">
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Cari</button>
														</div>
													</div>
												</div>
											</div>
										</form>
										
											
											<div class="col-md-12">
												<div class="table-responsive">  
													<table class="table table-striped">
														<thead>
															<tr>
																<th class="text-left">No</th>
																<th class="text-left">Nama Pasar</th>
																<th class="text-left">Nama Barang</th>
																<th class="text-left">Jumlah Pedagang</th>
																<th class="text-right">Aksi</th>
															</tr>
														</thead>
														<?php
														include '../library/pagination1.php';
														$value = isset($_GET['v']) ? mysqli_escape_string($koneksi, $_GET['v']) : '';
														$reload = "MasterPedagang.php?pagination=true&view=1&v=$value&psr=$KodePasar";

														if(isset($_GET['v']) && @$_GET['v'] != ''){
															@$pencarian = " AND (b.NamaBarang LIKE '%$value%' OR b.Merk LIKE '%$value%')";
														}
														$sql =  "SELECT p.KodePasar,p.KodeBarang,p.JumlahPedagang,b.NamaBarang,m.NamaPasar 
														FROM masterpedagang p 
														JOIN mstbarangpokok b ON p.KodeBarang=b.KodeBarang
														JOIN mstpasar m ON p.KodePasar=m.KodePasar 
														WHERE IF(LENGTH('$KodePasar') > 0, p.KodePasar = '$KodePasar', TRUE) ".@$pencarian."
														ORDER BY p.KodePasar ASC";
														
														$result = mysqli_query($koneksi,$sql);
														$rpp = 20;
														$page = intval(@$_GET["page"]);
														if($page<=0) $page = 1;  
														$tcount = mysqli_num_rows($result);
														$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
														$count = 0;
														$i = ($page-1)*$rpp;
														$no_urut = ($page-1)*$rpp;			
														?>
														<tbody>
															<?php
															while(($count<$rpp) && ($i<$tcount)) {
																mysqli_data_seek($result,$i);
																$data = mysqli_fetch_array($result);
																?>
																<tr class="odd gradeX">
																	<td width="50px">
																		<?php echo ++$no_urut;?> 
																	</td>
																	<td>
																		<?php echo $data ['NamaPasar'];?>
																	</td>
																	<td>
																		<?php echo $data ['NamaBarang'];?>
																	</td>
																	<td>
																		<?php echo $data ['JumlahPedagang'];?>
																	</td>
																	<td class="text-right">
																		<?php
																			if ($cek_fitur['EditData'] =='1'){ 
																				echo '
																				<a href="MasterPedagang.php?k='.base64_encode($data['KodePasar']).'&b='.base64_encode($data['KodeBarang']).'&view=2" title="Hapus"><i class="btn btn-warning btn-sm"><span class="fa fa-edit"></span></i></a>';
																			}
																			if ($cek_fitur['DeleteData'] =='1'){ 
																				echo '
																				<button id="btnHapus" value="'.$data['KodeBarang'].'" data-pasar="'.$data['KodePasar'].'"class="btn btn-danger btn-sm" title="Hapus" ><span class="fa fa-trash"></span></button>';
																			}
																		?>
																	</td>
																</tr>
																<?php
																$i++; 
																$count++;
															}

															if($tcount==0){
																echo '
																<tr>
																<td colspan="6" align="center">
																<strong>Tidak ada data</strong>
																</td>
																</tr>
																';
															}
															?>
														</tbody>
													</table>
													<div><?php echo paginate_one($reload, $page, $tpages); ?></div>
												</div>
											</div>
										
									</div>
								</div>
							</div>
							<div class="tab-pane fade <?php if(@$_GET['view']==2){ echo 'in active show'; }?>" id="home-sub">
								<div class="card col-lg-12">
									<div class="card-header d-flex align-items-center">
										<h3 class="h4">Tambah Data Pedagang</h3>
									</div>
									<div class="card-body">
										<form id="form_Pedagang" method="post" action="">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-control-label">Nama Pasar</label>
														<select class="form-control" name="KodePasar" id="KodePasar" <?php echo isset($_GET['view']) ? 'disabled' : 'required'; ?>>
															<option value="" selected disabled>Pilih Pasar</option>
															<?php 
															// $sql_g = "SELECT KodePasar,NamaPasar FROM mstpasar ORDER BY NamaPasar ASC";
															// $res_g = $koneksi->query($sql_g);
															// while ($row = mysqli_fetch_assoc($res_g)) {
															// 	if(isset($RowData['KodePasar']) && $row['KodePasar'] == $RowData['KodePasar']){
															// 		echo '<option value="'.$row['KodePasar'].'" selected>'.$row['NamaPasar'].'</option>';
															// 	}else{
															// 		echo '<option value="'.$row['KodePasar'].'">'.$row['NamaPasar'].'</option>';
															// 	}
															// }
															$sql_g = "SELECT KodePasar, NamaPasar FROM mstpasar ORDER BY NamaPasar ASC";

															$stmt_g = mysqli_prepare($koneksi, $sql_g);
															mysqli_stmt_execute($stmt_g);
															
															mysqli_stmt_bind_result($stmt_g, $KodePasar, $NamaPasar);

															while (mysqli_stmt_fetch($stmt_g)) {
																$selected = isset($RowData['KodePasar']) && $KodePasar == $RowData['KodePasar'] ? 'selected' : '';
																echo "<option value='$KodePasar' $selected>$NamaPasar</option>";
															}

															mysqli_stmt_close($stmt_g);
															
															?>
														</select>
													</div>
													<div class="form-group">
														<label class="form-control-label">Nama Barang</label>
														<select class="form-control" name="KodeBarang" id="KodeBarang" <?php echo isset($_GET['view']) ? 'disabled' : 'required'; ?>>
															<option value="" selected disabled>Pilih Barang</option>
															<?php 
															$sql_g = "SELECT KodeBarang,NamaBarang FROM mstbarangpokok WHERE (KodeBarang='BRG-2020-0000003' OR KodeBarang='BRG-2020-0000002' OR KodeBarang='BRG-2020-0000001' OR KodeBarang='BRG-2019-0000026' OR KodeBarang='BRG-2019-0000027' OR KodeBarang='BRG-2019-0000028' OR KodeBarang='BRG-2019-0000009') ORDER BY NamaBarang ASC";
															$res_g = $koneksi->query($sql_g);
															while ($row = mysqli_fetch_assoc($res_g)) {
																if(isset($RowData['KodeBarang']) && $row['KodeBarang'] == $RowData['KodeBarang']){
																	echo '<option value="'.$row['KodeBarang'].'" selected>'.$row['NamaBarang'].'</option>';
																}else{
																	echo '<option value="'.$row['KodeBarang'].'">'.$row['NamaBarang'].'</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="form-group">
														<label class="form-control-label">Jumlah Pedagang</label>
														<input type="text" placeholder="Jumlah Pedagang" class="form-control" name="JumlahPedagang" value="<?php echo isset($RowData['JumlahPedagang']) ? $RowData['JumlahPedagang'] : ''; ?>" required>
													</div>
												</div>
												<div class="col-md-12">
													<input type="hidden" class="form-control" name="Edit" value="<?php echo isset($_GET['view']) ? $_GET['view'] : ''; ?>" required>
													<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
													<a href="MasterPedagang.php"><span class="btn btn-warning">Batalkan</span></a>
												</div>
											</div>
										</form>
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
<?php include 'footer.php'; ?>
<script type="text/javascript">

	

	$("#form_Pedagang").submit(function(e) {
		e.preventDefault();
		var JumlahPedagang = $("[name='JumlahPedagang']").val();
		var KodeBarang = $("[name='KodeBarang']").val();
		var KodePasar = $("[name='KodePasar']").val();
		var Edit = $("[name='Edit']").val();
		

		var formData = new FormData();
		formData.append("JumlahPedagang", JumlahPedagang);
		formData.append("KodeBarang", KodeBarang);
		formData.append("KodePasar", KodePasar);
		formData.append("Edit", Edit);
		
		formData.append("action", 'SimpanPedagang');
		$.ajax({
			url: "aksi/AksiPedagang.php",
			method: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			dataType: 'json',
			success: function (data) {
				if (data.response == 200) {
					$('#form_Pedagang')[0].reset();
					swal({
						title: "Berhasil", 
						text: "Berhasil menyimpan data.", 
						icon: "success", 
						allowOutsideClick: false
					}).then(function() {
						window.location.href = "MasterPedagang.php";
					});
				} else {
					swal('Error', data.msg,'warning');
				}
			}
		});
	});

	$(document).on('click', '#btnHapus', function () {
		var kodeBarang = $(this).val();
		var kodePasar = $(this).attr("data-pasar");
		swal({
			title: "Peringatan",
			text: "Apakah Anda yakin menghapus data tersebut.",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				HapusData(kodeBarang, kodePasar);              
			}
		});
	});

	function HapusData(kodeBarang, kodePasar){
		var action = "HapusPedagang";
		$.ajax({
			url: "aksi/AksiPedagang.php",
			method: "POST",
			data: {action: action, KodeBarang: kodeBarang, KodePasar:kodePasar},
			dataType: 'json',
			success: function (data) {
				if(data.response = 200){
					swal({
						title: "Berhasil", 
						text: "Berhasil menghapus data.", 
						icon: "success", 
						allowOutsideClick: false
					}).then(function() {
						location.reload();
					});
				}else{
					swal('Gagal menghapus data\nCoba lagi.','error');
				}               
			}
		});
	}
</script>
