// potensi hack sql injection
<?php 
@session_start();
@$tip 	= $_SESSION['ip'];
@$tjam	= $_SESSION['jam'];
@$ttgl	= $_SESSION['tgl'];

if($tip=='' && $tjam=='' && $ttgl==''){
	$ip		= $_SERVER['REMOTE_ADDR'];
	$jam	= date("h:i:s");
	$tgl 	= date("d-m-Y");
	$_SESSION ["ip"] = $ip;
	$_SESSION ["jam"] = $jam;
	$_SESSION ["tgl"] = $tgl;
}
$sip	= $_SESSION['ip'];
$sjam	= $_SESSION['jam'];
$stgl	= $_SESSION['tgl'];

// 
$ip = $_SERVER['REMOTE_ADDR'];
$tanggal = date("d-m-Y");
$tgl = date("d");
$bln = date("m");
$thn = date("Y");
$tglk = $tgl-1;

$sql = "SELECT * FROM konter WHERE ip=? AND tanggal='$stgl' AND waktu='$sjam'";
$stmt = mysqli_stmt_init($koneksi);

// Prepared Statement
if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "Prepared Statement gagal dijalankan";
}else{
	mysqli_stmt_bind_param($stmt, "s", $ip);
	$result = mysqli_stmt_execute($stmt);

	if ($result) {
		// Jika eksekusi berhasil
		mysqli_stmt_store_result($stmt); 
		$read = mysqli_stmt_num_rows($stmt); 
		mysqli_stmt_free_result($stmt);
	} else {
		echo "eksekusi gagal dijalankan";
	}

	mysqli_stmt_close($stmt);
}
// script lama
// $baca  =mysqli_query($koneksi,"SELECT * FROM konter WHERE ip='$sip' AND tanggal='$stgl' AND waktu='$sjam'");
// $baca1 =mysqli_num_rows($baca);


if($read==0){
	$sql = "INSERT INTO konter (ip, tanggal, waktu) VALUES (?, ?, ?)";
	$stmt = mysqli_stmt_init($koneksi);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		echo "Prepeared Statment SQL failed";
	} else {
		mysqli_stmt_bind_param($stmt, "sss", $sip, $stgl, $sjam);
		mysqli_stmt_execute($stmt);
	}
	// $tkonter=mysqli_query($koneksi,"INSERT INTO konter VALUES ('$sip','$stgl','$sjam')");
}

$q = mysqli_query($koneksi,"SELECT * FROM konter");
$today = mysqli_query($koneksi,"SELECT * FROM konter WHERE tanggal='$tanggal'");
$hits_now  = mysqli_query($koneksi,"SELECT * FROM usersonline WHERE tanggal='$stgl'");

$visitor 	=mysqli_num_rows($q);
$todays		=mysqli_num_rows($today);
$hitsnow 	=mysqli_num_rows($hits_now);

function sistemSetting($koneksi, $id, $jenis){
	// mencegah html script injection 
	$sId = mysqli_real_escape_string($koneksi, $id);
	$sJenis = mysqli_real_escape_string($koneksi, $jenis);

	// menggunakan Prepared Statement untuk mencegah SQL Injection
	$sql =  "SELECT nama,value,file FROM setting where id=?";
	
	$stmt = mysqli_stmt_init($koneksi);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement gagal dijalankan";
	} else {
		// Binding parameter ke placeholder
		mysqli_stmt_bind_param($stmt, "s", $sId);
		// Menjalankan parameter di dalam database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$row = mysqli_fetch_array($result);

		if($sJenis=='nama'){
			return  $row['nama'];
		}elseif($sJenis=='value'){
			return  $row['value'];
		}else{
			return  $row['file'];
		}

	}
	// $result=mysqli_fetch_array($setting);

}

function UserOnline($koneksi){
	// Function to get the client IP address
	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	$tanggal=date("d-m-Y");
	$to_secs = 500;
	$t_stamp = time();
	$timeout = $t_stamp - $to_secs;
	// $REMOTEADDR=$_SERVER['REMOTE_ADDR'];
	$REMOTEADDR=get_client_ip();
	$PHPSELF=$_SERVER['PHP_SELF'];
	mysqli_query($koneksi,"INSERT INTO usersonline  VALUES ('$t_stamp','$REMOTEADDR','$PHPSELF', '$tanggal')");
	mysqli_query($koneksi,"DELETE FROM usersonline WHERE timestamp < '$timeout'");
	$result = mysqli_query($koneksi, "SELECT * FROM usersonline WHERE file='$PHPSELF' GROUP BY ip");
	$user   = mysqli_num_rows($result);

	return $user." Users";
}

function counter($koneksi){
	$sql =  "SELECT * FROM hitscounter";
	$sql1 = "UPDATE hitscounter SET hits = ?";
	$sql2 = "SELECT * FROM hitscounter";
	
	$stmt = mysqli_stmt_init($koneksi);

	$totalyangada1 = null;
	$tampilkansekarang1 = null;

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement gagal dijalankan";
	} else {
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if ($result) {
			$totalyangada = mysqli_fetch_array($result); // Use mysqli_fetch_assoc to fetch the associative array
			$totalyangada1 = $totalyangada['hits'] + 1;

			// Your code to update the database with the new value ($totalyangada1) goes here
			mysqli_free_result($result); // Free the result set
		} else {
			echo "Failed to fetch data from database";
		}

	}
	if(!mysqli_stmt_prepare($stmt, $sql1)){
		echo "Update gagal dijalankan";
	} else {
		// Binding parameter ke placeholder
		mysqli_stmt_bind_param($stmt, "s", $totalyangada1);
		// Menjalankan parameter di dalam database
		mysqli_stmt_execute($stmt);
	}
	if(!mysqli_stmt_prepare($stmt, $sql2)){
		echo "Tampil data gagal dijalankan";
	} else {
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if($result){
			$tampilkansekarang1 = mysqli_fetch_array($result);
			return  $tampilkansekarang1['hits'];
		} else {
			echo "Gagal ambil data !!";
		}
	}
	// script lama
	// $countertabel = mysqli_query($koneksi, "SELECT * FROM hitscounter");
	// $totalyangada = mysqli_fetch_array($countertabel);
	// $totalyangada1 = $totalyangada['hits']+1;

	// $updatecounter = mysqli_query($koneksi, "UPDATE hitscounter SET hits = '$totalyangada1'");
	// $tampilkansekarang = mysqli_query($koneksi, "SELECT * FROM hitscounter");
	// $tampilkansekarang1 = mysqli_fetch_array($tampilkansekarang);
	// return  $tampilkansekarang1['hits'];
}

function jumlahKomentar($koneksi, $KodeKonten, $JenisKonten, $Emoticon, $JenisEmoticon){

  if(isset($JenisEmoticon) AND $JenisEmoticon != ''){
  	$komentar = mysqli_query($koneksi, "SELECT * FROM tanggapankonten where KodeKonten='$KodeKonten' and JenisKonten='$JenisKonten' and  	EmailPengirim='$Emoticon' AND IsiKomentar='$JenisEmoticon' AND IsAktif=b'1'");
  }else{
  	$komentar = mysqli_query($koneksi, "SELECT * FROM tanggapankonten where KodeKonten='$KodeKonten' and JenisKonten='$JenisKonten' and  	EmailPengirim='$Emoticon' AND IsAktif=b'1' ");
  }
  $result	= mysqli_num_rows($komentar);
  return  $result;

}

?>
