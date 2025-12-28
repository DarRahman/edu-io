<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Kuis: JavaScript - edu.io</title>
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
        <h1 class="page-title">Kuis JavaScript</h1>
        <p style="color: var(--text-secondary)">
          Uji pemahamanmu tentang logika web!
        </p>
      </div>

      <main>
        <form class="quiz-form" data-quiz-id="js-quiz">
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
              1. Fungsi utama JavaScript adalah...
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
                  <span class="quiz-option-text"
                    >Mengatur tampilan halaman</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q1"
                  value="b"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text"
                    >Menambahkan interaktivitas pada halaman web</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q1"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">Membuat struktur halaman</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 2 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              2. File eksternal JavaScript memiliki ekstensi?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q2"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">.css</span>
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
                  <span class="quiz-option-text">.html</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q2"
                  value="c"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">.js</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 3 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              3. Tag HTML yang digunakan untuk menulis kode JavaScript adalah...
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q3"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">&lt;script&gt;</span>
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
                  <span class="quiz-option-text">&lt;js&gt;</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q3"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">&lt;style&gt;</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 4 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              4. Fungsi alert() dalam JavaScript digunakan untuk?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q4"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text"
                    >Menampilkan pesan pada jendela pop-up</span
                  >
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
                  <span class="quiz-option-text">Mengubah warna halaman</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q4"
                  value="c"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text">Menghapus elemen HTML</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 5 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              5. Variabel dalam JavaScript dapat dideklarasikan dengan kata
              kunci?
            </p>
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
                  <span class="quiz-option-text">int, string, bool</span>
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
                  <span class="quiz-option-text">var, let, const</span>
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
                  <span class="quiz-option-text">def, val, set</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 6 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              6. Operator + dalam JavaScript dapat digunakan untuk?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q6"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">Membandingkan dua nilai</span>
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
                  <span class="quiz-option-text">Membagi dua angka</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q6"
                  value="c"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">C</span>
                  <span class="quiz-option-text"
                    >Menambah nilai angka atau menggabungkan string</span
                  >
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 7 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              7. Pernyataan kondisi dalam JavaScript ditulis dengan kata kunci?
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
                  <span class="quiz-option-text">for</span>
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
                  <span class="quiz-option-text">if</span>
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
                  <span class="quiz-option-text">while</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 8 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              8. JavaScript dapat mengubah isi elemen HTML dengan menggunakan?
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q8"
                  value="a"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text"
                    >document.getElementById()</span
                  >
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q8"
                  value="b"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">style.color</span>
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
                  <span class="quiz-option-text">addEventListener()</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 9 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              9. Kegunaan utama JavaScript pada website adalah...
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
                  <span class="quiz-option-text"
                    >Membuat halaman lebih interaktif dan responsif</span
                  >
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
                  <span class="quiz-option-text"
                    >Mengatur gaya tampilan halaman</span
                  >
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
                  <span class="quiz-option-text"
                    >Menentukan struktur dasar halaman</span
                  >
                </div>
              </label>
            </div>
          </div>

          <!-- Soal 10 -->
          <div class="quiz-question-card">
            <p class="quiz-question-text">
              10. JavaScript dijalankan pada sisi...
            </p>
            <div class="quiz-options-grid">
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q10"
                  value="a"
                  class="quiz-option-input"
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">A</span>
                  <span class="quiz-option-text">Server</span>
                </div>
              </label>
              <label class="quiz-option-label">
                <input
                  type="radio"
                  name="q10"
                  value="b"
                  class="quiz-option-input"
                  required
                />
                <div class="quiz-option-content">
                  <span class="quiz-option-marker">B</span>
                  <span class="quiz-option-text">Klien(browser)</span>
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
                  <span class="quiz-option-text">Database</span>
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
