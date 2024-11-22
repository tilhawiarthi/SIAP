<?php
// Mulai sesi
// session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['id'])) {
    header("Location: home.php"); // Ganti dengan halaman utama aplikasi Anda
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form register
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Simpan data pengguna ke database (sesuaikan dengan koneksi database Anda)
    $conn = new mysqli('localhost', 'root', '', 'firecheck1'); // Ganti dengan kredensial database Anda
    
    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    // Periksa apakah username sudah ada
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error_message = "Nama pengguna sudah terdaftar!";
    } else {
        // Simpan pengguna baru ke database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $username; // Simpan data pengguna di sesi
            header("Location: index.php"); // Redirect ke halaman utama setelah registrasi
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan data. Coba lagi!";
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - S I A P</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('asset/we.jpg'); /* Ganti dengan path gambar latar belakang */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            text-align: center;
            height: 100vh;
            margin: 0;
            position: relative;
            padding: 20px;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan transparansi 50% */
            z-index: 1; /* Overlay ini di bawah konten lainnya */
            }

            .container-wrapper {
                position: relative;
                z-index: 2; /* Agar konten di atas overlay */
            }
        .container {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container-wrapper">
        <?php if (!empty($error_message)) : ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>

    <div class="container">
        <img src="asset/astra.png" alt="Logo Astra">
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Nama Pengguna</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
