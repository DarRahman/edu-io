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

    // ========= LOGIKA BADGE BARU =========
    // Jika nilai = 100, berikan badge berdasarkan quiz_name
    if ($row['score'] == 100) {
        $quizName = strtolower($row['quiz_name']);

        if (strpos($quizName, 'html') !== false && !in_array('html', array_column($badges, 'id'))) {
            $badges[] = [
                'id' => 'html',
                'name' => 'HTML Master Quiz',
                'icon' => 'fab fa-html5',
                'image' => 'htmlbadge.png',
                'color' => '#e34c26',
                'description' => 'Menyelesaikan kuis HTML dengan nilai sempurna!'
            ];
        }

        if (strpos($quizName, 'css') !== false && !in_array('css', array_column($badges, 'id'))) {
            $badges[] = [
                'id' => 'css',
                'name' => 'CSS Master Quiz',
                'icon' => 'fab fa-css3-alt',
                'image' => 'cssbadge.png',
                'color' => '#264de4',
                'description' => 'Menyelesaikan kuis CSS dengan nilai sempurna!'
            ];
        }

        if (strpos($quizName, 'js') !== false && !in_array('js', array_column($badges, 'id'))) {
            $badges[] = [
                'id' => 'js',
                'name' => 'JavaScript Master Quiz',
                'icon' => 'fab fa-js-square',
                'image' => 'jsbadge.png',
                'color' => '#f0db4f',
                'description' => 'Menyelesaikan kuis JavaScript dengan nilai sempurna!'
            ];
        }
    }
}

$isOwnProfile = ($username === $_SESSION['loggedInUser']);

// --- LOGIKA STATUS PERTEMANAN ---
$friendStatus = 'none'; // none, sent, received, friend
if (!$isOwnProfile) {
    $me = $_SESSION['loggedInUser'];
    $them = $username;
    $checkFriend = mysqli_query($conn, "SELECT * FROM friends WHERE (requester='$me' AND receiver='$them') OR (requester='$them' AND receiver='$me')");
    if (mysqli_num_rows($checkFriend) > 0) {
        $rel = mysqli_fetch_assoc($checkFriend);
        if ($rel['status'] === 'accepted') {
            $friendStatus = 'friend';
        } else {
            $friendStatus = ($rel['requester'] === $me) ? 'sent' : 'received';
        }
    }
}

// Ekstraksi username dari URL sosial
$ghHandle = '';
$igHandle = '';
$liHandle = '';
if (!empty($userData['github_link'])) {
    $p = parse_url($userData['github_link']);
    $path = isset($p['path']) ? $p['path'] : '';
    $segs = array_values(array_filter(explode('/', $path)));
    if (count($segs) > 0) {
        $ghHandle = $segs[0];
    }
}
if (!empty($userData['instagram_link'])) {
    $p = parse_url($userData['instagram_link']);
    $path = isset($p['path']) ? $p['path'] : '';
    $segs = array_values(array_filter(explode('/', $path)));
    if (count($segs) > 0) {
        $igHandle = $segs[0];
    }
}
if (!empty($userData['linkedin_link'])) {
    $p = parse_url($userData['linkedin_link']);
    $path = isset($p['path']) ? $p['path'] : '';
    $segs = array_values(array_filter(explode('/', $path)));
    if (count($segs) > 0) {
        $liHandle = end($segs);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
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
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .badge-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px 15px;
            background: var(--glass-bg);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            min-height: 180px;
            justify-content: center;
        }

        .badge-item.badge-earned {
            border-color: var(--accent-teal);
            background: linear-gradient(135deg, rgba(0, 168, 150, 0.1), transparent);
            box-shadow: 0 5px 15px rgba(0, 168, 150, 0.1);
        }

        .badge-item.badge-locked {
            opacity: 0.7;
        }

        .badge-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .badge-item.badge-earned:hover {
            border-color: #00a896;
            box-shadow: 0 10px 25px rgba(0, 168, 150, 0.3);
        }

        .badge-icon {
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .badge-item:hover .badge-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .badge-name {
            font-size: 0.85em;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        /* Efek glow untuk badge yang sudah didapat */
        .badge-earned::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg,
                    rgba(0, 168, 150, 0.3),
                    rgba(187, 134, 252, 0.3),
                    rgba(0, 168, 150, 0.3));
            border-radius: 16px;
            z-index: -1;
            animation: badgeGlow 3s infinite;
        }

        @keyframes badgeGlow {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.7;
            }
        }

        @media (max-width: 768px) {
            .badge-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .badge-list {
                grid-template-columns: 1fr;
            }
        }

        .social-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 18px;
            margin-top: 20px;
        }

        .social-card h4 {
            margin: 0 0 12px 0;
            color: var(--text-primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .social-pills {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-primary);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
        }

        .pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--shadow-color);
            color: #fff;
        }

        .pill i {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #fff;
        }

        .pill .handle {
            font-weight: 700;
        }

        .pill-github i {
            background: #333;
        }

        .pill-instagram i {
            background: #E1306C;
        }

        .pill-linkedin i {
            background: #0077b5;
        }

        .pill-github:hover {
            background: #333;
        }

        .pill-instagram:hover {
            background: #E1306C;
        }

        .pill-linkedin:hover {
            background: #0077b5;
        }
    </style>
