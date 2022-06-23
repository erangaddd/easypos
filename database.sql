-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2022 at 06:19 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `easypos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `categoty_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Seals'),
(2, 'Bush'),
(3, 'Pin');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` varchar(500) DEFAULT NULL,
  `customer_mobile` varchar(100) DEFAULT NULL,
  `customer_telephone` varchar(100) DEFAULT NULL,
  `customer_fax` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_address`, `customer_mobile`, `customer_telephone`, `customer_fax`, `customer_email`) VALUES
(3, 'John', 'Test', '0758585858', '0852525552', NULL, 'john@abc.com');

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

CREATE TABLE IF NOT EXISTS `grn` (
  `grn_id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_date` date DEFAULT NULL,
  `grn_invoice_no` varchar(50) DEFAULT NULL,
  `grn_supplier` varchar(150) DEFAULT NULL,
  `grn_batch_no` varchar(50) NOT NULL,
  `grn_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grn_id`),
  KEY `grn_id` (`grn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`grn_id`, `grn_date`, `grn_invoice_no`, `grn_supplier`, `grn_batch_no`, `grn_status`) VALUES
(2, '2021-08-01', 'INV01', 'USS', 'GRN20210801512', 1),
(3, '2021-08-01', 'INV02', 'AS TEch', 'GRN202108013KW', 1),
(4, '2021-08-01', 'INV03', 'China', 'GRN20210801K6C', 1),
(5, '2021-08-02', 'INV04', 'Toyota', 'GRN20210802XVH', 1),
(6, '2021-08-02', 'INV05', 'Toyota', 'GRN202108023BE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grn_items`
--

CREATE TABLE IF NOT EXISTS `grn_items` (
  `grn_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cost` double NOT NULL,
  `selling_price` double NOT NULL,
  `original_selling_price` double NOT NULL,
  `quantity` double NOT NULL,
  `original_quantity` double NOT NULL,
  PRIMARY KEY (`grn_item_id`),
  KEY `grn_item_id` (`grn_item_id`),
  KEY `grn_id` (`grn_id`),
  KEY `item_id` (`item_id`),
  KEY `grn_id_2` (`grn_id`),
  KEY `item_id_2` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `grn_items`
--

INSERT INTO `grn_items` (`grn_item_id`, `grn_id`, `item_id`, `cost`, `selling_price`, `original_selling_price`, `quantity`, `original_quantity`) VALUES
(7, 2, 4, 5000, 6500, 6500, 0, 20),
(6, 2, 3, 2450, 7500, 5000, 0, 25),
(5, 2, 7, 1420, 8500, 1750, 5, 70),
(8, 2, 1, 1000, 1750, 1500, 0, 50),
(9, 3, 7, 4500, 8500, 5500, 36, 46),
(10, 3, 3, 1250, 7500, 7500, 0, 100),
(11, 3, 4, 5000, 6500, 5500, 28, 80),
(12, 3, 1, 1250, 1750, 1500, 0, 25),
(13, 4, 7, 7150, 8500, 8500, 10, 30),
(14, 4, 3, 3150, 3900, 3900, 1, 25),
(15, 4, 4, 4500, 6500, 6500, 30, 10),
(16, 4, 1, 1500, 1750, 1750, 27, 35),
(17, 5, 8, 7850, 8900, 8900, 0, 40),
(18, 6, 8, 7500, 8500, 8500, 0, 50);

-- --------------------------------------------------------

--
-- Table structure for table `grn_items_merge`
--

CREATE TABLE IF NOT EXISTS `grn_items_merge` (
  `merge_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_item_id` int(11) NOT NULL,
  `to_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`merge_id`),
  KEY `from_item_id` (`from_item_id`),
  KEY `to_item_id` (`to_item_id`),
  KEY `merge_id` (`merge_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `grn_items_merge`
--

INSERT INTO `grn_items_merge` (`merge_id`, `from_item_id`, `to_item_id`, `quantity`) VALUES
(1, 11, 15, 10),
(2, 11, 15, 8),
(3, 15, 11, 10),
(4, 11, 15, 2),
(5, 17, 18, 10),
(6, 18, 17, 50),
(7, 12, 16, 20),
(8, 6, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `item_description` text,
  `item_origin` varchar(50) DEFAULT NULL,
  `minimum_quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_id` (`item_id`),
  KEY `type_id` (`type_id`),
  KEY `unit_id` (`unit_id`),
  KEY `item_id_2` (`item_id`),
  KEY `type_id_2` (`type_id`),
  KEY `unit_id_2` (`unit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `type_id`, `unit_id`, `item_name`, `item_description`, `item_origin`, `minimum_quantity`) VALUES
(1, 2, 1, 'IDH001', 'Item Dwsc', 'Korea', 400),
(3, 2, 6, 'GHN757', 'Sensor', 'Japan', 10),
(4, 2, 1, 'AGD234', 'Test', 'Korea', 45),
(7, 2, 6, 'KH345H', 'Engine oil seal', 'China', 200),
(8, 2, 6, 'HRD6745', 'OEM Radiator Hose', 'Japan', 50);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE IF NOT EXISTS `returns` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`return_id`),
  KEY `return_id` (`return_id`),
  KEY `sale_id` (`sale_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`return_id`, `sale_id`, `return_date`, `user_id`) VALUES
(1, 2, '2021-08-01', 1),
(2, 3, '2021-08-01', 1),
(3, 17, '2021-09-14', 1),
(4, 13, '2021-09-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `return_items`
--

CREATE TABLE IF NOT EXISTS `return_items` (
  `return_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` int(11) NOT NULL,
  `sale_item_id` int(11) NOT NULL,
  `return_quantity` double NOT NULL,
  `return_reason` varchar(500) NOT NULL,
  `added_to_stock` varchar(3) NOT NULL,
  PRIMARY KEY (`return_item_id`),
  KEY `return_item_id` (`return_item_id`),
  KEY `return_id` (`return_id`),
  KEY `sale_item_id` (`sale_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `return_items`
--

INSERT INTO `return_items` (`return_item_id`, `return_id`, `sale_item_id`, `return_quantity`, `return_reason`, `added_to_stock`) VALUES
(1, 1, 7, 20, 'OEM', 'yes'),
(2, 1, 5, 1, 'No label', 'yes'),
(3, 2, 11, 10, 'Damaged', 'yes'),
(4, 2, 9, 40, 'Wrong type', 'yes'),
(5, 3, 30, 2, '', 'yes'),
(6, 4, 25, 1, '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_number` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bill_date` date NOT NULL,
  `total` double(10,0) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_type` varchar(10) NOT NULL,
  `sale_discount` double DEFAULT NULL,
  `pay_status` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `sale_id` (`sale_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `bill_number`, `customer_id`, `bill_date`, `total`, `sale_date`, `sale_type`, `sale_discount`, `pay_status`, `user_id`) VALUES
(1, '20210001', 0, '2021-08-01', NULL, '2021-08-01 03:57:07', 'Cash', 0, 1, 1),
(2, '20210002', 0, '2021-08-01', NULL, '2021-08-01 04:22:31', 'Cash', 0, 1, 1),
(3, '20210003', 0, '2021-08-01', NULL, '2021-08-01 04:23:30', 'Cash', 0, 1, 1),
(4, '20210004', 0, '2021-08-02', NULL, '2021-08-02 06:21:06', 'Cash', 0, 1, 1),
(5, '20210005', 0, '2021-08-04', NULL, '2021-08-04 08:31:23', 'Cash', 0, 1, 1),
(6, '20210006', 3, '2021-08-04', NULL, '2021-08-04 08:33:59', 'Credit', 0, 1, 1),
(7, '20210007', 0, '2021-08-04', NULL, '2021-08-04 08:45:38', 'Cash', 0, 1, 1),
(8, '20210008', 3, '2021-09-06', NULL, '2021-09-06 12:46:50', 'Credit', 0, NULL, 1),
(9, '20210009', 0, '2021-09-14', NULL, '2021-09-14 04:34:19', 'Cash', 0, 1, 1),
(10, '20210010', 0, '2021-09-14', NULL, '2021-09-14 04:34:38', 'Cash', 0, 1, 1),
(11, '20210011', 0, '2021-09-14', NULL, '2021-09-14 07:53:58', 'Cash', 0, 1, 1),
(12, '20210012', 0, '2021-09-14', NULL, '2021-09-14 07:57:27', 'Cash', 0, 1, 1),
(13, '20210013', 0, '2021-09-14', NULL, '2021-09-14 07:58:05', 'Cash', 0, 1, 1),
(14, '20210014', 0, '2021-09-14', NULL, '2021-09-14 07:58:38', 'Cash', 0, 1, 1),
(15, '20210015', 0, '2021-09-14', 6500, '2021-09-14 08:00:48', 'Cash', 0, 1, 1),
(16, '20210016', 0, '2021-09-14', 15000, '2021-09-14 08:01:44', 'Cash', 0, 1, 1),
(17, '20210017', 0, '2021-09-14', 75000, '2021-09-14 08:32:40', 'Credit', 0, 1, 1),
(18, '20220001', 0, '2022-06-23', 10250, '2022-06-23 00:22:20', 'Cash', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE IF NOT EXISTS `sales_items` (
  `sale_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `grn_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `sale_item_quantity` double NOT NULL,
  `sale_item_discount` double DEFAULT NULL,
  `sale_item_price` double NOT NULL,
  PRIMARY KEY (`sale_item_id`),
  KEY `sale_item_id` (`sale_item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `grn_item_id` (`grn_item_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`sale_item_id`, `sale_id`, `grn_item_id`, `item_id`, `sale_item_quantity`, `sale_item_discount`, `sale_item_price`) VALUES
(1, 1, 5, 7, 10, 0, 8500),
(2, 1, 7, 4, 1, 0, 6500),
(3, 1, 8, 1, 5, 0, 1750),
(4, 2, 12, 1, 5, 0, 1750),
(5, 2, 6, 3, 5, 0, 7500),
(6, 2, 7, 4, 10, 0, 6500),
(7, 2, 8, 1, 45, 0, 1750),
(8, 3, 9, 7, 10, 0, 8500),
(9, 3, 5, 7, 60, 0, 8500),
(10, 3, 10, 3, 100, 0, 7500),
(11, 3, 11, 4, 40, 0, 6500),
(12, 3, 16, 1, 25, 0, 1750),
(13, 4, 18, 8, 10, 0, 8500),
(14, 5, 8, 1, 1, 0, 1750),
(15, 6, 8, 1, 5, 0, 1750),
(16, 7, 8, 1, 1, 100, 1650),
(17, 7, 8, 1, 1, 175, 1575),
(18, 8, 11, 4, 5, 0, 6500),
(19, 8, 8, 1, 2, 87.5, 1662.5),
(20, 9, 17, 8, 5, 0, 8900),
(21, 10, 17, 8, 75, 0, 8900),
(22, 11, 11, 4, 1, 0, 6500),
(23, 11, 14, 3, 1, 0, 3900),
(24, 12, 16, 1, 1, 0, 1750),
(25, 13, 14, 3, 1, 39, 3861),
(26, 14, 16, 1, 1, 17.5, 1732.5),
(27, 15, 11, 4, 1, 0, 6500),
(28, 16, 5, 7, 1, 0, 8500),
(29, 16, 11, 4, 1, 0, 6500),
(30, 17, 5, 7, 5, 0, 8500),
(31, 17, 11, 4, 5, 0, 6500),
(32, 18, 5, 7, 1, 0, 8500),
(33, 18, 16, 1, 1, 0, 1750);

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales_items`
--

CREATE TABLE IF NOT EXISTS `temp_sales_items` (
  `temp_sale_id` int(32) NOT NULL AUTO_INCREMENT,
  `grn_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `sale_item_quantity` double NOT NULL,
  `sale_item_discount` double NOT NULL,
  `sale_item_price` double NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`temp_sale_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `type_name` varchar(500) NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `type_id_2` (`type_id`),
  KEY `category_id_2` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `category_id`, `type_name`) VALUES
(2, 1, 'Test 2');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(50) NOT NULL,
  PRIMARY KEY (`unit_id`),
  KEY `unit_id` (`unit_id`),
  KEY `unit_id_2` (`unit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1, 'Kg'),
(6, 'PCS'),
(7, 'grams');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `userid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `name` varchar(50) DEFAULT NULL,
  `usertype` varchar(200) DEFAULT NULL COMMENT 'user type /parent/teacher/student/system admin',
  `brncode` varchar(100) NOT NULL,
  `username` varchar(200) DEFAULT NULL COMMENT 'usernaem',
  `password` varchar(200) DEFAULT NULL COMMENT 'password',
  `attempt` int(1) NOT NULL DEFAULT '0' COMMENT 'Number of attempts ',
  `expdate` date DEFAULT NULL,
  `active_flag` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`userid`, `name`, `usertype`, `brncode`, `username`, `password`, `attempt`, `expdate`, `active_flag`) VALUES
(1, 'Himal', 'admin', '0001', 'john@abc.com', 'frWAeRAk18PeKfPMu3sydYLj-YUH5x7ACYlwDUEYbMw', 0, '2021-05-12', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
