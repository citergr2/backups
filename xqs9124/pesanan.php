<?php
require 'kunci.php';

// Mengambil data pesanan dan menghitung total pendapatan
$pesanan = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
$total = $conn->query("SELECT SUM(harga) FROM pesanan WHERE status IN ('selesai', 'berhasil')")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Pesanan - XITERCSX</title>
    <link rel="icon" type="image/jpeg" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background:#000; color:#fff; padding:20px; padding-bottom:100px; min-height: 100vh; }

        .total-box { background:#09090B; padding:25px; border-radius:20px; border:1px solid #18181B; text-align:center; margin-bottom:20px; }
        .total-label { font-size:12px; color:#71717a; text-transform:uppercase; letter-spacing:0.5px; }
        .total-angka { font-size:28px; font-weight:700; color:#fff; margin-top:5px; }

        .card { background:#09090B; padding:18px; border-radius:16px; margin-bottom:12px; border:1px solid #18181B; display:flex; justify-content:space-between; align-items:center; }
        .btn-detail { background:#fff; color:#000; padding:8px 16px; border-radius:10px; text-decoration:none; font-size:12px; font-weight:700; }

        /* Navigasi Bawah */
        .nav-bawah {
            position:fixed; bottom:20px; left:50%; transform:translateX(-50%);
            width:95%; max-width:450px; background: rgba(15, 15, 15, 0.9);
            backdrop-filter: blur(20px); display:flex; justify-content:space-around;
            padding:12px; border-radius: 20px; border: 1px solid #27272A; z-index:999;
        }
        .nav-btn {
            padding:8px 16px; border-radius:10px; text-decoration:none;
            font-size:12px; font-weight:600; color:#71717a;
        }
        .nav-btn.aktif { background:#fff; color:#000; }
        
        .status-berhasil { color: #22c55e; }
        .status-lainnya { color: #eab308; }
    </style>
</head>
<body>
    <h2 style="margin-bottom:20px;">📦 Daftar Pesanan</h2>

    <div class="total-box">
        <div class="total-label">Total Pendapatan (Selesai)</div>
        <div class="total-angka">Rp<?= number_format($total ?: 0, 0, ',', '.') ?></div>
    </div>

    <?php if($pesanan->num_rows > 0): ?>
        <?php while($p = $pesanan->fetch_assoc()): ?>
        <div class="card">
            <div>
                <strong style="font-size:14px;"><?= htmlspecialchars($p['nama'] ?? 'Anonim') ?></strong><br>
                <small style="color:#71717a; font-size:12px;">
                    Rp<?= number_format($p['harga'],0,',','.') ?> •
                    <span class="<?= ($p['status'] == 'berhasil' || $p['status'] == 'selesai' ? 'status-berhasil' : 'status-lainnya') ?>;">
                        <?= htmlspecialchars(strtoupper($p['status'])) ?>
                    </span>
                </small>
            </div>
            <a href="detail_pesanan.php?id=<?= $p['id'] ?>" class="btn-detail">Detail</a>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align:center; color:#71717a; margin-top:40px; font-size:14px;">Belum ada pesanan masuk.</div>
    <?php endif; ?>

    <div class="nav-bawah">
        <a href="dashboard.php" class="nav-btn">Dashboard</a>
        <a href="pesanan.php" class="nav-btn aktif">Pesanan</a>
    </div>
</body>
</html>
