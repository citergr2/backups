<?php
$host = "localhost";
$user = "xitercsx_admin";
$pass = "citergrwwq12e";
$db   = "xitercsx_db";

// Menggunakan $conn agar sama dengan dashboard.php
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Alias untuk menjaga kompatibilitas jika ada file yang pakai $koneksi
$koneksi = $conn;
?>
