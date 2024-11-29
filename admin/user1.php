<?php
session_start();

//Mengecek apakah user sudah login
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: user1.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - S I A P</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
        }
        .logout-btn {
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .container {
            margin: 20px auto;
            max-width: 1200px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        nav {
            display: flex;
            justify-content: space-around;
            background-color: #007bff;
            padding: 10px;
            margin-bottom: 20px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }
        .user-info {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .user-info h2 {
            margin: 0;
        }
        .features {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping */
            justify-content: space-around;
        }
        .features div {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            flex: 1 1 30%; /* Flex-grow, flex-shrink, flex-basis */
            margin: 10px; /* Add margin for spacing */
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .features div:hover {
            background-color: #007bff;
            color: #fff;
        }
        .features div a {
            display: block;
            margin-top: 10px;
            padding: 10px 0;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .features div a:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: #fff;
            margin-top: 20px;
        }
        .logo img {
            max-width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
            height: auto; /* Mempertahankan rasio aspek gambar */
            margin-bottom: 5px;
            margin-top: 20px;
        }

        /* Media Queries untuk tampilan yang lebih kecil */
        @media (max-width: 768px) {
            .features div {
                flex: 1 1 100%; /* Full width on small screens */
            }
    </style>
</head>
<body>
    <header>
        <h1>S I A P - Admin Dashboard</h1>
        <a href="../logout.php" class="logout-btn">Logout</a> <!-- Tombol Logout di Header -->
    </header>

    <div class="container">
        <!-- Informasi Pengguna -->
        <div class="user-info">
            <!-- <h2>Salam Satu Hati</h2> -->
            <div class="logo">
                <img src="../asset/astra.png" alt="Logo"> <!-- Ganti dengan path gambar logo -->
            </div>
        </div>

        <!-- Fitur User -->
        <div class="features">
            <div>
                <h3>Hasil Inspeksi</h3>
                <p>Unduh laporan inspeksi.</p>
                <a href="../laporan-inspeksi/laporaninspeksi.php">Lihat Detail</a>
            </div>
            <div>
                <h3>Jadwal Inspeksi</h3>
                <p>Check jadwal inspeksi.</p>
                <a href="../jadwal/jadwalinspeksi.php">Lihat Jadwal</a>
            </div>
            <div>
                <h3>Data APAR</h3>
                <p>Lihat lokasi APAR.</p>
                <a href="inventoryadmin.php">Lihat Data APAR</a>
            </div>
            <div>
                <h3>List User</h3>
                <p>Lihat semua user yang ada.</p>
                <a href="listuser.php">Lihat User</a>
            </div>
        </div>
    </div>

    <footer>
    <p>&copy; <?= date("Y") ?> SIAP. All rights reserved</p>
    </footer>
</body>
</html>
<?