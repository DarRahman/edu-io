function getSwalThemeConfig() {
  const isDarkMode = document.documentElement.classList.contains("dark-mode");
  return {
    background: isDarkMode ? "#27273a" : "#fff",
    color: isDarkMode ? "#e0e0e0" : "#333",
  };
}

const publicPages = ["login.php", "register.php"];
const currentPage = window.location.pathname;
const loggedInUser = sessionStorage.getItem("loggedInUser");
const isPublicPage = publicPages.some((page) => currentPage.endsWith(page));

if (!loggedInUser && !isPublicPage) {
  window.location.href = "login.php";
}

document.addEventListener("DOMContentLoaded", () => {
  // Fitur Video Search (untuk video.html)
  if (
    document.body.classList.contains("video-page") ||
    window.location.pathname.endsWith("video.html")
  ) {
    const videos = [
      {
        title: "HTML Dasar untuk Pemula (Indonesia)",
        youtubeId: "UB1O30fR-EE",
        topic: "html",
      },
      {
        title: "Belajar HTML Lengkap - Web Programming UNPAS",
        youtubeId: "iR5itOM5xgE",
        topic: "html",
      },
      {
        title: "CSS Dasar untuk Pemula (Indonesia)",
        youtubeId: "yfoY53QXEnI",
        topic: "css",
      },
      {
        title: "Belajar CSS dari Nol - Web Programming UNPAS",
        youtubeId: "1Rs2ND1ryYc",
        topic: "css",
      },
      {
        title: "JavaScript Dasar untuk Pemula (Indonesia)",
        youtubeId: "W6NZfCO5SIk",
        topic: "javascript",
      },
      {
        title: "Belajar JavaScript Lengkap - Web Programming UNPAS",
        youtubeId: "RUTV_5m4VeI",
        topic: "javascript",
      },
    ];

    function renderVideos(filter = "") {
      const list = document.getElementById("video-list");
      if (!list) return;
      const keyword = filter.trim().toLowerCase();
      let filtered = videos;
      if (keyword) {
        filtered = videos.filter(
          (v) =>
            v.title.toLowerCase().includes(keyword) || v.topic.includes(keyword)
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
                    <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.08); margin-bottom:10px;">
                        <iframe src="https://www.youtube.com/embed/${v.youtubeId}" frameborder="0" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:10px;"></iframe>
                    </div>
                </div>
            `
        )
        .join("");
    }
    renderVideos();
    const searchInput = document.getElementById("video-search");
    if (searchInput) {
      searchInput.addEventListener("input", function (e) {
        renderVideos(e.target.value);
      });
    }
  }

  const quizForm = document.querySelector(".quiz-form");
  if (quizForm) {
    quizForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const quizId = quizForm.dataset.quizId;
      if (!quizId) return;

      const KUNCI_JAWABAN_SEMUA_KUIS = {
        "html-quiz": ["a", "b", "a", "b", "a", "b", "c", "c", "a", "c"],
        "css-quiz": ["b", "a", "c", "c", "c", "a", "b", "b", "a", "a"],
        "js-quiz": ["b", "c", "a", "a", "b", "c", "b", "a", "a", "b"],
      };

      const correctAnswers = KUNCI_JAWABAN_SEMUA_KUIS[quizId];
      if (!correctAnswers) return;

      let score = 0;
      for (let i = 1; i <= correctAnswers.length; i++) {
        const radioName = `q${i}`;
        const selectedAnswer = quizForm[radioName]
          ? Array.from(quizForm[radioName]).find((radio) => radio.checked)
              ?.value
          : null;
        if (selectedAnswer === correctAnswers[i - 1]) score++;
      }

      const finalScore = Math.round((score / correctAnswers.length) * 100);

      // --- PERBAIKAN PATH DI SINI ---
      // Jika kita di dalam folder Kuis, kita harus naik satu tingkat (../)
      const isSubfolder =
        window.location.pathname.includes("/Kuis/") ||
        window.location.pathname.includes("/Materi/");
      const targetUrl = isSubfolder
        ? "../simpan_nilai.php"
        : "simpan_nilai.php";
      const redirectUrl = isSubfolder ? "../nilai.php" : "nilai.php";

      const formData = new FormData();
      formData.append("quiz_id", quizId);
      formData.append("score", finalScore);

      fetch(targetUrl, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.trim() === "success") {
            window.location.href = redirectUrl;
          } else {
            Swal.fire({
              icon: "error",
              title: "Gagal Menyimpan",
              text: "Nilai gagal disimpan. Pastikan Anda sudah login di database.",
            }).then(() => {
              window.location.href = redirectUrl;
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          window.location.href = redirectUrl;
        });
    });
  }

  const user = sessionStorage.getItem("loggedInUser");
  const displayName = sessionStorage.getItem("displayName") || user; // TAMBAHKAN INI

  const navLinks = document.querySelector(".nav-links");

  if (user && navLinks) {
    const welcomeElement = document.createElement("li");
    welcomeElement.className = "nav-welcome-user";
    // UBAH ${user} MENJADI ${displayName}
    welcomeElement.innerHTML = `<a href="profile.php" class="nav-profile-link">Halo, ${displayName}</a>`;

    const logoutElement = document.createElement("li");
    logoutElement.innerHTML = '<a href="#" id="logout-btn">Logout</a>';

    const themeToggleElement = document.createElement("li");
    themeToggleElement.innerHTML = `<button class="theme-toggle-btn" id="theme-toggle-btn" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>`;

    navLinks.prepend(welcomeElement);
    navLinks.append(themeToggleElement);
    navLinks.append(logoutElement);

    const logoutButton = document.getElementById("logout-btn");
    logoutButton.addEventListener("click", (e) => {
      e.preventDefault();
      Swal.fire({
        ...getSwalThemeConfig(),
        title: "Konfirmasi Logout",
        text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#00A896",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Logout!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          sessionStorage.removeItem("loggedInUser");
          window.location.href = "login.php";
        }
      });
    });
  }

  const themeToggleButton = document.getElementById("theme-toggle-btn");
  const applyTheme = (theme) => {
    const themeIcon = themeToggleButton
      ? themeToggleButton.querySelector("i")
      : null;
    if (theme === "dark") {
      document.documentElement.classList.add("dark-mode");
      if (themeIcon) themeIcon.className = "fas fa-sun";
    } else {
      document.documentElement.classList.remove("dark-mode");
      if (themeIcon) themeIcon.className = "fas fa-moon";
    }
  };

  applyTheme(localStorage.getItem("theme") || "light");

  if (themeToggleButton) {
    themeToggleButton.addEventListener("click", () => {
      const isDarkMode =
        document.documentElement.classList.contains("dark-mode");
      const newTheme = isDarkMode ? "light" : "dark";
      applyTheme(newTheme);
      localStorage.setItem("theme", newTheme);
    });
  }
});
