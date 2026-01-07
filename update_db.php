<?php
include 'config/koneksi.php';

// Add last_seen to users
mysqli_query($conn, "ALTER TABLE users ADD COLUMN IF NOT EXISTS last_seen DATETIME DEFAULT CURRENT_TIMESTAMP");

// Create notifications table
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    message TEXT,
    type VARCHAR(50),
    link VARCHAR(255),
    is_read TINYINT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

echo "Database updated successfully.";
?>
