<?php
include 'koneksi.php';

$sql = "SELECT * FROM `form-pengunjung` ORDER BY dateOfVisit DESC";
$result = $conn->query($sql);

$data = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data .= "<tr>
            <td class='px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['whatsapp']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['nationality']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['age']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['gender']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['dateOfVisit']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['address']) . "</td>
            <td class='px-4 py-2'>" . htmlspecialchars($row['occupation']) . "</td>
        </tr>";
    }
} else {
    $data = "<tr><td colspan='9' class='px-4 py-6 text-center text-gray-400'>Belum ada data pengguna.</td></tr>";
}

echo $data;
?>
