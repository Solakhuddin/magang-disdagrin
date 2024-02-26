<?php
include ("../../library/config.php");
include '../../library/kode-konten.php';
$TanggalTransaksi	= date("Y-m-d H:i:s");
$JudulKonten 	= @$_POST['JudulKonten'];
$IsiKonten 		= @$_POST['IsiKonten'];
$JenisKonten 	= @$_POST['JenisKonten'];
$Kode 			= KodeKonten($JenisKonten, $koneksi);
$tgl			= date("YmdHis");

$Folder = $JenisKonten == 'Sakip' ? 'Sakip' : 'Unduhan';

$Gambar1 = false;
if (!empty($_FILES['Gambar1']['name'])) {
    $errors = array();
    $file_name = $_FILES['Gambar1']['name'];
    $file_size = $_FILES['Gambar1']['size'];
    $file_tmp = $_FILES['Gambar1']['tmp_name'];
    $file_type = $_FILES['Gambar1']['type'];
    $tmp = explode('.', $_FILES['Gambar1']['name']);
	// $file_ext = end($tmp);
    $file_ext = strtolower(end($tmp)); // Get the file extension in lowercase

    

    $extensions = array("pdf", "docx", "doc", "ppt", "pptx", "xlsx", "xls");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a pdf, doc, xls, or ppt file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 5 MB';
    }

    $newfilename = 'ast-'.date('YmdHis').'-1.'.$file_ext;
    if (empty($errors)) {
        move_uploaded_file($_FILES['Gambar1']['tmp_name'], "../../images/Dokumen/".$Folder."/" . $newfilename);
        $Gambar1 = $newfilename;
        $uploadPath = "../../images/Dokumen/".$Folder."/" . $newfilename;
        $success = move_uploaded_file($file_tmp, $uploadPath);
        if ($success) {
            $Gambar1 = $newfilename;
        } else {
            $errors[] = 'Upload failed. Please try again.';
        }
        // unlink("../../images/Dokument/Unduhan/$Gambar1_");
    }

}else{
	$Gambar1 = NULL;
}



    // $stmt = mysqli_query($koneksi,"INSERT INTO kontenweb (KodeKonten,TanggalKonten,JenisKonten,JudulKonten,IsiKonten,IsAktif,Gambar1) VALUES ('$Kode','$TanggalTransaksi','$JenisKonten','$JudulKonten','$IsiKonten',b'1','$Gambar1')");

	// if($stmt){
    $stmt = mysqli_prepare($koneksi, "INSERT INTO kontenweb (KodeKonten, TanggalKonten, JenisKonten, JudulKonten, IsiKonten, IsAktif, Gambar1) VALUES (?, ?, ?, ?, ?, b'1', ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $Kode, $TanggalTransaksi, $JenisKonten, $JudulKonten, $IsiKonten, $Gambar1);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
		if($JenisKonten=='Dokumen'){
			echo '<script language="javascript">alert("Data berhasil disimpan !"); document.location="../Unduhan.php"; </script>';
		}else{
			echo '<script language="javascript">alert("Data berhasil disimpan !"); document.location="../Sakip.php"; </script>';
		}		
	}else{
		unlink("../../images/Dokumen/".$Folder."/$Gambar1");
		
		if($JenisKonten=='Dokumen'){
		 	echo '<script language="javascript">alert("Data Gagal disimpan !"); document.location="../Unduhan.php"; </script>';
		}else{
			echo '<script language="javascript">alert("Data Gagal disimpan !"); document.location="../Sakip.php"; </script>';
		}
	} 
	
    mysqli_stmt_close($stmt);

