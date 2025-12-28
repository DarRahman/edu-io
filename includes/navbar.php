<?php
if (!isset($path)) {
    $path = "";
}
?>
<nav class="navbar">
  <a class="logo" href="<?php echo $path; ?>index.php">
    <img src="<?php echo $path; ?>logo.png" alt="Logo Edu.io" class="logo-img" />
  </a>

  <ul class="nav-links">
    <li><a href="<?php echo $path; ?>index.php">Home</a></li>

    <!-- Dropdown Menu "Belajar" -->
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Belajar <i class="fas fa-caret-down"></i></a>
      <div class="dropdown-content">
        <a href="<?php echo $path; ?>materi.php"><i class="fas fa-book"></i> Materi Teks</a>
        <a href="<?php echo $path; ?>video.php"><i class="fas fa-play-circle"></i> Video Tutorial</a>
        <a href="<?php echo $path; ?>playground.php"><i class="fas fa-code"></i> Live Coding</a>
      </div>
    </li>
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Kuis <i class="fas fa-caret-down"></i></a>
      <div class="dropdown-content">
        <a href="<?php echo $path; ?>kuis.php"><i class="fas fa-clipboard-check"></i> Pilih Kuis</a>
        <a href="<?php echo $path; ?>ai_quiz.php"><i class="fas fa-robot"></i> AI Quiz Generator</a>
        <a href="<?php echo $path; ?>leaderboard.php"><i class="fas fa-trophy"></i> Leaderboard</a>
      </div>
    </li>
    <li><a href="<?php echo $path; ?>forum.php">Forum</a></li>
    <!-- Menu User (Halo, Logout, Theme) akan disuntikkan oleh script.js di sini -->
  </ul>
</nav>
