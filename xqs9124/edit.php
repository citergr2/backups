<?php
require 'kunci.php';
$id = (int)$_GET['id'];

// Ambil data produk saat ini
$q_lama = $conn->query("SELECT * FROM produk WHERE id=$id");
$p_lama = $q_lama->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = (int)$_POST['harga'];
    $link = $conn->real_escape_string($_POST['link']);
    
    // Proses Edit Gambar
    if(!empty($_FILES['gambar']['name'])) {
        $target_dir = "/needtech/uploads/";
        $nama_file_baru = time() . '_' . basename($_FILES['gambar']['name']);
        
        // Hapus file lama dari server jika ada
        if(!empty($p_lama['gambar']) && file_exists($target_dir . $p_lama['gambar'])) {
            unlink($target_dir . $p_lama['gambar']);
        }
        
        if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target_dir . $nama_file_baru)) {
            $conn->query("UPDATE produk SET nama='$nama', harga=$harga, link_mf='$link', gambar='$nama_file_baru' WHERE id=$id");
        }
    } else {
        // Update teks saja jika tidak ganti gambar
        $conn->query("UPDATE produk SET nama='$nama', harga=$harga, link_mf='$link' WHERE id=$id");
    }
    
    echo "<script>alert('✅ Produk berhasil diupdate!'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk - XITERCSX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:arial; }
        body { background:#121212; color:#fff; padding:20px; }
        .grup { margin-bottom:15px; }
        input { width:100%; padding:12px; background:#1e1e1e; border:1px solid #333; border-radius:8px; color:#fff; }
        .drop-zone { width:100%; padding:30px; border:2px dashed #444; border-radius:12px; text-align:center; color:#888; background:#1e1e1e; cursor:pointer; margin-bottom:15px; }
        .drop-zone:hover { border-color:#2563eb; }
        .btn-simpan { width:100%; padding:14px; background:#2563eb; border:none; border-radius:8px; color:#fff; font-weight:bold; cursor:pointer; }
        #preview { display:none; width:100%; max-width:200px; margin:15px auto; border-radius:8px; border:1px solid #333; }
    </style>
</head>
<body>
    <h2 style="margin-bottom:20px;">✏️ Edit Produk</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="grup">
            <label>Nama Produk</label>
            <input type="text" name="nama" value="<?= $p_lama['nama'] ?>" required>
        </div>
        <div class="grup">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?= $p_lama['harga'] ?>" required>
        </div>
        <div class="grup">
            <label>Link Mediafire</label>
            <input type="text" name="link" value="<?= $p_lama['link_mf'] ?>" required>
        </div>
        
        <label>Ganti Foto</label>
        <div class="drop-zone" id="dropZone">
            <p id="fileText">Klik atau Seret foto baru di sini</p>
            <input type="file" name="gambar" id="id_gambar" accept="image/*" style="display:none;">
        </div>
        <img id="preview" src="#" alt="Preview">

        <button type="submit" class="btn-simpan">💾 Simpan Perubahan</button>
    </form>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('id_gambar');
        const fileText = document.getElementById('fileText');
        const preview = document.getElementById('preview');

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        dropZone.addEventListener('click', () => fileInput.click());
        dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.style.borderColor = '#2563eb'; });
        dropZone.addEventListener('dragleave', () => dropZone.style.borderColor = '#444');
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                fileText.textContent = e.dataTransfer.files[0].name;
                showPreview(e.dataTransfer.files[0]);
            }
        });
        fileInput.addEventListener('change', () => {
            if(fileInput.files.length) {
                fileText.textContent = fileInput.files[0].name;
                showPreview(fileInput.files[0]);
            }
        });
    </script>
</body>
</html>
