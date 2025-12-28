<?php
header('Content-Type: application/json');
include 'config.php';

$modelName = "gemini-2.5-flash"; 
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $modelName . ":generateContent?key=" . $apiKey;

$input = json_decode(file_get_contents('php://input'), true);
$history = $input['history'] ?? [];
$userName = $input['name'] ?? 'Siswa';

if (empty($history)) {
    echo json_encode(['reply' => 'Pesan kosong.']);
    exit;
}

// Instruksi Sistem
$systemInstruction = "Nama user: $userName. Kamu adalah AI Tutor edu.io. Sapa user dengan namanya. Bantu belajar koding (HTML/CSS/JS/PHP). Jawab ramah & gunakan Markdown.";

// Struktur Contents untuk Gemini
$contents = [
    ["role" => "user", "parts" => [["text" => $systemInstruction]]],
    ["role" => "model", "parts" => [["text" => "Baik, saya siap membantu sebagai Tutor AI edu.io!"]]]
];

// Gabungkan riwayat
foreach ($history as $msg) {
    $contents[] = $msg;
}

$data = ["contents" => $contents];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($httpCode === 200) {
    $botReply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa memproses.';
    echo json_encode(['reply' => $botReply]);
} else {
    $errorMsg = $result['error']['message'] ?? 'Error ' . $httpCode;
    echo json_encode(['reply' => "AI Error: " . $errorMsg]);
}