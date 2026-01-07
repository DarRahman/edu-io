<?php
session_start();
include '../config/koneksi.php';

$alertScript = ""; // Variabel untuk menampung script alert

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['loggedInUser'] = $username;
            $_SESSION['role'] = $data['role']; // Simpan Role ke Session

            // Ambil nama tampilan (Gunakan Full Name jika ada, jika tidak pakai Username)
            $displayName = (!empty($data['full_name'])) ? $data['full_name'] : $username;
            $role = $data['role'];

            // Tentukan target redirect
            $redirectTarget = ($role === 'admin') ? '../pages/admin_dashboard.php' : '../index.php';

            $alertScript = "
        sessionStorage.setItem('loggedInUser', '$username');
        sessionStorage.setItem('displayName', '$displayName');
        sessionStorage.setItem('role', '$role'); // Simpan Role ke Local Storage
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
            window.location.href = '$redirectTarget';
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
    <title>Login - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <!-- Pustaka Markdown & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
                <img src="../logo.png" alt="Logo edu.io" class="auth-logo">
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

                <div style="margin: 20px 0; text-align: center; color: var(--text-secondary);">Atau</div>

                <!-- Tombol Google -->
                <!-- Konfigurasi Google (Cukup 1 kali) -->
                <div id="g_id_onload"
                    data-client_id="652782440460-0o32m4tlim6rpp32bg94e6hg89rjnq45.apps.googleusercontent.com"
                    data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse"
                    data-auto_prompt="false">
                </div>

                <!-- Tampilan Tombol Google (Cukup 1 div ini saja) -->
                <div style="display: flex; justify-content: center; margin-top: 10px;">
                    <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                        data-text="signin_with" data-size="large" data-logo_alignment="left" data-width="400">
                    </div>
                </div>

                <script>
                    function handleCredentialResponse(response) {
                        // Google mengirim token (JWT)
                        const formData = new FormData();
                        formData.append('credential', response.credential);

                        // Kirim token ke backend PHP untuk diproses
                        fetch('auth_google.php', {
                            method: 'POST',
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    // Jika sukses, set data session di browser dan pindah ke index
                                    sessionStorage.setItem('loggedInUser', data.username);
                                    sessionStorage.setItem('displayName', data.full_name);
                                    window.location.href = '../index.php';
                                } else {
                                    Swal.fire('Gagal!', data.message, 'error');
                                }
                            })
                            .catch(err => console.error("Error Google Login:", err));
                    }
                </script>

                <p class="auth-redirect">
                    Belum punya akun? <a href="register.php">Daftar di sini</a>
                </p>
            </form>
        </main>
    </div>

    <!-- ================= AI CHATBOT UI ================= -->
    <?php include '../includes/chatbot.php'; ?>

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
