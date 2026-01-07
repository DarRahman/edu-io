<?php
session_start();
include '../config/koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$action = $_GET['action'] ?? '';

// 1. Ambil Daftar Teman untuk Diundang
if ($action === 'list_friends') {
    // Ambil teman yang statusnya 'accepted'
    // Kolom di tabel friends adalah 'requester' dan 'receiver'
    $query = "SELECT 
                CASE 
                    WHEN requester = '$currentUser' THEN receiver 
                    ELSE requester 
                END AS friend_username
              FROM friends 
              WHERE (requester = '$currentUser' OR receiver = '$currentUser') 
              AND status = 'accepted'";
              
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo json_encode(['error' => mysqli_error($conn)]);
        exit;
    }

    $friends = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $friends[] = $row;
    }
    echo json_encode($friends);
    exit;
}

// 2. Kirim Undangan
if ($action === 'send_invite') {
    $roomCode = mysqli_real_escape_string($conn, $_POST['room_code']);
    $receiver = mysqli_real_escape_string($conn, $_POST['receiver']);
    
    // Cek apakah sudah pernah diundang dan masih pending
    $check = mysqli_query($conn, "SELECT id FROM game_invites WHERE room_code='$roomCode' AND sender='$currentUser' AND receiver='$receiver' AND status='pending'");
    
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO game_invites (room_code, sender, receiver) VALUES ('$roomCode', '$currentUser', '$receiver')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Undangan sudah dikirim sebelumnya.']);
    }
    exit;
}

// 3. Cek Undangan Masuk (Polling oleh Receiver)
if ($action === 'check_invites') {
    // Cari undangan pending dalam 1 menit terakhir
    $query = "SELECT * FROM game_invites 
              WHERE receiver = '$currentUser' 
              AND status = 'pending' 
              AND created_at > NOW() - INTERVAL 1 MINUTE
              ORDER BY created_at DESC LIMIT 1";
              
    $result = mysqli_query($conn, $query);
    $invite = mysqli_fetch_assoc($result);
    
    if ($invite) {
        echo json_encode(['status' => 'found', 'data' => $invite]);
    } else {
        echo json_encode(['status' => 'none']);
    }
    exit;
}

// 4. Respon Undangan (Terima/Tolak)
if ($action === 'respond_invite') {
    $inviteId = (int)$_POST['invite_id'];
    $response = $_POST['response']; // 'accepted' or 'rejected'
    
    $sql = "UPDATE game_invites SET status = '$response' WHERE id = $inviteId";
    mysqli_query($conn, $sql);
    
    echo json_encode(['status' => 'success']);
    exit;
}
?>
