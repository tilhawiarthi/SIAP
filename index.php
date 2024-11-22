<?php
session_start(); // Mulai sesi untuk menyimpan data pengguna

$error_message = ''; // Variabel untuk menyimpan pesan kesalahan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Membuat koneksi ke database
    $conn = new mysqli("localhost", "root", "", "firecheck1");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menggunakan prepared statements untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Set session
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role; // Simpan role ke dalam session

            // Daftar email admin
            $admin_emails = ['admin@gmail.com', 'pegasusdps@gmail.com']; // Tambahkan lebih banyak email admin sesuai kebutuhan

            // Cek apakah email termasuk dalam daftar admin
            if (in_array($email, $admin_emails)) {
                // Jika email admin, redirect ke home.php
                header("Location: admin/user1.php");
            } else {
                // Jika bukan admin, redirect ke halaman user
                header("Location: home.php");
            }
            exit(); // Pastikan script berhenti setelah redirect
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Email tidak ditemukan!";
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('asset/we.jpg'); /* Ganti dengan path gambar latar belakang */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
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
            width: 100%;
            max-width: 400px; /* Menyelaraskan dengan lebar container */
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo img {
            width: 100%;
            max-width: 1000px;
            margin-bottom: 15px;
        }
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button[type="submit"] {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        .back-link {
            margin-top: 20px;
            display: block;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #fff;
            background-color: rgba(255, 0, 0, 0.7); /* Kotak merah transparan */
            border: 1px solid #ff0000;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
            width: 100%;
            max-width: 400px; /* Menyelaraskan dengan lebar container */
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
            <div class="logo">
                <img src="asset/astra.png" alt="Logo"> <!-- Ganti dengan path gambar logo -->
            </div>
            <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
                <button type="submit">Login</button>
            </form>
            <a class="back-link" href="forgot_password.php">Lupa password?</a>
            <a class="back-link" href="register.php">Belum punya akun? Klik di sini</a>
        </div>
    </div>
</body>
</html>
