<?php if (!isset($_SESSION[""])) {
  session_start();
}
error_reporting(~E_NOTICE & ~E_DEPRECATED);
require_once("db_connect.php");
require_once("functions.php");
if (isset($_SESSION["time-message"])) {
  if ((time() - $_SESSION["time-message"]) > 2) {
    if (isset($_SESSION["message-success"])) {
      unset($_SESSION["message-success"]);
    }
    if (isset($_SESSION["message-info"])) {
      unset($_SESSION["message-info"]);
    }
    if (isset($_SESSION["message-warning"])) {
      unset($_SESSION["message-warning"]);
    }
    if (isset($_SESSION["message-danger"])) {
      unset($_SESSION["message-danger"]);
    }
    if (isset($_SESSION["message-dark"])) {
      unset($_SESSION["message-dark"]);
    }
    unset($_SESSION["time-alert"]);
  }
}

$baseURL = "http://$_SERVER[HTTP_HOST]/apps/asdp-kupang/";

if (!isset($_SESSION["data-user"])) {
  if (isset($_POST["masuk"])) {
    if (masuk($_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["data-user"])) {
  $idUser = valid($_SESSION["data-user"]["id"]);
  
  $profile = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$idUser'");
  if (isset($_POST["ubah-profile"])) {
    if (edit_profile($_POST) > 0) {
      $_SESSION["message-success"] = "Profil akun anda berhasil di ubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $users = mysqli_query($conn, "SELECT * FROM users WHERE id_user!='$idUser' ORDER BY id_user DESC");
  if (isset($_POST["tambah-user"])) {
    if (add_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["username"] . " berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-user"])) {
    if (edit_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["usernameOld"] . " berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-user"])) {
    if (delete_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["username"] . " berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
}
