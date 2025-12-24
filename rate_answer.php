<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    echo "not_logged_in";
    exit;
}

if (isset($_POST['answer_id']) && isset($_POST['rating'])) {
    $aid = $_POST['answer_id'];
    $rate = $_POST['rating'];
    $username = $_SESSION['loggedInUser'];

    // Cek apakah user mencoba memberi rating pada jawaban sendiri
    $cekJawaban = mysqli_query($conn, "SELECT username FROM forum_answers WHERE id = $aid LIMIT 1");
    if ($cekJawaban && mysqli_num_rows($cekJawaban) > 0) {
        $rowJawaban = mysqli_fetch_assoc($cekJawaban);
        if ($rowJawaban['username'] === $username) {
            echo "cannot_rate_own_answer";
            exit;
        }
    }

    $query = "INSERT INTO forum_ratings (answer_id, username, rating_value) 
              VALUES ($aid, '$username', $rate) 
              ON DUPLICATE KEY UPDATE rating_value = $rate";

    if (mysqli_query($conn, $query)) {
        echo "success";
    }
}
?>