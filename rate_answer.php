<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    echo "not_logged_in";
    exit;
}

if (isset($_POST['answer_id']) && isset($_POST['rating'])) {
    $aid = (int) $_POST['answer_id'];
    $rate = (int) $_POST['rating'];
    $username = mysqli_real_escape_string($conn, $_SESSION['loggedInUser']);

    // Cek apakah user mencoba memberi rating pada jawaban sendiri
    $cekJawaban = mysqli_query($conn, "SELECT username FROM forum_answers WHERE id = $aid LIMIT 1");
    if ($cekJawaban && mysqli_num_rows($cekJawaban) > 0) {
        $rowJawaban = mysqli_fetch_assoc($cekJawaban);
        if ($rowJawaban['username'] === $username) {
            echo "cannot_rate_own_answer";
            exit;
        }
    }

    // Cek apakah user sudah pernah memberi rating pada jawaban ini
    $cekRating = mysqli_query($conn, "SELECT id FROM forum_ratings WHERE answer_id = $aid AND username = '$username' LIMIT 1");
    if ($cekRating && mysqli_num_rows($cekRating) > 0) {
        // Update rating jika sudah ada
        $update = mysqli_query($conn, "UPDATE forum_ratings SET rating_value = $rate WHERE answer_id = $aid AND username = '$username'");
        if ($update) {
            echo "success";
        }
    } else {
        // Insert rating baru
        $insert = mysqli_query($conn, "INSERT INTO forum_ratings (answer_id, username, rating_value) VALUES ($aid, '$username', $rate)");
        if ($insert) {
            echo "success";
        }
    }
}
?>