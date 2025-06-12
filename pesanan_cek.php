<?php
include 'koneksi.php';

$meja = $_GET['meja'];
$query = "SELECT m.nama, p.jumlah, p.catatan, p.waktu_pesan 
          FROM pesanan p 
          JOIN menu m ON p.id_menu = m.id 
          WHERE p.meja = '$meja'
          ORDER BY p.waktu_pesan DESC";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<ul class='list-group'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li class='list-group-item'>
                <strong>{$row['nama']}</strong> x {$row['jumlah']} <br/>
                <em>{$row['catatan']}</em> <br/>
                <small class='text-muted'>{$row['waktu_pesan']}</small>
              </li>";
    }
    echo "</ul>";
} else {
    echo "";
}
