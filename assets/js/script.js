/* =========================================
   1. GLOBAL HELPERS & CONFIG
   ========================================= */
function getSwalThemeConfig() {
  const isDarkMode = document.documentElement.classList.contains("dark-mode");
  return {
    background: isDarkMode ? "#27273a" : "#fff",
    color: isDarkMode ? "#e0e0e0" : "#333",
  };
}

// Menentukan Path Prefix (../)
const currentPage = window.location.pathname;
// Deteksi apakah kita berada di dalam subfolder (pages, auth, quiz, dll)
// Jika URL mengandung folder-folder ini, berarti kita butuh "../" untuk kembali ke root
const isInsideSubfolder = 
  currentPage.includes("/pages/") || 
  currentPage.includes("/auth/") || 
  currentPage.includes("/quiz/") || 
  currentPage.includes("/Materi/");

const pathPrefix = isInsideSubfolder ? "../" : "";

/* 
   2. REAL-TIME HEARTBEAT & NOTIFICATIONS
   ========================================= */
function startHeartbeat() {
  // Hanya jalankan jika user sudah login
  if (!sessionStorage.getItem("loggedInUser")) return;

  const performHeartbeat = () => {
    fetch(pathPrefix + "api/heartbeat.php")
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success' && data.notifications.length > 0) {
          let shouldReloadFriends = false;
          data.notifications.forEach(notif => {
            showToastNotification(notif);
            
            // Jika di halaman friends.php dan ada notif pertemanan, tandai untuk reload
            if (window.location.pathname.includes("friends.php")) {
              if (notif.type === 'friend_request' || notif.type === 'friend_accept') {
                shouldReloadFriends = true;
              }
            }
          });

          if (shouldReloadFriends) {
            setTimeout(() => location.reload(), 2000);
          }
        }
      })
      .catch(err => console.error("Heartbeat error:", err));
  };

  // Jalankan segera dan set interval setiap 5 detik
  performHeartbeat();
  setInterval(performHeartbeat, 5000);
}

function showToastNotification(notif) {
  const themes = getSwalThemeConfig();
  
  // Pilih icon berdasarkan tipe
  let icon = 'info';
  if (notif.type === 'friend_request') icon = 'user-plus';
  if (notif.type === 'friend_accept') icon = 'user-check';
  if (notif.type === 'forum_reply') icon = 'comment-dots';

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    background: themes.background,
    color: themes.color,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
      // Klik notifikasi untuk redirect? Opsional
      toast.addEventListener('click', () => {
        if (notif.link) window.location.href = pathPrefix + notif.link;
      });
    }
  });

  Toast.fire({
    icon: 'info', // SweetAlert2 default icons are limited, we use info but we can customize html
    title: `<div style="display:flex; align-items:center; gap:10px;">
              <i class="fas fa-${icon}"></i>
              <span>${notif.message}</span>
            </div>`
  });
}

