<?php require_once("controller/script.php");
if (!isset($_SESSION['tiket'])) {
  header("Location: ./");
  exit;
} else {
  $id_tiket = valid($conn, $_SESSION['tiket']['id_tiket']);
  $tiket = "SELECT * FROM tiket 
    JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang
    JOIN jk ON penumpang.id_jk=jk.id_jk
    JOIN pembayaran ON pembayaran.id_tiket=tiket.id_tiket
    JOIN pelayaran ON tiket.id_pelayaran = pelayaran.id_pelayaran 
    JOIN jadwal ON pelayaran.id_jadwal = jadwal.id_jadwal 
    JOIN kapal ON jadwal.id_kapal = kapal.id_kapal 
    JOIN rute ON jadwal.id_rute = rute.id_rute 
    WHERE tiket.id_tiket = '$id_tiket' 
    AND tiket.qr_code IS NOT NULL 
    AND tiket.tgl_jalan >= CURDATE()
    AND tiket.jam_jalan >= CURTIME()";
  $data_tiket = mysqli_query($conn, $tiket);
}
$_SESSION["page-name"] = "Tiket";
$_SESSION["page-url"] = "tiket";
?>

<!DOCTYPE html>
<html>

<head>

  <?php require_once("resources/header.php"); ?>
  <style>
    .col-custom {
      position: relative;
    }

    .col-custom img {
      max-height: 300px;
      -webkit-filter: brightness(50%);
      width: 100%;
      object-fit: cover;
    }

    .container-custom {
      position: absolute;
      top: 60%;
      left: 15%;
      transform: translate(-50%, -50%);
      text-align: left;
      color: white;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 20px;
      border-radius: 5px;
    }

    .container-custom h2 {
      font-size: 35px;
      margin-bottom: 10px;
    }

    .container-custom h4 {
      font-size: 30px;
      margin: 0;
    }

    @media screen and (max-width: 991px) {
      .col-custom img {
        height: 200px;
      }

      .container-custom {
        top: 50%;
        left: 50%;
        text-align: center;
      }

      .container-custom h2 {
        font-size: 24px;
      }

      .container-custom h4 {
        font-size: 18px;
      }
    }

    .card {
      transform: none;
      transition: 0.25s ease-in-out;
    }

    .card img {
      height: 200px;
      object-fit: cover;
    }

    .card:hover {
      transform: scale(1.1);
    }
  </style>

</head>

<body>

  <div class="hero_area">
    <?php require_once("resources/navbar.php"); ?>
  </div>

  <div class="col-lg-12 p-0 m-0 col-custom">
    <img src="assets/images/wb-merak.png" alt="...">
    <div class="container-custom">
      <h2>Tiket</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <?php if (mysqli_num_rows($data_tiket) > 0) {
          $row = mysqli_fetch_assoc($data_tiket); ?>
          <div class="col-lg-12 mt-4">
            <div class="card mb-3 mt-3 rounded-0 border-0 shadow">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="assets/images/logo-asdp.png" style="width: 100%;height: 100%;" class="img-fluid rounded-start rounded-0" alt="...">
                </div>
                <div class="col-md-8 my-auto">
                  <div class="card-body" style="text-align: left;">
                    <h2 class="card-title">Tiket <?= $row['jenis_kapal'] . ' ' . $row['nama_kapal'] ?></h2>
                    <div class="row">
                      <div class="col-lg-6">
                        <h5>Detail Penumpang</h4>
                          <div class="col">
                            <p class="card-text">Nama: <strong><?= $row['nama'] ?></strong></p>
                            <p class="card-text mt-n3">Jenis Kelamin: <strong><?= $row['jenis_kelamin'] ?></strong></p>
                            <p class="card-text mt-n3">Umur: <strong><?= $row['umur'] ?></strong></p>
                            <p class="card-text mt-n3">No. Telp: <strong><?= $row['nomor_telepon'] ?></strong></p>
                            <p class="card-text mt-n3">Alamat: <strong><?= $row['alamat'] ?></strong></p>
                            <p class="card-text mt-n3">Email: <strong><?= $row['email'] ?></strong></p>
                          </div>
                      </div>
                      <div class="col-lg-6">
                        <h5>Detail Tiket</h6>
                          <div class="col">
                            <p class="card-text">Penumpang: <strong><?= $row['penumpang'] ?></strong></p>
                            <p class="card-text mt-n3">Golongan: <strong><?= $row['golongan'] ?></strong></p>
                            <p class="card-text mt-n3">Kendaraan: <strong><?= $row['kendaraan'] ?></strong></p>
                            <p class="card-text mt-n3">Cabang: <strong><?= $row['cabang'] ?></strong></p>
                            <p class="card-text mt-n3">Linsatan: <strong><?= $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] ?></strong></p>
                            <p class="card-text mt-n3">Jarak: <strong><?= $row['jarak'] ?> km</strong></p>
                          </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-lg-12">
                        <p class="card-text mb-3">Tgl keberangkatan <strong><?php $tgl_berangkat = date_create($row["tgl_jalan"]);
                                                                            echo date_format($tgl_berangkat, "d M Y") . " - " . $row['jam_jalan']; ?></strong></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>

</body>

</html>