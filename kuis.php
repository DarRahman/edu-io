<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kuis - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png" />

    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <!-- Tambahkan library ini agar AI tidak stuck loading -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body>
    <nav class="navbar">
      <a class="logo" href="index.html">
        <img src="logo.png" alt="Logo Edu.io" class="logo-img" />
      </a>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="materi.html">Materi</a></li>
        <li class="active"><a href="kuis.html">Kuis</a></li>
        <li><a href="video.html">Video</a></li>
        <li><a href="forum.php">Forum</a></li>
      </ul>
    </nav>

    <div class="container">
      <h1 class="page-title">Pilih Kuis</h1>
      <main>
        <p style="text-align: center; color: var(--text-secondary)">
          Uji pemahaman Anda dengan memilih salah satu kuis di bawah ini.
        </p>

        <div class="materi-grid">
          <a href="Kuis/kuis-html.html" class="materi-card">
            <div class="materi-card-header">
              <i class="fab fa-html5"></i>
              <h3>Kuis: Pengenalan HTML</h3>
            </div>
            <p>
              Seberapa baik pemahaman Anda tentang tag, elemen, dan struktur
              dasar HTML?
            </p>
            <span class="start-link">Mulai Kuis &rarr;</span>
          </a>

          <a href="Kuis/kuis-css.html" class="materi-card">
            <div class="materi-card-header">
              <i class="fab fa-css3-alt"></i>
              <h3>Kuis: Dasar-dasar CSS</h3>
            </div>
            <p>
              Uji pengetahuan Anda tentang selektor, properti, dan cara membuat
              website lebih menarik.
            </p>
            <span class="start-link">Mulai Kuis &rarr;</span>
          </a>

          <a href="Kuis/kuis-js.html" class="materi-card">
            <div class="materi-card-header">
              <i class="fab fa-js-square"></i>
              <h3>Kuis: JavaScript</h3>
            </div>
            <p>
              Tantang dan uji pengetahuan diri Anda dengan soal-soal mengenai
              JavaScript.
            </p>
            <span class="start-link">Mulai Kuis &rarr;</span>
          </a>
        </div>

        <!-- Section Riwayat Nilai Kuis -->
        <section id="history-section" style="margin-top:40px;">
          <h2 style="text-align:center; color:var(--title-color); margin-bottom:20px; font-size:1.5em;">Riwayat Nilai Kuis Anda</h2>
          <div id="history-container" class="history-container">
          <?php
          session_start();
          include 'koneksi.php';
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
                $class = "score-low";
                if ($score >= 80)
                  $class = "score-high";
                elseif ($score >= 60)
                  $class = "score-medium";
                echo "
            <div class='score-history-card'>
              <div class='score-history-header'>
                <i class='$icon'></i>
                <h3>$name</h3>
              </div>
              <div class='score-history-value $class'>$score<span>/100</span></div>
              <small style='color: var(--text-secondary)'>Diselesaikan pada: {$row['created_at']}</small>
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

    <div id="ai-chat-launcher" onclick="toggleAIChat()">
      <i class="fas fa-robot"></i>
    </div>

    <!-- Jendela Chat AI -->
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
        <input
          type="text"
          id="ai-input"
          placeholder="Tanyakan sesuatu..."
          autocomplete="off"
        />
        <button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
