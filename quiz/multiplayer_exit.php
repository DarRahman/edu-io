<?php
session_start();
include '../config/koneksi.php';

if (isset($_GET['room']) && isset($_SESSION['loggedInUser'])) {
    $roomCode = mysqli_real_escape_string($conn, $_GET['room']);
    $username = $_SESSION['loggedInUser'];

    // Hapus user dari peserta
    mysqli_query($conn, "DELETE FROM quiz_participants WHERE room_code = '$roomCode' AND username = '$username'");

    // Opsional: Jika Host keluar saat status masih waiting, hapus room (bubar jalan)
    // Cek apakah user adalah host
    $checkHost = mysqli_query($conn, "SELECT host_username FROM quiz_rooms WHERE room_code = '$roomCode'");
    $roomData = mysqli_fetch_assoc($checkHost);

    if ($roomData && $roomData['host_username'] === $username) {
        // Hapus room dan semua peserta
        mysqli_query($conn, "DELETE FROM quiz_rooms WHERE room_code = '$roomCode'");
        mysqli_query($conn, "DELETE FROM quiz_participants WHERE room_code = '$roomCode'");
        mysqli_query($conn, "DELETE FROM game_invites WHERE room_code = '$roomCode'");
    }
}

header("Location: index.php");
exit;
?>
