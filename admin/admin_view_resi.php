<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan semua field diisi
    $nomor_resi = isset($_POST['nomor_resi']) ? trim($_POST['nomor_resi']) : null;
    $tanggal = isset($_POST['tanggal']) ? trim($_POST['tanggal']) : null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;

    // Cek apakah ada nilai yang kosong
    if ($nomor_resi && $tanggal && $status) {
        $query = "INSERT INTO resi (nomor_resi, tanggal, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $nomor_resi, $tanggal, $status);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data berhasil disimpan!'); window.location.href='produksi_resi.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data!'); window.history.back();</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Data berhasil dihapus!'); window.history.back();</script>";
    }

    mysqli_close($conn);
}
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Pastikan jQuery dimuat lebih awal -->
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
            color: #f4f4f4;
            margin-left: 5px;
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
        .modal-header {
            background-color: #b41220;
            color: white;
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
    <div class="container mt-4">
    <h2>Data Resi</h2>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nomor resi" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                <button id="btnReset" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>

    <?php
include '../config.php';

// Cek jika form di-submit untuk menghapus data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    // Pastikan ID valid dan lakukan penghapusan
    $query = "DELETE FROM resi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
    }
    $stmt->close();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM resi WHERE nomor_resi LIKE '%$search%' OR tanggal LIKE '%$search%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-danger table-striped'>";
    echo "<thead>
            <tr>
                <th>Nomor Resi</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
          </thead>
          <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['nomor_resi']) . "</td>
                <td>" . htmlspecialchars($row['tanggal']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p class='text-muted'>Tidak ada data resi ditemukan.</p>";
}

mysqli_close($conn);
?>
</div>

<!-- Modal Edit Resi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="edit_resi.php">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-nomor-resi">Nomor Resi</label>
                        <input type="text" class="form-control" id="edit-nomor-resi" name="nomor_resi" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit-tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Status</label>
                        <input type="text" class="form-control" id="edit-status" name="status" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS dan jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $(".edit-btn").click(function() {
        $("#edit-id").val($(this).data("id"));
        $("#edit-nomor-resi").val($(this).data("nomor_resi"));
        $("#edit-tanggal").val($(this).data("tanggal"));
        $("#edit-status").val($(this).data("status"));
        $("#editModal").modal("show");
    });
});
</script>
    </main>


</body>
</html>
