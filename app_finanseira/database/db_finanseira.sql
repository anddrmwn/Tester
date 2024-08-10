-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 08:46 AM
-- Server version: 10.5.23-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dksystem_finanseira`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_beban`
--

CREATE TABLE `tb_beban` (
  `beban_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_beban` varchar(55) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `tipe` enum('Kas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_beban`
--

INSERT INTO `tb_beban` (`beban_id`, `user_id`, `tanggal`, `jenis_beban`, `deskripsi`, `jumlah`, `tipe`, `created_at`) VALUES
(2, 1, '2024-07-16', '501', 'Tagihan listrik token Divisi Pertambangan pengelolahan', 2500000, 'Kas', '2024-07-30 23:30:01'),
(3, 1, '2024-04-03', '502', 'Tagihsan aqua galon 20 KG ', 9300000, 'Kas', '2024-07-30 23:30:28'),
(4, 1, '2024-06-20', '504', 'Memberikan gaji karyawan', 50000000, 'Kas', '2024-07-31 21:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_buyyer`
--

CREATE TABLE `tb_buyyer` (
  `buy_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pembelian` varchar(55) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `tipe` enum('Kas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_buyyer`
--

INSERT INTO `tb_buyyer` (`buy_id`, `user_id`, `tanggal`, `jenis_pembelian`, `deskripsi`, `jumlah`, `tipe`, `created_at`) VALUES
(2, 1, '2024-07-02', '601', 'Saham indodax', 8000000, 'Kas', '2024-07-30 22:09:35'),
(10, 1, '2024-07-05', '603', 'sarung tangan ', 1000000, 'Kas', '2024-07-30 22:27:49'),
(11, 1, '2024-01-01', '604', 'buku tulis', 250000, 'Kas', '2024-07-30 23:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer_support`
--

CREATE TABLE `tb_customer_support` (
  `cs_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `jenis_pengaduan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer_support`
--

INSERT INTO `tb_customer_support` (`cs_id`, `tanggal`, `user_id`, `jenis_pengaduan`, `deskripsi`) VALUES
(12, '2024-07-30', 1, 'Lag', 'Lag saat buka fitur\r\n'),
(13, '2024-07-17', 23, 'LEG', 'Leg aplikasi pajak');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `kategori_id` int(11) NOT NULL,
  `penjelasan_kategori` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`kategori_id`, `penjelasan_kategori`) VALUES
(1, 'Pendapatan'),
(2, 'Pengeluaran');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pajak`
--

CREATE TABLE `tb_pajak` (
  `pajak_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `gaji` bigint(20) NOT NULL,
  `nama_lengkap` varchar(155) NOT NULL,
  `jenis_pajak` varchar(100) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `persentase` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `tipe` enum('Kas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pajak`
--

INSERT INTO `tb_pajak` (`pajak_id`, `user_id`, `tanggal`, `gaji`, `nama_lengkap`, `jenis_pajak`, `npwp`, `persentase`, `jumlah`, `deskripsi`, `tipe`, `created_at`) VALUES
(7, 1, '2024-07-19', 52000000, 'Mas Yusuf Badruduen', 'PPH', '54184812418484', 10, 5200000, 'Penghasilan  dari Gaji Kantor Pusat PT Sucofindo', 'Kas', '2024-07-30 14:55:28'),
(8, 1, '2024-07-02', 7000000, 'Aimar Rizki', 'PPN', '51815251184', 15, 1050000, 'Pendapatan Gaji dari Negara Abu Dhabi', 'Kas', '2024-07-30 21:26:08'),
(9, 1, '2024-04-01', 9000000, 'Andi Aswan', 'PPN', '28518186464', 5, 450000, 'Pajak Penghasilan negara', 'Kas', '2024-07-31 00:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_piutang`
--

CREATE TABLE `tb_piutang` (
  `piutang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `no_transaksi` varchar(55) NOT NULL,
  `nama` varchar(155) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `tipe` enum('Kas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_piutang`
--

INSERT INTO `tb_piutang` (`piutang_id`, `user_id`, `tanggal`, `no_transaksi`, `nama`, `jatuh_tempo`, `deskripsi`, `jumlah`, `tipe`, `created_at`) VALUES
(6, 1, '2024-04-25', 'Invoice #1', 'Mas Yusuf', '2024-02-29', 'Utang pada asset pt wika', 500000000, 'Kas', '2024-07-30 13:26:09'),
(7, 1, '2024-02-02', 'Invoice #2', 'Muhammad Aimar Rizki', '2024-07-30', 'Pembayaran utang asset porodia', 85000000, 'Kas', '2024-07-30 13:50:34');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pos`
--

CREATE TABLE `tb_pos` (
  `kode` varchar(3) NOT NULL,
  `pos` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pos`
--

INSERT INTO `tb_pos` (`kode`, `pos`) VALUES
('5', 'Beban'),
('1', 'Harta'),
('2', 'Hutang'),
('3', 'Modal'),
('6', 'Pembelian'),
('4', 'Pendapatan'),
('7', 'Penjualan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sell`
--

CREATE TABLE `tb_sell` (
  `sell_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_penjualan` varchar(55) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah` bigint(20) NOT NULL DEFAULT 0,
  `tipe` enum('Nonkas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_sell`
--

INSERT INTO `tb_sell` (`sell_id`, `user_id`, `tanggal`, `jenis_penjualan`, `deskripsi`, `jumlah`, `tipe`, `created_at`) VALUES
(2, 1, '2024-07-02', '701', 'Suply Money Changer IDR ke MYR', 90000000, 'Nonkas', '2024-07-30 14:56:58'),
(3, 1, '2024-05-01', '702', 'Pakaian Batik PT Sucofindo', 8000000, 'Nonkas', '2024-07-30 21:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `tb_subpos`
--

CREATE TABLE `tb_subpos` (
  `kode` varchar(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `pos` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_subpos`
--

INSERT INTO `tb_subpos` (`kode`, `nama`, `pos`) VALUES
('502', 'Beban Air', '5'),
('504', 'Beban Gaji', '5'),
('501', 'Beban Listrik', '5'),
('505', 'Beban Penyusutan', '5'),
('503', 'Beban Telephone Fiber', '55'),
('102', 'Harta Emas', '1'),
('104', 'Harta Peralatan', '1'),
('105', 'Harta Piutang', '1'),
('101', 'Harta Tanah', '1'),
('103', 'Harta Uang', '1'),
('204', 'Hutang Dagang', '2'),
('202', 'Hutang Gaji Karyawan', '2'),
('205', 'Hutang Pinjaman Aset Kredit', '2'),
('201', 'Hutang Pinjaman Bangunan', '2'),
('302', 'Modal Saham', '3'),
('301', 'Modal Tanah', '3'),
('203', 'Obligasi', '2'),
('602', 'Pembelian Aset', '6'),
('603', 'Pembelian Baku', '6'),
('604', 'Pembelian Peralatan', '6'),
('601', 'Pembelian Saham', '6'),
('401', 'Pendapatan Bunga', '4'),
('402', 'Pendapatan Laba Gaji', '4'),
('403', 'Pendapatan Laba Tanah', '4'),
('702', 'Penjualan Grosir', '7'),
('703', 'Penjualan Online', '7'),
('704', 'Penjualan Proyek', '7'),
('701', 'Penjualan Tunai', '7');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `tipe` enum('Nonkas','Kas') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(155) NOT NULL,
  `nama_lengkap` varchar(155) DEFAULT NULL,
  `avatar` varchar(155) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_changed` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `username`, `email`, `password`, `nama_lengkap`, `avatar`, `role`, `created_at`, `last_changed`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$d.7WoXjA1pifSW0F0rAZue0f6zwRXaqGDn8Y8ESaZJvCibR5dlwFq', 'Administrator', NULL, 'admin', '2024-02-20 11:30:06', '2024-08-01 06:51:51'),
(2, 'staffinansial', 'finansial@gmail.com', '$2y$10$eMS2BOdyHOlWNPU89Oq87.RMH/J8RdnoOMkz70Ll4TjB8n3iuVjk2', NULL, NULL, 'user', '2024-02-20 11:30:06', '2024-02-20 11:02:50'),
(4, 'finansial11', 'finansial1@gmail.com', '$2y$10$Z6mCecuqAUJXntVe0nH/3u8lZEecdiVQupXnsWeCnDf9uR2VufhoK', NULL, NULL, 'user', '2024-02-21 08:46:04', '2024-02-21 08:46:04'),
(7, 'Staff keuangan', 'staff@01', '$2y$10$woVu0VvjL/A4ASP2OcufQ.6SCLOHyL1mN3I2RWNenGjiKvLPR4FAe', NULL, NULL, 'user', '2024-05-15 12:54:43', '2024-05-15 12:54:43'),
(8, 'mas_yusuf', 'yusufblabla@gmail.com', '$2y$10$xcxURqAz9EN5s/MoMneAvOn82EX2Lm0Ak25WCfU6Q.tINzZzHyhXa', NULL, NULL, 'admin', '2024-05-22 14:49:04', '2024-05-22 14:49:04'),
(9, 'mas_aziz', 'aziz@gmail.com', '$2y$10$8I01SxnvOe/vVqCZFUtQFu958dv19xNSfmNRcmhTJIJrM7VtI0wGa', NULL, NULL, 'user', '2024-05-22 14:50:15', '2024-05-22 14:50:15'),
(14, 'mamatx', 'mamat@gmail.com', '$2y$10$7iE5xmU4MO1JKW0zPacsDOAl7Lw5vh0yLpvLzKB/jsRXw5Frcnkf6', NULL, NULL, 'user', '2024-05-28 09:53:38', '2024-05-28 09:53:38'),
(16, 'Derrel', 'Derrel@gmail.com', '$2y$10$KV9rJnXAtq6/f5.MDs5O..Eh6qo16e.bJc/6cRZ4w1VDhT9ypE7W2', NULL, NULL, 'user', '2024-06-15 07:08:27', '2024-06-15 07:08:27'),
(17, 'aimrzki', 'muhammadaimar77@gmail.com', '$2y$10$GUCqd9YBAX1v4WN8QPc0QOc0jt1dfX4ZdKuqhCMno1HnISESgTy5K', NULL, NULL, 'user', '2024-06-16 00:09:05', '2024-06-16 00:18:36'),
(18, 'arfarayemas', 'indonesianstudent14@gmail.com', '$2y$10$SGg85iyeDLahMqbWa8rIYeurNCufkuXYx.RuA6X5UifQpn/kab1VC', NULL, NULL, 'user', '2024-06-16 00:20:47', '2024-06-16 00:20:47'),
(19, 'admiindadang', 'admindadang@gmail.com', '$2y$10$aGAhjnl8uFJnANG/I/0BWOuLyE6UrGaYSUaVyHvl/ik16iBEMTGL2', NULL, NULL, 'admin', '2024-07-22 09:11:17', '2024-07-22 09:11:17'),
(20, 'user01', 'user01@gmail.com', '$2y$10$nyzgT.zw48EcYS8zzb2zsO0B5Ts9BWloxAwSLk3hKFhF5UV.6dPUa', NULL, NULL, 'user', '2024-07-23 00:38:42', '2024-07-23 00:38:42'),
(21, 'testing', 'mabar@gmail.com', '$2y$10$LzngPZD1U9eeP/sqFHwlQu3ERmRPygSZJ3jR6pzP2dr18ONq62Bo.', NULL, NULL, 'user', '2024-07-23 15:38:37', '2024-07-23 15:38:37'),
(23, 'mamat', 'mrahadyan11@gmail.com', '$2y$10$Rcl3qPTBmJ4Qto8Y0owl0uUS3DdNDpf5tzaFzKGnFlWdp6ehVrb1q', 'Mamad Aveolux', NULL, 'user', '2024-07-31 02:47:23', '2024-07-31 02:52:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_beban`
--
ALTER TABLE `tb_beban`
  ADD PRIMARY KEY (`beban_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jenis_beban` (`jenis_beban`);

--
-- Indexes for table `tb_buyyer`
--
ALTER TABLE `tb_buyyer`
  ADD PRIMARY KEY (`buy_id`);

--
-- Indexes for table `tb_customer_support`
--
ALTER TABLE `tb_customer_support`
  ADD PRIMARY KEY (`cs_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `tb_pajak`
--
ALTER TABLE `tb_pajak`
  ADD PRIMARY KEY (`pajak_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jenis_pajak` (`jenis_pajak`);

--
-- Indexes for table `tb_piutang`
--
ALTER TABLE `tb_piutang`
  ADD PRIMARY KEY (`piutang_id`);

--
-- Indexes for table `tb_pos`
--
ALTER TABLE `tb_pos`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `kode` (`kode`),
  ADD KEY `pos` (`pos`);

--
-- Indexes for table `tb_sell`
--
ALTER TABLE `tb_sell`
  ADD PRIMARY KEY (`sell_id`),
  ADD KEY `jenis_penjualan` (`jenis_penjualan`),
  ADD KEY `deskripsi` (`deskripsi`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `deskripsi` (`deskripsi`),
  ADD KEY `jumlah` (`jumlah`),
  ADD KEY `tipe` (`tipe`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_beban`
--
ALTER TABLE `tb_beban`
  MODIFY `beban_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_buyyer`
--
ALTER TABLE `tb_buyyer`
  MODIFY `buy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_customer_support`
--
ALTER TABLE `tb_customer_support`
  MODIFY `cs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_pajak`
--
ALTER TABLE `tb_pajak`
  MODIFY `pajak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_piutang`
--
ALTER TABLE `tb_piutang`
  MODIFY `piutang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_sell`
--
ALTER TABLE `tb_sell`
  MODIFY `sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_customer_support`
--
ALTER TABLE `tb_customer_support`
  ADD CONSTRAINT `tb_customer_support_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Constraints for table `tb_pajak`
--
ALTER TABLE `tb_pajak`
  ADD CONSTRAINT `tb_pajak_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
