<?php
session_start();
include '../config/koneksi.php';
include '../config/config.php';

// Load Composer Autoloader
require '../vendor/autoload.php';

if (!isset($_SESSION['loggedInUser'])) {
    die("Silakan login terlebih dahulu.");
}

$username = $_SESSION['loggedInUser'];

// 1. Cek apakah user punya nilai 100 di 3 kuis utama
$query = "SELECT quiz_name FROM scores 
          WHERE username = '$username' 
          AND score = 100 
          AND quiz_name IN ('html-quiz', 'css-quiz', 'js-quiz')";
$result = mysqli_query($conn, $query);

$completedQuizzes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $completedQuizzes[] = $row['quiz_name'];
}

// Pastikan ketiga kuis ada dan nilainya 100
if (count(array_unique($completedQuizzes)) < 3) {
    die("Anda harus mendapatkan nilai 100 di semua kuis (HTML, CSS, JS) untuk mendapatkan sertifikat.");
}

// 2. Ambil Nama Lengkap User
$userQuery = mysqli_query($conn, "SELECT full_name FROM users WHERE username = '$username'");
$userData = mysqli_fetch_assoc($userQuery);
$displayName = !empty($userData['full_name']) ? $userData['full_name'] : $username;

// 3. Generate PDF
// 'L' = Landscape, 'mm' = milimeter, 'A4' = Ukuran kertas
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Path ke template sertifikat
$templatePath = '../img/certificate.jpeg';

if (!file_exists($templatePath)) {
    die("File template sertifikat tidak ditemukan di img/certificate.jpeg");
}

// Set background dari desain Canva (A4 Landscape: 297x210 mm)
$pdf->Image($templatePath, 0, 0, 297, 210); 

// --- PENGATURAN TEKS NAMA ---
// Gunakan font Arial Bold (Bawaan FPDF)
$pdf->SetFont('Arial', 'B', 50);
$pdf->SetTextColor(26, 35, 126); // Warna biru gelap (Indigo) - Sesuaikan dengan desain

// Atur posisi teks nama
// Berdasarkan gambar yang Anda kirim, nama harus di bawah "is presented to :"
// Kita coba di koordinat Y = 105 (tengah-tengah vertikal)
$pdf->SetXY(0, 100); 
$pdf->Cell(297, 20, strtoupper($displayName), 0, 1, 'C');

// Output PDF ke browser (I = Inline)
$pdf->Output('I', 'Sertifikat_' . $username . '.pdf');
