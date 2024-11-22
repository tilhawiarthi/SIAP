<?php
// Koneksi ke database
$host = 'localhost';
$db = 'firecheck1';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['No_Apar'])) {
    $noApar = $conn->real_escape_string($_POST['No_Apar']);
    $query = "SELECT * FROM inventory WHERE no_apar = '$noApar'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>