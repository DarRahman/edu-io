function getSwalThemeConfig() {
  const isDarkMode = document.documentElement.classList.contains("dark-mode");
  return {
    background: isDarkMode ? "#27273a" : "#fff",
    color: isDarkMode ? "#e0e0e0" : "#333",
  };
}

const publicPages = ["login.html", "register.html"];
const currentPage = window.location.pathname;
const loggedInUser = sessionStorage.getItem("loggedInUser");
const isPublicPage = publicPages.some((page) => currentPage.endsWith(page));

if (!loggedInUser && !isPublicPage) {
  window.location.href = "login.html";
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
      const currentUser = sessionStorage.getItem("loggedInUser");
      if (currentUser) {
        const allQuizScores =
          JSON.parse(localStorage.getItem("quizScores")) || {};
        if (!allQuizScores[currentUser]) allQuizScores[currentUser] = {};
        allQuizScores[currentUser][quizId] = finalScore;
        localStorage.setItem("quizScores", JSON.stringify(allQuizScores));
      }
      window.location.href = "nilai.html";
    });
  }

  const user = sessionStorage.getItem("loggedInUser");
  const navLinks = document.querySelector(".nav-links");

  if (user && navLinks) {
    const welcomeElement = document.createElement("li");
    welcomeElement.className = "nav-welcome-user";
    welcomeElement.innerHTML = `<span>Halo, ${user}</span>`;

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
          window.location.href = "login.html";
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

const registerForm = document.getElementById("register-form");
if (registerForm) {
  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const username = document.getElementById("reg-username").value;
    const password = document.getElementById("reg-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    if (!username || !password || !confirmPassword) {
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "error",
        title: "Oops...",
        text: "Semua kolom wajib diisi!",
      });
      return;
    }
    if (password !== confirmPassword) {
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "error",
        title: "Password Tidak Cocok",
        text: "Pastikan password dan konfirmasi password Anda sama.",
      });
      return;
    }
    const users = JSON.parse(localStorage.getItem("users")) || [];
    const userExists = users.find((user) => user.username === username);
    if (userExists) {
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "warning",
        title: "Username Sudah Digunakan",
        text: "Silakan pilih username yang lain.",
      });
      return;
    }
    users.push({ username, password });
    localStorage.setItem("users", JSON.stringify(users));
    Swal.fire({
      ...getSwalThemeConfig(),
      icon: "success",
      title: "Registrasi Berhasil!",
      text: "Akun Anda telah berhasil dibuat.",
      timer: 2500,
      timerProgressBar: true,
      showConfirmButton: false,
    }).then(() => {
      window.location.href = "login.html";
    });
  });
}

const loginForm = document.getElementById("login-form");
if (loginForm) {
  const passwordInput = document.getElementById("password");
  const togglePassword = document.getElementById("togglePassword");

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const username = document.getElementById("username").value;
    const password = passwordInput.value;

    if (!username || !password) {
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "warning",
        title: "Input Tidak Lengkap",
        text: "Harap masukkan username dan password Anda.",
      });
      return;
    }
    const users = JSON.parse(localStorage.getItem("users")) || [];
    const foundUser = users.find(
      (user) => user.username === username && user.password === password
    );

    if (foundUser) {
      sessionStorage.setItem("loggedInUser", username);
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "success",
        title: "Login Berhasil!",
        text: `Selamat datang kembali, ${username}!`,
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
      }).then(() => {
        window.location.href = "index.html";
      });
    } else {
      Swal.fire({
        ...getSwalThemeConfig(),
        icon: "error",
        title: "Login Gagal",
        text: "Username atau password yang Anda masukkan salah!",
      });
    }
  });

  if (togglePassword) {
    togglePassword.addEventListener("click", () => {
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      togglePassword.classList.toggle("fa-eye-slash");
    });
  }
}
