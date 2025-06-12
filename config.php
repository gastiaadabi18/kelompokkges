    <?php 

$konten = '';
if (isset($_GET['konten'])){
    $konten = $_GET['konten'];
}

switch ($konten){
    case 'home':
        $judul = "Dashboard";
        $konten = "include ('layout/konten.php');";
        break;

    case 'menu':
        $judul = " Menu";
        $konten = "include ('menu/tampil.php');";
        break;

    case 'tambah-menu':
        $judul = " Menu";
        $konten = "include ('menu/tambah.php');";
        break;
        
    case 'ubah-menu':
        $judul = " Menu";
        $konten = "include ('menu/ubah.php');";
        break;

    case 'hapus-menu':
        $judul = " Menu";
        $konten = "include ('menu/hapus.php');";
        break;
        
    case 'upload-menu':
        $judul = " Menu";
        $konten = "include ('menu/upload.php');";
        break;

    case 'selesai':
        $judul = "Selesaikan Pesanan";
        $konten = "include ('selesai.php');";
        break;


    case 'profil':
        $judul = "Profil Pengguna";
        $konten = "include ('profil.php');";
        break;

    default:
        $judul = "Dashboard";
        $konten = "include ('layout/konten.php');";
        break;
}
$main = $konten;
?>