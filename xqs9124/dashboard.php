<?php
require 'kunci.php';

$total_produk = $conn->query("SELECT COUNT(*) FROM produk")->fetch_row()[0];
$total_nilai = $conn->query("SELECT SUM(harga) FROM produk")->fetch_row()[0];
$total_pesanan = $conn->query("SELECT COUNT(*) FROM pesanan WHERE status = 'pending'")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    body { background:#000; color:#fff; padding: 20px; padding-bottom: 100px; min-height: 100vh; }
    
    /* Header Admin */
    .header { display:flex; align-items:center; gap:15px; margin-bottom:30px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 20px; }
    .foto { width:55px; height:55px; border-radius:50%; background:#333; overflow:hidden; border: 2px solid #8b0000; }
    .foto img { width: 100%; height: 100%; object-fit: cover; }
    
    /* Stats */
    .stat { display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:25px; }
    .stat-card { background:rgba(255,255,255,0.03); backdrop-filter: blur(10px); padding:20px; border-radius:20px; border: 1px solid rgba(255,255,255,0.1); }
    .stat-judul { color:#a1a1aa; font-size:12px; }
    .stat-angka { font-size:20px; font-weight:bold; margin-top:5px; color:#fff; }
    
    /* List Produk */
    .head { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .btn-biru { background:#8b0000; color:#fff; padding:10px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:bold; }
    .item { background:rgba(255,255,255,0.03); backdrop-filter: blur(5px); padding:15px; border-radius:16px; margin-bottom:12px; display:flex; justify-content:space-between; align-items:center; border: 1px solid rgba(255,255,255,0.05); }
    .item-kiri { display: flex; align-items: center; gap: 15px; }
    .item-foto { width: 50px; height: 50px; border-radius: 12px; object-fit: cover; background: #27272A; }
    .aksi a { margin-left:15px; font-size:18px; text-decoration:none; cursor:pointer; }
    
    /* Navbar Bawah Admin */
    .nav-bawah { position:fixed; bottom:20px; left:50%; transform:translateX(-50%); width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); display:flex; justify-content:space-around; padding:15px; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); z-index:999; }
    .nav-btn { text-decoration:none; font-size:12px; font-weight:bold; color:#71717a; padding: 5px 10px; }
    .nav-btn.aktif { color:#fff; background: rgba(255,255,255,0.1); border-radius: 10px; }
  </style>
</head>
<body>

<div class="header">
  <div class="foto"><img src="logo.jpg" alt="Logo"></div>
  <div>
    <h2>Dashboard</h2>
    <p style="color:#a1a1aa; font-size:12px;">Admin Panel XITERCSX</p>
  </div>
</div>

<div class="stat">
  <div class="stat-card">
    <div class="stat-judul">Total Produk</div>
    <div class="stat-angka"><?= $total_produk ?></div>
  </div>
  <div class="stat-card">
    <div class="stat-judul">Nilai Aset</div>
    <div class="stat-angka">Rp<?= number_format($total_nilai ?: 0, 0, ',', '.') ?></div>
  </div>
</div>

<div class="head">
  <h3>Kelola Produk</h3>
  <a href="tambah.php" class="btn-biru">+ Produk</a>
</div>

<?php
$ambil = $conn->query("SELECT * FROM produk ORDER BY id DESC");
while($p = $ambil->fetch_assoc()) {
    $src_gambar = "../uploads/" . trim($p['gambar']);
?>
<div class="item">
  <div class="item-kiri">
    <img src="<?= $src_gambar ?>" class="item-foto" onerror="this.style.display='none'">
    <div>
        <strong style="font-size: 14px;"><?= htmlspecialchars($p['nama']) ?></strong><br>
        <small style="color:#60a5fa">Rp<?= number_format($p['harga'],0,',','.') ?></small>
    </div>
  </div>
  <div class="aksi">
    <a href="edit.php?id=<?= $p['id'] ?>">✏️</a>
    <a onclick="bukaModalHapus('hapus.php?id=<?= $p['id'] ?>')">🗑️</a>
  </div>
</div>
<?php } ?>

<div id="modalHapus" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index:1000; align-items:center; justify-content:center;">
  <div style="background:#181818; padding:25px; border-radius:20px; width:85%; max-width:300px; text-align:center; border: 1px solid #333;">
    <h3>Konfirmasi Hapus</h3>
    <p style="color:#a1a1aa; margin-top:10px; font-size: 13px;">Data akan dihapus permanen.</p>
    <div style="display:flex; gap:10px; margin-top:20px;">
      <button onclick="document.getElementById('modalHapus').style.display='none'" style="flex:1; padding:12px; border-radius:12px; border:none; cursor:pointer;">Batal</button>
      <a id="linkHapus" href="#" style="flex:1; padding:12px; border-radius:12px; background:#ef4444; color:#fff; text-decoration:none; font-weight:bold;">Hapus</a>
    </div>
  </div>
</div>

<script>
function bukaModalHapus(url) {
    document.getElementById('linkHapus').href = url;
    document.getElementById('modalHapus').style.display = 'flex';
}
</script>

<div class="nav-bawah">
  <a href="dashboard.php" class="nav-btn aktif">Dash</a>
  <a href="pesanan.php" class="nav-btn">Pesanan</a>
  <a href="tambah.php" class="nav-btn">+ Baru</a>
  <a href="logout.php" class="nav-btn" style="color:#ef4444;">Keluar</a>
</div>

</body>
</html>
