<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Materi: JavaScript - edu.io</title>
  <link rel="icon" type="image/png" href="../favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../assets/css/materi_detail.css">
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

  <div class="materi-wrapper">
    <!-- Hero Section -->
    <header class="materi-hero" style="
          background: linear-gradient(135deg, #f7df1e, #f0db4f);
          color: #323330;
        ">
      <h1><i class="fab fa-js"></i> Pengenalan JavaScript</h1>
      <p style="color: #323330">
        Bahasa pemrograman yang membuat website menjadi interaktif dan
        dinamis.
      </p>
    </header>

    <!-- Section 1: Pengertian -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-info-circle"></i> Pengertian JavaScript
      </h2>
      <p class="materi-text">
        <strong>JavaScript</strong> adalah bahasa skrip yang digunakan untuk
        membuat konten halaman web dinamis, berfungsi untuk membuat elemen
        yang mampu meningkatkan interaksi pengunjung seperti menu drop-down,
        animasi, dan warna background dinamis.
      </p>
      <p class="materi-text">
        Sejarah JavaScript dimulai pada tahun 1995, diciptakan oleh Brendan
        Eich di Netscape Communications. Awalnya bernama LiveScript, kemudian
        diubah menjadi JavaScript.
      </p>

      <div class="info-box" style="border-left-color: #f7df1e">
        <i class="fas fa-exclamation-circle" style="color: #f7df1e"></i>
        <div class="info-box-content">
          <h4 style="color: #323330">JavaScript vs Java</h4>
          <p>
            Meski namanya mirip, JavaScript dan Java adalah bahasa yang sangat
            berbeda. JavaScript untuk web, Java untuk aplikasi desktop/mobile.
            JavaScript lebih ringan dan mudah dipelajari.
          </p>
        </div>
      </div>
    </section>

    <!-- Section 2: Fungsi -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-cogs"></i> Fungsi Utama JavaScript
      </h2>

      <div class="info-box" style="border-left-color: var(--accent-blue)">
        <i class="fas fa-mobile-alt" style="color: var(--accent-blue)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-blue)">1. Efisiensi Pengembangan</h4>
          <p>
            Framework seperti ReactJS, Angular, dan Vue.js memungkinkan
            developer menggunakan kode siap pakai, mempercepat proses
            development.
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: var(--accent-purple)">
        <i class="fas fa-server" style="color: var(--accent-purple)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-purple)">2. Web Server & Backend</h4>
          <p>
            Dengan Node.js, JavaScript bisa digunakan untuk membangun server
            dan infrastruktur backend, tidak hanya frontend.
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: var(--accent-teal)">
        <i class="fas fa-mouse-pointer" style="color: var(--accent-teal)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-teal)">3. Website Interaktif</h4>
          <p>
            Membuat animasi, mengubah konten tanpa reload, dan menangani
            interaksi user secara real-time.
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: var(--accent-yellow)">
        <i class="fas fa-gamepad" style="color: var(--accent-yellow)"></i>
        <div class="info-box-content">
          <h4 style="color: var(--accent-yellow)">4. Pengembangan Game</h4>
          <p>
            Dikombinasikan dengan HTML5 dan WebGL, JS bisa digunakan untuk
            membuat game browser yang kompleks.
          </p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: #2ecc71">
        <i class="fas fa-robot" style="color: #2ecc71"></i>
        <div class="info-box-content">
          <h4 style="color: #2ecc71">5. Aplikasi Mobile & Desktop</h4>
          <p>
            Dengan React Native dan Electron, JavaScript bisa membuat aplikasi
            mobile dan desktop native.
          </p>
        </div>
      </div>
    </section>

    <!-- Section 3: Tipe Data -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-database"></i> Tipe Data JavaScript
      </h2>
      <p class="materi-text">
        JavaScript mendukung berbagai tipe data untuk menyimpan nilai:
      </p>

      <div class="concept-grid">
        <div class="concept-card">
          <h4><i class="fas fa-quote-right"></i> String</h4>
          <p>Teks dalam tanda kutip</p>
          <code>"Hello World"<br />'JavaScript'<br />`Template ${literal}`</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-sort-numeric-up"></i> Number</h4>
          <p>Bilangan bulat atau desimal</p>
          <code>42<br />3.14<br />1e5 (100000)</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-check-square"></i> Boolean</h4>
          <p>Nilai logika true/false</p>
          <code>true<br />false</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-cube"></i> Object</h4>
          <p>Struktur data kompleks</p>
          <code>{nama: "Budi", umur: 25}</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-list"></i> Array</h4>
          <p>Kumpulan nilai dalam []</p>
          <code>["Merah", "Hijau", "Biru"]</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-ban"></i> Null & Undefined</h4>
          <p>Null: nilai kosong<br />Undefined: belum diisi</p>
          <code>null<br />undefined</code>
        </div>
      </div>

      <div class="js-example">
        <h4>Demo: Tipe Data</h4>
        <div class="demo-buttons">
          <button class="demo-btn" onclick="demoString()">String</button>
          <button class="demo-btn" onclick="demoNumber()">Number</button>
          <button class="demo-btn" onclick="demoArray()">Array</button>
          <button class="demo-btn" onclick="demoObject()">Object</button>
        </div>
        <div id="typeDemoOutput" class="output-box" style="color: #000000">
          Klik tombol untuk melihat contoh tipe data
        </div>
      </div>
    </section>

    <!-- Section 4: Variabel -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-memory"></i> Variabel dalam JavaScript
      </h2>
      <p class="materi-text">
        JavaScript memiliki 3 cara mendeklarasi variabel:
      </p>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Deklarasi Variabel</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>// var (function scope - legacy)
var namaLama = "Budi";

// let (block scope - bisa diubah)
let umur = 25;
umur = 26; // Boleh diubah

// const (block scope - tidak bisa diubah)
const PI = 3.14;
// PI = 3.15; // ERROR! const tidak bisa diubah

// Deklarasi multiple
let a = 1, b = 2, c = 3;

// Deklarasi tanpa nilai
let x; // undefined
x = 10; // assignment</code></pre>
      </div>

      <div class="interactive-demo">
        <h4 style="color: #000000">Demo: Variabel</h4>
        <div class="code-wrapper" style="background: #000000ff; border: 1px solid #000000ff">
          <pre style="color: #333"><code>let counter = 0;
const max = 5;

function increment() {
    if (counter < max) {
        counter++;
        updateDisplay();
    }
}

function reset() {
    counter = 0;
    updateDisplay();
}</code></pre>
        </div>
        <div class="demo-buttons">
          <button class="demo-btn" onclick="incrementCounter()">
            Tambah (+1)
          </button>
          <button class="demo-btn" onclick="resetCounter()">Reset</button>
        </div>
        <div id="counterDisplay" class="output-box" style="text-align: center; font-size: 24px; font-weight: bold; color: #000000ff">
          Counter: 0
        </div>
      </div>
    </section>

    <!-- Section 5: Operator -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-calculator"></i> Operator JavaScript
      </h2>

      <div class="materi-table-wrapper">
        <table class="materi-table">
          <thead>
            <tr>
              <th>Jenis</th>
              <th>Operator</th>
              <th>Contoh</th>
              <th>Hasil</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Aritmatika</td>
              <td><code>+ - * / % **</code></td>
              <td><code>10 + 5</code></td>
              <td><code>15</code></td>
            </tr>
            <tr>
              <td>Penugasan</td>
              <td><code>= += -= *= /=</code></td>
              <td><code>x += 5</code></td>
              <td><code>x = x + 5</code></td>
            </tr>
            <tr>
              <td>Perbandingan</td>
              <td><code>== === != !== &gt; &lt;</code></td>
              <td><code>5 === "5"</code></td>
              <td><code>false</code></td>
            </tr>
            <tr>
              <td>Logika</td>
              <td><code>&& || !</code></td>
              <td><code>true && false</code></td>
              <td><code>false</code></td>
            </tr>
            <tr>
              <td>Ternary</td>
              <td><code>? :</code></td>
              <td><code>age >= 18 ? "Dewasa" : "Anak"</code></td>
              <td>Kondisional</td>
            </tr>
            <tr>
              <td>Typeof</td>
              <td><code>typeof</code></td>
              <td><code>typeof "hello"</code></td>
              <td><code>"string"</code></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="js-example">
        <h4>Demo: Operator</h4>
        <div class="demo-buttons">
          <button class="demo-btn" onclick="demoOperators()">
            Operasi Matematika
          </button>
          <button class="demo-btn" onclick="demoComparison()">
            Perbandingan
          </button>
          <button class="demo-btn" onclick="demoLogical()">Logika</button>
          <button class="demo-btn" onclick="demoTernary()">Ternary</button>
        </div>
        <div id="operatorDemoOutput" class="output-box" style="color: #000000">
          Klik tombol untuk melihat contoh operator
        </div>
      </div>
    </section>

    <!-- Section 6: Control Flow -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-project-diagram"></i> Control Flow
      </h2>

      <div class="concept-grid">
        <div class="concept-card">
          <h4><i class="fas fa-question-circle"></i> If-Else</h4>
          <code>if (kondisi) {<br />
              // kode jika true<br />} else {<br />
              // kode jika false<br />}</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-sync-alt"></i> Switch-Case</h4>
          <code>switch(nilai) {<br />
              case 1: // kode<br />
              break;<br />
              default: // kode<br />}</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-redo"></i> For Loop</h4>
          <code>for(let i=0; i<10; i++) {<br />
              // kode berulang<br />}</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-retweet"></i> While Loop</h4>
          <code>while(kondisi) {<br />
              // kode berulang<br />}</code>
        </div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Contoh Lengkap</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>// If-Else
let nilai = 85;
if (nilai >= 90) {
    console.log("Grade A");
} else if (nilai >= 80) {
    console.log("Grade B"); // Ini yang dieksekusi
} else {
    console.log("Grade C");
}

// For Loop untuk array
let buah = ["Apel", "Mangga", "Jeruk"];
for (let i = 0; i < buah.length; i++) {
    console.log(buah[i]);
}

// While Loop
let hitung = 0;
while (hitung < 3) {
    console.log("Hitung: " + hitung);
    hitung++;
}

// For...of (modern)
for (let item of buah) {
    console.log(item);
}</code></pre>
      </div>
    </section>

    <!-- Section 7: Fungsi -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-function"></i> Fungsi (Function)
      </h2>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Berbagai Cara Membuat Fungsi</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>// 1. Function Declaration
function tambah(a, b) {
    return a + b;
}

// 2. Function Expression
const kali = function(a, b) {
    return a * b;
};

// 3. Arrow Function (ES6)
const bagi = (a, b) => {
    return a / b;
};

// Arrow Function singkat
const pangkat = (a, b) => a ** b;

// 4. Immediately Invoked Function Expression (IIFE)
(function() {
    console.log("IIFE dijalankan!");
})();

// Penggunaan
console.log(tambah(5, 3));    // 8
console.log(kali(4, 2));      // 8
console.log(bagi(10, 2));     // 5
console.log(pangkat(2, 3));   // 8</code></pre>
      </div>

      <div class="interactive-demo">
        <h4 style="color: #000000">Demo: Kalkulator Sederhana</h4>
        <div style="
              display: grid;
              grid-template-columns: repeat(2, 1fr);
              gap: 15px;
              margin: 15px 0;
            ">
          <input type="number" id="num1" placeholder="Angka 1" value="10"
            style="padding: 10px; border: 1px solid #ddd; border-radius: 5px" />
          <input type="number" id="num2" placeholder="Angka 2" value="5"
            style="padding: 10px; border: 1px solid #ddd; border-radius: 5px" />
        </div>
        <div class="demo-buttons">
          <button class="demo-btn" onclick="calculate('add')">
            Tambah (+)
          </button>
          <button class="demo-btn" onclick="calculate('subtract')">
            Kurangi (-)
          </button>
          <button class="demo-btn" onclick="calculate('multiply')">
            Kali (×)
          </button>
          <button class="demo-btn" onclick="calculate('divide')">
            Bagi (÷)
          </button>
        </div>
        <div id="calculatorResult" class="output-box" style="color: #000000; text-align: center; font-size: 20px">
          Hasil: -
        </div>
      </div>
    </section>

    <!-- Section 8: DOM Manipulation -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-mouse-pointer"></i> DOM Manipulation
      </h2>
      <p class="materi-text">
        JavaScript dapat memanipulasi HTML Document Object Model (DOM):
      </p>

      <div class="concept-grid">
        <div class="concept-card">
          <h4><i class="fas fa-search"></i> Selektor</h4>
          <code>document.getElementById()<br />document.querySelector()<br />document.querySelectorAll()</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-edit"></i> Modifikasi</h4>
          <code>element.innerHTML<br />element.textContent<br />element.style<br />element.className</code>
        </div>

        <div class="concept-card">
          <h4><i class="fas fa-plus-circle"></i> Event</h4>
          <code>addEventListener()<br />onclick, onchange<br />onmouseover,
              onkeydown</code>
        </div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Contoh DOM Manipulation</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>// HTML: &lt;button id="myBtn"&gt;Klik Saya&lt;/button&gt;
// HTML: &lt;div id="output"&gt;&lt;/div&gt;

// Dapatkan elemen
const button = document.getElementById('myBtn');
const output = document.getElementById('output');

// Tambah event listener
button.addEventListener('click', function() {
    // Ubah konten
    output.innerHTML = 'Tombol diklik!';
    
    // Ubah style
    output.style.color = 'green';
    output.style.backgroundColor = '#f0f0f0';
    output.style.padding = '10px';
    output.style.borderRadius = '5px';
    
    // Tambah class
    output.classList.add('highlight');
});

// Buat elemen baru
const newElement = document.createElement('p');
newElement.textContent = 'Elemen baru dibuat!';
document.body.appendChild(newElement);</code></pre>
      </div>
    </section>

    <!-- Section 9: Async JavaScript -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-clock"></i> Async JavaScript
      </h2>

      <div class="info-box" style="border-left-color: #3498db">
        <i class="fas fa-hourglass-half" style="color: #3498db"></i>
        <div class="info-box-content">
          <h4 style="color: #3498db">Mengapa Async?</h4>
          <p>
            JavaScript single-threaded, jadi untuk operasi yang butuh waktu
            (API call, file reading), kita gunakan async agar tidak blocking.
          </p>
        </div>
      </div>

      <div class="code-wrapper">
        <div class="code-header">
          <span>Callback, Promise, Async/Await</span>
          <i class="fas fa-copy"></i>
        </div>
        <pre><code>// 1. Callback (lama)
function fetchData(callback) {
    setTimeout(() => {
        callback('Data diterima');
    }, 1000);
}

// 2. Promise (ES6)
function fetchDataPromise() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve('Data promise');
        }, 1000);
    });
}

