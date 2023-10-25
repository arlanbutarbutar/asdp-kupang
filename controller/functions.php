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
function generateRandomCode($length = 6)
{
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $code = '';
  for ($i = 0; $i < $length; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $code;
}
function daftar_pelayaran($conn, $data)
{
  $checkPenumpang = mysqli_query($conn, "SELECT * FROM penumpang ORDER BY id_penumpang DESC LIMIT 1");
  if (mysqli_num_rows($checkPenumpang) > 0) {
    $row = mysqli_fetch_assoc($checkPenumpang);
    $lastIdPenumpang = $row['id_penumpang'];
  } else {
    $lastIdPenumpang = 0;
  }
  $nama = $data['nama'];
  $id_kelas = $data['id_kelas'];
  $id_jk = $data['id_jk'];
  $umur = $data['umur'];
  $alamat = $data['alamat'];
  $id_golongan = valid($conn, $data['id_golongan']);
  $nomor_telepon = valid($conn, $data['nomor_telepon']);
  $id_jadwal = valid($conn, $data['id_jadwal']);
  $no_pemesanan = generateRandomCode(6);

  $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE nomor_telepon='$nomor_telepon'");
  if (mysqli_num_rows($checkAccount) > 0) {
    $row = mysqli_fetch_assoc($checkAccount);
    $nomor_tlpn = $row['nomor_telepon'];
    $id_user = $row['id_user'];
    if ($row['id_status'] == 2) {
      $_SESSION["message-danger"] = "Maaf, akun anda belum diaktivasi. Silakan cek whatsapp anda kembali";
      $_SESSION["time-message"] = time();
      return false;
    } else {
      $en_user = crc32($nomor_telepon);
      for ($i = 0; $i < count($nama); $i++) {
        $id_penumpang = $lastIdPenumpang + 1;
        mysqli_query($conn, "INSERT INTO penumpang (id_penumpang, id_kelas, nama, id_jk, umur, alamat) VALUES ('$id_penumpang', '$id_kelas[$i]', '$nama[$i]', '$id_jk[$i]', '$umur[$i]', '$alamat[$i]')");
        mysqli_query($conn, "INSERT INTO pemesanan (id_user, id_jadwal, id_penumpang, id_golongan, no_pemesanan) VALUES ('$id_user', '$id_jadwal', '$id_penumpang', '$id_golongan', '$no_pemesanan')");
        $lastIdPenumpang = $id_penumpang;
      }

      // Send to Whatsapp
      $target = $nomor_telepon;
      $pesan = "Terima kasih telah memesan tiket perjalanan dari ASDP Cabang Kupang. Untuk melanjutkan silakan klik link berikut untuk proses pembayaran: http://127.0.0.1:1010/apps/asdp-kupang/auth/index?tlpn=$nomor_tlpn";
      WAAPI($target, $pesan);

      return mysqli_affected_rows($conn);
    }
  } else {
    $checkAccount = mysqli_query($conn, "SELECT * FROM users ORDER BY id_user DESC LIMIT 1");
    if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      $id_user = $row['id_user'] + 1;
    } else {
      $id_user = 1;
    }
    $en_user = crc32($nomor_telepon);
    mysqli_query($conn, "INSERT INTO users(id_user,en_user,username,nomor_telepon) VALUES('$id_user','$en_user','penumpang_$en_user','$nomor_telepon')");
    for ($i = 0; $i < count($nama); $i++) {
      $id_penumpang = $lastIdPenumpang + 1;
      mysqli_query($conn, "INSERT INTO penumpang (id_penumpang, id_kelas, nama, id_jk, umur, alamat) VALUES ('$id_penumpang', '$id_kelas[$i]', '$nama[$i]', '$id_jk[$i]', '$umur[$i]', '$alamat[$i]')");
      mysqli_query($conn, "INSERT INTO pemesanan (id_user, id_jadwal, id_penumpang, id_golongan, no_pemesanan) VALUES ('$id_user', '$id_jadwal', '$id_penumpang', '$id_golongan', '$no_pemesanan')");
      $lastIdPenumpang = $id_penumpang;
    }

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
          $sql = "UPDATE account_bank SET an='$an', bank='$bank', norek='$norek' WHERE id_bank='$id'";
        }
      }
    }

    if ($action == "delete") {
      $id = valid($conn, $data['id']);
      $sql = "DELETE FROM account_bank WHERE id_bank='$id'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function kelas($conn, $data, $action)
  {
    $nama_kelas = valid($conn, $data['nama_kelas']);
    $harga_kelas = valid($conn, $data['harga_kelas']);

    if ($action == "insert") {
      $kelas = "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas'";
      $check_kelas = mysqli_query($conn, $kelas);
      if (mysqli_num_rows($check_kelas) > 0) {
        $_SESSION["message-danger"] = "Maaf, nama kelas yang anda masukan sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      } else {
        $sql = "INSERT INTO kelas(nama_kelas,harga_kelas) VALUES('$nama_kelas','$harga_kelas')";
      }
    }

    if ($action == "update") {
      $id_kelas = valid($conn, $data['id_kelas']);
      $nama_kelasOld = valid($conn, $data['nama_kelasOld']);
      if ($nama_kelas != $nama_kelasOld) {
        $kelas = "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas'";
        $check_kelas = mysqli_query($conn, $kelas);
        if (mysqli_num_rows($check_kelas) > 0) {
          $_SESSION["message-danger"] = "Maaf, nama kelas yang anda masukan sudah ada.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $sql = "UPDATE kelas SET nama_kelas='$nama_kelas', harga_kelas='$harga_kelas' WHERE id_kelas='$id_kelas'";
    }

    if ($action == "delete") {
      $id_kelas = valid($conn, $data['id_kelas']);
      $sql = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function golongan($conn, $data, $action)
  {
    $nama_golongan = valid($conn, $data['nama_golongan']);
    $harga_golongan = valid($conn, $data['harga_golongan']);

    if ($action == "insert") {
      $golongan = "SELECT * FROM golongan WHERE nama_golongan='$nama_golongan'";
      $check_golongan = mysqli_query($conn, $golongan);
      if (mysqli_num_rows($check_golongan) > 0) {
        $_SESSION["message-danger"] = "Maaf, nama golongan yang anda masukan sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      } else {
        $sql = "INSERT INTO golongan(nama_golongan,harga_golongan) VALUES('$nama_golongan','$harga_golongan')";
      }
    }

    if ($action == "update") {
      $id_golongan = valid($conn, $data['id_golongan']);
      $nama_golonganOld = valid($conn, $data['nama_golonganOld']);
      if ($nama_golongan != $nama_golonganOld) {
        $golongan = "SELECT * FROM golongan WHERE nama_golongan='$nama_golongan'";
        $check_golongan = mysqli_query($conn, $golongan);
        if (mysqli_num_rows($check_golongan) > 0) {
          $_SESSION["message-danger"] = "Maaf, nama golongan yang anda masukan sudah ada.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $sql = "UPDATE golongan SET nama_golongan='$nama_golongan', harga_golongan='$harga_golongan' WHERE id_golongan='$id_golongan'";
    }

    if ($action == "delete") {
      $id_golongan = valid($conn, $data['id_golongan']);
      $sql = "DELETE FROM golongan WHERE id_golongan='$id_golongan'";
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
  function pembayaran($conn, $data, $action, $baseURL, $idUser)
  {
    $no_pemesanan = valid($conn, $data['no_pemesanan']);
    $id_bank = valid($conn, $data['id_bank']);
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
      $check_tgl = "SELECT jadwal.tanggal_berangkat, jadwal.jam_berangkat FROM pemesanan JOIN jadwal ON pemesanan.id_jadwal = jadwal.id_jadwal WHERE pemesanan.id_user = '$idUser' AND jadwal.tanggal_berangkat <= CURDATE() AND jadwal.jam_berangkat <= CURTIME()";
      $checkTgl = mysqli_query($conn, $check_tgl);
      if (mysqli_num_rows($checkTgl) > 0) {
        $_SESSION['message-danger'] = "Maaf, pemesanan tiket anda telah dianggap hangus atau tidak dapat dipakai. Silakan menunggu jadwal pelayaran berikutnya!.";
        $_SESSION['time-message'] = time();
        return false;
      }
      $sql = "INSERT INTO pembayaran(no_pemesanan,id_bank,bukti_bayar,total_bayar) VALUES('$no_pemesanan','$id_bank','$url_image','$total_bayar')";
      mysqli_query($conn, $sql);
    }

    if ($action == "update") {
      $avatarOld = valid($conn, $data['avatarOld']);
      $unwanted_characters = $baseURL . "assets/images/pembayaran/";
      $remove_avatar = str_replace($unwanted_characters, "", $avatarOld);
      if ($remove_avatar != "default.jpg") {
        unlink($path . $remove_avatar);
      }
      $sql = "UPDATE pembayaran SET id_bank='$id_bank', bukti_bayar='$url_image', status_pembayaran='Checking' WHERE no_pemesanan='$no_pemesanan'";
      mysqli_query($conn, $sql);
    }

    if ($action == "delete") {
    }

    return mysqli_affected_rows($conn);
  }
  function pembayaran_checking($conn, $data, $action, $nomor_telepon)
  {
    $status_pembayaran = valid($conn, $data['status_pembayaran']);

    if ($action == "insert") {
    }

    if ($action == "update") {
      $id_pembayaran = valid($conn, $data['id_pembayaran']);
      $id_jadwal = valid($conn, $data['id_jadwal']);
      $no_pemesanan = valid($conn, $data['no_pemesanan']);
      if ($status_pembayaran == "Gagal") {
        $pesan = "Maaf pembayaran gagal diterima, silakan masukan bukti pembayaran yang semestinya sesuai tiket anda!. Lihat tiket kamu disini👉 http://127.0.0.1:1010/apps/asdp-kupang/views/tiket";
        $sql = "UPDATE pembayaran SET status_pembayaran='$status_pembayaran' WHERE id_pembayaran='$id_pembayaran'";
        mysqli_query($conn, $sql);
      } else if ($status_pembayaran == "Diterima") {
        $pesan = "Selamat pembayaran berhasil, bukti pembayaran anda berhasil diterima dengan baik oleh petugas kami. Silakan masuk ke akun kamu dan tunjukan tiket saat ingin memasuki kapal. Lihat tiket kamu disini👉 http://127.0.0.1:1010/apps/asdp-kupang/views/tiket";
        $sql = "UPDATE pembayaran SET status_pembayaran='$status_pembayaran' WHERE id_pembayaran='$id_pembayaran'";
        mysqli_query($conn, $sql);
        $pemesanan = "SELECT * FROM pemesanan JOIN penumpang ON pemesanan.id_penumpang=penumpang.id_penumpang WHERE pemesanan.no_pemesanan='$no_pemesanan' AND pemesanan.id_status=1";
        $takePemesanan = mysqli_query($conn, $pemesanan);
        if (mysqli_num_rows($takePemesanan) > 0) {
          while ($row = mysqli_fetch_assoc($takePemesanan)) {
            $id_penumpang = $row['id_penumpang'];
            $check_tiket = "SELECT * FROM tiket WHERE id_jadwal='$id_jadwal' ORDER BY no_tiket DESC LIMIT 1";
            $checkTiket = mysqli_query($conn, $check_tiket);
            if (mysqli_num_rows($checkTiket) > 0) {
              $rowTiket = mysqli_fetch_assoc($checkTiket);
              $no_tiket = $rowTiket['no_tiket'] + 1;
            } else if (mysqli_num_rows($checkTiket) == 0) {
              $no_tiket = 1;
            }
            $qr_code = qrcode($no_pemesanan . $no_tiket);
            $sql = "INSERT INTO tiket(id_jadwal,id_penumpang,no_tiket,qr_code) VALUES('$id_jadwal','$id_penumpang','$no_tiket','$qr_code')";
            mysqli_query($conn, $sql);
          }
        }
      }
      // Send to Whatsapp
      $target = $nomor_telepon;
      WAAPI($target, $pesan);
    }

    if ($action == "delete") {
    }

    return mysqli_affected_rows($conn);
  }
  function pemesanan($conn, $data, $action)
  {

    if ($action == "insert") {
    }

    if ($action == "update") {
      $id_pemesanan = valid($conn, $data['id_pemesanan']);
      $no_pemesanan = valid($conn, $data['no_pemesanan']);
      $id_penumpang = valid($conn, $data['id_penumpang']);
      $harga = valid($conn, $data['harga']);
      $pembayaran = "SELECT * FROM pembayaran WHERE no_pemesanan='$no_pemesanan'";
      $takePembayaran = mysqli_query($conn, $pembayaran);
      if (mysqli_num_rows($takePembayaran) == 0) {
        mysqli_query($conn, "DELETE FROM pemesanan WHERE id_pemesanan='$id_pemesanan'");
      } else if (mysqli_num_rows($takePembayaran) > 0) {
        $check_pemesanan = "SELECT * FROM pemesanan JOIN jadwal ON pemesanan.id_jadwal=jadwal.id_jadwal WHERE pemesanan.id_pemesanan='$id_pemesanan' AND jadwal.tanggal_berangkat >= CURDATE() AND jadwal.jam_berangkat >= CURTIME()";
        $checkPemesanan = mysqli_query($conn, $check_pemesanan);
        if (mysqli_num_rows($checkPemesanan) > 0) {
          $row = mysqli_fetch_assoc($takePembayaran);
          $total_bayar = $row['total_bayar'] - $harga;
          if ($total_bayar > 0) {
            mysqli_query($conn, "UPDATE pembayaran SET total_bayar='$total_bayar' WHERE no_pemesanan='$no_pemesanan'");
          } else if ($total_bayar == 0) {
            mysqli_query($conn, "UPDATE pembayaran SET total_bayar='$total_bayar', status_pembayaran='Dibatalkan' WHERE no_pemesanan='$no_pemesanan'");
          }
          mysqli_query($conn, "UPDATE pemesanan SET id_status='2', tgl_batal=current_timestamp WHERE id_pemesanan='$id_pemesanan'");
          mysqli_query($conn, "DELETE FROM tiket WHERE id_penumpang='$id_penumpang'");
        } else if (mysqli_num_rows($checkPemesanan) == 0) {
          $_SESSION['message-danger'] = "Maaf, anda tidak dapat membatalkan karena sudah melewati jadwal pelayaran.";
          $_SESSION['time-message'] = time();
          return false;
        }
      }
    }

    if ($action == "delete") {
    }

    return mysqli_affected_rows($conn);
  }
}
