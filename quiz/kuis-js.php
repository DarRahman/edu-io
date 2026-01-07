<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Kuis: JavaScript - edu.io</title>
  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php $path = "../";
  include '../includes/navbar.php'; ?>

  <div class="container quiz-container">
    <div class="quiz-header">
      <h1 class="page-title">Kuis JavaScript</h1>
      <p style="color: var(--text-secondary)">
        Uji pemahamanmu tentang logika web!
      </p>
    </div>

    <main>
      <form class="quiz-form" data-quiz-id="js-quiz">
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
          <p class="quiz-question-text">
            1. Siapa yang menciptakan JavaScript dan pada tahun berapa?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Brendan Eich, 1995</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Tim Berners-Lee, 1990</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q1" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">James Gosling, 2000</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 2 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            2. Apa tipe data untuk menyimpan teks dalam JavaScript?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Number</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">String</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q2" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Boolean</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 3 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            3. Kata kunci mana yang digunakan untuk mendeklarasi variabel yang nilainya TIDAK bisa diubah?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">var</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">let</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q3" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">const</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 4 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            4. Apa hasil dari perbandingan 5 === "5" dalam JavaScript?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">false (karena tipe data berbeda)</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">true</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q4" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Error</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 5 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            5. Tipe data apa yang digunakan untuk menyimpan kumpulan nilai dalam tanda []?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Object</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Array</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q5" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">String</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 6 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            6. Operator logika yang berarti "DAN" dalam JavaScript adalah?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">&amp;&amp;</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">||</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q6" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">!</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 7 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            7. Pernyataan kondisi dalam JavaScript menggunakan kata kunci?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">if-else</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">for-each</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q7" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">do-while</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 8 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            8. Loop yang digunakan untuk mengulang kode dengan jumlah iterasi tertentu adalah?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">while</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="b" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">for</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q8" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">switch</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 9 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            9. Apa perbedaan antara null dan undefined dalam JavaScript?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="a" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">null: nilai kosong yang disengaja, undefined: variabel belum diisi</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Keduanya sama persis</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q9" value="c" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">null: tipe number, undefined: tipe string</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Soal 10 -->
        <div class="quiz-question-card">
          <p class="quiz-question-text">
            10. Apa fungsi utama JavaScript pada website menurut materi?
          </p>
          <div class="quiz-options-grid">
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="a" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">A</span>
                <span class="quiz-option-text">Mengatur warna dan tampilan halaman</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="b" class="quiz-option-input" />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">B</span>
                <span class="quiz-option-text">Membuat struktur konten halaman</span>
              </div>
            </label>
            <label class="quiz-option-label">
              <input type="radio" name="q10" value="c" class="quiz-option-input" required />
              <div class="quiz-option-content">
                <span class="quiz-option-marker">C</span>
                <span class="quiz-option-text">Membuat konten dinamis dan interaktif</span>
              </div>
            </label>
          </div>
        </div>

        <button type="submit" class="btn btn-submit-quiz">Lihat Hasil</button>
      </form>
    </main>
  </div>
  <footer>
    <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>
  <script src="../assets/js/script.js"></script>
</body>

</html>