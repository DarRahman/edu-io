<?php
session_start();
include '../config/koneksi.php';
include '../config/config.php'; // Pastikan $apiKey ada di sini

if (!isset($_SESSION['loggedInUser'])) {
  header("Location: ../auth/login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = mysqli_real_escape_string($conn, $_POST['topic']);
    $host = $_SESSION['loggedInUser'];

    // 1. Generate PIN Unik (6 digit angka)
    $roomCode = rand(100000, 999999);

    // 2. Panggil AI untuk buat soal
    $prompt = "Buatlah 10 soal pilihan ganda tentang '$topic' untuk level pemula. 
    Format output HARUS JSON murni tanpa markdown, dengan struktur array objek: 
    [{'question': '...', 'options': ['A', 'B', 'C', 'D'], 'correct_index': 0}, ...]. 
    Pastikan options ada 4. correct_index adalah 0-3.";

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek Error API
    if (isset($result['error'])) {
        $errMsg = addslashes($result['error']['message']);
        echo "<script>alert('Gemini API Error: $errMsg'); window.location='multiplayer_create.php';</script>";
        exit;
    }

    $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

    // Bersihkan markdown ```json jika ada
    $rawText = str_replace(['```json', '```'], '', $rawText);
    $quizData = trim($rawText);

    // Validasi JSON
    if (json_decode($quizData) === null) {
        // Fallback jika AI gagal generate JSON valid
        $debug = addslashes(substr($rawText, 0, 100));
        echo "<script>alert('Gagal generate soal (Invalid JSON). Raw: $debug'); window.location='multiplayer_create.php';</script>";
        exit;
    }

    // 3. Simpan ke DB
    $stmt = $conn->prepare("INSERT INTO quiz_rooms (room_code, host_username, topic, quiz_data) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $roomCode, $host, $topic, $quizData);

    if ($stmt->execute()) {
        // Tambahkan Host sebagai peserta juga
        mysqli_query($conn, "INSERT INTO quiz_participants (room_code, username) VALUES ('$roomCode', '$host')");

        header("Location: multiplayer_lobby.php?room=$roomCode");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buat Room Kuis - edu.io</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container" style="max-width: 600px; margin-top: 50px;">
        <div class="materi-card" style="text-align: center; padding: 40px;">
            <i class="fas fa-gamepad" style="font-size: 4em; color: var(--accent-teal); margin-bottom: 20px;"></i>
            <h1 style="margin-bottom: 10px;">Buat Room Quiz Multiplayer</h1>
            <p style="color: var(--text-secondary); margin-bottom: 30px;">Tantang temanmu dalam kuis real-time!</p>

            <form method="POST" onsubmit="showLoading()">
                <div class="input-group" style="text-align: left;">
                    <label>Topik Kuis</label>
                    <input type="text" name="topic" placeholder="Contoh: Sejarah Indonesia, Matematika Dasar, Anime..."
                        required style="font-size: 1.1em; padding: 15px;">
                </div>

                <button type="submit" class="btn" style="width: 100%; font-size: 1.1em; padding: 15px;">
                    <i class="fas fa-magic"></i> Generate & Buat Room
                </button>
            </form>

            <div id="loading" style="display: none; margin-top: 20px;">
                <i class="fas fa-spinner fa-spin"></i> Sedang membuat soal bersama AI...
            </div>
        </div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.querySelector('button[type="submit"]').disabled = true;
            document.querySelector('button[type="submit"]').innerHTML = 'Memproses...';
        }
    </script>
    <script src="../assets/js/script.js"></script>
    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
</body>

</html>