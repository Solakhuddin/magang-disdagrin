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
include "../library/config.php";
if(isset($_POST['SimpanData'])){
	@$KodeBatchPencetakan = htmlspecialchars($_POST['KodeBatchPencetakan']);
	@$UserName			  = htmlspecialchars($_POST['UserName']);
	@$WaktuTransaksi	  = htmlspecialchars($_POST['WaktuTransaksi']);
	@$TanggalTransaksi	  = htmlspecialchars($_POST['TanggalTransaksi']);
	@$TipeTransaksi	  	  = htmlspecialchars($_POST['TipeTransaksi']);
	@$Keterangan	  	  = htmlspecialchars($_POST['Keterangan']);
	@$TotalNilaKB	  	  = array_sum($_POST['TotalNominal']);
	$Tanggal 			  = date('Ymd');
	@$TanggalCetak		  = $TanggalTransaksi.' '.$WaktuTransaksi;

	// $sql = @mysqli_query($koneksi, "SELECT RIGHT(NoTransArusKB,8) AS kode FROM traruskb ORDER BY NoTransArusKB DESC LIMIT 1"); 
	// $nums = mysqli_num_rows($sql);
	// if($nums <> 0){
	// 	 $data = mysqli_fetch_array($sql);
	// 	 $kode = $data['kode'] + 1;
	// }else{
	// 	 $kode = 1;
	// }

	$query = "SELECT RIGHT(NoTransArusKB, 8) AS kode FROM traruskb ORDER BY NoTransArusKB DESC LIMIT 1";

	$stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);

    $nums = mysqli_stmt_num_rows($stmt);

    if ($nums != 0) {
        mysqli_stmt_bind_result($stmt, $kode);
        
        mysqli_stmt_fetch($stmt);
        
        $kode++;
    } else {
        $kode = 1;
    }
    mysqli_stmt_close($stmt);

	//mulai bikin kode
	 $bikin_kode = str_pad($kode, 8, "0", STR_PAD_LEFT);
	 $kode_jadi = "TRK-".$Tanggal."-".$bikin_kode;

	//  $SimpanData = @mysqli_query($koneksi, "INSERT INTO traruskb (NoTransArusKB,TanggalTransaksi,TipeTransaksi,KodeBatchPencetakan,TotalNilaKB,UserName,Keterangan)VALUES('$kode_jadi','$TanggalCetak','$TipeTransaksi', '$KodeBatchPencetakan','$TotalNilaKB', '$UserName', '$Keterangan')"); 

	$query = "INSERT INTO traruskb (NoTransArusKB, TanggalTransaksi, TipeTransaksi, KodeBatchPencetakan, TotalNilaKB, UserName, Keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)";

	$stmt = mysqli_prepare($koneksi, $query);

    mysqli_stmt_bind_param($stmt, "ssssdss", $kode_jadi, $TanggalCetak, $TipeTransaksi, $KodeBatchPencetakan, $TotalNilaKB, $UserName, $Keterangan);

    $cek = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

	if($cek){

		 for ($i=0; $i < sizeof($_POST['KodeKB']); $i++) {

		 	$JumlahDebetKB	=$_POST["JumlahDebetKB"][$i];
			$KodeKB     	=$_POST["KodeKB"][$i];
			$TotalNominal   =$_POST["TotalNominal"][$i];
			$NoSeriAwal     =$_POST["NoSeriAwal"][$i];
			$NoSeriAkhir    =$_POST["NoSeriAkhir"][$i];
			// $KodeBatch   	=$_POST["KodeBatch"][$i];
			$Keterangan   	=$_POST["Keterangan"][$i];
			$NoUrut 		=($i+1);
				
            // $DataItem = @mysqli_query($koneksi, "INSERT INTO traruskbitem (NoTransArusKB,NoUrut,KodeKB,JumlahDebetKB,TotalNominal,NoSeriAwal,NoSeriAkhir,Keterangan,KodeBatch)VALUES('$kode_jadi','$NoUrut','$KodeKB','$JumlahDebetKB','$TotalNominal','$NoSeriAwal','$NoSeriAkhir','$Keterangan', '$KodeBatchPencetakan')"); 
			
			$query = "INSERT INTO traruskbitem (NoTransArusKB, NoUrut, KodeKB, JumlahDebetKB, TotalNominal, NoSeriAwal, NoSeriAkhir, Keterangan, KodeBatch) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = mysqli_prepare($koneksi, $query);
			mysqli_stmt_bind_param($stmt, "sssssssss", $kode_jadi, $NoUrut, $KodeKB, $JumlahDebetKB, $TotalNominal, $NoSeriAwal, $NoSeriAkhir, $Keterangan, $KodeBatchPencetakan);

			$cek = mysqli_stmt_execute($stmt);

			mysqli_stmt_close($stmt);
		}

        if($cek){
			echo '<script language="javascript">alert("Data Berhasil Disimpan!"); document.location="Pencetakan.php"; </script>';
		}else{
			echo '<script language="javascript">alert(Data Gagal Disimpan!"); document.location="Pencetakan.php"; </script>';
		}

	}else{
		echo '<script type="text/javascript">
			  sweetAlert({
				title: "Simpan Data Gagal!",
				text: " ",
				type: "error"
			  },
			  function () {
				window.location.href = "Pencetakan.php";
			  });
			  </script>';
	}
}		

