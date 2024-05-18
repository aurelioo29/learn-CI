-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 02:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_point_of_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_d`
--

CREATE TABLE `tbl_beli_d` (
  `id_beli` bigint(20) NOT NULL,
  `no_faktur` varchar(15) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `qty` mediumint(9) NOT NULL DEFAULT 0,
  `harga_beli` decimal(10,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(10,2) NOT NULL DEFAULT 0.00,
  `nilai_diskon` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_beli_d`
--

INSERT INTO `tbl_beli_d` (`id_beli`, `no_faktur`, `id_produk`, `qty`, `harga_beli`, `diskon`, `nilai_diskon`, `sub_total`) VALUES
(1, 'F20240001', 1, 5, 10000.00, 500.00, 2500.00, 47500.00),
(2, 'F20240001', 2, 3, 15000.00, 750.00, 2250.00, 42750.00),
(3, 'F20240002', 2, 2, 20000.00, 1000.00, 3000.00, 37000.00),
(4, 'F20240001', 2, 4, 12000.00, 600.00, 1800.00, 43200.00),
(5, 'F20240003', 1, 6, 18000.00, 900.00, 2700.00, 61200.00),
(6, 'F20240002', 1, 1, 25000.00, 1250.00, 3750.00, 23750.00),
(7, 'F20240002', 1, 3, 17000.00, 850.00, 2550.00, 47950.00),
(8, 'F20240003', 1, 2, 22000.00, 1100.00, 3300.00, 53900.00),
(9, 'F20240003', 2, 5, 13000.00, 650.00, 1950.00, 60550.00),
(10, 'F20240004', 2, 4, 19000.00, 950.00, 2850.00, 55100.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_m`
--

CREATE TABLE `tbl_beli_m` (
  `no_faktur` varchar(15) NOT NULL,
  `tgl_faktur` date DEFAULT NULL,
  `id_supp` int(6) NOT NULL,
  `total_beli` decimal(10,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ppn` decimal(10,2) NOT NULL DEFAULT 0.00,
  `biaya_lain` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stts_bayar` smallint(1) NOT NULL DEFAULT 0,
  `tgl_jt` date NOT NULL,
  `stts_beli` smallint(1) NOT NULL DEFAULT 0,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(25) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `update_by` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_beli_m`
--

INSERT INTO `tbl_beli_m` (`no_faktur`, `tgl_faktur`, `id_supp`, `total_beli`, `diskon`, `ppn`, `biaya_lain`, `stts_bayar`, `tgl_jt`, `stts_beli`, `created_date`, `created_by`, `update_date`, `update_by`) VALUES
('F20240001', '2024-03-01', 1, 1000.00, 50.00, 10.00, 20.00, 1, '2024-03-10', 1, '2024-03-01', 'User1', NULL, NULL),
('F20240002', '2024-03-02', 2, 1500.00, 75.00, 15.00, 30.00, 1, '2024-03-12', 1, '2024-03-02', 'User2', NULL, NULL),
('F20240003', '2024-03-03', 3, 2000.00, 100.00, 20.00, 40.00, 0, '2024-03-15', 0, '2024-03-03', 'User3', NULL, NULL),
('F20240004', '2024-03-04', 4, 2500.00, 125.00, 25.00, 50.00, 1, '2024-03-18', 1, '2024-03-04', 'User4', NULL, NULL),
('F20240005', '2024-03-05', 5, 3000.00, 150.00, 30.00, 60.00, 1, '2024-03-20', 0, '2024-03-05', 'User5', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_kategori`
--

CREATE TABLE `tbl_m_kategori` (
  `id_kategori` int(6) NOT NULL,
  `nama_kategori` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_m_kategori`
--

INSERT INTO `tbl_m_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Kosmetik'),
(4, 'Obatan'),
(5, 'Rokok'),
(6, 'Mainan'),
(7, 'Chiki');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_produk`
--

CREATE TABLE `tbl_m_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_kategori` int(6) NOT NULL,
  `id_satuan` int(6) NOT NULL,
  `barcode` varchar(10) DEFAULT NULL,
  `harga_beli` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_pokok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(10,2) DEFAULT 0.00,
  `is_status` smallint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_m_produk`
--

INSERT INTO `tbl_m_produk` (`id_produk`, `nama_produk`, `id_kategori`, `id_satuan`, `barcode`, `harga_beli`, `harga_pokok`, `harga_jual`, `is_status`) VALUES
(1, 'Rokok Surya', 5, 6, '0xff3400', 100000.00, 120000.00, 25000.00, 1),
(2, 'Minyak', 2, 2, '0x24ff88', 25000.00, 20000.00, 35000.00, 1),
(4, 'Chocolatos', 2, 5, '0xff3400', 30000.00, 30000.00, 10000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_satuan`
--

CREATE TABLE `tbl_m_satuan` (
  `id_satuan` int(6) NOT NULL,
  `nama_satuan` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_m_satuan`
--

INSERT INTO `tbl_m_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Gram'),
(2, 'Kilogram'),
(3, 'Liter'),
(4, 'Mililiter'),
(5, 'Sachet'),
(6, 'Dus'),
(8, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_supplier`
--

CREATE TABLE `tbl_m_supplier` (
  `id_supp` int(6) NOT NULL,
  `jenis` varchar(5) NOT NULL,
  `nama_supp` varchar(35) NOT NULL,
  `kontak_person` varchar(35) DEFAULT NULL,
  `no_kontak` varchar(12) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kota` varchar(35) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `no_tlpn` varchar(15) DEFAULT NULL,
  `no_fax` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_m_supplier`
--

INSERT INTO `tbl_m_supplier` (`id_supp`, `jenis`, `nama_supp`, `kontak_person`, `no_kontak`, `alamat`, `kota`, `email`, `no_tlpn`, `no_fax`) VALUES
(1, 'Distr', 'Supplier A', 'John Doe', '1234567890', '123 Main Street', 'City A', 'john.doe@example.com', '123-456-7890', '123-456-7890'),
(2, 'Whole', 'Supplier B', 'Jane Smith', '2345678901', '456 Elm Street', 'City B', 'jane.smith@example.com', '234-567-8901', '234-567-7890'),
(3, 'Manuf', 'Supplier C', 'Michael Johnson', '3456789012', '789 Oak Street', 'City C', 'michael.j@example.com', '345-678-9012', '345-678-6789'),
(4, 'Impor', 'Supplier D', 'Emily Williams', '4567890123', '101 Maple Avenue', 'City D', 'emily.w@example.com', '456-789-0123', '456-789-5678'),
(5, 'Retai', 'Supplier E', 'Christopher Brown', '5678901234', '202 Pine Street', 'City E', 'chris.b@example.com', '567-890-1234', '567-890-4567'),
(6, 'Agent', 'Supplier F', 'Jessica Martinez', '6789012345', '303 Cedar Street', 'City F', 'jess.m@example.com', '678-901-2345', '678-901-7890'),
(7, 'Servi', 'Supplier G', 'David Lee', '7890123456', '404 Birch Street', 'City G', 'david.l@example.com', '789-012-3456', '789-012-3456'),
(8, 'Produ', 'Supplier H', 'Ashley Taylor', '8901234567', '505 Walnut Street', 'City H', 'ashley.t@example.com', '890-123-4567', '890-123-4567'),
(9, 'Vendo', 'Supplier I', 'Matthew Anderson', '9012345678', '606 Oakwood Street', 'City I', 'matt.a@example.com', '901-234-5678', '901-234-5678'),
(10, 'Suppl', 'Supplier J', 'Amanda Wilson', '0123456789', '707 Pinehurst Street', 'City J', 'amanda.w@example.com', '012-345-6789', '012-345-6789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_beli_d`
--
ALTER TABLE `tbl_beli_d`
  ADD PRIMARY KEY (`id_beli`),
  ADD KEY `no_faktur` (`no_faktur`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_beli_m`
--
ALTER TABLE `tbl_beli_m`
  ADD PRIMARY KEY (`no_faktur`),
  ADD KEY `id_supp` (`id_supp`);

--
-- Indexes for table `tbl_m_kategori`
--
ALTER TABLE `tbl_m_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_m_produk`
--
ALTER TABLE `tbl_m_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indexes for table `tbl_m_satuan`
--
ALTER TABLE `tbl_m_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tbl_m_supplier`
--
ALTER TABLE `tbl_m_supplier`
  ADD PRIMARY KEY (`id_supp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_beli_d`
--
ALTER TABLE `tbl_beli_d`
  MODIFY `id_beli` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_m_kategori`
--
ALTER TABLE `tbl_m_kategori`
  MODIFY `id_kategori` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_m_produk`
--
ALTER TABLE `tbl_m_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_m_satuan`
--
ALTER TABLE `tbl_m_satuan`
  MODIFY `id_satuan` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_m_supplier`
--
ALTER TABLE `tbl_m_supplier`
  MODIFY `id_supp` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_beli_d`
--
ALTER TABLE `tbl_beli_d`
  ADD CONSTRAINT `tbl_beli_d_ibfk_1` FOREIGN KEY (`no_faktur`) REFERENCES `tbl_beli_m` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_beli_d_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_beli_m`
--
ALTER TABLE `tbl_beli_m`
  ADD CONSTRAINT `tbl_beli_m_ibfk_1` FOREIGN KEY (`id_supp`) REFERENCES `tbl_m_supplier` (`id_supp`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_m_produk`
--
ALTER TABLE `tbl_m_produk`
  ADD CONSTRAINT `tbl_m_produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_m_kategori` (`id_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_m_produk_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `tbl_m_satuan` (`id_satuan`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
