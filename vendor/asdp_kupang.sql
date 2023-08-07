-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Agu 2023 pada 21.28
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asdp_kupang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `slug_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `slug_image`) VALUES
(2, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/galeri/1284979534.jpeg'),
(3, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/galeri/645485351.jpeg'),
(4, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/galeri/3190713968.jpeg'),
(6, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/galeri/239683439.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id` int(11) NOT NULL,
  `tgl_informasi` datetime NOT NULL DEFAULT current_timestamp(),
  `informasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_kapal`, `id_rute`, `tanggal_berangkat`, `jam_berangkat`) VALUES
(2, 3, 3, '2023-08-10', '10:00:00'),
(3, 6, 2, '2023-08-10', '14:00:00'),
(4, 5, 6, '2023-08-10', '18:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jk`
--

CREATE TABLE `jk` (
  `id_jk` int(11) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kapal`
--

INSERT INTO `kapal` (`id_kapal`, `img_kapal`, `nama_kapal`, `kapasitas`, `jenis_kapal`) VALUES
(3, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/kapal/1862062367.jpg', 'Awu', 930, 'KMP'),
(4, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/kapal/3736625038.jpg', 'Sinabung', 2000, 'KMP'),
(5, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/kapal/1129256479.png', 'Kirana I', 750, 'Roro'),
(6, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/kapal/2486753571.jpg', 'INERIE II', 200, 'KMP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelabuhan`
--

CREATE TABLE `pelabuhan` (
  `id` int(11) NOT NULL,
  `img_pelabuhan` varchar(100) NOT NULL,
  `nama_pelabuhan` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelabuhan`
--

INSERT INTO `pelabuhan` (`id`, `img_pelabuhan`, `nama_pelabuhan`, `kota`) VALUES
(1, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pelabuhan/1957020566.jpg', 'Bolok', 'Kupang'),
(2, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pelabuhan/259556095.jpg', 'Aimere', 'Ngada'),
(4, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pelabuhan/2266221360.jpg', 'Lembata', 'Lewoleba'),
(5, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pelabuhan/2821839762.jpg', 'Kamal', 'Surabaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayaran`
--

CREATE TABLE `pelayaran` (
  `id_pelayaran` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `penumpang` varchar(35) NOT NULL,
  `golongan` char(10) NOT NULL,
  `kendaraan` varchar(50) NOT NULL,
  `harga` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelayaran`
--

INSERT INTO `pelayaran` (`id_pelayaran`, `id_jadwal`, `penumpang`, `golongan`, `kendaraan`, `harga`) VALUES
(1, 3, 'Dewasa', '1', 'Motor 110 CC', '75000'),
(2, 3, 'Dewasa', '', '', '70000'),
(3, 3, 'Dewasa', '2', 'Motor 250 CC', '108000'),
(4, 4, 'Dewasa', '1', 'Motor 110 CC', '350000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tiket` int(11) DEFAULT NULL,
  `bukti_bayar` varchar(100) DEFAULT NULL,
  `total_bayar` char(20) DEFAULT NULL,
  `tgl_bayar` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_tiket`, `bukti_bayar`, `total_bayar`, `tgl_bayar`) VALUES
(9, 4, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pembayaran/2266221360.jpg', '350000', '2023-08-07'),
(11, 6, 'http://127.0.0.1:1010/apps/asdp-kupang/assets/images/pembayaran/454110262.jpg', '350000', '2023-08-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` int(11) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 3,
  `en_user` varchar(100) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 2,
  `nama` varchar(100) DEFAULT NULL,
  `id_jk` int(11) NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `id_role`, `en_user`, `id_status`, `nama`, `id_jk`, `umur`, `alamat`, `nomor_telepon`, `email`, `password`) VALUES
(1, 3, '3438966797', 1, 'putri', 2, 24, 'Liliba', '08242451251', 'putriraki240800@gmail.com', '$2y$10$RF0Ka6xW47CUopqyuw/LBOoOmyuoin26hSBo8bJUN2syKhBoDEpCi'),
(2, 3, '1816629146', 1, 'Arlan Butar Butar', 1, 23, 'Jalan W.J. Lalamentik No.95', '08113827421', 'arlan270899@gmail.com', '$2y$10$wdZtOt2oZKZJeSn.HIN00./5dNNe4SBsp2crvNkEnDaN5rjFw6.N.'),
(3, 3, '2806317327', 1, 'Arlan Butar Butar', 1, 23, 'Jalan W.J. Lalamentik No.95', '08113827421', 'arlanitha2704@gmail.com', '$2y$10$AET/6zqWJZwdBAfOd9zoh.jpiwW3n4/2SqCGR90whHKwalAmWR9jy');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rute`
--

INSERT INTO `rute` (`id_rute`, `cabang`, `pelabuhan_asal`, `pelabuhan_tujuan`, `jarak`) VALUES
(2, 'Ngada', 'Aimere', 'Bolok', 700),
(3, 'Kupang', 'Bolok', 'Lembata', 250),
(6, 'Kupang', 'Bolok', 'Kamal', 1237);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int(11) NOT NULL,
  `id_pelayaran` int(11) DEFAULT NULL,
  `id_penumpang` int(11) DEFAULT NULL,
  `harga` char(20) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT NULL,
  `qr_code` varchar(100) DEFAULT NULL,
  `tgl_jalan` date NOT NULL,
  `jam_jalan` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `id_pelayaran`, `id_penumpang`, `harga`, `status_pembayaran`, `qr_code`, `tgl_jalan`, `jam_jalan`) VALUES
(1, 3, 2, '108000', NULL, NULL, '2023-08-10', '14:00:00'),
(4, 4, 1, '350000', 'Diterima', '4.jpg', '2023-08-10', '18:00:00'),
(5, 1, 1, '75000', NULL, NULL, '2023-08-10', '18:00:00'),
(6, 4, 3, '350000', 'Gagal', NULL, '2023-08-10', '18:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT 2,
  `en_user` varchar(100) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 2,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `en_user`, `id_status`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, 'admin', 'admin@gmail.com', '$2y$10$kKijE2FsLEnD8pLxojA51ePUq6KRCnZu3x5qS25sHRwOoHJF4xGPm', '2023-06-21 10:14:13', '2023-06-21 10:14:13'),
(2, 2, '', 2, 'Arlan Butar Butar', 'arlanbutarbutar@netmedia-framecode.com', '$2y$10$IuD2vamOM2Q2CoyZ6aoWrumQV4T6ip69N2iZ4P.feDjutm8YU6Vbi', '2023-08-04 16:11:22', '2023-08-04 16:22:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `pelabuhan`
--
ALTER TABLE `pelabuhan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelayaran`
--
ALTER TABLE `pelayaran`
  ADD PRIMARY KEY (`id_pelayaran`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_tiket` (`id_tiket`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_jk` (`id_jk`),
  ADD KEY `id_status` (`id_status`);

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
  ADD KEY `id_penumpang` (`id_penumpang`),
  ADD KEY `tiket_ibfk_2` (`id_pelayaran`);

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
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jk`
--
ALTER TABLE `jk`
  MODIFY `id_jk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id_kapal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pelabuhan`
--
ALTER TABLE `pelabuhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pelayaran`
--
ALTER TABLE `pelayaran`
  MODIFY `id_pelayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id_penumpang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Ketidakleluasaan untuk tabel `pelayaran`
--
ALTER TABLE `pelayaran`
  ADD CONSTRAINT `pelayaran_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD CONSTRAINT `penumpang_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `users_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penumpang_ibfk_2` FOREIGN KEY (`id_jk`) REFERENCES `jk` (`id_jk`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penumpang_ibfk_3` FOREIGN KEY (`id_status`) REFERENCES `users_status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`id_pelayaran`) REFERENCES `pelayaran` (`id_pelayaran`) ON DELETE CASCADE ON UPDATE CASCADE,
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
