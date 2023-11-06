<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Golongan";
$_SESSION["page-url"] = "golongan";
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
                          <th scope="col" class="text-center">Nama Golongan</th>
                          <th scope="col" class="text-center">Harga</th>
                          <th scope="col" class="text-center">Keterangan</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_golongan) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_golongan)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td><?= $row['nama_golongan'] ?></td>
                              <td>Rp. <?= number_format($row['harga_golongan']) ?></td>
                              <td><?= $row['keterangan'] ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_golongan"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id_golongan"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $row["nama_golongan"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="nama_golongan" class="form-label">Nama Golongan <small class="text-danger">*</small></label>
                                              <input type="text" name="nama_golongan" value="<?php if (isset($_POST['nama_golongan'])) {
                                                                                                echo $_POST['nama_golongan'];
                                                                                              } else {
                                                                                                echo $row['nama_golongan'];
                                                                                              } ?>" class="form-control text-center" id="nama_golongan" minlength="3" placeholder="Nama Golongan" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="harga_golongan" class="form-label">Harga <small class="text-danger">*</small></label>
                                              <input type="number" name="harga_golongan" value="<?php if (isset($_POST['harga_golongan'])) {
                                                                                                  echo $_POST['harga_golongan'];
                                                                                                } else {
                                                                                                  echo $row['harga_golongan'];
                                                                                                } ?>" class="form-control text-center" id="harga_golongan" placeholder="Harga" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="keterangan" class="form-label">Keterangan <small class="text-danger">*</small></label>
                                              <textarea name="keterangan" class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: 100px;"><?php if (isset($_POST['keterangan'])) {
                                                                                                                                            echo $_POST['keterangan'];
                                                                                                                                          } else {
                                                                                                                                            echo $row['keterangan'];
                                                                                                                                          } ?></textarea>
                                            </div>
                                            <div class="modal-footer justify-content-center border-top-0">
                                              <input type="hidden" name="id_golongan" value="<?= $row["id_golongan"] ?>">
                                              <input type="hidden" name="nama_golonganOld" value="<?= $row["nama_golongan"] ?>">
                                              <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                              <button type="submit" name="ubah-golongan" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_golongan"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id_golongan"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row["nama_golongan"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id_golongan" value="<?= $row["id_golongan"] ?>">
                                            <button type="submit" name="hapus-golongan" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Golongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="nama_golongan" class="form-label">Nama Golongan <small class="text-danger">*</small></label>
                    <input type="text" name="nama_golongan" value="<?php if (isset($_POST['nama_golongan'])) {
                                                                      echo $_POST['nama_golongan'];
                                                                    } ?>" class="form-control text-center" id="nama_golongan" minlength="3" placeholder="Nama Golongan" required>
                  </div>
                  <div class="mb-3">
                    <label for="harga_golongan" class="form-label">Harga <small class="text-danger">*</small></label>
                    <input type="number" name="harga_golongan" value="<?php if (isset($_POST['harga_golongan'])) {
                                                                        echo $_POST['harga_golongan'];
                                                                      } ?>" class="form-control text-center" id="harga_golongan" placeholder="Harga" required>
                  </div>
                  <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan <small class="text-danger">*</small></label>
                    <textarea name="keterangan" class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: 100px;"><?php if (isset($_POST['keterangan'])) {
                                                                                                                  echo $_POST['keterangan'];
                                                                                                                } ?></textarea>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-golongan" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>