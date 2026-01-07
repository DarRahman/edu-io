<?php
session_start();
include '../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$aid = isset($_REQUEST['answer_id']) ? (int)$_REQUEST['answer_id'] : 0;
$rate = isset($_REQUEST['rating']) ? (int)$_REQUEST['rating'] : 0;
$username = mysqli_real_escape_string($conn, $_SESSION['loggedInUser']);

if ($aid > 0 && $rate > 0) {
    // Cek apakah user mencoba memberi rating pada jawaban sendiri
    $cekJawaban = mysqli_query($conn, "SELECT username FROM forum_answers WHERE id = $aid LIMIT 1");
    if ($cekJawaban && mysqli_num_rows($cekJawaban) > 0) {
        $rowJawaban = mysqli_fetch_assoc($cekJawaban);
        if ($rowJawaban['username'] === $username) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak bisa memberi rating pada jawaban sendiri']);
            exit;
        }
    }

    // Cek apakah user sudah pernah memberi rating pada jawaban ini
    $cekRating = mysqli_query($conn, "SELECT id FROM forum_ratings WHERE answer_id = $aid AND username = '$username' LIMIT 1");
    if (mysqli_num_rows($cekRating) > 0) {
        // Update rating jika sudah ada
        $update = mysqli_query($conn, "UPDATE forum_ratings SET rating_value = $rate WHERE answer_id = $aid AND username = '$username'");
        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Rating berhasil diupdate']);
            exit;
        }
    } else {
        // Insert rating baru
        $insert = mysqli_query($conn, "INSERT INTO forum_ratings (answer_id, username, rating_value) VALUES ($aid, '$username', $rate)");
        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Rating berhasil disimpan']);
            exit;
        }
    }
}

echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan']);
?>
