<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - S I A P</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'times', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #b03a2e;
            color: white;
            text-align: center;
            padding: 30px;
        }

        header h1 {
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            box-sizing: border-box;
            margin: auto;
        }

        footer {
            background-color: #b03a2e;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
        }

        .background-red {
            background: linear-gradient(135deg, #cd6155, #b03a2e);
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            color: #ffffff;
            margin-bottom: 30px;
            position: relative;
        }

        .background-red img {
            width: 400px;
            margin-bottom: 5px;
            margin-top: 20px;
        }

        .background-red img:hover {
            transform: scale(1.1);
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .menu-item {
            background: #b03a2e;
            color: white;
            padding: 25px;
            text-decoration: none;
            border-radius: 15px;
            width: 330px;
            text-align: center;
            transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .menu-item:hover {
            background: #943126;
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.3);
        }

        .menu-item img {
            max-width: 70px;
            margin-bottom: 10px;
        }

        .menu-burger {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 40px;
            cursor: pointer;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-burger div {
            width: 100%;
            height: 6px;
            background-color: #ffffff;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 70px;
            right: 20px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            text-align: right;
            z-index: 1000;
            min-width: 180px;
        }

        .dropdown-menu a {
            color: #b03a2e;
            text-decoration: none;
            display: block;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .dropdown-menu a:hover {
            background-color: #f9f9f9;
            color: #943126;
        }

        @media (max-width: 768px) {
            .background-red img {
                max-width: 90%;
            }

            .menu-item {
                width: 180px;
                padding: 20px;
            }

            .menu-burger {
                width: 40px;
                height: 30px;
            }

            .menu-burger div {
                height: 5px;
            }
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
            height: auto; /* Mempertahankan rasio aspek gambar */
            margin-bottom: 60px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>S I A P</h1>
        <h2>(Sistem Inspeksi Alat Pemadam)</h2>
        <div class="menu-burger" onclick="toggleDropdown()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </header>

    <div class="container">
        <div class="logo">
            <img src="asset/astra.png" alt="logo">
        </div>
        <div class="menu">
            <a href="generateqr.php" class="menu-item">
                <img src="asset/123.png" alt="Pengisian Form">
                <p>Input Data APAR</p>
            </a>
            <a href="scan_qr.php" class="menu-item">
                <img src="asset/qr.png" alt="scanqr">
                <p>Scan QR <br> (Pemeriksaan APAR)</p>
            </a>
            <a href="jadwal/jadwalInspeksi.php" class="menu-item">
                <img src="asset/jadwal.png" alt="Jadwal Inspeksi">
                <p>Jadwal Inspeksi</p>
            </a>
            <a href="inventory-list/inventory.php" class="menu-item">
                <img src="asset/kerdus.png" alt="Inventory">
                <p>Data APAR</p>
            </a>
        </div>
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> SIAP. All rights reserved</p>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>

</html>
