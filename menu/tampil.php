<?php
include "koneksi.php";

// Konfigurasi paginasi
$batas = 6;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
$next = $halaman + 1;
$prev = $halaman - 1;

// Hitung total data dan total halaman
$semuadata = mysqli_query($koneksi, "SELECT * FROM menu");
$jlhdata = mysqli_num_rows($semuadata);
$totalhalaman = ceil($jlhdata / $batas);
$nourut = $halaman_awal + 1;

// Cek apakah ada pencarian
if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $tampil = mysqli_query($koneksi, "SELECT * FROM menu WHERE nama LIKE '%$cari%' LIMIT $halaman_awal, $batas");
} else {
    $tampil = mysqli_query($koneksi, "SELECT * FROM menu LIMIT $halaman_awal, $batas");
}

// Validasi query
if (!$tampil) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!-- Mulai HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="style.css" rel="stylesheet"/>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Menu</h6>
                <div class="btn-group">
                    <?php $filter = isset($_GET['cari']) ? "?cari=" . $_GET['cari'] : ""; ?>
                    <a href="?konten=tambah-menu" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>

            <div class="card-body">

                <!-- Form Pencarian -->
                <form class="form-inline mb-4 mt-2" method="GET" action="" style="max-width: 400px;">
                    <input type="hidden" name="konten" value="menu">
                    <div class="input-group w-100">
                        <input type="text" name="cari" class="form-control" placeholder="Masukkan nama"
                            value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                                <a href="?konten=menu" class="btn btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>

                <!-- Daftar Cards -->
                <div class="row">
                    <?php while ($data = mysqli_fetch_array($tampil)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm d-flex flex-column">
                                <img src="upload/<?= $data['cover'] ?>" alt="NoImage" class="img-thumbnail" width="100%" height="200px">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $data['nama'] ?></h5>
                                    <p class="card-text"><?= $data['deskripsi'] ?></p>
                                    <p class="fw-bold text-primary mt-auto">Rp <?= $data['harga'] ?></p>
                                    <hr>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="?konten=ubah-menu&id=<?= $data['id'] ?>" class="btn btn-sm btn-success mx-1">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        <a href="?konten=hapus-menu&id=<?= $data['id'] ?>" class="btn btn-sm btn-danger mx-1"
                                           onclick="return confirm('Hapus data ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <hr>
                <nav aria-label="Navigasi halaman">
                    <ul class="pagination mt-3">
                        <li class="page-item">
                            <a class="page-link <?= ($halaman <= 1) ? 'disabled' : '' ?>"
                               <?= ($halaman > 1) ? "href='?konten=menu&halaman=$prev" . (isset($cari) ? "&cari=$cari" : "") . "'" : '' ?>>
                                Previous
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalhalaman; $i++): ?>
                            <li class="page-item <?= ($halaman == $i) ? 'active' : '' ?>">
                                <a class="page-link"
                                   href="?konten=menu&halaman=<?= $i ?><?= isset($cari) ? "&cari=$cari" : '' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item">
                            <a class="page-link <?= ($halaman >= $totalhalaman) ? 'disabled' : '' ?>"
                               <?= ($halaman < $totalhalaman) ? "href='?konten=menu&halaman=$next" . (isset($cari) ? "&cari=$cari" : "") . "'" : '' ?>>
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
