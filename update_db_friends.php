<?php
include 'koneksi.php';

// Buat tabel friends
$query = "CREATE TABLE IF NOT EXISTS friends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requester VARCHAR(50) NOT NULL,
    receiver VARCHAR(50) NOT NULL,
    status ENUM('pending', 'accepted') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel 'friends' berhasil dibuat.<br>";
} else {
    echo "Error membuat tabel friends: " . mysqli_error($conn) . "<br>";
}

// Tambahkan index agar pencarian lebih cepat (opsional tapi disarankan)
$indexQuery = "ALTER TABLE friends ADD INDEX idx_user_rel (requester, receiver)";
mysqli_query($conn, $indexQuery); // Abaikan error jika index sudah ada

echo "Selesai setup database teman.";
?>