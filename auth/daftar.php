<?php require_once("../controller/script.php");
if (isset($_SESSION["data-user"])) {
  header("Location: ../views/");
  exit();
}
$_SESSION["page-name"] = "Daftar";
$_SESSION["page-url"] = "daftar";
?>
<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/auth-header.php") ?></head>

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
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5 shadow">
              <img src="../assets/images/logo-asdp.png" style="width: 300px;margin-bottom: 10px;" alt="Logo ASDP Kupang">
              <h6 class="fw-light">Daftarkan akun kamu</h6>
              <form class="pt-3" action="" method="POST">
                <div class="form-group mt-3">
                  <label for="nama">Username <span class="text-danger">*</span></label>
                  <input type="text" name="nama" value="<?php if (isset($_POST['nama'])) {
                                                          echo $_POST['nama'];
                                                        } ?>" id="nama" class="form-control text-center" placeholder="Username" min="3" required>
                </div>
                <div class="form-group">
                  <label for="nomor_telepon">No. Handphone <span class="text-danger">*</span></label>
                  <input type="number" name="nomor_telepon" value="<?php if (isset($_POST['nomor_telepon'])) {
                                                                      echo $_POST['nomor_telepon'];
                                                                    } ?>" id="nomor_telepon" class="form-control text-center" placeholder="No. Handphone" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4||3}" required>
                </div>
                <div class="form-group">
                  <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                  <input type="password" name="password" id="password" class="form-control text-center" placeholder="Kata Sandi" required>
                </div>
                <div class="form-group">
                  <label for="re_password">Ulangi Sandi <span class="text-danger">*</span></label>
                  <input type="password" name="re_password" id="re_password" class="form-control text-center" placeholder="Ulangi Sandi" required>
                </div>
                <div class="mt-3">
                  <button type="submit" name="daftar" class="btn rounded-0 text-white" style="background-color: rgb(3, 164, 237);">Daftar</button>
                </div>
              </form>
              <hr style="width: 40%;">
              <p style="margin: -9% 45% 0 45%;">Atau</p>
              <hr style="width: 40%;margin: -2.6% 60% 0 60%;">
              <p class="d-flex flex-nowrap justify-content-center mt-3">Sudah punya akun? <a href="./" class="text-decoration-none" style="margin: 0 5px;">Masuk</a> sekarang</p>
              <p class="d-flex flex-nowrap justify-content-center mt-3">Kembali ke <a href="../" class="text-decoration-none" style="margin-left: 5px;">Beranda</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("../resources/auth-footer.php") ?>
</body>

</html>