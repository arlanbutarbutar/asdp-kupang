<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Tiket";
$_SESSION["page-url"] = "tiket";
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
                  <?php if ($role == 3) { ?>
                    <h6 class="p-3 w-75" style="line-height: 20px;"><span class="badge badge-warning">Peringatan!!</span> Jika anda belum membayar sampai pada keberangkatan kapal maka tiket anda akan dianggap hangus atau tidak dapat dipakai. Silakan membayar sebelum jadwal keberangkatan atau menunggu pelayaran berikutnya!</h6>
                  <?php } ?>
                  <div class="card-body table-responsive">
                    <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">#</th>
                          <?php if ($role <= 2) { ?>
                            <th scope="col">Penumpang</th>
                          <?php } ?>
                          <th scope="col" class="text-center">Nama Kapal</th>
                          <th scope="col" class="text-center">Lintasan</th>
                          <th scope="col" class="text-center">Jadwal</th>
                          <th scope="col" class="text-center">Kelas</th>
                          <th scope="col" class="text-center">Golongan</th>
                          <?php if ($role == 3) { ?>
                            <th scope="col" class="text-center">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_tiket) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_tiket)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <?php if ($role <= 2) { ?>
                                <td>
                                  <div>
                                    <p><strong><?= $row["nama"] ?></strong></p>
                                    <p><?= $row["jenis_kelamin"] ?></p>
                                    <p><?= $row["umur"] ?></p>
                                    <p><?= $row["alamat"] ?></p>
                                  </div>
                                </td>
                              <?php } ?>
                              <td><?= $row["nama_kapal"] ?></td>
                              <td><?= $row["pelabuhan_asal"] . " - " . $row["pelabuhan_tujuan"] ?></td>
                              <td><?php $tgl = date_create($row["tanggal_berangkat"]);
                                  echo date_format($tgl, "d M Y") . " - " . $row['jam_berangkat']; ?></td>
                              <td><?= $row["nama_kelas"] ?></td>
                              <td><?= $row["nama_golongan"] ?></td>
                              <?php if ($role == 3) { ?>
                                <td class="d-flex justify-content-center">
                                  <div class="col">
                                    <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#tiket<?= $row["id_tiket"] ?>">
                                      <i class="mdi mdi-ticket"></i> Tiket
                                    </button>
                                    <div class="modal fade" id="tiket<?= $row["id_tiket"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header border-bottom-0 shadow">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <?php if ($row['qr_code'] == NULL) { ?>
                                            <div class="modal-body text-center">
                                              <textarea class="form-control border-0 bg-transparent" style="height: 100px;line-height: 25px;font-size: 16px;" readonly>Tiket anda belum dapat diberikan dikarenakan pembayaran anda saat ini sedang dalam pengecekan petugas, silakan menunggu petugas kami akan mengirimkan notifikasi melalui whatsapp untuk status pembayaran.</textarea>
                                            </div>
                                          <?php } else { ?>
                                            <div class="modal-body text-center">
                                              <div class="card mb-3">
                                                <div class="row g-0">
                                                  <div class="col-md-4">
                                                    <img src="../assets/images/qrcode/<?= $row['qr_code'] ?>" style="width: 100%;height: 100%;" class="img-fluid rounded-start rounded-0" alt="...">
                                                  </div>
                                                  <div class="col-md-8 my-auto">
                                                    <div class="card-body" style="text-align: left;">
                                                      <h1 class="card-title"><?= $row['nama_kapal'] ?></h1>
                                                      <div class="row">
                                                        <div class="col-lg-6">
                                                          <p class="card-text">Kapal: <strong><?= $row['nama_kapal'] . " " . $row['jenis_kapal'] ?></strong></p>
                                                          <p class="card-text">Penumpang: <strong><?= $row['nama'] ?></strong></p>
                                                          <p class="card-text">Kelas: <strong><?= $row['nama_kelas'] ?></strong></p>
                                                          <p class="card-text">Golongan: <strong><?= $row['nama_golongan'] ?></strong></p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                          <p class="card-text">Cabang: <strong><?= $row['cabang'] ?></strong></p>
                                                          <p class="card-text">Linsatan: <strong><?= $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] ?></strong></p>
                                                          <p class="card-text">Jarak: <strong><?= $row['jarak'] ?> km</strong></p>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                        <div class="col-lg-12">
                                                          <p class="card-text mb-3">Tgl berangkat <strong><?php $tgl_berangkat = date_create($row["tanggal_berangkat"]);
                                                                                                          echo date_format($tgl_berangkat, "d M Y") . " - " . $row['jam_berangkat']; ?></strong></p>
                                                          <span class="badge bg-warning text-dark rounded-1 font-weight-bold">Perhatian!!</span>
                                                          <textarea class="form-control border-0 rounded-0 p-0 bg-transparent mt-2" style="height: 100px;line-height: 20px;" readonly>Mohon perhatikan tanggal keberangkatan dan tunjukan QR Code kepada petugas untuk bisa masuk ke kapal.</textarea>
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
                                    </div>
                                  </div>
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