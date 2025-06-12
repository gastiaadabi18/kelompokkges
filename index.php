
  <?php
// index.php
require_once('config.php');
session_start();
if ($_SESSION['statuslogin'] != 'Y') {
    echo "<script>alert('login gagal! Pastikan username dan password benar'); location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="style.css" rel="stylesheet"/>
</head>
<body>
  <aside class="sidebar d-flex flex-column">
    <?php if($_SESSION['level']=='manajer'){
             include('layout/sidebar.php');
                }elseif($_SESSION['level']=='kasir'){
            include('layout/sidebar-kasir.php');
            }elseif($_SESSION['level']=='pelayan'){
            include('layout/sidebar-pelayan.php');
            }?>
  </aside>
  <main class="main-content">
    <div class="top-bar mb-4">
      <?php include('layout/navbar.php') ?>
    </div>
    <section><?=eval($main)?></section>
  </main>
  <div class="pesanan"><?php include('pesanan.php') ?></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <div class="pesanan"><?php include('pesanan.php') ?></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const pesananModalEl = document.getElementById('pesananModal');
      const detailModalEl = document.getElementById('detailModal');

      function resetModal() {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
      }

      [pesananModalEl, detailModalEl].forEach(modalEl => {
        modalEl.addEventListener('hidden.bs.modal', resetModal);
      });

      document.querySelectorAll('.table-box').forEach(function (box) {
        box.addEventListener('click', function () {
          resetModal();
          const meja = this.textContent.trim().replace('Meja ', '');

          fetch('pesanan_cek.php?meja=' + meja)
            .then(response => response.text())
            .then(data => {
              if (data.trim() === '') {
                document.getElementById('inputMeja').value = meja;
                document.getElementById('mejaLabel').textContent = meja;
                document.getElementById('judulPesan').textContent = 'Pesan Untuk Meja ' + meja;
                document.getElementById('tipePesan').value = 'awal';
                new bootstrap.Modal(pesananModalEl).show();
              } else {
                document.getElementById('listPesanan').innerHTML = data;
                updateModals(meja);
                new bootstrap.Modal(detailModalEl).show();
              }
            });
        });
      });

      window.updateModals = function (meja) {
        document.getElementById('inputMeja').value = meja;
        document.getElementById('mejaLabel').textContent = meja;
        document.getElementById('mejaDetailLabel').textContent = meja;
        document.getElementById('selesaiLink').href = 'selesai.php?meja=' + meja;
        document.getElementById('cetakLink').href = 'cetak.php?meja=' + meja;
      };

      window.bukaFormTambahPesanan = function () {
        const meja = document.getElementById('mejaDetailLabel').textContent;
        document.getElementById('inputMeja').value = meja;
        document.getElementById('mejaLabel').textContent = meja;
        document.getElementById('judulPesan').textContent = 'Tambahkan Pesanan Meja ' + meja;
        document.getElementById('tipePesan').value = 'tambah';

        resetModal();
        new bootstrap.Modal(pesananModalEl).show();
      };

      // Auto buka modal jika ?meja ada di URL
      const params = new URLSearchParams(window.location.search);
      const mejaURL = params.get('meja');
      if (mejaURL) {
        fetch('pesanan_cek.php?meja=' + mejaURL)
          .then(res => res.text())
          .then(data => {
            if (data.trim() !== '') {
              document.getElementById('listPesanan').innerHTML = data;
              updateModals(mejaURL);
              new bootstrap.Modal(detailModalEl).show();
            }
          });
      }
    });
  </script>
</body>
</html>

