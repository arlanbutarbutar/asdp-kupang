<?php
function valid($conn, $value)
{
  $valid = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $value))));
  return $valid;
}
function separateAlphaNumeric($string)
{
  $alpha = "";
  $numeric = "";
  // Mengiterasi setiap karakter dalam string
  for ($i = 0; $i < strlen($string); $i++) {
    // Memeriksa apakah karakter adalah huruf
    if (ctype_alpha($string[$i])) {
      $alpha .= $string[$i];
    }
    // Memeriksa apakah karakter adalah angka
    if (ctype_digit($string[$i])) {
      $numeric .= $string[$i];
    }
  }
  // Mengembalikan array yang berisi huruf dan angka terpisah
  return array(
    "alpha" => $alpha,
    "numeric" => $numeric
  );
}
function compressImage($source, $destination, $quality)
{
  // mendapatkan info image
  $imgInfo = getimagesize($source);
  $mime = $imgInfo['mime'];
  // membuat image baru
  switch ($mime) {
      // proses kode memilih tipe tipe image 
    case 'image/jpeg':
      $image = imagecreatefromjpeg($source);
      break;
    case 'image/png':
      $image = imagecreatefrompng($source);
      break;
    default:
      $image = imagecreatefromjpeg($source);
  }

  // Menyimpan image dengan ukuran yang baru
  imagejpeg($image, $destination, $quality);

  // Return image
  return $destination;
}
function qrcode($id_tiket)
{
  require_once('../assets/phpqrcode/qrlib.php');
  $qrvalue = "http://127.0.0.1:1010/apps/asdp-kupang/redirect?tiket=" . $id_tiket;
  $tempDir = "../assets/images/qrcode/";
  $codeContents = $qrvalue;
  $fileName = $id_tiket . ".jpg";
  $pngAbsoluteFilePath = $tempDir . $fileName;
  if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
  }
  return $fileName;
}