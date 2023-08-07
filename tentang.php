<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Tentang";
$_SESSION["page-url"] = "tentang";
?>

<!DOCTYPE html>
<html>

<head>

  <?php require_once("resources/header.php"); ?>

</head>

<body>

  <div class="hero_area">
    <?php require_once("resources/navbar.php"); ?>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="assets/images/detail-tentang.jpeg" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Sekilas <span>ASDP</span>
              </h2>
            </div>
            <p class="text-dark">
              PT ASDP Indonesia Ferry ( Persero) atau ASDP adalah BUMN yang bergerak dalam bisnis jasa penyeberangan dan pelabuhan terintegrasi dan tujuan wisata waterfront . ASDP menjalankan armada ferry sebanyak lebih dari 160 unit yang menangani lebih dari 300 rute di 36 pelabuhan di seluruh Indonesia dan mengembangkan bisnis lainnya terkait dengan pengembangan kawasan pelabuhan, seperti Bakauheni Harbour City di Provinsi Lampung dan Kawasan Marina Labuan Bajo di Nusa Tenggara Timur.
            </p>
          </div>
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Visi Misi
              </h2>
            </div>
            <h6>Visi</h6>
            <p class="text-dark">
              Terdepan dalam menghubungkan masyarakat dan pasar melalui jasa penyeberangan-pelabuhan terintegrasi dan tujuan wisata waterfront
            </p>
            <h6>Misi</h6>
            <ol type="1">
              <li>
                <p class="text-dark">
                  Menciptakan dan mengoptimalkan nilai perusahaan dengan menghubungkan masyarakat dan pasar.
                </p>
              </li>
              <li>
                <p class="text-dark">
                  Menekankan keunggulan operasional melalui:
                </p>
                <ul>
                  <li>
                    <p class="text-dark">Budaya Pelayanan yang profesional dan berkualitas</p>
                  </li>
                  <li>
                    <p class="text-dark">Fasilitas pelabuhan terintegrasi, armada dan infrastruktur yang handal</p>
                  </li>
                  <li>
                    <p class="text-dark">Penerapan teknologi berbasis nilai</p>
                  </li>
                </ul>
              </li>
              <li>
                <p class="text-dark">
                  Aktif mendukung dan berperan dalam pengembangan ekonomi melalui layanan logistik dan tujuan wisata pilihan.
                </p>
              </li>
              <li>
                <p class="text-dark">
                  Secara konsisten mengedepankan keselamatan dan layanan penuh keramahan, tulus dan berkualitas.
                </p>
              </li>
              <li>
                <p class="text-dark">
                  Penerapan standar lingkungan berkelanjutan.
                </p>
              </li>
            </ol>
          </div>
        </div>
        <div class="col-lg-12 mt-5">
          <div class="img-box">
            <img src="assets/images/sekilas-asdp.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>

</body>

</html>