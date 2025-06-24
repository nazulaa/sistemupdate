<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workupdate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = ""; // Inisialisasi variabel untuk pesan
$data = []; // Inisialisasi array untuk menyimpan data dari database

// Fetch data from the database
$sql = "SELECT nama, role, divisi, tanggal, keterangan, jam_mulai, jam_lembur FROM lembur";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $message = "Tidak ada data yang tersedia.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Presensi</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome 6.6.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" rel="stylesheet">

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <!-- Leaflet 1.9.4 -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet Search Plugin -->
    <link rel="stylesheet" href="plugin/leaflet-search-master/dist/leaflet-search.min.css">

    <!-- Leaflet Default Extent Plugin -->
    <link rel="stylesheet" href="plugin/Leaflet.defaultextent-master/dist/leaflet.defaultextent.css">

    <style>
        body {
            background-color: #f4f4f4;
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
            font-style: bold;
            font-family: 'Poppins', cursive;
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
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 28px;
        }

        .nav-link {
            color: #efe9e1;
            margin-left: 15px;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item .nav-link {
            font-family: 'Poppins', sans-serif;
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
        h1 {
            font-size: 3rem; /* Adjust the font size */
            color: #b41220; /* Change the text color */
            font-weight: bold; /* Make the text bold */
            margin: 0; /* Remove default margin */
        }
        h2 {
            font-weight: 700;
        }
        .input-group-append .btn-outline-secondary {
            background-color: #e94654;
            border: #f4f4f4;
        }
        .input-group-append .btn-outline-secondary:hover {
            background-color: #B11F2C;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        thead {
            background-color: #b41220; /* Warna latar belakang merah untuk header */
            color: #f4f4f4; /* Warna teks putih untuk kontras */
        }
        th, td {
            padding: 12px;
            text-align: center; /* Center text */
        }
        tbody td {
            background-color: #ffffff; /* Warna latar belakang putih untuk baris data */
        }
        .btn-primary {
            background-color:#b41220;
            border: #f4f4f4;
        }
        .btn-primary:hover {
            background-color:#e94654;
            border: #f4f4f4;
            color: #343a40;
        }
        .btn-close {
            color: #D91F2E;
            border-color: #f4f4f4;
        }
        .btn-close:hover {
            color: #e94654;
        }

        .btn-custom {
            background-color: #D91F2E;
            color: white;
            margin: 0px;
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
            margin-bottom: 40px; /* Reduce bottom margin */
            margin-left: 40px;
            font-size: 30px;
            color: #D91F2E;
            box-shadow: 0 0 10px #b41220;
        }

        .greeting-card .d-inline-block{
            color: #f4f4f4;
        }

        .greeting-card h1 {
            margin: 0;
        }

        .card-grid {
            font-family: 'Poppins', sans-serif;
            color: #D91F2E;
            background-color: #D91F2E;
            box-shadow: 0 0 10px #b41220;
            border-radius: 15px;
            padding: 0px;
            font-size: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 40px;
            height: 120px; /* Adjust height for neat content */
        }

        .card-grid .section__text{
            font-family: 'Poppins', sans-serif;
            color: #f4f4f4;
            font-size: 38px;
            font-weight: bold;
        }

        .card__title {
            color: #f4f4f4;
            font-weight: bold;
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
        .container .text-left{
            color: #D91F2E;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            th, td {
                white-space: nowrap;
            }
            .greeting-card {
                margin-left: 0;
            }
            .navbar-brand {
                font-size: 2rem;
            }
            .nav-link {
                font-size: 1.2rem;
            }
            .card-grid {
                margin-top: 20px;
            }
            .card-grid .section__text {
                font-size: 30px;
            }
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
                    <a class="nav-link active" href="admin_page.php"><i class="fa-solid fa-house"></i><span> Data</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_input.php"><i class="fa-solid fa-id-card"></i><span> Input</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users_admin.php"><i class="fa-solid fa-users"></i> <span> Users</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_data_izin.php"><i class="fa-solid fa-notes-medical"></i><span> Izin</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_data_lembur.php"><i class="fa-solid fa-users"></i> <span> Lembur</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_view_resi.php"><i class="fa-solid fa-users"></i> <span> Resi</span></a>
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
    <header class="mb-4">
        <h1 class="d-inline-block ml-5">Halo, Selamat Datang!</h1>
    </header>

    <section>
        <h2 class="mb-4"><i class="fa-solid fa-table"></i> Data Pengajuan Lembur</h2>
        <div class="table-responsive">
            <table class="table-danger">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Divisi</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jam Mulai</th>
                        <th>Jam Lembur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td><?php echo htmlspecialchars($row['divisi']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam_lembur']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
