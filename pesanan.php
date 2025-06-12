<?php
include "koneksi.php";

if (isset($_POST['proses'])) {
    $meja     = $_POST['meja'];
    $id_menu  = $_POST['id_menu'];
    $jumlah   = $_POST['jumlah'];
    $catatan  = $_POST['catatan'] ?? '';
    $tipe     = $_POST['tipe_pesan'] ?? 'awal';

    $query = "INSERT INTO pesanan (meja, id_menu, jumlah, catatan, waktu_pesan) 
              VALUES ('$meja', '$id_menu', '$jumlah', '$catatan', NOW())";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $msg = ($tipe === 'tambah') ? 'Pesanan tambahan berhasil!' : 'Berhasil Dipesan!';
        echo "<script>
            alert('$msg');
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 100); // beri delay agar modal tidak tertumpuk
        </script>";
    } else {
        echo "<script>alert('Gagal Memesan: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
}
?>


<!-- Modal Pemesanan -->
<div class="modal fade" id="pesananModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="pesanan.php" class="modal-content">
      <div class="modal-header bg-warning-subtle">
        <h5 class="modal-title" id="judulPesan">
            Pesan Untuk Meja <span id="mejaLabel"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meja" id="inputMeja">
        <input type="hidden" name="tipe_pesan" id="tipePesan" value="awal">

        <div class="mb-3">
          <label for="id_menu" class="form-label">Pilih Menu</label>
          <select class="form-control" name="id_menu" required>
            <option value="">-- Pilih Menu --</option>
            <?php
            $menu_query = mysqli_query($koneksi, "SELECT id, nama FROM menu");
            while($menu = mysqli_fetch_assoc($menu_query)) {
              echo "<option value='{$menu['id']}'>{$menu['nama']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="jumlah" class="form-label">Jumlah</label>
          <input type="number" class="form-control" name="jumlah" value="1" min="1" required>
        </div>
        <div class="mb-3">
          <label for="catatan" class="form-label">Catatan</label>
          <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan tambahan..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="proses" class="btn btn-primary">Pesan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info-subtle">
        <h5 class="modal-title">Detail Pesanan Meja <span id="mejaDetailLabel"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="listPesanan">
          <!-- Daftar pesanan akan dimuat melalui AJAX -->
        </div>
      </div>
      <div class="modal-footer">
        <!-- Tombol Tambah Pesanan -->
        <button class="btn btn-success" onclick="bukaFormTambahPesanan()">Tambah Pesanan</button>
        <a id="cetakLink" href="cetak.php" target="_blank" class="btn btn-secondary">Cetak</a>
        <a id="selesaiLink" href="selesai.php?meja=1" class="btn btn-danger"
          onclick="return confirm('Yakin selesaikan semua pesanan untuk meja ini?')">
          Selesai
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  function updateModals(meja) {
    document.getElementById('inputMeja').value = meja;
    document.getElementById('mejaLabel').textContent = meja;
    document.getElementById('mejaDetailLabel').textContent = meja;
    document.getElementById('selesaiLink').href = 'selesai.php?meja=' + meja;
    document.getElementById('cetakLink').href = 'cetak.php?meja=' + meja;
  }

  function bukaFormTambahPesanan() {
    const meja = document.getElementById('mejaDetailLabel').textContent;

    document.getElementById('inputMeja').value = meja;
    document.getElementById('mejaLabel').textContent = meja;
    document.getElementById('judulPesan').textContent = 'Tambahkan Pesanan Meja ' + meja;
    document.getElementById('tipePesan').value = 'tambah';

    const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
    if (detailModal) detailModal.hide();

    // Bersihkan backdrop agar tidak ganggu interaksi
    document.body.classList.remove('modal-open');
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

    const pesananModal = new bootstrap.Modal(document.getElementById('pesananModal'));
    pesananModal.show();
  }

  // Saat modal pesanan ditutup, reset form dan backdrop
  document.getElementById('pesananModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('judulPesan').textContent = 'Pesan Untuk Meja ';
    document.getElementById('tipePesan').value = 'awal';

    // Bersihkan backdrop & class modal-open
    document.body.classList.remove('modal-open');
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

    // Jaga-jaga: hapus sisa backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
  });

  
</script>
