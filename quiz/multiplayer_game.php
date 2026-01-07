<?php
session_start();
include '../config/koneksi.php';

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

// Ambil Data Soal
$query = mysqli_query($conn, "SELECT quiz_data FROM quiz_rooms WHERE room_code = '$roomCode'");
$room = mysqli_fetch_assoc($query);
$questions = json_decode($room['quiz_data'], true);

// Ambil Progress User
$qProg = mysqli_query($conn, "SELECT current_question FROM quiz_participants WHERE room_code = '$roomCode' AND username = '$currentUser'");
$prog = mysqli_fetch_assoc($qProg);
$currentIndex = (int)($prog['current_question'] ?? 0);

// Jika sudah selesai semua soal
if ($currentIndex >= count($questions)) {
    header("Location: multiplayer_result.php?room=$roomCode");
    exit;
}

$currentQ = $questions[$currentIndex];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Quiz Race - <?php echo $roomCode; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
    <style>
        .option-btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            background: var(--glass-bg);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            text-align: left;
            cursor: pointer;
            transition: 0.2s;
            font-size: 1.1em;
            color: var(--text-primary);
        }
        .option-btn:hover {
            background: var(--accent-teal);
            color: white;
            border-color: var(--accent-teal);
        }
        .progress-bar {
            height: 10px;
            background: var(--bg-secondary);
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: var(--accent-teal);
            width: <?php echo ($currentIndex / count($questions)) * 100; ?>%;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 20px; left: 20px;">
        <a href="multiplayer_exit.php?room=<?php echo $roomCode; ?>" class="btn" style="background: #e74c3c; padding: 10px 20px;" onclick="return confirm('Yakin ingin menyerah?');">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </div>

    <div class="container" style="max-width: 600px; margin-top: 60px;">
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <div class="materi-card">
            <span class="badge" style="background: var(--accent-teal); color: white; padding: 5px 10px; border-radius: 5px;">
                Soal <?php echo $currentIndex + 1; ?> / <?php echo count($questions); ?>
            </span>
            
            <h2 style="margin: 20px 0;"><?php echo htmlspecialchars($currentQ['question']); ?></h2>
            
            <div id="options">
                <?php foreach ($currentQ['options'] as $idx => $opt): ?>
                    <button class="option-btn" onclick="submitAnswer(<?php echo $idx; ?>)">
                        <?php echo htmlspecialchars($opt); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        const correctIndex = <?php echo $currentQ['correct_index']; ?>;
        const roomCode = '<?php echo $roomCode; ?>';

        function submitAnswer(selectedIndex) {
            const isCorrect = (selectedIndex === correctIndex);
            
            // Visual Feedback
            const btns = document.querySelectorAll('.option-btn');
            btns[selectedIndex].style.background = isCorrect ? '#2ecc71' : '#e74c3c';
            btns[selectedIndex].style.color = 'white';
            
            if (!isCorrect) {
                btns[correctIndex].style.background = '#2ecc71'; // Show correct answer
                btns[correctIndex].style.color = 'white';
            }

            // Disable all buttons
            btns.forEach(b => b.disabled = true);

            // Send to Server
            const formData = new FormData();
            formData.append('is_correct', isCorrect);

            fetch(`../api/api_multiplayer.php?action=submit_answer&room=${roomCode}`, {
                method: 'POST',
                body: formData
            }).then(() => {
                setTimeout(() => {
                    location.reload(); // Load next question
                }, 1000);
            });
        }
    </script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
