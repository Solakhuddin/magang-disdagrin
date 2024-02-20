<?php
include 'akses.php';
@$fitur_id = 43;
include '../library/lock-menu.php';
include '../library/tgl-indo.php';
$Page = 'LapPupuk';
$SubPage = 'LapTokoDistribusi';
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
	.table thead th {
		
		text-align: center;
		
		border: 2px solid #dee2e6;
	}
	td {
		border: 2px solid #dee2e6;
	}
	</style>

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
              <h2 class="no-margin-bottom">Laporan Toko Distributor</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
         <section class="tables"> 
            <div class="container-fluid">
            	<?php if(isset($_GET['s'])) {?>
					<div class="col-lg-12">
						<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span class="fa fa-window-close"></span></button> Berhasil Edit Data</div>
					</div>
				<?php } ?>
                <div class="col-lg-12">
				  <div class="card">
					<div class="tab-content">
						<div class="tab-pane fade <?php if(@$_GET['id']==null){ echo 'in active show'; }?>" id="home-pills">
							<div class="card-header d-flex align-items-center">
							  <h3 class="h4">Laporan Toko </h3>
							  <div class="offset-lg-8">
								<a href="../library/html2pdf/cetak/LapTokoDistribusi.php" target="_blank"><span class="btn btn-secondary"><i class="fa fa-print"></i> Cetak Laporan</span></a>
							  </div>
							</div>
							<div class="card-body">							  
								<div class="col-lg-6 offset-lg-6">
									<form method="post" action="">
										<div class="form-group input-group">						
											<select id="IDPerson" name="IDPerson" class="form-control">	
											<?php
												echo "<option value=''>--- Semua Distributor ---</option>";
												$sqla = "SELECT IDPerson,NamaPerson FROM mstperson where JenisPerson LIKE '%PupukSub%'  AND IsVerified=b'1' and IsPerusahaan=b'1' AND ID_Distributor IS NULL ORDER BY NamaPerson";
												$oke = $koneksi->prepare($sqla);
												$oke->execute();
												$menu = $oke->get_result();
												while($kode = mysqli_fetch_array($menu)){
													if($kode['IDPerson']==$_REQUEST['IDPerson']){
														echo "<option value=\"".$kode['IDPerson']."\" selected>".$kode['NamaPerson']."</option>\n";
													}else{
														echo "<option value=\"".$kode['IDPerson']."\" >".$kode['NamaPerson']."</option>\n";
													}
												}
											?>
										</select>&nbsp;&nbsp;
										<span class="input-group-btn">
											<button class="btn btn-large btn-warning" type="submit">Cari</button>
										</span>
										</div>
									</form>
								</div>
							  <div class="table-responsive">  
								<table class="table table">
								  <thead>
									<tr>
									  <th>No</th>
									  <th>Nama Distributor</th>
									  <th>Nama Toko</th>
									  <th>Alamat</th>
									  <th>No Telephone</th>
									  <th>##</th>
									</tr>
								  </thead>
									<?php
										include '../library/pagination1.php';
										// mengatur variabel reload dan sql
										// where a.JenisPerson='Distributor' and a.IsVerified=b'1' and a.KlasifikasiUser='Distributor Pupuk'";
										// jika ada kata kunci pencarian (artinya form pencarian disubmit dan tidak kosong)pakai ini
										@$keyword=htmlspecialchars($_REQUEST['IDPerson']);
										$reload = "LapTokoDistribusi.php?pagination=true&IDPerson=$keyword";
										$sql =  "SELECT a.NamaPerson as Distributor, b.NamaPerson, b.AlamatLengkapPerson, b.NoHP,(SELECT COUNT(IDPerson) FROM mstperson WHERE ID_Distributor=a.IDPerson) AS jumlah,b.IDPerson 
										FROM mstperson a 
										join mstperson b on (a.IDPerson=b.ID_Distributor) 
										where a.JenisPerson LIKE '%PupukSub%'  AND a.IsVerified=b'1'";

										
										if(@$_REQUEST['IDPerson'] !=null){
											$sql .= " AND a.IDPerson='".$_REQUEST['IDPerson']."' ";
										}
										
										$sql .="  ORDER BY b.NamaPerson ASC";
										$oke1 = $koneksi->prepare($sql);
										$oke1->execute();
										$result = $oke1->get_result();
									
										
										//pagination config start
										// $rpp = 20; // jumlah record per halaman
										// $page = intval(@$_GET["page"]);
										// if($page<=0) $page = 1;  
										@$tcount = mysqli_num_rows($result);
										// $tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
										// $count = 0;
										// $i = ($page-1)*$rpp;
										// $no_urut = ($page-1)*$rpp;
										//pagination config end	
										$no = 1;
										$jum = 1;
									?>
									<tbody>
										<?php
										while($data = mysqli_fetch_array($result)) {
										// while(($count<$rpp) && ($i<$tcount)) {
										// 	mysqli_data_seek($result,$i);
										// 	@$data = mysqli_fetch_array($result);
										?>
										<tr class="odd gradeX">
											<?php 
											if($jum <= 1) {
												echo '<td align="center" rowspan="'.$data['jumlah'].'">'.$no.'</td>';
												echo '<td rowspan="'.$data['jumlah'].'">'.$data['Distributor'].'</td>';  
												$jum = $data['jumlah'];       
												$no++;                     
											} else {
												$jum = $jum - 1;
											}
											?>
											<td>
												<?php echo $data ['NamaPerson']; ?>
											</td>
											<td>
												<?php echo $data ['AlamatLengkapPerson']; ?>
											</td>
											<td>
												<?php echo $data ['NoHP']; ?>
											</td>
											<td>
												<?php if ($cek_fitur['EditData'] =='1'){ ?>
													<a href="LapTokoDistribusi_edit.php?id=<?php echo base64_encode($data['IDPerson']);?>" title='Edit'><i class='btn btn-warning btn-sm'><span class='fa fa-edit'></span></i></a>
												<?php } ?>
											</td>
										</tr>
										<?php
											// $i++; 
											// $count++;
										}
										?>
									</tbody>
								</table>
								<!-- <div><?php echo paginate_one($reload, $page, $tpages); ?></div> -->
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
	
	
	<!-- Modal-->
	  <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
		<div role="document" class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 id="exampleModalLabel" class="modal-title">Cetak Laporan User</h4>
			  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
			  <form method="post" target="_BLANK">
				<!--<div class="form-group">
					<label>Pilih Jenis User</label>
					<select name="User" class="form-control">
						<option value="" disabled selected>--- Jenis User ---</option>
						<option value="SEMUA" > Cetak Semua User </option>';
						<option value="Timbangan" >Timbangan</option>
						<option value="Pedagang" >Pedagang</option>
						<option value="PKL" >Pedagang Kaki Lima</option>
						<option value="Industri" >Industri</option>
					</select>
				</div>-->
				<div class="form-group">       
				  <input type="submit" name="Cetak" class="btn btn-primary" value="Cetak">
				  <input type="submit" name="Export" class="btn btn-danger" value="Export Excel">
				</div>
			  </form>
			</div>
			<div class="modal-footer">
			  <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
			</div>
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
	
	<!-- =============================================Progres Bar=================================-->
	<script type="text/javascript" src="../komponen/js/jquery.form.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() { 

		var progressbox     = $('#progressbox');
		var progressbar     = $('#progressbar');
		var statustxt       = $('#statustxt');
		var completed       = '0%';
		
		var options = { 
				target:   '#output',   // target element(s) to be updated with server response 
				beforeSubmit:  beforeSubmit,  // pre-submit callback 
				uploadProgress: OnProgress,
				success:       afterSuccess,  // post-submit callback 
				resetForm: true        // reset the form after successful submit 
			}; 
			
		 $('#MyUploadForm').submit(function() { 
				$(this).ajaxSubmit(options);  			
				// return false to prevent standard browser submit and page navigation 
				return false; 
			});
		
	//when upload progresses	
	function OnProgress(event, position, total, percentComplete)
	{
		//Progress bar
		progressbar.width(percentComplete + '%') //update progressbar percent complete
		statustxt.html(percentComplete + '%'); //update status text
		if(percentComplete>50)
			{
				statustxt.css('color','#fff'); //change status text to white after 50%
			}
	}

	//after succesful upload
	function afterSuccess()
	{
		$('#submit-btn').show(); //hide submit button
		$('#loading-img').hide(); //hide submit button

	}

	//function to check file size before uploading.
	function beforeSubmit(){
		//check whether browser fully supports all File API
	   if (window.File && window.FileReader && window.FileList && window.Blob)
		{

			if( !$('#filefoto1').val()) //check empty input filed
			{
				$("#output").html("Masukkan gambar terlebih dahulu!");
				return false
			}
			
			var fsize = $('#filefoto1')[0].files[0].size; //get file size
			var ftype = $('#filefoto1')[0].files[0].type; // get file type
			
			//allow only valid image file types 
			switch(ftype)
			{
				case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
					break;
				default:
					$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
					return false
			}
			
			//Allowed file size is less than 1 MB (1048576)
			if(fsize>3048576) 
			{
				$("#output").html("<b>"+bytesToSize(fsize) +"</b> File Gambar Terlalu Besar <br />Masksimal upload 3 MB.");
				return false
			}
			
			//Progress bar
			progressbox.show(); //show progressbar
			progressbar.width(completed); //initial value 0% of progressbar
			statustxt.html(completed); //set status text
			statustxt.css('color','#000'); //initial color of status text

					
			$('#submit-btn').hide(); //hide submit button
			$('#loading-img').show(); //hide submit button
			$("#output").html("");  
		}
		else
		{
			//Output error to older unsupported browsers that doesn't support HTML5 File API
			$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
			return false;
		}
	}

	//function to format bites bit.ly/19yoIPO
	function bytesToSize(bytes) {
	   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   if (bytes == 0) return '0 Bytes';
	   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}

	}); 

	</script>
	
	<script>
	var htmlobjek;
	$(document).ready(function(){
	  //apabila terjadi event onchange terhadap object <select id=nama_produk>

	  $("#KodeKec").change(function(){
		var KodeKec = $("#KodeKec").val();
		$.ajax({
			url: "../library/Dropdown/ambil-desa.php",
			data: "KodeKec="+KodeKec,
			cache: false,
			success: function(msg){
				$("#KodeDesa").html(msg);
			}
		});
	  });
	  
	});
	</script>
	
	<?php
		//Post data user simpan data baru
		@$NamaPerson			= htmlspecialchars($_POST['NamaPerson']);
		@$PJPerson				= htmlspecialchars($_POST['PJPerson']);
		// @$JenisPerson			= htmlspecialchars($_POST['JenisPerson']);
		@$AlamatLengkapPerson	= htmlspecialchars($_POST['AlamatLengkapPerson']);
		@$Username				= htmlspecialchars($_POST['UserName']);
		@$Password				= base64_encode($_POST['Password']);
		@$Keterangan			= htmlspecialchars($_POST['Keterangan']);
		@$IsPerusahaan			= htmlspecialchars($_POST['IsPerusahaan']);
		@$KodeKec				= htmlspecialchars($_POST['KodeKec']);
		@$KodeDesa				= htmlspecialchars($_POST['KodeDesa']);
		@$KodeKab				= htmlspecialchars($_POST['KodeKab']);
		@$NamaJalan				= htmlspecialchars($_POST['NamaJalan']);
		@$Lat					= htmlspecialchars($_POST['Lat']);
		@$Lng					= htmlspecialchars($_POST['Lng']);
		@$IDPerson				= htmlspecialchars($_POST['IDPerson']);
		@$Timbangan				= htmlspecialchars($_POST['Timbangan']);
		@$Pedagang				= htmlspecialchars($_POST['Pedagang']);
		@$PKL					= htmlspecialchars($_POST['PKL']);
		@$Industri				= htmlspecialchars($_POST['Industri']);
		@$NoRekeningBank		= htmlspecialchars($_POST['NoRekeningBank']);
		@$AnRekBank				= htmlspecialchars($_POST['AnRekBank']);
		@$JenisPerson			= $Timbangan."#".$Pedagang."#".$PKL."#".$Industri;
		
		
	
	if(isset($_POST['SimpanEdit'])){
		
		//query update
		$query = mysqli_query($koneksi,"UPDATE mstperson SET NamaPerson='$NamaPerson',PJPerson='$PJPerson',JenisPerson='$JenisPerson',AlamatLengkapPerson='$AlamatLengkapPerson',Password='$Password',Keterangan='$Keterangan',IsPerusahaan='$IsPerusahaan',KodeKec='$KodeKec',KodeDesa='$KodeDesa',NamaJalan='$NamaJalan',KoorLat='$Lat',KoorLong='$Lng', NoRekeningBank='$NoRekeningBank', AnRekBank='$AnRekBank' WHERE IDPerson='$IDPerson'");
		if($query){
			InsertLog($koneksi, 'Edit Data', 'Mengubah Master User atas nama '.$NamaPerson, $login_id, $IDPerson, 'Master User');
			echo '<script language="javascript">document.location="MasterUser.php";</script>';
		}else{
			echo '<script type="text/javascript">
				  sweetAlert({
					title: "Edit Data Gagal!",
					text: " ",
					type: "error"
				  },
				  function () {
					window.location.href = "MasterUser.php";
				  });
				  </script>';
		}
	}
	
	if(base64_decode(@$_GET['aksi'])=='Hapus'){
		//hapus transaksi timbangan user
		$HapusGambar = mysqli_query($koneksi,"SELECT FotoKTP,GambarPerson FROM mstperson WHERE IDPerson='".base64_decode($_GET['id'])."'");
		$data=mysqli_fetch_array($HapusGambar);
		
		$query = mysqli_query($koneksi,"delete from mstperson WHERE IDPerson='".base64_decode($_GET['id'])."'");
		if($query){
			unlink("../images/FotoPerson/".$data['GambarPerson']."");
			unlink("../images/FotoPerson/".$data['FotoKTP']."");
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Master User atas nama '.base64_decode(@$_GET['nm']), $login_id, base64_decode(@$_GET['id']), 'Master User');
			echo '<script language="javascript">document.location="MasterPerson.php"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
						type: "error"
					  },
					  function () {
						window.location.href = "MasterPerson.php";
					  });
					  </script>';
		}
	}
	
	if(isset($_POST['Cetak'])){
		// $User = htmlspecialchars($_POST['User']);
		// echo '<script language="javascript">document.location="../library/html2pdf/cetak/LapUser.php?id='.base64_encode($User).'";</script>';
		echo '<script language="javascript">document.location="../library/html2pdf/cetak/LapUser.php";</script>';
		
	}
	
	if(isset($_POST['Export'])){
		// $User = htmlspecialchars($_POST['User']);
		// echo '<script language="javascript">document.location="../library/Export/LapUser.php?id='.base64_encode($User).'";</script>';
		echo '<script language="javascript">document.location="../library/Export/LapUser.php";</script>';
		
	}
	function NamaPerson($koneksi, $IDPerson){
		$query = "SELECT NamaPerson FROM mstperson where IDPerson= ? ";
		$oke2 = $koneksi->prepare($query);
		$oke2->bind_param('s', $IDPerson);
		$oke2->execute();
		$conn = $oke2->get_result();
		$result = mysqli_fetch_array($conn);
		$NamaPerson = $result['NamaPerson'];
		
		return $NamaPerson;
	 }
	
	?>
  </body>
</html>