-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 10:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pickup_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `weight` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_id`, `employee_id`, `total_amount`, `pickup_date`, `created_at`, `weight`) VALUES
(10, 4, 3, '170000.00', '2025-04-16 00:00:00', '2025-04-06 05:20:22', 5),
(11, 7, 2, '230000.00', '2025-04-23 00:00:00', '2025-04-06 06:27:38', 7),
(12, 6, 3, '90000.00', '2025-04-09 00:00:00', '2025-04-06 06:27:49', 3),
(13, 5, 2, '390000.00', '2025-04-07 00:00:00', '2025-04-07 09:37:20', 11);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `service_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `service_id`, `quantity`, `price`) VALUES
(9, 10, 1, 1, '3.00'),
(10, 10, 2, 1, '2.00'),
(11, 11, 1, 1, '150000.00'),
(12, 11, 2, 1, '80000.00'),
(13, 12, 1, 1, '90000.00'),
(14, 13, 1, 1, '150000.00'),
(15, 13, 2, 1, '240000.00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`) VALUES
(1, 'Giặt', '30000.00'),
(2, 'Sấy', '40000.00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'khoaitaylocxoay', 'hoangnguyenchianh@gmail.com', NULL, '$2y$10$2zgd/sAnBMvzTaEUxlSvY.BgSoIDvMWIv9MVoZt2IghtDdZrY.UUe', 'admin', '2025-03-31 14:32:48'),
(2, 'trilord', 'trilord@gmail.com', NULL, '$2y$10$KhGVsxQU4hskLyoxUrqux.hTeKK8qg47DeUJZQNkP3H6BHmT09QeK', 'employee', '2025-04-06 02:23:37'),
(3, 'tailord', 'tai@gmail.com', NULL, '$2y$10$P9m1EtICAa/XVyCQsJLoK.S2wBWeHbE6g8L0.4D1GAo4ueb0nQKzK', 'employee', '2025-04-06 02:40:05'),
(4, 'Huy', 'huy@gmail.com', '0112301841', '$2y$10$AzcZtgkD8zSM8AruoYQVjON/ulUL3V1XIXTbar4Ub4uCn3uVcaS6.', 'customer', '2025-04-06 02:41:48'),
(5, 'tai lu bo', 'tailubo@gmail.com', '0102401888', '$2y$10$LSflyk2vrZ9fTMsXTsNQbOBC5l6Hgs0CYqqiSgFst7WWfOY9RyyEm', 'customer', '2025-04-06 05:40:10'),
(6, 'tri vua', 'trivua@gmail.com', '7891411231', '$2y$10$vDPsphQYsoTeRch9rFJ5t.KOHt/mR94uIwtiIGpOiPkGFHw.hj75q', 'customer', '2025-04-06 05:47:25'),
(7, 'anh do 33', 'anhdo123@gmail.com', '02445615422', '$2y$10$fCpETWOnF3GJs2snvsARG.l3JtThu/pu7dbrTcb6NHaE26N1VVeLm', 'customer', '2025-04-06 05:47:38'),
(9, 'Tri King', 'triking@gmail.com', '0102401841', '$2y$10$yllyBKJhDXRNK397BAYdN.XDR4YNUN0nhH9PC9tssqWPNZna1Q/eS', 'customer', '2025-04-06 15:51:34'),
(10, 'anh quan 24', 'anhquan@gmail.com', '0102401333', '$2y$10$vfGp9GZ.COsxaORJSK7P2OXxAOQzsVLbBWHzEK/QlRcEKZjkVfXmG', 'customer', '2025-04-06 15:53:38'),
(11, 'huy bui', 'huybui@gmail.com', '0102401841', '$2y$10$2zgd/sAnBMvzTaEUxlSvY.BgSoIDvMWIv9MVoZt2IghtDdZrY.UUe', 'admin', '2025-04-07 08:22:04'),
(12, 'tai lord', 'trilord33@gmail.com', '0102401841', '$2y$10$EKP1nooEkD/TtCfR0iQ36u8.xlKbkNySqGmwUuuo2oud8IRel1ZSy', 'employee', '2025-04-07 08:25:10'),
(13, 'tri kt', 'trikt@gmail.com', '0102301222', '$2y$10$yowVeVUNxp3vBdCHv5HEzehUg9Hj4ySNqwVie3FJ1OMKhhOgrGdjy', 'admin', '2025-04-07 08:28:42'),
(14, 'huykhachhang', 'huybui1@gmail.com', '0102401840', '$2y$10$OMjfvGhhUXM36Q7EQ8Dis.HnzgjtA5GVzRDw9bMczTyKw6OIp2M3S', 'customer', '2025-04-07 10:08:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `invoice_details_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
