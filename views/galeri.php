<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Galeri";
$_SESSION["page-url"] = "galeri";
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
                  <div class="card-body">
                    <!--begin::Action-->
                    <div class="p-5 text-center" id="drop-area">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="avatar">Seret dan Lepas di sini:</label>
                          <input type="file" class="form-control-file d-none" id="avatar" name="avatar[]" multiple>
                        </div>
                        <div class="form-group shadow mb-5" style="height: 200px;">
                          <div id="fileList"></div>
                        </div>
                        <button type="submit" name="tambah-galeri" class="btn btn-primary text-white border-0 rounded-0">Upload</button>
                      </form>
                    </div>
                    <!--end::Action-->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <?php if (mysqli_num_rows($view_galeri) > 0) {
              while ($row = mysqli_fetch_assoc($view_galeri)) { ?>
                <div class="col-lg-3 mt-3">
                  <!--begin::Card body-->
                  <div class="card-body border-0 rounded-0 p-0 bg-transparent">
                    <!--begin::Images content-->
                    <div class="d-flex flex-wrap justify-content-between">
                      <form action="" method="post">
                        <img src="<?= $row['slug_image'] ?>" class="img-thumbnail m-2" style="width: 100%;height: 300px;object-fit: cover;" alt="">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="avatarOld" value="<?= $row['slug_image'] ?>">
                        <button type="submit" name="hapus-galeri" class="btn btn-danger btn-sm" style="margin-left: -60px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;"><i class="bi bi-trash3"></i></button>
                      </form>
                    </div>
                    <!--end::Images content-->
                  </div>
                </div>
            <?php }
            } ?>
          </div>

          <?php require_once("../resources/dash-footer.php") ?>
          <script>
            const dropArea = document.querySelector("#drop-area");
            const input = document.querySelector("#avatar");

            dropArea.addEventListener("dragover", function(e) {
              e.preventDefault();
            });

            dropArea.addEventListener("drop", function(e) {
              e.preventDefault();
              input.files = e.dataTransfer.files;

              var files = input.files,
                filesLength = files.length;
              for (var i = 0; i < filesLength; i++) {
                var file = files[i];
                var fileName = file.name;
                var list = document.createElement("li");
                list.innerHTML = fileName;
                document.querySelector("#fileList").appendChild(list);
              }
            });

            input.addEventListener("change", function(e) {
              var files = e.target.files,
                filesLength = files.length;
              for (var i = 0; i < filesLength; i++) {
                var file = files[i];
                var fileName = file.name;
                var list = document.createElement("li");
                list.innerHTML = fileName;
                document.querySelector("#fileList").appendChild(list);
              }
            });
          </script>
</body>

</html>