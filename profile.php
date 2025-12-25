<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

// Logika cek profil sendiri atau orang lain
if (isset($_GET['user'])) {
    $username = mysqli_real_escape_string($conn, $_GET['user']);
} else {
    $username = $_SESSION['loggedInUser'];
}

// 1. Ambil Data User
$queryUser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$userData = mysqli_fetch_assoc($queryUser);

if (!$userData) {
    echo "User tidak ditemukan.";
    exit;
}

// 2. Ambil Riwayat Nilai & Hitung Badge
$queryScores = mysqli_query($conn, "SELECT * FROM scores WHERE username = '$username' ORDER BY created_at DESC");

// Array untuk menampung badge yang didapat
$badges = [];
$totalScore = 0;
$quizCount = 0;

// Kita simpan data nilai ke array dulu biar bisa dipakai berulang
$historyData = [];
while ($row = mysqli_fetch_assoc($queryScores)) {
    $historyData[] = $row;
    $totalScore += $row['score'];
    $quizCount++;

    // Logika Pemberian Badge (Nilai Sempurna 100)
    if ($row['score'] == 100) {
        if ($row['quiz_name'] == 'html-quiz')
            $badges[] = ['name' => 'HTML Master', 'icon' => 'fab fa-html5', 'color' => '#e34c26'];
        if ($row['quiz_name'] == 'css-quiz')
            $badges[] = ['name' => 'CSS Wizard', 'icon' => 'fab fa-css3-alt', 'color' => '#264de4'];
        if ($row['quiz_name'] == 'js-quiz')
            $badges[] = ['name' => 'JS Ninja', 'icon' => 'fab fa-js-square', 'color' => '#f0db4f'];
    }
}

