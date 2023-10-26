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

$jk = "SELECT * FROM jk";
$selectJK = mysqli_query($conn, $jk);
$gol = "SELECT * FROM golongan";
$selectGol = mysqli_query($conn, $gol);
$kel = "SELECT * FROM kelas";
$selectKel = mysqli_query($conn, $kel);
$pelabuhan = "SELECT * FROM pelabuhan";
$selectPelabuhanAsal = mysqli_query($conn, $pelabuhan);
$selectPelabuhanTujuan = mysqli_query($conn, $pelabuhan);

$lintasan = "SELECT * FROM rute GROUP BY cabang";
$front_lintasan = mysqli_query($conn, $lintasan);
$kapal = "SELECT * FROM kapal";
$front_kapal = mysqli_query($conn, $kapal);
$front_pelabuhan = mysqli_query($conn, $pelabuhan);
$jadwal = "SELECT * FROM jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute ORDER BY jadwal.tanggal_berangkat ASC";
$front_jadwal = mysqli_query($conn, $jadwal);
$galeri = "SELECT * FROM galeri";
$front_galeri = mysqli_query($conn, $galeri);
$informasi = "SELECT * FROM informasi";
$front_informasi = mysqli_query($conn, $informasi);

if (isset($_POST["daftar-pelayaran"])) {
  if (daftar_pelayaran($conn, $_POST) > 0) {
    unset($_SESSION['redirect']);
    header("Location: auth/");
    exit();
  }
}
if (isset($_POST["verifikasi"])) {
  if (daftar_pelayaran_approve($conn, $_POST) > 0) {
    header("Location: views/tiket");
    exit();
  }
}

