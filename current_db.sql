-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2022 at 04:01 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wallet_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `announcement_image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `announcement_image`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Guess the next opening', 'Guess the next opening', 'https://bungkuskawkaw.com/wp-content/uploads/2020/12/Bkk-Web-Banner-Home-Beverages-R1-Kent-13-1.png', 1, 1, '2022-04-20 05:28:48', NULL, NULL),
(3, 'Picture of the day', 'Picture of the day', 'https://bungkuskawkaw.com/wp-content/uploads/2020/12/Bkk-Web-Banner-Home-Beverages-R1-Kent-14.png', 1, 1, '2022-04-20 05:28:48', NULL, NULL),
(5, 'Photo of the month', 'Photo of the month', 'https://bungkuskawkaw.com/wp-content/uploads/2020/12/Bkk-Web-Banner-Home-Beverages-R1-Kent-10.png', 1, 1, '2022-04-20 05:28:48', NULL, NULL),
(7, 'new combo RM0.10', '12321', 'https://bungkuskawkaw.com/wp-content/uploads/2020/12/Bkk-Web-Banner-Home-Beverages-R1-Kent-12.png', 1, 1, '2022-04-20 05:28:48', NULL, NULL),
(18, 'red day', 'hello', '1651129617_announcement.jpg', 1, 2, '2022-04-28 07:06:57', '2022-04-28 01:36:57', NULL),
(19, 'grand opening cermony', 'this is nice opening', '1653479792_announcement.png', 1, 2, '2022-05-25 11:56:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `pincode`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'singapore', 100004, 1, '2019-11-29 05:29:59', '2022-05-16 04:44:05', NULL),
(16, 'mannargudi', 6140021, 2, '2022-05-24 04:58:20', '2022-05-24 04:58:20', NULL),
(17, 'needamanglam', 614367, 2, '2022-05-24 05:00:22', '2022-05-24 05:00:22', NULL),
(18, 'japan', 786567, 2, '2022-05-25 11:58:04', '2022-05-25 11:58:04', NULL),
(19, 'china', 89987, 1, '2022-05-25 11:58:19', '2022-05-25 11:58:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` int(15) NOT NULL,
  `receipt_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_date` datetime NOT NULL,
  `receipt_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_no` int(20) NOT NULL,
  `cashier_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_count` int(15) NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `outlet_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `outlet_id` int(20) NOT NULL,
  `pos_sno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purch_items` json NOT NULL,
  `gross_sales` decimal(5,2) NOT NULL,
  `discount` json NOT NULL,
  `service_charge` decimal(5,2) NOT NULL,
  `taxable_total` decimal(5,2) NOT NULL,
  `svc_tax_amt` decimal(5,2) NOT NULL,
  `vat_tax_amt` decimal(5,2) NOT NULL,
  `rounding_adj` decimal(5,2) NOT NULL,
  `total_tax` decimal(5,2) NOT NULL,
  `grand_total` decimal(5,2) NOT NULL,
  `payment` json NOT NULL,
  `refund_flag` int(11) NOT NULL,
  `cancel_flag` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `transaction_id`, `receipt_id`, `receipt_date`, `receipt_type`, `reference_no`, `table_no`, `cashier_id`, `customer_id`, `customer_count`, `business_name`, `outlet_name`, `outlet_id`, `pos_sno`, `purch_items`, `gross_sales`, `discount`, `service_charge`, `taxable_total`, `svc_tax_amt`, `vat_tax_amt`, `rounding_adj`, `total_tax`, `grand_total`, `payment`, `refund_flag`, `cancel_flag`, `created_at`, `updated_at`) VALUES
(1, 691350, 'muRoEb', '2022-10-13 15:04:29', 'DINE-IN', '#81497', 1, 'bkk-566606121', 'bkk-523918013', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 14:04:29', '2022-10-13 14:04:29'),
(2, 864287, 'INOIiK', '2022-10-13 15:30:01', 'DINE-IN', '#24626', 1, 'bkk-566606121', 'bkk-523918013', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 14:30:01', '2022-10-13 14:30:01'),
(3, 414447, 'wjPmbg', '2022-10-13 16:28:13', 'DINE-IN', '#31374', 1, 'bkk-393899499', 'bkk-393899499', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 15:28:13', '2022-10-13 15:28:13'),
(4, 495146, 'ekT7Zb', '2022-10-13 18:02:08', 'DINE-IN', '#62292', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:02:08', '2022-10-13 17:02:08'),
(5, 669147, 'OWMmdX', '2022-10-13 18:03:18', 'DINE-IN', '#45457', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:03:18', '2022-10-13 17:03:18'),
(6, 818114, 'eWlpal', '2022-10-13 18:04:41', 'DINE-IN', '#73036', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:04:41', '2022-10-13 17:04:41'),
(7, 521782, 'rt6LV2', '2022-10-13 18:21:17', 'DINE-IN', '#61566', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '{\"0\": {\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, \"1\": {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, \"10\": {\"amount\": 24}}', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:21:17', '2022-10-13 17:21:17'),
(8, 528715, 'OOMJCt', '2022-10-13 18:22:13', 'DINE-IN', '#58890', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, {\"amount\": 24}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:22:13', '2022-10-13 17:22:13'),
(9, 582910, 'poRIBF', '2022-10-13 18:22:47', 'DINE-IN', '#79680', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"120.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, {\"amount\": 24}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:22:47', '2022-10-13 17:22:47'),
(10, 611629, 's3BMXp', '2022-10-13 18:23:01', 'DINE-IN', '#81217', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": \"120.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": \"240.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, {\"amount\": 24}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:23:01', '2022-10-13 17:23:01'),
(11, 122217, 'WrP8j2', '2022-10-13 18:23:48', 'DINE-IN', '#79294', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, {\"amount\": 24}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:23:48', '2022-10-13 17:23:48'),
(12, 247514, 'UiDh0p', '2022-10-13 18:25:18', 'DINE-IN', '#24856', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:25:18', '2022-10-13 17:25:18'),
(13, 295468, '8S7Tdp', '2022-10-13 18:47:25', 'DINE-IN', '#80950', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:47:25', '2022-10-13 17:47:25'),
(14, 585772, 'H77rEi', '2022-10-13 18:48:10', 'DINE-IN', '#84108', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:48:10', '2022-10-13 17:48:10'),
(15, 493375, '4GGWeW', '2022-10-13 18:51:08', 'DINE-IN', '#98138', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-13 17:51:08', '2022-10-13 17:51:08'),
(16, 701218, 'M0eTBS', '2022-10-14 04:58:49', 'DINE-IN', '#36164', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '{\"0\": {\"amount\": \"12.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, \"1\": {\"amount\": \"24.00\", \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}, \"amount\": 24}', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 03:58:49', '2022-10-14 03:58:49'),
(17, 466090, 'ni0ysy', '2022-10-14 04:59:43', 'DINE-IN', '#41575', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 03:59:43', '2022-10-14 03:59:43'),
(18, 409779, '3NoNRA', '2022-10-14 05:07:37', 'DINE-IN', '#99117', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 04:07:37', '2022-10-14 04:07:37'),
(19, 296850, 'lo85A3', '2022-10-14 05:08:22', 'DINE-IN', '#23669', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 04:08:22', '2022-10-14 04:08:22'),
(20, 547189, 'GtiqL8', '2022-10-14 05:10:42', 'DINE-IN', '#90920', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": \"10.00\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": \"2.24\", \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 04:10:42', '2022-10-14 04:10:42'),
(21, 117124, 'RKZdot', '2022-10-14 05:12:48', 'DINE-IN', '#17831', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": 10, \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": 2.24, \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 04:12:48', '2022-10-14 04:12:48'),
(22, 880562, 'dc0ZfE', '2022-10-14 05:14:44', 'DINE-IN', '#15900', 1, 'bkk-566606121', 'bkk-566606121', 1, 'GrandImperial', 'Tesco Kepong Village', 1, '001', '[{\"amount\": 17.24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"Christmas Promo Item\"}, {\"discount_amount\": 4, \"discount_description\": \"Citibank discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"R001\", \"sub_item_desc\": \"Chicken Rice\", \"sub_item_amount\": 10, \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"10.00\", \"sub_item_ean_barcode\": \"RBS1\"}, {\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": 2.24, \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"2.24\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"C001\", \"item_desc\": \"Chicken Rice Set\", \"unit_price\": \"17.24\", \"item_ean_barcode\": null}, {\"amount\": 24, \"discount\": [{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}], \"quantity\": \"1\", \"sub_item\": [{\"sub_item_code\": \"D001\", \"sub_item_desc\": \"Chinese Tea\", \"sub_item_amount\": 0, \"sub_item_quantity\": \"1\", \"sub_item_unit_price\": \"0\", \"sub_item_ean_barcode\": \"RBS1\"}], \"item_code\": \"D001\", \"item_desc\": \"Red Bean Soup\", \"unit_price\": \"24.00\", \"item_ean_barcode\": \"RBS1\"}]', '47.48', '[{\"discount_amount\": 1, \"discount_description\": \"FoodPanda Discount\"}, {\"discount_amount\": 4, \"discount_description\": \"Food Delivery Discount\"}]', '1.40', '43.88', '0.00', '0.84', '0.02', '0.84', '44.74', '[{\"amount\": \"34.74\", \"cash_paid\": \"10.00\", \"cash_change\": \"6.50\", \"refund_flag\": null, \"payment_type\": \"CASH\"}, {\"amount\": \"10.00\", \"refund_flag\": null, \"payment_type\": \"WALLET\"}]', 0, 0, '2022-10-14 04:14:44', '2022-10-14 04:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `bundle_vouchers`
--

DROP TABLE IF EXISTS `bundle_vouchers`;
CREATE TABLE IF NOT EXISTS `bundle_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bundle_voucher_name` varchar(255) NOT NULL,
  `bundle_voucher_code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `vouchers` varchar(255) NOT NULL,
  `sale_start_date` date NOT NULL,
  `sale_end_date` date NOT NULL,
  `outlet_ids` varchar(255) NOT NULL,
  `buy_bundle_with` json NOT NULL,
  `max_qty` int(11) NOT NULL,
  `single_user_qty` int(11) NOT NULL,
  `tAndC` text,
  `free_gifts` json NOT NULL,
  `bundle_voucher_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bundle_vouchers`
--

INSERT INTO `bundle_vouchers` (`id`, `bundle_voucher_name`, `bundle_voucher_code`, `description`, `vouchers`, `sale_start_date`, `sale_end_date`, `outlet_ids`, `buy_bundle_with`, `max_qty`, `single_user_qty`, `tAndC`, `free_gifts`, `bundle_voucher_image`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `status`) VALUES
(1, 'TestBundle', 'b-v-bkksub489951100515', 'gfgfgfgf', '2,3', '2022-09-28', '2022-10-05', '2,7', '[{\"wallet_credit\": \"333\"}]', 33, 33, 'ggfgfgfgfgf', '[{\"free_items\": \"1\", \"free_points\": \"3\"}]', '', '2022-10-18 22:59:31', '2022-10-19 15:18:31', NULL, 1, 1, 3),
(2, 'TestBundle2', 'b-v-bkksub484898565256', 'gfgfgfgf', '', '2022-09-28', '2022-10-13', '2', '[{\"wallet_credit\": \"333\"}]', 33, 33, 'ggfgfgfgfgf', '[{\"free_items\": null, \"free_points\": null}]', '', '2022-10-18 23:03:43', '2022-10-19 15:18:38', NULL, 1, 0, 3),
(3, 'TestBundle6', 'b-v-bkksub501001005755', 'ggggg', '1,3', '2022-10-04', '2022-10-27', '3', '[{\"wallet_credit\": \"30\"}]', 3, 3, 'ffffffff', '[{\"free_items\": \"1\", \"free_points\": \"3\"}]', '1666134348_bundle_vouchers.png', '2022-10-18 23:05:48', '2022-10-19 15:18:44', NULL, 1, 1, 1),
(4, 'TestBundle4', 'b-v-bkksub984952505556', 'ddddddd', '', '2022-09-27', '2022-09-27', '1', '[{\"wallet_credit\": \"3\"}]', 3, 3, NULL, '[{\"free_items\": \"1\", \"free_points\": \"888\"}]', '', '2022-10-19 11:11:16', '2022-10-19 14:50:34', NULL, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bevarages', 1, 1, '2019-07-29 15:51:50', '2022-05-27 00:35:07', NULL),
(3, 'Vegetables', 2, 1, '2022-05-24 06:29:18', '2022-05-24 00:59:27', NULL),
(4, 'fruits', 2, 1, '2022-05-25 12:00:57', '2022-05-25 12:00:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `couponcodes`
--

DROP TABLE IF EXISTS `couponcodes`;
CREATE TABLE IF NOT EXISTS `couponcodes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1 - top-up, 2 - paid, 3 - get user info',
  `amount` decimal(10,2) DEFAULT NULL,
  `coupon` varchar(40) NOT NULL,
  `outlet_id` bigint(20) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `firebase_uuid` varchar(30) NOT NULL,
  `transaction_id` varchar(30) DEFAULT NULL,
  `tranasaction_datetime` datetime DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 - initiated, 1 - Success, 2- Failure, 3- Expired',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=465 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `couponcodes`
--

INSERT INTO `couponcodes` (`id`, `user_id`, `type`, `amount`, `coupon`, `outlet_id`, `merchant_id`, `firebase_uuid`, `transaction_id`, `tranasaction_datetime`, `currency`, `created_at`, `updated_at`, `updated_by`, `status`, `deleted_at`) VALUES
(10, 22, 1, '10.00', 'vtue3uUra44ue8M7', 2, NULL, '-Ll5GCjtRjHMNrm2jqvG', NULL, NULL, NULL, '2019-07-31 04:23:33', '2019-07-31 04:23:53', NULL, 1, NULL),
(11, 5, 0, NULL, 'w6MAWuCwJW7LddzQ', NULL, NULL, '-Ll5SrUWXbgOUBJ0ODpg', NULL, NULL, NULL, '2019-07-31 05:18:50', '2019-07-31 05:20:01', NULL, 3, NULL),
(12, 5, 1, '10.00', 'SlwVlbuO3jE4gkuJ', 2, NULL, '-Ll5qdOuER4NrkyL7O5c', NULL, NULL, NULL, '2019-07-31 07:07:06', '2019-07-31 07:07:36', NULL, 1, NULL),
(13, 5, 2, '5.00', 'OuuaJb1H9xBDeEku', 2, NULL, '-Ll5qntTUNot5N9gvtpE', NULL, NULL, NULL, '2019-07-31 07:07:49', '2019-07-31 07:08:21', NULL, 1, NULL),
(14, 22, 0, NULL, '6AQOAPmLfomnZT4G', NULL, NULL, '-Ll6cHmXI6T1rNjzK09L', NULL, NULL, NULL, '2019-07-31 10:44:00', '2019-07-31 10:45:02', NULL, 3, NULL),
(15, 5, 0, NULL, 'WHhSQIcJ5Gm1F1RE', NULL, NULL, '-Ll6oa2l3Nrl5ROAB0hC', NULL, NULL, NULL, '2019-07-31 11:37:45', '2019-07-31 11:38:47', NULL, 3, NULL),
(16, 17, 1, '10.00', 'rPSpDgQYQ0dhmst1', 6, NULL, '-Ll7Fn5Wlg083UX0cEgw', NULL, NULL, NULL, '2019-07-31 13:40:58', '2019-07-31 13:41:21', NULL, 1, NULL),
(17, 29, 0, NULL, 'm4PkunF7ojY7Jx2O', NULL, NULL, '-Ll7M9rLlP5VyPu9eW43', NULL, NULL, NULL, '2019-07-31 14:08:49', '2019-07-31 14:10:02', NULL, 3, NULL),
(18, 17, 0, NULL, '4jmZtCD76lxoCgp4', NULL, NULL, '-Ll7fIv88QYnFt0MRmn2', NULL, NULL, NULL, '2019-07-31 15:36:49', '2019-07-31 15:38:02', NULL, 3, NULL),
(19, 22, 0, NULL, 'RzDFyVDxO5T7zqet', NULL, NULL, '-Llb0wkTz_Xol62BTPPB', NULL, NULL, NULL, '2019-08-06 13:04:20', '2019-08-06 13:06:02', NULL, 3, NULL),
(20, 5, 1, '10.00', '1rppnBNJeLz6WLEG', 2, NULL, '-LmJUMs5T43BSaFZinz4', 'T-bkksub15554100519897975', '2019-08-15 08:56:10', 'RM', '2019-08-15 08:55:48', '2019-08-15 08:56:10', NULL, 1, NULL),
(21, 5, 2, '2.00', 'W6MZQZNpyfU3L6gR', 2, NULL, '-LmJUy8QLKwo7XBXsKal', 'T-bkksub25350975052101485', '2019-08-15 08:58:53', 'RM', '2019-08-15 08:58:24', '2019-08-15 08:58:53', NULL, 1, NULL),
(22, 17, 0, NULL, 'ByBQiQoF3R6V8xPY', NULL, NULL, '-LmopWR3tyuyBFy9yGyN', NULL, NULL, NULL, '2019-08-21 15:40:25', '2019-08-21 15:41:27', NULL, 3, NULL),
(23, 17, 0, NULL, 'YeXWpVGrtnAaKYlB', NULL, NULL, '-Lmu5LSrfiuCJvC2r4eF', NULL, NULL, NULL, '2019-08-22 16:12:02', '2019-08-22 16:13:04', NULL, 3, NULL),
(24, 17, 1, '10.00', '2OR0RIf08kCpnZHo', 2, NULL, '-LmuFrZh28h0sjXPF2Jx', 'T-bkksub11011014951975710', '2019-08-22 16:58:26', 'RM', '2019-08-22 16:57:59', '2019-08-22 16:58:26', NULL, 1, NULL),
(25, 17, 1, '10.00', 'wZev8jcEyrsQQZMq', 2, NULL, '-LmygZniaKrduOc8UagW', 'T-bkksub15057100995556555', '2019-08-23 13:38:02', 'RM', '2019-08-23 13:37:31', '2019-08-23 13:38:02', NULL, 1, NULL),
(26, 17, 1, '90.00', 'EUXw7Br7vzfsaWdI', 2, NULL, '-LmygmNs5lMqLJqbvxKu', 'T-bkksub19910248485653100', '2019-08-23 13:38:44', 'RM', '2019-08-23 13:38:27', '2019-08-23 13:38:44', NULL, 1, NULL),
(27, 17, 1, '67.00', 'Zs0Ta9jKAtAnLJFC', 2, NULL, '-LmyhNWuxwDdERemhV0U', 'T-bkksub11025456102489953', '2019-08-23 13:41:21', 'RM', '2019-08-23 13:41:03', '2019-08-23 13:41:21', NULL, 1, NULL),
(28, 17, 2, '5.00', 'mhGsi67ucHj8UdiA', 2, NULL, '-LmyhsB2zbWU-QMoqWpP', 'T-bkksub21005755571025755', '2019-08-23 13:43:25', 'RM', '2019-08-23 13:43:13', '2019-08-23 13:43:25', NULL, 1, NULL),
(29, 17, 2, '7.00', 'Uwq8mADBHZRlJO5F', 2, NULL, '-LmyjeuF3ZoxyjyaBgad', 'T-bkksub25049102100101979', '2019-08-23 13:51:20', 'RM', '2019-08-23 13:51:03', '2019-08-23 13:51:20', NULL, 1, NULL),
(30, 17, 1, '67.00', 'dBuIRrIUWcnGCepZ', 2, NULL, '-LmyjzvkRLnr7hETNd70', 'T-bkksub15654485097564857', '2019-08-23 13:52:50', 'RM', '2019-08-23 13:52:29', '2019-08-23 13:52:50', NULL, 1, NULL),
(31, 17, 2, '17.00', 'TB2NKpqaV5KGt3Ym', 2, NULL, '-LmykPMuyvUqkx5H-b_E', 'T-bkksub25010110299485549', '2019-08-23 13:54:36', 'RM', '2019-08-23 13:54:17', '2019-08-23 13:54:36', NULL, 1, NULL),
(32, 17, 0, NULL, 'moIg25xryKucGwNj', NULL, NULL, '-Lmz7Wqfzljgf4vJSkFo', NULL, NULL, NULL, '2019-08-23 15:39:39', '2019-08-23 15:41:02', NULL, 3, NULL),
(33, 17, 0, NULL, 'ugn3HbccNYIdA7Cf', NULL, NULL, '-Ln7xr6jJoCMZWZylSJk', NULL, NULL, NULL, '2019-08-25 13:29:15', '2019-08-25 13:31:02', NULL, 3, NULL),
(34, 5, 0, NULL, 'LXDm8sovfyVIO37s', NULL, NULL, '-LnBTiWXQ_FI8_cfxD73', NULL, NULL, NULL, '2019-08-26 05:51:42', '2019-08-26 05:53:02', NULL, 3, NULL),
(35, 5, 0, NULL, '5F4C9RbdEM6J08ou', NULL, NULL, '-LnBTydi3aZTwRs7fKv8', NULL, NULL, NULL, '2019-08-26 05:52:48', '2019-08-26 05:54:02', NULL, 3, NULL),
(36, 17, 0, NULL, 'MgL5dXRpwH2h3pzS', NULL, NULL, '-LnDPcsEZfKqF8fJTLjt', NULL, NULL, NULL, '2019-08-26 14:53:05', '2019-08-26 14:54:07', NULL, 3, NULL),
(37, 17, 0, NULL, '8fGNny0e8GKURMkE', NULL, NULL, '-LnDQ8R4UTIqKNAq-5qC', NULL, NULL, NULL, '2019-08-26 14:55:18', '2019-08-26 14:56:20', NULL, 3, NULL),
(38, 17, 0, NULL, '4y1ExqvUkDbkuGPz', NULL, NULL, '-LnDQS5Ya8T7Su16iRFC', NULL, NULL, NULL, '2019-08-26 14:56:39', '2019-08-26 14:57:40', NULL, 3, NULL),
(39, 17, 1, '67.00', 'oReRMiXt4990esqF', 2, NULL, '-LnDRezyugqF9uexZrUw', 'T-bkksub14949531029750515', '2019-08-26 15:02:17', 'RM', '2019-08-26 15:01:58', '2019-08-26 15:02:17', NULL, 1, NULL),
(40, 17, 2, '300.00', 'hIK4EkIpsbSkVxVs', 2, NULL, '-LnDRsRnwbkOz7n0FBys', NULL, NULL, NULL, '2019-08-26 15:02:53', '2019-08-26 15:03:27', NULL, 2, NULL),
(41, 17, 0, NULL, 'ebNA8ano5bND5mTU', NULL, NULL, '-LnNNVdweIAyHNVDeJ1W', NULL, NULL, NULL, '2019-08-28 13:19:59', '2019-08-28 13:21:01', NULL, 3, NULL),
(42, 17, 2, '300.00', 'AHIE2emFT3loJdtm', 2, NULL, '-LnNPpAQg4AY3RSJRNtg', NULL, NULL, NULL, '2019-08-28 13:30:08', '2019-08-28 13:30:52', NULL, 2, NULL),
(43, 5, 0, NULL, 'xHb7XpD25A63OIQb', NULL, NULL, '-LnNs1yruI5FnW8lhIFS', NULL, NULL, NULL, '2019-08-28 15:37:46', '2019-08-28 15:38:52', NULL, 3, NULL),
(44, 17, 0, NULL, 'tlbwMWWEAsEMVfp4', NULL, NULL, '-LnNs60Y01k3FbyN7I6n', NULL, NULL, NULL, '2019-08-28 15:38:03', '2019-08-28 15:39:04', NULL, 3, NULL),
(45, 17, 0, NULL, 'YZqAiD49cmLKfKYP', NULL, NULL, '-LnNsQoDlcq_VN4OM_1k', NULL, NULL, NULL, '2019-08-28 15:39:28', '2019-08-28 15:40:29', NULL, 3, NULL),
(46, 17, 0, NULL, 'uNO8Ig2C8USJozLD', NULL, NULL, '-LnNtOKarFUyjBTVYYks', NULL, NULL, NULL, '2019-08-28 15:43:40', '2019-08-28 15:44:41', NULL, 3, NULL),
(47, 17, 0, NULL, 'WF85nPkfAJZyA3sv', NULL, NULL, '-LnNtgEQjbHTlSMwlXR1', NULL, NULL, NULL, '2019-08-28 15:44:57', '2019-08-28 15:45:59', NULL, 3, NULL),
(48, 17, 0, NULL, 'qYxzAZvkgNM0lLlt', NULL, NULL, '-LnNvtVR3ksMWFZUkSEL', NULL, NULL, NULL, '2019-08-28 15:54:36', '2019-08-28 15:55:37', NULL, 3, NULL),
(49, 17, 0, NULL, 'FDwsq1V1DfKtigUC', NULL, NULL, '-LnNy1TqFtTciNQSWFEP', NULL, NULL, NULL, '2019-08-28 16:03:57', '2019-08-28 16:04:58', NULL, 3, NULL),
(50, 17, 0, NULL, 'kER9m1evntBbYqoL', NULL, NULL, '-LnO-lMOQOPPX2JksNKI', NULL, NULL, NULL, '2019-08-28 16:15:53', '2019-08-28 16:16:55', NULL, 3, NULL),
(51, 17, 0, NULL, 'PrQ8TWfEB5kDCjwE', NULL, NULL, '-LnO1WsuLl5h8Ao-vyOz', NULL, NULL, NULL, '2019-08-28 16:23:34', '2019-08-28 16:25:02', NULL, 3, NULL),
(52, 17, 0, NULL, 'DIwXL6odUFVKu7BY', NULL, NULL, '-LnO1lChyO3kTbHpw0an', NULL, NULL, NULL, '2019-08-28 16:24:37', '2019-08-28 16:25:39', NULL, 3, NULL),
(53, 17, 0, NULL, 'EL9jm2viTpx3E8fH', NULL, NULL, '-LnO2QcancTJcqVTiZJM', NULL, NULL, NULL, '2019-08-28 16:27:31', '2019-08-28 16:28:32', NULL, 3, NULL),
(54, 17, 0, NULL, 'Bhhr95TOO17CDRJe', NULL, NULL, '-LnO3EbdejDpVLMDTLND', NULL, NULL, NULL, '2019-08-28 16:31:04', '2019-08-28 16:32:05', NULL, 3, NULL),
(55, 17, 2, '2.00', 'hMdsGRpRWu2HcFPj', 2, NULL, '-LnO4-SXpdLmM3ApBTOn', 'T-bkksub25553101975098989', '2019-08-28 16:34:53', 'RM', '2019-08-28 16:34:24', '2019-08-28 16:34:53', NULL, 1, NULL),
(56, 17, 2, '2.00', '4GYYOMN3FdBV2s7E', 2, NULL, '-LnO4lURXu2g8mArZLIH', 'T-bkksub25110253485798101', '2019-08-28 16:38:04', 'RM', '2019-08-28 16:37:45', '2019-08-28 16:38:04', NULL, 1, NULL),
(57, 17, 1, '67.00', 't2vsSqNS0AS0mDHX', 2, NULL, '-LnO57B2buwZTeY3_sNx', 'T-bkksub19952524852971005', '2019-08-28 16:39:27', 'RM', '2019-08-28 16:39:18', '2019-08-28 16:39:27', NULL, 1, NULL),
(58, 17, 2, '2000.00', 'Xa8TND734Cny1cSj', 2, NULL, '-LnO5MgKh_moOBgX965m', NULL, NULL, NULL, '2019-08-28 16:40:21', '2019-08-28 16:40:32', NULL, 2, NULL),
(59, 17, 2, '2000.00', 'Nz4BGgpchBVrkJEI', 2, NULL, '-LnO5fHuSQbZRUiGCGUD', NULL, NULL, NULL, '2019-08-28 16:41:41', '2019-08-28 16:41:51', NULL, 2, NULL),
(60, 17, 2, '200.00', 'KNj1IhWDDLDvxuvh', 2, NULL, '-LnO5oq1yqz-fshE1suD', 'T-bkksub21005750100575157', '2019-08-28 16:42:31', 'RM', '2019-08-28 16:42:20', '2019-08-28 16:42:31', NULL, 1, NULL),
(61, 17, 1, '670.00', 'lxzpxysPDYHUve4e', 2, NULL, '-LnO5xQtZK9i-a9zkmci', 'T-bkksub19810250545448100', '2019-08-28 16:43:13', 'RM', '2019-08-28 16:42:56', '2019-08-28 16:43:13', NULL, 1, NULL),
(62, 17, 0, NULL, '667Mh1G1xE2mjQr8', NULL, NULL, '-LnO74we4Bel_ZOhOF3H', NULL, NULL, NULL, '2019-08-28 16:47:53', '2019-08-28 16:48:55', NULL, 3, NULL),
(63, 17, 0, NULL, 'FJ1PMoWSNFhd0jVC', NULL, NULL, '-LnO7NGB9kilWFLfRfq1', NULL, NULL, NULL, '2019-08-28 16:49:08', '2019-08-28 16:50:09', NULL, 3, NULL),
(64, 17, 0, NULL, 'zI0rPiZLVLko9w9Q', NULL, NULL, '-LnO7g2Bozma-cPDJBpX', NULL, NULL, NULL, '2019-08-28 16:50:29', '2019-08-28 16:51:30', NULL, 3, NULL),
(65, 17, 0, NULL, 'imUe687bhUt8g7yO', NULL, NULL, '-LnOCLns-yu2StuobdYE', NULL, NULL, NULL, '2019-08-28 17:10:52', '2019-08-28 17:11:54', NULL, 3, NULL),
(66, 17, 1, '13.00', 'MB5IA5q2WNoyUQhA', 2, NULL, '-LnOCzj3FQBAT9DHik4j', 'T-bkksub15149100100535210', '2019-08-28 17:13:51', 'RM', '2019-08-28 17:13:40', '2019-08-28 17:13:51', NULL, 1, NULL),
(67, 17, 2, '7.00', 'pfCepJoIEduxVPl0', 2, NULL, '-LnODAYH4eeVXTzsNhLa', 'T-bkksub25751525050515455', '2019-08-28 17:14:50', 'RM', '2019-08-28 17:14:29', '2019-08-28 17:14:50', NULL, 1, NULL),
(68, 29, 0, NULL, 'NqoJpmuP0WK5NOow', NULL, NULL, '-LnQ4M5IhIZyXbVSnNN3', NULL, NULL, NULL, '2019-08-29 01:55:11', '2019-08-29 01:57:02', NULL, 3, NULL),
(69, 17, 1, '670.00', 'sWMYshjG8B2Dl2WZ', 2, NULL, '-LnSqaDNZXeUICtHuHTI', 'T-bkksub15599575054565050', '2019-08-29 14:49:41', 'RM', '2019-08-29 14:49:32', '2019-08-29 14:49:41', NULL, 1, NULL),
(70, 17, 2, '200.00', '5nPJDGhY7WBXayi9', 2, NULL, '-LnSqgKoHJhgZga2rxht', 'T-bkksub21025357995153529', '2019-08-29 14:50:06', 'RM', '2019-08-29 14:49:57', '2019-08-29 14:50:06', NULL, 1, NULL),
(71, 17, 0, NULL, '6pFtiaE2iFn4tqOG', NULL, NULL, '-LnmQgP-CH2GlnSO5tdN', NULL, NULL, NULL, '2019-09-02 14:44:01', '2019-09-02 14:45:02', NULL, 3, NULL),
(72, 17, 0, NULL, 'tE8ArBr40e0rLWkc', NULL, NULL, '-LnmQrW0oBQdkg2D8VAB', NULL, NULL, NULL, '2019-09-02 14:44:47', '2019-09-02 14:46:02', NULL, 3, NULL),
(73, 17, 0, NULL, 'nLsDRmlewCQDaoHw', NULL, NULL, '-LnmRJ6RWvZDKeR5huvM', NULL, NULL, NULL, '2019-09-02 14:46:44', '2019-09-02 14:48:02', NULL, 3, NULL),
(74, 17, 1, '10.00', 'nwzwTLhlA9ZrpCKm', 2, NULL, '-LnmSkUbwvCoKbC7JEws', 'T-bkksub15497541015055102', '2019-09-02 14:53:11', 'RM', '2019-09-02 14:53:02', '2019-09-02 14:53:11', NULL, 1, NULL),
(75, 17, 0, NULL, '91YvcCOE7JXzoDJt', NULL, NULL, '-LnmU_LdTMLigSgdTqi1', NULL, NULL, NULL, '2019-09-02 15:01:01', '2019-09-02 15:02:02', NULL, 3, NULL),
(76, 5, 1, '10.00', 'XrrJCRZysvEiq9ry', 2, NULL, '-LnmaJ-XWSFb6yOSzABJ', 'T-bkksub14810248535298544', '2019-09-02 15:30:40', 'RM', '2019-09-02 15:30:25', '2019-09-02 15:30:40', NULL, 1, NULL),
(77, 5, 0, NULL, 'Gs5Ybm2ZaB3YlLzq', NULL, NULL, '-LnmqWfP1t7NRzExOmU1', NULL, NULL, NULL, '2019-09-02 16:41:15', '2019-09-02 16:43:02', NULL, 3, NULL),
(78, 5, 1, '12.00', '8QzNWK5w3RrG6AtI', 2, NULL, '-LnmqolEQ3pxJM2sY20x', 'T-bkksub14998554854514954', '2019-09-02 16:43:15', 'RM', '2019-09-02 16:42:34', '2019-09-02 16:43:15', NULL, 1, NULL),
(79, 5, 1, '123.00', 'K9YabYo3e63oLpcb', 2, NULL, '-LnmvCftXxMn3RZugxS1', 'T-bkksub15699102531024850', '2019-09-02 17:02:12', 'RM', '2019-09-02 17:01:44', '2019-09-02 17:02:12', NULL, 1, NULL),
(80, 5, 2, '5.00', 'rvbyuTGeU10N9Zby', 2, NULL, '-LnpXEo1bPgK0aepl8hH', 'T-bkksub25257561004853535', '2019-09-03 05:12:21', 'RM', '2019-09-03 05:11:31', '2019-09-03 05:12:21', NULL, 1, NULL),
(81, 5, 1, '123.00', 'uzoz6x7bHAYe1nfo', 2, NULL, '-LnplRmeTezEPe3KQVUF', 'T-bkksub15551489898539956', '2019-09-03 06:18:21', 'RM', '2019-09-03 06:17:56', '2019-09-03 06:18:21', NULL, 1, NULL),
(82, 5, 1, '1.00', 'kQapEaZzXa4nAAFA', 2, NULL, '-Lnplz-aQh74vE66lSde', 'T-bkksub15357525648575054', '2019-09-03 06:20:39', 'RM', '2019-09-03 06:20:16', '2019-09-03 06:20:39', NULL, 1, NULL),
(83, 5, 1, '12.00', 'mZNtWHv0xHj8CgO1', 2, NULL, '-LnpmRlUN1JTzUmZf0LG', 'T-bkksub15757100529997101', '2019-09-03 06:22:50', 'RM', '2019-09-03 06:22:18', '2019-09-03 06:22:50', NULL, 1, NULL),
(84, 5, 2, '123.00', '3bnqmK3ZVvrQWlSS', 2, NULL, '-LnpmqX9NNj8FwvbOnXJ', 'T-bkksub25199505010251529', '2019-09-03 06:24:42', 'RM', '2019-09-03 06:24:04', '2019-09-03 06:24:42', NULL, 1, NULL),
(85, 5, 1, '123.00', '8nk1FSqlLx0HD17X', 2, NULL, '-Lnpn2cyr8Jcvs4fB4Bk', 'T-bkksub15410256102100102', '2019-09-03 06:25:29', 'RM', '2019-09-03 06:24:57', '2019-09-03 06:25:29', NULL, 1, NULL),
(86, 41, 1, '200.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-03 20:47:03', NULL, NULL, 1, NULL),
(87, 41, 2, '50.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-03 20:48:18', NULL, NULL, 1, NULL),
(88, 17, 1, '10.00', 'CMS', 2, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-04 07:16:41', NULL, NULL, 1, NULL),
(89, 29, 0, NULL, 'E5IuIUeUGsoJRIad', NULL, NULL, '-LnwWYp9RZmtgRXpt9Ua', NULL, NULL, NULL, '2019-09-04 13:45:51', '2019-09-04 13:47:01', NULL, 3, NULL),
(90, 29, 0, NULL, 'fbTNYaG9peh0V7DV', NULL, NULL, '-Lnx26Na4WaPzLzZhQRW', NULL, NULL, NULL, '2019-09-04 16:12:28', '2019-09-04 16:14:01', NULL, 3, NULL),
(91, 29, 0, NULL, 'BMhy5tkB4Ehd65uD', NULL, NULL, '-Lnx2Q6iclF5LGNBsAtv', NULL, NULL, NULL, '2019-09-04 16:13:48', '2019-09-04 16:14:50', NULL, 3, NULL),
(92, 29, 1, '100.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-04 16:16:19', NULL, NULL, 1, NULL),
(93, 29, 0, NULL, 'KX4BoYfkclrFFCvU', NULL, NULL, '-Lnx3LUM_oiaKmVz7KHp', NULL, NULL, NULL, '2019-09-04 16:17:52', '2019-09-04 16:19:02', NULL, 3, NULL),
(94, 29, 0, NULL, 'bQdddQrvmjhNIC4m', NULL, NULL, '-Lnx4HhLqc3hmWMw-zPn', NULL, NULL, NULL, '2019-09-04 16:21:58', '2019-09-04 16:23:02', NULL, 3, NULL),
(95, 29, 0, NULL, 'qvlr69Diok39qIG0', NULL, NULL, '-Lnx5R1TAKG7GftQNHm7', NULL, NULL, NULL, '2019-09-04 16:26:59', '2019-09-04 16:28:01', NULL, 3, NULL),
(96, 29, 0, NULL, 'aRVLS7gI90KlZuXQ', NULL, NULL, '-LnzXwUYmjcnj1kJ40pe', NULL, NULL, NULL, '2019-09-05 03:50:46', '2019-09-05 03:52:02', NULL, 3, NULL),
(97, 17, 1, '12.00', 'Ps7jWXTIzdJyiol6', 2, NULL, '-LnzgWc4sQdNI-a4YBqg', 'T-bkksub15057100102984897', '2019-09-05 04:32:42', 'RM', '2019-09-05 04:32:37', '2019-09-05 04:32:42', NULL, 1, NULL),
(98, 17, 2, '2.00', 'MKSHOJmB9x46HbqZ', 2, NULL, '-Lnzgcx6_SXxKb5r7SyL', 'T-bkksub25649995652541014', '2019-09-05 04:33:16', 'RM', '2019-09-05 04:33:07', '2019-09-05 04:33:16', NULL, 1, NULL),
(99, 5, 0, NULL, 'Y2SARIXM7OtJAXj0', NULL, NULL, '-LnzizSI8qzx7uwdf7FA', NULL, NULL, NULL, '2019-09-05 04:43:24', '2019-09-05 04:45:02', NULL, 3, NULL),
(100, 5, 1, '12.00', 'HAcflaMBIFUXZlsL', 2, NULL, '-LnzjW_q15YptW5Wtp6_', 'T-bkksub15549575650531024', '2019-09-05 04:45:56', 'RM', '2019-09-05 04:45:44', '2019-09-05 04:45:56', NULL, 1, NULL),
(101, 17, 1, '58.00', 'CMS', 3, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-05 06:21:46', NULL, NULL, 1, NULL),
(102, 29, 0, NULL, 'Mh7mj9pvcgtuxDoE', NULL, NULL, '-Lo-79kop3-JSPT-bk2t', NULL, NULL, NULL, '2019-09-05 06:33:24', '2019-09-05 06:35:02', NULL, 3, NULL),
(103, 29, 1, '100.00', 'z6NgKQLzdnE7MWv4', 2, NULL, '-Lo-7S8p65vikBY9_JcN', 'T-bkksub19757102565451575', '2019-09-05 06:35:06', 'RM', '2019-09-05 06:34:39', '2019-09-05 06:35:06', NULL, 1, NULL),
(104, 29, 2, '12.00', 'rBRjbntvxxyJMbhQ', 2, NULL, '-Lo-7d5J0KvORCZ2fzBK', 'T-bkksub21025155100519948', '2019-09-05 06:36:08', 'RM', '2019-09-05 06:35:28', '2019-09-05 06:36:08', NULL, 1, NULL),
(105, 29, 0, NULL, 'WjTnSKVAmtuSZPnO', NULL, NULL, '-Lo-9wwVbY7iHIaG2iY8', NULL, NULL, NULL, '2019-09-05 06:45:34', '2019-09-05 06:47:02', NULL, 3, NULL),
(106, 29, 0, NULL, 'IbG3a0SZaOdLkQ2A', NULL, NULL, '-Lo-W3iOtgJteMjJFXdc', NULL, NULL, NULL, '2019-09-05 08:22:13', '2019-09-05 08:24:02', NULL, 3, NULL),
(107, 29, 0, NULL, 'ij2z6bfA8nBN8GMZ', NULL, NULL, '-LoEyTNThH8Utk4v39FN', NULL, NULL, NULL, '2019-09-08 08:24:58', '2019-09-08 08:26:01', NULL, 3, NULL),
(108, 29, 0, NULL, 'C9AhevTdnqBqCeOG', NULL, NULL, '-LodW0Y3_Lb4itQsG_ge', NULL, NULL, NULL, '2019-09-13 07:26:26', '2019-09-13 07:28:02', NULL, 3, NULL),
(109, 29, 0, NULL, 'NAIypLWshiu25t3w', NULL, NULL, '-LpCs3M4tSqIDXRQLYYr', NULL, NULL, NULL, '2019-09-20 08:53:26', '2019-09-20 08:55:02', NULL, 3, NULL),
(110, 17, 0, NULL, 'B1SOb8Opg91unm3u', NULL, NULL, '-LpbkHH_tocVap4zoYUB', NULL, NULL, NULL, '2019-09-25 09:29:34', '2019-09-25 09:30:36', NULL, 3, NULL),
(111, 17, 0, NULL, 'iqdiVKsgj0ckrTM8', NULL, NULL, '-LpbkYeBLGAh36PxIHdE', NULL, NULL, NULL, '2019-09-25 09:30:45', '2019-09-25 09:32:02', NULL, 3, NULL),
(112, 17, 0, NULL, 'udWzlHeHXHSrrTKq', NULL, NULL, '-LpfkSsL5xMcr7YgkuOt', NULL, NULL, NULL, '2019-09-26 04:08:50', '2019-09-26 04:10:02', NULL, 3, NULL),
(113, 17, 0, NULL, 'vXGqqprrcVqiI2b6', NULL, NULL, '-Lpfkod-rGQdsSDBEFeW', NULL, NULL, NULL, '2019-09-26 04:10:23', '2019-09-26 04:12:02', NULL, 3, NULL),
(114, 17, 0, NULL, 'G9W68kPKUaFnbKIX', NULL, NULL, '-LpftazMAEcIhWHetAZ1', NULL, NULL, NULL, '2019-09-26 04:48:47', '2019-09-26 04:50:02', NULL, 3, NULL),
(115, 17, 0, NULL, 'Psq67tGSQhQJ9b5L', NULL, NULL, '-LpqeiAxnrEyG4f4d6_L', NULL, NULL, NULL, '2019-09-28 06:59:33', '2019-09-28 07:01:03', NULL, 3, NULL),
(116, 17, 0, NULL, 'uyHYgjQJWnhI3qaV', NULL, NULL, '-Lq4TGl_n3pgH2rzJ1Tl', NULL, NULL, NULL, '2019-10-01 03:59:29', '2019-10-01 04:01:02', NULL, 3, NULL),
(117, 17, 0, NULL, 'rOUAYdH1vnI9nXBy', NULL, NULL, '-Lq9c73IHSLvFqmdbNy2', NULL, NULL, NULL, '2019-10-02 04:00:37', '2019-10-02 04:02:02', NULL, 3, NULL),
(118, 17, 0, NULL, '7mJaHJCBPQobmH39', NULL, NULL, '-LqKhPaRJFdOAAqBgJRu', NULL, NULL, NULL, '2019-10-04 07:39:33', '2019-10-04 07:41:02', NULL, 3, NULL),
(119, 17, 0, NULL, 'iWT9MGIYxWnyUn49', NULL, NULL, '-LqKkI-t2Qh_06WqG2Qb', NULL, NULL, NULL, '2019-10-04 07:52:09', '2019-10-04 07:54:01', NULL, 3, NULL),
(120, 17, 0, NULL, 'ybISNtINEd0uAp7b', NULL, NULL, '-LqqbWstOSSGYbXd07vG', NULL, NULL, NULL, '2019-10-10 17:01:18', '2019-10-10 17:03:01', NULL, 3, NULL),
(121, 17, 0, NULL, 'JVE72JWBhztjtHBQ', NULL, NULL, '-LqqbpCJhAuUUJNjojN4', NULL, NULL, NULL, '2019-10-10 17:02:37', '2019-10-10 17:04:02', NULL, 3, NULL),
(122, 5, 0, NULL, 'n3tJi0R5ON9o930u', NULL, NULL, '-Lqw0xoy1Q6zzlHdH92J', NULL, NULL, NULL, '2019-10-11 18:14:55', '2019-10-11 18:16:02', NULL, 3, NULL),
(123, 51, 0, NULL, 'HNJBuC5K4U7kq9xX', NULL, NULL, '-LqwAONk5BJlBYwgAuKr', NULL, NULL, NULL, '2019-10-11 18:56:07', '2019-10-11 18:58:02', NULL, 3, NULL),
(124, 5, 0, NULL, 'sZovOC9qJa84sYM1', NULL, NULL, '-LqyMy0MmfRRlhRxunQw', NULL, NULL, NULL, '2019-10-12 05:10:17', '2019-10-12 05:12:02', NULL, 3, NULL),
(125, 5, 0, NULL, 'ZJN5JJLGhteZfTMI', NULL, NULL, '-LqyNNos-NCR-rNTCyoO', NULL, NULL, NULL, '2019-10-12 05:12:07', '2019-10-12 05:14:03', NULL, 3, NULL),
(126, 5, 0, NULL, '4FzOQNRIs1tZhlBJ', NULL, NULL, '-LqzJZ_IKghrFw9jxGSQ', NULL, NULL, NULL, '2019-10-12 09:35:04', '2019-10-12 09:37:02', NULL, 3, NULL),
(127, 5, 0, NULL, 'K7qRHsVgckMrqsoh', NULL, NULL, '-LqzJhTuanfILkGcbn1H', NULL, NULL, NULL, '2019-10-12 09:35:40', '2019-10-12 09:37:03', NULL, 3, NULL),
(128, 5, 0, NULL, '3GlWnrgPeODu4SgB', NULL, NULL, '-LqzOSlpf5NRc1bgDSwb', NULL, NULL, NULL, '2019-10-12 09:56:26', '2019-10-12 09:58:02', NULL, 3, NULL),
(129, 5, 0, NULL, 'Q02VrVXfcP5yuacf', NULL, NULL, '-LqzPFYDIUyaBdEV2EoH', NULL, NULL, NULL, '2019-10-12 09:59:54', '2019-10-12 10:01:02', NULL, 3, NULL),
(130, 5, 0, NULL, 'KknpIoNLa4TfihUK', NULL, NULL, '-LqzPb3LtNN6tdRsAj9v', NULL, NULL, NULL, '2019-10-12 10:01:27', '2019-10-12 10:03:03', NULL, 3, NULL),
(131, 5, 0, NULL, 'eH95SaCjbHb46uHI', NULL, NULL, '-LqzQvfGm1fSTN-OC-EN', NULL, NULL, NULL, '2019-10-12 10:07:13', '2019-10-12 10:09:02', NULL, 3, NULL),
(132, 5, 0, NULL, '8G3tb36hXcsEm86x', NULL, NULL, '-LqzR1av6kMcp8Qn6_5a', NULL, NULL, NULL, '2019-10-12 10:07:42', '2019-10-12 10:09:03', NULL, 3, NULL),
(133, 5, 0, NULL, 'gZ59W8jAjc1HpCuO', NULL, NULL, '-LqzUvqiWAf3cGbvFM09', NULL, NULL, NULL, '2019-10-12 10:24:42', '2019-10-12 10:26:02', NULL, 3, NULL),
(134, 5, 0, NULL, 'hPZssodDyCMx743K', NULL, NULL, '-LqzXd9wSu4JWzmzT9U_', NULL, NULL, NULL, '2019-10-12 10:36:32', '2019-10-12 10:38:02', NULL, 3, NULL),
(135, 5, 0, NULL, 'hdDFN2ZOQlVr3OFv', NULL, NULL, '-LqzXo7_Xpyo_6q9zn_F', NULL, NULL, NULL, '2019-10-12 10:37:17', '2019-10-12 10:39:02', NULL, 3, NULL),
(136, 5, 0, NULL, 'fYTpUeQth1rvuBO2', NULL, NULL, '-LqzXslkMtpakRld1516', NULL, NULL, NULL, '2019-10-12 10:37:36', '2019-10-12 10:39:03', NULL, 3, NULL),
(137, 5, 0, NULL, 'fU7FAKDE3eXYfMUf', NULL, NULL, '-Lr-KMp-imfUuksDScvm', NULL, NULL, NULL, '2019-10-12 14:18:11', '2019-10-12 14:20:02', NULL, 3, NULL),
(138, 5, 0, NULL, 'Ar58e5FaYaa6TUZL', NULL, NULL, '-Lr-Kmw4qw1TCfvFAVNA', NULL, NULL, NULL, '2019-10-12 14:20:02', '2019-10-12 14:22:02', NULL, 3, NULL),
(139, 5, 0, NULL, 'YDeluT1rmNN8Zune', NULL, NULL, '-Lr-LrOQz_bfZgStxM3M', NULL, NULL, NULL, '2019-10-12 14:24:42', '2019-10-12 14:26:02', NULL, 3, NULL),
(140, 5, 0, NULL, 'fA7FhgpaCKauIb4E', NULL, NULL, '-Lr-OMtKho2evVNQcPug', NULL, NULL, NULL, '2019-10-12 14:35:40', '2019-10-12 14:37:02', NULL, 3, NULL),
(141, 5, 0, NULL, 'apQoKv30EgSRgiHK', NULL, NULL, '-Lr-OlXkFz543R27Z-7l', NULL, NULL, NULL, '2019-10-12 14:37:25', '2019-10-12 14:39:01', NULL, 3, NULL),
(142, 5, 0, NULL, '4guHed40zmmWpudw', NULL, NULL, '-Lr-PyjMg15vx6L3z8fK', NULL, NULL, NULL, '2019-10-12 14:42:41', '2019-10-12 14:44:02', NULL, 3, NULL),
(143, 5, 0, NULL, '3iYSHn1C9HuIcsrl', NULL, NULL, '-Lr-RKQY_vsA-WFrm-FR', NULL, NULL, NULL, '2019-10-12 14:48:36', '2019-10-12 14:50:02', NULL, 3, NULL),
(144, 5, 0, NULL, 'AFtMUYVQsKWxQWyE', NULL, NULL, '-Lr-Rngy1QyaXxuN6SuX', NULL, NULL, NULL, '2019-10-12 14:50:40', '2019-10-12 14:52:01', NULL, 3, NULL),
(145, 5, 0, NULL, 'xhXOlXGaCYEXD95G', NULL, NULL, '-Lr-SV5tyPBcasi5WCj-', NULL, NULL, NULL, '2019-10-12 14:53:42', '2019-10-12 14:55:02', NULL, 3, NULL),
(146, 5, 0, NULL, 'eISMpmg2FdoVmd1O', NULL, NULL, '-Lr-Sqhs9Gid1SNKp1Ao', NULL, NULL, NULL, '2019-10-12 14:55:14', '2019-10-12 14:57:02', NULL, 3, NULL),
(147, 5, 0, NULL, 'XS5LCtCeBMlEn4pC', NULL, NULL, '-Lr-dJPO5u5PTNl2bhZR', NULL, NULL, NULL, '2019-10-12 15:45:20', '2019-10-12 15:47:02', NULL, 3, NULL),
(148, 17, 1, '12.00', 'DPg0iYl6Wduf0iBs', 2, 1, '-Lr7M4_Um5VsbzP6kFEV', 'T-bkksub15349481029710251', '2019-10-14 03:43:11', 'RM', '2019-10-14 03:42:38', '2019-10-14 03:43:11', NULL, 1, NULL),
(149, 17, 2, '7.50', '4KFsnsV7RjWZSMYa', 2, 1, '-Lr7MlUsNYu6g9mPDnzz', 'T-bkksub25550101995454485', '2019-10-14 03:45:58', 'RM', '2019-10-14 03:45:38', '2019-10-14 03:45:58', NULL, 1, NULL),
(150, 5, 2, '5.00', 'aX9c2gEceYF3y9pN', 2, 1, '-Lr7kvR-dnvs1HNDnAul', 'T-bkksub29910051499797565', '2019-10-14 05:35:33', 'RM', '2019-10-14 05:35:32', '2019-10-14 05:35:33', NULL, 1, NULL),
(151, 5, 2, '5.00', 'Oo7tKTPtNAcUP4Ak', 2, 1, '-Lr7l0_mIWEPD3WkT9d_', 'T-bkksub21015657531029854', '2019-10-14 05:35:58', 'RM', '2019-10-14 05:35:57', '2019-10-14 05:35:58', NULL, 1, NULL),
(152, 5, 2, '5.00', '5QmwVk97LBeFBN0H', 2, 1, '-Lr7lUU4KYqmRsyRblf9', 'T-bkksub29910253505399565', '2019-10-14 05:38:01', 'RM', '2019-10-14 05:38:00', '2019-10-14 05:38:01', NULL, 1, NULL),
(153, 5, 2, '5.00', 'ddjOTwiXvs2z3ITo', 2, 1, '-Lr7mQfA9UT68z5hUeI6', 'T-bkksub29955505350101485', '2019-10-14 05:42:07', 'RM', '2019-10-14 05:42:06', '2019-10-14 05:42:07', NULL, 1, NULL),
(154, 5, 2, '5.00', 'sxgtV8xixxZeNXfz', 2, 1, '-Lr7nALRJqzUEVl9u6Yn', 'T-bkksub25397481011015754', '2019-10-14 05:45:22', 'RM', '2019-10-14 05:45:22', '2019-10-14 05:45:22', NULL, 1, NULL),
(155, 5, 2, '5.00', 'caTd2KFz9COX8D1A', 2, 1, '-Lr7nhhO-q3kGioHqQOl', 'T-bkksub29998565657100985', '2019-10-14 05:47:43', 'RM', '2019-10-14 05:47:42', '2019-10-14 05:47:43', NULL, 1, NULL),
(156, 5, 2, '5.00', 'R0CyOMrsGVS22nWz', 2, 1, '-Lr7o0o1c_31vWe8goZ5', 'T-bkksub21021019898574910', '2019-10-14 05:49:05', 'RM', '2019-10-14 05:49:05', '2019-10-14 05:49:05', NULL, 1, NULL),
(157, 5, 2, '5.00', 'vz2Qnijdmc4L5VNh', 2, 1, '-Lr7pBiL3Zz930U_DwP4', 'T-bkksub25249485010210156', '2019-10-14 05:54:12', 'RM', '2019-10-14 05:54:12', '2019-10-14 05:54:12', NULL, 1, NULL),
(158, 5, 2, '5.00', 'UXa25HeiAKkwZbuU', 2, 1, '-Lr7q8XeqhYXw6_Q8wrs', 'T-bkksub25699555550102974', '2019-10-14 05:58:21', 'RM', '2019-10-14 05:58:21', '2019-10-14 05:58:21', NULL, 1, NULL),
(159, 5, 2, '5.00', 'E6Nf9OUbYv8bD3H2', 2, 1, '-Lr7qZTQrx82OhCO1veA', 'T-bkksub29754495549985753', '2019-10-14 06:00:11', 'RM', '2019-10-14 06:00:11', '2019-10-14 06:00:11', NULL, 1, NULL),
(160, 5, 2, '5.00', 'kj9UVY8q0XFXPcGQ', 2, 1, '-Lr7ryRGcz0igBeWZ1G_', 'T-bkksub25256505110249549', '2019-10-14 06:06:20', 'RM', '2019-10-14 06:06:19', '2019-10-14 06:06:20', NULL, 1, NULL),
(161, 5, 2, '5.00', '8cG69M5omAVVcm93', 2, 1, '-Lr7sCJSdT_MYrhNZebm', 'T-bkksub25548489897994849', '2019-10-14 06:07:21', 'RM', '2019-10-14 06:07:20', '2019-10-14 06:07:21', NULL, 1, NULL),
(162, 5, 2, '5.00', '0XW34heLobAJeoBl', 2, 1, '-Lr7tQpJD7V6rie6B7s3', 'T-bkksub25754485599499750', '2019-10-14 06:12:43', 'RM', '2019-10-14 06:12:42', '2019-10-14 06:12:43', NULL, 1, NULL),
(163, 5, 2, '5.00', 'z3fUHKUgO0McbTGW', 2, 1, '-Lr7tYy8nIg3dn4uNopN', 'T-bkksub21025410056495054', '2019-10-14 06:13:16', 'RM', '2019-10-14 06:13:15', '2019-10-14 06:13:16', NULL, 1, NULL),
(164, 5, 2, '5.00', 'TOyg9su1fy8c9QfH', 2, 1, '-Lr7ucCW4f7qJYbGRkYR', 'T-bkksub25048100525056101', '2019-10-14 06:17:55', 'RM', '2019-10-14 06:17:55', '2019-10-14 06:17:55', NULL, 1, NULL),
(165, 5, 2, '5.00', 'Tzt0Imv0OPy1hsIK', 2, 1, '-Lr7vwrZgemXWdaP7rTO', 'T-bkksub25153564998531024', '2019-10-14 06:23:42', 'RM', '2019-10-14 06:23:42', '2019-10-14 06:23:42', NULL, 1, NULL),
(166, 5, 2, '5.00', '4Netx7jqTPoTVy7T', 2, 1, '-Lr7w0ckuzqRSfQnt3NZ', 'T-bkksub25257565257971011', '2019-10-14 06:24:02', 'RM', '2019-10-14 06:24:01', '2019-10-14 06:24:02', NULL, 1, NULL),
(167, 5, 2, '5.00', 'oY6aUJELo5p0tNfs', 2, 1, '-Lr7w31KmJyYXXLOgGMP', 'T-bkksub29797101481015010', '2019-10-14 06:24:11', 'RM', '2019-10-14 06:24:11', '2019-10-14 06:24:11', NULL, 1, NULL),
(168, 5, 2, '5.00', 'WA4oBkVjvw5Mt4Ur', 2, 1, '-Lr7w9AkxUXOtBSHvzWu', 'T-bkksub24849515598565755', '2019-10-14 06:24:37', 'RM', '2019-10-14 06:24:36', '2019-10-14 06:24:37', NULL, 1, NULL),
(169, 5, 2, '5.00', '9XEWFRp2TMjc4upt', 2, 1, '-Lr7whCy1pkm5lVVNl4K', 'T-bkksub25610298495654524', '2019-10-14 06:27:00', 'RM', '2019-10-14 06:27:00', '2019-10-14 06:27:00', NULL, 1, NULL),
(170, 5, 2, '5.00', 'TTY7sV7m2EYUX0y1', 2, 1, '-Lr7wpDE54glcc4DXKX3', 'T-bkksub21005156565697575', '2019-10-14 06:27:33', 'RM', '2019-10-14 06:27:32', '2019-10-14 06:27:33', NULL, 1, NULL),
(171, 5, 2, '5.00', 'v7Ji7a1wYCZwIi8T', 2, 1, '-Lr7yUB-P5e7j_tf_RLn', 'T-bkksub25654539954102985', '2019-10-14 06:34:47', 'RM', '2019-10-14 06:34:46', '2019-10-14 06:34:47', NULL, 1, NULL),
(172, 5, 2, '5.00', 'm3NzIXpjMFFDd2W1', 2, 1, '-Lr7zY-UajTyBp_1PYSc', 'T-bkksub21021024856549752', '2019-10-14 06:39:25', 'RM', '2019-10-14 06:39:24', '2019-10-14 06:39:25', NULL, 1, NULL),
(173, 5, 0, NULL, 'iCqKe4ZQHpCIjKkB', NULL, NULL, '-LrHzkBVezM1zTomGdso', NULL, NULL, NULL, '2019-10-16 05:16:30', '2019-10-16 05:17:32', NULL, 3, NULL),
(174, 5, 0, NULL, 'FxgzeGojHyRUMniW', NULL, NULL, '-LrI29erIrq3oevBZbHR', NULL, NULL, NULL, '2019-10-16 05:31:25', '2019-10-16 05:33:01', NULL, 3, NULL),
(175, 5, 0, NULL, 'iNzdSHRUGz6ORfFI', NULL, NULL, '-LrI2DNApLD_SHECANNM', NULL, NULL, NULL, '2019-10-16 05:31:41', '2019-10-16 05:33:02', NULL, 3, NULL),
(176, 5, 0, NULL, '3CDTq5qHfiyJRSMr', NULL, NULL, '-LrI2EFt5_mfZP93sLnu', NULL, NULL, NULL, '2019-10-16 05:31:44', '2019-10-16 05:33:03', NULL, 3, NULL),
(177, 5, 0, NULL, 'hkr7bC0QjVKZKmUf', NULL, NULL, '-LrJ7PoGwBsKTh51KuKN', NULL, NULL, NULL, '2019-10-16 10:33:59', '2019-10-16 10:35:00', NULL, 3, NULL),
(178, 52, 0, NULL, '1CAWOOMZUqjqnEW5', NULL, NULL, '-LrJDdfrtwqESiJTcok0', NULL, NULL, NULL, '2019-10-16 11:01:13', '2019-10-16 11:02:14', NULL, 3, NULL),
(179, 5, 0, NULL, 'pSj9YjYnx2lZvbmJ', NULL, NULL, '-LrND8twQ3CstawsoD76', NULL, NULL, NULL, '2019-10-17 05:37:32', '2019-10-17 05:38:33', NULL, 3, NULL),
(180, 5, 0, NULL, 'YbFCsJUfx8wR9VWB', NULL, NULL, '-LrNDQaSeM9DHLBOslzV', NULL, NULL, NULL, '2019-10-17 05:38:44', '2019-10-17 05:39:45', NULL, 3, NULL),
(181, 5, 0, NULL, 'mK9HzWr3vMfalY8y', NULL, NULL, '-LrNE37ql4efA7abzho_', NULL, NULL, NULL, '2019-10-17 05:41:30', '2019-10-17 05:43:02', NULL, 3, NULL),
(182, 17, 0, NULL, 'sjyfzWeIwDE8Ukgh', NULL, NULL, '-LrXdnTR40qVg3nhJoGk', NULL, NULL, NULL, '2019-10-19 06:14:32', '2019-10-19 06:16:02', NULL, 3, NULL),
(183, 17, 0, NULL, 'o09PVgx5T657J9Z7', NULL, NULL, '-LrnK9lXP7iGpZMtA1ap', NULL, NULL, NULL, '2019-10-22 11:57:55', '2019-10-22 11:59:02', NULL, 3, NULL),
(184, 17, 0, NULL, 'Jj7j9kwjcvxjv5AL', NULL, NULL, '-LrnLbrS4FtT2nGE_BGB', NULL, NULL, NULL, '2019-10-22 12:04:17', '2019-10-22 12:06:02', NULL, 3, NULL),
(185, 29, 0, NULL, 'Bcvn07DtA5MBW7lk', NULL, NULL, '-Lrpan326WXV8ivTSvhT', NULL, NULL, NULL, '2019-10-22 22:34:11', '2019-10-22 22:36:02', NULL, 3, NULL),
(186, 17, 0, NULL, 'wNJKvYewP5720jGu', NULL, NULL, '-LrpbIQYtFvtmQiwsiYv', NULL, NULL, NULL, '2019-10-22 22:36:24', '2019-10-22 22:38:02', NULL, 3, NULL),
(187, 17, 0, NULL, 'uGzb8CanyzYDerT4', NULL, NULL, '-Lrq9Dv_m7LMoQbFwE9w', NULL, NULL, NULL, '2019-10-23 01:09:00', '2019-10-23 01:10:02', NULL, 3, NULL),
(188, 17, 0, NULL, 'B92r0drkFbQZxeBx', NULL, NULL, '-LrqF-hHrZ2g0ckloCht', NULL, NULL, NULL, '2019-10-23 01:34:15', '2019-10-23 01:36:01', NULL, 3, NULL),
(189, 17, 0, NULL, '111IxFxlw7rPeQFe', NULL, NULL, '-LrrNSA99-Py764nS5h_', NULL, NULL, NULL, '2019-10-23 06:50:46', '2019-10-23 06:52:02', NULL, 3, NULL),
(190, 17, 0, NULL, '0P8X6JkbGlW8Udxa', NULL, NULL, '-LrwCLpnH5_-gN0F6V0v', NULL, NULL, NULL, '2019-10-24 05:20:22', '2019-10-24 05:22:02', NULL, 3, NULL),
(191, 17, 0, NULL, 'oD9LROyB53vL0ObR', NULL, NULL, '-LrwD0txkJ5_ma9W5phd', NULL, NULL, NULL, '2019-10-24 05:23:19', '2019-10-24 05:25:02', NULL, 3, NULL),
(192, 17, 0, NULL, 'HnsYDay2yTPOjAVU', NULL, NULL, '-LrwDT6alWB-1ukCfsrv', NULL, NULL, NULL, '2019-10-24 05:25:14', '2019-10-24 05:27:03', NULL, 3, NULL),
(193, 17, 0, NULL, 'P3vkWkoAxMei0yqx', NULL, NULL, '-LrwGXguhnrbVJ0dXppI', NULL, NULL, NULL, '2019-10-24 05:38:40', '2019-10-24 05:40:02', NULL, 3, NULL),
(194, 17, 0, NULL, 'mq6s2lQ8TaVQSX7n', NULL, NULL, '-LrwGn0mSyrUQJn_ri3N', NULL, NULL, NULL, '2019-10-24 05:39:46', '2019-10-24 05:41:02', NULL, 3, NULL),
(195, 17, 0, NULL, 'N6NhgFan9LE2iMaj', NULL, NULL, '-LsAvjrBzrXUU4gPZoNC', NULL, NULL, NULL, '2019-10-27 06:37:22', '2019-10-27 06:39:02', NULL, 3, NULL),
(196, 73, 0, NULL, 'JOGXroGwdJkqxUwF', NULL, NULL, '-LsNFf-iJl0EQUxQ3nCA', NULL, NULL, NULL, '2019-10-29 16:04:14', '2019-10-29 16:06:02', NULL, 3, NULL),
(197, 73, 0, NULL, 'JGjj0mROf3RysS2M', NULL, NULL, '-LsNFj-lyA9WHTFmtxub', NULL, NULL, NULL, '2019-10-29 16:04:30', '2019-10-29 16:06:03', NULL, 3, NULL),
(198, 73, 0, NULL, 'bjjiqWtoatYCWVgJ', NULL, NULL, '-LsNFr3N6vhDBfnUiU8M', NULL, NULL, NULL, '2019-10-29 16:05:03', '2019-10-29 16:06:04', NULL, 3, NULL),
(199, 74, 1, '5.00', 'WKaVs2XP1g4R3XCo', 2, 1, '-LsNGraxZ86P_vkECdx8', 'T-bkksub15698102509749565', '2019-10-29 16:10:00', 'RM', '2019-10-29 16:09:27', '2019-10-29 16:10:00', NULL, 1, NULL),
(200, 74, 2, '2.00', '080xTeSIFpFddbTA', 2, 1, '-LsNH27nT_zsXlCCrJqA', 'T-bkksub25357561005110155', '2019-10-29 16:10:18', 'RM', '2019-10-29 16:10:15', '2019-10-29 16:10:18', NULL, 1, NULL),
(201, 73, 1, '5.00', '2Jw9gB386fjCRvJb', 2, 1, '-LsNJMy4uOxxaoOFCXuE', 'T-bkksub15054985457579952', '2019-10-29 16:20:52', 'RM', '2019-10-29 16:20:24', '2019-10-29 16:20:52', NULL, 1, NULL),
(202, 73, 1, '10.00', 'CPEG17oJGYHiDGZ1', 2, 1, '-LsNJc0FMclHxabwFH0U', 'T-bkksub15156485148989955', '2019-10-29 16:21:37', 'RM', '2019-10-29 16:21:30', '2019-10-29 16:21:37', NULL, 1, NULL),
(203, 73, 2, '10.00', 'kSyRsufxn8Y9sm7R', 2, 1, '-LsNJjNEXMgBXe8jP5Ax', 'T-bkksub25650100524848102', '2019-10-29 16:22:07', 'RM', '2019-10-29 16:22:00', '2019-10-29 16:22:07', NULL, 1, NULL),
(204, 73, 1, '5.00', 'UF1K1IOIf6a5cJgs', 2, 1, '-LsNLTQawkldpPQophwx', 'T-bkksub11019957975548569', '2019-10-29 16:30:27', 'RM', '2019-10-29 16:29:35', '2019-10-29 16:30:27', NULL, 1, NULL),
(205, 73, 0, NULL, '1Qrs3dUVXgR5RsKi', NULL, NULL, '-LsNMAh_7JiKLZLRmKOu', NULL, NULL, NULL, '2019-10-29 16:32:40', '2019-10-29 16:34:02', NULL, 3, NULL),
(206, 73, 0, NULL, 'QczaQSGwsWQO6qlD', NULL, NULL, '-LsNMGKNaRzZqrKemPC3', NULL, NULL, NULL, '2019-10-29 16:33:03', '2019-10-29 16:35:02', NULL, 3, NULL),
(207, 73, 1, '2.00', 'lFyy7lRXxWvinPTn', 2, 1, '-LsNNsdcApqHzCLGCQ55', 'T-bkksub15151544957535410', '2019-10-29 16:40:19', 'RM', '2019-10-29 16:40:07', '2019-10-29 16:40:19', NULL, 1, NULL),
(208, 73, 0, NULL, 'RZZuon5Jyto6EZkM', NULL, NULL, '-LsNOjIGz6-z9oiK1qad', NULL, NULL, NULL, '2019-10-29 16:43:50', '2019-10-29 16:45:02', NULL, 3, NULL),
(209, 73, 0, NULL, 'VLHnWksCagfY99Gf', NULL, NULL, '-LsNOlU58x7ZeQ7QkyFp', NULL, NULL, NULL, '2019-10-29 16:43:59', '2019-10-29 16:45:03', NULL, 3, NULL),
(210, 73, 0, NULL, 'nt0sxY9TEnlIxuVf', NULL, NULL, '-LsNOn6jI2VZi0SYm43_', NULL, NULL, NULL, '2019-10-29 16:44:06', '2019-10-29 16:46:02', NULL, 3, NULL),
(211, 17, 0, NULL, 'vT34e3BMESFyaELA', NULL, NULL, '-LsOhb98tsal1Qo90w9L', NULL, NULL, NULL, '2019-10-29 22:50:17', '2019-10-29 22:52:02', NULL, 3, NULL),
(212, 76, 0, NULL, 'BGBnCRABtyDAHBlr', NULL, NULL, '-LsOwGGfdDDtlEher9A1', NULL, NULL, NULL, '2019-10-29 23:54:20', '2019-10-29 23:55:21', NULL, 3, NULL),
(213, 76, 0, NULL, 'G35eJcinUABz6kUI', NULL, NULL, '-LsOxR3IjA0bU1RE2zoR', NULL, NULL, NULL, '2019-10-29 23:59:26', '2019-10-30 00:01:02', NULL, 3, NULL),
(214, 17, 1, '50.00', '0DFay6xrRsRnJcQs', 2, 1, '-LsOy56Flf3uXXDRDHPq', 'T-bkksub15752515657495354', '2019-10-30 00:02:26', 'RM', '2019-10-30 00:02:18', '2019-10-30 00:02:26', NULL, 1, NULL),
(215, 17, 2, '100.00', 'nM8J14jwDT5L89bS', 2, 1, '-LsOyBWGHTs0Rm4KA1Ky', 'T-bkksub24849984910210056', '2019-10-30 00:02:53', 'RM', '2019-10-30 00:02:45', '2019-10-30 00:02:53', NULL, 1, NULL),
(216, 76, 0, NULL, 'UIT0nBdr49BCDOxp', NULL, NULL, '-LsQuJ--JQR-tVWSaTjO', NULL, NULL, NULL, '2019-10-30 09:05:01', '2019-10-30 09:06:02', NULL, 3, NULL),
(217, 76, 0, NULL, 'CFUWcmgAfFdGCPkO', NULL, NULL, '-LsQumGviqFqWi8LcTrv', NULL, NULL, NULL, '2019-10-30 09:07:05', '2019-10-30 09:09:02', NULL, 3, NULL),
(218, 76, 1, '100.00', 'dKrX3FY9jGmaGa9Z', 2, 1, '-LsQv530Dpq5Aq-1diIi', 'T-bkksub15610257499797102', '2019-10-30 09:09:00', 'RM', '2019-10-30 09:08:26', '2019-10-30 09:09:00', NULL, 1, NULL),
(219, 76, 1, '50.00', 'dzEpijlCZfQGQXAy', 2, 1, '-LsR4M65yKiomkzMPtjL', 'T-bkksub15299995010053100', '2019-10-30 09:53:24', 'RM', '2019-10-30 09:53:17', '2019-10-30 09:53:24', NULL, 1, NULL),
(220, 76, 2, '100.00', 'Pabfyr2QxPkUc6G3', 2, 1, '-LsR4S8uJtRwVDTR-uaZ', 'T-bkksub29754525256549850', '2019-10-30 09:53:43', 'RM', '2019-10-30 09:53:42', '2019-10-30 09:53:43', NULL, 1, NULL),
(221, 5, 0, NULL, 'uVdfjNwfKJqlDVBi', NULL, NULL, '-LsVFd-eaI0RM-xJ9Ziy', NULL, NULL, NULL, '2019-10-31 05:21:03', '2019-10-31 05:23:03', NULL, 3, NULL),
(222, 5, 0, NULL, 'dEM7baqD6lwWJ71v', NULL, NULL, '-LsVFefKb_z4659Plf7k', NULL, NULL, NULL, '2019-10-31 05:21:10', '2019-10-31 05:23:04', NULL, 3, NULL),
(223, 17, 0, NULL, 'Ee4ow7c4Fb8qrfLx', NULL, NULL, '-LsVdiNv6HEG0F6NeH89', NULL, NULL, NULL, '2019-10-31 07:10:39', '2019-10-31 07:12:02', NULL, 3, NULL),
(224, 17, 0, NULL, 'K4RSCTHPq8rvStqV', NULL, NULL, '-LsVe0-APfbNHhtL3Bw3', NULL, NULL, NULL, '2019-10-31 07:11:55', '2019-10-31 07:13:03', NULL, 3, NULL),
(225, 73, 0, NULL, 'IzrLhCnCYqXVAhOU', NULL, NULL, '-Lskda5KeSl5qDuVvMWn', NULL, NULL, NULL, '2019-11-03 09:44:00', '2019-11-03 09:45:02', NULL, 3, NULL),
(226, 73, 0, NULL, 'DMPbO3ZPnknzGWmt', NULL, NULL, '-LskdfAhiLvrdlXbmjjl', NULL, NULL, NULL, '2019-11-03 09:44:21', '2019-11-03 09:46:02', NULL, 3, NULL),
(227, 73, 0, NULL, 'dWKKnfU5OK5Zhg16', NULL, NULL, '-LskdwTFF0q48bD1C1hx', NULL, NULL, NULL, '2019-11-03 09:45:32', '2019-11-03 09:47:02', NULL, 3, NULL),
(228, 17, 0, NULL, 'F2JG3LyhjYI3LdN9', NULL, NULL, '-LsoK48UVyKqlAOWPdOr', NULL, NULL, NULL, '2019-11-04 02:52:51', '2019-11-04 02:54:02', NULL, 3, NULL),
(229, 17, 0, NULL, '5jEGaQrI20DFNDIo', NULL, NULL, '-LsoKgX9R1o7qs5ZUaol', NULL, NULL, NULL, '2019-11-04 02:55:33', '2019-11-04 02:57:02', NULL, 3, NULL),
(230, 76, 0, NULL, 'hjzYhs5zE9XjP927', NULL, NULL, '-LsoWL_OLEpew783MMGf', NULL, NULL, NULL, '2019-11-04 03:46:28', '2019-11-04 03:48:02', NULL, 3, NULL),
(231, 76, 0, NULL, 'IgswgoummjC3CbvW', NULL, NULL, '-LsoWgggSfuwbQZSoaG2', NULL, NULL, NULL, '2019-11-04 03:47:59', '2019-11-04 03:49:02', NULL, 3, NULL),
(232, 76, 0, NULL, '3o5Ct9EQVfytt7Ds', NULL, NULL, '-LstlMlk14c4M0Vc46i-', NULL, NULL, NULL, '2019-11-05 04:14:34', '2019-11-05 04:16:02', NULL, 3, NULL),
(233, 17, 0, NULL, 'kDABahDqe2evXmWD', NULL, NULL, '-LsuBTa1pkXTsLpX0U_d', NULL, NULL, NULL, '2019-11-05 06:12:59', '2019-11-05 06:14:02', NULL, 3, NULL),
(234, 76, 0, NULL, 'zxEzeWmOVkFqJ7Ns', NULL, NULL, '-LszsRWiEB32qMVWL9Zn', NULL, NULL, NULL, '2019-11-06 08:43:11', '2019-11-06 08:45:01', NULL, 3, NULL),
(235, 76, 0, NULL, 'P8meLI0T1IoCxOMJ', NULL, NULL, '-Lt9I2YuxBf5gAduNC-U', NULL, NULL, NULL, '2019-11-08 09:15:39', '2019-11-08 09:17:02', NULL, 3, NULL),
(236, 17, 1, '12.00', '6dRouRiIJ6Vezvoe', 2, 1, '-LtPwZb4CnsxvnUeIf8I', 'T-bkksub11001011024810210', '2019-11-11 14:51:16', 'RM', '2019-11-11 14:50:58', '2019-11-11 14:51:16', NULL, 1, NULL),
(237, 17, 0, NULL, 'Hd3SKgjMNVvdxzV0', NULL, NULL, '-LtPwkZZ_KLAeDrcQBs8', NULL, NULL, NULL, '2019-11-11 14:51:47', '2019-11-11 14:53:02', NULL, 3, NULL),
(238, 17, 0, NULL, 'lwffflBPFsEiagVC', NULL, NULL, '-LtPyAtLepPfliwr-J7T', NULL, NULL, NULL, '2019-11-11 14:58:01', '2019-11-11 14:59:02', NULL, 3, NULL),
(239, 17, 0, NULL, 'A77UlrrUMpYmsbE2', NULL, NULL, '-LtYbuNQbioxC0NNq2HE', NULL, NULL, NULL, '2019-11-13 07:17:17', '2019-11-13 07:19:03', NULL, 3, NULL),
(240, 76, 0, NULL, 'pCX4PdAnpSU0GSpe', NULL, NULL, '-LtZ1-SZ6Rtn4Z2fONJZ', NULL, NULL, NULL, '2019-11-13 09:11:18', '2019-11-13 09:13:02', NULL, 3, NULL),
(241, 73, 0, NULL, 'Qo1Y0lIID0aMNxLv', NULL, NULL, '-LtZyJn7dnnE1Zbp2Yx0', NULL, NULL, NULL, '2019-11-13 13:34:50', '2019-11-13 13:36:07', NULL, 3, NULL),
(242, 73, 1, '200.00', 'KEH2RDn77D73bWru', 2, 1, '-Lt_0O9u04ltYbm-qMRV', 'T-bkksub11029710052525251', '2019-11-13 13:48:28', 'RM', '2019-11-13 13:48:14', '2019-11-13 13:48:28', NULL, 1, NULL),
(243, 77, 0, NULL, 'MWjWbymEpqpWIgrs', NULL, NULL, '-LtcboR5DAOhFID2xOZS', NULL, NULL, NULL, '2019-11-14 06:34:59', '2019-11-14 06:36:02', NULL, 3, NULL),
(244, 77, 0, NULL, 'UPejr6y0d5cbIAmY', NULL, NULL, '-Ltcd7WS9JsF35-o0pqy', NULL, NULL, NULL, '2019-11-14 06:40:43', '2019-11-14 06:42:01', NULL, 3, NULL),
(245, 77, 0, NULL, 'vwZO2rFIfhgU3Z8F', NULL, NULL, '-LtdIYgqsFsSRG2Nvo7D', NULL, NULL, NULL, '2019-11-14 09:46:05', '2019-11-14 09:48:02', NULL, 3, NULL),
(246, 73, 3, NULL, 'YENU33D0uRcFP9cN', NULL, NULL, '-LttcqNsz_jde55gyhsw', NULL, NULL, NULL, '2019-11-17 13:53:02', '2019-11-17 13:55:02', NULL, 3, NULL),
(247, 73, 3, '0.00', 'mtpTSWJmkjUJZVt2', 2, 1, '-LttdpOAS05vt1NBj2Pu', 'U-bkksub25310057531005557', '2019-11-17 13:57:32', 'RM', '2019-11-17 13:57:20', '2019-11-17 13:57:32', NULL, 1, NULL),
(248, 5, 3, '0.00', 'GKABX21n5Swx2G6y', 2, 1, '-LtwKuk9xgJaLIZg9qo8', 'U-bkksub24910010210249505', '2019-11-18 02:29:27', 'RM', '2019-11-18 02:29:10', '2019-11-18 02:29:27', NULL, 1, NULL),
(249, 77, 0, NULL, 'F9xvinoK8IZVRRDB', NULL, NULL, '-Lu6cwpCH-zX6sowC3Ym', NULL, NULL, NULL, '2019-11-20 07:08:09', '2019-11-20 07:10:02', NULL, 3, NULL),
(250, 77, 0, NULL, 'T5r9mJzaoqBSxQPR', NULL, NULL, '-LuB78afSxPW1q_C_NNd', NULL, NULL, NULL, '2019-11-21 04:02:57', '2019-11-21 04:04:03', NULL, 3, NULL),
(251, 77, 0, NULL, 'eyUjRw7Mc131uhGr', NULL, NULL, '-LuBoelActVxiUkTdcaG', NULL, NULL, NULL, '2019-11-21 07:17:27', '2019-11-21 07:19:02', NULL, 3, NULL),
(252, 77, 0, NULL, '4JdtjmioZJRAnTMe', NULL, NULL, '-LuGu6Pgaky1MaTDdXB3', NULL, NULL, NULL, '2019-11-22 06:59:21', '2019-11-22 07:00:23', NULL, 3, NULL),
(253, 73, 0, NULL, 'RJ2rllepS5oFwLq2', NULL, NULL, '-LuTWwSyHy7GWavrUtP3', NULL, NULL, NULL, '2019-11-24 17:48:48', '2019-11-24 17:49:56', NULL, 3, NULL),
(254, 73, 1, '50.00', 'q5ZdKTXmDsHQhSwo', 2, 1, '-LuTXDrMeqPYXCCyoHmT', 'T-bkksub19752495656100995', '2019-11-24 17:50:15', 'RM', '2019-11-24 17:50:04', '2019-11-24 17:50:15', NULL, 1, NULL),
(255, 73, 2, '80.00', 'FHbJ2OVhfb0iuoth', 2, 1, '-LuTZ8MOQQOgGVePTZYl', 'T-bkksub29810010210110299', '2019-11-24 17:58:34', 'RM', '2019-11-24 17:58:26', '2019-11-24 17:58:34', NULL, 1, NULL),
(256, 73, 0, NULL, 'YAYVXswonqu0Kp2l', NULL, NULL, '-LuT_Gdk9rAvL8ILagL1', NULL, NULL, NULL, '2019-11-24 18:03:22', '2019-11-24 18:05:02', NULL, 3, NULL),
(257, 73, 3, '0.00', 'At4C9C6loVeQsGHQ', 2, 1, '-LuT_cc1Fw_Nu8cCJgWG', 'U-bkksub25310197989848981', '2019-11-24 18:05:06', 'RM', '2019-11-24 18:04:56', '2019-11-24 18:05:06', NULL, 1, NULL),
(258, 77, 0, NULL, 'PQfNCBOeGyIHBkWD', NULL, NULL, '-LuVhQoXaVSzhgl7Wour', NULL, NULL, NULL, '2019-11-25 03:58:15', '2019-11-25 04:00:02', NULL, 3, NULL),
(259, 77, 0, NULL, 'cU7AqpiXHhK6AGTI', NULL, NULL, '-Luf7N1k599MLuopg6u-', NULL, NULL, NULL, '2019-11-27 04:32:09', '2019-11-27 04:34:02', NULL, 3, NULL),
(260, 77, 0, NULL, 'iP7K4TizoSlIomZK', NULL, NULL, '-Luf8OIKQzc7VbYGhcOe', NULL, NULL, NULL, '2019-11-27 04:36:37', '2019-11-27 04:38:02', NULL, 3, NULL),
(261, 5, 0, NULL, 'QaNpOKW5Uv39sq7R', NULL, NULL, '-LuhJcGViXVxeKBYid9n', NULL, NULL, NULL, '2019-11-27 14:44:56', '2019-11-27 14:46:02', NULL, 3, NULL),
(262, 5, 0, NULL, 'fYnoju87YXzrwbOb', NULL, NULL, '-LuhJvFgQ8tpiz7zszIW', NULL, NULL, NULL, '2019-11-27 14:46:14', '2019-11-27 14:48:02', NULL, 3, NULL),
(263, 5, 0, NULL, 'UhTWYEcIUIdzcC9s', NULL, NULL, '-LuhLDnPBrfBXJk0K5MI', NULL, NULL, NULL, '2019-11-27 14:51:56', '2019-11-27 14:52:58', NULL, 3, NULL),
(264, 5, 0, NULL, '4IhJOIHg9z3jHMO7', NULL, NULL, '-LuhMe_6mCNfNte2kK9P', NULL, NULL, NULL, '2019-11-27 14:58:12', '2019-11-27 14:59:13', NULL, 3, NULL),
(265, 5, 0, NULL, 'QblKaaPEF9pQGnYn', NULL, NULL, '-LuhMyqvGXdXqDUyolms', NULL, NULL, NULL, '2019-11-27 14:59:35', '2019-11-27 15:01:02', NULL, 3, NULL),
(266, 5, 0, NULL, 'VDo6MV6jDuvNDfSt', NULL, NULL, '-Luhm1CySg0ooHfHb5cG', NULL, NULL, NULL, '2019-11-27 16:53:25', '2019-11-27 16:55:02', NULL, 3, NULL),
(267, 5, 0, NULL, 'Kj93q7NefUnHSyOr', NULL, NULL, '-LuhmjLxH7l8pr72Xkng', NULL, NULL, NULL, '2019-11-27 16:56:29', '2019-11-27 16:58:01', NULL, 3, NULL),
(268, 5, 0, NULL, '4rd1zCeSnLq4XmAH', NULL, NULL, '-Luhn1mjx6j__hCMNUbo', NULL, NULL, NULL, '2019-11-27 16:57:49', '2019-11-27 16:59:01', NULL, 3, NULL),
(269, 5, 0, NULL, 'Ug61xC7wJGh1UuZS', NULL, NULL, '-LuhnPbF0h1gngFaIPqS', NULL, NULL, NULL, '2019-11-27 16:59:27', '2019-11-27 17:00:30', NULL, 3, NULL),
(270, 5, 0, NULL, 'E5T2mA00tWCQuVh4', NULL, NULL, '-LuhnlJbfqOvJnX8No16', NULL, NULL, NULL, '2019-11-27 17:01:00', '2019-11-27 17:02:02', NULL, 3, NULL),
(271, 5, 0, NULL, '8Ff5Z939NGXS2VoV', NULL, NULL, '-LuhoQsDx4Jj1w-Vd-WZ', NULL, NULL, NULL, '2019-11-27 17:03:54', '2019-11-27 17:05:02', NULL, 3, NULL),
(272, 5, 0, NULL, 'UreTADrO4VLjpUrc', NULL, NULL, '-Luhq-LRu3TlfyjzSA39', NULL, NULL, NULL, '2019-11-27 17:10:45', '2019-11-27 17:12:02', NULL, 3, NULL),
(273, 5, 0, NULL, 'PyJJtmBbkqduCE0O', NULL, NULL, '-LuhqByCMVT41JDUzrjJ', NULL, NULL, NULL, '2019-11-27 17:11:37', '2019-11-27 17:13:01', NULL, 3, NULL),
(274, 5, 0, NULL, 'eLiQlvKmhmnDUs3k', NULL, NULL, '-LuhqQDsBroYv5plC_iY', NULL, NULL, NULL, '2019-11-27 17:12:36', '2019-11-27 17:14:02', NULL, 3, NULL),
(275, 5, 0, NULL, 'YJJLz7oM5EvFlL35', NULL, NULL, '-LuhqUcnxSf0jXO3paQh', NULL, NULL, NULL, '2019-11-27 17:12:54', '2019-11-27 17:14:02', NULL, 3, NULL),
(276, 5, 0, NULL, 'mHs3hu3GFZ0UhVxp', NULL, NULL, '-Luhqk141VCX1tdlvyo6', NULL, NULL, NULL, '2019-11-27 17:14:01', '2019-11-27 17:15:02', NULL, 3, NULL),
(277, 5, 0, NULL, 'MaCgo5TjsBXNRhvj', NULL, NULL, '-LuhtlI7lD_tOPq94Xvg', NULL, NULL, NULL, '2019-11-27 17:27:12', '2019-11-27 17:29:02', NULL, 3, NULL),
(278, 5, 0, NULL, '8MG5ZG54nNoqp5F5', NULL, NULL, '-Luhv4UzDGBp1RRprEJx', NULL, NULL, NULL, '2019-11-27 17:32:57', '2019-11-27 17:34:02', NULL, 3, NULL),
(279, 5, 0, NULL, 'L6cwGgKd3i5j7AGw', NULL, NULL, '-LujqERix3wSW5AkeJ8n', NULL, NULL, NULL, '2019-11-28 02:31:02', '2019-11-28 02:33:01', NULL, 3, NULL),
(280, 5, 0, NULL, 'xctJCPmBn5Js6ynP', NULL, NULL, '-LujqdBVvKkCY1ybz4J1', NULL, NULL, NULL, '2019-11-28 02:32:47', '2019-11-28 02:33:49', NULL, 3, NULL),
(281, 5, 0, NULL, 'EVLx4Oz74AorBJBR', NULL, NULL, '-LujqyQzJodPYuOdTya8', NULL, NULL, NULL, '2019-11-28 02:34:14', '2019-11-28 02:36:01', NULL, 3, NULL),
(282, 5, 0, NULL, 'ztYiB5PahQrZOliF', NULL, NULL, '-LulyYkYCANPg65zNCqg', NULL, NULL, NULL, '2019-11-28 12:26:37', '2019-11-28 12:27:44', NULL, 3, NULL),
(283, 77, 0, NULL, 'xT2dDyJg63Jcyufd', NULL, NULL, '-LumxGhJNibIXpfy41fV', NULL, NULL, NULL, '2019-11-28 17:00:38', '2019-11-28 17:02:02', NULL, 3, NULL),
(284, 5, 0, NULL, 'l4benXiC7MgHmVkL', NULL, NULL, '-LuulvGIhhZXsPj3l4Cx', NULL, NULL, NULL, '2019-11-30 05:28:00', '2019-11-30 05:29:02', NULL, 3, NULL),
(285, 5, 0, NULL, 'Z04w5H7zAgGwna0z', NULL, NULL, '-LuuxCoUivyOfbN9NJ5I', NULL, NULL, NULL, '2019-11-30 06:17:19', '2019-11-30 06:18:23', NULL, 3, NULL),
(286, 5, 0, NULL, 'CAQrcTwSWzlZmNPW', NULL, NULL, '-LuuzZXgTgjKebF6k-ed', NULL, NULL, NULL, '2019-11-30 06:27:37', '2019-11-30 06:29:02', NULL, 3, NULL),
(287, 5, 0, NULL, 'tFpM6WhvSHp9LPpC', NULL, NULL, '-Lv9ZIe96vhhEZOjdCYi', NULL, NULL, NULL, '2019-12-03 07:02:25', '2019-12-03 07:03:28', NULL, 3, NULL),
(288, 77, 0, NULL, 'tzv1KfeXqaOvOnB8', NULL, NULL, '-LvDfR1B_7wF3415K6KE', NULL, NULL, NULL, '2019-12-04 02:12:03', '2019-12-04 02:14:02', NULL, 3, NULL),
(289, 77, 0, NULL, 'tg6L4rfmR6eBx7c8', NULL, NULL, '-LvDflMucm0LcCmpgBPE', NULL, NULL, NULL, '2019-12-04 02:13:31', '2019-12-04 02:15:01', NULL, 3, NULL),
(290, 77, 0, NULL, 'QVyGdQSa8Plida4g', NULL, NULL, '-LvDfv6hn_5BIk0Vzpz0', NULL, NULL, NULL, '2019-12-04 02:14:11', '2019-12-04 02:16:02', NULL, 3, NULL),
(291, 5, 0, NULL, 'b3dkT5L1gDnypLhK', NULL, NULL, '-LvGO6sN-EXerJ-n1F1E', NULL, NULL, NULL, '2019-12-04 14:50:55', '2019-12-04 14:51:56', NULL, 3, NULL),
(292, 5, 0, NULL, '8k4Sv1kgzndDAW8N', NULL, NULL, '-LvGUScvymD1v9Sh8-Kb', NULL, NULL, NULL, '2019-12-04 15:18:36', '2019-12-04 15:20:02', NULL, 3, NULL),
(293, 5, 0, NULL, '30BDuXuN9rsKWaR7', NULL, NULL, '-LvGfejX3OzEOQj6dgfc', NULL, NULL, NULL, '2019-12-04 16:11:55', '2019-12-04 16:13:01', NULL, 3, NULL),
(294, 5, 0, NULL, 'QKWVkmYEE5X0mj0y', NULL, NULL, '-LvJOtc-TryFCmvBDtKm', NULL, NULL, NULL, '2019-12-05 04:53:09', '2019-12-05 04:54:10', NULL, 3, NULL),
(295, 5, 0, NULL, '303dnYKrJi5lJC6i', NULL, NULL, '-Lv_9ttj2CMA9ZcqNF3p', NULL, NULL, NULL, '2019-12-08 11:01:11', '2019-12-08 11:03:02', NULL, 3, NULL),
(296, 5, 0, NULL, '6vrp5ZuJGKfWqOF0', NULL, NULL, '-Lv_9ux_pPNb5dOmvjY3', NULL, NULL, NULL, '2019-12-08 11:01:15', '2019-12-08 11:02:34', NULL, 3, NULL),
(297, 79, 0, NULL, 'YUxZLdwLAa5TWmLv', NULL, NULL, '-LvfUi3QVtX260TA177N', NULL, NULL, NULL, '2019-12-09 16:29:51', '2019-12-09 16:31:02', NULL, 3, NULL),
(298, 29, 0, NULL, 'QQrAcexQlwcNc9M8', NULL, NULL, '-LviGwHNXEUtMorQbFmB', NULL, NULL, NULL, '2019-12-10 05:28:31', '2019-12-10 05:30:02', NULL, 3, NULL),
(299, 77, 0, NULL, '4yCcUb48TeELqvRY', NULL, NULL, '-Lvu6sqdWZYUHX61beT9', NULL, NULL, NULL, '2019-12-12 12:40:02', '2019-12-12 12:42:02', NULL, 3, NULL),
(300, 5, 0, NULL, 'YIgVuGN2DahvirNv', NULL, NULL, '-LwC_W4XM3-1ED9X98CE', NULL, NULL, NULL, '2019-12-16 07:22:16', '2019-12-16 07:24:02', NULL, 3, NULL),
(301, 5, 0, NULL, 'x7SN00tQ0RQqKSht', NULL, NULL, '-LwH_spYY2axyJ7iTaes', NULL, NULL, NULL, '2019-12-17 06:41:59', '2019-12-17 06:43:02', NULL, 3, NULL),
(302, 5, 0, NULL, 'dv3shYuzgJLFBkFY', NULL, NULL, '-LwScBH4Y7VZucd7pB2x', NULL, NULL, NULL, '2019-12-19 10:07:53', '2019-12-19 10:09:02', NULL, 3, NULL),
(303, 5, 0, NULL, 'fKQdatKfbAITE9Mi', NULL, NULL, '-LwSlnQpgL-5Zf-qNeXm', NULL, NULL, NULL, '2019-12-19 10:49:52', '2019-12-19 10:50:53', NULL, 3, NULL),
(304, 5, 0, NULL, 'WdSyrRXdeIYDdC2R', NULL, NULL, '-LwSnlQkxaQUlCWFVpsC', NULL, NULL, NULL, '2019-12-19 10:58:28', '2019-12-19 10:59:32', NULL, 3, NULL),
(305, 5, 0, NULL, 'zk7PXVPxunC999bW', NULL, NULL, '-LwSt_gfoSs_-SeoCaJc', NULL, NULL, NULL, '2019-12-19 11:23:53', '2019-12-19 11:25:01', NULL, 3, NULL),
(306, 5, 0, NULL, 'qBj02u2JGGaNQCzR', NULL, NULL, '-LwStutpb5tCYCC7TXvs', NULL, NULL, NULL, '2019-12-19 11:25:20', '2019-12-19 11:27:01', NULL, 3, NULL),
(307, 29, 0, NULL, 'NiwaAOuzCDkWcpx0', NULL, NULL, '-LwVpkZKQWRZFNxn42iG', NULL, NULL, NULL, '2019-12-20 01:06:01', '2019-12-20 01:07:02', NULL, 3, NULL),
(308, 80, 0, NULL, 'C6FrWJI4TENXLCW6', NULL, NULL, '-LwmzGu6TURszXDi5v7V', NULL, NULL, NULL, '2019-12-23 13:40:46', '2019-12-23 13:42:01', NULL, 3, NULL),
(309, 80, 0, NULL, 'QwqpyC3Gtq0HWnY6', NULL, NULL, '-LwmzapuJBkbUjtREtyZ', NULL, NULL, NULL, '2019-12-23 13:42:12', '2019-12-23 13:43:14', NULL, 3, NULL),
(310, 5, 0, NULL, 'RaexKUp1b21OuyBl', NULL, NULL, '-Lwn-MCebLMN-xc59sZG', NULL, NULL, NULL, '2019-12-23 13:45:30', '2019-12-23 13:46:51', NULL, 3, NULL),
(311, 80, 1, '5.00', '66zL8OAdVlQHLRXn', 2, 1, '-Lwn-mCr_4mwB_u3FU5I', 'T-bkksub15797102505699561', '2019-12-23 13:47:44', 'RM', '2019-12-23 13:47:21', '2019-12-23 13:47:44', NULL, 1, NULL),
(312, 80, 0, NULL, 'Nt3hjTrQuz9sAu5N', NULL, NULL, '-Lwn2-9Fn6hsty63cCG2', NULL, NULL, NULL, '2019-12-23 13:57:02', '2019-12-23 13:58:04', NULL, 3, NULL),
(313, 77, 0, NULL, '89OLFMD6Sgq0PdtT', NULL, NULL, '-Lwq2j2z4cxzm9LOJ47F', NULL, NULL, NULL, '2019-12-24 03:59:06', '2019-12-24 04:01:02', NULL, 3, NULL),
(314, 77, 0, NULL, 'BpWqVZyZWegc1QVc', NULL, NULL, '-LxKYHHQYijSh5U-LTwz', NULL, NULL, NULL, '2019-12-30 06:45:11', '2019-12-30 06:47:01', NULL, 3, NULL),
(315, 80, 1, '25.00', 'olAQNA4KwI8sGi6j', 2, 1, '-LxRcUnHnbCl9lYVlKHw', 'T-bkksub19999971004856539', '2019-12-31 15:45:35', 'RM', '2019-12-31 15:45:17', '2019-12-31 15:45:35', NULL, 1, NULL),
(316, 80, 0, NULL, 'wN6SzhLG8izfHOf2', NULL, NULL, '-LxlBYMBJiGeOSOxO6iU', NULL, NULL, NULL, '2020-01-04 15:35:13', '2020-01-04 15:37:01', NULL, 3, NULL);
INSERT INTO `couponcodes` (`id`, `user_id`, `type`, `amount`, `coupon`, `outlet_id`, `merchant_id`, `firebase_uuid`, `transaction_id`, `tranasaction_datetime`, `currency`, `created_at`, `updated_at`, `updated_by`, `status`, `deleted_at`) VALUES
(317, 5, 0, NULL, 'ZRrrT6MwpxjuXoSK', NULL, NULL, '-LxyYOmXPVqyg3MlTviz', NULL, NULL, NULL, '2020-01-07 05:50:07', '2020-01-07 05:52:01', NULL, 3, NULL),
(318, 80, 0, NULL, 'y0ZWXfPfzNMOkSt2', NULL, NULL, '-Ly7IbECCZ3sveuspFow', NULL, NULL, NULL, '2020-01-09 03:17:20', '2020-01-09 03:19:02', NULL, 3, NULL),
(319, 77, 0, NULL, 'oqUT7nlSVLha9QqI', NULL, NULL, '-Ly7xv4W3dKFoIFy-mml', NULL, NULL, NULL, '2020-01-09 06:22:11', '2020-01-09 06:24:02', NULL, 3, NULL),
(320, 80, 0, NULL, 'hOxg7FEXCjqmhC2M', NULL, NULL, '-LyET4RUqe6QnmV9-NEJ', NULL, NULL, NULL, '2020-01-10 12:40:26', '2020-01-10 12:41:27', NULL, 3, NULL),
(321, 80, 0, NULL, 'H0VP8kNgS7jj01wy', NULL, NULL, '-LyETpI2gd4G5M3a7tSN', NULL, NULL, NULL, '2020-01-10 12:43:42', '2020-01-10 12:45:02', NULL, 3, NULL),
(322, 29, 0, NULL, 'LdQDnSjXY9AC3k8r', NULL, NULL, '-LyXQLZKdPTkEaBmKmzX', NULL, NULL, NULL, '2020-01-14 05:01:17', '2020-01-14 05:03:01', NULL, 3, NULL),
(323, 29, 0, NULL, 'eFYgZTV6eE3MwYN8', NULL, NULL, '-LyXQ_cmau7EYSw0-PS5', NULL, NULL, NULL, '2020-01-14 05:02:18', '2020-01-14 05:04:02', NULL, 3, NULL),
(324, 29, 0, NULL, 'Me6lskCJ7B4R9YLy', NULL, NULL, '-LyXQatcMQYi_diMgVW0', NULL, NULL, NULL, '2020-01-14 05:02:23', '2020-01-14 05:04:03', NULL, 3, NULL),
(325, 29, 0, NULL, '4B9L2cRRTnvxeEV7', NULL, NULL, '-LyXT121PEZZjPQGB3WM', NULL, NULL, NULL, '2020-01-14 05:12:59', '2020-01-14 05:14:01', NULL, 3, NULL),
(326, 77, 0, NULL, 's44qcvzzTx8Sf08S', NULL, NULL, '-LycchcN8Ezbu9ZALUbu', NULL, NULL, NULL, '2020-01-15 09:57:22', '2020-01-15 09:59:02', NULL, 3, NULL),
(327, 77, 0, NULL, 'oiOOonbw9oVVi7F6', NULL, NULL, '-Lz2RLHPIWezO-ah2rpr', NULL, NULL, NULL, '2020-01-20 14:53:06', '2020-01-20 14:55:02', NULL, 3, NULL),
(328, 80, 0, NULL, 'VXwhPiSG7lymFMbs', NULL, NULL, '-Mw_uvUhrE3Y2CLoCWdC', NULL, NULL, NULL, '2022-02-23 17:31:19', NULL, NULL, 0, NULL),
(329, 80, 0, NULL, 'EhcaiUMrDtwDlLUg', NULL, NULL, '-MweJJLUSEHE7WzT23Sw', NULL, NULL, NULL, '2022-02-24 14:00:43', NULL, NULL, 0, NULL),
(330, 80, 0, NULL, 'Q1JwZHylWTMp2maQ', NULL, NULL, '-MweJLhTeeI60xAQFnS3', NULL, NULL, NULL, '2022-02-24 14:00:53', NULL, NULL, 0, NULL),
(331, 80, 0, NULL, 'UT3jqmDd4jjeEeLn', NULL, NULL, '-MweLy8QAc2BRtML3b2T', NULL, NULL, NULL, '2022-02-24 14:12:19', NULL, NULL, 0, NULL),
(332, 80, 3, '0.00', 'ekV2yu2ScnTKXgqf', 2, 1, '-MweMRn_3YMibLTJgtdk', 'U-bkksub25749525448985255', '2022-02-24 14:14:41', 'RM', '2022-02-24 14:14:24', '2022-02-24 14:14:41', NULL, 1, NULL),
(333, 80, 3, '0.00', 'HbrDx9ZKIZpClcqQ', 2, 1, '-Mwi_I8nCXznkbDqT6T1', 'U-bkksub25197525710248100', '2022-02-25 09:53:38', 'RM', '2022-02-25 09:53:24', '2022-03-03 16:09:09', NULL, 3, NULL),
(334, 5, 0, NULL, 'HlekQkPN346CER8E', NULL, NULL, '-MxShvWEp6_FZ6Rt2c4_', NULL, NULL, NULL, '2022-03-06 13:33:15', NULL, NULL, 0, NULL),
(335, 5, 3, '0.00', 'F3YlgUzyty20qveR', 2, 1, '-MxSiUAPjJgrFhJhw7K5', 'U-bkksub25151555348991019', '2022-03-06 13:35:56', 'RM', '2022-03-06 13:35:41', '2022-03-06 13:35:56', NULL, 1, NULL),
(336, 5, 0, NULL, 'pxA5qDlpgcK3wjiu', NULL, NULL, '-MxSinuZ1k6vIncAlST3', NULL, NULL, NULL, '2022-03-06 13:37:06', NULL, NULL, 0, NULL),
(337, 80, 3, '0.00', '3wzdQwPJnK7ysV8U', 2, 1, '-MxX7lIV7q024vDKDjbF', 'U-bkksub25651565256485649', '2022-03-07 10:09:10', 'RM', '2022-03-07 10:09:00', '2022-03-07 10:09:10', NULL, 1, NULL),
(338, 80, 3, '0.00', '3jOXEzY99EqmZ2gM', 2, 1, '-MxX8-rB5KSOvpdGry81', 'U-bkksub29810210099994910', '2022-03-07 10:10:08', 'RM', '2022-03-07 10:10:04', '2022-03-07 10:10:08', NULL, 1, NULL),
(339, 80, 3, '0.00', 'umYZeuelyPZjQqNs', 2, 1, '-MxX8IKpxOKBSoKN12x1', 'U-bkksub24849545752102515', '2022-03-07 10:11:21', 'RM', '2022-03-07 10:11:20', '2022-03-07 10:11:21', NULL, 1, NULL),
(340, 80, 0, NULL, 'pq6VPWZEFPsIo6wg', NULL, NULL, '-MxX8mZVsRjANLEnuimi', NULL, NULL, NULL, '2022-03-07 10:13:27', NULL, NULL, 0, NULL),
(341, 80, 3, '0.00', '1nwCuDGzpNauSMJf', 2, 1, '-MxXIxCm8YBCgpmKTKJW', 'U-bkksub21015456101102515', '2022-03-07 10:57:54', 'RM', '2022-03-07 10:57:53', '2022-03-07 10:57:54', NULL, 1, NULL),
(342, 80, 3, '0.00', 'ozW2bS9lSZYX6jzI', 2, 1, '-MxXJRZM462tUnd-Y0tK', 'U-bkksub21001011024956559', '2022-03-07 11:00:03', 'RM', '2022-03-07 11:00:01', '2022-03-07 11:00:03', NULL, 1, NULL),
(343, 80, 3, '0.00', '73doBXH6H6X0KzlD', 2, 1, '-MxXK4t_fbw8bPC7I-y3', 'U-bkksub21015656554910299', '2022-03-07 11:02:52', 'RM', '2022-03-07 11:02:50', '2022-03-07 11:02:52', NULL, 1, NULL),
(344, 80, 3, '0.00', 'diInjRyc14zmwykj', 2, 1, '-MxXKmUin3f0Z5OLv7aH', 'U-bkksub29948995748102524', '2022-03-07 11:05:54', 'RM', '2022-03-07 11:05:53', '2022-03-07 11:05:54', NULL, 1, NULL),
(345, 80, 3, '0.00', 'NQUHAK0MVAZiKcWz', 2, 1, '-MxXTFv9FHmaey-D1Iop', 'U-bkksub29855989997975053', '2022-03-07 11:45:31', 'RM', '2022-03-07 11:42:55', '2022-03-07 11:45:31', NULL, 1, NULL),
(346, 80, 0, NULL, 'xSqdzWsCXOJgMTcS', NULL, NULL, '-MxXkyKWS_Mc0_naczYT', NULL, NULL, NULL, '2022-03-07 13:04:39', NULL, NULL, 0, NULL),
(347, 5, 0, NULL, '0zoqgCaFTbzXWC0q', NULL, NULL, '-MxXlkcjCfS0zGuK4plT', NULL, NULL, NULL, '2022-03-07 13:08:05', NULL, NULL, 0, NULL),
(348, 80, 0, NULL, 'bxQ236K3qPuZqvsZ', NULL, NULL, '-MxXnbtJLJfTeJWhtsBb', NULL, NULL, NULL, '2022-03-07 13:16:14', NULL, NULL, 0, NULL),
(349, 80, 3, '0.00', '9IQahzDHLCsn9SaJ', 2, 1, '-MxXoUx9uzj2XTjAUCX1', 'U-bkksub29854529810155102', '2022-03-07 13:20:06', 'RM', '2022-03-07 13:20:03', '2022-03-07 13:20:06', NULL, 1, NULL),
(350, 80, 3, '0.00', 'A0GMODiHeCgm8hJ6', 2, 1, '-MxXp5A_IX0t074sYBYf', 'U-bkksub21015310151575349', '2022-03-07 13:22:47', 'RM', '2022-03-07 13:22:40', '2022-03-07 13:22:47', NULL, 1, NULL),
(351, 80, 3, '0.00', 'okrufccnecYDt4xx', 2, 1, '-MxY1hYly3HXjk8vIcDS', 'U-bkksub24957535653564810', '2022-03-07 14:22:18', 'RM', '2022-03-07 14:22:09', '2022-03-07 14:22:18', NULL, 1, NULL),
(352, 80, 3, '0.00', '0MqjE35vn5NeyyNp', 2, 1, '-MxYAg-F1RQOg3f4MPjw', 'U-bkksub24910048999953559', '2022-03-07 15:01:33', 'RM', '2022-03-07 15:01:22', '2022-03-07 15:01:33', NULL, 1, NULL),
(353, 80, 3, '0.00', 'i4jXfYlWtJrCFWLu', 2, 1, '-MxYFKTPaoj9lyZuJvag', 'U-bkksub25055102102525449', '2022-03-07 15:21:43', 'RM', '2022-03-07 15:21:41', '2022-03-07 15:21:43', NULL, 1, NULL),
(354, 80, 0, NULL, 'H4rGX0ZhRCaVGJa7', NULL, NULL, '-MxYMsZnIj9hQwuVB-6M', NULL, NULL, NULL, '2022-03-07 15:54:39', NULL, NULL, 0, NULL),
(355, 80, 3, '0.00', '12WJ05vsN4OqHySj', 2, 1, '-MxYOYHv-Dq9t14A8iWI', 'U-bkksub25249565257525156', '2022-03-07 16:02:04', 'RM', '2022-03-07 16:01:56', '2022-03-07 16:02:04', NULL, 1, NULL),
(356, 5, 0, NULL, 'Q1Zs6IASUUMmLZy6', NULL, NULL, '-MxYx_6TGLgE5zUdd1mS', NULL, NULL, NULL, '2022-03-07 18:39:21', NULL, NULL, 0, NULL),
(357, 5, 0, NULL, 'UKFiKwIS8mYad36m', NULL, NULL, '-MxcAohgNg91kj_AGoWK', NULL, NULL, NULL, '2022-03-08 14:20:04', NULL, NULL, 0, NULL),
(358, 80, 0, NULL, '8Cu1tT6KtAJNbWuI', NULL, NULL, '-MxcQrcVKpZj2LSnEhy1', NULL, NULL, NULL, '2022-03-08 15:30:10', NULL, NULL, 0, NULL),
(359, 80, 0, NULL, 'Pr704apyjiKROfYm', NULL, NULL, '-MxcQuhb-U4RFGBvTf8X', NULL, NULL, NULL, '2022-03-08 15:30:23', NULL, NULL, 0, NULL),
(360, 80, 0, NULL, 'xDXDgGiJvY0rxClo', NULL, NULL, '-MxcR4juj7kT-h1Ek50R', NULL, NULL, NULL, '2022-03-08 15:31:08', NULL, NULL, 0, NULL),
(361, 80, 0, NULL, 'YDhsSRcwDQ8cmx6A', NULL, NULL, '-MxcRQu-is7Vac01_hgJ', NULL, NULL, NULL, '2022-03-08 15:32:39', NULL, NULL, 0, NULL),
(362, 80, 0, NULL, 'Q7SzxSSSPAfMI2qD', NULL, NULL, '-MxhJ3VqDufyhY2GYI_i', NULL, NULL, NULL, '2022-03-09 14:14:12', NULL, NULL, 0, NULL),
(363, 80, 0, NULL, '4yOWilF8RstVwp3W', NULL, NULL, '-MxhWRoQyKR7TAkhBNdX', NULL, NULL, NULL, '2022-03-09 15:12:39', NULL, NULL, 0, NULL),
(364, 80, 0, NULL, '4VmhgkEuVhHxURAD', NULL, NULL, '-MxhZp5qFyVN08U2dZkb', NULL, NULL, NULL, '2022-03-09 15:27:25', NULL, NULL, 0, NULL),
(365, 80, 0, NULL, 'XdXDuVoCSgXiFMpk', NULL, NULL, '-MxhZqf2ioq9hZENapu7', NULL, NULL, NULL, '2022-03-09 15:27:32', NULL, NULL, 0, NULL),
(366, 80, 0, NULL, 'ujnMG44xWyYTxnw1', NULL, NULL, '-Mxh_CT4wvuCeHrR9Ujl', NULL, NULL, NULL, '2022-03-09 15:29:05', NULL, NULL, 0, NULL),
(367, 80, 0, NULL, '48R1UUxIiL8kYLAX', NULL, NULL, '-Mxh_uhSReJ93JzN5nQA', NULL, NULL, NULL, '2022-03-09 15:32:10', NULL, NULL, 0, NULL),
(368, 80, 0, NULL, '1OC2e6BAcoBCjYiL', NULL, NULL, '-MxhjHbTJZUYDj82ofaT', NULL, NULL, NULL, '2022-03-09 16:13:07', NULL, NULL, 0, NULL),
(369, 80, 3, '0.00', 'HpLhdzbYesM3ia5Q', 2, 1, '-MxhjqbieDd7c15P1KHd', 'U-bkksub29910099549810050', '2022-03-09 16:16:10', 'RM', '2022-03-09 16:15:35', '2022-03-09 16:16:10', NULL, 1, NULL),
(370, 80, 0, NULL, 'lzTGGwoL3opFm8BX', NULL, NULL, '-MxmP3iIE39RPbCMU60V', NULL, NULL, NULL, '2022-03-10 13:58:32', NULL, NULL, 0, NULL),
(371, 80, 0, NULL, 'jXHcWq4XjpXL2i5w', NULL, NULL, '-My6-l6ujEwfzwPrcjzH', NULL, NULL, NULL, '2022-03-14 13:59:59', NULL, NULL, 0, NULL),
(372, 80, 0, NULL, 'rL2lsZ8LtCSdloIN', NULL, NULL, '-My6-q2xKzWKSVxFOmo-', NULL, NULL, NULL, '2022-03-14 14:00:19', NULL, NULL, 0, NULL),
(373, 80, 0, NULL, 'a4E2KVvBsFbkTXky', NULL, NULL, '-My6-ypNSUY-gL2jZCAY', NULL, NULL, NULL, '2022-03-14 14:00:55', NULL, NULL, 0, NULL),
(374, 80, 0, NULL, '6EOYFvvODA2WxILH', NULL, NULL, '-My60G-AtTWBmysYcsI1', NULL, NULL, NULL, '2022-03-14 14:02:10', NULL, NULL, 0, NULL),
(375, 80, 0, NULL, 'YHrTHrsGM2Ny1QBa', NULL, NULL, '-My60N6FPOPgE68L6tsb', NULL, NULL, NULL, '2022-03-14 14:02:39', NULL, NULL, 0, NULL),
(376, 80, 0, NULL, '547nNU59N0hlFbHY', NULL, NULL, '-MyA7mZxdcLl39Jvui3U', NULL, NULL, NULL, '2022-03-15 09:13:31', NULL, NULL, 0, NULL),
(377, 80, 0, NULL, 'WQ75qgDxxwduPqD7', NULL, NULL, '-MyA7uGNB9P6lUFuAUaw', NULL, NULL, NULL, '2022-03-15 09:14:03', NULL, NULL, 0, NULL),
(378, 80, 0, NULL, 'YrGgT75pvKmy2Olw', NULL, NULL, '-MyA7zzH2TB9Db5fxUy7', NULL, NULL, NULL, '2022-03-15 09:14:26', NULL, NULL, 0, NULL),
(379, 80, 0, NULL, 'qaCHtpxwRe0E0LK2', NULL, NULL, '-MyA9VKuMS410uF3ZZzZ', NULL, NULL, NULL, '2022-03-15 09:21:01', NULL, NULL, 0, NULL),
(380, 80, 0, NULL, 'OGfDu12nUFhaLu4l', NULL, NULL, '-MyA9mrJvisRpmD5GJ3S', NULL, NULL, NULL, '2022-03-15 09:22:17', NULL, NULL, 0, NULL),
(381, 80, 0, NULL, 'zx3m9oPy4T2t7Bkc', NULL, NULL, '-MyAA-kb0D8h6J3hr7rI', NULL, NULL, NULL, '2022-03-15 09:23:14', NULL, NULL, 0, NULL),
(382, 80, 0, NULL, 'lae8AuenNRgt4Ofx', NULL, NULL, '-MyAAfUKSnBGHZBdtwhe', NULL, NULL, NULL, '2022-03-15 09:26:09', NULL, NULL, 0, NULL),
(383, 80, 0, NULL, 'rpWnN0qRYwdMTDiT', NULL, NULL, '-MyACZ97T6IB79jUY5tu', NULL, NULL, NULL, '2022-03-15 09:34:23', NULL, NULL, 0, NULL),
(384, 80, 0, NULL, 'zMMhuLsmSdeC6vO9', NULL, NULL, '-MyGGKKNagQsz2Vj4LxG', NULL, NULL, NULL, '2022-03-16 13:48:34', NULL, NULL, 0, NULL),
(385, 80, 0, NULL, 'Oz0tCNuGdvjTqg20', NULL, NULL, '-MyGGKU4rOU8AP2qNJMu', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(386, 80, 0, NULL, '9Qw28IziW3OA81Iz', NULL, NULL, '-MyGGKZolK0zm1xxT3Gq', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(387, 80, 0, NULL, 'T7dCciVhluRUmoUa', NULL, NULL, '-MyGGKb6YHJGQrQ_gC_B', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(388, 80, 0, NULL, '5EqylKIAS5V8Of9l', NULL, NULL, '-MyGGKdOM6CdSGRjlhFZ', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(389, 80, 0, NULL, 'DK8b6uXjWXxJNl6z', NULL, NULL, '-MyGGKdPoy5r73xqfS60', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(390, 80, 0, NULL, 'WXRQngr6Cahy0EIh', NULL, NULL, '-MyGGKiHdFaTY8BIhsVR', NULL, NULL, NULL, '2022-03-16 13:48:36', NULL, NULL, 0, NULL),
(391, 80, 0, NULL, '0QkMIwquzhq0pExx', NULL, NULL, '-MyGG_friUqxaq1oz22e', NULL, NULL, NULL, '2022-03-16 13:49:41', NULL, NULL, 0, NULL),
(392, 80, 0, NULL, '7BL8gKRt6YuAipzN', NULL, NULL, '-MyGLh9FRWlrriGJLh0X', NULL, NULL, NULL, '2022-03-16 14:12:02', NULL, NULL, 0, NULL),
(393, 80, 0, NULL, 'X9dxiH40wwpbxxnO', NULL, NULL, '-MyGSOz3q-CZ1mqUNYMW', NULL, NULL, NULL, '2022-03-16 14:41:19', NULL, NULL, 0, NULL),
(394, 80, 0, NULL, 'CtaGLCdlGLxnPKeL', NULL, NULL, '-MyGZTfJ62eGQPHgX1sE', NULL, NULL, NULL, '2022-03-16 15:12:13', NULL, NULL, 0, NULL),
(395, 80, 0, NULL, 'WM8iOdkVPz0SxhhL', NULL, NULL, '-MyGaTraYZ0YIRQ9n_gV', NULL, NULL, NULL, '2022-03-16 15:20:58', NULL, NULL, 0, NULL),
(396, 80, 0, NULL, 'M7tNqp7eALKTuEZY', NULL, NULL, '-MyH9fkjS40Uq7Wx40aD', NULL, NULL, NULL, '2022-03-16 17:59:08', NULL, NULL, 0, NULL),
(397, 80, 0, NULL, 'cbig3Uxz3tlkeqwm', NULL, NULL, '-MyH9jc3D3QLpNukSjSj', NULL, NULL, NULL, '2022-03-16 17:59:24', NULL, NULL, 0, NULL),
(398, 80, 0, NULL, 'eLsNRH1VOdLtMZwp', NULL, NULL, '-MyHAss3YeGjH1jhipq1', NULL, NULL, NULL, '2022-03-16 18:04:24', NULL, NULL, 0, NULL),
(399, 80, 0, NULL, 'OI1bRCcXlNp1W8yI', NULL, NULL, '-MyL6wx21qKd2rUuQTvD', NULL, NULL, NULL, '2022-03-17 12:25:41', NULL, NULL, 0, NULL),
(400, 80, 0, NULL, 'Bda99aJRr50brE2z', NULL, NULL, '-MyL7-QCnzlv-KXLSh1q', NULL, NULL, NULL, '2022-03-17 12:25:55', NULL, NULL, 0, NULL),
(401, 80, 0, NULL, 'oBBGauXDEukMFBXt', NULL, NULL, '-MyL7BmutT53jeP5MCMM', NULL, NULL, NULL, '2022-03-17 12:26:46', NULL, NULL, 0, NULL),
(402, 80, 0, NULL, 'qZfj2BjVgKUQ74mf', NULL, NULL, '-MyL7ZMTTaR4L46d6Bbu', NULL, NULL, NULL, '2022-03-17 12:28:22', NULL, NULL, 0, NULL),
(403, 80, 0, NULL, 'Ovohn17KLR8vAN4C', NULL, NULL, '-MyL8LTwqNPdjTindqbw', NULL, NULL, NULL, '2022-03-17 12:31:48', NULL, NULL, 0, NULL),
(404, 80, 0, NULL, 'TqIr8PNlMtp12KrT', NULL, NULL, '-MyL9EepXYiQK-qP2RuZ', NULL, NULL, NULL, '2022-03-17 12:35:42', NULL, NULL, 0, NULL),
(405, 80, 0, NULL, '4VJZpyl328NkAlbP', NULL, NULL, '-MyL9dDk0K8RC1hNdOa4', NULL, NULL, NULL, '2022-03-17 12:37:27', NULL, NULL, 0, NULL),
(406, 80, 0, NULL, '4LZJ6fwpDKwZs1d2', NULL, NULL, '-MyL9eVWpPg80QF6FBs7', NULL, NULL, NULL, '2022-03-17 12:37:32', NULL, NULL, 0, NULL),
(407, 80, 0, NULL, 'TzYyLIl779GFvZU2', NULL, NULL, '-MyLAWLcExrVTQmp4czV', NULL, NULL, NULL, '2022-03-17 12:41:16', NULL, NULL, 0, NULL),
(408, 80, 0, NULL, 'cMA9hOKWncJdzTzg', NULL, NULL, '-MyLBtXXENkbSbaSFS7v', NULL, NULL, NULL, '2022-03-17 12:47:18', NULL, NULL, 0, NULL),
(409, 80, 0, NULL, 'LwkXALTBftBjzLjG', NULL, NULL, '-MyLC_BqztoB6yr0wrKt', NULL, NULL, NULL, '2022-03-17 12:50:17', NULL, NULL, 0, NULL),
(410, 80, 0, NULL, 'F8V5XjV7p5a0JW9o', NULL, NULL, '-MyLFWbpUuJNzAvFPuEr', NULL, NULL, NULL, '2022-03-17 13:03:08', NULL, NULL, 0, NULL),
(411, 80, 0, NULL, 'VVWeOISGdLXpM7bL', NULL, NULL, '-MyLFY0UfToovRwI4Xmd', NULL, NULL, NULL, '2022-03-17 13:03:14', NULL, NULL, 0, NULL),
(412, 80, 0, NULL, 'fjiRTKiZt752auGz', NULL, NULL, '-MyLNalm_aG9B3r4O3oG', NULL, NULL, NULL, '2022-03-17 13:38:27', NULL, NULL, 0, NULL),
(413, 80, 0, NULL, '3EdaudbGyUdwCuwE', NULL, NULL, '-MyLOQmjfmNrdBJ5FKJp', NULL, NULL, NULL, '2022-03-17 13:42:04', NULL, NULL, 0, NULL),
(414, 80, 0, NULL, 'eQztgnfnWTrTTVLo', NULL, NULL, '-MyLcGiwdwHdLKj5EQ3g', NULL, NULL, NULL, '2022-03-17 14:46:55', NULL, NULL, 0, NULL),
(415, 80, 0, NULL, '31EhuTcvdcbbb7Xe', NULL, NULL, '-MyLe59-nfHfJfducZmU', NULL, NULL, NULL, '2022-03-17 14:54:52', NULL, NULL, 0, NULL),
(416, 80, 0, NULL, 'G0o5E1huFadej2QS', NULL, NULL, '-MyLe6TE9ieTzeh-gyg1', NULL, NULL, NULL, '2022-03-17 14:54:57', NULL, NULL, 0, NULL),
(417, 80, 0, NULL, 'CRIzNmQh2PMpbEuI', NULL, NULL, '-MyLhcLP1M_1QTvq8iHz', NULL, NULL, NULL, '2022-03-17 15:10:18', NULL, NULL, 0, NULL),
(418, 80, 0, NULL, 'fPdXIWxnIlvnIsHA', NULL, NULL, '-MyLhuctBMrBmvC5XwAD', NULL, NULL, NULL, '2022-03-17 15:11:33', NULL, NULL, 0, NULL),
(419, 80, 0, NULL, 'qGxxMivgbYO1WNmK', NULL, NULL, '-MyLi6AmJZhiJ03xTejB', NULL, NULL, NULL, '2022-03-17 15:12:24', NULL, NULL, 0, NULL),
(420, 80, 0, NULL, 'ZsMFDfjvLBUwFWRd', NULL, NULL, '-MyLiDidB9B-OPUmI_X4', NULL, NULL, NULL, '2022-03-17 15:12:55', NULL, NULL, 0, NULL),
(421, 80, 0, NULL, 'Lnu34or4ELyjIo18', NULL, NULL, '-MyLiQms4VlIgJrXso8P', NULL, NULL, NULL, '2022-03-17 15:13:49', NULL, NULL, 0, NULL),
(422, 80, 0, NULL, 'y0mDShArEaowveBR', NULL, NULL, '-MyLimDP_rcIddFP_M5Q', NULL, NULL, NULL, '2022-03-17 15:15:21', NULL, NULL, 0, NULL),
(423, 80, 0, NULL, '0K7FGEgo9f3N8CKd', NULL, NULL, '-MyLkG0P3MDwpg54H4C2', NULL, NULL, NULL, '2022-03-17 15:21:49', NULL, NULL, 0, NULL),
(424, 80, 0, NULL, '0fUPZCr3OBU1DdpG', NULL, NULL, '-MyMlY6a4VUbsosH9IcA', NULL, NULL, NULL, '2022-03-17 20:07:02', NULL, NULL, 0, NULL),
(425, 80, 0, NULL, 'VEsunYPaOs9U8xGb', NULL, NULL, '-MyMl_bbWY3cFXWjyWyT', NULL, NULL, NULL, '2022-03-17 20:07:13', NULL, NULL, 0, NULL),
(426, 80, 0, NULL, 'D3TTXol4YMYUeIF4', NULL, NULL, '-MyMlppe0bf2WGo3a7O6', NULL, NULL, NULL, '2022-03-17 20:08:19', NULL, NULL, 0, NULL),
(427, 80, 0, NULL, 'fMyVkVy8x2GjD6Tt', NULL, NULL, '-MyMluC4YARt1yqGjJb0', NULL, NULL, NULL, '2022-03-17 20:08:37', NULL, NULL, 0, NULL),
(428, 80, 0, NULL, 'D53sMw286e4UhnRi', NULL, NULL, '-MyMlxJCIqs6RBrhlOLZ', NULL, NULL, NULL, '2022-03-17 20:08:50', NULL, NULL, 0, NULL),
(429, 80, 0, NULL, 'wpienSiczAPT3sbm', NULL, NULL, '-MyMmf6wwnbabqvwQ-rP', NULL, NULL, NULL, '2022-03-17 20:11:57', NULL, NULL, 0, NULL),
(430, 80, 0, NULL, 'cAYAcrRLtQUIxF8C', NULL, NULL, '-MyMmi5W7rGyuIaoHpa0', NULL, NULL, NULL, '2022-03-17 20:12:10', NULL, NULL, 0, NULL),
(431, 80, 0, NULL, 'EszQnhRTmsoZ3Qbt', NULL, NULL, '-MyMnFaDOJK1ju6zQ5Wd', NULL, NULL, NULL, '2022-03-17 20:14:31', NULL, NULL, 0, NULL),
(432, 80, 0, NULL, 'YZuosnNz9KLL8DEl', NULL, NULL, '-MyMnKz636H2U33wptvc', NULL, NULL, NULL, '2022-03-17 20:14:53', NULL, NULL, 0, NULL),
(433, 80, 0, NULL, 'IXOasgj2zgvG4kBk', NULL, NULL, '-MyMnNLhY-f3uVlJjLO0', NULL, NULL, NULL, '2022-03-17 20:15:03', NULL, NULL, 0, NULL),
(434, 80, 0, NULL, 'FkTyT7Nw1ENWYtP0', NULL, NULL, '-MyR2Rvp-bm5qRTKrzrf', NULL, NULL, NULL, '2022-03-18 16:03:45', NULL, NULL, 0, NULL),
(435, 80, 0, NULL, '8Xo8YF7ynvGqM4Xf', NULL, NULL, '-MyR2VTIfjhrLmextnry', NULL, NULL, NULL, '2022-03-18 16:03:59', NULL, NULL, 0, NULL),
(436, 80, 0, NULL, 'xbkVZFcsPSvdaHSA', NULL, NULL, '-MyfMdYhS3v8nCnxtijD', NULL, NULL, NULL, '2022-03-21 15:26:17', NULL, NULL, 0, NULL),
(437, 80, 3, '0.00', 'x3IlE0wpcXh1G5uY', 2, 1, '-MyfQGsYR4QVBO0lbeBT', 'U-bkksub25352494851101545', '2022-03-21 15:42:11', 'RM', '2022-03-21 15:42:09', '2022-03-21 15:42:11', NULL, 1, NULL),
(438, 80, 3, '0.00', 'B0sdhFircXaxQAye', 2, 1, '-MyfWP9Jtaa0axVNhMyO', 'U-bkksub25399545199555552', '2022-03-21 16:09:09', 'RM', '2022-03-21 16:08:56', '2022-03-21 16:09:09', NULL, 1, NULL),
(439, 80, 3, '0.00', 'r9YnHxEIUtv2cCQ4', 2, 1, '-MyfWxFLajpIIgOw4qeJ', 'U-bkksub25649555356505552', '2022-03-21 16:11:30', 'RM', '2022-03-21 16:11:19', '2022-03-21 16:11:30', NULL, 1, NULL),
(440, 80, 0, NULL, 's0jCL8rU4PNGgn4t', NULL, NULL, '-MyfcWrZdUzKlVEIelct', NULL, NULL, NULL, '2022-03-21 16:40:02', NULL, NULL, 0, NULL),
(441, 80, 0, NULL, 'd9ifvZOxrEZc48sM', NULL, NULL, '-MznF5iAhbPBZo9yBsPe', NULL, NULL, NULL, '2022-04-04 14:25:59', NULL, NULL, 0, NULL),
(442, 80, 0, NULL, 'GUWG2ilGz1DYLOc7', NULL, NULL, '-Mzre47SuJ9pbn3KoIpn', NULL, NULL, NULL, '2022-04-05 10:57:57', NULL, NULL, 0, NULL),
(443, 80, 0, NULL, '1loa5WKuD7IUWhpf', NULL, NULL, '-N-4gmvTarn4gzL1nGaU', NULL, NULL, NULL, '2022-04-08 04:24:30', NULL, NULL, 0, NULL),
(444, 80, 0, NULL, 'MWQIkPbyxF1deaM1', NULL, NULL, '-N-5m0nPAxrhaKP9UkS_', NULL, NULL, NULL, '2022-04-08 09:26:59', NULL, NULL, 0, NULL),
(445, 80, 0, NULL, 'h3jfc3BaYEYwjp4R', NULL, NULL, '-N-5ntd2EyfVzq5QG30l', NULL, NULL, NULL, '2022-04-08 09:35:10', NULL, NULL, 0, NULL),
(446, 80, 0, NULL, 'xELj1EtIaNC7L6Xg', NULL, NULL, '-N-5oCDcvvRsBkonXQ8q', NULL, NULL, NULL, '2022-04-08 09:36:30', NULL, NULL, 0, NULL),
(447, 80, 0, NULL, 'kjcVlHqnLlJML2MG', NULL, NULL, '-N-5oF0OAFdwlqsFqRnE', NULL, NULL, NULL, '2022-04-08 09:36:42', NULL, NULL, 0, NULL),
(448, 80, 0, NULL, 'VFsIyWyhLz9BEXxI', NULL, NULL, '-N-6D4orJ2LetMtOmLLb', NULL, NULL, NULL, '2022-04-08 11:29:36', NULL, NULL, 0, NULL),
(449, 80, 0, NULL, 'U9Pk2yX2yxEaDDUJ', NULL, NULL, '-N-6Dh3_Am8zWVF5SdvY', NULL, NULL, NULL, '2022-04-08 11:32:16', NULL, NULL, 0, NULL),
(450, 80, 0, NULL, 'sxmZN88IjuFuIQyS', NULL, NULL, '-N-6Dpgv_D13P-QJD9DJ', NULL, NULL, NULL, '2022-04-08 11:32:52', NULL, NULL, 0, NULL),
(451, 80, 0, NULL, 'Yb4KYm530Bx5qckf', NULL, NULL, '-N-QVageOm6btR5CC_Kb', NULL, NULL, NULL, '2022-04-12 10:02:53', NULL, NULL, 0, NULL),
(452, 80, 0, NULL, 'VsEnFJQBemRwBBJl', NULL, NULL, '-N-QWIupYpfqZH1SgUEw', NULL, NULL, NULL, '2022-04-12 10:05:58', NULL, NULL, 0, NULL),
(453, 80, 0, NULL, 'UXqbsTDzjysLHLS1', NULL, NULL, '-N-QZM25hAIrAjmWAlGK', NULL, NULL, NULL, '2022-04-12 10:19:18', NULL, NULL, 0, NULL),
(454, 80, 0, NULL, 'pGIcYIrbU8cfZhhB', NULL, NULL, '-N-QaA5QpGFy0uKRYQiY', NULL, NULL, NULL, '2022-04-12 10:27:13', NULL, NULL, 0, NULL),
(455, 79, 1, '12.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub4954101100501014', '2022-05-06 04:33:15', 'RM', '2022-05-06 04:33:15', NULL, NULL, 1, NULL),
(456, 81, 1, '1.00', 'CMS', 3, 1, 'CMS', 'AD-bkksub5749515152995448', '2022-05-06 15:10:22', 'RM', '2022-05-06 15:10:22', NULL, NULL, 1, NULL),
(457, 81, 2, '1.00', 'CMS', 5, 1, 'CMS', 'AD-bkksub5599545010256100', '2022-05-06 15:10:35', 'RM', '2022-05-06 15:10:35', NULL, NULL, 1, NULL),
(458, 79, 1, '23.00', 'CMS', 3, 1, 'CMS', 'AD-bkksub5553985051555054', '2022-05-10 11:13:01', 'RM', '2022-05-10 11:13:01', NULL, NULL, 1, NULL),
(459, 79, 1, '12.00', 'CMS', 1, 1, 'CMS', 'AD-bkksub9751100495256549', '2022-05-16 08:06:28', 'RM', '2022-05-16 08:06:28', NULL, NULL, 1, NULL),
(460, 79, 1, '12.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub1005155515253549', '2022-05-16 12:02:47', 'RM', '2022-05-16 12:02:47', NULL, NULL, 1, NULL),
(461, 79, 1, '12.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub9799501025610055', '2022-05-16 12:26:35', 'RM', '2022-05-16 12:26:35', NULL, NULL, 1, NULL),
(462, 79, 1, '12.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub5298981029956100', '2022-05-16 12:27:13', 'RM', '2022-05-16 12:27:13', NULL, NULL, 1, NULL),
(463, 79, 1, '12.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub1004810252100100', '2022-05-16 12:29:30', 'RM', '2022-05-16 12:29:30', NULL, NULL, 1, NULL),
(464, 79, 1, '23.00', 'CMS', 2, 1, 'CMS', 'AD-bkksub5399529953985657', '2022-05-18 12:46:40', 'RM', '2022-05-18 12:46:40', NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

DROP TABLE IF EXISTS `coupon_codes`;
CREATE TABLE IF NOT EXISTS `coupon_codes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1 - top-up, 2 - paid, 3 - get user info',
  `amount` decimal(10,2) DEFAULT NULL,
  `coupon` varchar(40) NOT NULL,
  `outlet_id` bigint(20) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `firebase_uuid` varchar(30) NOT NULL,
  `transaction_id` varchar(30) DEFAULT NULL,
  `tranasaction_datetime` datetime DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 - initiated, 1 - Success, 2- Failure, 3- Expired',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=455 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `user_id`, `type`, `amount`, `coupon`, `outlet_id`, `merchant_id`, `firebase_uuid`, `transaction_id`, `tranasaction_datetime`, `currency`, `created_at`, `updated_at`, `updated_by`, `status`, `deleted_at`) VALUES
(10, 22, 1, '10.00', 'vtue3uUra44ue8M7', 2, NULL, '-Ll5GCjtRjHMNrm2jqvG', NULL, NULL, NULL, '2019-07-31 04:23:33', '2019-07-31 04:23:53', NULL, 1, NULL),
(11, 5, 0, NULL, 'w6MAWuCwJW7LddzQ', NULL, NULL, '-Ll5SrUWXbgOUBJ0ODpg', NULL, NULL, NULL, '2019-07-31 05:18:50', '2019-07-31 05:20:01', NULL, 3, NULL),
(12, 5, 1, '10.00', 'SlwVlbuO3jE4gkuJ', 2, NULL, '-Ll5qdOuER4NrkyL7O5c', NULL, NULL, NULL, '2019-07-31 07:07:06', '2019-07-31 07:07:36', NULL, 1, NULL),
(13, 5, 2, '5.00', 'OuuaJb1H9xBDeEku', 2, NULL, '-Ll5qntTUNot5N9gvtpE', NULL, NULL, NULL, '2019-07-31 07:07:49', '2019-07-31 07:08:21', NULL, 1, NULL),
(14, 22, 0, NULL, '6AQOAPmLfomnZT4G', NULL, NULL, '-Ll6cHmXI6T1rNjzK09L', NULL, NULL, NULL, '2019-07-31 10:44:00', '2019-07-31 10:45:02', NULL, 3, NULL),
(15, 5, 0, NULL, 'WHhSQIcJ5Gm1F1RE', NULL, NULL, '-Ll6oa2l3Nrl5ROAB0hC', NULL, NULL, NULL, '2019-07-31 11:37:45', '2019-07-31 11:38:47', NULL, 3, NULL),
(16, 17, 1, '10.00', 'rPSpDgQYQ0dhmst1', 6, NULL, '-Ll7Fn5Wlg083UX0cEgw', NULL, NULL, NULL, '2019-07-31 13:40:58', '2019-07-31 13:41:21', NULL, 1, NULL),
(17, 29, 0, NULL, 'm4PkunF7ojY7Jx2O', NULL, NULL, '-Ll7M9rLlP5VyPu9eW43', NULL, NULL, NULL, '2019-07-31 14:08:49', '2019-07-31 14:10:02', NULL, 3, NULL),
(18, 17, 0, NULL, '4jmZtCD76lxoCgp4', NULL, NULL, '-Ll7fIv88QYnFt0MRmn2', NULL, NULL, NULL, '2019-07-31 15:36:49', '2019-07-31 15:38:02', NULL, 3, NULL),
(19, 22, 0, NULL, 'RzDFyVDxO5T7zqet', NULL, NULL, '-Llb0wkTz_Xol62BTPPB', NULL, NULL, NULL, '2019-08-06 13:04:20', '2019-08-06 13:06:02', NULL, 3, NULL),
(20, 5, 1, '10.00', '1rppnBNJeLz6WLEG', 2, NULL, '-LmJUMs5T43BSaFZinz4', 'T-bkksub15554100519897975', '2019-08-15 08:56:10', 'RM', '2019-08-15 08:55:48', '2019-08-15 08:56:10', NULL, 1, NULL),
(21, 5, 2, '2.00', 'W6MZQZNpyfU3L6gR', 2, NULL, '-LmJUy8QLKwo7XBXsKal', 'T-bkksub25350975052101485', '2019-08-15 08:58:53', 'RM', '2019-08-15 08:58:24', '2019-08-15 08:58:53', NULL, 1, NULL),
(22, 17, 0, NULL, 'ByBQiQoF3R6V8xPY', NULL, NULL, '-LmopWR3tyuyBFy9yGyN', NULL, NULL, NULL, '2019-08-21 15:40:25', '2019-08-21 15:41:27', NULL, 3, NULL),
(23, 17, 0, NULL, 'YeXWpVGrtnAaKYlB', NULL, NULL, '-Lmu5LSrfiuCJvC2r4eF', NULL, NULL, NULL, '2019-08-22 16:12:02', '2019-08-22 16:13:04', NULL, 3, NULL),
(24, 17, 1, '10.00', '2OR0RIf08kCpnZHo', 2, NULL, '-LmuFrZh28h0sjXPF2Jx', 'T-bkksub11011014951975710', '2019-08-22 16:58:26', 'RM', '2019-08-22 16:57:59', '2019-08-22 16:58:26', NULL, 1, NULL),
(25, 17, 1, '10.00', 'wZev8jcEyrsQQZMq', 2, NULL, '-LmygZniaKrduOc8UagW', 'T-bkksub15057100995556555', '2019-08-23 13:38:02', 'RM', '2019-08-23 13:37:31', '2019-08-23 13:38:02', NULL, 1, NULL),
(26, 17, 1, '90.00', 'EUXw7Br7vzfsaWdI', 2, NULL, '-LmygmNs5lMqLJqbvxKu', 'T-bkksub19910248485653100', '2019-08-23 13:38:44', 'RM', '2019-08-23 13:38:27', '2019-08-23 13:38:44', NULL, 1, NULL),
(27, 17, 1, '67.00', 'Zs0Ta9jKAtAnLJFC', 2, NULL, '-LmyhNWuxwDdERemhV0U', 'T-bkksub11025456102489953', '2019-08-23 13:41:21', 'RM', '2019-08-23 13:41:03', '2019-08-23 13:41:21', NULL, 1, NULL),
(28, 17, 2, '5.00', 'mhGsi67ucHj8UdiA', 2, NULL, '-LmyhsB2zbWU-QMoqWpP', 'T-bkksub21005755571025755', '2019-08-23 13:43:25', 'RM', '2019-08-23 13:43:13', '2019-08-23 13:43:25', NULL, 1, NULL),
(29, 17, 2, '7.00', 'Uwq8mADBHZRlJO5F', 2, NULL, '-LmyjeuF3ZoxyjyaBgad', 'T-bkksub25049102100101979', '2019-08-23 13:51:20', 'RM', '2019-08-23 13:51:03', '2019-08-23 13:51:20', NULL, 1, NULL),
(30, 17, 1, '67.00', 'dBuIRrIUWcnGCepZ', 2, NULL, '-LmyjzvkRLnr7hETNd70', 'T-bkksub15654485097564857', '2019-08-23 13:52:50', 'RM', '2019-08-23 13:52:29', '2019-08-23 13:52:50', NULL, 1, NULL),
(31, 17, 2, '17.00', 'TB2NKpqaV5KGt3Ym', 2, NULL, '-LmykPMuyvUqkx5H-b_E', 'T-bkksub25010110299485549', '2019-08-23 13:54:36', 'RM', '2019-08-23 13:54:17', '2019-08-23 13:54:36', NULL, 1, NULL),
(32, 17, 0, NULL, 'moIg25xryKucGwNj', NULL, NULL, '-Lmz7Wqfzljgf4vJSkFo', NULL, NULL, NULL, '2019-08-23 15:39:39', '2019-08-23 15:41:02', NULL, 3, NULL),
(33, 17, 0, NULL, 'ugn3HbccNYIdA7Cf', NULL, NULL, '-Ln7xr6jJoCMZWZylSJk', NULL, NULL, NULL, '2019-08-25 13:29:15', '2019-08-25 13:31:02', NULL, 3, NULL),
(34, 5, 0, NULL, 'LXDm8sovfyVIO37s', NULL, NULL, '-LnBTiWXQ_FI8_cfxD73', NULL, NULL, NULL, '2019-08-26 05:51:42', '2019-08-26 05:53:02', NULL, 3, NULL),
(35, 5, 0, NULL, '5F4C9RbdEM6J08ou', NULL, NULL, '-LnBTydi3aZTwRs7fKv8', NULL, NULL, NULL, '2019-08-26 05:52:48', '2019-08-26 05:54:02', NULL, 3, NULL),
(36, 17, 0, NULL, 'MgL5dXRpwH2h3pzS', NULL, NULL, '-LnDPcsEZfKqF8fJTLjt', NULL, NULL, NULL, '2019-08-26 14:53:05', '2019-08-26 14:54:07', NULL, 3, NULL),
(37, 17, 0, NULL, '8fGNny0e8GKURMkE', NULL, NULL, '-LnDQ8R4UTIqKNAq-5qC', NULL, NULL, NULL, '2019-08-26 14:55:18', '2019-08-26 14:56:20', NULL, 3, NULL),
(38, 17, 0, NULL, '4y1ExqvUkDbkuGPz', NULL, NULL, '-LnDQS5Ya8T7Su16iRFC', NULL, NULL, NULL, '2019-08-26 14:56:39', '2019-08-26 14:57:40', NULL, 3, NULL),
(39, 17, 1, '67.00', 'oReRMiXt4990esqF', 2, NULL, '-LnDRezyugqF9uexZrUw', 'T-bkksub14949531029750515', '2019-08-26 15:02:17', 'RM', '2019-08-26 15:01:58', '2019-08-26 15:02:17', NULL, 1, NULL),
(40, 17, 2, '300.00', 'hIK4EkIpsbSkVxVs', 2, NULL, '-LnDRsRnwbkOz7n0FBys', NULL, NULL, NULL, '2019-08-26 15:02:53', '2019-08-26 15:03:27', NULL, 2, NULL),
(41, 17, 0, NULL, 'ebNA8ano5bND5mTU', NULL, NULL, '-LnNNVdweIAyHNVDeJ1W', NULL, NULL, NULL, '2019-08-28 13:19:59', '2019-08-28 13:21:01', NULL, 3, NULL),
(42, 17, 2, '300.00', 'AHIE2emFT3loJdtm', 2, NULL, '-LnNPpAQg4AY3RSJRNtg', NULL, NULL, NULL, '2019-08-28 13:30:08', '2019-08-28 13:30:52', NULL, 2, NULL),
(43, 5, 0, NULL, 'xHb7XpD25A63OIQb', NULL, NULL, '-LnNs1yruI5FnW8lhIFS', NULL, NULL, NULL, '2019-08-28 15:37:46', '2019-08-28 15:38:52', NULL, 3, NULL),
(44, 17, 0, NULL, 'tlbwMWWEAsEMVfp4', NULL, NULL, '-LnNs60Y01k3FbyN7I6n', NULL, NULL, NULL, '2019-08-28 15:38:03', '2019-08-28 15:39:04', NULL, 3, NULL),
(45, 17, 0, NULL, 'YZqAiD49cmLKfKYP', NULL, NULL, '-LnNsQoDlcq_VN4OM_1k', NULL, NULL, NULL, '2019-08-28 15:39:28', '2019-08-28 15:40:29', NULL, 3, NULL),
(46, 17, 0, NULL, 'uNO8Ig2C8USJozLD', NULL, NULL, '-LnNtOKarFUyjBTVYYks', NULL, NULL, NULL, '2019-08-28 15:43:40', '2019-08-28 15:44:41', NULL, 3, NULL),
(47, 17, 0, NULL, 'WF85nPkfAJZyA3sv', NULL, NULL, '-LnNtgEQjbHTlSMwlXR1', NULL, NULL, NULL, '2019-08-28 15:44:57', '2019-08-28 15:45:59', NULL, 3, NULL),
(48, 17, 0, NULL, 'qYxzAZvkgNM0lLlt', NULL, NULL, '-LnNvtVR3ksMWFZUkSEL', NULL, NULL, NULL, '2019-08-28 15:54:36', '2019-08-28 15:55:37', NULL, 3, NULL),
(49, 17, 0, NULL, 'FDwsq1V1DfKtigUC', NULL, NULL, '-LnNy1TqFtTciNQSWFEP', NULL, NULL, NULL, '2019-08-28 16:03:57', '2019-08-28 16:04:58', NULL, 3, NULL),
(50, 17, 0, NULL, 'kER9m1evntBbYqoL', NULL, NULL, '-LnO-lMOQOPPX2JksNKI', NULL, NULL, NULL, '2019-08-28 16:15:53', '2019-08-28 16:16:55', NULL, 3, NULL),
(51, 17, 0, NULL, 'PrQ8TWfEB5kDCjwE', NULL, NULL, '-LnO1WsuLl5h8Ao-vyOz', NULL, NULL, NULL, '2019-08-28 16:23:34', '2019-08-28 16:25:02', NULL, 3, NULL),
(52, 17, 0, NULL, 'DIwXL6odUFVKu7BY', NULL, NULL, '-LnO1lChyO3kTbHpw0an', NULL, NULL, NULL, '2019-08-28 16:24:37', '2019-08-28 16:25:39', NULL, 3, NULL),
(53, 17, 0, NULL, 'EL9jm2viTpx3E8fH', NULL, NULL, '-LnO2QcancTJcqVTiZJM', NULL, NULL, NULL, '2019-08-28 16:27:31', '2019-08-28 16:28:32', NULL, 3, NULL),
(54, 17, 0, NULL, 'Bhhr95TOO17CDRJe', NULL, NULL, '-LnO3EbdejDpVLMDTLND', NULL, NULL, NULL, '2019-08-28 16:31:04', '2019-08-28 16:32:05', NULL, 3, NULL),
(55, 17, 2, '2.00', 'hMdsGRpRWu2HcFPj', 2, NULL, '-LnO4-SXpdLmM3ApBTOn', 'T-bkksub25553101975098989', '2019-08-28 16:34:53', 'RM', '2019-08-28 16:34:24', '2019-08-28 16:34:53', NULL, 1, NULL),
(56, 17, 2, '2.00', '4GYYOMN3FdBV2s7E', 2, NULL, '-LnO4lURXu2g8mArZLIH', 'T-bkksub25110253485798101', '2019-08-28 16:38:04', 'RM', '2019-08-28 16:37:45', '2019-08-28 16:38:04', NULL, 1, NULL),
(57, 17, 1, '67.00', 't2vsSqNS0AS0mDHX', 2, NULL, '-LnO57B2buwZTeY3_sNx', 'T-bkksub19952524852971005', '2019-08-28 16:39:27', 'RM', '2019-08-28 16:39:18', '2019-08-28 16:39:27', NULL, 1, NULL),
(58, 17, 2, '2000.00', 'Xa8TND734Cny1cSj', 2, NULL, '-LnO5MgKh_moOBgX965m', NULL, NULL, NULL, '2019-08-28 16:40:21', '2019-08-28 16:40:32', NULL, 2, NULL),
(59, 17, 2, '2000.00', 'Nz4BGgpchBVrkJEI', 2, NULL, '-LnO5fHuSQbZRUiGCGUD', NULL, NULL, NULL, '2019-08-28 16:41:41', '2019-08-28 16:41:51', NULL, 2, NULL),
(60, 17, 2, '200.00', 'KNj1IhWDDLDvxuvh', 2, NULL, '-LnO5oq1yqz-fshE1suD', 'T-bkksub21005750100575157', '2019-08-28 16:42:31', 'RM', '2019-08-28 16:42:20', '2019-08-28 16:42:31', NULL, 1, NULL),
(61, 17, 1, '670.00', 'lxzpxysPDYHUve4e', 2, NULL, '-LnO5xQtZK9i-a9zkmci', 'T-bkksub19810250545448100', '2019-08-28 16:43:13', 'RM', '2019-08-28 16:42:56', '2019-08-28 16:43:13', NULL, 1, NULL),
(62, 17, 0, NULL, '667Mh1G1xE2mjQr8', NULL, NULL, '-LnO74we4Bel_ZOhOF3H', NULL, NULL, NULL, '2019-08-28 16:47:53', '2019-08-28 16:48:55', NULL, 3, NULL),
(63, 17, 0, NULL, 'FJ1PMoWSNFhd0jVC', NULL, NULL, '-LnO7NGB9kilWFLfRfq1', NULL, NULL, NULL, '2019-08-28 16:49:08', '2019-08-28 16:50:09', NULL, 3, NULL),
(64, 17, 0, NULL, 'zI0rPiZLVLko9w9Q', NULL, NULL, '-LnO7g2Bozma-cPDJBpX', NULL, NULL, NULL, '2019-08-28 16:50:29', '2019-08-28 16:51:30', NULL, 3, NULL),
(65, 17, 0, NULL, 'imUe687bhUt8g7yO', NULL, NULL, '-LnOCLns-yu2StuobdYE', NULL, NULL, NULL, '2019-08-28 17:10:52', '2019-08-28 17:11:54', NULL, 3, NULL),
(66, 17, 1, '13.00', 'MB5IA5q2WNoyUQhA', 2, NULL, '-LnOCzj3FQBAT9DHik4j', 'T-bkksub15149100100535210', '2019-08-28 17:13:51', 'RM', '2019-08-28 17:13:40', '2019-08-28 17:13:51', NULL, 1, NULL),
(67, 17, 2, '7.00', 'pfCepJoIEduxVPl0', 2, NULL, '-LnODAYH4eeVXTzsNhLa', 'T-bkksub25751525050515455', '2019-08-28 17:14:50', 'RM', '2019-08-28 17:14:29', '2019-08-28 17:14:50', NULL, 1, NULL),
(68, 29, 0, NULL, 'NqoJpmuP0WK5NOow', NULL, NULL, '-LnQ4M5IhIZyXbVSnNN3', NULL, NULL, NULL, '2019-08-29 01:55:11', '2019-08-29 01:57:02', NULL, 3, NULL),
(69, 17, 1, '670.00', 'sWMYshjG8B2Dl2WZ', 2, NULL, '-LnSqaDNZXeUICtHuHTI', 'T-bkksub15599575054565050', '2019-08-29 14:49:41', 'RM', '2019-08-29 14:49:32', '2019-08-29 14:49:41', NULL, 1, NULL),
(70, 17, 2, '200.00', '5nPJDGhY7WBXayi9', 2, NULL, '-LnSqgKoHJhgZga2rxht', 'T-bkksub21025357995153529', '2019-08-29 14:50:06', 'RM', '2019-08-29 14:49:57', '2019-08-29 14:50:06', NULL, 1, NULL),
(71, 17, 0, NULL, '6pFtiaE2iFn4tqOG', NULL, NULL, '-LnmQgP-CH2GlnSO5tdN', NULL, NULL, NULL, '2019-09-02 14:44:01', '2019-09-02 14:45:02', NULL, 3, NULL),
(72, 17, 0, NULL, 'tE8ArBr40e0rLWkc', NULL, NULL, '-LnmQrW0oBQdkg2D8VAB', NULL, NULL, NULL, '2019-09-02 14:44:47', '2019-09-02 14:46:02', NULL, 3, NULL),
(73, 17, 0, NULL, 'nLsDRmlewCQDaoHw', NULL, NULL, '-LnmRJ6RWvZDKeR5huvM', NULL, NULL, NULL, '2019-09-02 14:46:44', '2019-09-02 14:48:02', NULL, 3, NULL),
(74, 17, 1, '10.00', 'nwzwTLhlA9ZrpCKm', 2, NULL, '-LnmSkUbwvCoKbC7JEws', 'T-bkksub15497541015055102', '2019-09-02 14:53:11', 'RM', '2019-09-02 14:53:02', '2019-09-02 14:53:11', NULL, 1, NULL),
(75, 17, 0, NULL, '91YvcCOE7JXzoDJt', NULL, NULL, '-LnmU_LdTMLigSgdTqi1', NULL, NULL, NULL, '2019-09-02 15:01:01', '2019-09-02 15:02:02', NULL, 3, NULL),
(76, 5, 1, '10.00', 'XrrJCRZysvEiq9ry', 2, NULL, '-LnmaJ-XWSFb6yOSzABJ', 'T-bkksub14810248535298544', '2019-09-02 15:30:40', 'RM', '2019-09-02 15:30:25', '2019-09-02 15:30:40', NULL, 1, NULL),
(77, 5, 0, NULL, 'Gs5Ybm2ZaB3YlLzq', NULL, NULL, '-LnmqWfP1t7NRzExOmU1', NULL, NULL, NULL, '2019-09-02 16:41:15', '2019-09-02 16:43:02', NULL, 3, NULL),
(78, 5, 1, '12.00', '8QzNWK5w3RrG6AtI', 2, NULL, '-LnmqolEQ3pxJM2sY20x', 'T-bkksub14998554854514954', '2019-09-02 16:43:15', 'RM', '2019-09-02 16:42:34', '2019-09-02 16:43:15', NULL, 1, NULL),
(79, 5, 1, '123.00', 'K9YabYo3e63oLpcb', 2, NULL, '-LnmvCftXxMn3RZugxS1', 'T-bkksub15699102531024850', '2019-09-02 17:02:12', 'RM', '2019-09-02 17:01:44', '2019-09-02 17:02:12', NULL, 1, NULL),
(80, 5, 2, '5.00', 'rvbyuTGeU10N9Zby', 2, NULL, '-LnpXEo1bPgK0aepl8hH', 'T-bkksub25257561004853535', '2019-09-03 05:12:21', 'RM', '2019-09-03 05:11:31', '2019-09-03 05:12:21', NULL, 1, NULL),
(81, 5, 1, '123.00', 'uzoz6x7bHAYe1nfo', 2, NULL, '-LnplRmeTezEPe3KQVUF', 'T-bkksub15551489898539956', '2019-09-03 06:18:21', 'RM', '2019-09-03 06:17:56', '2019-09-03 06:18:21', NULL, 1, NULL),
(82, 5, 1, '1.00', 'kQapEaZzXa4nAAFA', 2, NULL, '-Lnplz-aQh74vE66lSde', 'T-bkksub15357525648575054', '2019-09-03 06:20:39', 'RM', '2019-09-03 06:20:16', '2019-09-03 06:20:39', NULL, 1, NULL),
(83, 5, 1, '12.00', 'mZNtWHv0xHj8CgO1', 2, NULL, '-LnpmRlUN1JTzUmZf0LG', 'T-bkksub15757100529997101', '2019-09-03 06:22:50', 'RM', '2019-09-03 06:22:18', '2019-09-03 06:22:50', NULL, 1, NULL),
(84, 5, 2, '123.00', '3bnqmK3ZVvrQWlSS', 2, NULL, '-LnpmqX9NNj8FwvbOnXJ', 'T-bkksub25199505010251529', '2019-09-03 06:24:42', 'RM', '2019-09-03 06:24:04', '2019-09-03 06:24:42', NULL, 1, NULL),
(85, 5, 1, '123.00', '8nk1FSqlLx0HD17X', 2, NULL, '-Lnpn2cyr8Jcvs4fB4Bk', 'T-bkksub15410256102100102', '2019-09-03 06:25:29', 'RM', '2019-09-03 06:24:57', '2019-09-03 06:25:29', NULL, 1, NULL),
(86, 41, 1, '200.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-03 20:47:03', NULL, NULL, 1, NULL),
(87, 41, 2, '50.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-03 20:48:18', NULL, NULL, 1, NULL),
(88, 17, 1, '10.00', 'CMS', 2, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-04 07:16:41', NULL, NULL, 1, NULL),
(89, 29, 0, NULL, 'E5IuIUeUGsoJRIad', NULL, NULL, '-LnwWYp9RZmtgRXpt9Ua', NULL, NULL, NULL, '2019-09-04 13:45:51', '2019-09-04 13:47:01', NULL, 3, NULL),
(90, 29, 0, NULL, 'fbTNYaG9peh0V7DV', NULL, NULL, '-Lnx26Na4WaPzLzZhQRW', NULL, NULL, NULL, '2019-09-04 16:12:28', '2019-09-04 16:14:01', NULL, 3, NULL),
(91, 29, 0, NULL, 'BMhy5tkB4Ehd65uD', NULL, NULL, '-Lnx2Q6iclF5LGNBsAtv', NULL, NULL, NULL, '2019-09-04 16:13:48', '2019-09-04 16:14:50', NULL, 3, NULL),
(92, 29, 1, '100.00', 'CMS', 1, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-04 16:16:19', NULL, NULL, 1, NULL),
(93, 29, 0, NULL, 'KX4BoYfkclrFFCvU', NULL, NULL, '-Lnx3LUM_oiaKmVz7KHp', NULL, NULL, NULL, '2019-09-04 16:17:52', '2019-09-04 16:19:02', NULL, 3, NULL),
(94, 29, 0, NULL, 'bQdddQrvmjhNIC4m', NULL, NULL, '-Lnx4HhLqc3hmWMw-zPn', NULL, NULL, NULL, '2019-09-04 16:21:58', '2019-09-04 16:23:02', NULL, 3, NULL),
(95, 29, 0, NULL, 'qvlr69Diok39qIG0', NULL, NULL, '-Lnx5R1TAKG7GftQNHm7', NULL, NULL, NULL, '2019-09-04 16:26:59', '2019-09-04 16:28:01', NULL, 3, NULL),
(96, 29, 0, NULL, 'aRVLS7gI90KlZuXQ', NULL, NULL, '-LnzXwUYmjcnj1kJ40pe', NULL, NULL, NULL, '2019-09-05 03:50:46', '2019-09-05 03:52:02', NULL, 3, NULL),
(97, 17, 1, '12.00', 'Ps7jWXTIzdJyiol6', 2, NULL, '-LnzgWc4sQdNI-a4YBqg', 'T-bkksub15057100102984897', '2019-09-05 04:32:42', 'RM', '2019-09-05 04:32:37', '2019-09-05 04:32:42', NULL, 1, NULL),
(98, 17, 2, '2.00', 'MKSHOJmB9x46HbqZ', 2, NULL, '-Lnzgcx6_SXxKb5r7SyL', 'T-bkksub25649995652541014', '2019-09-05 04:33:16', 'RM', '2019-09-05 04:33:07', '2019-09-05 04:33:16', NULL, 1, NULL),
(99, 5, 0, NULL, 'Y2SARIXM7OtJAXj0', NULL, NULL, '-LnzizSI8qzx7uwdf7FA', NULL, NULL, NULL, '2019-09-05 04:43:24', '2019-09-05 04:45:02', NULL, 3, NULL),
(100, 5, 1, '12.00', 'HAcflaMBIFUXZlsL', 2, NULL, '-LnzjW_q15YptW5Wtp6_', 'T-bkksub15549575650531024', '2019-09-05 04:45:56', 'RM', '2019-09-05 04:45:44', '2019-09-05 04:45:56', NULL, 1, NULL),
(101, 17, 1, '58.00', 'CMS', 3, NULL, 'CMS', NULL, NULL, 'RM', '2019-09-05 06:21:46', NULL, NULL, 1, NULL),
(102, 29, 0, NULL, 'Mh7mj9pvcgtuxDoE', NULL, NULL, '-Lo-79kop3-JSPT-bk2t', NULL, NULL, NULL, '2019-09-05 06:33:24', '2019-09-05 06:35:02', NULL, 3, NULL),
(103, 29, 1, '100.00', 'z6NgKQLzdnE7MWv4', 2, NULL, '-Lo-7S8p65vikBY9_JcN', 'T-bkksub19757102565451575', '2019-09-05 06:35:06', 'RM', '2019-09-05 06:34:39', '2019-09-05 06:35:06', NULL, 1, NULL),
(104, 29, 2, '12.00', 'rBRjbntvxxyJMbhQ', 2, NULL, '-Lo-7d5J0KvORCZ2fzBK', 'T-bkksub21025155100519948', '2019-09-05 06:36:08', 'RM', '2019-09-05 06:35:28', '2019-09-05 06:36:08', NULL, 1, NULL),
(105, 29, 0, NULL, 'WjTnSKVAmtuSZPnO', NULL, NULL, '-Lo-9wwVbY7iHIaG2iY8', NULL, NULL, NULL, '2019-09-05 06:45:34', '2019-09-05 06:47:02', NULL, 3, NULL),
(106, 29, 0, NULL, 'IbG3a0SZaOdLkQ2A', NULL, NULL, '-Lo-W3iOtgJteMjJFXdc', NULL, NULL, NULL, '2019-09-05 08:22:13', '2019-09-05 08:24:02', NULL, 3, NULL),
(107, 29, 0, NULL, 'ij2z6bfA8nBN8GMZ', NULL, NULL, '-LoEyTNThH8Utk4v39FN', NULL, NULL, NULL, '2019-09-08 08:24:58', '2019-09-08 08:26:01', NULL, 3, NULL),
(108, 29, 0, NULL, 'C9AhevTdnqBqCeOG', NULL, NULL, '-LodW0Y3_Lb4itQsG_ge', NULL, NULL, NULL, '2019-09-13 07:26:26', '2019-09-13 07:28:02', NULL, 3, NULL),
(109, 29, 0, NULL, 'NAIypLWshiu25t3w', NULL, NULL, '-LpCs3M4tSqIDXRQLYYr', NULL, NULL, NULL, '2019-09-20 08:53:26', '2019-09-20 08:55:02', NULL, 3, NULL),
(110, 17, 0, NULL, 'B1SOb8Opg91unm3u', NULL, NULL, '-LpbkHH_tocVap4zoYUB', NULL, NULL, NULL, '2019-09-25 09:29:34', '2019-09-25 09:30:36', NULL, 3, NULL),
(111, 17, 0, NULL, 'iqdiVKsgj0ckrTM8', NULL, NULL, '-LpbkYeBLGAh36PxIHdE', NULL, NULL, NULL, '2019-09-25 09:30:45', '2019-09-25 09:32:02', NULL, 3, NULL),
(112, 17, 0, NULL, 'udWzlHeHXHSrrTKq', NULL, NULL, '-LpfkSsL5xMcr7YgkuOt', NULL, NULL, NULL, '2019-09-26 04:08:50', '2019-09-26 04:10:02', NULL, 3, NULL),
(113, 17, 0, NULL, 'vXGqqprrcVqiI2b6', NULL, NULL, '-Lpfkod-rGQdsSDBEFeW', NULL, NULL, NULL, '2019-09-26 04:10:23', '2019-09-26 04:12:02', NULL, 3, NULL),
(114, 17, 0, NULL, 'G9W68kPKUaFnbKIX', NULL, NULL, '-LpftazMAEcIhWHetAZ1', NULL, NULL, NULL, '2019-09-26 04:48:47', '2019-09-26 04:50:02', NULL, 3, NULL),
(115, 17, 0, NULL, 'Psq67tGSQhQJ9b5L', NULL, NULL, '-LpqeiAxnrEyG4f4d6_L', NULL, NULL, NULL, '2019-09-28 06:59:33', '2019-09-28 07:01:03', NULL, 3, NULL),
(116, 17, 0, NULL, 'uyHYgjQJWnhI3qaV', NULL, NULL, '-Lq4TGl_n3pgH2rzJ1Tl', NULL, NULL, NULL, '2019-10-01 03:59:29', '2019-10-01 04:01:02', NULL, 3, NULL),
(117, 17, 0, NULL, 'rOUAYdH1vnI9nXBy', NULL, NULL, '-Lq9c73IHSLvFqmdbNy2', NULL, NULL, NULL, '2019-10-02 04:00:37', '2019-10-02 04:02:02', NULL, 3, NULL),
(118, 17, 0, NULL, '7mJaHJCBPQobmH39', NULL, NULL, '-LqKhPaRJFdOAAqBgJRu', NULL, NULL, NULL, '2019-10-04 07:39:33', '2019-10-04 07:41:02', NULL, 3, NULL),
(119, 17, 0, NULL, 'iWT9MGIYxWnyUn49', NULL, NULL, '-LqKkI-t2Qh_06WqG2Qb', NULL, NULL, NULL, '2019-10-04 07:52:09', '2019-10-04 07:54:01', NULL, 3, NULL),
(120, 17, 0, NULL, 'ybISNtINEd0uAp7b', NULL, NULL, '-LqqbWstOSSGYbXd07vG', NULL, NULL, NULL, '2019-10-10 17:01:18', '2019-10-10 17:03:01', NULL, 3, NULL),
(121, 17, 0, NULL, 'JVE72JWBhztjtHBQ', NULL, NULL, '-LqqbpCJhAuUUJNjojN4', NULL, NULL, NULL, '2019-10-10 17:02:37', '2019-10-10 17:04:02', NULL, 3, NULL),
(122, 5, 0, NULL, 'n3tJi0R5ON9o930u', NULL, NULL, '-Lqw0xoy1Q6zzlHdH92J', NULL, NULL, NULL, '2019-10-11 18:14:55', '2019-10-11 18:16:02', NULL, 3, NULL),
(123, 51, 0, NULL, 'HNJBuC5K4U7kq9xX', NULL, NULL, '-LqwAONk5BJlBYwgAuKr', NULL, NULL, NULL, '2019-10-11 18:56:07', '2019-10-11 18:58:02', NULL, 3, NULL),
(124, 5, 0, NULL, 'sZovOC9qJa84sYM1', NULL, NULL, '-LqyMy0MmfRRlhRxunQw', NULL, NULL, NULL, '2019-10-12 05:10:17', '2019-10-12 05:12:02', NULL, 3, NULL),
(125, 5, 0, NULL, 'ZJN5JJLGhteZfTMI', NULL, NULL, '-LqyNNos-NCR-rNTCyoO', NULL, NULL, NULL, '2019-10-12 05:12:07', '2019-10-12 05:14:03', NULL, 3, NULL),
(126, 5, 0, NULL, '4FzOQNRIs1tZhlBJ', NULL, NULL, '-LqzJZ_IKghrFw9jxGSQ', NULL, NULL, NULL, '2019-10-12 09:35:04', '2019-10-12 09:37:02', NULL, 3, NULL),
(127, 5, 0, NULL, 'K7qRHsVgckMrqsoh', NULL, NULL, '-LqzJhTuanfILkGcbn1H', NULL, NULL, NULL, '2019-10-12 09:35:40', '2019-10-12 09:37:03', NULL, 3, NULL),
(128, 5, 0, NULL, '3GlWnrgPeODu4SgB', NULL, NULL, '-LqzOSlpf5NRc1bgDSwb', NULL, NULL, NULL, '2019-10-12 09:56:26', '2019-10-12 09:58:02', NULL, 3, NULL),
(129, 5, 0, NULL, 'Q02VrVXfcP5yuacf', NULL, NULL, '-LqzPFYDIUyaBdEV2EoH', NULL, NULL, NULL, '2019-10-12 09:59:54', '2019-10-12 10:01:02', NULL, 3, NULL),
(130, 5, 0, NULL, 'KknpIoNLa4TfihUK', NULL, NULL, '-LqzPb3LtNN6tdRsAj9v', NULL, NULL, NULL, '2019-10-12 10:01:27', '2019-10-12 10:03:03', NULL, 3, NULL),
(131, 5, 0, NULL, 'eH95SaCjbHb46uHI', NULL, NULL, '-LqzQvfGm1fSTN-OC-EN', NULL, NULL, NULL, '2019-10-12 10:07:13', '2019-10-12 10:09:02', NULL, 3, NULL),
(132, 5, 0, NULL, '8G3tb36hXcsEm86x', NULL, NULL, '-LqzR1av6kMcp8Qn6_5a', NULL, NULL, NULL, '2019-10-12 10:07:42', '2019-10-12 10:09:03', NULL, 3, NULL),
(133, 5, 0, NULL, 'gZ59W8jAjc1HpCuO', NULL, NULL, '-LqzUvqiWAf3cGbvFM09', NULL, NULL, NULL, '2019-10-12 10:24:42', '2019-10-12 10:26:02', NULL, 3, NULL),
(134, 5, 0, NULL, 'hPZssodDyCMx743K', NULL, NULL, '-LqzXd9wSu4JWzmzT9U_', NULL, NULL, NULL, '2019-10-12 10:36:32', '2019-10-12 10:38:02', NULL, 3, NULL),
(135, 5, 0, NULL, 'hdDFN2ZOQlVr3OFv', NULL, NULL, '-LqzXo7_Xpyo_6q9zn_F', NULL, NULL, NULL, '2019-10-12 10:37:17', '2019-10-12 10:39:02', NULL, 3, NULL),
(136, 5, 0, NULL, 'fYTpUeQth1rvuBO2', NULL, NULL, '-LqzXslkMtpakRld1516', NULL, NULL, NULL, '2019-10-12 10:37:36', '2019-10-12 10:39:03', NULL, 3, NULL),
(137, 5, 0, NULL, 'fU7FAKDE3eXYfMUf', NULL, NULL, '-Lr-KMp-imfUuksDScvm', NULL, NULL, NULL, '2019-10-12 14:18:11', '2019-10-12 14:20:02', NULL, 3, NULL),
(138, 5, 0, NULL, 'Ar58e5FaYaa6TUZL', NULL, NULL, '-Lr-Kmw4qw1TCfvFAVNA', NULL, NULL, NULL, '2019-10-12 14:20:02', '2019-10-12 14:22:02', NULL, 3, NULL),
(139, 5, 0, NULL, 'YDeluT1rmNN8Zune', NULL, NULL, '-Lr-LrOQz_bfZgStxM3M', NULL, NULL, NULL, '2019-10-12 14:24:42', '2019-10-12 14:26:02', NULL, 3, NULL),
(140, 5, 0, NULL, 'fA7FhgpaCKauIb4E', NULL, NULL, '-Lr-OMtKho2evVNQcPug', NULL, NULL, NULL, '2019-10-12 14:35:40', '2019-10-12 14:37:02', NULL, 3, NULL),
(141, 5, 0, NULL, 'apQoKv30EgSRgiHK', NULL, NULL, '-Lr-OlXkFz543R27Z-7l', NULL, NULL, NULL, '2019-10-12 14:37:25', '2019-10-12 14:39:01', NULL, 3, NULL),
(142, 5, 0, NULL, '4guHed40zmmWpudw', NULL, NULL, '-Lr-PyjMg15vx6L3z8fK', NULL, NULL, NULL, '2019-10-12 14:42:41', '2019-10-12 14:44:02', NULL, 3, NULL),
(143, 5, 0, NULL, '3iYSHn1C9HuIcsrl', NULL, NULL, '-Lr-RKQY_vsA-WFrm-FR', NULL, NULL, NULL, '2019-10-12 14:48:36', '2019-10-12 14:50:02', NULL, 3, NULL),
(144, 5, 0, NULL, 'AFtMUYVQsKWxQWyE', NULL, NULL, '-Lr-Rngy1QyaXxuN6SuX', NULL, NULL, NULL, '2019-10-12 14:50:40', '2019-10-12 14:52:01', NULL, 3, NULL),
(145, 5, 0, NULL, 'xhXOlXGaCYEXD95G', NULL, NULL, '-Lr-SV5tyPBcasi5WCj-', NULL, NULL, NULL, '2019-10-12 14:53:42', '2019-10-12 14:55:02', NULL, 3, NULL),
(146, 5, 0, NULL, 'eISMpmg2FdoVmd1O', NULL, NULL, '-Lr-Sqhs9Gid1SNKp1Ao', NULL, NULL, NULL, '2019-10-12 14:55:14', '2019-10-12 14:57:02', NULL, 3, NULL),
(147, 5, 0, NULL, 'XS5LCtCeBMlEn4pC', NULL, NULL, '-Lr-dJPO5u5PTNl2bhZR', NULL, NULL, NULL, '2019-10-12 15:45:20', '2019-10-12 15:47:02', NULL, 3, NULL),
(148, 17, 1, '12.00', 'DPg0iYl6Wduf0iBs', 2, 1, '-Lr7M4_Um5VsbzP6kFEV', 'T-bkksub15349481029710251', '2019-10-14 03:43:11', 'RM', '2019-10-14 03:42:38', '2019-10-14 03:43:11', NULL, 1, NULL),
(149, 17, 2, '7.50', '4KFsnsV7RjWZSMYa', 2, 1, '-Lr7MlUsNYu6g9mPDnzz', 'T-bkksub25550101995454485', '2019-10-14 03:45:58', 'RM', '2019-10-14 03:45:38', '2019-10-14 03:45:58', NULL, 1, NULL),
(150, 5, 2, '5.00', 'aX9c2gEceYF3y9pN', 2, 1, '-Lr7kvR-dnvs1HNDnAul', 'T-bkksub29910051499797565', '2019-10-14 05:35:33', 'RM', '2019-10-14 05:35:32', '2019-10-14 05:35:33', NULL, 1, NULL),
(151, 5, 2, '5.00', 'Oo7tKTPtNAcUP4Ak', 2, 1, '-Lr7l0_mIWEPD3WkT9d_', 'T-bkksub21015657531029854', '2019-10-14 05:35:58', 'RM', '2019-10-14 05:35:57', '2019-10-14 05:35:58', NULL, 1, NULL),
(152, 5, 2, '5.00', '5QmwVk97LBeFBN0H', 2, 1, '-Lr7lUU4KYqmRsyRblf9', 'T-bkksub29910253505399565', '2019-10-14 05:38:01', 'RM', '2019-10-14 05:38:00', '2019-10-14 05:38:01', NULL, 1, NULL),
(153, 5, 2, '5.00', 'ddjOTwiXvs2z3ITo', 2, 1, '-Lr7mQfA9UT68z5hUeI6', 'T-bkksub29955505350101485', '2019-10-14 05:42:07', 'RM', '2019-10-14 05:42:06', '2019-10-14 05:42:07', NULL, 1, NULL),
(154, 5, 2, '5.00', 'sxgtV8xixxZeNXfz', 2, 1, '-Lr7nALRJqzUEVl9u6Yn', 'T-bkksub25397481011015754', '2019-10-14 05:45:22', 'RM', '2019-10-14 05:45:22', '2019-10-14 05:45:22', NULL, 1, NULL),
(155, 5, 2, '5.00', 'caTd2KFz9COX8D1A', 2, 1, '-Lr7nhhO-q3kGioHqQOl', 'T-bkksub29998565657100985', '2019-10-14 05:47:43', 'RM', '2019-10-14 05:47:42', '2019-10-14 05:47:43', NULL, 1, NULL),
(156, 5, 2, '5.00', 'R0CyOMrsGVS22nWz', 2, 1, '-Lr7o0o1c_31vWe8goZ5', 'T-bkksub21021019898574910', '2019-10-14 05:49:05', 'RM', '2019-10-14 05:49:05', '2019-10-14 05:49:05', NULL, 1, NULL),
(157, 5, 2, '5.00', 'vz2Qnijdmc4L5VNh', 2, 1, '-Lr7pBiL3Zz930U_DwP4', 'T-bkksub25249485010210156', '2019-10-14 05:54:12', 'RM', '2019-10-14 05:54:12', '2019-10-14 05:54:12', NULL, 1, NULL),
(158, 5, 2, '5.00', 'UXa25HeiAKkwZbuU', 2, 1, '-Lr7q8XeqhYXw6_Q8wrs', 'T-bkksub25699555550102974', '2019-10-14 05:58:21', 'RM', '2019-10-14 05:58:21', '2019-10-14 05:58:21', NULL, 1, NULL),
(159, 5, 2, '5.00', 'E6Nf9OUbYv8bD3H2', 2, 1, '-Lr7qZTQrx82OhCO1veA', 'T-bkksub29754495549985753', '2019-10-14 06:00:11', 'RM', '2019-10-14 06:00:11', '2019-10-14 06:00:11', NULL, 1, NULL),
(160, 5, 2, '5.00', 'kj9UVY8q0XFXPcGQ', 2, 1, '-Lr7ryRGcz0igBeWZ1G_', 'T-bkksub25256505110249549', '2019-10-14 06:06:20', 'RM', '2019-10-14 06:06:19', '2019-10-14 06:06:20', NULL, 1, NULL),
(161, 5, 2, '5.00', '8cG69M5omAVVcm93', 2, 1, '-Lr7sCJSdT_MYrhNZebm', 'T-bkksub25548489897994849', '2019-10-14 06:07:21', 'RM', '2019-10-14 06:07:20', '2019-10-14 06:07:21', NULL, 1, NULL),
(162, 5, 2, '5.00', '0XW34heLobAJeoBl', 2, 1, '-Lr7tQpJD7V6rie6B7s3', 'T-bkksub25754485599499750', '2019-10-14 06:12:43', 'RM', '2019-10-14 06:12:42', '2019-10-14 06:12:43', NULL, 1, NULL),
(163, 5, 2, '5.00', 'z3fUHKUgO0McbTGW', 2, 1, '-Lr7tYy8nIg3dn4uNopN', 'T-bkksub21025410056495054', '2019-10-14 06:13:16', 'RM', '2019-10-14 06:13:15', '2019-10-14 06:13:16', NULL, 1, NULL),
(164, 5, 2, '5.00', 'TOyg9su1fy8c9QfH', 2, 1, '-Lr7ucCW4f7qJYbGRkYR', 'T-bkksub25048100525056101', '2019-10-14 06:17:55', 'RM', '2019-10-14 06:17:55', '2019-10-14 06:17:55', NULL, 1, NULL),
(165, 5, 2, '5.00', 'Tzt0Imv0OPy1hsIK', 2, 1, '-Lr7vwrZgemXWdaP7rTO', 'T-bkksub25153564998531024', '2019-10-14 06:23:42', 'RM', '2019-10-14 06:23:42', '2019-10-14 06:23:42', NULL, 1, NULL),
(166, 5, 2, '5.00', '4Netx7jqTPoTVy7T', 2, 1, '-Lr7w0ckuzqRSfQnt3NZ', 'T-bkksub25257565257971011', '2019-10-14 06:24:02', 'RM', '2019-10-14 06:24:01', '2019-10-14 06:24:02', NULL, 1, NULL),
(167, 5, 2, '5.00', 'oY6aUJELo5p0tNfs', 2, 1, '-Lr7w31KmJyYXXLOgGMP', 'T-bkksub29797101481015010', '2019-10-14 06:24:11', 'RM', '2019-10-14 06:24:11', '2019-10-14 06:24:11', NULL, 1, NULL),
(168, 5, 2, '5.00', 'WA4oBkVjvw5Mt4Ur', 2, 1, '-Lr7w9AkxUXOtBSHvzWu', 'T-bkksub24849515598565755', '2019-10-14 06:24:37', 'RM', '2019-10-14 06:24:36', '2019-10-14 06:24:37', NULL, 1, NULL),
(169, 5, 2, '5.00', '9XEWFRp2TMjc4upt', 2, 1, '-Lr7whCy1pkm5lVVNl4K', 'T-bkksub25610298495654524', '2019-10-14 06:27:00', 'RM', '2019-10-14 06:27:00', '2019-10-14 06:27:00', NULL, 1, NULL),
(170, 5, 2, '5.00', 'TTY7sV7m2EYUX0y1', 2, 1, '-Lr7wpDE54glcc4DXKX3', 'T-bkksub21005156565697575', '2019-10-14 06:27:33', 'RM', '2019-10-14 06:27:32', '2019-10-14 06:27:33', NULL, 1, NULL),
(171, 5, 2, '5.00', 'v7Ji7a1wYCZwIi8T', 2, 1, '-Lr7yUB-P5e7j_tf_RLn', 'T-bkksub25654539954102985', '2019-10-14 06:34:47', 'RM', '2019-10-14 06:34:46', '2019-10-14 06:34:47', NULL, 1, NULL),
(172, 5, 2, '5.00', 'm3NzIXpjMFFDd2W1', 2, 1, '-Lr7zY-UajTyBp_1PYSc', 'T-bkksub21021024856549752', '2019-10-14 06:39:25', 'RM', '2019-10-14 06:39:24', '2019-10-14 06:39:25', NULL, 1, NULL),
(173, 5, 0, NULL, 'iCqKe4ZQHpCIjKkB', NULL, NULL, '-LrHzkBVezM1zTomGdso', NULL, NULL, NULL, '2019-10-16 05:16:30', '2019-10-16 05:17:32', NULL, 3, NULL),
(174, 5, 0, NULL, 'FxgzeGojHyRUMniW', NULL, NULL, '-LrI29erIrq3oevBZbHR', NULL, NULL, NULL, '2019-10-16 05:31:25', '2019-10-16 05:33:01', NULL, 3, NULL),
(175, 5, 0, NULL, 'iNzdSHRUGz6ORfFI', NULL, NULL, '-LrI2DNApLD_SHECANNM', NULL, NULL, NULL, '2019-10-16 05:31:41', '2019-10-16 05:33:02', NULL, 3, NULL),
(176, 5, 0, NULL, '3CDTq5qHfiyJRSMr', NULL, NULL, '-LrI2EFt5_mfZP93sLnu', NULL, NULL, NULL, '2019-10-16 05:31:44', '2019-10-16 05:33:03', NULL, 3, NULL),
(177, 5, 0, NULL, 'hkr7bC0QjVKZKmUf', NULL, NULL, '-LrJ7PoGwBsKTh51KuKN', NULL, NULL, NULL, '2019-10-16 10:33:59', '2019-10-16 10:35:00', NULL, 3, NULL),
(178, 52, 0, NULL, '1CAWOOMZUqjqnEW5', NULL, NULL, '-LrJDdfrtwqESiJTcok0', NULL, NULL, NULL, '2019-10-16 11:01:13', '2019-10-16 11:02:14', NULL, 3, NULL),
(179, 5, 0, NULL, 'pSj9YjYnx2lZvbmJ', NULL, NULL, '-LrND8twQ3CstawsoD76', NULL, NULL, NULL, '2019-10-17 05:37:32', '2019-10-17 05:38:33', NULL, 3, NULL),
(180, 5, 0, NULL, 'YbFCsJUfx8wR9VWB', NULL, NULL, '-LrNDQaSeM9DHLBOslzV', NULL, NULL, NULL, '2019-10-17 05:38:44', '2019-10-17 05:39:45', NULL, 3, NULL),
(181, 5, 0, NULL, 'mK9HzWr3vMfalY8y', NULL, NULL, '-LrNE37ql4efA7abzho_', NULL, NULL, NULL, '2019-10-17 05:41:30', '2019-10-17 05:43:02', NULL, 3, NULL),
(182, 17, 0, NULL, 'sjyfzWeIwDE8Ukgh', NULL, NULL, '-LrXdnTR40qVg3nhJoGk', NULL, NULL, NULL, '2019-10-19 06:14:32', '2019-10-19 06:16:02', NULL, 3, NULL),
(183, 17, 0, NULL, 'o09PVgx5T657J9Z7', NULL, NULL, '-LrnK9lXP7iGpZMtA1ap', NULL, NULL, NULL, '2019-10-22 11:57:55', '2019-10-22 11:59:02', NULL, 3, NULL),
(184, 17, 0, NULL, 'Jj7j9kwjcvxjv5AL', NULL, NULL, '-LrnLbrS4FtT2nGE_BGB', NULL, NULL, NULL, '2019-10-22 12:04:17', '2019-10-22 12:06:02', NULL, 3, NULL),
(185, 29, 0, NULL, 'Bcvn07DtA5MBW7lk', NULL, NULL, '-Lrpan326WXV8ivTSvhT', NULL, NULL, NULL, '2019-10-22 22:34:11', '2019-10-22 22:36:02', NULL, 3, NULL),
(186, 17, 0, NULL, 'wNJKvYewP5720jGu', NULL, NULL, '-LrpbIQYtFvtmQiwsiYv', NULL, NULL, NULL, '2019-10-22 22:36:24', '2019-10-22 22:38:02', NULL, 3, NULL),
(187, 17, 0, NULL, 'uGzb8CanyzYDerT4', NULL, NULL, '-Lrq9Dv_m7LMoQbFwE9w', NULL, NULL, NULL, '2019-10-23 01:09:00', '2019-10-23 01:10:02', NULL, 3, NULL),
(188, 17, 0, NULL, 'B92r0drkFbQZxeBx', NULL, NULL, '-LrqF-hHrZ2g0ckloCht', NULL, NULL, NULL, '2019-10-23 01:34:15', '2019-10-23 01:36:01', NULL, 3, NULL),
(189, 17, 0, NULL, '111IxFxlw7rPeQFe', NULL, NULL, '-LrrNSA99-Py764nS5h_', NULL, NULL, NULL, '2019-10-23 06:50:46', '2019-10-23 06:52:02', NULL, 3, NULL),
(190, 17, 0, NULL, '0P8X6JkbGlW8Udxa', NULL, NULL, '-LrwCLpnH5_-gN0F6V0v', NULL, NULL, NULL, '2019-10-24 05:20:22', '2019-10-24 05:22:02', NULL, 3, NULL),
(191, 17, 0, NULL, 'oD9LROyB53vL0ObR', NULL, NULL, '-LrwD0txkJ5_ma9W5phd', NULL, NULL, NULL, '2019-10-24 05:23:19', '2019-10-24 05:25:02', NULL, 3, NULL),
(192, 17, 0, NULL, 'HnsYDay2yTPOjAVU', NULL, NULL, '-LrwDT6alWB-1ukCfsrv', NULL, NULL, NULL, '2019-10-24 05:25:14', '2019-10-24 05:27:03', NULL, 3, NULL),
(193, 17, 0, NULL, 'P3vkWkoAxMei0yqx', NULL, NULL, '-LrwGXguhnrbVJ0dXppI', NULL, NULL, NULL, '2019-10-24 05:38:40', '2019-10-24 05:40:02', NULL, 3, NULL),
(194, 17, 0, NULL, 'mq6s2lQ8TaVQSX7n', NULL, NULL, '-LrwGn0mSyrUQJn_ri3N', NULL, NULL, NULL, '2019-10-24 05:39:46', '2019-10-24 05:41:02', NULL, 3, NULL),
(195, 17, 0, NULL, 'N6NhgFan9LE2iMaj', NULL, NULL, '-LsAvjrBzrXUU4gPZoNC', NULL, NULL, NULL, '2019-10-27 06:37:22', '2019-10-27 06:39:02', NULL, 3, NULL),
(196, 73, 0, NULL, 'JOGXroGwdJkqxUwF', NULL, NULL, '-LsNFf-iJl0EQUxQ3nCA', NULL, NULL, NULL, '2019-10-29 16:04:14', '2019-10-29 16:06:02', NULL, 3, NULL),
(197, 73, 0, NULL, 'JGjj0mROf3RysS2M', NULL, NULL, '-LsNFj-lyA9WHTFmtxub', NULL, NULL, NULL, '2019-10-29 16:04:30', '2019-10-29 16:06:03', NULL, 3, NULL),
(198, 73, 0, NULL, 'bjjiqWtoatYCWVgJ', NULL, NULL, '-LsNFr3N6vhDBfnUiU8M', NULL, NULL, NULL, '2019-10-29 16:05:03', '2019-10-29 16:06:04', NULL, 3, NULL),
(199, 74, 1, '5.00', 'WKaVs2XP1g4R3XCo', 2, 1, '-LsNGraxZ86P_vkECdx8', 'T-bkksub15698102509749565', '2019-10-29 16:10:00', 'RM', '2019-10-29 16:09:27', '2019-10-29 16:10:00', NULL, 1, NULL),
(200, 74, 2, '2.00', '080xTeSIFpFddbTA', 2, 1, '-LsNH27nT_zsXlCCrJqA', 'T-bkksub25357561005110155', '2019-10-29 16:10:18', 'RM', '2019-10-29 16:10:15', '2019-10-29 16:10:18', NULL, 1, NULL),
(201, 73, 1, '5.00', '2Jw9gB386fjCRvJb', 2, 1, '-LsNJMy4uOxxaoOFCXuE', 'T-bkksub15054985457579952', '2019-10-29 16:20:52', 'RM', '2019-10-29 16:20:24', '2019-10-29 16:20:52', NULL, 1, NULL),
(202, 73, 1, '10.00', 'CPEG17oJGYHiDGZ1', 2, 1, '-LsNJc0FMclHxabwFH0U', 'T-bkksub15156485148989955', '2019-10-29 16:21:37', 'RM', '2019-10-29 16:21:30', '2019-10-29 16:21:37', NULL, 1, NULL),
(203, 73, 2, '10.00', 'kSyRsufxn8Y9sm7R', 2, 1, '-LsNJjNEXMgBXe8jP5Ax', 'T-bkksub25650100524848102', '2019-10-29 16:22:07', 'RM', '2019-10-29 16:22:00', '2019-10-29 16:22:07', NULL, 1, NULL),
(204, 73, 1, '5.00', 'UF1K1IOIf6a5cJgs', 2, 1, '-LsNLTQawkldpPQophwx', 'T-bkksub11019957975548569', '2019-10-29 16:30:27', 'RM', '2019-10-29 16:29:35', '2019-10-29 16:30:27', NULL, 1, NULL),
(205, 73, 0, NULL, '1Qrs3dUVXgR5RsKi', NULL, NULL, '-LsNMAh_7JiKLZLRmKOu', NULL, NULL, NULL, '2019-10-29 16:32:40', '2019-10-29 16:34:02', NULL, 3, NULL),
(206, 73, 0, NULL, 'QczaQSGwsWQO6qlD', NULL, NULL, '-LsNMGKNaRzZqrKemPC3', NULL, NULL, NULL, '2019-10-29 16:33:03', '2019-10-29 16:35:02', NULL, 3, NULL),
(207, 73, 1, '2.00', 'lFyy7lRXxWvinPTn', 2, 1, '-LsNNsdcApqHzCLGCQ55', 'T-bkksub15151544957535410', '2019-10-29 16:40:19', 'RM', '2019-10-29 16:40:07', '2019-10-29 16:40:19', NULL, 1, NULL),
(208, 73, 0, NULL, 'RZZuon5Jyto6EZkM', NULL, NULL, '-LsNOjIGz6-z9oiK1qad', NULL, NULL, NULL, '2019-10-29 16:43:50', '2019-10-29 16:45:02', NULL, 3, NULL),
(209, 73, 0, NULL, 'VLHnWksCagfY99Gf', NULL, NULL, '-LsNOlU58x7ZeQ7QkyFp', NULL, NULL, NULL, '2019-10-29 16:43:59', '2019-10-29 16:45:03', NULL, 3, NULL),
(210, 73, 0, NULL, 'nt0sxY9TEnlIxuVf', NULL, NULL, '-LsNOn6jI2VZi0SYm43_', NULL, NULL, NULL, '2019-10-29 16:44:06', '2019-10-29 16:46:02', NULL, 3, NULL),
(211, 17, 0, NULL, 'vT34e3BMESFyaELA', NULL, NULL, '-LsOhb98tsal1Qo90w9L', NULL, NULL, NULL, '2019-10-29 22:50:17', '2019-10-29 22:52:02', NULL, 3, NULL),
(212, 76, 0, NULL, 'BGBnCRABtyDAHBlr', NULL, NULL, '-LsOwGGfdDDtlEher9A1', NULL, NULL, NULL, '2019-10-29 23:54:20', '2019-10-29 23:55:21', NULL, 3, NULL),
(213, 76, 0, NULL, 'G35eJcinUABz6kUI', NULL, NULL, '-LsOxR3IjA0bU1RE2zoR', NULL, NULL, NULL, '2019-10-29 23:59:26', '2019-10-30 00:01:02', NULL, 3, NULL),
(214, 17, 1, '50.00', '0DFay6xrRsRnJcQs', 2, 1, '-LsOy56Flf3uXXDRDHPq', 'T-bkksub15752515657495354', '2019-10-30 00:02:26', 'RM', '2019-10-30 00:02:18', '2019-10-30 00:02:26', NULL, 1, NULL),
(215, 17, 2, '100.00', 'nM8J14jwDT5L89bS', 2, 1, '-LsOyBWGHTs0Rm4KA1Ky', 'T-bkksub24849984910210056', '2019-10-30 00:02:53', 'RM', '2019-10-30 00:02:45', '2019-10-30 00:02:53', NULL, 1, NULL),
(216, 76, 0, NULL, 'UIT0nBdr49BCDOxp', NULL, NULL, '-LsQuJ--JQR-tVWSaTjO', NULL, NULL, NULL, '2019-10-30 09:05:01', '2019-10-30 09:06:02', NULL, 3, NULL),
(217, 76, 0, NULL, 'CFUWcmgAfFdGCPkO', NULL, NULL, '-LsQumGviqFqWi8LcTrv', NULL, NULL, NULL, '2019-10-30 09:07:05', '2019-10-30 09:09:02', NULL, 3, NULL),
(218, 76, 1, '100.00', 'dKrX3FY9jGmaGa9Z', 2, 1, '-LsQv530Dpq5Aq-1diIi', 'T-bkksub15610257499797102', '2019-10-30 09:09:00', 'RM', '2019-10-30 09:08:26', '2019-10-30 09:09:00', NULL, 1, NULL),
(219, 76, 1, '50.00', 'dzEpijlCZfQGQXAy', 2, 1, '-LsR4M65yKiomkzMPtjL', 'T-bkksub15299995010053100', '2019-10-30 09:53:24', 'RM', '2019-10-30 09:53:17', '2019-10-30 09:53:24', NULL, 1, NULL),
(220, 76, 2, '100.00', 'Pabfyr2QxPkUc6G3', 2, 1, '-LsR4S8uJtRwVDTR-uaZ', 'T-bkksub29754525256549850', '2019-10-30 09:53:43', 'RM', '2019-10-30 09:53:42', '2019-10-30 09:53:43', NULL, 1, NULL),
(221, 5, 0, NULL, 'uVdfjNwfKJqlDVBi', NULL, NULL, '-LsVFd-eaI0RM-xJ9Ziy', NULL, NULL, NULL, '2019-10-31 05:21:03', '2019-10-31 05:23:03', NULL, 3, NULL),
(222, 5, 0, NULL, 'dEM7baqD6lwWJ71v', NULL, NULL, '-LsVFefKb_z4659Plf7k', NULL, NULL, NULL, '2019-10-31 05:21:10', '2019-10-31 05:23:04', NULL, 3, NULL),
(223, 17, 0, NULL, 'Ee4ow7c4Fb8qrfLx', NULL, NULL, '-LsVdiNv6HEG0F6NeH89', NULL, NULL, NULL, '2019-10-31 07:10:39', '2019-10-31 07:12:02', NULL, 3, NULL),
(224, 17, 0, NULL, 'K4RSCTHPq8rvStqV', NULL, NULL, '-LsVe0-APfbNHhtL3Bw3', NULL, NULL, NULL, '2019-10-31 07:11:55', '2019-10-31 07:13:03', NULL, 3, NULL),
(225, 73, 0, NULL, 'IzrLhCnCYqXVAhOU', NULL, NULL, '-Lskda5KeSl5qDuVvMWn', NULL, NULL, NULL, '2019-11-03 09:44:00', '2019-11-03 09:45:02', NULL, 3, NULL),
(226, 73, 0, NULL, 'DMPbO3ZPnknzGWmt', NULL, NULL, '-LskdfAhiLvrdlXbmjjl', NULL, NULL, NULL, '2019-11-03 09:44:21', '2019-11-03 09:46:02', NULL, 3, NULL),
(227, 73, 0, NULL, 'dWKKnfU5OK5Zhg16', NULL, NULL, '-LskdwTFF0q48bD1C1hx', NULL, NULL, NULL, '2019-11-03 09:45:32', '2019-11-03 09:47:02', NULL, 3, NULL),
(228, 17, 0, NULL, 'F2JG3LyhjYI3LdN9', NULL, NULL, '-LsoK48UVyKqlAOWPdOr', NULL, NULL, NULL, '2019-11-04 02:52:51', '2019-11-04 02:54:02', NULL, 3, NULL),
(229, 17, 0, NULL, '5jEGaQrI20DFNDIo', NULL, NULL, '-LsoKgX9R1o7qs5ZUaol', NULL, NULL, NULL, '2019-11-04 02:55:33', '2019-11-04 02:57:02', NULL, 3, NULL),
(230, 76, 0, NULL, 'hjzYhs5zE9XjP927', NULL, NULL, '-LsoWL_OLEpew783MMGf', NULL, NULL, NULL, '2019-11-04 03:46:28', '2019-11-04 03:48:02', NULL, 3, NULL),
(231, 76, 0, NULL, 'IgswgoummjC3CbvW', NULL, NULL, '-LsoWgggSfuwbQZSoaG2', NULL, NULL, NULL, '2019-11-04 03:47:59', '2019-11-04 03:49:02', NULL, 3, NULL),
(232, 76, 0, NULL, '3o5Ct9EQVfytt7Ds', NULL, NULL, '-LstlMlk14c4M0Vc46i-', NULL, NULL, NULL, '2019-11-05 04:14:34', '2019-11-05 04:16:02', NULL, 3, NULL),
(233, 17, 0, NULL, 'kDABahDqe2evXmWD', NULL, NULL, '-LsuBTa1pkXTsLpX0U_d', NULL, NULL, NULL, '2019-11-05 06:12:59', '2019-11-05 06:14:02', NULL, 3, NULL),
(234, 76, 0, NULL, 'zxEzeWmOVkFqJ7Ns', NULL, NULL, '-LszsRWiEB32qMVWL9Zn', NULL, NULL, NULL, '2019-11-06 08:43:11', '2019-11-06 08:45:01', NULL, 3, NULL),
(235, 76, 0, NULL, 'P8meLI0T1IoCxOMJ', NULL, NULL, '-Lt9I2YuxBf5gAduNC-U', NULL, NULL, NULL, '2019-11-08 09:15:39', '2019-11-08 09:17:02', NULL, 3, NULL),
(236, 17, 1, '12.00', '6dRouRiIJ6Vezvoe', 2, 1, '-LtPwZb4CnsxvnUeIf8I', 'T-bkksub11001011024810210', '2019-11-11 14:51:16', 'RM', '2019-11-11 14:50:58', '2019-11-11 14:51:16', NULL, 1, NULL),
(237, 17, 0, NULL, 'Hd3SKgjMNVvdxzV0', NULL, NULL, '-LtPwkZZ_KLAeDrcQBs8', NULL, NULL, NULL, '2019-11-11 14:51:47', '2019-11-11 14:53:02', NULL, 3, NULL),
(238, 17, 0, NULL, 'lwffflBPFsEiagVC', NULL, NULL, '-LtPyAtLepPfliwr-J7T', NULL, NULL, NULL, '2019-11-11 14:58:01', '2019-11-11 14:59:02', NULL, 3, NULL),
(239, 17, 0, NULL, 'A77UlrrUMpYmsbE2', NULL, NULL, '-LtYbuNQbioxC0NNq2HE', NULL, NULL, NULL, '2019-11-13 07:17:17', '2019-11-13 07:19:03', NULL, 3, NULL),
(240, 76, 0, NULL, 'pCX4PdAnpSU0GSpe', NULL, NULL, '-LtZ1-SZ6Rtn4Z2fONJZ', NULL, NULL, NULL, '2019-11-13 09:11:18', '2019-11-13 09:13:02', NULL, 3, NULL),
(241, 73, 0, NULL, 'Qo1Y0lIID0aMNxLv', NULL, NULL, '-LtZyJn7dnnE1Zbp2Yx0', NULL, NULL, NULL, '2019-11-13 13:34:50', '2019-11-13 13:36:07', NULL, 3, NULL),
(242, 73, 1, '200.00', 'KEH2RDn77D73bWru', 2, 1, '-Lt_0O9u04ltYbm-qMRV', 'T-bkksub11029710052525251', '2019-11-13 13:48:28', 'RM', '2019-11-13 13:48:14', '2019-11-13 13:48:28', NULL, 1, NULL),
(243, 77, 0, NULL, 'MWjWbymEpqpWIgrs', NULL, NULL, '-LtcboR5DAOhFID2xOZS', NULL, NULL, NULL, '2019-11-14 06:34:59', '2019-11-14 06:36:02', NULL, 3, NULL),
(244, 77, 0, NULL, 'UPejr6y0d5cbIAmY', NULL, NULL, '-Ltcd7WS9JsF35-o0pqy', NULL, NULL, NULL, '2019-11-14 06:40:43', '2019-11-14 06:42:01', NULL, 3, NULL),
(245, 77, 0, NULL, 'vwZO2rFIfhgU3Z8F', NULL, NULL, '-LtdIYgqsFsSRG2Nvo7D', NULL, NULL, NULL, '2019-11-14 09:46:05', '2019-11-14 09:48:02', NULL, 3, NULL),
(246, 73, 3, NULL, 'YENU33D0uRcFP9cN', NULL, NULL, '-LttcqNsz_jde55gyhsw', NULL, NULL, NULL, '2019-11-17 13:53:02', '2019-11-17 13:55:02', NULL, 3, NULL),
(247, 73, 3, '0.00', 'mtpTSWJmkjUJZVt2', 2, 1, '-LttdpOAS05vt1NBj2Pu', 'U-bkksub25310057531005557', '2019-11-17 13:57:32', 'RM', '2019-11-17 13:57:20', '2019-11-17 13:57:32', NULL, 1, NULL),
(248, 5, 3, '0.00', 'GKABX21n5Swx2G6y', 2, 1, '-LtwKuk9xgJaLIZg9qo8', 'U-bkksub24910010210249505', '2019-11-18 02:29:27', 'RM', '2019-11-18 02:29:10', '2019-11-18 02:29:27', NULL, 1, NULL),
(249, 77, 0, NULL, 'F9xvinoK8IZVRRDB', NULL, NULL, '-Lu6cwpCH-zX6sowC3Ym', NULL, NULL, NULL, '2019-11-20 07:08:09', '2019-11-20 07:10:02', NULL, 3, NULL),
(250, 77, 0, NULL, 'T5r9mJzaoqBSxQPR', NULL, NULL, '-LuB78afSxPW1q_C_NNd', NULL, NULL, NULL, '2019-11-21 04:02:57', '2019-11-21 04:04:03', NULL, 3, NULL),
(251, 77, 0, NULL, 'eyUjRw7Mc131uhGr', NULL, NULL, '-LuBoelActVxiUkTdcaG', NULL, NULL, NULL, '2019-11-21 07:17:27', '2019-11-21 07:19:02', NULL, 3, NULL),
(252, 77, 0, NULL, '4JdtjmioZJRAnTMe', NULL, NULL, '-LuGu6Pgaky1MaTDdXB3', NULL, NULL, NULL, '2019-11-22 06:59:21', '2019-11-22 07:00:23', NULL, 3, NULL),
(253, 73, 0, NULL, 'RJ2rllepS5oFwLq2', NULL, NULL, '-LuTWwSyHy7GWavrUtP3', NULL, NULL, NULL, '2019-11-24 17:48:48', '2019-11-24 17:49:56', NULL, 3, NULL),
(254, 73, 1, '50.00', 'q5ZdKTXmDsHQhSwo', 2, 1, '-LuTXDrMeqPYXCCyoHmT', 'T-bkksub19752495656100995', '2019-11-24 17:50:15', 'RM', '2019-11-24 17:50:04', '2019-11-24 17:50:15', NULL, 1, NULL),
(255, 73, 2, '80.00', 'FHbJ2OVhfb0iuoth', 2, 1, '-LuTZ8MOQQOgGVePTZYl', 'T-bkksub29810010210110299', '2019-11-24 17:58:34', 'RM', '2019-11-24 17:58:26', '2019-11-24 17:58:34', NULL, 1, NULL),
(256, 73, 0, NULL, 'YAYVXswonqu0Kp2l', NULL, NULL, '-LuT_Gdk9rAvL8ILagL1', NULL, NULL, NULL, '2019-11-24 18:03:22', '2019-11-24 18:05:02', NULL, 3, NULL),
(257, 73, 3, '0.00', 'At4C9C6loVeQsGHQ', 2, 1, '-LuT_cc1Fw_Nu8cCJgWG', 'U-bkksub25310197989848981', '2019-11-24 18:05:06', 'RM', '2019-11-24 18:04:56', '2019-11-24 18:05:06', NULL, 1, NULL),
(258, 77, 0, NULL, 'PQfNCBOeGyIHBkWD', NULL, NULL, '-LuVhQoXaVSzhgl7Wour', NULL, NULL, NULL, '2019-11-25 03:58:15', '2019-11-25 04:00:02', NULL, 3, NULL),
(259, 77, 0, NULL, 'cU7AqpiXHhK6AGTI', NULL, NULL, '-Luf7N1k599MLuopg6u-', NULL, NULL, NULL, '2019-11-27 04:32:09', '2019-11-27 04:34:02', NULL, 3, NULL),
(260, 77, 0, NULL, 'iP7K4TizoSlIomZK', NULL, NULL, '-Luf8OIKQzc7VbYGhcOe', NULL, NULL, NULL, '2019-11-27 04:36:37', '2019-11-27 04:38:02', NULL, 3, NULL),
(261, 5, 0, NULL, 'QaNpOKW5Uv39sq7R', NULL, NULL, '-LuhJcGViXVxeKBYid9n', NULL, NULL, NULL, '2019-11-27 14:44:56', '2019-11-27 14:46:02', NULL, 3, NULL),
(262, 5, 0, NULL, 'fYnoju87YXzrwbOb', NULL, NULL, '-LuhJvFgQ8tpiz7zszIW', NULL, NULL, NULL, '2019-11-27 14:46:14', '2019-11-27 14:48:02', NULL, 3, NULL),
(263, 5, 0, NULL, 'UhTWYEcIUIdzcC9s', NULL, NULL, '-LuhLDnPBrfBXJk0K5MI', NULL, NULL, NULL, '2019-11-27 14:51:56', '2019-11-27 14:52:58', NULL, 3, NULL),
(264, 5, 0, NULL, '4IhJOIHg9z3jHMO7', NULL, NULL, '-LuhMe_6mCNfNte2kK9P', NULL, NULL, NULL, '2019-11-27 14:58:12', '2019-11-27 14:59:13', NULL, 3, NULL),
(265, 5, 0, NULL, 'QblKaaPEF9pQGnYn', NULL, NULL, '-LuhMyqvGXdXqDUyolms', NULL, NULL, NULL, '2019-11-27 14:59:35', '2019-11-27 15:01:02', NULL, 3, NULL),
(266, 5, 0, NULL, 'VDo6MV6jDuvNDfSt', NULL, NULL, '-Luhm1CySg0ooHfHb5cG', NULL, NULL, NULL, '2019-11-27 16:53:25', '2019-11-27 16:55:02', NULL, 3, NULL),
(267, 5, 0, NULL, 'Kj93q7NefUnHSyOr', NULL, NULL, '-LuhmjLxH7l8pr72Xkng', NULL, NULL, NULL, '2019-11-27 16:56:29', '2019-11-27 16:58:01', NULL, 3, NULL),
(268, 5, 0, NULL, '4rd1zCeSnLq4XmAH', NULL, NULL, '-Luhn1mjx6j__hCMNUbo', NULL, NULL, NULL, '2019-11-27 16:57:49', '2019-11-27 16:59:01', NULL, 3, NULL),
(269, 5, 0, NULL, 'Ug61xC7wJGh1UuZS', NULL, NULL, '-LuhnPbF0h1gngFaIPqS', NULL, NULL, NULL, '2019-11-27 16:59:27', '2019-11-27 17:00:30', NULL, 3, NULL),
(270, 5, 0, NULL, 'E5T2mA00tWCQuVh4', NULL, NULL, '-LuhnlJbfqOvJnX8No16', NULL, NULL, NULL, '2019-11-27 17:01:00', '2019-11-27 17:02:02', NULL, 3, NULL),
(271, 5, 0, NULL, '8Ff5Z939NGXS2VoV', NULL, NULL, '-LuhoQsDx4Jj1w-Vd-WZ', NULL, NULL, NULL, '2019-11-27 17:03:54', '2019-11-27 17:05:02', NULL, 3, NULL),
(272, 5, 0, NULL, 'UreTADrO4VLjpUrc', NULL, NULL, '-Luhq-LRu3TlfyjzSA39', NULL, NULL, NULL, '2019-11-27 17:10:45', '2019-11-27 17:12:02', NULL, 3, NULL),
(273, 5, 0, NULL, 'PyJJtmBbkqduCE0O', NULL, NULL, '-LuhqByCMVT41JDUzrjJ', NULL, NULL, NULL, '2019-11-27 17:11:37', '2019-11-27 17:13:01', NULL, 3, NULL),
(274, 5, 0, NULL, 'eLiQlvKmhmnDUs3k', NULL, NULL, '-LuhqQDsBroYv5plC_iY', NULL, NULL, NULL, '2019-11-27 17:12:36', '2019-11-27 17:14:02', NULL, 3, NULL),
(275, 5, 0, NULL, 'YJJLz7oM5EvFlL35', NULL, NULL, '-LuhqUcnxSf0jXO3paQh', NULL, NULL, NULL, '2019-11-27 17:12:54', '2019-11-27 17:14:02', NULL, 3, NULL),
(276, 5, 0, NULL, 'mHs3hu3GFZ0UhVxp', NULL, NULL, '-Luhqk141VCX1tdlvyo6', NULL, NULL, NULL, '2019-11-27 17:14:01', '2019-11-27 17:15:02', NULL, 3, NULL),
(277, 5, 0, NULL, 'MaCgo5TjsBXNRhvj', NULL, NULL, '-LuhtlI7lD_tOPq94Xvg', NULL, NULL, NULL, '2019-11-27 17:27:12', '2019-11-27 17:29:02', NULL, 3, NULL),
(278, 5, 0, NULL, '8MG5ZG54nNoqp5F5', NULL, NULL, '-Luhv4UzDGBp1RRprEJx', NULL, NULL, NULL, '2019-11-27 17:32:57', '2019-11-27 17:34:02', NULL, 3, NULL),
(279, 5, 0, NULL, 'L6cwGgKd3i5j7AGw', NULL, NULL, '-LujqERix3wSW5AkeJ8n', NULL, NULL, NULL, '2019-11-28 02:31:02', '2019-11-28 02:33:01', NULL, 3, NULL),
(280, 5, 0, NULL, 'xctJCPmBn5Js6ynP', NULL, NULL, '-LujqdBVvKkCY1ybz4J1', NULL, NULL, NULL, '2019-11-28 02:32:47', '2019-11-28 02:33:49', NULL, 3, NULL),
(281, 5, 0, NULL, 'EVLx4Oz74AorBJBR', NULL, NULL, '-LujqyQzJodPYuOdTya8', NULL, NULL, NULL, '2019-11-28 02:34:14', '2019-11-28 02:36:01', NULL, 3, NULL),
(282, 5, 0, NULL, 'ztYiB5PahQrZOliF', NULL, NULL, '-LulyYkYCANPg65zNCqg', NULL, NULL, NULL, '2019-11-28 12:26:37', '2019-11-28 12:27:44', NULL, 3, NULL),
(283, 77, 0, NULL, 'xT2dDyJg63Jcyufd', NULL, NULL, '-LumxGhJNibIXpfy41fV', NULL, NULL, NULL, '2019-11-28 17:00:38', '2019-11-28 17:02:02', NULL, 3, NULL),
(284, 5, 0, NULL, 'l4benXiC7MgHmVkL', NULL, NULL, '-LuulvGIhhZXsPj3l4Cx', NULL, NULL, NULL, '2019-11-30 05:28:00', '2019-11-30 05:29:02', NULL, 3, NULL),
(285, 5, 0, NULL, 'Z04w5H7zAgGwna0z', NULL, NULL, '-LuuxCoUivyOfbN9NJ5I', NULL, NULL, NULL, '2019-11-30 06:17:19', '2019-11-30 06:18:23', NULL, 3, NULL),
(286, 5, 0, NULL, 'CAQrcTwSWzlZmNPW', NULL, NULL, '-LuuzZXgTgjKebF6k-ed', NULL, NULL, NULL, '2019-11-30 06:27:37', '2019-11-30 06:29:02', NULL, 3, NULL),
(287, 5, 0, NULL, 'tFpM6WhvSHp9LPpC', NULL, NULL, '-Lv9ZIe96vhhEZOjdCYi', NULL, NULL, NULL, '2019-12-03 07:02:25', '2019-12-03 07:03:28', NULL, 3, NULL),
(288, 77, 0, NULL, 'tzv1KfeXqaOvOnB8', NULL, NULL, '-LvDfR1B_7wF3415K6KE', NULL, NULL, NULL, '2019-12-04 02:12:03', '2019-12-04 02:14:02', NULL, 3, NULL),
(289, 77, 0, NULL, 'tg6L4rfmR6eBx7c8', NULL, NULL, '-LvDflMucm0LcCmpgBPE', NULL, NULL, NULL, '2019-12-04 02:13:31', '2019-12-04 02:15:01', NULL, 3, NULL),
(290, 77, 0, NULL, 'QVyGdQSa8Plida4g', NULL, NULL, '-LvDfv6hn_5BIk0Vzpz0', NULL, NULL, NULL, '2019-12-04 02:14:11', '2019-12-04 02:16:02', NULL, 3, NULL),
(291, 5, 0, NULL, 'b3dkT5L1gDnypLhK', NULL, NULL, '-LvGO6sN-EXerJ-n1F1E', NULL, NULL, NULL, '2019-12-04 14:50:55', '2019-12-04 14:51:56', NULL, 3, NULL),
(292, 5, 0, NULL, '8k4Sv1kgzndDAW8N', NULL, NULL, '-LvGUScvymD1v9Sh8-Kb', NULL, NULL, NULL, '2019-12-04 15:18:36', '2019-12-04 15:20:02', NULL, 3, NULL),
(293, 5, 0, NULL, '30BDuXuN9rsKWaR7', NULL, NULL, '-LvGfejX3OzEOQj6dgfc', NULL, NULL, NULL, '2019-12-04 16:11:55', '2019-12-04 16:13:01', NULL, 3, NULL),
(294, 5, 0, NULL, 'QKWVkmYEE5X0mj0y', NULL, NULL, '-LvJOtc-TryFCmvBDtKm', NULL, NULL, NULL, '2019-12-05 04:53:09', '2019-12-05 04:54:10', NULL, 3, NULL),
(295, 5, 0, NULL, '303dnYKrJi5lJC6i', NULL, NULL, '-Lv_9ttj2CMA9ZcqNF3p', NULL, NULL, NULL, '2019-12-08 11:01:11', '2019-12-08 11:03:02', NULL, 3, NULL),
(296, 5, 0, NULL, '6vrp5ZuJGKfWqOF0', NULL, NULL, '-Lv_9ux_pPNb5dOmvjY3', NULL, NULL, NULL, '2019-12-08 11:01:15', '2019-12-08 11:02:34', NULL, 3, NULL),
(297, 79, 0, NULL, 'YUxZLdwLAa5TWmLv', NULL, NULL, '-LvfUi3QVtX260TA177N', NULL, NULL, NULL, '2019-12-09 16:29:51', '2019-12-09 16:31:02', NULL, 3, NULL),
(298, 29, 0, NULL, 'QQrAcexQlwcNc9M8', NULL, NULL, '-LviGwHNXEUtMorQbFmB', NULL, NULL, NULL, '2019-12-10 05:28:31', '2019-12-10 05:30:02', NULL, 3, NULL),
(299, 77, 0, NULL, '4yCcUb48TeELqvRY', NULL, NULL, '-Lvu6sqdWZYUHX61beT9', NULL, NULL, NULL, '2019-12-12 12:40:02', '2019-12-12 12:42:02', NULL, 3, NULL),
(300, 5, 0, NULL, 'YIgVuGN2DahvirNv', NULL, NULL, '-LwC_W4XM3-1ED9X98CE', NULL, NULL, NULL, '2019-12-16 07:22:16', '2019-12-16 07:24:02', NULL, 3, NULL),
(301, 5, 0, NULL, 'x7SN00tQ0RQqKSht', NULL, NULL, '-LwH_spYY2axyJ7iTaes', NULL, NULL, NULL, '2019-12-17 06:41:59', '2019-12-17 06:43:02', NULL, 3, NULL),
(302, 5, 0, NULL, 'dv3shYuzgJLFBkFY', NULL, NULL, '-LwScBH4Y7VZucd7pB2x', NULL, NULL, NULL, '2019-12-19 10:07:53', '2019-12-19 10:09:02', NULL, 3, NULL),
(303, 5, 0, NULL, 'fKQdatKfbAITE9Mi', NULL, NULL, '-LwSlnQpgL-5Zf-qNeXm', NULL, NULL, NULL, '2019-12-19 10:49:52', '2019-12-19 10:50:53', NULL, 3, NULL),
(304, 5, 0, NULL, 'WdSyrRXdeIYDdC2R', NULL, NULL, '-LwSnlQkxaQUlCWFVpsC', NULL, NULL, NULL, '2019-12-19 10:58:28', '2019-12-19 10:59:32', NULL, 3, NULL),
(305, 5, 0, NULL, 'zk7PXVPxunC999bW', NULL, NULL, '-LwSt_gfoSs_-SeoCaJc', NULL, NULL, NULL, '2019-12-19 11:23:53', '2019-12-19 11:25:01', NULL, 3, NULL),
(306, 5, 0, NULL, 'qBj02u2JGGaNQCzR', NULL, NULL, '-LwStutpb5tCYCC7TXvs', NULL, NULL, NULL, '2019-12-19 11:25:20', '2019-12-19 11:27:01', NULL, 3, NULL),
(307, 29, 0, NULL, 'NiwaAOuzCDkWcpx0', NULL, NULL, '-LwVpkZKQWRZFNxn42iG', NULL, NULL, NULL, '2019-12-20 01:06:01', '2019-12-20 01:07:02', NULL, 3, NULL),
(308, 80, 0, NULL, 'C6FrWJI4TENXLCW6', NULL, NULL, '-LwmzGu6TURszXDi5v7V', NULL, NULL, NULL, '2019-12-23 13:40:46', '2019-12-23 13:42:01', NULL, 3, NULL),
(309, 80, 0, NULL, 'QwqpyC3Gtq0HWnY6', NULL, NULL, '-LwmzapuJBkbUjtREtyZ', NULL, NULL, NULL, '2019-12-23 13:42:12', '2019-12-23 13:43:14', NULL, 3, NULL),
(310, 5, 0, NULL, 'RaexKUp1b21OuyBl', NULL, NULL, '-Lwn-MCebLMN-xc59sZG', NULL, NULL, NULL, '2019-12-23 13:45:30', '2019-12-23 13:46:51', NULL, 3, NULL),
(311, 80, 1, '5.00', '66zL8OAdVlQHLRXn', 2, 1, '-Lwn-mCr_4mwB_u3FU5I', 'T-bkksub15797102505699561', '2019-12-23 13:47:44', 'RM', '2019-12-23 13:47:21', '2019-12-23 13:47:44', NULL, 1, NULL),
(312, 80, 0, NULL, 'Nt3hjTrQuz9sAu5N', NULL, NULL, '-Lwn2-9Fn6hsty63cCG2', NULL, NULL, NULL, '2019-12-23 13:57:02', '2019-12-23 13:58:04', NULL, 3, NULL),
(313, 77, 0, NULL, '89OLFMD6Sgq0PdtT', NULL, NULL, '-Lwq2j2z4cxzm9LOJ47F', NULL, NULL, NULL, '2019-12-24 03:59:06', '2019-12-24 04:01:02', NULL, 3, NULL),
(314, 77, 0, NULL, 'BpWqVZyZWegc1QVc', NULL, NULL, '-LxKYHHQYijSh5U-LTwz', NULL, NULL, NULL, '2019-12-30 06:45:11', '2019-12-30 06:47:01', NULL, 3, NULL),
(315, 80, 1, '25.00', 'olAQNA4KwI8sGi6j', 2, 1, '-LxRcUnHnbCl9lYVlKHw', 'T-bkksub19999971004856539', '2019-12-31 15:45:35', 'RM', '2019-12-31 15:45:17', '2019-12-31 15:45:35', NULL, 1, NULL),
(316, 80, 0, NULL, 'wN6SzhLG8izfHOf2', NULL, NULL, '-LxlBYMBJiGeOSOxO6iU', NULL, NULL, NULL, '2020-01-04 15:35:13', '2020-01-04 15:37:01', NULL, 3, NULL);
INSERT INTO `coupon_codes` (`id`, `user_id`, `type`, `amount`, `coupon`, `outlet_id`, `merchant_id`, `firebase_uuid`, `transaction_id`, `tranasaction_datetime`, `currency`, `created_at`, `updated_at`, `updated_by`, `status`, `deleted_at`) VALUES
(317, 5, 0, NULL, 'ZRrrT6MwpxjuXoSK', NULL, NULL, '-LxyYOmXPVqyg3MlTviz', NULL, NULL, NULL, '2020-01-07 05:50:07', '2020-01-07 05:52:01', NULL, 3, NULL),
(318, 80, 0, NULL, 'y0ZWXfPfzNMOkSt2', NULL, NULL, '-Ly7IbECCZ3sveuspFow', NULL, NULL, NULL, '2020-01-09 03:17:20', '2020-01-09 03:19:02', NULL, 3, NULL),
(319, 77, 0, NULL, 'oqUT7nlSVLha9QqI', NULL, NULL, '-Ly7xv4W3dKFoIFy-mml', NULL, NULL, NULL, '2020-01-09 06:22:11', '2020-01-09 06:24:02', NULL, 3, NULL),
(320, 80, 0, NULL, 'hOxg7FEXCjqmhC2M', NULL, NULL, '-LyET4RUqe6QnmV9-NEJ', NULL, NULL, NULL, '2020-01-10 12:40:26', '2020-01-10 12:41:27', NULL, 3, NULL),
(321, 80, 0, NULL, 'H0VP8kNgS7jj01wy', NULL, NULL, '-LyETpI2gd4G5M3a7tSN', NULL, NULL, NULL, '2020-01-10 12:43:42', '2020-01-10 12:45:02', NULL, 3, NULL),
(322, 29, 0, NULL, 'LdQDnSjXY9AC3k8r', NULL, NULL, '-LyXQLZKdPTkEaBmKmzX', NULL, NULL, NULL, '2020-01-14 05:01:17', '2020-01-14 05:03:01', NULL, 3, NULL),
(323, 29, 0, NULL, 'eFYgZTV6eE3MwYN8', NULL, NULL, '-LyXQ_cmau7EYSw0-PS5', NULL, NULL, NULL, '2020-01-14 05:02:18', '2020-01-14 05:04:02', NULL, 3, NULL),
(324, 29, 0, NULL, 'Me6lskCJ7B4R9YLy', NULL, NULL, '-LyXQatcMQYi_diMgVW0', NULL, NULL, NULL, '2020-01-14 05:02:23', '2020-01-14 05:04:03', NULL, 3, NULL),
(325, 29, 0, NULL, '4B9L2cRRTnvxeEV7', NULL, NULL, '-LyXT121PEZZjPQGB3WM', NULL, NULL, NULL, '2020-01-14 05:12:59', '2020-01-14 05:14:01', NULL, 3, NULL),
(326, 77, 0, NULL, 's44qcvzzTx8Sf08S', NULL, NULL, '-LycchcN8Ezbu9ZALUbu', NULL, NULL, NULL, '2020-01-15 09:57:22', '2020-01-15 09:59:02', NULL, 3, NULL),
(327, 77, 0, NULL, 'oiOOonbw9oVVi7F6', NULL, NULL, '-Lz2RLHPIWezO-ah2rpr', NULL, NULL, NULL, '2020-01-20 14:53:06', '2020-01-20 14:55:02', NULL, 3, NULL),
(328, 80, 0, NULL, 'VXwhPiSG7lymFMbs', NULL, NULL, '-Mw_uvUhrE3Y2CLoCWdC', NULL, NULL, NULL, '2022-02-23 17:31:19', NULL, NULL, 0, NULL),
(329, 80, 0, NULL, 'EhcaiUMrDtwDlLUg', NULL, NULL, '-MweJJLUSEHE7WzT23Sw', NULL, NULL, NULL, '2022-02-24 14:00:43', NULL, NULL, 0, NULL),
(330, 80, 0, NULL, 'Q1JwZHylWTMp2maQ', NULL, NULL, '-MweJLhTeeI60xAQFnS3', NULL, NULL, NULL, '2022-02-24 14:00:53', NULL, NULL, 0, NULL),
(331, 80, 0, NULL, 'UT3jqmDd4jjeEeLn', NULL, NULL, '-MweLy8QAc2BRtML3b2T', NULL, NULL, NULL, '2022-02-24 14:12:19', NULL, NULL, 0, NULL),
(332, 80, 3, '0.00', 'ekV2yu2ScnTKXgqf', 2, 1, '-MweMRn_3YMibLTJgtdk', 'U-bkksub25749525448985255', '2022-02-24 14:14:41', 'RM', '2022-02-24 14:14:24', '2022-02-24 14:14:41', NULL, 1, NULL),
(333, 80, 3, '0.00', 'HbrDx9ZKIZpClcqQ', 2, 1, '-Mwi_I8nCXznkbDqT6T1', 'U-bkksub25197525710248100', '2022-02-25 09:53:38', 'RM', '2022-02-25 09:53:24', '2022-03-03 16:09:09', NULL, 3, NULL),
(334, 5, 0, NULL, 'HlekQkPN346CER8E', NULL, NULL, '-MxShvWEp6_FZ6Rt2c4_', NULL, NULL, NULL, '2022-03-06 13:33:15', NULL, NULL, 0, NULL),
(335, 5, 3, '0.00', 'F3YlgUzyty20qveR', 2, 1, '-MxSiUAPjJgrFhJhw7K5', 'U-bkksub25151555348991019', '2022-03-06 13:35:56', 'RM', '2022-03-06 13:35:41', '2022-03-06 13:35:56', NULL, 1, NULL),
(336, 5, 0, NULL, 'pxA5qDlpgcK3wjiu', NULL, NULL, '-MxSinuZ1k6vIncAlST3', NULL, NULL, NULL, '2022-03-06 13:37:06', NULL, NULL, 0, NULL),
(337, 80, 3, '0.00', '3wzdQwPJnK7ysV8U', 2, 1, '-MxX7lIV7q024vDKDjbF', 'U-bkksub25651565256485649', '2022-03-07 10:09:10', 'RM', '2022-03-07 10:09:00', '2022-03-07 10:09:10', NULL, 1, NULL),
(338, 80, 3, '0.00', '3jOXEzY99EqmZ2gM', 2, 1, '-MxX8-rB5KSOvpdGry81', 'U-bkksub29810210099994910', '2022-03-07 10:10:08', 'RM', '2022-03-07 10:10:04', '2022-03-07 10:10:08', NULL, 1, NULL),
(339, 80, 3, '0.00', 'umYZeuelyPZjQqNs', 2, 1, '-MxX8IKpxOKBSoKN12x1', 'U-bkksub24849545752102515', '2022-03-07 10:11:21', 'RM', '2022-03-07 10:11:20', '2022-03-07 10:11:21', NULL, 1, NULL),
(340, 80, 0, NULL, 'pq6VPWZEFPsIo6wg', NULL, NULL, '-MxX8mZVsRjANLEnuimi', NULL, NULL, NULL, '2022-03-07 10:13:27', NULL, NULL, 0, NULL),
(341, 80, 3, '0.00', '1nwCuDGzpNauSMJf', 2, 1, '-MxXIxCm8YBCgpmKTKJW', 'U-bkksub21015456101102515', '2022-03-07 10:57:54', 'RM', '2022-03-07 10:57:53', '2022-03-07 10:57:54', NULL, 1, NULL),
(342, 80, 3, '0.00', 'ozW2bS9lSZYX6jzI', 2, 1, '-MxXJRZM462tUnd-Y0tK', 'U-bkksub21001011024956559', '2022-03-07 11:00:03', 'RM', '2022-03-07 11:00:01', '2022-03-07 11:00:03', NULL, 1, NULL),
(343, 80, 3, '0.00', '73doBXH6H6X0KzlD', 2, 1, '-MxXK4t_fbw8bPC7I-y3', 'U-bkksub21015656554910299', '2022-03-07 11:02:52', 'RM', '2022-03-07 11:02:50', '2022-03-07 11:02:52', NULL, 1, NULL),
(344, 80, 3, '0.00', 'diInjRyc14zmwykj', 2, 1, '-MxXKmUin3f0Z5OLv7aH', 'U-bkksub29948995748102524', '2022-03-07 11:05:54', 'RM', '2022-03-07 11:05:53', '2022-03-07 11:05:54', NULL, 1, NULL),
(345, 80, 3, '0.00', 'NQUHAK0MVAZiKcWz', 2, 1, '-MxXTFv9FHmaey-D1Iop', 'U-bkksub29855989997975053', '2022-03-07 11:45:31', 'RM', '2022-03-07 11:42:55', '2022-03-07 11:45:31', NULL, 1, NULL),
(346, 80, 0, NULL, 'xSqdzWsCXOJgMTcS', NULL, NULL, '-MxXkyKWS_Mc0_naczYT', NULL, NULL, NULL, '2022-03-07 13:04:39', NULL, NULL, 0, NULL),
(347, 5, 0, NULL, '0zoqgCaFTbzXWC0q', NULL, NULL, '-MxXlkcjCfS0zGuK4plT', NULL, NULL, NULL, '2022-03-07 13:08:05', NULL, NULL, 0, NULL),
(348, 80, 0, NULL, 'bxQ236K3qPuZqvsZ', NULL, NULL, '-MxXnbtJLJfTeJWhtsBb', NULL, NULL, NULL, '2022-03-07 13:16:14', NULL, NULL, 0, NULL),
(349, 80, 3, '0.00', '9IQahzDHLCsn9SaJ', 2, 1, '-MxXoUx9uzj2XTjAUCX1', 'U-bkksub29854529810155102', '2022-03-07 13:20:06', 'RM', '2022-03-07 13:20:03', '2022-03-07 13:20:06', NULL, 1, NULL),
(350, 80, 3, '0.00', 'A0GMODiHeCgm8hJ6', 2, 1, '-MxXp5A_IX0t074sYBYf', 'U-bkksub21015310151575349', '2022-03-07 13:22:47', 'RM', '2022-03-07 13:22:40', '2022-03-07 13:22:47', NULL, 1, NULL),
(351, 80, 3, '0.00', 'okrufccnecYDt4xx', 2, 1, '-MxY1hYly3HXjk8vIcDS', 'U-bkksub24957535653564810', '2022-03-07 14:22:18', 'RM', '2022-03-07 14:22:09', '2022-03-07 14:22:18', NULL, 1, NULL),
(352, 80, 3, '0.00', '0MqjE35vn5NeyyNp', 2, 1, '-MxYAg-F1RQOg3f4MPjw', 'U-bkksub24910048999953559', '2022-03-07 15:01:33', 'RM', '2022-03-07 15:01:22', '2022-03-07 15:01:33', NULL, 1, NULL),
(353, 80, 3, '0.00', 'i4jXfYlWtJrCFWLu', 2, 1, '-MxYFKTPaoj9lyZuJvag', 'U-bkksub25055102102525449', '2022-03-07 15:21:43', 'RM', '2022-03-07 15:21:41', '2022-03-07 15:21:43', NULL, 1, NULL),
(354, 80, 0, NULL, 'H4rGX0ZhRCaVGJa7', NULL, NULL, '-MxYMsZnIj9hQwuVB-6M', NULL, NULL, NULL, '2022-03-07 15:54:39', NULL, NULL, 0, NULL),
(355, 80, 3, '0.00', '12WJ05vsN4OqHySj', 2, 1, '-MxYOYHv-Dq9t14A8iWI', 'U-bkksub25249565257525156', '2022-03-07 16:02:04', 'RM', '2022-03-07 16:01:56', '2022-03-07 16:02:04', NULL, 1, NULL),
(356, 5, 0, NULL, 'Q1Zs6IASUUMmLZy6', NULL, NULL, '-MxYx_6TGLgE5zUdd1mS', NULL, NULL, NULL, '2022-03-07 18:39:21', NULL, NULL, 0, NULL),
(357, 5, 0, NULL, 'UKFiKwIS8mYad36m', NULL, NULL, '-MxcAohgNg91kj_AGoWK', NULL, NULL, NULL, '2022-03-08 14:20:04', NULL, NULL, 0, NULL),
(358, 80, 0, NULL, '8Cu1tT6KtAJNbWuI', NULL, NULL, '-MxcQrcVKpZj2LSnEhy1', NULL, NULL, NULL, '2022-03-08 15:30:10', NULL, NULL, 0, NULL),
(359, 80, 0, NULL, 'Pr704apyjiKROfYm', NULL, NULL, '-MxcQuhb-U4RFGBvTf8X', NULL, NULL, NULL, '2022-03-08 15:30:23', NULL, NULL, 0, NULL),
(360, 80, 0, NULL, 'xDXDgGiJvY0rxClo', NULL, NULL, '-MxcR4juj7kT-h1Ek50R', NULL, NULL, NULL, '2022-03-08 15:31:08', NULL, NULL, 0, NULL),
(361, 80, 0, NULL, 'YDhsSRcwDQ8cmx6A', NULL, NULL, '-MxcRQu-is7Vac01_hgJ', NULL, NULL, NULL, '2022-03-08 15:32:39', NULL, NULL, 0, NULL),
(362, 80, 0, NULL, 'Q7SzxSSSPAfMI2qD', NULL, NULL, '-MxhJ3VqDufyhY2GYI_i', NULL, NULL, NULL, '2022-03-09 14:14:12', NULL, NULL, 0, NULL),
(363, 80, 0, NULL, '4yOWilF8RstVwp3W', NULL, NULL, '-MxhWRoQyKR7TAkhBNdX', NULL, NULL, NULL, '2022-03-09 15:12:39', NULL, NULL, 0, NULL),
(364, 80, 0, NULL, '4VmhgkEuVhHxURAD', NULL, NULL, '-MxhZp5qFyVN08U2dZkb', NULL, NULL, NULL, '2022-03-09 15:27:25', NULL, NULL, 0, NULL),
(365, 80, 0, NULL, 'XdXDuVoCSgXiFMpk', NULL, NULL, '-MxhZqf2ioq9hZENapu7', NULL, NULL, NULL, '2022-03-09 15:27:32', NULL, NULL, 0, NULL),
(366, 80, 0, NULL, 'ujnMG44xWyYTxnw1', NULL, NULL, '-Mxh_CT4wvuCeHrR9Ujl', NULL, NULL, NULL, '2022-03-09 15:29:05', NULL, NULL, 0, NULL),
(367, 80, 0, NULL, '48R1UUxIiL8kYLAX', NULL, NULL, '-Mxh_uhSReJ93JzN5nQA', NULL, NULL, NULL, '2022-03-09 15:32:10', NULL, NULL, 0, NULL),
(368, 80, 0, NULL, '1OC2e6BAcoBCjYiL', NULL, NULL, '-MxhjHbTJZUYDj82ofaT', NULL, NULL, NULL, '2022-03-09 16:13:07', NULL, NULL, 0, NULL),
(369, 80, 3, '0.00', 'HpLhdzbYesM3ia5Q', 2, 1, '-MxhjqbieDd7c15P1KHd', 'U-bkksub29910099549810050', '2022-03-09 16:16:10', 'RM', '2022-03-09 16:15:35', '2022-03-09 16:16:10', NULL, 1, NULL),
(370, 80, 0, NULL, 'lzTGGwoL3opFm8BX', NULL, NULL, '-MxmP3iIE39RPbCMU60V', NULL, NULL, NULL, '2022-03-10 13:58:32', NULL, NULL, 0, NULL),
(371, 80, 0, NULL, 'jXHcWq4XjpXL2i5w', NULL, NULL, '-My6-l6ujEwfzwPrcjzH', NULL, NULL, NULL, '2022-03-14 13:59:59', NULL, NULL, 0, NULL),
(372, 80, 0, NULL, 'rL2lsZ8LtCSdloIN', NULL, NULL, '-My6-q2xKzWKSVxFOmo-', NULL, NULL, NULL, '2022-03-14 14:00:19', NULL, NULL, 0, NULL),
(373, 80, 0, NULL, 'a4E2KVvBsFbkTXky', NULL, NULL, '-My6-ypNSUY-gL2jZCAY', NULL, NULL, NULL, '2022-03-14 14:00:55', NULL, NULL, 0, NULL),
(374, 80, 0, NULL, '6EOYFvvODA2WxILH', NULL, NULL, '-My60G-AtTWBmysYcsI1', NULL, NULL, NULL, '2022-03-14 14:02:10', NULL, NULL, 0, NULL),
(375, 80, 0, NULL, 'YHrTHrsGM2Ny1QBa', NULL, NULL, '-My60N6FPOPgE68L6tsb', NULL, NULL, NULL, '2022-03-14 14:02:39', NULL, NULL, 0, NULL),
(376, 80, 0, NULL, '547nNU59N0hlFbHY', NULL, NULL, '-MyA7mZxdcLl39Jvui3U', NULL, NULL, NULL, '2022-03-15 09:13:31', NULL, NULL, 0, NULL),
(377, 80, 0, NULL, 'WQ75qgDxxwduPqD7', NULL, NULL, '-MyA7uGNB9P6lUFuAUaw', NULL, NULL, NULL, '2022-03-15 09:14:03', NULL, NULL, 0, NULL),
(378, 80, 0, NULL, 'YrGgT75pvKmy2Olw', NULL, NULL, '-MyA7zzH2TB9Db5fxUy7', NULL, NULL, NULL, '2022-03-15 09:14:26', NULL, NULL, 0, NULL),
(379, 80, 0, NULL, 'qaCHtpxwRe0E0LK2', NULL, NULL, '-MyA9VKuMS410uF3ZZzZ', NULL, NULL, NULL, '2022-03-15 09:21:01', NULL, NULL, 0, NULL),
(380, 80, 0, NULL, 'OGfDu12nUFhaLu4l', NULL, NULL, '-MyA9mrJvisRpmD5GJ3S', NULL, NULL, NULL, '2022-03-15 09:22:17', NULL, NULL, 0, NULL),
(381, 80, 0, NULL, 'zx3m9oPy4T2t7Bkc', NULL, NULL, '-MyAA-kb0D8h6J3hr7rI', NULL, NULL, NULL, '2022-03-15 09:23:14', NULL, NULL, 0, NULL),
(382, 80, 0, NULL, 'lae8AuenNRgt4Ofx', NULL, NULL, '-MyAAfUKSnBGHZBdtwhe', NULL, NULL, NULL, '2022-03-15 09:26:09', NULL, NULL, 0, NULL),
(383, 80, 0, NULL, 'rpWnN0qRYwdMTDiT', NULL, NULL, '-MyACZ97T6IB79jUY5tu', NULL, NULL, NULL, '2022-03-15 09:34:23', NULL, NULL, 0, NULL),
(384, 80, 0, NULL, 'zMMhuLsmSdeC6vO9', NULL, NULL, '-MyGGKKNagQsz2Vj4LxG', NULL, NULL, NULL, '2022-03-16 13:48:34', NULL, NULL, 0, NULL),
(385, 80, 0, NULL, 'Oz0tCNuGdvjTqg20', NULL, NULL, '-MyGGKU4rOU8AP2qNJMu', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(386, 80, 0, NULL, '9Qw28IziW3OA81Iz', NULL, NULL, '-MyGGKZolK0zm1xxT3Gq', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(387, 80, 0, NULL, 'T7dCciVhluRUmoUa', NULL, NULL, '-MyGGKb6YHJGQrQ_gC_B', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(388, 80, 0, NULL, '5EqylKIAS5V8Of9l', NULL, NULL, '-MyGGKdOM6CdSGRjlhFZ', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(389, 80, 0, NULL, 'DK8b6uXjWXxJNl6z', NULL, NULL, '-MyGGKdPoy5r73xqfS60', NULL, NULL, NULL, '2022-03-16 13:48:35', NULL, NULL, 0, NULL),
(390, 80, 0, NULL, 'WXRQngr6Cahy0EIh', NULL, NULL, '-MyGGKiHdFaTY8BIhsVR', NULL, NULL, NULL, '2022-03-16 13:48:36', NULL, NULL, 0, NULL),
(391, 80, 0, NULL, '0QkMIwquzhq0pExx', NULL, NULL, '-MyGG_friUqxaq1oz22e', NULL, NULL, NULL, '2022-03-16 13:49:41', NULL, NULL, 0, NULL),
(392, 80, 0, NULL, '7BL8gKRt6YuAipzN', NULL, NULL, '-MyGLh9FRWlrriGJLh0X', NULL, NULL, NULL, '2022-03-16 14:12:02', NULL, NULL, 0, NULL),
(393, 80, 0, NULL, 'X9dxiH40wwpbxxnO', NULL, NULL, '-MyGSOz3q-CZ1mqUNYMW', NULL, NULL, NULL, '2022-03-16 14:41:19', NULL, NULL, 0, NULL),
(394, 80, 0, NULL, 'CtaGLCdlGLxnPKeL', NULL, NULL, '-MyGZTfJ62eGQPHgX1sE', NULL, NULL, NULL, '2022-03-16 15:12:13', NULL, NULL, 0, NULL),
(395, 80, 0, NULL, 'WM8iOdkVPz0SxhhL', NULL, NULL, '-MyGaTraYZ0YIRQ9n_gV', NULL, NULL, NULL, '2022-03-16 15:20:58', NULL, NULL, 0, NULL),
(396, 80, 0, NULL, 'M7tNqp7eALKTuEZY', NULL, NULL, '-MyH9fkjS40Uq7Wx40aD', NULL, NULL, NULL, '2022-03-16 17:59:08', NULL, NULL, 0, NULL),
(397, 80, 0, NULL, 'cbig3Uxz3tlkeqwm', NULL, NULL, '-MyH9jc3D3QLpNukSjSj', NULL, NULL, NULL, '2022-03-16 17:59:24', NULL, NULL, 0, NULL),
(398, 80, 0, NULL, 'eLsNRH1VOdLtMZwp', NULL, NULL, '-MyHAss3YeGjH1jhipq1', NULL, NULL, NULL, '2022-03-16 18:04:24', NULL, NULL, 0, NULL),
(399, 80, 0, NULL, 'OI1bRCcXlNp1W8yI', NULL, NULL, '-MyL6wx21qKd2rUuQTvD', NULL, NULL, NULL, '2022-03-17 12:25:41', NULL, NULL, 0, NULL),
(400, 80, 0, NULL, 'Bda99aJRr50brE2z', NULL, NULL, '-MyL7-QCnzlv-KXLSh1q', NULL, NULL, NULL, '2022-03-17 12:25:55', NULL, NULL, 0, NULL),
(401, 80, 0, NULL, 'oBBGauXDEukMFBXt', NULL, NULL, '-MyL7BmutT53jeP5MCMM', NULL, NULL, NULL, '2022-03-17 12:26:46', NULL, NULL, 0, NULL),
(402, 80, 0, NULL, 'qZfj2BjVgKUQ74mf', NULL, NULL, '-MyL7ZMTTaR4L46d6Bbu', NULL, NULL, NULL, '2022-03-17 12:28:22', NULL, NULL, 0, NULL),
(403, 80, 0, NULL, 'Ovohn17KLR8vAN4C', NULL, NULL, '-MyL8LTwqNPdjTindqbw', NULL, NULL, NULL, '2022-03-17 12:31:48', NULL, NULL, 0, NULL),
(404, 80, 0, NULL, 'TqIr8PNlMtp12KrT', NULL, NULL, '-MyL9EepXYiQK-qP2RuZ', NULL, NULL, NULL, '2022-03-17 12:35:42', NULL, NULL, 0, NULL),
(405, 80, 0, NULL, '4VJZpyl328NkAlbP', NULL, NULL, '-MyL9dDk0K8RC1hNdOa4', NULL, NULL, NULL, '2022-03-17 12:37:27', NULL, NULL, 0, NULL),
(406, 80, 0, NULL, '4LZJ6fwpDKwZs1d2', NULL, NULL, '-MyL9eVWpPg80QF6FBs7', NULL, NULL, NULL, '2022-03-17 12:37:32', NULL, NULL, 0, NULL),
(407, 80, 0, NULL, 'TzYyLIl779GFvZU2', NULL, NULL, '-MyLAWLcExrVTQmp4czV', NULL, NULL, NULL, '2022-03-17 12:41:16', NULL, NULL, 0, NULL),
(408, 80, 0, NULL, 'cMA9hOKWncJdzTzg', NULL, NULL, '-MyLBtXXENkbSbaSFS7v', NULL, NULL, NULL, '2022-03-17 12:47:18', NULL, NULL, 0, NULL),
(409, 80, 0, NULL, 'LwkXALTBftBjzLjG', NULL, NULL, '-MyLC_BqztoB6yr0wrKt', NULL, NULL, NULL, '2022-03-17 12:50:17', NULL, NULL, 0, NULL),
(410, 80, 0, NULL, 'F8V5XjV7p5a0JW9o', NULL, NULL, '-MyLFWbpUuJNzAvFPuEr', NULL, NULL, NULL, '2022-03-17 13:03:08', NULL, NULL, 0, NULL),
(411, 80, 0, NULL, 'VVWeOISGdLXpM7bL', NULL, NULL, '-MyLFY0UfToovRwI4Xmd', NULL, NULL, NULL, '2022-03-17 13:03:14', NULL, NULL, 0, NULL),
(412, 80, 0, NULL, 'fjiRTKiZt752auGz', NULL, NULL, '-MyLNalm_aG9B3r4O3oG', NULL, NULL, NULL, '2022-03-17 13:38:27', NULL, NULL, 0, NULL),
(413, 80, 0, NULL, '3EdaudbGyUdwCuwE', NULL, NULL, '-MyLOQmjfmNrdBJ5FKJp', NULL, NULL, NULL, '2022-03-17 13:42:04', NULL, NULL, 0, NULL),
(414, 80, 0, NULL, 'eQztgnfnWTrTTVLo', NULL, NULL, '-MyLcGiwdwHdLKj5EQ3g', NULL, NULL, NULL, '2022-03-17 14:46:55', NULL, NULL, 0, NULL),
(415, 80, 0, NULL, '31EhuTcvdcbbb7Xe', NULL, NULL, '-MyLe59-nfHfJfducZmU', NULL, NULL, NULL, '2022-03-17 14:54:52', NULL, NULL, 0, NULL),
(416, 80, 0, NULL, 'G0o5E1huFadej2QS', NULL, NULL, '-MyLe6TE9ieTzeh-gyg1', NULL, NULL, NULL, '2022-03-17 14:54:57', NULL, NULL, 0, NULL),
(417, 80, 0, NULL, 'CRIzNmQh2PMpbEuI', NULL, NULL, '-MyLhcLP1M_1QTvq8iHz', NULL, NULL, NULL, '2022-03-17 15:10:18', NULL, NULL, 0, NULL),
(418, 80, 0, NULL, 'fPdXIWxnIlvnIsHA', NULL, NULL, '-MyLhuctBMrBmvC5XwAD', NULL, NULL, NULL, '2022-03-17 15:11:33', NULL, NULL, 0, NULL),
(419, 80, 0, NULL, 'qGxxMivgbYO1WNmK', NULL, NULL, '-MyLi6AmJZhiJ03xTejB', NULL, NULL, NULL, '2022-03-17 15:12:24', NULL, NULL, 0, NULL),
(420, 80, 0, NULL, 'ZsMFDfjvLBUwFWRd', NULL, NULL, '-MyLiDidB9B-OPUmI_X4', NULL, NULL, NULL, '2022-03-17 15:12:55', NULL, NULL, 0, NULL),
(421, 80, 0, NULL, 'Lnu34or4ELyjIo18', NULL, NULL, '-MyLiQms4VlIgJrXso8P', NULL, NULL, NULL, '2022-03-17 15:13:49', NULL, NULL, 0, NULL),
(422, 80, 0, NULL, 'y0mDShArEaowveBR', NULL, NULL, '-MyLimDP_rcIddFP_M5Q', NULL, NULL, NULL, '2022-03-17 15:15:21', NULL, NULL, 0, NULL),
(423, 80, 0, NULL, '0K7FGEgo9f3N8CKd', NULL, NULL, '-MyLkG0P3MDwpg54H4C2', NULL, NULL, NULL, '2022-03-17 15:21:49', NULL, NULL, 0, NULL),
(424, 80, 0, NULL, '0fUPZCr3OBU1DdpG', NULL, NULL, '-MyMlY6a4VUbsosH9IcA', NULL, NULL, NULL, '2022-03-17 20:07:02', NULL, NULL, 0, NULL),
(425, 80, 0, NULL, 'VEsunYPaOs9U8xGb', NULL, NULL, '-MyMl_bbWY3cFXWjyWyT', NULL, NULL, NULL, '2022-03-17 20:07:13', NULL, NULL, 0, NULL),
(426, 80, 0, NULL, 'D3TTXol4YMYUeIF4', NULL, NULL, '-MyMlppe0bf2WGo3a7O6', NULL, NULL, NULL, '2022-03-17 20:08:19', NULL, NULL, 0, NULL),
(427, 80, 0, NULL, 'fMyVkVy8x2GjD6Tt', NULL, NULL, '-MyMluC4YARt1yqGjJb0', NULL, NULL, NULL, '2022-03-17 20:08:37', NULL, NULL, 0, NULL),
(428, 80, 0, NULL, 'D53sMw286e4UhnRi', NULL, NULL, '-MyMlxJCIqs6RBrhlOLZ', NULL, NULL, NULL, '2022-03-17 20:08:50', NULL, NULL, 0, NULL),
(429, 80, 0, NULL, 'wpienSiczAPT3sbm', NULL, NULL, '-MyMmf6wwnbabqvwQ-rP', NULL, NULL, NULL, '2022-03-17 20:11:57', NULL, NULL, 0, NULL),
(430, 80, 0, NULL, 'cAYAcrRLtQUIxF8C', NULL, NULL, '-MyMmi5W7rGyuIaoHpa0', NULL, NULL, NULL, '2022-03-17 20:12:10', NULL, NULL, 0, NULL),
(431, 80, 0, NULL, 'EszQnhRTmsoZ3Qbt', NULL, NULL, '-MyMnFaDOJK1ju6zQ5Wd', NULL, NULL, NULL, '2022-03-17 20:14:31', NULL, NULL, 0, NULL),
(432, 80, 0, NULL, 'YZuosnNz9KLL8DEl', NULL, NULL, '-MyMnKz636H2U33wptvc', NULL, NULL, NULL, '2022-03-17 20:14:53', NULL, NULL, 0, NULL),
(433, 80, 0, NULL, 'IXOasgj2zgvG4kBk', NULL, NULL, '-MyMnNLhY-f3uVlJjLO0', NULL, NULL, NULL, '2022-03-17 20:15:03', NULL, NULL, 0, NULL),
(434, 80, 0, NULL, 'FkTyT7Nw1ENWYtP0', NULL, NULL, '-MyR2Rvp-bm5qRTKrzrf', NULL, NULL, NULL, '2022-03-18 16:03:45', NULL, NULL, 0, NULL),
(435, 80, 0, NULL, '8Xo8YF7ynvGqM4Xf', NULL, NULL, '-MyR2VTIfjhrLmextnry', NULL, NULL, NULL, '2022-03-18 16:03:59', NULL, NULL, 0, NULL),
(436, 80, 0, NULL, 'xbkVZFcsPSvdaHSA', NULL, NULL, '-MyfMdYhS3v8nCnxtijD', NULL, NULL, NULL, '2022-03-21 15:26:17', NULL, NULL, 0, NULL),
(437, 80, 3, '0.00', 'x3IlE0wpcXh1G5uY', 2, 1, '-MyfQGsYR4QVBO0lbeBT', 'U-bkksub25352494851101545', '2022-03-21 15:42:11', 'RM', '2022-03-21 15:42:09', '2022-03-21 15:42:11', NULL, 1, NULL),
(438, 80, 3, '0.00', 'B0sdhFircXaxQAye', 2, 1, '-MyfWP9Jtaa0axVNhMyO', 'U-bkksub25399545199555552', '2022-03-21 16:09:09', 'RM', '2022-03-21 16:08:56', '2022-03-21 16:09:09', NULL, 1, NULL),
(439, 80, 3, '0.00', 'r9YnHxEIUtv2cCQ4', 2, 1, '-MyfWxFLajpIIgOw4qeJ', 'U-bkksub25649555356505552', '2022-03-21 16:11:30', 'RM', '2022-03-21 16:11:19', '2022-03-21 16:11:30', NULL, 1, NULL),
(440, 80, 0, NULL, 's0jCL8rU4PNGgn4t', NULL, NULL, '-MyfcWrZdUzKlVEIelct', NULL, NULL, NULL, '2022-03-21 16:40:02', NULL, NULL, 0, NULL),
(441, 80, 0, NULL, 'd9ifvZOxrEZc48sM', NULL, NULL, '-MznF5iAhbPBZo9yBsPe', NULL, NULL, NULL, '2022-04-04 14:25:59', NULL, NULL, 0, NULL),
(442, 80, 0, NULL, 'GUWG2ilGz1DYLOc7', NULL, NULL, '-Mzre47SuJ9pbn3KoIpn', NULL, NULL, NULL, '2022-04-05 10:57:57', NULL, NULL, 0, NULL),
(443, 80, 0, NULL, '1loa5WKuD7IUWhpf', NULL, NULL, '-N-4gmvTarn4gzL1nGaU', NULL, NULL, NULL, '2022-04-08 04:24:30', NULL, NULL, 0, NULL),
(444, 80, 0, NULL, 'MWQIkPbyxF1deaM1', NULL, NULL, '-N-5m0nPAxrhaKP9UkS_', NULL, NULL, NULL, '2022-04-08 09:26:59', NULL, NULL, 0, NULL),
(445, 80, 0, NULL, 'h3jfc3BaYEYwjp4R', NULL, NULL, '-N-5ntd2EyfVzq5QG30l', NULL, NULL, NULL, '2022-04-08 09:35:10', NULL, NULL, 0, NULL),
(446, 80, 0, NULL, 'xELj1EtIaNC7L6Xg', NULL, NULL, '-N-5oCDcvvRsBkonXQ8q', NULL, NULL, NULL, '2022-04-08 09:36:30', NULL, NULL, 0, NULL),
(447, 80, 0, NULL, 'kjcVlHqnLlJML2MG', NULL, NULL, '-N-5oF0OAFdwlqsFqRnE', NULL, NULL, NULL, '2022-04-08 09:36:42', NULL, NULL, 0, NULL),
(448, 80, 0, NULL, 'VFsIyWyhLz9BEXxI', NULL, NULL, '-N-6D4orJ2LetMtOmLLb', NULL, NULL, NULL, '2022-04-08 11:29:36', NULL, NULL, 0, NULL),
(449, 80, 0, NULL, 'U9Pk2yX2yxEaDDUJ', NULL, NULL, '-N-6Dh3_Am8zWVF5SdvY', NULL, NULL, NULL, '2022-04-08 11:32:16', NULL, NULL, 0, NULL),
(450, 80, 0, NULL, 'sxmZN88IjuFuIQyS', NULL, NULL, '-N-6Dpgv_D13P-QJD9DJ', NULL, NULL, NULL, '2022-04-08 11:32:52', NULL, NULL, 0, NULL),
(451, 80, 0, NULL, 'Yb4KYm530Bx5qckf', NULL, NULL, '-N-QVageOm6btR5CC_Kb', NULL, NULL, NULL, '2022-04-12 10:02:53', NULL, NULL, 0, NULL),
(452, 80, 0, NULL, 'VsEnFJQBemRwBBJl', NULL, NULL, '-N-QWIupYpfqZH1SgUEw', NULL, NULL, NULL, '2022-04-12 10:05:58', NULL, NULL, 0, NULL),
(453, 80, 0, NULL, 'UXqbsTDzjysLHLS1', NULL, NULL, '-N-QZM25hAIrAjmWAlGK', NULL, NULL, NULL, '2022-04-12 10:19:18', NULL, NULL, 0, NULL),
(454, 80, 0, NULL, 'pGIcYIrbU8cfZhhB', NULL, NULL, '-N-QaA5QpGFy0uKRYQiY', NULL, NULL, NULL, '2022-04-12 10:27:13', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_code` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `outlet_id` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `item_name`, `outlet_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'C001', 'Chicken Rice Set', '1', 1, '2022-10-17 17:26:56', NULL),
(2, 'D001', 'Red Bean Soup', '1', 1, '2022-10-17 17:27:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_best_price` varchar(20) CHARACTER SET utf8 NOT NULL,
  `upc_code` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `item_description` text CHARACTER SET utf8,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `sub_category_id`, `item_name`, `item_image`, `item_best_price`, `upc_code`, `product_id`, `item_description`, `created_by`, `created_at`, `updated_at`, `updated_by`, `deleted_at`, `status`) VALUES
(3, 1, 1, 'Kopi Cincau', '1564415762_menu.png', '5.90', '3453543534534', '2343453463434', 'Kopi Cincau', 1, '2019-07-29 15:56:02', '2022-04-20 05:22:48', 0, NULL, 1),
(4, 1, 1, 'Kopi Kaw Kaw', '1564415801_menu.png', '5.50', '2345345345345', '23453245345345', 'Kopi Kaw Kaw', 1, '2019-07-29 15:56:41', '2022-04-20 05:22:48', 0, NULL, 1),
(5, 1, 1, 'Cham Kaw Kaw', '1564415835_menu.png', '5.50', '345345645645645', '4563534534534', 'Cham Kaw Kaw', 1, '2019-07-29 15:57:15', '2022-04-20 05:22:48', 0, NULL, 1),
(6, 1, 1, 'BKK Special 3 Bangsa', '1564415868_menu.png', '5.90', '34534534534534', '243534534534534', 'BKK Special 3 Bangsa', 1, '2019-07-29 15:57:48', '2022-04-20 05:22:48', 0, NULL, 1),
(7, 1, 1, 'BKK Special Kopi Lo', '1564415915_menu.png', '5.90', '546456456456', '345345646456', 'BKK Special Kopi Lo', 1, '2019-07-29 15:58:35', '2022-04-20 05:22:48', 0, NULL, 1),
(8, 1, 1, 'Milo Kaw Kaw', '1564415952_menu.png', '5.90', '98679868768768', '34534534534534', 'Milo Kaw Kaw', 1, '2019-07-29 15:59:12', '2022-04-20 05:22:48', 0, NULL, 1),
(9, 1, 1, 'Milo Kosong Kaw Kaw', '1564416001_menu.png', '5.90', '0979696986986', '3453453523523', 'Milo Kosong Kaw Kaw', 1, '2019-07-29 16:00:01', '2022-04-20 05:22:48', 0, NULL, 1),
(10, 1, 1, 'Milo Dinasour Kaw Kaw', '1564416040_menu.png', '6.90', '90709799789798', '35345345345345', 'Milo Dinasour Kaw Kaw', 1, '2019-07-29 16:00:40', '2022-04-20 05:22:48', 0, NULL, 1),
(11, 1, 5, 'Limau', '1564416201_menu.png', '3.90', '35434534534', '23523534534534', 'Limau', 1, '2019-07-29 16:03:21', '2022-04-20 05:22:48', 0, NULL, 1),
(12, 1, 5, 'Barley Limau', '1564416241_menu.png', '4.50', '97698689686', '2143235345345', 'Barley Limau', 1, '2019-07-29 16:04:01', '2022-04-20 05:22:48', 0, NULL, 1),
(13, 1, 5, 'Cincau Ice', '1564416269_menu.png', '3.90', '09897986896896', '234345435345345', 'Cincau Ice', 1, '2019-07-29 16:04:29', '2022-04-20 05:22:48', 0, NULL, 1),
(14, 1, 5, 'Sirap Ice', '1564416298_menu.png', '3.50', '2345234535345', '23535352345', 'Sirap Ice', 1, '2019-07-29 16:04:58', '2022-04-20 05:22:48', 0, NULL, 1),
(15, 1, 5, 'Sirap Limau Ice', '1564416327_menu.png', '3.90', '2345345345345', '23452352352354', 'Sirap Limau Ice', 1, '2019-07-29 16:05:27', '2022-04-20 05:22:48', 0, NULL, 1),
(16, 1, 5, 'Sirap Bandung Ice', '1564416357_menu.png', '4.50', '23534534534534', '5645343434', 'Sirap Bandung Ice', 1, '2019-07-29 16:05:57', '2022-04-20 05:22:48', 0, NULL, 1),
(17, 1, 5, 'Sirap Bandung Cincau Ice', '1564416387_menu.png', '4.90', '23423534543534', '45454534343', 'Sirap Bandung Cincau Ice', 1, '2019-07-29 16:06:27', '2022-04-20 05:22:48', 0, NULL, 1),
(18, 1, 4, 'Chrysanthemum Tea', '1564416478_menu.png', '3.90', '987986896986', '68987969679', 'Chrysanthemum Tea', 1, '2019-07-29 16:07:58', '2022-04-20 05:22:48', 0, NULL, 1),
(19, 1, 4, 'Barley', '1564416504_menu.png', '3.90', '7687096696', '986986696', 'Barley', 1, '2019-07-29 16:08:24', '2022-04-20 05:22:48', 0, NULL, 1),
(21, 2, 6, 'BKK Nasi Lemak Original', '1564417295_menu.jpg', '3.90', '85785785875875', '87688585875', 'BKK Nasi Lemak Original', 1, '2019-07-29 16:21:35', '2022-04-20 05:22:48', 0, NULL, 1),
(22, 2, 6, 'BKK Nasi Lemak Ayam Merah', '1564417517_menu.jpg', '5.90', '68768686686868', '8689686698', 'BKK Nasi Lemak Ayam Merah', 1, '2019-07-29 16:25:17', '2022-04-20 05:22:48', 0, NULL, 1),
(23, 2, 6, 'Chee Cheong Fun', '1564417780_menu.jpg', '7.90', '434535345345345', '345345345345', 'Chee Cheong Fun', 1, '2019-07-29 16:29:40', '2022-04-20 05:22:48', 0, NULL, 1),
(24, 2, 6, 'Toast Kaya & Butter', '1564417822_menu.jpg', '3.50', '234535353453', '23423523535345', 'Toast Kaya & Butter', 1, '2019-07-29 16:30:22', '2022-04-20 05:22:48', 0, NULL, 1),
(25, 2, 6, 'Toast Set', '1564417847_menu.jpg', '6.20', '234234234234', '23423423423423', 'Toast Set', 1, '2019-07-29 16:30:47', '2022-04-20 05:22:48', 0, NULL, 1),
(26, 2, 6, 'Half Boiled Egg (Omega 3)', '1564417877_menu.jpg', '3.20', '253454564645', '565646546464', 'Half Boiled Egg (Omega 3)', 1, '2019-07-29 16:31:17', '2022-04-20 05:22:48', 0, NULL, 1),
(27, 1, 5, 'Air Suam', '', '1', '111', '111', NULL, 49, '2019-09-26 04:36:20', '2022-04-20 05:22:48', 0, '2019-09-26 11:36:50', 1),
(28, 1, 2, 'Teh C', '1645605144_menu.jpg', '2.50', '1764531', '9956456465', 'Teh C', 1, '2022-02-23 08:32:24', '2022-04-20 05:22:48', 0, NULL, 1),
(29, 1, 3, 'jolla chiping', '1653625001_menu.jpeg', '23', '23', '1', 'good to eat', 1, '2022-05-25 12:16:57', '2022-05-26 22:46:41', 0, NULL, 1),
(30, 1, 3, 'thanddories', '1653624972_menu.jpeg', '12', '112', '4', 'bad to eat', 1, '2022-05-25 12:19:16', '2022-05-26 22:46:12', 0, NULL, 1),
(31, 1, 3, 'ravai', '1653618033_menu.jpeg', '12', '12', '1', 'wefrwf', 1, '2022-05-27 02:20:33', '2022-05-27 02:20:33', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` varchar(50) DEFAULT NULL,
  `merchant_user_id` int(11) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `merchant_logo` varchar(255) DEFAULT NULL,
  `contact_name` varchar(30) DEFAULT NULL,
  `merchant_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(12) DEFAULT NULL,
  `address` text,
  `post_code` varchar(10) DEFAULT NULL,
  `merchant_category` int(11) DEFAULT NULL,
  `reg_no` varchar(20) DEFAULT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant_id`, `merchant_user_id`, `company_name`, `merchant_logo`, `contact_name`, `merchant_email`, `contact_phone`, `address`, `post_code`, `merchant_category`, `reg_no`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `is_deleted`, `deleted_at`) VALUES
(12, NULL, NULL, 'cogere', '1652698360_merchant.jpg', 'guna', 'cogere@gmail.com', '6780231031', '12,njdjjndjc', '3456782323', 2, '7638268', 'hi hello very', 1, '2022-05-16 10:52:40', '2022-05-16 05:22:49', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_outlet`
--

DROP TABLE IF EXISTS `merchant_outlet`;
CREATE TABLE IF NOT EXISTS `merchant_outlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `merchant_user_id` int(11) DEFAULT NULL,
  `outlet_secret_key` varchar(30) DEFAULT NULL,
  `outlet_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `outlet_address` varchar(255) NOT NULL,
  `outlet_latitude` varchar(25) NOT NULL,
  `outlet_longitude` varchar(25) NOT NULL,
  `outlet_logo` varchar(255) DEFAULT NULL,
  `outlet_phone` varchar(15) NOT NULL,
  `outlet_laneline` varchar(20) DEFAULT NULL,
  `outlet_email` varchar(100) DEFAULT NULL,
  `outlet_discount` varchar(30) DEFAULT NULL,
  `outlet_hours` varchar(50) NOT NULL,
  `primary_outlet` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchant_outlet`
--

INSERT INTO `merchant_outlet` (`id`, `merchant_id`, `merchant_user_id`, `outlet_secret_key`, `outlet_name`, `outlet_address`, `outlet_latitude`, `outlet_longitude`, `outlet_logo`, `outlet_phone`, `outlet_laneline`, `outlet_email`, `outlet_discount`, `outlet_hours`, `primary_outlet`, `created_at`, `updated_at`, `status`, `deleted_at`) VALUES
(1, 1, NULL, 'Fwp2p9JD7FrY87qY', 'Tesco Kepong Village', 'Level 2, No.3 Jalan 7A/62A, Bandar Manjalara 52200 Kepong. Kuala Lumpur', '3.192100', '101.621460', '1563982860_outlet.png', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 1, '2019-07-24 15:38:17', '2022-04-20 05:28:48', 1, NULL),
(2, 1, NULL, 'QsGVbMCYOvIJHytM', 'Nu Sentral, KL Sentral', 'LG Floor, 201, Jalan Tun Sambanthan, Brickfields, 50470 Kuala Lumpur', '3.128360', '101.683770', '1563982825_outlet.png', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '8am-10pm', 0, '2019-07-24 15:40:25', '2022-04-20 05:28:48', 1, NULL),
(3, 1, NULL, 'Z9sfUBrmOygcN0b7', 'Sunway Velocity, KL Cheras', 'LG Floor, Lingkaran SV, Sunway Velocity, Jalan Cheras, Maluri, 55100 Kuala Lumpur', '3.126870', '101.723680', '1563982940_outlet.png', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 0, '2019-07-24 15:42:20', '2022-04-20 05:28:48', 1, NULL),
(4, 1, NULL, 'Q9scyIj2IvfKqUaj', 'Berjaya Times Square, KL City', 'LG Floor. No. 1, Jalan Imbi, 55100 Kuala Lumpur', '3.142670', '101.710340', '1563983077_outlet.jpg', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 0, '2019-07-24 15:44:37', '2022-04-20 05:28:48', 1, NULL),
(5, 1, NULL, 'uO0rO9XMgykKV3S5', 'Sunway Putra Mall, KL City', 'LG Floor, No. 100, Jalan Putra, 50350 Kuala Lumpur', '3.166510', '101.691850', '1563983134_outlet.jpg', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 0, '2019-07-24 15:45:34', '2022-04-20 05:28:48', 1, NULL),
(6, 1, NULL, 'WUkvahrGVXnWOzjo', 'Wangsa Walk Mall, KL', 'G Floor, No. 9, Jalan Wangsa Perdana 1,Bandar Wangsa Maju,53300 Kuala Lumpur', '3.211630', '101.741750', '1563983191_outlet.jpg', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 0, '2019-07-24 15:46:31', '2022-04-20 05:28:48', 1, NULL),
(7, 1, NULL, 'Yo98QAPJ78tuuH2g', 'Publika Shopping Gallery, KL', 'Level UG, 1, Jalan Dutamas, Solaris Dutamas, 50480 Kuala Lumpur', '3.171730', '101.667780', '1563983250_outlet.jpg', '0147120490', NULL, 'LOCALDRINK@BUNGKUSKAWKAW.COM', NULL, '10am-10pm', 0, '2019-07-24 15:47:30', '2022-04-20 05:28:48', 1, NULL),
(9, 8, NULL, 'uZQo9IHJnD6DmTEM', 'stark', '12ondfnnfs', '1', '1', NULL, '567890231938', NULL, 'stark@gmail.com', NULL, '12', 1, '2022-05-02 05:46:26', '2022-05-02 05:46:26', 1, NULL),
(10, 2, NULL, 'w2XD4DVE4Yp50dGO', 'rahuman', '12 uppukara streert', '12', '12', '1652079173_outlet.jpeg', '456726311', NULL, 'as@gmail.com', NULL, '9', 0, '2022-05-09 06:52:53', '2022-05-09 06:52:53', 2, NULL),
(11, 2, NULL, 'RgdAeuc5fbIe0B6O', 'harry', '123,uppukara street', '2', '2', '1652679287_outlet.png', '9876576357', NULL, 'arry@gmaiil.com', NULL, '12', 0, '2022-05-16 04:52:27', '2022-05-16 00:04:47', 1, NULL),
(13, 9, NULL, 'VIweFZpVCFfgiAy8', 'jullah', '234,hallah street', '1', '1', NULL, '9877766567476', NULL, 'jullah@gmail.com', NULL, '12', 1, '2022-05-16 05:45:23', '2022-05-16 05:45:23', 1, NULL),
(20, 11, NULL, 'RKkpzvFVJ7k25rjv', 'patel', '12345dsaihfhadfhhfdahfhd', '1', '1', '1652695832_outlet.jpg', '877263627863', NULL, 'patel@gmail.com', NULL, '12', 0, '2022-05-16 10:10:32', '2022-05-16 10:10:32', 1, NULL),
(21, 11, NULL, 'aTTrNRhRSqiNcDg3', 'hrash', '34512rvjhbwkbdbkbdkab', '11', '11', '1652695857_outlet.jpg', '4569u3982y2', NULL, 'hrash@gmail.com', NULL, '12', 0, '2022-05-16 10:10:57', '2022-05-16 10:10:57', 1, NULL),
(22, 11, NULL, 'fYBw9x4sfYs9EZcn', 'REKHA', '1212bsbKBDASBDSAB', '11', '33', '1652695886_outlet.jpg', '45679320u3', NULL, 'rekha@gmail.com', NULL, '12', 0, '2022-05-16 10:11:26', '2022-05-16 10:11:26', 1, NULL),
(23, 12, NULL, 'ixO4f3yrmcPyCvyZ', 'ranjan', '12,mona nagafr', '1', '1', NULL, '974636e6783', NULL, 'ranjan@gail.com', NULL, '12', 1, '2022-05-16 10:52:40', '2022-05-16 10:52:40', 1, NULL),
(24, 1, NULL, NULL, 'Tesco Kepong Village', 'Tesco Kepong Village', '3.166510', '3.166510', NULL, '77777', NULL, NULL, NULL, '12hours', 0, '2022-10-14 00:00:00', '2022-10-14 06:59:55', 1, NULL),
(25, 1, NULL, NULL, 'Tesco Kepong Village', 'Tesco Kepong Village', '3.166510', '3.166510', NULL, '77777', NULL, NULL, NULL, '12hours', 0, '2022-10-14 00:00:00', '2022-10-14 07:00:13', 1, NULL),
(26, 1, NULL, NULL, 'Tesco Kepong Village', 'Tesco Kepong Village', '3.166510', '3.166510', NULL, '77777', NULL, NULL, NULL, '12hours', 0, '2022-10-14 00:00:00', '2022-10-14 07:00:16', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_04_13_072935_create_permission_tables', 2),
(11, '2022_08_12_054535_create_user_codes_table', 3),
(12, '2022_10_06_102042_create_bills_table', 4),
(13, '2022_10_07_080926_create_role_user_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notify_to` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `notification_icon` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notify_to`, `title`, `short_desc`, `notification_icon`, `created_by`, `created_at`, `deleted_at`, `description`) VALUES
(1, '0', 'test Notification', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '', 1, '2019-12-04 21:20:42', NULL, ''),
(2, '5', 'Hello Test', 'Good night Test notification', '1575471002_voucher.jpeg', 1, '2019-12-04 21:50:02', NULL, ''),
(3, '5', 'Voucher test', 'Voucher test notification', '1575471177_voucher.png', 1, '2019-12-04 21:52:57', NULL, ''),
(4, '5', 'Good night', 'Good night value', '1575473437_voucher.jpg', 1, '2019-12-04 22:30:37', NULL, ''),
(6, '0', 'Test', 'Hello good morning', '1587697647_voucher.png', 1, '2020-04-24 11:07:27', NULL, ''),
(13, '20', 'jothi anna', 'dkjahfhfqehqlkde', '1650620378_voucher.png', 1, '2022-04-22 04:09:38', NULL, ''),
(15, '20', 'jothi anna', 'dkjahfhfqehqlkde', '1650620424_voucher.png', 1, '2022-04-22 04:10:24', NULL, ''),
(18, '1', 'dasdnks', 'dqs a.', '1650620512_voucher.png', 1, '2022-04-22 04:11:52', NULL, ''),
(19, '1', 'dasdnks', 'dqs a.', '1650620536_voucher.png', 1, '2022-04-22 04:12:16', NULL, ''),
(20, '16', 'kishore tony', 'qe;kndkqnkenfknwfknwekfnkwnfwnk', '1650621278_voucher.png', 1, '2022-04-22 04:24:38', NULL, ''),
(21, '1', 'kiran', 'dndlqnldnqe', '1650621332_voucher.png', 1, '2022-04-22 04:25:32', NULL, ''),
(24, '1,5,11', 'qeq', 'eklnlkfekf', '1650625207_voucher.png', 1, '2022-04-22 05:30:07', NULL, ''),
(25, '0', 'hurry', 'fwelgnlrnwg', '1650625350_voucher.png', 1, '2022-04-22 05:32:30', NULL, ''),
(26, '1,5,21', 'kiran kishore', 'gduegiugfgiuewgiuf', '1650625518_voucher.png', 1, '2022-04-22 05:35:18', NULL, ''),
(28, '1,5', 'kim', 'enlkfnklf', '1650689339_voucher.png', 1, '2022-04-22 23:18:59', NULL, ''),
(29, '1', 'sql', 'wsnjndq', '1650690645_voucher.png', 1, '2022-04-22 23:40:45', NULL, ''),
(30, '1', 'jolly', 'dxlkqeelqk', '1650690748_voucher.png', 1, '2022-04-22 23:42:28', NULL, ''),
(31, '5', 'zoho', 'eqmwmwqe', '1650691095_voucher.png', 1, '2022-04-22 23:48:15', NULL, ''),
(32, '5', 'query', 'dsafiugigeieegiqedidq qgduqdqid', '1650691579_voucher.png', 1, '2022-04-22 23:56:19', NULL, ''),
(33, '1', 'red', 'kkekekekkekekek', '1650693098_voucher.png', 1, '2022-04-23 00:21:38', NULL, ''),
(34, '11', 'goodbye', 'ewewew', '1650694091_voucher.jpeg', 1, '2022-04-23 00:38:11', NULL, ''),
(37, '1', 'dragon', 'hdhdhdhdhdhdhd', '1650697041_voucher.png', 1, '2022-04-23 01:27:21', NULL, 'duduudududuudududuuduuddddddd'),
(38, '5', 'ball', 'dmd me d', '1650697089_voucher.png', 1, '2022-04-23 01:28:09', NULL, 'dqsjbjkwdbj kekekfkkenfn nkknf'),
(39, '1', 'goyyy', 'dee', '1650698320_voucher.png', 1, '2022-04-23 01:48:40', NULL, 'dad kandknekddee'),
(40, '1', 'roooyce', 'ewew', '1650698533_voucher.png', 1, '2022-04-23 01:52:13', NULL, 'wewe'),
(41, '1', 'good', 'dnwdkne', '1650698616_voucher.png', 1, '2022-04-23 01:53:36', NULL, 'fefkwblbwlblw'),
(42, '1', 'uyty', 'ewew', '1650698859_voucher.png', 1, '2022-04-23 01:57:39', NULL, 'cjkzbkjfsfsnfjskbf'),
(43, '1', 'eswar', 'dfioejiodje', '1650698963_voucher.png', 1, '2022-04-23 01:59:23', NULL, 'ewjnfjewnfef'),
(44, '11', 'lucifer', 'endlenfln', '1650699166_voucher.png', 1, '2022-04-23 02:02:46', NULL, 'dsfjbjdsbjfjsbjksbjkbfks'),
(46, '11', 'cena', 'swdqdmkmed', '1650699688_voucher.png', 1, '2022-04-23 02:11:28', NULL, 'dwdwdwdwdw'),
(47, '1,5', 'jilla', 'iquwrouiehfioew', '1650861877_voucher.jpg', 1, '2022-04-24 23:14:37', NULL, 'fwejjfbjkwfffweffffwfewcdccdewfwe'),
(48, '1,5', 'raw', 'feiwhlhew', '1650862717_voucher.jpg', 1, '2022-04-24 23:28:37', NULL, 'zxCczzzcx'),
(49, '1,5', 'redf', 'rnkrnknr', '1650862874_voucher.jpg', 1, '2022-04-24 23:31:14', NULL, 'tr;mml;rm;lrfrfrf'),
(50, '1', 'wade', 'trtyreqytrytryrwyq', '1650863327_voucher.jpg', 1, '2022-04-24 23:38:47', NULL, 'qweweqqqeddde'),
(51, '1,5', 'hello guys', 'hi hello frnds', '1651130588_voucher.jpg', 1, '2022-04-28 01:53:08', NULL, 'fdpkfpwkfprwf'),
(52, '1,5', 'hello guys', 'hi hello frnds', '1651130676_voucher.jpg', 1, '2022-04-28 01:54:36', NULL, 'fdpkfpwkfprwf'),
(53, '1', 'hi every one', 'hello this is my mac which i have update now itself', '1652179747_voucher.jpeg', 1, '2022-05-10 05:19:07', NULL, '<p><b>ewugiegirg<u>ehrkhkreht<font color=\"#000000\"><span style=\"background-color: rgb(255, 255, 0);\">rtheiuthiuhreh</span></font></u></b></p>'),
(54, '5', 'hello dudes', 'hi every one have a nice day', '1652697828_voucher.jpg', 1, '2022-05-16 05:13:48', NULL, '<p><b>fkkgkdhjkgkjhkjfg</b></p>');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage dashboard', 'web', '2022-04-13 05:35:34', '2022-04-13 05:35:34'),
(2, 'list dashboard', 'web', '2022-04-13 05:35:34', '2022-04-13 05:35:34'),
(3, 'view dashboard', 'web', '2022-04-13 05:35:34', '2022-04-13 05:35:34'),
(4, 'manage user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(5, 'list user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(6, 'view user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(7, 'create user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(8, 'edit user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(9, 'delete user', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(10, 'manage role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(11, 'list role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(12, 'view role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(13, 'create role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(14, 'edit role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(15, 'delete role', 'web', '2022-04-13 06:10:59', '2022-04-13 06:10:59'),
(16, 'manage merchant', 'web', '2022-04-15 05:27:02', '2022-04-15 05:27:02'),
(17, 'list merchant', 'web', '2022-04-15 05:27:03', '2022-04-15 05:27:03'),
(18, 'view merchant', 'web', '2022-04-15 05:27:03', '2022-04-15 05:27:03'),
(19, 'create merchant', 'web', '2022-04-15 05:27:03', '2022-04-15 05:27:03'),
(20, 'edit merchant', 'web', '2022-04-15 05:27:03', '2022-04-15 05:27:03'),
(21, 'delete merchant', 'web', '2022-04-15 05:27:03', '2022-04-15 05:27:03'),
(22, 'manage app user', 'web', '2022-04-19 05:06:42', '2022-04-19 05:06:42'),
(23, 'list app user', 'web', '2022-04-19 05:06:42', '2022-04-19 05:06:42'),
(24, 'view app user', 'web', '2022-04-19 05:06:42', '2022-04-19 05:06:42'),
(25, 'create app user', 'web', '2022-04-19 05:06:42', '2022-04-19 05:06:42'),
(26, 'edit app user', 'web', '2022-04-19 05:06:43', '2022-04-19 05:06:43'),
(27, 'delete app user', 'web', '2022-04-19 05:06:43', '2022-04-19 05:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`, `expires_at`) VALUES
(7, 'App\\Models\\User', 6, 'access_token', 'ea936f30855ecfd6e54a6f686aff48f2a276c247f61acb7feec69fa13fac0af7', '[\"*\"]', '2022-10-14 04:14:44', '2022-10-13 16:56:58', '2022-10-14 04:14:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Drinks', 1, 1, '2019-07-29 15:51:50', '2022-04-12 09:29:40', NULL),
(2, 'Others', 1, 1, '2019-07-29 16:15:10', '2022-04-12 09:29:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-04-13 05:35:34', '2022-04-13 05:35:34'),
(4, 'Customer', 'web', '2022-05-16 05:19:46', '2022-05-16 05:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-10-06 23:00:00', NULL),
(2, 6, 4, NULL, NULL),
(3, 154, 4, NULL, NULL),
(4, 155, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_key` varchar(30) NOT NULL,
  `_value` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `_key`, `_value`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'rpoint_per_currency', '45', 1, '2022-05-18 11:16:42', '2022-05-18 05:46:42', NULL),
(2, 'max_wallet_amount', '12', 1, '2022-05-11 02:26:59', '2022-05-10 20:56:59', NULL),
(3, 'min_topup_amount', '100', 1, '2022-05-11 02:28:05', '2022-05-10 20:58:05', NULL),
(4, 'max_topup_amount', '500', 1, '2022-05-11 02:28:05', '2022-05-10 20:58:05', NULL),
(5, 'topup_amount_options', '10,20,50,100,500,122', 1, '2022-05-11 02:37:10', '2022-05-10 21:07:10', NULL),
(6, 'rpoint_for_pay', '1', 1, '2022-05-18 11:16:42', '2022-05-18 05:46:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_category_name`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Signature', 1, 1, '2019-07-29 15:52:17', '2022-04-20 05:22:48', NULL),
(2, 1, 'Tea', 1, 1, '2019-07-29 15:52:33', '2022-05-25 06:36:44', NULL),
(3, 1, 'gopi manchurian', 1, 1, '2019-07-29 15:52:43', '2022-05-24 00:59:57', NULL),
(4, 1, 'Herbal Tea', 1, 1, '2019-07-29 15:52:55', '2022-04-20 05:22:48', NULL),
(5, 1, 'Refreshing', 1, 1, '2019-07-29 15:53:12', '2022-04-20 05:22:48', NULL),
(6, 1, 'Food', 1, 1, '2019-07-29 16:15:40', '2022-05-24 01:00:06', NULL),
(7, 1, 'chocloate coffee', 1, 1, '2022-05-25 12:03:27', '2022-05-25 06:33:45', NULL),
(9, 1, 'goa tea', 1, 1, '2022-05-25 12:07:20', '2022-05-25 12:07:20', NULL),
(10, 1, 'BLACK TEA', 1, 1, '2022-05-25 12:08:34', '2022-05-25 12:08:34', NULL),
(11, 1, 'cococola', 2, 1, '2022-05-27 06:08:00', '2022-05-27 00:38:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_unique_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `gender` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donotdisturb` int(11) NOT NULL DEFAULT '0',
  `dob` date DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verified` tinyint(1) DEFAULT '0',
  `is_phone_verified` tinyint(1) DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_pin` text COLLATE utf8mb4_unicode_ci,
  `registered_date` date DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_logged_in` int(11) NOT NULL DEFAULT '0',
  `user_qr_image` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `sign_up_type` int(11) DEFAULT NULL,
  `facebook_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rest_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_unique_id`, `member_id`, `first_name`, `last_name`, `full_name`, `gender`, `user_name`, `referral_code`, `role`, `donotdisturb`, `dob`, `photo`, `country_code`, `phone_number`, `postal_code`, `location`, `state`, `home_phone`, `is_email_verified`, `is_phone_verified`, `email`, `password`, `remember_token`, `transaction_pin`, `registered_date`, `last_login`, `is_approved`, `is_logged_in`, `user_qr_image`, `status`, `sign_up_type`, `facebook_id`, `lang`, `rest_id`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, '', NULL, 'Admin', '', 'john', NULL, 'admin', NULL, 'SUPER_ADMIN', 0, '0000-00-00', '', '', '', NULL, '', '', '', 2, 2, 'admin@walletapp.com', '$2y$10$mNXFMxAiB8TLQfq.2KAqiOgPGmVyo8mSpOuzxDsRyAjnJa0WvRb8q', '4XGz2ZFCPQFfpfGOBRb2LqG0AnYmFhIRKibB3S2WhqOAHm8NT92yj190cCMX', NULL, '0000-00-00', '0000-00-00 00:00:00', 0, 0, '', '1', NULL, NULL, NULL, NULL, '2019-06-10 21:59:29', '2019-07-23 18:15:02', 0, NULL),
(6, 'db2d7893-f1d7-4196-a15d-f2c4f2fa75bb', 'bkk-566606121', 'Tom', 'Ben', 'John Wickson', 'M', 'JohnXA3863', 'XA3863', 'CUSTOMER', 0, '1998-02-21', NULL, '234', '8095686238', '110011', '', '', '', 0, 1, 'joshuaoleru@yahoo.com', '', NULL, NULL, '2022-10-11', '2022-10-13 16:56:58', 0, 1, '', '1', NULL, NULL, NULL, NULL, '2022-10-11 05:03:09', '2022-10-18 05:44:26', 0, NULL),
(154, '8afd3a17-19a2-4f65-8912-f9bf5bd8da46', 'bkk-523918013', 'John', 'Wickson', 'John Wickson', 'M', 'JohnKC2872', 'KC2872', 'CUSTOMER', 0, '1998-02-21', NULL, '234', '4444', '110011', '', '', '', 0, 0, 'chi@gm.com', '', NULL, NULL, '2022-10-11', '2022-10-11 20:59:19', 0, 0, '', '1', NULL, NULL, NULL, NULL, '2022-10-11 06:11:54', '2022-10-13 15:01:19', 0, NULL),
(155, '74e2e51c-d781-4823-8616-f33faae88b44', 'bkk-393899499', 'Hank', 'Winky', 'Hank Winky', 'M', 'JohnZW5409', 'ZW5409', 'CUSTOMER', 0, '1988-07-08', NULL, '234', '555555', '8808088', 'China', 'Shanghai', NULL, 0, 0, 'wink@meet.com', '', NULL, NULL, '2022-10-13', '2022-10-13 15:23:04', 0, 0, NULL, '2', NULL, NULL, NULL, NULL, '2022-10-13 15:21:27', '2022-10-13 15:43:55', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_codes`
--

DROP TABLE IF EXISTS `user_codes`;
CREATE TABLE IF NOT EXISTS `user_codes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_code` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_device_info`
--

DROP TABLE IF EXISTS `user_device_info`;
CREATE TABLE IF NOT EXISTS `user_device_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT 'refer user table',
  `app_version` varchar(20) NOT NULL,
  `device_type` int(11) NOT NULL COMMENT '1-iOS,2-Android',
  `device_token` varchar(255) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `build_no` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_device_info`
--

INSERT INTO `user_device_info` (`id`, `user_id`, `app_version`, `device_type`, `device_token`, `device_id`, `build_no`, `created_at`, `updated_at`) VALUES
(2, 5, '1.0', 1, 'dMwmDTI-wa4:APA91bFSZAXxPI5zW0wWFBYoPvUI8OpeA3ziRY7RrP_335XhIhIGSc8W04AAv7rPWx3kC21yABkQ6o_bPwC3GOf6R84KmmixCxh1TPggSdt0iDTey2NwZUtQc0xpjjTz_1tw3wIpWTRc', '6E1A9CC9-FFBB-4A3D-8662-0D2D709E1A90', '2.5', '2019-12-04 14:51:59', '2022-04-20 05:28:49'),
(3, 5, '1.0', 1, 'dArTe8d7MAg:APA91bEPfxUOD-3hWhIeYM5YTm867080qzgn4n3Iz5KXyUaYMwwJ5s_WkKI6NgRDmiDbk6o7Tgn6NYsXq9U48Qa1ySGh_NM5j_vfn9VsMnSC00dNMusScrjYBbUaVHJ3xZYeSGc8kb4K', '6E1A9CC9-FFBB-4A3D-8662-0D2D709E1A90', '2.6', '2019-12-05 12:52:02', '2022-04-20 05:28:49'),
(4, 79, '1.0', 1, 'dTBwriAo2vo:APA91bFm6NjQEgOL_gsBvj8M-nyTH9EopxUd697H30AKuUN0hF5HsP4nAbhEeFXfEdlb1Ah32F8ckO2czmsKEh1tsolJUvXabtxRDURrTECpQHuocGBE50v_butebgcuFsPSfyg5erJ2', 'D7EA5D97-C45A-4D01-905C-267AE77C0246', '1.0', '2019-12-12 13:37:15', '2022-04-20 05:28:49'),
(5, 80, '2.0', 1, 'fo5lr7eG5pM:APA91bEqhHzRuK3tPtQqdC8qhRjK9cfjO5v8k_X08GDEgUcOpxNimcrnVzvWYrGlpf-2lbebU3XPH27P3WVUnZKbXF1yKJw-xizHjvVsRvKD1EQWz4NYcYXC6OeWpqCgUKAjEYRUr12-', '04EDCC5C-748C-4A36-82D0-B6C8466AA451', '1.0', '2019-12-12 13:55:44', '2022-04-20 05:28:49'),
(6, 5, '1.0', 1, 'cyqjvGuUvgg:APA91bGX0Sqspk2AbwDGDmXVDz6Zzda5gfQEunIlmWodUNFRegigw0-NrhxbmXng4ngXlYCbO4QJc3taivjKteGLexqO0qfahG78opzKYEoi0v1chev02wKRyb4d4-Fpr5kBrh_-QuCb', '6E1A9CC9-FFBB-4A3D-8662-0D2D709E1A90', '2.6', '2022-03-07 13:09:15', '2022-04-20 05:28:49'),
(7, 5, '1.0', 1, 'eOh9sHy7BUD2rUQUGC8Hzh:APA91bH5gJfjrPm-sycO1Z_uwJu-e7g6RzFLSNrj1beUbXzwygFQaBle6N_Vq6b-3tD6uWBXgGmpvJDcsEHMDsFZuCDRHJinJwQTpWJlGUEiCaKlUHnXS_IeHppqIgHRpK-G0T4ah98R', 'CC2D134E-826D-4BEC-881D-8F2BE1D406CE', '1.1', '2022-03-31 21:06:22', '2022-04-20 05:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_infos`
--

DROP TABLE IF EXISTS `user_infos`;
CREATE TABLE IF NOT EXISTS `user_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'References users',
  `area_id` int(11) DEFAULT NULL,
  `wallet_balance` varchar(20) DEFAULT NULL,
  `reward_points` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_infos`
--

INSERT INTO `user_infos` (`id`, `user_id`, `area_id`, `wallet_balance`, `reward_points`, `created_at`, `updated_at`) VALUES
(1, 4, 2, NULL, NULL, '2019-06-25 06:18:01', '2022-04-12 09:29:42'),
(2, 5, 2, NULL, NULL, '2019-06-27 08:09:05', '2022-04-12 09:29:42'),
(3, 6, 2, NULL, NULL, '2019-06-27 19:07:27', '2022-04-12 09:29:42'),
(4, 7, 2, NULL, NULL, '2019-06-27 19:11:01', '2022-04-12 09:29:42'),
(5, 8, 2, NULL, NULL, '2019-06-27 19:13:35', '2022-04-12 09:29:42'),
(6, 9, 2, NULL, NULL, '2019-06-27 19:14:38', '2022-04-12 09:29:42'),
(7, 10, 2, NULL, NULL, '2019-06-27 19:16:56', '2022-04-12 09:29:42'),
(8, 11, 2, NULL, NULL, '2019-06-27 19:18:44', '2022-04-12 09:29:42'),
(9, 13, 2, NULL, NULL, '2019-07-13 12:20:29', '2022-04-12 09:29:42'),
(10, 16, 2, NULL, NULL, '2019-07-13 13:38:24', '2022-04-12 09:29:42'),
(11, 17, 6, NULL, NULL, '2019-07-13 13:43:06', '2022-04-12 09:29:42'),
(12, 19, 2, NULL, NULL, '2019-07-14 15:09:01', '2022-04-12 09:29:42'),
(13, 20, 2, NULL, NULL, '2019-07-14 15:40:56', '2022-04-12 09:29:42'),
(14, 21, 2, NULL, NULL, '2019-07-15 03:16:08', '2022-04-12 09:29:42'),
(15, 22, 3, NULL, NULL, '2019-07-15 03:17:17', '2022-04-12 09:29:42'),
(16, 23, 2, NULL, NULL, '2019-07-20 15:50:28', '2022-04-12 09:29:42'),
(17, 24, 2, NULL, NULL, '2019-07-20 15:57:29', '2022-04-12 09:29:42'),
(18, 25, 2, NULL, NULL, '2019-07-20 16:05:00', '2022-04-12 09:29:42'),
(19, 26, 2, NULL, NULL, '2019-07-20 16:15:36', '2022-04-12 09:29:42'),
(20, 29, 3, NULL, NULL, '2019-07-31 04:52:10', '2022-04-12 09:29:42'),
(21, 39, 28, NULL, NULL, '2019-07-31 05:15:44', '2022-04-12 09:29:42'),
(23, 42, 2, NULL, NULL, '2019-07-31 05:57:46', '2022-04-12 09:29:42'),
(24, 45, 2, NULL, NULL, '2019-07-31 06:33:39', '2022-04-12 09:29:42'),
(26, 47, 3, NULL, NULL, '2019-08-15 08:28:26', '2022-04-12 09:29:42'),
(27, 51, 6, NULL, NULL, '2019-10-11 16:39:09', '2022-04-12 09:29:42'),
(28, 52, 2, NULL, NULL, '2019-10-16 10:43:17', '2022-04-12 09:29:42'),
(29, 53, 4, NULL, NULL, '2019-10-22 22:40:32', '2022-04-12 09:29:42'),
(39, 73, 3, NULL, NULL, '2019-10-29 16:03:19', '2022-04-12 09:29:42'),
(41, 76, 3, NULL, NULL, '2019-10-29 23:50:25', '2022-04-12 09:29:42'),
(42, 77, 3, NULL, NULL, '2019-11-14 01:16:22', '2022-04-12 09:29:42'),
(43, 78, 3, NULL, NULL, '2019-12-05 16:23:54', '2022-04-12 09:29:42'),
(44, 79, 8, NULL, NULL, '2019-12-06 17:46:20', '2022-04-12 09:29:42'),
(45, 80, 3, NULL, NULL, '2019-12-12 03:22:42', '2022-04-12 09:29:42'),
(46, 81, 4, NULL, NULL, '2019-12-21 01:38:21', '2022-04-12 09:29:42'),
(47, 108, NULL, NULL, NULL, '2022-10-05 11:20:12', '2022-10-05 11:20:12'),
(48, 109, NULL, NULL, NULL, '2022-10-05 11:25:41', '2022-10-05 11:25:41'),
(49, 111, NULL, NULL, NULL, '2022-10-05 11:31:18', '2022-10-05 11:31:18'),
(50, 113, NULL, NULL, NULL, '2022-10-05 14:40:15', '2022-10-05 14:40:15'),
(51, 114, NULL, NULL, NULL, '2022-10-05 15:04:51', '2022-10-05 15:04:51'),
(52, 115, NULL, NULL, NULL, '2022-10-05 15:21:00', '2022-10-05 15:21:00'),
(53, 116, NULL, NULL, NULL, '2022-10-05 15:27:18', '2022-10-05 15:27:18'),
(54, 117, NULL, NULL, NULL, '2022-10-05 15:35:13', '2022-10-05 15:35:13'),
(55, 118, NULL, NULL, NULL, '2022-10-05 15:59:31', '2022-10-05 15:59:31'),
(56, 119, NULL, NULL, NULL, '2022-10-06 10:46:22', '2022-10-06 10:46:22'),
(57, 120, NULL, NULL, NULL, '2022-10-07 11:15:19', '2022-10-07 11:15:19'),
(58, 121, NULL, NULL, NULL, '2022-10-07 11:17:36', '2022-10-07 11:17:36'),
(59, 122, NULL, NULL, NULL, '2022-10-07 11:26:53', '2022-10-07 11:26:53'),
(60, 123, NULL, NULL, NULL, '2022-10-07 11:29:04', '2022-10-07 11:29:04'),
(61, 1, NULL, NULL, NULL, '2022-10-10 09:37:35', '2022-10-10 09:37:35'),
(62, 2, NULL, NULL, NULL, '2022-10-10 09:40:18', '2022-10-10 09:40:18'),
(63, 1, NULL, NULL, NULL, '2022-10-10 09:42:23', '2022-10-10 09:42:23'),
(64, 1, NULL, NULL, NULL, '2022-10-10 09:42:56', '2022-10-10 09:42:56'),
(65, 1, NULL, NULL, NULL, '2022-10-10 09:43:48', '2022-10-10 09:43:48'),
(66, 2, NULL, NULL, NULL, '2022-10-10 09:44:19', '2022-10-10 09:44:19'),
(67, 3, NULL, NULL, NULL, '2022-10-10 09:44:57', '2022-10-10 09:44:57'),
(68, 4, NULL, NULL, NULL, '2022-10-10 09:45:55', '2022-10-10 09:45:55'),
(69, 5, NULL, NULL, NULL, '2022-10-10 09:46:56', '2022-10-10 09:46:56'),
(70, 6, NULL, NULL, NULL, '2022-10-10 09:48:07', '2022-10-10 09:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

DROP TABLE IF EXISTS `user_rewards`;
CREATE TABLE IF NOT EXISTS `user_rewards` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `reward_point` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 - Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_rewards`
--

INSERT INTO `user_rewards` (`id`, `user_id`, `member_id`, `reward_point`, `created_at`, `updated_at`, `status`, `deleted_at`) VALUES
(1, 154, 'bkk-523918013', '89.48', '2022-10-13 15:04:29', '2022-10-13 15:30:01', 1, NULL),
(2, 155, 'bkk-393899499', '44.74', '2022-10-13 16:28:13', '2022-10-13 16:28:13', 1, NULL),
(3, 6, 'bkk-566606121', '850.06', '2022-10-13 18:02:08', '2022-10-14 05:14:44', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_reward_history`
--

DROP TABLE IF EXISTS `user_reward_history`;
CREATE TABLE IF NOT EXISTS `user_reward_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `couponcode_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1 - top-up, 2 - paid',
  `amount` decimal(10,2) DEFAULT NULL,
  `rpoint_per_currency` varchar(20) DEFAULT NULL,
  `reward_point` varchar(10) DEFAULT NULL,
  `outlet_id` bigint(20) NOT NULL DEFAULT '0',
  `merchant_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 - Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_reward_history`
--

INSERT INTO `user_reward_history` (`id`, `couponcode_id`, `user_id`, `member_id`, `type`, `amount`, `rpoint_per_currency`, `reward_point`, `outlet_id`, `merchant_id`, `created_by`, `created_at`, `updated_at`, `status`, `deleted_at`) VALUES
(1, 50, 154, 'bkk-523918013', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 15:04:29', '2022-10-13 15:04:29', 1, NULL),
(2, 50, 154, 'bkk-523918013', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 15:30:01', '2022-10-13 15:30:01', 1, NULL),
(3, 50, 155, 'bkk-393899499', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 16:28:13', '2022-10-13 16:28:13', 1, NULL),
(4, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:02:08', '2022-10-13 18:02:08', 1, NULL),
(5, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:03:18', '2022-10-13 18:03:18', 1, NULL),
(6, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:04:41', '2022-10-13 18:04:41', 1, NULL),
(7, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:21:17', '2022-10-13 18:21:17', 1, NULL),
(8, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:22:13', '2022-10-13 18:22:13', 1, NULL),
(9, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:22:47', '2022-10-13 18:22:47', 1, NULL),
(10, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:23:01', '2022-10-13 18:23:01', 1, NULL),
(11, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:23:48', '2022-10-13 18:23:48', 1, NULL),
(12, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:25:18', '2022-10-13 18:25:18', 1, NULL),
(13, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:47:25', '2022-10-13 18:47:25', 1, NULL),
(14, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:48:11', '2022-10-13 18:48:11', 1, NULL),
(15, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-13 18:51:09', '2022-10-13 18:51:09', 1, NULL),
(16, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 04:58:49', '2022-10-14 04:58:49', 1, NULL),
(17, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 04:59:43', '2022-10-14 04:59:43', 1, NULL),
(18, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 05:07:37', '2022-10-14 05:07:37', 1, NULL),
(19, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 05:08:22', '2022-10-14 05:08:22', 1, NULL),
(20, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 05:10:42', '2022-10-14 05:10:42', 1, NULL),
(21, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 05:12:48', '2022-10-14 05:12:48', 1, NULL),
(22, 50, 6, 'bkk-566606121', 2, '44.74', '1', '44.74', 1, 0, 0, '2022-10-14 05:14:44', '2022-10-14 05:14:44', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_wallets`
--

DROP TABLE IF EXISTS `user_wallets`;
CREATE TABLE IF NOT EXISTS `user_wallets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `wallet_address` varchar(255) NOT NULL,
  `wallet_balance` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 - Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_wallets`
--

INSERT INTO `user_wallets` (`id`, `user_id`, `member_id`, `wallet_address`, `wallet_balance`, `created_at`, `updated_at`, `status`, `deleted_at`) VALUES
(1, 154, 'bkk-523918013', 'PB2442', '6986.86', '2022-10-13 15:03:32', '2022-10-13 15:30:01', 1, NULL),
(2, 155, 'bkk-393899499', 'EK7627', '990.98', '2022-10-13 16:27:20', '2022-10-13 16:28:13', 1, NULL),
(3, 6, 'bkk-566606121', 'DR5416', '810.98', '2022-10-13 18:01:56', '2022-10-14 05:14:44', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user__wallet__transactions`
--

DROP TABLE IF EXISTS `user__wallet__transactions`;
CREATE TABLE IF NOT EXISTS `user__wallet__transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wallet_address` varchar(255) NOT NULL,
  `wallet_balance` varchar(255) NOT NULL,
  `rest_id` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '1',
  `request_amount` varchar(255) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `pay_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user__wallet__transactions`
--

INSERT INTO `user__wallet__transactions` (`id`, `transaction_id`, `receipt_no`, `user_id`, `wallet_address`, `wallet_balance`, `rest_id`, `transaction_date`, `transaction_type`, `outlet_id`, `reason`, `status`, `request_amount`, `staff_id`, `pay_id`, `created_at`, `updated_at`) VALUES
(1, '204002', '6TvrsU', 154, 'PB2442', '1000.98', '1', '2022-10-13 15:03:32', '1', 5, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:03:32', '2022-10-13 14:03:32'),
(2, '691350', 'muRoEb', 154, 'PB2442', '990.98', '1', '2022-10-13 15:04:29', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 14:04:29', '2022-10-13 14:04:29'),
(3, '321549', 'PghsCU', 154, 'PB2442', '1991.96', '1', '2022-10-13 15:04:55', '1', 5, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:04:55', '2022-10-13 14:04:55'),
(4, '841088', 'qME9sk', 154, 'PB2442', '2992.94', '1', '2022-10-13 15:05:32', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:05:32', '2022-10-13 14:05:32'),
(5, '423652', 'KgvV7A', 154, 'PB2442', '3993.92', '1', '2022-10-13 15:26:15', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:26:15', '2022-10-13 14:26:15'),
(6, '823423', 'U7Tyht', 154, 'PB2442', '4994.90', '1', '2022-10-13 15:27:42', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:27:42', '2022-10-13 14:27:42'),
(7, '810467', 'AynY8p', 154, 'PB2442', '5995.88', '1', '2022-10-13 15:27:55', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:27:55', '2022-10-13 14:27:55'),
(8, '603698', 'sjSDgI', 154, 'PB2442', '6996.86', '1', '2022-10-13 15:29:02', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 14:29:02', '2022-10-13 14:29:02'),
(9, '864287', 'INOIiK', 154, 'PB2442', '6986.86', '1', '2022-10-13 15:30:01', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 14:30:01', '2022-10-13 14:30:01'),
(10, '398249', 'yijngH', 155, 'EK7627', '1000.98', '1', '2022-10-13 16:27:20', '1', 2, '', '1', '1000.98', 'bkk-393899499', '1', '2022-10-13 15:27:20', '2022-10-13 15:27:20'),
(11, '414447', 'wjPmbg', 155, 'EK7627', '990.98', '1', '2022-10-13 16:28:13', '2', 1, '', '1', '10.00', 'bkk-393899499', '1', '2022-10-13 15:28:13', '2022-10-13 15:28:13'),
(12, '750417', 'ASgPPe', 6, 'DR5416', '1000.98', '1', '2022-10-13 18:01:57', '1', 2, '', '1', '1000.98', 'bkk-566606121', '1', '2022-10-13 17:01:57', '2022-10-13 17:01:57'),
(13, '495146', 'ekT7Zb', 6, 'DR5416', '990.98', '1', '2022-10-13 18:02:08', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:02:08', '2022-10-13 17:02:08'),
(14, '669147', 'OWMmdX', 6, 'DR5416', '980.98', '1', '2022-10-13 18:03:18', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:03:18', '2022-10-13 17:03:18'),
(15, '818114', 'eWlpal', 6, 'DR5416', '970.98', '1', '2022-10-13 18:04:41', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:04:41', '2022-10-13 17:04:41'),
(16, '521782', 'rt6LV2', 6, 'DR5416', '960.98', '1', '2022-10-13 18:21:17', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:21:17', '2022-10-13 17:21:17'),
(17, '528715', 'OOMJCt', 6, 'DR5416', '950.98', '1', '2022-10-13 18:22:13', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:22:13', '2022-10-13 17:22:13'),
(18, '582910', 'poRIBF', 6, 'DR5416', '940.98', '1', '2022-10-13 18:22:47', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:22:47', '2022-10-13 17:22:47'),
(19, '611629', 's3BMXp', 6, 'DR5416', '930.98', '1', '2022-10-13 18:23:01', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:23:01', '2022-10-13 17:23:01'),
(20, '122217', 'WrP8j2', 6, 'DR5416', '920.98', '1', '2022-10-13 18:23:48', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:23:48', '2022-10-13 17:23:48'),
(21, '247514', 'UiDh0p', 6, 'DR5416', '910.98', '1', '2022-10-13 18:25:18', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:25:18', '2022-10-13 17:25:18'),
(22, '295468', '8S7Tdp', 6, 'DR5416', '900.98', '1', '2022-10-13 18:47:25', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:47:25', '2022-10-13 17:47:25'),
(23, '585772', 'H77rEi', 6, 'DR5416', '890.98', '1', '2022-10-13 18:48:10', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:48:10', '2022-10-13 17:48:10'),
(24, '493375', '4GGWeW', 6, 'DR5416', '880.98', '1', '2022-10-13 18:51:08', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-13 17:51:09', '2022-10-13 17:51:09'),
(25, '701218', 'M0eTBS', 6, 'DR5416', '870.98', '1', '2022-10-14 04:58:49', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 03:58:49', '2022-10-14 03:58:49'),
(26, '466090', 'ni0ysy', 6, 'DR5416', '860.98', '1', '2022-10-14 04:59:43', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 03:59:43', '2022-10-14 03:59:43'),
(27, '409779', '3NoNRA', 6, 'DR5416', '850.98', '1', '2022-10-14 05:07:37', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 04:07:37', '2022-10-14 04:07:37'),
(28, '296850', 'lo85A3', 6, 'DR5416', '840.98', '1', '2022-10-14 05:08:22', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 04:08:22', '2022-10-14 04:08:22'),
(29, '547189', 'GtiqL8', 6, 'DR5416', '830.98', '1', '2022-10-14 05:10:42', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 04:10:42', '2022-10-14 04:10:42'),
(30, '117124', 'RKZdot', 6, 'DR5416', '820.98', '1', '2022-10-14 05:12:48', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 04:12:48', '2022-10-14 04:12:48'),
(31, '880562', 'dc0ZfE', 6, 'DR5416', '810.98', '1', '2022-10-14 05:14:44', '2', 1, '', '1', '10.00', 'bkk-566606121', '1', '2022-10-14 04:14:44', '2022-10-14 04:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `outlet_ids` varchar(255) DEFAULT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `voucher_code` varchar(30) DEFAULT NULL,
  `voucher_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `voucher_description` text CHARACTER SET utf8 NOT NULL,
  `sale_start_date` date NOT NULL,
  `sale_end_date` date NOT NULL,
  `validity_period` varchar(11) NOT NULL,
  `applicable_to_items` varchar(255) NOT NULL,
  `buy_voucher_with` json NOT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `voucher_value` float DEFAULT NULL,
  `max_discount_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `total_required_points` int(11) DEFAULT NULL,
  `voucher_image` varchar(255) DEFAULT NULL,
  `tAndC` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `max_qty` int(11) DEFAULT NULL,
  `single_user_qty` int(11) DEFAULT NULL,
  `free_voucher_type` varchar(30) DEFAULT NULL,
  `group_id` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `outlet_ids`, `voucher_type_id`, `voucher_code`, `voucher_name`, `voucher_description`, `sale_start_date`, `sale_end_date`, `validity_period`, `applicable_to_items`, `buy_voucher_with`, `discount_type`, `voucher_value`, `max_discount_amount`, `total_required_points`, `voucher_image`, `tAndC`, `max_qty`, `single_user_qty`, `free_voucher_type`, `group_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, '1,4', 2, 'v-bkksub1579710299509', 'TestVoucher', 'fffffff', '2022-10-05', '2022-10-27', '3', '1,2', '[{\"points\": \"3\", \"wallet_credit\": null}]', 1, 3, 3.00, NULL, '', 'gggggg', 3, 3, NULL, 'rZAMrS', 1, 1, '2022-10-18 21:59:23', '2022-10-19 15:02:28', NULL, 1),
(2, '1,4', 2, 'v-bkksub1985310157515', 'TestVoucher', 'fffffff', '2022-10-05', '2022-10-11', '3', '1,2', '[{\"points\": \"3\", \"wallet_credit\": null}]', 1, 3, 3.00, NULL, '', 'gggggg', 3, 3, 'birthday', 'rZAMrS', 1, NULL, '2022-10-18 21:59:23', '2022-10-19 15:02:32', NULL, 3),
(3, '1,4', 2, 'v-bkksub1575710149521', 'TestVoucher', 'fffffff', '2022-10-05', '2022-10-11', '3', '1,2', '[{\"points\": \"3\", \"wallet_credit\": null}]', 1, 3, 3.00, NULL, '', 'gggggg', 3, 3, 'welcome', 'rZAMrS', 1, 1, '2022-10-18 21:59:23', '2022-10-19 15:02:37', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_type`
--

DROP TABLE IF EXISTS `voucher_type`;
CREATE TABLE IF NOT EXISTS `voucher_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `type_id` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1. Active, 2. Inactive, 3. Deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher_type`
--

INSERT INTO `voucher_type` (`id`, `type_name`, `type_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test', '234', 1, '2020-05-08 10:04:35', '2022-04-20 05:28:49', NULL),
(2, 'Summerer', '134', 1, '2020-05-08 10:12:31', '2022-04-21 09:01:03', NULL),
(4, 'kishore kiran', '11111', 1, '2022-04-21 14:31:21', '2022-04-21 09:06:48', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
