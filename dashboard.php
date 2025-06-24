<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="plugin/leaflet-search-master/dist/leaflet-search.min.css">
    <link rel="stylesheet" href="plugin/Leaflet.defaultextent-master/dist/leaflet.defaultextent.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color:#efe9e1;
        }

        h2 {
            text-align: center;
            color: #efe9e1;
            font-weight: bold;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-bottom: 80px;
            margin-top: 100px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ffffff;
        }

        th {
            background-color: #ac9c8d;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ffe6ee;
        }

        tr:hover {
            background-color: rgb(170, 66, 80);
            color: #efe9e1;
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

        h2.text-center {
            text-align: center;
            font-size: 36px;
            color: #D91F2E;
            font-family: 'Poppins', sans-serif;
            margin: 20px;
            padding: 10px;
            font-weight: 800;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        h2.text-center:hover {
            transform: scale(1.05);
        }

        .card .mb-3 {
            background-color: #D91F2E;
            color: #D91F2E;
        }

        section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 30px 50px;
            padding: 20px;
            background-color: #D91F2E;
            color: #efe9e1;
            border-radius: 20px;
            flex-wrap: wrap;
        }

        .section__img {
            flex: 2;
            max-width: 150px;
            height: auto;
            border-radius: 0.5rem;
            margin-right: 30px;
        }

        .section__data {
            flex: 1;
            padding-right: 20px;
            text-align: center;
        }

        .section__data h2 {
            font-size: 2rem;
            margin: 0;
        }

        .section__data p {
            font-size: 1rem;
            margin: 0;
        }

        .section__title {
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            align-items: start;
            color: #efe9e1;
        }

        .card__title {
            display: flex;
            align-items: center;
            font-weight: 900;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            color: #efe9e1;
            margin-top: 30px;
        }

        .section__text {
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 200;
            margin-top: 10px;
            text-align: center;
        }

        .dashboard-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 40px;
            margin-left: 100px;
            padding: 15px 15px 15px 40px;
            color: #efe9e1;
            background-color: #D91F2E;
            box-shadow: 0 0 10px #D91F2E;
            border-radius: 40px;
            width: 65%;
        }

        .card-grid {
            background-color: #D91F2E;
            border-radius: 20px;
            padding: 10px;
            text-align: center;
            margin: 10px;
            flex: 1;
        }

        .card-grid h5 {
            color: #efe9e1;
            font-weight: bold;
        }

        .card-grid p {
            color: #efe9e1;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card-text {
            display: flex;
            align-items: center;
            max-width: 60%;
            font-weight: bold;
        }

        .card-text h2 {
            display: flex;
            align-items: center;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .card-text p {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .card-text a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .card-image img {
            width: 200px;
            height: 200px;
            margin: 100px;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            section {
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .section__img {
            flex: 2;
            max-width: 180px;
            height: auto;
            border-radius: 0.5rem;
            margin-bottom: 0px;
        }

            .section__data {
                flex: 1;
                padding-right: 0;
                text-align: center;
            }

            .card-grid {
                flex: 1 1 calc(50% - 20px);
                margin: 10px;
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa-duotone fa-solid fa-house" style="--fa-primary-color: #ac9c8d; --fa-secondary-color: #741d29; --fa-secondary-opacity: 1;"></i> Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="section__data">
            <h2>GAWEAN SIMPUL</h2>
            <p>"Every great achievement begins with a single step. Stay focused, stay committed, and success will follow."</p>
        </div>
        <img src="src/images/freepik2.png" alt="greetings" class="section__img">
    </section>

    <div class="container mt-1">
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "workupdate";

        // Membuat koneksi ke database
        $conn = new mysqli($servername, $username, $password, $database);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk menghitung jumlah data di setiap tabel
        $usersCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()["total"];
        $tasksCount = $conn->query("SELECT COUNT(*) AS total FROM tugas")->fetch_assoc()["total"];
        $leavesCount = $conn->query("SELECT COUNT(*) AS total FROM izin")->fetch_assoc()["total"];

        $conn->close();

        ?>

        <div class="card-grid">
            <h5>Jumlah Pengguna/Karyawan</h5>
            <p><?php echo $usersCount; ?></p>
        </div>
        <div class="card-grid">
            <h5>Jumlah Tugas</h5>
            <p><?php echo $tasksCount; ?></p>
        </div>
        <div class="card-grid">
            <h5>Jumlah Cuti Karyawan</h5>
            <p><?php echo $leavesCount; ?></p>
        </div>
    </div>

</body>

</html>
