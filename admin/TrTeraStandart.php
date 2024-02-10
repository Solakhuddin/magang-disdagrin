<?php
include 'akses.php';
@$fitur_id = 47;
include '../library/lock-menu.php';
@include '../library/tgl-indo.php';
$Page = 'TrMetrologi';
$SubPage = 'TrTeraStandart';
$Tanggal = date('Ymd');
$TanggalNOW = date("Y-m-d");
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
	<link rel="stylesheet" href="../library/datatables/dataTables.bootstrap.css"/>
	<style>
	/*th {
		text-align: center;
	}*/
	.Zebra_DatePicker_Icon_Wrapper {
			width:100% !important;
	}
		
	.Zebra_DatePicker_Icon {
		top: 11px !important;
		right: 12px;
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
              <h2 class="no-margin-bottom">Tera Standar Ukur</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
         <section class="tables"> 
            <div class="container-fluid">
                <div class="col-lg-12">
				  <div class="card">
					<div class="tab-content">
						<div class="tab-pane fade <?php if(@$_GET['id']==null){ echo 'in active show'; }?>" id="tambah-user">
							<div class="card-header d-flex align-items-center">
							  <h3 class="h4">Tera Standar Ukur</h3>
							</div>
							<div class="card-body">
								<div class="row">
								  <div class="col-lg-12">
									<h5>Detil Timbangan Standart Ukur</h5>
									<div class="col-md-12 text-right">
                                  		<button type="button" class="btn btn-primary btn-sm" id="btnAdd">Tambah</button>
                                	</div>
                                	<br>
                                	 <form action="TrTeraStandart_aksi.php" method="post">
                                	 	<input type="hidden" name="IDPerson" value="PRS-2019-0000000">
                                	 	<input type="hidden" name="UserName" value="<?=$login_id?>">
									  <div class="table-responsive">  
										<table class="table table-striped">
										  <thead>
											<tr>
											  <th>No</th>
											  <th>Nama Timbangan</th>
											  <th>Hasil Tera</th>
											  <th>Metode</th>
											  <th>Aksi</th>
											</tr>
										  </thead>
										  <tbody id="tableBody">                      
                                          </tbody>
										</table>
									  </div>
									</form>
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
	<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

	<div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="form_target">
        <div class="modal-content">
          <div class="modal-header">
		  	<h4 id="exampleModalLabel" class="modal-title">Hasil Tera Timbangan</h4>
		  	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		  </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Nama Fitur</label>
                  <select name="IDTimbangan" id="IDTimbangan" class="form-control" required>	
					<?php
						echo "<option value=''>--- Pilih Timbangan ---</option>";
						$idPerson = 'PRS-2019-0000000'; 
						
						$query = mysqli_prepare($koneksi, "SELECT IDTimbangan, NamaTimbangan FROM timbanganperson WHERE IDPerson=? AND StatusUTTP='Aktif' ORDER BY NamaTimbangan ASC");

						mysqli_stmt_bind_param($query, 's', $idPerson);

						mysqli_stmt_execute($query);

						mysqli_stmt_bind_result($query, $IDTimbangan, $NamaTimbangan);

						while (mysqli_stmt_fetch($query)) {
							echo '<option value="' . $IDTimbangan . '" data-nama="' . $NamaTimbangan . '">' . $NamaTimbangan . '</option>';
						}

						mysqli_stmt_close($query);

						// source code lama
						// $menu = mysqli_query($koneksi,"SELECT IDTimbangan,NamaTimbangan 
						// 	from timbanganperson 
						// 	where IDPerson='PRS-2019-0000000' and StatusUTTP='Aktif' 
						// 	order by NamaTimbangan ASC");
						// while($kode = mysqli_fetch_array($menu)){
						// 	echo '<option value="'.$kode['IDTimbangan'].'" data-nama="'.$kode['NamaTimbangan'].'">'.$kode['NamaTimbangan'].'</option>';
						// }
					?>
				  </select>
                </div>
                <div class="form-group">
                  <div class="form-group" align="left">
					<label>Hasil Pelayanan Tera</label>
					<select name="HasilAction1" id="HasilAction1" class="form-control">
						<option value="TERA SAH" <?php echo isset($row['HasilAction1']) && $row['HasilAction1'] === "TERA SAH" ?"selected" : ""; ?>>TERA SAH</option>
						<option value="TERA BATAL" <?php echo isset($row['HasilAction1']) && $row['HasilAction1'] === "TERA BATAL" ?"selected" : ""; ?>>TERA BATAL</option>
					</select>
				  </div>
                </div>
                <div class="form-group">
                  <div class="form-group" align="left">
					<label>Metode Tera UTTP</label>
					<select name="HasilAction2" id="HasilAction2" class="form-control">
						<option value="">Pilih Opsi</option>
						<option value="Syarat Teknis Meter Bahan bakar Minyak dan Pompa Ukur Elpiji" <?php echo isset($row['HasilAction2']) && $row['HasilAction2'] === "Syarat Teknis Meter Bahan bakar Minyak dan Pompa Ukur Elpiji" ?"selected" : ""; ?>>Syarat Teknis Meter Bahan bakar Minyak dan Pompa Ukur Elpiji</option>
						<option value="Syarat Teknis Timbangan Bukan Otomatis" <?php echo isset($row['HasilAction2']) && $row['HasilAction2'] === "Syarat Teknis Timbangan Bukan Otomatis" ?"selected" : ""; ?>>Syarat Teknis Timbangan Bukan Otomatis</option>
					</select>
				  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary btn-sm" type="submit">Pilih</button>
            <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </form>
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
	<!-- DatePicker -->
	<script type="text/javascript" src="../library/Datepicker/dist/zebra_datepicker.min.js"></script>
	<script src="../library/datatables/jquery.dataTables.js"></script>
    <script src="../library/datatables/dataTables.bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#time1').Zebra_DatePicker({format: 'Y-m-d'});
		});

		$(document).on('click', '#btnAdd', function () {
	      $('#ModalTambah').modal('show');
	    });

	    var DataItem = [];
	    var NamaTimbangan = '';

	    $('#IDTimbangan').change(function () {
      		NamaTimbangan = $(this).find('option:selected').attr('data-nama');
   		});

		$(document).on('click', '#btnHapus', function () {
	      var NoUrut = $(this).attr("value");
	      DataItem.splice(NoUrut, 1);     
	      DrawTable();
	    });

		$("#form_target").submit(function(e) {
	      e.preventDefault();
	      var IDTimbangan      = $('#IDTimbangan').val();
	      var HasilAction1     = $('#HasilAction1').val();
	      var HasilAction2     = $("#HasilAction2").val();
      

      

	      var dataItem = [];
	      dataItem['IDTimbangan']   = IDTimbangan;
	      dataItem['HasilAction1']  = HasilAction1;
	      dataItem['HasilAction2']  = HasilAction2;
	      dataItem['NamaTimbangan'] = NamaTimbangan;
	      
	      DataItem.push(dataItem);
	      DrawTable();
	      $('#form_target')[0].reset();
	      $('#ModalTambah').modal('toggle');
	    });

    function DrawTable(){
      var strTable = '';
      for(i=0; i < DataItem.length; i++){
        strTable += '<tr>'
        +'<td class="text-center">'+(i+1)+'</td>'
        +'<td>'+DataItem[i]['IDTimbangan']+' <br>'+DataItem[i]['NamaTimbangan'] +'<input type="hidden" name="IDTimbangan[]" value="'+DataItem[i]['IDTimbangan']+'"></td>'
        +'<td class="text-left">'+DataItem[i]['HasilAction1']+'<input type="hidden" name="HasilAction1[]" value="'+DataItem[i]['HasilAction1']+'"></td>'
        +'<td class="text-left">'+DataItem[i]['HasilAction2']+'<input type="hidden" name="HasilAction2[]" value="'+DataItem[i]['HasilAction2']+'"></td>'
        
        +'<td class="text-center">'
        +'<button id="btnHapus" value="'+i+'" class="btn btn-danger btn-sm" title="Hapus"><span>x</span></button>'
        +'</td>'
        +'</tr>';
      }
      strTable += '<tr style="background:white;"><td colspan="5" class="text-right"><br><button type="submit" name="SimpanData" class="btn btn-success btn-sm">Simpan</button></td></tr>';
      $('#tableBody').html(strTable);
    }

	</script>	
	<?php 
		@$IDPerson		= htmlspecialchars($_POST['IDPerson']);
		@$KodeLokasi	= htmlspecialchars($_POST['KodeLokasi']);
		@$NoTransaksi	= htmlspecialchars($_POST['NoTransaksi']);
		@$UserName		= htmlspecialchars($_POST['UserName']);
		@$IDTimbangan	= htmlspecialchars($_POST['IDTimbangan']);
		@$Keterangan	= htmlspecialchars($_POST['Keterangan']);
		@$NoUrutTrans	= htmlspecialchars($_POST['NoUrutTrans']);
		@$NoSKRD		= htmlspecialchars($_POST['NoSKRD']);
		@$TotalRetribusi= htmlspecialchars($_POST['TotalRetribusi']);
		@$NoRefTera 	= htmlspecialchars($_POST['NoRefTera']);
		@$NoRefAmbil	= htmlspecialchars($_POST['NoRefAmbil']);
		@$KeteranganTera= htmlspecialchars($_POST['KeteranganTera']);
		@$HasilAction1  = htmlspecialchars($_POST['HasilAction1']);
		@$HasilAction2  = htmlspecialchars($_POST['HasilAction2']);
		@$Retribusi     = htmlspecialchars($_POST['Retribusi']);
		$TanggalTransaksi = date("Y-m-d H:i:s");
		
		if(isset($_POST['SimpanTrans'])){
			// cek apakah sudah ada permohonan
			
			$cek = mysqli_prepare($koneksi, "SELECT * FROM tractiontimbangan WHERE IDPerson=? AND (StatusTransaksi='PRSOSS SIDANG' OR StatusTransaksi='PRAWAITING')");

			mysqli_stmt_bind_param($cek, 's', $IDPerson);

			mysqli_stmt_execute($cek);

			$result = mysqli_stmt_get_result($cek);

			$num = mysqli_num_rows($result);

			mysqli_stmt_close($query);

			// $cek = @mysqli_query($koneksi, "SELECT * from tractiontimbangan where IDPerson='$IDPerson' AND (StatusTransaksi='PRSOSS SIDANG'  OR StatusTransaksi ='PRAWAITING')");
			// $num = @mysqli_num_rows($cek);
			
			if($num > 0){
				echo '<script type="text/javascript">swal( "Transaksi Sudah Ada!", " Silahkan Mengubah Transaksi Yang Sudah Ada ", "error" ); </script>';
			}else{ 
				// membuat id otomatis

				$query = mysqli_prepare($koneksi, "SELECT RIGHT(NoTransaksi,8) AS kode FROM tractiontimbangan ORDER BY NoTransaksi DESC LIMIT 1");

				mysqli_stmt_execute($query);

				mysqli_stmt_bind_result($query, $kode);

				mysqli_stmt_fetch($query);

				$nums = mysqli_stmt_num_rows($query);
				
				// source code lama
				// $sql = @mysqli_query($koneksi, "SELECT RIGHT(NoTransaksi,8) AS kode FROM tractiontimbangan ORDER BY NoTransaksi DESC LIMIT 1"); 
				// $nums = mysqli_num_rows($sql);
	
				if($nums <> 0){
					$kode = $data['kode'] + 1;
				}else{
					$kode = 1;
				}
				mysqli_stmt_close($query);
				//mulai bikin kode
				 $bikin_kode = str_pad($kode, 8, "0", STR_PAD_LEFT);
				 $kode_jadi = "TR-".$Tanggal."-".$bikin_kode;
				
				//simpan 
				$SimpanData = @mysqli_query($koneksi, "INSERT INTO tractiontimbangan (NoTransaksi,IDPerson,JenisTransaksi,UserTerima,UserTera,UserAmbil,KodeLokasi,TglTransaksi,StatusTransaksi)VALUES('$kode_jadi','$IDPerson','TERA DI LOKASI','$login_id','$login_id','$login_id','$KodeLokasi', DATE(NOW()), 'PRAWAITING')"); 
				
				if ($SimpanData){
						InsertLog($koneksi, 'Tambah Data', 'Menambah Transaksi Tera Timbangan Di Lokasi', $login_id, $kode_jadi, 'Transaksi Tera Di Lokasi');
						echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.base64_encode($kode_jadi).'";</script>';
					}else{
						echo '<script type="text/javascript">
					  sweetAlert({
						title: "Simpan Data Gagal!",
						text: " ",
						type: "error"
					  },
					  function () {
						window.location.href = "TrTeraDilokasi.php";
					  });
					  </script>';
					}
				
				
			}
	}
	
	
	
	//Simpan Edit Item Timbangan
	if(isset($_POST['SimpanEdit'])){
		$query = mysqli_prepare($koneksi, "SELECT a.RetribusiDiLokasi, b.UkuranRealTimbangan, a.NilaiBawah, a.RetPenambahanDilokasi, a.NilaiTambah FROM detilukuran a JOIN timbanganperson b ON (a.KodeTimbangan = b.KodeTimbangan AND a.KodeKelas = b.KodeKelas AND a.KodeUkuran = b.KodeUkuran) WHERE b.IDTimbangan = ?");

		mysqli_stmt_bind_param($query, "s", $IDTimbangan);

		mysqli_stmt_execute($query);

		mysqli_stmt_bind_result($query, $RetribusiDiLokasi, $UkuranRealTimbangan, $NilaiBawah, $RetPenambahanDilokasi, $NilaiTambah);

		mysqli_stmt_fetch($query);

		$res = array(
			"RetribusiDiLokasi" => $RetribusiDiLokasi, 
			"UkuranRealTimbangan" => $UkuranRealTimbangan, 
			"RetPenambahanDilokasi" => $RetPenambahanDilokasi, 
			"NilaiBawah" => $NilaiBawah, 
			"NilaiTambah" => $NilaiTambah
		);

		mysqli_stmt_close($query);

		// source code lama 
		// $sql 	= mysqli_query($koneksi, ("SELECT a.RetribusiDiLokasi,b.UkuranRealTimbangan,a.NilaiBawah,a.RetPenambahanDilokasi,a.NilaiTambah FROM detilukuran a join timbanganperson b on (a.KodeTimbangan,a.KodeKelas,a.KodeUkuran) = (b.KodeTimbangan,b.KodeKelas,b.KodeUkuran) WHERE b.IDTimbangan='$IDTimbangan'"));
		// $res    = mysqli_fetch_array($sql);
		
		if ($res['NilaiBawah'] == '0' AND $res['RetPenambahanDilokasi'] == '0' ) {
			$query = mysqli_prepare($koneksi, "UPDATE trtimbanganitem SET IDTimbangan=?, HasilAction1=?, HasilAction2=?, HasilAction3=?, NominalRetribusi=? WHERE NoTransaksi=? AND NoUrutTrans=?");

			mysqli_stmt_bind_param($query, "ssssdss", $IDTimbangan, $HasilAction1, $HasilAction2, $HasilAction3, $res["RetribusiDiLokasi"], $NoTransaksi, $NoUrutTrans);

			mysqli_stmt_execute($query);

			mysqli_stmt_close($query);

			// SC lama
			// $query = mysqli_query($koneksi,"UPDATE trtimbanganitem SET IDTimbangan='$IDTimbangan',HasilAction1='$HasilAction1', HasilAction2='$HasilAction2', HasilAction3='$HasilAction3',NominalRetribusi='".$res[0]."' WHERE NoTransaksi='$NoTransaksi' and NoUrutTrans='$NoUrutTrans'");
		}else{
			$Nilai = ($res['UkuranRealTimbangan']-$res['NilaiTambah'])/$res['NilaiBawah'];
			$Penambahan =($Nilai*$res['RetPenambahanDilokasi'])+$res['RetribusiDiLokasi'];
			
			$query = mysqli_prepare($koneksi, "UPDATE trtimbanganitem SET IDTimbangan=?, HasilAction1=?, HasilAction2=?, HasilAction3=?, NominalRetribusi=? WHERE NoTransaksi=? AND NoUrutTrans=?");

			mysqli_stmt_bind_param($query, "ssssdds", $IDTimbangan, $HasilAction1, $HasilAction2, $HasilAction3, $Penambahan, $NoTransaksi, $NoUrutTrans);

			mysqli_stmt_execute($query);

			mysqli_stmt_close($query);

			// SC lama
			// $query = mysqli_query($koneksi,"UPDATE trtimbanganitem SET IDTimbangan='$IDTimbangan',HasilAction1='$HasilAction1', HasilAction2='$HasilAction2', HasilAction3='$HasilAction3',NominalRetribusi='".$Penambahan."' WHERE NoTransaksi='$NoTransaksi' and NoUrutTrans='$NoUrutTrans'");
		}
				
		if ($query){
			InsertLog($koneksi, 'Edit Data', 'Mengubah Item Timbangan Transaksi Tera  Di Lokasi ', $login_id, $NoTransaksi, 'Transaksi Tera Di Lokasi');
			echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.base64_encode($NoTransaksi).'";</script>';
		}else{
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Simpan Data Gagal!",
				text: " ",
				type: "error"
			  },
			  function () {
				window.location.href = "TrTeraDilokasi.php";
			  });
			  </script>';
		}
	}
	
	
		
	//Hapus Data Item Timbangan
	if(base64_decode(@$_GET['aksi'])=='Hapus'){
		$id = htmlspecialchars(base64_decode($_GET['id']));
		$nm = htmlspecialchars(base64_decode($_GET['nm']));

		$query = mysqli_prepare($koneksi, "SELECT FotoAction1, FotoAction2, FotoAction3, IDTimbangan FROM trtimbanganitem WHERE NoTransaksi=? AND NoUrutTrans=?");

		mysqli_stmt_bind_param($query, "ss", $id, $nm);

		mysqli_stmt_execute($query);

		mysqli_stmt_bind_result($query, $FotoAction1, $FotoAction2, $FotoAction3, $IDTimbangan);

		mysqli_stmt_fetch($query);

		$data = array(
			"FotoAction1" => $FotoAction1, 
			"FotoAction2" => $FotoAction2, 
			"FotoAction3" => $FotoAction3, 
			"IDTimbangan" => $IDTimbangan
		);

		mysqli_stmt_close($query);

		// SC lama
		// $HapusGambar = mysqli_query($koneksi,"SELECT FotoAction1,FotoAction2,FotoAction3,IDTimbangan FROM trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."' and NoUrutTrans='".htmlspecialchars(base64_decode($_GET['nm']))."'");
		// $data=mysqli_fetch_array($HapusGambar);
		
		$query = mysqli_prepare($koneksi, "UPDATE timbanganperson SET StatusUTTP='Aktif' WHERE IDTimbangan=?");

		mysqli_stmt_bind_param($query, "s", $data['IDTimbangan']);

		mysqli_stmt_execute($query);

		mysqli_stmt_close($query);

		// SC lama
		// mysqli_query($koneksi,"update timbanganperson set StatusUTTP='Aktif' where IDTimbangan='".$data['IDTimbangan']."'");
		
		$id = htmlspecialchars(base64_decode($_GET['id']));
		$nm = htmlspecialchars(base64_decode($_GET['nm']));
		$rp = htmlspecialchars(base64_decode($_GET['rp']));

		$queryDelete = mysqli_prepare($koneksi, "DELETE FROM trtimbanganitem WHERE NoTransaksi=? AND NoUrutTrans=?");

		mysqli_stmt_bind_param($queryDelete, "ss", $id, $nm);

		mysqli_stmt_execute($queryDelete);

		// $query = mysqli_query($koneksi,"delete from trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."' and NoUrutTrans='".htmlspecialchars(base64_decode($_GET['nm']))."'");
		if(mysqli_stmt_affected_rows($queryDelete) > 0){
			$queryUpdate = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET TotalRetribusi=? WHERE NoTransaksi=?");
	
			mysqli_stmt_bind_param($queryUpdate, "ds", $rp, $id);
	
			mysqli_stmt_execute($queryUpdate);
			
			// mysqli_query($koneksi,"update tractiontimbangan set TotalRetribusi='".htmlspecialchars(base64_decode($_GET['rp']))."' where NoTransaksi='".htmlspecialchars(base64_decode($_GET['id']))."'");
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Data Item Timbangan', $login_id, base64_decode(@$_GET['id']), 'Transaksi Tera Di Lokasi');
			mysqli_stmt_close($queryUpdate);
			echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.$_GET['id'].'"; </script>';
		}else{
			mysqli_stmt_close($queryDelete);
			echo '<script type="text/javascript">
			sweetAlert({
				title: "Hapus Data Gagal!",
				text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
				type: "error"
			},
			function () {
				window.location.href = "TrTeraDilokasi.php";
			});
			</script>';
		}
		mysqli_stmt_close($queryDelete);
	}
	
	//Ganti User Pemohon
	if(isset($_POST['GantiTrans'])){ 
		// cek apakah sudah ada permohonan

		// Prepare the SQL statement
		$query = mysqli_prepare($koneksi, "SELECT * FROM tractiontimbangan WHERE IDPerson=? AND KodeLokasi=? AND (StatusTransaksi='PROSES SIDANG' OR StatusTransaksi='PRAWAITING')");

		mysqli_stmt_bind_param($query, "ss", $IDPerson, $KodeLokasi);

		mysqli_stmt_execute($query);

		mysqli_stmt_store_result($query);

		$num = mysqli_stmt_num_rows($query);

		mysqli_stmt_close($query);

		// SC lama
		// $cek = @mysqli_query($koneksi, "SELECT * from tractiontimbangan where IDPerson='$IDPerson' AND KodeLokasi='$KodeLokasi' AND ( StatusTransaksi='PROSES SIDANG' OR StatusTransaksi='PRAWAITING')");
		// $num = @mysqli_num_rows($cek);
		
		if($num > 0){
			echo '<script type="text/javascript">swal( "Transaksi Sudah Ada!", "Silahkan Mengubah Transaksi Yang Sudah Ada ", "error" ); </script>';
		}else{ 
			$queryDelete = mysqli_prepare($koneksi, "DELETE FROM trtimbanganitem WHERE NoTransaksi=?");
			mysqli_stmt_bind_param($queryDelete, "s", $NoTransaksi);
			mysqli_stmt_execute($queryDelete);

			$queryUpdate = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET IDPerson=?, KodeLokasi=? WHERE NoTransaksi=?");
			mysqli_stmt_bind_param($queryUpdate, "sss", $IDPerson, $KodeLokasi, $NoTransaksi);
			mysqli_stmt_execute($queryUpdate);

			// SC lama
			// mysqli_query($koneksi,"DELETE FROM trtimbanganitem WHERE NoTransaksi='$NoTransaksi'");
			//update 
			// $query = mysqli_query($koneksi,"UPDATE tractiontimbangan SET IDPerson='$IDPerson', KodeLokasi='$KodeLokasi' WHERE NoTransaksi='$NoTransaksi'");
			if ($queryUpdate){
				InsertLog($koneksi, 'Edit Data', 'Mengubah User Pemohon Transaksi Penerimaan Timbangan User', $login_id, $NoTransaksi, 'Transaksi Tera Di Lokasi');
				echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.base64_encode($NoTransaksi).'";</script>';
			}else{
				echo '<script type="text/javascript">
				  sweetAlert({
					title: "Simpan Data Gagal!",
					text: " ",
					type: "error"
				  },
				  function () {
					window.location.href = "TrTeraDilokasi.php";
				  });
				  </script>';
			}
			mysqli_stmt_close($queryDelete);
			mysqli_stmt_close($queryUpdate);
		}
	}
	
	//Simpan Transaksi Penerimaan
	if(isset($_POST['SimpanTransaksi'])){
		// cek apakah sudah ada permohonan
		$query = mysqli_prepare($koneksi, "SELECT * FROM trtimbanganitem WHERE NoTransaksi=?");

		mysqli_stmt_bind_param($query, "s", $NoTransaksi);

		mysqli_stmt_execute($query);

		mysqli_stmt_store_result($query);

		$num = mysqli_stmt_num_rows($query);

		mysqli_stmt_close($query);

		// $cek = @mysqli_query($koneksi, "SELECT * from trtimbanganitem where NoTransaksi='$NoTransaksi'");
		// $num = @mysqli_num_rows($cek);
		// echo $num;
		
		if($num <= 0){
			echo '<script type="text/javascript">swal( "Item Timbangan Belum Ada!", " Silahkan inputkan item timbangan user ", "error" ); </script>';
		}else{ 
			$query = mysqli_prepare($koneksi, "SELECT NoRefAmbil FROM tractiontimbangan WHERE NoTransaksi=?");

			mysqli_stmt_bind_param($query, "s", $NoTransaksi);

			mysqli_stmt_execute($query);

			mysqli_stmt_bind_result($query, $NoRefAmbil);

			mysqli_stmt_fetch($query);

			mysqli_stmt_close($query);

			// SC lama
			// $res = @mysqli_query($koneksi, "SELECT NoRefAmbil from tractiontimbangan where NoTransaksi='$NoTransaksi'");
			// $check = @mysqli_fetch_array($res);
			
			if (empty($NoRefAmbil)){
					// membuat id no ref tera
					$query = mysqli_prepare($koneksi, "SELECT RIGHT(NoRefTera, 8) AS kode FROM tractiontimbangan ORDER BY NoRefTera DESC LIMIT 1");

					mysqli_stmt_execute($query);

					mysqli_stmt_bind_result($query, $kode);

					mysqli_stmt_fetch($query);

					$nums = mysqli_stmt_num_rows($query);

					if ($nums != 0) {
						$kode += 1;
					} else {
						$kode = 1;
					}

					mysqli_stmt_close($query);

					// SC lama
					// $sql = @mysqli_query($koneksi, "SELECT RIGHT(NoRefTera,8) AS kode FROM tractiontimbangan ORDER BY NoRefTera DESC LIMIT 1"); 
					// $nums = mysqli_num_rows($sql);
					// if($nums <> 0){
					// 	 $data = mysqli_fetch_array($sql);
					// 	 $kode = $data['kode'] + 1;
					// }else{
					// 	 $kode = 1;
					// }

					//mulai bikin kode
					 $bikin_kode = str_pad($kode, 8, "0", STR_PAD_LEFT);
					 $kode_jadi = "TB-".$Tanggal."-".$bikin_kode;
				
					//Noref Ambil
					
					$query = mysqli_prepare($koneksi, "SELECT RIGHT(NoRefAmbil, 8) AS kodeambil FROM tractiontimbangan ORDER BY NoRefAmbil DESC LIMIT 1");

					mysqli_stmt_execute($query);

					mysqli_stmt_bind_result($query, $kodeambil);

					mysqli_stmt_fetch($query);

					$nums1 = mysqli_stmt_num_rows($query);

					if ($nums1 != 0) {
						$kode1 = $kodeambil + 1;
					} else {
						$kode1 = 1;
					}

					mysqli_stmt_close($query1);

					// SC lama
					// $sql1 = @mysqli_query($koneksi, "SELECT RIGHT(NoRefAmbil,8) AS kodeambil FROM tractiontimbangan ORDER BY NoRefAmbil DESC LIMIT 1"); 
					// $nums1 = mysqli_num_rows($sql1);
					// if($nums1 <> 0){
					// 	 $data1 = mysqli_fetch_array($sql1);
					// 	 $kode1 = $data1['kodeambil'] + 1;
					// }else{
					// 	 $kode1 = 1;
					// }

					//mulai bikin kode
					$bikin_kode1 = str_pad($kode1, 8, "0", STR_PAD_LEFT);
					$kode_ambil = "AML-".$Tanggal."-".$bikin_kode1;
				
					$query = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET NoSKRD=?, TotalRetribusi=?, KeteranganTera=?, NoRefTera=?, NoRefAmbil=?, IsDiambil=?, TglAmbil=?, IsDitera=?, UserTera=?, StatusTransaksi=?, TglTera=? WHERE NoTransaksi=? AND IDPerson=?");

					mysqli_stmt_bind_param($query, "sdsdssdssssss", $NoSKRD, $TotalRetribusi, $KeteranganTera, $kode_jadi, $kode_ambil, $IsDiambil, $TanggalTransaksi, $IsDitera, $login_id, $StatusTransaksi, $TanggalTransaksi, $NoTransaksi, $IDPerson);

					mysqli_stmt_execute($query);

					// Close the statement
					mysqli_stmt_close($query);

					// $query = mysqli_query($koneksi,"UPDATE tractiontimbangan SET NoSKRD='$NoSKRD', TotalRetribusi='$TotalRetribusi',KeteranganTera='$KeteranganTera',NoRefTera='$kode_jadi',NoRefAmbil='$kode_ambil',IsDiambil=b'1',TglAmbil='$TanggalTransaksi',IsDitera=b'1',UserTera='$login_id',StatusTransaksi='SELESAI',TglTera='$TanggalTransaksi' WHERE NoTransaksi='$NoTransaksi' and IDPerson='$IDPerson'");
			}else{
				$query = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET NoSKRD=?, TotalRetribusi=?, KeteranganTera=?, IsDiambil=?, TglAmbil=?, IsDitera=?, UserTera=?, StatusTransaksi=?, TglTera=? WHERE NoTransaksi=? AND IDPerson=?");

				mysqli_stmt_bind_param($query, "sdsdssdsss", $NoSKRD, $TotalRetribusi, $KeteranganTera, $IsDiambil, $TanggalTransaksi, $IsDitera, $login_id, $StatusTransaksi, $TanggalTera, $NoTransaksi, $IDPerson);

				mysqli_stmt_execute($query);

				mysqli_stmt_close($query);

				// SC lama
				// $query = mysqli_query($koneksi,"UPDATE tractiontimbangan SET NoSKRD='$NoSKRD', TotalRetribusi='$TotalRetribusi',KeteranganTera='$KeteranganTera',IsDiambil=b'1',TglAmbil='$TanggalTransaksi',IsDitera=b'1',UserTera='$login_id',StatusTransaksi='SELESAI',TglTera='$TanggalTransaksi' WHERE NoTransaksi='$NoTransaksi' and IDPerson='$IDPerson'");
			}
	
			if ($query){
				InsertLog($koneksi, 'Edit Data', 'Transaksi Tera DiLokasi', $login_id, $NoTransaksi, 'Transaksi Tera Di Lokasi');
				echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.base64_encode($NoTransaksi).'";</script>';
			}else{
				echo '<script type="text/javascript">
				  sweetAlert({
					title: "Simpan Data Gagal!",
					text: " ",
					type: "error"
				  },
				  function () {
					window.location.href = "TrTeraDilokasi.php";
				  });
				  </script>';
			}
		}
	}
	
	//Hapus Transaksi Penerimaan
	if(base64_decode(@$_GET['aksi'])=='HapusTransaksi'){
		$decoded_tr = htmlspecialchars(base64_decode($_GET['tr']));

		$query = mysqli_prepare($koneksi, "SELECT IDTimbangan FROM trtimbanganitem WHERE NoTransaksi=?");

		mysqli_stmt_bind_param($query, "s", $decoded_tr);

		mysqli_stmt_execute($query);

		mysqli_stmt_bind_result($query, $IDTimbangan);

		mysqli_stmt_fetch($query);

		mysqli_stmt_close($query);

		// $HapusGambar = mysqli_query($koneksi,"SELECT IDTimbangan FROM trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."'");
		// $data=mysqli_fetch_array($HapusGambar);

		$decoded_tr = htmlspecialchars(base64_decode($_GET['tr']));

		// Prepare the first SQL statement to delete records from trtimbanganitem
		$queryDelete1 = mysqli_prepare($koneksi, "DELETE FROM trtimbanganitem WHERE NoTransaksi=?");
		mysqli_stmt_bind_param($queryDelete1, "s", $decoded_tr);
		mysqli_stmt_execute($queryDelete1);
		mysqli_stmt_close($queryDelete1);

		// Prepare the second SQL statement to delete records from tractiontimbangan
		$queryDelete2 = mysqli_prepare($koneksi, "DELETE FROM tractiontimbangan WHERE NoTransaksi=?");
		mysqli_stmt_bind_param($queryDelete2, "s", $decoded_tr);
		mysqli_stmt_execute($queryDelete2);

		// Check if the deletion was successful
		// mysqli_query($koneksi,"DELETE FROM trtimbanganitem WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."'");
		// $query = mysqli_query($koneksi,"delete from tractiontimbangan WHERE NoTransaksi='".htmlspecialchars(base64_decode($_GET['tr']))."' ");
		if(mysqli_stmt_affected_rows($queryDelete2) > 0) {
			$queryUpdate = mysqli_prepare($koneksi, "UPDATE timbanganperson SET StatusUTTP='Aktif' WHERE IDTimbangan=?");
			mysqli_stmt_bind_param($queryUpdate, "s", $IDTimbangan);
			mysqli_stmt_execute($queryUpdate);
			mysqli_stmt_close($queryUpdate);

			// mysqli_query($koneksi,"update timbanganperson set StatusUTTP='Aktif' where IDTimbangan='$IDTimbangan'");
			InsertLog($koneksi, 'Hapus Data', 'Menghapus Data Transaksi Tera Timbangan Di Lokasi', $login_id, base64_decode(@$_GET['tr']), 'Transaksi Tera Di Lokasi');
			echo '<script language="javascript">document.location="TrTeraDilokasi.php"; </script>';
		}else{
			echo '<script type="text/javascript">
					  sweetAlert({
						title: "Hapus Data Gagal!",
						text: " Data Telah Digunakan Dalam Berbagai Transaksi ",
						type: "error"
					  },
					  function () {
						window.location.href = "TrTeraDilokasi.php";
					  });
					  </script>';
		}
	}
	
	if(isset($_POST['TeraUTTP'])){
		$query = mysqli_prepare($koneksi, "SELECT MAX(NoUrutTrans) as NoSaatIni FROM trtimbanganitem WHERE NoTransaksi=?");

		mysqli_stmt_bind_param($query, "s", $NoTransaksi);

		mysqli_stmt_execute($query);

		mysqli_stmt_bind_result($query, $NoSaatIni);

		mysqli_stmt_fetch($query);

		$Urutan = $NoSaatIni + 1;

		mysqli_stmt_close($query);

		// $AmbilNoUrut=mysqli_query($koneksi,"SELECT MAX(NoUrutTrans) as NoSaatIni FROM trtimbanganitem WHERE NoTransaksi='$NoTransaksi'");
		// $Data=mysqli_fetch_assoc($AmbilNoUrut);
		// $NoSekarang = $Data['NoSaatIni'];
		// $Urutan = $NoSekarang+1;
				
		@$Status = isset($HasilAction1) && $HasilAction1 === "TERA BATAL" ? "Non Aktif" : "Aktif";
		$query = mysqli_prepare($koneksi, "UPDATE timbanganperson SET StatusUTTP=? WHERE IDTimbangan=?");

		mysqli_stmt_bind_param($query, "ss", $Status, $IDTimbangan);

		mysqli_stmt_execute($query);

		mysqli_stmt_close($query);

		// mysqli_query($koneksi,"update timbanganperson set StatusUTTP='$Status' where IDTimbangan='$IDTimbangan'");
		
		$query = mysqli_prepare($koneksi, "SELECT a.RetribusiDiLokasi, b.UkuranRealTimbangan, a.NilaiBawah, a.RetPenambahanDilokasi, a.NilaiTambah FROM detilukuran a JOIN timbanganperson b ON (a.KodeTimbangan = b.KodeTimbangan AND a.KodeKelas = b.KodeKelas AND a.KodeUkuran = b.KodeUkuran) WHERE b.IDTimbangan=?");

		mysqli_stmt_bind_param($query, "s", $IDTimbangan);

		mysqli_stmt_execute($query);

		mysqli_stmt_bind_result($query, $RetribusiDiLokasi, $UkuranRealTimbangan, $NilaiBawah, $RetPenambahanDilokasi, $NilaiTambah);

		mysqli_stmt_fetch($query);

		$res = array(
				"RetribusiDiLokasi" => $RetribusiDiLokasi, 
				"UkuranRealTimbangan" => $UkuranRealTimbangan, 
				"NilaiBawah" => $NilaiBawah, 
				"RetPenambahanDilokasi" => $RetPenambahanDilokasi, 
				"NilaiTambah" => $NilaiTambah
			);

		mysqli_stmt_close($query);

		// $sql 	= mysqli_query($koneksi, ("SELECT a.RetribusiDiLokasi,b.UkuranRealTimbangan,a.NilaiBawah,a.RetPenambahanDilokasi,a.NilaiTambah FROM detilukuran a join timbanganperson b on (a.KodeTimbangan,a.KodeKelas,a.KodeUkuran) = (b.KodeTimbangan,b.KodeKelas,b.KodeUkuran) WHERE b.IDTimbangan='$IDTimbangan'"));
		// $res    = mysqli_fetch_array($sql);
		
		if ($HasilAction1 == 'TERA BATAL'){
			$query = mysqli_prepare($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi, NoUrutTrans, IDPerson, IDTimbangan, UserName, NominalRetribusi, KodeLokasi, HasilAction1, HasilAction2, TanggalTransaksi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			mysqli_stmt_bind_param($query, "ssssssssss", $NoTransaksi, $Urutan, $IDPerson, $IDTimbangan, $login_id, $NominalRetribusi, $KodeLokasi, $HasilAction1, $HasilAction2, $TanggalNOW);

			mysqli_stmt_execute($query);

			mysqli_stmt_close($query);

			// $SimpanData = @mysqli_query($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi,NoUrutTrans,IDPerson,IDTimbangan,UserName,NominalRetribusi,KodeLokasi,HasilAction1,HasilAction2,TanggalTransaksi)VALUES('$NoTransaksi','$Urutan','$IDPerson','$IDTimbangan','$login_id','0','$KodeLokasi','$HasilAction1','$HasilAction2','$TanggalNOW')"); 
			
			$Total = $Retribusi;
			
			$query = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET TotalRetribusi=? WHERE NoTransaksi=?");

			mysqli_stmt_bind_param($query, "ss", $Total, $NoTransaksi);

			mysqli_stmt_execute($query);

			mysqli_stmt_close($query);

			// mysqli_query($koneksi,"update tractiontimbangan set TotalRetribusi='$Total' where NoTransaksi='$NoTransaksi'");
			
		}else{
			if ($res['NilaiBawah'] == '0' AND $res['RetPenambahanDilokasi'] == '0' ) {
				$query = mysqli_prepare($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi, NoUrutTrans, IDPerson, IDTimbangan, UserName, NominalRetribusi, KodeLokasi, HasilAction1, HasilAction2, TanggalTransaksi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

				// Bind the parameters
				mysqli_stmt_bind_param($query, "ssssssssss", $NoTransaksi, $Urutan, $IDPerson, $IDTimbangan, $login_id, $res[0], $KodeLokasi, $HasilAction1, $HasilAction2, $TanggalNOW);

				mysqli_stmt_execute($query);

				// mysqli_stmt_close($query);

				// $SimpanData = @mysqli_query($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi,NoUrutTrans,IDPerson,IDTimbangan,UserName,NominalRetribusi,KodeLokasi,HasilAction1,HasilAction2,TanggalTransaksi)VALUES('$NoTransaksi','$Urutan','$IDPerson','$IDTimbangan','$login_id','".$res[0]."','$KodeLokasi','$HasilAction1','$HasilAction2','$TanggalNOW')"); 
				
				$Total = $Retribusi+$res[0];
				$query = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET TotalRetribusi=? WHERE NoTransaksi=?");

				mysqli_stmt_bind_param($query, "ds", $Total, $NoTransaksi);

				mysqli_stmt_execute($query);

				mysqli_stmt_close($query);
				// mysqli_query($koneksi,"update tractiontimbangan set TotalRetribusi='$Total' where NoTransaksi='$NoTransaksi'");
			}else{
				$Nilai = ($res['UkuranRealTimbangan']-$res['NilaiTambah'])/$res['NilaiBawah'];
				$Penambahan =($Nilai*$res['RetPenambahanDilokasi'])+$res['RetribusiDiLokasi'];
				
				$query = mysqli_prepare($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi, NoUrutTrans, IDPerson, IDTimbangan, UserName, NominalRetribusi, KodeLokasi, HasilAction1, HasilAction2, TanggalTransaksi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

				mysqli_stmt_bind_param($query, "ssssssssss", $NoTransaksi, $Urutan, $IDPerson, $IDTimbangan, $UserName, $Penambahan, $KodeLokasi, $HasilAction1, $HasilAction2, $TanggalNOW);

				mysqli_stmt_execute($query);

				mysqli_stmt_close($query);

				// $SimpanData = @mysqli_query($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi,NoUrutTrans,IDPerson,IDTimbangan,UserName,NominalRetribusi,KodeLokasi,HasilAction1,HasilAction2,TanggalTransaksi)VALUES('$NoTransaksi','$Urutan','$IDPerson','$IDTimbangan','$UserName','".$Penambahan."','$KodeLokasi','$HasilAction1','$HasilAction2','$TanggalNOW')"); 
				$Total = $Retribusi+$Penambahan;

				$query = mysqli_prepare($koneksi, "UPDATE tractiontimbangan SET TotalRetribusi=? WHERE NoTransaksi=?");

				mysqli_stmt_bind_param($query, "ds", $Total, $NoTransaksi);

				mysqli_stmt_execute($query);

				mysqli_stmt_close($query);
				
				// mysqli_query($koneksi,"update tractiontimbangan set TotalRetribusi='$Total' where NoTransaksi='$NoTransaksi'");
			}
			
		}
		
		if($SimpanData){
			InsertLog($koneksi, 'Tambah Data', 'Menambah Data Item Timbangan ', $login_id, $NoTransaksi, 'Transaksi Tera Di Lokasi');
			echo '<script language="javascript">document.location="TrTeraDilokasi.php?id='.base64_encode($NoTransaksi).'";</script>';
		}else{
			echo '<script language="javascript">alert("Data Gagal Disimpan!");document.location="TrTeraDilokasi.php"; </script>';
		}
		
	}
	
	
	?>
  </body>
</html>
