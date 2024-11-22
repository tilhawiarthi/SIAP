<?php
include '../koneksi.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_inspeksi = $_POST['nama_inspeksi'];
    $tanggal_inspeksi = $_POST['tanggal_inspeksi'];
    $waktu_inspeksi = $_POST['waktu_inspeksi'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];

    // Query untuk memasukkan data ke dalam tabel
    $sql = "INSERT INTO jadwal_inspeksi (nama_inspeksi, tanggal_inspeksi, waktu_inspeksi, lokasi, deskripsi)
            VALUES ('$nama_inspeksi', '$tanggal_inspeksi', '$waktu_inspeksi', '$lokasi', '$deskripsi')";

    if ($conn->query($sql) === TRUE) {
        // Setelah data berhasil disimpan, arahkan kembali ke halaman jadwalinspeksi.php
        header("Location: jadwalinspeksi.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
