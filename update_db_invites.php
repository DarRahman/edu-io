<?php
include 'koneksi.php';

$sql = "CREATE TABLE IF NOT EXISTS game_invites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_code VARCHAR(10) NOT NULL,
    sender VARCHAR(50) NOT NULL,
    receiver VARCHAR(50) NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Tabel 'game_invites' berhasil dibuat!</h3>";
    echo "<p>Sekarang fitur undang teman sudah siap digunakan.</p>";
    echo "<a href='index.php'>Kembali ke Home</a>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>