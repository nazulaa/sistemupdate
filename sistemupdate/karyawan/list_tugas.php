<?php
include '../config.php';
session_start();

date_default_timezone_set('Asia/Jakarta');

// Pastikan pengguna sudah login
if (!isset($_SESSION['name'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil divisi dari sesi
$divisi = $_SESSION['divisi'] ?? '';

// Query untuk mengambil tugas berdasarkan divisi
$query = "SELECT * FROM tugas WHERE divisi = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $divisi);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    
    <!-- Bootstrap 5.3.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
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
        
        .card {
            margin-bottom: 50px;
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
        thead th {
            background-color: #b41220; 
            color: #f4f4f4;
            padding: 12px;
            text-align: center; /* Tengahkan teks */
            border-right: 1px solid #f4f4f4; /* Garis antara kolom */
        }
        thead th:last-child {
            border-right: none; /* Hapus garis pada kolom terakhir */
        }
        tbody td {
            padding: 12px;
            text-align: center; /* Tengahkan teks */
            vertical-align: middle;
            border-right: 1px solid #f4f4f4; /* Garis antara kolom */
        }
        tbody td:last-child {
            border-right: none; /* Hapus garis pada kolom terakhir */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
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
            margin-bottom: 40px; /* Mengurangi margin bawah */
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
    /* Membuat teks di dalamnya berada di tengah */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 40px;
    height: 120px; /* Sesuaikan tinggi agar konten tetap rapi */
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
        .btn-close {
            color: #D91F2E;
            border-color: #f4f4f4;
        }
        .btn-close:hover {
            color: #e94654;
        }
        .btn-search {
            background-color: #bd2130;
            color: #f4f4f4;
            margin-top: 10px;
        }
        .btn-reset{
            background-color:rgb(123, 128, 133);
            color: #f4f4f4;
            margin-top: 10px;
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
        <header class="mb-4">
                      <h1 class="d-inline-block ml-5">Halo, Selamat Datang!</h1>
        </header>

    <div class="container mt-4">
        <h2 class="mb-4">Daftar Tugas</h2>
        
        <div class="row mb-3 align-items-end">
    <div class="col-md-4">
        <label for="searchTanggalPenugasan">Cari Berdasarkan Tanggal Penugasan</label>
        <input type="date" id="searchTanggalPenugasan" class="form-control">
    </div>
    <div class="col-md-4">
    <label for="searchTanggalDeadline">Cari Berdasarkan Tanggal Deadline</label>
        <input type="date" id="searchTanggalDeadline" class="form-control">
    </div>
    <div class="col-md-4">
        <button id="btnFilter" class="btn btn-search">Filter</button>
        <button id="btnReset" class="btn btn-reset">Reset</button>
    </div>
</div>

    <!-- Alert Message -->
    <div id="alertMessage" class="alert d-none" role="alert"></div>
    
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-right-from-bracket"></i></button>
                </div>
                <div class="modal-body">
                    <form id="tugasForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Tugas</label>
                            <input type="text" name="nama_tugas" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Penugasan</label>
                            <input type="date" name="tanggal_penugasan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Deadline</label>
                            <input type="date" name="tanggal_deadline" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Detail Tugas</label>
                            <textarea name="detail_tugas" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Divisi</label>
                            <input type="text" name="divisi" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <table class="table table-bordered">
    <thead class="table-danger">
        <tr>
            <th>ID</th>
            <th>Nama Tugas</th>
            <th>Tanggal Penugasan</th>
            <th>Tanggal Deadline</th>
            <th>Detail Tugas</th>
            <th>Divisi</th>
        </tr>
    </thead>
    <tbody id="tugasTable">
    <?php
    // Query untuk mengambil tugas berdasarkan divisi
    $divisi = $_SESSION['divisi'];
    $sql = "SELECT * FROM tugas WHERE divisi = '$divisi'";
    $result = $conn->query($sql);

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nama_tugas']) . '</td>';
            echo '<td>' . htmlspecialchars($row['tanggal_penugasan']) . '</td>';
            echo '<td>' . htmlspecialchars($row['tanggal_deadline']) . '</td>';
            echo '<td>' . htmlspecialchars($row['detail_tugas']) . '</td>';
            echo '<td>' . htmlspecialchars($row['divisi']) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center">Tidak ada tugas yang ditemukan.</td></tr>';
    }
    ?>
    </tbody>
</table>


        </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnFilter').click(function() {
                let tanggalPenugasan = $('#searchTanggalPenugasan').val();
                let tanggalDeadline = $('#searchTanggalDeadline').val();
                
                $('#tugasTable tr').filter(function() {
                    let textPenugasan = $(this).find('.penugasan').text();
                    let textDeadline = $(this).find('.deadline').text();
                    
                    $(this).toggle(
                        (tanggalPenugasan === '' || textPenugasan === tanggalPenugasan) && 
                        (tanggalDeadline === '' || textDeadline === tanggalDeadline)
                    );
                });
            });
            
            $('#btnReset').click(function() {
                $('#searchTanggalPenugasan').val('');
                $('#searchTanggalDeadline').val('');
                $('#tugasTable tr').show();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#tugasForm").submit(function(event) {
                event.preventDefault(); // Mencegah reload halaman

                $.ajax({
                    url: "input_tugas.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#alertMessage")
                                .removeClass("d-none alert-danger")
                                .addClass("alert-success")
                                .text(response.message)
                                .fadeIn().delay(2000).fadeOut();

                            // Tutup modal
                            $("#formModal").modal("hide");

                            // Kosongkan form
                            $("#tugasForm")[0].reset();

                            // Tambah data ke tabel tanpa reload
                            let newRow = `<tr>
                                <td>NEW</td>
                                <td>${$("input[name='nama_tugas']").val()}</td>
                                <td>${$("input[name='tanggal_penugasan']").val()}</td>
                                <td>${$("input[name='tanggal_deadline']").val()}</td>
                                <td>${$("textarea[name='detail_tugas']").val()}</td>
                                <td>${$("input[name='divisi']").val()}</td>
                            </tr>`;
                            $("#tugasTable").prepend(newRow);
                        } else {
                            $("#alertMessage")
                                .removeClass("d-none alert-success")
                                .addClass("alert-danger")
                                .text(response.message)
                                .fadeIn().delay(2000).fadeOut();
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggler').click(function() {
                $('#sidebar').toggleClass('collapsed');
                $('#main-content').toggleClass('collapsed');
                $(this).css('left', $('#sidebar').hasClass('collapsed') ? '0px' : '0px');
            });

            // Tampilkan alert jika ada pesan dari server
            <?php if (!empty($message)) : ?>
                alert("<?= $message; ?>");
            <?php endif; ?>
        });
    </script>
</body>
</html>
