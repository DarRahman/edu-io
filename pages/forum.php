<?php
session_start();
include '../config/koneksi.php';

if (!function_exists('getProfilePath')) {
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
    $checkOwnership = mysqli_query($conn, "SELECT username FROM forum_questions WHERE id = '$qid'");
    if ($checkOwnership && mysqli_num_rows($checkOwnership) > 0) {
        $questionData = mysqli_fetch_assoc($checkOwnership);
        $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
        if ($questionData['username'] == $currentUser || $isAdmin) {
            mysqli_query($conn, "DELETE r FROM forum_ratings r JOIN forum_answers a ON r.answer_id = a.id WHERE a.question_id = '$qid'");
            mysqli_query($conn, "DELETE FROM forum_answers WHERE question_id = '$qid'");
            mysqli_query($conn, "DELETE FROM forum_questions WHERE id = '$qid'");
            $_SESSION['alert'] = 'deleted';
            header("Location: forum.php");
            exit;
        }
    }
}

// --- LOGIKA HAPUS JAWABAN ---
if (isset($_POST['delete_answer'])) {
    $aid = $_POST['answer_id'];
    $checkOwnership = mysqli_query($conn, "SELECT username FROM forum_answers WHERE id = '$aid'");
    if ($checkOwnership && mysqli_num_rows($checkOwnership) > 0) {
        $answerData = mysqli_fetch_assoc($checkOwnership);
        $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
        if ($answerData['username'] == $currentUser || $isAdmin) {
            mysqli_query($conn, "DELETE FROM forum_ratings WHERE answer_id = '$aid'");
            mysqli_query($conn, "DELETE FROM forum_answers WHERE id = '$aid'");
            $_SESSION['alert'] = 'deleted_answer';
            header("Location: forum.php");
            exit;
        }
    }
}

$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Forum Diskusi - edu.io</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/forum.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>

<body>
    <?php $path = "../"; include '../includes/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title">Forum Diskusi</h1>

        <div style="text-align:center; margin-bottom:2em;">
            <form action="forum.php" method="GET">
                <input type="text" name="query" placeholder="Cari pertanyaan..." value="<?php echo $search; ?>"
                    style="width:60%; max-width:400px; padding:10px; border-radius:8px; border:1px solid var(--border-color); font-size:1em;">
                <button type="submit" class="btn" style="padding:10px 20px; margin:0;">Cari</button>
            </form>
        </div>

        <main class="materi-card" style="margin-bottom: 30px;">
            <form onsubmit="submitQuestionAjax(event, this)" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
                <textarea name="question" placeholder="Tulis pertanyaan..." rows="3"
                    style="width:100%; padding:15px; border-radius:10px; border:1px solid var(--border-color); font-family:inherit; resize: none; box-sizing: border-box;" required></textarea>
                <div style="display:flex; flex-direction: column; gap: 10px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <label for="file-upload" class="btn" style="background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-color); cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-image"></i> Tambah Gambar
                        </label>
                        <input id="file-upload" type="file" name="image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                        <span id="file-name" style="color: var(--text-secondary); font-size: 0.9em;"></span>
                    </div>
                    <img id="image-preview" style="max-width: 200px; border-radius: 8px; display: none; border: 1px solid var(--border-color);">
                </div>
                <button type="submit" class="btn" style="align-self: flex-end;">Posting</button>
            </form>
        </main>

        <div id="forum-list">
            <?php include '../api/get_forum_content.php'; ?>
        </div>
    </div>

    <footer>
        <?php include '../includes/visitor_stats.php'; ?>
        <p style="margin-top: 20px;">&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

    <div id="imgModal" class="image-modal">
        <span class="close-modal" onclick="document.getElementById('imgModal').style.display='none'">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const fileName = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => { preview.src = e.target.result; preview.style.display = 'block'; }
                reader.readAsDataURL(input.files[0]);
                fileName.textContent = input.files[0].name;
            } else {
                preview.style.display = 'none';
                fileName.textContent = '';
            }
        }

        function openModal(src) {
            document.getElementById("imgModal").style.display = "block";
            document.getElementById("img01").src = src;
        }

        const forumList = document.getElementById('forum-list');
        const searchQuery = '<?php echo $search; ?>';
        let isRefreshing = false;

        function refreshForumList() {
            if (isRefreshing) return;
            isRefreshing = true;
            const ts = Date.now();
            fetch(`../api/get_forum_content.php?query=${encodeURIComponent(searchQuery)}&_t=${ts}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    if (forumList.innerHTML.trim() !== html.trim()) {
                        const scrollPos = window.scrollY;
                        forumList.innerHTML = html;
                        window.scrollTo(0, scrollPos);
                        console.log("Forum refreshed");
                    }
                })
                .finally(() => {
                    isRefreshing = false;
                });
        }

        setInterval(refreshForumList, 5000);

        function submitAnswerAjax(event, form) {
            event.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            const formData = new FormData(form);
            fetch('../api/post_answer_ajax.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    form.reset();
                    refreshForumList();
                    Swal.fire({icon:'success', title:'Berhasil', text:'Jawaban dikirim!', timer:1000, showConfirmButton:false});
                } else {
                    Swal.fire({icon:'error', title:'Gagal', text: data.message});
                }
            })
            .finally(() => {
                btn.disabled = false;
            });
        }

        function submitQuestionAjax(event, form) {
            event.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            const formData = new FormData(form);
            fetch('../api/post_question_ajax.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    form.reset();
                    document.getElementById('image-preview').style.display = 'none';
                    document.getElementById('file-name').textContent = '';
                    refreshForumList();
                    Swal.fire({icon:'success', title:'Berhasil', text:'Pertanyaan dikirim!', timer:1000, showConfirmButton:false});
                } else {
                    Swal.fire({icon:'error', title:'Gagal', text: data.message});
                }
            })
            .finally(() => {
                btn.disabled = false;
            });
        }

        function likeQuestion(qid) {
            fetch(`../api/like_question.php?id=${qid}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' || data.success) {
                        const countSpan = document.getElementById(`like-count-${qid}`);
                        countSpan.innerText = data.total_likes;
                        const btn = countSpan.closest('button');
                        btn.style.background = data.user_liked ? '#dc3545' : 'var(--accent-teal)';
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oppss!',
                            text: data.message || 'Gagal menyukai pertanyaan',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
        }

        function rateAnswer(aid, rating) {
            fetch(`../api/rate_answer.php?answer_id=${aid}&rating=${rating}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        refreshForumList();
                        Swal.fire({icon:'success', title:'Berhasil', text:'Rating disimpan!', timer:1000, showConfirmButton:false});
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oppss!',
                            text: data.message || 'Gagal memberikan rating',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
        }

        function confirmDelete(event, form, type) {
            event.preventDefault(); 
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Hapus ${type} ini?`,
                icon: 'warning',
                showCancelButton: true
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        }
    </script>
    <?php include '../includes/chatbot.php'; ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>
