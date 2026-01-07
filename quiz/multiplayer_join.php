<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
  header("Location: ../auth/login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto_join'])) {
    $roomCode = isset($_GET['auto_join']) ?
        mysqli_real_escape_string($conn, $_GET['auto_join']) :
        mysqli_real_escape_string($conn, $_POST['room_code']);

    $username = $_SESSION['loggedInUser'];

    // 1. Cek apakah room ada dan status waiting
    $check = mysqli_query($conn, "SELECT * FROM quiz_rooms WHERE room_code = '$roomCode' AND status = 'waiting'");
    if (mysqli_num_rows($check) > 0) {
        // 2. Cek apakah user sudah join
        $checkUser = mysqli_query($conn, "SELECT * FROM quiz_participants WHERE room_code = '$roomCode' AND username = '$username'");
        if (mysqli_num_rows($checkUser) == 0) {
            // Join room
            mysqli_query($conn, "INSERT INTO quiz_participants (room_code, username) VALUES ('$roomCode', '$username')");
        }
        header("Location: multiplayer_lobby.php?room=$roomCode");
    } else {
        echo "<script>alert('Room tidak ditemukan atau permainan sudah dimulai!'); window.location='multiplayer_join.php';</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Join Room - edu.io</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="materi-card" style="text-align: center; padding: 40px;">
            <i class="fas fa-door-open" style="font-size: 4em; color: #f39c12; margin-bottom: 20px;"></i>
            <h1>Gabung Kuis</h1>
            <p style="margin-bottom: 30px;">Masukkan Kode PIN dari Host</p>

            <form method="POST">
                <input type="number" name="room_code" placeholder="PIN (6 Digit)" required
                    style="font-size: 2em; letter-spacing: 5px; text-align: center; width: 100%; max-width: 300px; padding: 15px; border-radius: 15px; border: 2px solid var(--border-color); margin-bottom: 20px;">

                <button type="submit" class="btn" style="width: 100%; font-size: 1.2em;">
                    MASUK <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
</body>

</html>