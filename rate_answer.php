<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    echo "not_logged_in";
    exit;
}

if (isset($_POST['answer_id']) && isset($_POST['rating'])) {
    $aid = $_POST['answer_id'];
    $rate = $_POST['rating'];
    $username = $_SESSION['loggedInUser'];
    
    $query = "INSERT INTO forum_ratings (answer_id, username, rating_value) 
              VALUES ($aid, '$username', $rate) 
              ON DUPLICATE KEY UPDATE rating_value = $rate";
              
    if (mysqli_query($conn, $query)) {
        echo "success";
    }
}
?>