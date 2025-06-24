<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nomor_resi = $_POST["nomor_resi"];
    $tanggal = $_POST["tanggal"];
    $status = $_POST["status"];

    $query = "UPDATE resi SET nomor_resi='$nomor_resi', tanggal='$tanggal', status='$status' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='produksi_resi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
