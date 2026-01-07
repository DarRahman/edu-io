<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Materi: Dasar-dasar CSS - edu.io</title>
  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Style tambahan untuk materi CSS */
    .code-wrapper pre code {
      color: #f8f8f2 !important;
      font-family: "Consolas", "Monaco", "Courier New", monospace;
      font-size: 0.95em;
      line-height: 1.5;
    }

    .css-example {
      border: 2px dashed var(--accent-teal);
      padding: 15px;
      margin: 15px 0;
      background: rgba(0, 168, 150, 0.05);
      border-radius: 10px;
    }

    .css-example .preview {
      padding: 15px;
      background: white;
      border-radius: 8px;
      margin-top: 10px;
      border: 1px solid var(--border-color);
    }

    .selector-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin: 20px 0;
    }

    .selector-card {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.3s ease;
    }

    .selector-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .selector-card h4 {
      color: var(--accent-teal);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .selector-card code {
      background: rgba(0, 0, 0, 0.1);
      padding: 3px 8px;
      border-radius: 4px;
      font-family: "Consolas", monospace;
    }

    .color-demo {
      width: 30px;
      height: 30px;
      display: inline-block;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      margin-right: 10px;
      vertical-align: middle;
    }

    .box-model-demo {
      width: 200px;
      height: 100px;
      margin: 30px auto;
      padding: 20px;
      border: 10px solid #3498db;
      background: #f8f9fa;
      position: relative;
    }

    .box-model-label {
      position: absolute;
      font-size: 12px;
      color: #666;
      background: white;
      padding: 2px 5px;
      border-radius: 3px;
      border: 1px solid #ddd;
    }

    .margin-label {
      top: -25px;
      left: 50%;
      transform: translateX(-50%);
    }

    .border-label {
      top: 50%;
      left: -45px;
      transform: translateY(-50%);
    }

    .padding-label {
      top: 50%;
      left: 230px;
      transform: translateY(-50%);
    }

    .content-label {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>

<body>
  <?php $path = "../";
  include '../includes/navbar.php'; ?>

  <div class="materi-wrapper">
    <!-- Hero Section -->
    <header class="materi-hero" style="background: linear-gradient(135deg, #2980b9, #2c3e50)">
      <h1><i class="fab fa-css3-alt"></i> Dasar-dasar CSS</h1>
      <p>
        Pelajari cara mempercantik tampilan website dengan Cascading Style
        Sheets.
      </p>
    </header>

    <!-- Section 1: Pengertian -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-info-circle"></i> Pengertian CSS
      </h2>
      <p class="materi-text">
        <strong>CSS (Cascading Style Sheet)</strong> digunakan untuk
        memberikan warna, style, ukuran, dan mengatur posisi elemen-elemen di
        halaman website. Tanpa CSS, website hanya akan berupa teks hitam putih
        yang membosankan.
      </p>

      <div class="info-box">
        <i class="fas fa-exclamation-circle"></i>
        <div class="info-box-content">
          <h4>Bukan Bahasa Pemrograman</h4>
          <p>
            CSS adalah bahasa <em>style sheet</em>, bukan bahasa pemrograman.
            Fungsinya memisahkan konten (HTML) dari tampilan (Desain).
          </p>
        </div>
      </div>

      <p class="materi-text">
        CSS memungkinkan satu file style digunakan untuk banyak halaman HTML
        sekaligus. Ini membuat pengelolaan tampilan website menjadi jauh lebih
        efisien.
      </p>

      <ul class="materi-list">
        <li>CSS adalah aturan untuk menampilkan elemen HTML.</li>
        <li>
          Script CSS sebaiknya dibuat terpisah dari HTML (External CSS).
        </li>
        <li>1 file CSS dapat mengontrol tampilan ribuan halaman HTML.</li>
        <li>CSS3 adalah versi terbaru dengan fitur-fitur modern.</li>
      </ul>
    </section>

    <!-- Section 2: Hubungan HTML & CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-link"></i> Hubungan CSS dan HTML
      </h2>
      <p class="materi-text">
        Jika diibaratkan,
        <strong>HTML adalah kerangka manusia</strong> (tulang), sedangkan
        <strong>CSS adalah kulit dan pakaiannya</strong>. HTML membangun
        struktur, CSS memberikan tampilan visual.
      </p>
      <p class="materi-text">
        CSS bekerja dengan memilih elemen HTML (selector) dan memberikan
        aturan gaya (property) kepadanya. Misalnya, mengubah semua teks dalam
        paragraf menjadi berwarna biru.
      </p>

      <div class="css-example">
        <h4>Contoh: HTML dengan CSS</h4>
        <div class="code-wrapper">
          <div class="code-header">
            <span>index.html</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;link rel="stylesheet" href="style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Selamat Datang&lt;/h1&gt;
    &lt;p class="deskripsi"&gt;Ini adalah paragraf dengan style CSS.&lt;/p&gt;
    &lt;div id="kontainer"&gt;
        Konten di sini
    &lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
        </div>

        <div class="code-wrapper">
          <div class="code-header">
            <span>style.css</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>/* Style untuk halaman */
h1 {
    color: #2980b9;
    text-align: center;
    font-family: 'Poppins', sans-serif;
}

.deskripsi {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

#kontainer {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #ddd;
}</code></pre>
        </div>
      </div>
    </section>

    <!-- Section 3: Fungsi CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-magic"></i> Fungsi Utama CSS
      </h2>

      <div class="info-box" style="border-left-color: var(--accent-teal)">
        <i class="fas fa-tachometer-alt" style="color: var(--accent-teal)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-teal)">1. Loading Lebih Cepat</h4>
          <p>
            Dengan CSS eksternal, browser hanya perlu memuat kode tampilan
            sekali untuk seluruh website (caching).
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: var(--accent-purple)">
        <i class="fas fa-paint-brush" style="color: var(--accent-purple)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-purple)">2. Variasi Tampilan</h4>
          <p>
            CSS menawarkan kontrol desain yang jauh lebih kaya daripada
            atribut HTML lama.
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: #f39c12">
        <i class="fas fa-mobile-alt" style="color: #f39c12"></i>
        <div class="info-box-content">
          <h4 style="color: #f39c12">3. Responsif (Rapi di Semua Layar)</h4>
          <p>
            CSS memungkinkan website menyesuaikan diri dengan ukuran layar HP,
            tablet, atau desktop (Responsive Web Design).
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: #2ecc71">
        <i class="fas fa-users" style="color: #2ecc71"></i>
        <div class="info-box-content">
          <h4 style="color: #2ecc71">4. Aksesibilitas</h4>
          <p>
            CSS membantu membuat website lebih mudah diakses oleh pengguna
            dengan kebutuhan khusus.
          </p>
        </div>
      </div>
    </section>

    <!-- Section 4: Sintaks Dasar CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-code"></i> Sintaks Dasar CSS
      </h2>
      <p class="materi-text">
        Struktur dasar CSS terdiri dari selector, property, dan value:
      </p>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Sintaks CSS</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>selector {
    property: value;
    property: value;
}</code></pre>
      </div>

      <div class="css-example">
        <div class="code-wrapper">
          <div class="code-header">
            <span>Contoh Praktis</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>/* Mengubah semua paragraf */
p {
    color: blue;
    font-size: 16px;
    line-height: 1.5;
}

/* Mengubah elemen dengan class "tombol" */
.tombol {
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Mengubah elemen dengan id "header" */
#header {
    background: linear-gradient(to right, #2980b9, #2c3e50);
    color: white;
    padding: 20px;
    text-align: center;
}</code></pre>
        </div>

        <div class="preview">
          <h4 style="
                background: linear-gradient(to right, #2980b9, #2c3e50);
                color: white;
                padding: 20px;
                text-align: center;
                margin: 0 0 15px 0;
                border-radius: 5px;
              ">
            Header dengan Gradient
          </h4>
          <p style="
                color: blue;
                font-size: 16px;
                line-height: 1.5;
                margin: 10px 0;
              ">
            Ini adalah paragraf dengan style biru dan line-height 1.5.
          </p>
          <button style="
                background-color: #3498db;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
              ">
            Tombol Styled
          </button>
        </div>
      </div>
    </section>

    <!-- Section 5: Selector CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-mouse-pointer"></i> Selector CSS
      </h2>
      <p class="materi-text">
        Selector digunakan untuk memilih elemen HTML yang akan diberi style:
      </p>

      <div class="selector-grid">
        <div class="selector-card">
          <h4><i class="fas fa-hashtag"></i> ID Selector</h4>
          <p>Memilih elemen berdasarkan ID (unik)</p>
          <code>#nama-id { }</code>
          <p>
            <small>Contoh: <code>#header { color: red; }</code></small>
          </p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-circle"></i> Class Selector</h4>
          <p>Memilih elemen berdasarkan class (bisa banyak)</p>
          <code>.nama-class { }</code>
          <p>
            <small>Contoh: <code>.tombol { background: blue; }</code></small>
          </p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-tag"></i> Element Selector</h4>
          <p>Memilih semua elemen dengan tag tertentu</p>
          <code>tag { }</code>
          <p>
            <small>Contoh: <code>p { font-size: 14px; }</code></small>
          </p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-asterisk"></i> Universal Selector</h4>
          <p>Memilih semua elemen di halaman</p>
          <code>* { }</code>
          <p>
            <small>Contoh: <code>* { margin: 0; padding: 0; }</code></small>
          </p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-sitemap"></i> Descendant Selector</h4>
          <p>Memilih elemen di dalam elemen lain</p>
          <code>parent child { }</code>
          <p>
            <small>Contoh: <code>div p { color: green; }</code></small>
          </p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-child"></i> Child Selector</h4>
          <p>Memilih anak langsung dari elemen</p>
          <code>parent > child { }</code>
          <p>
            <small>Contoh: <code>ul > li { list-style: none; }</code></small>
          </p>
        </div>
      </div>
    </section>

    <!-- Section 6: Warna dalam CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-palette"></i> Warna dalam CSS
      </h2>
      <p class="materi-text">CSS mendukung berbagai format warna:</p>

      <div class="materi-table-wrapper">
        <table class="materi-table">
          <thead>
            <tr>
              <th>Format</th>
              <th>Contoh</th>
              <th>Penjelasan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Nama Warna</td>
              <td>
                <code>color: red;</code>
                <span class="color-demo" style="background: red"></span>
              </td>
              <td>Menggunakan nama warna yang telah ditentukan</td>
            </tr>
            <tr>
              <td>HEX</td>
              <td>
                <code>color: #ff0000;</code>
                <span class="color-demo" style="background: #ff0000"></span>
              </td>
              <td>Format heksadesimal (6 digit)</td>
            </tr>
            <tr>
              <td>RGB</td>
              <td>
                <code>color: rgb(255, 0, 0);</code>
                <span class="color-demo" style="background: rgb(255, 0, 0)"></span>
              </td>
              <td>Red, Green, Blue (0-255)</td>
            </tr>
            <tr>
              <td>RGBA</td>
              <td>
                <code>color: rgba(255, 0, 0, 0.5);</code>
                <span class="color-demo" style="background: rgba(255, 0, 0, 0.5)"></span>
              </td>
              <td>RGB dengan transparansi (alpha 0-1)</td>
            </tr>
            <tr>
              <td>HSL</td>
              <td>
                <code>color: hsl(0, 100%, 50%);</code>
                <span class="color-demo" style="background: hsl(0, 100%, 50%)"></span>
              </td>
              <td>Hue, Saturation, Lightness</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Section 7: Box Model -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-square"></i> CSS Box Model
      </h2>
      <p class="materi-text">
        Setiap elemen HTML adalah sebuah "kotak" yang terdiri dari:
      </p>

      <div class="box-model-demo">
        <div class="box-model-label margin-label">Margin</div>
        <div class="box-model-label border-label">Border</div>
        <div class="box-model-label padding-label">Padding</div>
        <div class="box-model-label content-label">Content</div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Contoh Box Model</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>.kotak {
    width: 300px;
    height: 200px;
    padding: 20px;        /* Jarak dalam */
    border: 5px solid #3498db; /* Garis tepi */
    margin: 30px;         /* Jarak luar */
    background-color: #f8f9fa;
}</code></pre>
      </div>

      <ul class="materi-list">
        <li>
          <strong>Content:</strong> Area konten sebenarnya (teks, gambar, dll)
        </li>
        <li>
          <strong>Padding:</strong> Ruang antara konten dan border (warna
          background)
        </li>
        <li><strong>Border:</strong> Garis tepi di sekitar padding</li>
        <li><strong>Margin:</strong> Ruang di luar border (transparan)</li>
      </ul>
    </section>

    <!-- Section 8: Property Dasar CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-code"></i> Property Dasar CSS
      </h2>
      <p class="materi-text">
        Berikut adalah beberapa properti CSS yang paling sering digunakan:
      </p>

      <div class="materi-table-wrapper">
        <table class="materi-table">
          <thead>
            <tr>
              <th>Property</th>
              <th>Penjelasan</th>
              <th>Contoh</th>
              <th>Nilai Umum</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><code>color</code></td>
              <td>Mengatur warna teks</td>
              <td><code>color: red;</code></td>
              <td>Nama, HEX, RGB</td>
            </tr>
            <tr>
              <td><code>background-color</code></td>
              <td>Mengatur warna latar belakang</td>
              <td><code>background-color: #333;</code></td>
              <td>Nama, HEX, RGB</td>
            </tr>
            <tr>
              <td><code>font-size</code></td>
              <td>Mengatur ukuran huruf</td>
              <td><code>font-size: 16px;</code></td>
              <td>px, em, rem, %</td>
            </tr>
            <tr>
              <td><code>font-family</code></td>
              <td>Mengatur jenis font</td>
              <td><code>font-family: Arial;</code></td>
              <td>Arial, sans-serif, etc</td>
            </tr>
            <tr>
              <td><code>margin</code></td>
              <td>Jarak di LUAR elemen</td>
              <td><code>margin: 20px;</code></td>
              <td>px, em, %, auto</td>
            </tr>
            <tr>
              <td><code>padding</code></td>
              <td>Jarak di DALAM elemen</td>
              <td><code>padding: 15px;</code></td>
              <td>px, em, %</td>
            </tr>
            <tr>
              <td><code>border</code></td>
              <td>Garis tepi</td>
              <td><code>border: 1px solid black;</code></td>
              <td>width style color</td>
            </tr>
            <tr>
              <td><code>width / height</code></td>
              <td>Lebar dan tinggi</td>
              <td><code>width: 100%;</code></td>
              <td>px, %, vw, vh</td>
            </tr>
            <tr>
              <td><code>text-align</code></td>
              <td>Posisi teks horizontal</td>
              <td><code>text-align: center;</code></td>
              <td>left, center, right</td>
            </tr>
            <tr>
              <td><code>display</code></td>
              <td>Jenis tampilan elemen</td>
              <td><code>display: flex;</code></td>
              <td>block, inline, flex, grid</td>
            </tr>
            <tr>
              <td><code>position</code></td>
              <td>Posisi elemen</td>
              <td><code>position: relative;</code></td>
              <td>static, relative, absolute</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Section 9: Jenis CSS -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-layer-group"></i> 3 Jenis Penulisan CSS
      </h2>

      <div class="selector-grid">
        <div class="selector-card">
          <h4><i class="fas fa-code"></i> 1. Inline CSS</h4>
          <p>
            Ditulis langsung di tag HTML menggunakan atribut
            <code>style</code>
          </p>
          <code>&lt;p style="color:blue"&gt;</code>
          <div class="info-box" style="
                margin-top: 10px;
                padding: 10px;
                background: rgba(255, 0, 0, 0.1);
                border-left-color: #e74c3c;
              ">
            <i class="fas fa-exclamation-triangle" style="color: #e74c3c"></i>
            <div class="info-box-content">
              <p>
                <small>Tidak disarankan untuk proyek besar. Sulit dikelola.</small>
              </p>
            </div>
          </div>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-file-code"></i> 2. Internal CSS</h4>
          <p>
            Ditulis di dalam tag <code>&lt;style&gt;</code> di bagian
            <code>&lt;head&gt;</code>
          </p>
          <pre style="
                background: #f5f5f5;
                padding: 10px;
                border-radius: 5px;
                font-size: 12px;
              "><code>&lt;style&gt;
    p { color: blue; }
&lt;/style&gt;</code></pre>
          <p><small>Cocok untuk halaman tunggal.</small></p>
        </div>

        <div class="selector-card">
          <h4><i class="fas fa-external-link-alt"></i> 3. External CSS</h4>
          <p>
            File terpisah berekstensi <code>.css</code> yang dihubungkan
            dengan <code>&lt;link&gt;</code>
          </p>
          <code>&lt;link rel="stylesheet" href="style.css"&gt;</code>
          <div class="info-box" style="
                margin-top: 10px;
                padding: 10px;
                background: rgba(46, 204, 113, 0.1);
                border-left-color: #2ecc71;
              ">
            <i class="fas fa-check-circle" style="color: #2ecc71"></i>
            <div class="info-box-content">
              <p>
                <small><strong>Metode terbaik</strong> dan paling
                  profesional.</small>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 10: Flexbox & Grid -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-th"></i> Layout Modern: Flexbox & Grid
      </h2>

      <div class="info-box" style="border-left-color: #3498db">
        <i class="fab fa-css3-alt" style="color: #3498db"></i>
        <div class="info-box-content">
          <h4 style="color: #3498db">CSS Flexbox</h4>
          <p>
            Untuk layout satu dimensi (baris atau kolom). Sempurna untuk
            navbar, galeri, dll.
          </p>
          <code>display: flex;</code>
        </div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Contoh Flexbox</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>.container {
    display: flex;
    justify-content: space-between; /* Rata kiri-kanan */
    align-items: center;            /* Rata tengah vertikal */
    flex-wrap: wrap;                /* Bisa pindah baris */
}

.item {
    flex: 1;                        /* Besar proporsional */
    margin: 10px;
}</code></pre>
      </div>

      <div class="info-box" style="border-left-color: #9b59b6; margin-top: 20px">
        <i class="fas fa-border-all" style="color: #9b59b6"></i>
        <div class="info-box-content">
          <h4 style="color: #9b59b6">CSS Grid</h4>
          <p>
            Untuk layout dua dimensi (baris dan kolom). Sangat powerful untuk
            layout kompleks.
          </p>
          <code>display: grid;</code>
        </div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Contoh Grid</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 kolom sama besar */
    grid-gap: 20px;                        /* Jarak antar item */
    grid-template-rows: 200px auto 150px;  /* Tinggi baris */
}

.item {
    grid-column: span 2;                   /* Lebar 2 kolom */
    grid-row: 1;                           /* Posisi baris 1 */
}</code></pre>
      </div>
    </section>

    <!-- Section 11: Responsive Design -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-mobile-alt"></i> Responsive Design
      </h2>
      <p class="materi-text">
        Membuat website tampil optimal di semua perangkat:
      </p>

      <div class="css-example">
        <h4>Media Queries</h4>
        <div class="code-wrapper">
          <div class="code-header">
            <span>style.css</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>/* Default untuk desktop */
.container {
    width: 1200px;
    margin: 0 auto;
}

/* Tablet (768px - 1024px) */
@media (max-width: 1024px) {
    .container {
        width: 90%;
    }
    .menu { display: none; }
}

/* Smartphone (< 768px) */
@media (max-width: 768px) {
    .container {
        width: 100%;
        padding: 10px;
    }
    h1 { font-size: 24px; }
    .menu { display: block; }
}</code></pre>
        </div>
      </div>

      <div class="tips-grid">
        <div class="tip-card">
          <i class="fas fa-ruler-combined" style="color: #3498db"></i>
          <h3>Unit Responsif</h3>
          <p>
            Gunakan <code>%</code>, <code>vw</code>, <code>vh</code>,
            <code>em</code>, <code>rem</code> untuk ukuran yang fleksibel.
          </p>
        </div>

        <div class="tip-card">
          <i class="fas fa-image" style="color: #2ecc71"></i>
          <h3>Gambar Responsif</h3>
          <p>
            <code>img { max-width: 100%; height: auto; }</code> agar gambar
            tidak meluber.
          </p>
        </div>

        <div class="tip-card">
          <i class="fas fa-columns" style="color: #9b59b6"></i>
          <h3>Flexbox/Grid</h3>
          <p>
            Layout modern secara alami lebih responsif daripada float atau
            table.
          </p>
        </div>
      </div>
    </section>

    <!-- Section 12: Latihan Praktis -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-pencil-alt"></i> Latihan Praktis
      </h2>

      <div class="exercise-box">
        <h3><i class="fas fa-tasks"></i> Buat Layout dengan CSS</h3>
        <p>Coba buat layout responsif dengan spesifikasi berikut:</p>
        <ol class="materi-list">
          <li>Buat header dengan background gradient dan teks putih</li>
          <li>Buat navigasi horizontal menggunakan Flexbox</li>
          <li>Buat 3 kolom konten menggunakan CSS Grid</li>
          <li>Tambahkan gambar dengan border-radius dan shadow</li>
          <li>Buat tombol dengan hover effect</li>
          <li>Buat footer dengan posisi tetap di bawah</li>
          <li>Tambahkan media queries untuk tampilan mobile</li>
        </ol>

        <div class="tip-box">
          <i class="fas fa-lightbulb" style="color: #ffc107"></i>
          <p>
            <strong>Tip:</strong> Gunakan Chrome DevTools (F12) untuk menguji
            responsif dengan Device Toolbar.
          </p>
        </div>
      </div>
    </section>

    <!-- Navigation -->
    <div class="quiz-navigation">
      <a href="materi-html.php" class="btn-quiz-nav btn-prev">
        <i class="fas fa-arrow-left"></i> Materi HTML
      </a>
      <a href="materi-js.php" class="btn-quiz-nav btn-next">
        Lanjut ke JavaScript <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <footer>
    <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>

  <script src="../assets/js/script.js"></script>
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
  </script>
</body>

</html>