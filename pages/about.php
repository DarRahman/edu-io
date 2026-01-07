<?php
session_start();
include '../config/koneksi.php';
include '../config/config.php';

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Proses Form Saran
$alertScript = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah user login atau tamu
    $userId = isset($_SESSION['loggedInUser']) ? $_SESSION['loggedInUser'] : 'Guest'; // Simpan username jika login

    // Ambil data dari form
    $senderName = isset($_POST['sender_name']) ? mysqli_real_escape_string($conn, $_POST['sender_name']) : $userId;
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Validasi sederhana
    if (!empty($message)) {
        // Simpan ke database
        $query = "INSERT INTO feedback (username, message) VALUES ('$senderName', '$message')";

        if (mysqli_query($conn, $query)) {
            // --- LOGIKA KIRIM EMAIL ---
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = SMTP_EMAIL;
                $mail->Password   = SMTP_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('noreply@eduio.com', 'edu.io Feedback');
                $mail->addAddress(SMTP_EMAIL); // Kirim ke email Anda sendiri

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Saran Baru dari ' . $senderName;
                $mail->Body    = "<h3>Saran Baru Masuk</h3>
                                  <p><strong>Nama:</strong> $senderName</p>
                                  <p><strong>Pesan:</strong><br>" . nl2br($message) . "</p>";

                $mail->send();
            } catch (Exception $e) {
                // Email gagal dikirim, tapi data sudah masuk DB, jadi kita biarkan saja atau log error
            }
            // --------------------------

            $alertScript = "
                Swal.fire({
                    icon: 'success',
                    title: 'Terima Kasih!',
                    text: 'Saran Anda sangat berharga bagi kami.',
                    confirmButtonColor: '#00A896'
                });
            ";
        } else {
            $alertScript = "
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat mengirim saran.',
                });
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tentang Kami - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
    <style>
        /* Custom Style untuk Halaman About */
        .about-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .about-header h1 {
            font-size: 3em;
            color: var(--title-color);
            margin-bottom: 10px;
        }

        .about-header p {
            font-size: 1.2em;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .content-section {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 30px var(--shadow-color);
        }

        .content-section h2 {
            color: var(--accent-teal);
            font-size: 2em;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .text-content {
            font-size: 1.1em;
            line-height: 1.8;
            color: var(--text-primary);
            text-align: justify;
        }

        .image-content img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-content img:hover {
            transform: scale(1.02);
        }

        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .team-card {
            background: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        html.dark-mode .team-card {
            background: rgba(0, 0, 0, 0.2);
        }

        .team-card:hover {
            transform: translateY(-10px);
        }

        .team-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid var(--accent-teal);
        }

        .team-name {
            font-weight: 700;
            color: var(--title-color);
            margin-bottom: 5px;
        }

        .team-role {
            font-size: 0.9em;
            color: var(--text-secondary);
        }

        .team-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* Feedback Form */
        .feedback-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: inherit;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            /* Penting agar tidak melebar */
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 3px var(--shadow-color);
        }

        textarea.form-control {
            resize: none;
            min-height: 120px;
        }

        .btn-submit {
            width: 100%;
            background: var(--accent-teal);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background: varbbon-hover-bg);
        }

        html.dark-mode .btn-submit {
            background: var(--button-bg);
        }
html:not(.dark-mode) .btn-submit:hover {
    background-color: #49e0d1ff !important;
    color: #ffffffff !important;
}