// 3. Async/Await (ES7)
async function getData() {
    try {
        const data = await fetchDataPromise();
        console.log(data);
    } catch (error) {
        console.error(error);
    }
}

// Menggunakan Promise
fetchDataPromise()
    .then(data => console.log(data))
    .catch(error => console.error(error));</code></pre>
      </div>
    </section>

    <!-- Section 10: ES6+ Features -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-rocket"></i> Fitur ES6+ Modern
      </h2>

      <div class="materi-table-wrapper">
        <table class="materi-table">
          <thead>
            <tr>
              <th>Fitur</th>
              <th>Contoh</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Template Literals</td>
              <td><code>`Halo ${nama}`</code></td>
              <td>String dengan variabel</td>
            </tr>
            <tr>
              <td>Destructuring</td>
              <td><code>const {x, y} = obj</code></td>
              <td>Ekstrak nilai dari obj/array</td>
            </tr>
            <tr>
              <td>Spread Operator</td>
              <td><code>[...arr1, ...arr2]</code></td>
              <td>Gabungkan array/objek</td>
            </tr>
            <tr>
              <td>Default Parameters</td>
              <td><code>function(a=1, b=2)</code></td>
              <td>Nilai parameter default</td>
            </tr>
            <tr>
              <td>Modules</td>
              <td><code>import/export</code></td>
              <td>Pisahkan kode ke file</td>
            </tr>
            <tr>
              <td>Classes</td>
              <td><code>class Person {}</code></td>
              <td>OOP dalam JavaScript</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Section 11: Latihan Praktis -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-pencil-alt"></i> Latihan Praktis
      </h2>

      <div class="exercise-box">
        <h3><i class="fas fa-tasks"></i> Buat Aplikasi To-Do List</h3>
        <p>Coba buat aplikasi sederhana dengan spesifikasi berikut:</p>
        <ol class="materi-list">
          <li>Input text dan tombol "Tambah"</li>
          <li>List item yang bisa ditambahkan</li>
          <li>Fitur centang untuk menandai selesai</li>
          <li>Tombol hapus untuk setiap item</li>
          <li>Counter total item dan item selesai</li>
          <li>Simpan data ke localStorage</li>
          <li>Responsif untuk mobile</li>
        </ol>

        <div class="tip-box">
          <i class="fas fa-lightbulb" style="color: #ffc107"></i>
          <p>
            <strong>Tip:</strong> Gunakan array untuk menyimpan data, DOM
            manipulation untuk tampilan, dan event listeners untuk interaksi.
          </p>
        </div>

        <div class="code-wrapper">
          <div class="code-header">
            <span>Struktur Awal</span>
            <i class="fas fa-copy"></i>
          </div>
          <pre><code>// Data
