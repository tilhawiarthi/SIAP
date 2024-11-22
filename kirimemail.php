<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "firecheck1"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan tanggal hari ini
$today = date('Y-m-d');

// Query untuk mengambil email dari users dan tanggal inspeksi yang H-3, H-2, dan H-1 dari tanggal hari ini
$sql = "SELECT users.email, jadwal_inspeksi.tanggal_inspeksi 
        FROM users, jadwal_inspeksi
        WHERE DATE(jadwal_inspeksi.tanggal_inspeksi) = DATE_ADD(CURDATE(), INTERVAL 3 DAY)
           OR DATE(jadwal_inspeksi.tanggal_inspeksi) = DATE_ADD(CURDATE(), INTERVAL 2 DAY)
           OR DATE(jadwal_inspeksi.tanggal_inspeksi) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Inisialisasi PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Mengatur pengaturan SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Server SMTP
        $mail->SMTPAuth   = true; // Mengaktifkan otentikasi SMTP
        $mail->Username   = 'apar.notifikasi@gmail.com'; // Alamat email pengirim
        $mail->Password   = 'thmfrwlmdvinrzsu'; // Kata sandi email pengirim
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enkripsi TLS
        $mail->Port       = 587; // Port SMTP

        // Mengatur pengirim
        $mail->setFrom('apar.notifikasi@gmail.com', 'S I A P Notification'); // Alamat email pengirim

        // Mengambil setiap email dan tanggal inspeksi dari hasil query
        while ($row = $result->fetch_assoc()) {
            $emailPenerima = $row['email'];
            $tanggalInspeksi = $row['tanggal_inspeksi'];

            // Format tanggal inspeksi ke format yang diinginkan (misalnya d-m-Y)
            $formattedTanggal = date('d-m-Y', strtotime($tanggalInspeksi));

            // Tambahkan email penerima
            $mail->addAddress($emailPenerima);

            // Mengatur isi email
            $mail->isHTML(true); // Mengirimkan email dalam format HTML
            $mail->Subject = 'Pemberitahuan Inspeksi S I A P'; // Subjek email
            $mail->Body    = "<p>Pemberitahuan inspeksi APAR dijadwalkan pada tanggal $formattedTanggal. Pastikan semua persiapan telah dilakukan.</p>"; // Isi email dengan tanggal inspeksi
            $mail->AltBody = "Jangan lupa melakukan inspeksi pengecekan APAR pada tanggal $formattedTanggal."; // Isi email dalam format teks biasa

            // Mengirim email
            $mail->send();

            // Reset penerima untuk email berikutnya
            $mail->clearAddresses();
        }
        echo "Email berhasil dikirim ke semua pengguna.";
    } catch (Exception $e) {
        echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Tidak ada email atau tanggal inspeksi yang mendekati.";
}

// Menutup koneksi
$conn->close();
?>