if (!isset($_SESSION["data-user"])) {
  if (isset($_POST["daftar"])) {
    if (daftar($conn, $_POST) > 0) {
      $_SESSION["message-success"] = "Akun telah terdaftar, silakan cek email anda untuk memverifikasi akun.";
      $_SESSION["time-message"] = time();
      header("Location: verification");
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
  $nomor_telepon = valid($conn, $_SESSION["data-user"]["nomor_telepon"]);

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
      header("Location: pengguna");
      exit();
    }
  }
  if (isset($_POST["ubah-user"])) {
    if (users($_POST, $conn, $action = "update") > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: pengguna");
      exit();
    }
  }
  if (isset($_POST["hapus-user"])) {
    if (users($_POST, $conn, $action = "delete") > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: pengguna");
      exit();
    }
  }

  $penumpang = "SELECT * FROM penumpang JOIN jk ON penumpang.id_jk=jk.id_jk";
  $view_penumpang = mysqli_query($conn, $penumpang);

  $account_bank = "SELECT * FROM account_bank";
  $view_account_bank = mysqli_query($conn, $account_bank);
  if (isset($_POST["tambah-account-bank"])) {
    if (account_bank($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: account-bank");
      exit();
    }
  }
  if (isset($_POST["ubah-account-bank"])) {
    if (account_bank($conn, $_POST, $action = "update", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: account-bank");
      exit();
    }
  }
  if (isset($_POST["hapus-account-bank"])) {
    if (account_bank($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: account-bank");
      exit();
    }
  }

  $kelas = "SELECT * FROM kelas";
  $view_kelas = mysqli_query($conn, $kelas);
  if (isset($_POST["tambah-kelas"])) {
    if (kelas($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: kelas");
      exit();
    }
  }
  if (isset($_POST["ubah-kelas"])) {
    if (kelas($conn, $_POST, $action = "update", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: kelas");
      exit();
    }
  }
  if (isset($_POST["hapus-kelas"])) {
    if (kelas($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: kelas");
      exit();
    }
  }

  $golongan = "SELECT * FROM golongan";
  $view_golongan = mysqli_query($conn, $golongan);
  if (isset($_POST["tambah-golongan"])) {
    if (golongan($conn, $_POST, $action = "insert", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: golongan");
      exit();
    }
  }
  if (isset($_POST["ubah-golongan"])) {
    if (golongan($conn, $_POST, $action = "update", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: golongan");
      exit();
    }
  }
  if (isset($_POST["hapus-golongan"])) {
    if (golongan($conn, $_POST, $action = "delete", $baseURL) > 0) {
      $_SESSION["message-success"] = "Data account bank berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: golongan");
      exit();
    }
  }

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
    $pemesanan = "SELECT pemesanan.*, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.img_kapal, kapal.nama_kapal, kapal.kapasitas, kapal.jenis_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan, rute.jarak, penumpang.nama, penumpang.umur, penumpang.alamat, kelas.nama_kelas, kelas.harga_kelas, jk.jenis_kelamin, golongan.nama_golongan, golongan.harga_golongan FROM pemesanan JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang JOIN kelas ON penumpang.id_kelas=kelas.id_kelas JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan JOIN jk ON penumpang.id_jk=jk.id_jk";
    $view_pemesanan = mysqli_query($conn, $pemesanan);

    $tiket = "SELECT tiket.*, penumpang.nama, penumpang.umur, penumpang.alamat, jk.jenis_kelamin, kelas.nama_kelas, golongan.nama_golongan, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.nama_kapal, kapal.jenis_kapal, rute.cabang, rute.pelabuhan_asal, rute.pelabuhan_tujuan, rute.jarak 
    FROM tiket 
    JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang 
    JOIN kelas ON penumpang.id_kelas=kelas.id_kelas
    JOIN jk ON penumpang.id_jk=jk.id_jk
    JOIN pemesanan ON penumpang.id_penumpang=pemesanan.id_penumpang 
    JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan
    JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal 
    JOIN kapal ON jadwal.id_kapal=kapal.id_kapal 
    JOIN rute ON jadwal.id_rute=rute.id_rute";
    $view_tiket = mysqli_query($conn, $tiket);

    $pembayaran = "SELECT pembayaran.*, penumpang.nama, golongan.nama_golongan, jk.jenis_kelamin, penumpang.umur, penumpang.alamat, kelas.nama_kelas, kelas.harga_kelas, pemesanan.no_pemesanan, account_bank.an, account_bank.bank, account_bank.norek, jadwal.id_jadwal FROM pembayaran JOIN pemesanan ON pembayaran.no_pemesanan=pemesanan.no_pemesanan JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang JOIN jk ON penumpang.id_jk=jk.id_jk JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan JOIN kelas ON penumpang.id_kelas=kelas.id_kelas JOIN account_bank ON pembayaran.id_bank=account_bank.id_bank GROUP BY pemesanan.no_pemesanan";
    $view_pembayaran = mysqli_query($conn, $pembayaran);
    if (isset($_POST["ubah-pembayaran"])) {
      if (pembayaran_checking($conn, $_POST, $action = "update", $nomor_telepon) > 0) {
        $_SESSION["message-success"] = "Data status pembayaran berhasil diubah.";
        $_SESSION["time-message"] = time();
        header("Location: pembayaran");
        exit();
      }
    }

    $count_pengelola = "SELECT * FROM users WHERE id_role='2'";
    $count_pengelola = mysqli_query($conn, $count_pengelola);
    $countPengelola = mysqli_num_rows($count_pengelola);
    $count_penumpang = "SELECT * FROM penumpang";
    $count_penumpang = mysqli_query($conn, $count_penumpang);
    $countPenumpang = mysqli_num_rows($count_penumpang);
    $count_kapal = "SELECT * FROM kapal";
    $count_kapal = mysqli_query($conn, $count_kapal);
    $countKapal = mysqli_num_rows($count_kapal);
    $count_pemesanan = "SELECT * FROM pemesanan";
    $count_pemesanan = mysqli_query($conn, $count_pemesanan);
    $countPemesanan = mysqli_num_rows($count_pemesanan);
    $count_tiket = "SELECT * FROM tiket";
    $count_tiket = mysqli_query($conn, $count_tiket);
    $countTiket = mysqli_num_rows($count_tiket);
  } else if ($role == 3) {
    $pemesanan = "SELECT pemesanan.*, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.img_kapal, kapal.nama_kapal, kapal.kapasitas, kapal.jenis_kapal, rute.pelabuhan_asal, rute.pelabuhan_tujuan, rute.jarak, penumpang.nama, penumpang.umur, penumpang.alamat, kelas.nama_kelas, kelas.harga_kelas, jk.jenis_kelamin, golongan.nama_golongan, golongan.harga_golongan FROM pemesanan JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal JOIN kapal ON jadwal.id_kapal=kapal.id_kapal JOIN rute ON jadwal.id_rute=rute.id_rute JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang JOIN kelas ON penumpang.id_kelas=kelas.id_kelas JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan JOIN jk ON penumpang.id_jk=jk.id_jk WHERE pemesanan.id_user='$idUser'";
    $view_pemesanan = mysqli_query($conn, $pemesanan);

    $tiket = "SELECT tiket.*, penumpang.nama, penumpang.umur, penumpang.alamat, jk.jenis_kelamin, kelas.nama_kelas, golongan.nama_golongan, jadwal.tanggal_berangkat, jadwal.jam_berangkat, kapal.nama_kapal, kapal.jenis_kapal, rute.cabang, rute.pelabuhan_asal, rute.pelabuhan_tujuan, rute.jarak 
                FROM tiket 
                JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang 
                JOIN kelas ON penumpang.id_kelas=kelas.id_kelas
                JOIN jk ON penumpang.id_jk=jk.id_jk
                JOIN pemesanan ON penumpang.id_penumpang=pemesanan.id_penumpang 
                JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan
                JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal 
                JOIN kapal ON jadwal.id_kapal=kapal.id_kapal 
                JOIN rute ON jadwal.id_rute=rute.id_rute 
                WHERE pemesanan.id_user='$idUser'";
    $view_tiket = mysqli_query($conn, $tiket);

    $pembayaran = "SELECT * FROM pemesanan JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang JOIN kelas ON penumpang.id_kelas=kelas.id_kelas JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal WHERE pemesanan.id_user='$idUser' AND jadwal.tanggal_berangkat > CURDATE() OR jadwal.jam_berangkat > CURTIME() GROUP BY pemesanan.no_pemesanan";
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
             JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang 
             JOIN kelas ON penumpang.id_kelas=kelas.id_kelas 
             JOIN pemesanan ON penumpang.id_penumpang=pemesanan.id_penumpang 
             JOIN golongan ON pemesanan.id_golongan=golongan.id_golongan 
             JOIN pembayaran ON pemesanan.no_pemesanan=pembayaran.no_pemesanan
             JOIN jadwal ON pemesanan.id_jadwal = jadwal.id_jadwal 
             JOIN kapal ON jadwal.id_kapal = kapal.id_kapal 
             JOIN rute ON jadwal.id_rute = rute.id_rute 
             WHERE pemesanan.id_user = '$idUser' 
             AND tiket.qr_code IS NOT NULL 
             AND jadwal.tanggal_berangkat >= CURDATE()
             AND jadwal.jam_berangkat >= CURTIME()";
    $view_overview = mysqli_query($conn, $overview);

    $count_tiket = "SELECT * FROM tiket JOIN penumpang ON tiket.id_penumpang=penumpang.id_penumpang JOIN pemesanan ON penumpang.id_penumpang=pemesanan.id_penumpang WHERE pemesanan.id_user='$idUser'";
    $count_tiket = mysqli_query($conn, $count_tiket);
    $countTiket = mysqli_num_rows($count_tiket);
    $count_pembayaran = "SELECT * FROM pemesanan WHERE id_user='$idUser'";
    $count_pembayaran = mysqli_query($conn, $count_pembayaran);
    $countPembayaran = mysqli_num_rows($count_pembayaran);

    if (isset($_POST["hapus-pemesanan"])) {
      if (pemesanan($conn, $_POST, $action = "update") > 0) {
        $_SESSION["message-success"] = "Data pemesanan berhasil dibatalkan.";
        $_SESSION["time-message"] = time();
        header("Location: pemesanan");
        exit();
      }
    }
  }
}
