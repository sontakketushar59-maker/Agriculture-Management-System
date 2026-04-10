-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 09:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(255) NOT NULL,
  `fertilizer` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `district` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `crop_name`, `fertilizer`, `price`, `district`) VALUES
(1, 'Wheat', 'Urea, DAP, MOP', '1555.00', 'Nashik'),
(2, 'Wheat', 'Urea, DAP, MOP', '1555.00', 'Pune'),
(3, 'Wheat', 'Urea, DAP, MOP', '1555.00', 'Ahmednagar'),
(4, 'Rice', 'Urea, SSP, Zinc Sulphate', '1800.00', 'Kolhapur'),
(5, 'Rice', 'Urea, SSP, Zinc Sulphate', '1800.00', 'Satara'),
(6, 'Rice', 'Urea, SSP, Zinc Sulphate', '1800.00', 'Sangli'),
(7, 'Sugarcane', 'Urea, Potash, Phosphorus', '2200.00', 'Solapur'),
(8, 'Sugarcane', 'Urea, Potash, Phosphorus', '2200.00', 'Ahmednagar'),
(9, 'Sugarcane', 'Urea, Potash, Phosphorus', '2200.00', 'Beed'),
(10, 'Jowar', 'Urea, SSP, Zinc Sulphate', '1400.00', 'Beed'),
(11, 'Jowar', 'Urea, SSP, Zinc Sulphate', '1400.00', 'Latur'),
(12, 'Jowar', 'Urea, SSP, Zinc Sulphate', '1400.00', 'Osmanabad'),
(13, 'Bajra', 'Urea, DAP, Zinc Sulphate', '1350.00', 'Jalgaon'),
(14, 'Bajra', 'Urea, DAP, Zinc Sulphate', '1350.00', 'Dhule'),
(15, 'Bajra', 'Urea, DAP, Zinc Sulphate', '1350.00', 'Ahmednagar'),
(16, 'Maize', 'Urea, DAP, MOP', '1600.00', 'Nashik'),
(17, 'Maize', 'Urea, DAP, MOP', '1600.00', 'Pune'),
(18, 'Maize', 'Urea, DAP, MOP', '1600.00', 'Solapur'),
(19, 'Tur (Arhar)', 'Urea, SSP, DAP', '2000.00', 'Beed'),
(21, 'Tur (Arhar)', 'Urea, SSP, DAP', '2000.00', 'Nanded'),
(22, 'Moong', 'DAP, SSP, Rhizobium Culture', '2200.00', 'Akola'),
(23, 'Moong', 'DAP, SSP, Rhizobium Culture', '2200.00', 'Amravati'),
(24, 'Moong', 'DAP, SSP, Rhizobium Culture', '2200.00', 'Buldhana'),
(25, 'Urad', 'DAP, SSP, Zinc Sulphate', '2300.00', 'Buldhana'),
(26, 'Urad', 'DAP, SSP, Zinc Sulphate', '2300.00', 'Jalgaon'),
(27, 'Urad', 'DAP, SSP, Zinc Sulphate', '2300.00', 'Yavatmal'),
(28, 'Gram (Chana)', 'Urea, DAP, MOP', '2100.00', 'Jalgaon'),
(29, 'Gram (Chana)', 'Urea, DAP, MOP', '2100.00', 'Ahmednagar'),
(30, 'Gram (Chana)', 'Urea, DAP, MOP', '2100.00', 'Solapur'),
(31, 'Groundnut', 'Gypsum, SSP, Zinc Sulphate', '4500.00', 'Kolhapur'),
(32, 'Groundnut', 'Gypsum, SSP, Zinc Sulphate', '4500.00', 'Satara'),
(33, 'Groundnut', 'Gypsum, SSP, Zinc Sulphate', '4500.00', 'Nashik'),
(34, 'Soybean', 'Urea, SSP, Rhizobium Culture', '3900.00', 'Latur'),
(35, 'Soybean', 'Urea, SSP, Rhizobium Culture', '3900.00', 'Osmanabad'),
(36, 'Soybean', 'Urea, SSP, Rhizobium Culture', '3900.00', 'Beed'),
(37, 'Cotton', 'Urea, Potash, DAP', '5600.00', 'Nagpur'),
(38, 'Cotton', 'Urea, Potash, DAP', '5600.00', 'Amravati'),
(39, 'Cotton', 'Urea, Potash, DAP', '5600.00', 'Yavatmal'),
(40, 'Onion', 'Urea, DAP, MOP', '1800.00', 'Nashik'),
(41, 'Onion', 'Urea, DAP, MOP', '1800.00', 'Pune'),
(42, 'Onion', 'Urea, DAP, MOP', '1800.00', 'Ahmednagar'),
(43, 'Tomato', 'Urea, DAP, MOP', '1600.00', 'Pune'),
(44, 'Tomato', 'Urea, DAP, MOP', '1600.00', 'Nashik'),
(45, 'Tomato', 'Urea, DAP, MOP', '1600.00', 'Satara'),
(46, 'Banana', 'Urea, Potash, DAP', '5000.00', 'Jalgaon'),
(47, 'Banana', 'Urea, Potash, DAP', '5000.00', 'Nashik'),
(48, 'Banana', 'Urea, Potash, DAP', '5000.00', 'Pune'),
(49, 'Mango', 'Urea, Potash, SSP', '7000.00', 'Ratnagiri'),
(50, 'Mango', 'Urea, Potash, SSP', '7000.00', 'Sindhudurg'),
(53, 'Grapes', 'Urea, Potash, Zinc Sulphate', '8000.00', 'Pune'),
(54, 'Grapes', 'Urea, Potash, Zinc Sulphate', '8000.00', 'Sangli');

