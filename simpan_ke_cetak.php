<?php
include 'koneksi.php';

$meja = isset($_GET['meja']) ? (int)$_GET['meja'] : 0;
if ($meja === 0) {
    echo "Nomor meja tidak valid."; exit;
}

// Cek apakah data meja ini sudah pernah dicetak
$cek = mysqli_query($koneksi, "SELECT 1 FROM cetak WHERE mejah = $meja LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
    // Sudah dicetak sebelumnya
    header("Location: cetak.php?mejah=$meja");
    exit;
}

// Ambil data dari pesanan
$query = "SELECT 
            p.meja, m.id AS id_menu, m.nama AS nama_menu, m.harga, 
            p.jumlah, (m.harga * p.jumlah) AS subtotal, 
            p.waktu_pesan
          FROM pesanan p
          JOIN menu m ON p.id_menu = m.id
          WHERE p.meja = $meja";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Tidak ada pesanan aktif untuk meja $meja."; exit;
}

// Simpan ke tabel cetak
while ($row = mysqli_fetch_assoc($result)) {
    $mejah       = $row['meja'];
    $id_menuh    = $row['id_menu'];
    $nama_menu   = mysqli_real_escape_string($koneksi, $row['nama_menu']);
    $harga       = $row['harga'];
    $jumlah      = $row['jumlah'];
    $subtotal    = $row['subtotal'];
    $waktu_pesan = $row['waktu_pesan'];

    $insert = "INSERT INTO cetak (mejah, id_menuh, nama_menu, harga, jumlah, subtotal, waktu_pesan)
               VALUES ($mejah, $id_menuh, '$nama_menu', $harga, $jumlah, $subtotal, '$waktu_pesan')";
    mysqli_query($koneksi, $insert);
}

// Arahkan ke halaman cetak
header("Location: cetak.php?mejah=$meja");
exit;
?>
