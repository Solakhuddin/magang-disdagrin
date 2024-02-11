<html>
<head>
  <?php include 'title.php';?>
  <!-- Sweet Alerts -->
  <link rel="stylesheet" href="../library/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body>
<script src="js/jquery.min.js"></script>
<!-- Sweet Alerts -->
<script src="../library/sweetalert/sweetalert.min.js" type="text/javascript"></script>
</body>
<?php
if(isset($_POST['SimpanData'])){
	include "../library/config.php";

	@$IDPerson		= htmlspecialchars($_POST['IDPerson']);
	@$UserName		= htmlspecialchars($_POST['UserName']);
	$Tanggal = date('Ymd');
	$TanggalNOW = date("Y-m-d");


	$query = "SELECT RIGHT(NoTransaksi, 8) AS kode FROM tractiontimbangan ORDER BY NoTransaksi DESC LIMIT 1";
	$stmt = mysqli_prepare($koneksi, $query);

	mysqli_stmt_execute($stmt);

	mysqli_stmt_bind_result($stmt, $kode);

	mysqli_stmt_fetch($stmt);

	if (mysqli_stmt_num_rows($stmt) !== 0) {
		$kode += 1;
	} else {
		$kode = 1;
	}

	mysqli_stmt_close($stmt);

	// $sql = @mysqli_query($koneksi, "SELECT RIGHT(NoTransaksi,8) AS kode FROM tractiontimbangan ORDER BY NoTransaksi DESC LIMIT 1"); 
	// $nums = mysqli_num_rows($sql);
	// if($nums <> 0){
	// 	 $data = mysqli_fetch_array($sql);
	// 	 $kode = $data['kode'] + 1;
	// }else{
	// 	 $kode = 1;
	// }

	//mulai bikin kode
	 $bikin_kode = str_pad($kode, 8, "0", STR_PAD_LEFT);
	 $kode_jadi = "TR-".$Tanggal."-".$bikin_kode;

	 
	 // Prepare the SQL statement for inserting the main transaction
	 $insertQuery = "INSERT INTO tractiontimbangan (NoTransaksi,IDPerson,JenisTransaksi,UserTerima,UserTera,UserAmbil,TglTransaksi,StatusTransaksi,TotalRetribusi,IsDibayar,IsDiambil,TglAmbil,TglTera) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";
	 
	 // Prepare the statement
	 $insertStmt = mysqli_prepare($koneksi, $insertQuery);
	 
	 // Bind parameters
	 mysqli_stmt_bind_param($insertStmt, "sissssssiiss", $kode_jadi, $IDPerson, $JenisTransaksi, $UserName, $UserName, $UserName, $TglTransaksi, $StatusTransaksi, $TotalRetribusi, $IsDibayar, $IsDiambil);
	 
	 $SimpanData = mysqli_stmt_execute($insertStmt);
	 
	 //  $SimpanData = @mysqli_query($koneksi, "INSERT INTO tractiontimbangan (NoTransaksi,IDPerson,JenisTransaksi,UserTerima,UserTera,UserAmbil,TglTransaksi,StatusTransaksi,TotalRetribusi,IsDibayar,IsDiambil,TglAmbil,TglTera)VALUES('$kode_jadi','$IDPerson','TERA DI LOKASI','$UserName','$UserName','$UserName', DATE(NOW()), 'SELESAI','0',b'1',b'1',NOW(),NOW())"); 
	 
	if($SimpanData){

		 for ($i=0; $i < sizeof($_POST['IDTimbangan']); $i++) {

		 	$IDTimbangan	=$_POST["IDTimbangan"][$i];
			$HasilAction1   =$_POST["HasilAction1"][$i];
			$HasilAction2	=$_POST["HasilAction2"][$i];
			$NoUrutTrans	=($i+1);

			@$Status = isset($HasilAction1) && $HasilAction1 === "TERA BATAL" ? "Non Aktif" : "Aktif";
			
			// Update timbanganperson table
			$updateTimbanganPersonQuery = "UPDATE timbanganperson SET StatusUTTP = ? WHERE IDTimbangan = ?";
			$updateTimbanganPersonStmt = mysqli_prepare($koneksi, $updateTimbanganPersonQuery);
			mysqli_stmt_bind_param($updateTimbanganPersonStmt, "si", $Status, $IDTimbangan);
			mysqli_stmt_execute($updateTimbanganPersonStmt);
				
			// mysqli_query($koneksi,"update timbanganperson set StatusUTTP='$Status' where IDTimbangan='$IDTimbangan'");
			
			// Insert trtimbanganitem table
			$insertTrTimbanganItemQuery = "INSERT INTO trtimbanganitem (NoTransaksi,NoUrutTrans,IDPerson,IDTimbangan,UserName,NominalRetribusi,HasilAction1,HasilAction2,TanggalTransaksi) VALUES (?,?,?,?,?,?,?,?,$TanggalNOW)";
			$insertTrTimbanganItemStmt = mysqli_prepare($koneksi, $insertTrTimbanganItemQuery);
			mysqli_stmt_bind_param($insertTrTimbanganItemStmt, "siiissss", $kode_jadi, $NoUrutTrans, $IDPerson, $IDTimbangan, $UserName, $NominalRetribusi, $HasilAction1, $HasilAction2);
			$DataItem = mysqli_stmt_execute($insertTrTimbanganItemStmt);

            // $DataItem = @mysqli_query($koneksi, "INSERT INTO trtimbanganitem (NoTransaksi,NoUrutTrans,IDPerson,IDTimbangan,UserName,NominalRetribusi,HasilAction1,HasilAction2,TanggalTransaksi)VALUES('$kode_jadi','$NoUrutTrans','$IDPerson','$IDTimbangan','$UserName','0','$HasilAction1','$HasilAction2','$TanggalNOW')"); 
			mysqli_stmt_close($updateTimbanganPersonStmt);
			mysqli_stmt_close($insertTrTimbanganItemStmt);

			if($DataItem){
				echo '<script language="javascript">alert("Data Berhasil Disimpan!"); document.location="TrTeraStandart.php"; </script>';
			}else{
				echo '<script language="javascript">alert(Data Gagal Disimpan!"); document.location="TrTeraStandart.php"; </script>';
			}
        }
        // if($DataItem){
		// 	echo '<script language="javascript">alert("Data Berhasil Disimpan!"); document.location="TrTeraStandart.php"; </script>';
		// }else{
		// 	echo '<script language="javascript">alert(Data Gagal Disimpan!"); document.location="TrTeraStandart.php"; </script>';
		// }

	}else{
		echo '<script type="text/javascript">
			  sweetAlert({
				title: "Simpan Data Gagal!",
				text: " ",
				type: "error"
			  },
			  function () {
				window.location.href = "TrTeraStandart.php";
			  });
			  </script>';
	}
	mysqli_stmt_close($insertStmt);
}		

?>
</html>
