<?php
session_start();
include '../config/koneksi.php';

// Fungsi Helper untuk Foto Profil (Sama seperti di Forum)
function getProfilePath($foto)
{
    if (empty($foto))
        return "../img/default-pp.png";
    if (strpos($foto, 'http') === 0)
        return $foto;
    return "../img/" . $foto;
}

// Cek Login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../auth/login.php");
    exit;
}

// QUERY SAKTI:
// 1. Gabungkan tabel scores dan users.
// 2. Hitung total skor per user (SUM).
// 3. Urutkan dari terbesar (DESC).
// 4. Ambil 10 teratas saja.
$query = "SELECT u.username, u.full_name, u.profile_pic, SUM(s.score) as total_point 
          FROM scores s 
          JOIN users u ON s.username = u.username 
          GROUP BY u.username 
          ORDER BY total_point DESC 
          LIMIT 10";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Leaderboard - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        (function () {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    <style>
        /* CSS Khusus Leaderboard */
        .rank-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            /* Jarak antar baris */
        }

        .rank-row {
            background: var(--glass-bg);
            transition: transform 0.2s;
        }

        .rank-row:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .rank-cell {
            padding: 15px 20px;
            vertical-align: middle;
        }

        .rank-cell:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .rank-cell:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            font-weight: 800;
            font-size: 1.2em;
            color: var(--accent-teal);
        }

        .rank-badge {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            color: white;
            background: var(--text-secondary);
        }

        /* Warna Juara */
        .rank-1 {
            background: #FFC312;
            box-shadow: 0 0 10px #FFC312;
            font-size: 1.2em;
        }

        /* Emas */
        .rank-2 {
            background: #C0C0C0;
            box-shadow: 0 0 10px #C0C0C0;
        }

        /* Perak */
        .rank-3 {
            background: #CD7F32;
            box-shadow: 0 0 10px #CD7F32;
        }

        /* Perunggu */

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
    </style>
</head>

<body>
    <!-- NAVBAR (Sama seperti file lain) -->
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 class="page-title" style="margin-bottom: 10px;">🏆 Top 10 Siswa Terbaik</h1>
            <p style="color: var(--text-secondary);">Siapakah yang paling rajin belajar dan mengerjakan kuis?</p>
        </div>

        <main style="background: transparent; border: none; box-shadow: none; padding: 0;">
            <table class="rank-table">
                <?php
                $rank = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $displayName = !empty($row['full_name']) ? $row['full_name'] : $row['username'];
                        $pp = getProfilePath($row['profile_pic']);

                        // Tentukan kelas CSS untuk medali juara
                        $badgeClass = "rank-badge";
                        $badgeContent = $rank;
                        if ($rank == 1) {
                            $badgeClass .= " rank-1";
                            $badgeContent = "<i class='fas fa-crown'></i>";
                        } elseif ($rank == 2) {
                            $badgeClass .= " rank-2";
                        } elseif ($rank == 3) {
                            $badgeClass .= " rank-3";
                        }

                        // Highlight jika itu user yang sedang login
                        $highlightStyle = ($row['username'] == $_SESSION['loggedInUser']) ? "border: 2px solid var(--accent-teal);" : "";
                        ?>

                        <tr class="rank-row" style="<?php echo $highlightStyle; ?>">
                            <!-- Kolom 1: Ranking -->
                            <td class="rank-cell" style="width: 60px;">
                                <div class="<?php echo $badgeClass; ?>"><?php echo $badgeContent; ?></div>
                            </td>

                            <!-- Kolom 2: Profil -->
                            <td class="rank-cell">
                                <a href="profile.php?user=<?php echo $row['username']; ?>" class="user-info"
                                    style="text-decoration: none; color: inherit;">
                                    <img src="<?php echo $pp; ?>"
                                        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color);">
                                    <div>
                                        <div style="font-weight: 700; font-size: 1.1em;"><?php echo $displayName; ?></div>
                                        <small style="color: var(--text-secondary);">@<?php echo $row['username']; ?></small>
                                    </div>
                                </a>
                            </td>

                            <!-- Kolom 3: Total Skor -->
                            <td class="rank-cell" style="text-align: right;">
                                <?php echo $row['total_point']; ?> <span
                                    style="font-size: 0.6em; color: var(--text-secondary); font-weight: 400;">Pts</span>
                            </td>
                        </tr>

                        <?php
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; padding:20px;'>Belum ada data nilai kuis. Ayo kerjakan kuis sekarang!</td></tr>";
                }
                ?>
            </table>
        </main>
    </div>

    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <!-- AI Chatbot UI -->
    <div id="ai-chat-launcher" onclick="toggleAIChat()"><i class="fas fa-robot"></i></div>
    <div id="ai-chat-window">
        <div class="ai-chat-header"><span><i class="fas fa-magic"></i> edu.io AI Tutor</span><button
                onclick="toggleAIChat()">&times;</button></div>
        <div id="ai-chat-body">
            <div class="ai-message bot">Halo! Butuh bantuan?</div>
        </div>
        <div class="ai-chat-footer"><input type="text" id="ai-input" placeholder="..." autocomplete="off" /><button
                onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button></div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>