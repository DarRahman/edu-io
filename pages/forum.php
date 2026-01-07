<?php
session_start();
include '../config/koneksi.php';

function getProfilePath($foto)
{
    if (empty($foto)) {
        return "../img/default-pp.png";
    }
    if (strpos($foto, 'http') === 0) {
        return $foto;
    }
    return "../img/" . $foto;
}

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../auth/login.php");
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$alertScript = "";

if (isset($_SESSION['alert'])) {
    if ($_SESSION['alert'] == 'posted') {
        $alertScript = "Swal.fire({icon:'success', title:'Berhasil', text:'Pertanyaan berhasil dikirim!', timer:2000});";
    } elseif ($_SESSION['alert'] == 'answered') {
        $alertScript = "Swal.fire({icon:'success', title:'Berhasil', text:'Jawaban berhasil dikirim!', timer:2000});";
    } elseif ($_SESSION['alert'] == 'deleted') {
        $alertScript = "Swal.fire({icon:'success', title:'Berhasil', text:'Pertanyaan berhasil dihapus!', timer:2000});";
    } elseif ($_SESSION['alert'] == 'deleted_answer') {
        $alertScript = "Swal.fire({icon:'success', title:'Berhasil', text:'Jawaban berhasil dihapus!', timer:2000});";
    }
    unset($_SESSION['alert']);
}

// --- LOGIKA HAPUS PERTANYAAN ---
if (isset($_POST['delete_question'])) {
    $qid = $_POST['question_id'];

    // Hanya izinkan menghapus jika user adalah pemilik pertanyaan ATAU ADMIN
    $checkOwnership = mysqli_query($conn, "SELECT username FROM forum_questions WHERE id = '$qid'");
    if ($checkOwnership && mysqli_num_rows($checkOwnership) > 0) {
        $questionData = mysqli_fetch_assoc($checkOwnership);

        // Cek apakah user adalah pemilik atau admin
        $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

        if ($questionData['username'] == $currentUser || $isAdmin) {
            // Hapus rating terkait jawaban
            $delRatings = mysqli_query($conn, "DELETE r FROM forum_ratings r
                                               JOIN forum_answers a ON r.answer_id = a.id
                                               WHERE a.question_id = '$qid'");
            // Hapus jawaban terkait
            $delAnswers = mysqli_query($conn, "DELETE FROM forum_answers WHERE question_id = '$qid'");
            // Hapus pertanyaan
            $delQuestion = mysqli_query($conn, "DELETE FROM forum_questions WHERE id = '$qid'");
            if ($delRatings && $delAnswers && $delQuestion) {
                $_SESSION['alert'] = 'deleted';
                header("Location: forum.php");
                exit;
            } else {
                $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Terjadi kesalahan database saat menghapus pertanyaan!', timer:2000});";
            }
        } else {
            $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Anda tidak memiliki izin untuk menghapus pertanyaan ini!', timer:2000});";
        }
    } else {
        $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Pertanyaan tidak ditemukan!', timer:2000});";
    }
}

// --- LOGIKA HAPUS JAWABAN ---
if (isset($_POST['delete_answer'])) {
    $aid = $_POST['answer_id'];

    // Hanya izinkan menghapus jika user adalah pemilik jawaban ATAU ADMIN
    $checkOwnership = mysqli_query($conn, "SELECT username FROM forum_answers WHERE id = '$aid'");
    if ($checkOwnership && mysqli_num_rows($checkOwnership) > 0) {
        $answerData = mysqli_fetch_assoc($checkOwnership);

        // Cek apakah user adalah pemilik atau admin
        $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

        if ($answerData['username'] == $currentUser || $isAdmin) {
            // Hapus rating terkait jawaban
            $delRatings = mysqli_query($conn, "DELETE FROM forum_ratings WHERE answer_id = '$aid'");
            // Hapus jawaban
            $delAnswer = mysqli_query($conn, "DELETE FROM forum_answers WHERE id = '$aid'");
            if ($delRatings && $delAnswer) {
                $_SESSION['alert'] = 'deleted_answer';
                header("Location: forum.php");
                exit;
            } else {
                $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Terjadi kesalahan database saat menghapus jawaban!', timer:2000});";
            }
        } else {
            $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Anda tidak memiliki izin untuk menghapus jawaban ini!', timer:2000});";
        }
    } else {
        $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Jawaban tidak ditemukan!', timer:2000});";
    }
}

// --- LOGIKA SIMPAN PERTANYAAN & JAWABAN ---
if (isset($_POST['submit_question'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $imagePath = null;

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newFilename = uniqid('forum_', true) . '.' . $ext;
            $destination = '../img/forum/' . $newFilename;
            if (move_uploaded_file($filetmp, $destination)) {
                $imagePath = $newFilename;
            }
        }
    }

    $sql = "INSERT INTO forum_questions (username, question, image) VALUES ('$currentUser', '$question', " . ($imagePath ? "'$imagePath'" : "NULL") . ")";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = 'posted';
        header("Location: forum.php");
        exit;
    } else {
        $alertScript = "Swal.fire({icon:'error', title:'Gagal', text:'Terjadi kesalahan database!', timer:2000});";
    }
}
if (isset($_POST['submit_answer'])) {
    $qid = $_POST['question_id'];
    $ans = mysqli_real_escape_string($conn, $_POST['answer']);
    $cekJawab = mysqli_query($conn, "SELECT id FROM forum_answers WHERE question_id = '$qid' AND username = '$currentUser' LIMIT 1");
    if ($cekJawab && mysqli_num_rows($cekJawab) > 0) {
        $row = mysqli_fetch_assoc($cekJawab);
        $aid = $row['id'];
        mysqli_query($conn, "UPDATE forum_answers SET answer = '$ans', created_at = NOW() WHERE id = $aid");
        $_SESSION['alert'] = 'answered';
        header("Location: forum.php");
        exit;
    } else {
        mysqli_query($conn, "INSERT INTO forum_answers (question_id, username, answer) VALUES ('$qid', '$currentUser', '$ans')");
        $_SESSION['alert'] = 'answered';
        header("Location: forum.php");
        exit;
    }
}

