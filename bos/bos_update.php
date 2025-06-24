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

// Tambah atau Edit Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $tanggal = date('Y-m-d'); // Menyimpan tanggal saat ini
    $jam = date('H:i:s', time());
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
    $deskripsi = htmlspecialchars($_POST['deskripsi'], ENT_QUOTES, 'UTF-8');
    $bukti_gambar_lama = isset($_POST['bukti_gambar_lama']) ? htmlspecialchars($_POST['bukti_gambar_lama'], ENT_QUOTES, 'UTF-8') : "";

    // Handle Upload Gambar
    $bukti_gambar = $bukti_gambar_lama; // Default: gunakan gambar lama
    if (!empty($_FILES['bukti_gambar']['name'])) {
        $target_dir = "../uploads/"; // Folder tempat menyimpan gambar
        $target_file = $target_dir . time() . "_" . basename($_FILES['bukti_gambar']['name']); // Nama file unik
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Ekstensi file

        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES['bukti_gambar']['tmp_name']);
        if ($check !== false) {
            // Cek ukuran file (misalnya, maksimal 5MB)
            if ($_FILES['bukti_gambar']['size'] <= 5000000) {
                // Batasi format file (hanya gambar)
                if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    if (move_uploaded_file($_FILES['bukti_gambar']['tmp_name'], $target_file)) {
                        $bukti_gambar = basename($target_file); // Simpan nama file ke database

                        // Hapus gambar lama jika ada
                        if (!empty($bukti_gambar_lama) && file_exists("../uploads/" . $bukti_gambar_lama)) {
                            unlink("../uploads/" . $bukti_gambar_lama);
                        }
                    } else {
                        echo "Gagal mengupload gambar.";
                        exit();
                    }
                } else {
                    echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
                    exit();
                }
            } else {
                echo "Ukuran file terlalu besar (maksimal 5MB).";
                exit();
            }
        } else {
            echo "File bukan gambar.";
            exit();
        }
    }

    // Jika ID ada, berarti Edit
    if ($id > 0) {
        $query = "UPDATE updates SET tanggal=?, jam=?, status=?, deskripsi=?, divisi=?";
        if (!empty($bukti_gambar)) {
            $query .= ", bukti_gambar=?";
        }
        $query .= " WHERE id=?";
    
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($conn);
            exit();
        }
        if (!empty($bukti_gambar)) {
            mysqli_stmt_bind_param($stmt, "sssssi", $tanggal, $jam, $status, $deskripsi, $divisi, $bukti_gambar);
        } else {
            mysqli_stmt_bind_param($stmt, "sssssi", $tanggal, $jam, $status, $deskripsi, $divisi);
        }    
    } else {
        $query = "INSERT INTO updates (tanggal, jam, status, deskripsi, divisi, bukti_gambar) 
              VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($conn);
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ssssss", $tanggal, $jam, $status, $deskripsi, $divisi, $bukti_gambar);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: bos_update.php");
        exit();
    } else {
        echo "Gagal menyimpan data! Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Ambil nama file gambar
    $query = "SELECT bukti_gambar FROM updates WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($conn);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $bukti_gambar = $row['bukti_gambar'] ?? "";

    // Hapus file gambar dari folder uploads
    if (!empty($bukti_gambar) && file_exists("../uploads/" . $bukti_gambar)) {
        unlink("../uploads/" . $bukti_gambar);
    }

    // Hapus data dari database
    $query = "DELETE FROM updates WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        echo "Gagal mempersiapkan pernyataan SQL: " . mysqli_error($conn);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: bos_update.php");
        exit();
    } else {
        echo "Gagal menghapus data! Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Ambil Data untuk Ditampilkan di Tabel
$query = "SELECT * FROM updates ORDER BY tanggal DESC, jam DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Gagal mengambil data! Error: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
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
            margin: 8px;
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
        /* Warna untuk highlight berdasarkan tanggal */
        .highlight-today {
            background-color: #cce5ff !important;
            font-weight: bold;
        }

        .highlight-yesterday {
            background-color: #ffedcc !important;
        }

        .highlight-past {
            background-color: #ffffff !important;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            background-color: #D91F2E;
            color: white;
            border-radius: 8px 8px 0 0;
        }

        /* Gaya tombol dalam modal */
        .modal-footer .btn {
            width: 100px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            padding: 5px 10px; /* Pastikan padding sama */
        }

        /* Responsif */
        @media (max-width: 768px) {
            .btn {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        /* Warna untuk Hari Ini */
        .highlight-today {
            background-color: rgb(208, 239, 253);
            /* Biru muda */
            font-weight: bold;
        }

        /* Warna untuk Kemarin */
        .highlight-yesterday {
            background-color: rgb(249, 220, 188);
            /* Oranye muda */
        }

        /* Warna untuk Sebelumnya */
        .highlight-past {
            background-color: #ffffff;
        }
        .btn-update {
            background-color:#D91F2E;
            border-color: #D91F2E;
            margin-bottom: 13px;
            color: white; /* Agar teks lebih terlihat */
        }

        .btn-update:hover {
            background-color:#e94654;
            border-color: #e94654;
            color: gray; /* Agar teks lebih terlihat */
        }

        .title-up {
            color: #D91F2E;
            font-size: 30px;
            font-weight: bold;
            font-style: normal;
        }

        .btn .btn-cancel{
            background-color: #bd2130;

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
        .btn-edit{
            background-color:rgb(243, 214, 86);
            margin: 5px;
        }
        .btn-hapus{
            background-color: #e94654;
            
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
                    <a class="nav-link active" href="bos_page.php"><i class="fa-solid fa-house"></i><span> Data</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bos_update.php"><i class="fa-solid fa-id-card"></i><span> Update</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tugas_bos.php"><i class="fa-solid fa-users"></i> <span> Tasks</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data_izin_bos.php"><i class="fa-solid fa-notes-medical"></i><span> Izin</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data_lembur_bos.php"><i class="fa-solid fa-users"></i> <span> Lembur</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_resi_bos.php"><i class="fa-solid fa-users"></i> <span> Resi</span></a>
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

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header">
                <div class="title-up">
                    <p>Update Pekerjaan</p>
                </div>
                <button class="btn btn-update" data-toggle="modal" data-target="#modalUpdate" onclick="clearForm()">Tambah Update</button>
            </div>

           <!-- Form Pencarian -->
<div class="row mb-3 align-items-end">
    <div class="col-md-4">
        <label for="searchDeskripsi">Cari berdasarkan Deskripsi:</label>
        <input type="text" id="searchDeskripsi" class="form-control" placeholder="Masukkan deskripsi...">
    </div>
    <div class="col-md-4">
        <label for="searchTanggalPenugasan">Cari berdasarkan Tanggal Penugasan:</label>
        <input type="date" id="searchTanggalPenugasan" class="form-control" placeholder="dd/mm/yyyy">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button class="btn btn-search me-2" id="btnCari">Cari</button>
        <button class="btn btn-reset" id="btnReset">Reset</button>
    </div>
</div>



<div class="table-responsive">
            <table class="table-danger">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Divisi</th>
                        <th>Bukti Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                    <tbody id="tugasTable">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>";
                                echo "<td>" . $row['jam'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['divisi']) . "</td>";
                                
                                // Cek apakah ada gambar bukti
                                if (!empty($row['bukti_gambar'])) {
                                    echo "<td><button class='btn btn-sm btn-info' onclick='showImageModal(\"../uploads/" . $row['bukti_gambar'] . "\")'>Lihat</button></td>";
                                } else {
                                    echo "<td>-</td>";
                                }

                                // Tombol Edit dan Hapus
                                echo "<td>
                                    <button class='btn btn-sm btn-edit' onclick='editForm(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")'>Edit</button>
                                    <button class='btn btn-sm btn-hapus' onclick='confirmDelete(" . $row['id'] . ")'>Hapus</button>
                                  </td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Update -->
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="bos_update.php" method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update_id" name="id" value="">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" id="update_status" name="status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="update_deskripsi" name="deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Bukti Gambar</label>
                        <input type="file" name="bukti_gambar" class="form-control">
                        <input type="hidden" id="update_bukti_gambar_lama" name="bukti_gambar_lama" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Pratinjau Gambar -->
    <div id="imageModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pratinjau Bukti Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Hapus</a>
                    <button class="btn btn-secondary" onclick="$('#modalHapus').modal('hide');">Batal</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $("#btnCari").click(function () {
        let tanggal = $("#searchTanggalPenugasan").val();
        let deskripsi = $("#searchDeskripsi").val().toLowerCase();

        // Ubah format tanggal dari Y-m-d menjadi d-m-Y
        if (tanggal) {
            let parts = tanggal.split("-");
            tanggal = parts[2] + "-" + parts[1] + "-" + parts[0];
        }

        $("tbody tr").each(function () {
            let rowTanggal = $(this).find("td:first").text().trim();
            let rowDeskripsi = $(this).find("td:nth-child(4)").text().toLowerCase().trim();

            let cocokTanggal = (tanggal === "" || rowTanggal === tanggal);
            let cocokDeskripsi = (deskripsi === "" || rowDeskripsi.includes(deskripsi));

            $(this).toggle(cocokTanggal && cocokDeskripsi);
        });
    });

    $("#btnReset").click(function () {
        $("#searchTanggalPenugasan").val('');
        $("#searchDeskripsi").val('');
        $("tbody tr").show();
    });
});
</script>

<script>
    function editForm(data) {
        document.getElementById('update_id').value = data.id;
        document.getElementById('update_status').value = data.status;
        document.getElementById('update_deskripsi').value = data.deskripsi;
        document.getElementById('update_bukti_gambar_lama').value = data.bukti_gambar;
        
        // Tampilkan modal
        $('#modalUpdate').modal('show');
    }

    function clearForm() {
        document.getElementById('update_id').value = '';
        document.getElementById('update_status').value = '';
        document.getElementById('update_deskripsi').value = '';
        document.getElementById('update_bukti_gambar_lama').value = '';
        $('#modalUpdate').modal('show'); // Tampilkan modal dengan benar
    }

    function confirmDelete(id) {
        document.getElementById('confirmDeleteBtn').href = "update_page.php?hapus=" + id;
        $('#modalHapus').modal('show'); // Tampilkan modal hapus
    }

    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        $('#imageModal').modal('show');
    }
</script>



<script>
    $(document).ready(function () {
    // Close modal on button click
    $('.btn-close, .btn-secondary').click(function () {
        $('#modalUpdate').modal('hide');
    });
});

    $(document).ready(function () {
        // Pastikan klik tombol close menutup modal
        $('.close, .btn-close').click(function () {
            $('#modalUpdate').modal('hide');
            $('#modalHapus').modal('hide');
            $('#imageModal').modal('hide');
        });

        // Cek apakah modal bisa ditutup dengan klik di luar modal
        $('#modalUpdate').on('hidden.bs.modal', function () {
            console.log("Modal berhasil ditutup."); 
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#toggler').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('#main-content').toggleClass('collapsed');
            $(this).css('left', $('#sidebar').hasClass('collapsed') ? '10px' : '250px');
        });

        // Tampilkan alert jika ada pesan dari server
        <?php if (!empty($message)) : ?>
            alert("<?= $message; ?>");
        <?php endif; ?>
    });
</script>
</body>
</html>
