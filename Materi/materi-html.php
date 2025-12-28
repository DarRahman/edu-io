<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Materi: Pengenalan HTML - edu.io</title>
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
    <style>
      /* Tambahan style untuk kode agar terlihat di mode terang */
      .code-wrapper pre code {
        color: #e0e0e0 !important;
        font-family: "Consolas", "Monaco", "Courier New", monospace;
        font-size: 0.95em;
        line-height: 1.5;
        display: block;
      }

      /* Warna khusus untuk mode terang */
      body:not(.dark-mode) .code-wrapper pre code {
        color: #f8f8f2 !important;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
      }

      /* Warna untuk tag HTML dalam kode */
      .code-wrapper pre code .tag {
        color: #ff79c6 !important;
      }

      .code-wrapper pre code .attr-name {
        color: #50fa7b !important;
      }

      .code-wrapper pre code .attr-value {
        color: #f1fa8c !important;
      }

      .code-wrapper pre code .comment {
        color: #6272a4 !important;
      }
    </style>
  </head>

  <body>
    <?php $path = "../"; include '../includes/navbar.php'; ?>

    <div class="materi-wrapper">
      <!-- Hero Section -->
      <header
        class="materi-hero"
        style="background: linear-gradient(135deg, #e44d26, #f16529)"
      >
        <h1><i class="fab fa-html5"></i> Pengenalan HTML</h1>
        <p>
          Pelajari dasar-dasar HyperText Markup Language untuk membangun
          struktur website.
        </p>
      </header>

      <!-- Section 1: Pengertian -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-info-circle"></i> Apa itu HTML?
        </h2>
        <p class="materi-text">
          <strong>HTML (HyperText Markup Language)</strong> adalah bahasa
          standar yang digunakan untuk membuat halaman web. HTML bukanlah bahasa
          pemrograman, melainkan bahasa markup yang mendefinisikan struktur
          konten Anda.
        </p>

        <div class="info-box">
          <i class="fas fa-lightbulb"></i>
          <div class="info-box-content">
            <h4>Analogi Sederhana</h4>
            <p>
              Jika website adalah sebuah rumah, maka HTML adalah batu bata dan
              semen yang membentuk dinding dan strukturnya.
            </p>
          </div>
        </div>

        <p class="materi-text">
          HTML terdiri dari serangkaian elemen yang digunakan untuk membungkus
          bagian-bagian konten agar tampil atau bertindak dengan cara tertentu.
        </p>
      </section>

      <!-- Section 2: Struktur Dasar -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-code"></i> Struktur Dasar HTML
        </h2>
        <p class="materi-text">
          Setiap dokumen HTML memiliki struktur dasar yang harus diikuti agar
          dapat dibaca dengan benar oleh web browser.
        </p>

        <div class="code-wrapper">
          <div class="code-header">
            <span>index.html</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
    &lt;head&gt;
        &lt;title&gt;Judul Halaman&lt;/title&gt;
    &lt;/head&gt;
    &lt;body&gt;
        &lt;h1&gt;Halo Dunia!&lt;/h1&gt;
        &lt;p&gt;Ini adalah paragraf pertama saya.&lt;/p&gt;
    &lt;/body&gt;
