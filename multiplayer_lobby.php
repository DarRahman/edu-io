<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser']) || !isset($_GET['room'])) {
    header("Location: index.php");
    exit;
}

$roomCode = mysqli_real_escape_string($conn, $_GET['room']);
$currentUser = $_SESSION['loggedInUser'];

// Ambil Info Room
$query = mysqli_query($conn, "SELECT * FROM quiz_rooms WHERE room_code = '$roomCode'");
$room = mysqli_fetch_assoc($query);

if (!$room) {
    echo "Room tidak valid.";
    exit;
}

$isHost = ($room['host_username'] === $currentUser);

// Logic Start Game (Host Only)
if ($isHost && isset($_POST['start_game'])) {
    mysqli_query($conn, "UPDATE quiz_rooms SET status = 'playing' WHERE room_code = '$roomCode'");
    header("Location: multiplayer_game.php?room=$roomCode"); // Host ikut main
    exit;
}

// Logic Player Redirect jika game mulai
if (!$isHost && $room['status'] === 'playing') {
    header("Location: multiplayer_game.php?room=$roomCode");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lobby - <?php echo $roomCode; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
    <style>
        .pin-display {
            font-size: 4em;
            font-weight: 800;
            letter-spacing: 10px;
            color: var(--accent-teal);
            background: var(--bg-secondary);
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
            margin: 20px 0;
            border: 3px dashed var(--border-color);
        }
        .player-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        .player-card {
            background: var(--glass-bg);
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes popIn { from { transform: scale(0); } to { transform: scale(1); } }
    </style>
</head>
<body>
    <?php $path = ""; include 'includes/navbar.php'; ?>
    
    <div class="container" style="text-align: center;">
        <h2 style="color: var(--text-secondary);">KODE ROOM</h2>
        <div class="pin-display"><?php echo $roomCode; ?></div>
        <h3>Topik: <?php echo htmlspecialchars($room['topic']); ?></h3>
        
        <div class="materi-card" style="margin-top: 30px;">
            <h4><i class="fas fa-users"></i> Pemain Bergabung (<span id="count">0</span>)</h4>
            <div id="players" class="player-list">
                <!-- Player list via AJAX -->
            </div>
        </div>

        <?php if ($isHost): ?>
            <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="openInviteModal()" class="btn" style="font-size: 1.2em; padding: 15px 30px; background: var(--accent-blue);">
                    <i class="fas fa-user-plus"></i> UNDANG TEMAN
                </button>
                
                <form method="POST">
                    <button type="submit" name="start_game" class="btn" style="font-size: 1.2em; padding: 15px 40px; background: #2ecc71;">
                        MULAI GAME <i class="fas fa-play"></i>
                    </button>
                </form>
            </div>
            <p style="margin-top: 10px; color: var(--text-secondary);">Klik mulai jika semua teman sudah masuk.</p>
        <?php else: ?>
            <div style="margin-top: 30px;">
                <div class="loader" style="display:inline-block; border-width:3px; width:30px; height:30px;"></div>
                <p>Menunggu Host memulai permainan...</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const roomCode = '<?php echo $roomCode; ?>';
        const isHost = <?php echo $isHost ? 'true' : 'false'; ?>;

        function checkLobby() {
            fetch(`api_multiplayer.php?action=check_lobby&room=${roomCode}`)
                .then(res => res.json())
                .then(data => {
                    // Update Player List
                    const list = document.getElementById('players');
                    document.getElementById('count').innerText = data.players.length;
                    
                    list.innerHTML = data.players.map(p => `
                        <div class="player-card">
                            <i class="fas fa-user-astronaut" style="color: var(--accent-teal)"></i>
                            <strong>${p.username}</strong>
                        </div>
                    `).join('');

                    // Player: Cek status game
                    if (!isHost && data.status === 'playing') {
                        window.location.href = `multiplayer_game.php?room=${roomCode}`;
                    }
                });
        }

        setInterval(checkLobby, 2000); // Cek setiap 2 detik
        checkLobby(); // Cek pertama kali

        // --- INVITE SYSTEM ---
        function openInviteModal() {
            Swal.fire({
                title: 'Undang Teman',
                html: '<div id="friend-list-container"><i class="fas fa-spinner fa-spin"></i> Memuat teman...</div>',
                showConfirmButton: false,
                showCloseButton: true,
                didOpen: () => {
                    fetch('api_invite.php?action=list_friends')
                        .then(res => res.json())
                        .then(friends => {
                            const container = document.getElementById('friend-list-container');
                            if (friends.length === 0) {
                                container.innerHTML = '<p>Belum ada teman online.</p>';
                                return;
                            }
                            
                            let html = '<div style="display:flex; flex-direction:column; gap:10px; max-height:300px; overflow-y:auto;">';
                            friends.forEach(f => {
                                html += `
                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px; background:var(--bg-secondary); border-radius:10px;">
                                        <span>${f.friend_username}</span>
                                        <button onclick="sendInvite('${f.friend_username}')" class="btn" style="padding:5px 15px; font-size:0.9em;">
                                            Undang
                                        </button>
                                    </div>
                                `;
                            });
                            html += '</div>';
                            container.innerHTML = html;
                        });
                }
            });
        }

        function sendInvite(username) {
            const formData = new FormData();
            formData.append('room_code', roomCode);
            formData.append('receiver', username);

            fetch('api_invite.php?action=send_invite', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Terkirim!', `Undangan dikirim ke ${username}`, 'success');
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            });
        }
    </script>
    <script src="script.js"></script>
</body>
</html>