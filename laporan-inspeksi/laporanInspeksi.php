<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Inspeksi - S I A P</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #0288d1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, transform 0.3s;
        }
        .back-button:hover {
            background-color: #0277bd;
            transform: translateY(-2px);
        }
        .back-button .arrow-left {
            margin-right: 10px;
            font-weight: bold;
        }
        h1 {
            color: #000 ;
            margin-bottom: 30px;
            text-align: center;
            font-size: 50px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .branch-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .branch-item {
            background: #007bff;
            color: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
        }
        .branch-item:hover {
            background-color: #0277bd;
            transform: translateY(-5px);
        }
        .branch-name {
            flex-grow: 1;
            color : #fff;
            font-size: 18px;
            font-weight: 600;
        }
        .view-details {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .view-details:hover {
            background-color: #00695c;
            transform: translateY(-2px);
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #bbb;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hasil Laporan</h1>
        <div class="form-group">
            <input type="text" id="searchInput" onkeyup="filterBranches()" placeholder="Cari berdasarkan nama cabang...">
        </div>
        <ul class="branch-list">
            <li class="branch-item">
                <span class="branch-name">Astra Motor Region Bali</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi1.php?branch=2'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Gianyar</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi2.php?branch=2'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Singaraja</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi3.php?branch=3'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Nusa Dua</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi4.php?branch=4'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Seririt</span>
                <button class="view-details" onclick="window.location.href='aporaninspeksi5.php?branch=5'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Tabanan</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi6.php?branch=6'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Teuku Umar</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi7.php?branch=7'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Karangasem</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi8.php?branch=8'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Negara</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi9.php?branch=9'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Kuta</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi10.php?branch=10'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Gunung Agung</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi11.php?branch=11'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Sesetan</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi12.php?branch=12'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor NDS Cokro</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi13.php?branch=13'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Sangsit</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi14.php?branch=14'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Gn. Sanghyang</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi15.php?branch=15'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Batubulan</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi16.php?branch=16'">View Details</button>
            </li>
            <li class="branch-item">
                <span class="branch-name">Astra Motor Gianyar 2</span>
                <button class="view-details" onclick="window.location.href='laporaninspeksi17.php?branch=17'">View Details</button>
            </li>
        </ul>
    </div>
    <script>
        function filterBranches() {
            var input, filter, ul, li, span, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            ul = document.querySelector('.branch-list');
            li = ul.getElementsByClassName('branch-item');

            for (i = 0; i < li.length; i++) {
                span = li[i].getElementsByClassName('branch-name')[0];
                txtValue = span.textContent || span.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
