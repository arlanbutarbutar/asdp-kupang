<?php require_once("support_code.php");
if (!isset($_SESSION["data-user"])) {
  function masuk($data)
  {
    global $conn;
    $email = valid($data["email"]);
    $password = valid($data["password"]);

    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) == 0) {
      $_SESSION["message-danger"] = "Maaf, akun yang anda masukan belum terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    } else if (mysqli_num_rows($checkAccount) > 0) {
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
    }
  }
}
if (isset($_SESSION["data-user"])) {
  function edit_profile($data)
  {
    global $conn, $idUser;
    $username = valid($data["username"]);
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$idUser'");
    return mysqli_affected_rows($conn);
  }
  function add_user($data)
  {
    global $conn;
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
      $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users(username,email,password) VALUES('$username','$email','$password')");
    return mysqli_affected_rows($conn);
  }
  function edit_user($data)
  {
    global $conn, $time;
    $id_user = valid($data["id-user"]);
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $emailOld = valid($data["emailOld"]);
    if ($email != $emailOld) {
      $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
      if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $updated_at = date("Y-m-d " . $time);
    mysqli_query($conn, "UPDATE users SET username='$username', email='$email', updated_at='$updated_at' WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
  function delete_user($data)
  {
    global $conn;
    $id_user = valid($data["id-user"]);
    mysqli_query($conn, "DELETE FROM users WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
}
