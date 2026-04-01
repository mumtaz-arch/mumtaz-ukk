<?php
/**
 * Halaman Login - UKK SMK
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/app/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ' . BASE_URL . '/app/dashboard.php');
            exit;
        } else {
            $error = 'Username atau password tidak sesuai.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Sistem Inventaris</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL ?>/app/assets/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/app/assets/css/style.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
    </style>
</head>
<body>

<div class="login-page">

    <!-- Panel Kiri: Biru Gelap -->
    <div class="login-left-panel d-none d-lg-flex flex-column align-items-center justify-content-center">
        <div class="login-left-inner">
            <div class="logo-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
            </div>
            <h1>InvSis</h1>
            <p>Sistem Informasi Inventaris Barang<br>Berbasis Web — UKK SMK</p>
        </div>
    </div>

    <!-- Panel Kanan: Form Login -->
    <div class="login-right-panel">
        <div class="login-form-box">

            <!-- Logo mobile -->
            <div class="d-lg-none text-center mb-5">
                <div style="width: 50px; height: 50px; background: #1e3a5f; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="26" height="26" style="color:#fff">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
                <div style="font-size: 18px; font-weight: 700; color: #1e293b;">InvSis</div>
            </div>

            <div class="login-heading">
                <h2>Masuk ke Sistem</h2>
                <p>Silakan isi data akun Anda untuk melanjutkan.</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16" style="flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <div class="form-group mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username"
                           class="form-control"
                           placeholder="Masukkan username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control"
                           placeholder="Masukkan password"
                           required>
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                </button>
            </form>

            <div class="login-demo-box">
                <p>Info login: <strong>mumtaz</strong> / <strong>mumtaz123</strong></p>
            </div>

        </div>
    </div>

</div>

</body>
</html>