&lt;/html&gt;</code></pre>
        </div>

        <ul class="materi-list">
          <li>
            <strong>&lt;!DOCTYPE html&gt;</strong>: Mendefinisikan tipe dokumen
            sebagai HTML5.
          </li>
          <li><strong>&lt;html&gt;</strong>: Elemen akar dari halaman HTML.</li>
          <li>
            <strong>&lt;head&gt;</strong>: Berisi meta-informasi tentang dokumen
            (seperti judul).
          </li>
          <li>
            <strong>&lt;body&gt;</strong>: Berisi konten yang terlihat oleh
            pengunjung (teks, gambar, dll).
          </li>
        </ul>
      </section>

      <!-- Section 3: Elemen Penting -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-layer-group"></i> Elemen Penting HTML
        </h2>

        <div class="info-box" style="border-left-color: var(--accent-purple)">
          <i class="fas fa-heading" style="color: var(--accent-purple)"></i>
          <div class="info-box-content">
            <h4 style="color: var(--accent-purple)">Heading (Judul)</h4>
            <p>
              HTML menyediakan 6 level heading, dari
              <code>&lt;h1&gt;</code> (paling besar) hingga
              <code>&lt;h6&gt;</code> (paling kecil).
            </p>
          </div>
        </div>

        <div class="info-box" style="border-left-color: var(--accent-teal)">
          <i class="fas fa-paragraph" style="color: var(--accent-teal)"></i>
          <div class="info-box-content">
            <h4 style="color: var(--accent-teal)">Paragraf</h4>
            <p>
              Tag <code>&lt;p&gt;</code> digunakan untuk mendefinisikan blok
              teks atau paragraf.
            </p>
          </div>
        </div>

        <div class="info-box" style="border-left-color: var(--accent-yellow)">
          <i class="fas fa-link" style="color: var(--accent-yellow)"></i>
          <div class="info-box-content">
            <h4 style="color: var(--accent-yellow)">Link (Tautan)</h4>
            <p>
              Tag <code>&lt;a&gt;</code> dengan atribut
              <code>href</code> digunakan untuk membuat hyperlink.
            </p>
          </div>
        </div>
      </section>

      <!-- Section 4: Tag Dasar HTML -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-tags"></i> Tag Dasar HTML yang Harus Diketahui
        </h2>

        <div class="table-container">
          <table class="materi-table">
            <thead>
              <tr>
                <th>Tag</th>
                <th>Nama</th>
                <th>Fungsi</th>
                <th>Contoh</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><code>&lt;h1&gt; - &lt;h6&gt;</code></td>
                <td>Heading</td>
                <td>Membuat judul dengan ukuran berbeda</td>
                <td><code>&lt;h1&gt;Judul Utama&lt;/h1&gt;</code></td>
              </tr>
              <tr>
                <td><code>&lt;p&gt;</code></td>
                <td>Paragraf</td>
                <td>Membuat paragraf teks</td>
                <td><code>&lt;p&gt;Ini paragraf&lt;/p&gt;</code></td>
              </tr>
              <tr>
                <td><code>&lt;a&gt;</code></td>
                <td>Anchor/Link</td>
                <td>Membuat hyperlink</td>
                <td><code>&lt;a href="..."&gt;Link&lt;/a&gt;</code></td>
              </tr>
              <tr>
                <td><code>&lt;img&gt;</code></td>
                <td>Image</td>
                <td>Menampilkan gambar</td>
                <td><code>&lt;img src="foto.jpg" alt="Deskripsi"&gt;</code></td>
              </tr>
              <tr>
                <td><code>&lt;ul&gt; & &lt;li&gt;</code></td>
                <td>List</td>
                <td>Membuat daftar tidak berurutan</td>
                <td>
                  <code>&lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt;</code>
                </td>
              </tr>
              <tr>
                <td><code>&lt;div&gt;</code></td>
                <td>Division</td>
                <td>Mengelompokkan elemen untuk styling</td>
                <td>
                  <code>&lt;div class="container"&gt;...&lt;/div&gt;</code>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Section 5: Atribut HTML -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-cog"></i> Atribut HTML
        </h2>
        <p class="materi-text">
          Atribut memberikan informasi tambahan tentang elemen HTML. Atribut
          selalu ditulis dalam tag pembuka.
        </p>

        <div class="code-wrapper">
          <div class="code-header">
            <span>Contoh Atribut</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>&lt;!-- Atribut href pada link --&gt;
&lt;a href="https://edu.io" target="_blank"&gt;Kunjungi edu.io&lt;/a&gt;

&lt;!-- Atribut src dan alt pada gambar --&gt;
&lt;img src="logo.png" alt="Logo Edu.io" width="200" height="100"&gt;

&lt;!-- Atribut class dan id --&gt;
&lt;div class="container" id="main-content"&gt;
    Konten di sini
