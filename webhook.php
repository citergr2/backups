<?php
require __DIR__ . '/config.php';

$nama   = trim($_REQUEST['nama'] ?? '');
$harga  = trim($_REQUEST['harga'] ?? '');
$produk = trim($_REQUEST['produk'] ?? '');
$kode_unik = trim($_REQUEST['kode_unik'] ?? '');
$link_mf = trim($_REQUEST['link_mf'] ?? '');
$status = trim($_REQUEST['status'] ?? 'menunggu');

$harga = preg_replace('/[^0-9]/', '', $harga);

if ($nama && $harga && $produk) {
  $simpan = mysqli_query($koneksi, "INSERT INTO pesanan 
    (nama, produk, link_mf, harga, kode_unik, status, waktu) 
    VALUES ('$nama', '$produk', '$link_mf', '$harga', '$kode_unik', '$status', NOW())");

  if ($simpan) echo "OK";
  else echo "ERROR: " . mysqli_error($koneksi);
}
?>
