<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>edu.io - Menu Utama</title>

    <!-- Favicon & Styles -->
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="style.css" />

    <!-- Fonts & Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <!-- Libraries (Markdown for AI & SweetAlert) -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Pre-load Dark Mode Script -->
    <script>
      (function () {
        const currentTheme = localStorage.getItem("theme");
        if (currentTheme === "dark") {
          document.documentElement.classList.add("dark-mode");
        }
      })();
    </script>
  </head>

  <body>
    <!-- ================= NAVBAR ================= -->
    <?php $path = ""; include 'includes/navbar.php'; ?>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="container">
      <h1 class="page-title">Selamat Datang!</h1>

      <main>
        <p
          style="
            text-align: center;
            font-size: 1.2em;
            color: var(--text-secondary);
          "
        >
          Pilih salah satu menu di bawah untuk memulai perjalanan belajar Anda.
        </p>

        <!-- Grid Menu Utama -->
        <div class="feature-grid">
          <!-- Card 1: Materi -->
          <a
            href="materi.php"
            class="feature-card shadow-materi"
            data-aos="fade-up"
            data-aos-delay="100"
          >
            <div class="card-header">
              <i class="fas fa-compass-drafting icon-materi"></i>
              <h2>Jelajahi Materi</h2>
            </div>
            <p>
              Pelajari berbagai topik menarik untuk memperluas pengetahuan Anda.
            </p>
            <span class="card-link color-materi">Lihat Materi &rarr;</span>
          </a>

          <!-- Card 2: Kuis -->
          <a
            href="kuis.php"
            class="feature-card shadow-kuis"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            <div class="card-header">
              <i class="fas fa-clipboard-check icon-kuis"></i>
              <h2>Tantang Diri</h2>
            </div>
            <p>
              Uji pemahaman Anda dengan mengerjakan kuis interaktif yang seru.
            </p>
            <span class="card-link color-kuis">Mulai Kuis &rarr;</span>
          </a>

          <!-- Card 3: Live Coding -->
          <a
            href="playground.php"
            class="feature-card shadow-coding"
            data-aos="fade-up"
            data-aos-delay="300"
          >
            <div class="card-header">
              <i class="fas fa-code" style="color: #ff5722"></i>
              <h2>Live Coding</h2>
            </div>
            <p>
              Praktikkan kode langsung di browser dengan editor interaktif dan
              hasil real-time.
            </p>
            <span class="card-link" style="color: #ff5722"
              >Mulai Coding &rarr;</span
            >
          </a>

          <!-- Card 4: AI Quiz Generator -->
          <a
            href="ai_quiz.php"
            class="feature-card shadow-ai"
            data-aos="fade-up"
            data-aos-delay="400"
          >
            <div class="card-header">
              <i class="fas fa-robot" style="color: #9c27b0"></i>
              <h2>AI Quiz Generator</h2>
            </div>
            <p>Buat kuis otomatis dengan AI berdasarkan topik pilihan Anda.</p>
            <span class="card-link" style="color: #9c27b0"
              >Buat Kuis AI &rarr;</span
            >
          </a>

          <!-- Card 5: Video -->
          <a
            href="video.php"
            class="feature-card shadow-video"
            data-aos="fade-up"
            data-aos-delay="500"
          >
            <div class="card-header">
              <i class="fas fa-play-circle" style="color: #ff0000"></i>
              <h2>Video Tutorial</h2>
            </div>
            <p>Tonton pembelajaran visual agar materi lebih mudah dipahami.</p>
            <span class="card-link" style="color: #ff0000"
              >Tonton Video &rarr;</span
            >
          </a>

          <!-- Card 6: Forum -->
          <a
            href="forum.php"
            class="feature-card shadow-forum"
            data-aos="fade-up"
            data-aos-delay="600"
          >
            <div class="card-header">
              <i class="fas fa-comments" style="color: #9b59b6"></i>
              <h2>Forum Diskusi</h2>
            </div>
            <p>Tanyakan kesulitanmu dan berdiskusi dengan komunitas kami.</p>
            <span class="card-link" style="color: #9b59b6"
              >Gabung Diskusi &rarr;</span
            >
          </a>

          <!-- Card 7: Profil -->
          <a
            href="profile.php"
            class="feature-card shadow-profil"
            data-aos="fade-up"
            data-aos-delay="700"
          >
            <div class="card-header">
              <i class="fas fa-user-cog" style="color: #2ecc71"></i>
              <h2>Profil & Edit</h2>
            </div>
            <p>
              Atur foto profil, bio, dan lihat statistik belajar pribadi Anda.
            </p>
            <span class="card-link" style="color: #2ecc71"
              >Edit Profil &rarr;</span
            >
          </a>

          <!-- Card 8: Riwayat Nilai -->
          <a
            href="kuis.php#history-section"
            class="feature-card shadow-hasil"
            data-aos="fade-up"
            data-aos-delay="800"
          >
            <div class="card-header">
              <i class="fas fa-trophy icon-hasil"></i>
              <h2>Riwayat Nilai</h2>
            </div>
            <p>
              Lihat kembali skor dan statistik dari kuis yang telah Anda
              kerjakan.
            </p>
            <span class="card-link color-hasil">Lihat Riwayat &rarr;</span>
          </a>

          <!-- Card 9: Leaderboard -->
          <a
            href="leaderboard.php"
            class="feature-card shadow-hasil"
            data-aos="fade-up"
            data-aos-delay="900"
          >
            <div class="card-header">
              <i class="fas fa-medal" style="color: #ffc312"></i>
              <h2>Leaderboard</h2>
            </div>
            <p>Lihat peringkat siswa terbaik berdasarkan total skor kuis.</p>
            <span class="card-link" style="color: #ffc312"
              >Lihat Peringkat &rarr;</span
            >
          </a>
        </div>
      </main>
    </div>

    <footer>
      <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <!-- ================= AI CHATBOT UI ================= -->
    <div id="ai-chat-launcher" onclick="toggleAIChat()">
      <i class="fas fa-robot"></i>
    </div>

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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800, // Durasi animasi
        once: true, // Animasi hanya sekali saat scroll ke bawah
      });
    </script>

    <!-- Main Logic Script -->
    <script src="script.js"></script>
  </body>
</html>
