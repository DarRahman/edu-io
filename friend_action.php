<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$action = $_POST['action'] ?? '';
$targetUser = mysqli_real_escape_string($conn, $_POST['username'] ?? '');

if (empty($targetUser) || $targetUser === $currentUser) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user']);
    exit;
}

if ($action === 'add') {
    // Cek apakah sudah ada request
    $check = mysqli_query($conn, "SELECT * FROM friends WHERE (requester='$currentUser' AND receiver='$targetUser') OR (requester='$targetUser' AND receiver='$currentUser')");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Permintaan sudah ada atau sudah berteman.']);
    } else {
        $insert = mysqli_query($conn, "INSERT INTO friends (requester, receiver, status) VALUES ('$currentUser', '$targetUser', 'pending')");
        if ($insert) echo json_encode(['status' => 'success', 'message' => 'Permintaan pertemanan dikirim!']);
        else echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim permintaan.']);
    }
} elseif ($action === 'accept') {
    // Hanya receiver yang bisa accept
    $update = mysqli_query($conn, "UPDATE friends SET status='accepted' WHERE requester='$targetUser' AND receiver='$currentUser'");
    if ($update) echo json_encode(['status' => 'success', 'message' => 'Pertemanan diterima!']);
    else echo json_encode(['status' => 'error', 'message' => 'Gagal menerima permintaan.']);
} elseif ($action === 'reject' || $action === 'cancel' || $action === 'remove') {
    // Hapus relasi
    $delete = mysqli_query($conn, "DELETE FROM friends WHERE (requester='$currentUser' AND receiver='$targetUser') OR (requester='$targetUser' AND receiver='$currentUser')");
    if ($delete) echo json_encode(['status' => 'success', 'message' => 'Relasi dihapus.']);
    else echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>