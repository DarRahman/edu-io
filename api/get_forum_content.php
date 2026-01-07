<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hanya kirim header jika ini adalah request AJAX langsung (bukan di-include)
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Content-Type: text/html; charset=utf-8');
}

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
    exit;
}

$currentUser = $_SESSION['loggedInUser'];
$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

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
    $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    ?>
    <div class="materi-card" style="margin-bottom: 30px; border-left: 5px solid var(--accent-teal); text-align: left; position: relative;">
        <?php if ($isQuestionOwner || $isAdmin): ?>
            <form method="POST" action="forum.php" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                <input type="hidden" name="delete_question" value="1">
                <button type="button" onclick="confirmDelete(event, this.form, 'pertanyaan')"
                    style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8em;">
                    <i class="fas fa-trash"></i>
                    <?php echo ($isAdmin && !$isQuestionOwner) ? 'Hapus Admin' : 'Hapus' ; ?>
                </button>
            </form>
        <?php endif; ?>

        <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
            <a href="profile.php?user=<?php echo $q['username']; ?>">
                <img src="<?php echo getProfilePath($q['profile_pic']); ?>"
                    style="width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid var(--accent-teal);">
            </a>
            <div>
                <a href="profile.php?user=<?php echo $q['username']; ?>" style="text-decoration:none; color:inherit;">
                    <div style="font-weight:700;"><?php echo $displayPenanya; ?></div>
                </a>
                <small style="color:var(--text-secondary);"><?php echo $q['created_at']; ?></small>
            </div>
        </div>

        <div style="font-size:1.1em; margin-bottom:15px; font-weight: 400; line-height: 1.6;">
            <?php echo nl2br(htmlspecialchars($q['question'])); ?>
        </div>

        <?php if (!empty($q['image'])): ?>
            <div style="margin-bottom: 15px;">
                <img src="../img/forum/<?php echo $q['image']; ?>" alt="Post Image" class="forum-post-image" onclick="openModal(this.src)">
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 15px;">
            <button onclick="likeQuestion(<?php echo $q['id']; ?>)" class="btn"
                style="background: <?php echo $q['user_liked'] ? '#dc3545' : 'var(--accent-teal)'; ?>; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.9em;">
                <i class="fas fa-heart"></i> <span id="like-count-<?php echo $q['id']; ?>"><?php echo $q['total_likes']; ?></span>
            </button>
        </div>

        <div style="background: rgba(0,0,0,0.05); padding:15px; border-radius:8px; margin-bottom:15px;">
            <h4 style="margin-top:0;"><i class="fas fa-comments"></i> Jawaban:</h4>
            <?php
            $qid = $q['id'];
            $sqlA = "SELECT a.id, a.username, a.answer, a.created_at, u.full_name, u.profile_pic,
                    COALESCE((SELECT AVG(rating_value) FROM forum_ratings WHERE answer_id = a.id), 0) as avg_rating,
                    COALESCE((SELECT COUNT(*) FROM forum_ratings WHERE answer_id = a.id), 0) as total_voters
                    FROM forum_answers a JOIN users u ON a.username = u.username 
                    WHERE a.question_id = $qid ORDER BY a.created_at ASC";
            $resA = mysqli_query($conn, $sqlA);
            if (mysqli_num_rows($resA) > 0):
                while ($a = mysqli_fetch_assoc($resA)):
                    $displayPenjawab = !empty($a['full_name']) ? $a['full_name'] : $a['username'];
                    $rerata = round($a['avg_rating'], 1);
                    $isAnswerOwner = ($a['username'] == $currentUser);
                    ?>
                    <div style="position: relative; display:flex; align-items:start; gap:10px; margin-bottom:15px; border-bottom: 1px solid var(--border-color); padding-bottom:10px;">
                        <?php if ($isAnswerOwner || $isAdmin): ?>
                            <form method="POST" action="forum.php" style="position: absolute; top: 0; right: 0; z-index: 10;">
                                <input type="hidden" name="answer_id" value="<?php echo $a['id']; ?>">
                                <input type="hidden" name="delete_answer" value="1">
                                <button type="button" onclick="confirmDelete(event, this.form, 'jawaban')"
                                    style="background: #dc3545; color: white; border: none; padding: 3px 8px; border-radius: 5px; cursor: pointer; font-size: 0.7em;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="profile.php?user=<?php echo $a['username']; ?>">
                            <img src="<?php echo getProfilePath($a['profile_pic']); ?>" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                        </a>
                        <div style="flex:1;">
                            <a href="profile.php?user=<?php echo $a['username']; ?>" style="text-decoration:none; color:inherit;">
                                <span style="font-weight:600; font-size:0.9em;"><?php echo $displayPenjawab; ?></span>
                            </a>
                            <p style="margin:2px 0;"><?php echo htmlspecialchars($a['answer']); ?></p>
                            <div class="star-rating" style="font-size: 0.85em;">
                                <?php for ($i = 1; $i <= 5; $i++): 
                                    $starClass = ($rerata >= $i) ? 'fas' : 'far';
                                    ?>
                                    <i class="<?php echo $starClass; ?> fa-star" style="color:#FFC312; cursor:pointer;" onclick="rateAnswer(<?php echo $a['id']; ?>, <?php echo $i; ?>)"></i>
                                <?php endfor; ?>
                                <span style="color: var(--text-secondary); margin-left: 5px; font-weight: 600;">
                                    <?php echo $rerata; ?> <small style="font-weight:400;">/5 (<?php echo $a['total_voters']; ?> rating)</small>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <small style="color:var(--text-secondary);">Belum ada jawaban.</small>
            <?php endif; ?>
        </div>
        <form onsubmit="submitAnswerAjax(event, this)" style="display:flex; gap:10px;">
            <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
            <input type="text" name="answer" placeholder="Tulis jawaban..." style="flex:1; padding:8px 12px; border-radius:5px; border:1px solid var(--border-color);" required>
            <button type="submit" class="btn" style="padding:5px 15px; font-size:0.9em; margin:0;">Balas</button>
        </form>
    </div>
<?php endwhile; ?>
