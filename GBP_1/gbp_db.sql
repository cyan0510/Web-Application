-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 04:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gbp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_ID` int(11) NOT NULL,
  `type_id` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(50) NOT NULL DEFAULT '',
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_ID`, `type_id`, `name`, `description`, `price`) VALUES
(1, '302', 'Magic Drops Complete', 'Probiotics For Flowerhorn', 250),
(2, '303', 'Glass Tank', '500 Gallons', 1000),
(3, '301', 'Betta Food', '50 Grams', 350);

-- --------------------------------------------------------

--
-- Table structure for table `prod_type`
--

CREATE TABLE `prod_type` (
  `type_id` int(3) UNSIGNED NOT NULL,
  `type_name` varchar(180) NOT NULL DEFAULT '',
  `type_status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prod_type`
--

INSERT INTO `prod_type` (`type_id`, `type_name`, `type_status`) VALUES
(301, 'Feeds', 1),
(302, 'Probiotics', 1),
(303, 'Fish Tanks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_id`
--

CREATE TABLE `sales_id` (
  `payment_id` int(11) NOT NULL,
  `status` varchar(200) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_id`
--

INSERT INTO `sales_id` (`payment_id`, `status`, `remarks`) VALUES
(1, '1', 'Paid and Delivered'),
(2, '1', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sale_list`
--

DROP TABLE IF EXISTS `sale_list`;
CREATE TABLE `sale_list` (
  `id` int(30) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `client_name` text NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
   KEY `product_ID` (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_list`
--

INSERT INTO `sale_list` (`id`, `client_name`, `amount`) VALUES
(101, 'Jobertsz', 40),
(102, 'Maria', 1),
(103, 'Idrian', 5),
(104, 'Barry', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) UNSIGNED NOT NULL,
  `user_lastname` varchar(180) NOT NULL DEFAULT '',
  `user_firstname` varchar(180) NOT NULL DEFAULT '',
  `user_email` varchar(180) NOT NULL DEFAULT '',
  `user_password` varchar(180) NOT NULL DEFAULT '',
  `user_status` int(1) NOT NULL DEFAULT 1,
  `user_access` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_lastname`, `user_firstname`, `user_email`, `user_password`, `user_status`, `user_access`) VALUES
(10000001, 'admin', 'admin', 'admin@gmail.com', '123', 1, 'Manager'),
(10000002, 'Man', 'Jasper', 'staff@gmail.com', '123', 1, 'Supervisor'),
(10000003, 'Jozzie', 'Mario', 'staff2@gmail.com', '123', 1, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_ID`),
  ADD KEY `product_type_ID` (`type_id`);

--
-- Indexes for table `prod_type`
--
ALTER TABLE `prod_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `sale_list`
--
ALTER TABLE `sale_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prod_type`
--
ALTER TABLE `prod_type`
  MODIFY `type_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `sale_list`
--
ALTER TABLE `sale_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000004;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
