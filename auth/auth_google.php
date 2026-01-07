<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['credential'])) {
    $id_token = $_POST['credential'];

    // Decode JWT (Token Google) secara manual untuk localhost (Cara Simpel)
    $segments = explode('.', $id_token);
    if (count($segments) != 3) {
        echo json_encode(['success' => false, 'message' => 'Token tidak valid']);
        exit;
    }

    $payload = json_decode(base64_decode($segments[1]), true);

    if ($payload) {
        $google_id = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'];
        $picture = $payload['picture'];

        // Buat username dari email (misal: badar@gmail.com jadi badar)
        $username = explode('@', $email)[0];

        // 1. Cek apakah user Google ini sudah terdaftar?
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE google_id = '$google_id'");
        $user = mysqli_fetch_assoc($cek);

        if (!$user) {
            // 2. Jika belum ada, cek apakah username sudah dipakai orang lain?
            $cekUsername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
            if (mysqli_num_rows($cekUsername) > 0) {
                // Jika sudah ada yang pakai, tambahkan angka unik di belakangnya
                $username = $username . rand(10, 99);
            }

            // 3. Masukkan sebagai user baru (password dikosongkan karena via Google)
            // Cari baris INSERT di auth_google.php
            $query = "INSERT INTO users (username, full_name, google_id, profile_pic) 
          VALUES ('$username', '$name', '$google_id', '$picture')";
            mysqli_query($conn, $query);
        } else {
            // Jika sudah ada, ambil username-nya dari database (siapa tahu namanya sudah diubah)
            $username = $user['username'];
            $name = !empty($user['full_name']) ? $user['full_name'] : $user['username'];
        }

        // 4. Set Session Login PHP
        $_SESSION['loggedInUser'] = $username;

        echo json_encode([
            'success' => true,
            'username' => $username,
            'full_name' => $name
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal membaca data Google']);
    }
}
