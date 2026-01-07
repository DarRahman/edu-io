<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../auth/login.php");
    exit;
}

$currentUser = $_SESSION['loggedInUser'];

// 1. Ambil Daftar Teman (Accepted)
$friendsQuery = "SELECT * FROM friends WHERE (requester='$currentUser' OR receiver='$currentUser') AND status='accepted'";
$friendsResult = mysqli_query($conn, $friendsQuery);
$friends = [];
while ($row = mysqli_fetch_assoc($friendsResult)) {
    $friendUsername = ($row['requester'] === $currentUser) ? $row['receiver'] : $row['requester'];
    // Ambil detail user
    $uQuery = mysqli_query($conn, "SELECT full_name, profile_pic FROM users WHERE username='$friendUsername'");

    // Cek apakah user masih ada (belum dihapus admin)
    if ($uQuery && mysqli_num_rows($uQuery) > 0) {
        $uData = mysqli_fetch_assoc($uQuery);
        $friends[] = [
            'username' => $friendUsername,
            'full_name' => $uData['full_name'] ?? $friendUsername,
            'profile_pic' => $uData['profile_pic']
        ];
    } else {
        mysqli_query($conn, "DELETE FROM friends WHERE id = " . $row['id']);
    }
}

// 2. Ambil Request Masuk (Pending, receiver = current)
$incomingQuery = "SELECT f.*, u.full_name, u.profile_pic FROM friends f 
                  JOIN users u ON f.requester = u.username 
                  WHERE f.receiver='$currentUser' AND f.status='pending'";
$incomingResult = mysqli_query($conn, $incomingQuery);

// 3. Ambil Request Terkirim (Pending, requester = current)
$outgoingQuery = "SELECT f.*, u.full_name, u.profile_pic FROM friends f 
                  JOIN users u ON f.receiver = u.username 
                  WHERE f.requester='$currentUser' AND f.status='pending'";
$outgoingResult = mysqli_query($conn, $outgoingQuery);

