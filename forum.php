<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$alertScript = "";

// --- LOGIKA SIMPAN PERTANYAAN ---
if (isset($_POST['submit_question'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $query = "INSERT INTO forum_questions (username, question) VALUES ('$currentUser', '$question')";
    if (mysqli_query($conn, $query)) {
        $alertScript = "Swal.fire({icon:'success', title:'Pertanyaan Terkirim', showConfirmButton:false, timer:1500});";
    }
}

// --- LOGIKA SIMPAN JAWABAN ---
if (isset($_POST['submit_answer'])) {
    $qid = $_POST['question_id'];
    $ans = mysqli_real_escape_string($conn, $_POST['answer']);
    $query = "INSERT INTO forum_answers (question_id, username, answer) VALUES ('$qid', '$currentUser', '$ans')";
    if (mysqli_query($conn, $query)) {
        $alertScript = "Swal.fire({icon:'success', title:'Jawaban Terkirim', showConfirmButton:false, timer:1500});";
    }
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

        <!-- Form Tanya -->
        <main class="materi-card" style="margin-bottom: 30px;">
            <form action="forum.php" method="POST" style="display:flex; flex-direction:column; gap:10px;">
                <textarea name="question" placeholder="Tulis pertanyaan Anda..." rows="3" style="width:100%; padding:15px; border-radius:10px; border:1px solid var(--border-color); font-family:inherit;" required></textarea>
                <button type="submit" name="submit_question" class="btn">Kirim Pertanyaan</button>
            </form>
        </main>

        <!-- List Pertanyaan (Ambil dari Database) -->
        <div id="forum-list">
            <?php
            // Query JOIN untuk ambil foto profil & nama asli si penanya
            $sqlQ = "SELECT q.*, u.full_name, u.profile_pic 
                     FROM forum_questions q 
                     JOIN users u ON q.username = u.username 
                     ORDER BY q.created_at DESC";
            $resQ = mysqli_query($conn, $sqlQ);

            while ($q = mysqli_fetch_assoc($resQ)):
                $displayPenanya = !empty($q['full_name']) ? $q['full_name'] : $q['username'];
            ?>
                <div class="materi-card" style="margin-bottom: 20px; border-left: 5px solid var(--accent-teal);">
                    <!-- Header Penanya -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                        <img src="img/<?php echo $q['profile_pic']; ?>" style="width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid var(--accent-teal);">
                        <div>
                            <div style="font-weight:700;"><?php echo $displayPenanya; ?></div>
                            <small style="color:var(--text-secondary);"><?php echo $q['created_at']; ?></small>
                        </div>
                    </div>
                    
                    <div style="font-size:1.1em; margin-bottom:20px;"><?php echo $q['question']; ?></div>

                    <!-- List Jawaban -->
                    <div style="background: rgba(0,0,0,0.05); padding:15px; border-radius:8px; margin-bottom:15px;">
                        <h4 style="margin-top:0;"><i class="fas fa-comments"></i> Jawaban:</h4>
                        <?php
                        $qid = $q['id'];
                        // JOIN untuk ambil foto profil & nama asli si penjawab
                        $sqlA = "SELECT a.*, u.full_name, u.profile_pic 
                                 FROM forum_answers a 
                                 JOIN users u ON a.username = u.username 
                                 WHERE a.question_id = $qid ORDER BY a.created_at ASC";
                        $resA = mysqli_query($conn, $sqlA);
                        
                        if (mysqli_num_rows($resA) > 0):
                            while ($a = mysqli_fetch_assoc($resA)):
                                $displayPenjawab = !empty($a['full_name']) ? $a['full_name'] : $a['username'];
                        ?>
                            <div style="display:flex; gap:10px; margin-bottom:15px; border-bottom: 1px solid var(--border-color); padding-bottom:10px;">
                                <img src="img/<?php echo $a['profile_pic']; ?>" style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                                <div>
                                    <span style="font-weight:600; font-size:0.9em;"><?php echo $displayPenjawab; ?></span>
                                    <p style="margin:2px 0;"><?php echo $a['answer']; ?></p>
                                </div>
                            </div>
                        <?php endwhile; else: ?>
                            <small style="color:var(--text-secondary);">Belum ada jawaban.</small>
                        <?php endif; ?>
                    </div>

                    <!-- Form Balas -->
                    <form action="forum.php" method="POST" style="display:flex; gap:10px;">
                        <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                        <input type="text" name="answer" placeholder="Tulis jawaban..." style="flex:1; padding:8px 12px; border-radius:5px; border:1px solid var(--border-color);" required>
                        <button type="submit" name="submit_answer" class="btn" style="padding:5px 15px; font-size:0.9em;">Balas</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer><p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p></footer>

    <script src="script.js"></script>
    <?php if ($alertScript != ""): ?>
        <script><?php echo $alertScript; ?></script>
    <?php endif; ?>
</body>
</html>