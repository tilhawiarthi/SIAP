<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "firecheck1");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil detail inspeksi berdasarkan ID
$sql = "SELECT * FROM jadwal_inspeksi WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Data ditemukan, ambil detailnya
    $row = $result->fetch_assoc();
    $nama_inspeksi = $row['nama_inspeksi'];
    $tanggal_inspeksi = $row['tanggal_inspeksi'];
    $waktu_inspeksi = $row['waktu_inspeksi'];
    $lokasi = $row['lokasi'];
    $deskripsi = $row['deskripsi'];
} else {
    echo "Detail inspeksi tidak ditemukan.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Inspeksi - S I A P</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        p {
            text-align: left;
            margin-bottom: 15px;
        }
        .back-btn {
            margin-top: 20px;
        }
        .delete-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Inspeksi</h1>
        <p><strong>Nama Inspeksi:</strong> <?php echo htmlspecialchars($nama_inspeksi); ?></p>
        <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($tanggal_inspeksi); ?></p>
        <p><strong>Waktu:</strong> <?php echo htmlspecialchars($waktu_inspeksi); ?></p>
        <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($lokasi); ?></p>
        <p><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($deskripsi)); ?></p>
        <a href="jadwalinspeksi.php" class="btn btn-primary back-btn">Kembali ke Jadwal Inspeksi</a>
        <a href="hapus_inspeksi.php?id=<?php echo $id; ?>" class="btn btn-danger delete-btn" onclick="return confirm('Anda yakin ingin menghapus inspeksi ini?');">Hapus Inspeksi</a>
    </div>
</body>
</html>
