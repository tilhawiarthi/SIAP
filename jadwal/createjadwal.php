<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Inspeksi</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
        }
        .form-label {
            color: #495057;
            font-weight: 500;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Tambah Jadwal Inspeksi Baru</h2>
        <form action="proses_tambah_jadwal.php" method="POST">
            <div class="mb-3">
                <label for="nama_inspeksi" class="form-label">Nama Inspeksi</label>
                <input type="text" class="form-control" id="nama_inspeksi" name="nama_inspeksi" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_inspeksi" class="form-label">Tanggal Inspeksi</label>
                <input type="date" class="form-control" id="tanggal_inspeksi" name="tanggal_inspeksi" required>
            </div>
            <div class="mb-3">
                <label for="waktu_inspeksi" class="form-label">Waktu Inspeksi</label>
                <input type="time" class="form-control" id="waktu_inspeksi" name="waktu_inspeksi" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="jadwalinspeksi.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Script JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
