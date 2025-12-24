<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

// LOGIKA PENTING:
// Jika ada link ?user=abc di URL, maka tampilkan profil orang tersebut.
// Jika tidak ada, tampilkan profil diri sendiri.
if (isset($_GET['user'])) {
    $username = mysqli_real_escape_string($conn, $_GET['user']);
} else {
    $username = $_SESSION['loggedInUser'];
}

// 1. Ambil Data User berdasarkan username yang dipilih
$queryUser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$userData = mysqli_fetch_assoc($queryUser);

// Jika user tidak ditemukan di database
if (!$userData) {
    echo "User tidak ditemukan.";
    exit;
}

// 2. Ambil Riwayat Nilai Kuis user tersebut
$queryScores = mysqli_query($conn, "SELECT * FROM scores WHERE username = '$username' ORDER BY created_at DESC");

// Cek apakah ini profil milik sendiri atau orang lain
$isOwnProfile = ($username === $_SESSION['loggedInUser']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>

<body>
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo Edu.io" class="logo-img"></a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="materi.html">Materi</a></li>
            <li><a href="kuis.html">Kuis</a></li>
            <li><a href="nilai.php">Hasil</a></li>
            <li><a href="forum.php">Forum</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="page-title">Profil Pengguna</h1>

        <div class="materi-grid" style="grid-template-columns: 1fr 2fr;">
            <!-- Card Kiri: Informasi Profil -->
            <div class="materi-card" style="text-align: center;">
                <div style="margin-bottom: 20px;">
                    <?php
                    $foto = $userData['profile_pic'];

                    // LOGIKA PENENTUAN PATH FOTO
                    if (empty($foto)) {
                        // Jika kolom database kosong, pakai default
                        $pathFoto = "img/default-pp.png";
                    } elseif (strpos($foto, 'http') === 0) {
                        // Jika isinya link (User Google), pakai link-nya langsung
                        $pathFoto = $foto;
                    } else {
                        // Jika isinya nama file (User Manual), ambil dari folder img/
                        $pathFoto = "img/" . $foto;
                    }
                    ?>
                    <img src="<?php echo $pathFoto; ?>" alt="Foto Profil"
                        style="width: 150px; height: 150px; border-radius: 50%; border: 5px solid var(--accent-teal); object-fit: cover;">
                </div>
                <h3><?php echo $userData['full_name'] ?? $userData['username']; ?></h3>
                <p style="color: var(--accent-teal); font-weight: 600;">@<?php echo $userData['username']; ?></p>
                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
                <p style="font-style: italic; font-size: 0.9em;">
                    <?php echo $userData['bio'] ?? "Belum ada deskripsi."; ?>
                </p>
                <!-- Hanya tampilkan tombol edit jika ini profil milik sendiri -->
                <?php if ($isOwnProfile): ?>
                    <a href="edit_profile.php" class="btn" style="width: 100%; box-sizing: border-box;">Edit Profil</a>
                <?php endif; ?>
            </div>

            <!-- Card Kanan: Statistik Kuis -->
            <div class="materi-card">
                <h3><i class="fas fa-chart-line"></i> Pencapaian Belajar</h3>
                <div class="history-container" style="display: block; margin-top: 20px;">
                    <?php if (mysqli_num_rows($queryScores) > 0): ?>
                        <?php while ($s = mysqli_fetch_assoc($queryScores)): ?>
                            <div class="score-history-card"
                                style="flex-direction: row; justify-content: space-between; align-items: center; padding: 15px; margin-bottom: 10px; text-align: left;">
                                <div>
                                    <h4 style="margin:0;"><?php echo $s['quiz_name']; ?></h4>
                                    <small><?php echo $s['created_at']; ?></small>
                                </div>
                                <div class="score-history-value" style="font-size: 1.5em; margin:0;">
                                    <?php echo $s['score']; ?><span style="font-size: 0.5em;">/100</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="color: var(--text-secondary);">Belum ada kuis yang diselesaikan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>