<?php require_once("../controller/script.php");

// Menerima ID pesanan dari permintaan POST
$id_pemesanan = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['id']))));

$sql = "UPDATE pemesanan SET id_status='2', tgl_batal=current_timestamp WHERE id_pemesanan='$id_pemesanan'";
$result = $conn->query($sql);

if ($result === TRUE) {
  // echo "Status pesanan berhasil diperbarui.";
} else {
  // echo "Gagal memperbarui status pesanan: " . $conn->error;
}

$conn->close();
