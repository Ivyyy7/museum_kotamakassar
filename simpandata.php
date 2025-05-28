<?php
session_start();  // Mulai sesi PHP

// Cek apakah pengguna sudah mengisi form sebelumnya
if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] == true) {
    echo "Anda sudah mendaftar.";
    exit;  // Mencegah form diproses lagi
}

// Jika form belum disubmit, lanjutkan dengan pemrosesan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $nationality = $_POST['nationality'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $dateOfVisit = $_POST['dateOfVisit'];
    $address = $_POST['address'];
    $occupation = $_POST['occupation'];

    // Simpan data ke database (contoh menggunakan MySQLi)
    $conn = new mysqli("localhost", "root", "", "u612836073_db_museum");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO form-pengunjung (name, email, whatsapp, nationality, age, gender, dateOfVisit, address, occupation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissss", $name, $email, $whatsapp, $nationality, $age, $gender, $dateOfVisit, $address, $occupation);

    if ($stmt->execute()) {
        // Tandai bahwa form telah disubmit dalam sesi ini
        $_SESSION['form_submitted'] = true;
        echo "Pendaftaran berhasil!";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
