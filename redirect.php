<?php require_once("controller/script.php");
if (isset($_POST['pelayaran'])) {
  if (!isset($_SESSION['data-user'])) {
    $nama = valid($conn, $_POST['nama']);
    $id_jk = valid($conn, $_POST['id_jk']);
    $umur = valid($conn, $_POST['umur']);
    $alamat = valid($conn, $_POST['alamat']);
    $nomor_telepon = valid($conn, $_POST['nomor_telepon']);
    $email = valid($conn, $_POST['email']);
    $pelabuhan_asal = valid($conn, $_POST['pelabuhan_asal']);
    $pelabuhan_tujuan = valid($conn, $_POST['pelabuhan_tujuan']);

    $check_email = "SELECT * FROM penumpang WHERE email='$email'";
    $checkEmail = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($checkEmail) > 0) {
      $akses = 1;
    } else {
      $akses = 0;
    }

    $_SESSION['redirect'] = [
      'nama' => $nama,
      'id_jk' => $id_jk,
      'umur' => $umur,
      'alamat' => $alamat,
      'nomor_telepon' => $nomor_telepon,
      'email' => $email,
      'pelabuhan_asal' => $pelabuhan_asal,
      'pelabuhan_tujuan' => $pelabuhan_tujuan,
      'akses' => $akses
    ];
    header("Location: pelayaran");
    exit;
  } else if (isset($_SESSION['data-user'])) {
    $email = valid($conn, $_SESSION['data-user']['email']);
    $pelabuhan_asal = valid($conn, $_POST['pelabuhan_asal']);
    $pelabuhan_tujuan = valid($conn, $_POST['pelabuhan_tujuan']);
    $akses = 1;

    $_SESSION['redirect'] = [
      'email' => $email,
      'pelabuhan_asal' => $pelabuhan_asal,
      'pelabuhan_tujuan' => $pelabuhan_tujuan,
      'akses' => $akses
    ];
    header("Location: pelayaran");
    exit;
  }
}
if (isset($_POST['re-pelayaran'])) {
  unset($_SESSION['redirect']);
  header("Location: ./");
  exit;
}
if (isset($_GET['tiket'])) {
  $id_tiket = valid($conn, $_GET['tiket']);
  $check_tiket = "SELECT * FROM tiket WHERE id_tiket='$id_tiket'";
  $checkTiket = mysqli_query($conn, $check_tiket);
  if (mysqli_num_rows($checkTiket) > 0) {
    $_SESSION['tiket'] = ['id_tiket' => $id_tiket];
    header("Location: tiket");
    exit;
  } else {
    header("Location: ./");
    exit;
  }
}
