<?php
session_start();
require 'config.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: profile.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Cek apakah user yang ingin dihapus adalah admin
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user["role"] !== "admin") {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

header("Location: dashboard.php");
exit();
?>
