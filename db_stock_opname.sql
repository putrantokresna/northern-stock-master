DROP DATABASE IF EXISTS `db_stock_opname`;
CREATE DATABASE IF NOT EXISTS `db_stock_opname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `db_stock_opname`;

--
-- Database: `db_stock_opname`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE `tbl_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `target_user` int(10) UNSIGNED DEFAULT NULL,
  `inven_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sisa_hari` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_read`
--

CREATE TABLE `tbl_log_read` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `log_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('Delete','Read') DEFAULT 'Read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_log_read`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opname`
--

CREATE TABLE `tbl_opname` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opname_det`
--

CREATE TABLE `tbl_opname_det` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qty_system` int(10) UNSIGNED DEFAULT NULL,
  `qty_actual` int(10) UNSIGNED DEFAULT NULL,
  `produk_id` int(10) UNSIGNED DEFAULT NULL,
  `opname_id` int(10) UNSIGNED DEFAULT NULL,
  `qty_awal` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opname_det_prod`
--

CREATE TABLE `tbl_opname_det_prod` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `opname_det_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis` enum('Masuk','Keluar') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `qty_awal` int(10) UNSIGNED DEFAULT NULL,
  `qty_akhir` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk_inven`
--

CREATE TABLE `tbl_produk_inven` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `produk_id` int(10) UNSIGNED DEFAULT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `kadaluarsa` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('Visible','Disposed') DEFAULT 'Visible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('Admin','Karyawan') DEFAULT 'Karyawan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama`, `email`, `alamat`, `password`, `role`) VALUES
(1, 'Administrator', 'admin@example.net', NULL, '$2y$10$7uS1eJUosFxYIsxA7YlrPeFnimqJVnR5RVfdjeg56cXh8re.YXUyu', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_inven` (`inven_id`),
  ADD KEY `fk_log_user` (`target_user`);

--
-- Indexes for table `tbl_log_read`
--
ALTER TABLE `tbl_log_read`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logread_user` (`user_id`),
  ADD KEY `fk_logread_log` (`log_id`);

--
-- Indexes for table `tbl_opname`
--
ALTER TABLE `tbl_opname`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_opname_user_cr` (`created_by`);

--
-- Indexes for table `tbl_opname_det`
--
ALTER TABLE `tbl_opname_det`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_optdet_prod` (`produk_id`),
  ADD KEY `tbl_optdet_opt` (`opname_id`);

--
-- Indexes for table `tbl_opname_det_prod`
--
ALTER TABLE `tbl_opname_det_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_optdetprod_optdet` (`opname_det_id`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prod_user_cr` (`created_by`),
  ADD KEY `fk_prod_user_up` (`updated_by`);

--
-- Indexes for table `tbl_produk_inven`
--
ALTER TABLE `tbl_produk_inven`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prodinv_user_cr` (`created_by`),
  ADD KEY `fk_prodinv_produk` (`produk_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_log_read`
--
ALTER TABLE `tbl_log_read`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_opname`
--
ALTER TABLE `tbl_opname`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_opname_det`
--
ALTER TABLE `tbl_opname_det`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_opname_det_prod`
--
ALTER TABLE `tbl_opname_det_prod`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_produk_inven`
--
ALTER TABLE `tbl_produk_inven`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD CONSTRAINT `fk_log_inven` FOREIGN KEY (`inven_id`) REFERENCES `tbl_produk_inven` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`target_user`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_log_read`
--
ALTER TABLE `tbl_log_read`
  ADD CONSTRAINT `fk_logread_log` FOREIGN KEY (`log_id`) REFERENCES `tbl_log` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_logread_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_opname`
--
ALTER TABLE `tbl_opname`
  ADD CONSTRAINT `fk_opname_user_cr` FOREIGN KEY (`created_by`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_opname_det`
--
ALTER TABLE `tbl_opname_det`
  ADD CONSTRAINT `tbl_optdet_opt` FOREIGN KEY (`opname_id`) REFERENCES `tbl_opname` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_optdet_prod` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_opname_det_prod`
--
ALTER TABLE `tbl_opname_det_prod`
  ADD CONSTRAINT `tbl_optdetprod_optdet` FOREIGN KEY (`opname_det_id`) REFERENCES `tbl_opname_det` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD CONSTRAINT `fk_prod_user_cr` FOREIGN KEY (`created_by`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prod_user_up` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_produk_inven`
--
ALTER TABLE `tbl_produk_inven`
  ADD CONSTRAINT `fk_prodinv_produk` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodinv_user_cr` FOREIGN KEY (`created_by`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
