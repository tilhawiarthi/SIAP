<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

$BA = isset($_GET['ba']) ? $_GET['ba'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Query untuk mengambil data berdasarkan BA dan bulan/tahun tertentu
$query = "SELECT * FROM laporan_inspeksi WHERE BA = :ba AND MONTH(tanggal) = :month AND YEAR(tanggal) = :year";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':ba', $BA, PDO::PARAM_STR);
$stmt->bindParam(':month', $month, PDO::PARAM_INT);
$stmt->bindParam(':year', $year, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($items) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set header
    $headers = [
        'No Apar', 'Region', 'BA', 'SO', 'Alamat', 'Lantai', 'Ruangan',
        'Titik Penempatan', 'Merk', 'Tipe', 'Jenis Isi', 'Berat Isi', 'Tahun Produksi', 'Tahun Expored', 'Nama_Petugas', 'Tanggal',
        'Kondisi Serbuk', 'Tekanan Catridge', 'Tabung', 'Foto Tabung', 'Segel', 'Foto Segel', 
        'Pin Pengaman', 'Foto Pin Pengaman', 'Selang', 'Foto Selang', 
        'Nozzel', 'Foto Nozzel', 'Seal Nozzel', 'Foto Seal Nozzel', 
        'Rambu Rambu', 'Foto Rambu Rambu', 'Clear Area', 'Keterangan'
    ];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    // Apply styles to header row
    $sheet->getStyle('A1:AH1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FFFF00']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // Set column widths for header
    $columnWidths = [
        'A' => 10, 'B' => 10, 'C' => 10, 'D' => 10, 'E' => 15, 'F' => 10,
        'G' => 20, 'H' => 20, 'I' => 20, 'J' => 15, 'K' => 15, 'L' => 15,
        'M' => 20, 'N' => 20, 'O' => 20, 'P' => 20, 'Q' => 20, 'R' => 15,
        'S' => 20, 'T' => 15, 'U' => 20, 'V' => 15, 'W' => 20, 'X' => 15,
        'Y' => 20, 'Z' => 15, 'AA' => 20, 'AB' => 15, 'AC' => 20, 'AD' => 15,
        'AE' => 20, 'AF' => 20,'AG' => 20, 'AH' => 25, 
    ];

    foreach ($columnWidths as $colID => $width) {
        $sheet->getColumnDimension($colID)->setWidth($width);
    }

    // Add data
    $row = 2;
    foreach ($items as $item) {
        $sheet->setCellValue('A' . $row, $item['no_apar']);
        $sheet->setCellValue('B' . $row, $item['region']);
        $sheet->setCellValue('C' . $row, $item['ba']);
        $sheet->setCellValue('D' . $row, $item['so']);
        $sheet->setCellValue('E' . $row, $item['alamat']);
        $sheet->setCellValue('F' . $row, $item['lantai']);
        $sheet->setCellValue('G' . $row, $item['ruangan']);
        $sheet->setCellValue('H' . $row, $item['titik_penempatan']);
        $sheet->setCellValue('I' . $row, $item['merk']);
        $sheet->setCellValue('J' . $row, $item['tipe']);
        $sheet->setCellValue('K' . $row, $item['jenis_isi']);
        $sheet->setCellValue('L' . $row, $item['berat_isi']);
        $sheet->setCellValue('M' . $row, date('Y F d ', strtotime($item['Tahun_Produksi'])));
        $sheet->setCellValue('N' . $row, date('Y F d', strtotime($item['Tahun_Expired'])));
        $sheet->setCellValue('O' . $row, $item['Nama_Petugas']);
        $sheet->setCellValue('P' . $row, date('Y F d', strtotime($item['tanggal'])));
        $sheet->setCellValue('Q' . $row, $item['kondisi_serbuk']);
        $sheet->setCellValue('R' . $row, $item['tekanan_catridge']);
        $sheet->setCellValue('S' . $row, $item['tabung']);
        if (!empty($item['tabung_image']) && file_exists($item['tabung_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['tabung_image']);
            $drawing->setCoordinates('T' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('T' . $row, 'Tidak ada kerusakan');
        }

        $sheet->setCellValue('U' . $row, $item['segel']);

        if (!empty($item['segel_image']) && file_exists($item['segel_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['segel_image']);
            $drawing->setCoordinates('V' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('V' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('W' . $row, $item['pin_pengaman']);
        if (!empty($item['pin_pengaman_image']) && file_exists($item['pin_pengaman_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['pin_pengaman_image']);
            $drawing->setCoordinates('X' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('X' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('Y' . $row, $item['selang']);
        if (!empty($item['selang_image']) && file_exists($item['selang_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['selang_image']);
            $drawing->setCoordinates('Z' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('Z' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('AA' . $row, $item['nozzel']);
        if (!empty($item['nozzel_image']) && file_exists($item['nozzel_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['nozzel_image']);
            $drawing->setCoordinates('AB' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('AB' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('AC' . $row, $item['seal_nozzel']);
        if (!empty($item['seal_nozzel_image']) && file_exists($item['seal_nozzel_image'])) {
            $rowHeight = 40; 
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['seal_nozzel_image']);
            $drawing->setCoordinates('AD' . $row);
            $drawing->setHeight($rowHeight); 
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('AD' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('AE' . $row, $item['rambu_rambu']);
        if (!empty($item['rambu_image']) && file_exists($item['rambu_image'])) {
            $rowHeight = 40; // Sesuaikan dengan tinggi gambar yang diinginkan
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);
            $drawing = new Drawing();
            $drawing->setPath($item['rambu_image']);
            $drawing->setCoordinates('AF' . $row);
            $drawing->setHeight($rowHeight); // Sesuaikan dengan tinggi baris
            $drawing->setWorksheet($sheet);
        } else {
            $sheet->setCellValue('AF' . $row, 'Tidak ada kerusakan');
        }
        $sheet->setCellValue('AG' . $row, $item['clear_area']);
        $sheet->setCellValue('AH' . $row, $item['keterangan']);
 

        // Apply center alignment to the data row
        $sheet->getStyle('A' . $row . ':AH' . $row)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $row++;
    }
    
    // Apply borders to the entire table
    $sheet->getStyle('A1:AH' . ($row - 1))->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ]
    ]);

    // Generate Excel file
    $writer = new Xlsx($spreadsheet);
    
    // Output file to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Inspeksi_' . $BA . '_' . $month . '_' . $year . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    // Flush output buffer to prevent corrupt files
    if (ob_get_contents()) ob_end_clean();

    $writer->save('php://output');
    exit;
} else {
    echo "Laporan tidak ditemukan untuk periode tersebut.";
}
?>
