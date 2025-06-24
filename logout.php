<?php
session_start(); // Mulai sesi

// Hancurkan semua variabel sesi
$_SESSION = array(); // Menghapus semua variabel sesi

// Jika menggunakan cookie untuk sesi, hapus cookie sesi
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan sesi
session_destroy(); // Hancurkan sesi

// Arahkan pengguna ke halaman dashboard
header("Location: dashboard.php"); // Ganti dengan nama file dashboard Anda
exit();
