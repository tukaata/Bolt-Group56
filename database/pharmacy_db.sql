-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2021 at 06:30 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

DROP TABLE IF EXISTS `category_list`;
CREATE TABLE IF NOT EXISTS `category_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(1, 'Vitamins'),
(2, 'Antipyretics'),
(3, 'Analgesics'),
(4, 'Antibiotics'),
(5, 'Antiseptics'),
(6, 'Macrolides'),
(7, 'Tetracyclines'),
(8, 'Dosage');

-- --------------------------------------------------------

--
-- Table structure for table `customer_list`
--

DROP TABLE IF EXISTS `customer_list`;
CREATE TABLE IF NOT EXISTS `customer_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `contact` varchar(30) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_list`
--

INSERT INTO `customer_list` (`id`, `name`, `contact`, `address`) VALUES
(1, 'BRIGHT AGYEI', '+218 87867456453', 'SARKOMONO'),
(2, 'TITUS CUDJOE', '+233 577005341', 'ODORKOR'),
(3, 'KHALIL KESH', '+233 557084266', 'BORTIANOR'),
(4, 'KWAKWELE', '+244 4535344434', 'PANTANG ADENTA'),
(5, 'MARTIN BEDIAKO', '+233505678479', 'KASOA');

-- --------------------------------------------------------

--
-- Table structure for table `expired_product`
--

DROP TABLE IF EXISTS `expired_product`;
CREATE TABLE IF NOT EXISTS `expired_product` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `date_expired` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expired_product`
--

