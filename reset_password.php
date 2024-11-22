<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "firecheck1");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Update password jika token valid dan belum expired
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expire = NULL WHERE reset_token = ? AND reset_token_expire > NOW()");
        $stmt->bind_param("ss", $new_password, $token);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Password berhasil direset!";
        } else {
            echo "Token tidak valid atau sudah kadaluarsa.";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "Token tidak valid.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="">
        <input type="password" name="password" placeholder="Masukkan password baru" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
