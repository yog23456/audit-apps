-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2026 at 04:42 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_audit`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int NOT NULL,
  `no_invoice` varchar(100) NOT NULL,
  `sumber` varchar(100) DEFAULT 'ECES',
  `kategori` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `nilai` decimal(15,2) DEFAULT '0.00',
  `id_stage` int DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `progress` int DEFAULT '0',
  `id_user` int DEFAULT NULL,
  `target_aktual` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `no_invoice`, `sumber`, `kategori`, `project_name`, `nilai`, `id_stage`, `deadline`, `progress`, `id_user`, `target_aktual`, `created_at`, `updated_at`) VALUES
(1, 'INV/2026/001', 'Whistleblowing', 'Pengadaan', 'Project Alpha', 150000000.00, 1, '2026-08-15', 0, NULL, '2026-07-30', '2026-07-21 03:43:44', '2026-07-21 03:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `auditee`
--

CREATE TABLE `auditee` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `upload_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berita_acara`
--

CREATE TABLE `berita_acara` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `keputusan_spv` varchar(100) DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investigasi`
--

CREATE TABLE `investigasi` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `upload_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_stage`
--

CREATE TABLE `master_stage` (
  `id` int NOT NULL,
  `nama_stage` varchar(255) NOT NULL,
  `urutan` int NOT NULL,
  `role_akses` varchar(100) NOT NULL,
  `progress_value` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_stage`
--

INSERT INTO `master_stage` (`id`, `nama_stage`, `urutan`, `role_akses`, `progress_value`, `created_at`, `updated_at`) VALUES
(1, 'Pengumpulan & Telaah Dokumen', 1, 'auditor', 15, '2026-07-21 03:37:17', '2026-07-21 03:37:17'),
(2, 'Pelaksanaan Investigasi', 2, 'auditor', 35, '2026-07-21 03:37:17', '2026-07-21 03:37:17'),
(3, 'Tanggapan / Klarifikasi Auditee', 3, 'auditee', 50, '2026-07-21 03:37:17', '2026-07-21 03:37:17'),
(4, 'Review Supervisor Audit', 4, 'spv_audit', 70, '2026-07-21 03:37:17', '2026-07-21 03:37:17'),
(5, 'Review Head of Audit', 5, 'head_audit', 85, '2026-07-21 03:37:17', '2026-07-21 03:37:17'),
(6, 'Penandatanganan Berita Acara', 6, 'auditor', 100, '2026-07-21 03:37:17', '2026-07-21 03:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `review_head`
--

CREATE TABLE `review_head` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `keputusan_spv` varchar(100) DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_spv`
--

CREATE TABLE `review_spv` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `keputusan` varchar(100) DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telaah`
--

CREATE TABLE `telaah` (
  `id` int NOT NULL,
  `id_audit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `upload_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_name` enum('auditor','auditee','spv_audit','head_audit') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `password`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'auditor1', 'Ahmad Auditor', '$2y$10$VWxAgxfDGSuH7WXeIwDtZOJ2NdOr.Nsx6ORwc2Mxsxm/IQfQEFOeu', 'auditor', '2026-07-21 03:34:30', '2026-07-21 04:29:26'),
(2, 'auditee1', 'Budi Auditee', '$2y$10$VWxAgxfDGSuH7WXeIwDtZOJ2NdOr.Nsx6ORwc2Mxsxm/IQfQEFOeu', 'auditee', '2026-07-21 03:34:30', '2026-07-21 04:29:26'),
(3, 'spv1', 'Citra Supervisor', '$2y$10$VWxAgxfDGSuH7WXeIwDtZOJ2NdOr.Nsx6ORwc2Mxsxm/IQfQEFOeu', 'spv_audit', '2026-07-21 03:34:30', '2026-07-21 04:29:26'),
(4, 'head1', 'Deni Head Audit', '$2y$10$VWxAgxfDGSuH7WXeIwDtZOJ2NdOr.Nsx6ORwc2Mxsxm/IQfQEFOeu', 'head_audit', '2026-07-21 03:34:30', '2026-07-21 04:29:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_invoice` (`no_invoice`),
  ADD KEY `fk_audit_master_stage` (`id_stage`),
  ADD KEY `fk_audit_user` (`id_user`);

--
-- Indexes for table `auditee`
--
ALTER TABLE `auditee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_auditee_user` (`id_user`),
  ADD KEY `fk_auditee_audit` (`id_audit`);

--
-- Indexes for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_berita_acara_user` (`id_user`),
  ADD KEY `fk_berita_acara_audit` (`id_audit`);

--
-- Indexes for table `investigasi`
--
ALTER TABLE `investigasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_investigasi_user` (`id_user`),
  ADD KEY `fk_investigasi_audit` (`id_audit`);

--
-- Indexes for table `master_stage`
--
ALTER TABLE `master_stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_head`
--
ALTER TABLE `review_head`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_head_user` (`id_user`),
  ADD KEY `fk_review_head_audit` (`id_audit`);

--
-- Indexes for table `review_spv`
--
ALTER TABLE `review_spv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_spv_user` (`id_user`),
  ADD KEY `fk_review_spv_audit` (`id_audit`);

--
-- Indexes for table `telaah`
--
ALTER TABLE `telaah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_telaah_user` (`id_user`),
  ADD KEY `fk_telaah_audit` (`id_audit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auditee`
--
ALTER TABLE `auditee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berita_acara`
--
ALTER TABLE `berita_acara`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investigasi`
--
ALTER TABLE `investigasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_stage`
--
ALTER TABLE `master_stage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review_head`
--
ALTER TABLE `review_head`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_spv`
--
ALTER TABLE `review_spv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telaah`
--
ALTER TABLE `telaah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `fk_audit_master_stage` FOREIGN KEY (`id_stage`) REFERENCES `master_stage` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auditee`
--
ALTER TABLE `auditee`
  ADD CONSTRAINT `fk_auditee_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_auditee_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD CONSTRAINT `fk_berita_acara_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_berita_acara_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `investigasi`
--
ALTER TABLE `investigasi`
  ADD CONSTRAINT `fk_investigasi_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_investigasi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `review_head`
--
ALTER TABLE `review_head`
  ADD CONSTRAINT `fk_review_head_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_review_head_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `review_spv`
--
ALTER TABLE `review_spv`
  ADD CONSTRAINT `fk_review_spv_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_review_spv_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `telaah`
--
ALTER TABLE `telaah`
  ADD CONSTRAINT `fk_telaah_audit` FOREIGN KEY (`id_audit`) REFERENCES `audit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_telaah_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
