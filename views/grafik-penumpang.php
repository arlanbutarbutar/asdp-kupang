<?php require_once("../controller/script.php");

// Query untuk mengambil data penduduk berdasarkan jenis kelamin dalam satu tahun (misalnya tahun 2023)
$year = date('Y');
$sql = "SELECT jk.jenis_kelamin, MONTH(tiket.tgl_jalan) AS bulan, COUNT(*) AS total 
        FROM penumpang 
        JOIN jk ON penumpang.id_jk=jk.id_jk 
        JOIN tiket ON penumpang.id_penumpang=tiket.id_penumpang 
        WHERE YEAR(tiket.tgl_jalan) = '$year' 
        GROUP BY jk.jenis_kelamin, MONTH(tiket.tgl_jalan) 
        ORDER BY jk.jenis_kelamin";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = array(
    'gender' => $row['jenis_kelamin'],
    'bulan' => (int)$row['bulan'],
    'total' => (int)$row['total'],
  );
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
