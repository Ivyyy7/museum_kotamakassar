<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Contoh kredensial statis
$adminUsername = "adminmuseum";
$adminPassword = "admin123"; // Sebaiknya dienkripsi pada sistem nyata

if ($username === $adminUsername && $password === $adminPassword) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: dashboard.html");
    exit();
} else {
    echo "<script>alert('Login gagal. Username atau password salah.'); window.history.back();</script>";
}
?>
