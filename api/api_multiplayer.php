<?php
include '../config/koneksi.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$roomCode = mysqli_real_escape_string($conn, $_GET['room'] ?? '');

if ($action === 'check_lobby') {
    // Ambil status room
    $qRoom = mysqli_query($conn, "SELECT status FROM quiz_rooms WHERE room_code = '$roomCode'");
    $room = mysqli_fetch_assoc($qRoom);
    
    // Ambil peserta
    $qPlayers = mysqli_query($conn, "SELECT username FROM quiz_participants WHERE room_code = '$roomCode'");
    $players = [];
    while ($row = mysqli_fetch_assoc($qPlayers)) {
        $players[] = $row;
    }
    
    echo json_encode(['status' => $room['status'], 'players' => $players]);
}

if ($action === 'get_leaderboard') {
    // Ambil leaderboard live
    $query = "SELECT username, score, current_question, is_finished FROM quiz_participants 
              WHERE room_code = '$roomCode' 
              ORDER BY score DESC, is_finished DESC, current_question DESC";
    $res = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($action === 'submit_answer') {
    session_start();
    $username = mysqli_real_escape_string($conn, $_SESSION['loggedInUser']);
    $isCorrect = ($_POST['is_correct'] ?? 'false') === 'true';
    
    // Update score & progress
    $scoreAdd = $isCorrect ? 100 : 0;
    $sql = "UPDATE quiz_participants SET 
            score = COALESCE(score, 0) + $scoreAdd, 
            current_question = COALESCE(current_question, 0) + 1 
            WHERE room_code = '$roomCode' AND username = '$username'";
    mysqli_query($conn, $sql);
    
    echo json_encode(['status' => 'ok']);
}

if ($action === 'finish_game') {
    session_start();
    $username = mysqli_real_escape_string($conn, $_SESSION['loggedInUser']);
    mysqli_query($conn, "UPDATE quiz_participants SET is_finished = 1 WHERE room_code = '$roomCode' AND username = '$username'");
    echo json_encode(['status' => 'ok']);
}

if ($action === 'check_all_finished') {
    $qTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM quiz_participants WHERE room_code = '$roomCode'");
    $total = mysqli_fetch_assoc($qTotal)['total'];

    $qFinished = mysqli_query($conn, "SELECT COUNT(*) as finished FROM quiz_participants WHERE room_code = '$roomCode' AND is_finished = 1");
    $finished = mysqli_fetch_assoc($qFinished)['finished'];

    echo json_encode([
        'all_finished' => ($total > 0 && $total == $finished),
        'total' => (int)$total,
        'finished' => (int)$finished
    ]);
}
?>
