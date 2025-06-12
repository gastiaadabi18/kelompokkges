<?php
include 'koneksi.php';

if (isset($_GET['meja'])) {
    $meja = $_GET['meja'];
    mysqli_query($koneksi, "DELETE FROM pesanan WHERE meja='$meja'");
    echo "<script>
      alert('Pesanan untuk Meja $meja telah diselesaikan dan dihapus!');
      window.location.href='index.php';
    </script>";
} else {
    echo "<script>
      alert('Nomor meja tidak ditemukan!');
      window.location.href='index.php';
    </script>";
}
