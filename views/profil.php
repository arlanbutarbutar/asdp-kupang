<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Kelola Akun Saya";
$_SESSION["page-url"] = "profil";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/dash-header.php") ?></head>

<body>
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
          <?php if (mysqli_num_rows($profile) > 0) {
            while ($row = mysqli_fetch_assoc($profile)) { ?>
              <div class="row flex-row-reverse">
                <div class="col-lg-4">
                  <div class="card rounded-0 mt-3">
                    <div class="card-body text-center">
                      <h2>Ubah Profil</h2>
                      <form action="" method="POST">
                        <?php if ($role <= 2) { ?>
                          <div class="mb-3">
                            <label for="username" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="<?php if (isset($_POST['username'])) {
                                                                        echo $_POST['username'];
                                                                      } else {
                                                                        echo $row['username'];
                                                                      } ?>" class="form-control" id="username" placeholder="Nama" required>
                          </div>
                          <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                            <input type="password" name="password" value="" class="form-control" id="password" placeholder="Kata Sandi" required>
                          </div>
                        <?php } else { ?>
                          <div class="form-group mt-3">
                            <label for="nama">Username <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="<?php if (isset($_POST['nama'])) {
                                                                    echo $_POST['nama'];
                                                                  } else {
                                                                    echo $row['nama'];
                                                                  } ?>" id="nama" class="form-control text-center" placeholder="Username" min="3" required>
                          </div>
                          <div class="form-group">
                            <label for="id_jk">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="id_jk" id="id_jk" class="form-select" aria-label="Default select example" required>
                              <option selected value="<?= $row['id_jk'] ?>"><?= $row['jenis_kelamin'] ?></option>
                              <?php $id_jk = $row['id_jk'];
                              $jk = "SELECT * FROM jk WHERE id_jk!='$id_jk'";
                              $selectJK = mysqli_query($conn, $jk);
                              foreach ($selectJK as $row_jk) { ?>
                                <option value="<?= $row_jk['id_jk'] ?>"><?= $row_jk['jenis_kelamin'] ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="umur">Umur <span class="text-danger">*</span></label>
                            <input type="number" name="umur" value="<?php if (isset($_POST['umur'])) {
                                                                      echo $_POST['umur'];
                                                                    } else {
                                                                      echo $row['umur'];
                                                                    } ?>" id="umur" class="form-control text-center" placeholder="Umur" step="1" min="1" required>
                          </div>
                          <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="alamat" value="<?php if (isset($_POST['alamat'])) {
                                                                      echo $_POST['alamat'];
                                                                    } else {
                                                                      echo $row['alamat'];
                                                                    } ?>" id="alamat" class="form-control text-center" placeholder="Alamat" required>
                          </div>
                          <div class="form-group">
                            <label for="nomor_telepon">No. Telp <span class="text-danger">*</span></label>
                            <input type="number" name="nomor_telepon" value="<?php if (isset($_POST['nomor_telepon'])) {
                                                                                echo $_POST['nomor_telepon'];
                                                                              } else {
                                                                                echo $row['nomor_telepon'];
                                                                              } ?>" id="nomor_telepon" class="form-control text-center" placeholder="No. Telp" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4||3}" required>
                          </div>
                          <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="<?php if (isset($_POST['email'])) {
                                                                      echo $_POST['email'];
                                                                    } else {
                                                                      echo $row['email'];
                                                                    } ?>" id="email" class="form-control text-center" placeholder="Email" required>
                          </div>
                          <div class="form-group">
                            <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control text-center" placeholder="Kata Sandi" required>
                          </div>
                        <?php } ?>
                        <button type="submit" name="ubah-profile" class="btn btn-primary border-0 btn-sm rounded-0">Simpan</button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card rounded-0 mt-3">
                    <div class="card-body">
                      <h2>Profil Akun</h2>
                      <div class="table-responsive">
                        <table class="table table-borderless table-sm">
                          <tbody>
                            <?php if ($role <= 2) { ?>
                              <tr>
                                <th scope="row">Nama</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["username"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Email</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["email"] ?></td>
                              </tr>
                            <?php } else { ?>
                              <tr>
                                <th scope="row">Nama</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["nama"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Jenis Kelamin</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["jenis_kelamin"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Umur</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["umur"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Alamat</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["alamat"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">No. Telp</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["nomor_telepon"] ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Email</th>
                                <td>:</td>
                                <td class="w-75"><?= $row["email"] ?></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php }
          } ?>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>