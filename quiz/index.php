<?php
// Letakkan di paling atas untuk logic session & koneksi
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Pilih Kuis - edu.io</title>

  <!-- Favicon, Styles, Fonts, Icons -->
  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
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
  <?php $path = "../";
  include '../includes/navbar.php'; ?>

  <!-- ================= MAIN CONTENT ================= -->
  <div class="container">
    <h1 class="page-title">Pilih Kuis</h1>
    <main>
      <p style="text-align: center; color: var(--text-secondary)">
        Uji pemahaman Anda dengan memilih salah satu kuis di bawah ini.
      </p>

      <!-- Pilihan Kuis -->
      <div class="materi-grid">
        <a href="kuis-html.php" class="materi-card">
          <div class="materi-card-header"><i class="fab fa-html5"></i>
            <h3>Kuis: Pengenalan HTML</h3>
          </div>
          <p>Seberapa baik pemahaman Anda tentang tag, elemen, dan struktur dasar HTML?</p>
          <span class="start-link">Mulai Kuis &rarr;</span>
        </a>
        <a href="kuis-css.php" class="materi-card">
          <div class="materi-card-header"><i class="fab fa-css3-alt"></i>
            <h3>Kuis: Dasar-dasar CSS</h3>
          </div>
          <p>Uji pengetahuan Anda tentang selektor, properti, dan cara membuat website lebih menarik.</p>
          <span class="start-link">Mulai Kuis &rarr;</span>
        </a>
        <a href="kuis-js.php" class="materi-card">
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

      <!-- ================= SERTIFIKAT SECTION ================= -->
      <?php
      // Cek kualifikasi sertifikat
      $checkCert = mysqli_query($conn, "SELECT COUNT(DISTINCT quiz_name) as total FROM scores 
                                        WHERE username = '$username' AND score = 100 
                                        AND quiz_name IN ('html-quiz', 'css-quiz', 'js-quiz')");
      $certData = mysqli_fetch_assoc($checkCert);

      if ($certData['total'] == 3):
      ?>
        <section class="certificate-section" style="text-align: center; margin-top: 50px; padding: 40px; background: var(--glass-bg); border-radius: 20px; border: 1px solid var(--glass-border);">
          <h2 style="color: var(--accent-teal); margin-bottom: 15px;"><i class="fas fa-award"></i> Selamat! Anda Berhak Mendapatkan Sertifikat</h2>
          <p style="color: var(--text-secondary); margin-bottom: 25px;">Anda telah menyelesaikan kuis HTML, CSS, dan JavaScript dengan nilai sempurna.</p>
          <a href="../pages/generate_certificate.php" target="_blank" class="btn-primary" style="display: inline-flex; align-items: center; gap: 10px; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-file-pdf"></i> Download Sertifikat (PDF)
          </a>
        </section>
      <?php endif; ?>

    </main>
  </div>

  <footer>
    <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>

  <?php include '../includes/chatbot.php'; ?>

  <script src="../assets/js/script.js"></script>
</body>

</html>