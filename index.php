<?php require_once("controller/script.php");
$_SESSION["page-name"] = "";
$_SESSION["page-url"] = "./";
?>

<!DOCTYPE html>
<html style="scroll-behavior: smooth;">

<head>

  <?php require_once("resources/header.php"); ?>

</head>

<body>

  <div class="hero_area">
    <?php require_once("resources/navbar.php"); ?>
    <section class="slider_section " style="position: relative;z-index: 1;">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <div class="play_btn">
                      <button type="button" id="playButton" class="btn btn-primary" data-toggle="modal" data-target="#videoPopup">
                        <i class="fa fa-play" aria-hidden="true"></i>
                      </button>
                    </div>
                    <h1>
                      ASDP Indonesia Ferry<br>
                      <span>
                        Cabang Kupang
                      </span>
                    </h1>
                    <h4>
                      "We Bridge The Nation"
                    </h4>
                    <a href="#pemesanan" class="btn border-0 shadow mb-5">Pesan Tiket Sekarang</a>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                    <img src="assets/images/banner.jpeg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!-- book section -->
  <section class="book_section layout_padding" id="pemesanan">
    <div class="container">
      <div class="row">
        <div class="col">
          <form action="redirect" method="post">
            <h4>
              Pemesanan <span>Tiket</span>
            </h4>
            <div class="form-row ">
              <div class="form-group col-lg-4">
                <label for="pelabuhan_asal">Pelabuhan Asal <small class="text-danger">*</small></label>
                <select name="pelabuhan_asal" id="pelabuhan_asal" class="form-control" aria-label="Default select example" required>
                  <option selected value="">Pilih Pelabuhan Asal</option>
                  <?php foreach ($selectPelabuhanAsal as $row_spa) { ?>
                    <option value="<?= $row_spa['nama_pelabuhan'] ?>"><?= $row_spa['nama_pelabuhan'] . ' - Kota ' . $row_spa['kota'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-lg-4">
                <label for="pelabuhan_tujuan">Pelabuhan Tujuan <small class="text-danger">*</small></label>
                <select name="pelabuhan_tujuan" id="pelabuhan_tujuan" class="form-control" aria-label="Default select example" required>
                  <option selected value="">Pilih Pelabuhan Tujuan</option>
                  <?php foreach ($selectPelabuhanTujuan as $row_spt) { ?>
                    <option value="<?= $row_spt['nama_pelabuhan'] ?>"><?= $row_spt['nama_pelabuhan'] . ' - Kota ' . $row_spt['kota'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-lg-4">
                <label for="pelabuhan_tujuan">Penumpang <small class="text-danger">*</small></label>
                <input type="number" name="pessanger" value="1" class="form-control" min="1" required>
              </div>
              <div class="form-group col-lg-3">
                <button type="submit" name="pelayaran" class="btn w-100 btn-sm" style="margin-top: 32px;">Cek Pelayaran</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

  <!-- about section -->
  <section class="about_section mb-5">
    <div class="container  ">
      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="assets/images/tentang.jpeg" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Tentang <span>Kami</span>
              </h2>
            </div>
            <p class="text-dark">
              PT ASDP Indonesia Ferry ( Persero) atau ASDP adalah BUMN yang bergerak dalam bisnis jasa penyeberangan dan pelabuhan terintegrasi dan tujuan wisata waterfront . ASDP menjalankan armada ferry sebanyak lebih dari 160 unit yang menangani lebih dari 300 rute di 36 pelabuhan di seluruh Indonesia dan mengembangkan bisnis lainnya terkait dengan pengembangan kawasan pelabuhan, seperti Bakauheni Harbour City di Provinsi Lampung dan Kawasan Marina Labuan Bajo di Nusa Tenggara Timur.
            </p>
            <a href="tentang">
              Baca Lebih
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <!-- Bootstrap Modal (Popup) -->
  <div class="modal fade" id="videoPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe class="embed-responsive-item" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" style="width: 100%;height: 622px;" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("resources/footer.php"); ?>
  <script>
    // Replace this with the YouTube video URL you want to display
    const videoUrl = "https://www.youtube.com/embed/x6cudNR7iws?autoplay=1&showinfo=0&controls=0";

    const playButton = document.getElementById("playButton");
    const videoIframe = document.querySelector("#videoPopup iframe");

    // Function to open the popup and set the video URL
    function openPopup() {
      videoIframe.src = videoUrl;
      $("#videoPopup").modal("show");
    }

    // Function to close the popup
    function closePopup() {
      videoIframe.src = "";
      $("#videoPopup").modal("hide");
    }

    // Event listener for the play button
    playButton.addEventListener("click", openPopup);

    // Event listener for the Bootstrap modal close event
    $("#videoPopup").on("hidden.bs.modal", closePopup);
  </script>

</body>

</html>