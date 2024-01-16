<?php
include "../config.php";
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=LapKeuanganMetrologi.xls");
$Tanggal = isset($_GET['bl']) ? mysqli_real_escape_string($koneksi,$_GET['bl']) : date('Y-m');
$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
?>
<table>
	<tr><td colspan="10" align="center"><strong>LAPORAN POTENSI PENDAPATAN BIDANG METROLOGI BULAN <?php echo strtoupper($BulanIndo[date('m', strtotime($Tanggal)) - 1].' '.date('Y', strtotime($Tanggal))) ?></strong></td></tr>
	<tr><td colspan="10" align="center"><strong>DINAS PERDAGANGAN DAN PERINDUSTRIAN KABUPATEN JOMBANG</strong></td></tr>
	<tr></tr>
</table>
		
<table border="1" cellpadding="10">
	<tr style="background-color: #a6a9a9;">
	  <th align="center" rowspan="2">No</th>
	  <th align="center" rowspan="2">Jenis UTTP</th>
	  <th align="center" colspan="2">Retribusi</th>
	  <th align="center" colspan="3">Potensi Pendapatan</th>
	  <th align="center" colspan="3">Realisasi Pendapatan</th>
	</tr>
	<tr style="background-color: #a6a9a9;">
		<th align="center" >Kantor</th>
		<th align="center" >Lokasi</th>
		<th align="center" >Jumlah</th>
		<th align="center" >Kantor</th>
		<th align="center" >Lokasi</th>
		<th align="center" >Jumlah</th>
		<th align="center" >Kantor</th>
		<th align="center" >Lokasi</th>
	</tr>

	
	<?php
		
		$sql =  "SELECT a.KodeTimbangan,a.KodeKelas,a.KodeUkuran,c.NamaTimbangan,d.NamaKelas,e.NamaUkuran,e.RetribusiDikantor,e.RetribusiDiLokasi,b.KodeKec from timbanganperson a  join lokasimilikperson b on (a.KodeLokasi,a.IDPerson)=(b.KodeLokasi,b.IDPerson) join msttimbangan c on a.KodeTimbangan=c.KodeTimbangan join kelas d on (a.KodeTimbangan,a.KodeKelas)=(d.KodeTimbangan,d.KodeKelas) join detilukuran e on (a.KodeTimbangan,a.KodeKelas,a.KodeUkuran)=(e.KodeTimbangan,e.KodeKelas,e.KodeUkuran) join mstperson h on h.IDPerson=a.IDPerson WHERE h.UserName != 'dinas' ";
									
		
		$sql .="  GROUP by a.KodeTimbangan,a.KodeKelas,a.KodeUkuran order by  a.KodeTimbangan,a.KodeKelas,a.KodeUkuran";
		$result = mysqli_query($koneksi,$sql);
		$tcount = mysqli_num_rows($result);
			
		if ($tcount == 0 ){
			echo '
				<tr>
					<td colspan="10" align="center">
						<strong>Data Tidak Ada</strong>
					</td>
				</tr>
			
			';	
		}else{
			$no = 0; 
			
			while($data = mysqli_fetch_array($result)){
			
				$query = mysqli_query($koneksi, ("select IDTimbangan from timbanganperson a  join lokasimilikperson b on (a.KodeLokasi,a.IDPerson) = (b.KodeLokasi,b.IDPerson) where a.KodeTimbangan='".$data['KodeTimbangan']."' and a.KodeKelas='".$data['KodeKelas']."' and a.KodeUkuran='".$data['KodeUkuran']."'"));
				$nums2 = mysqli_num_rows($query); 
				
				$kantor=$data[6]*$nums2;
				$JumlahKantor[] = $kantor;
				
				$lokasi=$data[7]*$nums2;
				$JumlahLokasi[] = $lokasi;

				$query2 = "select b.IDTimbangan 
				from trtimbanganitem b
				Join timbanganperson a on a.IDTimbangan = b.IDTimbangan 
				where a.KodeTimbangan='".$data['KodeTimbangan']."' and a.KodeKelas='".$data['KodeKelas']."' and a.KodeUkuran='".$data['KodeUkuran']."' and LEFT(b.TanggalTransaksi,7) = '$Tanggal' ";
				$conn  = mysqli_query($koneksi, $query2);
				$nums3 = mysqli_num_rows($conn); 
				
				$realisasikantor=$data[6]*$nums3;
				$JumlahRealisasiKantor[] = $realisasikantor;

				$realisasilokasi=$data[7]*$nums3;
				$JumlahRealisasiLokasi[] = $realisasilokasi;
				
				echo "<tr>";
					echo "<td align='center'>".++$no."</td>";
					echo "<td>".ucwords($data[3])." ".$data[4]." ".$data[5]." </td>";
					echo "<td align='right'>".$data[6]."</td>";
					echo "<td align='right'>".$data[7]."</td>";
					echo "<td align='right'>".$nums2."</td>";
					echo "<td align='right'>".$kantor."</td>";
					echo "<td align='right'>".$lokasi."</td>";
					echo "<td align='right'>".$nums3."</td>";
					echo "<td align='right'>".$realisasikantor."</td>";
					echo "<td align='right'>".$realisasilokasi."</td>";
				echo "</tr>";
		
				// $no++; // Tambah 1 setiap kali looping
			
			}
			echo '
					<tr align="center">
						<td colspan="2"><strong>TOTAL</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td><strong>'.array_sum($JumlahKantor).'</strong></td>
						<td><strong>'.array_sum($JumlahLokasi).'</strong></td>
						<td></td>
						<td><strong>'.array_sum($JumlahRealisasiKantor).'</strong></td>
						<td><strong>'.array_sum($JumlahRealisasiLokasi).'</strong></td>
					</tr>
			';
		}
	?>
</table>

<?php
echo '<script language="javascript">
		window.close();
	  </script>';
?>
