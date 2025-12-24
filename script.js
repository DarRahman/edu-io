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
      { title: "HTML Dasar untuk Pemula (Indonesia)", youtubeId: "UB1O30fR-EE", topic: "html" },
      { title: "Belajar HTML Lengkap - Web Programming UNPAS", youtubeId: "iR5itOM5xgE", topic: "html" },
      { title: "CSS Dasar untuk Pemula (Indonesia)", youtubeId: "yfoY53QXEnI", topic: "css" },
      { title: "Belajar CSS dari Nol - Web Programming UNPAS", youtubeId: "1Rs2ND1ryYc", topic: "css" },
      { title: "JavaScript Dasar untuk Pemula (Indonesia)", youtubeId: "W6NZfCO5SIk", topic: "javascript" },
      { title: "Belajar JavaScript Lengkap - Web Programming UNPAS", youtubeId: "RUTV_5m4VeI", topic: "javascript" }
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
        .then(() => window.location.href = pathPrefix + "nilai.php")
        .catch(() => window.location.href = pathPrefix + "nilai.php");
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