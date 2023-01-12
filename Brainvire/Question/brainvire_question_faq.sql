-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2023 at 11:43 AM
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
-- Table structure for table `brainvire_question_faq`
--

CREATE TABLE `brainvire_question_faq` (
  `faq_id` int UNSIGNED NOT NULL COMMENT 'Entity Id',
  `product_id` int UNSIGNED NOT NULL COMMENT 'product Id',
  `name` varchar(255) NOT NULL COMMENT 'name',
  `email` varchar(255) NOT NULL COMMENT 'email',
  `question` varchar(255) NOT NULL COMMENT 'quetion',
  `answer` varchar(255) NOT NULL COMMENT 'answer',
  `product_name` varchar(255) NOT NULL COMMENT 'product Name',
  `status` varchar(255) DEFAULT NULL COMMENT 'status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='QA Table';

--
-- Dumping data for table `brainvire_question_faq`
--

INSERT INTO `brainvire_question_faq` (`faq_id`, `product_id`, `name`, `email`, `question`, `answer`, `product_name`, `status`) VALUES
(7, 76, 'Ronit', 'ronit.zinzuvadiya@brainvire.com', 'Cash On Delivery Available?', 'Yes', 'Sennheiser HE1', '1'),
(8, 76, 'Ronit', 'ronit.zinzuvadiya@brainvire.com', 'Mic is including or Excluding with this purchase?', 'Including', 'Sennheiser HE1', '0'),
(9, 53, 'Ronit', 'ronit.zinzuvadiya@brainvire.com', 'RGB keyboard?', 'Yes', 'Dell Alienware', '1'),
(10, 30, 'Ronit', 'ronit.zinzuvadiya@brainvire.com', 'What i\'ll get inside the box?', 'Watch, Charger for Watch and Documentation', 'Apple Watch', '1'),
(11, 30, 'Sarvang', 'sarvang@gmail.com', 'Wired or wireless charger?', 'Wired', 'Apple Watch', '1'),
(12, 109, 'Ronit', 'ronit.zinzuvadiya@brainvire.com', 'How many pages?', '500', 'brainvire', '1'),
(13, 76, 'Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'What Comes inside the box?', 'abe headphone hoga aur kya hoga re..', 'Sennheiser HE1', '2'),
(15, 30, 'Max ', 'max@gmail.com', 'Limited Edition?', 'Yes', 'Apple Watch', '1'),
(17, 30, 'Ranjan Bhai', 'ranjanbhai@gmail.com', 'This watch can check heartbeats?', 'Yes', 'Apple Watch', '1'),
(18, 53, 'Ronny', 'ronit@gmail.com', 'Weight?', '3 KG', 'Dell Alienware', '1'),
(19, 50, 'Ronit Zinzuvadiya', 'ronit@gmail.com', 'Glass in back-side?', 'Yes', 'Iphone 13 Pro Max', '1'),
(29, 50, 'Ronit Zinzuvadiya', 'ronit@gmail.com', 'price change?', 'no', 'Iphone 13 Pro Max', '2'),
(30, 50, 'Ronit Zinzuvadiya', 'ronit@gmail.com', 'hello', 'sad', 'Iphone 13 Pro Max', '0'),
(31, 50, 'Ronit Zinzuvadiya', 'ronit@gmail.com', 'Available in Green color?', 'Sorry as of now the green color is not available in stock.', 'Iphone 13 Pro Max', '1'),
(46, 105, ' Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'hi', 'hi', 'Iphone Case', '0'),
(59, 61, ' Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'fbgbfgbfgbf', 'majak nahi', 'Purse', '2'),
(61, 29, 'Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'Leather bag?', 'Yes', 'Bag', '0'),
(62, 29, ' Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', '1.5KG?', 'Yes', 'Bag', '2'),
(63, 29, ' Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'Hello Aman!', 'Hey', 'Bag', '1'),
(64, 29, ' Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'nice', 'Yes', 'Bag', '1'),
(65, 29, 'Ronit Zinzuvadiya', 'ronit.zinzuvadiya@brainvire.com', 'How many pockets?', '3', 'Bag', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brainvire_question_faq`
--
ALTER TABLE `brainvire_question_faq`
  ADD PRIMARY KEY (`faq_id`),
  ADD KEY `BRAINVIRE_QUESTION_FAQ_PRD_ID_CAT_CTGR_PRD_PRD_ID` (`product_id`);
ALTER TABLE `brainvire_question_faq` ADD FULLTEXT KEY `BRAINVIRE_QUESTION_FAQ_PRD_NAME_NAME_EMAIL_QUESTION_ANSWER_STS` (`product_name`,`name`,`email`,`question`,`answer`,`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brainvire_question_faq`
--
ALTER TABLE `brainvire_question_faq`
  MODIFY `faq_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Entity Id', AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brainvire_question_faq`
--
ALTER TABLE `brainvire_question_faq`
  ADD CONSTRAINT `BRAINVIRE_QUESTION_FAQ_PRD_ID_CAT_CTGR_PRD_PRD_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_category_product` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
