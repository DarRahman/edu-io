<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Video Tutorial - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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

    <div class="container">
      <h1 class="page-title">Video Tutorial HTML, CSS, & JavaScript</h1>
      <main>
        <div style="text-align: center; margin-bottom: 2em">
          <input
            type="text"
            id="video-search"
            placeholder="Cari video..."
            class="input-group"
            style="
              width: 60%;
              max-width: 400px;
              padding: 10px;
              border-radius: 8px;
              border: 1px solid var(--border-color);
              font-size: 1em;
            "
          />
        </div>
        <div id="video-list" class="materi-grid"></div>
      </main>
    </div>
    <footer>
      <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <div id="ai-chat-launcher" onclick="toggleAIChat()">
      <i class="fas fa-robot"></i>
    </div>

    <!-- Jendela Chat AI -->
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

    <script src="script.js"></script>
    <script>
      // Daftar video (bisa ditambah sesuai kebutuhan)
      const videos = [
        // ===== HTML =====
        {
          title: "HTML Tutorial for Beginners",
          youtubeId: "UB1O30fR-EE",
          topic: "html",
        },
        {
          title: "HTML Full Course - freeCodeCamp",
          youtubeId: "pQN-pnXPaVg",
          topic: "html",
        },
        {
          title: "Semantic HTML Explained",
          youtubeId: "kX3TfdUqpuU",
          topic: "html",
        },
        // ===== CSS =====
        {
          title: "CSS Tutorial for Beginners",
          youtubeId: "yfoY53QXEnI",
          topic: "css",
        },
        {
          title: "CSS Full Course - freeCodeCamp",
          youtubeId: "OXGznpKZ_sA",
          topic: "css",
        },
        {
          title: "CSS Flexbox in 20 Minutes",
          youtubeId: "JJSoEo8JSnc",
          topic: "css",
        },
        {
          title: "Responsive Web Design CSS",
          youtubeId: "srvUrASNj0s",
          topic: "css",
        },
        {
          title: "CSS Box Model Explained",
          youtubeId: "rIO5326FgPE",
          topic: "css",
        },
        // ===== JAVASCRIPT =====
        {
          title: "JavaScript Tutorial for Beginners",
          youtubeId: "W6NZfCO5SIk",
          topic: "javascript",
        },
        {
          title: "JavaScript Full Course - freeCodeCamp",
          youtubeId: "PkZNo7MFNFg",
          topic: "javascript",
        },
        {
          title: "JavaScript DOM Manipulation",
          youtubeId: "0ik6X4DJKCc",
          topic: "javascript",
        },
        {
          title: "JavaScript Event Listeners",
          youtubeId: "y17RuWkWdn8",
          topic: "javascript",
        },
        {
          title: "JavaScript Async Await",
          youtubeId: "V_Kr9OSfDeU",
          topic: "javascript",
        },
        {
          title: "JavaScript Local Storage",
          youtubeId: "AUOzvFzdIk4",
          topic: "javascript",
        },
        {
          title: "JavaScript Functions Explained",
          youtubeId: "xUI5Tsl2JpY",
          topic: "javascript",
        },
        {
          title: "JavaScript Arrays Tutorial",
          youtubeId: "oigfaZ5ApsM",
          topic: "javascript",
        },
        {
          title: "JavaScript Objects Tutorial",
          youtubeId: "PFmuCDHHpwk",
          topic: "javascript",
        },
      ];

      function renderVideos(filter = "") {
        const list = document.getElementById("video-list");
        const keyword = filter.trim().toLowerCase();
        let filtered = videos;
        if (keyword) {
          filtered = videos.filter(
            (v) =>
              v.title.toLowerCase().includes(keyword) ||
              v.topic.includes(keyword)
          );
        }
        if (filtered.length === 0) {
          list.innerHTML = `<div style='text-align:center; color:var(--text-secondary);'>Video tidak ditemukan.</div>`;
          return;
        }
        list.innerHTML = filtered
          .map(
            (v) => `
            <div class="materi-card" style="max-width:350px; margin:auto;">
                <div class="materi-card-header">
                    <i class="fab fa-youtube" style="color:#FF0000;"></i>
                    <h3 style="font-size:1.1em;">${v.title}</h3>
                </div>
                <div class="video-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/${v.youtubeId}"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        `
          )
          .join("");
      }
      document.addEventListener("DOMContentLoaded", function () {
        renderVideos();
        document
          .getElementById("video-search")
          .addEventListener("input", function (e) {
            renderVideos(e.target.value);
          });
      });
    </script>
  </body>
</html>
