<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $github = mysqli_real_escape_string($conn, $_POST['github_link']);
    $instagram = mysqli_real_escape_string($conn, $_POST['instagram_link']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin_link']);

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
        $update = mysqli_query($conn, "UPDATE users SET full_name = '$fullName', bio = '$bio', profile_pic = '$profilePic', github_link = '$github', instagram_link = '$instagram', linkedin_link = '$linkedin' WHERE username = '$username'");

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
    <?php $path = ""; include 'includes/navbar.php'; ?>

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
                    <label><i class="fab fa-github"></i> GitHub URL</label>
                    <input type="url" name="github_link" value="<?php echo $oldData['github_link'] ?? ''; ?>"
                        placeholder="https://github.com/username">
                </div>

                <div class="input-group">
                    <label><i class="fab fa-instagram"></i> Instagram URL</label>
                    <input type="url" name="instagram_link" value="<?php echo $oldData['instagram_link'] ?? ''; ?>"
                        placeholder="https://instagram.com/username">
                </div>

                <div class="input-group">
                    <label><i class="fab fa-linkedin"></i> LinkedIn URL</label>
                    <input type="url" name="linkedin_link" value="<?php echo $oldData['linkedin_link'] ?? ''; ?>"
                        placeholder="https://linkedin.com/in/username">
                </div>


                <div class="input-group">
                    <label>Foto Profil (Maks 2MB)</label>
                    <input type="file" id="ppInput" accept="image/*">
                    <input type="hidden" name="pp_cropped" id="ppCropped">
                    <small style="color: var(--text-secondary)">Kosongkan jika tidak ingin ganti foto.</small>
                    
                    <!-- Preview Hasil Crop -->
                    <div style="margin-top:15px; text-align: center;">
                        <p style="margin-bottom: 5px; font-size: 0.9em; color: var(--text-secondary);">Preview:</p>
                        <img id="previewCrop"
                            src="<?php echo !empty($oldData['profile_pic']) ? (strpos($oldData['profile_pic'], 'http') === 0 ? $oldData['profile_pic'] : 'img/' . $oldData['profile_pic']) : 'img/default-pp.png'; ?>"
                            style="width:150px; height:150px; border-radius:50%; object-fit:cover; border: 3px solid var(--accent-teal); box-shadow: 0 0 15px rgba(0,168,150,0.3);">
                    </div>
                </div>

                <!-- Modal Crop (Hidden by default) -->
                <div id="cropModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.85); backdrop-filter: blur(5px); align-items:center; justify-content:center;">
                    <div style="background: var(--bg-primary); border: 1px solid var(--glass-border); padding: 25px; border-radius: 20px; width: 90%; max-width: 500px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                        <h3 style="color: var(--text-primary); margin-bottom: 20px;">Sesuaikan Foto Profil</h3>
                        
                        <div style="height: 350px; width: 100%; background: #333; border-radius: 10px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                            <img id="imageToCrop" style="max-width: 100%; max-height: 100%; display: block;">
                        </div>

                        <div style="display: flex; gap: 15px; justify-content: center;">
                            <button type="button" id="btnCrop" class="btn" style="background: var(--accent-teal); flex: 1;"><i class="fas fa-check"></i> Potong & Simpan</button>
                            <button type="button" id="btnCancelCrop" class="btn" style="background: #dc3545; flex: 1;"><i class="fas fa-times"></i> Batal</button>
                        </div>
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
                    const modal = document.getElementById('cropModal');
                    const imageToCrop = document.getElementById('imageToCrop');
                    const btnCrop = document.getElementById('btnCrop');
                    const btnCancel = document.getElementById('btnCancelCrop');

                    input.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function (event) {
                            imageToCrop.src = event.target.result;
                            modal.style.display = 'flex'; // Tampilkan modal
                            
                            // Hancurkan cropper lama jika ada
                            if (cropper) cropper.destroy();

                            // Init Cropper baru
                            cropper = new Cropper(imageToCrop, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.8,
                                guides: true,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                                toggleDragModeOnDblclick: false,
                            });
                        };
                        reader.readAsDataURL(file);
                        // Reset input value agar bisa pilih file yang sama jika dibatalkan
                        input.value = ''; 
                    });

                    btnCrop.addEventListener('click', function() {
                        if (cropper) {
                            // Ambil hasil crop
                            const canvas = cropper.getCroppedCanvas({
                                width: 400,
                                height: 400,
                                imageSmoothingEnabled: true,
                                imageSmoothingQuality: 'high',
                            });
                            
                            // Tampilkan di preview halaman utama
                            preview.src = canvas.toDataURL('image/jpeg');
                            
                            // Simpan ke hidden input untuk dikirim ke server
                            hiddenInput.value = canvas.toDataURL('image/jpeg');
                            
                            // Tutup modal
                            modal.style.display = 'none';
                            cropper.destroy();
                            cropper = null;
                        }
                    });

                    btnCancel.addEventListener('click', function() {
                        modal.style.display = 'none';
                        if (cropper) {
                            cropper.destroy();
                            cropper = null;
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