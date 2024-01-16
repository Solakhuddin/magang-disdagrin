<?php
include '../admin/akses.php';
$Page = 'MasterData';
$SubPage='MasterGrup';
$fitur_id = 20;
include '../library/lock-menu.php';
include '../library/tgl-indo.php';

$KodeGroup = '';

if(isset($_GET['aksi']) && base64_decode($_GET['aksi']) === "hapus"){
	$id = base64_decode($_GET['id']);
	$nm = base64_decode($_GET['nm']);
}

if(isset($_GET['k']) && $_GET['k'] != ''){
	$KodeGroup = mysqli_escape_string($koneksi, base64_decode($_GET['k']));
	$sql = "SELECT * FROM mstgroupbarang WHERE KodeGroup = '$KodeGroup'";
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
					location.href="MasterGrup.php";
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
				location.href="MasterGrup.php";
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
					<h2 class="no-margin-bottom">Master Group</h2>
				</div>
			</header>

			<section class="dashboard-counts no-padding-bottom">
				<div class="container-fluid">
					<div class="col-lg-12">
						<ul class="nav nav-pills">
							<?php if ($cek_fitur['ViewData'] =='1'){ ?>
								<li>
									<a href="#home-pills" data-toggle="tab"><span class="btn btn-primary">Data Group</span></a>&nbsp;
								</li>
								<li>
									<a href="#home-sub" data-toggle="tab"><span class="btn btn-primary">Tambah Data</span></a>&nbsp;
								</li>
							<?php } ?>
							<li>
								<?php if ($cek_fitur['PrintData'] =='1'){ ?>
									<!-- <li> -->
										<!-- <a href="../library/html2pdf/cetak/MasterTimbangan.php" title='Print Data' target="_BLANK"><span class="btn btn-primary">Cetak Data Group</span></a> -->

									<!-- </li> -->
								<?php } ?>
							</ul>
						</div>
						<br>
						<div class="tab-content">
							<div class="tab-pane fade <?php if(!isset($_GET['view']) || @$_GET['view']==1){ echo 'in active show'; }?>" id="home-pills">
								<div class="card">
									<div class="card-header d-flex align-items-center">
										<h3 class="h4">Data Group</h3>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-6 text-right">
												<form action="">
													<div class="input-group mb-3">
														<input name="v" type="text" class="form-control" placeholder="Cari" value="<?php echo isset($_GET['v']) ? $_GET['v'] : '' ?>">
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Cari</button>
														</div>
													</div>
												</form>
											</div>
											<div class="col-md-12">
												<div class="table-responsive">  
													<table class="table table-striped">
														<thead>
															<tr>
																<th class="text-left">No</th>
																<th class="text-left">Nama Group</th>
																<th class="text-left">Keterangan</th>
																<th class="text-center">Status</th>
																<th class="text-right">Aksi</th>
															</tr>
														</thead>
														<?php
														include '../library/pagination1.php';
														$value = isset($_GET['v']) ? mysqli_escape_string($koneksi, $_GET['v']) : '';
														$reload = "MasterGrup.php?pagination=true&view=1&v=".$value;
														if(isset($_GET['v']) && $_GET['v'] != ''){
															$sql =  "SELECT * FROM mstgroupbarang ";
															$sql .= "WHERE (NamaGroup LIKE '%$value%' OR Keterangan LIKE '%$value%') ORDER BY NamaGroup ASC";
														}else{
															$sql =  "SELECT * FROM mstgroupbarang ORDER BY NamaGroup ASC";
														}

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
																		<?php echo $data ['NamaGroup'];?>
																	</td>
																	<td>
																		<?php echo $data ['Keterangan'];?>
																	</td>
																	<td class="text-center">
																		<?php echo $data ['IsAktif'] > 0 ? '<font class="text-success">Aktif</font>' : '<font class="text-danger">Tidak Aktif</font>';?>
																	</td>
																	<td width="100px" class="text-right">										
																		<?php
																		if ($cek_fitur['EditData'] =='1'){ 
																			echo '<a href="MasterGrup.php?k='.base64_encode($data['KodeGroup']).'&view=2" title="Edit"><i class="btn btn-warning btn-sm"><span class="fa fa-edit"></span></i></a>';
																		}
																		// if ($cek_fitur['DeleteData'] =='1'){ 
																		// 	echo ' <a href="#" title="Hapus" onclick="konfirmasihapus('."'".base64_encode($data['KodeGroup'])."', '".base64_encode($data['NamaGroup'])."', '".base64_encode('Hapus')."'".')"><i class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></i></a>';
																		// }
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
																<td colspan="5" align="center">
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
							</div>
							<div class="tab-pane fade <?php if(@$_GET['view']==2){ echo 'in active show'; }?>" id="home-sub">
								<div class="card col-lg-12">
									<div class="card-header d-flex align-items-center">
										<h3 class="h4">Tambah Data Group</h3>
									</div>
									<div class="card-body">
										<form id="form_Group" method="post" action="">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-control-label">Nama Group</label>
														<input type="text" placeholder="Nama Group" class="form-control" name="txtNamaGroup" value="<?php echo isset($RowData['NamaGroup']) ? $RowData['NamaGroup'] : ''; ?>" required>
													</div>
													<div class="form-group">
														<label class="form-control-label">Keterangan</label>
														<input type="text" placeholder="Keterangan" class="form-control" name="txtKeterangan" value="<?php echo isset($RowData['Keterangan']) ? $RowData['Keterangan'] : ''; ?>" required>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-control-label">Status</label>
														<div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" id="defaultInline1" name="rbIsAktif" value="1" <?php echo isset($RowData['IsAktif']) && $RowData['IsAktif'] == '1' ? 'checked' : '' ?> required>
																<label class="custom-control-label" for="defaultInline1">Aktif</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" id="defaultInline2" name="rbIsAktif" value="0" <?php echo isset($RowData['IsAktif']) && $RowData['IsAktif'] == '0' ? 'checked' : '' ?> required>
																<label class="custom-control-label" for="defaultInline2">Tidak Aktif</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="btn btn-primary">Simpan</button>
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

<div id="dialog-hapus" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- konten modal-->
        <div class="modal-content">
			<form action="MasterGrup.php" method="get">
            <!-- heading modal -->
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus</h4>
            </div>
            <div class="modal-body" style="padding:27px;">
					<input type="hidden" name="view" value="1">
					<input type="hidden" name="id" id="id" value="1">
					<input type="hidden" name="nm" id="nm" value="1">
					<input type="hidden" name="aksi" id="aksi" value="1">
				<label for="">Apakah anda yakin akan menghapus data ini ?</label>
			</div>
			<div class="modal-footer">
				<button type="submit" id="btn-hapus-modal" class="btn btn-sm btn-danger">Hapus</button>	
				<a href="#" data-dismiss="modal" class="btn btn-sm btn-secondary">Batal</a>		
			</div>
			</form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script type="text/javascript">

	function konfirmasihapus(id, nm, aksi){
		document.getElementById('id').value = id;
		document.getElementById('nm').value = nm;
		document.getElementById('aksi').value = aksi;
		$("#dialog-hapus").modal("show");
	}

	var KodeGroup;

	$(document).ready(function () {
		KodeGroup = "<?php echo $KodeGroup; ?>";
	});

	$("#form_Group").submit(function(e) {
		e.preventDefault();
		var NamaGroup = $("[name='txtNamaGroup']").val();
		var Keterangan = $("[name='txtKeterangan']").val();		
		var IsAktif = $("input[name='rbIsAktif']:checked").val();
		console.log(NamaGroup+' '+Keterangan+' '+IsAktif);
		var formData = new FormData();
		formData.append("KodeGroup", KodeGroup);
		formData.append("NamaGroup", NamaGroup);
		formData.append("Keterangan", Keterangan);
		formData.append("IsAktif", IsAktif);
		formData.append("action", 'SimpanGroup');
		$.ajax({
			url: "aksi/AksiGrup.php",
			method: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			dataType: 'json',
			success: function (data) {
				console.log(data.msg);
				if (data.response == 200) {
					$('#form_Group')[0].reset();
					// sweetAlert({
					// 	title: "Login Sukses!",
					// 	text: " Anda Berhasil Login ",
					// 	type: "success"
					// 	}, function () {
					// 	window.location.href = "MasterGrup.php";
					// });
					swal("Berhasil", "Berhasil menyimpan data", "success")
					.then((value) => {
						window.location.href = "MasterGrup.php";
					});
				} else {
					swal('Error', data.msg,'warning');
				}
			}
		});
	});
</script>