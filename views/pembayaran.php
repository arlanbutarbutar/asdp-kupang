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
                          <th scope="col" class="text-center">Tgl Bayar</th>
                          <?php if ($role <= 2) { ?>
                            <th scope="col" class="text-center">Nama Penumpang</th>
                            <th scope="col" class="text-center">Jenis Kelamin</th>
                            <th scope="col" class="text-center">Umur</th>
                            <th scope="col" class="text-center">No. Telp</th>
                          <?php } ?>
                          <th scope="col" class="text-center">Penumpang</th>
                          <th scope="col" class="text-center">Golongan</th>
                          <th scope="col" class="text-center">Kendaraan</th>
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
                              <td><?php $tgl = date_create($row["tgl_bayar"]);
                                  echo date_format($tgl, "d M Y") ?></td>
                              <?php if ($role <= 2) { ?>
                                <td><?= $row["nama"] ?></td>
                                <td><?= $row["jenis_kelamin"] ?></td>
                                <td class="text-center"><?= $row["umur"] ?></td>
                                <td><?= $row["nomor_telepon"] ?></td>
                              <?php } ?>
                              <td><?= $row["penumpang"] ?></td>
                              <td><?= $row["golongan"] ?></td>
                              <td><?= $row["kendaraan"] ?></td>
                              <td><?= $row["status_pembayaran"] ?></td>
                              <td>Rp. <?= number_format($row["harga"]) ?></td>
                              <td class="d-flex justify-content-center">
                                <?php if ($role == 3) { ?>
                                  <div class="col">
                                    <button type="button" class="btn btn-success btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#bayar<?= $row["id_tiket"] ?>">
                                      <i class="mdi mdi-cash-multiple"></i> Bayar
                                    </button>
                                    <div class="modal fade" id="bayar<?= $row["id_tiket"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header border-bottom-0 shadow">
                                            <h5 class="modal-title" id="exampleModalLabel">Bayar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <?php if ($row['status_pembayaran'] == NULL || $row['status_pembayaran'] == "Gagal") { ?>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                              <div class="modal-body text-center">
                                                <?php if ($row['status_pembayaran'] == "Gagal") { ?>
                                                  <p>Bukti pembayaran anda gagal, silakan masukan bukti pembayaran yang<br> semestinya sesuai tiket anda!</p>
                                                <?php } ?>
                                                <div class="mb-3 mt-3">
                                                  <label for="avatar" class="form-label">Upload Bukti Bayar <small class="text-danger">*</small></label>
                                                  <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                                                            echo $_POST['avatar'];
                                                                                          } ?>" class="form-control text-center" id="avatar" placeholder="Upload Bukti Bayar" required>
                                                </div>
                                              </div>
                                              <div class="modal-footer justify-content-center border-top-0">
                                                <input type="hidden" name="id_tiket" value="<?= $row["id_tiket"] ?>">
                                                <input type="hidden" name="total_bayar" value="<?= $row["harga"] ?>">
                                                <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                                <?php if ($row['status_pembayaran'] == "Gagal") { ?>
                                                  <input type="hidden" name="avatarOld" value="<?= $row["bukti_bayar"] ?>">
                                                  <button type="submit" name="ubah-pembayaran" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Bayar Sekarang</button>
                                                <?php } else { ?>
                                                  <button type="submit" name="tambah-pembayaran" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Bayar Sekarang</button>
                                                <?php } ?>
                                              </div>
                                            </form>
                                          <?php } else if ($row['status_pembayaran'] == "Checking") { ?>
                                            <div class="modal-body text-center">
                                              <textarea class="form-control border-0 bg-transparent" style="height: 150px;line-height: 25px;font-size: 16px;" readonly>Pembayaran anda saat ini sedang dalam pengecekan petugas, silakan menunggu petugas kami akan mengirimkan notifikasi melalui whatsapp untuk status pembayaran.</textarea>
                                            </div>
                                          <?php } else if ($row['status_pembayaran'] == "Diterima") { ?>
                                            <div class="modal-body text-center">
                                              Bukti pembayaran anda berhasil diterima dengan baik oleh petugas kami.
                                            </div>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php } else if ($role <= 2) {
                                  if ($row['status_pembayaran'] == "Checking") { ?>
                                    <div class="col">
                                      <button type="button" class="btn btn-success btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#bayar<?= $row["id_tiket"] ?>">
                                        <i class="mdi mdi-cash-multiple"></i> Cek Bayar
                                      </button>
                                      <div class="modal fade" id="bayar<?= $row["id_tiket"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                  <input type="hidden" name="id_tiket" value="<?= $row["id_tiket"] ?>">
                                                  <input type="hidden" name="nomor_telepon" value="<?= $row["nomor_telepon"] ?>">
                                                  <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                                  <button type="submit" name="ubah-tiket" class="btn btn-success btn-sm rounded-0 border-0" style="height: 30px;">Kirim</button>
                                                </div>
                                              </form>
                                            <?php } else if ($row['status_pembayaran'] == "Diterima") { ?>
                                              <div class="modal-body text-center">
                                                Bukti pembayaran berhasil diterima dengan baik oleh petugas.
                                              </div>
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                <?php }
                                } ?>
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