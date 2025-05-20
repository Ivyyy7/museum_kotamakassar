<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Inisialisasi data
$today = 0;
$yesterday = 0;
$month_total = 0;
$daily_data = [0, 0, 0, 0, 0, 0, 0]; // Senin–Minggu
$monthly_data = [];
$monthly_labels = [];

// Data Hari Ini
$today_date = date('Y-m-d');
$sql_today = "SELECT COUNT(*) AS total FROM `form-pengunjung` WHERE DATE(dateOfVisit) = '$today_date'";
$res_today = $conn->query($sql_today);
$today = $res_today->fetch_assoc()['total'];

// Data Kemarin
$yesterday_date = date('Y-m-d', strtotime("-1 day"));
$sql_yesterday = "SELECT COUNT(*) AS total FROM `form-pengunjung` WHERE DATE(dateOfVisit) = '$yesterday_date'";
$res_yesterday = $conn->query($sql_yesterday);
$yesterday = $res_yesterday->fetch_assoc()['total'];

// Total Bulan Ini
$month = date('m');
$year = date('Y');
$sql_month = "SELECT COUNT(*) AS total FROM `form-pengunjung` WHERE MONTH(dateOfVisit) = '$month' AND YEAR(dateOfVisit) = '$year'";
$res_month = $conn->query($sql_month);
$month_total = $res_month->fetch_assoc()['total'];

// Data Harian
$sql_daily = "SELECT DAYOFWEEK(dateOfVisit) AS day, COUNT(*) AS total 
              FROM `form-pengunjung` 
              WHERE YEARWEEK(dateOfVisit, 1) = YEARWEEK(CURDATE(), 1)
              GROUP BY day";
$res_daily = $conn->query($sql_daily);
while ($row = $res_daily->fetch_assoc()) {
    $day_index = $row['day'] - 2; // Senin = 1 => index 0
    if ($day_index < 0) $day_index = 6; // Minggu
    $daily_data[$day_index] = (int)$row['total'];
}

// Data Bulanan 3 bulan terakhir
$sql_monthly = "SELECT DATE_FORMAT(dateOfVisit, '%b') AS month, COUNT(*) AS total 
                FROM `form-pengunjung` 
                WHERE dateOfVisit >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
                GROUP BY MONTH(dateOfVisit)
                ORDER BY MONTH(dateOfVisit)";
$res_monthly = $conn->query($sql_monthly);
while ($row = $res_monthly->fetch_assoc()) {
    $monthly_labels[] = $row['month'];
    $monthly_data[] = (int)$row['total'];
}

// Hasil JSON
echo json_encode([
    'today' => $today,
    'yesterday' => $yesterday,
    'month_total' => $month_total,
    'daily' => [
        'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        'data' => $daily_data
    ],
    'monthly' => [
        'labels' => $monthly_labels,
        'data' => $monthly_data
    ]
]);
?>
