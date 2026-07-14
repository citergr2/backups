<?php
require 'config.php';
$filter = isset($_GET['pilih']) ? mysqli_real_escape_string($koneksi, $_GET['pilih']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<title>XITERCSX</title>
<link rel="icon" type="image/jpeg" href="LOGO/logo.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
  body { background:#000; color:#fff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding-top: 90px; padding-bottom: 120px; }
  .container { width: 100%; max-width: 450px; position: relative; }

  /* Top Bar (Fixed) */
  .top-bar {
    position: fixed; top: 15px; left: 50%; transform: translateX(-50%);
    width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9);
    backdrop-filter: blur(20px); padding: 12px 20px; display: flex; align-items: center;
    border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999;
  }
  .logo-n { width:40px; height:40px; background:#8b0000; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:18px; margin-right: 12px; }

  h2 { padding: 0 15px 15px; font-size: 20px; }
  .daftar-kat { padding: 0 15px; }
  .kat { background:rgba(15, 15, 15, 0.6); border:1px solid rgba(255,255,255,0.05); border-radius:16px; padding:16px; margin-bottom:12px; display:flex; justify-content:space-between; align-items:center; text-decoration:none; color:#fff; }
  .jumlah { color:#60a5fa; font-size:14px; font-weight:600; }

  /* Grid & Card */
  .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap: 15px; padding: 0 15px; }
  .card { background:rgba(15, 15, 15, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; overflow:hidden; text-decoration:none; color:inherit; }
  .card-gambar { width:100%; height:130px; background:#18181B; }
  .card-gambar img { width:100%; height:100%; object-fit:cover; }
  .card-info { padding:12px; }
  .card-nama { font-size:13px; margin-bottom:6px; font-weight:500; }
  .card-harga { color:#60a5fa; font-weight:700; font-size:14px; }

  /* Nav Bawah */
  .nav-bawah {
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
    width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9);
    backdrop-filter: blur(20px); padding: 10px; display: flex;
    justify-content: space-around; align-items: center;
    border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999;
  }
  .nav-item { text-align:center; text-decoration:none; color:#71717a; font-size:8px; font-weight:bold; flex: 1; }
  .nav-item.aktif { color:#fff; }
  .nav-icon { font-size: 20px; display: block; margin-bottom: 2px; font-weight: 100; }
</style>
</head>
<body>

<div class="container">
  <div class="top-bar">
    <div class="logo-n">X</div>
    <div style="font-weight:700; flex-grow:1;">XITERCSX</div>
    <a href="kategori.php" style="color:#fff; text-decoration:none; font-size:20px;">☰</a>
  </div>

  <?php
  function hitung($nama, $koneksi){
    return mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM produk WHERE kategori='$nama'"));
  }

  if(!$filter) {
  ?>
    <h2>🔤 Kategori</h2>
    <div class="daftar-kat">
      <?php foreach(['Freefire', 'Script', 'Rundom Api', 'Lainnya'] as $k): ?>
      <a href="kategori.php?pilih=<?= $k ?>" class="kat">
        <span><?= $k ?></span>
        <span class="jumlah"><?= hitung($k, $koneksi) ?> Produk</span>
      </a>
      <?php endforeach; ?>
    </div>
  <?php
  } else {
  ?>
    <h2>📦 <?= htmlspecialchars($filter) ?></h2>
    <div class="grid">
      <?php
      $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori='$filter' ORDER BY id DESC");
      while($p = mysqli_fetch_assoc($q)) {
      ?>
      <a href="detail.php?id=<?= $p['id'] ?>" class="card">
        <div class="card-gambar"><img src="uploads/<?= htmlspecialchars($p['gambar']) ?>"></div>
        <div class="card-info">
          <div class="card-nama"><?= htmlspecialchars($p['nama']) ?></div>
          <div class="card-harga">Rp <?= number_format($p['harga'],0,',','.') ?></div>
        </div>
      </a>
      <?php } ?>
    </div>
  <?php } ?>

  <div class="nav-bawah">
    <a href="index.php" class="nav-item"><span class="nav-icon">⌂</span> BERANDA</a>
    <a href="produk.php" class="nav-item"><span class="nav-icon">⚿</span> PRODUK</a>
    <a href="kategori.php" class="nav-item aktif"><span class="nav-icon">☰</span> KATEGORI</a>
    <a href="testimoni.php" class="nav-item"><span class="nav-icon">💬</span> TESTI</a>
    <a href="kontak.php" class="nav-item"><span class="nav-icon">📞</span> KONTAK</a>
  </div>
</div>

</body>
</html>
