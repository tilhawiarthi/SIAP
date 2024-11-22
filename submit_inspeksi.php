<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan Anda sudah menginstal PHPMailer

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

// Mengambil data dari form dengan pemeriksaan isset
$no_apar = $_POST['no_apar'] ?? '';
$region = $_POST['region'] ?? '';
$ba = $_POST['ba'] ?? '';
$so = $_POST['so'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$lantai = $_POST['lantai'] ?? '';
$ruangan = $_POST['ruangan'] ?? '';
$titik_penempatan = $_POST['titik_penempatan'] ?? '';
$merk = $_POST['merk'] ?? '';
$tipe = $_POST['tipe'] ?? '';
$jenis_isi = $_POST['jenis_isi'] ?? '';
$berat_isi = $_POST['berat_isi'] ?? '';
$Tahun_Produksi = $_POST['Tahun_Produksi'] ?? '';
$Tahun_Expired = $_POST['Tahun_Expired'] ?? '';
$Nama_Petugas = $_POST['Nama_Petugas'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$kondisi_serbuk = $_POST['kondisi_serbuk'] ?? '';
$tekanan_catridge = $_POST['tekanan_catridge'] ?? '';
$tabung = $_POST['tabung'] ?? '';
$segel = $_POST['segel'] ?? '';
$pin_pengaman = $_POST['pin_pengaman'] ?? '';
$selang = $_POST['selang'] ?? '';
$nozzel = $_POST['nozzel'] ?? '';
$seal_nozzel = $_POST['seal_nozzel'] ?? '';
$rambu_rambu = $_POST['rambu_rambu'] ?? '';
$clear_area = $_POST['clear_area'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

// Function untuk mengupload file gambar
function uploadImage($fileInputName) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
        $targetDir = "uploads/"; // Direktori penyimpanan
        $targetFile = $targetDir . basename($_FILES[$fileInputName]["name"]);
        move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile);
        return $targetFile; // Mengembalikan path file
    }
    return null; // Jika tidak ada file diupload
}

// Upload setiap gambar yang diinputkan
$tekanan_image_path = uploadImage('tekanan_image');
$tabung_image_path = uploadImage('tabung_image');
$segel_image_path = uploadImage('segel_image');
$pin_pengaman_image_path = uploadImage('pin_pengaman_image');
$selang_image_path = uploadImage('selang_image');
$nozzel_image_path = uploadImage('nozzel_image');
$seal_nozzel_image_path = uploadImage('seal_nozzel_image');
$rambu_image_path = uploadImage('rambu_image');
$clear_image_path = uploadImage('clear_image');

// Menyimpan data ke tabel laporan_inspeksi
$sql_laporan = "INSERT INTO laporan_inspeksi (no_apar, region, ba, so, alamat, lantai, ruangan, titik_penempatan, merk, tipe, jenis_isi, berat_isi, Tahun_Produksi, Tahun_Expired, Nama_Petugas, tanggal, kondisi_serbuk, tekanan_catridge, tabung, segel, pin_pengaman, selang, nozzel, seal_nozzel, rambu_rambu, clear_area, keterangan, tekanan_image, tabung_image, segel_image, pin_pengaman_image, selang_image, nozzel_image, seal_nozzel_image, rambu_image, clear_image) 
VALUES ('$no_apar', '$region', '$ba', '$so', '$alamat', '$lantai', '$ruangan','$titik_penempatan', '$merk', '$tipe', '$jenis_isi', '$berat_isi', '$Tahun_Produksi', '$Tahun_Expired', '$Nama_Petugas', '$tanggal', '$kondisi_serbuk', '$tekanan_catridge', '$tabung', '$segel', '$pin_pengaman', '$selang', '$nozzel', '$seal_nozzel', '$rambu_rambu', '$clear_area', '$keterangan', '$tekanan_image_path', '$tabung_image_path', '$segel_image_path', '$pin_pengaman_image_path', '$selang_image_path', '$nozzel_image_path', '$seal_nozzel_image_path', '$rambu_image_path', '$clear_image_path')";

// Menyimpan data ke tabel inspections
$sql_inspection = "INSERT INTO inspections (ba, alamat, tanggal) 
VALUES ('$ba', '$alamat', '$tanggal')";

// Eksekusi query untuk laporan_inspeksi
if ($conn->query($sql_laporan) === TRUE) {
    // Eksekusi query untuk inspections
    if ($conn->query($sql_inspection) === TRUE) {
        $message = "Data berhasil disimpan.";
        $alertType = "success";

        // Cek apakah ada kerusakan
        $isDamaged = false;
        if ($kondisi_serbuk === 'Beku' || $tekanan_catridge === 'Kurang' || $tabung === 'Berkarat' || $segel === 'Putus' || $pin_pengaman === 'Tidak Ada' || $selang === 'Patah' || $nozzel === 'Pecah' || $seal_nozzel === 'Robek' || $rambu_rambu === 'Tidak Ada') {
            $isDamaged = true;
        }

        // Mengirim email jika ada kerusakan
        if ($isDamaged) {
            $emailQuery = "SELECT email FROM users";
            $result = $conn->query($emailQuery);

            // Mengirim email kepada semua pengguna
            if ($result->num_rows > 0) {
                $mail = new PHPMailer(true);
                try {
                    // Konfigurasi SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.example.com'; // Ganti dengan SMTP server Anda
                    $mail->SMTPAuth = true;
                    $mail->Username = 'apar.notifikasi@gmail.com'; // Ganti dengan email Anda
                    $mail->Password = 'thmfrwlmdvinrzsu'; // Ganti dengan password email Anda
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Mengatur pengirim
                    $mail->setFrom('apar.notifikasi@gmail.com', 'Notifikasi APAR'); // Ganti dengan email dan nama Anda

                    // Mengatur penerima
                    while ($row = $result->fetch_assoc()) {
                        $mail->addAddress($row['email']);
                    }

                    // Subjek dan isi email
                    $mail->Subject = 'Pemberitahuan Kerusakan APAR';
                    $mail->Body = "Ada kerusakan pada APAR berikut:\n\n" .
                                  "No APAR: $no_apar\n" .
                                  "Region: $region\n" .
                                  "BA: $ba\n" .
                                  "Alamat: $alamat\n" .
                                  "Kondisi Serbuk: $kondisi_serbuk\n" .
                                  "Tekanan Catridge: $tekanan_catridge\n" .
                                  "Kondisi Tabung: $tabung\n" .
                                  "Kondisi Segel: $segel\n" .
                                  "Kondisi Pin Pengaman: $pin_pengaman\n" .
                                  "Kondisi Selang: $selang\n" .
                                  "Kondisi Nozzel: $nozzel\n" .
                                  "Kondisi Seal Nozzel: $seal_nozzel\n" .
                                  "Kondisi Rambu: $rambu_rambu\n" .
                                  "Keterangan: $keterangan\n\n" .
                                  "Silakan periksa segera!";

                    // Mengirim email
                    $mail->send();
                } catch (Exception $e) {
                    error_log("Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}");
                }
            }
        }
    } else {
        $message = "Terjadi kesalahan saat menyimpan data ke tabel inspections: " . $conn->error;
        $alertType = "error";
    }
} else {
    $message = "Terjadi kesalahan saat menyimpan data ke tabel laporan_inspeksi: " . $conn->error;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $alertType; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Mengatur waktu tunggu sebelum pengalihan (dalam milidetik)
        var redirectTime = 2000; // 2 detik

        // Mengalihkan ke scan_qr.php setelah waktu tunggu
        setTimeout(function() {
            window.location.href = 'scan_qr.php';
        }, redirectTime);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>