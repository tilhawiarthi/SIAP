<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "firecheck1";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$No_Apar = $_POST['No_Apar']; // Pastikan ini sesuai dengan input HTML
$Region = $_POST['Region']; // Pastikan ini sesuai dengan input HTML
$BA = $_POST['BA']; // Pastikan ini sesuai dengan input HTML
$SO = $_POST['SO']; // Pastikan ini sesuai dengan input HTML
$alamat = $_POST['alamat']; // Pastikan ini sesuai dengan input HTML
$lantai = $_POST['lantai']; // Pastikan ini sesuai dengan input HTML
$ruangan = $_POST['ruangan']; // Pastikan ini sesuai dengan input HTML
$titik_penempatan = $_POST['titik_penempatan']; // Pastikan ini sesuai dengan input HTML
$merk = $_POST['merk']; // Pastikan ini sesuai dengan input HTML
$tipe = $_POST['tipe']; // Pastikan ini sesuai dengan input HTML
$jenis_isi = $_POST['jenis_isi']; // Pastikan ini sesuai dengan input HTML
$berat_isi = $_POST['berat_isi']; // Pastikan ini sesuai dengan input HTML
$Tahun_Produksi = $_POST['Tahun_Produksi']; // Pastikan ini sesuai dengan input HTML
$Tahun_Expired = $_POST['Tahun_Expired']; // Pastikan ini sesuai dengan input HTML

// Memeriksa apakah file foto diunggah
if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    
    // Memeriksa ukuran file (300 KB = 300 * 1024 bytes)
    if ($foto['size'] > 300 * 1024) {
        die("Ukuran file foto terlalu besar. Maksimal 300 KB.");
    }}

// Format data untuk QR Code
$qrData = json_encode([
    'No_Apar' => $No_Apar,
    'Region' => $Region,
    'BA' => $BA,
    'SO' => $SO,
    'alamat' => $alamat,
    'lantai' => $lantai,
    'ruangan' => $ruangan,
    'titik_penempatan' => $titik_penempatan,
    'merk' => $merk,
    'tipe' => $tipe,
    'jenis_isi' => $jenis_isi,
    'berat_isi' => $berat_isi,
    'tahun_produksi' => $Tahun_Produksi,
    'tahun_expired' => $Tahun_Expired,
]);

// Insert ke tabel inventory
$sqlInventory = "INSERT INTO inventory 
(No_Apar, Region, BA, SO, alamat, lantai, ruangan, titik_penempatan, merk, tipe, jenis_isi, berat_isi, Tahun_Produksi, Tahun_Expired, kodeqr) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmtInventory = $conn->prepare($sqlInventory);
if (!$stmtInventory) {
    die("Error preparing statement for inventory: " . $conn->error);
}

$stmtInventory->bind_param('sssssssssssssss', 
    $No_Apar, $Region, $BA, $SO, $alamat, $lantai, $ruangan, $titik_penempatan, 
    $merk, $tipe, $jenis_isi, $berat_isi, $Tahun_Produksi, $Tahun_Expired, $qrData
);

$inventoryResult = $stmtInventory->execute();

$stmtInventory->close();

// Menentukan pesan notifikasi
if ($inventoryResult) {
    $message = "Data berhasil disimpan!";
    $alertType = "success";
} else {
    $message = "Terjadi kesalahan saat menyimpan data: " . $conn->error; // Tambahkan detail kesalahan
    $alertType = "error";
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <div class="toast-container">
        <div class="toast align-items-center text-bg-<?php echo $alertType; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $message; ?>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.querySelector('.toast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();

            // Redirect after 2 seconds
            setTimeout(function() {
                window.location.href = 'home.php'; // Ganti dengan halaman yang sesuai
            }, 2000); // Waktu tunggu sebelum redirect, misalnya 2000 ms (2 detik)
        });
    </script>
</body>
</html>