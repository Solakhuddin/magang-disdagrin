<?php 
date_default_timezone_set('Asia/Jakarta');
session_start();  
ob_start();
include_once("../../config.php"); //buat koneksi ke database  
include '../../tgl-indo.php';
include '../../terbilang.php';
@$id   = htmlspecialchars(base64_decode($_GET['id'])); //kode berita yang akan dikonvert  
$TanggalTransaksi	= date("Y-m-d");
  
$NamaBulan = array (1 =>   'Januari',
	'Februari',
	'Maret',
	'April',
	'Mei',
	'Juni',
	'Juli',
	'Agustus',
	'September',
	'Oktober',
	'November',
	'Desember'
);

?>
<style>
table th {
  padding-top: 10px;
  padding-bottom: 10px;
  border-left:1px solid #e0e0e0;
  border-bottom: 1px solid #e0e0e0;
  background: #5c54cc;
  color :white;
}
</style>
<page style="width:100%;" backtop="5mm" backbottom="10mm"  backright="5mm">
	<table>
		<tr>
		  <td rowspan="3"><img src="../../../images/Assets/logo_cetak.png" style="width:75px;height:100px"/></td>
		  <td align="center" style="width: 550px; padding-top:10px;">
			<font style="font-size: 18px; line-height: 1.3;">PEMERINTAH KABUPATEN JOMBANG</font><br>
			<font style="font-size: 23px; line-height: 1.3;">DINAS PERDAGANGAN DAN PERINDUSTRIAN</font><br>
			<font style="font-size: 16px; line-height: 1.3;">Jl. KH. Wahid Hasyim No.143 Jombang 61419</font><br>
			<font style="font-size: 14px; line-height: 1.3;">Telp. ( 0321 ) 874549 Fax (0321) 850494 Email: disperdagperin@jombangkab.go.id<br>
			Website: jombangkab.go.id</font>
		 </td>
		</tr>
    </table><hr class="garis">
	
	
	<table>
		<tr>
		  <td align="center" style="width: 650px; padding-top:10px;">
			<strong><font style="font-size: 16px; line-height: 1.3;">LAPORAN TOKO DISTRIBUTOR PUPUK</font></strong><br>
		 </td>
		</tr>
    </table>
	
	
	<table style="width:100%; margin-top: 10px; margin-right: 10px; border-collapse: collapse;">
		<tr style="border : 1px;">
			<th align="center" style="border : 1px; width:5%;">No</th>
			<th align="center" style="border : 1px; width:25%;">Nama Distributor</th>
			<th align="center" style="border : 1px; width:20%;">Nama Toko</th>
			<th align="center" style="border : 1px; width:30%;">Alamat</th>
			<th align="center" style="border : 1px; width:20%;">No Telephone</th>
		</tr>
		<?php 
		
		$sql =  "SELECT a.NamaPerson as Distributor, b.NamaPerson, b.AlamatLengkapPerson, b.NoHP,(SELECT COUNT(IDPerson) FROM mstperson WHERE ID_Distributor=a.IDPerson) AS jumlah 
		FROM mstperson a 
		join mstperson b on (a.IDPerson=b.ID_Distributor) 
		where a.JenisPerson LIKE '%PupukSub%' AND a.IsVerified=b'1' 
		ORDER BY a.NamaPerson ASC";

		$result = mysqli_query($koneksi,$sql);
			
		$no = 0;
		$jum = 1;
		$Distributor = '';
		$tcount = mysqli_num_rows($result);
		
		if ($tcount == 0 OR $tcount == NULL ) {
			echo '';
		}else {
			while($data=mysqli_fetch_assoc($result)){

				if(@$data['Distributor'] != $Distributor){   ?>
					<tr>
						<td style="padding-top :5px; border: solid 1px; width:5%;" ><?php echo ++$no; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:25%;" ><?php echo $data ['Distributor']; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:20%;" ><?php echo $data ['NamaPerson']; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:30%;" ><?php echo $data ['AlamatLengkapPerson']; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:20%;" ><?php echo $data ['NoHP']; ?></td>
					</tr>

				<?php }else{ ?>
					<tr>
						<td style="padding-top :5px; border: solid 1px; width:5%;" ></td>
						<td style="padding-top :5px; border: solid 1px; width:25%;" ></td>
						<td style="padding-top :5px; border: solid 1px; width:20%;" ><?php echo $data ['NamaPerson']; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:30%;" ><?php echo $data ['AlamatLengkapPerson']; ?></td>
						<td style="padding-top :5px; border: solid 1px; width:20%;" ><?php echo $data ['NoHP']; ?></td>
					</tr>

				<?php } 
					$Distributor = @$data['Distributor'];
		 	}
		} 
		?>
		
	</table>
</page>


<?php  
$filename="Laporan_TokoDistribusi.pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya  
//==========================================================================================================  
//Copy dan paste langsung script dibawah ini,untuk mengetahui lebih jelas tentang fungsinya silahkan baca-baca tutorial tentang HTML2PDF  
//==========================================================================================================  
$content = ob_get_clean();  
// $content = '<page style="font-family: freeserif">'.nl2br($content).'</page>';  
 require_once('../../html2pdf/html2pdf.class.php');
 try  
 {  
  $html2pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(18, 5, 15, 3));  
  $html2pdf->setDefaultFont('Arial');  
  $html2pdf->writeHTML($content, isset($_GET['vuehtml']));  
  $html2pdf->Output($filename);  
  
 }  
 catch(HTML2PDF_exception $e) { echo $e; }  
?>  