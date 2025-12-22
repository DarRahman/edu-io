<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Nilai - edu.io</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar">
        <a class="logo" href="index.html">
            <img src="logo.png" alt="Logo Edu.io" class="logo-img">
        </a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="materi.html">Materi</a></li>
            <li><a href="kuis.html">Kuis</a></li>
            <li class="active"><a href="nilai.phpl">Hasil</a></li>
            <li><a href="video.html">Video</a></li>
            <li><a href="forum.html">Forum</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="page-title">Riwayat Nilai Kuis Anda</h1>
        <main>
            <div id="history-container" class="history-container">
                <?php
                session_start();
                include 'koneksi.php';

                if (!isset($_SESSION['loggedInUser'])) {
                    echo "<div class='no-score-message'><h2>Silakan Login untuk melihat nilai.</h2></div>";
                } else {
                    $username = $_SESSION['loggedInUser'];
                    $query = mysqli_query($conn, "SELECT * FROM scores WHERE username = '$username' ORDER BY created_at DESC");

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $quiz_id = $row['quiz_name'];
                            $score = $row['score'];

                            // Menentukan Icon & Nama Kuis
                            $icon = "fas fa-question-circle";
                            $name = "Kuis Tidak Dikenal";
                            if ($quiz_id == "html-quiz") {
                                $icon = "fab fa-html5";
                                $name = "Kuis: HTML";
                            }
                            if ($quiz_id == "css-quiz") {
                                $icon = "fab fa-css3-alt";
                                $name = "Kuis: CSS";
                            }
                            if ($quiz_id == "js-quiz") {
                                $icon = "fab fa-js-square";
                                $name = "Kuis: JavaScript";
                            }

                            // Warna Skor
                            $class = "score-low";
                            if ($score >= 80)
                                $class = "score-high";
                            elseif ($score >= 60)
                                $class = "score-medium";

                            echo "
                    <div class='score-history-card'>
                        <div class='score-history-header'>
                            <i class='$icon'></i>
                            <h3>$name</h3>
                        </div>
                        <div class='score-history-value $class'>$score<span>/100</span></div>
                        <small style='color: var(--text-secondary)'>Diselesaikan pada: {$row['created_at']}</small>
                    </div>";
                        }
                    } else {
                        echo "<div class='no-score-message'><i class='fas fa-box-open'></i><h2>Belum ada nilai.</h2></div>";
                    }
                }
                ?>
            </div>

            <div class="action-buttons">
                <a href="kuis.html" class="btn">Kerjakan Kuis Lain</a>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 edu.io. Semua Hak Cipta Dilindungi.</p>
    </footer>

</body>

</html>