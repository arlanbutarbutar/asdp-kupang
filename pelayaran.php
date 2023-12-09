<?php require_once("controller/script.php");
if (!isset($_SESSION['redirect'])) {
  header("Location: ./");
  exit;
} else {
  $pelabuhan_asal = valid($conn, $_SESSION['redirect']['pelabuhan_asal']);
  $pelabuhan_tujuan = valid($conn, $_SESSION['redirect']['pelabuhan_tujuan']);
  $sekarang = date('Y-m-d H:i:s');
  $jadwal = "SELECT * FROM jadwal 
           JOIN kapal ON jadwal.id_kapal = kapal.id_kapal 
           JOIN rute ON jadwal.id_rute = rute.id_rute 
           WHERE rute.pelabuhan_asal = '$pelabuhan_asal' 
           AND rute.pelabuhan_tujuan = '$pelabuhan_tujuan'
           AND jadwal.tanggal_berangkat > CURDATE() OR (jadwal.tanggal_berangkat = CURDATE() AND jadwal.jam_berangkat > CURTIME())";
  $front_jadwal = mysqli_query($conn, $jadwal);
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

    .card-scale {
      transform: none;
      transition: 0.25s ease-in-out;
    }

    .card-scale img {
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

    .card-scale:hover,
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
      <div class="row">
        <div class="col-lg-12">
          <h4>Pilih Pelayaran Kamu</h4>
        </div>
        <?php if (mysqli_num_rows($front_jadwal) > 0) {
          while ($row = mysqli_fetch_assoc($front_jadwal)) { ?>
            <div class="col-lg-3 mt-3">
              <div class="card card-scale border-0 shadow">
                <img src="<?= $row['img_kapal'] ?>" class="card-img-top" alt="<?= $row['nama_kapal'] ?>">
                <h5 class="card-title-custom"><?= $row['nama_kapal'] ?></h5>
                <div class="card-body" style="margin-top: 40px;">
                  <p>Jadwal <strong><?php $tgl = date_create($row["tanggal_berangkat"]);
                                    echo date_format($tgl, "d M Y") . " - " . $row['jam_berangkat']; ?></strong></p>
                  <?php $date_now = date("Y-m-d");
                  if ($date_now == $row["tanggal_berangkat"]) {
                    $jam_berangkat_database = $row['jam_berangkat'];
                    $timestamp_jam_berangkat = strtotime($jam_berangkat_database);
                    $timestamp_limit = $timestamp_jam_berangkat - (3 * 3600);
                    $time_limit = date('H:i:s', $timestamp_limit);
                    $timestamp_sekarang = time();
                    if ($timestamp_limit > $timestamp_sekarang) {
                      $href = "#";
                      $data_modal = 'data-toggle="modal" data-target="#limit' . $row['id_jadwal'] . '"';
                    } else {
                      $href = "pelayaran?select=" . $row['id_jadwal'];
                      $data_modal = "";
                    }
                  } else {
                    $href = "pelayaran?select=" . $row['id_jadwal'];
                    $data_modal = "";
                  } ?>
                  <a href="<?= $href ?>" class="btn btn-primary btn-sm rounded-0 text-white" <?= $data_modal ?>>Pilih Kapal</a>
                </div>
              </div>
            </div>
            <div class="modal fade border-0" id="limit<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0 shadow">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Maaf jadwal kapal <?= $row['nama_kapal'] ?> sudah tidak dapat dipesan.</p>
                  </div>
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
      <?php if (isset($_GET['select'])) {
        if (!empty($_GET['select'])) { ?>
          <div class="row">
            <div class="col-lg-12">
              <hr>
              <h4>Masukan Data Kamu</h4>
            </div>
            <?php $id_jadwal = valid($conn, $_GET['select']);
            $take_jadwal = "SELECT * FROM jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute WHERE jadwal.id_jadwal='$id_jadwal'";
            $takeJadwal = mysqli_query($conn, $take_jadwal);
            if (mysqli_num_rows($takeJadwal) > 0) {
              while ($row_pel = mysqli_fetch_assoc($takeJadwal)) { ?>
                <div class="col-md-10">
                  <div class="card mb-3 rounded-0 border-0 shadow">
                    <div class="row g-0">
                      <div class="col-md-4 mb-auto">
                        <img src="<?= $row_pel['img_kapal'] ?>" class="img-fluid rounded-start" alt="<?= $row_pel['nama_kapal'] ?>">
                      </div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="card-body">
                              <h5 class="card-title"><?= $row_pel['nama_kapal'] ?></h5>
                              <p>Kapasitas <strong><?= $row_pel['kapasitas'] ?> penumpang</strong></p>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="card-body">
                              <p>Lintasan <strong><?= $row_pel['pelabuhan_asal'] . ' - ' . $row_pel['pelabuhan_tujuan'] ?></strong></p>
                              <p style="margin-top: -15px;">Jadwal <strong><?php $tgl = date_create($row_pel["tanggal_berangkat"]);
                                                                            echo date_format($tgl, "d M Y") . " - " . $row_pel['jam_berangkat']; ?></strong></p>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="card-body">
                              <form action="" method="post">
                                <?php $pessanger = valid($conn, $_SESSION["redirect"]["pessanger"]);
                                for ($pess = 1; $pess <= $pessanger; $pess++) { ?>
                                  <h6>Penumpang <?= $pess ?></h6>
                                  <div class="form-group mt-3">
                                    <label for="nama">Nama Penumpang <span class="text-danger">*</span></label>
                                    <input type="text" name="nama[]" id="nama" class="form-control text-center" placeholder="Nama Penumpang" min="3" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="id_kelas">Kelas <span class="text-danger">*</span></label>
                                    <select name="id_kelas[]" id="id_kelas" class="form-control" aria-label="Default select example" required>
                                      <option selected value="">Pilih Kelas</option>
                                      <?php foreach ($selectKel as $row_kel) { ?>
                                        <option value="<?= $row_kel['id_kelas'] ?>"><?= $row_kel['nama_kelas'] . " Rp. " . number_format($row_kel['harga_kelas']) ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="id_jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="id_jk[]" id="id_jk" class="form-control" aria-label="Default select example" required>
                                      <option selected value="">Pilih Jenis Kelamin</option>
                                      <?php foreach ($selectJK as $row_jk) { ?>
                                        <option value="<?= $row_jk['id_jk'] ?>"><?= $row_jk['jenis_kelamin'] ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="umur">Umur <span class="text-danger">*</span></label>
                                    <input type="number" name="umur[]" id="umur" class="form-control text-center" placeholder="Umur" step="1" min="1" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat[]" id="alamat" class="form-control text-center" placeholder="Alamat" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="id_golongan">Golongan <span class="text-danger">*</span></label>
                                    <select name="id_golongan[]" id="id_golongan<?= $pess ?>" class="form-control" aria-label="Default select example" required>
                                      <option selected value="">Pilih Golongan</option>
                                      <?php foreach ($selectGol as $row_gol) { ?>
                                        <option value="<?= $row_gol['id_golongan'] ?>"><?= $row_gol['nama_golongan'] . " Rp. " . number_format($row_gol['harga_golongan']) ?></option>
                                      <?php } ?>
                                    </select>
                                    <small id="golongan-info<?= $pess ?>"></small>
                                  </div>
                                  <!-- Buat objek JavaScript untuk menyimpan data tambahan -->
                                  <script>
                                    var golonganData = {
                                      <?php foreach ($selectGol as $row_gol) { ?>
                                        <?= $row_gol['id_golongan'] ?>: "<?= $row_gol['keterangan'] ?>",
                                      <?php } ?>
                                    };

                                    // Ambil elemen select dan small
                                    var select<?= $pess ?> = document.getElementById('id_golongan<?= $pess ?>');
                                    var infoSmall<?= $pess ?> = document.getElementById('golongan-info<?= $pess ?>');

                                    // Tambahkan event listener untuk mengubah keterangan saat memilih opsi
                                    select<?= $pess ?>.addEventListener('change', function() {
                                      var selectedOption = select<?= $pess ?>.options[select<?= $pess ?>.selectedIndex];
                                      var selectedId = selectedOption.value;
                                      var selectedData = golonganData[selectedId];
                                      infoSmall<?= $pess ?>.textContent = "Keterangan: " + selectedData;
                                    });
                                  </script>
                                <?php } ?>
                                <hr>
                                <p class="text-success">Masukan nomor handphone anda disini untuk melanjutkan pembayaran.</p>
                                <div class="form-group">
                                  <label for="nomor_telepon">No. HP <span class="text-danger">*</span></label>
                                  <input type="number" name="nomor_telepon" id="nomor_telepon" class="form-control text-center" placeholder="No. HP" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4||3}" required>
                                </div>
                                <input type="hidden" name="id_jadwal" value="<?= $row_pel['id_jadwal'] ?>">
                                <button type="submit" name="daftar-pelayaran" class="btn btn-primary rounded-0 text-white">Pesan Tiket</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
          </div>
          <hr>
      <?php }
      } ?>
    </div>
  </section>
  <!-- end about section -->

  <?php require_once("resources/footer.php"); ?>


</body>

</html>