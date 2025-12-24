<?php
session_start();
include 'koneksi.php';

function getProfilePath($foto) {
    if (empty($foto)) {
        return "img/default-pp.png";
    }
    // Jika isinya link (User Google), langsung kembalikan linknya
    if (strpos($foto, 'http') === 0) {
        return $foto;
    }
    // Jika isinya file lokal, tambahkan folder img/
    return "img/" . $foto;
}

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$alertScript = "";

// Ambil keyword search jika ada
$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

// --- LOGIKA SIMPAN PERTANYAAN & JAWABAN (Tetap sama seperti sebelumnya) ---
if (isset($_POST['submit_question'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    mysqli_query($conn, "INSERT INTO forum_questions (username, question) VALUES ('$currentUser', '$question')");
}
if (isset($_POST['submit_answer'])) {
    $qid = $_POST['question_id'];
    $ans = mysqli_real_escape_string($conn, $_POST['answer']);
    mysqli_query($conn, "INSERT INTO forum_answers (question_id, username, answer) VALUES ('$qid', '$currentUser', '$ans')");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Forum Diskusi - edu.io</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark-mode'); }
    </script>
</head>

<body>
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo" class="logo-img"></a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="materi.html">Materi</a></li>
            <li><a href="kuis.html">Kuis</a></li>
            <li><a href="nilai.php">Hasil</a></li>
            <li class="active"><a href="forum.php">Forum</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="page-title">Forum Diskusi</h1>

        <!-- FITUR SEARCH -->
        <div style="text-align:center; margin-bottom:2em;">
            <form action="forum.php" method="GET">
                <input type="text" name="query" placeholder="Cari pertanyaan..." value="<?php echo $search; ?>"
                    style="width:60%; max-width:400px; padding:10px; border-radius:8px; border:1px solid var(--border-color); font-size:1em;">
                <button type="submit" class="btn" style="padding:10px 20px; margin:0;">Cari</button>
            </form>
        </div>

        <!-- FORM TANYA -->
        <main class="materi-card" style="margin-bottom: 30px;">
            <form action="forum.php" method="POST" style="display:flex; flex-direction:column; gap:10px;">
                <textarea name="question" placeholder="Tulis pertanyaan Anda..." rows="2"
                    style="width:100%; padding:15px; border-radius:10px; border:1px solid var(--border-color); font-family:inherit;"
                    required></textarea>
                <button type="submit" name="submit_question" class="btn">Kirim Pertanyaan</button>
            </form>
        </main>

        <!-- List Pertanyaan (Ambil dari Database) -->
        <div id="forum-list">
            <?php
            // SQL DENGAN FILTER SEARCH
            $sqlQ = "SELECT q.*, u.full_name, u.profile_pic FROM forum_questions q 
                     JOIN users u ON q.username = u.username 
                     WHERE q.question LIKE '%$search%'
                     ORDER BY q.created_at DESC";
            $resQ = mysqli_query($conn, $sqlQ);

            while ($q = mysqli_fetch_assoc($resQ)):
                $displayPenanya = !empty($q['full_name']) ? $q['full_name'] : $q['username'];
                ?>
                <!-- KARTU UTAMA PERTANYAAN -->
                <div class="materi-card"
                    style="margin-bottom: 30px; border-left: 5px solid var(--accent-teal); text-align: left;">

                    <!-- Header: Foto & Nama Penanya -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                        <a href="profile.php?user=<?php echo $q['username']; ?>">
                            <img src="img/<?php echo $q['profile_pic']; ?>"
                                style="width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid var(--accent-teal);">
                        </a>
                        <div>
                            <a href="profile.php?user=<?php echo $q['username']; ?>"
                                style="text-decoration:none; color:inherit;">
                                <div style="font-weight:700;"><?php echo $displayPenanya; ?></div>
                            </a>
                            <small style="color:var(--text-secondary);"><?php echo $q['created_at']; ?></small>
                        </div>
                    </div>

                    <!-- Isi Pertanyaan -->
                    <div style="font-size:1.1em; margin-bottom:20px; font-weight: 500;">
                        <?php echo nl2br(htmlspecialchars($q['question'])); ?>
                    </div>

                    <!-- Kotak List Jawaban -->
                    <div style="background: rgba(0,0,0,0.05); padding:15px; border-radius:8px; margin-bottom:15px;">
                        <h4 style="margin-top:0;"><i class="fas fa-comments"></i> Jawaban:</h4>

                        <?php
                        $qid = $q['id'];
                        $sqlA = "SELECT a.*, u.full_name, u.profile_pic, 
                                 IFNULL(AVG(r.rating_value), 0) as avg_rating, 
                                 COUNT(r.id) as total_voters
                                 FROM forum_answers a 
                                 JOIN users u ON a.username = u.username 
                                 LEFT JOIN forum_ratings r ON a.id = r.answer_id
                                 WHERE a.question_id = $qid 
                                 GROUP BY a.id 
                                 ORDER BY a.created_at ASC";

                        $resA = mysqli_query($conn, $sqlA);

                        if (mysqli_num_rows($resA) > 0):
                            while ($a = mysqli_fetch_assoc($resA)):
                                $displayPenjawab = !empty($a['full_name']) ? $a['full_name'] : $a['username'];
                                $rerata = round($a['avg_rating'], 1);
                                ?>
                                <div
                                    style="display:flex; align-items:start; gap:10px; margin-bottom:15px; border-bottom: 1px solid var(--border-color); padding-bottom:10px;">
                                    <a href="profile.php?user=<?php echo $a['username']; ?>">
                                        <img src="img/<?php echo $a['profile_pic']; ?>"
                                            style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                    </a>
                                    <div style="flex:1;">
                                        <a href="profile.php?user=<?php echo $a['username']; ?>"
                                            style="text-decoration:none; color:inherit;">
                                            <span style="font-weight:600; font-size:0.9em;"><?php echo $displayPenjawab; ?></span>
                                        </a>
                                        <p style="margin:2px 0;"><?php echo htmlspecialchars($a['answer']); ?></p>

                                        <!-- RATING BINTANG -->
                                        <div class="star-rating" style="font-size: 0.85em;">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++):
                                                $starClass = ($rerata >= $i) ? 'fas' : 'far';
                                                ?>
                                                <i class="<?php echo $starClass; ?> fa-star" style="color:#FFC312; cursor:pointer;"
                                                    onclick="rateAnswer(<?php echo $a['id']; ?>, <?php echo $i; ?>)"></i>
                                            <?php endfor; ?>
                                            <span style="color: var(--text-secondary); margin-left: 5px; font-weight: 600;">
                                                <?php echo $rerata; ?> <small style="font-weight:400;">/5
                                                    (<?php echo $a['total_voters']; ?> rating)</small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;
                        else: ?>
                            <small style="color:var(--text-secondary);">Belum ada jawaban.</small>
                        <?php endif; ?>
                    </div>

                    <!-- Form Balas Jawaban -->
                    <form action="forum.php" method="POST" style="display:flex; gap:10px;">
                        <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                        <input type="text" name="answer" placeholder="Tulis jawaban..."
                            style="flex:1; padding:8px 12px; border-radius:5px; border:1px solid var(--border-color);"
                            required>
                        <button type="submit" name="submit_answer" class="btn"
                            style="padding:5px 15px; font-size:0.9em; margin:0;">Balas</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <!-- SCRIPT AJAX UNTUK RATING -->
    <script>
        function rateAnswer(answerId, score) {
            const formData = new FormData();
            formData.append('answer_id', answerId);
            formData.append('rating', score);

            fetch('rate_answer.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        location.reload(); // Refresh untuk melihat perubahan bintang
                    }
                });
        }
    </script>
</body>

</html>