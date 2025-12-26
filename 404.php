<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Tidak Ditemukan - edu.io</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark-mode');</script>
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh; text-align:center;">
    
    <div class="container" style="max-width: 600px;">
        <i class="fas fa-ghost" style="font-size: 8em; color: var(--accent-teal); margin-bottom: 20px; animation: float 3s ease-in-out infinite;"></i>
        <h1 style="font-size: 4em; margin: 0; color: var(--title-color);">404</h1>
        <h2 style="margin-top: 10px;">Ups! Halaman Hilang</h2>
        <p style="color: var(--text-secondary); margin: 20px 0;">Sepertinya kamu tersesat di dunia koding. Halaman yang kamu cari tidak ditemukan.</p>
        
        <a href="index.html" class="btn"><i class="fas fa-home"></i> Kembali ke Home</a>
    </div>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</body>
</html>