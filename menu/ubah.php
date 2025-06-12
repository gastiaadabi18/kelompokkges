<?php

include('koneksi.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $tampil = mysqli_query($koneksi,"SELECT * FROM menu WHERE id ='$id'");
    $data = mysqli_fetch_array($tampil);
}

include"koneksi.php";
if(isset($_POST['proses'])){
    $nama= $_POST['nama'];
    $deskripsi= $_POST['deskripsi'];
    $harga= $_POST['harga'];

    $tampil = mysqli_query($koneksi," UPDATE menu SET nama='$nama',harga='$harga',deskripsi='$deskripsi' WHERE id='$id'");

    if($tampil){
        echo "<script>alert('Menu berhasil diubah!');
        location.href='index.php?konten=menu';
        </script>";
    }
    else{
        echo "<script>alert('Menu gagal ditambah!');
        location.href='index.php?konten=menu';
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tampil = mysqli_query($koneksi, "SELECT * FROM menu WHERE id ='$id'");
    $data = mysqli_fetch_array($tampil);
}

if (isset($_POST['proses'])) {
    $cover = $_FILES['cover'];
    $nama = $_FILES['cover']['name'];
    $ukuran = $_FILES['cover']['size'];
    $tipe = $_FILES['cover']['type'];
    $ext = explode('.', $nama);
    $ext_file = strtolower(end($ext));
    $extensi_diizinkan = ['jpg', 'png', 'jpeg'];

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        if (in_array($ext_file, $extensi_diizinkan)) {
            if ($ukuran < 1024000) { // Maksimal 1MB
                $filecover = $id . '_' . $nama;
                move_uploaded_file($_FILES['cover']['tmp_name'], 'upload/' . $filecover);
                $tampil = mysqli_query($koneksi, "UPDATE menu SET cover ='$filecover' WHERE id='$id'");

                // Jika upload berhasil, redirect ke tampil.php atau halaman lain
                echo "<script>alert('Upload Berhasil');
                location.href='index.php?konten=tampil-menu';
                </script>";
            } else {
                echo "<script>alert('Upload Gagal! Ukuran File Terlalu Besar');
                location.href='index.php?konten=upload-menu&id=" . $id . "';
                </script>";
            }
        } else {
            echo "<script>alert('Format file tidak diizinkan. Hanya JPG, PNG, dan JPEG yang diperbolehkan.');
            location.href='index.php?konten=upload-menu&id=" . $id . "';
            </script>";
        }
    } else {
        echo "<script>alert('Anda Belum Memilih File Untuk DiUpload');
        location.href='index.php?konten=upload-menu&id=" . $id . "';
        </script>";
    }
}
?>

<div class="row">
    <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex f;ex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data menu</h6>
            <a href="?konten=menu" class="btn btn-primary btn-small"><i class="fa fa-plus"></i>lihat data</a>
        </div>
        <div class="card-body">

                            <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama']?>" placeholder="Masukkan nama menu">
    </div>

    <div class="form-group">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $data['deskripsi']?>" placeholder="Masukkan deskripsi">
    </div>

    <div class="form-group">
        <label for="harga" class="form-label">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $data['harga']?>" placeholder="Masukkan harga">
    </div>

    <div class="form-group">
        <label for="cover">Upload Gambar Menu</label>
        <input type="file" class="form-control" name="cover">
    </div>

    <button type="submit" class="btn btn-primary" name="proses">Simpan</button>
</form>


                        </div>
    </div>
    </div>
</div>