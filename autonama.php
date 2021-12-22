<?php
include "include/config.php"; //Include file koneksi
$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

$sql="SELECT * FROM tbl_pegawai WHERE pegawai LIKE '%$searchTerm%' ORDER BY pegawai ASC"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

$hasil=mysqli_query($config,$sql); //Query dieksekusi

//Disajikan dengan menggunakan perulangan
while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['pegawai'];
}
//Nilainya disimpan dalam bentuk json
echo json_encode($data);
?>