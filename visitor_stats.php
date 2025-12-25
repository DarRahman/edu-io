<?php
include 'koneksi.php';
session_start();

// --- 1. SETUP DATABASE OTOMATIS (Auto-Migration) ---
// Cek/Buat tabel untuk User Online
$checkTableOnline = mysqli_query($conn, "SHOW TABLES LIKE 'online_users'");
if (mysqli_num_rows($checkTableOnline) == 0) {
    mysqli_query($conn, "CREATE TABLE online_users (session_id VARCHAR(255) PRIMARY KEY, last_activity INT)");
}

// Cek/Buat tabel untuk Total Statistik
$checkTableStats = mysqli_query($conn, "SHOW TABLES LIKE 'site_stats'");
if (mysqli_num_rows($checkTableStats) == 0) {
    mysqli_query($conn, "CREATE TABLE site_stats (id INT PRIMARY KEY, total_visits INT)");
    mysqli_query($conn, "INSERT INTO site_stats VALUES (1, 0)");
}

// --- 2. LOGIKA USER ONLINE ---
$sid = session_id();
$time = time();
$timeout = 300; // User dianggap offline jika tidak aktif selama 300 detik (5 menit)

// Masukkan atau Update waktu aktivitas user saat ini
mysqli_query($conn, "REPLACE INTO online_users (session_id, last_activity) VALUES ('$sid', '$time')");

// Hapus user yang sudah tidak aktif (timeout)
$cutoff_time = $time - $timeout;
mysqli_query($conn, "DELETE FROM online_users WHERE last_activity < $cutoff_time");

// Hitung jumlah user online
$online_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM online_users");
$online_row = mysqli_fetch_assoc($online_query);
$online_count = $online_row['count'];

// --- 3. LOGIKA TOTAL PENGUNJUNG ---
// Cek cookie agar tidak menghitung refresh halaman sebagai kunjungan baru
if (!isset($_COOKIE['visited_eduio'])) {
    // Tambah counter di database
    mysqli_query($conn, "UPDATE site_stats SET total_visits = total_visits + 1 WHERE id = 1");
    
    // Set cookie selama 24 jam
    setcookie('visited_eduio', 'yes', time() + (86400 * 1), "/"); 
}

// Ambil total pengunjung
$total_query = mysqli_query($conn, "SELECT total_visits FROM site_stats WHERE id = 1");
$total_row = mysqli_fetch_assoc($total_query);
$total_visits = $total_row['total_visits'];

// --- 4. OUTPUT JSON ---
header('Content-Type: application/json');
echo json_encode([
    'online' => $online_count,
    'total' => $total_visits
]);
?>
