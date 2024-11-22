<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengisian - S I A P</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #b71c1c 50%, #450000 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
            text-align: center;
        }

        h2 {
            color: #555;
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #666;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-group input[type="file"] {
            padding: 0;
            border: none;
            margin-top: 5px;
        }

        .form-group select {
            padding-right: 35px;
            appearance: none;
            background: url('data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns%3D%27http%3A//www.w3.org/2000/svg%27 width%3D%2724%27 height%3D%2724%27 viewBox%3D%270 0 24 24%27 fill%3D%27none%27 stroke%3D%27%23666%27 stroke-width%3D%272%27 stroke-linecap%3D%27round%27 stroke-linejoin%3D%27round%27 class%3D%27feather feather-chevron-down%27%3E%3Cpolyline points%3D%276 9 12 15 18 9%27/%3E%3C/svg%3E') no-repeat right 15px center;
            background-size: 16px;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Form Pengisian</h1>
        <h2>Data Inspeksi</h2>
        <form action="submit_inspeksi.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <div class="form-group">
                <label for="Nama_Petugas">Nama Petugas</label>
                <input type="text" id="Nama_Petugas" name="Nama_Petugas" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Inspeksi</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="kondisi_serbuk">Kondisi Serbuk</label>
                <input type="text" id="kondisi_serbuk" name="kondisi_serbuk" required>
            </div>
            <div class="form-group">
                <label for="tekanan_catridge">Tekanan Catridge</label>
                <input type="text" id="tekanan_catridge" name="tekanan_catridge" required>
            </div>
            <div class="form-group">
                <label for="Tahun_Produksi">Tahun Produksi</label>
                <input type="date" id="Tahun_Produksi" name="Tahun_Produksi" required>
            </div>
            <div class="form-group">
                <label for="Tahun_Expired">Tahun Expired</label>
                <input type="date" id="Tahun_Expired" name="Tahun_Expired" required>
            </div>
            <div class="form-group">
                <label for="tabung">Tabung</label>
                <select id="tabung" name="tabung" required>
                    <option value="" disabled selected>Pilih Kondisi Tabung</option>
                    <option value="berkarat">Berkarat</option>
                    <option value="tidak_berkarat">Tidak Berkarat</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tabung_image">Foto Tabung(jika ada kerusakan)</label>
                <input type="file" id="tabung_image" name="tabung_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="segel">Segel</label>
                <select id="segel" name="segel" required>
                    <option value="" disabled selected>Pilih Kondisi Segel</option>
                    <option value="putus">Putus</option>
                    <option value="tidak_putus">Tidak Putus</option>
                </select>
            </div>
            <div class="form-group">
                <label for="segel_image">Foto Segel(jika ada kerusakan)</label>
                <input type="file" id="segel_image" name="segel_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="pin_pengaman">Pin Pengaman</label>
                <select id="pin_pengaman" name="pin_pengaman" required>
                    <option value="" disabled selected>Pilih Kondisi Pin Pengaman</option>
                    <option value="ada">Ada</option>
                    <option value="tidak_ada">Tidak Ada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pin_pengaman_image">Foto Pin Pengaman(jika ada kerusakan)</label>
                <input type="file" id="pin_pengaman_image" name="pin_pengaman_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="selang">Selang</label>
                <select id="selang" name="selang" required>
                    <option value="" disabled selected>Pilih Kondisi Selang</option>
                    <option value="patah">Patah</option>
                    <option value="tidak_patah">Tidak Patah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selang_image">Foto Selang(jika ada kerusakan)</label>
                <input type="file" id="selang_image" name="selang_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="nozzel">Nozzel</label>
                <select id="nozzel" name="nozzel" required>
                    <option value="" disabled selected>Pilih Kondisi Nozzel</option>
                    <option value="pecah">Pecah</option>
                    <option value="tidak_pecah">Tidak Pecah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nozzel_image">Foto Nozzel(jika ada kerusakan)</label>
                <input type="file" id="nozzel_image" name="nozzel_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="seal_nozzel">Seal Nozzel</label>
                <select id="seal_nozzel" name="seal_nozzel" required>
                    <option value="" disabled selected>Pilih Kondisi Seal Nozzel</option>
                    <option value="robek">Robek</option>
                    <option value="tidak_robek">Tidak Robek</option>
                </select>
            </div>
            <div class="form-group">
                <label for="seal_nozzel_image">Foto Seal Nozzel(jika ada kerusakan)</label>
                <input type="file" id="seal_nozzel_image" name="seal_nozzel_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="rambu">Rambu Rambu</label>
                <select id="rambu" name="rambu" required>
                    <option value="" disabled selected>Pilih Kondisi Rambu</option>
                    <option value="ada">Ada</option>
                    <option value="tidak_ada">Tidak Ada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rambu_image">Foto Rambu Rambu(jika ada kerusakan)</label>
                <input type="file" id="rambu_image" name="rambu_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="clear_area">Clear Area</label>
                <input type="text" id="clear_area" name="clear_area" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
