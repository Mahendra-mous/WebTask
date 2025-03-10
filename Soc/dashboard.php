<?php
session_start();
require 'config.php';

// Cek apakah yang mengakses adalah admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: profile.php");
    exit();
}

// Ambil daftar user dari database
$result = $conn->query("SELECT id, username, email, role FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            display: flex; justify-content: center; align-items: center;
            height: 100vh; background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .dashboard-container {
            background: white; padding: 30px; border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center; width: 700px;
        }
        h2 { margin-bottom: 15px; color: #333; }
        table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: #5a67d8; color: white; }
        .btn { padding: 8px 12px; border-radius: 6px; color: white; text-decoration: none; transition: 0.3s; }
        .btn-edit { background: #48bb78; } .btn-edit:hover { background: #2f855a; }
        .btn-delete { background: #e53e3e; } .btn-delete:hover { background: #c53030; }
        .btn-logout { display: inline-block; margin-top: 15px; background: #f6ad55; padding: 12px 20px; }
        .btn-logout:hover { background: #dd6b20; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Dashboard Admin</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["username"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["role"]; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-edit">Edit</a>
                    <?php if ($row["role"] !== "admin") { ?>
                        <a href="delete_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-delete" onclick="return confirm('Hapus user ini?');">Hapus</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>

</body>
</html>
