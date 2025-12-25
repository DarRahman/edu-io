function getSwalThemeConfig() {
  const isDarkMode = document.documentElement.classList.contains("dark-mode");
  return {
    background: isDarkMode ? "#27273a" : "#fff",
    color: isDarkMode ? "#e0e0e0" : "#333",
  };
}

// --- LOGIKA PATH UNTUK SUB-FOLDER ---
const currentPage = window.location.pathname;
const isInsideSubfolder = currentPage.includes('/Materi/') || currentPage.includes('/Kuis/');
const pathPrefix = isInsideSubfolder ? '../' : '';

const publicPages = ["login.php", "register.php"];
const loggedInUser = sessionStorage.getItem("loggedInUser");
const displayName = sessionStorage.getItem("displayName") || loggedInUser;
const isPublicPage = publicPages.some((page) => currentPage.endsWith(page));

// Proteksi Halaman
if (!loggedInUser && !isPublicPage) {
  window.location.href = pathPrefix + "login.php";
}

document.addEventListener("DOMContentLoaded", () => {
  // --- FITUR VIDEO SEARCH ---
  if (document.body.classList.contains("video-page") || currentPage.endsWith("video.html")) {
    const videos = [
     // ===== HTML =====
      { title: "HTML Tutorial for Beginners", youtubeId: "UB1O30fR-EE", topic: "html" },
      { title: "HTML Full Course - freeCodeCamp", youtubeId: "pQN-pnXPaVg", topic: "html" },
      { title: "Semantic HTML Explained", youtubeId: "kX3TfdUqpuU", topic: "html" },
      // ===== CSS =====
      { title: "CSS Tutorial for Beginners", youtubeId: "yfoY53QXEnI", topic: "css" },
      { title: "CSS Full Course - freeCodeCamp", youtubeId: "OXGznpKZ_sA", topic: "css" },
      { title: "CSS Flexbox in 20 Minutes", youtubeId: "JJSoEo8JSnc", topic: "css" },
      { title: "Responsive Web Design CSS", youtubeId: "srvUrASNj0s", topic: "css" },
      { title: "CSS Box Model Explained", youtubeId: "rIO5326FgPE", topic: "css" },
      // ===== JAVASCRIPT =====
      { title: "JavaScript Tutorial for Beginners", youtubeId: "W6NZfCO5SIk", topic: "javascript" },
      { title: "JavaScript Full Course - freeCodeCamp", youtubeId: "PkZNo7MFNFg", topic: "javascript" },
      { title: "JavaScript DOM Manipulation", youtubeId: "0ik6X4DJKCc", topic: "javascript" },
      { title: "JavaScript Event Listeners", youtubeId: "y17RuWkWdn8", topic: "javascript" },
      { title: "JavaScript Async Await", youtubeId: "V_Kr9OSfDeU", topic: "javascript" },
      { title: "JavaScript Local Storage", youtubeId: "AUOzvFzdIk4", topic: "javascript" },
      { title: "JavaScript Functions Explained", youtubeId: "xUI5Tsl2JpY", topic: "javascript" },
      { title: "JavaScript Arrays Tutorial", youtubeId: "oigfaZ5ApsM", topic: "javascript" },
      { title: "JavaScript Objects Tutorial", youtubeId: "PFmuCDHHpwk", topic: "javascript" }
    ];

    function renderVideos(filter = "") {
      const list = document.getElementById("video-list");
      if (!list) return;
      const keyword = filter.trim().toLowerCase();
      let filtered = keyword ? videos.filter(v => v.title.toLowerCase().includes(keyword) || v.topic.includes(keyword)) : videos;
      
      if (filtered.length === 0) {
        list.innerHTML = `<div style='text-align:center; color:var(--text-secondary);'>Video tidak ditemukan.</div>`;
        return;
      }
      list.innerHTML = filtered.map(v => `
        <div class="materi-card" style="max-width:350px; margin:auto;">
            <div class="materi-card-header">
                <i class="fab fa-youtube" style="color:#FF0000;"></i>
                <h3 style="font-size:1.1em;">${v.title}</h3>
            </div>
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.08); margin-bottom:10px;">
                <iframe src="https://www.youtube.com/embed/${v.youtubeId}" frameborder="0" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:10px;"></iframe>
            </div>
        </div>
      `).join("");
    }
    renderVideos();
    document.getElementById("video-search")?.addEventListener("input", (e) => renderVideos(e.target.value));
  }

  // --- FITUR KUIS ---
  const quizForm = document.querySelector(".quiz-form");
  if (quizForm) {
    quizForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const quizId = quizForm.dataset.quizId;
      const KUNCI_JAWABAN = {
        "html-quiz": ["a", "b", "a", "b", "a", "b", "c", "c", "a", "c"],
        "css-quiz": ["b", "a", "c", "c", "c", "a", "b", "b", "a", "a"],
        "js-quiz": ["b", "c", "a", "a", "b", "c", "b", "a", "a", "b"],
      };

      let score = 0;
      KUNCI_JAWABAN[quizId].forEach((ans, i) => {
        if (quizForm[`q${i+1}`]?.value === ans) score++;
      });

      const finalScore = Math.round((score / KUNCI_JAWABAN[quizId].length) * 100);
      const formData = new FormData();
      formData.append("quiz_id", quizId);
      formData.append("score", finalScore);

      fetch(pathPrefix + "simpan_nilai.php", { method: "POST", body: formData })
        .then(() => window.location.href = pathPrefix + "kuis.php#history-section")
        .catch(() => window.location.href = pathPrefix + "kuis.php#history-section");
    });
  }

  // --- DINAMIS NAVBAR (HALO, DARK MODE, LOGOUT) ---
  const navLinks = document.querySelector(".nav-links");
  if (loggedInUser && navLinks) {
    const welcomeLi = document.createElement("li");
    welcomeLi.className = "nav-welcome-user";
    welcomeLi.innerHTML = `<a href="${pathPrefix}profile.php" class="nav-profile-link">Halo, ${displayName}</a>`;

    const logoutLi = document.createElement("li");
    logoutLi.innerHTML = '<a href="#" id="logout-btn">Logout</a>';

    const themeLi = document.createElement("li");
    themeLi.innerHTML = `<button class="theme-toggle-btn" id="theme-toggle-btn"><i class="fas fa-moon"></i></button>`;

    navLinks.prepend(welcomeLi);
    navLinks.append(themeLi);
    navLinks.append(logoutLi);

    document.getElementById("logout-btn").addEventListener("click", (e) => {
      e.preventDefault();
      Swal.fire({
        ...getSwalThemeConfig(),
        title: "Konfirmasi Logout",
        text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#00A896",
        confirmButtonText: "Ya, Logout!",
      }).then((result) => {
        if (result.isConfirmed) {
          sessionStorage.clear();
          window.location.href = pathPrefix + "login.php";
        }
      });
    });
  }

  // --- TEMA ---
  const themeBtn = document.getElementById("theme-toggle-btn");
  const applyTheme = (t) => {
    document.documentElement.classList.toggle("dark-mode", t === "dark");
    if (themeBtn) themeBtn.querySelector("i").className = t === "dark" ? "fas fa-sun" : "fas fa-moon";
  };
  applyTheme(localStorage.getItem("theme") || "light");
  themeBtn?.addEventListener("click", () => {
    const newT = document.documentElement.classList.contains("dark-mode") ? "light" : "dark";
    localStorage.setItem("theme", newT);
    applyTheme(newT);
  });
});

