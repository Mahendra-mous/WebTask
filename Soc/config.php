<?php
$host = "localhost";
$user = "root"; // Gunakan "root" jika belum diubah
$pass = ""; // Kosongkan jika MySQL tidak pakai password
$dbname = "akun_db"; // Pastikan database ini sudah ada di phpMyAdmin

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
