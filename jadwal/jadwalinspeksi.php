<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Inisialisasi PHPMailer
$mail = new PHPMailer(true);

// Koneksi ke database menggunakan PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=firecheck1", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Query untuk mengambil data jadwal inspeksi
$sql = "SELECT * FROM jadwal_inspeksi ORDER BY tanggal_inspeksi ASC";
$statement = $conn->query($sql);
$events = array();
$inspeksiSelesai = array(); // Menyimpan status inspeksi untuk setiap bulan

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $bulan = date('F', strtotime($row['tanggal_inspeksi'])); // Mengambil nama bulan
    if (!isset($inspeksiSelesai[$bulan])) {
        $inspeksiSelesai[$bulan] = false; // Inisialisasi status inspeksi untuk bulan tersebut
    }
    
    if ($row['status'] === 'selesai') {
        $inspeksiSelesai[$bulan] = true; // Tandai jika ada inspeksi selesai di bulan tersebut
    }

    $events[] = array(
        'title' => $row['nama_inspeksi'],
        'start' => $row['tanggal_inspeksi'],
        'description' => $row['deskripsi'],
        'url' => 'detailinspeksi.php?id=' . $row['id']  // URL mengarah ke halaman detail dengan parameter id
    );
}

// Query untuk mengambil email dari users dan tanggal inspeksi yang H-3, H-2, dan H-1 dari tanggal hari ini
$emailSql = "SELECT users.email, jadwal_inspeksi.tanggal_inspeksi 
        FROM users
        JOIN jadwal_inspeksi ON DATE(jadwal_inspeksi.tanggal_inspeksi) IN (
            DATE_ADD(CURDATE(), INTERVAL 3 DAY),
            DATE_ADD(CURDATE(), INTERVAL 2 DAY),
            DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        )";

$emailStatement = $conn->query($emailSql);

if ($emailStatement->rowCount() > 0) {
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
        while ($row = $emailStatement->fetch(PDO::FETCH_ASSOC)) {
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
    } catch (Exception $e) {
        echo ": {$mail->ErrorInfo}";
    }
} 

$conn = null; // Tutup koneksi

// Convert data ke format JSON untuk digunakan di FullCalendar
$eventsJson = json_encode($events);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Inspeksi - S I A P</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
        }
        h1 {
            font-size: 32px;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
        }
        #calendar {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .back-btn, .add-event-btn {
            background-color: #17a2b8;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            text-align: center;
        }
        .back-btn:hover, .add-event-btn:hover {
            background-color: #138496;
        }
        .bulan-list {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .bulan-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }
        .bulan-item.checked {
            background-color: #28a745;
            color: #fff;
        }
        .bulan-item label {
            font-size: 16px;
            margin-left: 10px;
        }
        .bulan-item button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            color: #495057;
            transition: background-color 0.3s ease;
        }
        .bulan-item button:hover {
            background-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Jadwal Inspeksi</h1>
        <div class="btn-container">
            <!-- <a href="home.php" class="back-btn">Kembali</a> -->
            <a href="createjadwal.php" class="add-event-btn">Tambah Jadwal Baru</a>
        </div>
        <div id="calendar"></div>

      <!-- List Bulan dengan ceklist
<div class="bulan-list">
    <?php
    foreach ($inspeksiSelesai as $bulan => $selesai) {
        echo '<div class="bulan-item">';
        echo '<input type="checkbox" id="' . htmlspecialchars($bulan) . '" ' . ($selesai ? 'checked' : '') . '>';
        echo '<label for="' . htmlspecialchars($bulan) . '">' . htmlspecialchars($bulan) . '</label>';
        echo '</div>';
    }
    ?>
</div> -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo $eventsJson; ?>,
                eventClick: function(info) {
                    info.jsEvent.preventDefault();  // Mencegah aksi default (membuka halaman baru secara otomatis)
                    if (info.event.url) {
                        window.location.href = info.event.url;  // Mengarahkan ke halaman detail sesuai dengan URL
                    }
                },
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                editable: false,
                selectable: true,
                eventColor: '#17a2b8'
            });
            calendar.render();
        });
    </script>
</body>
</html>
