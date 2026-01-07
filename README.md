# edu.io - Platform Edukasi Web Interaktif

**edu.io** adalah platform pembelajaran daring berbasis web yang dirancang untuk membantu pengguna mempelajari dasar-dasar pengembangan web (HTML, CSS, dan JavaScript). Proyek ini telah berkembang menjadi aplikasi web dinamis (Full-Stack) dengan integrasi database, autentikasi modern, kecerdasan buatan (AI), dan fitur multiplayer real-time.

Proyek ini dibuat sebagai **Tugas Kelompok Proyek Akhir Mata Kuliah Web Design**.

---

## 👥 Informasi Kelompok
**Kelompok 3:**
**Anggota:**
1. Khaira Nur Fatihah - 14524008
2. Badar Rahman - 14524303
3. Raehan Pramudia Nugraha - 14524304

---

## 🚀 Fitur Utama (v3.5 - Multiplayer Update)

### 🎮 Mabar Kuis (Multiplayer Race Mode) **[BARU]**
- **Real-time Race:** Tantang teman dalam kuis di mana kecepatan dan ketepatan menentukan pemenang.
- **AI Generated Quiz:** Host cukup memasukkan topik (misal: "Sejarah", "Anime", "Coding"), AI akan membuatkan soal unik secara instan.
- **Lobby & PIN System:** Gabung menggunakan Kode PIN 6 digit atau undangan langsung.
- **Live Leaderboard:** Pantau posisi balapan antar pemain secara langsung.
- **Focus Mode:** Tampilan permainan bebas gangguan (tanpa navbar).

### 🤝 Sistem Pertemanan (Social) **[BARU]**
- **Add & Search Friend:** Cari teman berdasarkan username dan tambahkan ke daftar teman.
- **Game Invites:** Undang teman yang sedang online langsung ke dalam room permainan via notifikasi popup.
- **Friend List:** Lihat daftar teman dan status pertemanan di halaman profil.

### 🤖 AI Power (Integrasi Gemini 2.5 Flash)
- **AI Tutor Chatbot:** Asisten belajar 24/7 yang dapat menjawab pertanyaan koding.
- **AI Quiz Generator:** Fitur canggih untuk membuat soal kuis otomatis tanpa batas.

### 🏆 Gamifikasi & Interaktivitas
- **Sistem Leaderboard:** Peringkat global pengguna berdasarkan total skor.
- **Badges & Achievements:** Dapatkan lencana eksklusif saat mencapai nilai sempurna.
- **Profile Customization:** Upload dan crop foto profil dengan tampilan modern.

### 📚 Modul Pembelajaran
- **Materi Terstruktur:** Modul HTML, CSS, dan JS.
- **Video Tutorial:** Integrasi video pembelajaran YouTube.
- **Playground:** Live coding editor untuk HTML/CSS/JS.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
| :--- | :--- |
| **Frontend** | HTML5, CSS3 (Glassmorphism), JavaScript (ES6+), SweetAlert2, Cropper.js |
| **Backend** | PHP 8+ (Native/Procedural) |
| **Database** | MySQL / MariaDB |
| **AI Service** | Google Gemini API (via cURL) |
| **Real-time** | AJAX Polling (Simulated Real-time) |
| **Auth** | Google Identity Services (OAuth 2.0) |

---

## 📂 Struktur Folder Utama

```text
edu-io/
+-- api/                    # Backend API & Logic (AI, Multiplayer, dll)
+-- assets/                 # CSS, JS, Images
+-- auth/                   # Halaman Login & Register
+-- config/                 # Koneksi Database & Konfigurasi
+-- includes/               # Komponen PHP (Navbar, dll)
+-- pages/                  # Halaman Utama (Profile, Forum, dll)
+-- quiz/                   # Halaman Kuis & Logic Kuis
+-- Materi/                 # Halaman materi pembelajaran
```
+-- api_multiplayer.php     # API: Logika Game Multiplayer
+-- friends.php             # Halaman Manajemen Teman
+-- multiplayer_create.php  # Halaman Host (Buat Room)
+-- multiplayer_game.php    # Halaman Permainan (Player)
+-- multiplayer_lobby.php   # Halaman Tunggu (Lobby)
+-- multiplayer_result.php  # Halaman Hasil Akhir (Podium)
+-- index.php               # Dashboard Utama
+-- koneksi.php             # Koneksi Database
+-- script.js               # Logic Frontend Global
+-- style.css               # Global Styling
```

## 💻 Cara Menjalankan Proyek (Localhost)

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/username/edu-io.git
    ```
2.  **Siapkan Database:**
    - Buat database di phpMyAdmin bernama **`db_eduio`**.
    - Import file SQL utama 
3.  **Konfigurasi:**
    - Sesuaikan `koneksi.php`.
    - Masukkan API Key Google Gemini di `config.php`.
4.  **Jalankan:**
    - Akses via browser: `http://localhost/eduio/`

---

## 🤝 Kontribusi
Proyek ini dikembangkan oleh Kelompok 3.

---
© 2025 edu.io - Hak Cipta Dilindungi.
