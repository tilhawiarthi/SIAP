<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan PHPMailer diinstal dan autoloaded

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan data ada sebelum mengaksesnya
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $newPassword = $_POST['password'];

        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "firecheck");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Perbarui password
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPasswordHash, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Kirim email konfirmasi
            $subject = "Password Changed Successfully";
            $message = "Password Anda telah berhasil diubah.";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Ganti dengan SMTP host
                $mail->SMTPAuth   = true;
                $mail->Username   = 'apar.notifikasi@gmail.com'; // Ganti dengan email Anda
                $mail->Password   = 'thmfrwlmdvinrzsu'; // Ganti dengan password email Anda
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('apar.notifikasi@gmail.com', 'Reset Password');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                echo "Password Anda telah berhasil diubah. Email konfirmasi telah dikirim!";

                // Redirect ke halaman login setelah berhasil mengubah password
                header("Location: index.php"); // Ganti 'login.php' dengan halaman login Anda
                exit(); // Pastikan script berhenti setelah redirect
            } catch (Exception $e) {
                echo "Email tidak dapat dikirim. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Email tidak ditemukan atau password tidak dapat diperbarui!";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Data tidak lengkap!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
            z-index: 0; /* Overlay ini berada di bawah container */
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            z-index: 1;
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="">
        <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Ubah Password</button>
        </form>
    </div>
</body>
</html>
