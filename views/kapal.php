<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Kapal";
$_SESSION["page-url"] = "kapal";
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
                          <th scope="col" class="text-center">Kapasitas</th>
                          <th scope="col" class="text-center">Jenis Kapal</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_kapal) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_kapal)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td>
                                <div class="d-flex ">
                                  <img src="<?= $row['img_kapal'] ?>" alt="<?= $row['nama_kapal'] ?>">
                                  <div class="m-auto">
                                    <h6 style="margin-left: 10px;"><?= $row['nama_kapal'] ?></h6>
                                  </div>
                                </div>
                              </td>
                              <td><?= $row["kapasitas"] ?></td>
                              <td><?= $row["jenis_kapal"] ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_kapal"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id_kapal"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $row["nama_kapal"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="avatar" class="form-label">Gambar Kapal <small class="text-danger">*</small></label>
                                              <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                                                        echo $_POST['avatar'];
                                                                                      } ?>" class="form-control text-center" id="avatar" placeholder="Gambar Kapal">
                                            </div>
                                            <div class="mb-3">
                                              <label for="nama_kapal" class="form-label">Nama Kapal <small class="text-danger">*</small></label>
                                              <input type="text" name="nama_kapal" value="<?php if (isset($_POST['nama_kapal'])) {
                                                                                            echo $_POST['nama_kapal'];
                                                                                          } else {
                                                                                            echo $row['nama_kapal'];
                                                                                          } ?>" class="form-control text-center" id="nama_kapal" minlength="3" placeholder="Nama Kapal" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="kapasitas" class="form-label">Kapasitas <small class="text-danger">*</small></label>
                                              <input type="number" name="kapasitas" value="<?php if (isset($_POST['kapasitas'])) {
                                                                                              echo $_POST['kapasitas'];
                                                                                            } else {
                                                                                              echo $row['kapasitas'];
                                                                                            } ?>" class="form-control text-center" id="kapasitas" placeholder="Kapasitas" step="1" min="1" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="jenis_kapal" class="form-label">Jenis Kapal <small class="text-danger">*</small></label>
                                              <input type="text" name="jenis_kapal" value="<?php if (isset($_POST['jenis_kapal'])) {
                                                                                              echo $_POST['jenis_kapal'];
                                                                                            } else {
                                                                                              echo $row['jenis_kapal'];
                                                                                            } ?>" class="form-control text-center" id="jenis_kapal" placeholder="Jenis Kapal" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id_kapal" value="<?= $row["id_kapal"] ?>">
                                            <input type="hidden" name="nama_kapalOld" value="<?= $row["nama_kapal"] ?>">
                                            <input type="hidden" name="avatarOld" value="<?= $row["img_kapal"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-kapal" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_kapal"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id_kapal"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row["nama_kapal"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus <?= $row["nama_kapal"] ?> ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id_kapal" value="<?= $row["id_kapal"] ?>">
                                            <input type="hidden" name="avatarOld" value="<?= $row["img_kapal"] ?>">
                                            <button type="submit" name="hapus-kapal" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kapal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="avatar" class="form-label">Gambar Kapal <small class="text-danger">*</small></label>
                    <input type="file" name="avatar" value="<?php if (isset($_POST['avatar'])) {
                                                              echo $_POST['avatar'];
                                                            } ?>" class="form-control text-center" id="avatar" placeholder="Gambar Kapal" required>
                  </div>
                  <div class="mb-3">
                    <label for="nama_kapal" class="form-label">Nama Kapal <small class="text-danger">*</small></label>
                    <input type="text" name="nama_kapal" value="<?php if (isset($_POST['nama_kapal'])) {
                                                                  echo $_POST['nama_kapal'];
                                                                } ?>" class="form-control text-center" id="nama_kapal" minlength="3" placeholder="Nama Kapal" required>
                  </div>
                  <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas <small class="text-danger">*</small></label>
                    <input type="number" name="kapasitas" value="<?php if (isset($_POST['kapasitas'])) {
                                                                    echo $_POST['kapasitas'];
                                                                  } ?>" class="form-control text-center" id="kapasitas" placeholder="Kapasitas" step="1" min="1" required>
                  </div>
                  <div class="mb-3">
                    <label for="jenis_kapal" class="form-label">Jenis Kapal <small class="text-danger">*</small></label>
                    <input type="text" name="jenis_kapal" value="<?php if (isset($_POST['jenis_kapal'])) {
                                                                    echo $_POST['jenis_kapal'];
                                                                  } ?>" class="form-control text-center" id="jenis_kapal" placeholder="Jenis Kapal" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-kapal" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>