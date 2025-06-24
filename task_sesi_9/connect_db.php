<?php
// Konfigurasi database
$host = "localhost";      // Host database (biasanya "localhost")
$user = "root";           // Username MySQL
$pass = "";               // Password MySQL
$db   = "tokoku";  // Nama database (ganti dengan nama database Anda)

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>