<?php
session_start();
// Hancurkan semua sesi yang ada
session_unset();
session_destroy();

// Arahkan kembali ke halaman testimoni atau beranda
header("Location: ../index.php");
exit();
?>
