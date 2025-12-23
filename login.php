<?php
session_start();
include 'koneksi.php';

$alertScript = ""; // Variabel untuk menampung script alert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['loggedInUser'] = $username;

            // Ambil nama tampilan (Gunakan Full Name jika ada, jika tidak pakai Username)
            $displayName = (!empty($data['full_name'])) ? $data['full_name'] : $username;

            $alertScript = "
        sessionStorage.setItem('loggedInUser', '$username');
        sessionStorage.setItem('displayName', '$displayName'); // SIMPAN NAMA LENGKAP DI SINI
        Swal.fire({
            background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
            color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang kembali, $displayName',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = 'index.html';
        });
    ";
        } else {
            // Script untuk Password Salah
            $alertScript = "
                Swal.fire({
                    background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
                    color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Password yang Anda masukkan salah!',
                    confirmButtonColor: '#00A896'
                });
            ";
        }
    } else {
        // Script untuk Username Tidak Ditemukan
        $alertScript = "
            Swal.fire({
                background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
                color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
                icon: 'error',
                title: 'Opps!',
                text: 'Username tidak ditemukan!',
                confirmButtonColor: '#00A896'
            });
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Pustaka SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Pre-load theme agar tidak kedip saat refresh
        (function () {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
</head>

<body>
    <div class="auth-container">
        <main class="auth-form">
            <form id="login-form" action="login.php" method="POST">
                <img src="logo.png" alt="Logo edu.io" class="auth-logo">
                <h2>Selamat Datang Kembali!</h2>
                <p class="auth-subtext">Silakan masuk untuk melanjutkan.</p>

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn auth-btn">Login</button>

                <p class="auth-redirect">
                    Belum punya akun? <a href="register.php">Daftar di sini</a>
                </p>
            </form>
        </main>
    </div>

    <script src="script.js"></script>

    <!-- Eksekusi Alert Jika Ada -->
    <?php if ($alertScript != ""): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php echo $alertScript; ?>
            });
        </script>
    <?php endif; ?>

</body>

</html>