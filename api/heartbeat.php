<?php
session_start();
include '../config/koneksi.php';

if (isset($_SESSION['loggedInUser'])) {
    $user = $_SESSION['loggedInUser'];
    mysqli_query($conn, "UPDATE users SET last_seen = NOW() WHERE username = '$user'");
    
    // Update online_users table for visitor stats too
    $sid = session_id();
    $time = time();
    mysqli_query($conn, "REPLACE INTO online_users (session_id, last_activity) VALUES ('$sid', '$time')");
}

// Clean up old online users (timeout 40 seconds)
$cutoff = time() - 40;
mysqli_query($conn, "DELETE FROM online_users WHERE last_activity < $cutoff");

// Get notifications
$notifications = [];
if (isset($_SESSION['loggedInUser'])) {
    $user = $_SESSION['loggedInUser'];
    $res = mysqli_query($conn, "SELECT * FROM notifications WHERE username = '$user' AND is_read = 0 ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($res)) {
        $notifications[] = $row;
    }
    
    // Mark as read after fetching
    if (!empty($notifications)) {
        mysqli_query($conn, "UPDATE notifications SET is_read = 1 WHERE username = '$user' AND is_read = 0");
    }
}

echo json_encode(['status' => 'success', 'notifications' => $notifications]);
