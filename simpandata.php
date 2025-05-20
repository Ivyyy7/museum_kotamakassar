<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name         = $_POST['name'];
    $email        = $_POST['email'];
    $whatsapp     = $_POST['whatsapp'];
    $nationality  = $_POST['nationality'];
    $age          = $_POST['age'];
    $gender       = $_POST['gender'];
    $dateOfVisit  = date("Y-m-d H:i:s", strtotime($_POST['dateOfVisit']));
    $address      = $_POST['address'];
    $occupation   = $_POST['occupation'];

    $sql = "INSERT INTO `form-pengunjung` (name, email, whatsapp, nationality, age, gender, dateOfVisit, address, occupation)
    VALUES ('$name', '$email', '$whatsapp', '$nationality', $age, '$gender', '$dateOfVisit', '$address', '$occupation')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='register.html';</script>";
    } else {
        echo "Gagal menyimpan data: " . $conn->error;
    }
}
?>
