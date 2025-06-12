<?php 
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "db_cafe";

$koneksi = mysqli_connect($host,$dbuser,$dbpass,$dbname);

// cek koneksi

if (!$koneksi){
    die("Koneksi Gagal".mysqli_connect_error());
}

?>