// Ambil keyword search jika ada
$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Forum Diskusi - edu.io</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
    <style>
        /* Styling Gambar Postingan */
        .forum-post-image {
            width: 100%;
            max-width: 350px;
            /* Batasi lebar agar tidak menjadi persegi panjang lebar */
            aspect-ratio: 1 / 1;
            /* Paksa rasio 1:1 (Persegi) */
            object-fit: cover;
            /* Potong gambar agar rapi mengisi kotak */
            border-radius: 12px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: transform 0.3s ease;
            display: block;
        }

        .forum-post-image:hover {
            transform: scale(1.02);
        }

        /* Modal untuk melihat gambar full */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            max-height: 90vh;
            object-fit: contain;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php $path = "../";
    include '../includes/navbar.php'; ?>

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
            <form action="forum.php" method="POST" enctype="multipart/form-data"
                style="display:flex; flex-direction:column; gap:10px;">
                <textarea name="question" placeholder="Tulis pertanyaan atau diskusi Anda..." rows="3"
                    style="width:100%; padding:15px; border-radius:10px; border:1px solid var(--border-color); font-family:inherit; resize: none; box-sizing: border-box;"
                    required></textarea>

                <!-- Input Gambar -->
                <div style="display:flex; flex-direction: column; gap: 10px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <label for="file-upload" class="btn"
                            style="background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-color); cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-image"></i> Tambah Gambar
                        </label>
                        <input id="file-upload" type="file" name="image" accept="image/*" style="display:none;"
                            onchange="previewImage(this)">
                        <span id="file-name" style="color: var(--text-secondary); font-size: 0.9em;"></span>
                    </div>
                    <img id="image-preview"
                        style="max-width: 200px; border-radius: 8px; display: none; border: 1px solid var(--border-color);">
                </div>

                <button type="submit" name="submit_question" class="btn" style="align-self: flex-end;">Posting</button>
            </form>
        </main>

        <script>
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const fileName = document.getElementById('file-name');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                    fileName.textContent = input.files[0].name;
                } else {
                    preview.style.display = 'none';
                    fileName.textContent = '';
                }
            }
        </script>

        <!-- List Pertanyaan -->
        <div id="forum-list">
            <?php
            $sqlQ = "SELECT q.*, u.full_name, u.profile_pic,
                     COALESCE((SELECT COUNT(*) FROM forum_likes WHERE question_id = q.id), 0) as total_likes,
                     COALESCE((SELECT 1 FROM forum_likes WHERE question_id = q.id AND username = '$currentUser'), 0) as user_liked
                     FROM forum_questions q
                     JOIN users u ON q.username = u.username
                     WHERE q.question LIKE '%$search%'
                     ORDER BY q.created_at DESC";
            $resQ = mysqli_query($conn, $sqlQ);

            while ($q = mysqli_fetch_assoc($resQ)):
                $displayPenanya = !empty($q['full_name']) ? $q['full_name'] : $q['username'];
                $isQuestionOwner = ($q['username'] == $currentUser);
                ?>
                <!-- KARTU UTAMA PERTANYAAN -->
                <div class="materi-card"
                    style="margin-bottom: 30px; border-left: 5px solid var(--accent-teal); text-align: left; position: relative;">

                    <!-- TOMBOL HAPUS PERTANYAAN (hanya untuk pemilik ATAU ADMIN) -->
                    <?php
                    $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
                    if ($isQuestionOwner || $isAdmin):
                        ?>
                        <form method="POST" action="forum.php" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                            <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                            <input type="hidden" name="delete_question" value="1">
                            <button type="button" onclick="confirmDelete(event, this.form, 'pertanyaan')"
                                style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8em;">
                                <i class="fas fa-trash"></i>
                                <?php echo ($isAdmin && !$isQuestionOwner) ? 'Hapus (Admin)' : 'Hapus'; ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- Header: Foto & Nama Penanya -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                        <a href="profile.php?user=<?php echo $q['username']; ?>">
                            <img src="<?php echo getProfilePath($q['profile_pic']); ?>"
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
                    <div style="font-size:1.1em; margin-bottom:15px; font-weight: 400; line-height: 1.6;">
                        <?php echo nl2br(htmlspecialchars($q['question'])); ?>
                    </div>

                    <!-- Gambar Postingan (Jika Ada) -->
                    <?php if (!empty($q['image'])): ?>
                        <div style="margin-bottom: 15px;">
                            <img src="../img/forum/<?php echo $q['image']; ?>" alt="Post Image" class="forum-post-image"
                                onclick="openModal(this.src)">
                        </div>
                    <?php endif; ?>

                    <!-- Like Button -->
                    <div style="margin-bottom: 15px;">
                        <button onclick="likeQuestion(<?php echo $q['id']; ?>)" class="btn"
                            style="background: <?php echo $q['user_liked'] ? '#dc3545' : 'var(--accent-teal)'; ?>; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.9em;">
                            <i class="fas fa-heart"></i> <span
                                id="like-count-<?php echo $q['id']; ?>"><?php echo $q['total_likes']; ?></span>
                        </button>
                    </div>

                    <!-- Kotak List Jawaban -->
                    <div style="background: rgba(0,0,0,0.05); padding:15px; border-radius:8px; margin-bottom:15px;">
                        <h4 style="margin-top:0;"><i class="fas fa-comments"></i> Jawaban:</h4>

                        <?php
                        $qid = $q['id'];
                        $sqlA = "SELECT 
                            a.id,
                            a.question_id,
                            a.username,
                            a.answer,
                            a.created_at,
                            u.full_name,
                            u.profile_pic,
                            COALESCE((SELECT AVG(rating_value) FROM forum_ratings WHERE answer_id = a.id), 0) as avg_rating,
                            COALESCE((SELECT COUNT(*) FROM forum_ratings WHERE answer_id = a.id), 0) as total_voters
                        FROM forum_answers a 
                        JOIN users u ON a.username = u.username 
                        WHERE a.question_id = $qid 
                        ORDER BY a.created_at ASC";

                        $resA = mysqli_query($conn, $sqlA);

                        if (mysqli_num_rows($resA) > 0):
                            while ($a = mysqli_fetch_assoc($resA)):
                                $displayPenjawab = !empty($a['full_name']) ? $a['full_name'] : $a['username'];
                                $rerata = round($a['avg_rating'], 1);
                                $isAnswerOwner = ($a['username'] == $currentUser);
                                ?>
                                <div
                                    style="position: relative; display:flex; align-items:start; gap:10px; margin-bottom:15px; border-bottom: 1px solid var(--border-color); padding-bottom:10px;">

                                    <!-- TOMBOL HAPUS JAWABAN (hanya untuk pemilik ATAU ADMIN) -->
                                    <?php if ($isAnswerOwner || $isAdmin): ?>
                                        <form method="POST" action="forum.php"
                                            style="position: absolute; top: 0; right: 0; z-index: 10;">
                                            <input type="hidden" name="answer_id" value="<?php echo $a['id']; ?>">
                                            <input type="hidden" name="delete_answer" value="1">
                                            <button type="button" onclick="confirmDelete(event, this.form, 'jawaban')"
                                                style="background: #dc3545; color: white; border: none; padding: 3px 8px; border-radius: 5px; cursor: pointer; font-size: 0.7em;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="profile.php?user=<?php echo $a['username']; ?>">
                                        <img src="<?php echo getProfilePath($a['profile_pic']); ?>"
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
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <!-- AI Chatbot -->
    <div id="ai-chat-launcher" onclick="toggleAIChat()">
        <i class="fas fa-robot"></i>
    </div>

    <div id="ai-chat-window">
        <div class="ai-chat-header">
            <span><i class="fas fa-magic"></i> edu.io AI Tutor</span>
            <button onclick="toggleAIChat()">&times;</button>
        </div>
        <div id="ai-chat-body">
            <div class="ai-message bot">
                Halo! Saya Tutor AI edu.io. Ada yang bisa saya bantu terkait koding
                atau materi hari ini?
            </div>
        </div>
        <div class="ai-chat-footer">
            <input type="text" id="ai-input" placeholder="Tanyakan sesuatu..." autocomplete="off" />
            <button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <!-- Modal Gambar Fullscreen -->
    <div id="imgModal" class="image-modal">
        <span class="close-modal" onclick="document.getElementById('imgModal').style.display='none'">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        function openModal(src) {
            var modal = document.getElementById("imgModal");
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = src;
        }

        // Fungsi konfirmasi hapus dengan SweetAlert
        function confirmDelete(event, form, type) {
            event.preventDefault(); // Mencegah submit form langsung

            // Fallback jika getSwalThemeConfig belum dimuat
            const swalConfig = (typeof getSwalThemeConfig === 'function')
                ? getSwalThemeConfig()
                : { background: '#fff', color: '#333' };

            Swal.fire({
                ...swalConfig,
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus ${type} ini? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika user klik "Ya"
                }
            });
            return false;
        }

        function likeQuestion(questionId) {
            if (window._likeInProgress) return;
            window._likeInProgress = true;

            const formData = new FormData();
            formData.append('question_id', questionId);

            fetch('../api/like_question.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const likeCount = document.getElementById('like-count-' + questionId);
                        const likeButton = likeCount.closest('button');

                        likeCount.textContent = data.new_count;

                        if (data.action === 'liked') {
                            likeButton.style.background = '#dc3545';
                        } else {
                            likeButton.style.background = 'var(--accent-teal)';
                        }
                    } else {
                        if (data.message === 'not_logged_in') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Login Diperlukan',
                                text: 'Silakan login untuk memberikan like.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else if (data.message === 'cannot_like_own_question') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tidak diizinkan',
                                text: 'Anda tidak dapat memberikan like pada pertanyaan sendiri.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memproses like.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                    window._likeInProgress = false;
                })
                .catch((err) => {
                    console.error("Like Error:", err);
                    window._likeInProgress = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses like.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
        }

        function rateAnswer(answerId, score) {
            if (window._ratingInProgress) return;
            window._ratingInProgress = true;

            const stars = document.querySelectorAll('.star-rating i');
            stars.forEach(el => el.style.pointerEvents = 'none');

            const formData = new FormData();
            formData.append('answer_id', answerId);
            formData.append('rating', score);

            fetch('../api/rate_answer.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    const trimmedData = data.trim();
                    if (trimmedData === "success") {
                        stars.forEach(el => {
                            el.style.pointerEvents = 'none';
                            el.onclick = null;
                        });
                        window._ratingInProgress = false;
                        location.reload();
                    } else if (trimmedData === "cannot_rate_own_answer") {
                        window._ratingInProgress = false;
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tidak diizinkan',
                                text: 'Anda tidak dapat memberi rating pada jawaban sendiri.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        stars.forEach(el => el.style.pointerEvents = 'auto');
                    } else {
                        // Error lain
                        console.error("Rating Error:", data);
                        window._ratingInProgress = false;
                        stars.forEach(el => el.style.pointerEvents = 'auto');
                    }
                })
                .catch((err) => {
                    console.error("Fetch Error:", err);
                    window._ratingInProgress = false;
                    stars.forEach(el => el.style.pointerEvents = 'auto');
                });
        }

        // Menjalankan alert dari PHP (jika ada) setelah DOM siap
        document.addEventListener('DOMContentLoaded', function () {
            <?php echo $alertScript; ?>
        });
    </script>
</body>

</html>