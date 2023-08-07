<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Pelayaran";
$_SESSION["page-url"] = "pelayaran";
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
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-primary text-white me-0 btn-sm rounded-0" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</a>
                    </div>
                  </div>
                </div>
                <div class="card rounded-0 mt-3">
                  <div class="card-body table-responsive">
                    <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">#</th>
                          <th scope="col" class="text-center">Nama Kapal</th>
                          <th scope="col" class="text-center">Lintasan</th>
                          <th scope="col" class="text-center">Jadwal</th>
                          <th scope="col" class="text-center">Penumpang</th>
                          <th scope="col" class="text-center">Golongan</th>
                          <th scope="col" class="text-center">Kendaraan</th>
                          <th scope="col" class="text-center">Harga</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_pelayaran) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_pelayaran)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td><?= $row["nama_kapal"] ?></td>
                              <td><?= $row["pelabuhan_asal"] . " - " . $row["pelabuhan_tujuan"] ?></td>
                              <td><?php $tgl = date_create($row["tanggal_berangkat"]);
                                  echo date_format($tgl, "d M Y") . " - " . $row['jam_berangkat']; ?></td>
                              <td><?= $row["penumpang"] ?></td>
                              <td><?= $row["golongan"] ?></td>
                              <td><?= $row["kendaraan"] ?></td>
                              <td>Rp. <?= number_format($row["harga"]) ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_pelayaran"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id_pelayaran"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah Pelayaran</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="id_jadwal" class="form-label">Jadwal <small class="text-danger">*</small></label>
                                              <select name="id_jadwal" id="id_jadwal" class="form-select" aria-label="Default select example" required>
                                                <option selected value="<?= $row['id_jadwal'] ?>"><?php $tgl = date_create($row["tanggal_berangkat"]);
                                                                                                  echo $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] . " (" . date_format($tgl, "d M Y") . " - " . $row['jam_berangkat'] . ")"; ?></option>
                                                <?php $id_jadwal = $row['id_jadwal'];
                                                $select_jadwal = "SELECT * FROM jadwal JOIN rute ON jadwal.id_rute=rute.id_rute WHERE id_jadwal!='$id_jadwal'";
                                                $selectJadwal = mysqli_query($conn, $select_jadwal);
                                                foreach ($selectJadwal as $row_jadwal) { ?>
                                                  <option value="<?= $row_jadwal['id_jadwal'] ?>"><?php $tgl = date_create($row_jadwal["tanggal_berangkat"]);
                                                                                                  echo $row_jadwal['pelabuhan_asal'] . ' - ' . $row_jadwal['pelabuhan_tujuan'] . " (" . date_format($tgl, "d M Y") . " - " . $row_jadwal['jam_berangkat'] . ")"; ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="penumpang" class="form-label">Penumpang <small class="text-danger">*</small></label>
                                              <input type="text" name="penumpang" value="<?php if (isset($_POST['penumpang'])) {
                                                                                            echo $_POST['penumpang'];
                                                                                          } else {
                                                                                            echo $row['penumpang'];
                                                                                          } ?>" class="form-control text-center" id="penumpang" placeholder="Penumpang" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="golongan" class="form-label">Golongan</label>
                                              <input type="text" name="golongan" value="<?php if (isset($_POST['golongan'])) {
                                                                                          echo $_POST['golongan'];
                                                                                        } else {
                                                                                          echo $row['golongan'];
                                                                                        } ?>" class="form-control text-center" id="golongan" placeholder="Golongan">
                                            </div>
                                            <div class="mb-3">
                                              <label for="kendaraan" class="form-label">Kendaraan</label>
                                              <input type="text" name="kendaraan" value="<?php if (isset($_POST['kendaraan'])) {
                                                                                            echo $_POST['kendaraan'];
                                                                                          } else {
                                                                                            echo $row['kendaraan'];
                                                                                          } ?>" class="form-control text-center" id="kendaraan" placeholder="Kendaraan">
                                            </div>
                                            <div class="mb-3">
                                              <label for="harga" class="form-label">Harga <small class="text-danger">*</small></label>
                                              <input type="number" name="harga" value="<?php if (isset($_POST['harga'])) {
                                                                                          echo $_POST['harga'];
                                                                                        } else {
                                                                                          echo $row['harga'];
                                                                                        } ?>" class="form-control text-center" id="harga" placeholder="Harga" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id_pelayaran" value="<?= $row["id_pelayaran"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-pelayaran" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_pelayaran"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id_pelayaran"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus Pelayaran</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus pelayaran ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id_pelayaran" value="<?= $row["id_pelayaran"] ?>">
                                            <button type="submit" name="hapus-pelayaran" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
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

        <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header border-bottom-0 shadow">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pelayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="id_jadwal" class="form-label">Jadwal <small class="text-danger">*</small></label>
                    <select name="id_jadwal" id="id_jadwal" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Jadwal</option>
                      <?php foreach ($view_jadwal as $row_jadwal) { ?>
                        <option value="<?= $row_jadwal['id_jadwal'] ?>"><?php $tgl = date_create($row_jadwal["tanggal_berangkat"]);
                                                                        echo $row_jadwal['pelabuhan_asal'] . ' - ' . $row_jadwal['pelabuhan_tujuan'] . " (" . date_format($tgl, "d M Y") . " - " . $row_jadwal['jam_berangkat'] . ")"; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="penumpang" class="form-label">Penumpang <small class="text-danger">*</small></label>
                    <input type="text" name="penumpang" value="<?php if (isset($_POST['penumpang'])) {
                                                                  echo $_POST['penumpang'];
                                                                } ?>" class="form-control text-center" id="penumpang" placeholder="Penumpang" required>
                  </div>
                  <div class="mb-3">
                    <label for="golongan" class="form-label">Golongan</label>
                    <input type="text" name="golongan" value="<?php if (isset($_POST['golongan'])) {
                                                                echo $_POST['golongan'];
                                                              } ?>" class="form-control text-center" id="golongan" placeholder="Golongan">
                  </div>
                  <div class="mb-3">
                    <label for="kendaraan" class="form-label">Kendaraan</label>
                    <input type="text" name="kendaraan" value="<?php if (isset($_POST['kendaraan'])) {
                                                                  echo $_POST['kendaraan'];
                                                                } ?>" class="form-control text-center" id="kendaraan" placeholder="Kendaraan">
                  </div>
                  <div class="mb-3">
                    <label for="harga" class="form-label">Harga <small class="text-danger">*</small></label>
                    <input type="number" name="harga" value="<?php if (isset($_POST['harga'])) {
                                                                echo $_POST['harga'];
                                                              } ?>" class="form-control text-center" id="harga" placeholder="Harga" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-pelayaran" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>