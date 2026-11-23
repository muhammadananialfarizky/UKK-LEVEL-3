<?php
session_start();
require_once '../config/kuis_db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $nis      = trim($_POST['nis'] ?? '');
    $kelas    = trim($_POST['kelas_jurusan'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama === '' || $nis === '' || $kelas === '' || $email === '' || $password === '') {
        $error = 'Semua kolom wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (nis, kelas_jurusan, nama_lengkap, email, password, role) VALUES (:nis, :kelas, :nama, :email, :password, 'siswa')");
            $stmt->execute([
                ':nis' => $nis,
                ':kelas' => $kelas,
                ':nama' => $nama,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            $error = isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062
                ? 'Email atau NIS sudah terdaftar!'
                : 'Terjadi kesalahan saat mendaftar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register Siswa - Etalase Digital Stella</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 320px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">

</head>

<body>

    <div class="card">
        <img src="../assets/logo/download.png" alt="Logo Telkom Schools" style="max-height: 60px; width: auto;" class="mb-2">
        <h2>Daftar Siswa</h2>
        <p class="text-muted small">Buat akun baru untuk mengunggah karya</p>
        <?php if ($error): ?><p style="color:red; font-size:14px;"><?= $error ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="nis" placeholder="NIS" required>
            <input type="text" name="kelas_jurusan" placeholder="Kelas/Jurusan" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password (minimal 6 karakter)" required>
            <button type="submit">Daftar</button>
        </form>
        <p style="font-size:12px;">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>

</html>