// =========================================
// 3. MAIN LOGIC (AFTER DOM LOADED)
// =========================================
document.addEventListener("DOMContentLoaded", () => {
  // Start Heartbeat
  startHeartbeat();

  const loggedInUser = sessionStorage.getItem("loggedInUser");
  const isPublicPage = ["login.php", "register.php"].some((page) =>
    window.location.pathname.endsWith(page)
  );

  if (!loggedInUser && !isPublicPage) {
    window.location.replace(pathPrefix + "auth/login.php");
    return;
  }

  // --- HAMBURGER MENU LOGIC ---
  const navbar = document.querySelector(".navbar");
  if (navbar && !document.querySelector(".hamburger")) {
    const hamburger = document.createElement("div");
    hamburger.className = "hamburger";
    hamburger.innerHTML = '<i class="fas fa-bars"></i>';
    navbar.appendChild(hamburger);

    const navLinks = document.querySelector(".nav-links");
    hamburger.addEventListener("click", () => {
      navLinks.classList.toggle("active");
      // Toggle icon
      const icon = hamburger.querySelector("i");
      if (navLinks.classList.contains("active")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-times");
      } else {
        icon.classList.remove("fa-times");
        icon.classList.add("fa-bars");
      }
    });

    // Mobile Dropdown Logic
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach((dropdown) => {
      const dropbtn = dropdown.querySelector(".dropbtn");
      if (dropbtn) {
        dropbtn.addEventListener("click", (e) => {
          if (window.innerWidth <= 768) {
            e.preventDefault();
            dropdown.classList.toggle("active");
          }
        });
      }
    });
  }

  // --- A. ACTIVE MENU LOGIC (FIXED) ---
  // Dinonaktifkan karena sudah ditangani oleh PHP di navbar.php
  /*
  const navLinksList = document.querySelectorAll(".nav-links a");
  navLinksList.forEach((link) => {
    const linkHref = link.getAttribute("href");
    if (!linkHref || linkHref === "#") return;

    // Bersihkan path untuk perbandingan
    const cleanLink = linkHref.replace("../", "").replace("./", "");
    const cleanCurrent = currentPage.split("/").pop();

    if (cleanCurrent === cleanLink || currentPage.endsWith(linkHref)) {
      // Hapus class active dari elemen lain
      document
        .querySelectorAll(".active")
        .forEach((el) => el.classList.remove("active"));
      document
        .querySelectorAll(".active-item")
        .forEach((el) => el.classList.remove("active-item"));

      const parentDropdown = link.closest(".dropdown");
      if (parentDropdown) {
        link.classList.add("active-item");
        parentDropdown.classList.add("active");
      } else if (link.parentElement.tagName === "LI") {
        link.parentElement.classList.add("active");
      }
    }
  });
  */

  // --- B. FITUR VIDEO SEARCH ---
  if (
    document.body.classList.contains("video-page") ||
    currentPage.endsWith("video.php")
  ) {
    const videos = [
      {
        title: "HTML Dasar untuk Pemula",
        youtubeId: "UB1O30fR-EE",
        topic: "html",
      },
      {
        title: "Belajar HTML Lengkap - WPU",
        youtubeId: "pQN-pnXPaVg",
        topic: "html",
      },
      {
        title: "CSS Dasar untuk Pemula",
        youtubeId: "yfoY53QXEnI",
        topic: "css",
      },
      {
        title: "CSS Flexbox in 20 Minutes",
        youtubeId: "JJSoEo8JSnc",
        topic: "css",
      },
      {
        title: "JavaScript Dasar untuk Pemula",
        youtubeId: "W6NZfCO5SIk",
        topic: "javascript",
      },
      {
        title: "JavaScript DOM Manipulation",
        youtubeId: "0ik6X4DJKCc",
        topic: "javascript",
      },
    ];

    function renderVideos(filter = "") {
      const list = document.getElementById("video-list");
      if (!list) return;
      const keyword = filter.trim().toLowerCase();
      let filtered = keyword
        ? videos.filter(
            (v) =>
              v.title.toLowerCase().includes(keyword) ||
              v.topic.includes(keyword)
          )
        : videos;
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
                        <iframe src="https://www.youtube.com/embed/${v.youtubeId}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            `
        )
        .join("");
    }
    renderVideos();
    document
      .getElementById("video-search")
      ?.addEventListener("input", (e) => renderVideos(e.target.value));
  }

  // --- C. FITUR KUIS ---
  const quizForm = document.querySelector(".quiz-form");
  if (quizForm) {
    // Progress Bar Logic
    const progressFill = document.querySelector(".quiz-progress-fill");
    const totalQuestions = 10; // Asumsi 10 soal per kuis

    if (progressFill) {
      quizForm.addEventListener("change", () => {
        const answeredCount = quizForm.querySelectorAll(
          "input[type='radio']:checked"
        ).length;
        const progress = (answeredCount / totalQuestions) * 100;
        progressFill.style.width = `${progress}%`;
      });
    }

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
        if (quizForm[`q${i + 1}`]?.value === ans) score++;
      });
      const finalScore = Math.round(
        (score / KUNCI_JAWABAN[quizId].length) * 100
      );
      const formData = new FormData();
      formData.append("quiz_id", quizId);
      formData.append("score", finalScore);

      fetch(pathPrefix + "api/simpan_nilai.php", { method: "POST", body: formData })
        .then(
          () => (window.location.href = pathPrefix + "quiz/index.php#history-section")
        )
        .catch(
          () => (window.location.href = pathPrefix + "quiz/index.php#history-section")
        );
    });
  }

  // --- D. DINAMIS NAVBAR ---
  // --- D. DINAMIS NAVBAR ---
  const navLinks = document.querySelector(".nav-links");
  if (loggedInUser && navLinks) {
    const displayName = sessionStorage.getItem("displayName") || loggedInUser;

    const welcomeLi = document.createElement("li");
    welcomeLi.className = "nav-welcome-user";
    welcomeLi.innerHTML = `
    <a href="${pathPrefix}pages/profile.php" class="nav-profile-link">
      Halo, ${displayName}
    </a>`;

    const logoutLi = document.createElement("li");
    logoutLi.innerHTML = '<a href="#" id="logout-btn">Logout</a>';

    const themeLi = document.createElement("li");
    themeLi.innerHTML = `<button class="theme-toggle-btn" id="theme-toggle-btn">
       <i class="fas fa-moon"></i>
     </button>`;

    navLinks.prepend(welcomeLi);
    navLinks.append(themeLi);
    navLinks.append(logoutLi);

    document.addEventListener("click", (e) => {
      if (e.target.id === "logout-btn") {
        e.preventDefault();
        Swal.fire({
          ...getSwalThemeConfig(),
          title: "Konfirmasi Logout",
          text: "Apakah Anda yakin ingin logout?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Logout",
        }).then((result) => {
          if (result.isConfirmed) {
            sessionStorage.removeItem("loggedInUser");
            sessionStorage.removeItem("displayName");
            window.location.replace(pathPrefix + "auth/login.php");
          }
        });
      }
    });
  }
  // --- E. TEMA ---
  const themeBtn = document.getElementById("theme-toggle-btn");
  const applyTheme = (t) => {
    document.documentElement.classList.toggle("dark-mode", t === "dark");
    if (themeBtn)
      themeBtn.querySelector("i").className =
        t === "dark" ? "fas fa-sun" : "fas fa-moon";
  };
  applyTheme(localStorage.getItem("theme") || "light");
  themeBtn?.addEventListener("click", () => {
    const newT = document.documentElement.classList.contains("dark-mode")
      ? "light"
      : "dark";
    localStorage.setItem("theme", newT);
    applyTheme(newT);
  });

  // Support Enter Chatbot
  document.getElementById("ai-input")?.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendToAI();
  });
  // --- F. QUIZ PROGRESS BAR ---
  const quizInputs = document.querySelectorAll(".quiz-option-input");
  const progressBar = document.querySelector(".quiz-progress-fill");
  if (quizInputs.length > 0 && progressBar) {
    const totalQuestions = new Set(
      Array.from(quizInputs).map((input) => input.name)
    ).size;

    quizInputs.forEach((input) => {
      input.addEventListener("change", () => {
        const answeredCount = new Set(
          Array.from(
            document.querySelectorAll(".quiz-option-input:checked")
          ).map((i) => i.name)
        ).size;
        const percent = (answeredCount / totalQuestions) * 100;
        progressBar.style.width = percent + "%";
      });
    });
  }
});

