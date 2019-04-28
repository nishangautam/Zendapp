-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2018 at 06:39 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `storekeeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `page_count` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`, `date_created`, `status`, `page_count`) VALUES
(1, 'Nuddlessd', '2018-08-31 00:35:44', 1, 0),
(2, 'Chauchau', '2018-08-31 03:15:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `page_count` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer`, `address`, `email`, `contact`, `image`, `date`, `status`, `page_count`) VALUES
(2, 'Alisha', 'Garamuni', 'acharyaalisha023@gmail.com', '9825986066', '-Alisha.jpg', '2018-08-31 00:35:10', 0, 0),
(4, 'Tite', 'test address', 'admin@example.com', '9825986066', '-Tite.jpg', '2018-08-31 18:28:10', 0, 0),
(5, 'nishant', 'surunga', 'tgtggautam@gmail.com', '9825986066', '5-nishant.jpg', '2018-08-31 18:30:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`login_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `email`, `status`, `date_created`, `login_id`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'nishan.gautam.987@gmail.com', 1, '2018-08-03 00:00:00', 1),
('Nishan', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@example.com', 0, '2018-08-28 22:04:55', 7);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `product_quantity` decimal(18,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `purchase_count` int(11) NOT NULL,
  `sale_count` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product`, `price`, `product_quantity`, `image`, `status`, `date_created`, `category_id`, `purchase_count`, `sale_count`) VALUES
(1, 'Wai-Wai', '20', '120.00', '1-Wai-Wai.jpg', 1, '2018-08-31 00:36:18', 1, 0, 0),
(2, 'Parlizi', '25', '100.00', '2-Parlizi.jpeg', 1, '2018-08-31 03:18:42', 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `supplier_id`, `date_created`, `amount`, `status`) VALUES
(1, 4, '2018-08-31 19:04:50', '1800.00', 0),
(2, 2, '2018-09-01 16:00:52', '180.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE IF NOT EXISTS `purchasedetail` (
  `purchasedetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  PRIMARY KEY (`purchasedetail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `purchasedetail`
--

INSERT INTO `purchasedetail` (`purchasedetail_id`, `purchase_id`, `product_id`, `product_quantity`, `price`, `discount`, `amount`) VALUES
(1, 1, 1, 100, 10, 10, '900.00'),
(2, 1, 2, 100, 10, 10, '900.00'),
(3, 2, 1, 10, 10, 10, '90.00'),
(4, 2, 1, 10, 10, 10, '90.00');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`sale_id`, `customer_id`, `date_created`, `status`, `amount`) VALUES
(1, 4, '2018-08-31 19:06:20', 0, '180.00'),
(2, 2, '2018-08-31 19:07:16', 0, '1782.00');

-- --------------------------------------------------------

--
-- Table structure for table `saledetail`
--

CREATE TABLE IF NOT EXISTS `saledetail` (
  `saledetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  PRIMARY KEY (`saledetail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `saledetail`
--

INSERT INTO `saledetail` (`saledetail_id`, `sale_id`, `product_id`, `product_quantity`, `price`, `discount`, `amount`) VALUES
(1, 1, 1, 10, 10, 10, '90.00'),
(2, 1, 1, 10, 10, 10, '90.00'),
(3, 2, 1, 89, 20, 10, '1602.00'),
(4, 2, 2, 99, 10, 10, '891.00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `date_created` datetime NOT NULL,
  `page_count` int(11) NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier`, `address`, `email`, `contact`, `image`, `status`, `date_created`, `page_count`) VALUES
(2, 'Dipa', 'Surungaa', 'nishan.gautaam.987@gmail.com', '9825981962', '2-Dipa.jpg', 1, '2018-08-31 00:34:22', 0),
(4, 'abc', 'test address', 'admin@example.com', '9825981962', '-abc.jpg', 1, '2018-08-31 18:31:51', 0),
(6, 'Nishan', 'Surunga', 'nishan.gautam.987@gmail.com', '9825981962', '-Nishan.jpg', 1, '2018-08-31 18:37:29', 0),
(8, 'abcs', 'surunga', 'admin@exaample.com', '9825981962', '-abcs.jpg', 1, '2018-08-31 18:41:50', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
