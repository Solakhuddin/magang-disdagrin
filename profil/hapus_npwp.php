<?php
include '../library/config.php';
include '../library/sistemsetting.php';
@$id = htmlspecialchars(base64_decode($_GET['id']));
$Page='Profil';

$profil = mysqli_query($koneksi,"SELECT * FROM setting where id='$id'");
$row	= mysqli_fetch_assoc($profil);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <?php include 'title.php';?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Your page description here" />
  <meta name="author" content="" />

  <!-- css -->
  <link href="https://fonts.googleapis.com/css?family=Handlee|Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/bootstrap-responsive.css" rel="stylesheet" />
  <link href="css/flexslider.css" rel="stylesheet" />
  <link href="css/prettyPhoto.css" rel="stylesheet" />
  <link href="css/camera.css" rel="stylesheet" />
  <link href="css/jquery.bxslider.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />

  <!-- Theme skin -->
  <link href="color/default.css" rel="stylesheet" />

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
  

  <!-- =======================================================
    Theme Name: Eterna
    Theme URL: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body>

  <div id="wrapper">

    <!-- start header -->
    <?php include 'header.php';?>
    <!-- end header -->


    <section id="content">
     
      <div class="container">
        <div class="container">
            <form>
                <h4 class="font-weight-bold">IDENTITAS WAJIB PAJAK</h4>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nomer Pokok Wajib Pajak</label>
                    <input type="number" class="form-control" id="NPWP"  placeholder="Mohon masukkan NPWP Anda">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Wajib Pajak</label>
                    <input type="text" class="form-control" id="NPWP"  placeholder="Masukkan Nama Wajib Pajak Anda">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <hr>
                <h4 class="font-weight-bold">ALASAN PENGHAPUSAN NPWP</h4>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak orang pribadi telah meninggal dunia dan tidak meninggalkan warisan</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak bendahara pemerintah yang tidak lagi memenuhi syarat sebagai Wajib Pajak karena yang bersangkutan sudah tidak lagi melakukan pembayaran</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak orang pribbadi yang telah meninggalkan indonesia untuk selama-lamanya</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib pajak yang memiliki lebih dari 1(satu) Nomor Pokok Wajib Pajak untuk menentukan Nomor Pokok Wajib Pajak yang dapat digunakan sebagai sarana administratif dalam pelaksanaan hak dan pemenuhan kewajiban perpajakan</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak orang pribadi yang berstatus sebagai pengurus, komisaris, pemegang saham,/pemilik dan pegawai yang telah diberikan Nomor Pokok Wajib Pajak melalui pemberian kerja/bendahara pemerintahan dan pennghasilan netonya tidak melibihi Penghasilan Tidak Kena Pajak</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak badan kantor perwakilan perusahaan asing yang tidak mempunyai kewajiban Pajak Penghasil badan yang telah menghentikan kegiatan usahanya</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Warisan yang belum terbagi dalam kedudukan sebagai Subjek Pajak sudah selesai dibagi</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wanita yang sebelumnya telah memiliki Nomor Pokok Wajib Pajak dan menikah tanpa membuat perjanjian pemisahan harta dan penghasilan serta tidak ingin melaksanakan hak dan memenuhi kewajiban perpajakannya terpisah dari suaminya</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wanita Kawin yang memiliki memiliki Nomor Pokok Wajib Pajak berbeda dengan Nomor Pokok Wajib Pajak suami dan pelaksanaan hak dan pemenuhan kewajiban perpajakannya digabungkan dengan pelaksanaan hak dan pemenuhan kewajiban perpajakan suami</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Anak belum dewasa yang telah memiliki Nomor Pokok Wajib Pajak</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak bentuk usaha tetap yang telah menghentikan kegiatan usahanya di indonesia</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Wajib Pajak badan tertentu selain perseroan terbatas dengan status tidak aktif (non efektif) yang tidak mempunyai kewajiban Pajak Penghasilan dan secara nyata tidak menunjukkan adanya kegiatan usaha</label>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Alasan Lain :</label>
                    <input type="textarea" class="form-control" id="NPWP"  placeholder="Masukkan Alasan Penghapusan Wajib Pajak Anda">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <hr>
                <h4 class="font-weight-bold">PERNYATAAN</h4>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Dengan menyadari sepenuhnya akan segala akibatnya termasuk sanksi-sanksi sesuai dengan ketentuan perundang-undangan yang berlaku, saya menyatakan bahwa apa yang telah saya beritahukan di atas adalah benar dan lengkap</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        
        <br><br><br><hr>
        <div class="row">
            <div class="span4">
            <div class="clearfix"></div>
            <aside class="right-sidebar">
              <div class="widget">
                  <h5 class="widgetheading">INFORMASI KONTAK<span></span></h5>
                  <ul class="contact-info">
                  <li><label>Alamat :</label> <?php echo sistemSetting($koneksi, '4', 'value'); ?></li>
                  <li><label>Telephone & Fax :</label> <?php echo sistemSetting($koneksi, '2', 'value'); ?></li>
                  <li><label>Email : </label> <?php echo sistemSetting($koneksi, '3', 'value'); ?></li>
                </ul>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </section>

    <!-- start footer -->
		<?php include 'footer.php';?>
    <!-- end footer -->
  </div>
  <!-- <a href="Pengaduan.php" class="scrollup"><i class="icon-comments-alt icon-circled icon-bgsuccess icon-2x "></i></a> -->

  <!-- javascript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/bootstrap.js"></script>

  <script src="js/modernizr.custom.js"></script>
  <script src="js/toucheffects.js"></script>
  <script src="js/google-code-prettify/prettify.js"></script>
  <script src="js/jquery.bxslider.min.js"></script>

  <script src="js/jquery.prettyPhoto.js"></script>
  <script src="js/portfolio/jquery.quicksand.js"></script>
  <script src="js/portfolio/setting.js"></script>

  <script src="js/jquery.flexslider.js"></script>
  <script src="js/animate.js"></script>
  <script src="js/inview.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Custom JavaScript File -->
  <script src="js/custom2.js"></script>
  <!-- <script src="js/custom.js"></script> -->


</body>

</html>
