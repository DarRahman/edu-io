<?php
header('Content-Type: application/json');
include '../config/config.php';

// --- KONFIGURASI ---
$modelName = "gemini-2.5-flash";
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $modelName . ":generateContent?key=" . $apiKey;

// Tangkap Input
$input = json_decode(file_get_contents('php://input'), true);
$topic = $input['topic'] ?? '';

if (empty($topic)) {
    echo json_encode(['status' => 'error', 'message' => 'Topik tidak boleh kosong.']);
    exit;
}

// --- PROMPT ENGINEERING (THE BRAIN) ---
$systemPrompt = "
Anda adalah Generator Kuis Edukasi untuk website 'edu.io'.
Tugas: Menerima topik dari user dan membuatkan 5 soal pilihan ganda.

INPUT USER: '$topic'

INSTRUKSI PENTING:
1. Validasi Topik: Apakah topik ini bersifat edukatif, akademis, atau pengetahuan umum yang layak?
   - JIKA TIDAK (Misal: SARA, kekerasan, curhat, tidak jelas, pornografi, hacking ilegal):
     Kembalikan JSON dengan status 'error' dan pesan penolakan yang sopan.
   
   - JIKA YA (Topik valid):
     Buatkan 5 soal pilihan ganda yang relevan.
     
2. FORMAT OUTPUT WAJIB JSON (Raw JSON, tanpa markdown ```json).
   Struktur JSON harus persis seperti ini:
   {
     \"status\": \"success\",
     \"topic\": \"Judul Topik\",
     \"questions\": [
       {
         \"q\": \"Pertanyaan nomor 1?\",
         \"options\": [\"Pilihan A\", \"Pilihan B\", \"Pilihan C\", \"Pilihan D\"],
         \"correct\": 0 
       }
     ]
   }
   (Catatan: 'correct' adalah index array jawaban benar: 0=A, 1=B, 2=C, 3=D)
";

$data = [
    "contents" => [
        ["parts" => [["text" => $systemPrompt]]]
    ]
];

// --- KIRIM KE GOOGLE ---
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// --- BERSIHKAN OUTPUT ---
if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
    
    // Hapus tanda markdown ```json jika AI bandel menambahkannya
    $cleanJson = str_replace(['```json', '```'], '', $rawText);
    
    echo $cleanJson;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghubungi otak AI.']);
}
?>
