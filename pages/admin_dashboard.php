<?php
session_start();
include '../config/koneksi.php';

// 1. Cek Akses Admin
// Jika tidak login atau bukan admin, tendang ke home
if (!isset($_SESSION['loggedInUser']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 2. Handle Actions (Delete/Edit)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    if ($_GET['action'] == 'delete_feedback') {
        mysqli_query($conn, "DELETE FROM feedback WHERE id='$id'");
        header("Location: admin_dashboard.php?msg=feedback_deleted");
        exit;
    }
    
    if ($_GET['action'] == 'delete_user') {
        // Jangan biarkan admin menghapus dirinya sendiri
        if ($id !== $_SESSION['loggedInUser']) {
            mysqli_query($conn, "DELETE FROM users WHERE username='$id'");
            // Hapus juga data terkait
            mysqli_query($conn, "DELETE FROM scores WHERE username='$id'");
            header("Location: admin_dashboard.php?msg=user_deleted");
            exit;
        }
    }
    
    if ($_GET['action'] == 'delete_quiz') {
        mysqli_query($conn, "DELETE FROM scores WHERE id='$id'");
        header("Location: admin_dashboard.php?tab=quiz&msg=quiz_deleted");
        exit;
    }
}

// Handle Edit Quiz (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_quiz'])) {
    $quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
    $new_score = intval($_POST['new_score']);
    
    // Validasi score 0-100
    if ($new_score >= 0 && $new_score <= 100) {
        mysqli_query($conn, "UPDATE scores SET score = $new_score WHERE id = '$quiz_id'");
        header("Location: admin_dashboard.php?tab=quiz&msg=quiz_updated");
        exit;
    }
}

// 3. Fetch Data
// Hitung Total
$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$totalFeedback = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM feedback"));
$totalQuizzes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM scores"));

// Ambil Total Kunjungan
$statsQuery = mysqli_query($conn, "SELECT total_visits FROM site_stats WHERE id = 1");
$stats = mysqli_fetch_assoc($statsQuery);
$totalVisits = $stats['total_visits'] ?? 0;

// Ambil Data Feedback
$feedbackQuery = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");

// Ambil Data Users
$usersQuery = mysqli_query($conn, "SELECT * FROM users ORDER BY username ASC");

