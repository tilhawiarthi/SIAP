<?php
// get_data.php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost"; // Ganti dengan server Anda
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "firecheck1"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Ambil no_apar dari parameter GET
$no_apar = isset($_GET['no_apar']) ? $_GET['no_apar'] : '';

// Query untuk mendapatkan data tahun produksi dan expired
$sql = "SELECT Tahun_Produksi, Tahun_Expired FROM inventory WHERE no_apar = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $no_apar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ambil data
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(null); // Tidak ada data ditemukan
}

$stmt->close();
$conn->close();
?>