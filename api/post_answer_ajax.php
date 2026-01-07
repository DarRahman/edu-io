<?php
session_start();
header('Content-Type: application/json');
include '../config/koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$qid = (int)$_POST['question_id'];
$ans = mysqli_real_escape_string($conn, $_POST['answer']);

if (empty($ans)) {
    echo json_encode(['status' => 'error', 'message' => 'Answer cannot be empty']);
    exit;
}

// Ambil info pembuat pertanyaan untuk notifikasi
$qOwnerQuery = mysqli_query($conn, "SELECT username FROM forum_questions WHERE id = $qid");
if ($qOwnerQuery && mysqli_num_rows($qOwnerQuery) > 0) {
    $qOwnerData = mysqli_fetch_assoc($qOwnerQuery);
    $qOwner = $qOwnerData['username'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Pertanyaan tidak ditemukan']);
    exit;
}

if (mysqli_query($conn, "INSERT INTO forum_answers (question_id, username, answer) VALUES ('$qid', '$currentUser', '$ans')")) {
    // KIRIM NOTIFIKASI ke pemilik pertanyaan (jika bukan dirinya sendiri)
    if ($qOwner && $qOwner !== $currentUser) {
        $msg = "$currentUser memberikan jawaban pada diskusi Anda.";
        mysqli_query($conn, "INSERT INTO notifications (username, message, type, link) VALUES ('$qOwner', '$msg', 'forum_reply', 'pages/forum.php')");
    }
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}
