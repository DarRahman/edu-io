function getSwalThemeConfig() {
    const isDarkMode = document.documentElement.classList.contains('dark-mode');
    return {
        background: isDarkMode ? '#27273a' : '#fff',
        color: isDarkMode ? '#e0e0e0' : '#333',
    };
}

const publicPages = ['/login.html', '/register.html'];
const currentPage = window.location.pathname.endsWith('/') ? '/index.html' : window.location.pathname;
const loggedInUser = sessionStorage.getItem('loggedInUser');

if (!loggedInUser && !publicPages.includes(currentPage)) {
    window.location.href = '/login.html';
}


document.addEventListener("DOMContentLoaded", () => {

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
                const selectedAnswer = quizForm[radioName] ? Array.from(quizForm[radioName]).find(radio => radio.checked)?.value : null;
                if (selectedAnswer === correctAnswers[i - 1]) score++;
            }

            const finalScore = Math.round((score / correctAnswers.length) * 100);
            const currentUser = sessionStorage.getItem('loggedInUser');
            if (currentUser) {
                const allQuizScores = JSON.parse(localStorage.getItem('quizScores')) || {};
                if (!allQuizScores[currentUser]) allQuizScores[currentUser] = {};
                allQuizScores[currentUser][quizId] = finalScore;
                localStorage.setItem('quizScores', JSON.stringify(allQuizScores));
            }
            window.location.href = "/nilai.html";
        });
    }

    const user = sessionStorage.getItem('loggedInUser');
    const navLinks = document.querySelector('.nav-links');

    if (user && navLinks) {
        const welcomeElement = document.createElement('li');
        welcomeElement.className = 'nav-welcome-user';
        welcomeElement.innerHTML = `<span>Halo, ${user}</span>`;

        const logoutElement = document.createElement('li');
        logoutElement.innerHTML = '<a href="#" id="logout-btn">Logout</a>';

        const themeToggleElement = document.createElement('li');
        themeToggleElement.innerHTML = `<button class="theme-toggle-btn" id="theme-toggle-btn" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>`;

        navLinks.prepend(welcomeElement);
        navLinks.append(themeToggleElement);
        navLinks.append(logoutElement);

        const logoutButton = document.getElementById('logout-btn');
        logoutButton.addEventListener('click', (e) => {
            e.preventDefault();
            Swal.fire({
                ...getSwalThemeConfig(),
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A896',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.removeItem('loggedInUser');
                    window.location.href = '/login.html';
                }
            });
        });
    }

    const themeToggleButton = document.getElementById('theme-toggle-btn');
    const applyTheme = (theme) => {
        const themeIcon = themeToggleButton ? themeToggleButton.querySelector('i') : null;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark-mode');
            if (themeIcon) themeIcon.className = 'fas fa-sun';
        } else {
            document.documentElement.classList.remove('dark-mode');
            if (themeIcon) themeIcon.className = 'fas fa-moon';
        }
    };

    applyTheme(localStorage.getItem('theme') || 'light');

    if (themeToggleButton) {
        themeToggleButton.addEventListener('click', () => {
            const isDarkMode = document.documentElement.classList.contains('dark-mode');
            const newTheme = isDarkMode ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
});


const registerForm = document.getElementById('register-form');
if (registerForm) {
    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const username = document.getElementById('reg-username').value;
        const password = document.getElementById('reg-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (!username || !password || !confirmPassword) {
            Swal.fire({ ...getSwalThemeConfig(), icon: 'error', title: 'Oops...', text: 'Semua kolom wajib diisi!' });
            return;
        }
        if (password !== confirmPassword) {
            Swal.fire({ ...getSwalThemeConfig(), icon: 'error', title: 'Password Tidak Cocok', text: 'Pastikan password dan konfirmasi password Anda sama.' });
            return;
        }
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const userExists = users.find(user => user.username === username);
        if (userExists) {
            Swal.fire({ ...getSwalThemeConfig(), icon: 'warning', title: 'Username Sudah Digunakan', text: 'Silakan pilih username yang lain.' });
            return;
        }
        users.push({ username, password });
        localStorage.setItem('users', JSON.stringify(users));
        Swal.fire({
            ...getSwalThemeConfig(),
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: 'Akun Anda telah berhasil dibuat.',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/login.html';
        });
    });
}

const loginForm = document.getElementById('login-form');
if (loginForm) {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = passwordInput.value;

        if (!username || !password) {
            Swal.fire({ ...getSwalThemeConfig(), icon: 'warning', title: 'Input Tidak Lengkap', text: 'Harap masukkan username dan password Anda.' });
            return;
        }
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const foundUser = users.find(user => user.username === username && user.password === password);

        if (foundUser) {
            sessionStorage.setItem('loggedInUser', username);
            Swal.fire({
                ...getSwalThemeConfig(),
                icon: 'success',
                title: 'Login Berhasil!',
                text: `Selamat datang kembali, ${username}!`,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '/index.html';
            });
        } else {
            Swal.fire({ ...getSwalThemeConfig(), icon: 'error', title: 'Login Gagal', text: 'Username atau password yang Anda masukkan salah!' });
        }
    });

    if (togglePassword) {
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye-slash');
        });
    }
}