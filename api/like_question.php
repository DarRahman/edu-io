<?php
session_start();
include '../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['success' => false, 'message' => 'not_logged_in']);
    exit;
}

$currentUser = $_SESSION['loggedInUser'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['question_id'])) {
    echo json_encode(['success' => false, 'message' => 'invalid_request']);
    exit;
}

$questionId = intval($_POST['question_id']);

// Check if the question exists and get the owner
$questionQuery = mysqli_query($conn, "SELECT username FROM forum_questions WHERE id = '$questionId'");
if (!$questionQuery || mysqli_num_rows($questionQuery) === 0) {
    echo json_encode(['success' => false, 'message' => 'question_not_found']);
    exit;
}

$questionData = mysqli_fetch_assoc($questionQuery);
// Prevent liking own question
if ($questionData['username'] === $currentUser) {
    echo json_encode(['success' => false, 'message' => 'cannot_like_own_question']);
    exit;
}

// Check if user already liked this question
$checkLike = mysqli_query($conn, "SELECT id FROM forum_likes WHERE question_id = '$questionId' AND username = '$currentUser'");

if (mysqli_num_rows($checkLike) > 0) {
    // User already liked, so unlike
    mysqli_query($conn, "DELETE FROM forum_likes WHERE question_id = '$questionId' AND username = '$currentUser'");
    $action = 'unliked';
} else {
    // User hasn't liked, so like
    mysqli_query($conn, "INSERT INTO forum_likes (question_id, username, created_at) VALUES ('$questionId', '$currentUser', NOW())");
    $action = 'liked';
}

// Get new like count
$likeCountQuery = mysqli_query($conn, "SELECT COUNT(*) as count FROM forum_likes WHERE question_id = '$questionId'");
$likeCount = mysqli_fetch_assoc($likeCountQuery)['count'];

echo json_encode([
    'success' => true,
    'action' => $action,
    'new_count' => $likeCount
]);
?>