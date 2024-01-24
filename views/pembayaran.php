<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Pembayaran";
$_SESSION["page-url"] = "pembayaran";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/dash-header.php") ?></head>

<body style="font-family: 'Montserrat', sans-serif;">
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
  <div class="container-scroller">
    <?php require_once("../resources/dash-topbar.php") ?>
    <div class="container-fluid page-body-wrapper">
      <?php require_once("../resources/dash-sidebar.php") ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <h3><?= $_SESSION["page-name"] ?></h3>
                    </li>
                  </ul>
                </div>
                <div class="card rounded-0 mt-3">
                  <div class="card-body table-responsive">
                    <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">#</th>
                          <th scope="col" class="text-center">No. Pemesanan</th>
                          <th scope="col" class="text-center">Nama Penumpang</th>
                          <th scope="col" class="text-center">Kelas</th>
                          <th scope="col" class="text-center">Golongan</th>
                          <th scope="col" class="text-center">Status Bayar</th>
                          <th scope="col" class="text-center">Total Bayar</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_pembayaran) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_pembayaran)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <th>#<?= $row['no_pemesanan'] ?></th>
                              <td><?php
                                  $no_pemesanan = $row['no_pemesanan'];
                                  $take_pemesanan = "SELECT * FROM pemesanan JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang WHERE pemesanan.no_pemesanan='$no_pemesanan'";
                                  $takePemesanan = mysqli_query($conn, $take_pemesanan);
                                  $noPem = 1;
                                  while ($rowPem = mysqli_fetch_assoc($takePemesanan)) {
                                    echo "<p>" . $noPem . ". " . $rowPem['nama'] . "</p>";
                                    $noPem++;
                                  }
                                  ?></td>
                              <td><?= $row["nama_kelas"] ?></td>
                              <td><?= $row["nama_golongan"] ?></td>
                              <td><?php
                                  $no_pemesanan = $row['no_pemesanan'];
                                  $check_pembayaran = "SELECT * FROM pembayaran WHERE no_pemesanan='$no_pemesanan'";
                                  $checkPembayaran = mysqli_query($conn, $check_pembayaran);
                                  if (mysqli_num_rows($checkPembayaran) == 0) {
                                    echo "Belum terbayar";
                                  } else if (mysqli_num_rows($checkPembayaran) > 0) {
                                    $rowBayar = mysqli_fetch_assoc($checkPembayaran);
                                    echo $rowBayar['status_pembayaran'];
                                  }
                                  ?></td>
                              <td>Rp. <?php $no_pemesanan = $row['no_pemesanan'];
                                      $calculate_pembayaran = "SELECT SUM(kelas.harga_kelas + golongan.harga_golongan) AS total_pembayaran
                                                                    FROM pemesanan
                                                                    JOIN penumpang ON pemesanan.id_penumpang = penumpang.id_penumpang
                                                                    JOIN golongan ON penumpang.id_golongan = golongan.id_golongan
                                                                    JOIN kelas ON penumpang.id_kelas = kelas.id_kelas
                                                                    WHERE pemesanan.no_pemesanan = '$no_pemesanan'";
                                      $calculatePembayaran = mysqli_query($conn, $calculate_pembayaran);
                                      $rowCalBayar = mysqli_fetch_assoc($calculatePembayaran);
                                      $total_pembayaran = $rowCalBayar['total_pembayaran'];
                                      echo number_format($total_pembayaran);
                                      ?></td>
                              <td class="d-flex justify-content-center">
                                <?php if ($role == 3) { ?>
                                  <div class="col text-center">
                                    <?php if ($row['id_status'] == 1) { ?>
                                      <button type="button" class="btn btn-success btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#bayar<?= $row["no_pemesanan"] ?>">
                                        <i class="mdi mdi-cash-multiple"></i> Bayar
                                      </button>
                                      <?php
                                      $select_pembayaran = "SELECT * FROM pembayaran WHERE no_pemesanan='$row[no_pemesanan]'";
                                      $take_pembayaran = mysqli_query($conn, $select_pembayaran);
                                      if (mysqli_num_rows($take_pembayaran) == 0) {
                                        $idPesanan = $row["id_pemesanan"];
                                        $tanggalPembelian = $row["tgl_pesan"];

                                        // Menghitung waktu kedaluwarsa
                                        $waktuKedaluwarsa = hitungWaktuExpired($tanggalPembelian); ?>
                                        <p><span id="timer<?= $row["id_pemesanan"] ?>"></span></p>

                                        <script>
                                          // Menghitung waktu mundur dari waktu kedaluwarsa
                                          var waktuKedaluwarsa<?= $idPesanan; ?> = new Date("<?= $waktuKedaluwarsa; ?>").getTime();
                                          var idPesanan = <?= $idPesanan; ?>;

                                          // Mendapatkan elemen HTML untuk menampilkan timer
                                          var timerDisplay<?= $idPesanan; ?> = document.getElementById('timer<?= $idPesanan; ?>');

                                          // Fungsi untuk mengupdate timer setiap detik
                                          function updateTimer() {
                                            var sekarang = new Date().getTime();

                                            // Menghitung selisih waktu
                                            var selisih = waktuKedaluwarsa<?= $idPesanan; ?> - sekarang;

                                            // Menghitung menit dan detik yang tersisa
                                            var menit = Math.floor(selisih / (1000 * 60));
                                            var detik = Math.floor((selisih % (1000 * 60)) / 1000);

                                            // Menampilkan waktu tersisa pada elemen HTML
                                            timerDisplay<?= $idPesanan; ?>.textContent = 'Pesanan Akan Dibatalkan Otomatis Dalam ' + menit.toString().padStart(2, '0') + ':' + detik.toString().padStart(2, '0');

                                            // Menghentikan timer ketika mencapai 0
                                            if (selisih < 0) {
                                              clearInterval(timerInterval<?= $idPesanan; ?>);
                                              timerDisplay<?= $idPesanan; ?>.textContent = 'Pemesanan Dibatalkan Otomatis';

                                              // Lakukan pembaruan data di database saat waktu kedaluwarsa
                                              if (idPesanan !== null) {
                                                // Kirim permintaan AJAX ke skrip PHP untuk memperbarui status pesanan
                                                var xhr = new XMLHttpRequest();
                                                xhr.open('POST', 'update-pembayaran.php', true); // Ubah 'update-status.php' dengan nama file PHP yang sesuai
                                                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                                xhr.onreadystatechange = function() {
                                                  if (xhr.readyState === 4 && xhr.status === 200) {
                                                    console.log('Status pesanan diperbarui.');
                                                  }
                                                };
                                                xhr.send('id=' + idPesanan);
                                              }
                                            }
                                          }

                                          // Memulai timer
                                          updateTimer(); // Menampilkan waktu awal
                                          var timerInterval<?= $idPesanan; ?> = setInterval(updateTimer, 1000); // Memanggil fungsi updateTimer setiap 1 detik
                                        </script>
                                      <?php } ?>
                                      <div class="modal fade" id="bayar<?= $row["no_pemesanan"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header border-bottom-0 shadow">
                                              <h5 class="modal-title" id="exampleModalLabel">Bayar</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <?php
                                            $action_pembayaran = "SELECT * FROM pembayaran WHERE no_pemesanan='$no_pemesanan'";
                                            $actionPembayaran = mysqli_query($conn, $action_pembayaran);
                                            if (mysqli_num_rows($actionPembayaran) == 0) { ?>
                                              <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body text-center">
                                                  <div class="mb-3">
                                                    <label for="id_bank" class="form-label">Bank</label>
                                                    <select name="id_bank" class="form-select" aria-label="Default select example" required>
                                                      <option value="" selected>Pilih Bank</option>
                                                      <?php foreach ($view_account_bank as $row_bank) { ?>
                                                        <option value="<?= $row_bank['id_bank'] ?>"><?= $row_bank['bank'] . " - " . $row_bank['norek'] . " (" . $row_bank['an'] . ")" ?></option>
                                                      <?php } ?>
                                                    </select>
                                                  </div>
                                                  <div class="mb-3">
                                                    <label for="avatar" class="form-label">Upload Bukti Bayar <small class="text-danger">*</small></label>
                                                    <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                                                              echo $_POST['avatar'];
                                                                                            } ?>" class="form-control text-center" id="avatar" placeholder="Upload Bukti Bayar" required>
                                                  </div>
                                                </div>
                                                <div class="modal-footer justify-content-center border-top-0">
                                                  <input type="hidden" name="no_pemesanan" value="<?= $row["no_pemesanan"] ?>">
                                                  <input type="hidden" name="total_bayar" value="<?= $total_pembayaran ?>">
                                                  <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                                  <button type="submit" name="tambah-pembayaran" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Bayar Sekarang</button>
                                                </div>
                                              </form>
                                              <?php
                                            } else if (mysqli_num_rows($actionPembayaran) > 0) {
                                              $rowAction = mysqli_fetch_assoc($actionPembayaran);
                                              if ($rowAction['status_pembayaran'] == "Checking") { ?>
                                                <div class="modal-body text-center">
                                                  <textarea class="form-control border-0 bg-transparent" style="height: 150px;line-height: 25px;font-size: 16px;" readonly>Pembayaran anda saat ini sedang dalam pengecekan petugas, silakan menunggu petugas kami akan mengirimkan notifikasi melalui whatsapp untuk status pembayaran.</textarea>
                                                </div>
                                              <?php } else if ($rowAction['status_pembayaran'] == "Gagal") { ?>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                  <div class="modal-body text-center">
                                                    <p>Bukti pembayaran anda gagal, silakan masukan bukti pembayaran yang<br> semestinya sesuai tiket anda!</p>
                                                    <div class="mb-3">
                                                      <label for="id_bank" class="form-label">Bank</label>
                                                      <select name="id_bank" class="form-select" aria-label="Default select example" required>
                                                        <option value="" selected>Pilih Bank</option>
                                                        <?php foreach ($view_account_bank as $row_bank) { ?>
                                                          <option value="<?= $row_bank['id_bank'] ?>"><?= $row_bank['bank'] . " - " . $row_bank['norek'] . " (" . $row_bank['an'] . ")" ?></option>
                                                        <?php } ?>
                                                      </select>
                                                    </div>
                                                    <div class="mb-3">
                                                      <label for="avatar" class="form-label">Upload Bukti Bayar <small class="text-danger">*</small></label>
                                                      <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                                                                echo $_POST['avatar'];
                                                                                              } ?>" class="form-control text-center" id="avatar" placeholder="Upload Bukti Bayar" required>
                                                    </div>
                                                  </div>
                                                  <div class="modal-footer justify-content-center border-top-0">
                                                    <input type="hidden" name="id_pembayaran" value="<?= $row["id_pembayaran"] ?>">
                                                    <input type="hidden" name="total_bayar" value="<?= $total_pembayaran ?>">
                                                    <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                                    <input type="hidden" name="avatarOld" value="<?= $row["bukti_bayar"] ?>">
                                                    <button type="submit" name="ubah-pembayaran" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Bayar Sekarang</button>
                                                  </div>
                                                </form>
                                              <?php } else if ($rowAction['status_pembayaran'] == "Diterima") { ?>
                                                <div class="modal-body text-center">
                                                  Bukti pembayaran anda berhasil diterima dengan baik oleh petugas kami.
                                                </div>
                                            <?php }
                                            } ?>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } else if ($row['id_status'] == 2) {  ?>
                                      <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;">
                                        <i class="mdi mdi-cash-multiple"></i> Dibatalkan
                                      </button>
                                    <?php } ?>
                                  </div>
                                <?php } else if ($role <= 2) { ?>
                                  <div class="col">
                                    <button type="button" class="btn btn-success btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#bayar<?= $row["id_pembayaran"] ?>">
                                      <i class="mdi mdi-cash-multiple"></i> Cek Bayar
                                    </button>
                                    <div class="modal fade" id="bayar<?= $row["id_pembayaran"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header border-bottom-0 shadow">
                                            <h5 class="modal-title" id="exampleModalLabel">Bayar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <?php if ($row['status_pembayaran'] == "Checking") { ?>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                              <div class="modal-body text-center">
                                                <img src="<?= $row['bukti_bayar'] ?>" style="border-radius: 0;width: 100%;height: 100%;object-fit: cover;" alt="">
                                                <p>Pembayaran dilakukan via bank: <br><?= $row['bank'] . " - " . $row['norek'] . " (" . $row['an'] . ")" ?></p>
                                                <div class="mb-3 mt-3">
                                                  <label for="status_pembayaran" class="form-label">Status Bukti Bayar <small class="text-danger">*</small></label>
                                                  <select name="status_pembayaran" id="status_pembayaran" class="form-select" aria-label="Default select example" required>
                                                    <option selected value="">Pilih Status Pembayaran</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Gagal">Gagal</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="modal-footer justify-content-center border-top-0">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row["id_pembayaran"] ?>">
                                                <input type="hidden" name="id_jadwal" value="<?= $row["id_jadwal"] ?>">
                                                <input type="hidden" name="no_pemesanan" value="<?= $row["no_pemesanan"] ?>">
                                                <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah-pembayaran" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Kirim</button>
                                              </div>
                                            </form>
                                          <?php } else if ($row['status_pembayaran'] == "Gagal") { ?>
                                            <div class="modal-body text-center">
                                              Bukti pembayaran gagal diterima oleh petugas.
                                            </div>
                                          <?php } else if ($row['status_pembayaran'] == "Diterima") { ?>
                                            <div class="modal-body text-center">
                                              Bukti pembayaran berhasil diterima dengan baik oleh petugas.
                                            </div>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                              </td>
                            </tr>
                        <?php $no++;
                          }
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>