if(base64_decode($_POST['aksi']) == 'Hapus'){
	$NoTransArusKB = base64_decode($_POST['id']);
	if(CekTransaksi($koneksi, $NoTransArusKB)){
		$result = HapusKertas($koneksi, $NoTransArusKB);
		if($result){
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Berhasil Hapus Data",
				text: " ",
				type: "success"
			  },
			  function () {
				window.location.href = "Pencetakan.php";
			  });
			  </script>';
		}else{
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Hapus Data Gagal!",
				text: "Silah coba ulang..",
				type: "error"
			  },
			  function () {
				window.location.href = "Pencetakan.php";
			  });
			  </script>';
		}
	}else{
		echo '<script type="text/javascript">
			  sweetAlert({
				title: "Hapus Data Gagal!",
				text: "Data Sudah Digunakan Transaksi",
				type: "error"
			  },
			  function () {
				window.location.href = "Pencetakan.php";
			  });
			  </script>';
	}		
}

if(base64_decode($_POST['aksi']) == 'HapusItem'){
	$NoTransArusKB = base64_decode($_POST['id']);
	$NoUrut = base64_decode($_POST['nm']);
	if(CekTransaksiItem($koneksi, $NoTransArusKB, $NoUrut)){
		$result = HapusKertasItem($koneksi, $NoTransArusKB, $NoUrut);
		if($result){
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Berhasil Hapus Data",
				text: "",
				type: "success"
			  },
			  function () {
				window.location.href = "Pencetakan_edit.php?id='.base64_encode($NoTransArusKB).'";
			  });
			  </script>';
		}else{
			echo '<script type="text/javascript">
			  sweetAlert({
				title: "Hapus Data Gagal!",
				text: "Silah coba ulang..",
				type: "error"
			  },
			  function () {
				window.location.href = "Pencetakan_edit.php?id='.base64_encode($NoTransArusKB).'";
			  });
			  </script>';
		}
	}else{
		echo '<script type="text/javascript">
			  sweetAlert({
				title: "Hapus Data Gagal!",
				text: "Data Sudah Digunakan Transaksi",
				type: "error"
			  },
			  function () {
				window.location.href = "Pencetakan_edit.php?id='.base64_encode($NoTransArusKB).'";
			  });
			  </script>';
	}
			
}

if($_POST['aksi'] == 'EditItem'){
	$NoTransArusKB = mysqli_escape_string($koneksi, $_POST['NoTransArusKB']);
	$NoUrut 	   = mysqli_escape_string($koneksi, $_POST['NoUrut']);
	$KodeKB 	   = mysqli_escape_string($koneksi, $_POST['KodeKB']);
	$JumlahDebetKB = mysqli_escape_string($koneksi, $_POST['JumlahDebetKB']);
	$KodeBatch 	   = mysqli_escape_string($koneksi, $_POST['KodeBatch']);
	$NoSeriAwal    = mysqli_escape_string($koneksi, $_POST['NoSeriAwal']);
	$NoSeriAkhir   = $NoSeriAwal+($JumlahDebetKB-1);
	$NilaiTotal    = mysqli_escape_string($koneksi, $_POST['NilaiTotal']);
	$TotalNominal  = $NilaiTotal * $JumlahDebetKB;
	$result = EditItem($koneksi, $NoTransArusKB, $NoUrut, $KodeKB, $JumlahDebetKB, $KodeBatch, $NoSeriAwal, $NoSeriAkhir, $TotalNominal);
	if($result){
		$TotalNilaKB = HitungTotalNilaiKB($koneksi, $NoTransArusKB);
		UpdateTransaksiArusKB($koneksi, $NoTransArusKB, $TotalNilaKB, 'TotalNilaKB');
		echo '<script type="text/javascript">
		  sweetAlert({
			title: "Berhasil Edit Data",
			text: "",
			type: "success"
		  },
		  function () {
			window.location.href = "Pencetakan_edit.php?id='.base64_encode($NoTransArusKB).'";
		  });
		  </script>';
	}else{
		echo '<script type="text/javascript">
		  sweetAlert({
			title: "Edit Data Gagal!",
			text: "Silah coba ulang..",
			type: "error"
		  },
		  function () {
			window.location.href = "Pencetakan_edit.php?id='.base64_encode($NoTransArusKB).'";
		  });
		  </script>';
	}
	
			
}

