<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Quiz Generator - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');
    </script>
    <style>
        /* Style Khusus Halaman Ini */
        .quiz-generator-box {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .generated-quiz {
            display: none;
            /* Sembunyi sebelum digenerate */
            text-align: left;
            margin-top: 30px;
        }

        .quiz-item {
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .quiz-options label {
            display: block;
            padding: 10px;
            border: 1px solid var(--border-color);
            margin-top: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s;
        }

        .quiz-options label:hover {
            background: var(--bg-secondary);
            border-color: var(--accent-teal);
        }

        .quiz-options input {
            margin-right: 10px;
        }

        /* Loading Animation */
        .loader {
            display: none;
            border: 5px solid var(--bg-secondary);
            border-top: 5px solid var(--accent-teal);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Standar -->
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo" class="logo-img" /></a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li class="dropdown active">
                <a href="#" class="dropbtn">Belajar <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="materi.html"><i class="fas fa-book"></i> Materi Teks</a>
                    <a href="video.html"><i class="fas fa-play-circle"></i> Video Tutorial</a>
                    <!-- Link ini otomatis aktif karena href-nya cocok dengan nama file -->
                    <a href="playground.php"><i class="fas fa-code"></i> Live Coding</a>
                </div>
            </li>
            <li class="dropdown active">
                <a href="#" class="dropbtn">Kuis <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="kuis.php"><i class="fas fa-clipboard-check"></i> Pilih Kuis</a>
                    <a href="ai_quiz.php"><i class="fas fa-robot"></i> AI Quiz Generator</a>
                    <a href="leaderboard.php"><i class="fas fa-trophy"></i> Leaderboard</a>
                </div>
            </li>
            <li><a href="forum.php">Forum</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="quiz-generator-box">
            <h1 class="page-title"><i class="fas fa-robot"></i> AI Quiz Generator</h1>
            <p>Masukkan topik apa saja, AI akan membuatkan soal latihan untukmu!</p>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <input type="text" id="topicInput" class="input-group"
                    placeholder="Contoh: CSS Flexbox, Sejarah Indonesia, Python..."
                    style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color);">
                <button onclick="generateQuiz()" class="btn" style="margin:0;">Buat Soal</button>
            </div>

            <div id="loader" class="loader"></div>
        </div>

        <!-- Wadah Soal -->
        <div id="quizContainer" class="generated-quiz">
            <h2 id="quizTitle" style="text-align: center; margin-bottom: 20px;"></h2>
            <div id="questionsList"></div>
            <button onclick="checkAnswers()" class="btn" style="width: 100%;">Cek Nilai</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
    <script src="script.js"></script>

    <script>
        let currentQuestions = []; // Simpan kunci jawaban di sini

        async function generateQuiz() {
            const topic = document.getElementById('topicInput').value.trim();
            if (!topic) return Swal.fire('Error', 'Masukkan topik dulu!', 'warning');

            // UI Loading
            document.getElementById('loader').style.display = 'block';
            document.getElementById('quizContainer').style.display = 'none';

            try {
                const res = await fetch('ai_quiz_process.php', {
                    method: 'POST',
                    body: JSON.stringify({ topic: topic })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    renderQuiz(data);
                } else {
                    Swal.fire('Ups!', data.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Gagal terhubung ke AI.', 'error');
                console.error(error);
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function renderQuiz(data) {
            currentQuestions = data.questions; // Simpan data untuk pengecekan nanti
            const container = document.getElementById('questionsList');
            document.getElementById('quizTitle').innerText = "Topik: " + data.topic;
            container.innerHTML = '';

            data.questions.forEach((q, index) => {
                let optionsHtml = '';
                q.options.forEach((opt, optIndex) => {
                    optionsHtml += `
                        <label>
                            <input type="radio" name="q${index}" value="${optIndex}">
                            ${opt}
                        </label>
                    `;
                });

                container.innerHTML += `
                    <div class="quiz-item">
                        <p style="font-weight:bold; font-size:1.1em;">${index + 1}. ${q.q}</p>
                        <div class="quiz-options">${optionsHtml}</div>
                    </div>
                `;
            });

            document.getElementById('quizContainer').style.display = 'block';
        }

        function checkAnswers() {
            let score = 0;
            let total = currentQuestions.length;

            currentQuestions.forEach((q, index) => {
                const selected = document.querySelector(`input[name="q${index}"]:checked`);
                if (selected && parseInt(selected.value) === q.correct) {
                    score++;
                }
            });

            const finalScore = Math.round((score / total) * 100);

            let pesan = finalScore >= 80 ? "Hebat!" : "Belajar lagi ya!";
            Swal.fire({
                title: `Nilai Kamu: ${finalScore}`,
                text: `${pesan} (Benar ${score} dari ${total} soal)`,
                icon: finalScore >= 60 ? 'success' : 'warning'
            });
        }
    </script>
</body>

</html>