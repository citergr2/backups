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

/* Item FAQ dengan gaya Glassmorphism */
.daftar-faq { padding:0 15px; }
.faq-item { background:rgba(15, 15, 15, 0.6); border:1px solid rgba(255,255,255,0.05); border-radius:16px; padding:16px; margin-bottom:12px; cursor:pointer; }
.tanya { display:flex; justify-content:space-between; align-items:center; font-size:15px; font-weight:500; }
.tanya span { color:#60a5fa; font-size:18px; transition:0.3s; }
.jawab { margin-top:12px; color:#a1a1aa; font-size:14px; line-height:1.6; display:none; }

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

    <h2>❓ Pertanyaan Umum</h2>

    <div class="daftar-faq">
      <div class="faq-item" onclick="toggle(this)">
        <div class="tanya">Berapa lama produk dikirim? <span>⌄</span></div>
        <div class="jawab">Produk dikirim otomatis maksimal 5-10 menit setelah pembayaran terverifikasi.</div>
      </div>

      <div class="faq-item" onclick="toggle(this)">
        <div class="tanya">Apakah ada garansi? <span>⌄</span></div>
        <div class="jawab">Ada garansi 1x24 jam. Jika produk rusak/tidak bisa dipakai, kami ganti baru atau uang kembali.</div>
      </div>

      <div class="faq-item" onclick="toggle(this)">
        <div class="tanya">Metode pembayaran? <span>⌄</span></div>
        <div class="jawab">Mendukung QRIS, E-Wallet (DANA, OVO, GoPay, ShopeePay)</div>
      </div>

      <div class="faq-item" onclick="toggle(this)">
        <div class="tanya">Apakah file aman? <span>⌄</span></div>
        <div class="jawab">Aman 100%. Semua file sudah dipindai bebas virus, dan link bersifat pribadi hanya untuk pembeli.</div>
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

<script>
function toggle(el){
  const jawab = el.querySelector('.jawab');
  const panah = el.querySelector('.tanya span');
  const isShown = jawab.style.display === 'block';
  jawab.style.display = isShown ? 'none' : 'block';
  panah.style.transform = isShown ? 'rotate(0)' : 'rotate(180deg)';
}
</script>

</body>
</html>
