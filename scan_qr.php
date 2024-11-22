<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemindai QR Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
        }
        video {
            width: 100%;
            max-width: 600px;
            border: 2px solid black;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .result {
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            display: none; /* Sembunyikan hasil sampai pemindaian berhasil */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: black;
            outline: none;
        }
    </style>
</head>
<body>
    <h1>Pemindai Kode QR</h1>
    <video id="video" playsinline></video>

    <div class="result" id="result">
        <h2>Hasil Pemindaian:</h2>
        <form action="submit_inspeksi.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="no_apar">No Apar</label>
                <input type="text" id="no_apar" name="no_apar" readonly>
            </div>
            <div class="form-group">
                <label for="region">Region</label>
                <input type="text" id="region" name="region" readonly>
            </div>
            <div class="form-group">
                <label for="ba">BA</label>
                <input type="text" id="ba" name="ba" readonly>
            </div>
            <div class="form-group">
                <label for="so">SO</label>
                <input type="text" id="so" name="so" readonly>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" readonly>
            </div>
            <div class="form-group">
                <label for="lantai">Lantai</label>
                <input type="text" id="lantai" name="lantai" readonly>
            </div>
            <div class="form-group">
                <label for="ruangan">Ruangan</label>
                <input type="text" id="ruangan" name="ruangan" readonly>
            </div>
            <div class="form-group">
                <label for="titik_penempatan">Titik Penempatan</label>
                <input type="text" id="titik_penempatan" name="titik_penempatan" readonly>
            </div>
            <div class="form-group">
                <label for="merk">Merk</label>
                <input type="text" id="merk" name="merk" readonly>
            </div>
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" id="tipe" name="tipe" readonly>
            </div>
            <div class="form-group">
                <label for="jenis_isi">Jenis Isi</label>
                <input type="text" id="jenis_isi" name="jenis_isi" readonly>
            </div>
            <div class="form-group">
                <label for="berat_isi">Berat Isi</label>
                <input type="text" id="berat_isi" name="berat_isi" readonly>
            </div>
            <div class="form-group">
                <label for="Tahun_Produksi">Tahun Produksi</label>
                <input type="text" id="Tahun_Produksi" name="Tahun_Produksi" readonly>
            </div>
            <div class="form-group">
                <label for="Tahun_Expired">Tahun Expired</label>
                <input type="text" id="Tahun_Expired" name="Tahun_Expired" readonly>
            </div>
            <div class="form-group">
                <label for="Nama_Petugas">Nama Petugas</label>
                <input type="text" id="Nama_Petugas" name="Nama_Petugas" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Inspeksi</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="kondisi_serbuk">kondisi Serbuk</label>
                <select id="kondisi_serbuk" name="kondisi_serbuk" required>
                    <option value="" disabled selected>Pilih Kondisi Serbuk</option>
                    <option value="Beku">Beku</option>
                    <option value="Bagus">Bagus</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tekanan_catridge">Tekanan Catridge</label>
                <select id="tekanan_catridge" name="tekanan_catridge" required>
                    <option value="" disabled selected>Pilih Tekanan Catridge</option>
                    <option value="Normal">Normal</option>
                    <option value="Kurang">Kurang</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tekanan_image">Foto Tekanan Catridge (jika ada kerusakan)</label>
                <input type="file" id="tekanan_image" name="tekanan_image" accept="image/*">
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
                <label for="tabung_image">Foto Tabung (jika ada kerusakan)</label>
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
                <label for="segel_image">Foto Segel (jika ada kerusakan)</label>
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
                <label for="pin_pengaman_image">Foto Pin Pengaman (jika ada kerusakan)</label>
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
                <label for="selang_image">Foto Selang (jika ada kerusakan)</label>
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
                <label for="nozzel_image">Foto Nozzel (jika ada kerusakan)</label>
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
                <label for="seal_nozzel_image">Foto Seal Nozzel (jika ada kerusakan)</label>
                <input type="file" id="seal_nozzel_image" name="seal_nozzel_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="rambu_rambu">Rambu Rambu</label>
                <select id="rambu_rambu" name="rambu_rambu" required>
                    <option value="" disabled selected>Pilih Kondisi Rambu</option>
                    <option value="ada">Ada</option>
                    <option value="tidak_ada">Tidak Ada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rambu_image">Foto Rambu Rambu (jika ada kerusakan</label>
                <input type="file" id="rambu_image" name="rambu_image" accept="image/*">
            </div>
           <div class="form-group">
                <label for="clear_area">Clear Area</label>
                <select id="clear_area" name="clear_area" required>
                    <option value="" disabled selected>Pilih Clear Area</option>
                    <option value="terhalang">Terhalang</option>
                    <option value="clear">Clear</option>
                </select>
            </div>
            <div class="form-group">
                <label for="clear_image">Foto Clear Area (jika ada kerusakan)</label>
                <input type="file" id="clear_image" name="clear_image" accept="image/*">
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

    <script>
    const codeReader = new ZXing.BrowserQRCodeReader();

    // Mendapatkan perangkat video
    codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
            // Mencari kamera belakang
            const backCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back'));

            // Jika kamera belakang ditemukan, gunakan ID-nya, jika tidak, gunakan kamera pertama
            const deviceId = backCamera ? backCamera.deviceId : videoInputDevices[0].deviceId;

            // Mulai pemindaian
            codeReader.decodeFromVideoDevice(deviceId, 'video', (result, err) => {
                if (result) {
                    // Sembunyikan elemen video setelah berhasil dipindai
                    document.getElementById('video').style.display = 'none';

                    // Tampilkan hasil pemindaian
                    document.getElementById('result').style.display = 'block';

                    // Misalkan hasil pemindaian adalah string JSON
                    const jsonData = JSON.parse(result.text);

                    // Mengisi input dengan data yang dipindai
                    document.getElementById('no_apar').value = jsonData.no_apar || '';
                    document.getElementById('region').value = jsonData.region || '';
                    document.getElementById('ba').value = jsonData.ba || '';
                    document.getElementById('so').value = jsonData.so || '';
                    document.getElementById('alamat').value = jsonData.alamat || '';
                    document.getElementById('lantai').value = jsonData.lantai || '';
                    document.getElementById('ruangan').value = jsonData.ruangan || '';
                    document.getElementById('titik_penempatan').value = jsonData.titik_penempatan || '';
                    document.getElementById('merk').value = jsonData.merk || '';
                    document.getElementById('tipe').value = jsonData.tipe || '';
                    document.getElementById('jenis_isi').value = jsonData.jenis_isi || '';
                    document.getElementById('berat_isi').value = jsonData.berat_isi || '';

                    // Format Tahun Produksi dan Tahun Expired
                    document.getElementById('Tahun_Produksi').value = jsonData.Tahun_Produksi || '';
                    document.getElementById('Tahun_Expired').value = jsonData.Tahun_Expired || '';

                    // Hentikan pemindaian setelah berhasil
                    codeReader.reset();
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    console.error(err);
                }
            });
        })
        .catch((err) => {
            console.error(err);
        });
</script>
</body>
</html>