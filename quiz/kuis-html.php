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
            2. Apa fungsi dari tag &lt;!DOCTYPE html&gt;?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Mendefinisikan tipe dokumen sebagai HTML5</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Membuat judul halaman</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menampilkan paragraf teks</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 3 -->
        <div class="quiz-question-card">
          <p class="question-text">
            3. Tag &lt;head&gt; berfungsi untuk...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Menampilkan konten yang terlihat pengunjung</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Berisi meta-informasi tentang dokumen (seperti judul)</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Membuat hyperlink ke halaman lain</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 4 -->
        <div class="quiz-question-card">
          <p class="question-text">
            4. Tag mana yang digunakan untuk membuat hyperlink?
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
            5. Atribut apa yang digunakan untuk menentukan URL tujuan pada tag &lt;a&gt;?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">href</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">src</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">url</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 6 -->
        <div class="quiz-question-card">
          <p class="question-text">
            6. Atribut "alt" pada tag &lt;img&gt; berfungsi untuk?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Menentukan ukuran gambar</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Teks alternatif untuk gambar (aksesibilitas dan SEO)</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menentukan sumber gambar</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 7 -->
        <div class="quiz-question-card">
          <p class="question-text">7. Tag &lt;div&gt; digunakan untuk?</p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Mengelompokkan elemen untuk styling</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Membuat garis horizontal</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menampilkan video</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 8 -->
        <div class="quiz-question-card">
          <p class="question-text">8. Atribut "target" dengan nilai "_blank" pada tag &lt;a&gt; berfungsi untuk?</p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Membuka link di halaman yang sama</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Menyembunyikan link</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Membuka link di tab baru</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 9 -->
        <div class="quiz-question-card">
          <p class="question-text">
            9. Tag &lt;ul&gt; dan &lt;li&gt; digunakan untuk membuat...
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Daftar tidak berurutan (unordered list)</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Tabel data</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Formulir input</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 10 -->
        <div class="quiz-question-card">
          <p class="question-text">
            10. Atribut data-* (seperti data-info="online") digunakan untuk?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Menampilkan data secara langsung di halaman</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Menyimpan data kustom pada elemen HTML</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Menghubungkan ke database</span>
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