<?php
ob_start();
session_start();

date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workupdate";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['name'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil nama dari sesi
$name = htmlspecialchars($_SESSION['name']);

// Proses presensi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['absen_datang'])) {
        $sql = "INSERT INTO absensi (name, absensi_datang) VALUES ('$name', NOW())";
        if ($conn->query($sql) === TRUE) {
            $message = "Presensi hadir berhasil!";
        } else {
            $message = "Gagal melakukan presensi: " . $conn->error;
        }
    }

    if (isset($_POST['absen_pulang'])) {
        $sql = "UPDATE absensi SET absensi_pulang = NOW() WHERE name = '$name' AND absensi_pulang IS NULL";
        if ($conn->query($sql) === TRUE) {
            $message = "Presensi pulang berhasil!";
        } else {
            $message = "Gagal melakukan presensi: " . $conn->error;
        }
    }
}

// Query untuk menghitung jumlah data di setiap tabel
$usersCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()["total"];
$tasksCount = $conn->query("SELECT COUNT(*) AS total FROM tugas")->fetch_assoc()["total"];
$leavesCount = $conn->query("SELECT COUNT(*) AS total FROM izin")->fetch_assoc()["total"];

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Presensi</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome 6.6.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        /* Navbar Customization */
        .navbar {
            background-color: #D91F2E;
            border: 2px solid #D91F2E;
            box-shadow: 0 0 10px #D91F2E;
        }

        .navbar-brand {
            color: #efe9e1;
            margin-left: 12px;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .navbar-brand:hover {
            color: #322d29;
            transform: scale(1.15);
            transition: transform 0.3s ease-in-out;
        }

        .navbar-brand i {
            margin-right: 3px;
        }

        .navbar-brand .text-dua {
            color: #efe9e1;
            font-weight: bold;
            font-size: 28px;
        }

        .nav-link {
            color: #efe9e1;
            margin-left: 15px;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item .nav-link {
            font-size: 20px;
            font-weight: 700;
            color: #efe9e1;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #efe9e1;
        }

        .nav-link:hover {
            color: rgb(4, 23, 65) !important;
        }

        .navbar-toggler-icon {
            background-color: #D91F2E;
            color: #efe9e1;
        }

        h2.text-center {
            text-align: center;
            font-size: 36px;
            color: #D91F2E;
            margin: 20px;
            padding: 10px;
            font-weight: 800;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        h2.text-center:hover {
            transform: scale(1.05);
        }

        .card {
            margin-bottom: 50px;
            background-color: #f4f4f4;
            border: 1px solid #D91F2E;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            color: #D91F2E;
        }

        .card__title {
            font-size: 24px;
            font-weight: bold;
        }

        .section__text {
            font-size: 38px;
            font-weight: bold;
            color: #D91F2E;
        }

        .btn-custom {
            background-color: #D91F2E;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e94654;
            color: #343a40;
        }

        .greeting-card {
            background-color: #D91F2E;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 40px;
            margin-left: 40px;
            align-items: center;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-size: 30px;
            color: #f4f4f4;
        }

        .greeting-card h1 {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            align-items: center;
            font-weight: 900;
        }

        .h1 {
            align-items: center;
        }

        .card-grid {
            background-color: #f4f4f4;
            border: 1px solid #D91F2E;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 20px;
            font-size: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 40px;
            height: 120px;
        }

        .card-grid .section__text {
            font-size: 38px;
            font-weight: bold;
            color: #D91F2E;
        }

        .card-text {
            max-width: 60%;
        }

        .card-text h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card-text p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .card-text a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container .text-left {
            color: #D91F2E;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span class="text-dua">SIMPUL</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="karyawan_page.php"><i class="fa-solid fa-house"></i><span> Presensi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="update_page.php"><i class="fa-solid fa-bars-progress"></i><span> Progress</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list_tugas.php"><i class="fa-solid fa-file-pen"></i> <span> Tugas</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page_izin.php"><i class="fa-solid fa-notes-medical"></i><span> Izin</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page_lembur.php"><i class="fa-solid fa-users"></i> <span> Lembur</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_resi_page.php"><i class="fa-solid fa-receipt"></i> <span> Resi</span></a>
                    </li>
                    <li class="nav-item mt-auto text-center">
                        <a class="nav-link text-danger bg-white rounded px-3 py-2 mx-auto d-inline-block shadow-sm" href="../logout.php">
                            <span> Logout </span> <i class="fa-solid fa-person-running"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="p-4" id="main-content">
        <div class="greeting-card">
            <h1 class="d-inline-block">Halo, <?php echo $name; ?>!</h1>
        </div>

        <div class="container mt-3">
            <h2 class="text-center">Halaman Presensi</h2>
            <?php if (isset($message)) : ?>
                <div class="alert alert-info text-center"><?= $message; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3 text-center">
                    <button type="submit" name="absen_datang" class="btn btn-custom">Presensi Hadir</button>
                    <button type="submit" name="absen_pulang" class="btn btn-custom">Presensi Pulang</button>
                </div>
            </form>
        </div>

        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="card-grid mb-3">
                        <div class="card-body text-center">
                            <h5 class="card__title">Jumlah Karyawan</h5>
                            <p class="section__text display-4"><?php echo $usersCount; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-grid mb-3">
                        <div class="card-body text-center">
                            <h5 class="card__title">Jumlah Tugas</h5>
                            <p class="section__text display-4"><?php echo $tasksCount; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-grid mb-3">
                        <div class="card-body text-center">
                            <h5 class="card__title">Jumlah Cuti</h5>
                            <p class="section__text display-4"><?php echo $leavesCount; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>

</html>