let todos = [];

// Fungsi tambah todo
function addTodo(text) {
    const todo = {
        id: Date.now(),
        text: text,
        completed: false
    };
    todos.push(todo);
    renderTodos();
}

// Fungsi render ke DOM
function renderTodos() {
    // Manipulasi DOM di sini
}

// Event listener untuk form
document.getElementById('todoForm')
    .addEventListener('submit', function(e) {
        e.preventDefault();
        const input = document.getElementById('todoInput');
        addTodo(input.value);
        input.value = '';
    });</code></pre>
        </div>
      </div>
    </section>

    <!-- Section 12: Kelebihan & Kekurangan -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-balance-scale"></i> Kelebihan & Kekurangan
      </h2>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px">
        <div class="info-box" style="border-left-color: #2ecc71; margin: 0">
          <i class="fas fa-check-circle" style="color: #2ecc71"></i>
          <div class="info-box-content">
            <h4 style="color: #2ecc71">Kelebihan</h4>
            <ul style="
                  padding-left: 20px;
                  margin: 0;
                  font-size: 0.9em;
                  color: var(--text-secondary);
                ">
              <li>Mudah dipelajari pemula.</li>
              <li>Eksekusi cepat di browser.</li>
              <li>Komunitas sangat besar.</li>
              <li>Bisa untuk Frontend & Backend (Node.js).</li>
              <li>Banyak framework dan library.</li>
              <li>Cross-platform (web, mobile, desktop).</li>
            </ul>
          </div>
        </div>

        <div class="info-box" style="border-left-color: #e74c3c; margin: 0">
          <i class="fas fa-exclamation-triangle" style="color: #e74c3c"></i>
          <div class="info-box-content">
            <h4 style="color: #e74c3c">Kekurangan</h4>
            <ul style="
                  padding-left: 20px;
                  margin: 0;
                  font-size: 0.9em;
                  color: var(--text-secondary);
                ">
              <li>Keamanan di sisi klien (client-side).</li>
              <li>Debugging kadang sulit.</li>
              <li>Perbedaan interpretasi browser.</li>
              <li>Single-threaded (butuh async programming).</li>
              <li>Type coercion bisa membingungkan.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 13: Next Steps -->
    <section class="materi-card">
      <h2 class="materi-section-title">
        <i class="fas fa-graduation-cap"></i> Langkah Selanjutnya
      </h2>

      <div class="tips-grid">
        <div class="tip-card">
          <i class="fab fa-react" style="color: #61dafb"></i>
          <h3>React.js</h3>
          <p>
            Library UI untuk aplikasi web yang kompleks dengan Virtual DOM.
          </p>
        </div>

        <div class="tip-card">
          <i class="fab fa-node-js" style="color: #68a063"></i>
          <h3>Node.js</h3>
          <p>Runtime JavaScript untuk backend (server, API, database).</p>
        </div>

        <div class="tip-card">
          <i class="fab fa-vuejs" style="color: #42b883"></i>
          <h3>Vue.js</h3>
          <p>Framework progresif untuk membangun antarmuka pengguna.</p>
        </div>

        <div class="tip-card">
          <i class="fas fa-tools" style="color: #f7df1e"></i>
          <h3>Build Tools</h3>
          <p>Webpack, Babel, ESLint untuk development profesional.</p>
        </div>
      </div>

      <div class="info-box" style="border-left-color: #9b59b6; margin-top: 20px">
        <i class="fas fa-book" style="color: #9b59b6"></i>
        <div class="info-box-content">
          <h4 style="color: #9b59b6">Sumber Belajar</h4>
          <p>
            MDN Web Docs, JavaScript.info, FreeCodeCamp, Codecademy, dan video
            tutorial di YouTube.
          </p>
        </div>
      </div>
    </section>

    <!-- Navigation -->
    <div class="quiz-navigation">
      <a href="materi-css.php" class="btn-quiz-nav btn-prev">
        <i class="fas fa-arrow-left"></i> Kembali ke CSS
      </a>
      <a href="../quiz/index.php" class="btn-quiz-nav btn-next">
        Mulai Kuis <i class="fas fa-flag-checkered"></i>
      </a>
    </div>
  </div>

  <script src="../assets/js/script.js"></script>
  <script>
    // Demo Functions
    let counter = 0;
    const maxCounter = 5;

    function demoString() {
      const str = "Hello JavaScript!";
      const str2 = `Panjang string: ${str.length}`;
      const str3 = str.toUpperCase();
      document.getElementById("typeDemoOutput").innerHTML =
        `String: "${str}"<br>` +
        `Template Literal: ${str2}<br>` +
        `Uppercase: ${str3}`;
    }

    function demoNumber() {
      const num1 = 10;
      const num2 = 3.14;
      const sum = num1 + num2;
      const pow = num1 ** 2;
      document.getElementById("typeDemoOutput").innerHTML =
        `Integer: ${num1}<br>` +
        `Float: ${num2}<br>` +
        `Sum: ${sum}<br>` +
        `Power: ${pow}`;
    }

    function demoArray() {
      const fruits = ["Apple", "Banana", "Orange"];
      const joined = fruits.join(", ");
      const mapped = fruits.map((fruit) => fruit.toUpperCase());
      document.getElementById("typeDemoOutput").innerHTML =
        `Array: [${fruits}]<br>` +
        `Joined: ${joined}<br>` +
        `Mapped: [${mapped}]<br>` +
        `Length: ${fruits.length}`;
    }

    function demoObject() {
      const person = {
        name: "John Doe",
        age: 30,
        city: "Jakarta",
        greet: function () {
          return `Hello, I'm ${this.name}`;
        },
      };
      document.getElementById("typeDemoOutput").innerHTML =
        `Object: ${JSON.stringify(person)}<br>` +
        `Name: ${person.name}<br>` +
        `Age: ${person.age}<br>` +
        `Method: ${person.greet()}`;
    }

    function incrementCounter() {
      if (counter < maxCounter) {
        counter++;
        updateDisplay();
      }
    }

    function resetCounter() {
      counter = 0;
      updateDisplay();
    }

    function updateDisplay() {
      document.getElementById(
        "counterDisplay"
      ).innerHTML = `Counter: ${counter}`;
      if (counter >= maxCounter) {
        document.getElementById("counterDisplay").innerHTML +=
          "<br><small style='color: green;'>Maksimum tercapai!</small>";
      }
    }

    function demoOperators() {
      const a = 10,
        b = 3;
      document.getElementById("operatorDemoOutput").innerHTML =
        `Aritmatika:<br>` +
        `${a} + ${b} = ${a + b}<br>` +
        `${a} - ${b} = ${a - b}<br>` +
        `${a} * ${b} = ${a * b}<br>` +
        `${a} / ${b} = ${(a / b).toFixed(2)}<br>` +
        `${a} % ${b} = ${a % b}`;
    }

    function demoComparison() {
      const num = 5;
      const str = "5";
      document.getElementById("operatorDemoOutput").innerHTML =
        `Perbandingan:<br>` +
        `${num} == "${str}": ${num == str}<br>` +
        `${num} === "${str}": ${num === str}<br>` +
        `${num} != "${str}": ${num != str}<br>` +
        `${num} !== "${str}": ${num !== str}`;
    }

    function demoLogical() {
      const isLogged = true;
      const isAdmin = false;
      document.getElementById("operatorDemoOutput").innerHTML =
        `Logika:<br>` +
        `isLogged && isAdmin: ${isLogged && isAdmin}<br>` +
        `isLogged || isAdmin: ${isLogged || isAdmin}<br>` +
        `!isAdmin: ${!isAdmin}`;
    }

    function demoTernary() {
      const age = 20;
      const canVote = age >= 17 ? "Bisa memilih" : "Belum bisa memilih";
      document.getElementById("operatorDemoOutput").innerHTML =
        `Ternary Operator:<br>` + `Umur: ${age}<br>` + `Hasil: ${canVote}`;
    }

    function calculate(operation) {
      const num1 = parseFloat(document.getElementById("num1").value) || 0;
      const num2 = parseFloat(document.getElementById("num2").value) || 0;
      let result;

      switch (operation) {
        case "add":
          result = num1 + num2;
          break;
        case "subtract":
          result = num1 - num2;
          break;
        case "multiply":
          result = num1 * num2;
          break;
        case "divide":
          result = num2 !== 0 ? num1 / num2 : "Error: Pembagian nol";
          break;
      }

      document.getElementById(
        "calculatorResult"
      ).innerHTML = `Hasil: ${num1} ${getOperationSymbol(
        operation
      )} ${num2} = ${result}`;
    }

    function getOperationSymbol(op) {
      switch (op) {
        case "add":
          return "+";
        case "subtract":
          return "-";
        case "multiply":
          return "×";
        case "divide":
          return "÷";
        default:
          return "?";
      }
    }

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
  <footer>
        <?php include '../includes/visitor_stats.php'; ?>
    <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
  </footer>
</body>

</html>