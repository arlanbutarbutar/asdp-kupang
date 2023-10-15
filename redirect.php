<?php require_once("controller/script.php");
if (isset($_POST['pelayaran'])) {
  $pelabuhan_asal = valid($conn, $_POST['pelabuhan_asal']);
  $pelabuhan_tujuan = valid($conn, $_POST['pelabuhan_tujuan']);
  $pessanger = valid($conn, $_POST['pessanger']);

  $_SESSION['redirect'] = [
    'pelabuhan_asal' => $pelabuhan_asal,
    'pelabuhan_tujuan' => $pelabuhan_tujuan,
    'pessanger' => $pessanger,
  ];
  header("Location: pelayaran");
  exit;
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
