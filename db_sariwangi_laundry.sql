-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2024 at 03:08 AM
-- Server version: 8.0.34
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sariwangi_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `kd_jenis` int NOT NULL,
  `jenis_laundry` varchar(100) NOT NULL,
  `lama_proses` int NOT NULL,
  `tarif` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`kd_jenis`, `jenis_laundry`, `lama_proses`, `tarif`) VALUES
(31, 'Express', 1, 10000),
(35, 'Cuci Kering', 2, 6000),
(36, 'Cuci dan Setrika', 2, 9000),
(38, 'Setrika Aja', 2, 6000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` int NOT NULL,
  `tgl_laporan` date NOT NULL,
  `ket_laporan` int NOT NULL,
  `catatan` text NOT NULL,
  `id_laundry` char(10) DEFAULT NULL,
  `pemasukan` int NOT NULL,
  `id_pengeluaran` char(10) DEFAULT NULL,
  `pengeluaran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `id_pengeluaran`, `pengeluaran`) VALUES
(66, '2024-07-08', 1, '-', '0', 24000, NULL, 0),
(68, '2024-07-08', 2, 'bayar wifi', NULL, 0, '2', 100000),
(69, '2024-07-08', 1, 'tidak ada catatan', 'LD-0003', 50000, NULL, 0),
(70, '2024-07-08', 1, 'tidak ada catatan', 'LD-0004', 36000, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry`
--

CREATE TABLE `tb_laundry` (
  `id_laundry` char(10) NOT NULL,
  `pelangganid` int NOT NULL,
  `userid` int NOT NULL,
  `kd_jenis` char(6) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jml_kilo` int NOT NULL,
  `catatan` text NOT NULL,
  `totalbayar` int NOT NULL,
  `status_pembayaran` int NOT NULL,
  `status_pengambilan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_laundry`
--

INSERT INTO `tb_laundry` (`id_laundry`, `pelangganid`, `userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`, `status_pengambilan`) VALUES
('LD-0002', 20, 53, '31', '2024-07-08', '2024-07-09', 3, '-', 24000, 1, 1),
('LD-0003', 20, 38, '31', '2024-07-08', '2024-07-09', 5, 'tidak ada catatan', 50000, 1, 1),
('LD-0004', 25, 38, '35', '2024-07-08', '2024-07-10', 6, 'tidak ada catatan', 36000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `pelangganid` int NOT NULL,
  `pelanggannama` varchar(150) NOT NULL,
  `pelangganalamat` text NOT NULL,
  `pelanggantelp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`pelangganid`, `pelanggannama`, `pelangganalamat`, `pelanggantelp`) VALUES
(20, 'Indira Natio', 'Jl. Anggrek III', '089876543218'),
(25, 'Indra Wijaya', 'Jl. Raflesia I', '081398765432'),
(26, 'Rudi Salim', 'Jl. Tulip III', '085812345678');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id_pengeluaran` int NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `catatan` text NOT NULL,
  `pengeluaran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`id_pengeluaran`, `tgl_pengeluaran`, `catatan`, `pengeluaran`) VALUES
(2, '2024-07-08', 'bayar wifi', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `userid` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpass` varchar(100) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `usertelp` varchar(20) NOT NULL,
  `userfoto` varchar(50) DEFAULT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`userid`, `username`, `userpass`, `nama`, `alamat`, `usertelp`, `userfoto`, `level`) VALUES
(38, 'admin', '$2y$10$OOwI90ecCkZRPEF8d4ezsuzXi7m97HHdu0uz0Z61kQRFgQf8klDIO', 'Bintang Nugraha', 'Jl. Rafflesia No. 7, RT. 05/RW. 02, Kelurahan Gading Serpong, Kecamatan Serpong, Kota Tangerang Selatan, Banten 15325', '085155344993', '667eedae016d7.jpg', 'admin'),
(53, 'kasir', '$2y$10$4bXerdsxDcfdju9bdOkmXuVyrljA9bNx3pYCdUFSCTmo8mPgP8YPW', 'Jaenab', 'Jl. Anggrek II', '089876543218', '668ad79ec41a8.jpeg', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tb_laundry`
--
ALTER TABLE `tb_laundry`
  ADD PRIMARY KEY (`id_laundry`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`pelangganid`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `kd_jenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `pelangganid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  MODIFY `id_pengeluaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
