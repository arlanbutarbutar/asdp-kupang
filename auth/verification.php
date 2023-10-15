<?php require_once("../controller/script.php");
if (isset($_SESSION["data-user"])) {
  header("Location: ../views/");
  exit();
}
$_SESSION["page-name"] = "Verifikasi";
$_SESSION["page-url"] = "verification";

if (isset($_GET['en'])) {
  if (!empty($_GET['en'])) {
    $en = valid($conn, $_GET['en']);
    $verify = mysqli_query($conn, "SELECT * FROM users WHERE en_user='$en'");
    if (mysqli_num_rows($verify) > 0) {
      $row = mysqli_fetch_assoc($verify);
      mysqli_query($conn, "UPDATE users SET id_status='1' WHERE en_user='$en'");
    }
  }
}
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
              <h2 class="fw-light mb-3 font-weight-bold">Verifikasi akun kamu</h3>
                <?php if (!isset($_GET['en'])) { ?>
                  <p style="font-size: 16px;">Akun anda telah terdaftar, silakan cek whatsapp anda untuk memverifikasi akun</p>
                  <?php } else {
                  if (empty($_GET['en'])) { ?>
                    <p style="font-size: 16px;">Akun anda telah terdaftar, silakan cek whatsapp anda untuk memverifikasi akun</p>
                  <?php } else { ?>
                    <p style="font-size: 16px;">Akun anda diverifikasi, silakan masukan password anda dan masuk ke halaman dashboard anda untuk melanjutkan pembayaran</p>
                    <form action="" method="post">
                      <div class="form-group">
                        <label for="nomor_telepon">No. HP <span class="text-danger">*</span></label>
                        <input type="number" name="nomor_telepon" value="<?= $row['nomor_telepon'] ?>" id="nomor_telepon" class="form-control text-center" placeholder="No. HP" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4||3}" required>
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
                        <button type="submit" name="verifikasi" class="btn rounded-0 text-white" style="background-color: rgb(3, 164, 237);">Submit</button>
                      </div>
                    </form>
                <?php }
                } ?>
                <p class="d-flex flex-nowrap justify-content-center mt-3">Kembali ke <a href="./" class="text-decoration-none" style="margin-left: 5px;">Beranda</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("../resources/auth-footer.php") ?>
</body>

</html>