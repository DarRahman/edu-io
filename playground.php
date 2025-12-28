<?php
session_start();
include 'koneksi.php';

// Cek Login (Sama seperti file lain)
if (!isset($_SESSION['loggedInUser'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Live Coding Playground - edu.io</title>

  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="stylesheet" href="style.css">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    (function () {
      const currentTheme = localStorage.getItem("theme");
      if (currentTheme === "dark") {
        document.documentElement.classList.add("dark-mode");
      }
    })();
  </script>

  <!-- CSS Khusus untuk menghilangkan margin container bawaan agar full screen -->
  <style>
    /* Override style body agar tidak ada scrollbar ganda */
    body {
      overflow: hidden;
      padding-top: 70px;
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <!-- ================= NAVBAR ================= -->
  <?php $path = ""; include 'includes/navbar.php'; ?>

  <!-- ================= EDITOR AREA ================= -->
  <!-- Tidak pakai class .container agar full width -->
  <div class="editor-container">

    <!-- Kolom Kiri: Input Kode -->
    <div class="editor-box">
      <div class="editor-label">
        <span><i class="fas fa-code"></i> HTML & CSS Editor</span>
        <button class="btn-run" onclick="runCode()">
          <i class="fas fa-play"></i> Run / Refresh
        </button>
      </div>
      <!-- Default Value: Contoh kode sederhana -->
      <textarea id="sourceCode" spellcheck="false" onkeyup="runCode()"><!DOCTYPE html>
<html>
<head>
<style>
  body { 
    font-family: sans-serif; 
    padding: 20px;
    background: #f0f0f0;
  }
  h1 { 
    color: #00A896; 
    text-align: center;
  }
  .kotak {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    text-align: center;
  }
  button {
    background: #192A56;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }
  button:hover { background: #00A896; }
</style>
</head>
<body>

<div class="kotak">
  <h1>Halo, edu.io!</h1>
  <p>Coba ubah teks atau warna di editor sebelah kiri.</p>
  <button onclick="alert('Tombol berfungsi!')">Klik Saya</button>
</div>

</body>
</html></textarea>
    </div>

    <!-- Kolom Kanan: Hasil -->
    <div class="preview-box">
      <div class="editor-label" style="background: #333;">
        <span><i class="fas fa-desktop"></i> Hasil Preview</span>
      </div>
      <iframe id="previewFrame"></iframe>
    </div>
  </div>

  <!-- ================= AI CHATBOT ================= -->
  <div id="ai-chat-launcher" onclick="toggleAIChat()">
    <i class="fas fa-robot"></i>
  </div>

  <div id="ai-chat-window">
    <div class="ai-chat-header">
      <span><i class="fas fa-magic"></i> edu.io AI Tutor</span>
      <button onclick="toggleAIChat()">&times;</button>
    </div>
    <div id="ai-chat-body">
      <div class="ai-message bot">
        Halo! Sedang eksperimen koding ya? Jika ada kode yang error, tanyakan saja padaku!
      </div>
    </div>
    <div class="ai-chat-footer">
      <input type="text" id="ai-input" placeholder="Tanyakan sesuatu..." autocomplete="off" />
      <button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button>
    </div>
  </div>

  <script src="script.js"></script>

  <!-- Script Khusus Live Editor -->
  <script>
    function runCode() {
      const code = document.getElementById("sourceCode").value;
      const frame = document.getElementById("previewFrame");
      const frameDoc = frame.contentDocument || frame.contentWindow.document;

      frameDoc.open();
      frameDoc.write(code);
      frameDoc.close();
    }

    // Jalankan sekali saat halaman dimuat
    document.addEventListener("DOMContentLoaded", () => {
      runCode();
    });
  </script>
</body>

</html>