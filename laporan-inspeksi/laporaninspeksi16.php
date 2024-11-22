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

$BA = 'H555'; // Ganti dengan BA yang sesuai
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Query untuk mengambil data berdasarkan BA dan bulan/tahun tertentu, menghindari duplikasi tanggal
$query = "SELECT BA, MIN(tanggal) AS tanggal, alamat 
          FROM inspections 
          WHERE BA = :ba 
            AND MONTH(tanggal) = :month 
            AND YEAR(tanggal) = :year
          GROUP BY BA, alamat
          ORDER BY tanggal ASC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':ba', $BA, PDO::PARAM_STR);
$stmt->bindParam(':month', $selectedMonth, PDO::PARAM_INT);
$stmt->bindParam(':year', $selectedYear, PDO::PARAM_INT);
$stmt->execute();

// Ambil data inventaris dari database
$inventory_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil bulan untuk form filter
$months = range(1, 12);

// Ambil semua tahun yang ada di database
$yearQuery = "SELECT DISTINCT YEAR(tanggal) as year FROM inspections ORDER BY year ASC";
$yearStmt = $pdo->prepare($yearQuery);
$yearStmt->execute();
$years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);

// Tambahkan tahun saat ini dan beberapa tahun ke depan untuk dropdown
$currentYear = date('Y');
$years = array_merge(range($currentYear - 5, $currentYear + 1000), $years);
$years = array_unique($years); // Hapus duplikat
sort($years); // Urutkan tahun
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Inspeksi - S I A Pk</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
        }
        .filter-form {
            margin-bottom: 20px;
            text-align: center;
        }
        .filter-form select {
            padding: 10px;
            margin: 0 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 700;
        }
        tr:hover {
            background-color: #ecf0f1;
        }
        .button {
            background-color: #27ae60;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s;
            font-size: 12px;
            text-align: center;
        }
        .button:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Laporan Inspeksi</h1>

        <form class="filter-form" method="GET" action="">
            <label for="month">Bulan:</label>
            <select name="month" id="month">
                <?php foreach ($months as $month): ?>
                <option value="<?php echo $month; ?>" <?php if ($month == $selectedMonth) echo 'selected'; ?>>
                    <?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="year">Tahun:</label>
            <select name="year" id="year">
                <?php foreach ($years as $year): ?>
                <option value="<?php echo $year; ?>" <?php if ($year == $selectedYear) echo 'selected'; ?>>
                    <?php echo $year; ?>
                </option>
                <?php endforeach; ?>
            </select>

            <input type="hidden" name="BA" value="<?php echo htmlspecialchars($BA); ?>">
            <button type="submit" class="button">Tampilkan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>BA</th>
                    <th>Bulan Inspeksi</th>
                    <th>Alamat</th>
                    <th>Unduh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['BA']); ?></td>
                    <td><?php echo date('F Y', strtotime($item['tanggal'])); ?></td>
                    <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                    <td>
                        <a href="../generatePDF.php?ba=<?php echo urlencode($item['BA']); ?>&month=<?php echo urlencode($selectedMonth); ?>&year=<?php echo urlencode($selectedYear); ?>" class="button">Unduh</a>
                     </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
