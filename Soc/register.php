
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'config.php'; // File koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = "user"; // Default user role

    // Validasi jika password tidak cocok
    if ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password harus sama!";
    } else {
        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Username sudah digunakan, pilih username lain!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan user ke database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $success_message = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
            } else {
                $error_message = "Terjadi kesalahan, coba lagi!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        .message {
            font-size: 14px;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
        }

        .error {
            background-color: #ffdddd;
            color: #d8000c;
        }

        .success {
            background-color: #ddffdd;
            color: #4CAF50;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #5a67d8;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #434190;
        }

        p {
            margin-top: 10px;
        }

        a {
            color: #5a67d8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>

</html>