/* Dark Mode: Warna hover kuning/oren */
html.dark-mode .btn-submit:hover {
    background-color: #ceb2f1ff!important;
    color: #ffffffff !important;
}
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .about-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container">

        <!-- Header -->
        <div class="about-header">
            <h1>Tentang edu.io</h1>
            <p>Platform pembelajaran interaktif masa depan untuk generasi digital.</p>
        </div>

        <!-- Visi & Misi -->
        <div class="content-section">
            <div class="content-grid">
                <div class="text-content">
                    <h2><i class="fas fa-rocket"></i> Tentang edu.io</h2>
                    <p>
                        edu.io adalah platform pembelajaran interaktif yang dirancang untuk membantu pengguna
                        mempelajari teknologi pengembangan web seperti HTML, CSS, dan JavaScript. Dengan fitur-fitur
                        seperti materi pembelajaran, kuis interaktif, live coding, generator kuis AI, tutorial video,
                        forum diskusi, dan leaderboard, edu.io bertujuan untuk membuat proses belajar coding menjadi
                        lebih menarik dan efektif bagi generasi digital.
                    </p>
                    <p>
                        Website ini dibuat oleh tiga mahasiswa untuk memenuhi tugas mata kuliah Desain Web pada semester
                        3. Kami berkomitmen untuk menyediakan sumber daya belajar yang berkualitas dan mudah diakses,
                        serta mendorong komunitas belajar yang kolaboratif dan inovatif.
                    </p>
                </div>
                <div class="image-content">
                    <!-- Placeholder Image: Bisa diganti nanti -->
                    <img src="https://placehold.co/600x400/00a896/ffffff?text=Ilustrasi+Visi+Misi" alt="Visi Misi">
                </div>
            </div>
        </div>

        <!-- Tim Pengembang -->
        <div class="content-section">
            <h2 style="text-align: center; justify-content: center;"><i class="fas fa-users"></i> Tim Pengembang</h2>
            <p style="text-align: center; color: var(--text-secondary);">Orang-orang hebat di balik layar edu.io</p>

            <div class="team-grid">
                <?php
                // Helper function untuk ambil data user
                function getUserData($conn, $username)
                {
                    $q = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
                    if ($q && mysqli_num_rows($q) > 0) {
                        return mysqli_fetch_assoc($q);
                    }
                    return null;
                }

                // 1. Lead Developer (User yang sedang login atau default)
                $leadUser = isset($_SESSION['loggedInUser']) ? $_SESSION['loggedInUser'] : 'Guest';
                $leadData = getUserData($conn, $leadUser);

                $leadName = $leadData['full_name'] ?? $leadUser;
                $leadPic = $leadData['profile_pic'] ?? 'default-pp.png';
                $leadPicPath = (strpos($leadPic, 'http') === 0) ? $leadPic : "img/" . $leadPic;
                ?>

                <!-- Anggota 1 (Lead Developer - Sesuai Akun Login) -->
                <a href="profile.php" class="team-card-link">
                    <div class="team-card">
                        <img src="<?php echo $leadPicPath; ?>" alt="Developer" class="team-img">
                        <div class="team-name"><?php echo htmlspecialchars($leadName); ?></div>
                        <div class="team-role">Lead Developer</div>
                    </div>
                </a>

                <?php
                // 2. Anggota Tim (Placeholder dari user '1', '2', '3')
                // Kita ambil user dengan username '2' dan '3' sebagai contoh tim lain
                // Jika tidak ada, pakai placeholder
                $user2 = getUserData($conn, '2');
                $user3 = getUserData($conn, '3');

                $name2 = $user2['full_name'] ?? 'Desainer UI/UX';
                $pic2 = isset($user2['profile_pic']) ? ((strpos($user2['profile_pic'], 'http') === 0) ? $user2['profile_pic'] : "img/" . $user2['profile_pic']) : 'https://placehold.co/100x100/ffc312/ffffff?text=UI';

                $name3 = $user3['full_name'] ?? 'Database Admin';
                $pic3 = isset($user3['profile_pic']) ? ((strpos($user3['profile_pic'], 'http') === 0) ? $user3['profile_pic'] : "img/" . $user3['profile_pic']) : 'https://placehold.co/100x100/c724b1/ffffff?text=DB';
                ?>

                <!-- Anggota 2 (User '2') -->
                <a href="profile.php?user=2" class="team-card-link">
                    <div class="team-card">
                        <img src="<?php echo $pic2; ?>" alt="Designer" class="team-img">
                        <div class="team-name"><?php echo htmlspecialchars($name2); ?></div>
                        <div class="team-role">Creative Director</div>
                    </div>
                </a>

                <!-- Anggota 3 (User '3') -->
                <a href="profile.php?user=3" class="team-card-link">
                    <div class="team-card">
                        <img src="<?php echo $pic3; ?>" alt="Database" class="team-img">
                        <div class="team-name"><?php echo htmlspecialchars($name3); ?></div>
                        <div class="team-role">Backend Specialist</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Kotak Saran -->
        <div class="content-section">
            <h2 style="text-align: center; justify-content: center;"><i class="fas fa-envelope-open-text"></i> Kotak
                Saran</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 30px;">
                Punya ide fitur baru atau menemukan bug? Beritahu kami!
            </p>

            <div class="feedback-form">
                <form action="about.php" method="POST">
                    <?php if (!isset($_SESSION['loggedInUser'])): ?>
                        <div class="form-group">
                            <label for="sender_name">Nama Anda</label>
                            <input type="text" id="sender_name" name="sender_name" class="form-control"
                                placeholder="Masukkan nama Anda" required>
                        </div>
                    <?php else: ?>
                        <p style="text-align: center; margin-bottom: 20px;">
                            Mengirim sebagai: <strong>@<?php echo $_SESSION['loggedInUser']; ?></strong>
                        </p>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="message">Pesan / Saran</label>
                        <textarea id="message" name="message" class="form-control"
                            placeholder="Tuliskan saran, kritik, atau ide fitur Anda di sini..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Saran
                    </button>
                </form>
            </div>
        </div>

    </div>
    <script src="../assets/js/script.js"></script>

    <!-- Script Alert -->
    <?php if ($alertScript != ""): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php echo $alertScript; ?>
            });
        </script>
    <?php endif; ?>

</body>

</html>