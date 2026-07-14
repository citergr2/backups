<?php
session_start();
// PERHATIKAN: ini kuncinya, ingat betul tulisannya!
define("KUNCI", "citergrwwq12e"); 

if(!isset($_SESSION['buka']) || $_SESSION['buka']!=KUNCI){
  if($_POST['kunci']==KUNCI) { 
    $_SESSION['buka'] = KUNCI;
    // ⚠️ TAMBAH BARIS INI YA! Biar otomatis lompat ke dashboard
    header("Location: dashboard.php");
    exit;
  } else {
    echo '<style>body{background:#121212;color:#fff;display:flex;min-height:100vh;align-items:center;justify-content:center;font-family:arial}</style>
    <div style="background:#1e1e1e;padding:30px;border-radius:12px;width:90%;max-width:300px;text-align:center">
      <h3>Kunci Akses</h3>
      <form method="post">
        <input type="password" name="kunci" placeholder="Masukkan Kunci" style="width:100%;padding:12px;margin:15px 0;background:#333;border:none;border-radius:8px;color:#fff">
        <button style="width:100%;padding:12px;background:#2563eb;border:none;border-radius:8px;color:#fff;font-weight:bold">Masuk</button>
      </form>
    </div>';
    exit;
  }
}
require '../config.php';
date_default_timezone_set('Asia/Jakarta');
?>
