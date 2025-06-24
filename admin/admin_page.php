<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Responsif</title>
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
            margin-left: 5px;
            color: #f4f4f4;
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

    <main class="flex-fill p-4" id="main-content">
    <header class="mb-4">
        <h1 class="d-inline-block ml-5">Halo, Admin!</h1>
    </header>
    <section>
        <h2>Data Kehadiran</h2>

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama" aria-label="Search">
                <input type="date" class="form-control" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    <button id="btnReset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>

        <?php
        include '../config.php';

        // Handle delete request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            $delete_id = intval($_POST['delete_id']);
            if ($delete_id > 0) {
                $stmt = $conn->prepare("DELETE FROM absensi WHERE id = ?");
                $stmt->bind_param("i", $delete_id);
                $stmt->execute();
                $stmt->close();
                echo "<div class='alert alert-success'>Data berhasil dihapus.</div>";
            } else {
                echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
            }
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $date_filter = isset($_GET['date']) ? $_GET['date'] : '';

        // Query dasar
        $query = "SELECT * FROM absensi WHERE 1";

        // Filter berdasarkan nama jika ada input pencarian
        if (!empty($search)) {
            $query .= " AND name LIKE '%$search%'";
        }

        // Filter berdasarkan tanggal dari waktu hadir
        if (!empty($date_filter)) {
            $query .= " AND DATE(absensi_datang) = '$date_filter'";
        }

        $result = mysqli_query($conn, $query);

        // Menampilkan hasil dalam tabel
        echo "<table class='table-danger table-striped'>";
        echo "<thead>
                <tr>
                    <th>Nama</th>
                    <th>Waktu Hadir</th>
                    <th>Waktu Pulang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['absensi_datang']}</td>
                    <td>{$row['absensi_pulang']}</td>
                    <td>{$row['lembur']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-danger'>Hapus</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";

        ?>
    </section>
</main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            if (response === 'success') {
                                row.remove();
                                alert('Data berhasil dihapus.');
                            } else {
                                alert('Gagal menghapus data.');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggler').click(function() {
                $('#sidebar').toggleClass('collapsed');
                $('#main-content').toggleClass('collapsed');
                if ($('#sidebar').hasClass('collapsed')) {
                    $(this).css('left', '10px'); // Adjust position of toggler when sidebar is collapsed
                } else {
                    $(this).css('left', '250px'); // Reset position of toggler when sidebar is expanded
                }
            });
        });
    </script>
</body>

</html>