/* =========================================
   4. AI CHATBOT FEATURES
   ========================================= */
let aiChatHistory = [];

function toggleAIChat() {
  const chatWindow = document.getElementById("ai-chat-window");
  if (!chatWindow) return;
  const currentDisplay = window.getComputedStyle(chatWindow).display;
  chatWindow.style.display = currentDisplay === "none" ? "flex" : "none";
}

function copyCode(btn) {
  const pre = btn.parentElement;
  const code = pre.querySelector("code").innerText;
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

async function typeEffect(element, rawText) {
  element.classList.add("typing-cursor");
  let i = 0;
  let currentText = "";
  const speed = 10;
  return new Promise((resolve) => {
    const interval = setInterval(() => {
      if (i < rawText.length) {
        currentText += rawText.charAt(i);
        element.innerHTML = marked.parse(currentText);
        element.querySelectorAll("pre").forEach((pre) => {
          if (!pre.querySelector(".copy-btn")) {
            pre.innerHTML += `<button class="copy-btn" onclick="copyCode(this)">Copy</button>`;
          }
        });
        i++;
        const chatBody = document.getElementById("ai-chat-body");
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
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
  chatBody.scrollTop = chatBody.scrollHeight;

  try {
    const response = await fetch(pathPrefix + "api/ai_process.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ history: aiChatHistory, name: userName }),
    });
    const data = await response.json();
    const botDiv = document.getElementById(loadingId);
    await typeEffect(botDiv, data.reply);
    aiChatHistory.push({ role: "model", parts: [{ text: data.reply }] });
  } catch (error) {
    document.getElementById(loadingId).innerText =
      "Ups! Gagal tersambung ke server.";
  }
}

/* =========================================
   5. VISITOR STATS (REMOVED)
   ========================================= */
// Stats logic removed as per request

// --- E. SISTEM UNDANGAN MABAR ---
function checkInvites() {
  if (!sessionStorage.getItem("loggedInUser")) return;

  fetch(pathPrefix + "api/api_invite.php?action=check_invites")
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "found") {
        const invite = data.data;
        const swalConfig = getSwalThemeConfig();

        Swal.fire({
          title: "Undangan Mabar!",
          text: `${invite.sender} mengundang kamu ke Room ${invite.room_code}`,
          icon: "question",
          showCancelButton: true,
          confirmButtonText: "Terima",
          cancelButtonText: "Tolak",
          background: swalConfig.background,
          color: swalConfig.color,
        }).then((result) => {
          const formData = new FormData();
          formData.append("invite_id", invite.id);

          if (result.isConfirmed) {
            formData.append("response", "accepted");
            fetch(pathPrefix + "api/api_invite.php?action=respond_invite", {
              method: "POST",
              body: formData,
            }).then(() => {
              // Redirect ke Join Room Otomatis
              window.location.href =
                pathPrefix + "quiz/multiplayer_join.php?auto_join=" + invite.room_code;
            });
          } else {
            formData.append("response", "rejected");
            fetch(pathPrefix + "api/api_invite.php?action=respond_invite", {
              method: "POST",
              body: formData,
            });
          }
        });
      }
    });
}

// Cek undangan setiap 5 detik
setInterval(checkInvites, 5000);
