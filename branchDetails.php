<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "firecheck1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$branchId = isset($_GET['branch']) ? intval($_GET['branch']) : 0;

if ($branchId <= 0) {
    die("Invalid branch ID.");
}

$sql = "SELECT * FROM branches WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $branchId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $branch = $result->fetch_assoc();
} else {
    die("Branch not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Details - S I A P</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .branch-info {
            text-align: left;
            margin-top: 20px;
        }
        .branch-info label {
            font-weight: bold;
        }
        .branch-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Branch Office Details</h1>
        <div class="branch-info">
            <p><label for="ba">Name:</label> <?php echo htmlspecialchars($branch['ba']); ?></p>
            <p><label for="alamat">Address:</label> <?php echo htmlspecialchars($branch['alamat']); ?></p>
            <p><label for="lantai">Contact:</label> <?php echo htmlspecialchars($branch['lantai']); ?></p>
            <p><label for="ruangan">Contact:</label> <?php echo htmlspecialchars($branch['ruangan']); ?></p>
            <p><label for="titik_penempatan">Contact:</label> <?php echo htmlspecialchars($branch['titik_penempatan']); ?></p>
            <p><label for="status">Contact:</label> <?php echo htmlspecialchars($branch['status']); ?></p>
        </div>
        <a href="inventory.php">Back to Inventory</a>
    </div>
</body>
</html>
