<?php
session_start();
include '../config/config.php';
include '../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['error' => 'Silakan login terlebih dahulu.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$topic = $data['topic'] ?? '';

if (empty($topic)) {
    echo json_encode(['error' => 'Topik tidak boleh kosong.']);
    exit;
}

// Gunakan API Key dari config.php
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

$prompt = "Tugas: Anda adalah filter konten ketat untuk edu.io. Periksa topik: '$topic'.

ATURAN VALIDASI SANGAT KETAT:
1. Jika topik mengandung kata sensitif terkait pornografi, konten dewasa, judi, narkoba, SARA, kekerasan, atau hal ilegal (sekecil apapun hubungannya):
   ANDA WAJIB menolak. Jangan mencoba menjadikannya materi edukasi atau analisis teknologi.
   KEMBALIKAN JSON INI: {\"status\": \"error\", \"message\": \"Akses ditolak. Topik tersebut mengandung konten sensitif atau tidak pantas untuk platform pendidikan.\"}

2. Jika topik TIDAK berhubungan sama sekali dengan Web Development, Desain, atau Teknologi (misal: 'cara memasak nasi'):
   KEMBALIKAN JSON INI: {\"status\": \"error\", \"message\": \"Maaf, saya hanya bisa membuat materi seputar Web Development dan Teknologi.\"}

3. JIKA VALID (Topik tentang Web Dev/Teknologi yang aman):
Buat materi dalam format JSON:
{
  \"status\": \"success\",
  \"title\": \"Judul Materi\",
  \"sections\": [
    {
      \"header_icon\": \"fa-solid fa-code\", 
      \"header_text\": \"Judul Section\",
      \"items\": [
        {
          \"icon\": \"fa-solid fa-lightbulb\",
          \"title\": \"Judul Sub-item\",
          \"content\": \"Penjelasan mendalam...\",
          \"color\": \"purple\"
        }
      ]
    }
  ]
}

Jangan memberikan teks penjelasan apapun di luar JSON (Raw JSON only).";

$payload = [
    "contents" => [["parts" => [["text" => $prompt]]]]
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$rawContent = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

// Membersihkan markdown if necessary
$cleanJson = trim(str_replace(['```json', '```'], '', $rawContent));

// Validasi apakah benar JSON
$jsonCheck = json_decode($cleanJson, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'AI memberikan format yang salah. Silakan coba lagi.']);
    exit;
}

echo $cleanJson;
