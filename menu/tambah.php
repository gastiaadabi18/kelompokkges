<?php 
include "koneksi.php";

// Proses simpan jika form disubmit
if (isset($_POST['proses'])) {
    $nama       = $_POST['nama'];
    $harga      = $_POST['harga'];
    $deskripsi  = $_POST['deskripsi'];
    $filecover  = ''; // Default kosong

    // Proses upload file jika ada
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $namaFile   = $_FILES['cover']['name'];
        $ukuran     = $_FILES['cover']['size'];
        $tmp        = $_FILES['cover']['tmp_name'];
        $ext        = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowedExt)) {
            if ($ukuran < 1024000) { // Maks 1MB
                $filecover = uniqid() . '_' . $namaFile;
                move_uploaded_file($tmp, 'upload/' . $filecover);
            } else {
                echo "<script>alert('Ukuran file terlalu besar! Maksimal 1MB');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file tidak diizinkan! Hanya JPG, JPEG, dan PNG.');</script>";
            exit;
        }
    }

    // Simpan ke tabel nama
    $query = mysqli_query($koneksi, "INSERT INTO nama (nama, harga, deskripsi, cover) VALUES ('$nama', '$harga', '$deskripsi', '$filecover')");

    if ($query) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = 'index.php?konten=nama';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            window.location.href = 'index.php?konten=tambah';
        </script>";
    }
}
?>



<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Menambahkan nama</h6>
                <a href="index.php?konten=nama" class="btn btn-small btn-primary">Lihat Data nama</a>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nama" class="form-label">nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama nama">
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi">
                                </div>

                                <div class="form-group">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukkan harga">
                                </div>

                                <div class="form-group">
                                    <label for="cover">Upload Gambar nama</label>
                                    <input type="file" class="form-control" name="cover">
                                </div>
    
                    <button type="submit" name="proses" class="btn btn-primary">Simpan</button>
                    <a href="index.php?konten=tambah" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
