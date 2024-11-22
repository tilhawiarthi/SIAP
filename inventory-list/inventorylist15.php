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

$ba = 'H554';

// Query dengan prepared statement untuk memanggil data berdasarkan BA tertentu
$query = "SELECT DISTINCT * FROM inventory WHERE ba = :ba ORDER BY no_apar ASC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':ba', $ba, PDO::PARAM_STR);
$stmt->execute();

// Ambil data inventaris dari database
$inventory_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menghapus duplikasi data jika diperlukan
$unique_inventory_items = [];
foreach ($inventory_items as $item) {
    $unique_inventory_items[$item['no_apar']] = $item;
}
$inventory_items = array_values($unique_inventory_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List - S I A P</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        /* .container { */
           /* width: 100%; atau bisa dihapus max-width */
            /* margin: 50px auto; */
            /* background: #fff; */
            /* padding: 40px; */
            /* border-radius: 10px; */
            /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); */
        /* } */

        h1 {
            font-size: 28px;
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #c82333;
        }
        .back-button .arrow-left {
            margin-right: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 16px;
        }
        table thead {
            background-color: #343a40;
            color: #fff;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        table th {
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
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
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventory List</h1>

        <table>
            <thead>
                <tr>
                    <th>NO APAR</th>
                    <th>region</th>
                    <th>BA</th>
                    <th>SO</th>
                    <th>Alamat</th>
                    <th>Lantai</th>
                    <th>Ruangan</th>
                    <th>Titik Penempatan</th>
                    <th>merk</th>
                    <th>tipe</th>
                    <th>jenis isi</th>
                    <th>berat isi</th>
                    <th>Tahun Produksi</th>
                    <th>Tahun Expired</th>  
                    <th>Kode QR</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['no_apar']); ?></td>
                    <td><?php echo htmlspecialchars($item['region']); ?></td>
                    <td><?php echo htmlspecialchars($item['ba']); ?></td>
                    <td><?php echo htmlspecialchars($item['so']); ?></td>
                    <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($item['lantai']); ?></td>
                    <td><?php echo htmlspecialchars($item['ruangan']); ?></td>
                    <td><?php echo htmlspecialchars($item['titik_penempatan']); ?></td>
                    <td><?php echo htmlspecialchars($item['merk']); ?></td>
                    <td><?php echo htmlspecialchars($item['tipe']); ?></td>
                    <td><?php echo htmlspecialchars($item['jenis_isi']); ?></td>
                    <td><?php echo htmlspecialchars($item['berat_isi']); ?></td>
                    <td><?php echo date('F Y', strtotime($item['Tahun_Produksi'])); ?></td>
                    <td><?php echo date('F Y', strtotime($item['Tahun_Expired'])); ?></td>
                    <td>
                         <?php 
                        // Menggabungkan data yang relevan menjadi satu string untuk QR Code
                            $kode = json_encode([
                            'no_apar' => $item['no_apar'],
                            'region' => $item['region'],
                            'ba' => $item['ba'],
                             'so' => $item['so'],
                            'alamat' => $item['alamat'],
                             'lantai' => $item['lantai'],
                             'ruangan' => $item['ruangan'],
                             'titik_penempatan' => $item['titik_penempatan'],
                             'merk' => $item['merk'],
                             'tipe' => $item['tipe'],
                             'jenis_isi' => $item['jenis_isi'],
                             'berat_isi' => $item['berat_isi'],
                             'Tahun_Produksi' => $item['Tahun_Produksi'],
                             'Tahun_Expired' => $item['Tahun_Expired']
                             ]);
    
                                 require_once('../phpqrcode/phpqrcode/qrlib.php');

                                // Ganti parameter ketiga dengan ukuran yang valid, misalnya 4
                                QRcode::png($kode, "kode{$item['no_apar']}.png", QR_ECLEVEL_L, 4, 2);
                                ?>
                                <img src="kode<?php echo htmlspecialchars($item['no_apar']); ?>.png" alt="QR Code for <?php echo htmlspecialchars($item['no_apar']); ?>">
                    </td>>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
