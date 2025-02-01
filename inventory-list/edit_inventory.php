<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'firecheck1';
$username = 'root';  // Ganti sesuai dengan username database Anda
$password = '';  // Ganti sesuai dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Ambil `no_apar` dari URL
if (!isset($_GET['no_apar'])) {
    die("Error: No APAR tidak ditemukan.");
}

$no_apar = $_GET['no_apar'];

// Ambil data berdasarkan `no_apar`
$query = "SELECT * FROM inventory WHERE no_apar = :no_apar";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':no_apar', $no_apar, PDO::PARAM_STR);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Error: Data tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $region = $_POST['region'];
    $ba = $_POST['ba'];
    $so = $_POST['so'];
    $alamat = $_POST['alamat'];
    $lantai = $_POST['lantai'];
    $ruangan = $_POST['ruangan'];
    $titik_penempatan = $_POST['titik_penempatan'];
    $merk = $_POST['merk'];
    $tipe = $_POST['tipe'];
    $jenis_isi = $_POST['jenis_isi'];
    $berat_isi = $_POST['berat_isi'];
    $tahun_produksi = $_POST['Tahun_Produksi'];
    $tahun_expired = $_POST['Tahun_Expired'];

    // Query update data
    $updateQuery = "UPDATE inventory SET 
        region = :region, ba = :ba, so = :so, alamat = :alamat, lantai = :lantai,
        ruangan = :ruangan, titik_penempatan = :titik_penempatan, merk = :merk,
        tipe = :tipe, jenis_isi = :jenis_isi, berat_isi = :berat_isi,
        Tahun_Produksi = :tahun_produksi, Tahun_Expired = :tahun_expired
        WHERE no_apar = :no_apar";

    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':ba', $ba);
    $stmt->bindParam(':so', $so);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':lantai', $lantai);
    $stmt->bindParam(':ruangan', $ruangan);
    $stmt->bindParam(':titik_penempatan', $titik_penempatan);
    $stmt->bindParam(':merk', $merk);
    $stmt->bindParam(':tipe', $tipe);
    $stmt->bindParam(':jenis_isi', $jenis_isi);
    $stmt->bindParam(':berat_isi', $berat_isi);
    $stmt->bindParam(':tahun_produksi', $tahun_produksi);
    $stmt->bindParam(':tahun_expired', $tahun_expired);
    $stmt->bindParam(':no_apar', $no_apar);

    if ($stmt->execute()) {
        header("Location: inventory.php?success=update");
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory - SIAP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
            transition: background 0.3s;
            cursor: pointer;
            border: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #dc3545;
            margin-top: 10px;
        }
        .back-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Inventory</h2>
    <form method="post">
        <label>Region</label>
        <input type="text" name="region" value="<?php echo htmlspecialchars($item['region']); ?>" required>

        <label>BA</label>
        <input type="text" name="ba" value="<?php echo htmlspecialchars($item['ba']); ?>" required>

        <label>SO</label>
        <input type="text" name="so" value="<?php echo htmlspecialchars($item['so']); ?>" required>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?php echo htmlspecialchars($item['alamat']); ?>" required>

        <label>Lantai</label>
        <input type="text" name="lantai" value="<?php echo htmlspecialchars($item['lantai']); ?>" required>

        <label>Ruangan</label>
        <input type="text" name="ruangan" value="<?php echo htmlspecialchars($item['ruangan']); ?>" required>

        <label>Titik Penempatan</label>
        <input type="text" name="titik_penempatan" value="<?php echo htmlspecialchars($item['titik_penempatan']); ?>" required>

        <label>Merk</label>
        <input type="text" name="merk" value="<?php echo htmlspecialchars($item['merk']); ?>" required>

        <label>Tipe</label>
        <input type="text" name="tipe" value="<?php echo htmlspecialchars($item['tipe']); ?>" required>

        <label>Jenis Isi</label>
        <input type="text" name="jenis_isi" value="<?php echo htmlspecialchars($item['jenis_isi']); ?>" required>

        <label>Berat Isi</label>
        <input type="text" name="berat_isi" value="<?php echo htmlspecialchars($item['berat_isi']); ?>" required>

        <label>Tahun Produksi</label>
        <input type="text" name="Tahun_Produksi" value="<?php echo htmlspecialchars($item['Tahun_Produksi']); ?>" required>

        <label>Tahun Expired</label>
        <input type="text" name="Tahun_Expired" value="<?php echo htmlspecialchars($item['Tahun_Expired']); ?>" required>

        <button type="submit" class="button">Simpan Perubahan</button>
        <a href="inventorylist1.php" class="button back-button">Batal</a>
    </form>
</div>

</body>
</html>
