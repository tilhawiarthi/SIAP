<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code APAR - S I A P</title>
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
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 500;
            color: #666;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 20px;
            }

            .form-group input,
            .form-group button {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Generate QR Code APAR</h1>
        <h2>Input Data</h2>
        <form action="submitqr.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="No_Apar">No Apar</label>
                <input type="text" id="No_Apar" name="No_Apar" onblur="fetchData()" required>
            </div>
            <div class="form-group">
                <label for="Region">Region</label>
                <input type="text" id="Region" name="Region" required>
            </div>
            <div class="form-group">
                <label for="BA">BA</label>
                <input type="text" id="BA" name="BA" required>
            </div>
            <div class="form-group">
                <label for="SO">SO</label>
                <input type="text" id="SO" name="SO" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="lantai">Lantai</label>
                <input type="text" id="lantai" name="lantai" required>
            </div>
            <div class="form-group">
                <label for="ruangan">Ruangan</label>
                <input type="text" id="ruangan" name="ruangan" required>
            </div>
            <div class="form-group">
                <label for="titik_penempatan">Titik Penempatan</label>
                <input type="text" id="titik_penempatan" name="titik_penempatan" required>
            </div>
            <div class="form-group">
                <label for="merk">Merk</label>
                <input type="text" id="merk" name="merk" required>
            </div>
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" id="tipe" name="tipe" required>
            </div>
            <div class="form-group">
                <label for="jenis_isi">Jenis Isi</label>
                <input type="text" id="jenis_isi" name="jenis_isi" required>
            </div>
            <div class="form-group">
                <label for="berat_isi">Berat Isi</label>
                <input type="text" id="berat_isi" name="berat_isi" required>
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
                <button type="submit">Generate QR Code</button>
            </div>
        </form>
    </div>
</body>
</html>
<script>
    function fetchData() {
        var noApar = document.getElementById("No_Apar").value;
        if (noApar) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_data.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    if (data) {
                        document.getElementById("tanggal").value = data.tanggal; 
                        document.getElementById("region").value = data.region;
                        document.getElementById("ba").value = data.ba;
                        document.getElementById("so").value = data.so;
                        document.getElementById("alamat").value = data.alamat;
                        document.getElementById("lantai").value = data.lantai;
                        document.getElementById("ruangan").value = data.ruangan;
                        document.getElementById("titik_penempatan").value = data.titik_penempatan;
                        document.getElementById("merk").value = data.merk;
                        document.getElementById("tipe").value = data.tipe;
                        document.getElementById("jenis_isi").value = data.jenis_isi;
                        document.getElementById("berat_isi").value = data.berat_isi;
                        document.getElementById("Tahun_Produksi").value = data.Tahun_Produksi;
                        document.getElementById("Tahun_Expired").value = data.Tahun_Expired;
                    }
                }
            };
            xhr.send("no_apar=" + noApar);
        }
    }

    function generateQRCode() {
            var data = {
                No_Apar: document.getElementById("no_apar").value,
                Region: document.getElementById("region").value,
                BA: document.getElementById("ba").value,
                SO: document.getElementById("so").value,
                Alamat: document.getElementById("alamat").value,
                Lantai: document.getElementById("lantai").value,
                Ruangan: document.getElementById("ruangan").value,
                Titik_Penempatan: document.getElementById("titik_penempatan").value,
                Merk: document.getElementById("merk").value,
                Tipe: document.getElementById("tipe").value,
                Jenis_Isi: document.getElementById("jenis_isi").value,
                Berat_Isi: document.getElementById("berat_isi").value,
                Tahun_Produksi: document.getElementById("Tahun_Produksi").value,
                Tahun_Expired: document.getElementById("Tahun_Expired").value
            };

            // Generate QR Code
            $('#qrcode').empty(); // Clear previous QR code
            $('#qrcode').qrcode(JSON.stringify(data));

        }
</script>
</html>
