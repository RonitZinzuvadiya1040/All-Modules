-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2023 at 11:31 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magento`
--

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int NOT NULL COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `gender` varchar(10) DEFAULT NULL COMMENT 'Gender',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `phone` varchar(10) DEFAULT NULL COMMENT 'Phone',
  `password` varchar(255) DEFAULT NULL COMMENT 'Password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Form';

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `gender`, `email`, `phone`, `password`) VALUES
(1, 'Ronit', 'male', 'ronit@gmail.com', '9033463695', 'Ronit@1040');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;