<?php
// Letakkan di paling atas untuk logic session & koneksi
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pilih Kuis - edu.io</title>

  <!-- Favicon, Styles, Fonts, Icons -->
  <link rel="icon" type="image/png" href="favicon.png" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Pre-load Dark Mode -->
  <script>
    (function () {
      if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark-mode");
      }
    })();
  </script>
</head>

<body>
  <!-- ================= NAVBAR ================= -->
  <nav class="navbar">
    <a class="logo" href="index.html">
      <img src="logo.png" alt="Logo Edu.io" class="logo-img" />
    </a>
    <ul class="nav-links">
      <li><a href="index.html">Home</a></li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Belajar <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="materi.html"><i class="fas fa-book"></i> Materi Teks</a>
          <a href="video.html"><i class="fas fa-play-circle"></i> Video Tutorial</a>
          <a href="playground.php"><i class="fas fa-code"></i> Live Coding</a>
        </div>
      </li>
      <li class="dropdown active">
        <a href="#" class="dropbtn">Kuis <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="kuis.php"><i class="fas fa-clipboard-check"></i> Pilih Kuis</a>
          <a href="ai_quiz.php"><i class="fas fa-robot"></i> AI Quiz Generator</a>
          <a href="leaderboard.php"><i class="fas fa-trophy"></i> Leaderboard</a>
        </div>
      </li>
      <li><a href="forum.php">Forum</a></li>
    </ul>
  </nav>

  <!-- ================= MAIN CONTENT ================= -->
  <div class="container">
    <h1 class="page-title">Pilih Kuis</h1>
    <main>
      <p style="text-align: center; color: var(--text-secondary)">
        Uji pemahaman Anda dengan memilih salah satu kuis di bawah ini.
      </p>

      <!-- Pilihan Kuis -->
      <div class="materi-grid">
        <a href="Kuis/kuis-html.html" class="materi-card">
          <div class="materi-card-header"><i class="fab fa-html5"></i>
            <h3>Kuis: Pengenalan HTML</h3>
          </div>
          <p>Seberapa baik pemahaman Anda tentang tag, elemen, dan struktur dasar HTML?</p>
          <span class="start-link">Mulai Kuis &rarr;</span>
        </a>
        <a href="Kuis/kuis-css.html" class="materi-card">
          <div class="materi-card-header"><i class="fab fa-css3-alt"></i>
            <h3>Kuis: Dasar-dasar CSS</h3>
          </div>
          <p>Uji pengetahuan Anda tentang selektor, properti, dan cara membuat website lebih menarik.</p>
          <span class="start-link">Mulai Kuis &rarr;</span>
        </a>
        <a href="Kuis/kuis-js.html" class="materi-card">
          <div class="materi-card-header"><i class="fab fa-js-square"></i>
            <h3>Kuis: JavaScript</h3>
          </div>
          <p>Tantang dan uji pengetahuan diri Anda dengan soal-soal mengenai JavaScript.</p>
          <span class="start-link">Mulai Kuis &rarr;</span>
        </a>
      </div>

      <!-- Section Riwayat Nilai Kuis (Gabungan dari nilai.php) -->
      <section id="history-section">
        <h2>Riwayat Nilai Kuis Anda</h2>
        <div class="history-container">
          <?php
          if (!isset($_SESSION['loggedInUser'])) {
            echo "<div class='no-score-message'><h2>Silakan Login untuk melihat nilai.</h2></div>";
          } else {
            $username = $_SESSION['loggedInUser'];
            $query = mysqli_query($conn, "SELECT * FROM scores WHERE username = '$username' ORDER BY created_at DESC");

            if (mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                $quiz_id = $row['quiz_name'];
                $score = $row['score'];
                $icon = "fas fa-question-circle";
                $name = "Kuis Tidak Dikenal";
                if ($quiz_id == "html-quiz") {
                  $icon = "fab fa-html5";
                  $name = "Kuis: HTML";
                }
                if ($quiz_id == "css-quiz") {
                  $icon = "fab fa-css3-alt";
                  $name = "Kuis: CSS";
                }
                if ($quiz_id == "js-quiz") {
                  $icon = "fab fa-js-square";
                  $name = "Kuis: JavaScript";
                }

                $class = ($score >= 80) ? "score-high" : (($score >= 60) ? "score-medium" : "score-low");

                echo "
                        <div class='score-history-card'>
                          <div class='score-history-header'><i class='$icon'></i><h3>$name</h3></div>
                          <div class='score-history-value $class'>$score<span>/100</span></div>
                          <small style='color: var(--text-secondary)'>Diselesaikan pada: " . date('d M Y, H:i', strtotime($row['created_at'])) . "</small>
                        </div>";
              }
            } else {
              echo "<div class='no-score-message'><i class='fas fa-box-open'></i><h2>Belum ada nilai.</h2></div>";
            }
          }
          ?>
        </div>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>

  <!-- ================= AI CHATBOT UI ================= -->
  <div id="ai-chat-launcher" onclick="toggleAIChat()">
    <i class="fas fa-robot"></i>
  </div>
  <div id="ai-chat-window">
    <div class="ai-chat-header"><span><i class="fas fa-magic"></i> edu.io AI Tutor</span><button
        onclick="toggleAIChat()">&times;</button></div>
    <div id="ai-chat-body">
      <div class="ai-message bot">Halo! Saya Tutor AI edu.io. Ada yang bisa saya bantu?</div>
    </div>
    <div class="ai-chat-footer"><input type="text" id="ai-input" placeholder="Tanyakan sesuatu..."
        autocomplete="off" /><button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button></div>
  </div>

  <script src="script.js"></script>
</body>

</html>