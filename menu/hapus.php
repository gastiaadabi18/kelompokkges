<?php
include('koneksi.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $tampil = mysqli_query($koneksi,"DELETE FROM menu WHERE id ='$id'");
    
    if($tampil){
        echo "<script>alert('Menu Berhasil Dihapus!');
        location.href='index.php?konten=menu';
        </script>";
    }
    else{
        echo "<script>alert('Menu Gagal Dihapus!');
        location.href='index.php?konten=menu';
        </script>";
    }
}