<?php
require 'config.php';
session_start();

// API dari Bot
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'tambah') {
    if ($_POST['kunci'] === "citergrwwq12e") {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $isi  = mysqli_real_escape_string($conn, $_POST['pesan']);
        mysqli_query($conn, "INSERT INTO testimoni (nama, isi) VALUES ('$nama', '$isi')");
        exit("OK");
    }
}

// Logika Admin
if(isset($_POST['password_admin']) && $_POST['password_admin'] === "citergrwwq12e") { $_SESSION['admin_login'] = true; }
if(isset($_GET['hapus'])) {
    if(isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
        mysqli_query($conn, "DELETE FROM testimoni WHERE id='".(int)$_GET['hapus']."'");
        header("Location: testimoni.php"); exit();
    } else { $meminta_password = $_GET['hapus']; }
}
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
    .container { width: 100%; max-width: 450px; }

    /* Top Bar (Fixed) */
    .top-bar { position: fixed; top: 15px; left: 50%; transform: translateX(-50%); width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); padding: 12px 20px; display: flex; align-items: center; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999; }
    .logo-n { width:40px; height:40px; background:#8b0000; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:18px; margin-right: 12px; }
    .judul-app { font-weight:700; flex-grow: 1; }

    h2 { padding: 0 15px 15px; font-size: 20px; }
    .container-testi { padding: 0 15px; display: flex; flex-direction: column; gap: 12px; }
    .card-testi { background:rgba(15, 15, 15, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius:16px; padding:16px; }
    .testi-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .testi-nama { font-weight:600; font-size:14px; color:#fff; }
    .testi-isi { font-size:13px; color:#a1a1aa; line-height:1.5; }
    .btn-hapus { color:#ff4d4d; font-size:11px; text-decoration:none; border:1px solid #ff4d4d; padding:2px 8px; border-radius:4px; }
    
    .form-admin { background:rgba(15, 15, 15, 0.6); border:1px solid #8b0000; padding:15px; border-radius:16px; margin: 0 15px 20px; }
    .form-admin input { width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px; color:#fff; margin-top:8px; }
    
    .nav-bawah { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); padding: 10px; display: flex; justify-content: space-around; align-items: center; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999; }
    .nav-item { text-align:center; text-decoration:none; color:#71717a; font-size:8px; font-weight:bold; flex: 1; }
    .nav-item.aktif { color:#fff; }
    .nav-icon { font-size: 20px; display: block; margin-bottom: 2px; font-weight: 100; }
</style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <div class="logo-n">X</div>
        <div class="judul-app">XITERCSX</div>
        <div style="display: flex; gap: 15px; font-size: 20px;">
            <a href="faq.php" style="text-decoration:none; color:#fff;">❓</a>
            <a href="cara-order.php" style="text-decoration:none; color:#fff;">📖</a>
        </div>
    </div>

    <h2>💬 Testimoni Pembeli</h2>

    <?php if(isset($meminta_password)): ?>
    <div class="form-admin">
        <form method="post">
            <p style="font-size:12px;">Masukkan Password Admin:</p>
            <input type="password" name="password_admin" placeholder="Password...">
            <button type="submit" style="width:100%; margin-top:10px; padding:8px; background:#8b0000; color:#fff; border:none; border-radius:8px; cursor:pointer;">KONFIRMASI</button>
        </form>
    </div>
    <?php endif; ?>

    <div class="container-testi">
        <?php
        $q = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC LIMIT 20");
        if(mysqli_num_rows($q) > 0) {
            while($t = mysqli_fetch_assoc($q)) {
        ?>
        <div class="card-testi">
            <div class="testi-header">
                <div class="testi-nama">User-<?= substr($t['nama'], -4) ?></div>
                <a href="testimoni.php?hapus=<?= $t['id'] ?>" class="btn-hapus">HAPUS</a>
            </div>
            <div class="testi-isi"><?= htmlspecialchars($t['isi']) ?></div>
        </div>
        <?php }
        } else {
            echo "<p style='text-align:center; color:#555; padding:20px;'>Belum ada testimoni.</p>";
        }
        ?>
    </div>

    <div class="nav-bawah">
        <a href="index.php" class="nav-item"> <span class="nav-icon">⌂</span> BERANDA </a>
        <a href="produk.php" class="nav-item"> <span class="nav-icon">⚿</span> PRODUK </a>
        <a href="kategori.php" class="nav-item"> <span class="nav-icon">☰</span> KATEGORI </a>
        <a href="testimoni.php" class="nav-item aktif"> <span class="nav-icon">💬</span> TESTI </a>
        <a href="kontak.php" class="nav-item"> <span class="nav-icon">📞</span> KONTAK </a>
    </div>
</div>

</body>
</html>
