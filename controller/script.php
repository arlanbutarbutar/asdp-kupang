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

$baseURL = "https://$_SERVER[HTTP_HOST]/";

$jk = "SELECT * FROM jk";
$selectJK = mysqli_query($conn, $jk);
$pelabuhan = "SELECT * FROM pelabuhan";
$selectPelabuhanAsal = mysqli_query($conn, $pelabuhan);
$selectPelabuhanTujuan = mysqli_query($conn, $pelabuhan);

$lintasan = "SELECT * FROM rute GROUP BY cabang";
$front_lintasan = mysqli_query($conn, $lintasan);
$kapal = "SELECT * FROM kapal";
$front_kapal = mysqli_query($conn, $kapal);
$front_pelabuhan = mysqli_query($conn, $pelabuhan);
$jadwal = "SELECT * FROM jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute";
$front_jadwal = mysqli_query($conn, $jadwal);
$galeri = "SELECT * FROM galeri";
$front_galeri = mysqli_query($conn, $galeri);
$informasi = "SELECT * FROM informasi";
$front_informasi = mysqli_query($conn, $informasi);

if (isset($_POST["daftar-pelayaran"])) {
  if (daftar_pelayaran($conn, $_POST) > 0) {
    if ($_SESSION['redirect']['akses'] == 0) {
      $_SESSION["message-success"] = "Akun telah terdaftar, silakan cek email anda untuk memverifikasi akun.";
      $_SESSION["time-message"] = time();
      unset($_SESSION['redirect']);
      header("Location: auth/");
    } else if ($_SESSION['redirect']['akses'] == 1) {
      unset($_SESSION['redirect']);
      header("Location: views/tiket");
    }
    exit();
  }
}

