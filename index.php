<?php
require 'config.php';

// Logika Filter & Search
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where_clauses = [];

if($filter) {
  $filter_bersih = mysqli_real_escape_string($koneksi, $filter);
  $where_clauses[] = "kategori = '$filter_bersih'";
}
if($search) {
  $search_bersih = mysqli_real_escape_string($koneksi, $search);
  $where_clauses[] = "nama LIKE '%$search_bersih%'";
}

$where = (count($where_clauses) > 0) ? "WHERE " . implode(" AND ", $where_clauses) : "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>XITERCSX</title>
  <link rel="icon" type="image/jpg" href="LOGO/logo.jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  * { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
  
  body { 
    background:#000; color:#fff; min-height: 100vh; 
    display: flex; flex-direction: column; align-items: center; 
    padding-top: 145px; padding-bottom: 120px; 
  }

  .container { width: 100%; max-width: 450px; position: relative; }

  /* Top Bar (Fixed) + Search Bar terintegrasi */
  .top-bar {
    position: fixed; top: 15px; left: 50%; transform: translateX(-50%);
    width: 95%; max-width: 450px;
    background: rgba(15, 15, 15, 0.9);
    backdrop-filter: blur(20px);
    padding: 12px 15px;
    display: flex; flex-direction: column; gap: 10px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 999;
  }
  .top-header { display: flex; align-items: center; width: 100%; }
  .logo-n { width:40px; height:40px; background:#8b0000; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:18px; margin-right: 12px; }
  .top-bar form { width: 100%; }
  .top-bar input { width:100%; background:#18181B; border:1px solid #27272A; border-radius:12px; padding:10px; color:#fff; font-size: 14px; }

  /* Filter */
  .filter { display:flex; gap:10px; padding:0 15px 20px; overflow-x:auto; }
  .filter-btn { padding: 8px 16px; border-radius: 8px; background:#1a1a1a; color:#a1a1aa; font-size:12px; text-decoration:none; white-space:nowrap; }
  .filter-btn.aktif { background:#8b0000; color:#ffffff; }

  /* Grid Produk */
  .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap: 15px; padding: 0 15px; }
  .card { background:#09090B; border: 1px solid #18181B; border-radius: 12px; overflow:hidden; text-decoration:none; color:inherit; }
  .card-gambar { width:100%; height: 130px; background:#18181B; }
  .card-gambar img { width:100%; height:100%; object-fit:cover; }
  .card-info { padding: 12px; }
  .card-nama { font-size: 13px; margin-bottom: 6px; font-weight: 500; }
  .card-harga { color:#60a5fa; font-weight:700; font-size: 14px; }

  /* Nav Bawah */
  .nav-bawah {
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
    width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9);
    backdrop-filter: blur(20px); padding: 10px; display: flex;
    justify-content: space-between; align-items: center;
    border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 999;
  }
  .nav-item { text-align:center; text-decoration:none; color:#71717a; font-size:8px; font-weight:bold; flex: 1; }
  .nav-item.aktif { color:#fff; }
  .nav-icon { font-size: 20px; display: block; margin-bottom: 2px; font-weight: 100; }
</style>
</head>
<body>

<div class="container">
  <div class="top-bar">
    <div class="top-header">
      <div class="logo-n">X</div>
      <div style="font-weight:700; flex-grow: 1;">XITERCSX</div>
      <div style="display: flex; gap: 15px; font-size: 20px;">
        <a href="faq.php" style="text-decoration:none; color:#fff;">❓</a>
        <a href="cara-order.php" style="text-decoration:none; color:#fff;">📖</a>
      </div>
    </div>
    <form action="index.php" method="GET">
      <?php if($filter): ?><input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>"><?php endif; ?>
      <input type="text" name="search" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>">
    </form>
  </div>


  <div class="grid">
    <?php
    $q = mysqli_query($koneksi, "SELECT * FROM produk $where ORDER BY id DESC");
    if(mysqli_num_rows($q) > 0) {
      while($p = mysqli_fetch_assoc($q)) {
    ?>
    <a href="detail.php?id=<?= $p['id'] ?>" class="card">
      <div class="card-gambar">
        <img src="uploads/<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>">
      </div>
      <div class="card-info">
        <div class="card-nama"><?= htmlspecialchars($p['nama']) ?></div>
        <div class="card-harga">Rp <?= number_format($p['harga'],0,',','.') ?></div>
      </div>
    </a>
    <?php } 
    } else {
      echo "<p style='grid-column:1/-1; text-align:center; padding-top:20px;'>Produk tidak ditemukan.</p>";
    }
    ?>
  </div>

  <div class="nav-bawah">
    <a href="index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'aktif' : '' ?>">
      <span class="nav-icon">⌂</span> BERANDA
    </a>
    <a href="produk.php" class="nav-item">
      <span class="nav-icon">⚿</span> PRODUK
    </a>
    <a href="kategori.php" class="nav-item">
      <span class="nav-icon">☰</span> KATEGORI
    </a>
    <a href="testimoni.php" class="nav-item">
      <span class="nav-icon">💬</span> TESTI
    </a>
    <a href="kontak.php" class="nav-item">
      <span class="nav-icon">📞</span> KONTAK
    </a>
  </div>
</div>

</body>
</html>