// 4. Search Logic
$searchResults = [];
$searchQuery = "";
if (isset($_GET['q'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['q']);
    if (!empty($searchQuery)) {
        // Cari user yang BUKAN diri sendiri
        $sqlSearch = "SELECT username, full_name, profile_pic FROM users 
                      WHERE (username LIKE '%$searchQuery%' OR full_name LIKE '%$searchQuery%') 
                      AND username != '$currentUser'
                      LIMIT 10";
        $resSearch = mysqli_query($conn, $sqlSearch);
        while ($row = mysqli_fetch_assoc($resSearch)) {
            // Cek status pertemanan
            $target = $row['username'];
            $check = mysqli_query($conn, "SELECT * FROM friends WHERE (requester='$currentUser' AND receiver='$target') OR (requester='$target' AND receiver='$currentUser')");
            $status = 'none';
            if (mysqli_num_rows($check) > 0) {
                $rel = mysqli_fetch_assoc($check);
                if ($rel['status'] === 'accepted') {
                    $status = 'friend';
                } else {
                    $status = ($rel['requester'] === $currentUser) ? 'sent' : 'received';
                }
            }
            $row['friend_status'] = $status;
            $searchResults[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Teman & Komunitas - edu.io</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');
    </script>
    <style>
        .friend-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .friend-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .friend-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-teal);
        }

        .friend-info {
            flex: 1;
        }

        .friend-name {
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none;
        }

        .friend-username {
            font-size: 0.85em;
            color: var(--text-secondary);
        }

        .action-btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            transition: 0.2s;
        }

        .btn-add {
            background: var(--accent-teal);
            color: white;
        }

        .btn-accept {
            background: #2ecc71;
            color: white;
        }

        .btn-reject {
            background: #e74c3c;
            color: white;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .search-input {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            color: var(--text-primary);
        }
    </style>
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title"><i class="fas fa-users"></i> Teman & Komunitas</h1>

        <!-- SEARCH SECTION -->
        <div class="materi-card">
            <h3><i class="fas fa-search"></i> Cari Teman</h3>
            <form action="friends.php" method="GET" class="search-box">
                <input type="text" name="q" class="search-input" placeholder="Cari username atau nama..."
                    value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn" style="margin:0;">Cari</button>
            </form>

            <?php if (!empty($searchQuery)): ?>
                <h4>Hasil Pencarian:</h4>
                <?php if (empty($searchResults)): ?>
                    <p style="color: var(--text-secondary);">Tidak ditemukan user dengan nama tersebut.</p>
                <?php else: ?>
                    <div class="friend-grid">
                        <?php foreach ($searchResults as $res): ?>
                            <div class="friend-card">
                                <img src="<?php echo !empty($res['profile_pic']) ? (strpos($res['profile_pic'], 'http') === 0 ? $res['profile_pic'] : '../img/' . $res['profile_pic']) : '../img/default-pp.png'; ?>"
                                    class="friend-img">
                                <div class="friend-info">
                                    <a href="profile.php?user=<?php echo $res['username']; ?>"
                                        class="friend-name"><?php echo $res['full_name'] ?? $res['username']; ?></a>
                                    <div class="friend-username">@<?php echo $res['username']; ?></div>
                                </div>
                                <div>
                                    <?php if ($res['friend_status'] === 'none'): ?>
                                        <button onclick="friendAction('add', '<?php echo $res['username']; ?>')"
                                            class="action-btn btn-add"><i class="fas fa-user-plus"></i> Add</button>
                                    <?php elseif ($res['friend_status'] === 'sent'): ?>
                                        <button onclick="friendAction('cancel', '<?php echo $res['username']; ?>')"
                                            class="action-btn btn-secondary"><i class="fas fa-times"></i> Batal</button>
                                    <?php elseif ($res['friend_status'] === 'received'): ?>
                                        <button onclick="friendAction('accept', '<?php echo $res['username']; ?>')"
                                            class="action-btn btn-accept"><i class="fas fa-check"></i> Terima</button>
                                    <?php elseif ($res['friend_status'] === 'friend'): ?>
                                        <span class="badge"
                                            style="background:var(--accent-teal); padding:5px 10px; border-radius:5px; color:white;"><i
                                                class="fas fa-check-circle"></i> Teman</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">

            <!-- DAFTAR TEMAN -->
            <div>
                <h3 style="border-bottom: 2px solid var(--accent-teal); padding-bottom: 10px; margin-bottom: 20px;">
                    Daftar Teman (<?php echo count($friends); ?>)
                </h3>
                <?php if (empty($friends)): ?>
                    <p style="color: var(--text-secondary);">Belum ada teman. Yuk cari teman baru!</p>
                <?php else: ?>
                    <?php foreach ($friends as $f): ?>
                        <div class="friend-card">
                            <img src="<?php echo !empty($f['profile_pic']) ? (strpos($f['profile_pic'], 'http') === 0 ? $f['profile_pic'] : '../img/' . $f['profile_pic']) : '../img/default-pp.png'; ?>"
                                class="friend-img">
                            <div class="friend-info">
                                <a href="profile.php?user=<?php echo $f['username']; ?>"
                                    class="friend-name"><?php echo $f['full_name']; ?></a>
                                <div class="friend-username">@<?php echo $f['username']; ?></div>
                            </div>
                            <button onclick="confirmRemove('<?php echo $f['username']; ?>')" class="action-btn btn-reject"
                                title="Hapus Teman"><i class="fas fa-user-minus"></i></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- REQUEST PERTEMANAN -->
            <div>
                <h3 style="border-bottom: 2px solid #f39c12; padding-bottom: 10px; margin-bottom: 20px;">
                    Permintaan Masuk (<?php echo mysqli_num_rows($incomingResult); ?>)
                </h3>
                <?php if (mysqli_num_rows($incomingResult) == 0): ?>
                    <p style="color: var(--text-secondary);">Tidak ada permintaan masuk.</p>
                <?php else: ?>
                    <?php while ($in = mysqli_fetch_assoc($incomingResult)): ?>
                        <div class="friend-card">
                            <img src="<?php echo !empty($in['profile_pic']) ? (strpos($in['profile_pic'], 'http') === 0 ? $in['profile_pic'] : '../img/' . $in['profile_pic']) : '../img/default-pp.png'; ?>"
                                class="friend-img">
                            <div class="friend-info">
                                <a href="profile.php?user=<?php echo $in['requester']; ?>"
                                    class="friend-name"><?php echo $in['full_name'] ?? $in['requester']; ?></a>
                                <div class="friend-username">@<?php echo $in['requester']; ?></div>
                            </div>
                            <div style="display:flex; gap:5px;">
                                <button onclick="friendAction('accept', '<?php echo $in['requester']; ?>')"
                                    class="action-btn btn-accept"><i class="fas fa-check"></i></button>
                                <button onclick="friendAction('reject', '<?php echo $in['requester']; ?>')"
                                    class="action-btn btn-reject"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php if (mysqli_num_rows($outgoingResult) > 0): ?>
                    <h4 style="margin-top: 30px; color: var(--text-secondary);">Permintaan Terkirim</h4>
                    <?php while ($out = mysqli_fetch_assoc($outgoingResult)): ?>
                        <div class="friend-card" style="opacity: 0.8;">
                            <img src="<?php echo !empty($out['profile_pic']) ? (strpos($out['profile_pic'], 'http') === 0 ? $out['profile_pic'] : '../img/' . $out['profile_pic']) : '../img/default-pp.png'; ?>"
                                class="friend-img">
                            <div class="friend-info">
                                <span class="friend-name"><?php echo $out['full_name'] ?? $out['receiver']; ?></span>
                                <div class="friend-username">Menunggu konfirmasi...</div>
                            </div>
                            <button onclick="friendAction('cancel', '<?php echo $out['receiver']; ?>')"
                                class="action-btn btn-secondary"><i class="fas fa-times"></i></button>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <script>
        function friendAction(action, username) {
            const formData = new FormData();
            formData.append('action', action);
            formData.append('username', username);

            fetch('../api/friend_action.php', {
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

        function confirmRemove(username) {
            Swal.fire({
                title: 'Hapus Teman?',
                text: "Anda yakin ingin menghapus @" + username + " dari daftar teman?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    friendAction('remove', username);
                }
            })
        }
    </script>
    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
    <script src="../assets/js/script.js"></script>
</body>

</html>