&lt;/div&gt;</code></pre>
        </div>

        <!-- Section 6: Tambahan Materi dari image.png -->
        <div
          class="materi-card"
          style="
            margin-top: 20px;
            background: rgba(66, 135, 245, 0.1);
            border-left: 4px solid var(--accent-teal);
          "
        >
          <h3><i class="fas fa-code"></i> Contoh Atribut HTML Lengkap</h3>

          <div
            class="info-box"
            style="border-left-color: var(--accent-yellow); margin: 15px 0"
          >
            <i class="fas fa-link" style="color: var(--accent-yellow)"></i>
            <div class="info-box-content">
              <h4 style="color: var(--accent-yellow)">Atribut pada Link</h4>
              <p>
                <code
                  >&lt;a href="https://www.da-tamato-buam-honungi.edu.co/"
                  target="_blank"&gt;Kunjungi Website&lt;/a&gt;</code
                >
              </p>
            </div>
          </div>

          <div
            class="info-box"
            style="border-left-color: var(--accent-purple); margin: 15px 0"
          >
            <i class="fas fa-image" style="color: var(--accent-purple)"></i>
            <div class="info-box-content">
              <h4 style="color: var(--accent-purple)">Atribut pada Gambar</h4>
              <p>
                <code
                  >&lt;img src="logo.png" alt="Deskripsi Gambar" width="300"
                  height="200"&gt;</code
                ><br />
                Contoh:
                <code
                  >src="https://www.pak-gibs-lose.fan.io/~atribu-gap-hejgic-126-9"</code
                >
              </p>
            </div>
          </div>

          <div
            class="info-box"
            style="border-left-color: var(--accent-teal); margin: 15px 0"
          >
            <i class="fas fa-tags" style="color: var(--accent-teal)"></i>
            <div class="info-box-content">
              <h4 style="color: var(--accent-teal)">Atribut Class dan ID</h4>
              <p>
                <code
                  >&lt;div class="container"
                  id="main-content"&gt;Konten&lt;/div&gt;</code
                ><br />
                Contoh penggunaan: <code>class="da-tamato-detector"</code>
              </p>
            </div>
          </div>

          <div
            class="info-box"
            style="border-left-color: #2ecc71; margin: 15px 0"
          >
            <i class="fas fa-check-circle" style="color: #2ecc71"></i>
            <div class="info-box-content">
              <h4 style="color: #2ecc71">Data Attributes</h4>
              <p>
                <code
                  >&lt;div data-info="online" data-version="1.0"&gt;Data
                  OK&lt;/div&gt;</code
                ><br />
                Atribut data-* digunakan untuk menyimpan data kustom.
              </p>
            </div>
          </div>
        </div>

        <h3 style="margin-top: 20px">Atribut Penting:</h3>
        <ul class="materi-list">
          <li><strong>class</strong>: Menentukan kelas CSS untuk styling</li>
          <li>
            <strong>id</strong>: Memberikan identifikasi unik untuk elemen
          </li>
          <li><strong>style</strong>: Menambahkan CSS inline</li>
          <li><strong>href</strong>: Menentukan URL untuk link</li>
          <li><strong>src</strong>: Menentukan sumber untuk gambar/media</li>
          <li><strong>alt</strong>: Teks alternatif untuk gambar</li>
          <li>
            <strong>target</strong>: Menentukan dimana link akan dibuka (misal:
            _blank untuk tab baru)
          </li>
          <li>
            <strong>width & height</strong>: Menentukan ukuran gambar/element
          </li>
          <li><strong>data-*</strong>: Atribut kustom untuk menyimpan data</li>
        </ul>
      </section>

      <!-- Section 7: Latihan Praktis -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-pencil-alt"></i> Latihan Praktis
        </h2>

        <div class="exercise-box">
          <h3><i class="fas fa-tasks"></i> Buat Halaman HTML Sederhana</h3>
          <p>Coba buat halaman HTML dengan spesifikasi berikut:</p>
          <ol class="materi-list">
            <li>Gunakan struktur dasar HTML5 yang benar</li>
            <li>Tambahkan judul halaman dengan <code>&lt;h1&gt;</code></li>
            <li>Buat 2 paragraf dengan <code>&lt;p&gt;</code></li>
            <li>
              Tambahkan gambar dengan atribut <code>src</code> dan
              <code>alt</code>
            </li>
            <li>
              Buat daftar hobi dengan <code>&lt;ul&gt;</code> dan
              <code>&lt;li&gt;</code>
            </li>
            <li>Tambahkan link ke Google dengan <code>&lt;a&gt;</code></li>
            <li>
              Tambahkan atribut <code>class</code> dan <code>id</code> pada
              elemen
            </li>
            <li>Gunakan atribut <code>data-*</code> untuk data kustom</li>
          </ol>

          <div class="tip-box">
            <i class="fas fa-lightbulb" style="color: #ffc107"></i>
            <p>
              <strong>Tip:</strong> Gunakan Live Coding di menu "Belajar" untuk
              mencoba kode HTML langsung!
            </p>
          </div>
        </div>
      </section>

      <!-- Section 8: Tips & Best Practices -->
      <section class="materi-card">
        <h2 class="materi-section-title">
          <i class="fas fa-star"></i> Tips & Best Practices
        </h2>

        <div class="tips-grid">
          <div class="tip-card">
            <i class="fas fa-check-circle" style="color: #2ecc71"></i>
            <h3>Gunakan Semantik HTML</h3>
            <p>
              Gunakan tag semantik seperti <code>&lt;header&gt;</code>,
              <code>&lt;nav&gt;</code>, <code>&lt;main&gt;</code>,
              <code>&lt;footer&gt;</code> untuk struktur yang lebih baik.
            </p>
          </div>

          <div class="tip-card">
            <i class="fas fa-text-height" style="color: #3498db"></i>
            <h3>Gunakan Heading dengan Benar</h3>
            <p>
              Gunakan <code>&lt;h1&gt;</code> hanya sekali per halaman sebagai
              judul utama, kemudian <code>&lt;h2&gt;</code>,
              <code>&lt;h3&gt;</code>, dst.
            </p>
          </div>

          <div class="tip-card">
            <i class="fas fa-eye" style="color: #e74c3c"></i>
            <h3>Selalu Tambahkan Alt Text</h3>
            <p>
              Gunakan atribut <code>alt</code> pada gambar untuk aksesibilitas
              dan SEO.
            </p>
          </div>

          <div class="tip-card">
            <i class="fas fa-code" style="color: #9b59b6"></i>
            <h3>Indentasi Kode</h3>
            <p>
              Gunakan indentasi yang konsisten untuk kode yang lebih mudah
              dibaca.
            </p>
          </div>

          <div class="tip-card">
            <i class="fas fa-cogs" style="color: #e67e22"></i>
            <h3>Gunakan Atribut dengan Benar</h3>
            <p>
              Pastikan atribut seperti <code>href</code>, <code>src</code>, dan
              <code>alt</code> diisi dengan nilai yang valid dan bermakna.
            </p>
          </div>

          <div class="tip-card">
            <i class="fas fa-mobile-alt" style="color: #1abc9c"></i>
            <h3>Responsif dengan Atribut</h3>
            <p>
              Gunakan atribut seperti <code>width="100%"</code> dan
              <code>height="auto"</code> untuk gambar responsif.
            </p>
          </div>
        </div>
      </section>

      <!-- Navigation -->
      <div class="quiz-navigation">
        <a href="../materi.php" class="btn-quiz-nav btn-prev">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="materi-css.php" class="btn-quiz-nav btn-next">
          Lanjut ke CSS <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>

    <script src="../script.js"></script>
    <script>
      // Fungsi untuk copy code
      document.querySelectorAll(".fa-copy").forEach((icon) => {
        icon.addEventListener("click", function () {
          const codeBlock = this.closest(".code-wrapper").querySelector("code");
          const codeText = codeBlock.textContent;

          navigator.clipboard.writeText(codeText).then(() => {
            const originalIcon = this.className;
            this.className = "fas fa-check";
            this.style.color = "#2ecc71";

            setTimeout(() => {
              this.className = originalIcon;
              this.style.color = "";
            }, 2000);
          });
        });
      });

      // Tambahkan kelas untuk mode terang
      document.addEventListener("DOMContentLoaded", function () {
        if (!document.documentElement.classList.contains("dark-mode")) {
          // Tambahkan style khusus untuk mode terang
          const style = document.createElement("style");
          style.textContent = `
            body:not(.dark-mode) .code-wrapper pre code {
              color: #f8f8f2 !important;
            }
            body:not(.dark-mode) .code-wrapper {
              background: #282a36 !important;
            }
            body:not(.dark-mode) .code-header {
              background: #1e1f29 !important;
              color: #f8f8f2 !important;
            }
          `;
          document.head.appendChild(style);
        }
      });
    </script>
  </body>
</html>
