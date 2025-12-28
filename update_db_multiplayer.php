<?php
include 'koneksi.php';

// 1. Tabel quiz_rooms
$q1 = "CREATE TABLE IF NOT EXISTS quiz_rooms (
    room_code VARCHAR(10) PRIMARY KEY,
    host_username VARCHAR(50) NOT NULL,
    topic VARCHAR(100) NOT NULL,
    quiz_data JSON NOT NULL,
    status ENUM('waiting', 'playing', 'finished') DEFAULT 'waiting',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// 2. Tabel quiz_participants
$q2 = "CREATE TABLE IF NOT EXISTS quiz_participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_code VARCHAR(10) NOT NULL,
    username VARCHAR(50) NOT NULL,
    score INT DEFAULT 0,
    current_question INT DEFAULT 0,
    is_finished TINYINT(1) DEFAULT 0,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_code) REFERENCES quiz_rooms(room_code) ON DELETE CASCADE
)";

if (mysqli_query($conn, $q1) && mysqli_query($conn, $q2)) {
    echo "Tabel multiplayer berhasil dibuat.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>