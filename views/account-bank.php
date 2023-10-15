<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Account Bank";
$_SESSION["page-url"] = "account-bank";
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
                          <th scope="col" class="text-center">A/N</th>
                          <th scope="col" class="text-center">Bank</th>
                          <th scope="col" class="text-center">Norek</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_account_bank) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_account_bank)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td><?= $row['an'] ?></td>
                              <td><?= $row['bank'] ?></td>
                              <td><?= $row['norek'] ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $row["bank"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="an" class="form-label">Atas Nama (A/N) <small class="text-danger">*</small></label>
                                              <input type="text" name="an" value="<?php if (isset($_POST['an'])) {
                                                                                    echo $_POST['an'];
                                                                                  } else {
                                                                                    echo $row['an'];
                                                                                  } ?>" class="form-control text-center" id="an" minlength="3" placeholder="Atas Nama" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="bank" class="form-label">Bank <small class="text-danger">*</small></label>
                                              <input type="text" name="bank" value="<?php if (isset($_POST['bank'])) {
                                                                                      echo $_POST['bank'];
                                                                                    } else {
                                                                                      echo $row['bank'];
                                                                                    } ?>" class="form-control text-center" id="bank" maxlength="10" placeholder="Bank" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="norek" class="form-label">Nomor Rekening <small class="text-danger">*</small></label>
                                              <input type="number" name="norek" value="<?php if (isset($_POST['norek'])) {
                                                                                          echo $_POST['norek'];
                                                                                        } else {
                                                                                          echo $row['norek'];
                                                                                        } ?>" class="form-control text-center" id="norek" minlength="6" placeholder="Nomor Rekening" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <input type="hidden" name="bankOld" value="<?= $row["bank"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-account-bank" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
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
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row["bank"] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <button type="submit" name="hapus-account-bank" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Account Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="an" class="form-label">Atas Nama (A/N) <small class="text-danger">*</small></label>
                    <input type="text" name="an" value="<?php if (isset($_POST['an'])) {
                                                          echo $_POST['an'];
                                                        } ?>" class="form-control text-center" id="an" minlength="3" placeholder="Atas Nama" required>
                  </div>
                  <div class="mb-3">
                    <label for="bank" class="form-label">Bank <small class="text-danger">*</small></label>
                    <input type="text" name="bank" value="<?php if (isset($_POST['bank'])) {
                                                            echo $_POST['bank'];
                                                          } ?>" class="form-control text-center" id="bank" maxlength="10" placeholder="Bank" required>
                  </div>
                  <div class="mb-3">
                    <label for="norek" class="form-label">Nomor Rekening <small class="text-danger">*</small></label>
                    <input type="number" name="norek" value="<?php if (isset($_POST['norek'])) {
                                                                echo $_POST['norek'];
                                                              } ?>" class="form-control text-center" id="norek" minlength="6" placeholder="Nomor Rekening" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-account-bank" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>