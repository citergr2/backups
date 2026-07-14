<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'kunci.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = $conn->real_escape_string($_POST['nama']);
    $kat   = $conn->real_escape_string($_POST['kategori']);
    $harga = (int)$_POST['harga'];
    $link  = $conn->real_escape_string($_POST['link']);
    $desk  = $conn->real_escape_string($_POST['deskripsi']);

    $target_dir = "../uploads/"; // Disesuaikan agar relatif dari file admin
    if (!file_exists($target_dir)) mkdir($target_dir, 0755, true);

    $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $nama_file = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', pathinfo($_FILES['gambar']['name'], PATHINFO_FILENAME)) . '.' . $file_ext;
    $target_file = $target_dir . $nama_file;

    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if($check !== false) {
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO produk (nama, kategori, harga, link_mf, gambar, deskripsi, tgl) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssisss", $nama, $kat, $harga, $link, $nama_file, $desk);

            if($stmt->execute()) {
                echo "<script>alert('✅ Produk berhasil ditambahkan!'); window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('❌ Gagal simpan ke database: ".$stmt->error."');</script>";
            }
        } else {
            echo "<script>alert('⚠️ Gagal upload file gambar.');</script>";
        }
    } else {
        echo "<script>alert('⚠️ File yang diunggah bukan gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background:#000; color:#fff; padding:20px; display: flex; justify-content: center; min-height: 100vh; }
        .wrapper { width: 100%; max-width: 500px; }
        
        .btn-exit { display: inline-block; padding: 10px 20px; background: rgba(255,255,255,0.1); color: #fff; text-decoration: none; border-radius: 12px; font-size: 13px; margin-bottom: 20px; backdrop-filter: blur(5px); }
        
        .card-form { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); padding: 25px; border-radius: 20px; backdrop-filter: blur(10px); }
        .grup { margin-bottom: 20px; }
        label { display:block; margin-bottom:8px; font-size:13px; color:#aaa; }
        input, select, textarea { width:100%; padding:14px; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.1); border-radius:12px; color:#fff; font-size:15px; }
        
        .drop-zone { width:100%; padding:30px; border:2px dashed rgba(255,255,255,0.2); border-radius:16px; text-align:center; color:#888; background:rgba(255,255,255,0.02); cursor:pointer; margin-bottom:15px; }
        .btn-simpan { width:100%; padding:16px; background:#8b0000; border:none; border-radius:12px; color:#fff; font-weight:bold; cursor:pointer; font-size:16px; }
        #preview { display:none; width:100%; max-width:150px; margin:0 auto 15px auto; border-radius:12px; border:1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div class="wrapper">
        <a href="dashboard.php" class="btn-exit">← Kembali</a>
        <div class="card-form">
            <h2 style="margin-bottom:20px;">➕ Tambah Produk</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="grup">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="Freefire">Freefire</option>
                        <option value="Script">Script</option>
                        <option value="Rundom Api">Rundom Api</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="grup">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" required>
                </div>
                <div class="grup">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" required>
                </div>
                <div class="grup">
                    <label>Link Mediafire</label>
                    <input type="text" name="link" required>
                </div>
                <div class="grup">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" rows="4"></textarea>
                </div>

                <label>Foto Produk</label>
                <img id="preview" src="#" alt="Preview">
                <div class="drop-zone" id="dropZone">
                    <p id="fileText">Klik untuk pilih foto</p>
                    <input type="file" name="gambar" id="id_gambar" accept="image/*" style="display:none;" required>
                </div>

                <button type="submit" class="btn-simpan">💾 Simpan Produk</button>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('id_gambar');
        const fileText = document.getElementById('fileText');
        const preview = document.getElementById('preview');

        dropZone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            if(fileInput.files.length) {
                fileText.textContent = fileInput.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => { preview.src = e.target.result; preview.style.display = 'block'; };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    </script>
</body>
</html>
