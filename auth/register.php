<?php
include '../config/koneksi.php';

$alertScript = ""; // Variabel untuk menampung script alert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['reg-username']);
    $password = $_POST['reg-password'];
    $confirm_password = $_POST['confirm-password'];

    // 1. Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirm_password) {
        $alertScript = "
            Swal.fire({
                background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
                color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
                icon: 'error',
                title: 'Password Tidak Cocok',
                text: 'Pastikan password dan konfirmasi password Anda sama.',
                confirmButtonColor: '#00A896'
            });
        ";
    } else {
        // 2. Cek apakah username sudah ada
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek_user) > 0) {
            $alertScript = "
                Swal.fire({
                    background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
                    color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
                    icon: 'warning',
                    title: 'Username Sudah Digunakan',
                    text: 'Silakan pilih username yang lain.',
                    confirmButtonColor: '#00A896'
                });
            ";
        } else {
            // 3. Simpan ke database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Cari baris ini di register.php
            $query = "INSERT INTO users (username, password, profile_pic) VALUES ('$username', '$hashed_password', 'default-pp.png')";

            if (mysqli_query($conn, $query)) {
                $alertScript = "
                    Swal.fire({
                        background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
                        color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: 'Akun Anda telah berhasil dibuat. Silakan login.',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                ";
            } else {
                $error_msg = mysqli_error($conn);
                $alertScript = "
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: $error_msg'
                    });
                ";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Pre-load theme agar tidak kedip
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
            <form id="register-form" method="POST" action="register.php">
                <img src="logo.png" alt="Logo edu.io" class="auth-logo">
                <h2>Buat Akun Baru</h2>
                <p class="auth-subtext">Daftar untuk memulai petualangan belajar Anda.</p>

                <div class="input-group">
                    <label for="reg-username">Username</label>
                    <input type="text" id="reg-username" name="reg-username" required>
                </div>

                <div class="input-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" name="reg-password" required>
                </div>

                <div class="input-group">
                    <label for="confirm-password">Konfirmasi Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>

                <button type="submit" class="btn auth-btn">Register</button>

                <p class="auth-redirect">
                    Sudah punya akun? <a href="login.php">Login di sini</a>
                </p>
            </form>
        </main>
    </div>

    <script src="../assets/js/script.js"></script>

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
