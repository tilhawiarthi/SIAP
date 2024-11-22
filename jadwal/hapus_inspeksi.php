<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "firecheck1");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM jadwal_inspeksi WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Inspeksi berhasil dihapus.');
                window.location.href = 'jadwalinspeksi.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

$conn->close();
?>
