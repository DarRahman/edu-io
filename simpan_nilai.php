<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah user benar-benar sudah login di SESSION
    if (isset($_SESSION['loggedInUser'])) {
        $username = $_SESSION['loggedInUser'];
        $quiz_name = $_POST['quiz_id'];
        $score = $_POST['score'];

        $query = "INSERT INTO scores (username, quiz_name, score) 
                  VALUES ('$username', '$quiz_name', '$score') 
                  ON DUPLICATE KEY UPDATE score = '$score', created_at = CURRENT_TIMESTAMP";

        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "error_db";
        }
    } else {
        echo "not_logged_in";
    }
}
?>