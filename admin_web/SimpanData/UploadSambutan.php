<?php
include ("../../library/config.php");

	//mendefinisikan folder upload
	define("UPLOAD_DIR", "../../images/Assets/");

	if (!empty($_FILES["media"])) {
		$media	= $_FILES["media"];
		$ext	= pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);
		$size	= $_FILES["media"]["size"];
		$tgl	= date("Y-m-d");

		if($size > (1024000*3)){ // maksimal 3 MB
			echo 'Upload Gagal ! Ukuran file maksimal 3 MB.';
			exit;
		}else{
			if ($media["error"] !== UPLOAD_ERR_OK) {
				echo 'Gagal upload file.';
				exit;
			}

			// filename yang aman
			// $name = preg_replace("/[^A-Z0-9._-]/i", "_", $media["name"]);

			$name = uniqid('file_') . '.' . $ext;

			// mencegah overwrite filename
			// $i = 0;
			// $parts = pathinfo($name);
			// while (file_exists(UPLOAD_DIR . $name)) {
			// 	$i++;
			// 	$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
			// }

			// Move the uploaded file to a secure directory
			$uploadPath = '../../images/Assets/';
			$success = move_uploaded_file($media["tmp_name"], $uploadPath . $name);
			if (!$success) {
				echo 'Upload file gagal.';
				exit;
			}

			// Validate file extension
			$allowedExtensions = array('jpg', 'jpeg', 'png');
			if (!in_array($ext, $allowedExtensions)) {
				unlink($uploadPath . $name); // Remove the uploaded file
				echo "Extension file harus .jpg/.jpeg/.png";
				exit;
			}

			// Update the database
			$stmt = mysqli_prepare($koneksi, "UPDATE kontenweb SET Gambar1=? WHERE JenisKonten='Sambutan'");
			mysqli_stmt_bind_param($stmt, "s", $name);
			$query = mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);

			if ($query) {
				// Delete previous file
				$previousFile = mysqli_query($koneksi, "SELECT Gambar1 FROM kontenweb WHERE JenisKonten='Sambutan'");
				$row = mysqli_fetch_assoc($previousFile);
				if ($row['Gambar1'] != null) {
					unlink($uploadPath . $row['Gambar1']);
				}
				mysqli_free_result($previousFile);

				echo '<script language="javascript">alert("Data Berhasil Disimpan!");document.location="Sambutan.php";</script>';
				exit;
			} else {
				unlink($uploadPath . $name); // Remove the uploaded file
				echo "Upload File Gagal !";
				exit;
			}

			// $success = move_uploaded_file($media["tmp_name"], UPLOAD_DIR . $name);
			// if ($success) {					
			// 	if($ext=='jpg' OR $ext=='jpeg' OR $ext=='png'){
			// 		//cari file untuk di hapus
			// 		$AmbilData = mysqli_query($koneksi,"SELECT Gambar1 FROM kontenweb WHERE JenisKonten='Sambutan'");
			// 		$row=mysqli_fetch_assoc($AmbilData);
			// 		//insert ke db.
			// 		$query = mysqli_query($koneksi,"UPDATE kontenweb SET Gambar1='$name' WHERE JenisKonten='Sambutan'");
			// 		if($query){
			// 			if($row['Gambar1']!=null){
			// 				unlink("../../images/Assets/".$row['Gambar1']."");
			// 				echo '<script language="javascript">alert("Data Berhasil Disimpan!");document.location="Sambutan.php";</script>';
			// 				// echo "Upload File Berhasil!";
			// 				exit;
			// 			}else{
			// 				echo "Upload File Berhasil!";
			// 				exit;
			// 			}
			// 		}else{
			// 			echo "Upload File Gagal !";
			// 			exit;
			// 		}
			// 	}else{
			// 		echo "Extension file harus .jpg/.jpeg/.png";
			// 		exit;
			// 	}
			// }
			// chmod(UPLOAD_DIR . $name, 0644);


		}
	}
?>
