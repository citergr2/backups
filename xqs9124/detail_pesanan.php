<?php
require 'kunci.php';

// 1. SET ZONA WAKTU KE WIB (ASIA/JAKARTA)
date_default_timezone_set('Asia/Jakarta');

// 2. Proses Hapus
if (isset($_GET['hapus']) && isset($_GET['id'])) {
    $id_hapus = (int)$_GET['id'];
    $conn->query("DELETE FROM pesanan WHERE id = $id_hapus");
    echo "<script>alert('✅ Pesanan berhasil dihapus!'); window.location='pesanan.php';</script>";
    exit;
}

// 3. Ambil data pesanan
$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM pesanan WHERE id=$id");
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='pesanan.php';</script>";
    exit;
}

// 4. KONVERSI WAKTU AGAR AKURAT WIB
$waktu_mentah = $data['waktu'] ?? null;
if ($waktu_mentah) {
    // Membuat objek DateTime dari database
    $date = new DateTime($waktu_mentah);
    // Memaksa zona waktu ke Jakarta (WIB)
    $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
    $waktu_tampil = $date->format('d M Y, H:i:s');
} else {
    $waktu_tampil = '-';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan - XITERCSX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background:#0f0f0f; color:#e0e0e0; padding:20px; }
        .container { background:#1a1a1a; padding:25px; border-radius:12px; border:1px solid #333; }
        p { margin-bottom:15px; color:#aaa; font-size: 14px; }
        strong { color:#fff; display: block; font-size: 16px; margin-top: 5px; }
        .btn-kembali { display:block; text-align:center; margin-top:30px; color:#2563eb; text-decoration:none; font-weight:bold; }
        .btn-hapus { display:block; text-align:center; margin-top:20px; color:#ef4444; text-decoration:none; font-weight:bold; font-size: 14px; }
    </style>
</head>
<body>
    <h2 style="margin-bottom:20px;">🔍 Detail Pesanan #<?= $id ?></h2>
    <div class="container">
        <p>Nama Pembeli: <strong><?= htmlspecialchars($data['nama'] ?? '-') ?></strong></p>
        <p>Produk: <strong><?= htmlspecialchars($data['produk'] ?? '-') ?></strong></p>
        <p>Total Harga: <strong>Rp<?= number_format($data['harga'],0,',','.') ?></strong></p>
        <p>Status: <strong><?= htmlspecialchars($data['status'] ?? '-') ?></strong></p>
        <p>Waktu: <strong><?= $waktu_tampil ?> WIB</strong></p>

        <a href="pesanan.php" class="btn-kembali">← Kembali ke Daftar</a>

        <a href="detail_pesanan.php?id=<?= $id ?>&hapus=1"
           class="btn-hapus"
           onclick="return confirm('⚠️ Yakin ingin menghapus pesanan ini secara permanen?')">
           🗑️ Hapus Pesanan
        </a>
    </div>
</body>
</html>