// --- FITUR CHATBOT AI V2 (TYPING & COPY) ---
let aiChatHistory = [];

function toggleAIChat() {
  const chatWindow = document.getElementById("ai-chat-window");
  if (!chatWindow) return;
  const currentDisplay = window.getComputedStyle(chatWindow).display;
  chatWindow.style.display = currentDisplay === "none" ? "flex" : "none";
}

// Fungsi untuk menyalin kode ke clipboard
function copyCode(btn) {
    const pre = btn.parentElement;
    const code = pre.querySelector('code').innerText;
    
    navigator.clipboard.writeText(code).then(() => {
        const originalText = btn.innerText;
        btn.innerText = "Copied!";
        btn.style.background = "#2ecc71";
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.background = "";
        }, 2000);
    });
}

// Fungsi Efek Mengetik
async function typeEffect(element, rawText) {
    element.classList.add("typing-cursor");
    let i = 0;
    let currentText = "";
    
    // Kecepatan mengetik (ms)
    const speed = 15; 

    return new Promise((resolve) => {
        const interval = setInterval(() => {
            if (i < rawText.length) {
                currentText += rawText.charAt(i);
                // Render markdown secara realtime sambil mengetik
                element.innerHTML = marked.parse(currentText);
                
                // Tambahkan tombol copy ke setiap blok 'pre' yang baru muncul
                const preBlocks = element.querySelectorAll('pre');
                preBlocks.forEach(pre => {
                    if (!pre.querySelector('.copy-btn')) {
                        pre.innerHTML += `<button class="copy-btn" onclick="copyCode(this)">Copy</button>`;
                    }
                });

                i++;
                const chatBody = document.getElementById("ai-chat-body");
                chatBody.scrollTop = chatBody.scrollHeight;
            } else {
                clearInterval(interval);
                element.classList.remove("typing-cursor");
                resolve();
            }
        }, speed);
    });
}

async function sendToAI() {
  const input = document.getElementById("ai-input");
  const chatBody = document.getElementById("ai-chat-body");
  const message = input.value.trim();
  const userName = sessionStorage.getItem("displayName") || "Siswa";

  if (!message) return;

  chatBody.innerHTML += `<div class="ai-message user">${message}</div>`;
  input.value = "";
  chatBody.scrollTop = chatBody.scrollHeight;

  aiChatHistory.push({ role: "user", parts: [{ text: message }] });

  const loadingId = "ai-loading-" + Date.now();
  chatBody.innerHTML += `<div class="ai-message bot" id="${loadingId}">...</div>`;

  try {
    const response = await fetch("ai_process.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ history: aiChatHistory, name: userName }),
    });

    const data = await response.json();
    const botDiv = document.getElementById(loadingId);
    
    // Jalankan efek mengetik
    await typeEffect(botDiv, data.reply);

    aiChatHistory.push({ role: "model", parts: [{ text: data.reply }] });
  } catch (error) {
    document.getElementById(loadingId).innerText = "Ups! Gagal tersambung ke server.";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("ai-input")?.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendToAI();
  });
});