<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = $_POST['nama_tugas'];
    $tanggal_penugasan = $_POST['tanggal_penugasan'];
    $tanggal_deadline = $_POST['tanggal_deadline'];
    $detail_tugas = $_POST['detail_tugas'];
    $divisi = $_POST['divisi'];

    $insert_query = "INSERT INTO tugas (nama_tugas, tanggal_penugasan, tanggal_deadline, detail_tugas, divisi) 
                     VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nama_tugas, $tanggal_penugasan, $tanggal_deadline, $detail_tugas, $divisi);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Tugas berhasil disimpan"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan tugas"]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Query error: " . mysqli_error($conn)]);
    }
}
?>
