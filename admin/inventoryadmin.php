<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - S I A P</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
            margin: 0;
            color: #333;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff; /* Warna biru */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 50px;
            display: flex;
            align-items: center;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3; /* Warna biru lebih gelap */
        }

        .back-button .arrow-left {
            margin-right: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            padding-top: 80px;
        }

        h1 {
            color: #444;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
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
            background: #007bff; /* Warna biru */
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
            background-color: #0056b3; /* Warna biru lebih gelap */
            transform: translateY(-5px);
        }

        .branch-name {
            flex-grow: 1;
            font-size: 18px;
            font-weight: 600;
        }

        .view-details {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .view-details:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Inventory List</h1>
        <div class="form-group">
            <input type="text" id="searchInput" onkeyup="filterBranches()" placeholder="Cari berdasarkan nama cabang..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
        </div>
        <ul class="branch-list">
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist1.php?branch=1'">
                <span class="branch-name">Astra Motor Region Bali</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist2.php?branch=2'">
                <span class="branch-name">Astra Motor Gianyar</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist3.php?branch=3'">
                <span class="branch-name">Astra Motor Singaraja</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist4.php?branch=4'">
                <span class="branch-name">Astra Motor Nusa Dua</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist5.php?branch=5'">
                <span class="branch-name">Astra Motor Seririt</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist6.php?branch=6'">
                <span class="branch-name">Astra Motor Tabanan</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist7.php?branch=7'">
                <span class="branch-name">Astra Motor Teuku Umar</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist8.php?branch=8'">
                <span class="branch-name">Astra Motor Karangasem</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist9.php?branch=9'">
                <span class="branch-name">Astra Motor Negara</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist10.php?branch=10'">
                <span class="branch-name">Astra Motor Kuta</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist11.php?branch=11'">
                <span class="branch-name">Astra Motor Gunung Agung</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist12.php?branch=12'">
                <span class="branch-name">Astra Motor Sesetan</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist13.php?branch=13'">
                <span class="branch-name">Astra Motor NDS Cokro</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist14.php?branch=14'">
                <span class="branch-name">Astra Motor Sangsit</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist15.php?branch=15'">
                <span class="branch-name">Astra Motor Gn. Sanghyang</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist16.php?branch=16'">
                <span class="branch-name">Astra Motor Batubulan</span>
                <button class="view-details">View Details</button>
            </li>
            <li class="branch-item" onclick="window.location.href='../inventory-list/inventorylist17.php?branch=17'">
                <span class="branch-name">Astra Motor Gianyar 2</span>
                <button class="view-details">View Details</button>
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
