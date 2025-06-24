<?php
include '../config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Handle task deletion
        $taskId = mysqli_real_escape_string($conn, $_POST['id']);
        $query = "DELETE FROM tugas WHERE id = '$taskId'";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil dihapus.']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus tugas: ' . mysqli_error($conn)]);
            exit();
        }
    } else {
        // Handle task addition
        $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
        $tanggal_penugasan = mysqli_real_escape_string($conn, $_POST['tanggal_penugasan']);
        $tanggal_deadline = mysqli_real_escape_string($conn, $_POST['tanggal_deadline']);
        $detail_tugas = mysqli_real_escape_string($conn, $_POST['detail_tugas']);
        $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

        $query = "INSERT INTO tugas (nama_tugas, tanggal_penugasan, tanggal_deadline, detail_tugas, divisi) VALUES ('$nama_tugas', '$tanggal_penugasan', '$tanggal_deadline', '$detail_tugas', '$divisi')";

        if (mysqli_query($conn, $query)) {
            $message = 'Tugas berhasil ditambahkan.';
        } else {
            $message = 'Terjadi kesalahan saat menambahkan tugas: ' . mysqli_error($conn);
        }
    }
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
    
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Bootstrap Bundle with Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <!-- Font Awesome 6.6.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            background-color:#e94654;
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
            color: #b41220;
            border-color: #f4f4f4;
        }
        .btn-close:hover {
            color: #e94654;
        }

        .nav-link .text-danger {
            background-color: #b41220;
            color: #fff;
            height: 100vh;
            width: 250px;
            transition: transform 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            font-weight: 700;
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
    <h2 class="mb-4">Daftar Tugas</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#formModal">
        <i class="fa-solid fa-plus"></i> Tambah Tugas
    </button>

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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
    <form id="tugasForm" action="tugas_bos.php" method="POST">
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
            <select name="divisi" class="form-control" required>
                <option value="Kreatif">Kreatif</option>
                <option value="Administrasi">Administrasi</option>
                <option value="Produksi">Produksi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan
        </button>
    </form>
</div>

            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Nama Tugas</th>
                    <th>Tanggal Penugasan</th>
                    <th>Tanggal Deadline</th>
                    <th>Detail Tugas</th>
                    <th>Divisi</th>
                    <th>Aksi</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody id="tugasTable">
                <?php
                include '../config.php';
                $query = "SELECT * FROM tugas ORDER BY id DESC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nama_tugas']}</td>
                        <td class='penugasan'>{$row['tanggal_penugasan']}</td>
                        <td class='deadline'>{$row['tanggal_deadline']}</td>
                        <td>{$row['detail_tugas']}</td>
                        <td>{$row['divisi']}</td>
                        <td>
                            <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Hapus</button>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
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
        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            const taskId = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                $.post('tugas_bos.php', { action: 'delete', id: taskId }, function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        // Remove the row from the table
                        $(`button[data-id='${taskId}']`).closest('tr').remove();
                    } else {
                        alert('Terjadi kesalahan saat menghapus tugas: ' + response.message);
                    }
                }, 'json');
            }
        });
    });
</script>


<!-- Bootstrap Bundle with Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
