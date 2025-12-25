# edu.io - Platform Edukasi Web Interaktif (Full-Stack)

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

## 🚀 Fitur Utama (v2.0 - Dev 2)

### 🔐 Autentikasi & Keamanan
- **Login & Register:** Terintegrasi dengan database MySQL (Server-side).
- **Google Login:** Dukungan OAuth 2.0 untuk login cepat menggunakan akun Google.
- **Keamanan:** Password hashing (`password_hash`), proteksi sesi, dan sanitasi input.
- **UI Autentikasi:** Tampilan modern dengan *overlay* alert menggunakan SweetAlert2.

### 🤖 AI Tutor (Integrasi Gemini AI)
- **Chatbot Pintar:** Asisten belajar 24/7 yang ditenagai oleh **Google Gemini 2.5 Flash**.
- **Fitur Koding:** Jawaban AI mendukung format *Markdown* dan *Syntax Highlighting* untuk kode.
- **Chat History:** AI dapat mengingat konteks percakapan sebelumnya.
- **Copy Code:** Fitur salin kode otomatis dari jawaban AI.

### 💬 Forum Diskusi Komunitas
- **Real-time Database:** Pertanyaan dan jawaban tersimpan di MySQL, dapat dilihat oleh semua pengguna.
- **Pencarian:** Fitur pencarian pertanyaan (`Search`).
- **Rating Jawaban:** Sistem rating bintang rata-rata (*Average Rating*) yang presisi.
- **Integrasi Profil:** Nama dan foto profil pengguna terhubung langsung ke setiap postingan.

### 👤 Manajemen Profil Pengguna
- **Profil Dinamis:** Halaman profil yang menampilkan biodata dan riwayat nilai.
- **Edit Profil:** Pengguna dapat mengubah nama lengkap, bio, dan foto profil.
- **Foto Profil Pintar:** Mendukung upload foto lokal maupun foto dari akun Google.

### 📚 Modul & Kuis
- **Materi Terstruktur:** Modul pembelajaran HTML, CSS, dan JavaScript.
- **Kuis Interaktif:** Penilaian otomatis di sisi server.
- **Riwayat Nilai:** Skor kuis tersimpan permanen di database dan ditampilkan dengan indikator warna.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
| :--- | :--- |
| **Frontend** | HTML5, CSS3 (Glassmorphism), JavaScript (ES6+), SweetAlert2, Marked.js, FontAwesome |
| **Backend** | PHP (Native) |
| **Database** | MySQL / MariaDB |
| **AI API** | Google Gemini API (REST via cURL) |
| **Auth API** | Google Identity Services (OAuth 2.0) |

---

## 📂 Struktur Folder

```text
edu-io/
├── Kuis/                   # File halaman kuis (HTML)
├── Materi/                 # File halaman materi (HTML)
├── img/                    # Penyimpanan foto profil user
├── ai_process.php          # Backend: Logika koneksi ke Gemini AI
├── auth_google.php         # Backend: Handler login Google
├── edit_profile.php        # Backend & UI: Edit profil user
├── forum.php               # Halaman Forum Diskusi (Full PHP)
├── index.html              # Dashboard utama
├── koneksi.php             # Konfigurasi koneksi database
├── login.php               # Halaman Login
├── logout.php              # Script Logout
├── nilai.php               # Halaman Riwayat Nilai
├── profile.php             # Halaman Profil User
├── rate_answer.php         # API: Logika rating forum
├── register.php            # Halaman Registrasi
├── simpan_nilai.php        # API: Logika penyimpanan skor kuis
├── script.js               # Logika Frontend (Navbar dinamis, Chatbot, dll)
└── style.css               # Styling global (Dark/Light mode support)

```

## 💻 Cara Menjalankan Proyek (Localhost)

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/username/edu-io.git
    ```
2.  **Siapkan Database:**
    - Nyalakan **XAMPP** (Apache & MySQL).
    - Buka `phpMyAdmin` dan buat database baru bernama **`db_eduio`**.
    - Import file SQL (jika ada) atau buat tabel-tabel berikut: `users`, `scores`, `forum_questions`, `forum_answers`, `forum_ratings`.
3.  **Konfigurasi Koneksi:**
    - Buka file `koneksi.php`.
    - Sesuaikan dengan kredensial database lokal Anda (Default XAMPP: user `root`, password kosong).
4.  **Konfigurasi API (Opsional):**
    - **Fitur AI:** Buka `ai_process.php` dan masukkan API Key Google Gemini Anda pada variabel `$apiKey`.
    - **Google Login:** Buka `login.php` dan sesuaikan `data-client_id` dengan Client ID Google Cloud Console Anda.

5.  **Jalankan:**
    - Buka browser dan akses alamat berikut:
      `http://localhost/edu-io/login.php`

---

## 🤝 Kontribusi & Pengembangan
Proyek ini masih dalam tahap pengembangan aktif. Jika Anda menemukan *bug* atau ingin menambahkan fitur, silakan buat *Pull Request* atau hubungi tim pengembang.

---
© 2025 edu.io - Hak Cipta Dilindungi.