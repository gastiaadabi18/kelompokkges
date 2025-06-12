<?php
include 'koneksi.php';

$meja = isset($_GET['meja']) ? (int)$_GET['meja'] : 0;
if ($meja === 0) {
    echo "Nomor meja tidak valid."; exit;
}

// Ambil data dari pesanan + menu untuk meja terkait
$query = "SELECT 
            p.*, m.nama AS nama_menu, m.harga 
          FROM pesanan p
          JOIN menu m ON p.id_menu = m.id
          WHERE p.meja = $meja";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Tidak ada pesanan aktif untuk meja ini."; exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet"/>
    <title>Struk Meja <?= $meja ?></title>
    <style>
        body { font-family: monospace; width: 300px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        h2, .small { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 4px 0; }
        .total { border-top: 1px dashed #000; font-weight: bold; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <h2>COFE KKGES</h2>
        <div class="small">Jl. Ujung Padang No.7, Tinjowan</div>
        <div class="small">Telp: 0812 3456 7890</div>
        <hr>
        <div><strong>Meja:</strong> <?= $meja ?></div>
        <div><strong>Tanggal:</strong> <?= date('d-m-Y H:i') ?></div>
    </div>
    <table>
        <?php
        $total = 0;
        $ids_to_delete = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $subtotal = $row['harga'] * $row['jumlah'];
            $total += $subtotal;
            $ids_to_delete[] = $row['id']; // simpan id pesanan untuk dihapus

            echo "
            <tr>
                <td colspan='2'>{$row['nama_menu']}</td>
            </tr>
            <tr>
                <td>{$row['jumlah']} x Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td align='right'>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
            </tr>";
        }
        ?>
        <tr class="total">
            <td>Total</td>
            <td align="right">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
    </table>
    <div class="center" style="margin-top:10px;">
        <p>Terima kasih atas kunjungan Anda</p>
        <p>~ Cofe KKGES ~</p>
    </div>
</body>
</html>
<?php

?>
