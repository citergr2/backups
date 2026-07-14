<?php
require 'kunci.php';
$id = (int)$_GET['id'];

$q = $conn->query("SELECT gambar FROM produk WHERE id=$id");
$p = $q->fetch_assoc();

if(!empty($p['gambar'])) {
    $target_file = "/needtech/uploads/" . $p['gambar'];
    if(file_exists($target_file)) unlink($target_file);
}

$conn->query("DELETE FROM produk WHERE id=$id");

// Kembali ke dashboard dengan membawa status sukses
header("Location: dashboard.php?status=sukses");
?>
