<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_eduio";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>