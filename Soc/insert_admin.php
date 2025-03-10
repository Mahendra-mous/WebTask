<?php
require 'config.php'; // Koneksi ke database

$admin_username = 'admin';
$admin_password = 'admin123'; // Gantilah dengan password yang lebih kuat
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT); // Hash password
$role = 'admin';

// Cek apakah admin sudah ada
$check_stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$check_stmt->bind_param("s", $admin_username);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows == 0) {
    // Jika belum ada, tambahkan admin
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $admin_username, $hashed_password, $role);
    
    if ($stmt->execute()) {
        echo "Admin berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan admin!";
    }
} else {
    echo "Admin sudah ada!";
}

$check_stmt->close();
$stmt->close();
$conn->close();
?>
