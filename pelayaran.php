<?php require_once("controller/script.php");
if (!isset($_SESSION['redirect'])) {
  header("Location: ./");
  exit;
} else {
  $pelabuhan_asal = valid($conn, $_SESSION['redirect']['pelabuhan_asal']);
  $pelabuhan_tujuan = valid($conn, $_SESSION['redirect']['pelabuhan_tujuan']);
  $pelayaran = "SELECT pelayaran.*, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.img_kapal, kapal.nama_kapal, kapal.kapasitas, kapal.jenis_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan FROM pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute WHERE rute.pelabuhan_asal='$pelabuhan_asal' AND rute.pelabuhan_tujuan='$pelabuhan_tujuan' GROUP BY pelayaran.id_jadwal ORDER BY pelayaran.id_pelayaran DESC";
  $front_pelayaran = mysqli_query($conn, $pelayaran);
}
$_SESSION["page-name"] = "Pelayaran";
$_SESSION["page-url"] = "pelayaran";
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

    .card-title-custom {
      cursor: default;
      margin: -40px 20px;
      padding: 5px 10px;
      color: #fff;
      background-color: none;
      transition: 0.25s ease-in-out;
    }

    .card:hover,
    .card-title-custom:hover {
      transform: scale(1.1);
      color: #00c6a9;
      background-color: #fff;
    }
  </style>

</head>

