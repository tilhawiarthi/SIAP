<?php
session_start();
session_destroy(); // Menghancurkan semua session
header('Location: index.php'); // Redirect kembali ke halaman login
exit;
?>
