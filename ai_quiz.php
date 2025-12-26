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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom override for AI input area */
        .ai-input-section {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 10px 30px var(--shadow-color);
        }
    </style>
</head>

<body>
    <!-- Navbar Standar -->
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo" class="logo-img" /></a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Belajar <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="materi.html"><i class="fas fa-book"></i> Materi Teks</a>
                    <a href="video.html"><i class="fas fa-play-circle"></i> Video Tutorial</a>
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
        <div class="quiz-header">
            <h1 class="page-title"><i class="fas fa-robot"></i> AI Quiz Generator</h1>
            <p style="color: var(--text-secondary);">Masukkan topik apa saja, AI akan membuatkan soal latihan untukmu!</p>
        </div>

        <div class="ai-input-section">
            <div style="display: flex; gap: 15px; max-width: 600px; margin: 0 auto;">
                <input type="text" id="topicInput" class="input-group"
                    placeholder="Contoh: CSS Flexbox, Sejarah Indonesia, Python..."
                    style="flex: 1; padding: 15px; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);">
                <button onclick="generateQuiz()" class="btn" style="margin:0; white-space: nowrap;">
                    <i class="fas fa-magic"></i> Buat Soal
                </button>
            </div>
            <div id="loader" class="loader"></div>
        </div>

        <!-- Wadah Soal -->
        <div id="quizContainer" class="generated-quiz" style="display: none;">
            
            <!-- Progress Bar -->
            <div class="quiz-progress-container" style="margin-bottom: 30px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span class="quiz-progress-text" id="progressText"><i class="fas fa-tasks"></i> 0 Soal</span>
                    <span style="font-size: 0.9em; color: var(--text-secondary);">Semangat! 🔥</span>
                </div>
                <div class="quiz-progress-bar">
                    <div class="quiz-progress-fill" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <h2 id="quizTitle" style="text-align: center; margin-bottom: 30px; color: var(--accent-teal);"></h2>
            
            <div id="questionsList"></div>
            
            <button onclick="checkAnswers()" class="btn-submit-quiz">
                <i class="fas fa-check-circle"></i> Cek Nilai
            </button>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>
    <script src="script.js"></script>

    <script>
        let currentQuestions = []; 

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
            currentQuestions = data.questions; 
            const container = document.getElementById('questionsList');
            document.getElementById('quizTitle').innerText = "Topik: " + data.topic;
            document.getElementById('progressText').innerHTML = `<i class="fas fa-tasks"></i> ${data.questions.length} Soal`;
            
            container.innerHTML = '';

            const markers = ['A', 'B', 'C', 'D', 'E'];

            data.questions.forEach((q, index) => {
                let optionsHtml = '';
                q.options.forEach((opt, optIndex) => {
                    const marker = markers[optIndex] || '?';
                    optionsHtml += `
                        <label class="quiz-option-label">
                            <input type="radio" name="q${index}" value="${optIndex}" class="quiz-option-input" onchange="updateProgress()">
                            <div class="quiz-option-content">
                                <span class="quiz-option-marker">${marker}</span>
                                <span class="quiz-option-text">${opt}</span>
                            </div>
                        </label>
                    `;
                });

                container.innerHTML += `
                    <div class="quiz-question-card">
                        <p class="quiz-question-text">${index + 1}. ${q.q}</p>
                        <div class="quiz-options-grid">${optionsHtml}</div>
                    </div>
                `;
            });

            document.getElementById('quizContainer').style.display = 'block';
            updateProgress(); // Reset progress bar
        }

        function updateProgress() {
            const total = currentQuestions.length;
            const answered = document.querySelectorAll('.quiz-option-input:checked').length;
            const percent = (answered / total) * 100;
            document.getElementById('progressBar').style.width = `${percent}%`;
        }

        function checkAnswers() {
            let score = 0;
            let total = currentQuestions.length;

            currentQuestions.forEach((q, index) => {
                const selected = document.querySelector(`input[name="q${index}"]:checked`);
                const card = document.querySelectorAll('.quiz-question-card')[index];
                
                // Reset styles
                card.style.borderColor = 'var(--glass-border)';
                
                if (selected) {
                    const val = parseInt(selected.value);
                    if (val === q.correct) {
                        score++;
                        // Highlight correct card
                        card.style.borderColor = 'var(--accent-teal)';
                    } else {
                        // Highlight incorrect card
                        card.style.borderColor = '#e74c3c';
                    }
                }
            });

            const finalScore = Math.round((score / total) * 100);

            let pesan = finalScore >= 80 ? "Hebat!" : "Belajar lagi ya!";
            Swal.fire({
                title: `Nilai Kamu: ${finalScore}`,
                text: `${pesan} (Benar ${score} dari ${total} soal)`,
                icon: finalScore >= 60 ? 'success' : 'warning',
                background: document.documentElement.classList.contains('dark-mode') ? '#27273a' : '#fff',
                color: document.documentElement.classList.contains('dark-mode') ? '#fff' : '#333'
            });
        }
    </script>
</body>

</html>