<?php 
require 'config.php'; 

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$p = mysqli_fetch_assoc($q);

if(!$p) die("Produk tidak ditemukan!");

// BUAT KODE UNIK OTOMATIS (3 ANGKA)
$kode_unik = rand(100,999);
$total_bayar = $p['harga'] + $kode_unik;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<title><?= htmlspecialchars($p['nama']) ?> - XITERCSX</title>
<link rel="icon" type="image/jpeg" href="LOGO/logo.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
body { background:#000; color:#fff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding-top: 90px; padding-bottom: 20px; }
.container { width: 100%; max-width: 450px; }

/* Top Bar (Fixed) */
.top-bar { position: fixed; top: 15px; left: 50%; transform: translateX(-50%); width: 95%; max-width: 450px; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(20px); padding: 12px 20px; display: flex; align-items: center; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.1); z-index: 999; }
.kembali { color:#fff; font-size:24px; text-decoration:none; padding-right:15px; }
.logo-n { width:40px; height:40px; background:#8b0000; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:18px; }
.judul-app { font-size:18px; font-weight:700; margin-left:12px; }

/* Konten */
.gambar-wrap { margin: 0 15px 20px; border-radius:16px; overflow:hidden; background:#18181B; border:1px solid rgba(255,255,255,0.05); }
.gambar-produk { width:100%; height:300px; object-fit:cover; }
.info { margin:0 15px 20px; }
.kategori { background:rgba(30, 58, 138, 0.5); color:#93c5fd; padding:4px 12px; border-radius:20px; font-size:13px; display:inline-block; margin-bottom:10px; }
.nama-produk { font-size:22px; font-weight:700; margin-bottom:8px; }
.harga { color:#60a5fa; font-size:24px; font-weight:bold; margin-bottom:15px; }
.deskripsi { color:#a1a1aa; line-height:1.7; font-size:15px; background:rgba(15,15,15,0.6); padding:15px; border-radius:16px; border:1px solid rgba(255,255,255,0.05); }

/* Tombol Beli */
.btn-beli { width: calc(100% - 30px); margin: 0 15px 20px; background:#8b0000; color:#fff; border:none; padding:16px; border-radius:16px; font-weight:bold; cursor:pointer; font-size:16px; }

/* Modal Glassmorphism */
.modal-latar { display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.8); backdrop-filter:blur(5px); z-index:200; padding:20px; overflow-y:auto; }
.modal-kotak { background:rgba(15, 15, 15, 0.95); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:20px; max-width:420px; margin:50px auto; }
.metode-item { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:14px; margin-bottom:10px; cursor:pointer; }
.metode-item.aktif { border-color:#8b0000; background:rgba(139,0,0,0.2); }
.btn-cek { width:100%; background:#16a34a; color:#fff; border:none; padding:14px; border-radius:12px; font-weight:bold; margin-top:15px; cursor:pointer; }
</style>
</head>
<body>

<div class="container">
    <div class="top-bar">
      <a href="produk.php" class="kembali">←</a>
      <div class="logo-n">X</div>
      <div class="judul-app">XITERCSX</div>
    </div>

    <div class="gambar-wrap">
      <img src="uploads/<?= htmlspecialchars($p['gambar']) ?>" class="gambar-produk">
    </div>

    <div class="info">
      <span class="kategori"><?= htmlspecialchars($p['kategori'] ?? 'Produk') ?></span>
      <h1 class="nama-produk"><?= htmlspecialchars($p['nama']) ?></h1>
      <div class="harga">Rp <?= number_format($p['harga'],0,',','.') ?></div>
      <div class="deskripsi"><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></div>
    </div>

    <button class="btn-beli" id="tombolBeli">🛒 Beli Sekarang</button>
</div>

<div class="modal-latar" id="modalBayar">
  <div class="modal-kotak">
    <span style="float:right; cursor:pointer; font-size:20px;" id="tutupModal">✕</span>
    <h3 style="margin-bottom:20px;">Pilih Pembayaran</h3>

    <div class="metode-item" data-metode="dana">💳 Transfer DANA: 087868300595</div>

    <div id="detailBayar" style="display:none; border-top:1px solid rgba(255,255,255,0.1); padding-top:15px; margin-top:10px;">
        <div id="pesanPeringatan" style="background:rgba(139,0,0,0.3); color:#fff; padding:10px; border-radius:8px; font-size:12px; font-weight:bold; margin-bottom:15px; text-align:center; border:1px solid #8b0000;">
            TRANSFER SESUAI NOMINAL DI BAWAH!
        </div>

        <div id="kontenQRIS" style="display:none; text-align:center; margin-bottom:15px;">
            <img src="qris.jpg" style="width:180px; border-radius:10px; border:2px solid #fff;">
        </div>

        <div style="background:rgba(255,255,255,0.05); padding:12px; border-radius:12px; text-align:center;">
            <p style="font-size:12px; color:#aaa;">Total bayar wajib:</p>
            <p style="font-size:22px; font-weight:bold; color:#60a5fa;">Rp <?= number_format($total_bayar,0,',','.') ?></p>
        </div>
        <button class="btn-cek" id="btnKonfirmasi">✅ Konfirmasi Pembayaran</button>
    </div>
  </div>
</div>

<script>
const dataProduk = { nama: '<?= addslashes($p['nama']) ?>', total: '<?= number_format($total_bayar,0,',','.') ?>' };
document.getElementById('tombolBeli').onclick = () => document.getElementById('modalBayar').style.display = 'block';
document.getElementById('tutupModal').onclick = () => document.getElementById('modalBayar').style.display = 'none';

document.querySelectorAll('.metode-item').forEach(i => {
    i.onclick = () => {
        document.querySelectorAll('.metode-item').forEach(x => x.classList.remove('aktif'));
        i.classList.add('aktif');
        document.getElementById('detailBayar').style.display = 'block';
        document.getElementById('kontenQRIS').style.display = (i.dataset.metode === 'qris') ? 'block' : 'none';
    };
});

document.getElementById('btnKonfirmasi').onclick = () => {
  const pesan = `Halo Admin! Saya ingin konfirmasi pembayaran:
*Produk:* ${dataProduk.nama}
*Total:* Rp ${dataProduk.total}
Mohon diproses, terima kasih.`;
  window.location.href = `https://wa.me/6285939407602?text=${encodeURIComponent(pesan)}`;
};
</script>
</body>
</html>
