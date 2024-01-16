<?php
	include "../../library/config.php";
	@$id 			= htmlspecialchars(base64_decode($_GET['id']));
	@$JenisKonten 	= $_POST['JenisKonten'];
	@$IdKonten 		= $_POST['IdKonten'];
    @$Keterangan 	= htmlspecialchars($_POST['Keterangan']);
	
	// @$StatusPerson 	= $_POST['StatusPerson'];
	@$tgl			= date("YmdHis");
	
	
	
if(isset($_POST)){
	############ Edit settings ##############
	$ThumbSquareSize 		= 200; //Thumbnail will be 200x200
	$BigImageMaxSize 		= 800; //Image Maximum height or width
	$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
	if($JenisKonten=='Berita'){
		$DestinationDirectory	= '../../images/web_profil/berita/'; //specify upload directory ends with / (slash)			
	}elseif($JenisKonten=='Foto'){
		$DestinationDirectory	= '../../images/web_profil/galeri/'; //specify upload directory ends with / (slash)
	}elseif($JenisKonten=='Slider'){
		$DestinationDirectory	= '../../images/web_profil/slider/'; //specify upload directory ends with / (slash)
	}elseif($JenisKonten=='Artikel'){
		$DestinationDirectory	= '../../images/web_profil/artikel/'; //specify upload directory ends with / (slash)
	}
	$Quality 				= 1000; //jpeg quality
	##########################################
	
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	// check $_FILES['ImageFile'] not empty
	if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name']))
	{
		die('Upload bermasalah,cek ulang extensi gambar yang di upload!'); // output error when above checks fail.
	}
	
	// Random number will be added after image name
	// $RandomNumber 	= rand(0, 9999999999); 

	$ImageName 		= str_replace(' ','-',strtolower($_FILES['ImageFile']['name'])); //get image name
	$ImageSize 		= $_FILES['ImageFile']['size']; // get original image size
	$TempSrc	 	= $_FILES['ImageFile']['tmp_name']; // Temp name of image file stored in PHP tmp folder
	$ImageType	 	= $_FILES['ImageFile']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.
		
	//Let's check allowed $ImageType, we use PHP SWITCH statement here
	switch(strtolower($ImageType))
	{ 
		case 'image/png':
			//Create a new image from file 
			$CreatedImage =  imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
			break;
		case 'image/gif':
			$CreatedImage =  imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
			break;			
		case 'image/jpeg':
		case 'image/pjpeg':
			$CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
			break;
		default:
			die('Unsupported File!'); //output error and exit
	}
	
	//PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
	//Get first two values from image, width and height. 
	//list assign svalues to $CurWidth,$CurHeight
	list($CurWidth,$CurHeight)=getimagesize($TempSrc);
	
	//Get file extension from Image name, this will be added after random name
	$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
  	$ImageExt = str_replace('.','',$ImageExt);
	
	//remove extension from filename
	$ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName); 
	
	//Construct a new name with random number and extension.
	//$NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
	$NewImageName = $id.'-'.$tgl.'.'.$ImageExt;
	
	//set the Destination Image
	$thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumbnail name with destination directory
	$DestRandImageName 			= $DestinationDirectory.$NewImageName; // Image with destination directory
	
	//Resize image to Specified Size by calling resizeImage function.
	if(resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType))
	{
		//Create a square Thumbnail right after, this time we are using cropImage() function
		if(!cropImage($CurWidth,$CurHeight,$ThumbSquareSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
			{
				echo 'Error Creating thumbnail';
			}	
		
		if($JenisKonten=='Foto'){
			
			//bikin kode untuk detilkonten
			$AmbilNoUrut=mysqli_query($koneksi,"SELECT MAX(Nourut) as NoSaatIni FROM detailkonten WHERE  KodeKonten='$id' AND JenisKonten='$JenisKonten'");
			$Data=mysqli_fetch_assoc($AmbilNoUrut);
			$NoSekarang = $Data['NoSaatIni'];
			$Urutan = $NoSekarang+1;
			
			// Insert info into database table!
			$query = mysqli_query($koneksi,"INSERT INTO detailkonten (Nourut,KodeKonten,Dokumen,keterangan,JenisKonten) VALUES ('$Urutan','$id','$NewImageName','$Keterangan','$JenisKonten')");
			if($query){
				echo '<script language="javascript">alert("Foto Berhasil Disimpan!");document.location="UploadFoto.php?id='.$_GET['id'].'&jns='.base64_encode($JenisKonten).'";location.reload(); </script>';
			}
			
		}elseif($JenisKonten=='Slider'){
			$AmbilGambar=mysqli_query($koneksi,"SELECT Gambar1 FROM kontenweb WHERE KodeKonten='$id'");
			$gambar=mysqli_fetch_assoc($AmbilGambar);
			$gambarLama = $gambar['Gambar1'];
			
			if($gambarLama != null OR $gambarLama !=''){
				
				// Insert info into database table!
				$query = mysqli_query($koneksi,"UPDATE kontenweb SET Gambar1='$NewImageName', IsAktif=b'1' WHERE KodeKonten='$id'");
				
				
				if($query){
					//hapus gambar lama
					@unlink("../../images/web_profil/slider/$gambarLama");
					@unlink("../../images/web_profil/slider/thumb_$gambarLama");
					echo '<script language="javascript">alert("Foto Berhasil Disimpan!");document.location="MstSlider.php"; </script>';
					
				}
			}else{
				// Insert info into database table!
				$query = mysqli_query($koneksi,"UPDATE kontenweb SET Gambar1='$NewImageName', IsAktif=b'1' WHERE KodeKonten='$id'");
				if($query){
					echo '<script language="javascript">alert("Foto Berhasil Disimpan!");document.location="MstSlider.php"; </script>';
				}
			}		
		
		}elseif($JenisKonten=='Artikel'){
		
			//bikin kode untuk detilkonten
			$AmbilNoUrut=mysqli_query($koneksi,"SELECT MAX(Nourut) as NoSaatIni FROM detailkonten WHERE  KodeKonten='$id' AND JenisKonten='$JenisKonten'");
			$Data=mysqli_fetch_assoc($AmbilNoUrut);
			$NoSekarang = $Data['NoSaatIni'];
			$Urutan = $NoSekarang+1;
			
			// Insert info into database table!
			$query = mysqli_query($koneksi,"INSERT INTO detailkonten (Nourut,KodeKonten,Dokumen,keterangan,JenisKonten) VALUES ('$Urutan','$id','$NewImageName','$Keterangan','$JenisKonten')");
			if($query){
				echo '<script language="javascript">alert("Foto Berhasil Disimpan!");document.location="UploadFoto.php?id='.$_GET['id'].'&jns='.base64_encode($JenisKonten).'";location.reload(); </script>';
			}
		
		}elseif($JenisKonten=='Berita'){
			
			//buat kode untuk detail gambar
			$AmbilNoUrut=mysqli_query($koneksi,"SELECT MAX(Nourut) as NoSaatIni FROM detailkonten WHERE KodeKonten='$id' AND JenisKonten='$JenisKonten'");
			$Data=mysqli_fetch_assoc($AmbilNoUrut);
			$NoSekarang = $Data['NoSaatIni'];
			$Urutan = $NoSekarang+1;
			
			// Insert info into database table!
			$query = mysqli_query($koneksi,"INSERT INTO detailkonten (Nourut,KodeKonten,JenisKonten,Dokumen,keterangan) VALUES ('$Urutan','$id','$JenisKonten','$NewImageName','$Keterangan')");
				if($query){
					echo '<script language="javascript">alert("Foto Berhasil Disimpan!");document.location="UploadFoto.php?id='.$_GET['id'].'&jns='.base64_encode($JenisKonten).'";location.reload(); </script>';
				}else{
					echo '<script language="javascript">alert("Foto Gagal Disimpan!");document.location="UploadFoto.php?id='.$_GET['id'].'&jns='.base64_encode($JenisKonten).'";location.reload(); </script>';
						
				
				}		
		}		
	}else{
		die('Resize Error'); //output error
	}
}


// This function will proportionally resize image 
function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//Construct a proportional size of new image
	$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
	$NewWidth  			= ceil($ImageScale*$CurWidth);
	$NewHeight 			= ceil($ImageScale*$CurHeight);
	$NewCanves 			= imagecreatetruecolor($NewWidth, $NewHeight);
	
	// Resize Image
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;
	}

}

//This function corps image to create exact square images, no matter what its original size!
function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{	 
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
	if($CurWidth>$CurHeight)
	{
		$y_offset = 0;
		$x_offset = ($CurWidth - $CurHeight) / 2;
		$square_size 	= $CurWidth - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($CurHeight - $CurWidth) / 2;
		$square_size = $CurHeight - ($y_offset * 2);
	}
	
	$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;

	}
	  
}