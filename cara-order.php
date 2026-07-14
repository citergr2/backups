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

/* Langkah Order dengan Glassmorphism */
.daftar-langkah { padding:0 15px; }
.langkah { background:rgba(15, 15, 15, 0.6); border:1px solid rgba(255,255,255,0.05); border-radius:16px; padding:16px; margin-bottom:12px; display:flex; gap:14px; align-items:flex-start; }
.nomor { width:36px; height:36px; background:#8b0000; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:16px; flex-shrink:0; }
.teks h3 { font-size:15px; font-weight:600; margin-bottom:2px; }
.teks p { color:#a1a1aa; font-size:14px; line-height:1.5; }

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

    <h2>📖 Cara Pemesanan</h2>

    <div class="daftar-langkah">
      <div class="langkah">
        <div class="nomor">1</div>
        <div class="teks">
          <h3>Pilih Produk</h3>
          <p>Cari dan pilih produk digital yang kamu butuhkan.</p>
        </div>
      </div>

      <div class="langkah">
        <div class="nomor">2</div>
        <div class="teks">
          <h3>Klik Lihat Detail</h3>
          <p>Cek keterangan produk lalu lanjutkan ke pembelian.</p>
        </div>
      </div>

      <div class="langkah">
        <div class="nomor">3</div>
        <div class="teks">
          <h3>Selesaikan Pembayaran</h3>
          <p>Bayar pakai metode yang tersedia: QRIS, Transfer Bank, E-Wallet, dll.</p>
        </div>
      </div>

      <div class="langkah">
        <div class="nomor">4</div>
        <div class="teks">
          <h3>Terima Produk</h3>
          <p>Setelah pembayaran terverifikasi, link produk dikirim otomatis ke kamu!</p>
        </div>
      </div>
    </div>

    <div class="nav-bawah">
      <a href="index.php" class="nav-item"> <span class="nav-icon">⌂</span> BERANDA </a>
      <a href="produk.php" class="nav-item"> <span class="nav-icon">⚿</span> PRODUK </a>
      <a href="kategori.php" class="nav-item"> <span class="nav-icon">☰</span> KATEGORI </a>
      <a href="testimoni.php" class="nav-item"> <span class="nav-icon">💬</span> TESTI </a>
      <a href="kontak.php" class="nav-item"> <span class="nav-icon">📞</span> KONTAK </a>
    </div>
</div>

</body>
</html>
