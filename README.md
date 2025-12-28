# edu.io - Platform Edukasi Web Interaktif

**edu.io** adalah platform pembelajaran daring berbasis web yang dirancang untuk membantu pengguna mempelajari dasar-dasar pengembangan web (HTML, CSS, dan JavaScript). Proyek ini telah berkembang menjadi aplikasi web dinamis (Full-Stack) dengan integrasi database, autentikasi modern, dan kecerdasan buatan (AI).

Proyek ini dibuat sebagai **Tugas Kelompok Proyek Akhir Mata Kuliah Web Design**.

---

## 👥 Informasi Kelompok
**Kelompok 3:**
**Anggota:**
1. Khaira Nur Fatihah - 14524008
2. Badar Rahman - 14524303
3. Raehan Pramudia Nugraha - 14524304

---

## 🚀 Fitur Utama (v3.0 - Final Release)

### 🤖 AI Power (Integrasi Gemini 2.5 Flash)
- **AI Tutor Chatbot:** Asisten belajar 24/7 yang dapat menjawab pertanyaan koding, menjelaskan konsep, dan memperbaiki bug.
- **AI Quiz Generator (BARU):** Fitur canggih untuk membuat soal kuis otomatis tanpa batas berdasarkan topik apa saja yang diminta pengguna.

### 🎮 Gamifikasi & Interaktivitas (BARU)
- **Sistem Leaderboard:** Peringkat global pengguna berdasarkan total skor kuis.
- **Badges & Achievements:** Dapatkan lencana eksklusif (seperti *HTML Master*, *JS Ninja*) saat mencapai nilai sempurna (100).
- **UI Kuis Modern:** Tampilan kuis interaktif dengan *Glassmorphism*, *Sticky Progress Bar*, dan animasi transisi.

### 📚 Modul Pembelajaran
- **Materi Terstruktur:** Modul HTML, CSS, dan JS dengan tampilan *Card-Based Layout* yang nyaman dibaca.
- **Code Highlighting:** Blok kode dengan tampilan gelap ala text editor.
- **Navigasi Intuitif:** Kemudahan berpindah antar materi dan kuis.

### 💬 Forum & Komunitas
- **Diskusi Real-time:** Tanya jawab antar pengguna yang tersimpan di database.
- **Sistem Rating:** Berikan bintang pada jawaban yang membantu.
- **Profil Terintegrasi:** Identitas penanya dan penjawab terlihat jelas.

### 🔒 Keamanan & Autentikasi
- **Secure Login:** Password hashing (`password_hash`) dan proteksi sesi.
- **Google OAuth:** Login instan menggunakan akun Google.
- **Config Protection:** API Key disimpan aman dalam file `config.php` terpisah.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
| :--- | :--- |
| **Frontend** | HTML5, CSS3 (Glassmorphism), JavaScript (ES6+), SweetAlert2, FontAwesome |
| **Backend** | PHP 8+ (Native/Procedural) |
| **Database** | MySQL / MariaDB |
| **AI Service** | Google Gemini API (via cURL) |
| **Auth** | Google Identity Services (OAuth 2.0) |

---

## 📂 Struktur Folder

```text
edu-io/
+-- Kuis/                   # Halaman kuis statis (HTML)
+-- Materi/                 # Halaman materi pembelajaran (HTML)
+-- img/
│   +-- badges/             # Aset gambar lencana/badge
│   +-- ...                 # Foto profil user
+-- ai_process.php          # Backend: Chatbot AI
+-- ai_quiz.php             # Frontend: Halaman AI Quiz Generator
+-- ai_quiz_process.php     # Backend: Generator Soal AI
+-- auth_google.php         # Handler login Google
+-- config.php              # Konfigurasi API Key (Gitignored)
+-- forum.php               # Halaman Forum Diskusi
+-- index.html              # Landing Page / Dashboard
+-- koneksi.php             # Koneksi Database
+-- leaderboard.php         # Halaman Peringkat User
+-- login.php               # Halaman Login
+-- profile.php             # Halaman Profil User
+-- register.php            # Halaman Registrasi
+-- script.js               # Logic Frontend Global
+-- simpan_nilai.php        # API: Simpan skor & Logika Badge
+-- style.css               # Global Styling (Dark/Light Mode)
+-- visitor_stats.php       # Tracker statistik pengunjung
```

## 💻 Cara Menjalankan Proyek (Localhost)

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/username/edu-io.git
    ```
2.  **Siapkan Database:**
    - Buat database di phpMyAdmin bernama **`db_eduio`**.
    - Import file SQL yang disertakan (jika ada) atau pastikan tabel `users`, `scores`, `badges`, `forum_*` sudah dibuat.
3.  **Konfigurasi:**
    - **Database:** Sesuaikan `koneksi.php` dengan user/pass MySQL Anda.
    - **API Key:** Buka `config.php` dan masukkan API Key Google Gemini Anda.
      ```php
      $apiKey = "YOUR_GEMINI_API_KEY";
      ```
4.  **Jalankan:**
    - Akses via browser: `http://localhost/edu-io/login.php`

---

## 🤝 Kontribusi
Proyek ini dikembangkan oleh Kelompok 3.

---
© 2025 edu.io - Hak Cipta Dilindungi.
