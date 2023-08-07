<?php require_once("support_code.php");
function daftar_pelayaran($conn, $data)
{
  $nama = valid($conn, $data['nama']);
  $id_jk = valid($conn, $data['id_jk']);
  $umur = valid($conn, $data['umur']);
  $alamat = valid($conn, $data['alamat']);
  $nomor_telepon = valid($conn, $data['nomor_telepon']);
  $email = valid($conn, $data['email']);
  $password = valid($conn, $data['password']);
  $len_password = strlen($password);
  $re_password = valid($conn, $data['re_password']);
  $akses = valid($conn, $data['akses']);
  $id_pelayaran = valid($conn, $data['id_pelayaran']);
  $harga = valid($conn, $data['harga']);
  $tgl_jalan = valid($conn, $data['tgl_jalan']);
  $jam_jalan = valid($conn, $data['jam_jalan']);

  if ($len_password < 8) {
    $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan kurang dari 8 karakter.";
    $_SESSION["time-message"] = time();
    return false;
  }
  if ($akses == 0) {
    if ($password != $re_password) {
      $_SESSION["message-danger"] = "Maaf, kata sandi yang kamu masukan belum sama.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $checkAccount = mysqli_query($conn, "SELECT * FROM penumpang ORDER BY id_penumpang DESC LIMIT 1");
    if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      $id_penumpang = $row['id_penumpang'] + 1;
    } else {
      $id_penumpang = 1;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $en_user = crc32($email);
    require("mail.php");
    $to       = $email;
    $subject  = 'Verifikasi Akun ASDP kamu sekarang!!';
    $message  = "<!doctype html>
        <html>
          <head>
            <meta name='viewport' content='width=device-width'>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <title>Verifikasi Akun</title>
          </head>
          <body>
            <img src='https://i.ibb.co/tPKPsRq/logo-asdp.png' style='width: 250px;'>
            <p>Selamat akun anda sudah terdaftar, tinggal satu langkah lagi anda sudah bisa menggunakan akun anda. Silakan verifikasi sekarang dengan mengklik tautan di bawah ini.</p>
            <a href='https://100154.tugasakhir.my.id/auth/index?auth=" . $password . "&crypt=" . $en_user . "' target='_blank' style='background-color: #ffffff; border: solid 1px #000; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; border-color: #000; color: #000;'>Verifikasi Sekarang</a>
          </body>
        </html>";
    smtp_mail($to, $subject, $message, '', '', 0, 0, true);
    $sql = "INSERT INTO penumpang(id_penumpang,en_user,nama,id_jk,umur,alamat,nomor_telepon,email,password) VALUES('$id_penumpang','$en_user','$nama','$id_jk','$umur','$alamat','$nomor_telepon','$email','$password');";
    $sql .= "INSERT INTO tiket(id_pelayaran,id_penumpang,harga,tgl_jalan,jam_jalan) VALUES('$id_pelayaran','$id_penumpang','$harga','$tgl_jalan','$jam_jalan');";
    mysqli_multi_query($conn, $sql);
  } else if ($akses == 1) {
    $checkAccount = mysqli_query($conn, "SELECT * FROM penumpang WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      $id_penumpang = $row['id_penumpang'];
      if ($row['id_status'] == 2) {
        $_SESSION["message-danger"] = "Maaf, akun anda belum diaktivasi. Silakan cek email anda kembali";
        $_SESSION["time-message"] = time();
        return false;
      } else {
        if (password_verify($password, $row["password"])) {
          $sql = "INSERT INTO tiket(id_pelayaran,id_penumpang,harga,tgl_jalan,jam_jalan) VALUES('$id_pelayaran','$id_penumpang','$harga','$tgl_jalan','$jam_jalan')";
          mysqli_query($conn, $sql);
          $_SESSION["data-user"] = [
            "id" => $row["id_penumpang"],
            "role" => $row["id_role"],
            "email" => $row["email"],
            "username" => $row["nama"],
          ];
        } else {
          $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
    }
  }

  return mysqli_affected_rows($conn);
}
if (!isset($_SESSION["data-user"])) {
  function daftar($conn, $data)
  {
    $nama = valid($conn, $data["nama"]);
    $id_jk = valid($conn, $data["id_jk"]);
    $umur = valid($conn, $data["umur"]);
    $alamat = valid($conn, $data["alamat"]);
    $nomor_telepon = valid($conn, $data["nomor_telepon"]);
    $email = valid($conn, $data["email"]);
    $password = valid($conn, $data["password"]);
    $re_password = valid($conn, $data["re_password"]);
    $len_password = strlen($password);

    $checkAccount = mysqli_query($conn, "SELECT * FROM penumpang WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) > 0) {
      $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
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
    $en_user = crc32($email);
    require("mail.php");
    $to       = $email;
    $subject  = 'Verifikasi Akun ASDP kamu sekarang!!';
    $message  = "<!doctype html>
      <html>
        <head>
          <meta name='viewport' content='width=device-width'>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Verifikasi Akun</title>
        </head>
        <body>
          <img src='https://i.ibb.co/tPKPsRq/logo-asdp.png' style='width: 250px;'>
          <p>Selamat akun anda sudah terdaftar, tinggal satu langkah lagi anda sudah bisa menggunakan akun anda. Silakan verifikasi sekarang dengan mengklik tautan di bawah ini.</p>
          <a href='https://100154.tugasakhir.my.id/auth/index?auth=" . $password . "&crypt=" . $en_user . "' target='_blank' style='background-color: #ffffff; border: solid 1px #000; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; border-color: #000; color: #000;'>Verifikasi Sekarang</a>
        </body>
      </html>";
    smtp_mail($to, $subject, $message, '', '', 0, 0, true);

    $sql = "INSERT INTO penumpang(en_user,nama,id_jk,umur,alamat,nomor_telepon,email,password) VALUES('$en_user','$nama','$id_jk','$umur','$alamat','$nomor_telepon','$email','$password')";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function masuk($conn, $data)
  {
    $email = valid($conn, $data["email"]);
    $password = valid($conn, $data["password"]);

    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($password, $row["password"])) {
        $_SESSION["data-user"] = [
          "id" => $row["id_user"],
          "role" => $row["id_role"],
          "email" => $row["email"],
          "username" => $row["username"],
        ];
      } else {
        $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
        $_SESSION["time-message"] = time();
        return false;
      }
    } else if (mysqli_num_rows($checkAccount) == 0) {
      $checkAccount = mysqli_query($conn, "SELECT * FROM penumpang WHERE email='$email'");
      if (mysqli_num_rows($checkAccount) > 0) {
        $row = mysqli_fetch_assoc($checkAccount);
        if ($row['id_status'] == 2) {
          $_SESSION["message-danger"] = "Maaf, akun anda belum diaktivasi. Silakan cek email anda kembali";
          $_SESSION["time-message"] = time();
          return false;
        } else {
          if (password_verify($password, $row["password"])) {
            $_SESSION["data-user"] = [
              "id" => $row["id_penumpang"],
              "role" => $row["id_role"],
              "email" => $row["email"],
              "username" => $row["nama"],
            ];
          } else {
            $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
            $_SESSION["time-message"] = time();
            return false;
          }
        }
      } else if (mysqli_num_rows($checkAccount) == 0) {
        $_SESSION["message-danger"] = "Maaf, akun yang anda masukan belum terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
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
    $email = valid($conn, $data["email"]);
    $password = valid($conn, $data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    if ($action == "insert") {
      $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
      if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
      $sql = "INSERT INTO users(username,email,password) VALUES('$username','$email','$password')";
      mysqli_query($conn, $sql);
    }

    if ($action == "update") {
      $id_user = valid($conn, $data["id-user"]);
      $emailOld = valid($conn, $data["emailOld"]);
      if ($email != $emailOld) {
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
          $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
          $_SESSION["time-message"] = time();
          return false;
        }
      }
      $sql = "UPDATE users SET username='$username', email='$email', updated_at=current_timestamp WHERE id_user='$id_user'";
      mysqli_query($conn, $sql);
    }

    if ($action == "delete") {
      $id_user = valid($conn, $data["id-user"]);
      $sql = "DELETE FROM users WHERE id_user='$id_user'";
      mysqli_query($conn, $sql);
    }

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
      $email = valid($conn, $data['email']);
      if ($status_pembayaran == "Gagal") {
        $pesan_status = "Maaf pembayaran gagal diterima, silakan masukan bukti pembayaran yang semestinya sesuai tiket anda!";
      } else if ($status_pembayaran == "Diterima") {
        $pesan_status = "Selamat pembayaran berhasil, bukti pembayaran anda berhasil diterima dengan baik oleh petugas kami. Silakan masuk ke akun kamu dan tunjukan tiket saat ingin memasuki kapal.";
        $qr_code = qrcode($id_tiket);
      }
      require("mail.php");
      $to       = $email;
      $subject  = 'Pembayaran Kamu ' . $status_pembayaran . '!!';
      $message  = "<!doctype html>
      <html>
        <head>
          <meta name='viewport' content='width=device-width'>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Status Pembayaran</title>
        </head>
        <body>
          <img src='https://i.ibb.co/tPKPsRq/logo-asdp.png' style='width: 250px;'>
          <p>" . $pesan_status . "</p>
          <a href='https://100154.tugasakhir.my.id/views/tiket' target='_blank' style='background-color: #ffffff; border: solid 1px #000; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; border-color: #000; color: #000;'>Lihat Tiket</a>
        </body>
      </html>";
      smtp_mail($to, $subject, $message, '', '', 0, 0, true);
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