</head>

<body>
    <!-- Navbar (Sama seperti file lain) -->
    <?php $path = ""; include 'includes/navbar.php'; ?>

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

                <!-- TOMBOL ACTION (Edit Profil / Add Friend) -->
                <div style="margin-bottom: 20px;">
                    <?php if ($isOwnProfile): ?>
                        <a href="edit_profile.php" class="btn" style="width:100%; display:block; text-align:center;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    <?php else: ?>
                        <?php if ($friendStatus === 'none'): ?>
                            <button onclick="friendAction('add', '<?php echo $username; ?>')" class="btn" style="width:100%; background:var(--accent-teal);">
                                <i class="fas fa-user-plus"></i> Tambah Teman
                            </button>
                        <?php elseif ($friendStatus === 'sent'): ?>
                            <button onclick="friendAction('cancel', '<?php echo $username; ?>')" class="btn" style="width:100%; background:var(--bg-secondary); border:1px solid var(--border-color); color:var(--text-primary);">
                                <i class="fas fa-clock"></i> Menunggu Konfirmasi
                            </button>
                        <?php elseif ($friendStatus === 'received'): ?>
                            <div style="display:flex; gap:10px;">
                                <button onclick="friendAction('accept', '<?php echo $username; ?>')" class="btn" style="flex:1; background:#2ecc71;">
                                    <i class="fas fa-check"></i> Terima
                                </button>
                                <button onclick="friendAction('reject', '<?php echo $username; ?>')" class="btn" style="flex:1; background:#e74c3c;">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        <?php elseif ($friendStatus === 'friend'): ?>
                            <button class="btn" style="width:100%; background:var(--bg-secondary); cursor:default; border:1px solid var(--accent-teal); color:var(--accent-teal);">
                                <i class="fas fa-check-circle"></i> Berteman
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($userData['github_link']) || !empty($userData['instagram_link']) || !empty($userData['linkedin_link'])): ?>
                    <div class="social-card">
                        <h4><i class="fas fa-share-alt"></i> Sosial Media</h4>
                        <div class="social-pills">
                            <?php if (!empty($userData['github_link'])): ?>
                                <a href="<?php echo $userData['github_link']; ?>" target="_blank" class="pill pill-github"
                                    title="GitHub">
                                    <i class="fab fa-github"></i>
                                    <span>GitHub <span class="handle">@<?php echo htmlspecialchars($ghHandle); ?></span></span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($userData['instagram_link'])): ?>
                                <a href="<?php echo $userData['instagram_link']; ?>" target="_blank" class="pill pill-instagram"
                                    title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                    <span>Instagram <span
                                            class="handle">@<?php echo htmlspecialchars($igHandle); ?></span></span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($userData['linkedin_link'])): ?>
                                <a href="<?php echo $userData['linkedin_link']; ?>" target="_blank" class="pill pill-linkedin"
                                    title="LinkedIn">
                                    <i class="fab fa-linkedin"></i>
                                    <span>LinkedIn <span
                                            class="handle">@<?php echo htmlspecialchars($liHandle); ?></span></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

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
                    <h3 style="margin-top:0;">
                        <i class="fas fa-award" style="color: #FFC312;"></i> Koleksi Lencana
                        <span
                            style="font-size:0.7em; color:var(--text-secondary); font-weight:normal; margin-left:10px;">
                            <?php echo count($badges); ?> / 3 lencana
                        </span>
                    </h3>
                    <p style="font-size:0.9em; color:var(--text-secondary); margin-bottom:15px;">
                        Dapatkan nilai 100 di setiap kuis untuk membuka lencana spesial!
                    </p>

                    <div class="badge-list">
                        <?php
                        // Daftar semua badge yang mungkin
                        $allBadges = [
                            'html' => [
                                'name' => 'HTML Master Quiz',
                                'image' => 'htmlbadge.png',
                                'color' => '#e34c26',
                                'description' => 'Menyelesaikan kuis HTML dengan nilai sempurna!'
                            ],
                            'css' => [
                                'name' => 'CSS Master Quiz',
                                'image' => 'cssbadge.png',
                                'color' => '#264de4',
                                'description' => 'Menyelesaikan kuis CSS dengan nilai sempurna!'
                            ],
                            'js' => [
                                'name' => 'JavaScript Master Quiz',
                                'image' => 'jsbadge.png',
                                'color' => '#f0db4f',
                                'description' => 'Menyelesaikan kuis JavaScript dengan nilai sempurna!'
                            ]
                        ];

                        foreach ($allBadges as $badgeId => $badgeInfo):
                            $hasBadge = false;
                            foreach ($badges as $userBadge) {
                                if ($userBadge['id'] === $badgeId) {
                                    $hasBadge = true;
                                    break;
                                }
                            }
                            ?>
                            <div class="badge-item <?php echo $hasBadge ? 'badge-earned' : 'badge-locked'; ?>"
                                data-badge="<?php echo $badgeId; ?>"
                                title="<?php echo $hasBadge ? $badgeInfo['description'] : 'Belum terbuka. Dapatkan nilai 100 di kuis ' . strtoupper($badgeId) . '!'; ?>">

                                <?php if ($hasBadge): ?>
                                    <!-- Badge sudah didapat -->
                                    <div class="badge-icon">
                                        <img src="img/badges/<?php echo $badgeInfo['image']; ?>"
                                            alt="<?php echo $badgeInfo['name']; ?>"
                                            style="width: 60px; height: 60px; object-fit: contain;">
                                    </div>
                                    <span class="badge-name" style="color: <?php echo $badgeInfo['color']; ?>;">
                                        <?php echo $badgeInfo['name']; ?>
                                    </span>
                                    <small style="color: #198754; font-size: 0.7em; margin-top: 5px;">
                                        <i class="fas fa-check-circle"></i> Terbuka
                                    </small>
                                <?php else: ?>
                                    <!-- Badge masih terkunci -->
                                    <div class="badge-icon" style="filter: grayscale(1); opacity: 0.5;">
                                        <img src="img/badges/<?php echo $badgeInfo['image']; ?>"
                                            alt="<?php echo $badgeInfo['name']; ?>"
                                            style="width: 60px; height: 60px; object-fit: contain;">
                                    </div>
                                    <span class="badge-name" style="color: var(--text-secondary);">
                                        <?php echo $badgeInfo['name']; ?>
                                    </span>
                                    <small style="color: #dc3545; font-size: 0.7em; margin-top: 5px;">
                                        <i class="fas fa-lock"></i> Terkunci
                                    </small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
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
    <script>
        function friendAction(action, username) {
            const formData = new FormData();
            formData.append('action', action);
            formData.append('username', username);

            fetch('friend_action.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>

</html>