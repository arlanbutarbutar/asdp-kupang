<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Jadwal";
$_SESSION["page-url"] = "jadwal";
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
                          <th scope="col" class="text-center">Pelabuhan Asal</th>
                          <th scope="col" class="text-center">Pelabuhan Tujuan</th>
                          <th scope="col" class="text-center">Tgl Berangkat</th>
                          <th scope="col" class="text-center">Jam Berangkat</th>
                          <th scope="col" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (mysqli_num_rows($view_jadwal) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($view_jadwal)) { ?>
                            <tr>
                              <th scope="row" class="text-center"><?= $no; ?></th>
                              <td><?= $row["nama_kapal"] ?></td>
                              <td><?= $row["pelabuhan_asal"] ?></td>
                              <td><?= $row["pelabuhan_tujuan"] ?></td>
                              <td><?php $tgl_berangkat = date_create($row["tanggal_berangkat"]);
                                  echo date_format($tgl_berangkat, "d M Y"); ?></td>
                              <td><?= $row["jam_berangkat"] ?></td>
                              <td class="d-flex justify-content-center">
                                <div class="col">
                                  <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_jadwal"] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row["id_jadwal"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah Jadwal</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                          <div class="modal-body text-center">
                                            <div class="mb-3">
                                              <label for="id_kapal" class="form-label">Kapal <small class="text-danger">*</small></label>
                                              <select name="id_kapal" id="id_kapal" class="form-select" aria-label="Default select example" required>
                                                <option selected value="<?= $row['id_kapal'] ?>"><?= $row['nama_kapal'] ?></option>
                                                <?php $id_kapal = $row['id_kapal'];
                                                $select_kapal = "SELECT * FROM kapal WHERE id_kapal!='$id_kapal'";
                                                $selectKapal = mysqli_query($conn, $select_kapal);
                                                foreach ($selectKapal as $row_kapal) { ?>
                                                  <option value="<?= $row_kapal['id_kapal'] ?>"><?= $row_kapal['nama_kapal'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="id_rute" class="form-label">Rute <small class="text-danger">*</small></label>
                                              <select name="id_rute" id="id_rute" class="form-select" aria-label="Default select example" required>
                                                <option selected value="<?= $row['id_rute'] ?>"><?= $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] ?></option>
                                                <?php $id_rute = $row['id_rute'];
                                                $select_rute = "SELECT * FROM rute WHERE id_rute!='$id_rute'";
                                                $selectRute = mysqli_query($conn, $select_rute);
                                                foreach ($selectRute as $row_rute) { ?>
                                                  <option value="<?= $row_rute['id_rute'] ?>"><?= $row_rute['pelabuhan_asal'] . ' - ' . $row_rute['pelabuhan_tujuan'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="tanggal_berangkat" class="form-label">Tgl Berangkat <small class="text-danger">*</small></label>
                                              <input type="date" name="tanggal_berangkat" value="<?php if (isset($_POST['tanggal_berangkat'])) {
                                                                                                    echo $_POST['tanggal_berangkat'];
                                                                                                  } else {
                                                                                                    echo $row['tanggal_berangkat'];
                                                                                                  } ?>" class="form-control text-center" id="tanggal_berangkat" placeholder="Tgl Berangkat" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="jam_berangkat" class="form-label">Jam Berangkat <small class="text-danger">*</small></label>
                                              <input type="time" name="jam_berangkat" value="<?php if (isset($_POST['jam_berangkat'])) {
                                                                                                echo $_POST['jam_berangkat'];
                                                                                              } else {
                                                                                                echo $row['jam_berangkat'];
                                                                                              } ?>" class="form-control text-center" id="jam_berangkat" placeholder="Jam Berangkat" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <input type="hidden" name="id_jadwal" value="<?= $row["id_jadwal"] ?>">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-jadwal" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_jadwal"] ?>">
                                    <i class="bi bi-trash3"></i>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row["id_jadwal"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header border-bottom-0 shadow">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus Jadwal</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus jadwal <strong><?= $row['nama_kapal'] . '</strong> tujuan <strong>' . $row['pelabuhan_asal'] . ' - ' . $row['pelabuhan_tujuan'] ?></strong> ini?
                                        </div>
                                        <div class="modal-footer justify-content-center border-top-0">
                                          <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                          <form action="" method="POST">
                                            <input type="hidden" name="id_jadwal" value="<?= $row["id_jadwal"] ?>">
                                            <button type="submit" name="hapus-jadwal" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="id_kapal" class="form-label">Kapal <small class="text-danger">*</small></label>
                    <select name="id_kapal" id="id_kapal" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Kapal</option>
                      <?php $select_kapal = "SELECT * FROM kapal";
                      $selectKapal = mysqli_query($conn, $select_kapal);
                      foreach ($selectKapal as $row_kapal) { ?>
                        <option value="<?= $row_kapal['id_kapal'] ?>"><?= $row_kapal['nama_kapal'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="id_rute" class="form-label">Rute <small class="text-danger">*</small></label>
                    <select name="id_rute" id="id_rute" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Rute</option>
                      <?php $select_rute = "SELECT * FROM rute";
                      $selectRute = mysqli_query($conn, $select_rute);
                      foreach ($selectRute as $row_rute) { ?>
                        <option value="<?= $row_rute['id_rute'] ?>"><?= $row_rute['pelabuhan_asal'] . ' - ' . $row_rute['pelabuhan_tujuan'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="tanggal_berangkat" class="form-label">Tgl Berangkat <small class="text-danger">*</small></label>
                    <input type="date" name="tanggal_berangkat" value="<?php if (isset($_POST['tanggal_berangkat'])) {
                                                                          echo $_POST['tanggal_berangkat'];
                                                                        } ?>" class="form-control text-center" id="tanggal_berangkat" placeholder="Tgl Berangkat" required>
                  </div>
                  <div class="mb-3">
                    <label for="jam_berangkat" class="form-label">Jam Berangkat <small class="text-danger">*</small></label>
                    <input type="time" name="jam_berangkat" value="<?php if (isset($_POST['jam_berangkat'])) {
                                                                      echo $_POST['jam_berangkat'];
                                                                    } ?>" class="form-control text-center" id="jam_berangkat" placeholder="Jam Berangkat" required>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-jadwal" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>