<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Rute";
$_SESSION["page-url"] = "rute";
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
                          <th scope="col" class="text-center">Cabang</th>
                          <th scope="col" class="text-center">Pelabuhan Asal</th>
                          <th scope="col" class="text-center">Pelabuhan Tujuan</th>
                          <th scope="col" class="text-center">Jarak</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_rute) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_rute)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td><?= $row["cabang"] ?></td>
                              <td><?= $row["pelabuhan_asal"] ?></td>
                              <td><?= $row["pelabuhan_tujuan"] ?></td>
                              <td class="text-center"><?= $row["jarak"] ?> km</td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_rute"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id_rute"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah Rute</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="cabang" class="form-label">Cabang (Kota) <small class="text-danger">*</small></label>
                                              <input type="text" name="cabang" value="<?php if (isset($_POST['cabang'])) {
                                                                                        echo $_POST['cabang'];
                                                                                      } else {
                                                                                        echo $row['cabang'];
                                                                                      } ?>" class="form-control text-center" id="cabang" minlength="3" placeholder="Cabang (Kota)" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="pelabuhan_asal" class="form-label">Pelabuhan Asal <small class="text-danger">*</small></label>
                                              <select name="pelabuhan_asal" id="pelabuhan_asal" class="form-select" aria-label="Default select example" required>
                                                <option selected value="<?= $row['pelabuhan_asal'] ?>"><?= $row['pelabuhan_asal'] ?></option>
                                                <?php foreach ($selectPelabuhanAsal as $row_spa) { ?>
                                                  <option value="<?= $row_spa['nama_pelabuhan'] ?>"><?= $row_spa['nama_pelabuhan'] . ' - Kota ' . $row_spa['kota'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="pelabuhan_tujuan" class="form-label">Pelabuhan Tujuan <small class="text-danger">*</small></label>
                                              <select name="pelabuhan_tujuan" id="pelabuhan_tujuan" class="form-select" aria-label="Default select example" required>
                                                <option selected value="<?= $row['pelabuhan_tujuan'] ?>"><?= $row['pelabuhan_tujuan'] ?></option>
                                                <?php foreach ($selectPelabuhanTujuan as $row_spt) { ?>
                                                  <option value="<?= $row_spt['nama_pelabuhan'] ?>"><?= $row_spt['nama_pelabuhan'] . ' - Kota ' . $row_spt['kota'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="jarak" class="form-label">Jarak <small class="text-danger">*</small></label>
                                              <input type="number" name="jarak" value="<?php if (isset($_POST['jarak'])) {
                                                                                          echo $_POST['jarak'];
                                                                                        } else {
                                                                                          echo $row['jarak'];
                                                                                        } ?>" class="form-control text-center" id="jarak" placeholder="Jarak" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id_rute" value="<?= $row["id_rute"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-rute" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_rute"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id_rute"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus Rute</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus rute <strong><?= $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] ?></strong> ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id_rute" value="<?= $row["id_rute"] ?>">
                                            <button type="submit" name="hapus-rute" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Rute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="cabang" class="form-label">Cabang (Kota) <small class="text-danger">*</small></label>
                    <input type="text" name="cabang" value="<?php if (isset($_POST['cabang'])) {
                                                              echo $_POST['cabang'];
                                                            } ?>" class="form-control text-center" id="cabang" minlength="3" placeholder="Cabang (Kota)" required>
                  </div>
                  <div class="mb-3">
                    <label for="pelabuhan_asal" class="form-label">Pelabuhan Asal <small class="text-danger">*</small></label>
                    <select name="pelabuhan_asal" id="pelabuhan_asal" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Pelabuhan Asal</option>
                      <?php foreach ($selectPelabuhanAsal as $row_spa) { ?>
                        <option value="<?= $row_spa['nama_pelabuhan'] ?>"><?= $row_spa['nama_pelabuhan'] . ' - Kota ' . $row_spa['kota'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="pelabuhan_tujuan" class="form-label">Pelabuhan Tujuan <small class="text-danger">*</small></label>
                    <select name="pelabuhan_tujuan" id="pelabuhan_tujuan" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Pelabuhan Tujuan</option>
                      <?php foreach ($selectPelabuhanTujuan as $row_spt) { ?>
                        <option value="<?= $row_spt['nama_pelabuhan'] ?>"><?= $row_spt['nama_pelabuhan'] . ' - Kota ' . $row_spt['kota'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="jarak" class="form-label">Jarak <small class="text-danger">*</small></label>
                    <input type="number" name="jarak" value="<?php if (isset($_POST['jarak'])) {
                                                                echo $_POST['jarak'];
                                                              } ?>" class="form-control text-center" id="jarak" placeholder="Jarak" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-rute" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>