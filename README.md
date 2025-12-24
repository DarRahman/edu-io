# edu.io - Platform Edukasi Web Interaktif

**edu.io** adalah platform pembelajaran daring berbasis web yang dirancang untuk membantu pengguna mempelajari dasar-dasar pengembangan web (HTML, CSS, dan JavaScript) melalui materi terstruktur, video tutorial, dan kuis interaktif.

Proyek ini dibuat sebagai **Tugas Kelompok Proyek Akhir Mata Kuliah Web Design**.

---

## 👥 Informasi Kelompok
**Nama Kelompok:** 
**Anggota:**
1. Khaira Nur Fatihah - 14524008
2. Badar Rahman - 14524303
3. Raehan Pramudia Nugraha - 14524304

---

## 🚀 Fitur Saat Ini (v1.0 - Client Side)
Versi saat ini berjalan sepenuhnya di sisi klien (*client-side*) dengan fitur-fitur berikut:

- **Sistem Autentikasi:** Login dan Register menggunakan *LocalStorage*.
- **Modul Pembelajaran:** Materi lengkap mengenai HTML, CSS, dan JavaScript.
- **Kuis Interaktif:** Uji pemahaman dengan kuis pilihan ganda dan sistem penilaian otomatis.
- **Riwayat Nilai:** Menyimpan dan menampilkan skor kuis pengguna secara lokal.
- **Video Tutorial:** Galeri video pembelajaran yang terintegrasi dengan YouTube API.
- **Forum Diskusi:** Fitur tanya jawab yang menggunakan *IndexedDB* untuk penyimpanan data lokal.
- **Mode Gelap (Dark Mode):** Dukungan tampilan tema gelap untuk kenyamanan pengguna.
- **UI/UX Responsif:** Desain modern menggunakan *Glassmorphism* yang nyaman diakses di berbagai perangkat.

---

## 🛠️ Teknologi yang Digunakan
- **HTML5:** Struktur konten web.
- **CSS3:** Styling (Custom properties, Flexbox, Grid, Glassmorphism).
- **JavaScript (ES6):** Logika interaktif, manipulasi DOM, dan penyimpanan data lokal.
- **FontAwesome:** Ikonografi.
- **Google Fonts:** Tipografi (Poppins).
- **SweetAlert2:** Notifikasi dan dialog yang interaktif.
- **IndexedDB & LocalStorage:** Manajemen data sementara di browser.

---

## 📂 Struktur Folder
```text
edu-io/
├── Kuis/                   # Folder Kuis
│   ├── kuis-html.html      # Kuis HTML
│   ├── kuis-css.html       # Kuis CSS
│   └── kuis-js.html        # Kuis JavaScript
├── Materi/                 # Folder Materi
│   ├── materi-html.html    # Materi HTML
│   ├── materi-css.html     # Materi CSS
│   └── materi-js.html      # Materi JavaScript
├── favicon.png             # Ikon website
├── forum.html              # Halaman forum diskusi
├── index.html              # Dashboard utama
├── login.html              # Halaman masuk
├── register.html           # Halaman daftar
├── logo.png                # Logo aplikasi
├── nilai.html              # Halaman riwayat nilai
├── video.html              # Halaman video tutorial
├── script.js               # Logika utama (JS)
└── style.css               # Styling global (CSS)

```

## 💻 Cara Menjalankan Proyek
1. **Clone** atau unduh repositori ini.
2. Pastikan Anda memiliki browser modern (Chrome/Edge/Firefox).
3. Buka file `login.html` untuk memulai aplikasi.
4. Gunakan fitur register untuk membuat akun pertama Anda.

---
© 2025 edu.io - Hak Cipta Dilindungi.