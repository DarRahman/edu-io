<?php
session_start();
include '../config/koneksi.php';

// 1. Cek Akses Admin
// Jika tidak login atau bukan admin, tendang ke home
if (!isset($_SESSION['loggedInUser']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 2. Handle Actions (Delete)
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
            // Opsional: Hapus juga data terkait (skor, teman, dll) jika perlu
            header("Location: admin_dashboard.php?msg=user_deleted");
            exit;
        }
    }
}

// 3. Fetch Data
// Hitung Total
$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$totalFeedback = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM feedback"));

// Ambil Data Feedback
$feedbackQuery = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");

// Ambil Data Users
$usersQuery = mysqli_query($conn, "SELECT * FROM users ORDER BY username ASC");
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
    <style>
        /* Admin Specific Styles */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-teal);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8em;
            color: white;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 2em;
            color: var(--text-primary);
        }

        .stat-info p {
            margin: 0;
            color: var(--text-secondary);
        }

        /* Tables */
        .table-container {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            overflow-x: auto;
            margin-bottom: 40px;
        }

        .section-title {
            margin-bottom: 20px;
            color: var(--title-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .admin-table th, .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table th {
            font-weight: 600;
            color: var(--accent-teal);
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .badge-role {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .role-admin {
            background: rgba(255, 195, 18, 0.2);
            color: #f0932b;
        }

        .role-user {
            background: rgba(0, 168, 150, 0.1);
            color: var(--accent-teal);
        }

        .btn-action {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
            color: white;
        }
    </style>
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
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalUsers; ?></h3>
                    <p>Total Pengguna</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--accent-purple);">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalFeedback; ?></h3>
                    <p>Total Saran</p>
                </div>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="table-container">
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

        <!-- User Management Section -->
        <div class="table-container">
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

    </div>

    <script src="../assets/js/script.js"></script>
    <script>
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

        // Cek URL parameter untuk notifikasi sukses
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('msg')) {
            const msg = urlParams.get('msg');
            if (msg === 'user_deleted') {
                Swal.fire('Terhapus!', 'Pengguna berhasil dihapus.', 'success');
            } else if (msg === 'feedback_deleted') {
                Swal.fire('Terhapus!', 'Saran berhasil dihapus.', 'success');
            }
            // Bersihkan URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>

</body>
</html>
