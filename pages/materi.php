<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Daftar Materi - Edukasi Interaktif</title>

  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Libraries (Marked & SweetAlert) -->
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Dark Mode Pre-load -->
  <script>
    (function () {
      const currentTheme = localStorage.getItem("theme");
      if (currentTheme === "dark") {
        document.documentElement.classList.add("dark-mode");
      }
    })();
  </script>
</head>

<body>
  <!-- ================= NAVBAR ================= -->
  <?php $path = "../";
  include '../includes/navbar.php'; ?>

  <!-- ================= MAIN CONTENT ================= -->
  <div class="container">
    <h1 class="page-title">Daftar Materi</h1>
    <main>
      <p style="text-align: center">
        Silakan pilih salah satu materi di bawah ini untuk mulai belajar.
      </p>

      <div class="materi-grid">
        <!-- Modul HTML -->
        <a href="../Materi/materi-html.php" class="materi-card">
          <div class="materi-card-header">
            <i class="fab fa-html5"></i>
            <h3>Pengenalan HTML</h3>
          </div>
          <p>
            Pelajari dasar-dasar HyperText Markup Language, kerangka dari
            semua website.
          </p>
          <span class="start-link">Mulai Belajar &rarr;</span>
        </a>

        <!-- Modul CSS -->
        <a href="../Materi/materi-css.php" class="materi-card">
          <div class="materi-card-header">
            <i class="fab fa-css3-alt"></i>
            <h3>Dasar-dasar CSS</h3>
          </div>
          <p>
            Buat website Anda menjadi lebih menarik secara visual dengan
            Cascading Style Sheets.
          </p>
          <span class="start-link">Mulai Belajar &rarr;</span>
        </a>

        <!-- Modul JS -->
        <a href="../Materi/materi-js.php" class="materi-card">
          <div class="materi-card-header">
            <i class="fab fa-js-square"></i>
            <h3>Javascript</h3>
          </div>
          <p>
            Pahami alur kerja JavaScript untuk menciptakan pengalaman pengguna
            yang responsif.
          </p>
          <span class="start-link">Mulai Belajar &rarr;</span>
        </a>
      </div>
    </main>
  </div>

  <footer>
    <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>

  <!-- ================= AI CHATBOT UI ================= -->
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
        Halo! Saya Tutor AI edu.io. Ada yang bisa saya bantu terkait koding
        atau materi hari ini?
      </div>
    </div>
    <div class="ai-chat-footer">
      <input type="text" id="ai-input" placeholder="Tanyakan sesuatu..." autocomplete="off" />
      <button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button>
    </div>
  </div>

  <script src="../assets/js/script.js"></script>
</body>

</html>