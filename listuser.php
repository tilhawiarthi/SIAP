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

// Role yang akan ditampilkan
$role = "user"; // Bisa diganti dengan "moderator" atau peran lainnya
$sql = "SELECT id, username, email FROM users WHERE role = '$role'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna - Role: <?php echo ucfirst($role); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Reset browser default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .table-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
            color: #333;
            font-weight: bold;
        }

        td {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-users {
            text-align: center;
            font-size: 18px;
            color: #555;
            padding: 20px 0;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .table-container {
                padding: 10px;
            }

            th, td {
                font-size: 12px;
                padding: 8px;
            }

            h2 {
                font-size: 20px;
            }
        }

        /* Button styles */
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #5cb85c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Daftar <?php echo ucfirst($role); ?></h2>

    <?php
    // Cek apakah query berhasil
    if ($result->num_rows > 0) {
        // Tampilkan data dalam tabel
        echo "<table>";
        echo "<tr><th>Username</th><th>Email</th></tr>";
        
        // Looping data untuk setiap baris
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // Pesan jika tidak ada pengguna ditemukan
        echo "<p class='no-users'>Tidak ada pengguna dengan role '$role' ditemukan.</p>";
    }

    // Tutup koneksi
    $conn->close();
    ?>

    <a href="user1.php" class="button">Kembali ke Dashboard</a>
</div>

</body>
</html>