-- --------------------------------------------------------

--
-- Table structure for table `fertilizers`
--

CREATE TABLE `fertilizers` (
  `id` int(11) NOT NULL,
  `fertilizer_name` varchar(255) NOT NULL,
  `fertilizer_price` decimal(10,2) NOT NULL,
  `fertilizer_quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fertilizers`
--

INSERT INTO `fertilizers` (`id`, `fertilizer_name`, `fertilizer_price`, `fertilizer_quantity`) VALUES
(1, 'Urea', '500.00', '1Litre'),
(2, 'Urea', '500.00', '500 ml'),
(3, 'DAP', '700.00', '1 Litre'),
(4, 'NPK 20-20-20', '800.00', '1 Litre'),
(5, 'Potash', '600.00', '1 Litre'),
(6, 'Super Phosphate', '750.00', '1 Litre');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `items` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_no` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `items`, `total_price`, `order_date`, `invoice_no`, `payment_mode`, `address`) VALUES
(1, 2, '[{\"id\":\"2\",\"name\":\"Wheat\",\"price\":\"1555.00\",\"type\":\"crop\"}]', '1555.00', '2025-03-23 15:57:24', 'INV-67E02F646823D', 'cash', 'Nashik'),
(2, 3, '[{\"id\":\"1\",\"name\":\"Urea\",\"price\":\"100.00\",\"type\":\"fertilizer\"}]', '100.00', '2025-03-23 15:58:27', 'INV-67E02FA3EEE7D', 'cash', 'Pune');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `password` varchar(8) NOT NULL,
  `address` varchar(100) NOT NULL,
  `register_as` varchar(11) NOT NULL,
  `location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `mobile`, `password`, `address`, `register_as`, `location`) VALUES
(1, 'Akanksha', 9172964021, 'Akanksha', 'Nashik', 'Admin', 0),
(2, 'Darshan', 8329639241, 'Darshan', 'Nashik', 'User', 0),
(3, 'Amruta', 9876543210, 'Amruta', 'Nashik', 'User', 0),
(4, 'Karan', 7778889990, 'Karan', 'Kopargaon', 'User', 0),
(5, 'Admin', 7777777777, 'Admin', 'Nashik', 'Uder', 0),
(6, 'Sadhana', 7798562425, '77985624', 'Nashik', 'User', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fertilizers`
--
ALTER TABLE `fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `fertilizers`
--
ALTER TABLE `fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
