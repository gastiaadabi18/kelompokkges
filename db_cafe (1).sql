-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2025 pada 06.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cafe`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cetak`
--

CREATE TABLE `cetak` (
  `id` int(11) NOT NULL,
  `mejah` int(11) NOT NULL,
  `id_menuh` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `waktu_pesan` datetime NOT NULL,
  `waktu_cetak` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(15) NOT NULL,
  `deskripsi` text NOT NULL,
  `cover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama`, `harga`, `deskripsi`, `cover`) VALUES
(5, 'Sanger Expresso', 23000, 'Sanger Espresso adalah minuman kopi khas Aceh yang memiliki cita rasa unik dan khas. Minuman ini merupakan perpaduan antara kopi hitam yang kuat dengan susu kental manis dan sedikit gula, menciptakan keseimbangan rasa yang tidak terlalu manis namun tetap kaya dan creamy', '5_Americano-coffee-recipe-1068x712.jpg'),
(6, 'Americano', 26000, 'Americano adalah minuman kopi yang terdiri dari espresso yang dicampur dengan air panas, menghasilkan rasa yang lebih ringan dibandingkan espresso murni. Minuman ini memiliki sejarah unik—konon, tentara Amerika selama Perang Dunia II mencampurkan air panas ke dalam espresso agar lebih menyerupai kopi yang biasa mereka minum di Amerika', '6_e3cf71be727218c00f52d45e95ef182a.jpg'),
(16, 'Vietnam Drip', 17000, 'Kopi Vietnam, atau Cà Phê Sữa Đá, adalah minuman kopi khas Vietnam yang memiliki cita rasa kuat dan unik. Minuman ini biasanya dibuat dengan biji kopi robusta yang memiliki kadar kafein tinggi dan rasa yang lebih pahit dibandingkan arabika', '16_WSLUnoT9LA.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `meja` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `waktu_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `meja`, `id_menu`, `jumlah`, `catatan`, `waktu_pesan`) VALUES
(27, 1, 5, 3, 'bg', '2025-06-11 14:49:53'),
(28, 1, 6, 4, 'kon', '2025-06-11 14:51:09'),
(29, 2, 16, 3, 'bgbg', '2025-06-12 02:58:29'),
(30, 2, 5, 4, 'wakwak', '2025-06-12 02:58:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_lengkap` varchar(75) NOT NULL,
  `level` enum('manajer','kasir','pelayan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_lengkap`, `level`) VALUES
(3, 'kasir', '202cb962ac59075b964b07152d234b70', 'kurir lantam', 'kasir'),
(4, 'pelayan', '202cb962ac59075b964b07152d234b70', 'joel purba', 'pelayan'),
(5, 'manajer', '202cb962ac59075b964b07152d234b70', 'roni baskara', 'manajer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cetak`
--
ALTER TABLE `cetak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cetak`
--
ALTER TABLE `cetak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
