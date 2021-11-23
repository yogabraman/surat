<?php
include "include/config.php"; //Include file koneksi
$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

$sql="SELECT * FROM tbl_surat_masuk WHERE asal_surat LIKE '%$searchTerm%' ORDER BY asal_surat ASC"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

$hasil=mysqli_query($config,$sql); //Query dieksekusi

//Disajikan dengan menggunakan perulangan
while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['asal_surat'];
}
//Nilainya disimpan dalam bentuk json
echo json_encode($data);
?>