if($_POST['aksi'] == 'Edit'){
	$NoTransArusKB 		 = mysqli_escape_string($koneksi, $_POST['NoTransArusKB']);
	$KodeBatchPencetakan = mysqli_escape_string($koneksi, $_POST['KodeBatchPencetakan']);
	$Keterangan			 = mysqli_escape_string($koneksi, $_POST['Keterangan']);
	$WaktuTransaksi		 = mysqli_escape_string($koneksi, $_POST['WaktuTransaksi']);
	$TanggalTransaksi	 = mysqli_escape_string($koneksi, $_POST['TanggalTransaksi']);
	$TanggalCetak		 = $TanggalTransaksi.' '.$WaktuTransaksi;
	$result = UpdateTransaksiArus($koneksi, $NoTransArusKB, $TanggalCetak, $Keterangan, $KodeBatchPencetakan);
	if($result){
		echo '<script type="text/javascript">
		  sweetAlert({
			title: "Berhasil Edit Data",
			text: "",
			type: "success"
		  },
		  function () {
			window.location.href = "Pencetakan.php";
		  });
		  </script>';
	}else{
		echo '<script type="text/javascript">
		  sweetAlert({
			title: "Edit Data Gagal!",
			text: "Silah coba ulang..",
			type: "error"
		  },
		  function () {
			window.location.href = "Pencetakan.php";
		  });
		  </script>';
	}
	
			
}

function CekTransaksi($conn, $NoTransArusKB){
	// $sql = "SELECT COUNT(NoTransArusKB) AS Jumlah FROM traruskbitem WHERE NoTransArusKB = '$NoTransArusKB' AND Keterangan = 'Sudah Dipakai'";
	// $res = $conn->query($sql);
	// if(mysqli_num_rows($res) > 0){
	// 	$row = mysqli_fetch_assoc($res);
	// 	return $row['Jumlah'] > 0 ? false : true;
	// }else{
	// 	return true;
	// }
	
	$sql = "SELECT COUNT(NoTransArusKB) AS Jumlah FROM traruskbitem WHERE NoTransArusKB = ? AND Keterangan = 'Sudah Dipakai'";

	if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $NoTransArusKB);

		mysqli_stmt_execute($stmt);

		mysqli_stmt_bind_result($stmt, $Jumlah);

		mysqli_stmt_fetch($stmt);

		mysqli_stmt_close($stmt);

		if ($Jumlah > 0) {
			return false;
		} else {
			return true;
		}
	} else {
		return true;
	}
}

function HapusKertas($conn, $NoTransArusKB){
	// $sqlitem = "DELETE FROM traruskbitem WHERE NoTransArusKB = '$NoTransArusKB'";
	// $item = $conn->query($sqlitem);
	// if($item){
	// 	$sql = "DELETE FROM traruskb WHERE NoTransArusKB = '$NoTransArusKB'";
	// 	$conn->query($sql);
	// 	return $conn->query($sql);
	// }
	$sqlitem = "DELETE FROM traruskbitem WHERE NoTransArusKB = ?";
	$stmt = mysqli_prepare($conn, $sqlitem);
    mysqli_stmt_bind_param($stmt, "s", $NoTransArusKB);

    $cek = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

	$sql = "DELETE FROM traruskb WHERE NoTransArusKB = ?";
	if ($cek) {
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "s", $NoTransArusKB);

		$hasil = mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);

		return $hasil;
	}

}

function CekTransaksiItem($conn, $NoTransArusKB, $NoUrut){
	$sql = "SELECT COUNT(NoTransArusKB) AS Jumlah FROM traruskbitem WHERE NoTransArusKB = '$NoTransArusKB' AND NoUrut AND '$NoUrut'  AND Keterangan != 'Sudah Dipakai'";
	$res = $conn->query($sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_assoc($res);
		return $row['Jumlah'] > 0 ? true : false;
	}else{
		return false;
	}
}