$isOwnProfile = ($username === $_SESSION['loggedInUser']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil <?php echo $username; ?> - edu.io</title>
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
    <style>
        /* CSS Khusus Profil Baru */
        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        /* Kartu Biodata Kiri */
        .profile-sidebar {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            height: fit-content;
        }

        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--bg-secondary);
            box-shadow: 0 0 20px rgba(0, 168, 150, 0.3);
        }

        .profile-name {
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .profile-username {
            color: var(--accent-teal);
            font-weight: 600;
            margin-bottom: 15px;
            display: block;
        }

        .profile-bio {
            font-size: 0.9em;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* Kartu Kanan (Badge & Stats) */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .stat-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 168, 150, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            color: var(--accent-teal);
        }

        /* Badge Container */
        .badge-container {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 25px;
        }

        .badge-list {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .badge-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80px;
            text-align: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: 0.3s;
        }

        .badge-item:hover {
            transform: translateY(-5px);
            border-color: var(--accent-teal);
        }

        .badge-icon {
            font-size: 2.5em;
            margin-bottom: 8px;
        }

        .badge-name {
            font-size: 0.75em;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar (Sama seperti file lain) -->
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo Edu.io" height="70" width="150"
                class="logo-img" /></a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Belajar <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="materi.html"><i class="fas fa-book"></i> Materi Teks</a>
                    <a href="video.html"><i class="fas fa-play-circle"></i> Video Tutorial</a>
                    <a href="playground.php"><i class="fas fa-code"></i> Live Coding</a>
                </div>
            </li>
            <li><a href="kuis.php">Kuis</a></li>
            <li><a href="forum.php">Forum</a></li>
        </ul>
    </nav>

    <div class="container">

        <div class="profile-grid">
            <!-- 1. SIDEBAR KIRI (FOTO & BIO) -->
            <div class="profile-sidebar">
                <div class="profile-pic-container">
                    <?php
                    $foto = $userData['profile_pic'];
                    $pathFoto = (empty($foto)) ? "img/default-pp.png" : ((strpos($foto, 'http') === 0) ? $foto : "img/" . $foto);
                    ?>
                    <img src="<?php echo $pathFoto; ?>" alt="Foto Profil">
                </div>

                <div class="profile-name"><?php echo $userData['full_name'] ?? $userData['username']; ?></div>
                <span class="profile-username">@<?php echo $userData['username']; ?></span>

                <p class="profile-bio">
                    <?php echo !empty($userData['bio']) ? $userData['bio'] : "Pengguna ini belum menuliskan deskripsi diri."; ?>
                </p>

                <?php if ($isOwnProfile): ?>
                    <a href="edit_profile.php" class="btn" style="width: 100%; display:block; box-sizing:border-box;">Edit
                        Profil</a>
                <?php endif; ?>
            </div>

            <!-- 2. KONTEN KANAN (BADGE & STATS) -->
            <div class="profile-content">

                <!-- Statistik Singkat -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div>
                            <div style="font-size:1.5em; font-weight:700;"><?php echo $quizCount; ?></div>
                            <div style="font-size:0.85em; color:var(--text-secondary);">Kuis Selesai</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-star"></i></div>
                        <div>
                            <div style="font-size:1.5em; font-weight:700;"><?php echo $totalScore; ?></div>
                            <div style="font-size:0.85em; color:var(--text-secondary);">Total Poin</div>
                        </div>
                    </div>
                </div>

                <!-- Koleksi Badge -->
                <div class="badge-container">
                    <h3 style="margin-top:0;"><i class="fas fa-award" style="color: #FFC312;"></i> Koleksi Lencana</h3>
                    <p style="font-size:0.9em; color:var(--text-secondary); margin-bottom:15px;">Dapatkan nilai 100 di
                        setiap kuis untuk membuka lencana!</p>

                    <div class="badge-list">
                        <?php if (empty($badges)): ?>
                            <div style="color:var(--text-secondary); font-style:italic;">Belum ada lencana yang diraih. Ayo
                                semangat!</div>
                        <?php else: ?>
                            <?php foreach ($badges as $badge): ?>
                                <div class="badge-item">
                                    <i class="<?php echo $badge['icon']; ?> badge-icon"
                                        style="color: <?php echo $badge['color']; ?>;"></i>
                                    <span class="badge-name"><?php echo $badge['name']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Riwayat Nilai (Tabel Ringkas) -->
                <div class="materi-card" style="padding: 25px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.2em;">
                        <i class="fas fa-history" style="color: var(--accent-teal);"></i> Riwayat Terakhir
                    </h3>

                    <?php if (empty($historyData)): ?>
                        <div style="text-align: center; padding: 30px; color: var(--text-secondary);">
                            <i class="fas fa-box-open" style="font-size: 3em; margin-bottom: 10px; opacity: 0.3;"></i>
                            <p>Belum ada data kuis.</p>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <?php foreach ($historyData as $s):
                                // Tentukan warna dan ikon berdasarkan skor
                                if ($s['score'] >= 80) {
                                    $color = '#198754';
                                    $icon = 'check-circle';
                                } elseif ($s['score'] >= 60) {
                                    $color = '#FFC312';
                                    $icon = 'exclamation-circle';
                                } else {
                                    $color = '#dc3545';
                                    $icon = 'times-circle';
                                }
                                ?>
                                <div style="
                display: flex; 
                align-items: center; 
                justify-content: space-between; 
                padding: 15px; 
                background: rgba(255,255,255,0.03); 
                border: 1px solid var(--border-color); 
                border-radius: 12px;
                transition: transform 0.2s;" onmouseover="this.style.transform='translateX(5px)'"
                                    onmouseout="this.style.transform='translateX(0)'">

                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="
                        width: 45px; height: 45px; 
                        background: <?php echo $color; ?>15; 
                        color: <?php echo $color; ?>; 
                        border-radius: 50%; 
                        display: flex; align-items: center; justify-content: center;
                        font-size: 1.2em;">
                                            <i class="fas fa-<?php echo $icon; ?>"></i>
                                        </div>
                                        <div>
                                            <span
                                                style="font-weight: 700; font-size: 1em; display: block; color: var(--text-primary);">
                                                <?php echo $s['quiz_name']; ?>
                                            </span>
                                            <small style="color: var(--text-secondary); font-size: 0.8em;">
                                                <i class="far fa-clock"></i>
                                                <?php echo date('d M Y, H:i', strtotime($s['created_at'])); ?>
                                            </small>
                                        </div>
                                    </div>

                                    <div style="text-align: right;">
                                        <div style="font-weight: 800; font-size: 1.4em; color: <?php echo $color; ?>;">
                                            <?php echo $s['score']; ?>
                                        </div>
                                        <span
                                            style="font-size: 0.7em; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary);">Poin</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
    <div id="ai-chat-launcher" onclick="toggleAIChat()"><i class="fas fa-robot"></i></div>

    <script src="script.js"></script>
</body>

</html>