INSERT INTO `expired_product` (`id`, `product_id`, `qty`, `date_expired`, `date_created`) VALUES
(3, 6, 5, '2020-10-05', '2020-10-09 08:20:08'),
(4, 5, 5, '2021-07-12', '2021-07-12 15:46:02'),
(5, 2, 30, '2021-06-28', '2021-07-16 17:53:32'),
(10, 6, 5, '2020-10-05', '2020-10-09 08:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1= stockin , 2 = stockout',
  `stock_from` varchar(100) NOT NULL COMMENT 'sales/receiving',
  `form_id` int(30) NOT NULL,
  `expiry_date` date NOT NULL,
  `expired_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `other_details` text NOT NULL,
  `remarks` text NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `qty`, `type`, `stock_from`, `form_id`, `expiry_date`, `expired_confirmed`, `other_details`, `remarks`, `date_updated`) VALUES
(15, 6, 500, 1, 'receiving', 4, '2021-12-16', 0, '{"price":"5.0","qty":"500"}', 'Stock from Receiving-00000000\r\n', '2021-07-12 15:19:49'),
(16, 8, 200, 1, 'receiving', 5, '2022-12-14', 0, '{"price":"25","qty":"200"}', 'Stock from Receiving-88218930\n', '2021-07-12 15:20:34'),
(17, 2, 550, 1, 'receiving', 6, '2022-05-20', 0, '{"price":"10","qty":"550"}', 'Stock from Receiving-79830290\n', '2021-07-12 15:22:18'),
(18, 3, 450, 1, 'receiving', 7, '2022-03-31', 0, '{"price":"30","qty":"450"}', 'Stock from Receiving-58206554\n', '2021-07-12 15:23:21'),
(19, 5, 200, 1, 'receiving', 8, '2022-04-21', 0, '{"price":"5","qty":"200"}', 'Stock from Receiving-78319133\n', '2021-07-12 15:24:35'),
(20, 4, 350, 1, 'receiving', 9, '2022-08-24', 0, '{"price":"15","qty":"350"}', 'Stock from Receiving-87464659\n', '2021-07-12 15:34:31'),
(21, 7, 400, 1, 'receiving', 10, '2023-06-29', 0, '{"price":"31","qty":"400"}', 'Stock from Receiving-93193445\n', '2021-07-12 15:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE IF NOT EXISTS `product_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category_id` text NOT NULL,
  `type_id` int(30) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `name` varchar(150) NOT NULL,
  `measurement` text NOT NULL,
  `description` text NOT NULL,
  `prescription` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `type_id`, `sku`, `price`, `name`, `measurement`, `description`, `prescription`) VALUES
(2, '4', 1, '32563070', 200, 'Amoxicillin 250', '250mg', '2 x a day\r\nMorning \r\nEvening', 1),
(3, '4', 2, '59118534', 10, 'Cephalexin 250', '250mg', 'Sample', 0),
(4, '3', 5, '89612125', 10, 'Hydromorphone 2', '2mg', 'Sample', 0),
(5, '3', 5, '90433847', 15, 'Demerol 50', '50mg', 'Sample', 0),
(6, '3', 5, '30410592', 30, 'Paracetamol 50', '50mg', 'Sample', 1),
(7, '1', 5, '15196587\n', 50, 'Pyridoxine 50', '50mg', 'Sample', 0),
(8, '5', 6, '57429604', 50, 'Intravenous', '500mg', 'Sample only', 1);

-- --------------------------------------------------------

--
-- Table structure for table `receiving_list`
--

DROP TABLE IF EXISTS `receiving_list`;
CREATE TABLE IF NOT EXISTS `receiving_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `ref_no` varchar(100) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receiving_list`
--

INSERT INTO `receiving_list` (`id`, `ref_no`, `supplier_id`, `total_amount`, `date_added`) VALUES
(4, '00000000\n', 4, 2500, '2021-07-12 15:19:27'),
(5, '88218930\n', 3, 5000, '2021-07-12 15:20:34'),
(6, '79830290\n', 1, 5500, '2021-07-12 15:22:18'),
(7, '58206554\n', 4, 13500, '2021-07-12 15:23:21'),
(8, '78319133\n', 1, 1000, '2021-07-12 15:24:35'),
(9, '87464659\n', 5, 5250, '2021-07-12 15:34:31'),
(10, '93193445\n', 4, 12400, '2021-07-12 15:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `sales_list`
--

DROP TABLE IF EXISTS `sales_list`;
CREATE TABLE IF NOT EXISTS `sales_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `ref_no` varchar(30) NOT NULL,
  `customer_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `amount_tendered` double NOT NULL,
  `amount_change` double NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_list`
--

INSERT INTO `sales_list` (`id`, `ref_no`, `customer_id`, `total_amount`, `amount_tendered`, `amount_change`, `date_updated`) VALUES
(6, '14902956\n', 0, 150, 200, 50, '2021-07-12 14:39:28'),
(7, '00000000\n', 2, 100, 0, 0, '2021-07-12 21:28:25'),
(8, '52207044\n', 3, 40, 0, 0, '2021-07-13 16:42:43'),
(9, '34573692\n', 5, 100, 0, 0, '2021-07-16 14:00:29'),
(10, '59611464\n', 5, 15, 0, 0, '2021-07-16 14:01:20'),
(11, '43116305\n', 1, 30, 50, 20, '2021-07-16 14:31:16'),
(12, '74782717\n', 0, 200, 0, 0, '2021-07-16 17:46:05'),
(13, '11374403\n', 0, 30, 0, 0, '2021-07-16 17:46:48'),
(14, '79055107\n', 3, 6000, 0, 0, '2021-07-16 17:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_list`
--

DROP TABLE IF EXISTS `supplier_list`;
CREATE TABLE IF NOT EXISTS `supplier_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `supplier_name` text NOT NULL,
  `contact` varchar(30) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_list`
--

INSERT INTO `supplier_list` (`id`, `supplier_name`, `contact`, `address`) VALUES
(1, 'TOBINCO', '030 345768433', 'INDUSTRAL AREA'),
(3, 'ERNEST CHEMIST ', '030 657809834', 'ACCRA '),
(4, 'POKUPHARMA', '+233 547869433', 'EJISU KUMASI'),
(5, 'KINAPHARMA', '+233 247689043', 'KONONGO');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Online Food Ordering System', 'info@sample.com', '+6948 8542 623', '1600654680_photo-1504674900247-0877df9cc836.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;ABOUT US&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;b style=&quot;margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem Ipsum&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#x2019;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;h2 style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;Where does it come from?&lt;/h2&gt;&lt;p style=&quot;text-align: center; margin-bottom: 15px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400;&quot;&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.&lt;/p&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `type_list`
--

DROP TABLE IF EXISTS `type_list`;
CREATE TABLE IF NOT EXISTS `type_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_list`
--

INSERT INTO `type_list` (`id`, `name`) VALUES
(1, 'Liquids'),
(2, 'Capsule'),
(3, 'Drops'),
(4, 'Inhalers'),
(5, 'Tablet'),
(6, 'Injection'),
(7, 'Oxytocin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=admin , 2 = cashier',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'DR FYNEST', 'admin', 'admin', 1),
(4, 'KWAKWELE', 'KWAKWELE', 'KWAKWELE', 2),
(5, 'TITUS', 'KWAKWELE', 'KWAKWELE', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