function HapusKertasItem($conn, $NoTransArusKB, $NoUrut){
	// $sqlitem = "DELETE FROM traruskbitem WHERE NoTransArusKB = '$NoTransArusKB' AND NoUrut ='$NoUrut'  AND Keterangan != 'Sudah Dipakai' ";
	// $conn->query($sqlitem);
	$sqlitem = "DELETE FROM traruskbitem WHERE NoTransArusKB = ? AND NoUrut = ? AND Keterangan != 'Sudah Dipakai'";
	$stmt = mysqli_prepare($conn, $sqlitem);
    mysqli_stmt_bind_param($stmt, "ss", $NoTransArusKB, $NoUrut);

    $hasil = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

	return $hasil;
}

function EditItem($conn, $NoTransArusKB, $NoUrut, $KodeKB, $JumlahDebetKB, $KodeBatch, $NoSeriAwal, $NoSeriAkhir, $TotalNominal){
	// $sqlitem = "UPDATE traruskbitem SET KodeKB='$KodeKB', JumlahDebetKB='$JumlahDebetKB', KodeBatch='$KodeBatch', NoSeriAwal='$NoSeriAwal', NoSeriAkhir='$NoSeriAkhir', TotalNominal='$TotalNominal' WHERE NoTransArusKB = '$NoTransArusKB' AND NoUrut='$NoUrut'";
	// $conn->query($sqlitem);
	$sqlitem = "UPDATE traruskbitem SET KodeKB=?, JumlahDebetKB=?, KodeBatch=?, NoSeriAwal=?, NoSeriAkhir=?, TotalNominal=? WHERE NoTransArusKB = ? AND NoUrut=?";

	$stmt = mysqli_prepare($conn, $sqlitem);
    mysqli_stmt_bind_param($stmt, "ssssssss", $KodeKB, $JumlahDebetKB, $KodeBatch, $NoSeriAwal, $NoSeriAkhir, $TotalNominal, $NoTransArusKB, $NoUrut);

    $hasil = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
	return $hasil;
}

function HitungTotalNilaiKB($conn, $NoTransArusKB){
	// $sql = "SELECT IFNULL(SUM(TotalNominal), 0) AS Jumlah FROM traruskbitem WHERE NoTransArusKB = '$NoTransArusKB'";
	// $res = $conn->query($sql);
	// if(mysqli_num_rows($res) > 0){
	// 	$row = mysqli_fetch_assoc($res);
	// 	return $row['Jumlah'];
	// }else{
	// 	return 0;
	// }
	$sql = "SELECT IFNULL(SUM(TotalNominal), 0) AS Jumlah FROM traruskbitem WHERE NoTransArusKB = ?";

	if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", $NoTransArusKB);

		mysqli_stmt_execute($stmt);

		mysqli_stmt_bind_result($stmt, $Jumlah);

		mysqli_stmt_fetch($stmt);

		mysqli_stmt_close($stmt);

		return $Jumlah;
	} else {
		return 0;
	}
}

function UpdateTransaksiArusKB($conn, $NoTransArusKB, $Value, $Table){
	// $sqlitem = "UPDATE traruskb SET $Table='$Value' WHERE NoTransArusKB = '$NoTransArusKB'";
	// return $conn->query($sqlitem);
	$sqlitem = "UPDATE traruskb SET $Table=? WHERE NoTransArusKB = ?";

	$stmt = mysqli_prepare($conn, $sqlitem);
    mysqli_stmt_bind_param($stmt, "ss", $Value, $NoTransArusKB);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function UpdateTransaksiArus($conn, $NoTransArusKB, $TanggalTransaksi, $Keterangan, $KodeBatchPencetakan){
	// $sqlitem = "UPDATE traruskb SET TanggalTransaksi='$TanggalTransaksi', Keterangan='$Keterangan', KodeBatchPencetakan='$KodeBatchPencetakan' WHERE NoTransArusKB = '$NoTransArusKB'";
	// return $conn->query($sqlitem);
	// Prepare the SQL statement
	$sqlitem = "UPDATE traruskb SET TanggalTransaksi=?, Keterangan=?, KodeBatchPencetakan=? WHERE NoTransArusKB = ?";

	$stmt = mysqli_prepare($conn, $sqlitem);
    mysqli_stmt_bind_param($stmt, "ssss", $TanggalTransaksi, $Keterangan, $KodeBatchPencetakan, $NoTransArusKB);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}


?>
</html>
