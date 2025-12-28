<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser']) || !isset($_GET['room'])) {
    header("Location: index.php");
    exit;
}

$roomCode = mysqli_real_escape_string($conn, $_GET['room']);
$query = mysqli_query($conn, "SELECT * FROM quiz_rooms WHERE room_code = '$roomCode'");
$room = mysqli_fetch_assoc($query);

// Hitung total soal
$questions = json_decode($room['quiz_data'], true);
$totalQ = count($questions);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Live Monitor - <?php echo $roomCode; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
    <style>
        .racer-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            transition: all 0.5s ease;
            position: relative;
        }
        .racer-track {
            flex: 1;
            background: rgba(255,255,255,0.1);
            height: 50px;
            border-radius: 25px;
            position: relative;
            margin-left: 15px;
            border: 1px solid var(--border-color);
        }
        .racer-avatar {
            position: absolute;
            top: -5px;
            left: 0;
            transition: left 0.5s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60px;
        }
        .racer-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .racer-name {
            font-size: 0.8em;
            font-weight: bold;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 2px 5px;
            border-radius: 5px;
            margin-top: -10px;
            white-space: nowrap;
        }
        .finish-line {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: repeating-linear-gradient(
                45deg,
                #000,
                #000 10px,
                #fff 10px,
                #fff 20px
            );
            z-index: 0;
        }
    </style>
</head>
<body>
    <?php $path = ""; include 'includes/navbar.php'; ?>
    
    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1><i class="fas fa-flag-checkered"></i> Live Race</h1>
            <h2 style="color: var(--accent-teal);">Room: <?php echo $roomCode; ?></h2>
            <p>Pantau progress pemain secara real-time!</p>
        </div>

        <div class="materi-card" id="race-track">
            <!-- Track akan diisi via JS -->
        </div>
    </div>

    <script>
        const roomCode = '<?php echo $roomCode; ?>';
        const totalQuestions = <?php echo $totalQ; ?>;

        function updateRace() {
            fetch(`api_multiplayer.php?action=get_leaderboard&room=${roomCode}`)
                .then(res => res.json())
                .then(data => {
                    const track = document.getElementById('race-track');
                    track.innerHTML = ''; // Reset

                    data.forEach(player => {
                        // Hitung persentase progress (0 - 100%)
                        // Kita kurangi sedikit (90%) agar avatar tidak keluar track
                        let progress = (player.current_question / totalQuestions) * 90;
                        if (player.is_finished == 1) progress = 92; // Finish line

                        const html = `
                            <div class="racer-row">
                                <div style="width: 100px; font-weight: bold;">${player.username}<br>
                                <small style="color: var(--accent-teal)">${player.score} pts</small></div>
                                <div class="racer-track">
                                    <div class="finish-line"></div>
                                    <div class="racer-avatar" style="left: ${progress}%">
                                        <img src="img/default-pp.png"> <!-- Bisa diganti foto profil asli -->
                                        <span class="racer-name">${player.username}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        track.innerHTML += html;
                    });
                });
        }

        setInterval(updateRace, 2000); // Update tiap 2 detik
        updateRace();
    </script>
    <script src="script.js"></script>
</body>
</html>