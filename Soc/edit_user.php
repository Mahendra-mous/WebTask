<?php
session_start();
require 'config.php';

// Cek apakah yang mengakses adalah admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: profile.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #667eea, #764ba2); }
        .edit-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center; width: 400px; }
        h2 { margin-bottom: 15px; color: #333; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; }
        .btn { padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; transition: 0.3s; }
        .btn-save { background: #48bb78; color: white; } .btn-save:hover { background: #2f855a; }
        .btn-cancel { background: #e53e3e; color: white; text-decoration: none; } .btn-cancel:hover { background: #c53030; }
    </style>
</head>
<body>

    <div class="edit-container">
        <h2>Edit User</h2>
        <form method="POST">
            <input type="text" name="username" value="<?php echo $user["username"]; ?>" required>
            <input type="email" name="email" value="<?php echo $user["email"]; ?>" required>
            <select name="role">
                <option value="user" <?php if ($user["role"] == "user") echo "selected"; ?>>User</option>
                <option value="admin" <?php if ($user["role"] == "admin") echo "selected"; ?>>Admin</option>
            </select>
            <button type="submit" class="btn btn-save">Simpan</button>
            <a href="dashboard.php" class="btn btn-cancel">Batal</a>
        </form>
    </div>

</body>
</html>
