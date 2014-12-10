-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2014 at 06:14 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `souvenirs`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_c` varchar(45) DEFAULT NULL,
  `lastname_c` varchar(45) DEFAULT NULL,
  `adress_c` varchar(45) DEFAULT NULL,
  `country_c` varchar(45) DEFAULT NULL,
  `zc_c` varchar(45) DEFAULT NULL,
  `tel_c` varchar(45) DEFAULT NULL,
  `mobile_c` varchar(45) DEFAULT NULL,
  `age_c` varchar(45) DEFAULT NULL,
  `rfc_c` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`,`user_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_sale`
--

CREATE TABLE IF NOT EXISTS `detail_sale` (
  `detail_sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt` int(11) DEFAULT NULL,
  `date_sale` date DEFAULT NULL,
  `time_sale` time DEFAULT NULL,
  `cant` int(11) DEFAULT NULL,
  `name_p` varchar(45) DEFAULT NULL,
  `price_p` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `detail_salecol` varchar(45) DEFAULT NULL,
  `type_pay` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `product_product_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_sale_id`,`product_product_id`),
  KEY `fk_detail_sale_product1_idx` (`product_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_p` varchar(45) DEFAULT NULL,
  `desc_p` varchar(45) DEFAULT NULL,
  `price_p` double DEFAULT NULL,
  `stock_p` int(11) DEFAULT NULL,
  `picture_p` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `type_product_type_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_type_product_idx` (`type_product_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name_p`, `desc_p`, `price_p`, `stock_p`, `picture_p`, `created`, `type_product_type_id`) VALUES
(1, 'Discografía', 'Doop Hoop Hooligans & Unorthodox Jukebox', 1000, 10, 'public_html/img/uno.jpg', '2014-10-02 00:00:00', 1),
(2, 'Necklace Bootle', 'Shaped  ring necklace', 300, 30, 'public_html/img/dos.jpg', '2014-10-03 00:00:00', 1),
(5, 'Guitar Picks', '2 Guitar Picks With Hooligan text', 200, 200, 'public_html/img/tres.jpg', '2014-10-17 00:00:00', 1),
(6, 'T-Shirt  Lazy Song', 'Black T-shirt about lazy song', 250, 100, 'public_html/img/cuatro.jpg', '2014-10-17 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `desc_profile` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `type_product`
--

CREATE TABLE IF NOT EXISTS `type_product` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `desc_type:product` varchar(45) DEFAULT NULL,
  `creted` datetime DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `type_product`
--

INSERT INTO `type_product` (`type_id`, `desc_type:product`, `creted`) VALUES
(1, 'Jewerly', '2014-10-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_u` varchar(45) DEFAULT NULL,
  `nickname_u` varchar(45) DEFAULT NULL,
  `pass_u` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `profile_profile_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`profile_profile_id`),
  KEY `fk_user_profile1_idx` (`profile_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_sale`
--
ALTER TABLE `detail_sale`
  ADD CONSTRAINT `fk_detail_sale_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_type_product` FOREIGN KEY (`type_product_type_id`) REFERENCES `type_product` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_profile1` FOREIGN KEY (`profile_profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
