<?php
include ("../../library/config.php");

	@$TanggalTransaksi=date("Y-m-d H:i:s");
	$id 			= htmlspecialchars($_POST['id']);
	$keterangan 	= $_POST['keterangan'];
	$file 	        = $_POST['file'];

	$Gambar1 = false;
    if (!empty($_FILES['Gambar1']['name'])) {
        $errors = array();
        $file_name = $_FILES['Gambar1']['name'];
        $file_size = $_FILES['Gambar1']['size'];
        $file_tmp = $_FILES['Gambar1']['tmp_name'];
        $file_type = $_FILES['Gambar1']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['Gambar1']['name'])));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
        }

        if (!getimagesize($file_tmp)) {
            $errors[] = 'this file is not image';
        }

        $newfilename = $id.'-'.date('YmdHis').'-1.'.$file_ext;
        if (empty($errors)) {
            // move_uploaded_file($file_tmp, "../..//images/Assets/" . $newfilename);
            // $Gambar1 = $newfilename;
            // unlink("../../images/Assets/$Gambar1_");

            $uploadPath = "../../images/Assets/";
            $success = move_uploaded_file($file_tmp, $uploadPath . $newfilename);
            if ($success) {
                $Gambar1 = $newfilename;
                unlink("../../images/Assets/$Gambar1_"); // Delete previous file
            } else {
                $errors[] = 'Upload failed. Please try again.';
            }

        }
    }else{
    	$Gambar1 = $file;
    }
	
	// $query = mysqli_query($koneksi,"UPDATE setting SET value='$keterangan', file='$Gambar1' WHERE id='$id'");
	
    $stmt = mysqli_prepare($koneksi, "UPDATE setting SET value=?, file=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $keterangan, $Gambar1, $id);
    $result = mysqli_stmt_execute($stmt);
	if ($result) {
		echo '<script language="javascript">alert("Data Berhasil Disimpan !"); document.location="../SistemSetting.php"; </script>';
		
	} else {
		echo '<script language="javascript">alert("Maaf, Data Gagal Disimpan !"); document.location="../SistemSetting.php"; </script>';
	}
    mysqli_stmt_close($stmt);
	
		
?>
