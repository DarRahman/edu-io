<?php
if (!isset($path)) {
    $path = "";
}

// Include database connection
include $path . 'config/koneksi.php';

// Auto-create tables if not exist
$checkTableOnline = mysqli_query($conn, "SHOW TABLES LIKE 'online_users'");
if (mysqli_num_rows($checkTableOnline) == 0) {
    mysqli_query($conn, "CREATE TABLE online_users (session_id VARCHAR(255) PRIMARY KEY, last_activity INT)");
}
$checkTableStats = mysqli_query($conn, "SHOW TABLES LIKE 'site_stats'");
if (mysqli_num_rows($checkTableStats) == 0) {
    mysqli_query($conn, "CREATE TABLE site_stats (id INT PRIMARY KEY, total_visits INT)");
    mysqli_query($conn, "INSERT INTO site_stats VALUES (1, 0)");
}

// Track online users
$sid = session_id();
$time = time();
$timeout = 300;
mysqli_query($conn, "REPLACE INTO online_users (session_id, last_activity) VALUES ('$sid', '$time')");
$cutoff_time = $time - $timeout;
mysqli_query($conn, "DELETE FROM online_users WHERE last_activity < $cutoff_time");
$online_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM online_users");
$online_row = mysqli_fetch_assoc($online_query);
$online_count = $online_row['count'];

// Track total visits
if (!isset($_COOKIE['visited_eduio'])) {
    mysqli_query($conn, "UPDATE site_stats SET total_visits = total_visits + 1 WHERE id = 1");
    setcookie('visited_eduio', 'yes', time() + (86400 * 1), "/");
}
$total_query = mysqli_query($conn, "SELECT total_visits FROM site_stats WHERE id = 1");
$total_row = mysqli_fetch_assoc($total_query);
$total_visits = $total_row['total_visits'];

// Store in session to avoid re-querying
$_SESSION['online_count'] = $online_count;
$_SESSION['total_visits'] = $total_visits;

// Return JSON for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['online' => $online_count, 'total' => $total_visits]);
    exit;
}
?>

<div class="visitor-stats-footer">
    <div class="visitor-stats">
        <div class="stat-item">
            <i class="fas fa-circle"></i>
            <span>Online:
                <?php echo $_SESSION['online_count'] ?? 0; ?>
            </span>
        </div>
        <div class="stat-item">
            <i class="fas fa-eye"></i>
            <span>Visits:
                <?php echo $_SESSION['total_visits'] ?? 0; ?>
            </span>
        </div>
    </div>
</div>

<script>
    // Function to fetch and update visitor stats
    function updateVisitorStats() {
        fetch('includes/visitor_stats.php')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.stat-item:first-child span').textContent = 'Online: ' + (data.online || 0);
                document.querySelector('.stat-item:last-child span').textContent = 'Visits: ' + (data.total || 0);
            })
            .catch(error => {
                console.error('Error fetching visitor stats:', error);
            });
    }

    // Update stats on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateVisitorStats();
        // Update every 30 seconds
        setInterval(updateVisitorStats, 30000);
    });
</script>