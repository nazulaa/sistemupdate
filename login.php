<?php
ob_start();
session_start();

date_default_timezone_set('Asia/Jakarta');

@include 'config.php';

$error = []; // Inisialisasi array error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Validasi input
    if (empty($email)) {
        $error[] = "Email tidak boleh kosong.";
    }
    if (empty($pass)) {
        $error[] = "Password tidak boleh kosong.";
    }

    // Jika tidak ada error, lanjutkan untuk memverifikasi kredensial
    if (empty($error)) {
        // Query untuk memverifikasi pengguna
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'"; // Pastikan untuk menggunakan hashing untuk password
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['divisi'] = $user['divisi'];

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin/admin_page.php");
            } elseif ($user['role'] == 'kepala_divisi' && ($user['divisi'] == 'administrasi' || $user['divisi'] == 'kreatif')) {
                header("Location: kepala_divisi/kepala_divisi.php");
            } elseif ($user['role'] == 'karyawan') {
                header("Location: karyawan/karyawan_page.php");
            } elseif ($user['role'] == 'kepala_divisi' && $user['divisi'] == 'produksi') {
                header("Location: produksi/kadiv_produksi.php");
            }
            exit();
        } else {
            $error[] = "Email atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, rgba(190, 23, 37, 0.84), rgba(254, 225, 225, 0.84));
        }
        .login-form {
            width: 400px; /* Lebar form */
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .text-center{
            color: #d9090d;
            font-weight: bold;
        }
        /* Responsive Styles */
        @media (max-width: 992px) {
            .login-form {
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 25px;
            }
        }

        @media (max-width: 768px) {
            .card-grid {
                flex: 1 1 calc(100% - 20px);
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 class="text-center">Login</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php foreach ($error as $err): ?>
                    <p><?php echo $err; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
