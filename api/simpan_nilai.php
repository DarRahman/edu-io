<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['loggedInUser'])) {
        $username = $_SESSION['loggedInUser'];
        $quiz_name = $_POST['quiz_id'];
        $score = $_POST['score'];

        // 1. Simpan nilai ke database
        $query = "INSERT INTO scores (username, quiz_name, score) 
                  VALUES ('$username', '$quiz_name', '$score') 
                  ON DUPLICATE KEY UPDATE score = '$score', created_at = CURRENT_TIMESTAMP";

        if (mysqli_query($conn, $query)) {

            // 2. LOGIKA PEMBERIAN BADGE JIKA NILAI 100
            if ($score == 100) {
                $badge_type = '';
                $badge_name = '';
                $badge_icon = '';

                // Tentukan badge berdasarkan jenis kuis
                switch ($quiz_name) {
                    case 'html-quiz':
                        $badge_type = 'html_master';
                        $badge_name = 'HTML Master';
                        $badge_icon = 'badges/html-badge.png';
                        break;
                    case 'css-quiz':
                        $badge_type = 'css_wizard';
                        $badge_name = 'CSS Wizard';
                        $badge_icon = 'badges/css-badge.png';
                        break;
                    case 'js-quiz':
                        $badge_type = 'js_ninja';
                        $badge_name = 'JavaScript Ninja';
                        $badge_icon = 'badges/js-badge.png';
                        break;
                    default:
                        // Untuk kuis lain atau AI quiz
                        $badge_type = 'expert_' . $quiz_name;
                        $badge_name = 'Expert in ' . ucfirst(str_replace('-', ' ', $quiz_name));
                        $badge_icon = 'badges/general-badge.png';
                }

                // 3. Cek apakah user sudah punya badge ini
                $checkBadge = mysqli_query(
                    $conn,
                    "SELECT * FROM badges 
                     WHERE username = '$username' 
                     AND badge_type = '$badge_type'"
                );

                if (mysqli_num_rows($checkBadge) == 0) {
                    // Simpan badge ke database
                    $insertBadge = mysqli_query(
                        $conn,
                        "INSERT INTO badges (username, badge_type, badge_name, badge_icon) 
                         VALUES ('$username', '$badge_type', '$badge_name', '$badge_icon')"
                    );

                    if ($insertBadge) {
                        // Kirim pesan sukses dengan info badge
                        echo json_encode([
                            'status' => 'success',
                            'badge_earned' => true,
                            'badge_name' => $badge_name,
                            'badge_icon' => $badge_icon
                        ]);
                    } else {
                        echo json_encode(['status' => 'success', 'badge_earned' => false]);
                    }
                } else {
                    echo json_encode(['status' => 'success', 'badge_earned' => false, 'message' => 'Badge sudah dimiliki']);
                }
            } else {
                echo json_encode(['status' => 'success', 'badge_earned' => false]);
            }

        } else {
            echo json_encode(['status' => 'error_db']);
        }
    } else {
        echo json_encode(['status' => 'not_logged_in']);
    }
}
?>
