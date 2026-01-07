<?php
session_start();
header('Content-Type: application/json');
include '../config/koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$question = mysqli_real_escape_string($conn, $_POST['question']);
$imagePath = null;

if (empty($question)) {
    echo json_encode(['status' => 'error', 'message' => 'Question cannot be empty']);
    exit;
}

// Handle Image Upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $filename = $_FILES['image']['name'];
    $filetmp = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        $newFilename = uniqid('forum_', true) . '.' . $ext;
        $destination = '../img/forum/' . $newFilename;
        if (move_uploaded_file($filetmp, $destination)) {
            $imagePath = $newFilename;
        }
    }
}

$sql = "INSERT INTO forum_questions (username, question, image) VALUES ('$currentUser', '$question', " . ($imagePath ? "'$imagePath'" : "NULL") . ")";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}
