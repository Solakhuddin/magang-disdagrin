<?php 
include 'akses.php';
$Page = 'User';

if(@$_GET['id']==null){
	$Sebutan = 'Tambah Data';
}else{
	$Sebutan = 'Edit Data';	
	$Readonly = 'readonly';
	
	$Edit = mysqli_query($koneksi,"SELECT * FROM userlogin WHERE UserName='".base64_decode($_GET['id'])."'");
	$RowData = mysqli_fetch_assoc($Edit);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include 'title.php';?>
	 <!-- Sweet Alerts -->
	<link rel="stylesheet" href="../library/sweetalert/sweetalert.css" rel="stylesheet">
  </head>
  <body>
    <!-- navbar-->
    <!-- header -->
	 <?php include 'header.php';?>
    <!-- header -->
    <div class="d-flex align-items-stretch">
	<!-- menu -->
	 <?php include 'menu.php';?>
    <!-- menu -->
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
          <section class="py-5">
            <div class="row">
              <!-- Form Elements -->
              <div class="col-lg-12 mb-5">
				<ul class="nav nav-pills">
					<li <?php if(@$id==null){echo 'class="active"';} ?>>
						<a href="#home-pills" data-toggle="tab"><span class="btn btn-primary">Data User</span></a>&nbsp;
					</li>
					<li>
						<a href="#tambah-user" data-toggle="tab"><span class="btn btn-primary"><?php echo @$Sebutan; ?></span></a>
					</li>
				</ul><br/>
                <div class="card">
					<div class="tab-content">
						<div class="tab-pane fade <?php if(@$_GET['id']==null){ echo 'in active show'; }?>" id="home-pills">
						  <div class="card-header">
							<h3 class="h6 text-uppercase mb-0">User Login</h3>
						  </div>
							<div class="card-body">
								<div class="col-lg-4 offset-lg-8">
									<form method="post" action="">
										<div class="form-group input-group">						
											<input type="text" name="keyword" class="form-control" placeholder="Nama..." value="<?php echo @$_REQUEST['keyword']; ?>">
											<span class="input-group-btn">
												<button class="btn btn-success" style="border-radius:2px;" type="submit">Cari</button>
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
									  <th>NIP</th>
									  <th>Jabatan</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
									<?php
										include '../library/pagination1.php';
										// mengatur variabel reload dan sql
										$kosong=null;
										if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
											// jika ada kata kunci pencarian (artinya form pencarian disubmit dan tidak kosong)pakai ini
											$keyword=$_REQUEST['keyword'];
											$reload = "UserLogin.php?pagination=true&keyword=$keyword";
											$sql =  "SELECT * FROM userlogin WHERE NamaPegawai LIKE '%$keyword%' and IsAktif=b'1' AND  JenisLogin = 'ADMIN WEB' ORDER BY NamaPegawai ASC";
											$result = mysqli_query($koneksi,$sql);
										}else{
										//jika tidak ada pencarian pakai ini
											$reload = "UserLogin.php?pagination=true";
											$sql =  "SELECT * FROM userlogin where IsAktif=b'1' AND  JenisLogin = 'ADMIN WEB' ORDER BY NamaPegawai ASC";
											@$result = mysqli_query($koneksi,$sql);
										}
										
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
										if($tcount==0){
											echo '<tr><td colspan="8" align="center"><strong>Tidak ada data</strong></td></tr>';
										}else{
										while(($count<$rpp) && ($i<$tcount)) {
											mysqli_data_seek($result,$i);
											@$data = mysqli_fetch_array($result);
										?>
										<tr class="odd gradeX">
											<td width="50px">
												<?php echo ++$no_urut;?> 
											</td>
											<td>
												<strong><?php echo $data ['NamaPegawai']; ?></strong>
											</td>
											<td>
												<?php echo $data ['NIP']; ?>
											</td>
											<td>
												<?php echo $data ['Jabatan']; ?>
											</td>
											
											<td width="150px" align="center">
												<a href="UserLogin.php?id=<?php echo base64_encode($data['UserName']);?>" title='Edit'><i class='btn btn-warning btn-sm' style="border-radius:2px;"><span class='fa fa-edit'></span> </i></a> 
											
												<?php
												if($data['UserName'] === $login_id AND $data['UserName'] == 'administrator'){
													echo '';
												} else {
													echo '<a href="UserLogin.php?id='.base64_encode($data['UserName']).'&aksi='.base64_encode('Hapus').'" title="Hapus" onclick="return confirmation()"><i class="btn btn-danger btn-sm" style="border-radius:2px;"><span class="fa fa-trash"></span></i></a>';
												}
												?>
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
						<div class="tab-pane fade <?php if(@$_GET['id']!=null){ echo 'in active show'; }?>" id="tambah-user">
						  <div class="card-header">
							<h3 class="h6 text-uppercase mb-0"><?php echo $Sebutan; ?></h3>
						  </div>
							<div class="card-body">
								<form class="form-horizontal" method="post" action="">
								  <div class="form-group row">
									<label class="col-md-2 form-control-label">Nama Lengkap*</label>
									<div class="col-md-10">
									  <input type="text" class="form-control" style="border-radius:2px;" maxlength="100" placeholder="Nama Lengkap" value="<?php echo @$RowData['NamaPegawai'];?>" name="nama" required>
									</div>
								  </div>
								  <div class="form-group row">
									<label class="col-md-2 form-control-label">NIP</label>
									<div class="col-md-10">
									  <input type="text" class="form-control" style="border-radius:2px;" maxlength="20" placeholder="NIP" value="<?php echo @$RowData['NIP'];?>" name="nip" >
									</div>
								  </div>
								  <div class="form-group row">
									<label class="col-md-2 form-control-label">Jabatan</label>
									<div class="col-md-10">
									  <input type="text" class="form-control" style="border-radius:2px;" maxlength="20" placeholder="Jabatan" value="<?php echo @$RowData['Jabatan'];?>" name="jabatan" >
									</div>
								  </div>
								  <div class="form-group row">
									<label class="col-md-2 form-control-label">Username*</label>
									<div class="col-md-10">
									  <input type="text" class="form-control" style="border-radius:2px;" name="username" maxlength="100" placeholder="Username" value="<?php echo @$RowData['UserName'];?>" required <?php echo @$Readonly;?> >
									</div>
								  </div>
								  <div class="form-group row">
									<label class="col-md-2 form-control-label">Password*</label>
									<div class="col-md-10">
									  <input type="password" class="form-control" style="border-radius:2px;" maxlength="255" placeholder="Password" value="<?php echo @base64_decode($RowData['UserPsw']);?>" name="password" required>
									</div>
								  </div><hr>
								  <?php
									if(@$_GET['id']==null){
										echo '<button type="submit" class="btn btn-success btn-sm"  style="border-radius:2px;" name="Simpan">Simpan</button> &nbsp;';
									}else{
										echo '<button type="submit" class="btn btn-success btn-sm"  style="border-radius:2px;" name="SimpanEdit">Simpan</button> &nbsp;';
									}
								  ?>
								  <a href="UserLogin.php"><span class="btn btn-warning btn-sm"  style="border-radius:2px;">Batalkan</span></a>
								</form>
							</div>
						</div>
					</div>
                </div>
				
				
              </div>
            </div>
          </section>
        </div>
       <?php include 'footer.php';?>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/js/front.js"></script>
	<!-- Sweet Alerts -->
	<script src="../library/sweetalert/sweetalert.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function confirmation() {
			var answer = confirm("Apakah Anda yakin menghapus data ini ?")
			if (answer == true){
				window.location = "UserLogin.php";
				}
			else{
			alert("Terima Kasih !");	return false; 	
				}
			}
	</script>
  </body>
  <?php 
	//POST DATA
		@$nama			 	= htmlspecialchars($_POST['nama']);
		@$nip		 		= htmlspecialchars($_POST['nip']);
		@$jabatan			= htmlspecialchars($_POST['jabatan']);
		@$username		 	= htmlspecialchars($_POST['username']);
		@$password		 	= base64_encode($_POST['password']);
		
	//Tambah Data
		if(isset($_POST['Simpan'])){
			//cek apakah username ada yang sama atau tidak
			$cekuser = mysqli_query($koneksi,"select UserName from userlogin where UserName='$username'");
			$numuser = mysqli_num_rows($cekuser);
			if($numuser == 1 ){
				echo '<script type="text/javascript">
						  sweetAlert({
							title: "Simpan Data Gagal!",
							text: " Username sudah ada, Silahkan ganti username Anda! ",
							type: "error"
						  },
						  function () {
							window.location.href = "UserLogin.php";
						  });
						  </script>';
			}else{
				$query = mysqli_query($koneksi,"INSERT into userlogin (UserName,UserPsw,NIP,Jabatan,NamaPegawai,IsAktif,JenisLogin) 
				VALUES ('$username','$password','$nip','$jabatan','$nama',b'1','ADMIN WEB')");
				if($query){
					
					echo '<script language="javascript">alert("Data Berhasil Disimpan!");document.location="UserLogin.php";</script>';
				}else{
					echo '<script type="text/javascript">
						  sweetAlert({
							title: "Simpan Data Gagal!",
							text: " ",
							type: "error"
						  },
						  function () {
							window.location.href = "UserLogin.php";
						  });
						  </script>';
				}
			}
		}
		
	//Edit Data	
		if(isset($_POST['SimpanEdit'])){
			//update data user login berdasarkan username yng di pilih
			$query = mysqli_query($koneksi,"UPDATE userlogin SET NamaPegawai='$nama', NIP='$nip',Jabatan='$jabatan', UserPsw='$password' WHERE UserName='$username'");
			
			if($query){
				
				echo '<script type="text/javascript">
					  sweetAlert({
						title: "Edit Data Berhasil!",
						text: " ",
						type: "success"
					  },
					  function () {
						window.location.href = "UserLogin.php";
					  });
					  </script>';
			}else{
				echo '<script type="text/javascript">
					  sweetAlert({
						title: "Edit Data Gagal!",
						text: " ",
						type: "error"
					  },
					  function () {
						window.location.href = "UserLogin.php";
					  });
					  </script>';
			}
		}
	
	//Hapus Data
	if(base64_decode(@$_GET['aksi'])=='Hapus'){
		$query = mysqli_query($koneksi,"UPDATE userlogin SET IsAktif=b'0' WHERE UserName='".base64_decode($_GET['id'])."'");
		if($query){
			echo '<script language="javascript">document.location="UserLogin.php"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
						type: "error"
					  },
					  function () {
						window.location.href = "UserLogin.php";
					  });
					  </script>';
		}
		
	}
  ?>
</html>