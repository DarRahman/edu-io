<?php
session_start();
include '../config/koneksi.php';

function getProfilePath($foto)
{
    if (empty($foto)) {
        return "../img/default-pp.png";
    }
    if (strpos($foto, 'http') === 0) {
        return $foto;
    }
    return "../img/" . $foto;
}

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../auth/login.php");
    exit;
}
if (!isset($_GET['room'])) {
    header("Location: index.php");
    exit;
}

$roomCode = mysqli_real_escape_string($conn, $_GET['room']);
$currentUser = $_SESSION['loggedInUser'];

// Tandai user sudah selesai
mysqli_query($conn, "UPDATE quiz_participants SET is_finished = 1 WHERE room_code = '$roomCode' AND username = '$currentUser'");

// Cek apakah semua sudah selesai
$qTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM quiz_participants WHERE room_code = '$roomCode'");
$totalParticipants = mysqli_fetch_assoc($qTotal)['total'] ?? 0;

$qFinished = mysqli_query($conn, "SELECT COUNT(*) as finished FROM quiz_participants WHERE room_code = '$roomCode' AND is_finished = 1");
$finishedParticipants = mysqli_fetch_assoc($qFinished)['finished'] ?? 0;

$allFinished = ($totalParticipants > 0 && $totalParticipants == $finishedParticipants);

// Ambil Top 3 (Hanya jika semua sudah selesai)
$winners = [];
if ($allFinished) {
    $query = "SELECT p.username, p.score, u.profile_pic 
              FROM quiz_participants p 
              JOIN users u ON p.username = u.username 
              WHERE p.room_code = '$roomCode' 
              ORDER BY p.score DESC, p.is_finished DESC 
              LIMIT 3";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($res)) {
        $winners[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Akhir - <?php echo $roomCode; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
    <link rel="stylesheet" href="../assets/css/multiplayer.css">
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container" style="text-align: center;">
        <h1><i class="fas fa-trophy"></i> Hasil Akhir</h1>
        
        <?php if ($allFinished): ?>
            <p>Selamat kepada para pemenang!</p>

            <div class="podium">
                <?php if (isset($winners[1])): ?>
                    <div class="podium-item" style="order: 1;">
                    <img src="<?php echo getProfilePath($winners[1]['profile_pic']); ?>" class="winner-avatar">
                    <div style="font-weight: bold; margin-bottom: 5px;"><?php echo $winners[1]['username']; ?></div>
                    <div class="podium-block rank-2">2</div>
                    <div style="margin-top: 5px; font-weight: bold;"><?php echo $winners[1]['score']; ?> pts</div>
                </div>
            <?php endif; ?>

            <?php if (isset($winners[0])): ?>
                <div class="podium-item" style="order: 2;">
                    <i class="fas fa-crown"
                        style="color: #f1c40f; font-size: 2em; margin-bottom: 10px; animation: bounce 1s infinite;"></i>
                    <img src="<?php echo getProfilePath($winners[0]['profile_pic']); ?>" class="winner-avatar"
                        style="width: 80px; height: 80px; border-color: #f1c40f;">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 1.2em;">
                        <?php echo $winners[0]['username']; ?></div>
                    <div class="podium-block rank-1">1</div>
                    <div style="margin-top: 5px; font-weight: bold;"><?php echo $winners[0]['score']; ?> pts</div>
                </div>
            <?php endif; ?>

            <?php if (isset($winners[2])): ?>
                <div class="podium-item" style="order: 3;">
                    <img src="<?php echo getProfilePath($winners[2]['profile_pic']); ?>" class="winner-avatar">
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-top: 50px;">
                <a href="index.php" class="btn">Kembali ke Home</a>
            </div>
        <?php else: ?>
            <div class="materi-card" style="margin-top: 50px; padding: 40px;">
                <div class="loader" style="display:inline-block; border-width:5px; width:50px; height:50px;"></div>
                <h2 style="margin-top: 20px;">Menunggu Pemain Lain...</h2>
                <p id="wait-status" style="font-size: 1.2em; color: var(--text-secondary);">
                    <?php echo $finishedParticipants; ?> dari <?php echo $totalParticipants; ?> pemain sudah selesai.
                </p>
                <p>Halaman ini akan otomatis diperbarui jika semua sudah selesai.</p>
            </div>

            <script>
                const roomCode = '<?php echo $roomCode; ?>';
                function checkStatus() {
                    fetch(`../api/api_multiplayer.php?action=check_all_finished&room=${roomCode}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('wait-status').innerText = 
                                `${data.finished} dari ${data.total} pemain sudah selesai.`;
                            
                            if (data.all_finished) {
                                location.reload();
                            }
                        });
                }
                setInterval(checkStatus, 2000);
            </script>
        <?php endif; ?>
    </div>

    <script src="../assets/js/script.js"></script>
    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
</body>

</html>