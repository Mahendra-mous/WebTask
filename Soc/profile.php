<?php
session_start();
require 'config.php'; // Sambungkan ke database

if (!isset($_SESSION["username"]) || $_SESSION["role"] != "user") {
    header("Location: login.php");
    exit();
}

// Ambil username dari session
$username = $_SESSION["username"];

// Query untuk mengambil email dari database
$stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"];
} else {
    $email = "Email tidak ditemukan";
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .profile-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
            position: relative;
        }
        h2 {
            margin-bottom: 10px;
            color: #333;
        }
        .profile-info {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #5a67d8;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn:hover {
            background: #434190;
        }
        .btn-edit {
            background: #48bb78;
        }
        .btn-edit:hover {
            background: #2f855a;
        }
        .btn-dashboard {
            background: #f6ad55;
        }
        .btn-dashboard:hover {
            background: #dd6b20;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h2>
        <p class="profile-info">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>
        <p class="profile-info">Email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
        <br>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
