<?php require 'config.php'; ?>
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

h2 { padding: 0 15px 15px; font-size: 20px; font-weight:700; }
.daftar-kontak { padding:0 15px; }
.kotak { background:rgba(15, 15, 15, 0.6); border:1px solid rgba(255,255,255,0.05); border-radius:16px; padding:20px; }
.kotak p { margin:12px 0; font-size:15px; color:#a1a1aa; }
.kotak span { color:#fff; font-weight:600; display: block; margin-top: 4px; }
.kotak a { color:#60a5fa; text-decoration:none; }
.garis { border:none; border-top:1px solid rgba(255,255,255,0.1); margin:14px 0; }
.catatan { color:#71717a; font-size:14px; margin-top:8px; font-style: italic; }

/* Nav Bawah */
.nav-bawah { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); padding: 10px; display: flex; justify-content: space-between; align-items: center; border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999; }
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

    <h2>📞 Hubungi Kami</h2>

    <div class="daftar-kontak">
      <div class="kotak">
        <p>📱 WhatsApp: <span><a href="https://wa.me/6287868300595">087868300595</a></span></p>
        <p>💬 Instagram: <span><a href="https://www.instagram.com/xitercsx_official">@XITERCSX_Official</a></span></p>
        <p>📧 Tiktok: <span><a href="https://www.tiktok.com/@xitercsx_official">xitercsx_official</a></span></p>
        <p>⏰ Jam Buka: <span>08.00 - 22.00 WIB</span></p>
        <hr class="garis">
        <p class="catatan">Pemesanan paling cepat diproses di jam kerja ya!</p>
      </div>
    </div>

    <div class="nav-bawah">
      <a href="index.php" class="nav-item"> <span class="nav-icon">⌂</span> BERANDA </a>
      <a href="produk.php" class="nav-item"> <span class="nav-icon">⚿</span> PRODUK </a>
      <a href="kategori.php" class="nav-item"> <span class="nav-icon">☰</span> KATEGORI </a>
      <a href="testimoni.php" class="nav-item"> <span class="nav-icon">💬</span> TESTI </a>
      <a href="kontak.php" class="nav-item aktif"> <span class="nav-icon">📞</span> KONTAK </a>
    </div>
</div>

</body>
</html>
