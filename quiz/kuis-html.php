<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF8" />
  <title>Kuis Pengetahuan - Edukasi Interaktif</title>
  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php $path = "../";
  include '../includes/navbar.php'; ?>

  <div class="container">
    <!-- Header Baru -->
    <div class="quiz-header">
      <h1 class="page-title">Kuis HTML Dasar</h1>
      <p style="color: var(--text-secondary)">
        Uji pemahamanmu tentang struktur dasar web!
      </p>
    </div>

    <main>
      <form class="quiz-form" data-quiz-id="html-quiz">
        <!-- Sticky Progress Bar -->
        <div class="quiz-progress-container">
          <div style="
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
              ">
            <span class="quiz-progress-text"><i class="fas fa-tasks"></i> 10 Soal</span>
            <span style="font-size: 0.9em; color: var(--text-secondary)">Semangat! 🔥</span>
          </div>
          <div class="quiz-progress-bar">
            <div class="quiz-progress-fill" style="width: 0%"></div>
          </div>
        </div>

        <!-- Soal 1 -->
        <div class="quiz-question-card">
          <p class="question-text">1. Apa kepanjangan dari HTML?</p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">HyperText Markup Language</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">HighText Machine Language</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Hyperlink and Text Markup Language</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 2 -->
        <div class="quiz-question-card">
          <p class="question-text">
            2. Tag HTML manakah yang digunakan untuk membuat paragraf?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;h1&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;p&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;br&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 3 -->
        <div class="quiz-question-card">
          <p class="question-text">
            3. Tag yang berfungsi sebagai judul utama dalam HTML adalah...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;h1&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;title&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;head&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 4 -->
        <div class="quiz-question-card">
          <p class="question-text">
            4. Tag HTML manakah yang digunakan untuk membuat link?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;link&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;a&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;href&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 5 -->
        <div class="quiz-question-card">
          <p class="question-text">
            5. Elemen yang digunakan untuk menampung seluruh konten halaman
            web adalah...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;body&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;head&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;footer&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 6 -->
        <div class="quiz-question-card">
          <p class="question-text">
            6. File HTML biasanya disimpan dengan ekstensi?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">.doc</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">.html</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">.txt</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 7 -->
        <div class="quiz-question-card">
          <p class="question-text">7. Atribut href digunakan untuk?</p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Menentukan warna teks</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Menampilkan teks bergaya miring</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menentukan lokasi file tujuan hyperlink</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 8 -->
        <div class="quiz-question-card">
          <p class="question-text">8. Fungsi utama HTML adalah...</p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Mengatur logika program</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Menyimpan data pengguna</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menentukan struktur dan isi halaman web</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 9 -->
        <div class="quiz-question-card">
          <p class="question-text">
            9. Tag yang digunakan untuk menampilkan gambar pada halaman web
            adalah...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;img&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;picture&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;image&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 10 -->
        <div class="quiz-question-card">
          <p class="question-text">
            10. Tag yang berfungsi untuk membuat baris baru adalah...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&lt;b&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">&lt;hr&gt;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">&lt;br&gt;</span>
              </div>
            </label>
          </div>
        </div>

        <button type="submit" class="btn quiz-submit-btn">
          Kirim Jawaban <i class="fas fa-paper-plane"></i>
        </button>
      </form>
    </main>
  </div>

  <footer>
    <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>

  <!-- Script ini penting untuk memeriksa login, logout, dan memproses kuis -->
  <script src="../assets/js/script.js"></script>
</body>

</html>