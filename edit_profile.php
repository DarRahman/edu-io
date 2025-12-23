<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['loggedInUser'];
$alertScript = "";

// 1. Ambil data lama untuk ditampilkan di form
$queryOld = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$oldData = mysqli_fetch_assoc($queryOld);

// 2. Proses jika tombol simpan ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    // Logika Upload Foto
    $profilePic = $oldData['profile_pic']; // Default pakai yang lama
    if ($_FILES['pp']['name'] != "") {
        $namaFile = $_FILES['pp']['name'];
        $ukuranFile = $_FILES['pp']['size'];
        $error = $_FILES['pp']['error'];
        $tmpName = $_FILES['pp']['tmp_name'];

        // Cek ekstensi (hanya jpg, jpeg, png)
        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiValid)) {
            $alertScript = "Swal.fire({icon:'error', title:'Format Salah', text:'Hanya menerima JPG/PNG'});";
        } elseif ($ukuranFile > 2000000) { // Max 2MB
            $alertScript = "Swal.fire({icon:'error', title:'Terlalu Besar', text:'Maksimal ukuran foto 2MB'});";
        } else {
            // Rename file agar tidak bentrok (contoh: badar_12345.jpg)
            $newFileName = $username . "_" . time() . "." . $ekstensiGambar;
            move_uploaded_file($tmpName, 'img/' . $newFileName);
            $profilePic = $newFileName;
        }
    }

    // 3. Update Database
    if ($alertScript == "") {
        $update = mysqli_query($conn, "UPDATE users SET full_name = '$fullName', bio = '$bio', profile_pic = '$profilePic' WHERE username = '$username'");

        if ($update) {
            $alertScript = "
        sessionStorage.setItem('displayName', '$fullName'); // UPDATE NAMA DI NAVBAR
        Swal.fire({
            background: localStorage.getItem('theme') === 'dark' ? '#27273a' : '#fff',
            color: localStorage.getItem('theme') === 'dark' ? '#e0e0e0' : '#333',
            icon: 'success',
            title: 'Profil Diperbarui!',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = 'profile.php';
        });
    ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - edu.io</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>

<body>
    <nav class="navbar">
        <a class="logo" href="index.html"><img src="logo.png" alt="Logo Edu.io" class="logo-img"></a>
    </nav>

    <div class="container" style="max-width: 600px;">
        <h1 class="page-title">Edit Profil</h1>

        <main class="materi-card">
            <!-- Form harus pakai enctype untuk upload file -->
            <form action="edit_profile.php" method="POST" enctype="multipart/form-data">

                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" value="<?php echo $oldData['full_name']; ?>"
                        placeholder="Masukkan nama lengkap..." required>
                </div>

                <div class="input-group">
                    <label>Bio / Deskripsi</label>
                    <textarea name="bio" rows="4"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border-color); font-family:inherit;"><?php echo $oldData['bio']; ?></textarea>
                </div>

                <div class="input-group">
                    <label>Foto Profil (Maks 2MB)</label>
                    <input type="file" name="pp" accept="image/*">
                    <small style="color: var(--text-secondary)">Kosongkan jika tidak ingin ganti foto.</small>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn" style="flex: 2;">Simpan Perubahan</button>
                    <a href="profile.php" class="btn" style="flex: 1; background: #6c757d;">Batal</a>
                </div>
            </form>
        </main>
    </div>

    <?php if ($alertScript != ""): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php echo $alertScript; ?>
            });
        </script>
    <?php endif; ?>
</body>

</html>