<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Pemesanan";
$_SESSION["page-url"] = "pemesanan";
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
                          <th scope="col" class="text-center">Jadwal</th>
                          <th scope="col" class="text-center">Penumpang</th>
                          <th scope="col" class="text-center">Kapal</th>
                          <th scope="col" class="text-center">Kelas</th>
                          <th scope="col" class="text-center">Golongan</th>
                          <th scope="col" class="text-center">Harga</th>
                          <?php if ($role == 3) { ?>
                            <th scope="col" class="text-center">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_pemesanan) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_pemesanan)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <th>#<?= $row["no_pemesanan"] ?></th>
                              <td><?php $tgl = date_create($row["tanggal_berangkat"]);
                                  echo date_format($tgl, "d M Y") . " - " . $row['jam_berangkat']; ?></td>
                              <td>
                                <div>
                                  <p><strong><?= $row["nama"] ?></strong></p>
                                  <p><?= $row["jenis_kelamin"] ?></p>
                                  <p><?= $row["umur"] ?></p>
                                  <p><?= $row["alamat"] ?></p>
                                </div>
                              </td>
                              <td>
                                <div>
                                  <p><strong><?= $row["nama_kapal"] ?></strong></p>
                                  <p><?= $row["kapasitas"] ?></p>
                                  <p><?= $row["jenis_kapal"] ?></p>
                                  <p><?= $row["pelabuhan_asal"] . " - " . $row["pelabuhan_tujuan"] . " (" . $row['jarak'] . ")" ?></p>
                                </div>
                              </td>
                              <td><?= $row["nama_kelas"] ?></td>
                              <td><?= $row["nama_golongan"] ?></td>
                              <td>Rp. <?= number_format($row["harga_kelas"] + $row["harga_golongan"]) ?></td>
                              <?php if ($role == 3) { ?>
                                <td>
                                  <?php if ($row['id_status'] == 1) { ?>
                                    <div class="col">
                                      <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#batal<?= $row["id_pemesanan"] ?>">
                                        <i class="bi bi-trash3"></i> Batal
                                      </button>
                                      <div class="modal fade" id="batal<?= $row["id_pemesanan"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header border-bottom-0 shadow">
                                              <h5 class="modal-title" id="exampleModalLabel">Batal</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                              Anda yakin ingin membatalkan pemesanan ini?
                                            </div>
                                            <div class="modal-footer justify-content-center border-top-0">
                                              <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                              <form action="" method="POST">
                                                <input type="hidden" name="id_pemesanan" value="<?= $row["id_pemesanan"] ?>">
                                                <input type="hidden" name="no_pemesanan" value="<?= $row["no_pemesanan"] ?>">
                                                <input type="hidden" name="id_penumpang" value="<?= $row["id_penumpang"] ?>">
                                                <input type="hidden" name="harga" value="<?= $row["harga_kelas"] + $row["harga_golongan"] ?>">
                                                <button type="submit" name="hapus-pemesanan" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Batalkan Pemesanan</button>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } else if ($row['id_status'] == 2) { ?>
                                    <div class="col">
                                      <button type="button" class="btn btn-outline-danger btn-sm text-white rounded-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#dibatalkan<?= $row["id_pemesanan"] ?>">
                                        <i class="bi bi-trash3"></i> Telah dibatal
                                      </button>
                                      <div class="modal fade" id="dibatalkan<?= $row["id_pemesanan"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header border-bottom-0 shadow">
                                              <h5 class="modal-title" id="exampleModalLabel">Batal</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                              <p>Pengembalian dana atas transaksi batal pembelian tiket sudah diproses <br>senilai Rp. <?= number_format($row["harga_kelas"] + $row["harga_golongan"]) ?>. Mohon kesedian untuk menunggu dalam estimasi <br>7 hari kerja (Tidak termasuk Hari Sbatu, Minggu, Libur Nasional/Tanggal <br>Merah) sejak tanggal <?php $tgl = date_create($row["tgl_batal"]);
                                                                                                                                                                                                                                                                                                                                                  echo date_format($tgl, "d M Y") ?> maksimal pukul 23:59 WITA. Anda dapat <br>mengecek secara berkala pada mutasi rekening.</p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                </td>
                              <?php } ?>
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