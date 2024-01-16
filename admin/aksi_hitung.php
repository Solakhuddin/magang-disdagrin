<?php
function jumlahUTTP($koneksi){
	$Query1 =  "SELECT COUNT(IDTimbangan) From timbanganperson where StatusUTTP='Aktif' and IDPerson != 'PRS-2019-0000000'";
	$res1   = mysqli_query($koneksi, $Query1);
	$result1 = mysqli_fetch_array($res1);
	return(number_format($result1[0]));
	
}

function pembulatan($uang){
	
	if($uang < 0){
		$akhir = 0;
	}else{
		$ratusan = substr(number_format($uang), -2);
		
		if($ratusan<50) {
		 $akhir = $uang - $ratusan;
		}else{
		 $akhir = $uang + (100-$ratusan);
		 
		}
	}
	
	return 'Rp '.number_format($akhir);
}

