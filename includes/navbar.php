<?php
if (!isset($path)) {
  $path = "";
}

// Fungsi untuk menentukan apakah halaman aktif
function isActive($href)
{
  global $path;
  $currentUri = $_SERVER['REQUEST_URI'];
  // Hapus query string jika ada
  $currentUri = strtok($currentUri, '?');
  // Dapatkan path relatif dari URI saat ini (hapus /eduio)
  $relativePath = str_replace('/eduio', '', $currentUri);
  $relativePath = ltrim($relativePath, '/');
  // Dapatkan path relatif dari href
  $relativeHref = str_replace($path, '', $href);
  $relativeHref = ltrim($relativeHref, '/');
  // Bandingkan path relatif
  return $relativePath === $relativeHref;
}

// Fungsi untuk menentukan apakah dropdown aktif
function isDropdownActive($subLinks)
{
  foreach ($subLinks as $link) {
    if (isActive($link)) {
      return true;
    }
  }
  return false;
}

// Fungsi untuk menentukan apakah dropdown Belajar aktif (lebih inklusif)
function isBelajarActive()
{
  $currentUri = strtok($_SERVER['REQUEST_URI'], '?');
  return strpos($currentUri, '/pages/materi.php') !== false ||
    strpos($currentUri, '/pages/video.php') !== false ||
    strpos($currentUri, '/quiz/playground.php') !== false;
}

// Fungsi untuk menentukan apakah dropdown Kuis aktif (lebih inklusif)
function isKuisActive()
{
  $currentUri = strtok($_SERVER['REQUEST_URI'], '?');
  return (strpos($currentUri, '/quiz/') !== false && strpos($currentUri, '/quiz/playground.php') === false) ||
    strpos($currentUri, '/pages/leaderboard.php') !== false;
}

// Fungsi untuk menentukan apakah Home aktif
function isHomeActive()
{
  $currentUri = strtok($_SERVER['REQUEST_URI'], '?');
  // Hapus /eduio jika ada di awal
  $relativePath = str_replace('/eduio', '', $currentUri);
  return $relativePath === '/' || $relativePath === '/index.php' || $relativePath === '';
}

// Daftar sub-link untuk dropdown Belajar
$belajarLinks = [
  '/pages/materi.php',
  '/pages/video.php',
  '/quiz/playground.php'
];

// Daftar sub-link untuk dropdown Kuis
$kuisLinks = [
  '/quiz/index.php',
  '/quiz/ai_quiz.php',
  '/quiz/multiplayer_create.php',
  '/quiz/multiplayer_join.php',
  '/pages/leaderboard.php'
];
?>
<nav class="navbar">
  <a class="logo <?php echo isHomeActive() ? 'active' : ''; ?>" href="<?php echo $path; ?>index.php">
    <img src="<?php echo $path; ?>logo.png" alt="Logo Edu.io" class="logo-img" />
  </a>

  <ul class="nav-links">
    <li class="<?php echo isHomeActive() ? 'active' : ''; ?>"><a
        href="<?php echo $path; ?>index.php">Home</a></li>

    <!-- Dropdown Menu "Belajar" -->
    <li class="dropdown <?php echo isBelajarActive() ? 'active' : ''; ?>">
      <a href="javascript:void(0)" class="dropbtn <?php echo isBelajarActive() ? 'active' : ''; ?>">Belajar <i
          class="fas fa-caret-down"></i></a>
      <div class="dropdown-content">
        <a href="<?php echo $path; ?>pages/materi.php"
          class="<?php echo isActive($path . 'pages/materi.php') ? 'active' : ''; ?>"><i class="fas fa-book"></i> Materi
          Teks</a>
        <a href="<?php echo $path; ?>pages/video.php"
          class="<?php echo isActive($path . 'pages/video.php') ? 'active' : ''; ?>"><i class="fas fa-play-circle"></i>
          Video Tutorial</a>
        <a href="<?php echo $path; ?>quiz/playground.php"
          class="<?php echo isActive($path . 'quiz/playground.php') ? 'active' : ''; ?>"><i class="fas fa-code"></i>
          Live Coding</a>
      </div>
    </li>
    <li class="dropdown <?php echo isKuisActive() ? 'active' : ''; ?>">
      <a href="javascript:void(0)" class="dropbtn <?php echo isKuisActive() ? 'active' : ''; ?>">Kuis <i
          class="fas fa-caret-down"></i></a>
      <div class="dropdown-content">
        <a href="<?php echo $path; ?>quiz/index.php"
          class="<?php echo isActive($path . 'quiz/index.php') ? 'active' : ''; ?>"><i
            class="fas fa-clipboard-check"></i> Pilih Kuis</a>
        <a href="<?php echo $path; ?>quiz/ai_quiz.php"
          class="<?php echo isActive($path . 'quiz/ai_quiz.php') ? 'active' : ''; ?>"><i class="fas fa-robot"></i> AI
          Quiz Generator</a>
        <a href="<?php echo $path; ?>quiz/multiplayer_create.php"
          class="<?php echo isActive($path . 'quiz/multiplayer_create.php') ? 'active' : ''; ?>"><i
            class="fas fa-gamepad"></i> Mabar Kuis (Host)</a>
        <a href="<?php echo $path; ?>quiz/multiplayer_join.php"
          class="<?php echo isActive($path . 'quiz/multiplayer_join.php') ? 'active' : ''; ?>"><i
            class="fas fa-door-open"></i> Join Mabar</a>
        <a href="<?php echo $path; ?>pages/leaderboard.php"
          class="<?php echo isActive($path . 'pages/leaderboard.php') ? 'active' : ''; ?>"><i class="fas fa-trophy"></i>
          Leaderboard</a>
      </div>
    </li>
    <li class="<?php echo isActive($path . 'pages/friends.php') ? 'active' : ''; ?>"><a
        href="<?php echo $path; ?>pages/friends.php">Teman</a></li>
    <li class="<?php echo isActive($path . 'pages/forum.php') ? 'active' : ''; ?>"><a
        href="<?php echo $path; ?>pages/forum.php">Forum</a></li>
    <li class="<?php echo isActive($path . 'pages/about.php') ? 'active' : ''; ?>"><a
        href="<?php echo $path; ?>pages/about.php">Tentang</a></li>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <li class="<?php echo isActive($path . 'pages/admin_dashboard.php') ? 'active' : ''; ?>"><a
          href="<?php echo $path; ?>pages/admin_dashboard.php" style="color: var(--accent-yellow); font-weight: bold;"><i
            class="fas fa-user-shield"></i> Admin Panel</a></li>
    <?php endif; ?>
    <!-- Menu User (Halo, Logout, Theme) akan disuntikkan oleh script.js di sini -->
  </ul>
</nav>