if (!isset($_SESSION["data-user"])) {
  if (isset($_POST["daftar"])) {
    if (daftar($conn, $_POST) > 0) {
      $_SESSION["message-success"] = "Akun telah terdaftar, silakan cek email anda untuk memverifikasi akun.";
      $_SESSION["time-message"] = time();
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["masuk"])) {
    if (masuk($conn, $_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["data-user"])) {
  $idUser = valid($conn, $_SESSION["data-user"]["id"]);
  $role = valid($conn, $_SESSION["data-user"]["role"]);
  $emailUser = valid($conn, $_SESSION["data-user"]["email"]);

  if ($role <= 2) {
    $profile = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$idUser'");
  } else {
    $profile = mysqli_query($conn, "SELECT penumpang.*, jk.jenis_kelamin FROM penumpang JOIN jk ON penumpang.id_jk=jk.id_jk WHERE penumpang.id_penumpang='$idUser'");
  }
  if (isset($_POST["ubah-profile"])) {
    if (edit_profile($conn, $_POST, $idUser, $role, $action = "update") > 0) {
      $_SESSION["message-success"] = "Profil akun anda berhasil di ubah.";
      $_SESSION["time-message"] = time();
      header("Location: profil");
      exit();
    }
  }

  $users = "SELECT users.*, users_role.role FROM users JOIN users_role ON users.id_role=users_role.id_role WHERE users.id_user!='$idUser'";
  $view_users = mysqli_query($conn, $users);
  if (isset($_POST["tambah-user"])) {
    if (users($_POST, $conn, $action = "insert") > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: pengelola");
      exit();
    }
  }
  if (isset($_POST["ubah-user"])) {
    if (users($_POST, $conn, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: pengelola");
      exit();
    }
  }
  if (isset($_POST["hapus-user"])) {
    if (users($_POST, $conn, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: pengelola");
      exit();
    }
  }

  $penumpang = "SELECT * FROM penumpang JOIN jk ON penumpang.id_jk=jk.id_jk";
  $view_penumpang = mysqli_query($conn, $penumpang);

  $kapal = "SELECT * FROM kapal";
  $view_kapal = mysqli_query($conn, $kapal);
  if (isset($_POST["tambah-kapal"])) {
    if (kapal($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data kapal berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: kapal");
      exit();
    }
  }
  if (isset($_POST["ubah-kapal"])) {
    if (kapal($conn, $_POST, $action = "update", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data kapal berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: kapal");
      exit();
    }
  }
  if (isset($_POST["hapus-kapal"])) {
    if (kapal($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data kapal berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: kapal");
      exit();
    }
  }

  $pelabuhan = "SELECT * FROM pelabuhan";
  $view_pelabuhan = mysqli_query($conn, $pelabuhan);
  if (isset($_POST["tambah-pelabuhan"])) {
    if (pelabuhan($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data pelabuhan berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: pelabuhan");
      exit();
    }
  }
  if (isset($_POST["ubah-pelabuhan"])) {
    if (pelabuhan($conn, $_POST, $action = "update", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data pelabuhan berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: pelabuhan");
      exit();
    }
  }
  if (isset($_POST["hapus-pelabuhan"])) {
    if (pelabuhan($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data pelabuhan berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: pelabuhan");
      exit();
    }
  }

  $rute = "SELECT * FROM rute";
  $view_rute = mysqli_query($conn, $rute);
  if (isset($_POST["tambah-rute"])) {
    if (rute($conn, $_POST, $action = "insert") > 0) {
      $_SESSION["message-success"] = "Data rute berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: rute");
      exit();
    }
  }
  if (isset($_POST["ubah-rute"])) {
    if (rute($conn, $_POST, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data rute berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: rute");
      exit();
    }
  }
  if (isset($_POST["hapus-rute"])) {
    if (rute($conn, $_POST, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data rute berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: rute");
      exit();
    }
  }

  $jadwal = "SELECT jadwal.*, kapal.nama_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan FROM jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute";
  $view_jadwal = mysqli_query($conn, $jadwal);
  if (isset($_POST["tambah-jadwal"])) {
    if (jadwal($conn, $_POST, $action = "insert") > 0) {
      $_SESSION["message-success"] = "Data jadwal berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: jadwal");
      exit();
    }
  }
  if (isset($_POST["ubah-jadwal"])) {
    if (jadwal($conn, $_POST, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data jadwal berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: jadwal");
      exit();
    }
  }
  if (isset($_POST["hapus-jadwal"])) {
    if (jadwal($conn, $_POST, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data jadwal berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: jadwal");
      exit();
    }
  }

  $pelayaran = "SELECT pelayaran.*, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.nama_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan FROM pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute";
  $view_pelayaran = mysqli_query($conn, $pelayaran);
  if (isset($_POST["tambah-pelayaran"])) {
    if (pelayaran($conn, $_POST, $action = "insert") > 0) {
      $_SESSION["message-success"] = "Data pelayaran berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: pelayaran");
      exit();
    }
  }
  if (isset($_POST["ubah-pelayaran"])) {
    if (pelayaran($conn, $_POST, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data pelayaran berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: pelayaran");
      exit();
    }
  }
  if (isset($_POST["hapus-pelayaran"])) {
    if (pelayaran($conn, $_POST, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data pelayaran berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: pelayaran");
      exit();
    }
  }

  $informasi = "SELECT * FROM informasi";
  $view_informasi = mysqli_query($conn, $informasi);
  if (isset($_POST["tambah-informasi"])) {
    if (informasi($conn, $_POST, $action = "insert") > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }
  if (isset($_POST["ubah-informasi"])) {
    if (informasi($conn, $_POST, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }
  if (isset($_POST["hapus-informasi"])) {
    if (informasi($conn, $_POST, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }

  $galeri = "SELECT * FROM galeri";
  $view_galeri = mysqli_query($conn, $galeri);
  if (isset($_POST["tambah-galeri"])) {
    if (galeri($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data galeri berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: galeri");
      exit();
    }
  }
  if (isset($_POST["hapus-galeri"])) {
    if (galeri($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data galeri berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: galeri");
      exit();
    }
  }

  if ($role <= 2) {
    $tiket = "SELECT * FROM tiket JOIN pelayaran ON tiket.id_pelayaran=pelayaran.id_pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang JOIN jk ON penumpang.id_jk=jk.id_jk";
    $view_tiket = mysqli_query($conn, $tiket);
    if (isset($_POST["ubah-tiket"])) {
      if (tiket($conn, $_POST, $action = "update") > 0) {
        $_SESSION["message-success"] = "Data status pembayaran berhasil diubah.";
        $_SESSION["time-message"] = time();
        header("Location: pembayaran");
        exit();
      }
    }

    $pembayaran = "SELECT pembayaran.*, tiket.harga, tiket.status_pembayaran, pelayaran.penumpang, pelayaran.golongan, pelayaran.kendaraan, penumpang.nama, jk.jenis_kelamin, penumpang.umur, penumpang.nomor_telepon, penumpang.email FROM pembayaran JOIN tiket ON pembayaran.id_tiket=tiket.id_tiket JOIN pelayaran ON tiket.id_pelayaran=pelayaran.id_pelayaran JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang JOIN jk ON penumpang.id_jk=jk.id_jk";
    $view_pembayaran = mysqli_query($conn, $pembayaran);

    $count_pengelola = "SELECT * FROM users WHERE id_role='2'";
    $count_pengelola = mysqli_query($conn, $count_pengelola);
    $countPengelola = mysqli_num_rows($count_pengelola);
    $count_penumpang = "SELECT * FROM penumpang";
    $count_penumpang = mysqli_query($conn, $count_penumpang);
    $countPenumpang = mysqli_num_rows($count_penumpang);
    $count_kapal = "SELECT * FROM kapal";
    $count_kapal = mysqli_query($conn, $count_kapal);
    $countKapal = mysqli_num_rows($count_kapal);
    $count_pelayaran = "SELECT * FROM pelayaran";
    $count_pelayaran = mysqli_query($conn, $count_pelayaran);
    $countPelayaran = mysqli_num_rows($count_pelayaran);
    $count_tiket = "SELECT * FROM tiket WHERE tiket.qr_code IS NOT NULL";
    $count_tiket = mysqli_query($conn, $count_tiket);
    $countTiket = mysqli_num_rows($count_tiket);
  } else if ($role == 3) {
    $tiket = "SELECT tiket.*, pelayaran.penumpang, pelayaran.golongan, pelayaran.kendaraan, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.nama_kapal, kapal.jenis_kapal, rute.cabang, rute.pelabuhan_asal, rute.pelabuhan_tujuan, rute.jarak FROM tiket JOIN pelayaran ON tiket.id_pelayaran=pelayaran.id_pelayaran JOIN jadwal ON pelayaran.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute WHERE tiket.id_penumpang='$idUser'";
    $view_tiket = mysqli_query($conn, $tiket);
    if (isset($_POST["hapus-tiket"])) {
      if (tiket($conn, $_POST, $action = "delete") > 0) {
        $_SESSION["message-success"] = "Data tiket berhasil dibatalkan.";
        $_SESSION["time-message"] = time();
        header("Location: tiket");
        exit();
      }
    }

    $pembayaran = "SELECT pembayaran.*, tiket.harga, tiket.status_pembayaran, pelayaran.penumpang, pelayaran.golongan, pelayaran.kendaraan FROM pembayaran JOIN tiket ON pembayaran.id_tiket=tiket.id_tiket JOIN pelayaran ON tiket.id_pelayaran=pelayaran.id_pelayaran WHERE tiket.id_penumpang='$idUser'";
    $view_pembayaran = mysqli_query($conn, $pembayaran);
    if (isset($_POST["tambah-pembayaran"])) {
      if (pembayaran($conn, $_POST, $action = "insert", $baseURL, $idUser) > 0) {
        $_SESSION["message-success"] = "Data pembayaran berhasil, selakan menunggu pengecekan dan petugas akan mengirimkan notifikasi email status pembayaran.";
        $_SESSION["time-message"] = time();
        header("Location: pembayaran");
        exit();
      }
    }
    if (isset($_POST["ubah-pembayaran"])) {
      if (pembayaran($conn, $_POST, $action = "update", $baseURL, $idUser) > 0) {
        $_SESSION["message-success"] = "Data pembayaran berhasil dikirim ulang, selakan menunggu pengecekan dan petugas akan mengirimkan notifikasi email status pembayaran.";
        $_SESSION["time-message"] = time();
        header("Location: pembayaran");
        exit();
      }
    }

    $overview = "SELECT * FROM tiket 
             JOIN pembayaran ON pembayaran.id_tiket=tiket.id_tiket
             JOIN pelayaran ON tiket.id_pelayaran = pelayaran.id_pelayaran 
             JOIN jadwal ON pelayaran.id_jadwal = jadwal.id_jadwal 
             JOIN kapal ON jadwal.id_kapal = kapal.id_kapal 
             JOIN rute ON jadwal.id_rute = rute.id_rute 
             WHERE tiket.id_penumpang = '$idUser' 
             AND tiket.qr_code IS NOT NULL 
             AND tiket.tgl_jalan >= CURDATE()
             AND tiket.jam_jalan >= CURTIME()";
    $view_overview = mysqli_query($conn, $overview);

    $count_tiket = "SELECT * FROM tiket WHERE tiket.id_penumpang='$idUser'";
    $count_tiket = mysqli_query($conn, $count_tiket);
    $countTiket = mysqli_num_rows($count_tiket);
    $count_pembayaran = "SELECT * FROM pembayaran JOIN tiket ON pembayaran.id_tiket=tiket.id_tiket WHERE tiket.id_penumpang='$idUser'";
    $count_pembayaran = mysqli_query($conn, $count_pembayaran);
    $countPembayaran = mysqli_num_rows($count_pembayaran);
  }
}
