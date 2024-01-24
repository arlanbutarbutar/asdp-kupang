-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 24 Jan 2024 pada 08.41
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
-- Struktur dari tabel `account_bank`
--

CREATE TABLE `account_bank` (
  `id_bank` int(11) NOT NULL,
  `an` varchar(100) NOT NULL,
  `bank` varchar(10) NOT NULL,
  `norek` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `account_bank`
--

INSERT INTO `account_bank` (`id_bank`, `an`, `bank`, `norek`) VALUES
(5, 'Sahala Zakaria Recardo Butar Butar', 'BCA', '3141140122'),
(6, 'Michael Handre Patty', 'BRI', '467501040127530');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `slug_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `slug_image`) VALUES
(2, 'https://100154.tugasakhir.my.id/assets/images/galeri/1284979534.jpeg'),
(3, 'https://100154.tugasakhir.my.id/assets/images/galeri/645485351.jpeg'),
(4, 'https://100154.tugasakhir.my.id/assets/images/galeri/3190713968.jpeg'),
(6, 'https://100154.tugasakhir.my.id/assets/images/galeri/239683439.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `golongan`
--

CREATE TABLE `golongan` (
  `id_golongan` int(11) NOT NULL,
  `nama_golongan` varchar(75) NOT NULL,
  `harga_golongan` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `golongan`
--

INSERT INTO `golongan` (`id_golongan`, `nama_golongan`, `harga_golongan`, `keterangan`) VALUES
(16, 'Non Golongan (Tidak Membawa Kendaraan)', 0, ''),
(17, 'Golongan 1 (Sepeda)', 13000, ''),
(18, 'Golongan II (Motor &lt; 500 cc dan Gerobak Dorong)', 23500, ''),
(19, 'Golongan III (Motor &gt;500 cc dan Kendaran Roda 3)', 29000, ''),
(20, 'Golongan IV P (Kendaraan Penumpang)', 153000, ''),
(21, 'Golongan IV B (Kendaraan Barang )', 131000, ''),
(22, 'Golongan V P (Kendaraan Penumpang &lt;=7 m)', 330000, ''),
(23, 'Golongan V B (Kendaraan Barang &lt;=7 m )', 119000, ''),
(24, 'Golongan VI P(Kendaraan Penumpang ukuran &gt; 7 m)', 486000, ''),
(25, 'Golongan VI B (Kendaraan Barang &gt; 7m dan &lt;=10)', 290000, ''),
(26, 'Golongan VII (Ukuran &gt;10 m s.d 12 m)', 323000, ''),
(27, 'Golongan VIII (Panjang &gt;12 m s.d 16 m)', 475000, ''),
(28, 'Golongan IX (Panjang&gt;16m)', 1251000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id` int(11) NOT NULL,
  `tgl_informasi` datetime NOT NULL DEFAULT current_timestamp(),
  `informasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `informasi`
--

INSERT INTO `informasi` (`id`, `tgl_informasi`, `informasi`) VALUES
(2, '2023-08-05 16:26:37', '<p><strong>Lorem ipsum</strong> dolor sit amet consectetur adipisicing elit. Laudantium dolor officia voluptas accusantium, similique expedita repudiandae, veniam quas corporis debitis voluptates in eligendi laboriosam corrupti unde quasi modi esse eius earum doloribus consequatur enim ea. Eaque nisi, cumque earum corporis inventore exercitationem sunt dolorem, libero necessitatibus ducimus, ea provident incidunt? Aperiam aliquid iste voluptatem laboriosam, dignissimos vero ratione cumque ipsum dolore mollitia hic cupiditate nulla quo tempore vitae dicta? Laboriosam doloribus quasi, neque qui illum culpa consectetur ut consequatur magnam saepe? Quod, earum voluptate obcaecati qui sit optio dignissimos, sunt rerum explicabo inventore numquam cupiditate natus vel. Ratione, laborum ab!</p>\r\n'),
(3, '2023-08-05 21:36:07', '<h2><strong>Lorem ipsum</strong></h2>\r\n\r\n<p>dolor sit amet consectetur adipisicing elit. Maxime consectetur consequuntur recusandae necessitatibus at doloremque neque, animi, repellat expedita odio officia possimus esse ab id mollitia, minus iste ipsa. Dicta, dignissimos minus repudiandae mollitia ab modi error eum debitis harum iste itaque nesciunt sunt non magnam ratione voluptate sequi excepturi?</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_kapal` int(11) DEFAULT NULL,
  `id_rute` int(11) DEFAULT NULL,
  `tanggal_berangkat` date DEFAULT NULL,
  `jam_berangkat` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_kapal`, `id_rute`, `tanggal_berangkat`, `jam_berangkat`) VALUES
(53, 8, 9, '2024-01-09', '08:00:00'),
(54, 8, 9, '2024-02-09', '08:00:00'),
(55, 12, 10, '2023-12-23', '08:30:00'),
(56, 15, 9, '2023-12-23', '16:00:00'),
(57, 12, 9, '2023-12-23', '08:00:00'),
(58, 15, 10, '2023-12-23', '16:30:00'),
(59, 10, 9, '2023-12-21', '08:00:00'),
(60, 17, 9, '2023-12-25', '08:00:00'),
(61, 10, 10, '2023-12-21', '08:30:00'),
(62, 13, 9, '2023-12-24', '08:00:00'),
(63, 11, 9, '2023-12-22', '08:00:00'),
(64, 13, 10, '2023-12-24', '08:30:00'),
(65, 11, 10, '2023-12-22', '16:30:00'),
(66, 14, 9, '2023-12-20', '16:00:00'),
(67, 12, 10, '2023-12-23', '08:30:00'),
(68, 17, 9, '2023-12-24', '08:00:00'),
(69, 14, 10, '2023-12-22', '16:30:00'),
(70, 13, 9, '2023-12-24', '16:00:00'),
(71, 17, 10, '2023-12-25', '08:30:00'),
(72, 9, 9, '2023-12-26', '08:00:00'),
(73, 9, 10, '2023-12-26', '08:30:00'),
(74, 12, 9, '2023-12-27', '08:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jk`
--

CREATE TABLE `jk` (
  `id_jk` int(11) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jk`
--

INSERT INTO `jk` (`id_jk`, `jenis_kelamin`) VALUES
(1, 'Laki-Laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kapal`
--

CREATE TABLE `kapal` (
  `id_kapal` int(11) NOT NULL,
  `img_kapal` varchar(100) NOT NULL,
  `nama_kapal` varchar(100) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `jenis_kapal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kapal`
--

INSERT INTO `kapal` (`id_kapal`, `img_kapal`, `nama_kapal`, `kapasitas`, `jenis_kapal`) VALUES
(8, 'https://100154.tugasakhir.my.id/assets/images/kapal/2933876070.jpg', 'UMA KALADA', 216, 'KMP'),
(9, 'https://100154.tugasakhir.my.id/assets/images/kapal/2081592042.jpg', 'LAKAAN', 196, 'KMP'),
(10, 'https://100154.tugasakhir.my.id/assets/images/kapal/2707377426.jpg', 'INERIE II', 196, 'KMP'),
(11, 'https://100154.tugasakhir.my.id/assets/images/kapal/441040536.jpg', 'RANAKA', 500, 'KMP'),
(12, 'https://100154.tugasakhir.my.id/assets/images/kapal/1122809567.jpg', 'ILE LABALEKAN', 250, 'KMP'),
(13, 'https://100154.tugasakhir.my.id/assets/images/kapal/3895379472.jpg', 'CAKALANG II', 340, 'KMP'),
(14, 'https://100154.tugasakhir.my.id/assets/images/kapal/3692822672.jpg', 'ILE APE', 192, 'KMP'),
(15, 'https://100154.tugasakhir.my.id/assets/images/kapal/3769674038.jpg', 'ILE MANDIRI', 240, 'KMP'),
(17, 'https://100154.tugasakhir.my.id/assets/images/kapal/3857704568.jpg', 'NAMPARNOS', 100, 'KMP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(75) NOT NULL,
  `harga_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `harga_kelas`) VALUES
(1, 'Ekonomi Dewasa', 10500),
(2, 'Ekonomi Anak', 8000),
(4, 'Business Dewasa', 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelabuhan`
--

CREATE TABLE `pelabuhan` (
  `id` int(11) NOT NULL,
  `img_pelabuhan` varchar(100) NOT NULL,
  `nama_pelabuhan` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelabuhan`
--

INSERT INTO `pelabuhan` (`id`, `img_pelabuhan`, `nama_pelabuhan`, `kota`) VALUES
(6, 'https://100154.tugasakhir.my.id/assets/images/pelabuhan/216798106.jpg', 'Hansisi', 'Kabupaten Semau'),
(8, 'https://100154.tugasakhir.my.id/assets/images/pelabuhan/1957020566.jpg', 'Bolok', 'Kupang');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_penumpang` int(11) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 1,
  `no_pemesanan` char(6) NOT NULL,
  `tgl_pesan` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_batal` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_user`, `id_jadwal`, `id_penumpang`, `id_status`, `no_pemesanan`, `tgl_pesan`, `tgl_batal`) VALUES
(158, 4, 57, 1, 1, 'KRgLMV', '2023-12-20 11:27:35', ''),
(159, 4, 57, 2, 1, 'KRgLMV', '2023-12-20 11:27:35', ''),
(160, 4, 57, 3, 1, 'KRgLMV', '2023-12-20 11:27:35', ''),
(161, 6, 59, 4, 1, 'HQsuOR', '2023-12-20 12:11:49', ''),
(162, 6, 59, 5, 1, 'HQsuOR', '2023-12-20 12:11:49', ''),
(163, 4, 54, 6, 1, 'nRWth8', '2024-01-24 09:11:12', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `id_jk` int(11) NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `id_golongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `id_kelas`, `nama`, `id_jk`, `umur`, `alamat`, `id_golongan`) VALUES
(1, 1, 'Si A', 1, 35, 'alamaat 1', 18),
(2, 1, 'si b', 1, 24, 'jln herewila', 16),
(3, 1, 'si c', 2, 27, 'alamat 3', 18),
(4, 1, 'Arlan Butar Butar', 1, 24, 'Jln. Bajawa', 18),
(5, 1, 'deby', 2, 23, 'oepura', 16),
(6, 4, 'Pak Donatus Manehat', 1, 57, 'unwira', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rute`
--

CREATE TABLE `rute` (
  `id_rute` int(11) NOT NULL,
  `cabang` varchar(50) NOT NULL,
  `pelabuhan_asal` varchar(100) DEFAULT NULL,
  `pelabuhan_tujuan` varchar(100) DEFAULT NULL,
  `jarak` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rute`
--

INSERT INTO `rute` (`id_rute`, `cabang`, `pelabuhan_asal`, `pelabuhan_tujuan`, `jarak`) VALUES
(9, 'Kupang', 'Bolok', 'Hansisi', 6),
(10, 'Hansisi', 'Hansisi', 'Bolok', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_penumpang` int(11) DEFAULT NULL,
  `no_tiket` int(11) NOT NULL,
  `qr_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `id_jadwal`, `id_penumpang`, `no_tiket`, `qr_code`) VALUES
(150, 57, 1, 1, 'KRgLMV1.jpg'),
(151, 57, 2, 2, 'KRgLMV2.jpg'),
(152, 57, 3, 3, 'KRgLMV3.jpg'),
(153, 59, 4, 1, 'HQsuOR1.jpg'),
(154, 59, 5, 2, 'HQsuOR2.jpg'),
(155, 54, 6, 1, 'nRWth81.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT 3,
  `en_user` varchar(100) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 2,
  `username` varchar(100) DEFAULT NULL,
  `nomor_telepon` char(12) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `en_user`, `id_status`, `username`, `nomor_telepon`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, 'admin', '0811', '$2y$10$KaPdjBjCBEWxMi148njHKOC1MMTwG4szV4S3VKPTqW2D340ZQtYKC', '2023-06-21 10:14:13', '2023-06-21 10:14:13'),
(2, 2, '', 1, 'Kepala ASDP Cabang Kupang', '0812', '$2y$10$IuD2vamOM2Q2CoyZ6aoWrumQV4T6ip69N2iZ4P.feDjutm8YU6Vbi', '2023-08-04 16:11:22', '2023-11-17 07:11:00'),
(3, 3, '2955354567', 1, 'penumpang_2955354567', '081239396798', '$2y$10$AjOCnKvxfJ/9glV2A4mfhedpRCnupLN2OLyKAcPxKhmFGRjponHhK', '2023-11-25 13:47:32', '2023-11-25 13:47:32'),
(4, 3, '3905729406', 1, 'penumpang_3905729406', '081339866609', '$2y$10$AY/RLh/tcBIMRdQ/57zVJ.P93rokEgb6k5ttzXu4r8ayhVn0pVXzq', '2023-11-29 07:41:26', '2023-11-29 07:41:26'),
(5, 3, '1418404474', 1, 'penumpang_1418404474', '08133986609', NULL, '2023-12-05 06:03:21', '2023-12-05 06:03:21'),
(6, 3, '1981580600', 1, 'penumpang_1981580600', '081237472119', '$2y$10$tkMcMW9W8xuqbr/stIGCpep/3Io0ENq.cxOw.j1CUpE9TZb57oGmC', '2023-12-09 19:57:18', '2023-12-09 19:57:18'),
(14, 3, '3408766284', 1, 'jill', '081239242214', '$2y$10$JwBHHVjAWohspen2w2lLsei4a4Ti58MTBAim2W6U0PtEewVXLVW1S', '2023-12-19 19:26:29', '2023-12-19 19:26:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id_role`, `role`) VALUES
(1, 'Admin'),
(2, 'Kepala ASDP'),
(3, 'Penumpang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_status`
--

CREATE TABLE `users_status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_status`
--

INSERT INTO `users_status` (`id_status`, `status`) VALUES
(1, 'Active'),
(2, 'No Active');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account_bank`
--
ALTER TABLE `account_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_kapal` (`id_kapal`),
  ADD KEY `id_rute` (`id_rute`);

--
-- Indeks untuk tabel `jk`
--
ALTER TABLE `jk`
  ADD PRIMARY KEY (`id_jk`);

--
-- Indeks untuk tabel `kapal`
--
ALTER TABLE `kapal`
  ADD PRIMARY KEY (`id_kapal`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `pelabuhan`
--
ALTER TABLE `pelabuhan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_bank` (`id_bank`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `pemesanan_ibfk_2` (`id_penumpang`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`),
  ADD KEY `id_jk` (`id_jk`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_golongan` (`id_golongan`);

--
-- Indeks untuk tabel `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `id_penumpang` (`id_penumpang`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_status` (`id_status`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `users_status`
--
ALTER TABLE `users_status`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account_bank`
--
ALTER TABLE `account_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id_golongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `jk`
--
ALTER TABLE `jk`
  MODIFY `id_jk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id_kapal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelabuhan`
--
ALTER TABLE `pelabuhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id_penumpang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users_status`
--
ALTER TABLE `users_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_kapal`) REFERENCES `kapal` (`id_kapal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_bank`) REFERENCES `account_bank` (`id_bank`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_penumpang`) REFERENCES `penumpang` (`id_penumpang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD CONSTRAINT `penumpang_ibfk_2` FOREIGN KEY (`id_jk`) REFERENCES `jk` (`id_jk`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penumpang_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penumpang_ibfk_4` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id_golongan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_3` FOREIGN KEY (`id_penumpang`) REFERENCES `penumpang` (`id_penumpang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `users_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `users_status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
