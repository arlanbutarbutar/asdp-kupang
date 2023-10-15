<?php require_once("support_code.php");
function WAAPI($target, $pesan, $token = "P2eS-zGGpJJPjwI8UnC1")
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'target' => $target,
      'message' => $pesan,
    ),
    CURLOPT_HTTPHEADER => array(
      "Authorization: $token"
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return $response;
}

function daftar_pelayaran($conn, $data)
{
  $checkAccount = mysqli_query($conn, "SELECT * FROM penumpang ORDER BY id_penumpang DESC LIMIT 1");
  if (mysqli_num_rows($checkAccount) > 0) {
    $row = mysqli_fetch_assoc($checkAccount);
    $lastIdPenumpang = $row['id_penumpang'];
  } else {
    $lastIdPenumpang = 0;
  }
  $nama = $data['nama'];
  $id_jk = $data['id_jk'];
  $umur = $data['umur'];
  $alamat = $data['alamat'];
  $nomor_telepon = valid($conn, $data['nomor_telepon']);
  $id_pelayaran = valid($conn, $data['id_pelayaran']);
  $harga = valid($conn, $data['harga']);
  $tgl_jalan = valid($conn, $data['tgl_jalan']);
  $jam_jalan = valid($conn, $data['jam_jalan']);

  $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
  if (mysqli_num_rows($checkAccount) > 0) {
    $row = mysqli_fetch_assoc($checkAccount);
    $nomor_tlpn = $row['nomor_telepon'];
    if ($row['id_status'] == 2) {
      $_SESSION["message-danger"] = "Maaf, akun anda belum diaktivasi. Silakan cek whatsapp anda kembali";
      $_SESSION["time-message"] = time();
      return false;
    } else {
      $en_user = crc32($nomor_telepon);
      for ($i = 0; $i < count($nama); $i++) {
        $id_penumpang = $lastIdPenumpang + 1;
        mysqli_query($conn, "INSERT INTO penumpang (id_penumpang, en_user, nama, id_jk, umur, alamat, nomor_telepon) VALUES ('$id_penumpang', '$en_user', '$nama[$i]', '$id_jk[$i]', '$umur[$i]', '$alamat[$i]', '$nomor_telepon')");
        mysqli_query($conn, "INSERT INTO tiket (id_pelayaran, id_penumpang, harga, tgl_jalan, jam_jalan) VALUES ('$id_pelayaran', '$id_penumpang', '$harga', '$tgl_jalan', '$jam_jalan')");
        $lastIdPenumpang = $id_penumpang;
      }

      // Send to Whatsapp
      $target = $nomor_telepon;
      $pesan = "Terima kasih telah memesan tiket perjalanan dari ASDP Cabang Kupang. Untuk melanjutkan silakan klik link berikut untuk proses pembayaran: http://127.0.0.1:1010/apps/asdp-kupang/auth/index?tlpn=$nomor_tlpn";
      WAAPI($target, $pesan);

      return mysqli_affected_rows($conn);
    }
  } else {
    $en_user = crc32($nomor_telepon);
    for ($i = 0; $i < count($nama); $i++) {
      $id_penumpang = $lastIdPenumpang + 1;
      mysqli_query($conn, "INSERT INTO penumpang (id_penumpang, en_user, nama, id_jk, umur, alamat, nomor_telepon) VALUES ('$id_penumpang', '$en_user', '$nama[$i]', '$id_jk[$i]', '$umur[$i]', '$alamat[$i]', '$nomor_telepon')");
      mysqli_query($conn, "INSERT INTO tiket (id_pelayaran, id_penumpang, harga, tgl_jalan, jam_jalan) VALUES ('$id_pelayaran', '$id_penumpang', '$harga', '$tgl_jalan', '$jam_jalan')");
      $lastIdPenumpang = $id_penumpang;
    }
    mysqli_query($conn, "INSERT INTO users(en_user,username,nomor_telepon) VALUES('$en_user','penumpang_$en_user','$nomor_telepon')");

    // Send to Whatsapp
    $target = $nomor_telepon;
    $pesan = "Terima kasih telah memesan tiket perjalanan dari ASDP Cabang Kupang. Untuk melanjutkan silakan klik link berikut untuk memverifikasi akun: http://127.0.0.1:1010/apps/asdp-kupang/auth/verification?en=$en_user";
    WAAPI($target, $pesan);

    unset($_SESSION['redirect']);
    header("Location: auth/verification");
    exit();
  }
}
function daftar_pelayaran_approve($conn, $data)
{
  $nomor_telepon = valid($conn, $data['nomor_telepon']);
  $password = valid($conn, $data['password']);
  $len_password = strlen($password);
  $re_password = valid($conn, $data['re_password']);
  if ($password != $re_password) {
    $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan belum sama.";
    $_SESSION["time-message"] = time();
    return false;
  }
  if ($len_password < 8) {
    $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan kurang dari 8 karakter.";
    $_SESSION["time-message"] = time();
    return false;
  }
  $password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "UPDATE users SET password='$password' WHERE nomor_telepon='$nomor_telepon'";
  mysqli_query($conn, $sql);
  $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
  if (mysqli_num_rows($checkAccount) > 0) {
    $row = mysqli_fetch_assoc($checkAccount);
    $_SESSION["data-user"] = [
      "id" => $row["id_user"],
      "role" => $row["id_role"],
      "username" => $row["username"],
      "nomor_telepon" => $row["nomor_telepon"],
    ];
  }
  return mysqli_affected_rows($conn);
}
if (!isset($_SESSION["data-user"])) {
  function daftar($conn, $data)
  {
    $nama = valid($conn, $data["nama"]);
    $nomor_telepon = valid($conn, $data["nomor_telepon"]);
    $password = valid($conn, $data["password"]);
    $re_password = valid($conn, $data["re_password"]);
    $len_password = strlen($password);

    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
    if (mysqli_num_rows($checkAccount) > 0) {
      $_SESSION["message-danger"] = "Maaf, No. HP yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    if ($len_password < 8) {
      $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan kurang dari 8 karakter.";
      $_SESSION["time-message"] = time();
      return false;
    }
    if ($password != $re_password) {
      $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan belum sama.";
      $_SESSION["time-message"] = time();
      return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $en_user = crc32($nomor_telepon);

    $sql = "INSERT INTO users(en_user,username,nomor_telepon,password) VALUES('$en_user','$nama','$nomor_telepon','$password')";
    mysqli_query($conn, $sql);

    // Send to Whatsapp
    $target = $nomor_telepon;
    $pesan = "Akun anda telah terdaftar di sistem ASDP Cabang Kupang. Untuk melanjutkan silakan klik link berikut untuk memverifikasi akun: http://127.0.0.1:1010/apps/asdp-kupang/auth/verification?en=$en_user";
    WAAPI($target, $pesan);

    return mysqli_affected_rows($conn);
  }
  function masuk($conn, $data)
  {
    $nomor_telepon = valid($conn, $data["nomor_telepon"]);
    $password = valid($conn, $data["password"]);

    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
    if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($password, $row["password"])) {
        $_SESSION["data-user"] = [
          "id" => $row["id_user"],
          "role" => $row["id_role"],
          "username" => $row["username"],
          "nomor_telepon" => $row["nomor_telepon"],
        ];
      } else {
        $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
        $_SESSION["time-message"] = time();
        return false;
      }
    } else if (mysqli_num_rows($checkAccount) == 0) {
      $_SESSION["message-danger"] = "Maaf, akun yang anda masukan belum terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
  }
}
if (isset($_SESSION["data-user"])) {
  function edit_profile($conn, $data, $idUser, $role, $action)
  {
    $password = valid($conn, $data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    if ($action == "insert") {
    }

    if ($action == "update") {
      if ($role <= 2) {
        $username = valid($conn, $data["username"]);
        $sql = "UPDATE users SET username='$username', password='$password' WHERE id_user='$idUser'";
      } else {
        $nama = valid($conn, $data['nama']);
        $id_jk = valid($conn, $data['id_jk']);
        $umur = valid($conn, $data['umur']);
        $alamat = valid($conn, $data['alamat']);
        $nomor_telepon = valid($conn, $data['nomor_telepon']);
        $sql = "UPDATE penumpang SET nama='$nama', id_jk='$id_jk', umur='$umur', alamat='$alamat', nomor_telepon='$nomor_telepon', password='$password' WHERE id_penumpang='$idUser'";
      }
      mysqli_query($conn, $sql);
    }

    if ($action == "delete") {
    }

    return mysqli_affected_rows($conn);
  }
  function users($data, $conn, $action)
  {
    $username = valid($conn, $data["username"]);
    $nomor_telepon = valid($conn, $data["nomor_telepon"]);
    $password = valid($conn, $data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    if ($action == "insert") {
      $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
      if (mysqli_num_rows($checkAccount) > 0) {
        $_SESSION["message-danger"] = "Maaf, no. handphone yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
      $sql = "INSERT INTO users(id_role,username,nomor_telepon,password) VALUES('1','$username','$nomor_telepon','$password')";
      mysqli_query($conn, $sql);
    }

    if ($action == "update") {
      $id_user = valid($conn, $data["id-user"]);
      $nomor_teleponOld = valid($conn, $data["nomor_teleponOld"]);
      if ($nomor_telepon != $nomor_teleponOld) {
        $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
        if (mysqli_num_rows($checkAccount) > 0) {
          $_SESSION["message-danger"] = "Maaf, no. handphone yang anda masukan sudah terdaftar.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $sql = "UPDATE users SET username='$username', nomor_telepon='$nomor_telepon', updated_at=current_timestamp WHERE id_user='$id_user'";
      mysqli_query($conn, $sql);
    }

    if ($action == "delete") {
      $id_user = valid($conn, $data["id-user"]);
      $sql = "DELETE FROM users WHERE id_user='$id_user'";
      mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
  }
  function account_bank($conn, $data, $action)
  {
    $an = valid($conn, $data['an']);
    $bank = valid($conn, $data['bank']);
    $norek = valid($conn, $data['norek']);

    if ($action == "insert") {
      $account_bank = "SELECT * FROM account_bank WHERE bank='$bank'";
      $check_account_bank = mysqli_query($conn, $account_bank);
      if (mysqli_num_rows($check_account_bank) > 0) {
        $_SESSION["message-danger"] = "Maaf, bank yang anda masukan sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      } else {
        $sql = "INSERT INTO account_bank(an,bank,norek) VALUES('$an','$bank','$norek')";
      }
    }

    if ($action == "update") {
      $id = valid($conn, $data['id']);
      $bankOld = valid($conn, $data['bankOld']);
      if ($bank != $bankOld) {
        $account_bank = "SELECT * FROM account_bank WHERE bank='$bank'";
        $check_account_bank = mysqli_query($conn, $account_bank);
        if (mysqli_num_rows($check_account_bank) > 0) {
          $_SESSION["message-danger"] = "Maaf, bank yang anda masukan sudah ada.";
          $_SESSION["time-message"] = time();
          return false;
        } else {
          $sql = "UPDATE account_bank SET an='$an', bank='$bank', norek='$norek' WHERE id='$id'";
        }
      }
    }

    if ($action == "delete") {
      $id = valid($conn, $data['id']);
      $sql = "DELETE FROM account_bank WHERE id='$id'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function kapal($conn, $data, $action, $baseURL)
  {
    $nama_kapal = valid($conn, $data['nama_kapal']);
    $kapasitas = valid($conn, $data['kapasitas']);
    $jenis_kapal = valid($conn, $data['jenis_kapal']);

    // Upload Image Ship
    if ($action != "delete") {
      if (!empty($_FILES['avatar']["name"])) {
        $path = "../assets/images/kapal/";
        $fileName = basename($_FILES["avatar"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["avatar"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $url_image = $baseURL . "assets/images/kapal/" . $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $_SESSION['message-danger'] = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $_SESSION['time-message'] = time();
          return false;
        }
      }
    }

    if ($action == "insert") {
      $check_nama = "SELECT * FROM kapal WHERE nama_kapal='$nama_kapal'";
      $checkNama = mysqli_query($conn, $check_nama);
      if (mysqli_num_rows($checkNama) > 0) {
        $_SESSION["message-danger"] = "Maaf, nama kapal yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
      $sql = "INSERT INTO kapal(img_kapal,nama_kapal,kapasitas,jenis_kapal) VALUES('$url_image','$nama_kapal','$kapasitas','$jenis_kapal')";
    }

    if ($action == "update") {
      $id_kapal = valid($conn, $data['id_kapal']);
      $nama_kapalOld = valid($conn, $data['nama_kapalOld']);
      if ($nama_kapal != $nama_kapalOld) {
        $check_nama = "SELECT * FROM kapal WHERE nama_kapal='$nama_kapal'";
        $checkNama = mysqli_query($conn, $check_nama);
        if (mysqli_num_rows($checkNama) > 0) {
          $_SESSION["message-danger"] = "Maaf, nama kapal yang anda masukan sudah terdaftar.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $avatar = valid($conn, $data['avatarOld']);
      if (!empty($_FILES['avatar']["name"])) {
        $unwanted_characters = $baseURL . "assets/images/kapal/";
        $remove_avatar = str_replace($unwanted_characters, "", $avatar);
        if ($remove_avatar != "default.jpg") {
          unlink($path . $remove_avatar);
        }
      } else if (empty($_FILE['avatar']["name"])) {
        $url_image = $avatar;
      }
      $sql = "UPDATE kapal SET img_kapal='$url_image', nama_kapal='$nama_kapal', kapasitas='$kapasitas', jenis_kapal='$jenis_kapal' WHERE id_kapal='$id_kapal'";
    }

    if ($action == "delete") {
      $id_kapal = valid($conn, $data['id_kapal']);
      $avatar = valid($conn, $data['avatarOld']);
      $path = "../assets/images/kapal/";
      $unwanted_characters = $baseURL . "assets/images/kapal/";
      $remove_avatar = str_replace($unwanted_characters, "", $avatar);
      unlink($path . $remove_avatar);
      $sql = "DELETE FROM kapal WHERE id_kapal='$id_kapal'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function pelabuhan($conn, $data, $action, $baseURL)
  {
    $nama_pelabuhan = valid($conn, $data['nama_pelabuhan']);
    $kota = valid($conn, $data['kota']);

    // Upload Image Ship
    if ($action != "delete") {
      if (!empty($_FILES['avatar']["name"])) {
        $path = "../assets/images/pelabuhan/";
        $fileName = basename($_FILES["avatar"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["avatar"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $url_image = $baseURL . "assets/images/pelabuhan/" . $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $_SESSION['message-danger'] = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $_SESSION['time-message'] = time();
          return false;
        }
      }
    }

    if ($action == "insert") {
      $check_nama = "SELECT * FROM pelabuhan WHERE nama_pelabuhan='$nama_pelabuhan'";
      $checkNama = mysqli_query($conn, $check_nama);
      if (mysqli_num_rows($checkNama) > 0) {
        $_SESSION["message-danger"] = "Maaf, nama pelabuhan yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
      $sql = "INSERT INTO pelabuhan(img_pelabuhan,nama_pelabuhan,kota) VALUES('$url_image','$nama_pelabuhan','$kota')";
    }

    if ($action == "update") {
      $id = valid($conn, $data['id']);
      $nama_pelabuhanOld = valid($conn, $data['nama_pelabuhanOld']);
      if ($nama_pelabuhan != $nama_pelabuhanOld) {
        $check_nama = "SELECT * FROM pelabuhan WHERE nama_pelabuhan='$nama_pelabuhan'";
        $checkNama = mysqli_query($conn, $check_nama);
        if (mysqli_num_rows($checkNama) > 0) {
          $_SESSION["message-danger"] = "Maaf, nama pelabuhan yang anda masukan sudah terdaftar.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $avatar = valid($conn, $data['avatarOld']);
      if (!empty($_FILES['avatar']["name"])) {
        $unwanted_characters = $baseURL . "assets/images/pelabuhan/";
        $remove_avatar = str_replace($unwanted_characters, "", $avatar);
        if ($remove_avatar != "default.jpg") {
          unlink($path . $remove_avatar);
        }
      } else if (empty($_FILE['avatar']["name"])) {
        $url_image = $avatar;
      }
      $sql = "UPDATE pelabuhan SET img_pelabuhan='$url_image', nama_pelabuhan='$nama_pelabuhan', kota='$kota' WHERE id='$id'";
    }

    if ($action == "delete") {
      $id = valid($conn, $data['id']);
      $avatar = valid($conn, $data['avatarOld']);
      $path = "../assets/images/pelabuhan/";
      $unwanted_characters = $baseURL . "assets/images/pelabuhan/";
      $remove_avatar = str_replace($unwanted_characters, "", $avatar);
      unlink($path . $remove_avatar);
      $sql = "DELETE FROM pelabuhan WHERE id='$id'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function rute($conn, $data, $action)
  {
    $cabang = valid($conn, $data['cabang']);
    $pelabuhan_asal = valid($conn, $data['pelabuhan_asal']);
    $pelabuhan_tujuan = valid($conn, $data['pelabuhan_tujuan']);
    $jarak = valid($conn, $data['jarak']);

    if ($action == "insert") {
      $sql = "INSERT INTO rute(cabang,pelabuhan_asal,pelabuhan_tujuan,jarak) VALUES('$cabang','$pelabuhan_asal','$pelabuhan_tujuan','$jarak')";
    }

    if ($action == "update") {
      $id_rute = valid($conn, $data['id_rute']);
      $sql = "UPDATE rute SET cabang='$cabang', pelabuhan_asal='$pelabuhan_asal', pelabuhan_tujuan='$pelabuhan_tujuan', jarak='$jarak' WHERE id_rute='$id_rute'";
    }

    if ($action == "delete") {
      $id_rute = valid($conn, $data['id_rute']);
      $sql = "DELETE FROM rute WHERE id_rute='$id_rute'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function jadwal($conn, $data, $action)
  {
    $id_kapal = valid($conn, $data['id_kapal']);
    $id_rute = valid($conn, $data['id_rute']);
    $tanggal_berangkat = valid($conn, $data['tanggal_berangkat']);
    $jam_berangkat = valid($conn, $data['jam_berangkat']);

    if ($action == "insert") {
      $sql = "INSERT INTO jadwal(id_kapal,id_rute,tanggal_berangkat,jam_berangkat) VALUES('$id_kapal','$id_rute','$tanggal_berangkat','$jam_berangkat')";
    }

    if ($action == "update") {
      $id_jadwal = valid($conn, $data['id_jadwal']);
      $sql = "UPDATE jadwal SET id_kapal='$id_kapal', id_rute='$id_rute', tanggal_berangkat='$tanggal_berangkat', jam_berangkat='$jam_berangkat' WHERE id_jadwal='$id_jadwal'";
    }

    if ($action == "delete") {
      $id_jadwal = valid($conn, $data['id_jadwal']);
      $sql = "DELETE FROM jadwal WHERE id_jadwal='$id_jadwal'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function pelayaran($conn, $data, $action)
  {
    $id_jadwal = valid($conn, $data['id_jadwal']);
    $penumpang = valid($conn, $data['penumpang']);
    $golongan = valid($conn, $data['golongan']);
    $kendaraan = valid($conn, $data['kendaraan']);
    $harga = valid($conn, $data['harga']);

    if ($action == "insert") {
      $sql = "INSERT INTO pelayaran(id_jadwal,penumpang,golongan,kendaraan,harga) VALUES('$id_jadwal','$penumpang','$golongan','$kendaraan','$harga')";
    }

    if ($action == "update") {
      $id_pelayaran = valid($conn, $data['id_pelayaran']);
      $sql = "UPDATE pelayaran SET id_jadwal='$id_jadwal', penumpang='$penumpang', golongan='$golongan', kendaraan='$kendaraan', harga='$harga' WHERE id_pelayaran='$id_pelayaran'";
    }

    if ($action == "delete") {
      $id_pelayaran = valid($conn, $data['id_pelayaran']);
      $sql = "DELETE FROM pelayaran WHERE id_pelayaran='$id_pelayaran'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function informasi($conn, $data, $action)
  {
    $informasi = $data['informasi'];

    if ($action == "insert") {
      $sql = "INSERT INTO informasi(informasi) VALUES('$informasi')";
    }

    if ($action == "update") {
      $id = valid($conn, $data['id']);
      $sql = "UPDATE informasi SET informasi='$informasi', tgl_informasi=current_timestamp WHERE id='$id'";
    }

    if ($action == "delete") {
      $id = valid($conn, $data['id']);
      $sql = "DELETE FROM informasi WHERE id='$id'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function galeri($conn, $data, $action, $baseURL)
  {
    if ($action == "insert") {
      if (!empty($_FILES['avatar']['name'])) {
        $files = $_FILES['avatar'];
        $upload_directory = "../assets/images/galeri/";

        for ($i = 0; $i < count($files['name']); $i++) {
          $file_name = $files['name'][$i];
          $file_tmp = $files['tmp_name'][$i];
          $file_size = $files['size'][$i];

          if ($file_size > 2097152) {
            $_SESSION['message-danger'] = "Ukuran file harus tepat 2 MB";
            $_SESSION['time-message'] = time();
            return false;
          }

          $fileName = str_replace(" ", "-", $file_name);
          $fileName_encrypt = crc32($fileName);
          $ekstensiGambar = explode('.', $fileName);
          $ekstensiGambar = strtolower(end($ekstensiGambar));
          $imageUploadPath = $upload_directory . $fileName_encrypt . "." . $ekstensiGambar;
          $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
          $allowTypes = array('jpg', 'png', 'jpeg');
          if (in_array($fileType, $allowTypes)) {
            compressImage($file_tmp, $imageUploadPath, 75);
            $url_image = $baseURL . "assets/images/galeri/" . $fileName_encrypt . "." . $ekstensiGambar;
            mysqli_query($conn, "INSERT INTO galeri(slug_image) VALUES('$url_image')");
          } else {
            $_SESSION['message-danger'] = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
      }
    }

    if ($action == "delete") {
      $id = valid($conn, $data['id']);
      $avatar = valid($conn, $data['avatarOld']);
      $path = "../assets/images/galeri/";
      $unwanted_characters = $baseURL . "assets/images/galeri/";
      $remove_avatar = str_replace($unwanted_characters, "", $avatar);
      unlink($path . $remove_avatar);
      $sql = "DELETE FROM galeri WHERE id='$id'";
      mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
  }
  function tiket($conn, $data, $action)
  {
    $status_pembayaran = valid($conn, $data['status_pembayaran']);
    $qr_code = valid($conn, $data['qr_code']);

    if ($action == "insert") {
    }

    if ($action == "update") {
      $id_tiket = valid($conn, $data['id_tiket']);
      $nomor_telepon = valid($conn, $data['nomor_telepon']);
      if ($status_pembayaran == "Gagal") {
        $pesan_status = "Maaf pembayaran gagal diterima, silakan masukan bukti pembayaran yang semestinya sesuai tiket anda!";
      } else if ($status_pembayaran == "Diterima") {
        $pesan_status = "Selamat pembayaran berhasil, bukti pembayaran anda berhasil diterima dengan baik oleh petugas kami. Silakan masuk ke akun kamu dan tunjukan tiket saat ingin memasuki kapal.";
        $qr_code = qrcode($id_tiket);
      }

      // Send to Whatsapp
      $target = $nomor_telepon;
      $pesan = "Pembayaran kamu *" . $status_pembayaran . "*. Silakan lihat tiket kamu disini👉 http://127.0.0.1:1010/apps/asdp-kupang/views/tiket";
      WAAPI($target, $pesan);

      if ($status_pembayaran == "Gagal") {
        $sql = "UPDATE tiket SET status_pembayaran='$status_pembayaran' WHERE id_tiket='$id_tiket'";
      } else if ($status_pembayaran == "Diterima") {
        $sql = "UPDATE tiket SET status_pembayaran='$status_pembayaran', qr_code='$qr_code' WHERE id_tiket='$id_tiket'";
      }
    }

    if ($action == "delete") {
      $id_tiket = valid($conn, $data['id_tiket']);
      $sql = "DELETE FROM tiket WHERE id_tiket='$id_tiket'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function pembayaran($conn, $data, $action, $baseURL, $idUser)
  {
    $id_tiket = valid($conn, $data['id_tiket']);
    $total_bayar = valid($conn, $data['total_bayar']);

    // Upload Image Ship
    if ($action != "delete") {
      $path = "../assets/images/pembayaran/";
      $fileName = basename($_FILES["avatar"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["avatar"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $url_image = $baseURL . "assets/images/pembayaran/" . $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $_SESSION['message-danger'] = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
        $_SESSION['time-message'] = time();
        return false;
      }
    }

    if ($action == "insert") {
      $check_tgl = "SELECT jadwal.tanggal_berangkat, jadwal.jam_berangkat FROM tiket JOIN pelayaran ON tiket.id_pelayaran = pelayaran.id_pelayaran JOIN jadwal ON pelayaran.id_jadwal = jadwal.id_jadwal WHERE tiket.id_penumpang = '$idUser' AND jadwal.tanggal_berangkat <= CURDATE() AND jadwal.jam_berangkat <= CURTIME()";
      $checkTgl = mysqli_query($conn, $check_tgl);
      if (mysqli_num_rows($checkTgl) > 0) {
        $_SESSION['message-danger'] = "Maaf, tiket anda telah dianggap hangus atau tidak dapat dipakai. Silakan menunggu jadwal pelayaran berikutnya!.";
        $_SESSION['time-message'] = time();
        return false;
      }
      $sql = "INSERT INTO pembayaran(id_tiket,bukti_bayar,total_bayar) VALUES('$id_tiket','$url_image','$total_bayar');";
      $sql .= "UPDATE tiket SET status_pembayaran='Checking' WHERE id_tiket='$id_tiket';";
      mysqli_multi_query($conn, $sql);
    }

    if ($action == "update") {
      $avatarOld = valid($conn, $data['avatarOld']);
      $unwanted_characters = $baseURL . "assets/images/pembayaran/";
      $remove_avatar = str_replace($unwanted_characters, "", $avatarOld);
      if ($remove_avatar != "default.jpg") {
        unlink($path . $remove_avatar);
      }
      $sql = "UPDATE pembayaran SET bukti_bayar='$url_image' WHERE id_tiket='$id_tiket';";
      $sql .= "UPDATE tiket SET status_pembayaran='Checking' WHERE id_tiket='$id_tiket';";
      mysqli_multi_query($conn, $sql);
    }

    if ($action == "delete") {
    }

    return mysqli_affected_rows($conn);
  }
}
