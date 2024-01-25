-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Jan 2024 pada 11.57
-- Versi server: 10.3.39-MariaDB-cll-lve
-- Versi PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gaslvldx_tugas100154`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `no_pemesanan` char(6) DEFAULT NULL,
  `id_bank` int(11) NOT NULL,
  `bukti_bayar` varchar(100) DEFAULT NULL,
  `total_bayar` char(20) DEFAULT NULL,
  `tgl_bayar` date DEFAULT current_timestamp(),
  `status_pembayaran` varchar(50) NOT NULL DEFAULT 'Checking'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `no_pemesanan`, `id_bank`, `bukti_bayar`, `total_bayar`, `tgl_bayar`, `status_pembayaran`) VALUES
(61, 'KRgLMV', 6, 'https://100154.tugasakhir.my.id/assets/images/pembayaran/2044336822.png', '78500', '2023-12-20', 'Diterima'),
(62, 'HQsuOR', 5, 'https://100154.tugasakhir.my.id/assets/images/pembayaran/3233001952.jpg', '44500', '2023-12-20', 'Diterima'),
(63, 'nRWth8', 6, 'https://100154.tugasakhir.my.id/assets/images/pembayaran/3766063148.png', '178000', '2024-01-24', 'Diterima');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_bank` (`id_bank`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_bank`) REFERENCES `account_bank` (`id_bank`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
