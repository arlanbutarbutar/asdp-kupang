<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Pelabuhan";
$_SESSION["page-url"] = "pelabuhan";
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
                          <th scope="col" class="text-center">Pelabuhan</th>
                          <th scope="col" class="text-center">Kota</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_pelabuhan) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_pelabuhan)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td>
                                <div class="d-flex ">
                                  <img src="<?= $row['img_pelabuhan'] ?>" alt="<?= $row['nama_pelabuhan'] ?>">
                                  <div>
                                    <h6 style="margin-left: 10px;"><?= $row['nama_pelabuhan'] ?></h6>
                                  </div>
                                </div>
                              </td>
                              <td><?= $row['kota'] ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $row["nama_pelabuhan"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="avatar" class="form-label">Gambar Pelabuhan <small class="text-danger">*</small></label>
                                              <input type="file" name="avatar" class="form-control text-center" id="avatar" placeholder="Gambar Pelabuhan">
                                            </div>
                                            <div class="mb-3">
                                              <label for="nama_pelabuhan" class="form-label">Nama Pelabuhan <small class="text-danger">*</small></label>
                                              <input type="text" name="nama_pelabuhan" value="<?php if (isset($_POST['nama_pelabuhan'])) {
                                                                                                echo $_POST['nama_pelabuhan'];
                                                                                              } else {
                                                                                                echo $row['nama_pelabuhan'];
                                                                                              } ?>" class="form-control text-center" id="nama_pelabuhan" minlength="3" placeholder="Nama Pelabuhan" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="kota" class="form-label">Kota <small class="text-danger">*</small></label>
                                              <input type="text" name="kota" value="<?php if (isset($_POST['kota'])) {
                                                                                      echo $_POST['kota'];
                                                                                    } else {
                                                                                      echo $row['kota'];
                                                                                    } ?>" class="form-control text-center" id="kota" minlength="3" placeholder="Kota" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <input type="hidden" name="nama_pelabuhanOld" value="<?= $row["nama_pelabuhan"] ?>">
                                            <input type="hidden" name="avatarOld" value="<?= $row["img_pelabuhan"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-pelabuhan" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row["nama_pelabuhan"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus <?= $row["nama_pelabuhan"] ?> ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <input type="hidden" name="avatarOld" value="<?= $row["img_pelabuhan"] ?>">
                                            <button type="submit" name="hapus-pelabuhan" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pelabuhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="avatar" class="form-label">Gambar Pelabuhan <small class="text-danger">*</small></label>
                    <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                              echo $_POST['avatar'];
                                                            } ?>" class="form-control text-center" id="avatar" placeholder="Gambar Pelabuhan" required>
                  </div>
                  <div class="mb-3">
                    <label for="nama_pelabuhan" class="form-label">Nama Pelabuhan <small class="text-danger">*</small></label>
                    <input type="text" name="nama_pelabuhan" value="<?php if (isset($_POST['nama_pelabuhan'])) {
                                                                      echo $_POST['nama_pelabuhan'];
                                                                    } ?>" class="form-control text-center" id="nama_pelabuhan" minlength="3" placeholder="Nama Pelabuhan" required>
                  </div>
                  <div class="mb-3">
                    <label for="kota" class="form-label">Kota <small class="text-danger">*</small></label>
                    <input type="text" name="kota" value="<?php if (isset($_POST['kota'])) {
                                                            echo $_POST['kota'];
                                                          } ?>" class="form-control text-center" id="kota" minlength="3" placeholder="Kota" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-pelabuhan" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>