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

    // Logika Upload Foto (support crop base64)
    $profilePic = $oldData['profile_pic']; // Default pakai yang lama

    // 1. Cek apakah ada data Cropped Image (Base64)
    if (!empty($_POST['pp_cropped'])) {
        $data = $_POST['pp_cropped'];
        if (preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $data = base64_decode($data);
            $ext = ($type[1] === 'jpeg') ? 'jpg' : $type[1];
            $newFileName = $username . "_" . time() . "." . $ext;
            file_put_contents('img/' . $newFileName, $data);
            $profilePic = $newFileName;
        }
    }
    // 2. Cek apakah ada file upload biasa ($_FILES)
    else if (isset($_FILES['pp']) && $_FILES['pp']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['pp']['name'];
        $ukuranFile = $_FILES['pp']['size'];
        $tmpName = $_FILES['pp']['tmp_name'];

        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (!in_array($ekstensiGambar, $ekstensiValid)) {
            $alertScript = "Swal.fire({icon:'error', title:'Format Salah', text:'Hanya menerima JPG/PNG'});";
        } elseif ($ukuranFile > 2000000) { // Max 2MB
            $alertScript = "Swal.fire({icon:'error', title:'Terlalu Besar', text:'Maksimal ukuran foto 2MB'});";
        } else {
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
                    <input type="file" id="ppInput" accept="image/*">
                    <input type="hidden" name="pp_cropped" id="ppCropped">
                    <small style="color: var(--text-secondary)">Kosongkan jika tidak ingin ganti foto.</small>
                    <div style="margin-top:10px;">
                        <img id="previewCrop"
                            src="<?php echo !empty($oldData['profile_pic']) ? 'img/' . $oldData['profile_pic'] : 'img/default-pp.png'; ?>"
                            style="max-width:150px; max-height:150px; border-radius:50%; display:block;">
                    </div>
                </div>
                <!-- Cropper.js CSS -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
                <!-- Cropper.js JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
                <script>
                    let cropper;
                    const input = document.getElementById('ppInput');
                    const preview = document.getElementById('previewCrop');
                    const hiddenInput = document.getElementById('ppCropped');
                    input.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            preview.src = event.target.result;
                            if (cropper) cropper.destroy();
                            cropper = new Cropper(preview, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 1,
                                cropend: function () {
                                    const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
                                    hiddenInput.value = canvas.toDataURL('image/jpeg');
                                }
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                    // Saat submit, pastikan hiddenInput sudah terisi
                    document.querySelector('form').addEventListener('submit', function (e) {
                        if (cropper) {
                            const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
                            hiddenInput.value = canvas.toDataURL('image/jpeg');
                        }
                    });
                </script>

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