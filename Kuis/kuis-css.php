<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Kuis: Dasar-dasar CSS - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png" />
    <link rel="stylesheet" href="../style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body>
    <?php $path = "../"; include '../includes/navbar.php'; ?>

    <div class="container quiz-container">
      <div class="quiz-header">
        <h1 class="page-title">Kuis CSS Dasar</h1>
        <p style="color: var(--text-secondary)">
          Uji pemahamanmu tentang styling web!
        </p>
      </div>

      <main>
        <form class="quiz-form" data-quiz-id="css-quiz">
          <!-- Sticky Progress Bar -->
          <div class="quiz-progress-container">
            <div
              style="
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
              "
            >
              <span class="quiz-progress-text"
                ><i class="fas fa-tasks"></i> 10 Soal</span
              >
              <span style="font-size: 0.9em; color: var(--text-secondary)"
                >Semangat! 🔥</span
              >
            </div>
            <div class="quiz-progress-bar">
              <div class="quiz-progress-fill" style="width: 0%"></div>
            </div>
          </div>

          <!-- Soal 1 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              1. Apa properti CSS untuk mengubah warna latar belakang elemen?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q1"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">color</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q1"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">background-color</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q1"
                  value="c"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">bgcolor</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 2 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              2. Selektor CSS manakah yang digunakan untuk memilih elemen dengan
              `id="header"`?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q2"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">#header</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q2"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">.header</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q2"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">header</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 3 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              3. Bagaimana cara Anda menyisipkan komentar di dalam file CSS?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q3"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">// ini komentar</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q3"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text"
                    >&lt;!-- ini komentar --&gt;</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q3"
                  value="c"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">/* ini komentar */</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 4 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">4. Apa kepanjangan dari CSS?</p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q4"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">Creative Style Sheets</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q4"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">Computer Style Sheets</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q4"
                  value="c"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">Cascading Style Sheets</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 5 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">5. Fungsi utama CSS adalah...</p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q5"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text"
                    >Mengatur struktur konten halaman</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q5"
                  value="b"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text"
                    >Menjalankan logika interaktif</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q5"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text"
                    >Mengatur tampilan dan gaya elemen pada halaman web</span
                  >
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 6 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              6. Jenis CSS yang ditulis langsung di dalam tag HTML disebut?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q6"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">Inline CSS</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q6"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">Internal CSS</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q6"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">External CSS</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 7 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              7. Jenis CSS yang disimpan di file terpisah dengan ekstensi .css
              disebut?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q7"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">Inline CSS</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q7"
                  value="b"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">External CSS</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q7"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">Local CSS</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 8 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              8. Property untuk mengatur ukuran teks adalah...
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q8"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">text-size</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q8"
                  value="b"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">font-size</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q8"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">size</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 9 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              9. Property untuk memberikan jarak luar antar elemen disebut?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q9"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">margin</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q9"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">padding</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q9"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">border</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 10 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              10. Keuntungan menggunakan CSS adalah...
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q10"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text"
                    >Membuat tampilan halaman lebih konsisten dan mudah
                    diatur</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q10"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text"
                    >Mengatur logika program di server</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q10"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text"
                    >Menambah kapasitas penyimpanan web</span
                  >
                </div>
              </label>
            </div>
          </div>

          <button type="submit" class="btn btn-submit-quiz">Lihat Hasil</button>
        </form>
      </main>
    </div>
    <footer>
      <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
    <script src="../script.js"></script>
  </body>
</html>