<body>
  <?php if (isset($_SESSION["message-success"])) { ?>
    <div class="message-success" data-message-success="<?= $_SESSION["message-success"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-info"])) { ?>
    <div class="message-info" data-message-info="<?= $_SESSION["message-info"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-warning"])) { ?>
    <div class="message-warning" data-message-warning="<?= $_SESSION["message-warning"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-danger"])) { ?>
    <div class="message-danger" data-message-danger="<?= $_SESSION["message-danger"] ?>"></div>
  <?php } ?>

  <div class="hero_area">
    <?php require_once("resources/navbar.php"); ?>
  </div>

  <div class="col-lg-12 p-0 m-0 col-custom">
    <img src="assets/images/wb-merak.png" alt="...">
    <div class="container-custom">
      <h2>Pelayaran</h2>
      <h4 style="color: #e6b81d;">ASDP Cabang Kupang</h4>
    </div>
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container">
      <?php if (isset($_GET['select'])) {
        if (!empty($_GET['select'])) { ?>
          <div class="row">
            <div class="col-lg-12">
              <h4>Pilih Tiket Kamu</h4>
            </div>
            <?php $id_jadwal = valid($conn, $_GET['select']);
            $take_pelayaran = "SELECT pelayaran.*, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.img_kapal, kapal.nama_kapal, kapal.kapasitas, kapal.jenis_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan FROM pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute WHERE pelayaran.id_jadwal='$id_jadwal'";
            $takePelayaran = mysqli_query($conn, $take_pelayaran);
            if (mysqli_num_rows($takePelayaran) > 0) {
              while ($row_pel = mysqli_fetch_assoc($takePelayaran)) { ?>
                <div class="col-md-10">
                  <div class="card mb-3 rounded-0 border-0 shadow">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="<?= $row_pel['img_kapal'] ?>" class="img-fluid rounded-start" alt="<?= $row_pel['nama_kapal'] ?>">
                      </div>
                      <div class="col-md-4">
                        <div class="card-body">
                          <h5 class="card-title"><?= $row_pel['nama_kapal'] ?></h5>
                          <p>Penumpang <strong><?= $row_pel['penumpang'] ?></strong></p>
                          <p style="margin-top: -15px;">Golongan <strong><?= $row_pel['golongan'] . " " . $row_pel['kendaraan'] ?></strong></p>
                          <p style="margin-top: -15px;">Harga Rp. <strong><?= number_format($row_pel['harga']) ?></strong></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card-body">
                          <p>Lintasan <strong><?= $row_pel['pelabuhan_asal'] . ' - ' . $row_pel['pelabuhan_tujuan'] ?></strong></p>
                          <p style="margin-top: -15px;">Jadwal <strong><?php $tgl = date_create($row_pel["tanggal_berangkat"]);
                                                                        echo date_format($tgl, "d M Y") . " - " . $row_pel['jam_berangkat']; ?></strong></p>
                          <button type="button" class="btn btn-primary btn-sm rounded-0 text-white" data-toggle="modal" data-target="#tiket<?= $row_pel['id_pelayaran'] ?>">
                            Pilih Tiket
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="tiket<?= $row_pel['id_pelayaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header border-bottom-0 shadow">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Penumpang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                        <div class="modal-body">
                          <?php if ($_SESSION['redirect']['akses'] == 0) { ?>
                            <div class="form-group mt-3">
                              <label for="nama">Nama Penumpang <span class="text-danger">*</span></label>
                              <input type="text" name="nama" value="<?php if (isset($_SESSION['redirect']['nama'])) {
                                                                      echo $_SESSION['redirect']['nama'];
                                                                    } ?>" id="nama" class="form-control text-center" placeholder="Nama Penumpang" min="3" required>
                            </div>
                            <div class="form-group">
                              <label for="id_jk">Jenis Kelamin <span class="text-danger">*</span></label>
                              <select name="id_jk" id="id_jk" class="form-control" aria-label="Default select example" required>
                                <option selected value="">Pilih Jenis Kelamin</option>
                                <?php foreach ($selectJK as $row_jk) { ?>
                                  <option value="<?= $row_jk['id_jk'] ?>"><?= $row_jk['jenis_kelamin'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="umur">Umur <span class="text-danger">*</span></label>
                              <input type="number" name="umur" value="<?php if (isset($_SESSION['redirect']['umur'])) {
                                                                        echo $_SESSION['redirect']['umur'];
                                                                      } ?>" id="umur" class="form-control text-center" placeholder="Umur" step="1" min="1" required>
                            </div>
                            <div class="form-group">
                              <label for="alamat">Alamat <span class="text-danger">*</span></label>
                              <input type="text" name="alamat" value="<?php if (isset($_SESSION['redirect']['alamat'])) {
                                                                        echo $_SESSION['redirect']['alamat'];
                                                                      } ?>" id="alamat" class="form-control text-center" placeholder="Alamat" required>
                            </div>
                            <div class="form-group">
                              <label for="nomor_telepon">No. Telp <span class="text-danger">*</span></label>
                              <input type="number" name="nomor_telepon" value="<?php if (isset($_SESSION['redirect']['nomor_telepon'])) {
                                                                                  echo $_SESSION['redirect']['nomor_telepon'];
                                                                                } ?>" id="nomor_telepon" class="form-control text-center" placeholder="No. Telp" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4||3}" required>
                            </div>
                            <hr>
                            <p class="text-danger"><span class="badge badge-danger">Perhatian!!</span> Akun anda belum terdaftar, silakan masukan email dan kata sandi yang saat ini anda gunakan.</p>
                            <div class="form-group">
                              <label for="email">Email <span class="text-danger">*</span></label>
                              <input type="email" name="email" value="<?php if (isset($_SESSION['redirect']['email'])) {
                                                                        echo $_SESSION['redirect']['email'];
                                                                      } ?>" id="email" class="form-control text-center" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                              <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                              <input type="password" name="password" id="password" class="form-control text-center" placeholder="Kata Sandi" required>
                            </div>
                            <div class="form-group">
                              <label for="re_password">Ulangi Sandi <span class="text-danger">*</span></label>
                              <input type="password" name="re_password" id="re_password" class="form-control text-center" placeholder="Ulangi Sandi" required>
                            </div>
                          <?php } elseif ($_SESSION['redirect']['akses'] == 1) { ?>
                            <p class="text-success"><span class="badge badge-success">Success!!</span> Akun anda terdaftar, silakan masukan kata sandi untuk melanjutkan pembayaran.</p>
                            <div class="form-group">
                              <label for="email">Email <span class="text-danger">*</span></label>
                              <input type="email" name="email" value="<?php if (isset($_SESSION['redirect']['email'])) {
                                                                        echo $_SESSION['redirect']['email'];
                                                                      } ?>" id="email" class="form-control text-center" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                              <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                              <input type="password" name="password" id="password" class="form-control text-center" placeholder="Kata Sandi" required>
                            </div>
                          <?php } ?>
                        </div>
                        <div class="modal-footer border-top-0 justify-content-center">
                          <input type="hidden" name="id_pelayaran" value="<?= $row_pel['id_pelayaran'] ?>">
                          <input type="hidden" name="harga" value="<?= $row_pel['harga'] ?>">
                          <input type="hidden" name="tgl_jalan" value="<?= $row_pel['tanggal_berangkat'] ?>">
                          <input type="hidden" name="jam_jalan" value="<?= $row_pel['jam_berangkat'] ?>">
                          <input type="hidden" name="akses" value="<?= $_SESSION['redirect']['akses'] ?>">
                          <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
                          <button type="submit" name="daftar-pelayaran" class="btn btn-primary rounded-0 text-white">Lanjut</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
          </div>
          <hr>
      <?php }
      } ?>
      <div class="row">
        <div class="col-lg-12">
          <h4>Pilih Pelayaran Kamu</h4>
        </div>
        <?php if (mysqli_num_rows($front_pelayaran) > 0) {
          while ($row = mysqli_fetch_assoc($front_pelayaran)) { ?>
            <div class="col-lg-3 mt-3">
              <div class="card border-0 shadow">
                <img src="<?= $row['img_kapal'] ?>" class="card-img-top" alt="<?= $row['nama_kapal'] ?>">
                <h5 class="card-title-custom"><?= $row['nama_kapal'] ?></h5>
                <div class="card-body" style="margin-top: 40px;">
                  <a href="pelayaran?select=<?= $row['id_jadwal'] ?>" class="btn btn-primary btn-sm rounded-0 text-white">Pilih Kapal</a>
                </div>
              </div>
            </div>
          <?php }
        } else { ?>
          <div class="col-lg-3 mt-3">
            <p>Pelayaran tidak ditemukan!</p>
            <form action="redirect" method="post">
              <button type="submit" name="re-pelayaran" class="btn btn-primary btn-sm rounded-0 text-white">Kembali</button>
            </form>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>


</body>

</html>