// Ambil Data Quizzes dengan User Info (max 3 per user, sesuai requirement)
$quizzesQuery = mysqli_query($conn, "
    SELECT s.id, s.username, s.quiz_name, s.score, s.created_at, u.full_name,
           ROW_NUMBER() OVER (PARTITION BY s.username ORDER BY s.created_at DESC) as quiz_rank
    FROM scores s
    JOIN users u ON s.username = u.username
    ORDER BY s.username, s.created_at DESC
");

// Group quizzes by user (max 3)
$userQuizzes = [];
while ($quiz = mysqli_fetch_assoc($quizzesQuery)) {
    if (!isset($userQuizzes[$quiz['username']])) {
        $userQuizzes[$quiz['username']] = [];
    }
    if (count($userQuizzes[$quiz['username']]) < 3) {
        $userQuizzes[$quiz['username']][] = $quiz;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - edu.io</title>
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
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <!-- Navbar -->
    <?php $path = "../"; include '../includes/navbar.php'; ?>

    <div class="container">
        <div class="admin-header">
            <div>
                <h1 style="margin:0;">Dashboard Admin</h1>
                <p style="color: var(--text-secondary);">Kelola pengguna dan umpan balik aplikasi.</p>
            </div>
            <div style="text-align: right;">
                <span style="display:block; font-weight:bold; color:var(--accent-teal);">
                    <i class="fas fa-user-shield"></i> <?php echo $_SESSION['loggedInUser']; ?>
                </span>
                <span style="font-size:0.9em; color:var(--text-secondary);">Administrator</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-teal);">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($totalVisits); ?></h3>
                    <p>Total Kunjungan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #3498db;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($totalUsers); ?></h3>
                    <p>Total Pengguna</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-purple);">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($totalFeedback); ?></h3>
                    <p>Total Saran</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #e67e22;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo number_format($totalQuizzes); ?></h3>
                    <p>Total Quiz</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'feedback')">
                <i class="fas fa-envelope-open-text"></i> Saran
            </button>
            <button class="tab-btn" onclick="openTab(event, 'quiz')">
                <i class="fas fa-graduation-cap"></i> Kelola Quiz
            </button>
            <button class="tab-btn" onclick="openTab(event, 'users')">
                <i class="fas fa-users"></i> Kelola Pengguna
            </button>
        </div>

        <!-- Feedback Tab -->
        <div id="feedback" class="tab-content active">
            <h2 class="section-title"><i class="fas fa-envelope-open-text"></i> Kotak Saran Masuk</h2>
            
            <?php if (mysqli_num_rows($feedbackQuery) > 0): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Pengirim</th>
                        <th>Pesan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($fb = mysqli_fetch_assoc($feedbackQuery)): 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d M Y H:i', strtotime($fb['created_at'])); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($fb['username']); ?></strong>
                        </td>
                        <td><?php echo nl2br(htmlspecialchars($fb['message'])); ?></td>
                        <td>
                            <a href="#" onclick="confirmDelete('feedback', '<?php echo $fb['id']; ?>')" class="btn-action btn-delete" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p style="text-align:center; color:var(--text-secondary); padding:20px;">Belum ada saran yang masuk.</p>
            <?php endif; ?>
        </div>

        <!-- Quiz Tab -->
        <div id="quiz" class="tab-content">
            <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Kelola Quiz Pengguna</h2>
            
            <?php if (count($userQuizzes) > 0): ?>
                <div class="quiz-grid">
                    <?php foreach ($userQuizzes as $username => $quizzes): ?>
                        <div class="user-quiz-section">
                            <div class="quiz-user-header">
                                <h3><?php echo htmlspecialchars($username); ?> <span class="quiz-count"><?php echo count($quizzes); ?>/3</span></h3>
                            </div>
                            
                            <?php foreach ($quizzes as $quiz): ?>
                                <div class="quiz-card">
                                    <div class="quiz-header">
                                        <div>
                                            <div class="quiz-name"><?php echo htmlspecialchars($quiz['quiz_name']); ?></div>
                                            <small style="color:var(--text-secondary);"><?php echo date('d M Y H:i', strtotime($quiz['created_at'])); ?></small>
                                        </div>
                                        <div class="quiz-score">
                                            <?php echo $quiz['score']; ?>%
                                        </div>
                                    </div>
                                    
                                    <div class="quiz-actions">
                                        <button class="btn-edit" onclick="openEditModal(<?php echo $quiz['id']; ?>, '<?php echo htmlspecialchars($quiz['quiz_name']); ?>', <?php echo $quiz['score']; ?>)">
                                            <i class="fas fa-edit"></i> Edit Score
                                        </button>
                                        <button class="btn-delete" onclick="confirmDeleteQuiz(<?php echo $quiz['id']; ?>, '<?php echo htmlspecialchars($quiz['quiz_name']); ?>')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align:center; color:var(--text-secondary); padding:20px;">Belum ada data quiz.</p>
            <?php endif; ?>
        </div>

        <!-- Users Tab -->
        <div id="users" class="tab-content">
            <h2 class="section-title"><i class="fas fa-users-cog"></i> Manajemen Pengguna</h2>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Foto</th>
                        <th>Username / Nama</th>
                        <th width="15%">Role</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($usr = mysqli_fetch_assoc($usersQuery)): 
                        $pic = $usr['profile_pic'];
                        $picPath = (empty($pic)) ? "../img/default-pp.png" : ((strpos($pic, 'http') === 0) ? $pic : "../img/" . $pic);
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <img src="<?php echo $picPath; ?>" alt="PP" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                        </td>
                        <td>
                            <div style="font-weight:bold;"><?php echo htmlspecialchars($usr['username']); ?></div>
                            <div style="font-size:0.9em; color:var(--text-secondary);"><?php echo htmlspecialchars($usr['full_name'] ?? '-'); ?></div>
                        </td>
                        <td>
                            <span class="badge-role <?php echo ($usr['role'] == 'admin') ? 'role-admin' : 'role-user'; ?>">
                                <?php echo ucfirst($usr['role']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($usr['username'] !== $_SESSION['loggedInUser']): ?>
                            <a href="#" onclick="confirmDelete('user', '<?php echo $usr['username']; ?>')" class="btn-action btn-delete" title="Hapus User">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php else: ?>
                                <span style="font-size:0.8em; color:var(--text-secondary);">Anda</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Quiz Modal -->
        <div id="editQuizModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">Edit Score Quiz</div>
                <form method="POST" onsubmit="return validateScoreForm()">
                    <input type="hidden" id="quiz_id" name="quiz_id">
                    <div class="form-group">
                        <label>Nama Quiz</label>
                        <input type="text" id="quiz_name_display" readonly>
                    </div>
                    <div class="form-group">
                        <label>Score (0-100)</label>
                        <input type="number" id="new_score" name="new_score" min="0" max="100" required>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit" name="edit_quiz" class="btn-save">Simpan</button>
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        // Tab Navigation
        function openTab(event, tabName) {
            // Sembunyikan semua tab
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Hapus active dari semua tombol
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Tampilkan tab yang dipilih
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Modal Functions
        function openEditModal(quizId, quizName, score) {
            document.getElementById('quiz_id').value = quizId;
            document.getElementById('quiz_name_display').value = quizName;
            document.getElementById('new_score').value = score;
            document.getElementById('editQuizModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editQuizModal').classList.remove('active');
        }

        function validateScoreForm() {
            const score = parseInt(document.getElementById('new_score').value);
            if (isNaN(score) || score < 0 || score > 100) {
                Swal.fire('Error', 'Score harus antara 0-100', 'error');
                return false;
            }
            return true;
        }

        function confirmDelete(type, id) {
            let title = (type === 'user') ? 'Hapus Pengguna?' : 'Hapus Saran?';
            let text = (type === 'user') ? 'Pengguna ini akan dihapus permanen.' : 'Saran ini akan dihapus permanen.';
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `admin_dashboard.php?action=delete_${type}&id=${id}`;
                }
            })
        }

        function confirmDeleteQuiz(quizId, quizName) {
            Swal.fire({
                title: 'Hapus Quiz?',
                text: `Quiz "${quizName}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `admin_dashboard.php?action=delete_quiz&id=${quizId}`;
                }
            })
        }

        // Cek URL parameter untuk notifikasi sukses
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('msg')) {
            const msg = urlParams.get('msg');
            if (msg === 'user_deleted') {
                Swal.fire('Terhapus!', 'Pengguna berhasil dihapus.', 'success');
            } else if (msg === 'feedback_deleted') {
                Swal.fire('Terhapus!', 'Saran berhasil dihapus.', 'success');
            } else if (msg === 'quiz_deleted') {
                Swal.fire('Terhapus!', 'Quiz berhasil dihapus.', 'success');
            } else if (msg === 'quiz_updated') {
                Swal.fire('Tersimpan!', 'Score quiz berhasil diperbarui.', 'success');
            }
            // Bersihkan URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // Auto-open quiz tab if coming from quiz action
        if (urlParams.has('tab') && urlParams.get('tab') === 'quiz') {
            const quizBtn = document.querySelector('button[onclick="openTab(event, \'quiz\')"]');
            if (quizBtn) {
                setTimeout(() => {
                    quizBtn.click();
                }, 100);
            }
        }
    </script>

    <?php include '../includes/chatbot.php'; ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>
