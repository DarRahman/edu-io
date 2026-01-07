<?php
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>AI Materi Generator - edu.io</title>
    <link rel="icon" type="image/png" href="../favicon.png" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/css/ai_materi.css">
</head>
<body>
    <?php $path = "../"; include '../includes/navbar.php'; ?>

    <div class="materi-gen-wrapper">
        <div class="gen-input-section">
            <span class="ai-badge">SMART AI GENERATOR</span>
            <h1><i class="fas fa-brain"></i> AI Materi Generator</h1>
            <p>Tuliskan topik apa pun tentang Web Development, dan AI akan merangkum materi terbaik untuk Anda.</p>
            
            <div class="gen-input-group">
                <input type="text" id="topicInput" placeholder="Contoh: CSS Grid, JavaScript Promises, PHP OOP..." class="gen-input">
                <button onclick="generateMateri()" id="genBtn" class="gen-btn">
                    <i class="fas fa-magic"></i> Buat Materi
                </button>
            </div>
            <div id="loader" class="loader-spinner"></div>
        </div>

        <div id="resultArea" class="materi-result-container">
            <div class="empty-state">
                <i class="fas fa-file-alt" style="font-size: 4rem; opacity: 0.2; margin-bottom: 20px; display: block;"></i>
                <p>Belum ada materi yang dibuat. Silakan masukkan topik di atas.</p>
            </div>
        </div>
    </div>

    <script>
    async function generateMateri() {
        const topicInput = document.getElementById('topicInput');
        const genBtn = document.getElementById('genBtn');
        const loader = document.getElementById('loader');
        const resultArea = document.getElementById('resultArea');
        
        const topic = topicInput.value.trim();
        if (!topic) {
            return Swal.fire({
                icon: 'warning',
                title: 'Topik Kosong',
                text: 'Silakan isi topik materi terlebih dahulu!'
            });
        }

        // UI State
        topicInput.disabled = true;
        genBtn.disabled = true;
        loader.style.display = 'block';
        resultArea.style.opacity = '0.5';

        try {
            const response = await fetch('../api/ai_materi_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ topic: topic })
            });

            const data = await response.json();

            if (data.status === 'error') {
                return Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: data.message
                });
            }

            if (data.error) throw new Error(data.error);

            renderMateri(data);
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal Membuat Materi',
                text: 'Terjadi kesalahan saat menghubungi AI. Silakan coba lagi.'
            });
        } finally {
            topicInput.disabled = false;
            genBtn.disabled = false;
            loader.style.display = 'none';
            resultArea.style.opacity = '1';
        }
    }

    function renderMateri(data) {
        let html = `<h1 class="page-title" style="margin-bottom:30px;">${data.title}</h1>`;
        
        data.sections.forEach(section => {
            html += `
                <div class="ai-materi-card">
                    <h2 class="ai-materi-section-title">
                        <i class="${section.header_icon}"></i> ${section.header_text}
                    </h2>
                    <div class="materi-items-list">
            `;
            
            section.items.forEach(item => {
                const colorClass = item.color || 'blue';
                html += `
                    <div class="materi-item-box ${colorClass}">
                        <i class="${item.icon} materi-item-icon" style="color: var(--accent-${colorClass})"></i>
                        <div class="materi-item-content">
                            <h4>${item.title}</h4>
                            <p>${item.content}</p>
                        </div>
                    </div>
                `;
            });
            
            html += `</div></div>`;
        });
        
        document.getElementById('resultArea').innerHTML = html;
        
        // Scroll to top of results
        window.scrollTo({
            top: document.getElementById('resultArea').offsetTop - 100,
            behavior: 'smooth'
        });
    }
    </script>

    <?php include '../includes/chatbot.php'; ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>
