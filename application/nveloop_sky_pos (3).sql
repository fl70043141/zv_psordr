-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2018 at 01:37 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nveloop_sky_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE IF NOT EXISTS `addons` (
  `id` int(11) NOT NULL,
  `addon_name` varchar(50) NOT NULL,
  `addon_type` int(10) NOT NULL COMMENT '1:addition,2:substracr',
  `calculation_type` int(10) NOT NULL COMMENT '1-Fixed Amount,2-percentage_included,3-percentage_not_included',
  `calculation_included` text NOT NULL,
  `calculation_included_addons` text NOT NULL,
  `addon_value` double NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `active_from` int(15) NOT NULL,
  `active_to` int(15) NOT NULL,
  `ignore_end_date` int(2) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `addon_name`, `addon_type`, `calculation_type`, `calculation_included`, `calculation_included_addons`, `addon_value`, `currency_code`, `description`, `active_from`, `active_to`, `ignore_end_date`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Discount', 2, 2, '', '', 5, 'LKR', 'test Descrep', 1, 1, 0, 1, '0000-00-00', 0, '2018-08-03', 1, 0, '0000-00-00', 0),
(2, 'NBT', 1, 2, '["1"]', '', 10, '', '', 1, 1, 0, 0, '2017-08-31', 1, '2017-09-28', 1, 0, '0000-00-00', 0),
(3, 'VAT', 1, 2, '["2"]', '', 11, 'LKR', 'Government Tax', 1514745000, 1546194600, 1, 1, '2017-08-31', 1, '2018-10-09', 1, 0, '0000-00-00', 0),
(4, 'NBT2', 1, 1, '', '', 811, 'LKR', 'sdadadasda dada', 8, 10, 0, 0, '2017-08-31', 1, '0000-00-00', 0, 1, '2017-08-31', 1),
(5, 'Service Charges', 1, 1, '', '', 1800, 'LKR', 'Hotel Service charge', 1514745000, 1546194600, 1, 1, '2017-08-31', 1, '2018-10-09', 1, 0, '0000-00-00', 0),
(6, 'Staff Discount', 2, 2, '["1","2"]', '', 40, 'LKR', 'Discount for resort and shop staff', 1514745000, 1546194600, 1, 1, '2018-10-09', 1, '2018-10-09', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `addon_calculation_included`
--

CREATE TABLE IF NOT EXISTS `addon_calculation_included` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` int(1) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addon_calculation_included`
--

INSERT INTO `addon_calculation_included` (`id`, `name`, `status`, `deleted`) VALUES
(1, 'Tarrifs', 1, 0),
(2, 'All Bills', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` smallint(6) NOT NULL,
  `account_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` smallint(6) NOT NULL DEFAULT '0' COMMENT '1:current,2:saving',
  `bank_account_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_address` tinytext COLLATE utf8_unicode_ci,
  `bank_curr_code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dflt_curr_act` tinyint(1) NOT NULL DEFAULT '0',
  `bank_charge_act` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_reconciled_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ending_reconcile_balance` double NOT NULL DEFAULT '0',
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `account_code`, `account_type`, `bank_account_name`, `bank_account_number`, `bank_name`, `bank_address`, `bank_curr_code`, `dflt_curr_act`, `bank_charge_act`, `last_reconciled_date`, `ending_reconcile_balance`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(2, 'COMPANY_AC', 1, 'Ahsan Gems - CB', '1234556789', 'Commercial Bank', 'Beruwela', 'LKR', 1, '1', '0000-00-00 00:00:00', 0, 1, '2018-07-04', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_banner`
--

CREATE TABLE IF NOT EXISTS `cms_banner` (
  `id` int(11) NOT NULL,
  `banner_name` varchar(50) NOT NULL,
  `type` varchar(25) NOT NULL,
  `image` text NOT NULL,
  `image_loc` varchar(200) NOT NULL,
  `data_json` text NOT NULL,
  `status` int(3) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_banner`
--

INSERT INTO `cms_banner` (`id`, `banner_name`, `type`, `image`, `image_loc`, `data_json`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Home Page Sliders', '', '', '', '{"1":{"title":"Nveloop Solutions","desc":"Complete Restaurant Solution","order":"1","texts":"","link":"","status":"1","image_name":"1 (1).jpg"},"2":{"title":"Nveloop Gem Solution","desc":"Controll your business with Nveloop Easy Gem Merchant Software","order":"2","texts":"","link":"","status":"1","image_name":"2 (1).jpg"},"3":{"title":"Garage Software","desc":"Garage Management with Rent car Reservation","order":"3","texts":"","link":"","status":"1","image_name":"3 (1).jpg"}}', 1, '2017-07-31', 1, '2018-08-08', 1, 0, '0000-00-00', 0),
(2, 'Popular Destinations', '', '', '', '{"1":{"title":"Sigiriya Rock1","desc":"North Central","order":"1","texts":"","link":"www.sigiriya.com","status":"1","image_name":"1.jpg"},"2":{"title":"Hortan plain1","desc":"Nuwera Eliya Nature1","order":"2","texts":"","link":"www.sigiriya.com","status":"1","image_name":"2.jpg"},"3":{"title":"Ayurvedic 1","desc":"Best Health Treatments1","order":"3","texts":"","link":"www.sigiriya.com","status":"1","image_name":"3.jpg"},"4":{"title":"Souther Beaches","desc":"Tropical beach stay","order":"4","texts":"","link":"www.abc.cin","status":"1","image_name":"4 (1).jpg"}}', 1, '2017-07-31', 1, '2017-08-04', 1, 0, '0000-00-00', 0),
(3, 'Featured Holiday Activities', '', '', '', '{"1":{"title":"Sigiriya Rock","desc":"great place ancient","order":"1","texts":"","link":"","status":"1","image_name":"Sigiriya.jpg"},"2":{"title":"Hortan plain1","desc":"Nuwera Eliya Nature","order":"1","texts":"","link":"","status":"1","image_name":"HortanPlains.jpg"}}', 1, '2017-07-31', 1, '2017-08-04', 1, 0, '0000-00-00', 0),
(4, 'Featured Destinations', '', '', '', '{"1":{"title":"Water Rafting","desc":"kitulgala Water Rafting Adventure trip","order":"1","texts":"","link":"","status":"1","image_name":"1.jpg"},"2":{"title":"Bentota","desc":"Water Sports on Ocean","order":"2","texts":"","link":"","status":"1","image_name":"2.jpg"},"3":{"title":"Horain Plains","desc":"Nature beauty","order":"3","texts":"","link":"","status":"1","image_name":"3.jpg"},"4":{"title":"Souther Beaches","desc":"Tropical","order":"4","texts":"","link":"","status":"1","image_name":"4.jpg"},"5":{"title":"Featured Destinations","desc":"Best Stay","order":"5","texts":"","link":"","status":"1","image_name":"HortanPlains (1).jpg"},"6":{"title":"Souther Beaches","desc":"Longest Beach","order":"6","texts":"","link":"","status":"1","image_name":"travel-17.jpg"}}', 1, '2017-07-31', 1, '2017-08-04', 1, 0, '0000-00-00', 0),
(5, 'Featured Holiday Activities test', '', '', '', '{"1":{"title":"Leasure World","desc":"3 Activities","order":"1","texts":"Full Package--$30,Watare Sports--$120,Child Package--360","link":"leisureworld.lk","status":"1","image_name":"4.jpg"},"2":{"title":"Kithulgala","desc":"3 Activities","order":"2","texts":"Full Package--$30,Watare Sports--$120,Child Package--360","link":"watersport.lk","status":"1","image_name":"2.jpg"},"3":{"title":"Village Activities","desc":"3 Activities","order":"3","texts":"Full Package--$30,Watare Sports--$120,Child Package--360","link":"www.kithulgala.lk","status":"1","image_name":"3.jpg"}}', 1, '2017-07-31', 1, '2017-07-31', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `street_address` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `other_phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `website` varchar(100) NOT NULL,
  `company_type` varchar(50) NOT NULL,
  `company_grade` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `currency_code` varchar(5) NOT NULL DEFAULT 'LKR',
  `status` int(11) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `street_address`, `address2`, `city`, `state`, `country`, `zipcode`, `phone`, `fax`, `other_phone`, `email`, `website`, `company_type`, `company_grade`, `reg_no`, `logo`, `currency_code`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Nveloop Gem & Jewellers', 'No 146, Galle Road', '', 'Kaluthara South', 'WP', 'LK', '12070', '+9411 4503 047', '+9411 4503 047', '+9477 5440 889', 'info@nveloopjewelry.com', 'www.nveloop.com', 'Software', '', '', 'logo_1.jpg', 'LKR', 1, '2017-09-13', 1, '2018-09-25', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `consignees`
--

CREATE TABLE IF NOT EXISTS `consignees` (
  `id` int(11) NOT NULL,
  `consignee_name` varchar(120) NOT NULL,
  `consignee_short_name` varchar(30) NOT NULL,
  `description` varchar(400) NOT NULL,
  `address` varchar(400) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `phone2` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bank_acc_number` varchar(50) NOT NULL,
  `bank_acc_name` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_acc_branch` varchar(100) NOT NULL,
  `commission_plan` int(5) NOT NULL,
  `commission_amount` double NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignee_commission`
--

CREATE TABLE IF NOT EXISTS `consignee_commission` (
  `id` int(11) NOT NULL,
  `transection_type` int(10) NOT NULL COMMENT '1:purchase,2:sales',
  `trans_ref` int(20) NOT NULL,
  `consignee_id` int(10) NOT NULL,
  `commission_plan` int(10) NOT NULL,
  `commision_unit` double NOT NULL,
  `commision_amount` double NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignee_recieve`
--

CREATE TABLE IF NOT EXISTS `consignee_recieve` (
  `id` int(11) NOT NULL,
  `cr_no` varchar(25) NOT NULL,
  `consignee_id` int(15) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `recieve_date` int(20) NOT NULL,
  `payment_term_id` int(5) NOT NULL,
  `currency_code` varchar(20) NOT NULL DEFAULT 'LKR',
  `currency_value` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignee_recieve_description`
--

CREATE TABLE IF NOT EXISTS `consignee_recieve_description` (
  `id` int(11) NOT NULL,
  `cr_id` int(20) NOT NULL,
  `cs_no` varchar(25) NOT NULL,
  `item_id` int(20) NOT NULL,
  `item_desc` varchar(100) NOT NULL,
  `item_quantity` double NOT NULL,
  `item_quantity_2` double NOT NULL,
  `item_quantity_uom_id` int(10) NOT NULL,
  `item_quantity_uom_id_2` int(10) NOT NULL,
  `unit_price` double NOT NULL,
  `discount_persent` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignee_submission`
--

CREATE TABLE IF NOT EXISTS `consignee_submission` (
  `id` int(11) NOT NULL,
  `cs_no` varchar(25) NOT NULL,
  `consignee_id` int(15) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `submitted_date` int(20) NOT NULL,
  `sales_type_id` int(10) NOT NULL DEFAULT '0',
  `discount_type` int(5) NOT NULL COMMENT '1:percentage,2:fixed amount',
  `discount_value` double NOT NULL,
  `payement_term_id` int(5) NOT NULL,
  `currency_code` varchar(20) NOT NULL DEFAULT 'LKR',
  `currency_value` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignee_submission_description`
--

CREATE TABLE IF NOT EXISTS `consignee_submission_description` (
  `id` int(11) NOT NULL,
  `cs_id` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `item_quantity` double NOT NULL,
  `item_quantity_2` double NOT NULL,
  `item_quantity_uom_id` int(10) NOT NULL,
  `item_quantity_uom_id_2` int(10) NOT NULL,
  `unit_price` double NOT NULL,
  `discount_persent` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `deleted` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `lat`, `lng`, `status`, `deleted`) VALUES
(1, 'US', 'United States', '38', '-97', 1, 0),
(2, 'CA', 'Canada', '60', '-95', 1, 0),
(3, 'AF', 'Afghanistan', '33', '65', 1, 0),
(4, 'AL', 'Albania', '41', '20', 1, 0),
(5, 'DZ', 'Algeria', '28', '3', 1, 0),
(6, 'DS', 'American Samoa', '', '', 1, 0),
(7, 'AD', 'Andorra', '42.5', '1.5', 1, 0),
(8, 'AO', 'Angola', '-12.5', '18.5', 1, 0),
(9, 'AI', 'Anguilla', '18.25', '-63.16666666', 1, 0),
(10, 'AQ', 'Antarctica', '-90', '0', 1, 0),
(11, 'AG', 'Antigua and/or Barbuda', '17.05', '-61.8', 1, 0),
(12, 'AR', 'Argentina', '-34', '-64', 1, 0),
(13, 'AM', 'Armenia', '40', '45', 1, 0),
(14, 'AW', 'Aruba', '12.5', '-69.96666666', 1, 0),
(15, 'AU', 'Australia', '-27', '133', 1, 0),
(16, 'AT', 'Austria', '47.33333333', '13.33333333', 1, 0),
(17, 'AZ', 'Azerbaijan', '40.5', '47.5', 1, 0),
(18, 'BS', 'Bahamas', '24.25', '-76', 1, 0),
(19, 'BH', 'Bahrain', '26', '50.55', 1, 0),
(20, 'BD', 'Bangladesh', '24', '90', 1, 0),
(21, 'BB', 'Barbados', '13.16666666', '-59.53333333', 1, 0),
(22, 'BY', 'Belarus', '53', '28', 1, 0),
(23, 'BE', 'Belgium', '50.83333333', '4', 1, 0),
(24, 'BZ', 'Belize', '17.25', '-88.75', 1, 0),
(25, 'BJ', 'Benin', '9.5', '2.25', 1, 0),
(26, 'BM', 'Bermuda', '32.33333333', '-64.75', 1, 0),
(27, 'BT', 'Bhutan', '27.5', '90.5', 1, 0),
(28, 'BO', 'Bolivia', '-17', '-65', 1, 0),
(29, 'BA', 'Bosnia and Herzegovina', '44', '18', 1, 0),
(30, 'BW', 'Botswana', '-22', '24', 1, 0),
(31, 'BV', 'Bouvet Island', '-54.43333333', '3.4', 1, 0),
(32, 'BR', 'Brazil', '-10', '-55', 1, 0),
(33, 'IO', 'British Indian Ocean Territory', '-6', '71.5', 1, 0),
(34, 'BN', 'Brunei Darussalam', '4.5', '114.66666666', 1, 0),
(35, 'BG', 'Bulgaria', '43', '25', 1, 0),
(36, 'BF', 'Burkina Faso', '13', '-2', 1, 0),
(37, 'BI', 'Burundi', '-3.5', '30', 1, 0),
(38, 'KH', 'Cambodia', '13', '105', 1, 0),
(39, 'CM', 'Cameroon', '6', '12', 1, 0),
(40, 'CV', 'Cape Verde', '16', '-24', 1, 0),
(41, 'KY', 'Cayman Islands', '19.5', '-80.5', 1, 0),
(42, 'CF', 'Central African Republic', '7', '21', 1, 0),
(43, 'TD', 'Chad', '15', '19', 1, 0),
(44, 'CL', 'Chile', '-30', '-71', 1, 0),
(45, 'CN', 'China', '35', '105', 1, 0),
(46, 'CX', 'Christmas Island', '-10.5', '105.66666666', 1, 0),
(47, 'CC', 'Cocos (Keeling) Islands', '-12.5', '96.83333333', 1, 0),
(48, 'CO', 'Colombia', '4', '-72', 1, 0),
(49, 'KM', 'Comoros', '-12.16666666', '44.25', 1, 0),
(50, 'CG', 'Congo', '-1', '15', 1, 0),
(51, 'CK', 'Cook Islands', '-21.23333333', '-159.76666666', 1, 0),
(52, 'CR', 'Costa Rica', '10', '-84', 1, 0),
(53, 'HR', 'Croatia (Hrvatska)', '45.16666666', '15.5', 1, 0),
(54, 'CU', 'Cuba', '21.5', '-80', 1, 0),
(55, 'CY', 'Cyprus', '35', '33', 1, 0),
(56, 'CZ', 'Czech Republic', '49.75', '15.5', 1, 0),
(57, 'DK', 'Denmark', '56', '10', 1, 0),
(58, 'DJ', 'Djibouti', '11.5', '43', 1, 0),
(59, 'DM', 'Dominica', '15.41666666', '-61.33333333', 1, 0),
(60, 'DO', 'Dominican Republic', '19', '-70.66666666', 1, 0),
(61, 'TP', 'East Timor', '', '', 1, 0),
(62, 'EC', 'Ecuador', '-2', '-77.5', 1, 0),
(63, 'EG', 'Egypt', '27', '30', 1, 0),
(64, 'SV', 'El Salvador', '13.83333333', '-88.91666666', 1, 0),
(65, 'GQ', 'Equatorial Guinea', '2', '10', 1, 0),
(66, 'ER', 'Eritrea', '15', '39', 1, 0),
(67, 'EE', 'Estonia', '59', '26', 1, 0),
(68, 'ET', 'Ethiopia', '8', '38', 1, 0),
(69, 'FK', 'Falkland Islands (Malvinas)', '-51.75', '-59', 1, 0),
(70, 'FO', 'Faroe Islands', '62', '-7', 1, 0),
(71, 'FJ', 'Fiji', '-18', '175', 1, 0),
(72, 'FI', 'Finland', '64', '26', 1, 0),
(73, 'FR', 'France', '46', '2', 1, 0),
(74, 'FX', 'France, Metropolitan', '', '', 1, 0),
(75, 'GF', 'French Guiana', '4', '-53', 1, 0),
(76, 'PF', 'French Polynesia', '-15', '-140', 1, 0),
(77, 'TF', 'French Southern Territories', '-49.25', '69.167', 1, 0),
(78, 'GA', 'Gabon', '-1', '11.75', 1, 0),
(79, 'GM', 'Gambia', '13.46666666', '-16.56666666', 1, 0),
(80, 'GE', 'Georgia', '42', '43.5', 1, 0),
(81, 'DE', 'Germany', '51', '9', 1, 0),
(82, 'GH', 'Ghana', '8', '-2', 1, 0),
(83, 'GI', 'Gibraltar', '36.13333333', '-5.35', 1, 0),
(246, 'GK', 'Guernsey', '', '', 1, 0),
(84, 'GR', 'Greece', '39', '22', 1, 0),
(85, 'GL', 'Greenland', '72', '-40', 1, 0),
(86, 'GD', 'Grenada', '12.11666666', '-61.66666666', 1, 0),
(87, 'GP', 'Guadeloupe', '16.25', '-61.583333', 1, 0),
(88, 'GU', 'Guam', '13.46666666', '144.78333333', 1, 0),
(89, 'GT', 'Guatemala', '15.5', '-90.25', 1, 0),
(90, 'GN', 'Guinea', '11', '-10', 1, 0),
(91, 'GW', 'Guinea-Bissau', '12', '-15', 1, 0),
(92, 'GY', 'Guyana', '5', '-59', 1, 0),
(93, 'HT', 'Haiti', '19', '-72.41666666', 1, 0),
(94, 'HM', 'Heard and Mc Donald Islands', '-53.1', '72.51666666', 1, 0),
(95, 'HN', 'Honduras', '15', '-86.5', 1, 0),
(96, 'HK', 'Hong Kong', '22.267', '114.188', 1, 0),
(97, 'HU', 'Hungary', '47', '20', 1, 0),
(98, 'IS', 'Iceland', '65', '-18', 1, 0),
(99, 'IN', 'India', '20', '77', 1, 0),
(244, 'IM', 'Isle of Man', '54.25', '-4.5', 1, 0),
(100, 'ID', 'Indonesia', '-5', '120', 1, 0),
(101, 'IR', 'Iran (Islamic Republic of)', '32', '53', 1, 0),
(102, 'IQ', 'Iraq', '33', '44', 1, 0),
(103, 'IE', 'Ireland', '53', '-8', 1, 0),
(104, 'IL', 'Israel', '31.47', '35.13', 1, 0),
(105, 'IT', 'Italy', '42.83333333', '12.83333333', 1, 0),
(106, 'CI', 'Ivory Coast', '8', '-5', 1, 0),
(245, 'JE', 'Jersey', '49.25', '-2.16666666', 1, 0),
(107, 'JM', 'Jamaica', '18.25', '-77.5', 1, 0),
(108, 'JP', 'Japan', '36', '138', 1, 0),
(109, 'JO', 'Jordan', '31', '36', 1, 0),
(110, 'KZ', 'Kazakhstan', '48', '68', 1, 0),
(111, 'KE', 'Kenya', '1', '38', 1, 0),
(112, 'KI', 'Kiribati', '1.41666666', '173', 1, 0),
(113, 'KP', 'Korea, Democratic People''s Republic of', '40', '127', 1, 0),
(114, 'KR', 'Korea, Republic of', '37', '127.5', 1, 0),
(115, 'XK', 'Kosovo', '42.666667', '21.166667', 1, 0),
(116, 'KW', 'Kuwait', '29.5', '45.75', 1, 0),
(117, 'KG', 'Kyrgyzstan', '41', '75', 1, 0),
(118, 'LA', 'Lao People''s Democratic Republic', '18', '105', 1, 0),
(119, 'LV', 'Latvia', '57', '25', 1, 0),
(120, 'LB', 'Lebanon', '33.83333333', '35.83333333', 1, 0),
(121, 'LS', 'Lesotho', '-29.5', '28.5', 1, 0),
(122, 'LR', 'Liberia', '6.5', '-9.5', 1, 0),
(123, 'LY', 'Libyan Arab Jamahiriya', '25', '17', 1, 0),
(124, 'LI', 'Liechtenstein', '47.26666666', '9.53333333', 1, 0),
(125, 'LT', 'Lithuania', '56', '24', 1, 0),
(126, 'LU', 'Luxembourg', '49.75', '6.16666666', 1, 0),
(127, 'MO', 'Macau', '22.16666666', '113.55', 1, 0),
(128, 'MK', 'Macedonia', '41.83333333', '22', 1, 0),
(129, 'MG', 'Madagascar', '-20', '47', 1, 0),
(130, 'MW', 'Malawi', '-13.5', '34', 1, 0),
(131, 'MY', 'Malaysia', '2.5', '112.5', 1, 0),
(132, 'MV', 'Maldives', '3.25', '73', 1, 0),
(133, 'ML', 'Mali', '17', '-4', 1, 0),
(134, 'MT', 'Malta', '35.83333333', '14.58333333', 1, 0),
(135, 'MH', 'Marshall Islands', '9', '168', 1, 0),
(136, 'MQ', 'Martinique', '14.666667', '-61', 1, 0),
(137, 'MR', 'Mauritania', '20', '-12', 1, 0),
(138, 'MU', 'Mauritius', '-20.28333333', '57.55', 1, 0),
(139, 'TY', 'Mayotte', '', '', 1, 0),
(140, 'MX', 'Mexico', '23', '-102', 1, 0),
(141, 'FM', 'Micronesia, Federated States of', '6.91666666', '158.25', 1, 0),
(142, 'MD', 'Moldova, Republic of', '47', '29', 1, 0),
(143, 'MC', 'Monaco', '43.73333333', '7.4', 1, 0),
(144, 'MN', 'Mongolia', '46', '105', 1, 0),
(145, 'ME', 'Montenegro', '42.5', '19.3', 1, 0),
(146, 'MS', 'Montserrat', '16.75', '-62.2', 1, 0),
(147, 'MA', 'Morocco', '32', '-5', 1, 0),
(148, 'MZ', 'Mozambique', '-18.25', '35', 1, 0),
(149, 'MM', 'Myanmar', '22', '98', 1, 0),
(150, 'NA', 'Namibia', '-22', '17', 1, 0),
(151, 'NR', 'Nauru', '-0.53333333', '166.91666666', 1, 0),
(152, 'NP', 'Nepal', '28', '84', 1, 0),
(153, 'NL', 'Netherlands', '52.5', '5.75', 1, 0),
(154, 'AN', 'Netherlands Antilles', '', '', 1, 0),
(155, 'NC', 'New Caledonia', '-21.5', '165.5', 1, 0),
(156, 'NZ', 'New Zealand', '-41', '174', 1, 0),
(157, 'NI', 'Nicaragua', '13', '-85', 1, 0),
(158, 'NE', 'Niger', '16', '8', 1, 0),
(159, 'NG', 'Nigeria', '10', '8', 1, 0),
(160, 'NU', 'Niue', '-19.03333333', '-169.86666666', 1, 0),
(161, 'NF', 'Norfolk Island', '-29.03333333', '167.95', 1, 0),
(162, 'MP', 'Northern Mariana Islands', '15.2', '145.75', 1, 0),
(163, 'NO', 'Norway', '62', '10', 1, 0),
(164, 'OM', 'Oman', '21', '57', 1, 0),
(165, 'PK', 'Pakistan', '30', '70', 1, 0),
(166, 'PW', 'Palau', '7.5', '134.5', 1, 0),
(243, 'PS', 'Palestine', '31.9', '35.2', 1, 0),
(167, 'PA', 'Panama', '9', '-80', 1, 0),
(168, 'PG', 'Papua New Guinea', '-6', '147', 1, 0),
(169, 'PY', 'Paraguay', '-23', '-58', 1, 0),
(170, 'PE', 'Peru', '-10', '-76', 1, 0),
(171, 'PH', 'Philippines', '13', '122', 1, 0),
(172, 'PN', 'Pitcairn', '-25.06666666', '-130.1', 1, 0),
(173, 'PL', 'Poland', '52', '20', 1, 0),
(174, 'PT', 'Portugal', '39.5', '-8', 1, 0),
(175, 'PR', 'Puerto Rico', '18.25', '-66.5', 1, 0),
(176, 'QA', 'Qatar', '25.5', '51.25', 1, 0),
(177, 'RE', 'Reunion', '-21.15', '55.5', 1, 0),
(178, 'RO', 'Romania', '46', '25', 1, 0),
(179, 'RU', 'Russian Federation', '60', '100', 1, 0),
(180, 'RW', 'Rwanda', '-2', '30', 1, 0),
(181, 'KN', 'Saint Kitts and Nevis', '17.33333333', '-62.75', 1, 0),
(182, 'LC', 'Saint Lucia', '13.88333333', '-60.96666666', 1, 0),
(183, 'VC', 'Saint Vincent and the Grenadines', '13.25', '-61.2', 1, 0),
(184, 'WS', 'Samoa', '-13.58333333', '-172.33333333', 1, 0),
(185, 'SM', 'San Marino', '43.76666666', '12.41666666', 1, 0),
(186, 'ST', 'Sao Tome and Principe', '1', '7', 1, 0),
(187, 'SA', 'Saudi Arabia', '25', '45', 1, 0),
(188, 'SN', 'Senegal', '14', '-14', 1, 0),
(189, 'RS', 'Serbia', '44', '21', 1, 0),
(190, 'SC', 'Seychelles', '-4.58333333', '55.66666666', 1, 0),
(191, 'SL', 'Sierra Leone', '8.5', '-11.5', 1, 0),
(192, 'SG', 'Singapore', '1.36666666', '103.8', 1, 0),
(193, 'SK', 'Slovakia', '48.66666666', '19.5', 1, 0),
(194, 'SI', 'Slovenia', '46.11666666', '14.81666666', 1, 0),
(195, 'SB', 'Solomon Islands', '-8', '159', 1, 0),
(196, 'SO', 'Somalia', '10', '49', 1, 0),
(197, 'ZA', 'South Africa', '-29', '24', 1, 0),
(198, 'GS', 'South Georgia South Sandwich Islands', '-54.5', '-37', 1, 0),
(199, 'ES', 'Spain', '40', '-4', 1, 0),
(200, 'LK', 'Sri Lanka', '7', '81', 1, 0),
(201, 'SH', 'St. Helena', '', '', 1, 0),
(202, 'PM', 'St. Pierre and Miquelon', '46.83333333', '-56.33333333', 1, 0),
(203, 'SD', 'Sudan', '15', '30', 1, 0),
(204, 'SR', 'Suriname', '4', '-56', 1, 0),
(205, 'SJ', 'Svalbard and Jan Mayen Islands', '78', '20', 1, 0),
(206, 'SZ', 'Swaziland', '-26.5', '31.5', 1, 0),
(207, 'SE', 'Sweden', '62', '15', 1, 0),
(208, 'CH', 'Switzerland', '47', '8', 1, 0),
(209, 'SY', 'Syrian Arab Republic', '35', '38', 1, 0),
(210, 'TW', 'Taiwan', '23.5', '121', 1, 0),
(211, 'TJ', 'Tajikistan', '39', '71', 1, 0),
(212, 'TZ', 'Tanzania, United Republic of', '-6', '35', 1, 0),
(213, 'TH', 'Thailand', '15', '100', 1, 0),
(214, 'TG', 'Togo', '8', '1.16666666', 1, 0),
(215, 'TK', 'Tokelau', '-9', '-172', 1, 0),
(216, 'TO', 'Tonga', '-20', '-175', 1, 0),
(217, 'TT', 'Trinidad and Tobago', '11', '-61', 1, 0),
(218, 'TN', 'Tunisia', '34', '9', 1, 0),
(219, 'TR', 'Turkey', '39', '35', 1, 0),
(220, 'TM', 'Turkmenistan', '40', '60', 1, 0),
(221, 'TC', 'Turks and Caicos Islands', '21.75', '-71.58333333', 1, 0),
(222, 'TV', 'Tuvalu', '-8', '178', 1, 0),
(223, 'UG', 'Uganda', '1', '32', 1, 0),
(224, 'UA', 'Ukraine', '49', '32', 1, 0),
(225, 'AE', 'United Arab Emirates', '24', '54', 1, 0),
(226, 'GB', 'United Kingdom', '54', '-2', 1, 0),
(227, 'UM', 'United States minor outlying islands', '', '', 1, 0),
(228, 'UY', 'Uruguay', '-33', '-56', 1, 0),
(229, 'UZ', 'Uzbekistan', '41', '64', 1, 0),
(230, 'VU', 'Vanuatu', '-16', '167', 1, 0),
(231, 'VA', 'Vatican City State', '41.9', '12.45', 1, 0),
(232, 'VE', 'Venezuela', '8', '-66', 1, 0),
(233, 'VN', 'Vietnam', '16.16666666', '107.83333333', 1, 0),
(234, 'VG', 'Virgin Islands (British)', '18.431383', '-64.62305', 1, 0),
(235, 'VI', 'Virgin Islands (U.S.)', '18.35', '-64.933333', 1, 0),
(236, 'WF', 'Wallis and Futuna Islands', '-13.3', '-176.2', 1, 0),
(237, 'EH', 'Western Sahara', '24.5', '-13', 1, 0),
(238, 'YE', 'Yemen', '15', '48', 1, 0),
(239, 'YU', 'Yugoslavia', '', '', 1, 0),
(240, 'ZR', 'Zaire', '', '', 1, 0),
(241, 'ZM', 'Zambia', '-15', '30', 1, 0),
(242, 'ZW', 'Zimbabwe', '-20', '30', 1, 0),
(247, '--', 'Not Specified', '0', '-0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `country_cities`
--

CREATE TABLE IF NOT EXISTS `country_cities` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name_en` varchar(45) DEFAULT NULL,
  `name_si` varchar(45) DEFAULT NULL,
  `name_ta` varchar(45) DEFAULT NULL,
  `sub_name_en` varchar(45) DEFAULT NULL,
  `sub_name_si` varchar(45) DEFAULT NULL,
  `sub_name_ta` varchar(45) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1847 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country_cities`
--

INSERT INTO `country_cities` (`id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude`) VALUES
(1, 1, 'Akkaraipattu', 'අක්කරපත්තුව', NULL, NULL, NULL, NULL, '32400', 7.2167, 81.85),
(2, 1, 'Ambagahawatta', 'අඹගහවත්ත', NULL, NULL, NULL, NULL, '90326', 7.4, 81.3),
(3, 1, 'Ampara', 'අම්පාර', NULL, NULL, NULL, NULL, '32000', 7.2833, 81.6667),
(4, 1, 'Bakmitiyawa', 'බක්මිටියාව', NULL, NULL, NULL, NULL, '32024', 7.026268, 81.633832),
(5, 1, 'Deegawapiya', 'දීඝවාපිය', NULL, NULL, NULL, NULL, '32006', 7.2833, 81.6667),
(6, 1, 'Devalahinda', 'දෙවලහිඳ', NULL, NULL, NULL, NULL, '32038', 7.1889, 81.5778),
(7, 1, 'Digamadulla Weeragoda', 'දිගාමඩුල්ල වීරගොඩ', NULL, NULL, NULL, NULL, '32008', 7.2833, 81.6667),
(8, 1, 'Dorakumbura', 'දොරකුඹුර', NULL, NULL, NULL, NULL, '32104', 7.358849, 81.280133),
(9, 1, 'Gonagolla', 'ගොනගොල්ල', NULL, NULL, NULL, NULL, '32064', 7.449853, 81.618014),
(10, 1, 'Hulannuge', 'හුලංනුගේ', NULL, NULL, NULL, NULL, '32514', 7.4, 81.3),
(11, 1, 'Kalmunai', 'කල්මුණේ', NULL, NULL, NULL, NULL, '32300', 7.413897, 81.826718),
(12, 1, 'Kannakipuram', 'කන්නකිපුරම්', NULL, NULL, NULL, NULL, '32405', 7.2167, 81.85),
(13, 1, 'Karativu', 'කරතිව්', NULL, NULL, NULL, NULL, '32250', 7.3833, 81.8333),
(14, 1, 'Kekirihena', 'කැකිරිහේන', NULL, NULL, NULL, NULL, '32074', 7.490724, 81.310836),
(15, 1, 'Koknahara', 'කොක්නහර', NULL, NULL, NULL, NULL, '32035', 7.184832, 81.555806),
(16, 1, 'Kolamanthalawa', 'කෝලමන්තලාව', NULL, NULL, NULL, NULL, '32102', 7.351733, 81.249913),
(17, 1, 'Komari', 'කෝමාරි', NULL, NULL, NULL, NULL, '32418', 6.976958, 81.78883),
(18, 1, 'Lahugala', 'ලාහුගල', NULL, NULL, NULL, NULL, '32512', 7.415566, 81.33954),
(19, 1, 'lmkkamam', 'ල්ම්ක්කමම්', NULL, NULL, NULL, NULL, '32450', 7.1125, 81.8542),
(20, 1, 'Mahaoya', 'මහඔය', NULL, NULL, NULL, NULL, '32070', 7.535248, 81.351145),
(21, 1, 'Marathamune', 'මාරත්මුනේ', NULL, NULL, NULL, NULL, '32314', 7.45, 81.8167),
(22, 1, 'Namaloya', 'නාමල්ඔය', NULL, NULL, NULL, NULL, '32037', 7.1889, 81.5778),
(23, 1, 'Navithanveli', 'නාවිදන්වෙලි', NULL, NULL, NULL, NULL, '32308', 7.4333, 81.7833),
(24, 1, 'Nintavur', 'නින්දවූර්', NULL, NULL, NULL, NULL, '32340', 7.35, 81.85),
(25, 1, 'Oluvil', 'ඔළුවිල', NULL, NULL, NULL, NULL, '32360', 7.2833, 81.85),
(26, 1, 'Padiyatalawa', 'පදියතලාව', NULL, NULL, NULL, NULL, '32100', 7.4, 81.2333),
(27, 1, 'Pahalalanda', 'පහලලන්ද', NULL, NULL, NULL, NULL, '32034', 7.21752, 81.578714),
(28, 1, 'Panama', 'පානම', NULL, NULL, NULL, NULL, '32508', 6.812201, 81.712237),
(29, 1, 'Pannalagama', 'පන්නලගම', NULL, NULL, NULL, NULL, '32022', 7.0667, 81.6167),
(30, 1, 'Paragahakele', 'පරගහකැලේ', NULL, NULL, NULL, NULL, '32031', 7.25669, 81.609526),
(31, 1, 'Periyaneelavanai', 'පෙරියනීලවන්නි', NULL, NULL, NULL, NULL, '32316', 7.434002, 81.814169),
(32, 1, 'Polwaga Janapadaya', 'පොල්වග ජනපදය', NULL, NULL, NULL, NULL, '32032', 7.1889, 81.5778),
(33, 1, 'Pottuvil', 'පොතුවිල්', NULL, NULL, NULL, NULL, '32500', 6.8667, 81.8333),
(34, 1, 'Sainthamaruthu', 'සායින්දමරුදු', NULL, NULL, NULL, NULL, '32280', 7.3833, 81.8333),
(35, 1, 'Samanthurai', 'සමන්තුරේ', NULL, NULL, NULL, NULL, '32200', 7.3833, 81.8333),
(36, 1, 'Serankada', 'සේරන්කද', NULL, NULL, NULL, NULL, '32101', 7.464517, 81.263599),
(37, 1, 'Tempitiya', 'ටැම්පිටිය', NULL, NULL, NULL, NULL, '32072', 7.610374, 81.429907),
(38, 1, 'Thambiluvil', 'ල්තැඹිළුවි', NULL, NULL, NULL, NULL, '32415', 7.132227, 81.819074),
(39, 1, 'Tirukovil', 'තිරුකෝවිල', NULL, NULL, NULL, NULL, '32420', 7.1167, 81.85),
(40, 1, 'Uhana', 'උහන', NULL, NULL, NULL, NULL, '32060', 7.363281, 81.637746),
(41, 1, 'Wadinagala', 'වඩිනාගල', NULL, NULL, NULL, NULL, '32039', 7.127849, 81.56922),
(42, 1, 'Wanagamuwa', 'වනගමුව', NULL, NULL, NULL, NULL, '32454', 7.1125, 81.8542),
(43, 2, 'Angamuwa', 'අංගමුව', NULL, NULL, NULL, NULL, '50248', 8.177645, 80.205048),
(44, 2, 'Anuradhapura', 'අනුරාධපුරය', NULL, NULL, NULL, NULL, '50000', 8.35, 80.3833),
(45, 2, 'Awukana', 'අව්කන', NULL, NULL, NULL, NULL, '50169', 7.9753, 80.5266),
(46, 2, 'Bogahawewa', 'බෝගහවැව', NULL, NULL, NULL, NULL, '50566', 8.328993, 80.251702),
(47, 2, 'Dematawewa', 'දෙමටවැව', NULL, NULL, NULL, NULL, '50356', 8.357373, 80.870087),
(48, 2, 'Dimbulagala', 'දිඹුලාගල', NULL, NULL, NULL, NULL, '51031', 7.9167, 80.55),
(49, 2, 'Dutuwewa', 'දුටුවැව', NULL, NULL, NULL, NULL, '50393', 8.65, 80.5167),
(50, 2, 'Elayapattuwa', 'ඇලයාපත්තුව', NULL, NULL, NULL, NULL, '50014', 8.413522, 80.318148),
(51, 2, 'Ellewewa', 'ඇල්ලේවැව', NULL, NULL, NULL, NULL, '51034', 7.9167, 80.55),
(52, 2, 'Eppawala', 'එප්පාවල', NULL, NULL, NULL, NULL, '50260', 8.1167, 80.7333),
(53, 2, 'Etawatunuwewa', 'ඇතාවැටුනවැව', NULL, NULL, NULL, NULL, '50584', 8.5595, 80.5476),
(54, 2, 'Etaweeragollewa', 'ඇතාවීරගොලෑව', NULL, NULL, NULL, NULL, '50518', 8.613962, 80.539713),
(55, 2, 'Galapitagala', 'ගලපිටගල', NULL, NULL, NULL, NULL, '32066', 8.089843, 80.685528),
(56, 2, 'Galenbindunuwewa', 'ගලෙන්බිඳුනුවැව', NULL, NULL, NULL, NULL, '50390', 8.5833, 80.55),
(57, 2, 'Galkadawala', 'ගල්කඩවල', NULL, NULL, NULL, NULL, '50006', 8.412861, 80.378175),
(58, 2, 'Galkiriyagama', 'ගල්කිරියාගම', NULL, NULL, NULL, NULL, '50120', 7.9414, 80.565),
(59, 2, 'Galkulama', 'ගල්කුලම', NULL, NULL, NULL, NULL, '50064', 8.270414, 80.506526),
(60, 2, 'Galnewa', 'ගල්නෑව', NULL, NULL, NULL, NULL, '50170', 8.2, 80.3667),
(61, 2, 'Gambirigaswewa', 'ගම්බිරිගස්වැව', NULL, NULL, NULL, NULL, '50057', 8.4667, 80.3667),
(62, 2, 'Ganewalpola', 'ගනේවල්පොල', NULL, NULL, NULL, NULL, '50142', 8.090528, 80.628195),
(63, 2, 'Gemunupura', 'ගැමුණුපුර', NULL, NULL, NULL, NULL, '50224', 8.0667, 80.6833),
(64, 2, 'Getalawa', 'ගෙතලාව', NULL, NULL, NULL, NULL, '50392', 8.6167, 80.5333),
(65, 2, 'Gnanikulama', 'ඝාණිකුළම', NULL, NULL, NULL, NULL, '50036', 8.297336, 80.431753),
(66, 2, 'Gonahaddenawa', 'ගෝනහද්දෙනෑව', NULL, NULL, NULL, NULL, '50554', 8.5333, 80.5083),
(67, 2, 'Habarana', 'හබරන', NULL, NULL, NULL, NULL, '50150', 8.047531, 80.748664),
(68, 2, 'Halmillawa Dambulla', 'හල්මිලෑව දඹුල්ල', NULL, NULL, NULL, NULL, '50124', 7.9474, 80.594),
(69, 2, 'Halmillawetiya', 'හල්මිල්ලවැටිය', NULL, NULL, NULL, NULL, '50552', 8.35, 80.2667),
(70, 2, 'Hidogama', 'හිද්දෝගම', NULL, NULL, NULL, NULL, '50044', 8.250421, 80.418663),
(71, 2, 'Horawpatana', 'හොරොව්පතාන', NULL, NULL, NULL, NULL, '50350', 8.4333, 80.8667),
(72, 2, 'Horiwila', 'හොරිවිල', NULL, NULL, NULL, NULL, '50222', 8.0667, 80.6833),
(73, 2, 'Hurigaswewa', 'හුරිගස්වැව', NULL, NULL, NULL, NULL, '50176', 8.1333, 80.3667),
(74, 2, 'Hurulunikawewa', 'හුරුලුනිකවැව', NULL, NULL, NULL, NULL, '50394', 8.6167, 80.5333),
(75, 2, 'Ihala Puliyankulama', 'ඉහල පුලියන්කුලම', NULL, NULL, NULL, NULL, '61316', 8.153213, 80.559989),
(76, 2, 'Kagama', 'කගම', NULL, NULL, NULL, NULL, '50282', 8.061465, 80.478039),
(77, 2, 'Kahatagasdigiliya', 'කහටගස්දිගිලිය', NULL, NULL, NULL, NULL, '50320', 8.4167, 80.6833),
(78, 2, 'Kahatagollewa', 'කහටගොල්ලෑව', NULL, NULL, NULL, NULL, '50562', 8.45, 80.65),
(79, 2, 'Kalakarambewa', 'කලකරඹෑව', NULL, NULL, NULL, NULL, '50288', 8.0833, 80.4667),
(80, 2, 'Kalaoya', 'කලාඔය', NULL, NULL, NULL, NULL, '50226', 8.0667, 80.6833),
(81, 2, 'Kalawedi Ulpotha', 'කලාවැදි උල්පොත', NULL, NULL, NULL, NULL, '50556', 8.5333, 80.5083),
(82, 2, 'Kallanchiya', 'කලංචිය', NULL, NULL, NULL, NULL, '50454', 8.45, 80.55),
(83, 2, 'Kalpitiya', 'කල්පිටිය', NULL, NULL, NULL, NULL, '61360', 8.2333, 79.7667),
(84, 2, 'Kalukele Badanagala', 'කළුකැලේ බදනාගල', NULL, NULL, NULL, NULL, '51037', 7.9167, 80.55),
(85, 2, 'Kapugallawa', 'කපුගල්ලව', NULL, NULL, NULL, NULL, '50370', 8.4233, 80.6783),
(86, 2, 'Karagahawewa', 'කරගහවැව', NULL, NULL, NULL, NULL, '50232', 8.23416, 80.322772),
(87, 2, 'Kashyapapura', 'කාශ්‍යපපුර', NULL, NULL, NULL, NULL, '51032', 7.9167, 80.55),
(88, 2, 'Kebithigollewa', 'කැබිතිගොල්ලෑව', NULL, NULL, NULL, NULL, '50500', 8.5333, 80.4833),
(89, 2, 'Kekirawa', 'කැකිරාව', NULL, NULL, NULL, NULL, '50100', 8.037462, 80.59801),
(90, 2, 'Kendewa', 'කේන්දෑව', NULL, NULL, NULL, NULL, '50452', 8.4833, 80.6),
(91, 2, 'Kiralogama', 'කිරළෝගම', NULL, NULL, NULL, NULL, '50259', 8.19407, 80.37012),
(92, 2, 'Kirigalwewa', 'කිරිගල්වැව', NULL, NULL, NULL, NULL, '50511', 8.537767, 80.556651),
(93, 2, 'Kirimundalama', 'කිරිමුන්ඩලම', NULL, NULL, NULL, NULL, '61362', 8.2333, 79.7667),
(94, 2, 'Kitulhitiyawa', 'කිතුල්හිටියාව', NULL, NULL, NULL, NULL, '50132', 7.916592, 80.63811),
(95, 2, 'Kurundankulama', 'කුරුන්දන්කුලම', NULL, NULL, NULL, NULL, '50062', 8.2, 80.45),
(96, 2, 'Labunoruwa', 'ලබුනෝරුව', NULL, NULL, NULL, NULL, '50088', 8.168026, 80.617001),
(97, 2, 'Ihalagama', 'ඉහලගම', NULL, NULL, NULL, NULL, '50304', 8.35, 80.5),
(98, 2, 'Ipologama', 'ඉපොලොගම', NULL, NULL, NULL, NULL, '50280', 8.0833, 80.4667),
(99, 2, 'Madatugama', 'මාදතුගම', NULL, NULL, NULL, NULL, '50130', 7.940041, 80.638217),
(100, 2, 'Maha Elagamuwa', 'මහ ඇලගමුව', NULL, NULL, NULL, NULL, '50126', 7.991935, 80.61824),
(101, 2, 'Mahabulankulama', 'මහබුලංකුලම', NULL, NULL, NULL, NULL, '50196', 7.9753, 80.5266),
(102, 2, 'Mahailluppallama', 'මහඉලුප්පල්ලම', NULL, NULL, NULL, NULL, '50270', 8.106, 80.3619),
(103, 2, 'Mahakanadarawa', 'මහකනදරාව', NULL, NULL, NULL, NULL, '50306', 8.35, 80.5),
(104, 2, 'Mahapothana', 'මහපොතාන', NULL, NULL, NULL, NULL, '50327', 8.4167, 80.6833),
(105, 2, 'Mahasenpura', 'මහසෙන්පුර', NULL, NULL, NULL, NULL, '50574', 8.5595, 80.5476),
(106, 2, 'Mahawilachchiya', 'මහවිලච්චිය', NULL, NULL, NULL, NULL, '50022', 8.2814, 80.4588),
(107, 2, 'Mailagaswewa', 'මයිලගස්වැව', NULL, NULL, NULL, NULL, '50384', 8.4, 80.6333),
(108, 2, 'Malwanagama', 'මල්වනගම', NULL, NULL, NULL, NULL, '50236', 8.225, 80.3333),
(109, 2, 'Maneruwa', 'මනේරුව', NULL, NULL, NULL, NULL, '50182', 7.895997, 80.475966),
(110, 2, 'Maradankadawala', 'මරදන්කඩවල', NULL, NULL, NULL, NULL, '50080', 8.1333, 80.4833),
(111, 2, 'Maradankalla', 'මරදන්කල්ල', NULL, NULL, NULL, NULL, '50308', 8.317498, 80.537899),
(112, 2, 'Medawachchiya', 'මැදවච්චිය', NULL, NULL, NULL, NULL, '50500', 8.540822, 80.495957),
(113, 2, 'Megodawewa', 'මීගොඩවැව', NULL, NULL, NULL, NULL, '50334', 8.2333, 80.7333),
(114, 2, 'Mihintale', 'මිහින්තලේ', NULL, NULL, NULL, NULL, '50300', 8.35, 80.5),
(115, 2, 'Morakewa', 'මොරකෑව', NULL, NULL, NULL, NULL, '50349', 8.513051, 80.778223),
(116, 2, 'Mulkiriyawa', 'මුල්කිරියාව', NULL, NULL, NULL, NULL, '50324', 8.4167, 80.6833),
(117, 2, 'Muriyakadawala', 'මුරියකඩවල', NULL, NULL, NULL, NULL, '50344', 8.236464, 80.654663),
(118, 5, 'Colombo 15', 'කොළඹ 15', 'கொழும்பு 15', 'Modara', 'මෝදර', 'முகத்துவாரம்', '01500', 6.959444, 79.875278),
(119, 2, 'Nachchaduwa', 'නච්චදූව', NULL, NULL, NULL, NULL, '50046', 8.2667, 80.4667),
(120, 2, 'Namalpura', 'නාමල්පුර', NULL, NULL, NULL, NULL, '50339', 8.2333, 80.7333),
(121, 2, 'Negampaha', 'නෑගම්පහ', NULL, NULL, NULL, NULL, '50180', 7.9872, 80.4597),
(122, 2, 'Nochchiyagama', 'නොච්චියාගම', NULL, NULL, NULL, NULL, '50200', 8.266802, 80.20823),
(123, 2, 'Nuwaragala', 'නුවරගල', NULL, NULL, NULL, NULL, '51039', 7.9167, 80.55),
(124, 2, 'Padavi Maithripura', 'පදවි මෛත්‍රීපුර', NULL, NULL, NULL, NULL, '50572', 8.5595, 80.5476),
(125, 2, 'Padavi Parakramapura', 'පදවි පරාක්‍රමපුර', NULL, NULL, NULL, NULL, '50582', 8.5595, 80.5476),
(126, 2, 'Padavi Sripura', 'පදවි ශ්‍රීපුර', NULL, NULL, NULL, NULL, '50587', 8.5595, 80.5476),
(127, 2, 'Padavi Sritissapura', 'පදවි ශ්‍රීතිස්සපුර', NULL, NULL, NULL, NULL, '50588', 8.5595, 80.5476),
(128, 2, 'Padaviya', 'පදවිය', NULL, NULL, NULL, NULL, '50570', 8.5595, 80.5476),
(129, 2, 'Padikaramaduwa', 'පඩිකරමඩුව', NULL, NULL, NULL, NULL, '50338', 8.2333, 80.7333),
(130, 2, 'Pahala Halmillewa', 'පහල හල්මිල්ලෑව', NULL, NULL, NULL, NULL, '50206', 8.21672, 80.19116),
(131, 2, 'Pahala Maragahawe', 'පහල මරගහවෙ', NULL, NULL, NULL, NULL, '50220', 8.0667, 80.6833),
(132, 2, 'Pahalagama', 'පහලගම', NULL, NULL, NULL, NULL, '50244', 8.186896, 80.283767),
(133, 2, 'Palugaswewa', 'පලුගස්වැව', NULL, NULL, NULL, NULL, '50144', 8.053538, 80.71918),
(134, 2, 'Pandukabayapura', 'පන්ඩුකාබයපුර', NULL, NULL, NULL, NULL, '50448', 8.4467, 80.46731),
(135, 2, 'Pandulagama', 'පන්ඩුලගම', NULL, NULL, NULL, NULL, '50029', 8.2814, 80.4588),
(136, 2, 'Parakumpura', 'පරාක්‍රමපුර', NULL, NULL, NULL, NULL, '50326', 8.4167, 80.6833),
(137, 2, 'Parangiyawadiya', 'පරංගියාවාඩිය', NULL, NULL, NULL, NULL, '50354', 8.491831, 80.910014),
(138, 2, 'Parasangahawewa', 'පරසන්ගහවැව', NULL, NULL, NULL, NULL, '50055', 8.4333, 80.4333),
(139, 2, 'Pelatiyawa', 'පැලටියාව', NULL, NULL, NULL, NULL, '51033', 7.9167, 80.55),
(140, 2, 'Pemaduwa', 'පෙමදූව', NULL, NULL, NULL, NULL, '50020', 8.2814, 80.4588),
(141, 2, 'Perimiyankulama', 'පෙරිමියන්කුලම', NULL, NULL, NULL, NULL, '50004', 8.270584, 80.535827),
(142, 2, 'Pihimbiyagolewa', 'පිහිඹියගොල්ලෑව', NULL, NULL, NULL, NULL, '50512', 8.5595, 80.5476),
(143, 2, 'Pubbogama', 'පුබ්බෝගම', NULL, NULL, NULL, NULL, '50122', 7.9167, 80.6),
(144, 2, 'Punewa', 'පූනෑව', NULL, NULL, NULL, NULL, '50506', 8.6167, 80.4667),
(145, 2, 'Rajanganaya', 'රාජාංගනය', NULL, NULL, NULL, NULL, '50246', 8.1708, 80.2833),
(146, 2, 'Rambewa', 'රම්බෑව්', NULL, NULL, NULL, NULL, '50450', 8.4333, 80.5),
(147, 2, 'Rampathwila', 'රම්පත්විල', NULL, NULL, NULL, NULL, '50386', 8.4, 80.6333),
(148, 2, 'Rathmalgahawewa', 'රත්මල්ගහවැව', NULL, NULL, NULL, NULL, '50514', 8.5595, 80.5476),
(149, 2, 'Saliyapura', 'සාලියපුර', NULL, NULL, NULL, NULL, '50008', 8.3389, 80.4333),
(150, 2, 'Seeppukulama', 'සීප්පුකුලම', NULL, NULL, NULL, NULL, '50380', 8.4, 80.6333),
(151, 2, 'Senapura', 'සේනාපුර', NULL, NULL, NULL, NULL, '50284', 8.0833, 80.4667),
(152, 2, 'Sivalakulama', 'සිවලකුලම', NULL, NULL, NULL, NULL, '50068', 8.25237, 80.641743),
(153, 2, 'Siyambalewa', 'සියඹලෑව', NULL, NULL, NULL, NULL, '50184', 7.95, 80.5167),
(154, 2, 'Sravasthipura', 'ස්‍රාවස්තිපුර', NULL, NULL, NULL, NULL, '50042', 8.2667, 80.4333),
(155, 2, 'Talawa', 'තලාව', NULL, NULL, NULL, NULL, '50230', 8.2167, 80.35),
(156, 2, 'Tambuttegama', 'තඹුත්තේගම', NULL, NULL, NULL, NULL, '50240', 8.15, 80.3),
(157, 2, 'Tammennawa', 'තම්මැන්නාව', NULL, NULL, NULL, NULL, '50104', 8.0333, 80.6),
(158, 2, 'Tantirimale', 'තන්තිරිමලේ', NULL, NULL, NULL, NULL, '50016', 8.4, 80.3),
(159, 2, 'Telhiriyawa', 'තෙල්හිරියාව', NULL, NULL, NULL, NULL, '50242', 8.15, 80.3333),
(160, 2, 'Tirappane', 'තිරප්පනේ', NULL, NULL, NULL, NULL, '50072', 8.2167, 80.3833),
(161, 2, 'Tittagonewa', 'තිත්තගෝනෑව', NULL, NULL, NULL, NULL, '50558', 8.7167, 80.75),
(162, 2, 'Udunuwara Colony', 'උඩුනුවර කොළණිය', NULL, NULL, NULL, NULL, '50207', 8.2417, 80.1917),
(163, 2, 'Upuldeniya', 'උපුල්දෙනිය', NULL, NULL, NULL, NULL, '50382', 8.4, 80.6333),
(164, 2, 'Uttimaduwa', 'උට්ටිමඩුව', NULL, NULL, NULL, NULL, '50067', 8.254989, 80.55487),
(165, 2, 'Vellamanal', 'වෙල්ලමනල්', NULL, NULL, NULL, NULL, '31053', 8.5167, 81.1833),
(166, 2, 'Viharapalugama', 'විහාරපාළුගම', NULL, NULL, NULL, NULL, '50012', 8.4, 80.3),
(167, 2, 'Wahalkada', 'වාහල්කඩ', NULL, NULL, NULL, NULL, '50564', 8.5667, 80.6222),
(168, 2, 'Wahamalgollewa', 'වහමල්ගොල්ලෑව', NULL, NULL, NULL, NULL, '50492', 8.479838, 80.497451),
(169, 2, 'Walagambahuwa', 'වලගම්බාහුව', NULL, NULL, NULL, NULL, '50086', 8.153134, 80.499049),
(170, 2, 'Walahaviddawewa', 'වලහාවිද්දෑව', NULL, NULL, NULL, NULL, '50516', 8.5595, 80.5476),
(171, 2, 'Welimuwapotana', 'වැලිමුවපතාන', NULL, NULL, NULL, NULL, '50358', 8.4333, 80.8667),
(172, 2, 'Welioya Project', 'වැලිඔය ව්‍යාපෘතිය', NULL, NULL, NULL, NULL, '50586', 8.5595, 80.5476),
(173, 3, 'Akkarasiyaya', 'අක්කරසියය', NULL, NULL, NULL, NULL, '90166', 6.7792, 80.9208),
(174, 3, 'Aluketiyawa', 'අලුකෙටියාව', NULL, NULL, NULL, NULL, '90736', 7.317155, 81.127134),
(175, 3, 'Aluttaramma', 'අළුත්තරම', NULL, NULL, NULL, NULL, '90722', 7.2167, 81.0667),
(176, 3, 'Ambadandegama', 'අඹදන්ඩෙගම', NULL, NULL, NULL, NULL, '90108', 6.81591, 81.056492),
(177, 3, 'Ambagasdowa', 'අඹගස්දූව', NULL, NULL, NULL, NULL, '90300', 6.928519, 80.892126),
(178, 3, 'Arawa', 'අරාව', NULL, NULL, NULL, NULL, '90017', 7.162769, 81.07755),
(179, 3, 'Arawakumbura', 'අරාවකුඹුර', NULL, NULL, NULL, NULL, '90532', 7.084925, 81.198802),
(180, 3, 'Arawatta', 'අරාවත්ත', NULL, NULL, NULL, NULL, '90712', 7.328715, 81.036976),
(181, 3, 'Atakiriya', 'අටකිරියාව', NULL, NULL, NULL, NULL, '90542', 7.0667, 81.1056),
(182, 3, 'Badulla', 'බදුල්ල', NULL, NULL, NULL, NULL, '90000', 6.995365, 81.048438),
(183, 3, 'Baduluoya', 'බදුලුඔය', NULL, NULL, NULL, NULL, '90019', 7.151852, 81.023867),
(184, 3, 'Ballaketuwa', 'බල්ලකැටුව', NULL, NULL, NULL, NULL, '90092', 6.862905, 81.097249),
(185, 3, 'Bambarapana', 'බඹරපාන', NULL, NULL, NULL, NULL, '90322', 7.1167, 81.0375),
(186, 3, 'Bandarawela', 'බණ්ඩාරවෙල', NULL, NULL, NULL, NULL, '90100', 6.828867, 80.990898),
(187, 3, 'Beramada', 'බෙරමඩ', NULL, NULL, NULL, NULL, '90066', 7.055713, 80.987238),
(188, 3, 'Bibilegama', 'බිබිලේගම', NULL, NULL, NULL, NULL, '90502', 6.887473, 81.141268),
(189, 3, 'Boragas', 'බොරගස්', NULL, NULL, NULL, NULL, '90362', 6.901625, 80.840162),
(190, 3, 'Boralanda', 'බොරලන්ද', NULL, NULL, NULL, NULL, '90170', 6.828637, 80.881603),
(191, 3, 'Bowela', 'බෝවෙල', NULL, NULL, NULL, NULL, '90302', 6.95, 80.9333),
(192, 3, 'Central Camp', 'මධ්‍යම කඳවුර', NULL, NULL, NULL, NULL, '32050', 7.3589, 81.1759),
(193, 3, 'Damanewela', 'දමනෙවෙල', NULL, NULL, NULL, NULL, '32126', 7.2125, 81.0583),
(194, 3, 'Dambana', 'දඹාන', NULL, NULL, NULL, NULL, '90714', 7.3583, 81.1083),
(195, 3, 'Dehiattakandiya', 'දෙහිඅත්තකන්ඩිය', NULL, NULL, NULL, NULL, '32150', 7.2125, 81.0583),
(196, 3, 'Demodara', 'දෙමෝදර', NULL, NULL, NULL, NULL, '90080', 6.899055, 81.053273),
(197, 3, 'Diganatenna', 'දිගනතැන්න', NULL, NULL, NULL, NULL, '90132', 6.8667, 80.9667),
(198, 3, 'Dikkapitiya', 'දික්කපිටිය', NULL, NULL, NULL, NULL, '90214', 6.7381, 80.9669),
(199, 3, 'Dimbulana', 'දිඹුලාන', NULL, NULL, NULL, NULL, '90324', 7.006897, 80.948431),
(200, 3, 'Divulapelessa', 'දිවුලපැලැස්ස', NULL, NULL, NULL, NULL, '90726', 7.2167, 81.0667),
(201, 3, 'Diyatalawa', 'දියතලාව', NULL, NULL, NULL, NULL, '90150', 6.8, 80.9667),
(202, 3, 'Dulgolla', 'දුල්ගොල්ල', NULL, NULL, NULL, NULL, '90104', 6.819618, 81.012115),
(203, 3, 'Ekiriyankumbura', 'ඇකිරියන්කුඹුර', NULL, NULL, NULL, NULL, '91502', 7.269736, 81.226709),
(204, 3, 'Ella', 'ඇල්ල', NULL, NULL, NULL, NULL, '90090', 6.874485, 81.050937),
(205, 3, 'Ettampitiya', 'ඇට්ටම්පිටිය', NULL, NULL, NULL, NULL, '90140', 6.9342, 80.9853),
(206, 3, 'Galauda', 'ගලඋඩ', NULL, NULL, NULL, NULL, '90065', 7.037347, 80.981759),
(207, 3, 'Galporuyaya', 'ගල්පොරුයාය', NULL, NULL, NULL, NULL, '90752', 7.4, 81.05),
(208, 3, 'Gawarawela', 'ගවරවෙල', NULL, NULL, NULL, NULL, '90082', 6.897394, 81.069668),
(209, 3, 'Girandurukotte', 'ගිරාඳුරුකෝට්ටෙ', NULL, NULL, NULL, NULL, '90750', 7.4, 81.05),
(210, 3, 'Godunna', 'ගොඩුන්න', NULL, NULL, NULL, NULL, '90067', 7.071959, 80.975003),
(211, 3, 'Gurutalawa', 'ගුරුතලාව', NULL, NULL, NULL, NULL, '90208', 6.8431, 80.9228),
(212, 3, 'Haldummulla', 'හල්දුම්මුල්ල', NULL, NULL, NULL, NULL, '90180', 6.77061, 80.884385),
(213, 3, 'Hali Ela', 'හාලි ඇල', NULL, NULL, NULL, NULL, '90060', 6.95, 81.0333),
(214, 3, 'Hangunnawa', 'හඟුන්නෑව', NULL, NULL, NULL, NULL, '90224', 6.948019, 80.871427),
(215, 3, 'Haputale', 'හපුතලේ', NULL, NULL, NULL, NULL, '90160', 6.7667, 80.9667),
(216, 3, 'Hebarawa', 'හබරාව', NULL, NULL, NULL, NULL, '90724', 7.2167, 81.0667),
(217, 3, 'Heeloya', 'හීලොය', NULL, NULL, NULL, NULL, '90112', 6.8212, 80.9407),
(218, 3, 'Helahalpe', 'හෙලහල්පේ', NULL, NULL, NULL, NULL, '90122', 6.8212, 80.9407),
(219, 3, 'Helapupula', 'හෙලපුපුළ', NULL, NULL, NULL, NULL, '90094', 6.8556, 81.0722),
(220, 3, 'Hopton', 'හෝප්ටන්', NULL, NULL, NULL, NULL, '90524', 6.9594, 81.1552),
(221, 3, 'Idalgashinna', 'ඉදල්ගස්ඉන්න', NULL, NULL, NULL, NULL, '96167', 6.7833, 80.9),
(222, 3, 'Kahataruppa', 'කහටරුප්ප', NULL, NULL, NULL, NULL, '90052', 7.023705, 81.105188),
(223, 3, 'Kalugahakandura', 'කළුගහකණ්ඳුර', NULL, NULL, NULL, NULL, '90546', 7.123675, 81.094178),
(224, 3, 'Kalupahana', 'කළුපහණ', NULL, NULL, NULL, NULL, '90186', 6.770298, 80.854521),
(225, 3, 'Kebillawela', 'කොබිල්ලවෙල', NULL, NULL, NULL, NULL, '90102', 6.816937, 80.993072),
(226, 3, 'Kendagolla', 'කන්දෙගොල්ල', NULL, NULL, NULL, NULL, '90048', 6.990765, 81.110073),
(227, 3, 'Keselpotha', 'කෙසෙල්පොත', NULL, NULL, NULL, NULL, '90738', 7.32819, 81.083285),
(228, 3, 'Ketawatta', 'කේතවත්ත', NULL, NULL, NULL, NULL, '90016', 7.103503, 81.080813),
(229, 3, 'Kiriwanagama', 'කිරිවනගම', NULL, NULL, NULL, NULL, '90184', 6.971183, 80.91551),
(230, 3, 'Koslanda', 'කොස්ලන්ද', NULL, NULL, NULL, NULL, '90190', 6.759935, 81.027417),
(231, 3, 'Kuruwitenna', NULL, NULL, NULL, NULL, NULL, '90728', 7.2167, 81.0667),
(232, 3, 'Kuttiyagolla', NULL, NULL, NULL, NULL, NULL, '90046', 7.0167, 81.0833),
(233, 3, 'Landewela', NULL, NULL, NULL, NULL, NULL, '90068', 7.002113, 81.000496),
(234, 3, 'Liyangahawela', NULL, NULL, NULL, NULL, NULL, '90106', 6.817452, 81.032456),
(235, 3, 'Lunugala', NULL, NULL, NULL, NULL, NULL, '90530', 7.041299, 81.199335),
(236, 3, 'Lunuwatta', NULL, NULL, NULL, NULL, NULL, '90310', 6.953933, 80.917059),
(237, 3, 'Madulsima', NULL, NULL, NULL, NULL, NULL, '90535', 7.045064, 81.133375),
(238, 3, 'Mahiyanganaya', NULL, NULL, NULL, NULL, NULL, '90700', 7.2444, 81.1167),
(239, 3, 'Makulella', NULL, NULL, NULL, NULL, NULL, '90114', 6.8212, 80.9407),
(240, 3, 'Malgoda', NULL, NULL, NULL, NULL, NULL, '90754', 7.4, 81.05),
(241, 3, 'Mapakadawewa', NULL, NULL, NULL, NULL, NULL, '90730', 7.3, 81.1167),
(242, 3, 'Maspanna', NULL, NULL, NULL, NULL, NULL, '90328', 7.024427, 80.942159),
(243, 3, 'Maussagolla', NULL, NULL, NULL, NULL, NULL, '90582', 6.898433, 81.147817),
(244, 3, 'Mawanagama', NULL, NULL, NULL, NULL, NULL, '32158', 7.2125, 81.0583),
(245, 3, 'Medawela Udukinda', NULL, NULL, NULL, NULL, NULL, '90218', 6.846, 80.9279),
(246, 3, 'Meegahakiula', NULL, NULL, NULL, NULL, NULL, '90015', 7.0833, 80.9833),
(247, 3, 'Metigahatenna', NULL, NULL, NULL, NULL, NULL, '90540', 6.9667, 81.0833),
(248, 3, 'Mirahawatta', NULL, NULL, NULL, NULL, NULL, '90134', 6.8817, 80.9347),
(249, 3, 'Miriyabedda', NULL, NULL, NULL, NULL, NULL, '90504', 6.9167, 81.15),
(250, 3, 'Nawamedagama', NULL, NULL, NULL, NULL, NULL, '32120', 7.2125, 81.0583),
(251, 3, 'Nelumgama', NULL, NULL, NULL, NULL, NULL, '90042', 7, 81.0917),
(252, 3, 'Nikapotha', NULL, NULL, NULL, NULL, NULL, '90165', 6.740622, 80.97083),
(253, 3, 'Nugatalawa', NULL, NULL, NULL, NULL, NULL, '90216', 6.9, 80.8833),
(254, 3, 'Ohiya', NULL, NULL, NULL, NULL, NULL, '90168', 6.821352, 80.841789),
(255, 3, 'Pahalarathkinda', NULL, NULL, NULL, NULL, NULL, '90756', 7.4, 81.05),
(256, 3, 'Pallekiruwa', NULL, NULL, NULL, NULL, NULL, '90534', 7.007551, 81.227033),
(257, 3, 'Passara', NULL, NULL, NULL, NULL, NULL, '90500', 6.935017, 81.151166),
(258, 3, 'Pattiyagedara', NULL, NULL, NULL, NULL, NULL, '90138', 6.8742, 80.9507),
(259, 3, 'Pelagahatenna', NULL, NULL, NULL, NULL, NULL, '90522', 6.9594, 81.1552),
(260, 3, 'Perawella', NULL, NULL, NULL, NULL, NULL, '90222', 6.943148, 80.84264),
(261, 3, 'Pitamaruwa', NULL, NULL, NULL, NULL, NULL, '90544', 7.106546, 81.135882),
(262, 3, 'Pitapola', NULL, NULL, NULL, NULL, NULL, '90171', 6.803692, 80.884474),
(263, 3, 'Puhulpola', NULL, NULL, NULL, NULL, NULL, '90212', 6.907145, 80.931109),
(264, 3, 'Rajagalatenna', NULL, NULL, NULL, NULL, NULL, '32068', 7.5458, 81.125),
(265, 3, 'Ratkarawwa', NULL, NULL, NULL, NULL, NULL, '90164', 6.8, 80.9167),
(266, 3, 'Ridimaliyadda', NULL, NULL, NULL, NULL, NULL, '90704', 7.2333, 81.1),
(267, 3, 'Silmiyapura', NULL, NULL, NULL, NULL, NULL, '90364', 6.912388, 80.843988),
(268, 3, 'Sirimalgoda', NULL, NULL, NULL, NULL, NULL, '90044', 7.003857, 81.073671),
(269, 3, 'Siripura', NULL, NULL, NULL, NULL, NULL, '32155', 7.2125, 81.0583),
(270, 3, 'Sorabora Colony', NULL, NULL, NULL, NULL, NULL, '90718', 7.3583, 81.1083),
(271, 3, 'Soragune', NULL, NULL, NULL, NULL, NULL, '90183', 6.8333, 80.8778),
(272, 3, 'Soranatota', NULL, NULL, NULL, NULL, NULL, '90008', 7.0167, 81.05),
(273, 3, 'Taldena', NULL, NULL, NULL, NULL, NULL, '90014', 7.0833, 81.05),
(274, 3, 'Timbirigaspitiya', NULL, NULL, NULL, NULL, NULL, '90012', 7.0333, 81.05),
(275, 3, 'Uduhawara', NULL, NULL, NULL, NULL, NULL, '90226', 6.94706, 80.85877),
(276, 3, 'Uraniya', NULL, NULL, NULL, NULL, NULL, '90702', 7.237143, 81.102818),
(277, 3, 'Uva Karandagolla', NULL, NULL, NULL, NULL, NULL, '90091', 6.8333, 81.0667),
(278, 3, 'Uva Mawelagama', NULL, NULL, NULL, NULL, NULL, '90192', 6.7333, 81.0167),
(279, 3, 'Uva Tenna', NULL, NULL, NULL, NULL, NULL, '90188', 6.8333, 80.8778),
(280, 3, 'Uva Tissapura', NULL, NULL, NULL, NULL, NULL, '90734', 7.3, 81.1167),
(281, 3, 'Welimada', NULL, NULL, NULL, NULL, NULL, '90200', 6.906059, 80.913222),
(282, 3, 'Werunketagoda', NULL, NULL, NULL, NULL, NULL, '32062', 7.5458, 81.125),
(283, 3, 'Wewatta', NULL, NULL, NULL, NULL, NULL, '90716', 7.337729, 81.201255),
(284, 3, 'Wineethagama', NULL, NULL, NULL, NULL, NULL, '90034', 7.029, 80.937),
(285, 3, 'Yalagamuwa', NULL, NULL, NULL, NULL, NULL, '90329', 7.047834, 80.950541),
(286, 3, 'Yalwela', NULL, NULL, NULL, NULL, NULL, '90706', 7.2667, 81.15),
(287, 4, 'Addalaichenai', NULL, NULL, NULL, NULL, NULL, '32350', 7.4833, 81.75),
(288, 4, 'Ampilanthurai', 'අම්පිලන්තුරෙයි', NULL, NULL, NULL, NULL, '30162', 7.8597, 81.4411),
(289, 4, 'Araipattai', NULL, NULL, NULL, NULL, NULL, '30150', 7.667705, 81.725335),
(290, 4, 'Ayithiyamalai', NULL, NULL, NULL, NULL, NULL, '30362', 7.670934, 81.574798),
(291, 4, 'Bakiella', NULL, NULL, NULL, NULL, NULL, '30206', 7.5083, 81.7583),
(292, 4, 'Batticaloa', 'මඩකලපුව', NULL, NULL, NULL, NULL, '30000', 7.7167, 81.7),
(293, 4, 'Cheddipalayam', 'චෙඩ්ඩිපලයම්', NULL, NULL, NULL, NULL, '30194', 7.575161, 81.783189),
(294, 4, 'Chenkaladi', 'චෙන්කලඩි', NULL, NULL, NULL, NULL, '30350', 7.7833, 81.6),
(295, 4, 'Eravur', 'එරාවූර්', NULL, NULL, NULL, NULL, '30300', 7.768518, 81.619817),
(296, 4, 'Kaluwanchikudi', NULL, NULL, NULL, NULL, NULL, '30200', 7.5167, 81.7833),
(297, 4, 'Kaluwankemy', NULL, NULL, NULL, NULL, NULL, '30372', 7.8, 81.5667),
(298, 4, 'Kannankudah', NULL, NULL, NULL, NULL, NULL, '30016', 7.675505, 81.674125),
(299, 4, 'Karadiyanaru', NULL, NULL, NULL, NULL, NULL, '30354', 7.689478, 81.531117),
(300, 4, 'Kathiraveli', NULL, NULL, NULL, NULL, NULL, '30456', 8.243933, 81.360298),
(301, 4, 'Kattankudi', NULL, NULL, NULL, NULL, NULL, '30100', 7.675, 81.73),
(302, 4, 'Kiran', NULL, NULL, NULL, NULL, NULL, '30394', 7.866841, 81.529737),
(303, 4, 'Kirankulam', NULL, NULL, NULL, NULL, NULL, '30159', 7.615628, 81.764245),
(304, 4, 'Koddaikallar', NULL, NULL, NULL, NULL, NULL, '30249', 7.6389, 81.6639),
(305, 4, 'Kokkaddichcholai', NULL, NULL, NULL, NULL, NULL, '30160', 7.8597, 81.4411),
(306, 4, 'Kurukkalmadam', NULL, NULL, NULL, NULL, NULL, '30192', 7.594069, 81.77497),
(307, 4, 'Mandur', NULL, NULL, NULL, NULL, NULL, '30220', 7.482114, 81.762407),
(308, 4, 'Miravodai', NULL, NULL, NULL, NULL, NULL, '30426', 7.9, 81.5167),
(309, 4, 'Murakottanchanai', NULL, NULL, NULL, NULL, NULL, '30392', 7.8667, 81.5333),
(310, 4, 'Navagirinagar', NULL, NULL, NULL, NULL, NULL, '30238', 7.525, 81.725),
(311, 4, 'Navatkadu', NULL, NULL, NULL, NULL, NULL, '30018', 7.5833, 81.7167),
(312, 4, 'Oddamavadi', NULL, NULL, NULL, NULL, NULL, '30420', 7.9167, 81.5167),
(313, 4, 'Palamunai', NULL, NULL, NULL, NULL, NULL, '32354', 7.4833, 81.75),
(314, 4, 'Pankudavely', NULL, NULL, NULL, NULL, NULL, '30352', 7.75, 81.5667),
(315, 4, 'Periyaporativu', NULL, NULL, NULL, NULL, NULL, '30230', 7.536243, 81.764557),
(316, 4, 'Periyapullumalai', NULL, NULL, NULL, NULL, NULL, '30358', 7.561255, 81.47434),
(317, 4, 'Pillaiyaradi', NULL, NULL, NULL, NULL, NULL, '30022', 7.75, 81.6333),
(318, 4, 'Punanai', NULL, NULL, NULL, NULL, NULL, '30428', 7.9667, 81.3833),
(319, 4, 'Thannamunai', NULL, NULL, NULL, NULL, NULL, '30024', 7.76355, 81.645852),
(320, 4, 'Thettativu', NULL, NULL, NULL, NULL, NULL, '30196', 7.5833, 81.7833),
(321, 4, 'Thikkodai', NULL, NULL, NULL, NULL, NULL, '30236', 7.525269, 81.684177),
(322, 4, 'Thirupalugamam', NULL, NULL, NULL, NULL, NULL, '30234', 7.525, 81.725),
(323, 4, 'Unnichchai', NULL, NULL, NULL, NULL, NULL, '30364', 7.6167, 81.55),
(324, 4, 'Vakaneri', NULL, NULL, NULL, NULL, NULL, '30424', 7.9167, 81.4333),
(325, 4, 'Vakarai', NULL, NULL, NULL, NULL, NULL, '30450', 8.165968, 81.415623),
(326, 4, 'Valaichenai', NULL, NULL, NULL, NULL, NULL, '30400', 7.7, 81.6),
(327, 4, 'Vantharumoolai', NULL, NULL, NULL, NULL, NULL, '30376', 7.807445, 81.591476),
(328, 4, 'Vellavely', NULL, NULL, NULL, NULL, NULL, '30204', 7.5, 81.7333),
(329, 5, 'Akarawita', 'අකරවිට', NULL, NULL, NULL, NULL, '10732', 6.95, 80.1),
(330, 5, 'Ambalangoda', 'අම්බලන්ගොඩ', NULL, NULL, NULL, NULL, '80300', 6.77533, 79.96413),
(331, 5, 'Athurugiriya', 'අතුරුගිරිය', NULL, NULL, NULL, NULL, '10150', 6.873072, 79.997214),
(332, 5, 'Avissawella', 'අවිස්සාවේල්ල', NULL, NULL, NULL, NULL, '10700', 6.955003, 80.211692),
(333, 5, 'Batawala', 'බටවැල', NULL, NULL, NULL, NULL, '10513', 6.877924, 80.051592),
(334, 5, 'Battaramulla', 'බත්තරමුල්ල', NULL, NULL, NULL, NULL, '10120', 6.900299, 79.922136),
(335, 5, 'Biyagama', 'බියගම', NULL, NULL, NULL, NULL, '11650', 6.9408, 79.9889),
(336, 5, 'Bope', 'බෝපෙ', NULL, NULL, NULL, NULL, '10522', 6.8333, 80.1167),
(337, 5, 'Boralesgamuwa', 'බොරලැස්ගමුව', NULL, NULL, NULL, NULL, '10290', 6.8425, 79.9006),
(338, 5, 'Colombo 8', 'කොළඹ 8', 'கொழும்பு 8', 'Borella', 'බොරැල්ල', 'பொறளை', '00800', 6.914722, 79.877778),
(339, 5, 'Dedigamuwa', 'දැඩිගමුව', NULL, NULL, NULL, NULL, '10656', 6.9115, 80.0622),
(340, 5, 'Dehiwala', 'දෙහිවල', NULL, NULL, NULL, NULL, '10350', 6.856387, 79.865156),
(341, 5, 'Deltara', 'දෙල්තර', NULL, NULL, NULL, NULL, '10302', 6.7833, 79.9167),
(342, 5, 'Habarakada', 'හබරකඩ', NULL, NULL, NULL, NULL, '10204', 6.882518, 80.017704),
(343, 5, 'Hanwella', NULL, NULL, NULL, NULL, NULL, '10650', 6.905988, 80.083333),
(344, 5, 'Hiripitya', NULL, NULL, NULL, NULL, NULL, '10232', 6.85, 79.95),
(345, 5, 'Hokandara', NULL, NULL, NULL, NULL, NULL, '10118', 6.890237, 79.969894),
(346, 5, 'Homagama', NULL, NULL, NULL, NULL, NULL, '10200', 6.85685, 80.005384),
(347, 5, 'Horagala', NULL, NULL, NULL, NULL, NULL, '10502', 6.807635, 80.066995),
(348, 5, 'Kaduwela', NULL, NULL, NULL, NULL, NULL, '10640', 6.930497, 79.984817),
(349, 5, 'Kaluaggala', NULL, NULL, NULL, NULL, NULL, '11224', 6.9167, 80.1),
(350, 5, 'Kapugoda', NULL, NULL, NULL, NULL, NULL, '10662', 6.9486, 80.1),
(351, 5, 'Kehelwatta', NULL, NULL, NULL, NULL, NULL, '12550', 6.75, 79.9167),
(352, 5, 'Kiriwattuduwa', NULL, NULL, NULL, NULL, NULL, '10208', 6.804157, 80.009759),
(353, 5, 'Kolonnawa', NULL, NULL, NULL, NULL, NULL, '10600', 6.933035, 79.888095),
(354, 5, 'Kosgama', NULL, NULL, NULL, NULL, NULL, '10730', 6.9333, 80.1411),
(355, 5, 'Madapatha', NULL, NULL, NULL, NULL, NULL, '10306', 6.766824, 79.930103),
(356, 5, 'Maharagama', NULL, NULL, NULL, NULL, NULL, '10280', 6.843401, 79.932766),
(357, 5, 'Malabe', NULL, NULL, NULL, NULL, NULL, '10115', 6.901241, 79.958072),
(358, 5, 'Moratuwa', NULL, NULL, NULL, NULL, NULL, '10400', 6.7733, 79.8825),
(359, 5, 'Mount Lavinia', NULL, NULL, NULL, NULL, NULL, '10370', 6.838864, 79.863141),
(360, 5, 'Mullegama', NULL, NULL, NULL, NULL, NULL, '10202', 6.887403, 80.012959),
(361, 5, 'Napawela', NULL, NULL, NULL, NULL, NULL, '10704', 6.9531, 80.2183),
(362, 5, 'Nugegoda', NULL, NULL, NULL, NULL, NULL, '10250', 6.877563, 79.886231),
(363, 5, 'Padukka', NULL, NULL, NULL, NULL, NULL, '10500', 6.837834, 80.090301),
(364, 5, 'Pannipitiya', NULL, NULL, NULL, NULL, NULL, '10230', 6.843999, 79.944518),
(365, 5, 'Piliyandala', NULL, NULL, NULL, NULL, NULL, '10300', 6.7981, 79.9264),
(366, 5, 'Pitipana Homagama', NULL, NULL, NULL, NULL, NULL, '10206', 6.8477, 80.016),
(367, 5, 'Polgasowita', NULL, NULL, NULL, NULL, NULL, '10320', 6.7842, 79.9811),
(368, 5, 'Pugoda', NULL, NULL, NULL, NULL, NULL, '10660', 6.9703, 80.1222),
(369, 5, 'Ranala', NULL, NULL, NULL, NULL, NULL, '10654', 6.915253, 80.032962),
(370, 5, 'Siddamulla', NULL, NULL, NULL, NULL, NULL, '10304', 6.815785, 79.955978),
(371, 5, 'Siyambalagoda', NULL, NULL, NULL, NULL, NULL, '81462', 6.800041, 79.966845),
(372, 5, 'Sri Jayawardenepu', NULL, NULL, NULL, NULL, NULL, '10100', 6.8897, 79.9359),
(373, 5, 'Talawatugoda', NULL, NULL, NULL, NULL, NULL, '10116', 6.8692, 79.9411),
(374, 5, 'Tummodara', NULL, NULL, NULL, NULL, NULL, '10682', 6.9061, 80.1353),
(375, 5, 'Waga', NULL, NULL, NULL, NULL, NULL, '10680', 6.9061, 80.1353),
(376, 5, 'Colombo 6', 'කොළඹ 6', 'கொழும்பு 6', 'Wellawatta', 'වැල්ලවත්ත', 'வெள்ளவத்தை', '00600', 6.874657, 79.860483),
(377, 6, 'Agaliya', 'අගලිය', NULL, NULL, NULL, NULL, '80212', 6.1833, 80.2),
(378, 6, 'Ahangama', 'අහංගම', NULL, NULL, NULL, NULL, '80650', 5.970765, 80.370204),
(379, 6, 'Ahungalla', 'අහුන්ගල්ල', NULL, NULL, NULL, NULL, '80562', 6.315216, 80.03029),
(380, 6, 'Akmeemana', 'අක්මීමාන', NULL, NULL, NULL, NULL, '80090', 6.1845, 80.3032),
(381, 6, 'Alawatugoda', 'අලවතුගොඩ', NULL, NULL, NULL, NULL, '20140', 6.4167, 80),
(382, 6, 'Aluthwala', 'අළුත්වල', NULL, NULL, NULL, NULL, '80332', 6.180801, 80.136538),
(383, 6, 'Ampegama', 'අම්පෙගම', NULL, NULL, NULL, NULL, '80204', 6.193907, 80.14453),
(384, 6, 'Amugoda', 'අමුගොඩ', NULL, NULL, NULL, NULL, '80422', 6.314635, 80.22104),
(385, 6, 'Anangoda', 'අනන්ගොඩ', NULL, NULL, NULL, NULL, '80044', 6.0722, 80.2389),
(386, 6, 'Angulugaha', 'අඟුලුගහ', NULL, NULL, NULL, NULL, '80122', 6.036963, 80.322148),
(387, 6, 'Ankokkawala', 'අංකොක්කාවල', NULL, NULL, NULL, NULL, '80048', 6.05329, 80.274014),
(388, 6, 'Aselapura', 'ඇසලපුර', NULL, NULL, NULL, NULL, '51072', 6.3167, 80.0333),
(389, 6, 'Baddegama', 'බද්දේගම', NULL, NULL, NULL, NULL, '80200', 6.165975, 80.201841),
(390, 6, 'Balapitiya', 'බලපිටිය', NULL, NULL, NULL, NULL, '80550', 6.269254, 80.036054),
(391, 6, 'Banagala', 'බනගල', NULL, NULL, NULL, NULL, '80143', 6.2706, 80.42),
(392, 6, 'Batapola', 'බටපොල', NULL, NULL, NULL, NULL, '80320', 6.235697, 80.120034),
(393, 6, 'Bentota', 'බෙන්තොට', NULL, NULL, NULL, NULL, '80500', 6.4211, 79.9989),
(394, 6, 'Boossa', 'බූස්ස', NULL, NULL, NULL, NULL, '80270', 6.2233, 80.2),
(395, 6, 'Dellawa', 'දෙල්ලව', NULL, NULL, NULL, NULL, '81477', 6.335012, 80.452741),
(396, 6, 'Dikkumbura', 'දික්කුඹුර', NULL, NULL, NULL, NULL, '80654', 6.012945, 80.376153),
(397, 6, 'Dodanduwa', 'දොඩන්දූව', NULL, NULL, NULL, NULL, '80250', 6.0967, 80.1456),
(398, 6, 'Ella Tanabaddegama', 'ඇල්ල තනබද්දේගම', NULL, NULL, NULL, NULL, '80402', 6.2922, 80.1988),
(399, 6, 'Elpitiya', 'ඇල්පිටිය', NULL, NULL, NULL, NULL, '80400', 6.300214, 80.171923),
(400, 6, 'Galle', 'ගාල්ල', NULL, NULL, NULL, NULL, '80000', 6.0536, 80.2117),
(401, 6, 'Ginimellagaha', 'ගිනිමෙල්ලගහ', NULL, NULL, NULL, NULL, '80220', 6.2233, 80.2),
(402, 6, 'Gintota', 'ගින්තොට', NULL, NULL, NULL, NULL, '80280', 6.0564, 80.1839),
(403, 6, 'Godahena', 'ගොඩහේන', NULL, NULL, NULL, NULL, '80302', 6.2333, 80.0667),
(404, 6, 'Gonamulla Junction', 'ගෝනමුල්ල හංදිය', NULL, NULL, NULL, NULL, '80054', 6.0667, 80.3),
(405, 6, 'Gonapinuwala', 'ගොනාපිනූවල', NULL, NULL, NULL, NULL, '80230', 6.2233, 80.2),
(406, 6, 'Habaraduwa', 'හබරාදූව', NULL, NULL, NULL, NULL, '80630', 6.0043, 80.326),
(407, 6, 'Haburugala', 'හබුරුගල', NULL, NULL, NULL, NULL, '80506', 6.4052, 80.038306),
(408, 6, 'Hikkaduwa', NULL, NULL, NULL, NULL, NULL, '80240', 6.139535, 80.113201),
(409, 6, 'Hiniduma', NULL, NULL, NULL, NULL, NULL, '80080', 6.316028, 80.328888),
(410, 6, 'Hiyare', NULL, NULL, NULL, NULL, NULL, '80056', 6.079898, 80.317871),
(411, 6, 'Kahaduwa', NULL, NULL, NULL, NULL, NULL, '80460', 6.2244, 80.21),
(412, 6, 'Kahawa', NULL, NULL, NULL, NULL, NULL, '80312', 6.185429, 80.07601),
(413, 6, 'Karagoda', NULL, NULL, NULL, NULL, NULL, '80151', 6.084182, 80.395041),
(414, 6, 'Karandeniya', NULL, NULL, NULL, NULL, NULL, '80360', 6.260467, 80.072462),
(415, 6, 'Kosgoda', NULL, NULL, NULL, NULL, NULL, '80570', 6.332288, 80.028315),
(416, 6, 'Kottawagama', NULL, NULL, NULL, NULL, NULL, '80062', 6.1375, 80.3419),
(417, 6, 'Kottegoda', NULL, NULL, NULL, NULL, NULL, '81180', 6.1667, 80.1),
(418, 6, 'Kuleegoda', NULL, NULL, NULL, NULL, NULL, '80328', 6.2167, 80.1167),
(419, 6, 'Magedara', NULL, NULL, NULL, NULL, NULL, '80152', 6.108129, 80.393927),
(420, 6, 'Mahawela Sinhapura', NULL, NULL, NULL, NULL, NULL, '51076', 6.3167, 80.0333),
(421, 6, 'Mapalagama', NULL, NULL, NULL, NULL, NULL, '80112', 6.234713, 80.27784),
(422, 6, 'Mapalagama Central', NULL, NULL, NULL, NULL, NULL, '80116', 6.2167, 80.3),
(423, 6, 'Mattaka', NULL, NULL, NULL, NULL, NULL, '80424', 6.302366, 80.254218),
(424, 6, 'Meda-Keembiya', NULL, NULL, NULL, NULL, NULL, '80092', 6.1845, 80.3032),
(425, 6, 'Meetiyagoda', NULL, NULL, NULL, NULL, NULL, '80330', 6.189135, 80.093504),
(426, 6, 'Nagoda', NULL, NULL, NULL, NULL, NULL, '80110', 6.201296, 80.277829),
(427, 6, 'Nakiyadeniya', NULL, NULL, NULL, NULL, NULL, '80064', 6.143029, 80.338164),
(428, 6, 'Nawadagala', NULL, NULL, NULL, NULL, NULL, '80416', 6.304655, 80.134175),
(429, 6, 'Neluwa', NULL, NULL, NULL, NULL, NULL, '80082', 6.37393, 80.363267),
(430, 6, 'Nindana', NULL, NULL, NULL, NULL, NULL, '80318', 6.207731, 80.107663),
(431, 6, 'Pahala Millawa', NULL, NULL, NULL, NULL, NULL, '81472', 6.293995, 80.475431),
(432, 6, 'Panangala', NULL, NULL, NULL, NULL, NULL, '80075', 6.274182, 80.334525),
(433, 6, 'Pannimulla Panagoda', NULL, NULL, NULL, NULL, NULL, '80086', 6.36, 80.3653),
(434, 6, 'Parana ThanaYamgoda', NULL, NULL, NULL, NULL, NULL, '80114', 6.2167, 80.3),
(435, 6, 'Patana', NULL, NULL, NULL, NULL, NULL, '22012', 6.1333, 80.1167),
(436, 6, 'Pitigala', NULL, NULL, NULL, NULL, NULL, '80420', 6.348894, 80.217851),
(437, 6, 'Poddala', NULL, NULL, NULL, NULL, NULL, '80170', 6.1167, 80.2167),
(438, 6, 'Polgampola', NULL, NULL, NULL, NULL, NULL, '12136', 6.3244, 80.4383),
(439, 6, 'Porawagama', NULL, NULL, NULL, NULL, NULL, '80408', 6.279568, 80.231811),
(440, 6, 'Rantotuwila', NULL, NULL, NULL, NULL, NULL, '80354', 6.3833, 80.0833),
(441, 6, 'Talagampola', NULL, NULL, NULL, NULL, NULL, '80058', 6.0667, 80.3),
(442, 6, 'Talgaspe', NULL, NULL, NULL, NULL, NULL, '80406', 6.3, 80.2),
(443, 6, 'Talpe', NULL, NULL, NULL, NULL, NULL, '80615', 6.0061, 80.2961),
(444, 6, 'Tawalama', NULL, NULL, NULL, NULL, NULL, '80148', 6.3333, 80.3333),
(445, 6, 'Tiranagama', NULL, NULL, NULL, NULL, NULL, '80244', 6.1333, 80.1167),
(446, 6, 'Udalamatta', NULL, NULL, NULL, NULL, NULL, '80108', 6.18924, 80.306106),
(447, 6, 'Udugama', NULL, NULL, NULL, NULL, NULL, '80070', 6.188469, 80.338951),
(448, 6, 'Uluvitike', NULL, NULL, NULL, NULL, NULL, '80168', 6.3056, 80.309),
(449, 6, 'Unawatuna', NULL, NULL, NULL, NULL, NULL, '80600', 6.0169, 80.249901),
(450, 6, 'Unenwitiya', NULL, NULL, NULL, NULL, NULL, '80214', 6.2417, 80.225),
(451, 6, 'Uragaha', NULL, NULL, NULL, NULL, NULL, '80352', 6.35, 80.1167),
(452, 6, 'Uragasmanhandiya', NULL, NULL, NULL, NULL, NULL, '80350', 6.358461, 80.082277),
(453, 6, 'Wakwella', NULL, NULL, NULL, NULL, NULL, '80042', 6.1, 80.1833),
(454, 6, 'Walahanduwa', NULL, NULL, NULL, NULL, NULL, '80046', 6.05443, 80.251763),
(455, 6, 'Wanchawela', NULL, NULL, NULL, NULL, NULL, '80120', 6.0333, 80.3167),
(456, 6, 'Wanduramba', NULL, NULL, NULL, NULL, NULL, '80100', 6.136388, 80.252794),
(457, 6, 'Warukandeniya', NULL, NULL, NULL, NULL, NULL, '80084', 6.381574, 80.43131),
(458, 6, 'Watugedara', NULL, NULL, NULL, NULL, NULL, '80340', 6.25, 80.05),
(459, 6, 'Weihena', NULL, NULL, NULL, NULL, NULL, '80216', 6.310127, 80.23392),
(460, 6, 'Welikanda', NULL, NULL, NULL, NULL, NULL, '51070', 6.3167, 80.0333),
(461, 6, 'Wilanagama', NULL, NULL, NULL, NULL, NULL, '20142', 6.4167, 80),
(462, 6, 'Yakkalamulla', NULL, NULL, NULL, NULL, NULL, '80150', 6.109027, 80.349195),
(463, 6, 'Yatalamatta', NULL, NULL, NULL, NULL, NULL, '80107', 6.172247, 80.293052),
(464, 7, 'Akaragama', 'අකරගම', NULL, NULL, NULL, NULL, '11536', 7.262603, 79.958057),
(465, 7, 'Ambagaspitiya', 'අඹගස්පිටිය', NULL, NULL, NULL, NULL, '11052', 7.0833, 80.0667),
(466, 7, 'Ambepussa', 'අඹේපුස්ස', NULL, NULL, NULL, NULL, '11212', 7.25, 80.1667),
(467, 7, 'Andiambalama', 'ආඬිඅම්බලම', NULL, NULL, NULL, NULL, '11558', 7.188346, 79.902344),
(468, 7, 'Attanagalla', 'අත්තනගල්ල', NULL, NULL, NULL, NULL, '11120', 7.1119, 80.1328),
(469, 7, 'Badalgama', 'බඩල්ගම', NULL, NULL, NULL, NULL, '11538', 7.291218, 79.978003),
(470, 7, 'Banduragoda', 'බඳුරගොඩ', NULL, NULL, NULL, NULL, '11244', 7.2319, 80.0678),
(471, 7, 'Batuwatta', 'බටුවත්ත', NULL, NULL, NULL, NULL, '11011', 7.058399, 79.932048),
(472, 7, 'Bemmulla', 'බෙම්මුල්ල', NULL, NULL, NULL, NULL, '11040', 7.120933, 80.028191),
(473, 7, 'Biyagama IPZ', 'බියගම IPZ', NULL, NULL, NULL, NULL, '11672', 6.9492, 80.0153),
(474, 7, 'Bokalagama', 'බොකලගම', NULL, NULL, NULL, NULL, '11216', 7.2333, 80.15),
(475, 7, 'Bollete (WP)', 'බොල්ලතේ', NULL, NULL, NULL, NULL, '11024', 7.0667, 79.95),
(476, 7, 'Bopagama', 'බෝපගම', NULL, NULL, NULL, NULL, '11134', 7.079641, 80.15868),
(477, 7, 'Buthpitiya', 'බුත්පිටිය', NULL, NULL, NULL, NULL, '11720', 7.042846, 80.051854),
(478, 7, 'Dagonna', 'දාගොන්න', NULL, NULL, NULL, NULL, '11524', 7.221568, 79.927455),
(479, 7, 'Danowita', 'දංඕවිට', NULL, NULL, NULL, NULL, '11896', 7.2028, 80.1758),
(480, 7, 'Debahera', 'දෙබහැර', NULL, NULL, NULL, NULL, '11889', 7.1389, 80.0981),
(481, 7, 'Dekatana', 'දෙකටන', NULL, NULL, NULL, NULL, '11690', 6.968317, 80.035385),
(482, 7, 'Delgoda', 'දෙල්ගොඩ', NULL, NULL, NULL, NULL, '11700', 6.986583, 80.01576),
(483, 7, 'Delwagura', 'දෙල්වගුර', NULL, NULL, NULL, NULL, '11228', 7.265367, 80.003272),
(484, 7, 'Demalagama', 'දෙමළගම', NULL, NULL, NULL, NULL, '11692', 6.988934, 80.046886),
(485, 7, 'Demanhandiya', 'දෙමන්හන්දිය', NULL, NULL, NULL, NULL, '11270', 7.2333, 79.9),
(486, 7, 'Dewalapola', 'දේවාලපොල', NULL, NULL, NULL, NULL, '11102', 7.162553, 79.997446),
(487, 7, 'Divulapitiya', 'දිවුලපිටිය', NULL, NULL, NULL, NULL, '11250', 7.2167, 80.0156),
(488, 7, 'Divuldeniya', 'දිවුල්දෙණිය', NULL, NULL, NULL, NULL, '11208', 7.3, 80.1),
(489, 7, 'Dompe', 'දොම්පෙ', NULL, NULL, NULL, NULL, '11680', 6.949806, 80.055083),
(490, 7, 'Dunagaha', 'දුනගහ', NULL, NULL, NULL, NULL, '11264', 7.2342, 79.9756),
(491, 7, 'Ekala', 'ඒකල', NULL, NULL, NULL, NULL, '11380', 7.105558, 79.91532),
(492, 7, 'Ellakkala', 'ඇල්ලක්කල', NULL, NULL, NULL, NULL, '11116', 7.135968, 80.132524),
(493, 7, 'Essella', NULL, NULL, NULL, NULL, NULL, '11108', 7.178736, 80.021603),
(494, 7, 'Galedanda', 'ගලේදණ්ඩ', NULL, NULL, NULL, NULL, '90206', 6.964202, 79.930611),
(495, 7, 'Gampaha', 'ගම්පහ', NULL, NULL, NULL, NULL, '11000', 7.0917, 79.9942),
(496, 7, 'Ganemulla', 'ගණේමුල්ල', NULL, NULL, NULL, NULL, '11020', 7.064183, 79.963294),
(497, 7, 'Giriulla', 'ගිරිවුල්ල', NULL, NULL, NULL, NULL, '60140', 7.3275, 80.1267),
(498, 7, 'Gonawala', 'ගෝනවල', NULL, NULL, NULL, NULL, '11630', 6.9612, 79.9992),
(499, 7, 'Halpe', 'හල්පෙ', NULL, NULL, NULL, NULL, '70145', 7.261935, 80.10821),
(500, 7, 'Hapugastenna', NULL, NULL, NULL, NULL, NULL, '70164', 7.1, 80.1667),
(501, 7, 'Heiyanthuduwa', NULL, NULL, NULL, NULL, NULL, '11618', 6.96283, 79.963309),
(502, 7, 'Hinatiyana Madawala', NULL, NULL, NULL, NULL, NULL, '11568', 7.1667, 79.95),
(503, 7, 'Hiswella', NULL, NULL, NULL, NULL, NULL, '11734', 7.021559, 80.160869),
(504, 7, 'Horampella', NULL, NULL, NULL, NULL, NULL, '11564', 7.185188, 79.976771),
(505, 7, 'Hunumulla', NULL, NULL, NULL, NULL, NULL, '11262', 7.244925, 79.996921),
(506, 7, 'Hunupola', NULL, NULL, NULL, NULL, NULL, '60582', 7.111463, 80.130625),
(507, 7, 'Ihala Madampella', NULL, NULL, NULL, NULL, NULL, '11265', 7.250345, 79.960941),
(508, 7, 'Imbulgoda', NULL, NULL, NULL, NULL, NULL, '11856', 7.035, 79.9931),
(509, 7, 'Ja-Ela', NULL, NULL, NULL, NULL, NULL, '11350', 7.076147, 79.894932),
(510, 7, 'Kadawatha', NULL, NULL, NULL, NULL, NULL, '11850', 7.0258, 79.9882),
(511, 7, 'Kahatowita', NULL, NULL, NULL, NULL, NULL, '11144', 7.0667, 80.1167),
(512, 7, 'Kalagedihena', NULL, NULL, NULL, NULL, NULL, '11875', 7.118004, 80.058001),
(513, 7, 'Kaleliya', NULL, NULL, NULL, NULL, NULL, '11160', 7.195, 80.1136),
(514, 7, 'Kandana', NULL, NULL, NULL, NULL, NULL, '11320', 7.05056, 79.895123),
(515, 7, 'Katana', NULL, NULL, NULL, NULL, NULL, '11534', 7.2517, 79.9078),
(516, 7, 'Katudeniya', NULL, NULL, NULL, NULL, NULL, '21016', 7.3, 80.0833),
(517, 7, 'Katunayake', NULL, NULL, NULL, NULL, NULL, '11450', 7.1647, 79.8731),
(518, 7, 'Katunayake Air Force Camp', NULL, NULL, NULL, NULL, NULL, '11440', 7.1407, 79.8782),
(519, 7, 'Katunayake(FTZ)', NULL, NULL, NULL, NULL, NULL, '11420', 7.1407, 79.8782),
(520, 7, 'Katuwellegama', NULL, NULL, NULL, NULL, NULL, '11526', 7.208557, 79.94572),
(521, 7, 'Kelaniya', NULL, NULL, NULL, NULL, NULL, '11600', 6.956357, 79.921431),
(522, 7, 'Kimbulapitiya', NULL, NULL, NULL, NULL, NULL, '11522', 7.202265, 79.908937),
(523, 7, 'Kirindiwela', NULL, NULL, NULL, NULL, NULL, '11730', 7.044223, 80.126707),
(524, 7, 'Kitalawalana', NULL, NULL, NULL, NULL, NULL, '11206', 7.3, 80.1),
(525, 7, 'Kochchikade', NULL, NULL, NULL, NULL, NULL, '11540', 7.2581, 79.8542),
(526, 7, 'Kotadeniyawa', NULL, NULL, NULL, NULL, NULL, '11232', 7.279861, 80.05581),
(527, 7, 'Kotugoda', NULL, NULL, NULL, NULL, NULL, '11390', 7.1217, 79.9297),
(528, 7, 'Kumbaloluwa', NULL, NULL, NULL, NULL, NULL, '11105', 7.179375, 80.082233),
(529, 7, 'Loluwagoda', NULL, NULL, NULL, NULL, NULL, '11204', 7.294586, 80.126624),
(530, 7, 'Mabodale', NULL, NULL, NULL, NULL, NULL, '11114', 7.2, 80.0167),
(531, 7, 'Madelgamuwa', NULL, NULL, NULL, NULL, NULL, '11033', 7.110062, 79.948175),
(532, 7, 'Makewita', NULL, NULL, NULL, NULL, NULL, '11358', 7.1, 79.9333),
(533, 7, 'Makola', NULL, NULL, NULL, NULL, NULL, '11640', 6.983178, 79.9525),
(534, 7, 'Malwana', NULL, NULL, NULL, NULL, NULL, '11670', 6.951988, 80.012561),
(535, 7, 'Mandawala', NULL, NULL, NULL, NULL, NULL, '11061', 7.003066, 80.097082),
(536, 7, 'Marandagahamula', NULL, NULL, NULL, NULL, NULL, '11260', 7.2447, 79.9696),
(537, 7, 'Mellawagedara', NULL, NULL, NULL, NULL, NULL, '11234', 7.285808, 80.023977),
(538, 7, 'Minuwangoda', NULL, NULL, NULL, NULL, NULL, '11550', 7.176455, 79.954904),
(539, 7, 'Mirigama', NULL, NULL, NULL, NULL, NULL, '11200', 7.2414, 80.1325),
(540, 7, 'Miriswatta', NULL, NULL, NULL, NULL, NULL, '80508', 7.0711, 80.0183),
(541, 7, 'Mithirigala', NULL, NULL, NULL, NULL, NULL, '11742', 6.9648, 80.0648),
(542, 7, 'Muddaragama', NULL, NULL, NULL, NULL, NULL, '11112', 7.2167, 80.05),
(543, 7, 'Mudungoda', NULL, NULL, NULL, NULL, NULL, '11056', 7.064698, 79.999092),
(544, 7, 'Mulleriyawa New Town', NULL, NULL, NULL, NULL, NULL, '10620', 6.9301, 80.0549),
(545, 7, 'Naranwala', NULL, NULL, NULL, NULL, NULL, '11063', 7.001631, 80.027404),
(546, 7, 'Nawana', NULL, NULL, NULL, NULL, NULL, '11222', 7.270062, 80.092618),
(547, 7, 'Nedungamuwa', NULL, NULL, NULL, NULL, NULL, '11066', 7.05, 80.0333),
(548, 7, 'Negombo', NULL, NULL, NULL, NULL, NULL, '11500', 7.2086, 79.8358),
(549, 7, 'Nikadalupotha', NULL, NULL, NULL, NULL, NULL, '60580', 7.1167, 80.1333),
(550, 7, 'Nikahetikanda', NULL, NULL, NULL, NULL, NULL, '11128', 7.099089, 80.179551),
(551, 7, 'Nittambuwa', NULL, NULL, NULL, NULL, NULL, '11880', 7.144243, 80.096178),
(552, 7, 'Niwandama', NULL, NULL, NULL, NULL, NULL, '11354', 7.078762, 79.928331),
(553, 7, 'Opatha', NULL, NULL, NULL, NULL, NULL, '80142', 7.132037, 79.921419),
(554, 7, 'Pamunugama', NULL, NULL, NULL, NULL, NULL, '11370', 7.094359, 79.844569),
(555, 7, 'Pamunuwatta', NULL, NULL, NULL, NULL, NULL, '11214', 7.214678, 80.139696),
(556, 7, 'Panawala', NULL, NULL, NULL, NULL, NULL, '70612', 6.9833, 80.0333),
(557, 7, 'Pasyala', NULL, NULL, NULL, NULL, NULL, '11890', 7.172926, 80.115911),
(558, 7, 'Peliyagoda', NULL, NULL, NULL, NULL, NULL, '11830', 6.960977, 79.878852),
(559, 7, 'Pepiliyawala', NULL, NULL, NULL, NULL, NULL, '11741', 7.002342, 80.128886),
(560, 7, 'Pethiyagoda', NULL, NULL, NULL, NULL, NULL, '11043', 7.1167, 80.0167),
(561, 7, 'Polpithimukulana', NULL, NULL, NULL, NULL, NULL, '11324', 7.0444, 79.8782),
(562, 7, 'Puwakpitiya', NULL, NULL, NULL, NULL, NULL, '10712', 7.040498, 80.064451),
(563, 7, 'Radawadunna', NULL, NULL, NULL, NULL, NULL, '11892', 7.177279, 80.141344),
(564, 7, 'Radawana', NULL, NULL, NULL, NULL, NULL, '11725', 7.029871, 80.100915),
(565, 7, 'Raddolugama', NULL, NULL, NULL, NULL, NULL, '11400', 7.140656, 79.898198),
(566, 7, 'Ragama', NULL, NULL, NULL, NULL, NULL, '11010', 7.025281, 79.917386),
(567, 7, 'Ruggahawila', NULL, NULL, NULL, NULL, NULL, '11142', 7.0667, 80.1167),
(568, 7, 'Seeduwa', NULL, NULL, NULL, NULL, NULL, '11410', 7.132059, 79.885024),
(569, 7, 'Siyambalape', NULL, NULL, NULL, NULL, NULL, '11607', 6.964545, 79.986406),
(570, 7, 'Talahena', NULL, NULL, NULL, NULL, NULL, '11504', 7.1667, 79.8167),
(571, 7, 'Thambagalla', NULL, NULL, NULL, NULL, NULL, '60584', 7.1167, 80.1333),
(572, 7, 'Thimbirigaskatuwa', NULL, NULL, NULL, NULL, NULL, '11532', 7.2669, 79.9495),
(573, 7, 'Tittapattara', NULL, NULL, NULL, NULL, NULL, '10664', 6.9297, 80.0889),
(574, 7, 'Udathuthiripitiya', NULL, NULL, NULL, NULL, NULL, '11054', 7.075, 80.0333),
(575, 7, 'Udugampola', NULL, NULL, NULL, NULL, NULL, '11030', 7.1167, 79.9833),
(576, 7, 'Uggalboda', NULL, NULL, NULL, NULL, NULL, '11034', 7.135549, 79.948259),
(577, 7, 'Urapola', NULL, NULL, NULL, NULL, NULL, '11126', 7.104792, 80.136935),
(578, 7, 'Uswetakeiyawa', NULL, NULL, NULL, NULL, NULL, '11328', 7.031046, 79.860339),
(579, 7, 'Veyangoda', NULL, NULL, NULL, NULL, NULL, '11100', 7.156981, 80.095842),
(580, 7, 'Walgammulla', NULL, NULL, NULL, NULL, NULL, '11146', 7.071902, 80.116511),
(581, 7, 'Walpita', NULL, NULL, NULL, NULL, NULL, '11226', 7.258131, 80.034704),
(582, 7, 'Walpola (WP)', NULL, NULL, NULL, NULL, NULL, '11012', 7.0418, 79.9257),
(583, 7, 'Wathurugama', NULL, NULL, NULL, NULL, NULL, '11724', 7.0421, 80.0701),
(584, 7, 'Watinapaha', NULL, NULL, NULL, NULL, NULL, '11104', 7.2, 79.9833),
(585, 7, 'Wattala', NULL, NULL, NULL, NULL, NULL, '11104', 6.990037, 79.892207),
(586, 7, 'Weboda', NULL, NULL, NULL, NULL, NULL, '11858', 7.0167, 79.9833),
(587, 7, 'Wegowwa', NULL, NULL, NULL, NULL, NULL, '11562', 7.178443, 79.962063),
(588, 7, 'Weweldeniya', NULL, NULL, NULL, NULL, NULL, '11894', 7.1834, 80.1446),
(589, 7, 'Yakkala', NULL, NULL, NULL, NULL, NULL, '11870', 7.1167, 80.05),
(590, 7, 'Yatiyana', NULL, NULL, NULL, NULL, NULL, '11566', 7.184998, 79.931858),
(591, 8, 'Ambalantota', 'අම්බලන්තොට', NULL, NULL, NULL, NULL, '82100', 6.114494, 81.025983),
(592, 8, 'Angunakolapelessa', 'අඟුණකොළපැලැස්ස', NULL, NULL, NULL, NULL, '82220', 6.162261, 80.899471),
(593, 8, 'Angunakolawewa', 'අඟුණකොලවැව', NULL, NULL, NULL, NULL, '91302', 6.389127, 81.093226),
(594, 8, 'Bandagiriya Colony', 'බන්ඩගිරිය කොලොනි', NULL, NULL, NULL, NULL, '82005', 6.1833, 81.1389),
(595, 8, 'Barawakumbuka', 'බරවකුඹුර', NULL, NULL, NULL, NULL, '82110', 6.1667, 80.8167),
(596, 8, 'Beliatta', 'බෙලිඅත්ත', NULL, NULL, NULL, NULL, '82400', 6.048637, 80.734343),
(597, 8, 'Beragama', 'බෙරගම', NULL, NULL, NULL, NULL, '82102', 6.15, 81.0667),
(598, 8, 'Beralihela', 'බෙරලිහෙල', NULL, NULL, NULL, NULL, '82618', 6.2556, 81.2944),
(599, 8, 'Bundala', 'බූන්දල', NULL, NULL, NULL, NULL, '82002', 6.195164, 81.250493),
(600, 8, 'Ellagala', 'ඇල්ලගල', NULL, NULL, NULL, NULL, '82619', 6.26867, 81.359512);
INSERT INTO `country_cities` (`id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude`) VALUES
(601, 8, 'Gangulandeniya', 'ගඟුලදෙණිය', NULL, NULL, NULL, NULL, '82586', 6.2833, 80.7167),
(602, 8, 'Getamanna', 'ගැටමාන්න', NULL, NULL, NULL, NULL, '82420', 6.036244, 80.669146),
(603, 8, 'Goda Koggalla', 'ගොඩ කොග්ගල්ල', NULL, NULL, NULL, NULL, '82401', 6.0333, 80.75),
(604, 8, 'Gonagamuwa Uduwila', 'ගොනාගමුව උඩුවිල', NULL, NULL, NULL, NULL, '82602', 6.25, 81.2917),
(605, 8, 'Gonnoruwa', 'ගොන්නොරුව', NULL, NULL, NULL, NULL, '82006', 6.230443, 81.112465),
(606, 8, 'Hakuruwela', 'හකුරුවෙල', NULL, NULL, NULL, NULL, '82248', 6.146456, 80.83047),
(607, 8, 'Hambantota', 'හම්බන්තොට', NULL, NULL, NULL, NULL, '82000', 6.127563, 81.111287),
(608, 8, 'Handugala', 'හඳගුල', NULL, NULL, NULL, NULL, '81326', 6.188877, 80.62414),
(609, 8, 'Hungama', NULL, NULL, NULL, NULL, NULL, '82120', 6.108006, 80.927144),
(610, 8, 'Ihala Beligalla', NULL, NULL, NULL, NULL, NULL, '82412', 6.092378, 80.747311),
(611, 8, 'Ittademaliya', NULL, NULL, NULL, NULL, NULL, '82462', 6.167432, 80.735179),
(612, 8, 'Julampitiya', NULL, NULL, NULL, NULL, NULL, '82252', 6.2261, 80.7403),
(613, 8, 'Kahandamodara', NULL, NULL, NULL, NULL, NULL, '82126', 6.078654, 80.902917),
(614, 8, 'Kariyamaditta', NULL, NULL, NULL, NULL, NULL, '82274', 6.257359, 80.809448),
(615, 8, 'Katuwana', NULL, NULL, NULL, NULL, NULL, '82500', 6.2667, 80.6972),
(616, 8, 'Kawantissapura', NULL, NULL, NULL, NULL, NULL, '82622', 6.2786, 81.2524),
(617, 8, 'Kirama', NULL, NULL, NULL, NULL, NULL, '82550', 6.2117, 80.6653),
(618, 8, 'Kirinda', NULL, NULL, NULL, NULL, NULL, '82614', 6.268985, 81.290653),
(619, 8, 'Lunama', NULL, NULL, NULL, NULL, NULL, '82108', 6.098517, 80.971511),
(620, 8, 'Lunugamwehera', NULL, NULL, NULL, NULL, NULL, '82634', 6.3417, 81.15),
(621, 8, 'Magama', NULL, NULL, NULL, NULL, NULL, '82608', 6.280108, 81.270354),
(622, 8, 'Mahagalwewa', NULL, NULL, NULL, NULL, NULL, '82016', 6.1833, 81.1389),
(623, 8, 'Mamadala', NULL, NULL, NULL, NULL, NULL, '82109', 6.158126, 80.96681),
(624, 8, 'Medamulana', NULL, NULL, NULL, NULL, NULL, '82254', 6.175878, 80.770016),
(625, 8, 'Middeniya', NULL, NULL, NULL, NULL, NULL, '82270', 6.2494, 80.7672),
(626, 8, 'Migahajandur', NULL, NULL, NULL, NULL, NULL, '82014', 6.1833, 81.1389),
(627, 8, 'Modarawana', NULL, NULL, NULL, NULL, NULL, '82416', 6.117576, 80.720781),
(628, 8, 'Mulkirigala', NULL, NULL, NULL, NULL, NULL, '82242', 6.12, 80.7397),
(629, 8, 'Nakulugamuwa', NULL, NULL, NULL, NULL, NULL, '82300', 6.1842, 80.9063),
(630, 8, 'Netolpitiya', NULL, NULL, NULL, NULL, NULL, '82135', 6.066848, 80.850703),
(631, 8, 'Nihiluwa', NULL, NULL, NULL, NULL, NULL, '82414', 6.077147, 80.696499),
(632, 8, 'Padawkema', NULL, NULL, NULL, NULL, NULL, '82636', 6.35, 81.1667),
(633, 8, 'Pahala Andarawewa', NULL, NULL, NULL, NULL, NULL, '82008', 6.1833, 81.1389),
(634, 8, 'Rammalawarapitiya', NULL, NULL, NULL, NULL, NULL, '82554', 6.2117, 80.6653),
(635, 8, 'Ranakeliya', NULL, NULL, NULL, NULL, NULL, '82612', 6.2167, 81.3),
(636, 8, 'Ranmuduwewa', NULL, NULL, NULL, NULL, NULL, '82018', 6.1833, 81.1389),
(637, 8, 'Ranna', NULL, NULL, NULL, NULL, NULL, '82125', 6.103377, 80.890168),
(638, 8, 'Ratmalwala', NULL, NULL, NULL, NULL, NULL, '82276', 6.2667, 80.85),
(639, 8, 'RU/Ridiyagama', NULL, NULL, NULL, NULL, NULL, '82106', 6.1375, 81.0042),
(640, 8, 'Sooriyawewa Town', NULL, NULL, NULL, NULL, NULL, '82010', 6.1833, 81.1389),
(641, 8, 'Tangalla', NULL, NULL, NULL, NULL, NULL, '82200', 6.0231, 80.7889),
(642, 8, 'Tissamaharama', NULL, NULL, NULL, NULL, NULL, '82600', 6.370333, 81.328087),
(643, 8, 'Uda Gomadiya', NULL, NULL, NULL, NULL, NULL, '82504', 6.2667, 80.6972),
(644, 8, 'Udamattala', NULL, NULL, NULL, NULL, NULL, '82638', 6.3333, 81.1333),
(645, 8, 'Uswewa', NULL, NULL, NULL, NULL, NULL, '82278', 6.246247, 80.862175),
(646, 8, 'Vitharandeniya', NULL, NULL, NULL, NULL, NULL, '82232', 6.1824, 80.806),
(647, 8, 'Walasmulla', NULL, NULL, NULL, NULL, NULL, '82450', 6.15, 80.7),
(648, 8, 'Weeraketiya', NULL, NULL, NULL, NULL, NULL, '82240', 6.135, 80.7865),
(649, 8, 'Weerawila', NULL, NULL, NULL, NULL, NULL, '82632', 6.3417, 81.15),
(650, 8, 'Weerawila NewTown', NULL, NULL, NULL, NULL, NULL, '82615', 6.2556, 81.2944),
(651, 8, 'Wekandawela', NULL, NULL, NULL, NULL, NULL, '82246', 6.135, 80.7865),
(652, 8, 'Weligatta', NULL, NULL, NULL, NULL, NULL, '82004', 6.205897, 81.196032),
(653, 8, 'Yatigala', NULL, NULL, NULL, NULL, NULL, '82418', 6.1, 80.6833),
(654, 9, 'Jaffna', NULL, NULL, NULL, NULL, NULL, '40000', 9.660668, 80.022706),
(655, 10, 'Agalawatta', 'අගලවත්ත', NULL, NULL, NULL, NULL, '12200', 6.541499, 80.155785),
(656, 10, 'Alubomulla', 'අලුබෝමුල්ල', NULL, NULL, NULL, NULL, '12524', 6.711977, 79.965857),
(657, 10, 'Anguruwatota', 'අංගුරුවතොට', NULL, NULL, NULL, NULL, '12320', 6.6383, 80.0861),
(658, 10, 'Atale', 'අටලේ', NULL, NULL, NULL, NULL, '71363', 6.45, 80.2667),
(659, 10, 'Baduraliya', 'බදුරලීය', NULL, NULL, NULL, NULL, '12230', 6.523102, 80.232371),
(660, 10, 'Bandaragama', 'බණ්ඩාරගම', NULL, NULL, NULL, NULL, '12530', 6.710264, 79.986087),
(661, 10, 'Batugampola', 'බටුගම්පොල', NULL, NULL, NULL, NULL, '10526', 6.769068, 80.142775),
(662, 10, 'Bellana', 'බෙල්ලන', NULL, NULL, NULL, NULL, '12224', 6.518936, 80.183117),
(663, 10, 'Beruwala', 'බේරුවල', NULL, NULL, NULL, NULL, '12070', 6.4739, 79.9842),
(664, 10, 'Bolossagama', 'බොලොස්සගම', NULL, NULL, NULL, NULL, '12008', 6.62099, 80.015288),
(665, 10, 'Bombuwala', 'බොඹුවල', NULL, NULL, NULL, NULL, '12024', 6.5833, 80.0167),
(666, 10, 'Boralugoda', 'බොරළුගොඩ', NULL, NULL, NULL, NULL, '12142', 6.438709, 80.278799),
(667, 10, 'Bulathsinhala', 'බුලත්සිංහල', NULL, NULL, NULL, NULL, '12300', 6.666199, 80.164896),
(668, 10, 'Danawala Thiniyawala', 'දනවල තිනියවල', NULL, NULL, NULL, NULL, '12148', 6.4333, 80.2667),
(669, 10, 'Delmella', 'දෙල්මෙල්ල', NULL, NULL, NULL, NULL, '12304', 6.67833, 80.210488),
(670, 10, 'Dharga Town', 'දර්ගා නගරය', NULL, NULL, NULL, NULL, '12090', 6.441, 80.0089),
(671, 10, 'Diwalakada', 'දිවාලකද', NULL, NULL, NULL, NULL, '12308', 6.696767, 80.146983),
(672, 10, 'Dodangoda', 'දොඩන්ගොඩ', NULL, NULL, NULL, NULL, '12020', 6.555952, 80.006847),
(673, 10, 'Dombagoda', 'දොඹගොඩ', NULL, NULL, NULL, NULL, '12416', 6.661797, 80.053343),
(674, 10, 'Ethkandura', 'ඇත්කඳුර', NULL, NULL, NULL, NULL, '80458', 6.4415, 80.1807),
(675, 10, 'Galpatha', 'ගල්පාත', NULL, NULL, NULL, NULL, '12005', 6.5983, 80.0015),
(676, 10, 'Gamagoda', 'ගමගොඩ', NULL, NULL, NULL, NULL, '12016', 6.597103, 80.005539),
(677, 10, 'Gonagalpura', 'ගොනාගල්පුර', NULL, NULL, NULL, NULL, '80502', 6.6307, 80.0169),
(678, 10, 'Gonapola Junction', 'ගෝනපොල හංදිය', NULL, NULL, NULL, NULL, '12410', 6.6944, 80.0333),
(679, 10, 'Govinna', 'ගෝවින්න', NULL, NULL, NULL, NULL, '12310', 6.663337, 80.116274),
(680, 10, 'Gurulubadda', 'ගුරුලුබැද්ද', NULL, NULL, NULL, NULL, '12236', 6.5333, 80.2667),
(681, 10, 'Halkandawila', 'හල්කන්දවිල', NULL, NULL, NULL, NULL, '12055', 6.5167, 80.0167),
(682, 10, 'Haltota', 'හල්තොට', NULL, NULL, NULL, NULL, '12538', 6.69554, 80.02127),
(683, 10, 'Halvitigala Colony', 'හල්විටගල ජනපදය', NULL, NULL, NULL, NULL, '80146', 6.5791, 80.2233),
(684, 10, 'Halwala', 'හල්වල', NULL, NULL, NULL, NULL, '12118', 6.416524, 80.106562),
(685, 10, 'Halwatura', 'හල්වතුර', NULL, NULL, NULL, NULL, '12306', 6.7, 80.2),
(686, 10, 'Handapangoda', 'හඳපාන්ගොඩ', NULL, NULL, NULL, NULL, '10524', 6.789746, 80.140774),
(687, 10, 'Hedigalla Colony', NULL, NULL, NULL, NULL, NULL, '12234', 6.5333, 80.2667),
(688, 10, 'Henegama', NULL, NULL, NULL, NULL, NULL, '11715', 6.7167, 80.0333),
(689, 10, 'Hettimulla', NULL, NULL, NULL, NULL, NULL, '71210', 6.461362, 79.992643),
(690, 10, 'Horana', NULL, NULL, NULL, NULL, NULL, '12400', 6.719389, 80.061557),
(691, 10, 'Ittapana', NULL, NULL, NULL, NULL, NULL, '12116', 6.42254, 80.079501),
(692, 10, 'Kahawala', NULL, NULL, NULL, NULL, NULL, '10508', 6.7833, 80.1),
(693, 10, 'Kalawila Kiranthidiya', NULL, NULL, NULL, NULL, NULL, '12078', 6.4619, 80.0004),
(694, 10, 'Kalutara', NULL, NULL, NULL, NULL, NULL, '12000', 6.581333, 79.958546),
(695, 10, 'Kananwila', NULL, NULL, NULL, NULL, NULL, '12418', 6.7667, 80.05),
(696, 10, 'Kandanagama', NULL, NULL, NULL, NULL, NULL, '12428', 6.7667, 80.0778),
(697, 10, 'Kelinkanda', NULL, NULL, NULL, NULL, NULL, '12218', 6.587128, 80.29322),
(698, 10, 'Kitulgoda', NULL, NULL, NULL, NULL, NULL, '12222', 6.5167, 80.1833),
(699, 10, 'Koholana', NULL, NULL, NULL, NULL, NULL, '12007', 6.618149, 79.989353),
(700, 10, 'Kuda Uduwa', NULL, NULL, NULL, NULL, NULL, '12426', 6.747871, 80.078499),
(701, 10, 'Labbala', NULL, NULL, NULL, NULL, NULL, '60162', 6.4833, 80),
(702, 10, 'lhalahewessa', NULL, NULL, NULL, NULL, NULL, '80432', 6.4415, 80.1807),
(703, 10, 'lnduruwa', NULL, NULL, NULL, NULL, NULL, '80510', 6.4681, 80.0257),
(704, 10, 'lngiriya', NULL, NULL, NULL, NULL, NULL, '12440', 6.7296, 80.0604),
(705, 10, 'Maggona', NULL, NULL, NULL, NULL, NULL, '12060', 6.503158, 79.977597),
(706, 10, 'Mahagama', NULL, NULL, NULL, NULL, NULL, '12210', 6.620177, 80.154204),
(707, 10, 'Mahakalupahana', NULL, NULL, NULL, NULL, NULL, '12126', 6.3917, 80.1417),
(708, 10, 'Maharangalla', NULL, NULL, NULL, NULL, NULL, '71211', 6.4667, 80),
(709, 10, 'Malgalla Talangalla', NULL, NULL, NULL, NULL, NULL, '80144', 6.5791, 80.2233),
(710, 10, 'Matugama', NULL, NULL, NULL, NULL, NULL, '12100', 6.5222, 80.1144),
(711, 10, 'Meegahatenna', NULL, NULL, NULL, NULL, NULL, '12130', 6.3637, 80.285),
(712, 10, 'Meegama', NULL, NULL, NULL, NULL, NULL, '12094', 6.648, 80.0089),
(713, 10, 'Meegoda', NULL, NULL, NULL, NULL, NULL, '10504', 6.8053, 80.0829),
(714, 10, 'Millaniya', NULL, NULL, NULL, NULL, NULL, '12412', 6.686206, 80.017227),
(715, 10, 'Millewa', NULL, NULL, NULL, NULL, NULL, '12422', 6.7833, 80.0667),
(716, 10, 'Miwanapalana', NULL, NULL, NULL, NULL, NULL, '12424', 6.75, 80.1),
(717, 10, 'Molkawa', NULL, NULL, NULL, NULL, NULL, '12216', 6.607725, 80.238612),
(718, 10, 'Morapitiya', NULL, NULL, NULL, NULL, NULL, '12232', 6.527127, 80.263667),
(719, 10, 'Morontuduwa', NULL, NULL, NULL, NULL, NULL, '12564', 6.65, 79.9667),
(720, 10, 'Nawattuduwa', NULL, NULL, NULL, NULL, NULL, '12106', 6.5019, 80.0937),
(721, 10, 'Neboda', NULL, NULL, NULL, NULL, NULL, '12030', 6.5906, 80.0842),
(722, 10, 'Padagoda', NULL, NULL, NULL, NULL, NULL, '12074', 6.456979, 80.009049),
(723, 10, 'Pahalahewessa', NULL, NULL, NULL, NULL, NULL, '12144', 6.4333, 80.2667),
(724, 10, 'Paiyagala', NULL, NULL, NULL, NULL, NULL, '12050', 6.5167, 80.0167),
(725, 10, 'Panadura', NULL, NULL, NULL, NULL, NULL, '12500', 6.7133, 79.9042),
(726, 10, 'Pannala', NULL, NULL, NULL, NULL, NULL, '60160', 6.4833, 80),
(727, 10, 'Paragastota', NULL, NULL, NULL, NULL, NULL, '12414', 6.6667, 80),
(728, 10, 'Paragoda', NULL, NULL, NULL, NULL, NULL, '12302', 6.627108, 80.24112),
(729, 10, 'Paraigama', NULL, NULL, NULL, NULL, NULL, '12122', 6.4167, 80.1167),
(730, 10, 'Pelanda', NULL, NULL, NULL, NULL, NULL, '12214', 6.6056, 80.2333),
(731, 10, 'Pelawatta', NULL, NULL, NULL, NULL, NULL, '12138', 6.385227, 80.207989),
(732, 10, 'Pimbura', NULL, NULL, NULL, NULL, NULL, '70472', 6.570997, 80.161311),
(733, 10, 'Pitagaldeniya', NULL, NULL, NULL, NULL, NULL, '71360', 6.45, 80.2667),
(734, 10, 'Pokunuwita', NULL, NULL, NULL, NULL, NULL, '12404', 6.7333, 80.0333),
(735, 10, 'Poruwedanda', NULL, NULL, NULL, NULL, NULL, '12432', 6.7333, 80.1167),
(736, 10, 'Ratmale', NULL, NULL, NULL, NULL, NULL, '81030', 6.45, 80.2),
(737, 10, 'Remunagoda', NULL, NULL, NULL, NULL, NULL, '12009', 6.594994, 80.031349),
(738, 10, 'Talgaswela', NULL, NULL, NULL, NULL, NULL, '80470', 6.4415, 80.1807),
(739, 10, 'Tebuwana', NULL, NULL, NULL, NULL, NULL, '12025', 6.5944, 80.0611),
(740, 10, 'Uduwara', NULL, NULL, NULL, NULL, NULL, '12322', 6.6167, 80.0667),
(741, 10, 'Utumgama', NULL, NULL, NULL, NULL, NULL, '12127', 6.3917, 80.1417),
(742, 10, 'Veyangalla', NULL, NULL, NULL, NULL, NULL, '12204', 6.5422, 80.1583),
(743, 10, 'Wadduwa', NULL, NULL, NULL, NULL, NULL, '12560', 6.667121, 79.924051),
(744, 10, 'Walagedara', NULL, NULL, NULL, NULL, NULL, '12112', 6.437775, 80.071449),
(745, 10, 'Walallawita', NULL, NULL, NULL, NULL, NULL, '12134', 6.3667, 80.2),
(746, 10, 'Waskaduwa', NULL, NULL, NULL, NULL, NULL, '12580', 6.6317, 79.9442),
(747, 10, 'Welipenna', NULL, NULL, NULL, NULL, NULL, '12108', 6.466448, 80.101763),
(748, 10, 'Weliveriya', NULL, NULL, NULL, NULL, NULL, '11710', 6.7167, 80.0333),
(749, 10, 'Welmilla Junction', NULL, NULL, NULL, NULL, NULL, '12534', 6.7072, 80.01),
(750, 10, 'Weragala', NULL, NULL, NULL, NULL, NULL, '71622', 6.527062, 80.004097),
(751, 10, 'Yagirala', NULL, NULL, NULL, NULL, NULL, '12124', 6.378714, 80.161812),
(752, 10, 'Yatadolawatta', NULL, NULL, NULL, NULL, NULL, '12104', 6.52309, 80.064428),
(753, 10, 'Yatawara Junction', NULL, NULL, NULL, NULL, NULL, '12006', 6.5983, 80.0015),
(754, 11, 'Aludeniya', 'අලුදෙණිය', NULL, NULL, NULL, NULL, '20062', 7.370491, 80.46648),
(755, 11, 'Ambagahapelessa', 'අඹගහපැලැස්ස', NULL, NULL, NULL, NULL, '20986', 7.243803, 81.00264),
(756, 11, 'Ambagamuwa Udabulathgama', 'අඹගමුව උඩබුලත්ගම', NULL, NULL, NULL, NULL, '20678', 7.0333, 80.5),
(757, 11, 'Ambatenna', 'අඹතැන්න', NULL, NULL, NULL, NULL, '20136', 7.3472, 80.6192),
(758, 11, 'Ampitiya', 'අම්පිටිය', NULL, NULL, NULL, NULL, '20160', 7.2667, 80.65),
(759, 11, 'Ankumbura', 'අංකුඹුර', NULL, NULL, NULL, NULL, '20150', 7.434149, 80.568704),
(760, 11, 'Atabage', 'අටබාගෙ', NULL, NULL, NULL, NULL, '20574', 7.1333, 80.6),
(761, 11, 'Balana', 'බලන', NULL, NULL, NULL, NULL, '20308', 7.269032, 80.485503),
(762, 11, 'Bambaragahaela', 'බඹරගහඇල', NULL, NULL, NULL, NULL, '20644', 7.0523, 80.5023),
(763, 11, 'Batagolladeniya', 'බටගොල්ලදෙණිය', NULL, NULL, NULL, NULL, '20154', 7.41596, 80.576688),
(764, 11, 'Batugoda', 'බටුගොඩ', NULL, NULL, NULL, NULL, '20132', 7.366275, 80.59604),
(765, 11, 'Batumulla', 'බටුමුල්ල', NULL, NULL, NULL, NULL, '20966', 7.256086, 80.978905),
(766, 11, 'Bawlana', 'බව්ලන', NULL, NULL, NULL, NULL, '20218', 7.211388, 80.718828),
(767, 11, 'Bopana', 'බෝපන', NULL, NULL, NULL, NULL, '20932', 7.3, 80.9),
(768, 11, 'Danture', 'දංතුරේ', NULL, NULL, NULL, NULL, '20465', 7.2833, 80.5333),
(769, 11, 'Dedunupitiya', 'දේදුනුපිටිය', NULL, NULL, NULL, NULL, '20068', 7.3333, 80.4333),
(770, 11, 'Dekinda', 'දෙකිඳ', NULL, NULL, NULL, NULL, '20658', 7.014688, 80.509932),
(771, 11, 'Deltota', 'දෙල්තොට', NULL, NULL, NULL, NULL, '20430', 7.2, 80.6667),
(772, 11, 'Divulankadawala', 'දිවුලන්කදවල', NULL, NULL, NULL, NULL, '51428', 7.175, 80.55),
(773, 11, 'Dolapihilla', 'දොලපිහිල්ල', NULL, NULL, NULL, NULL, '20126', 7.393576, 80.584659),
(774, 11, 'Dolosbage', 'දොලොස්බාගෙ', NULL, NULL, NULL, NULL, '20510', 7.0806, 80.4731),
(775, 11, 'Dunuwila', 'දුනුවිල', NULL, NULL, NULL, NULL, '20824', 7.3833, 80.6333),
(776, 11, 'Etulgama', 'ඇතුල්ගම', NULL, NULL, NULL, NULL, '20202', 7.2333, 80.65),
(777, 11, 'Galaboda', 'ගලබොඩ', NULL, NULL, NULL, NULL, '20664', 6.9875, 80.5319),
(778, 11, 'Galagedara', 'ගලගෙදර', NULL, NULL, NULL, NULL, '20100', 7.369716, 80.520308),
(779, 11, 'Galaha', 'ගලහ', NULL, NULL, NULL, NULL, '20420', 7.195764, 80.668659),
(780, 11, 'Galhinna', 'ගල්හින්න', NULL, NULL, NULL, NULL, '20152', 7.418361, 80.560015),
(781, 11, 'Gampola', 'ගම්පොල', NULL, NULL, NULL, NULL, '20500', 7.1647, 80.5767),
(782, 11, 'Gelioya', 'ගෙලිඔය', NULL, NULL, NULL, NULL, '20620', 7.2136, 80.6017),
(783, 11, 'Godamunna', 'ගොඩමුන්න', NULL, NULL, NULL, NULL, '20214', 7.227313, 80.697447),
(784, 11, 'Gomagoda', 'ගොමගොඩ', NULL, NULL, NULL, NULL, '20184', 7.3167, 80.7333),
(785, 11, 'Gonagantenna', 'ගොනාගන්තැන්න', NULL, NULL, NULL, NULL, '20712', 7.1517, 80.7118),
(786, 11, 'Gonawalapatana', 'ගෝනවලපතන', NULL, NULL, NULL, NULL, '20656', 7.0358, 80.5262),
(787, 11, 'Gunnepana', 'ගුන්නෙපන', NULL, NULL, NULL, NULL, '20270', 7.2696, 80.6537),
(788, 11, 'Gurudeniya', 'ගුරුදෙණිය', NULL, NULL, NULL, NULL, '20189', 7.265953, 80.702921),
(789, 11, 'Hakmana', 'හක්මන', NULL, NULL, NULL, NULL, '81300', 7.334701, 80.82402),
(790, 11, 'Handaganawa', 'හඳගනාව', NULL, NULL, NULL, NULL, '20984', 7.277451, 80.989485),
(791, 11, 'Handawalapitiya', 'හඳවලපිටිය', NULL, NULL, NULL, NULL, '20438', 7.2, 80.6667),
(792, 11, 'Handessa', 'හඳැස්ස', NULL, NULL, NULL, NULL, '20480', 7.230048, 80.580831),
(793, 11, 'Hanguranketha', NULL, NULL, NULL, NULL, NULL, '20710', 7.1517, 80.7118),
(794, 11, 'Harangalagama', NULL, NULL, NULL, NULL, NULL, '20669', 7.0271, 80.5493),
(795, 11, 'Hataraliyadda', NULL, NULL, NULL, NULL, NULL, '20060', 7.3333, 80.4667),
(796, 11, 'Hindagala', NULL, NULL, NULL, NULL, NULL, '20414', 7.231512, 80.600815),
(797, 11, 'Hondiyadeniya', NULL, NULL, NULL, NULL, NULL, '20524', 7.1364, 80.5766),
(798, 11, 'Hunnasgiriya', NULL, NULL, NULL, NULL, NULL, '20948', 7.298756, 80.849834),
(799, 11, 'Inguruwatta', NULL, NULL, NULL, NULL, NULL, '60064', 7.175038, 80.599767),
(800, 11, 'Jambugahapitiya', NULL, NULL, NULL, NULL, NULL, '20822', 7.3833, 80.6333),
(801, 11, 'Kadugannawa', NULL, NULL, NULL, NULL, NULL, '20300', 7.2536, 80.5275),
(802, 11, 'Kahataliyadda', NULL, NULL, NULL, NULL, NULL, '20924', 7.376, 80.8213),
(803, 11, 'Kalugala', NULL, NULL, NULL, NULL, NULL, '20926', 7.390136, 80.883008),
(804, 11, 'Kandy', NULL, NULL, NULL, NULL, NULL, '20000', 7.2964, 80.635),
(805, 11, 'Kapuliyadde', NULL, NULL, NULL, NULL, NULL, '20206', 7.2401, 80.6808),
(806, 11, 'Katugastota', NULL, NULL, NULL, NULL, NULL, '20800', 7.3161, 80.6211),
(807, 11, 'Katukitula', NULL, NULL, NULL, NULL, NULL, '20588', 7.1089, 80.6339),
(808, 11, 'Kelanigama', NULL, NULL, NULL, NULL, NULL, '20688', 7.0049, 80.5182),
(809, 11, 'Kengalla', NULL, NULL, NULL, NULL, NULL, '20186', 7.296461, 80.711767),
(810, 11, 'Ketaboola', NULL, NULL, NULL, NULL, NULL, '20660', 7.0271, 80.5493),
(811, 11, 'Ketakumbura', NULL, NULL, NULL, NULL, NULL, '20306', 7.210532, 80.571678),
(812, 11, 'Kobonila', NULL, NULL, NULL, NULL, NULL, '20928', 7.376, 80.8213),
(813, 11, 'Kolabissa', NULL, NULL, NULL, NULL, NULL, '20212', 7.225, 80.7167),
(814, 11, 'Kolongoda', NULL, NULL, NULL, NULL, NULL, '20971', 7.3552, 80.8375),
(815, 11, 'Kulugammana', NULL, NULL, NULL, NULL, NULL, '20048', 7.315193, 80.590268),
(816, 11, 'Kumbukkandura', NULL, NULL, NULL, NULL, NULL, '20902', 7.2969, 80.7686),
(817, 11, 'Kumburegama', NULL, NULL, NULL, NULL, NULL, '20086', 7.357279, 80.551316),
(818, 11, 'Kundasale', NULL, NULL, NULL, NULL, NULL, '20168', 7.2667, 80.6833),
(819, 11, 'Leemagahakotuwa', NULL, NULL, NULL, NULL, NULL, '20482', 7.2333, 80.5833),
(820, 11, 'lhala Kobbekaduwa', NULL, NULL, NULL, NULL, NULL, '20042', 7.3167, 80.5833),
(821, 11, 'Lunugama', NULL, NULL, NULL, NULL, NULL, '11062', 7.198402, 80.578244),
(822, 11, 'Lunuketiya Maditta', NULL, NULL, NULL, NULL, NULL, '20172', 7.3292, 80.716),
(823, 11, 'Madawala Bazaar', NULL, NULL, NULL, NULL, NULL, '20260', 7.2696, 80.6537),
(824, 11, 'Madawalalanda', NULL, NULL, NULL, NULL, NULL, '32016', 7.3792, 80.4982),
(825, 11, 'Madugalla', NULL, NULL, NULL, NULL, NULL, '20938', 7.265802, 80.882139),
(826, 11, 'Madulkele', NULL, NULL, NULL, NULL, NULL, '20840', 7.400281, 80.728874),
(827, 11, 'Mahadoraliyadda', NULL, NULL, NULL, NULL, NULL, '20945', 7.3, 80.85),
(828, 11, 'Mahamedagama', NULL, NULL, NULL, NULL, NULL, '20216', 7.225, 80.7167),
(829, 11, 'Mahanagapura', NULL, NULL, NULL, NULL, NULL, '32018', 7.3792, 80.4982),
(830, 11, 'Mailapitiya', NULL, NULL, NULL, NULL, NULL, '20702', 7.1517, 80.7118),
(831, 11, 'Makkanigama', NULL, NULL, NULL, NULL, NULL, '20828', 7.3833, 80.6333),
(832, 11, 'Makuldeniya', NULL, NULL, NULL, NULL, NULL, '20921', 7.341706, 80.777466),
(833, 11, 'Mangalagama', NULL, NULL, NULL, NULL, NULL, '32069', 7.285856, 80.563656),
(834, 11, 'Mapakanda', NULL, NULL, NULL, NULL, NULL, '20662', 7.007889, 80.531101),
(835, 11, 'Marassana', NULL, NULL, NULL, NULL, NULL, '20210', 7.221663, 80.732336),
(836, 11, 'Marymount Colony', NULL, NULL, NULL, NULL, NULL, '20714', 7.1517, 80.7118),
(837, 11, 'Mawatura', NULL, NULL, NULL, NULL, NULL, '20564', 7.1, 80.5667),
(838, 11, 'Medamahanuwara', NULL, NULL, NULL, NULL, NULL, '20940', 7.3, 80.85),
(839, 11, 'Medawala Harispattuwa', NULL, NULL, NULL, NULL, NULL, '20120', 7.3417, 80.6833),
(840, 11, 'Meetalawa', NULL, NULL, NULL, NULL, NULL, '20512', 7.0986, 80.4699),
(841, 11, 'Megoda Kalugamuwa', NULL, NULL, NULL, NULL, NULL, '20409', 7.2631, 80.6028),
(842, 11, 'Menikdiwela', NULL, NULL, NULL, NULL, NULL, '20470', 7.288455, 80.501662),
(843, 11, 'Menikhinna', NULL, NULL, NULL, NULL, NULL, '20170', 7.3167, 80.7),
(844, 11, 'Mimure', NULL, NULL, NULL, NULL, NULL, '20923', 7.4333, 80.8333),
(845, 11, 'Minigamuwa', NULL, NULL, NULL, NULL, NULL, '20109', 7.3333, 80.5167),
(846, 11, 'Minipe', NULL, NULL, NULL, NULL, NULL, '20983', 7.223556, 80.990971),
(847, 11, 'Moragahapallama', NULL, NULL, NULL, NULL, NULL, '32012', 7.3792, 80.4982),
(848, 11, 'Murutalawa', NULL, NULL, NULL, NULL, NULL, '20232', 7.3, 80.5667),
(849, 11, 'Muruthagahamulla', NULL, NULL, NULL, NULL, NULL, '20526', 7.1364, 80.5766),
(850, 11, 'Nanuoya', NULL, NULL, NULL, NULL, NULL, '22150', 7.1171, 80.6387),
(851, 11, 'Naranpanawa', NULL, NULL, NULL, NULL, NULL, '20176', 7.339733, 80.729831),
(852, 11, 'Narawelpita', NULL, NULL, NULL, NULL, NULL, '81302', 7.3167, 80.8),
(853, 11, 'Nawalapitiya', NULL, NULL, NULL, NULL, NULL, '20650', 7.05048, 80.530631),
(854, 11, 'Nawathispane', NULL, NULL, NULL, NULL, NULL, '20670', 7.0333, 80.5),
(855, 11, 'Nillambe', NULL, NULL, NULL, NULL, NULL, '20418', 7.15, 80.6333),
(856, 11, 'Nugaliyadda', NULL, NULL, NULL, NULL, NULL, '20204', 7.2333, 80.7),
(857, 11, 'Ovilikanda', NULL, NULL, NULL, NULL, NULL, '21020', 7.45, 80.5667),
(858, 11, 'Pallekotuwa', NULL, NULL, NULL, NULL, NULL, '20084', 7.3333, 80.5667),
(859, 11, 'Panwilatenna', NULL, NULL, NULL, NULL, NULL, '20544', 7.1556, 80.6314),
(860, 11, 'Paradeka', NULL, NULL, NULL, NULL, NULL, '20578', 7.12293, 80.618959),
(861, 11, 'Pasbage', NULL, NULL, NULL, NULL, NULL, '20654', 7.0358, 80.5262),
(862, 11, 'Pattitalawa', NULL, NULL, NULL, NULL, NULL, '20511', 7.1167, 80.4667),
(863, 11, 'Peradeniya', NULL, NULL, NULL, NULL, NULL, '20400', 7.2631, 80.6028),
(864, 11, 'Pilimatalawa', NULL, NULL, NULL, NULL, NULL, '20450', 7.2333, 80.5333),
(865, 11, 'Poholiyadda', NULL, NULL, NULL, NULL, NULL, '20106', 7.343274, 80.520186),
(866, 11, 'Pubbiliya', NULL, NULL, NULL, NULL, NULL, '21502', 7.385927, 80.481336),
(867, 11, 'Pupuressa', NULL, NULL, NULL, NULL, NULL, '20546', 7.115632, 80.677455),
(868, 11, 'Pussellawa', NULL, NULL, NULL, NULL, NULL, '20580', 7.112565, 80.644101),
(869, 11, 'Putuhapuwa', NULL, NULL, NULL, NULL, NULL, '20906', 7.334198, 80.759353),
(870, 11, 'Rajawella', NULL, NULL, NULL, NULL, NULL, '20180', 7.280519, 80.748217),
(871, 11, 'Rambukpitiya', NULL, NULL, NULL, NULL, NULL, '20676', 7.0333, 80.5),
(872, 11, 'Rambukwella', NULL, NULL, NULL, NULL, NULL, '20128', 7.294759, 80.777664),
(873, 11, 'Rangala', NULL, NULL, NULL, NULL, NULL, '20922', 7.344486, 80.795047),
(874, 11, 'Rantembe', NULL, NULL, NULL, NULL, NULL, '20990', 7.3552, 80.8375),
(875, 11, 'Sangarajapura', NULL, NULL, NULL, NULL, NULL, '20044', 7.3167, 80.5833),
(876, 11, 'Senarathwela', NULL, NULL, NULL, NULL, NULL, '20904', 7.280125, 80.761602),
(877, 11, 'Talatuoya', NULL, NULL, NULL, NULL, NULL, '20200', 7.2536, 80.6925),
(878, 11, 'Teldeniya', NULL, NULL, NULL, NULL, NULL, '20900', 7.2969, 80.7686),
(879, 11, 'Tennekumbura', NULL, NULL, NULL, NULL, NULL, '20166', 7.2833, 80.6667),
(880, 11, 'Uda Peradeniya', NULL, NULL, NULL, NULL, NULL, '20404', 7.249001, 80.614072),
(881, 11, 'Udahentenna', NULL, NULL, NULL, NULL, NULL, '20506', 7.0889, 80.5189),
(882, 11, 'Udatalawinna', NULL, NULL, NULL, NULL, NULL, '20802', 7.3161, 80.6211),
(883, 11, 'Udispattuwa', NULL, NULL, NULL, NULL, NULL, '20916', 7.3552, 80.8375),
(884, 11, 'Ududumbara', NULL, NULL, NULL, NULL, NULL, '20950', 7.3552, 80.8375),
(885, 11, 'Uduwahinna', NULL, NULL, NULL, NULL, NULL, '20934', 7.2833, 80.8917),
(886, 11, 'Uduwela', NULL, NULL, NULL, NULL, NULL, '20164', 7.2722, 80.6667),
(887, 11, 'Ulapane', NULL, NULL, NULL, NULL, NULL, '20562', 7.114072, 80.552445),
(888, 11, 'Unuwinna', NULL, NULL, NULL, NULL, NULL, '20708', 7.1517, 80.7118),
(889, 11, 'Velamboda', NULL, NULL, NULL, NULL, NULL, '20640', 7.0523, 80.5023),
(890, 11, 'Watagoda', NULL, NULL, NULL, NULL, NULL, '22110', 7.39731, 80.588304),
(891, 11, 'Watagoda Harispattuwa', NULL, NULL, NULL, NULL, NULL, '20134', 7.3569, 80.6012),
(892, 11, 'Wattappola', NULL, NULL, NULL, NULL, NULL, '20454', 7.234802, 80.543661),
(893, 11, 'Weligampola', NULL, NULL, NULL, NULL, NULL, '20666', 7.0271, 80.5493),
(894, 11, 'Wendaruwa', NULL, NULL, NULL, NULL, NULL, '20914', 7.3552, 80.8375),
(895, 11, 'Weragantota', NULL, NULL, NULL, NULL, NULL, '20982', 7.3167, 80.9833),
(896, 11, 'Werapitya', NULL, NULL, NULL, NULL, NULL, '20908', 7.2969, 80.7686),
(897, 11, 'Werellagama', NULL, NULL, NULL, NULL, NULL, '20080', 7.3167, 80.5833),
(898, 11, 'Wettawa', NULL, NULL, NULL, NULL, NULL, '20108', 7.3508, 80.5221),
(899, 11, 'Yahalatenna', NULL, NULL, NULL, NULL, NULL, '20234', 7.3, 80.5667),
(900, 11, 'Yatihalagala', NULL, NULL, NULL, NULL, NULL, '20034', 7.3, 80.6),
(901, 12, 'Alawala', 'අලවල', NULL, NULL, NULL, NULL, '11122', 7.197379, 80.282779),
(902, 12, 'Alawatura', 'අලවතුර', NULL, NULL, NULL, NULL, '71204', 7.1333, 80.3333),
(903, 12, 'Alawwa', 'අලව්ව', NULL, NULL, NULL, NULL, '60280', 7.2875, 80.2536),
(904, 12, 'Algama', 'අල්ගම', NULL, NULL, NULL, NULL, '71607', 7.158338, 80.162939),
(905, 12, 'Alutnuwara', 'අළුත්නුවර', NULL, NULL, NULL, NULL, '71508', 7.2333, 80.4667),
(906, 12, 'Ambalakanda', 'අම්බලකන්ද', NULL, NULL, NULL, NULL, '71546', 7.134049, 80.446804),
(907, 12, 'Ambulugala', 'අම්බුළුගල', NULL, NULL, NULL, NULL, '71503', 7.239127, 80.409623),
(908, 12, 'Amitirigala', 'අමිතිරිගල', NULL, NULL, NULL, NULL, '71320', 7.0306, 80.1839),
(909, 12, 'Ampagala', 'අම්පාගල', NULL, NULL, NULL, NULL, '71232', 7.080239, 80.289037),
(910, 12, 'Anhandiya', 'අංහන්දිය', NULL, NULL, NULL, NULL, '60074', 7.2667, 80.2667),
(911, 12, 'Anhettigama', 'අංහෙට්ටිගම', NULL, NULL, NULL, NULL, '71403', 6.922121, 80.371876),
(912, 12, 'Aranayaka', 'අරනායක', NULL, NULL, NULL, NULL, '71540', 7.144705, 80.461358),
(913, 12, 'Aruggammana', 'අරුග්ගම්මන', NULL, NULL, NULL, NULL, '71041', 7.117733, 80.306712),
(914, 12, 'Batuwita', 'බටුවිට', NULL, NULL, NULL, NULL, '71321', 7.044339, 80.179129),
(915, 12, 'Beligala(Sab)', 'බෙලිගල', NULL, NULL, NULL, NULL, '71044', 7.2167, 80.2917),
(916, 12, 'Belihuloya', 'බෙලිහුල්ඔය', NULL, NULL, NULL, NULL, '70140', 7.2667, 80.2167),
(917, 12, 'Berannawa', 'බෙරන්නව', NULL, NULL, NULL, NULL, '71706', 7.064482, 80.405526),
(918, 12, 'Bopitiya', 'බෝපිටිය', NULL, NULL, NULL, NULL, '60155', 7.179761, 80.205221),
(919, 12, 'Bopitiya (SAB)', 'බෝපිටිය (සබර)', NULL, NULL, NULL, NULL, '71612', 7.2583, 80.2167),
(920, 12, 'Boralankada', 'බොරලන්කද', NULL, NULL, NULL, NULL, '71418', 6.979656, 80.330338),
(921, 12, 'Bossella', 'බොස්සැල්ල', NULL, NULL, NULL, NULL, '71208', 7.1333, 80.4),
(922, 12, 'Bulathkohupitiya', 'බුලත්කොහුපිටිය', NULL, NULL, NULL, NULL, '71230', 7.105994, 80.338761),
(923, 12, 'Damunupola', 'දමුනුපොල', NULL, NULL, NULL, NULL, '71034', 7.187968, 80.334456),
(924, 12, 'Debathgama', 'දෙබත්ගම', NULL, NULL, NULL, NULL, '71037', 7.1833, 80.3583),
(925, 12, 'Dedugala', 'දේදුගල', NULL, NULL, NULL, NULL, '71237', 7.093849, 80.418959),
(926, 12, 'Deewala Pallegama', 'දීවල පල්ලෙගම', NULL, NULL, NULL, NULL, '71022', 7.2333, 80.2667),
(927, 12, 'Dehiowita', 'දෙහිඕවිට', NULL, NULL, NULL, NULL, '71400', 6.9706, 80.2675),
(928, 12, 'Deldeniya', 'දෙල්දෙණිය', NULL, NULL, NULL, NULL, '71009', 7.280914, 80.35876),
(929, 12, 'Deloluwa', 'දෙලෝලුව', NULL, NULL, NULL, NULL, '71401', 6.9653, 80.3181),
(930, 12, 'Deraniyagala', 'දැරණියගල', NULL, NULL, NULL, NULL, '71430', 6.932387, 80.335039),
(931, 12, 'Dewalegama', 'දේවාලේගම', NULL, NULL, NULL, NULL, '71050', 7.278928, 80.319135),
(932, 12, 'Dewanagala', 'දෙවනගල', NULL, NULL, NULL, NULL, '71527', 7.2167, 80.4667),
(933, 12, 'Dombemada', 'දොඹේමද', NULL, NULL, NULL, NULL, '71115', 7.37974, 80.348761),
(934, 12, 'Dorawaka', 'දොරවක', NULL, NULL, NULL, NULL, '71601', 7.1833, 80.2167),
(935, 12, 'Dunumala', 'දුනුමල', NULL, NULL, NULL, NULL, '71605', 7.1738, 80.2074),
(936, 12, 'Galapitamada', 'ගලපිටමඩ', NULL, NULL, NULL, NULL, '71603', 7.14, 80.2364),
(937, 12, 'Galatara', 'ගලතර', NULL, NULL, NULL, NULL, '71505', 7.2167, 80.4167),
(938, 12, 'Galigamuwa Town', 'ගලිගමුව නගරය', NULL, NULL, NULL, NULL, '71350', 7.2, 80.3),
(939, 12, 'Gallella', 'ගල්ලෑල්ල', NULL, NULL, NULL, NULL, '70062', 6.85, 80.35),
(940, 12, 'Galpatha(Sab)', 'ගල්පාත (සබරගමුව)', NULL, NULL, NULL, NULL, '71312', 7.05, 80.2333),
(941, 12, 'Gantuna', 'ගන්තුන', NULL, NULL, NULL, NULL, '71222', 7.1667, 80.3667),
(942, 12, 'Getahetta', 'ගැටහැත්ත', NULL, NULL, NULL, NULL, '70620', 6.9128, 80.2358),
(943, 12, 'Godagampola', 'ගොඩගම්පොල', NULL, NULL, NULL, NULL, '70556', 6.885959, 80.313855),
(944, 12, 'Gonagala', 'ගෝනාගල', NULL, NULL, NULL, NULL, '71318', 7.035326, 80.207373),
(945, 12, 'Hakahinna', 'හකහින්න', NULL, NULL, NULL, NULL, '71352', 7.2, 80.3),
(946, 12, 'Hakbellawaka', 'හක්බෙල්ලවක', NULL, NULL, NULL, NULL, '71715', 7.003952, 80.328796),
(947, 12, 'Halloluwa', 'හල්ලෝලුව', NULL, NULL, NULL, NULL, '20032', 7.2, 80.35),
(948, 12, 'Hedunuwewa', NULL, NULL, NULL, NULL, NULL, '22024', 6.9306, 80.2747),
(949, 12, 'Hemmatagama', NULL, NULL, NULL, NULL, NULL, '71530', 7.1667, 80.5),
(950, 12, 'Hewadiwela', NULL, NULL, NULL, NULL, NULL, '71108', 7.372493, 80.377574),
(951, 12, 'Hingula', NULL, NULL, NULL, NULL, NULL, '71520', 7.247803, 80.469032),
(952, 12, 'Hinguralakanda', NULL, NULL, NULL, NULL, NULL, '71417', 6.91506, 80.304394),
(953, 12, 'Hingurana', NULL, NULL, NULL, NULL, NULL, '32010', 6.9167, 80.4167),
(954, 12, 'Hiriwadunna', NULL, NULL, NULL, NULL, NULL, '71014', 7.2833, 80.3833),
(955, 12, 'Ihala Walpola', NULL, NULL, NULL, NULL, NULL, '80134', 7.350958, 80.397324),
(956, 12, 'Ihalagama', NULL, NULL, NULL, NULL, NULL, '70144', 7.2667, 80.3333),
(957, 12, 'Imbulana', NULL, NULL, NULL, NULL, NULL, '71313', 7.08264, 80.245565),
(958, 12, 'Imbulgasdeniya', NULL, NULL, NULL, NULL, NULL, '71055', 7.2853, 80.3186),
(959, 12, 'Kabagamuwa', NULL, NULL, NULL, NULL, NULL, '71202', 7.136698, 80.341558),
(960, 12, 'Kahapathwala', NULL, NULL, NULL, NULL, NULL, '60062', 7.3, 80.4583),
(961, 12, 'Kandaketya', NULL, NULL, NULL, NULL, NULL, '90020', 7.2333, 80.4667),
(962, 12, 'Kannattota', NULL, NULL, NULL, NULL, NULL, '71372', 7.081348, 80.275311),
(963, 12, 'Karagahinna', NULL, NULL, NULL, NULL, NULL, '21014', 7.3604, 80.3832),
(964, 12, 'Kegalle', NULL, NULL, NULL, NULL, NULL, '71000', 7.249349, 80.351662),
(965, 12, 'Kehelpannala', NULL, NULL, NULL, NULL, NULL, '71533', 7.161131, 80.519539),
(966, 12, 'Ketawala Leula', NULL, NULL, NULL, NULL, NULL, '20198', 7.1167, 80.35),
(967, 12, 'Kitulgala', NULL, NULL, NULL, NULL, NULL, '71720', 6.9944, 80.4114),
(968, 12, 'Kondeniya', NULL, NULL, NULL, NULL, NULL, '71501', 7.2667, 80.4333),
(969, 12, 'Kotiyakumbura', NULL, NULL, NULL, NULL, NULL, '71370', 7.0833, 80.2667),
(970, 12, 'Lewangama', NULL, NULL, NULL, NULL, NULL, '71315', 7.112902, 80.239),
(971, 12, 'Mahabage', NULL, NULL, NULL, NULL, NULL, '71722', 7.019803, 80.450227),
(972, 12, 'Makehelwala', NULL, NULL, NULL, NULL, NULL, '71507', 7.282441, 80.47528),
(973, 12, 'Malalpola', NULL, NULL, NULL, NULL, NULL, '71704', 7.053091, 80.351009),
(974, 12, 'Maldeniya', NULL, NULL, NULL, NULL, NULL, '22021', 6.9306, 80.2747),
(975, 12, 'Maliboda', NULL, NULL, NULL, NULL, NULL, '71411', 6.887528, 80.464212),
(976, 12, 'Maliyadda', NULL, NULL, NULL, NULL, NULL, '90022', 7.2333, 80.4667),
(977, 12, 'Malmaduwa', NULL, NULL, NULL, NULL, NULL, '71325', 7.15, 80.2833),
(978, 12, 'Marapana', NULL, NULL, NULL, NULL, NULL, '70041', 7.2333, 80.35),
(979, 12, 'Mawanella', NULL, NULL, NULL, NULL, NULL, '71500', 7.244446, 80.439045),
(980, 12, 'Meetanwala', NULL, NULL, NULL, NULL, NULL, '60066', 7.3, 80.4583),
(981, 12, 'Migastenna Sabara', NULL, NULL, NULL, NULL, NULL, '71716', 7.0333, 80.3333),
(982, 12, 'Miyanawita', NULL, NULL, NULL, NULL, NULL, '71432', 6.900423, 80.351075),
(983, 12, 'Molagoda', NULL, NULL, NULL, NULL, NULL, '71016', 7.25, 80.3833),
(984, 12, 'Morontota', NULL, NULL, NULL, NULL, NULL, '71220', 7.1667, 80.3667),
(985, 12, 'Narangala', NULL, NULL, NULL, NULL, NULL, '90064', 7.07922, 80.360764),
(986, 12, 'Narangoda', NULL, NULL, NULL, NULL, NULL, '60152', 7.198165, 80.294552),
(987, 12, 'Nattarampotha', NULL, NULL, NULL, NULL, NULL, '20194', 7.1167, 80.35),
(988, 12, 'Nelundeniya', NULL, NULL, NULL, NULL, NULL, '71060', 7.2319, 80.2669),
(989, 12, 'Niyadurupola', NULL, NULL, NULL, NULL, NULL, '71602', 7.1667, 80.2167),
(990, 12, 'Noori', NULL, NULL, NULL, NULL, NULL, '71407', 6.9508, 80.3174),
(991, 12, 'Pannila', NULL, NULL, NULL, NULL, NULL, '12114', 6.866357, 80.320996),
(992, 12, 'Pattampitiya', NULL, NULL, NULL, NULL, NULL, '71130', 7.315516, 80.434412),
(993, 12, 'Pilawala', NULL, NULL, NULL, NULL, NULL, '20196', 7.1167, 80.35),
(994, 12, 'Pothukoladeniya', NULL, NULL, NULL, NULL, NULL, '71039', 7.1833, 80.3583),
(995, 12, 'Puswelitenna', NULL, NULL, NULL, NULL, NULL, '60072', 7.3667, 80.3667),
(996, 12, 'Rambukkana', NULL, NULL, NULL, NULL, NULL, '71100', 7.323016, 80.391856),
(997, 12, 'Rilpola', NULL, NULL, NULL, NULL, NULL, '90026', 7.2333, 80.4667),
(998, 12, 'Rukmale', NULL, NULL, NULL, NULL, NULL, '11129', 7.2, 80.4833),
(999, 12, 'Ruwanwella', NULL, NULL, NULL, NULL, NULL, '71300', 7.048852, 80.2561),
(1000, 12, 'Samanalawewa', NULL, NULL, NULL, NULL, NULL, '70142', 7.2667, 80.2167),
(1001, 12, 'Seaforth Colony', NULL, NULL, NULL, NULL, NULL, '71708', 7.0469, 80.3502),
(1002, 5, 'Colombo 2', 'කොළඹ 2', 'கொழும்பு 2', 'Slave Island', 'කොම්පඤ්ඤ වීදිය', 'கொம்பனித்தெரு', '200', 6.926944, 79.848611),
(1003, 12, 'Spring Valley', NULL, NULL, NULL, NULL, NULL, '90028', 7.2333, 80.4667),
(1004, 12, 'Talgaspitiya', NULL, NULL, NULL, NULL, NULL, '71541', 7.1667, 80.4833),
(1005, 12, 'Teligama', NULL, NULL, NULL, NULL, NULL, '71724', 7.0033, 80.3647),
(1006, 12, 'Tholangamuwa', NULL, NULL, NULL, NULL, NULL, '71619', 7.233983, 80.225956),
(1007, 12, 'Thotawella', NULL, NULL, NULL, NULL, NULL, '71106', 7.3555, 80.3969),
(1008, 12, 'Udaha Hawupe', NULL, NULL, NULL, NULL, NULL, '70154', 7.05, 80.2833),
(1009, 12, 'Udapotha', NULL, NULL, NULL, NULL, NULL, '71236', 7.09414, 80.377416),
(1010, 12, 'Uduwa', NULL, NULL, NULL, NULL, NULL, '20052', 7.110957, 80.387557),
(1011, 12, 'Undugoda', NULL, NULL, NULL, NULL, NULL, '71200', 7.141866, 80.365332),
(1012, 12, 'Ussapitiya', NULL, NULL, NULL, NULL, NULL, '71510', 7.216957, 80.444573),
(1013, 12, 'Wahakula', NULL, NULL, NULL, NULL, NULL, '71303', 7.058236, 80.207402),
(1014, 12, 'Waharaka', NULL, NULL, NULL, NULL, NULL, '71304', 7.088513, 80.198619),
(1015, 12, 'Wanaluwewa', NULL, NULL, NULL, NULL, NULL, '11068', 7.0667, 80.175),
(1016, 12, 'Warakapola', NULL, NULL, NULL, NULL, NULL, '71600', 7.230053, 80.196768),
(1017, 12, 'Watura', NULL, NULL, NULL, NULL, NULL, '71035', 7.1833, 80.3833),
(1018, 12, 'Weeoya', NULL, NULL, NULL, NULL, NULL, '71702', 7.0469, 80.3502),
(1019, 12, 'Wegalla', NULL, NULL, NULL, NULL, NULL, '71234', 7.099631, 80.30654),
(1020, 12, 'Weligalla', NULL, NULL, NULL, NULL, NULL, '20610', 7.1833, 80.2),
(1021, 12, 'Welihelatenna', NULL, NULL, NULL, NULL, NULL, '71712', 7.0333, 80.3333),
(1022, 12, 'Wewelwatta', NULL, NULL, NULL, NULL, NULL, '70066', 6.85, 80.35),
(1023, 12, 'Yatagama', NULL, NULL, NULL, NULL, NULL, '71116', 7.32512, 80.356415),
(1024, 12, 'Yatapana', NULL, NULL, NULL, NULL, NULL, '71326', 7.1333, 80.3),
(1025, 12, 'Yatiyantota', NULL, NULL, NULL, NULL, NULL, '71700', 7.0242, 80.3006),
(1026, 12, 'Yattogoda', NULL, NULL, NULL, NULL, NULL, '71029', 7.2333, 80.2667),
(1027, 13, 'Kandavalai', NULL, NULL, NULL, NULL, NULL, '', 9.4515585, 80.5008173),
(1028, 13, 'Karachchi', NULL, NULL, NULL, NULL, NULL, '', 9.3769363, 80.3766044),
(1029, 13, 'Kilinochchi', NULL, NULL, NULL, NULL, NULL, '', 9.416667, 80.416667),
(1030, 13, 'Pachchilaipalli', NULL, NULL, NULL, NULL, NULL, '', 9.6115808, 80.3273106),
(1031, 13, 'Poonakary', NULL, NULL, NULL, NULL, NULL, '', 9.5035013, 80.2111173),
(1032, 14, 'Akurana', 'අකුරණ', NULL, NULL, NULL, NULL, '20850', 7.637034, 80.023362),
(1033, 14, 'Alahengama', 'අලහෙන්ගම', NULL, NULL, NULL, NULL, '60416', 7.6779, 80.1151),
(1034, 14, 'Alahitiyawa', 'අලහිටියාව', NULL, NULL, NULL, NULL, '60182', 7.473913, 80.171211),
(1035, 14, 'Ambakote', 'අඹකොටේ', NULL, NULL, NULL, NULL, '60036', 7.492063, 80.452844),
(1036, 14, 'Ambanpola', 'අඹන්පොල', NULL, NULL, NULL, NULL, '60650', 7.915973, 80.237512),
(1037, 14, 'Andiyagala', 'ආඬියාගල', NULL, NULL, NULL, NULL, '50112', 7.4667, 80.1333),
(1038, 14, 'Anukkane', 'අනුක්කනේ', NULL, NULL, NULL, NULL, '60214', 7.501814, 80.120028),
(1039, 14, 'Aragoda', 'අරංගොඩ', NULL, NULL, NULL, NULL, '60308', 7.366116, 80.344207),
(1040, 14, 'Ataragalla', 'අටරගල්ල', NULL, NULL, NULL, NULL, '60706', 7.9696, 80.2768),
(1041, 14, 'Awulegama', 'අවුලේගම', NULL, NULL, NULL, NULL, '60462', 7.6569, 80.2203),
(1042, 14, 'Balalla', 'බලල්ල', NULL, NULL, NULL, NULL, '60604', 7.791025, 80.250762),
(1043, 14, 'Bamunukotuwa', 'බමුණකොටුව', NULL, NULL, NULL, NULL, '60347', 7.8667, 80.2167),
(1044, 14, 'Bandara Koswatta', 'බන්ඩාර කොස්වත්ත', NULL, NULL, NULL, NULL, '60424', 7.603296, 80.17257),
(1045, 14, 'Bingiriya', 'බින්ගිරිය', NULL, NULL, NULL, NULL, '60450', 7.605177, 79.921996),
(1046, 14, 'Bogamulla', 'බෝගමුල්ල', NULL, NULL, NULL, NULL, '60107', 7.4589, 80.2107),
(1047, 14, 'Boraluwewa', 'බොරළුවැව', NULL, NULL, NULL, NULL, '60437', 7.682578, 80.034757),
(1048, 14, 'Boyagane', 'බෝයගානෙ', NULL, NULL, NULL, NULL, '60027', 7.452272, 80.341672),
(1049, 14, 'Bujjomuwa', 'බුජ්ජෝමුව', NULL, NULL, NULL, NULL, '60291', 7.4581, 80.0603),
(1050, 14, 'Buluwala', 'බුලුවල', NULL, NULL, NULL, NULL, '60076', 7.484201, 80.473535),
(1051, 14, 'Dadayamtalawa', 'දඩයම්තලාව', NULL, NULL, NULL, NULL, '32046', 7.65, 79.9667),
(1052, 14, 'Dambadeniya', 'දඹදෙණිය', NULL, NULL, NULL, NULL, '60130', 7.370527, 80.146193),
(1053, 14, 'Daraluwa', 'දරලුව', NULL, NULL, NULL, NULL, '60174', 7.359407, 79.978233),
(1054, 14, 'Deegalla', 'දීගල්ල', NULL, NULL, NULL, NULL, '60228', 7.510205, 80.029797),
(1055, 14, 'Demataluwa', 'දෙමටලුව', NULL, NULL, NULL, NULL, '60024', 7.513976, 80.258741),
(1056, 14, 'Demuwatha', 'දෙමුවත', NULL, NULL, NULL, NULL, '70332', 7.35, 80.1667),
(1057, 14, 'Diddeniya', 'දෙණියාය', NULL, NULL, NULL, NULL, '60544', 7.685279, 80.47286),
(1058, 14, 'Digannewa', 'දිගන්නෑව', NULL, NULL, NULL, NULL, '60485', 7.897218, 80.101328),
(1059, 14, 'Divullegoda', 'දිවුලේගොඩ', NULL, NULL, NULL, NULL, '60472', 7.75, 80.2),
(1060, 14, 'Diyasenpura', 'දියසෙන්පුර', NULL, NULL, NULL, NULL, '51504', 7.8167, 80.1833),
(1061, 14, 'Dodangaslanda', 'දොඩන්ගස්ලන්ද', NULL, NULL, NULL, NULL, '60530', 7.5667, 80.5333),
(1062, 14, 'Doluwa', 'දොළුව', NULL, NULL, NULL, NULL, '20532', 7.621516, 80.418833),
(1063, 14, 'Doragamuwa', 'දොරගමුව', NULL, NULL, NULL, NULL, '20816', 7.5833, 79.9333),
(1064, 14, 'Doratiyawa', 'දොරටියාව', NULL, NULL, NULL, NULL, '60013', 7.450628, 80.380562),
(1065, 14, 'Dunumadalawa', 'දුනුමඩවල', NULL, NULL, NULL, NULL, '50214', 7.8, 80.0833),
(1066, 14, 'Dunuwilapitiya', 'දුනුවිලපිටිය', NULL, NULL, NULL, NULL, '21538', 7.3667, 80.2),
(1067, 14, 'Ehetuwewa', 'ඇහැටුවැව', NULL, NULL, NULL, NULL, '60716', 7.927568, 80.332035),
(1068, 14, 'Elibichchiya', 'ඇලිබිච්චිය', NULL, NULL, NULL, NULL, '60156', 7.313179, 80.056935),
(1069, 14, 'Embogama', NULL, NULL, NULL, NULL, NULL, '60718', 7.9214, 80.3608),
(1070, 14, 'Etungahakotuwa', 'ඇතුන්ගහකොටුව', NULL, NULL, NULL, NULL, '60266', 7.5167, 79.9667),
(1071, 14, 'Galadivulwewa', 'ගලදිවුල්වැව', NULL, NULL, NULL, NULL, '50210', 7.8, 80.0833),
(1072, 14, 'Galgamuwa', 'ගල්ගමුව', NULL, NULL, NULL, NULL, '60700', 7.995468, 80.267527),
(1073, 14, 'Gallellagama', 'ගල්ලෑල්ලගම', NULL, NULL, NULL, NULL, '20095', 7.3, 80.15),
(1074, 14, 'Gallewa', NULL, NULL, NULL, NULL, NULL, '60712', 7.9667, 80.3333),
(1075, 14, 'Ganegoda', 'ගණේගොඩ', NULL, NULL, NULL, NULL, '80440', 7.5833, 80),
(1076, 14, 'Girathalana', 'ගිරාතලන', NULL, NULL, NULL, NULL, '60752', 7.9833, 80.3833),
(1077, 14, 'Gokaralla', 'ගොකරුල්ල', NULL, NULL, NULL, NULL, '60522', 7.6301, 80.3775),
(1078, 14, 'Gonawila', 'ගොනාවිල', NULL, NULL, NULL, NULL, '60170', 7.3167, 80),
(1079, 14, 'Halmillawewa', 'හල්මිල්ලවැව', NULL, NULL, NULL, NULL, '60441', 7.5953, 79.9972),
(1080, 14, 'Handungamuwa', NULL, NULL, NULL, NULL, NULL, '21536', 7.3667, 80.2),
(1081, 14, 'Harankahawa', NULL, NULL, NULL, NULL, NULL, '20092', 7.3, 80.15),
(1082, 14, 'Helamada', NULL, NULL, NULL, NULL, NULL, '71046', 7.3167, 80.2833),
(1083, 14, 'Hengamuwa', NULL, NULL, NULL, NULL, NULL, '60414', 7.703282, 80.111254),
(1084, 14, 'Hettipola', NULL, NULL, NULL, NULL, NULL, '60430', 7.605372, 80.083137),
(1085, 14, 'Hewainna', NULL, NULL, NULL, NULL, NULL, '10714', 7.3333, 80.2167),
(1086, 14, 'Hilogama', NULL, NULL, NULL, NULL, NULL, '60486', 7.75, 80.0833),
(1087, 14, 'Hindagolla', NULL, NULL, NULL, NULL, NULL, '60034', 7.4833, 80.4167),
(1088, 14, 'Hiriyala Lenawa', NULL, NULL, NULL, NULL, NULL, '60546', 7.6709, 80.4751),
(1089, 14, 'Hiruwalpola', NULL, NULL, NULL, NULL, NULL, '60458', 7.553915, 79.924699),
(1090, 14, 'Horambawa', NULL, NULL, NULL, NULL, NULL, '60181', 7.45, 80.1833),
(1091, 14, 'Hulogedara', NULL, NULL, NULL, NULL, NULL, '60474', 7.7833, 80.1833),
(1092, 14, 'Hulugalla', NULL, NULL, NULL, NULL, NULL, '60477', 7.79059, 80.140007),
(1093, 14, 'Ihala Gomugomuwa', NULL, NULL, NULL, NULL, NULL, '60211', 7.5167, 80.0833),
(1094, 14, 'Ihala Katugampala', NULL, NULL, NULL, NULL, NULL, '60135', 7.3672, 80.1467),
(1095, 14, 'Indulgodakanda', NULL, NULL, NULL, NULL, NULL, '60016', 7.422625, 80.402808),
(1096, 14, 'Ithanawatta', NULL, NULL, NULL, NULL, NULL, '60025', 7.4458, 80.3458),
(1097, 14, 'Kadigawa', NULL, NULL, NULL, NULL, NULL, '60492', 7.7167, 80),
(1098, 14, 'Kalankuttiya', NULL, NULL, NULL, NULL, NULL, '50174', 8.05, 80.3833),
(1099, 14, 'Kalatuwawa', NULL, NULL, NULL, NULL, NULL, '10718', 7.6333, 80.3667),
(1100, 14, 'Kalugamuwa', NULL, NULL, NULL, NULL, NULL, '60096', 7.449717, 80.256696),
(1101, 14, 'Kanadeniyawala', NULL, NULL, NULL, NULL, NULL, '60054', 7.43824, 80.535658),
(1102, 14, 'Kanattewewa', NULL, NULL, NULL, NULL, NULL, '60422', 7.6167, 80.2),
(1103, 14, 'Kandegedara', NULL, NULL, NULL, NULL, NULL, '90070', 7.424611, 80.071498),
(1104, 14, 'Karagahagedara', NULL, NULL, NULL, NULL, NULL, '60106', 7.475787, 80.209967),
(1105, 14, 'Karambe', NULL, NULL, NULL, NULL, NULL, '60602', 7.805937, 80.339167),
(1106, 14, 'Katiyawa', NULL, NULL, NULL, NULL, NULL, '50261', 7.624637, 80.553944),
(1107, 14, 'Katupota', NULL, NULL, NULL, NULL, NULL, '60350', 7.5331, 80.1897),
(1108, 14, 'Kawudulla', NULL, NULL, NULL, NULL, NULL, '51414', 7.75, 80.3833),
(1109, 14, 'Kawuduluwewa Stagell', NULL, NULL, NULL, NULL, NULL, '51514', 7.8167, 80.1833),
(1110, 14, 'Kekunagolla', NULL, NULL, NULL, NULL, NULL, '60183', 7.49608, 80.170446),
(1111, 14, 'Keppitiwalana', NULL, NULL, NULL, NULL, NULL, '60288', 7.323203, 80.190441),
(1112, 14, 'Kimbulwanaoya', NULL, NULL, NULL, NULL, NULL, '60548', 7.6709, 80.4751),
(1113, 14, 'Kirimetiyawa', NULL, NULL, NULL, NULL, NULL, '60184', 7.5247, 80.1408),
(1114, 14, 'Kirindawa', NULL, NULL, NULL, NULL, NULL, '60212', 7.502078, 80.096123),
(1115, 14, 'Kirindigalla', NULL, NULL, NULL, NULL, NULL, '60502', 7.554314, 80.475005),
(1116, 14, 'Kithalawa', NULL, NULL, NULL, NULL, NULL, '60188', 7.4816, 80.1615),
(1117, 14, 'Kitulwala', NULL, NULL, NULL, NULL, NULL, '11242', 7.5, 80.5333),
(1118, 14, 'Kobeigane', NULL, NULL, NULL, NULL, NULL, '60410', 7.656731, 80.120999),
(1119, 14, 'Kohilagedara', NULL, NULL, NULL, NULL, NULL, '60028', 7.4167, 80.3667),
(1120, 14, 'Konwewa', NULL, NULL, NULL, NULL, NULL, '60630', 7.8, 80.0667),
(1121, 14, 'Kosdeniya', NULL, NULL, NULL, NULL, NULL, '60356', 7.574081, 80.138826),
(1122, 14, 'Kosgolla', NULL, NULL, NULL, NULL, NULL, '60029', 7.4, 80.3833),
(1123, 14, 'Kotagala', NULL, NULL, NULL, NULL, NULL, '22080', 7.45, 80.2333),
(1124, 5, 'Colombo 13', 'කොළඹ 13', 'கொழும்பு 13', 'Kotahena', 'කොටහේන', 'கொட்டாஞ்சேனை', '01300', 6.942778, 79.858611),
(1125, 14, 'Kotawehera', NULL, NULL, NULL, NULL, NULL, '60483', 7.7911, 80.1023),
(1126, 14, 'Kudagalgamuwa', NULL, NULL, NULL, NULL, NULL, '60003', 7.558498, 80.340333),
(1127, 14, 'Kudakatnoruwa', NULL, NULL, NULL, NULL, NULL, '60754', 7.9833, 80.3833),
(1128, 14, 'Kuliyapitiya', NULL, NULL, NULL, NULL, NULL, '60200', 7.469551, 80.04873),
(1129, 14, 'Kumaragama', NULL, NULL, NULL, NULL, NULL, '51412', 7.75, 80.3833),
(1130, 14, 'Kumbukgeta', NULL, NULL, NULL, NULL, NULL, '60508', 7.675, 80.3667),
(1131, 14, 'Kumbukwewa', NULL, NULL, NULL, NULL, NULL, '60506', 7.797468, 80.217857),
(1132, 14, 'Kuratihena', NULL, NULL, NULL, NULL, NULL, '60438', 7.6, 80.1333),
(1133, 14, 'Kurunegala', NULL, NULL, NULL, NULL, NULL, '60000', 7.4867, 80.3647),
(1134, 14, 'lbbagamuwa', NULL, NULL, NULL, NULL, NULL, '60500', 7.675, 80.3667),
(1135, 14, 'lhala Kadigamuwa', NULL, NULL, NULL, NULL, NULL, '60238', 7.5436, 79.9819),
(1136, 14, 'Lihiriyagama', NULL, NULL, NULL, NULL, NULL, '61138', 7.3447, 79.9425),
(1137, 14, 'lllagolla', NULL, NULL, NULL, NULL, NULL, '20724', 7.4333, 80.1333),
(1138, 14, 'llukhena', NULL, NULL, NULL, NULL, NULL, '60232', 7.5436, 79.9819),
(1139, 14, 'Lonahettiya', NULL, NULL, NULL, NULL, NULL, '60108', 7.4589, 80.2107),
(1140, 14, 'Madahapola', NULL, NULL, NULL, NULL, NULL, '60552', 7.711952, 80.499003),
(1141, 14, 'Madakumburumulla', NULL, NULL, NULL, NULL, NULL, '60209', 7.44599, 79.994062),
(1142, 14, 'Madalagama', NULL, NULL, NULL, NULL, NULL, '70158', 7.353398, 80.314033),
(1143, 14, 'Madawala Ulpotha', NULL, NULL, NULL, NULL, NULL, '21074', 7.703, 80.5051),
(1144, 14, 'Maduragoda', NULL, NULL, NULL, NULL, NULL, '60532', 7.5667, 80.5333),
(1145, 14, 'Maeliya', NULL, NULL, NULL, NULL, NULL, '60512', 7.734847, 80.4079),
(1146, 14, 'Magulagama', NULL, NULL, NULL, NULL, NULL, '60221', 7.542895, 80.090321),
(1147, 14, 'Maha Ambagaswewa', NULL, NULL, NULL, NULL, NULL, '51518', 7.8167, 80.1833),
(1148, 14, 'Mahagalkadawala', NULL, NULL, NULL, NULL, NULL, '60731', 8.062861, 80.28052),
(1149, 14, 'Mahagirilla', NULL, NULL, NULL, NULL, NULL, '60479', 7.8333, 80.1333),
(1150, 14, 'Mahamukalanyaya', NULL, NULL, NULL, NULL, NULL, '60516', 7.7417, 80.4318),
(1151, 14, 'Mahananneriya', NULL, NULL, NULL, NULL, NULL, '60724', 8.013545, 80.183367),
(1152, 14, 'Mahapallegama', NULL, NULL, NULL, NULL, NULL, '71063', 7.366, 80.0918),
(1153, 14, 'Maharachchimulla', NULL, NULL, NULL, NULL, NULL, '60286', 7.335989, 80.212673),
(1154, 14, 'Mahatalakolawewa', NULL, NULL, NULL, NULL, NULL, '51506', 7.8167, 80.1833),
(1155, 14, 'Mahawewa', NULL, NULL, NULL, NULL, NULL, '61220', 7.5167, 79.9167),
(1156, 14, 'Maho', NULL, NULL, NULL, NULL, NULL, '60600', 7.8228, 80.2778),
(1157, 14, 'Makulewa', NULL, NULL, NULL, NULL, NULL, '60714', 7.998315, 80.345072),
(1158, 14, 'Makulpotha', NULL, NULL, NULL, NULL, NULL, '60514', 7.751748, 80.43986),
(1159, 14, 'Makulwewa', NULL, NULL, NULL, NULL, NULL, '60578', 7.6333, 80.05),
(1160, 14, 'Malagane', NULL, NULL, NULL, NULL, NULL, '60404', 7.65, 80.2667),
(1161, 14, 'Mandapola', NULL, NULL, NULL, NULL, NULL, '60434', 7.63521, 80.108641),
(1162, 14, 'Maspotha', NULL, NULL, NULL, NULL, NULL, '60344', 7.8667, 80.2167),
(1163, 14, 'Mawathagama', NULL, NULL, NULL, NULL, NULL, '60060', 7.409691, 80.315775),
(1164, 14, 'Medirigiriya', NULL, NULL, NULL, NULL, NULL, '51500', 7.8167, 80.1833),
(1165, 14, 'Medivawa', NULL, NULL, NULL, NULL, NULL, '60612', 7.7678, 80.2858),
(1166, 14, 'Meegalawa', NULL, NULL, NULL, NULL, NULL, '60750', 7.9833, 80.3833),
(1167, 14, 'Meegaswewa', NULL, NULL, NULL, NULL, NULL, '51508', 7.8167, 80.1833),
(1168, 14, 'Meewellawa', NULL, NULL, NULL, NULL, NULL, '60484', 7.85, 80.15),
(1169, 14, 'Melsiripura', NULL, NULL, NULL, NULL, NULL, '60540', 7.65, 80.5),
(1170, 14, 'Metikumbura', NULL, NULL, NULL, NULL, NULL, '60304', 7.3615, 80.3177),
(1171, 14, 'Metiyagane', NULL, NULL, NULL, NULL, NULL, '60121', 7.390854, 80.180612),
(1172, 14, 'Minhettiya', NULL, NULL, NULL, NULL, NULL, '60004', 7.581261, 80.307757),
(1173, 14, 'Minuwangete', NULL, NULL, NULL, NULL, NULL, '60406', 7.7167, 80.25),
(1174, 14, 'Mirihanagama', NULL, NULL, NULL, NULL, NULL, '60408', 7.6542, 80.2583),
(1175, 14, 'Monnekulama', NULL, NULL, NULL, NULL, NULL, '60495', 7.824042, 80.060587),
(1176, 14, 'Moragane', NULL, NULL, NULL, NULL, NULL, '60354', 7.547791, 80.130329),
(1177, 14, 'Moragollagama', NULL, NULL, NULL, NULL, NULL, '60640', 7.6333, 80.2167),
(1178, 14, 'Morathiha', NULL, NULL, NULL, NULL, NULL, '60038', 7.510701, 80.488428),
(1179, 14, 'Munamaldeniya', NULL, NULL, NULL, NULL, NULL, '60218', 7.55, 80.0667),
(1180, 14, 'Muruthenge', NULL, NULL, NULL, NULL, NULL, '60122', 7.3942, 80.1861),
(1181, 14, 'Mutugala', NULL, NULL, NULL, NULL, NULL, '51064', 7.3667, 80.1667),
(1182, 14, 'Nabadewa', NULL, NULL, NULL, NULL, NULL, '60482', 7.6833, 80.0667),
(1183, 14, 'Nagollagama', NULL, NULL, NULL, NULL, NULL, '60590', 7.752013, 80.309254),
(1184, 14, 'Nagollagoda', NULL, NULL, NULL, NULL, NULL, '60226', 7.563335, 80.037807),
(1185, 14, 'Nakkawatta', NULL, NULL, NULL, NULL, NULL, '60186', 7.448259, 80.141879),
(1186, 14, 'Narammala', NULL, NULL, NULL, NULL, NULL, '60100', 7.431387, 80.206159),
(1187, 14, 'Nawasenapura', NULL, NULL, NULL, NULL, NULL, '51066', 7.3667, 80.1667),
(1188, 14, 'Nawatalwatta', NULL, NULL, NULL, NULL, NULL, '60292', 7.4581, 80.0603),
(1189, 14, 'Nelliya', NULL, NULL, NULL, NULL, NULL, '60549', 7.690523, 80.457947),
(1190, 14, 'Nikaweratiya', NULL, NULL, NULL, NULL, NULL, '60470', 7.747585, 80.115201),
(1191, 14, 'Nugagolla', NULL, NULL, NULL, NULL, NULL, '21534', 7.3667, 80.2),
(1192, 14, 'Nugawela', NULL, NULL, NULL, NULL, NULL, '20072', 7.329999, 80.220383),
(1193, 14, 'Padeniya', NULL, NULL, NULL, NULL, NULL, '60461', 7.648348, 80.222132),
(1194, 14, 'Padiwela', NULL, NULL, NULL, NULL, NULL, '60236', 7.545547, 79.9905),
(1195, 14, 'Pahalagiribawa', NULL, NULL, NULL, NULL, NULL, '60735', 8.0833, 80.2111),
(1196, 14, 'Pahamune', NULL, NULL, NULL, NULL, NULL, '60112', 7.4833, 80.2),
(1197, 14, 'Palagala', NULL, NULL, NULL, NULL, NULL, '50111', 7.4667, 80.1333),
(1198, 14, 'Palapathwela', NULL, NULL, NULL, NULL, NULL, '21070', 7.9, 80.2),
(1199, 14, 'Palaviya', NULL, NULL, NULL, NULL, NULL, '61280', 7.5785, 79.9098),
(1200, 14, 'Pallewela', NULL, NULL, NULL, NULL, NULL, '11150', 7.4667, 79.9833),
(1201, 14, 'Palukadawala', NULL, NULL, NULL, NULL, NULL, '60704', 7.947895, 80.279058),
(1202, 14, 'Panadaragama', NULL, NULL, NULL, NULL, NULL, '60348', 7.8667, 80.2167),
(1203, 14, 'Panagamuwa', NULL, NULL, NULL, NULL, NULL, '60052', 7.55, 80.4667),
(1204, 14, 'Panaliya', NULL, NULL, NULL, NULL, NULL, '60312', 7.328059, 80.331852),
(1205, 14, 'Panapitiya', NULL, NULL, NULL, NULL, NULL, '70152', 7.4167, 80.1833);
INSERT INTO `country_cities` (`id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude`) VALUES
(1206, 14, 'Panliyadda', NULL, NULL, NULL, NULL, NULL, '60558', 7.7061, 80.4964),
(1207, 14, 'Pansiyagama', NULL, NULL, NULL, NULL, NULL, '60554', 7.7061, 80.4964),
(1208, 14, 'Parape', NULL, NULL, NULL, NULL, NULL, '71105', 7.3667, 80.4167),
(1209, 14, 'Pathanewatta', NULL, NULL, NULL, NULL, NULL, '90071', 7.4167, 80.0833),
(1210, 14, 'Pattiya Watta', NULL, NULL, NULL, NULL, NULL, '20118', 7.3833, 80.3167),
(1211, 14, 'Perakanatta', NULL, NULL, NULL, NULL, NULL, '21532', 7.3667, 80.2),
(1212, 14, 'Periyakadneluwa', NULL, NULL, NULL, NULL, NULL, '60518', 7.7417, 80.4318),
(1213, 14, 'Pihimbiya Ratmale', NULL, NULL, NULL, NULL, NULL, '60439', 7.6299, 80.0953),
(1214, 14, 'Pihimbuwa', NULL, NULL, NULL, NULL, NULL, '60053', 7.460742, 80.512294),
(1215, 14, 'Pilessa', NULL, NULL, NULL, NULL, NULL, '60058', 7.45, 80.4167),
(1216, 14, 'Polgahawela', NULL, NULL, NULL, NULL, NULL, '60300', 7.332765, 80.295285),
(1217, 14, 'Polgolla', NULL, NULL, NULL, NULL, NULL, '20250', 7.4167, 80.5333),
(1218, 14, 'Polpitigama', NULL, NULL, NULL, NULL, NULL, '60620', 7.8142, 80.4042),
(1219, 14, 'Pothuhera', NULL, NULL, NULL, NULL, NULL, '60330', 7.4181, 80.3317),
(1220, 14, 'Pothupitiya', NULL, NULL, NULL, NULL, NULL, '70338', 7.35542, 80.17166),
(1221, 14, 'Pujapitiya', NULL, NULL, NULL, NULL, NULL, '20112', 7.3833, 80.3167),
(1222, 14, 'Rakwana', NULL, NULL, NULL, NULL, NULL, '70300', 7.9, 80.4),
(1223, 14, 'Ranorawa', NULL, NULL, NULL, NULL, NULL, '50212', 7.8, 80.0833),
(1224, 14, 'Rathukohodigala', NULL, NULL, NULL, NULL, NULL, '20818', 7.5833, 79.9333),
(1225, 14, 'Ridibendiella', NULL, NULL, NULL, NULL, NULL, '60606', 7.802, 80.287),
(1226, 14, 'Ridigama', NULL, NULL, NULL, NULL, NULL, '60040', 7.55, 80.4833),
(1227, 14, 'Saliya Asokapura', NULL, NULL, NULL, NULL, NULL, '60736', 8.0833, 80.2111),
(1228, 14, 'Sandalankawa', NULL, NULL, NULL, NULL, NULL, '60176', 7.304619, 79.944358),
(1229, 14, 'Sevanapitiya', NULL, NULL, NULL, NULL, NULL, '51062', 7.3667, 80.1667),
(1230, 14, 'Sirambiadiya', NULL, NULL, NULL, NULL, NULL, '61312', 8.1, 80.2667),
(1231, 14, 'Sirisetagama', NULL, NULL, NULL, NULL, NULL, '60478', 7.7772, 80.1506),
(1232, 14, 'Siyambalangamuwa', NULL, NULL, NULL, NULL, NULL, '60646', 7.529179, 80.340311),
(1233, 14, 'Siyambalawewa', NULL, NULL, NULL, NULL, NULL, '32048', 7.65, 79.9667),
(1234, 14, 'Solepura', NULL, NULL, NULL, NULL, NULL, '60737', 8.153657, 80.153384),
(1235, 14, 'Solewewa', NULL, NULL, NULL, NULL, NULL, '60738', 8.145855, 80.132596),
(1236, 14, 'Sunandapura', NULL, NULL, NULL, NULL, NULL, '60436', 7.6299, 80.0953),
(1237, 14, 'Talawattegedara', NULL, NULL, NULL, NULL, NULL, '60306', 7.3833, 80.3),
(1238, 14, 'Tambutta', NULL, NULL, NULL, NULL, NULL, '60734', 8.0833, 80.2167),
(1239, 14, 'Tennepanguwa', NULL, NULL, NULL, NULL, NULL, '90072', 7.4167, 80.0833),
(1240, 14, 'Thalahitimulla', NULL, NULL, NULL, NULL, NULL, '60208', 7.432473, 80.001954),
(1241, 14, 'Thalakolawewa', NULL, NULL, NULL, NULL, NULL, '60624', 7.796943, 80.433851),
(1242, 14, 'Thalwita', NULL, NULL, NULL, NULL, NULL, '60572', 7.5943, 80.2108),
(1243, 14, 'Tharana Udawela', NULL, NULL, NULL, NULL, NULL, '60227', 7.5333, 80.0667),
(1244, 14, 'Thimbiriyawa', NULL, NULL, NULL, NULL, NULL, '60476', 7.750904, 80.140975),
(1245, 14, 'Tisogama', NULL, NULL, NULL, NULL, NULL, '60453', 7.6065, 79.9406),
(1246, 14, 'Torayaya', NULL, NULL, NULL, NULL, NULL, '60499', 7.5167, 80.4),
(1247, 14, 'Tulhiriya', NULL, NULL, NULL, NULL, NULL, '71610', 7.2833, 80.2167),
(1248, 14, 'Tuntota', NULL, NULL, NULL, NULL, NULL, '71062', 7.5, 79.9167),
(1249, 14, 'Tuttiripitigama', NULL, NULL, NULL, NULL, NULL, '60426', 7.6, 80.1333),
(1250, 14, 'Udagaldeniya', NULL, NULL, NULL, NULL, NULL, '71113', 7.3583, 80.35),
(1251, 14, 'Udahingulwala', NULL, NULL, NULL, NULL, NULL, '20094', 7.3, 80.15),
(1252, 14, 'Udawatta', NULL, NULL, NULL, NULL, NULL, '20722', 7.4333, 80.1333),
(1253, 14, 'Udubaddawa', NULL, NULL, NULL, NULL, NULL, '60250', 7.4828, 79.9753),
(1254, 14, 'Udumulla', NULL, NULL, NULL, NULL, NULL, '71521', 7.45, 80.4),
(1255, 14, 'Uhumiya', NULL, NULL, NULL, NULL, NULL, '60094', 7.4667, 80.2833),
(1256, 14, 'Ulpotha Pallekele', NULL, NULL, NULL, NULL, NULL, '60622', 7.8071, 80.4188),
(1257, 14, 'Ulpothagama', NULL, NULL, NULL, NULL, NULL, '20965', 7.7167, 80.3167),
(1258, 14, 'Usgala Siyabmalangamuwa', NULL, NULL, NULL, NULL, NULL, '60732', 8.0833, 80.2111),
(1259, 14, 'Vijithapura', NULL, NULL, NULL, NULL, NULL, '50110', 7.4667, 80.1333),
(1260, 14, 'Wadakada', NULL, NULL, NULL, NULL, NULL, '60318', 7.39697, 80.267596),
(1261, 14, 'Wadumunnegedara', NULL, NULL, NULL, NULL, NULL, '60204', 7.4167, 79.9667),
(1262, 14, 'Walakumburumulla', NULL, NULL, NULL, NULL, NULL, '60198', 7.4167, 80.0167),
(1263, 14, 'Wannigama', NULL, NULL, NULL, NULL, NULL, '60465', 7.6569, 80.2203),
(1264, 14, 'Wannikudawewa', NULL, NULL, NULL, NULL, NULL, '60721', 7.9977, 80.2964),
(1265, 14, 'Wannilhalagama', NULL, NULL, NULL, NULL, NULL, '60722', 7.9977, 80.2964),
(1266, 14, 'Wannirasnayakapura', NULL, NULL, NULL, NULL, NULL, '60490', 7.6889, 80.1556),
(1267, 14, 'Warawewa', NULL, NULL, NULL, NULL, NULL, '60739', 8.121572, 80.14855),
(1268, 14, 'Wariyapola', NULL, NULL, NULL, NULL, NULL, '60400', 7.628694, 80.235989),
(1269, 14, 'Watareka', NULL, NULL, NULL, NULL, NULL, '10511', 7.397142, 80.432878),
(1270, 14, 'Wattegama', NULL, NULL, NULL, NULL, NULL, '20810', 7.5833, 79.9333),
(1271, 14, 'Watuwatta', NULL, NULL, NULL, NULL, NULL, '60262', 7.5167, 79.9167),
(1272, 14, 'Weerapokuna', NULL, NULL, NULL, NULL, NULL, '60454', 7.649426, 79.981893),
(1273, 14, 'Welawa Juncton', NULL, NULL, NULL, NULL, NULL, '60464', 7.6569, 80.2203),
(1274, 14, 'Welipennagahamulla', NULL, NULL, NULL, NULL, NULL, '60240', 7.4581, 80.0603),
(1275, 14, 'Wellagala', NULL, NULL, NULL, NULL, NULL, '60402', 7.6167, 80.2833),
(1276, 14, 'Wellarawa', NULL, NULL, NULL, NULL, NULL, '60456', 7.5729, 79.913974),
(1277, 14, 'Wellawa', NULL, NULL, NULL, NULL, NULL, '60570', 7.566524, 80.369189),
(1278, 14, 'Welpalla', NULL, NULL, NULL, NULL, NULL, '60206', 7.4333, 80.05),
(1279, 14, 'Wennoruwa', NULL, NULL, NULL, NULL, NULL, '60284', 7.369467, 80.219573),
(1280, 14, 'Weuda', NULL, NULL, NULL, NULL, NULL, '60080', 7.4, 80.1667),
(1281, 14, 'Wewagama', NULL, NULL, NULL, NULL, NULL, '60195', 7.42031, 80.099835),
(1282, 14, 'Wilgamuwa', NULL, NULL, NULL, NULL, NULL, '21530', 7.3667, 80.2),
(1283, 14, 'Yakwila', NULL, NULL, NULL, NULL, NULL, '60202', 7.3833, 80.0333),
(1284, 14, 'Yatigaloluwa', NULL, NULL, NULL, NULL, NULL, '60314', 7.328729, 80.264509),
(1285, 15, 'Mannar', NULL, NULL, NULL, NULL, NULL, '41000', 8.9833, 79.9),
(1286, 15, 'Puthukudiyiruppu', NULL, NULL, NULL, NULL, NULL, '30158', 9.046951, 79.853286),
(1287, 16, 'Akuramboda', 'අකුරම්බොඩ', NULL, NULL, NULL, NULL, '21142', 7.646383, 80.600048),
(1288, 16, 'Alawatuwala', 'අලවතුවල', NULL, NULL, NULL, NULL, '60047', 7.55, 80.5583),
(1289, 16, 'Alwatta', 'අල්වත්ත', NULL, NULL, NULL, NULL, '21004', 7.449444, 80.663358),
(1290, 16, 'Ambana', 'අම්බාන', NULL, NULL, NULL, NULL, '21504', 7.651007, 80.693816),
(1291, 16, 'Aralaganwila', 'අරලගන්විල', NULL, NULL, NULL, NULL, '51100', 7.696, 80.5842),
(1292, 16, 'Ataragallewa', 'අටරගල්ලෑව', NULL, NULL, NULL, NULL, '21512', 7.5333, 80.6067),
(1293, 16, 'Bambaragaswewa', 'බඹරගස්වැව', NULL, NULL, NULL, NULL, '21212', 7.784315, 80.540511),
(1294, 16, 'Barawardhana Oya', 'බරවර්ධන ඔය', NULL, NULL, NULL, NULL, '20967', 7.5667, 80.625),
(1295, 16, 'Beligamuwa', 'බෙලිගමුව', NULL, NULL, NULL, NULL, '21214', 7.725882, 80.552789),
(1296, 16, 'Damana', 'දමන', NULL, NULL, NULL, NULL, '32014', 7.8417, 80.5797),
(1297, 16, 'Dambulla', 'දඹුල්ල', NULL, NULL, NULL, NULL, '21100', 7.868039, 80.646464),
(1298, 16, 'Damminna', 'දම්මින්න', NULL, NULL, NULL, NULL, '51106', 7.696, 80.5842),
(1299, 16, 'Dankanda', 'දංකන්ද', NULL, NULL, NULL, NULL, '21032', 7.519616, 80.694168),
(1300, 16, 'Delwite', 'දෙල්විටේ', NULL, NULL, NULL, NULL, '60044', 7.55, 80.5583),
(1301, 16, 'Devagiriya', 'දේවගිරිය', NULL, NULL, NULL, NULL, '21552', 7.5833, 80.9667),
(1302, 16, 'Dewahuwa', 'දේවහුව', NULL, NULL, NULL, NULL, '21206', 7.7589, 80.5683),
(1303, 16, 'Divuldamana', 'දිවුල්දමන', NULL, NULL, NULL, NULL, '51104', 7.696, 80.5842),
(1304, 16, 'Dullewa', 'දුල්වල', NULL, NULL, NULL, NULL, '21054', 7.511012, 80.59862),
(1305, 16, 'Dunkolawatta', 'දුන්කොලවත්ත', NULL, NULL, NULL, NULL, '21046', 7.4917, 80.625),
(1306, 16, 'Elkaduwa', 'ඇල්කඩුව', NULL, NULL, NULL, NULL, '21012', 7.410706, 80.693258),
(1307, 16, 'Erawula Junction', 'එරවුල හන්දිය', NULL, NULL, NULL, NULL, '21108', 7.8633, 80.6842),
(1308, 16, 'Etanawala', 'එතනවල', NULL, NULL, NULL, NULL, '21402', 7.5217, 80.6847),
(1309, 16, 'Galewela', 'ගලේවෙල', NULL, NULL, NULL, NULL, '21200', 7.759807, 80.56744),
(1310, 16, 'Galoya Junction', 'ගල්ඔය හන්දිය', NULL, NULL, NULL, NULL, '51375', 7.696, 80.5842),
(1311, 16, 'Gammaduwa', 'ගම්මඩුව', NULL, NULL, NULL, NULL, '21068', 7.581654, 80.698521),
(1312, 16, 'Gangala Puwakpitiya', 'ගන්ගල පුවක්පිටිය', NULL, NULL, NULL, NULL, '21404', 7.5217, 80.6847),
(1313, 16, 'Hasalaka', NULL, NULL, NULL, NULL, NULL, '20960', 7.5667, 80.625),
(1314, 16, 'Hattota Amuna', NULL, NULL, NULL, NULL, NULL, '21514', 7.5333, 80.6067),
(1315, 16, 'Imbulgolla', NULL, NULL, NULL, NULL, NULL, '21064', 7.575027, 80.663159),
(1316, 16, 'Inamaluwa', NULL, NULL, NULL, NULL, NULL, '21124', 7.951344, 80.690187),
(1317, 16, 'Iriyagolla', NULL, NULL, NULL, NULL, NULL, '60045', 7.55, 80.6333),
(1318, 16, 'Kaikawala', NULL, NULL, NULL, NULL, NULL, '21066', 7.507177, 80.659444),
(1319, 16, 'Kalundawa', NULL, NULL, NULL, NULL, NULL, '21112', 7.8, 80.7167),
(1320, 16, 'Kandalama', NULL, NULL, NULL, NULL, NULL, '21106', 7.887403, 80.703507),
(1321, 16, 'Kavudupelella', NULL, NULL, NULL, NULL, NULL, '21072', 7.5914, 80.6258),
(1322, 16, 'Kibissa', NULL, NULL, NULL, NULL, NULL, '21122', 7.9397, 80.7278),
(1323, 16, 'Kiwula', NULL, NULL, NULL, NULL, NULL, '21042', 7.4917, 80.625),
(1324, 16, 'Kongahawela', NULL, NULL, NULL, NULL, NULL, '21500', 7.679932, 80.706607),
(1325, 16, 'Laggala Pallegama', NULL, NULL, NULL, NULL, NULL, '21520', 7.5333, 80.6067),
(1326, 16, 'Leliambe', NULL, NULL, NULL, NULL, NULL, '21008', 7.4346, 80.6519),
(1327, 16, 'Lenadora', NULL, NULL, NULL, NULL, NULL, '21094', 7.753507, 80.660161),
(1328, 16, 'lhala Halmillewa', NULL, NULL, NULL, NULL, NULL, '50262', 7.8667, 80.6417),
(1329, 16, 'lllukkumbura', NULL, NULL, NULL, NULL, NULL, '21406', 7.5217, 80.6847),
(1330, 16, 'Madipola', NULL, NULL, NULL, NULL, NULL, '21156', 7.6833, 80.5833),
(1331, 16, 'Maduruoya', NULL, NULL, NULL, NULL, NULL, '51108', 7.696, 80.5842),
(1332, 16, 'Mahawela', NULL, NULL, NULL, NULL, NULL, '21140', 7.581804, 80.607485),
(1333, 16, 'Mananwatta', NULL, NULL, NULL, NULL, NULL, '21144', 7.685106, 80.601107),
(1334, 16, 'Maraka', NULL, NULL, NULL, NULL, NULL, '21554', 7.586801, 80.962009),
(1335, 16, 'Matale', NULL, NULL, NULL, NULL, NULL, '21000', 7.4717, 80.6244),
(1336, 16, 'Melipitiya', NULL, NULL, NULL, NULL, NULL, '21055', 7.5458, 80.5833),
(1337, 16, 'Metihakka', NULL, NULL, NULL, NULL, NULL, '21062', 7.536495, 80.654081),
(1338, 16, 'Millawana', NULL, NULL, NULL, NULL, NULL, '21154', 7.6503, 80.5772),
(1339, 16, 'Muwandeniya', NULL, NULL, NULL, NULL, NULL, '21044', 7.461452, 80.660098),
(1340, 16, 'Nalanda', NULL, NULL, NULL, NULL, NULL, '21082', 7.662487, 80.635004),
(1341, 16, 'Naula', NULL, NULL, NULL, NULL, NULL, '21090', 7.708132, 80.652321),
(1342, 16, 'Opalgala', NULL, NULL, NULL, NULL, NULL, '21076', 7.619927, 80.698338),
(1343, 16, 'Pallepola', NULL, NULL, NULL, NULL, NULL, '21152', 7.620686, 80.600466),
(1344, 16, 'Pimburattewa', NULL, NULL, NULL, NULL, NULL, '51102', 7.696, 80.5842),
(1345, 16, 'Pulastigama', NULL, NULL, NULL, NULL, NULL, '51050', 7.67, 80.565),
(1346, 16, 'Ranamuregama', NULL, NULL, NULL, NULL, NULL, '21524', 7.5333, 80.6067),
(1347, 16, 'Rattota', NULL, NULL, NULL, NULL, NULL, '21400', 7.5217, 80.6847),
(1348, 16, 'Selagama', NULL, NULL, NULL, NULL, NULL, '21058', 7.594457, 80.58381),
(1349, 16, 'Sigiriya', NULL, NULL, NULL, NULL, NULL, '21120', 7.954968, 80.755205),
(1350, 16, 'Sinhagama', NULL, NULL, NULL, NULL, NULL, '51378', 7.696, 80.5842),
(1351, 16, 'Sungavila', NULL, NULL, NULL, NULL, NULL, '51052', 7.67, 80.565),
(1352, 16, 'Talagoda Junction', NULL, NULL, NULL, NULL, NULL, '21506', 7.5722, 80.6222),
(1353, 16, 'Talakiriyagama', NULL, NULL, NULL, NULL, NULL, '21116', 7.8206, 80.6172),
(1354, 16, 'Tamankaduwa', NULL, NULL, NULL, NULL, NULL, '51089', 7.67, 80.565),
(1355, 16, 'Udasgiriya', NULL, NULL, NULL, NULL, NULL, '21051', 7.535254, 80.570342),
(1356, 16, 'Udatenna', NULL, NULL, NULL, NULL, NULL, '21006', 7.4167, 80.65),
(1357, 16, 'Ukuwela', NULL, NULL, NULL, NULL, NULL, '21300', 7.423917, 80.62996),
(1358, 16, 'Wahacotte', NULL, NULL, NULL, NULL, NULL, '21160', 7.7142, 80.5972),
(1359, 16, 'Walawela', NULL, NULL, NULL, NULL, NULL, '21048', 7.520365, 80.597403),
(1360, 16, 'Wehigala', NULL, NULL, NULL, NULL, NULL, '21009', 7.409019, 80.669112),
(1361, 16, 'Welangahawatte', NULL, NULL, NULL, NULL, NULL, '21408', 7.5217, 80.6847),
(1362, 16, 'Wewalawewa', NULL, NULL, NULL, NULL, NULL, '21114', 7.8103, 80.6669),
(1363, 16, 'Yatawatta', NULL, NULL, NULL, NULL, NULL, '21056', 7.562698, 80.578361),
(1364, 17, 'Akuressa', 'අකුරැස්ස', NULL, NULL, NULL, NULL, '81400', 6.0964, 80.4808),
(1365, 17, 'Alapaladeniya', 'අලපලදෙණිය', NULL, NULL, NULL, NULL, '81475', 6.2833, 80.45),
(1366, 17, 'Aparekka', 'අපරැක්ක', NULL, NULL, NULL, NULL, '81032', 6.008083, 80.621556),
(1367, 17, 'Athuraliya', 'අතුරලීය', NULL, NULL, NULL, NULL, '81402', 6.069724, 80.497879),
(1368, 17, 'Bengamuwa', 'බෙන්ගමුව', NULL, NULL, NULL, NULL, '81614', 6.253417, 80.59808),
(1369, 17, 'Bopagoda', 'බෝපගොඩ', NULL, NULL, NULL, NULL, '81412', 6.1561, 80.4903),
(1370, 17, 'Dampahala', 'දම්පහල', NULL, NULL, NULL, NULL, '81612', 6.259631, 80.633081),
(1371, 17, 'Deegala Lenama', 'දීගල ලෙනම', NULL, NULL, NULL, NULL, '81452', 6.2333, 80.45),
(1372, 17, 'Deiyandara', 'දෙයියන්දර', NULL, NULL, NULL, NULL, '81320', 6.152388, 80.604696),
(1373, 17, 'Denagama', 'දෙනගම', NULL, NULL, NULL, NULL, '81314', 6.11481, 80.642749),
(1374, 17, 'Denipitiya', 'දෙණිපිටිය', NULL, NULL, NULL, NULL, '81730', 5.9667, 80.45),
(1375, 17, 'Deniyaya', 'දෙණියාය', NULL, NULL, NULL, NULL, '81500', 6.339732, 80.548055),
(1376, 17, 'Derangala', 'දෙරණගල', NULL, NULL, NULL, NULL, '81454', 6.229572, 80.445492),
(1377, 17, 'Devinuwara (Dondra)', 'දෙවිනුවර (දෙවුන්දර)', NULL, NULL, NULL, NULL, '81160', 5.9319, 80.6069),
(1378, 17, 'Dikwella', 'දික්වැල්ල', NULL, NULL, NULL, NULL, '81200', 5.9667, 80.6833),
(1379, 17, 'Diyagaha', 'දියගහ', NULL, NULL, NULL, NULL, '81038', 5.9833, 80.5667),
(1380, 17, 'Diyalape', 'දියලපේ', NULL, NULL, NULL, NULL, '81422', 6.121802, 80.447911),
(1381, 17, 'Gandara', 'ගන්දර', NULL, NULL, NULL, NULL, '81170', 5.933629, 80.61575),
(1382, 17, 'Godapitiya', 'ගොඩපිටිය', NULL, NULL, NULL, NULL, '81408', 6.121801, 80.480996),
(1383, 17, 'Gomilamawarala', 'ගොමිලමවරල', NULL, NULL, NULL, NULL, '81072', 6.1833, 80.5667),
(1384, 17, 'Hawpe', NULL, NULL, NULL, NULL, NULL, '80132', 6.129973, 80.489743),
(1385, 17, 'Horapawita', NULL, NULL, NULL, NULL, NULL, '81108', 6.1167, 80.5833),
(1386, 17, 'Kalubowitiyana', NULL, NULL, NULL, NULL, NULL, '81478', 6.3167, 80.4),
(1387, 17, 'Kamburugamuwa', NULL, NULL, NULL, NULL, NULL, '81750', 5.940612, 80.496449),
(1388, 17, 'Kamburupitiya', NULL, NULL, NULL, NULL, NULL, '81100', 6.069847, 80.56473),
(1389, 17, 'Karagoda Uyangoda', NULL, NULL, NULL, NULL, NULL, '81082', 6.0715, 80.5193),
(1390, 17, 'Karaputugala', NULL, NULL, NULL, NULL, NULL, '81106', 6.07377, 80.603484),
(1391, 17, 'Karatota', NULL, NULL, NULL, NULL, NULL, '81318', 6.0667, 80.6667),
(1392, 17, 'Kekanadurra', NULL, NULL, NULL, NULL, NULL, '81020', 6.0715, 80.5193),
(1393, 17, 'Kiriweldola', NULL, NULL, NULL, NULL, NULL, '81514', 6.372272, 80.533507),
(1394, 17, 'Kiriwelkele', NULL, NULL, NULL, NULL, NULL, '81456', 6.249957, 80.451047),
(1395, 17, 'Kolawenigama', NULL, NULL, NULL, NULL, NULL, '81522', 6.321671, 80.500227),
(1396, 17, 'Kotapola', NULL, NULL, NULL, NULL, NULL, '81480', 6.292393, 80.533957),
(1397, 17, 'Lankagama', NULL, NULL, NULL, NULL, NULL, '81526', 6.35, 80.4667),
(1398, 17, 'Makandura', NULL, NULL, NULL, NULL, NULL, '81070', 6.137036, 80.571982),
(1399, 17, 'Maliduwa', NULL, NULL, NULL, NULL, NULL, '81424', 6.1333, 80.4167),
(1400, 17, 'Maramba', NULL, NULL, NULL, NULL, NULL, '81416', 6.1614, 80.5035),
(1401, 17, 'Matara', NULL, NULL, NULL, NULL, NULL, '81000', 5.9486, 80.5428),
(1402, 17, 'Mediripitiya', NULL, NULL, NULL, NULL, NULL, '81524', 6.35, 80.4667),
(1403, 17, 'Miella', NULL, NULL, NULL, NULL, NULL, '81312', 6.1167, 80.6833),
(1404, 17, 'Mirissa', NULL, NULL, NULL, NULL, NULL, '81740', 5.94679, 80.452288),
(1405, 17, 'Morawaka', NULL, NULL, NULL, NULL, NULL, '81470', 6.25, 80.4833),
(1406, 17, 'Mulatiyana Junction', NULL, NULL, NULL, NULL, NULL, '81071', 6.1833, 80.5667),
(1407, 17, 'Nadugala', NULL, NULL, NULL, NULL, NULL, '81092', 5.975464, 80.548935),
(1408, 17, 'Naimana', NULL, NULL, NULL, NULL, NULL, '81017', 6.0715, 80.5193),
(1409, 17, 'Palatuwa', NULL, NULL, NULL, NULL, NULL, '81050', 5.984516, 80.518656),
(1410, 17, 'Parapamulla', NULL, NULL, NULL, NULL, NULL, '81322', 6.150219, 80.61675),
(1411, 17, 'Pasgoda', NULL, NULL, NULL, NULL, NULL, '81615', 6.242998, 80.616175),
(1412, 17, 'Penetiyana', NULL, NULL, NULL, NULL, NULL, '81722', 6.034813, 80.450626),
(1413, 17, 'Pitabeddara', NULL, NULL, NULL, NULL, NULL, '81450', 6.2167, 80.45),
(1414, 17, 'Puhulwella', NULL, NULL, NULL, NULL, NULL, '81290', 6.045752, 80.619203),
(1415, 17, 'Radawela', NULL, NULL, NULL, NULL, NULL, '81316', 6.124672, 80.60726),
(1416, 17, 'Ransegoda', NULL, NULL, NULL, NULL, NULL, '81064', 6.0715, 80.5193),
(1417, 17, 'Rotumba', NULL, NULL, NULL, NULL, NULL, '81074', 6.229142, 80.571151),
(1418, 17, 'Sultanagoda', NULL, NULL, NULL, NULL, NULL, '81051', 5.9667, 80.5),
(1419, 17, 'Telijjawila', NULL, NULL, NULL, NULL, NULL, '81060', 6.0715, 80.5193),
(1420, 17, 'Thihagoda', NULL, NULL, NULL, NULL, NULL, '81280', 6.011602, 80.561851),
(1421, 17, 'Urubokka', NULL, NULL, NULL, NULL, NULL, '81600', 6.302863, 80.631175),
(1422, 17, 'Urugamuwa', NULL, NULL, NULL, NULL, NULL, '81230', 6.0116, 80.6437),
(1423, 17, 'Urumutta', NULL, NULL, NULL, NULL, NULL, '81414', 6.150181, 80.519582),
(1424, 17, 'Viharahena', NULL, NULL, NULL, NULL, NULL, '81508', 6.379073, 80.598006),
(1425, 17, 'Walakanda', NULL, NULL, NULL, NULL, NULL, '81294', 6.01655, 80.649889),
(1426, 17, 'Walasgala', NULL, NULL, NULL, NULL, NULL, '81220', 5.981913, 80.693678),
(1427, 17, 'Waralla', NULL, NULL, NULL, NULL, NULL, '81479', 6.277439, 80.522519),
(1428, 17, 'Weligama', NULL, NULL, NULL, NULL, NULL, '81700', 5.9667, 80.4167),
(1429, 17, 'Wilpita', NULL, NULL, NULL, NULL, NULL, '81404', 6.1, 80.5167),
(1430, 17, 'Yatiyana', NULL, NULL, NULL, NULL, NULL, '81034', 6.028888, 80.603158),
(1431, 18, 'Ayiwela', NULL, NULL, NULL, NULL, NULL, '91516', 7.1, 81.2333),
(1432, 18, 'Badalkumbura', 'බඩල්කුඹුර', NULL, NULL, NULL, NULL, '91070', 6.893287, 81.234346),
(1433, 18, 'Baduluwela', 'බදුලුවෙල', NULL, NULL, NULL, NULL, '91058', 7.11307, 81.435299),
(1434, 18, 'Bakinigahawela', 'බකිණිගහවෙල', NULL, NULL, NULL, NULL, '91554', 6.9333, 81.2833),
(1435, 18, 'Balaharuwa', 'බලහරුව', NULL, NULL, NULL, NULL, '91295', 6.520177, 81.058519),
(1436, 18, 'Bibile', 'බිබිලේ', NULL, NULL, NULL, NULL, '91500', 7.1667, 81.2167),
(1437, 18, 'Buddama', 'බුද්ධගම', NULL, NULL, NULL, NULL, '91038', 7.046413, 81.486844),
(1438, 18, 'Buttala', 'බුත්තල', NULL, NULL, NULL, NULL, '91100', 6.75, 81.2333),
(1439, 18, 'Dambagalla', 'දඹගල්ල', NULL, NULL, NULL, NULL, '91050', 6.955743, 81.375946),
(1440, 18, 'Diyakobala', 'දියකොබල', NULL, NULL, NULL, NULL, '91514', 7.1056, 81.2222),
(1441, 18, 'Dombagahawela', 'දොඹගහවෙල', NULL, NULL, NULL, NULL, '91010', 6.898197, 81.441375),
(1442, 18, 'Ethimalewewa', 'ඇතිමලේවැව', NULL, NULL, NULL, NULL, '91020', 6.9216, 81.3833),
(1443, 18, 'Ettiliwewa', 'ඇත්තිලිවැව', NULL, NULL, NULL, NULL, '91250', 6.73, 81.12),
(1444, 18, 'Galabedda', 'ගලබැද්ද', NULL, NULL, NULL, NULL, '91008', 6.9167, 81.3833),
(1445, 18, 'Gamewela', 'ගමේවැල', NULL, NULL, NULL, NULL, '90512', 6.9167, 81.2),
(1446, 18, 'Hambegamuwa', 'හම්බෙගමුව', NULL, NULL, NULL, NULL, '91308', 6.503718, 80.874695),
(1447, 18, 'Hingurukaduwa', NULL, NULL, NULL, NULL, NULL, '90508', 6.817257, 81.153429),
(1448, 18, 'Hulandawa', NULL, NULL, NULL, NULL, NULL, '91004', 6.868479, 81.333215),
(1449, 18, 'Inginiyagala', NULL, NULL, NULL, NULL, NULL, '91040', 7.198617, 81.494496),
(1450, 18, 'Kandaudapanguwa', NULL, NULL, NULL, NULL, NULL, '91032', 6.9667, 81.5167),
(1451, 18, 'Kandawinna', NULL, NULL, NULL, NULL, NULL, '91552', 6.9333, 81.2833),
(1452, 18, 'Kataragama', NULL, NULL, NULL, NULL, NULL, '91400', 6.4167, 81.3333),
(1453, 18, 'Kotagama', NULL, NULL, NULL, NULL, NULL, '91512', 7.116448, 81.17788),
(1454, 18, 'Kotamuduna', NULL, NULL, NULL, NULL, NULL, '90506', 6.892542, 81.177651),
(1455, 18, 'Kotawehera Mankada', NULL, NULL, NULL, NULL, NULL, '91312', 6.4636, 81.053),
(1456, 18, 'Kudawewa', NULL, NULL, NULL, NULL, NULL, '61226', 6.4167, 81.0333),
(1457, 18, 'Kumbukkana', NULL, NULL, NULL, NULL, NULL, '91098', 6.814795, 81.274913),
(1458, 18, 'Marawa', NULL, NULL, NULL, NULL, NULL, '91006', 6.805944, 81.381458),
(1459, 18, 'Mariarawa', NULL, NULL, NULL, NULL, NULL, '91052', 6.975969, 81.481047),
(1460, 18, 'Medagana', NULL, NULL, NULL, NULL, NULL, '91550', 6.9333, 81.2833),
(1461, 18, 'Medawelagama', NULL, NULL, NULL, NULL, NULL, '90518', 6.9167, 81.2),
(1462, 18, 'Miyanakandura', NULL, NULL, NULL, NULL, NULL, '90584', 6.869169, 81.152967),
(1463, 18, 'Monaragala', NULL, NULL, NULL, NULL, NULL, '91000', 6.8667, 81.35),
(1464, 18, 'Moretuwegama', NULL, NULL, NULL, NULL, NULL, '91108', 6.75, 81.2333),
(1465, 18, 'Nakkala', NULL, NULL, NULL, NULL, NULL, '91003', 6.887816, 81.306082),
(1466, 18, 'Namunukula', NULL, NULL, NULL, NULL, NULL, '90580', 6.8667, 81.1167),
(1467, 18, 'Nannapurawa', NULL, NULL, NULL, NULL, NULL, '91519', 7.0833, 81.25),
(1468, 18, 'Nelliyadda', NULL, NULL, NULL, NULL, NULL, '91042', 7.389929, 81.408141),
(1469, 18, 'Nilgala', NULL, NULL, NULL, NULL, NULL, '91508', 7.215945, 81.312806),
(1470, 18, 'Obbegoda', NULL, NULL, NULL, NULL, NULL, '91007', 6.8786, 81.3476),
(1471, 18, 'Okkampitiya', NULL, NULL, NULL, NULL, NULL, '91060', 6.753201, 81.29752),
(1472, 18, 'Pangura', NULL, NULL, NULL, NULL, NULL, '91002', 6.9833, 81.3167),
(1473, 18, 'Pitakumbura', NULL, NULL, NULL, NULL, NULL, '91505', 7.191575, 81.27524),
(1474, 18, 'Randeniya', NULL, NULL, NULL, NULL, NULL, '91204', 6.803474, 81.1119),
(1475, 18, 'Ruwalwela', NULL, NULL, NULL, NULL, NULL, '91056', 7.017476, 81.386203),
(1476, 18, 'Sella Kataragama', NULL, NULL, NULL, NULL, NULL, '91405', 6.4167, 81.3333),
(1477, 18, 'Siyambalagune', NULL, NULL, NULL, NULL, NULL, '91202', 6.8, 81.1333),
(1478, 18, 'Siyambalanduwa', NULL, NULL, NULL, NULL, NULL, '91030', 6.910581, 81.552112),
(1479, 18, 'Suriara', NULL, NULL, NULL, NULL, NULL, '91306', 6.4636, 81.053),
(1480, 18, 'Tanamalwila', NULL, NULL, NULL, NULL, NULL, '91300', 6.4333, 81.1333),
(1481, 18, 'Uva Gangodagama', NULL, NULL, NULL, NULL, NULL, '91054', 7.0056, 81.4222),
(1482, 18, 'Uva Kudaoya', NULL, NULL, NULL, NULL, NULL, '91298', 6.75, 81.2),
(1483, 18, 'Uva Pelwatta', NULL, NULL, NULL, NULL, NULL, '91112', 6.75, 81.2333),
(1484, 18, 'Warunagama', NULL, NULL, NULL, NULL, NULL, '91198', 6.75, 81.2333),
(1485, 18, 'Wedikumbura', NULL, NULL, NULL, NULL, NULL, '91005', 6.8333, 81.3833),
(1486, 18, 'Weherayaya Handapanagala', NULL, NULL, NULL, NULL, NULL, '91206', 6.7778, 81.1167),
(1487, 18, 'Wellawaya', NULL, NULL, NULL, NULL, NULL, '91200', 6.719458, 81.106295),
(1488, 18, 'Wilaoya', NULL, NULL, NULL, NULL, NULL, '91022', 6.9216, 81.3833),
(1489, 18, 'Yudaganawa', NULL, NULL, NULL, NULL, NULL, '51424', 6.776882, 81.229725),
(1490, 19, 'Mullativu', NULL, NULL, NULL, NULL, NULL, '42000', 9.266667, 80.816667),
(1491, 20, 'Agarapathana', 'ආගරපතන', NULL, NULL, NULL, NULL, '22094', 6.824224, 80.709671),
(1492, 20, 'Ambatalawa', 'අඹතලාව', NULL, NULL, NULL, NULL, '20686', 7.05, 80.6667),
(1493, 20, 'Ambewela', 'අඹේවෙල', NULL, NULL, NULL, NULL, '22216', 6.899935, 80.783603),
(1494, 20, 'Bogawantalawa', 'බොගවන්තලාව', NULL, NULL, NULL, NULL, '22060', 6.8, 80.6833),
(1495, 20, 'Bopattalawa', 'බෝපත්තලාව', NULL, NULL, NULL, NULL, '22095', 6.9011, 80.6694),
(1496, 20, 'Dagampitiya', 'දාගම්පිටිය', NULL, NULL, NULL, NULL, '20684', 6.977604, 80.466144),
(1497, 20, 'Dayagama Bazaar', 'දයගම බසාර්', NULL, NULL, NULL, NULL, '22096', 6.9011, 80.6694),
(1498, 20, 'Dikoya', 'දික්ඔය', NULL, NULL, NULL, NULL, '22050', 6.8786, 80.6272),
(1499, 20, 'Doragala', 'දොරගල', NULL, NULL, NULL, NULL, '20567', 7.0731, 80.5892),
(1500, 20, 'Dunukedeniya', 'දුනුකෙදෙණිය', NULL, NULL, NULL, NULL, '22002', 6.982643, 80.632911),
(1501, 20, 'Egodawela', 'එගොඩවෙල', NULL, NULL, NULL, NULL, '90013', 7.024081, 80.662636),
(1502, 20, 'Ekiriya', 'ඇකිරිය', NULL, NULL, NULL, NULL, '20732', 7.148834, 80.757167),
(1503, 20, 'Elamulla', 'ඇලමුල්ල', NULL, NULL, NULL, NULL, '20742', 7.0833, 80.8),
(1504, 20, 'Ginigathena', 'ගිනිගතැන', NULL, NULL, NULL, NULL, '20680', 6.9864, 80.4894),
(1505, 20, 'Gonakele', 'ගොනාකැලේ', NULL, NULL, NULL, NULL, '22226', 6.9917, 80.8194),
(1506, 20, 'Haggala', 'හග්ගල', NULL, NULL, NULL, NULL, '22208', 6.9697, 80.77),
(1507, 20, 'Halgranoya', 'හාල්ගරනඔය', NULL, NULL, NULL, NULL, '22240', 7.0417, 80.8917),
(1508, 20, 'Hangarapitiya', NULL, NULL, NULL, NULL, NULL, '22044', 6.932637, 80.464959),
(1509, 20, 'Hapugastalawa', NULL, NULL, NULL, NULL, NULL, '20668', 7.0667, 80.5667),
(1510, 20, 'Harasbedda', NULL, NULL, NULL, NULL, NULL, '22262', 7.04738, 80.876477),
(1511, 20, 'Hatton', NULL, NULL, NULL, NULL, NULL, '22000', 6.899356, 80.599855),
(1512, 20, 'Hewaheta', NULL, NULL, NULL, NULL, NULL, '20440', 7.1108, 80.7547),
(1513, 20, 'Hitigegama', NULL, NULL, NULL, NULL, NULL, '22046', 6.947521, 80.457154),
(1514, 20, 'Jangulla', NULL, NULL, NULL, NULL, NULL, '90063', 7.0333, 80.8917),
(1515, 20, 'Kalaganwatta', NULL, NULL, NULL, NULL, NULL, '22282', 7.104232, 80.902715),
(1516, 20, 'Kandapola', NULL, NULL, NULL, NULL, NULL, '22220', 6.981495, 80.802798),
(1517, 20, 'Karandagolla', NULL, NULL, NULL, NULL, NULL, '20738', 7.057024, 80.899844),
(1518, 20, 'Keerthi Bandarapura', NULL, NULL, NULL, NULL, NULL, '22274', 7.1108, 80.8581),
(1519, 20, 'Kiribathkumbura', NULL, NULL, NULL, NULL, NULL, '20442', 7.1108, 80.7547),
(1520, 20, 'Kotiyagala', NULL, NULL, NULL, NULL, NULL, '91024', 6.784171, 80.68557),
(1521, 20, 'Kotmale', NULL, NULL, NULL, NULL, NULL, '20560', 7.0214, 80.5942),
(1522, 20, 'Kottellena', NULL, NULL, NULL, NULL, NULL, '22040', 6.893287, 80.50215),
(1523, 20, 'Kumbalgamuwa', NULL, NULL, NULL, NULL, NULL, '22272', 7.109883, 80.853852),
(1524, 20, 'Kumbukwela', NULL, NULL, NULL, NULL, NULL, '22246', 7.055729, 80.887479),
(1525, 20, 'Kurupanawela', NULL, NULL, NULL, NULL, NULL, '22252', 7.01894, 80.920981),
(1526, 20, 'Labukele', NULL, NULL, NULL, NULL, NULL, '20592', 7.0442, 80.6919),
(1527, 20, 'Laxapana', NULL, NULL, NULL, NULL, NULL, '22034', 6.8952, 80.5088),
(1528, 20, 'Lindula', NULL, NULL, NULL, NULL, NULL, '22090', 6.920326, 80.684129),
(1529, 20, 'Madulla', NULL, NULL, NULL, NULL, NULL, '22256', 7.047667, 80.918204),
(1530, 20, 'Mandaram Nuwara', NULL, NULL, NULL, NULL, NULL, '20744', 7.0833, 80.8),
(1531, 20, 'Maskeliya', NULL, NULL, NULL, NULL, NULL, '22070', 6.831379, 80.568585),
(1532, 20, 'Maswela', NULL, NULL, NULL, NULL, NULL, '20566', 7.072503, 80.6439),
(1533, 20, 'Maturata', NULL, NULL, NULL, NULL, NULL, '20748', 7.0833, 80.8),
(1534, 20, 'Mipanawa', NULL, NULL, NULL, NULL, NULL, '22254', 7.0333, 80.9167),
(1535, 20, 'Mipilimana', NULL, NULL, NULL, NULL, NULL, '22214', 6.8667, 80.8167),
(1536, 20, 'Morahenagama', NULL, NULL, NULL, NULL, NULL, '22036', 6.942625, 80.478482),
(1537, 20, 'Munwatta', NULL, NULL, NULL, NULL, NULL, '20752', 7.11534, 80.809403),
(1538, 20, 'Nayapana Janapadaya', NULL, NULL, NULL, NULL, NULL, '20568', 7.0731, 80.5892),
(1539, 20, 'Nildandahinna', NULL, NULL, NULL, NULL, NULL, '22280', 7.0833, 80.8833),
(1540, 20, 'Nissanka Uyana', NULL, NULL, NULL, NULL, NULL, '22075', 6.8358, 80.5703),
(1541, 20, 'Norwood', NULL, NULL, NULL, NULL, NULL, '22058', 6.835736, 80.602181),
(1542, 20, 'Nuwara Eliya', NULL, NULL, NULL, NULL, NULL, '22200', 6.9697, 80.77),
(1543, 20, 'Padiyapelella', NULL, NULL, NULL, NULL, NULL, '20750', 7.092506, 80.798544),
(1544, 20, 'Pallebowala', NULL, NULL, NULL, NULL, NULL, '20734', 7.1151, 80.8108),
(1545, 20, 'Panvila', NULL, NULL, NULL, NULL, NULL, '20830', 7.0667, 80.6833),
(1546, 20, 'Pitawala', NULL, NULL, NULL, NULL, NULL, '20682', 6.998608, 80.452257),
(1547, 20, 'Pundaluoya', NULL, NULL, NULL, NULL, NULL, '22120', 7.018255, 80.676081),
(1548, 20, 'Ramboda', NULL, NULL, NULL, NULL, NULL, '20590', 7.060427, 80.69534),
(1549, 20, 'Rikillagaskada', NULL, NULL, NULL, NULL, NULL, '20730', 7.145849, 80.78095),
(1550, 20, 'Rozella', NULL, NULL, NULL, NULL, NULL, '22008', 6.9306, 80.5531),
(1551, 20, 'Rupaha', NULL, NULL, NULL, NULL, NULL, '22245', 7.0333, 80.9),
(1552, 20, 'Ruwaneliya', NULL, NULL, NULL, NULL, NULL, '22212', 6.93721, 80.772258),
(1553, 20, 'Santhipura', NULL, NULL, NULL, NULL, NULL, '22202', 6.9697, 80.77),
(1554, 20, 'Talawakele', NULL, NULL, NULL, NULL, NULL, '22100', 6.9367, 80.6611),
(1555, 20, 'Tawalantenna', NULL, NULL, NULL, NULL, NULL, '20838', 7.0667, 80.6833),
(1556, 20, 'Teripeha', NULL, NULL, NULL, NULL, NULL, '22287', 7.1189, 80.9244),
(1557, 20, 'Udamadura', NULL, NULL, NULL, NULL, NULL, '22285', 7.094106, 80.914817),
(1558, 20, 'Udapussallawa', NULL, NULL, NULL, NULL, NULL, '22250', 7.0333, 80.9111),
(1559, 20, 'Uva Deegalla', NULL, NULL, NULL, NULL, NULL, '90062', 7.0333, 80.8917),
(1560, 20, 'Uva Uduwara', NULL, NULL, NULL, NULL, NULL, '90061', 7.0333, 80.8917),
(1561, 20, 'Uvaparanagama', NULL, NULL, NULL, NULL, NULL, '90230', 6.8832, 80.7912),
(1562, 20, 'Walapane', NULL, NULL, NULL, NULL, NULL, '22270', 7.091924, 80.860522),
(1563, 20, 'Watawala', NULL, NULL, NULL, NULL, NULL, '22010', 6.951339, 80.533199),
(1564, 20, 'Widulipura', NULL, NULL, NULL, NULL, NULL, '22032', 6.8952, 80.5088),
(1565, 20, 'Wijebahukanda', NULL, NULL, NULL, NULL, NULL, '22018', 7.0167, 80.6167),
(1566, 21, 'Attanakadawala', 'අත්තනගඩවල', NULL, NULL, NULL, NULL, '51235', 7.903734, 80.828104),
(1567, 21, 'Bakamuna', 'බකමූණ', NULL, NULL, NULL, NULL, '51250', 7.7833, 80.8167),
(1568, 21, 'Diyabeduma', 'දියබෙදුම', NULL, NULL, NULL, NULL, '51225', 7.89851, 80.898332),
(1569, 21, 'Elahera', 'ඇලහැර', NULL, NULL, NULL, NULL, '51258', 7.7244, 80.7883),
(1570, 21, 'Giritale', 'ගිරිතලේ', NULL, NULL, NULL, NULL, '51026', 7.9833, 80.9333),
(1571, 21, 'Hingurakdamana', NULL, NULL, NULL, NULL, NULL, '51408', 8.055896, 81.011875),
(1572, 21, 'Hingurakgoda', NULL, NULL, NULL, NULL, NULL, '51400', 8.036505, 80.948686),
(1573, 21, 'Jayanthipura', NULL, NULL, NULL, NULL, NULL, '51024', 8, 81),
(1574, 21, 'Kalingaela', NULL, NULL, NULL, NULL, NULL, '51002', 7.9583, 81.0417),
(1575, 21, 'Lakshauyana', NULL, NULL, NULL, NULL, NULL, '51006', 7.9583, 81.0417),
(1576, 21, 'Mankemi', NULL, NULL, NULL, NULL, NULL, '30442', 7.9833, 81.25),
(1577, 21, 'Minneriya', NULL, NULL, NULL, NULL, NULL, '51410', 8.036343, 80.903215),
(1578, 21, 'Onegama', NULL, NULL, NULL, NULL, NULL, '51004', 7.992203, 81.090758),
(1579, 21, 'Orubendi Siyambalawa', NULL, NULL, NULL, NULL, NULL, '51256', 7.751972, 80.812093),
(1580, 21, 'Palugasdamana', NULL, NULL, NULL, NULL, NULL, '51046', 8.0167, 81.0833),
(1581, 21, 'Panichankemi', NULL, NULL, NULL, NULL, NULL, '30444', 7.9833, 81.25),
(1582, 21, 'Polonnaruwa', NULL, NULL, NULL, NULL, NULL, '51000', 7.940295, 81.007138),
(1583, 21, 'Talpotha', NULL, NULL, NULL, NULL, NULL, '51044', 8.0167, 81.0833),
(1584, 21, 'Tambala', NULL, NULL, NULL, NULL, NULL, '51049', 8.0167, 81.0833),
(1585, 21, 'Unagalavehera', NULL, NULL, NULL, NULL, NULL, '51008', 8.001006, 80.995549),
(1586, 21, 'Wijayabapura', NULL, NULL, NULL, NULL, NULL, '51042', 8.0167, 81.0833),
(1587, 22, 'Adippala', NULL, NULL, NULL, NULL, NULL, '61012', 7.5833, 79.8417),
(1588, 22, 'Alutgama', 'අළුත්ගම', NULL, NULL, NULL, NULL, '12080', 7.7667, 79.9333),
(1589, 22, 'Alutwewa', 'අළුත්වැව', NULL, NULL, NULL, NULL, '51014', 7.8667, 79.95),
(1590, 22, 'Ambakandawila', 'අඹකඳවිල', NULL, NULL, NULL, NULL, '61024', 7.5333, 79.8),
(1591, 22, 'Anamaduwa', 'ආනමඩුව', NULL, NULL, NULL, NULL, '61500', 7.881625, 80.00353),
(1592, 22, 'Andigama', 'අඬිගම', NULL, NULL, NULL, NULL, '61508', 7.7775, 79.9528),
(1593, 22, 'Angunawila', 'අඟුණවිල', NULL, NULL, NULL, NULL, '61264', 7.7667, 79.85),
(1594, 22, 'Attawilluwa', 'අත්තවිල්ලුව', NULL, NULL, NULL, NULL, '61328', 7.4167, 79.8833),
(1595, 22, 'Bangadeniya', 'බංගදෙණිය', NULL, NULL, NULL, NULL, '61238', 7.619471, 79.809055),
(1596, 22, 'Baranankattuwa', 'බරණන්කට්ටුව', NULL, NULL, NULL, NULL, '61262', 7.803253, 79.872624),
(1597, 22, 'Battuluoya', 'බත්තුලුඔය', NULL, NULL, NULL, NULL, '61246', 7.734655, 79.817455),
(1598, 22, 'Bujjampola', 'බුජ්ජම්පොල', NULL, NULL, NULL, NULL, '61136', 7.3333, 79.9),
(1599, 22, 'Chilaw', 'හලාවත', NULL, NULL, NULL, NULL, '61000', 7.5758, 79.7953),
(1600, 22, 'Dalukana', 'දලුකන', NULL, NULL, NULL, NULL, '51092', 7.3167, 79.85),
(1601, 22, 'Dankotuwa', 'දංකොටුව', NULL, NULL, NULL, NULL, '61130', 7.300443, 79.88505),
(1602, 22, 'Dewagala', 'දේවගල', NULL, NULL, NULL, NULL, '51094', 7.3167, 79.85),
(1603, 22, 'Dummalasuriya', 'දුම්මලසූරිය', NULL, NULL, NULL, NULL, '60260', 7.4833, 79.9),
(1604, 22, 'Dunkannawa', 'දුන්කන්නාව', NULL, NULL, NULL, NULL, '61192', 7.4167, 79.9),
(1605, 22, 'Eluwankulama', 'එළුවන්කුලම', NULL, NULL, NULL, NULL, '61308', 8.332832, 79.859928),
(1606, 22, 'Ettale', 'ඇත්තලේ', NULL, NULL, NULL, NULL, '61343', 8.097416, 79.717306),
(1607, 22, 'Galamuna', 'ගලමුන', NULL, NULL, NULL, NULL, '51416', 7.464661, 79.872371),
(1608, 22, 'Galmuruwa', 'ගල්මුරුව', NULL, NULL, NULL, NULL, '61233', 7.501718, 79.895774),
(1609, 22, 'Hansayapalama', NULL, NULL, NULL, NULL, NULL, '51098', 7.3167, 79.85),
(1610, 22, 'Ihala Kottaramulla', NULL, NULL, NULL, NULL, NULL, '61154', 7.383069, 79.871755),
(1611, 22, 'Ilippadeniya', NULL, NULL, NULL, NULL, NULL, '61018', 7.567036, 79.826233),
(1612, 22, 'Inginimitiya', NULL, NULL, NULL, NULL, NULL, '61514', 7.964099, 80.112055),
(1613, 22, 'Ismailpuram', NULL, NULL, NULL, NULL, NULL, '61302', 8.0333, 79.8167),
(1614, 22, 'Jayasiripura', NULL, NULL, NULL, NULL, NULL, '51246', 7.6333, 79.8167),
(1615, 22, 'Kakkapalliya', NULL, NULL, NULL, NULL, NULL, '61236', 7.5333, 79.8267),
(1616, 22, 'Kalkudah', NULL, NULL, NULL, NULL, NULL, '30410', 8.1167, 79.7167),
(1617, 22, 'Kalladiya', NULL, NULL, NULL, NULL, NULL, '61534', 7.95, 79.9333),
(1618, 22, 'Kandakuliya', NULL, NULL, NULL, NULL, NULL, '61358', 7.98, 79.9569),
(1619, 22, 'Karathivu', NULL, NULL, NULL, NULL, NULL, '61307', 8.192511, 79.832662),
(1620, 22, 'Karawitagara', NULL, NULL, NULL, NULL, NULL, '61022', 7.572417, 79.86173),
(1621, 22, 'Karuwalagaswewa', NULL, NULL, NULL, NULL, NULL, '61314', 8.037625, 79.94267),
(1622, 22, 'Katuneriya', NULL, NULL, NULL, NULL, NULL, '61180', 7.3667, 79.8333),
(1623, 22, 'Koswatta', NULL, NULL, NULL, NULL, NULL, '61158', 7.3667, 79.9),
(1624, 22, 'Kottantivu', NULL, NULL, NULL, NULL, NULL, '61252', 7.85, 79.7833),
(1625, 22, 'Kottapitiya', NULL, NULL, NULL, NULL, NULL, '51244', 7.63568, 79.815394),
(1626, 22, 'Kottukachchiya', NULL, NULL, NULL, NULL, NULL, '61532', 7.938617, 79.954577),
(1627, 22, 'Kumarakattuwa', NULL, NULL, NULL, NULL, NULL, '61032', 7.661964, 79.886873),
(1628, 22, 'Kurinjanpitiya', NULL, NULL, NULL, NULL, NULL, '61356', 7.98, 79.9569),
(1629, 22, 'Kuruketiyawa', NULL, NULL, NULL, NULL, NULL, '61516', 8.0167, 80.05),
(1630, 22, 'Lunuwila', NULL, NULL, NULL, NULL, NULL, '61150', 7.350819, 79.85725),
(1631, 22, 'Madampe', NULL, NULL, NULL, NULL, NULL, '61230', 7.5, 79.8333),
(1632, 22, 'Madurankuliya', NULL, NULL, NULL, NULL, NULL, '61270', 7.896391, 79.836449),
(1633, 22, 'Mahakumbukkadawala', NULL, NULL, NULL, NULL, NULL, '61272', 7.85, 79.9),
(1634, 22, 'Mahauswewa', NULL, NULL, NULL, NULL, NULL, '61512', 7.9575, 80.0683),
(1635, 22, 'Mampitiya', NULL, NULL, NULL, NULL, NULL, '51090', 7.3167, 79.85),
(1636, 22, 'Mampuri', NULL, NULL, NULL, NULL, NULL, '61341', 7.9964, 79.7411),
(1637, 22, 'Mangalaeliya', NULL, NULL, NULL, NULL, NULL, '61266', 7.775, 79.85),
(1638, 22, 'Marawila', NULL, NULL, NULL, NULL, NULL, '61210', 7.4094, 79.8322),
(1639, 22, 'Mudalakkuliya', NULL, NULL, NULL, NULL, NULL, '61506', 7.799533, 79.977428),
(1640, 22, 'Mugunuwatawana', NULL, NULL, NULL, NULL, NULL, '61014', 7.58487, 79.854684),
(1641, 22, 'Mukkutoduwawa', NULL, NULL, NULL, NULL, NULL, '61274', 7.928236, 79.75648),
(1642, 22, 'Mundel', NULL, NULL, NULL, NULL, NULL, '61250', 7.7958, 79.8283),
(1643, 22, 'Muttibendiwila', NULL, NULL, NULL, NULL, NULL, '61195', 7.45, 79.8833),
(1644, 22, 'Nainamadama', NULL, NULL, NULL, NULL, NULL, '61120', 7.3714, 79.8837),
(1645, 22, 'Nalladarankattuwa', NULL, NULL, NULL, NULL, NULL, '61244', 7.689152, 79.844243),
(1646, 22, 'Nattandiya', NULL, NULL, NULL, NULL, NULL, '61190', 7.4086, 79.8683),
(1647, 22, 'Nawagattegama', NULL, NULL, NULL, NULL, NULL, '61520', 8, 80.1167),
(1648, 22, 'Nelumwewa', NULL, NULL, NULL, NULL, NULL, '51096', 7.3167, 79.85),
(1649, 22, 'Norachcholai', NULL, NULL, NULL, NULL, NULL, '61342', 7.9964, 79.7411),
(1650, 22, 'Pallama', NULL, NULL, NULL, NULL, NULL, '61040', 7.681225, 79.918239),
(1651, 22, 'Palliwasalturai', NULL, NULL, NULL, NULL, NULL, '61354', 7.98, 79.9569),
(1652, 22, 'Panirendawa', NULL, NULL, NULL, NULL, NULL, '61234', 7.542426, 79.886377),
(1653, 22, 'Parakramasamudraya', NULL, NULL, NULL, NULL, NULL, '51016', 7.8667, 79.95),
(1654, 22, 'Pothuwatawana', NULL, NULL, NULL, NULL, NULL, '61162', 7.4833, 79.9),
(1655, 22, 'Puttalam', NULL, NULL, NULL, NULL, NULL, '61300', 8.043613, 79.841209),
(1656, 22, 'Puttalam Cement Factory', NULL, NULL, NULL, NULL, NULL, '61326', 7.4167, 79.8833),
(1657, 22, 'Rajakadaluwa', NULL, NULL, NULL, NULL, NULL, '61242', 7.650515, 79.828283),
(1658, 22, 'Saliyawewa Junction', NULL, NULL, NULL, NULL, NULL, '61324', 7.4167, 79.8833),
(1659, 22, 'Serukele', NULL, NULL, NULL, NULL, NULL, '61042', 7.7333, 79.9167),
(1660, 22, 'Siyambalagashene', NULL, NULL, NULL, NULL, NULL, '61504', 7.8239, 79.978),
(1661, 22, 'Tabbowa', NULL, NULL, NULL, NULL, NULL, '61322', 7.4167, 79.8833),
(1662, 22, 'Talawila Church', NULL, NULL, NULL, NULL, NULL, '61344', 7.9964, 79.7411),
(1663, 22, 'Toduwawa', NULL, NULL, NULL, NULL, NULL, '61224', 7.4861, 79.8022),
(1664, 22, 'Udappuwa', NULL, NULL, NULL, NULL, NULL, '61004', 7.5758, 79.7953),
(1665, 22, 'Uridyawa', NULL, NULL, NULL, NULL, NULL, '61502', 7.8239, 79.978),
(1666, 22, 'Vanathawilluwa', NULL, NULL, NULL, NULL, NULL, '61306', 8.17001, 79.8461),
(1667, 22, 'Waikkal', NULL, NULL, NULL, NULL, NULL, '61110', 7.2833, 79.85),
(1668, 22, 'Watugahamulla', NULL, NULL, NULL, NULL, NULL, '61198', 7.4667, 79.9),
(1669, 22, 'Wennappuwa', NULL, NULL, NULL, NULL, NULL, '61170', 7.35048, 79.850112),
(1670, 22, 'Wijeyakatupotha', NULL, NULL, NULL, NULL, NULL, '61006', 7.5758, 79.7953),
(1671, 22, 'Wilpotha', NULL, NULL, NULL, NULL, NULL, '61008', 7.5758, 79.7953),
(1672, 22, 'Yodaela', NULL, NULL, NULL, NULL, NULL, '51422', 7.5833, 79.8667),
(1673, 22, 'Yogiyana', NULL, NULL, NULL, NULL, NULL, '61144', 7.286035, 79.924213),
(1674, 23, 'Akarella', 'අකරැල්ල', NULL, NULL, NULL, NULL, '70082', 6.59053, 80.644197),
(1675, 23, 'Amunumulla', 'අමුනුමුල්ල', NULL, NULL, NULL, NULL, '90204', 6.7333, 80.75),
(1676, 23, 'Atakalanpanna', 'අටකලන්පන්න', NULL, NULL, NULL, NULL, '70294', 6.5333, 80.6),
(1677, 23, 'Ayagama', 'අයගම', NULL, NULL, NULL, NULL, '70024', 6.63662, 80.317329),
(1678, 23, 'Balangoda', 'බලන්ගොඩ', NULL, NULL, NULL, NULL, '70100', 6.661743, 80.69371),
(1679, 23, 'Batatota', 'බටතොට', NULL, NULL, NULL, NULL, '70504', 6.8333, 80.3667),
(1680, 23, 'Beralapanathara', 'බෙරලපනතර', NULL, NULL, NULL, NULL, '81541', 6.4521, 80.4894),
(1681, 23, 'Bogahakumbura', 'බෝගහකුඹුර', NULL, NULL, NULL, NULL, '90354', 6.6833, 80.7667),
(1682, 23, 'Bolthumbe', 'බොල්තුඹෙ', NULL, NULL, NULL, NULL, '70131', 6.739114, 80.664956),
(1683, 23, 'Bomluwageaina', NULL, NULL, NULL, NULL, NULL, '70344', 6.4, 80.6333),
(1684, 23, 'Bowalagama', 'බෝවලගම', NULL, NULL, NULL, NULL, '82458', 6.3917, 80.6833),
(1685, 23, 'Bulutota', 'බුලුතොට', NULL, NULL, NULL, NULL, '70346', 6.4333, 80.65),
(1686, 23, 'Dambuluwana', 'දඹුලුවාන', NULL, NULL, NULL, NULL, '70019', 6.7167, 80.3333),
(1687, 23, 'Daugala', 'දවුගල', NULL, NULL, NULL, NULL, '70455', 6.4901, 80.4248),
(1688, 23, 'Dela', 'දෙල', NULL, NULL, NULL, NULL, '70042', 6.6258, 80.4486),
(1689, 23, 'Delwala', 'දෙල්වල', NULL, NULL, NULL, NULL, '70046', 6.513055, 80.473993),
(1690, 23, 'Dodampe', 'දොඩම්පෙ', NULL, NULL, NULL, NULL, '70017', 6.73603, 80.301105),
(1691, 23, 'Doloswalakanda', 'දොලොස්වලකන්ද', NULL, NULL, NULL, NULL, '70404', 6.55133, 80.470258),
(1692, 23, 'Dumbara Manana', 'දුම්බර මනන', NULL, NULL, NULL, NULL, '70495', 6.680322, 80.247485),
(1693, 23, 'Eheliyagoda', 'ඇහැළියගොඩ', NULL, NULL, NULL, NULL, '70600', 6.85, 80.2667),
(1694, 23, 'Ekamutugama', 'එකමුතුගම', NULL, NULL, NULL, NULL, '70254', 6.3406, 80.7804),
(1695, 23, 'Elapatha', 'ඇලපාත', NULL, NULL, NULL, NULL, '70032', 6.66081, 80.366828),
(1696, 23, 'Ellagawa', 'ඇල්ලගාව', NULL, NULL, NULL, NULL, '70492', 6.5687, 80.363),
(1697, 23, 'Ellaulla', '', NULL, NULL, NULL, NULL, '70552', 6.8583, 80.3083),
(1698, 23, 'Ellawala', 'ඇල්ලවල', NULL, NULL, NULL, NULL, '70606', 6.809945, 80.259547),
(1699, 23, 'Embilipitiya', 'ඇඹිලිපිටිය', NULL, NULL, NULL, NULL, '70200', 6.3439, 80.8489),
(1700, 23, 'Eratna', 'එරත්න', NULL, NULL, NULL, NULL, '70506', 6.7986, 80.3784),
(1701, 23, 'Erepola', 'එරෙපොල', NULL, NULL, NULL, NULL, '70602', 6.804277, 80.242773),
(1702, 23, 'Gabbela', 'ගබ්බෙල', NULL, NULL, NULL, NULL, '70156', 6.7167, 80.35),
(1703, 23, 'Gangeyaya', 'ගන්ගෙයාය', NULL, NULL, NULL, NULL, '70195', 6.7516, 80.5927),
(1704, 23, 'Gawaragiriya', 'ගවරගිරිය', NULL, NULL, NULL, NULL, '70026', 6.6422, 80.2667),
(1705, 23, 'Gillimale', 'ගිලීමලේ', NULL, NULL, NULL, NULL, '70002', 6.729, 80.4415),
(1706, 23, 'Godakawela', 'ගොඩකවැල', NULL, NULL, NULL, NULL, '70160', 6.505599, 80.647268),
(1707, 23, 'Gurubewilagama', 'ගුරුබෙවිලගම', NULL, NULL, NULL, NULL, '70136', 6.7, 80.5667),
(1708, 23, 'Halwinna', 'හල්වින්න', NULL, NULL, NULL, NULL, '70171', 6.6833, 80.7167),
(1709, 23, 'Handagiriya', 'හඳගිරිය', NULL, NULL, NULL, NULL, '70106', 6.562839, 80.780347),
(1710, 23, 'Hatangala', NULL, NULL, NULL, NULL, NULL, '70105', 6.532527, 80.739407),
(1711, 23, 'Hatarabage', NULL, NULL, NULL, NULL, NULL, '70108', 6.65, 80.75),
(1712, 23, 'Hewanakumbura', NULL, NULL, NULL, NULL, NULL, '90358', 6.6833, 80.7667),
(1713, 23, 'Hidellana', NULL, NULL, NULL, NULL, NULL, '70012', 6.7192, 80.3842),
(1714, 23, 'Hiramadagama', NULL, NULL, NULL, NULL, NULL, '70296', 6.533544, 80.60045),
(1715, 23, 'Horewelagoda', NULL, NULL, NULL, NULL, NULL, '82456', 6.3917, 80.6833),
(1716, 23, 'Ittakanda', NULL, NULL, NULL, NULL, NULL, '70342', 6.403532, 80.636458),
(1717, 23, 'Kahangama', NULL, NULL, NULL, NULL, NULL, '70016', 6.704217, 80.362927),
(1718, 23, 'Kahawatta', NULL, NULL, NULL, NULL, NULL, '70150', 6.708145, 80.303805),
(1719, 23, 'Kalawana', NULL, NULL, NULL, NULL, NULL, '70450', 6.531595, 80.407285),
(1720, 23, 'Kaltota', NULL, NULL, NULL, NULL, NULL, '70122', 6.6833, 80.6833),
(1721, 23, 'Kalubululanda', NULL, NULL, NULL, NULL, NULL, '90352', 6.6833, 80.7667),
(1722, 23, 'Kananke Bazaar', NULL, NULL, NULL, NULL, NULL, '80136', 6.7361, 80.4354),
(1723, 23, 'Kandepuhulpola', NULL, NULL, NULL, NULL, NULL, '90356', 6.6833, 80.7667),
(1724, 23, 'Karandana', NULL, NULL, NULL, NULL, NULL, '70488', 6.77254, 80.206883),
(1725, 23, 'Karangoda', NULL, NULL, NULL, NULL, NULL, '70018', 6.677224, 80.368723),
(1726, 23, 'Kella Junction', NULL, NULL, NULL, NULL, NULL, '70352', 6.4, 80.6833),
(1727, 23, 'Keppetipola', NULL, NULL, NULL, NULL, NULL, '90350', 6.6833, 80.7667),
(1728, 23, 'Kiriella', NULL, NULL, NULL, NULL, NULL, '70480', 6.753583, 80.265838),
(1729, 23, 'Kiriibbanwewa', NULL, NULL, NULL, NULL, NULL, '70252', 6.3406, 80.7804),
(1730, 23, 'Kolambageara', NULL, NULL, NULL, NULL, NULL, '70180', 6.7516, 80.5927),
(1731, 23, 'Kolombugama', NULL, NULL, NULL, NULL, NULL, '70403', 6.5667, 80.4833),
(1732, 23, 'Kolonna', NULL, NULL, NULL, NULL, NULL, '70350', 6.404095, 80.681552),
(1733, 23, 'Kudawa', NULL, NULL, NULL, NULL, NULL, '70005', 6.757336, 80.504485),
(1734, 23, 'Kuruwita', NULL, NULL, NULL, NULL, NULL, '70500', 6.7792, 80.3686),
(1735, 23, 'Lellopitiya', NULL, NULL, NULL, NULL, NULL, '70056', 6.655172, 80.471348),
(1736, 23, 'lmaduwa', NULL, NULL, NULL, NULL, NULL, '80130', 6.7361, 80.4354),
(1737, 23, 'lmbulpe', NULL, NULL, NULL, NULL, NULL, '70134', 6.7159, 80.6375),
(1738, 23, 'Mahagama Colony', NULL, NULL, NULL, NULL, NULL, '70256', 6.3406, 80.7804),
(1739, 23, 'Mahawalatenna', NULL, NULL, NULL, NULL, NULL, '70112', 6.5833, 80.75),
(1740, 23, 'Makandura Sabara', NULL, NULL, NULL, NULL, NULL, '70298', 6.5333, 80.6),
(1741, 23, 'Malwala Junction', NULL, NULL, NULL, NULL, NULL, '70001', 6.7, 80.4333),
(1742, 23, 'Malwatta', NULL, NULL, NULL, NULL, NULL, '32198', 6.65, 80.4167),
(1743, 23, 'Matuwagalagama', NULL, NULL, NULL, NULL, NULL, '70482', 6.7667, 80.2333),
(1744, 23, 'Medagalatur', NULL, NULL, NULL, NULL, NULL, '70021', 6.6414, 80.2882),
(1745, 23, 'Meddekanda', NULL, NULL, NULL, NULL, NULL, '70127', 6.6833, 80.6833),
(1746, 23, 'Minipura Dumbara', NULL, NULL, NULL, NULL, NULL, '70494', 6.5687, 80.363),
(1747, 23, 'Mitipola', NULL, NULL, NULL, NULL, NULL, '70604', 6.836923, 80.221949),
(1748, 23, 'Moragala Kirillapone', NULL, NULL, NULL, NULL, NULL, '81532', 6.8333, 80.3),
(1749, 23, 'Morahela', NULL, NULL, NULL, NULL, NULL, '70129', 6.679967, 80.691531),
(1750, 23, 'Mulendiyawala', NULL, NULL, NULL, NULL, NULL, '70212', 6.291657, 80.760239),
(1751, 23, 'Mulgama', NULL, NULL, NULL, NULL, NULL, '70117', 6.645942, 80.817832),
(1752, 23, 'Nawalakanda', NULL, NULL, NULL, NULL, NULL, '70469', 6.5167, 80.3333),
(1753, 23, 'NawinnaPinnakanda', NULL, NULL, NULL, NULL, NULL, '70165', 6.7168, 80.4999),
(1754, 23, 'Niralagama', NULL, NULL, NULL, NULL, NULL, '70038', 6.65, 80.3667),
(1755, 23, 'Nivitigala', NULL, NULL, NULL, NULL, NULL, '70400', 6.6, 80.4553),
(1756, 23, 'Omalpe', NULL, NULL, NULL, NULL, NULL, '70215', 6.327391, 80.694691),
(1757, 23, 'Opanayaka', NULL, NULL, NULL, NULL, NULL, '70080', 6.608359, 80.625134),
(1758, 23, 'Padalangala', NULL, NULL, NULL, NULL, NULL, '70230', 6.244961, 80.916029),
(1759, 23, 'Pallebedda', NULL, NULL, NULL, NULL, NULL, '70170', 6.45, 80.7333),
(1760, 23, 'Pallekanda', NULL, NULL, NULL, NULL, NULL, '82454', 6.6333, 80.6667),
(1761, 23, 'Pambagolla', NULL, NULL, NULL, NULL, NULL, '70133', 6.7333, 80.6833),
(1762, 23, 'Panamura', NULL, NULL, NULL, NULL, NULL, '70218', 6.351417, 80.776404),
(1763, 23, 'Panapola', NULL, NULL, NULL, NULL, NULL, '70461', 6.425337, 80.445421),
(1764, 23, 'Paragala', NULL, NULL, NULL, NULL, NULL, '81474', 6.601317, 80.343575),
(1765, 23, 'Parakaduwa', NULL, NULL, NULL, NULL, NULL, '70550', 6.825482, 80.299049),
(1766, 23, 'Pebotuwa', NULL, NULL, NULL, NULL, NULL, '70045', 6.540192, 80.452191),
(1767, 23, 'Pelmadulla', NULL, NULL, NULL, NULL, NULL, '70070', 6.620071, 80.542243),
(1768, 23, 'Pinnawala', NULL, NULL, NULL, NULL, NULL, '70130', 6.731251, 80.672146),
(1769, 23, 'Pothdeniya', NULL, NULL, NULL, NULL, NULL, '81538', 6.8333, 80.3),
(1770, 23, 'Rajawaka', NULL, NULL, NULL, NULL, NULL, '70116', 6.609347, 80.797987),
(1771, 23, 'Ranwala', NULL, NULL, NULL, NULL, NULL, '70162', 6.553121, 80.665495),
(1772, 23, 'Rassagala', NULL, NULL, NULL, NULL, NULL, '70135', 6.695227, 80.617304),
(1773, 23, 'Ratgama', NULL, NULL, NULL, NULL, NULL, '80260', 6.7333, 80.4833),
(1774, 23, 'Ratna Hangamuwa', NULL, NULL, NULL, NULL, NULL, '70036', 6.65, 80.3667),
(1775, 23, 'Ratnapura', NULL, NULL, NULL, NULL, NULL, '70000', 6.677603, 80.405592),
(1776, 23, 'Sewanagala', NULL, NULL, NULL, NULL, NULL, '70250', 6.3406, 80.7804),
(1777, 23, 'Sri Palabaddala', NULL, NULL, NULL, NULL, NULL, '70004', 6.800198, 80.476202),
(1778, 23, 'Sudagala', NULL, NULL, NULL, NULL, NULL, '70502', 6.7833, 80.4),
(1779, 23, 'Talakolahinna', NULL, NULL, NULL, NULL, NULL, '70101', 6.5844, 80.7332),
(1780, 23, 'Tanjantenna', NULL, NULL, NULL, NULL, NULL, '70118', 6.6361, 80.8536),
(1781, 23, 'Teppanawa', NULL, NULL, NULL, NULL, NULL, '70512', 6.75, 80.3167),
(1782, 23, 'Tunkama', NULL, NULL, NULL, NULL, NULL, '70205', 6.2833, 80.8833),
(1783, 23, 'Udakarawita', NULL, NULL, NULL, NULL, NULL, '70044', 6.7317, 80.4287),
(1784, 23, 'Udaniriella', NULL, NULL, NULL, NULL, NULL, '70034', 6.65, 80.3667),
(1785, 23, 'Udawalawe', NULL, NULL, NULL, NULL, NULL, '70190', 6.7516, 80.5927),
(1786, 23, 'Ullinduwawa', NULL, NULL, NULL, NULL, NULL, '70345', 6.367322, 80.631196),
(1787, 23, 'Veddagala', NULL, NULL, NULL, NULL, NULL, '70459', 6.45, 80.4333),
(1788, 23, 'Vijeriya', NULL, NULL, NULL, NULL, NULL, '70348', 6.4, 80.6333),
(1789, 23, 'Waleboda', NULL, NULL, NULL, NULL, NULL, '70138', 6.726367, 80.64106),
(1790, 23, 'Watapotha', NULL, NULL, NULL, NULL, NULL, '70408', 6.577958, 80.510709),
(1791, 23, 'Waturawa', NULL, NULL, NULL, NULL, NULL, '70456', 6.4833, 80.4333),
(1792, 23, 'Weligepola', NULL, NULL, NULL, NULL, NULL, '70104', 6.567212, 80.707078),
(1793, 23, 'Welipathayaya', NULL, NULL, NULL, NULL, NULL, '70124', 6.6833, 80.6833),
(1794, 23, 'Wikiliya', NULL, NULL, NULL, NULL, NULL, '70114', 6.6203, 80.7467),
(1795, 24, 'Agbopura', 'අග්බෝපුර', NULL, NULL, NULL, NULL, '31304', 8.330575, 80.97191),
(1796, 24, 'Buckmigama', 'බක්මීගම', NULL, NULL, NULL, NULL, '31028', 8.6667, 80.95),
(1797, 24, 'China Bay', 'චීන වරාය', NULL, NULL, NULL, NULL, '31050', 8.561664, 81.187386),
(1798, 24, 'Dehiwatte', 'දෙහිවත්ත', NULL, NULL, NULL, NULL, '31226', 8.4458, 81.2875),
(1799, 24, 'Echchilampattai', 'එච්චිලම්පට්ටෙයි', NULL, NULL, NULL, NULL, '31236', 8.4458, 81.2875),
(1800, 24, 'Galmetiyawa', 'ගල්මැටියාව', NULL, NULL, NULL, NULL, '31318', 8.3683, 81.0281),
(1801, 24, 'Gomarankadawala', 'ගෝමරන්කඩවල', NULL, NULL, NULL, NULL, '31026', 8.677731, 80.960417),
(1802, 24, 'Kaddaiparichchan', NULL, NULL, NULL, NULL, NULL, '31212', 8.459198, 81.278164),
(1803, 24, 'Kallar', NULL, NULL, NULL, NULL, NULL, '30250', 8.2833, 81.2667),
(1804, 24, 'Kanniya', NULL, NULL, NULL, NULL, NULL, '31032', 8.6333, 81.0167),
(1805, 24, 'Kantalai', NULL, NULL, NULL, NULL, NULL, '31300', 8.365483, 80.966897),
(1806, 24, 'Kantalai Sugar Factory', NULL, NULL, NULL, NULL, NULL, '31306', 8.3683, 81.0281),
(1807, 24, 'Kiliveddy', NULL, NULL, NULL, NULL, NULL, '31220', 8.354092, 81.275605);
INSERT INTO `country_cities` (`id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude`) VALUES
(1808, 24, 'Kinniya', NULL, NULL, NULL, NULL, NULL, '31100', 8.497717, 81.179214),
(1809, 24, 'Kuchchaveli', NULL, NULL, NULL, NULL, NULL, '31014', 8.792709, 81.036113),
(1810, 24, 'Kumburupiddy', NULL, NULL, NULL, NULL, NULL, '31012', 8.7333, 81.15),
(1811, 24, 'Kurinchakemy', NULL, NULL, NULL, NULL, NULL, '31112', 8.4989, 81.1897),
(1812, 24, 'Lankapatuna', NULL, NULL, NULL, NULL, NULL, '31234', 8.4458, 81.2875),
(1813, 24, 'Mahadivulwewa', NULL, NULL, NULL, NULL, NULL, '31036', 8.613863, 80.9518),
(1814, 24, 'Maharugiramam', NULL, NULL, NULL, NULL, NULL, '31106', 8.4989, 81.1897),
(1815, 24, 'Mallikativu', NULL, NULL, NULL, NULL, NULL, '31224', 8.4458, 81.2875),
(1816, 24, 'Mawadichenai', NULL, NULL, NULL, NULL, NULL, '31238', 8.4458, 81.2875),
(1817, 24, 'Mullipothana', NULL, NULL, NULL, NULL, NULL, '31312', 8.3683, 81.0281),
(1818, 24, 'Mutur', NULL, NULL, NULL, NULL, NULL, '31200', 8.45, 81.2667),
(1819, 24, 'Neelapola', NULL, NULL, NULL, NULL, NULL, '31228', 8.4458, 81.2875),
(1820, 24, 'Nilaveli', NULL, NULL, NULL, NULL, NULL, '31010', 8.658756, 81.148516),
(1821, 24, 'Pankulam', NULL, NULL, NULL, NULL, NULL, '31034', 8.6333, 81.0167),
(1822, 24, 'Pulmoddai', NULL, NULL, NULL, NULL, NULL, '50567', 8.9333, 80.9833),
(1823, 24, 'Rottawewa', NULL, NULL, NULL, NULL, NULL, '31038', 8.6333, 81.0167),
(1824, 24, 'Sampaltivu', NULL, NULL, NULL, NULL, NULL, '31006', 8.6167, 81.2),
(1825, 24, 'Sampoor', NULL, NULL, NULL, NULL, NULL, '31216', 8.493354, 81.284828),
(1826, 24, 'Serunuwara', NULL, NULL, NULL, NULL, NULL, '31232', 8.4458, 81.2875),
(1827, 24, 'Seruwila', NULL, NULL, NULL, NULL, NULL, '31260', 8.4458, 81.2875),
(1828, 24, 'Sirajnagar', NULL, NULL, NULL, NULL, NULL, '31314', 8.3683, 81.0281),
(1829, 24, 'Somapura', NULL, NULL, NULL, NULL, NULL, '31222', 8.4458, 81.2875),
(1830, 24, 'Tampalakamam', NULL, NULL, NULL, NULL, NULL, '31046', 8.4925, 81.0964),
(1831, 24, 'Thuraineelavanai', NULL, NULL, NULL, NULL, NULL, '30254', 8.2833, 81.2667),
(1832, 24, 'Tiriyayi', NULL, NULL, NULL, NULL, NULL, '31016', 8.7444, 81.15),
(1833, 24, 'Toppur', NULL, NULL, NULL, NULL, NULL, '31250', 8.4, 81.3167),
(1834, 24, 'Trincomalee', NULL, NULL, NULL, NULL, NULL, '31000', 8.5667, 81.2333),
(1835, 24, 'Wanela', NULL, NULL, NULL, NULL, NULL, '31308', 8.3683, 81.0281),
(1836, 25, 'Vavuniya', NULL, NULL, NULL, NULL, NULL, '43000', 8.758818, 80.493461),
(1837, 5, 'Colombo 1', 'කොළඹ 1', 'கொழும்பு 1', 'Fort', 'කොටුව', 'கோட்டை', '100', 6.925833, 79.841667),
(1838, 5, 'Colombo 3', 'කොළඹ 3', 'கொழும்பு 3', 'Colpetty', 'කොල්ලුපිටිය', 'கொள்ளுபிட்டி', '300', 6.900556, 79.853333),
(1839, 5, 'Colombo 4', 'කොළඹ 4', 'கொழும்பு 4', 'Bambalapitiya', 'බම්බලපිටිය', 'பம்பலப்பிட்டி', '400', 6.888889, 79.856667),
(1840, 5, 'Colombo 5', 'කොළඹ 5', 'கொழும்பு 5', 'Havelock Town', 'තිඹිරිගස්යාය', 'ஹெவ்லொக் நகரம்', '500', 6.879444, 79.865278),
(1841, 5, 'Colombo 7', 'කොළඹ 7', 'கொழும்பு 7', 'Cinnamon Gardens', 'කුරුඳු වත්ත', 'கறுவாத் தோட்டம்', '700', 6.906667, 79.863333),
(1842, 5, 'Colombo 9', 'කොළඹ 9', 'கொழும்பு 9', 'Dematagoda', 'දෙමටගොඩ', 'தெமட்டகொடை', '900', 6.93, 79.877778),
(1843, 5, 'Colombo 10', 'කොළඹ 10', 'கொழும்பு 10', 'Maradana', 'මරදාන', 'மருதானை', '1000', 6.928333, 79.864167),
(1844, 5, 'Colombo 11', 'කොළඹ 11', 'கொழும்பு 11', 'Pettah', 'පිට කොටුව', 'புறக் கோட்டை', '1100', 6.936667, 79.849722),
(1845, 5, 'Colombo 12', 'කොළඹ 12', 'கொழும்பு 12', 'Hulftsdorp', 'අලුත් කඩේ', 'புதுக்கடை', '1200', 6.9425, 79.858333),
(1846, 5, 'Colombo 14', 'කොළඹ 14', 'கொழும்பு 14', 'Grandpass', 'ග්‍රන්ඩ්පාස්', 'பாலத்துறை', '1400', 6.9475, 79.874722);

-- --------------------------------------------------------

--
-- Table structure for table `country_districts`
--

CREATE TABLE IF NOT EXISTS `country_districts` (
  `id` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `district_code` varchar(10) NOT NULL,
  `state_id` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country_districts`
--

INSERT INTO `country_districts` (`id`, `district_name`, `district_code`, `state_id`, `status`, `deleted`) VALUES
(1, 'Ampara', '', 7, 1, 0),
(2, 'Anuradhapura', '', 2, 1, 0),
(3, 'Badulla', '', 8, 1, 0),
(4, 'Batticaloa', '', 7, 1, 0),
(5, 'Colombo', '', 3, 1, 0),
(6, 'Galle', '', 9, 1, 0),
(7, 'Gampaha', '', 3, 1, 0),
(8, 'Hambantota', '', 9, 1, 0),
(9, 'Jaffna', '', 1, 1, 0),
(10, 'Kalutara', '', 3, 1, 0),
(11, 'Kandy', '', 5, 1, 0),
(12, 'Kegalle', '', 6, 1, 0),
(13, 'Kurunegala', '', 2, 1, 0),
(14, 'Mannar', '', 1, 1, 0),
(15, 'Matale', '', 5, 1, 0),
(16, 'Matara', '', 9, 1, 0),
(17, 'Monaragala', '', 8, 1, 0),
(19, 'Mullaitivu', '', 1, 1, 0),
(20, 'Nuwaraeliya', '', 5, 1, 0),
(21, 'Polonnaruwa', '', 2, 1, 0),
(22, 'Puttalam', '', 2, 1, 0),
(23, 'Ratnapura', '', 6, 1, 0),
(24, 'Trincomalee', '', 7, 1, 0),
(25, 'Vavuniya', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `country_states`
--

CREATE TABLE IF NOT EXISTS `country_states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(40) NOT NULL,
  `Short_name` varchar(20) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country_states`
--

INSERT INTO `country_states` (`id`, `state_name`, `Short_name`, `country_code`, `status`, `deleted`) VALUES
(1, 'Northern', 'NP', 'LK', 1, 0),
(2, 'Nort Western', 'NW', 'LK', 1, 0),
(3, 'Western', 'WP', 'LK', 1, 0),
(4, 'North Central', 'NC', 'LK', 1, 0),
(5, 'Central', 'CP', 'LK', 1, 0),
(6, 'Sabaragamuwa', 'SG', 'LK', 1, 0),
(7, 'Eastern', 'EP', 'LK', 1, 0),
(8, 'Uva', 'UP', 'LK', 1, 0),
(9, 'Southern', 'SP', 'LK', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `craftmans`
--

CREATE TABLE IF NOT EXISTS `craftmans` (
  `id` int(11) NOT NULL,
  `craftman_name` varchar(120) NOT NULL,
  `craftman_short_name` varchar(30) NOT NULL,
  `description` varchar(400) NOT NULL,
  `address` varchar(400) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `phone2` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bank_acc_number` varchar(50) NOT NULL,
  `bank_acc_name` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_acc_branch` varchar(100) NOT NULL,
  `commission_plan` int(5) NOT NULL,
  `commission_amount` double NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `craftmans`
--

INSERT INTO `craftmans` (`id`, `craftman_name`, `craftman_short_name`, `description`, `address`, `phone`, `phone2`, `email`, `bank_acc_number`, `bank_acc_name`, `bank_name`, `bank_acc_branch`, `commission_plan`, `commission_amount`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'V Pushparaja Natarajan', 'CRFN01', 'Jewellery maker Expertise', '123/4B, First Floor, Galle Road, Panadura.', '091588855855', '092588855822', 'natraja@nveloop.com', '1234567890141', 'A P Natrajan', 'Sampath Bank ', 'Moratuwa City', 0, 0, 1, '2018-09-13', 1, '2018-09-13', 1, 0, '0000-00-00', 0),
(2, 'Manikam Gopal', 'CRFN02', '', 'Dharga Town', '7995440889', '', '', '', '', '', '', 0, 0, 1, '2018-09-13', 1, '0000-00-00', 0, 1, '2018-09-13', 1),
(3, 'Sri Kanth', 'CRFN023', '', 'Dharga Town', '07975449878', '', '', '', '', '', '', 0, 0, 1, '2018-09-13', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes`
--

CREATE TABLE IF NOT EXISTS `credit_notes` (
  `id` int(11) NOT NULL,
  `cn_no` varchar(25) NOT NULL,
  `invoice_type` int(5) NOT NULL COMMENT '10:Sales_Invoice, 20:Supplier Invoice',
  `person_id` int(10) NOT NULL COMMENT 'Customer or Supplier',
  `cn_reference` varchar(50) NOT NULL,
  `payment_term_id` int(10) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `currency_value` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `credit_note_date` int(20) NOT NULL,
  `payment_settled` int(2) NOT NULL,
  `memo` varchar(500) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes_desc`
--

CREATE TABLE IF NOT EXISTS `credit_notes_desc` (
  `id` int(11) NOT NULL,
  `cn_id` int(20) NOT NULL,
  `invoice_no` varchar(25) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `item_desc` varchar(100) NOT NULL,
  `invoiced_date` int(25) NOT NULL,
  `units` double NOT NULL,
  `unit_price` double NOT NULL,
  `disc_tot_refund` double NOT NULL,
  `secondary_units` double NOT NULL,
  `uom_id` int(10) NOT NULL,
  `uom_id_2` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` float(15,8) NOT NULL,
  `value_rate` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_by` int(6) NOT NULL,
  `deleted_on` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `value_rate`, `status`, `date_modified`, `deleted`, `deleted_by`, `deleted_on`) VALUES
(1, 'Pound Sterling', 'GBP', '£', '', '2', 0.00510000, 196.0784, 1, '2017-05-12 07:46:38', 0, 0, '0000-00-00'),
(2, 'US Dollar', 'USD', '$', '', '2', 0.00650000, 153.8462, 1, '2017-05-12 07:46:38', 0, 0, '0000-00-00'),
(3, 'Euro', 'EUR', '', '€', '2', 0.00600000, 166.6667, 1, '2017-05-12 07:46:38', 0, 0, '0000-00-00'),
(4, 'Sri Lankan Rupee', 'LKR', 'Rs. ', '', '2', 1.00000000, 0, 1, '2017-05-12 18:01:29', 0, 0, '0000-00-00'),
(6, 'Indian Rupee', 'INR', '₹', '₹', '2', 0.28149191, 3.5525, 1, '0000-00-00 00:00:00', 1, 1, '2018-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `customer_type_id` int(5) NOT NULL,
  `description` varchar(300) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `nic_no` varchar(20) NOT NULL,
  `license_no` varchar(20) NOT NULL,
  `hotel_representative` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `website` varchar(100) NOT NULL,
  `commision_plan` int(10) NOT NULL COMMENT '1-percentage,2-Fixed Amount',
  `commission_value` double NOT NULL,
  `credit_limit` double NOT NULL,
  `customer_image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `short_name`, `customer_type_id`, `description`, `reg_no`, `nic_no`, `license_no`, `hotel_representative`, `address`, `city`, `postal_code`, `state`, `country`, `contact_person`, `phone`, `fax`, `email`, `website`, `commision_plan`, `commission_value`, `credit_limit`, `customer_image`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Nveloop POS Regular ', 'NV-1', 1, '', '', '', '', '', '123, Galle Road', 'Kaluthara South', '', '1', 'LK', '', '0715889595', '', '', '', 1, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'Faheem Farook', 'C-02', 6, '', '', '', '', '', 'No 18, Main Street', 'Kalutara', '', '', 'LK', '', '7474665655', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'Shfaras Nawas', 'C-03', 6, '', '', '', '', '', 'No 18, Main Street', 'Kalutara', '', '1', 'LK', '', '7474665655', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '2018-10-17', 1, 0, '0000-00-00', 0),
(4, 'N. A. Fernando', 'C-04', 1, '', '', '', '', '', '123, Alwis Place', 'Rathmalana', '', '', 'LK', '', '0115456996', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 'Nihal Senewiratna', 'C-05', 1, '', '', '', '', '', '145/55B, School Lane', 'Dehiwela', '', '', 'LK', '', '0115487558', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, 'Steve Roger', 'C-06', 1, '', '', '', '', '', '125A, Galle Road', 'Colombo 6', '', '', 'LK', '', '0112545585', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, 'Gallage Sampath', 'C-07', 1, '', '', '', '', '', '125, Main Street', 'Kaluthara North', '', '', 'LK', '', '0115458766', '', '', '', 0, 0, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_branches`
--

CREATE TABLE IF NOT EXISTS `customer_branches` (
  `id` int(11) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `branch_name` varchar(150) NOT NULL,
  `branch_short_name` varchar(50) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `sales_person_id` int(10) NOT NULL,
  `description` varchar(300) NOT NULL,
  `mailing_address` varchar(300) NOT NULL,
  `billing_address` varchar(300) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_branches`
--

INSERT INTO `customer_branches` (`id`, `customer_id`, `branch_name`, `branch_short_name`, `contact_person`, `sales_person_id`, `description`, `mailing_address`, `billing_address`, `phone`, `fax`, `email`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 1, 'Nveloop POS Regular ', 'NV-1', '', 0, '', '', '123, Galle Road Kaluthara South', '0715889595', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 2, 'Faheem Farook', 'C-02', '', 0, '', '', 'No 18, Main Street Kalutara', '7474665655', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 3, 'Shafras Nawas', 'C-03', 'Shafras Nawas', 1, '', 'No 18, Main Street Kalutara', 'No 18, Main Street Kalutara', '7474665655', '', '', 1, '2018-10-17', 1, '2018-10-17', 1, 0, '0000-00-00', 0),
(4, 4, 'N. A. Fernando', 'C-04', '', 0, '', '', '123, Alwis Place Rathmalana', '0115456996', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 5, 'Nihal Senewiratna', 'C-05', '', 0, '', '', '145/55B, School Lane Dehiwela', '0115487558', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, 6, 'Steve Roger', 'C-06', '', 0, '', '', '125A, Galle Road Colombo 6', '0112545585', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, 7, 'Gallage Sampath', 'C-07', '', 0, '', '', '125, Main Street Kaluthara North', '0115458766', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE IF NOT EXISTS `customer_type` (
  `id` int(11) NOT NULL,
  `customer_type_name` varchar(25) NOT NULL,
  `show_pos` int(2) NOT NULL DEFAULT '1',
  `addons_included` text NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`id`, `customer_type_name`, `show_pos`, `addons_included`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Default', 0, '', 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'POS Customers', 1, '["3","5"]', 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'Garage & Rent Car', 0, '', 0, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(4, 'POS Gold Customers', 1, '', 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 'Silver Customers', 1, '', 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, 'Staff', 1, '["6"]', 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, 'frdt', 1, '["1","3","5"]', 1, '0000-00-00', 0, '0000-00-00', 0, 1, '2018-10-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dropdown_list`
--

CREATE TABLE IF NOT EXISTS `dropdown_list` (
  `id` int(11) NOT NULL,
  `dropdown_id` int(100) NOT NULL,
  `dropdown_value` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `ri_value` varchar(100) NOT NULL DEFAULT '',
  `sg_value` varchar(100) NOT NULL DEFAULT '',
  `added_on` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dropdown_list`
--

INSERT INTO `dropdown_list` (`id`, `dropdown_id`, `dropdown_value`, `status`, `parent_id`, `ri_value`, `sg_value`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(28, 5, 'No Heat', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(27, 5, 'Heated', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(26, 4, 'Lotus', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(25, 4, 'Berberyn-BGL', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(15, 14, 'Selling Price', 1, NULL, '', '', '2017-10-20', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(16, 14, 'Whole Sale', 1, NULL, '', '', '2017-10-20', 1, '2018-07-03', 1, 0, '0000-00-00', 0),
(20, 15, 'QUOTATION', 1, NULL, '', '', '2017-11-09', 1, '2017-11-29', 1, 0, '0000-00-00', 0),
(23, 4, 'GRS', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(24, 4, 'Emteem - EGL', 1, NULL, '', '', '2018-06-09', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(22, 15, 'ESTIMATIMATION', 1, NULL, '', '', '2017-11-09', 1, '2017-11-29', 1, 0, '0000-00-00', 0),
(29, 16, 'Oval', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(30, 17, 'Red', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(31, 17, 'Vivid Red', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(32, 18, 'Sri Lankan', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(33, 17, 'Green', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(34, 17, 'Vivid Green', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(35, 16, 'Round', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(36, 16, 'Cushion', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(37, 17, 'Royal Blue', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(38, 17, 'Pinkish Red', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(39, 4, 'SSEF', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(40, 17, 'Yellow', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(41, 18, 'Madagascar', 1, NULL, '', '', '2018-10-07', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(42, 16, 'Radient', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(43, 18, 'Mozambique', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(44, 17, 'Pink', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(45, 17, 'white', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(46, 16, 'Cabochon', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(47, 18, 'Ethiopia', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(48, 16, 'Emerald', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(49, 16, 'Heart', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(50, 18, 'Myanmar', 1, NULL, '', '', '2018-10-08', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dropdown_list_names`
--

CREATE TABLE IF NOT EXISTS `dropdown_list_names` (
  `id` int(11) NOT NULL,
  `dropdown_list_name` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dropdown_list_names`
--

INSERT INTO `dropdown_list_names` (`id`, `dropdown_list_name`, `status`, `deleted`) VALUES
(4, 'Certification', 1, 0),
(5, 'Treatments', 1, 0),
(15, 'Quote or Estimation', 1, 0),
(14, 'Sales Type', 1, 0),
(16, 'Shape', 1, 0),
(17, 'Color', 1, 0),
(18, 'Origin', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_chart_classes`
--

CREATE TABLE IF NOT EXISTS `gl_chart_classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(20) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl_chart_classes`
--

INSERT INTO `gl_chart_classes` (`id`, `class_name`, `status`, `deleted`) VALUES
(1, 'Assets', 1, 0),
(2, 'Liabilitis', 1, 0),
(3, 'Income', 1, 0),
(4, 'Cost', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_chart_master`
--

CREATE TABLE IF NOT EXISTS `gl_chart_master` (
  `id` int(11) NOT NULL,
  `account_name` varchar(40) NOT NULL,
  `account_code` varchar(10) NOT NULL,
  `account_type_id` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl_chart_master`
--

INSERT INTO `gl_chart_master` (`id`, `account_name`, `account_code`, `account_type_id`, `status`, `deleted`) VALUES
(1, 'Cash Account', '1060', 1, 1, 0),
(2, 'Cash Account1', '1065', 1, 0, 0),
(3, 'Accounts Receivables', '1200', 1, 1, 0),
(5, 'Inventory', '1510', 2, 1, 0),
(9, 'Goods Received Clearing', '1550', 2, 1, 0),
(14, 'Accounts Payable', '2100', 4, 1, 0),
(21, 'Accrued Wages', '2210', 4, 1, 0),
(33, 'Bank Loans', '2620', 5, 1, 0),
(37, 'Sales', '4010', 8, 1, 0),
(43, 'Cost of Goods Sold - Retail', '5010', 10, 1, 0),
(48, 'Discounts Received', '5060', 10, 1, 0),
(64, 'Advertising & Promotions', '5615', 12, 1, 0),
(65, 'Bad Debts', '5620', 12, 1, 0),
(67, 'Insurance', '5685', 12, 1, 0),
(70, 'Rent', '5760', 12, 1, 0),
(71, 'Repair & Maintenance', '5765', 12, 1, 0),
(72, 'Telephone', '5780', 12, 1, 0),
(74, 'Utilities', '5790', 12, 1, 0),
(75, 'Work Shop SO', '1210', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_chart_types`
--

CREATE TABLE IF NOT EXISTS `gl_chart_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(25) NOT NULL,
  `class_id` int(2) NOT NULL,
  `paren_id` int(3) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl_chart_types`
--

INSERT INTO `gl_chart_types` (`id`, `type_name`, `class_id`, `paren_id`, `status`, `deleted`) VALUES
(1, 'Current Assets', 1, 0, 1, 0),
(2, 'Inventory Assets', 1, 0, 1, 0),
(3, 'Capital Assets', 1, 0, 1, 0),
(4, 'Current Liabilities', 2, 0, 1, 0),
(5, 'Long Term Liabilities', 2, 0, 1, 0),
(6, 'Share Capital', 2, 0, 1, 0),
(7, 'Retained Earnings', 2, 0, 1, 0),
(8, 'Sales Revenue', 3, 0, 1, 0),
(9, 'Other Revenue', 3, 0, 1, 0),
(10, 'Cost of Goods Sold', 4, 0, 1, 0),
(11, 'Payroll Expenses', 4, 0, 1, 0),
(12, 'General & Administration', 4, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_fiscal_year`
--

CREATE TABLE IF NOT EXISTS `gl_fiscal_year` (
  `id` int(11) NOT NULL,
  `begin` int(20) DEFAULT NULL,
  `end` int(20) DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gl_fiscal_year`
--

INSERT INTO `gl_fiscal_year` (`id`, `begin`, `end`, `closed`, `status`, `deleted`) VALUES
(1, 1522521000, 1553970600, 0, 1, 0),
(2, 1554057000, 1585593000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_quick_entries`
--

CREATE TABLE IF NOT EXISTS `gl_quick_entries` (
  `id` int(11) NOT NULL,
  `quick_entry_account_id` int(15) NOT NULL,
  `amount` double NOT NULL,
  `entry_date` int(20) NOT NULL,
  `fiscal_year_id` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl_quick_entry_accounts`
--

CREATE TABLE IF NOT EXISTS `gl_quick_entry_accounts` (
  `id` int(11) NOT NULL,
  `account_name` varchar(25) NOT NULL,
  `short_name` varchar(15) NOT NULL,
  `debit_gl_code` int(8) NOT NULL,
  `credit_gl_code` int(8) NOT NULL,
  `status` int(2) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl_quick_entry_accounts`
--

INSERT INTO `gl_quick_entry_accounts` (`id`, `account_name`, `short_name`, `debit_gl_code`, `credit_gl_code`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Telephone  Bill', 'TP', 5780, 1060, 1, '2018-08-25', 1, '2018-10-16', 1, 0, '2018-08-25', 1),
(2, 'Building Rent', 'BRENT', 5760, 1060, 1, '2018-08-25', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'Advertising Charges', 'ADS01', 5615, 1060, 1, '2018-08-25', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(4, 'Repair and Maintenence', 'REPAIR', 5765, 1060, 1, '2018-08-25', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 'Cash in ', 'CASHIN', 1060, 1200, 1, '2018-08-27', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_transections`
--

CREATE TABLE IF NOT EXISTS `gl_transections` (
  `id` int(11) NOT NULL,
  `person_type` int(5) NOT NULL COMMENT '10:customers,20:supplier,30:comsignee,40:Quick Entries',
  `person_id` int(10) NOT NULL,
  `trans_ref` int(30) NOT NULL,
  `trans_date` int(20) NOT NULL,
  `account` int(20) NOT NULL,
  `account_code` int(11) NOT NULL,
  `memo` varchar(30) NOT NULL,
  `amount` double NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `fiscal_year` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL,
  `deleted_by` int(5) NOT NULL,
  `deleted_on` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl_transections`
--

INSERT INTO `gl_transections` (`id`, `person_type`, `person_id`, `trans_ref`, `trans_date`, `account`, `account_code`, `memo`, `amount`, `currency_code`, `fiscal_year`, `status`, `deleted`, `deleted_by`, `deleted_on`) VALUES
(1, 10, 3, 1, 1539761836, 5, 1510, 'SALE_POS', -69840, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(2, 10, 3, 1, 1539761836, 3, 1200, 'SALE_POS', 69840, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(3, 10, 3, 1, 1539761836, 3, 1200, '', -69840, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(4, 10, 3, 1, 1539761836, 2, 1060, '', 69840, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(5, 11, 1, 1, 1539763124, 75, 1210, 'SALES ORDER', -342200, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(6, 11, 1, 1, 1539763124, 3, 1200, 'SALES ORDER', 342200, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(7, 11, 4, 2, 1539763332, 75, 1210, 'SALES ORDER', -179120, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(8, 11, 4, 2, 1539763332, 3, 1200, 'SALES ORDER', 179120, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(9, 11, 5, 3, 1539763647, 75, 1210, 'SALES ORDER', -471575, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(10, 11, 5, 3, 1539763647, 3, 1200, 'SALES ORDER', 471575, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(11, 11, 6, 4, 1539765952, 75, 1210, 'SALES ORDER', -130000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(12, 11, 6, 4, 1539765952, 3, 1200, 'SALES ORDER', 130000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(13, 11, 7, 5, 1539767343, 75, 1210, 'SALES ORDER', -252000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(14, 11, 7, 5, 1539767343, 3, 1200, 'SALES ORDER', 252000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(15, 11, 2, 6, 1539767498, 75, 1210, 'SALES ORDER', -411200, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(16, 11, 2, 6, 1539767498, 3, 1200, 'SALES ORDER', 411200, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(17, 11, 6, 7, 1539767664, 75, 1210, 'SALES ORDER', -135600, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(18, 11, 6, 7, 1539767664, 3, 1200, 'SALES ORDER', 135600, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(19, 11, 2, 8, 1539767743, 75, 1210, 'SALES ORDER', -132000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(20, 11, 2, 8, 1539767743, 3, 1200, 'SALES ORDER', 132000, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(21, 20, 1, 3, 1539770170, 5, 1510, 'CM RECEIVE', 630998, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(22, 20, 1, 3, 1539770170, 14, 2100, '', -630998, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(23, 20, 1, 3, 1539770170, 14, 2100, '', 630998, 'LKR', 1, 1, 0, 0, '0000-00-00'),
(24, 20, 1, 3, 1539770170, 2, 1060, '', -630998, 'LKR', 1, 1, 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_location`
--

CREATE TABLE IF NOT EXISTS `inventory_location` (
  `id` int(11) NOT NULL,
  `location_name` varchar(30) NOT NULL,
  `location_code` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_location`
--

INSERT INTO `inventory_location` (`id`, `location_name`, `location_code`, `description`, `contact_person`, `address`, `phone`, `phone2`, `email`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Kaluthar Head Office', 'KHO', '', 'Faheem Farook', 'No 18, Main Street, Kaluthara South', '0754545664', '', 'faheem@gmail.com', 1, '2018-10-17', 1, '2018-10-17', 1, 0, '0000-00-00', 0),
(2, 'Colombo Showroom', 'CMBSR', '', 'Vafran Ahamed', '125/5B, Unity Plaza, Galle Road,Colombo 04', '011123456789', '', '', 1, '2018-10-17', 1, '2018-10-17', 1, 0, '0000-00-00', 0),
(3, 'Beiging Showroom', 'BJNSR', '', 'Shafras Nawas', '123. Xuansue Avenue, Morata,Beiging, China', '+3255566556', '', '', 1, '2018-10-17', 1, '2018-10-17', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_location_transfer`
--

CREATE TABLE IF NOT EXISTS `inventory_location_transfer` (
  `id` int(11) NOT NULL,
  `from_location_id` int(15) NOT NULL,
  `to_location_id` int(15) NOT NULL,
  `transfer_date` int(20) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_location_transfer_desc`
--

CREATE TABLE IF NOT EXISTS `inventory_location_transfer_desc` (
  `id` int(11) NOT NULL,
  `transfer_id` int(15) NOT NULL,
  `item_id` int(15) NOT NULL,
  `item_description` varchar(60) NOT NULL,
  `item_quantity` double NOT NULL,
  `item_quantity_uom_id` int(10) NOT NULL,
  `item_quantity_2` double NOT NULL,
  `item_quantity_uom_id_2` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(25) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `invoice_date` int(20) NOT NULL,
  `invoiced` int(5) NOT NULL,
  `so_id` int(20) NOT NULL,
  `cr_id` int(15) NOT NULL,
  `invoice_type_id` int(5) NOT NULL COMMENT '1:Direct,2:Order,3:Reserved',
  `consignee_id` int(15) NOT NULL,
  `sales_type_id` int(10) NOT NULL DEFAULT '0',
  `discount_type` int(5) NOT NULL COMMENT '1:percentage,2:fixed amount',
  `discount_value` double NOT NULL,
  `payement_term_id` int(5) NOT NULL,
  `currency_code` varchar(20) NOT NULL DEFAULT 'LKR',
  `currency_value` double NOT NULL,
  `payment_settled` int(5) NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `customer_id`, `reference`, `comments`, `invoice_date`, `invoiced`, `so_id`, `cr_id`, `invoice_type_id`, `consignee_id`, `sales_type_id`, `discount_type`, `discount_value`, `payement_term_id`, `currency_code`, `currency_value`, `payment_settled`, `location_id`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'NI10180000001', 3, '', '', 1539714600, 1, 0, 0, 1, 0, 15, 0, 0, 1, 'LKR', 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_addons`
--

CREATE TABLE IF NOT EXISTS `invoice_addons` (
  `id` int(11) NOT NULL,
  `invoice_id` int(20) NOT NULL,
  `addon_id` int(20) NOT NULL,
  `addon_amount` double NOT NULL,
  `addon_info` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_addons`
--

INSERT INTO `invoice_addons` (`id`, `invoice_id`, `addon_id`, `addon_amount`, `addon_info`, `status`, `deleted`) VALUES
(1, 1, 6, -46560, '[{"id":"6","addon_name":"Staff Discount","addon_type":"2","calculation_type":"2","calculation_included":"[\\"1\\",\\"2\\"]","calculation_included_addons":"","addon_value":"40","currency_code":"LKR","description":"Discount for resort and shop staff","active_from":"1514745000","active_to":"1546194600","ignore_end_date":"1","status":"1","added_on":"2018-10-09","added_by":"1","updated_on":"2018-10-09","updated_by":"1","deleted":"0","deleted_on":"0000-00-00","deleted_by":"0"}]', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_description`
--

CREATE TABLE IF NOT EXISTS `invoice_description` (
  `id` int(11) NOT NULL,
  `invoice_id` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `item_quantity` double(20,3) NOT NULL,
  `item_quantity_2` double NOT NULL,
  `item_quantity_uom_id` int(10) NOT NULL,
  `item_quantity_uom_id_2` int(10) NOT NULL,
  `unit_price` double NOT NULL,
  `discount_persent` double NOT NULL,
  `discount_fixed` double NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_description`
--

INSERT INTO `invoice_description` (`id`, `invoice_id`, `item_id`, `item_description`, `item_quantity`, `item_quantity_2`, `item_quantity_uom_id`, `item_quantity_uom_id_2`, `unit_price`, `discount_persent`, `discount_fixed`, `location_id`, `status`, `deleted`) VALUES
(1, 1, 15, 'Silver Ring', 11.000, 1, 3, 1, 3600, 0, 0, 1, 1, 0),
(2, 1, 10, 'Earing Dangling', 8.000, 1, 3, 1, 9600, 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_temp`
--

CREATE TABLE IF NOT EXISTS `invoice_temp` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `temp_invoice_no` varchar(20) NOT NULL,
  `item_data` text NOT NULL,
  `customer_id` int(10) NOT NULL,
  `temp_invoice_status` int(5) NOT NULL COMMENT '0:open, 1:paused,2:reserved',
  `payments` text NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_type`
--

CREATE TABLE IF NOT EXISTS `invoice_type` (
  `id` int(11) NOT NULL,
  `invoice_type_name` varchar(20) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_type`
--

INSERT INTO `invoice_type` (`id`, `invoice_type_name`, `status`, `deleted`) VALUES
(1, 'DIRECT', 1, 0),
(2, 'ORDER', 1, 0),
(3, 'RESERVE', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `item_name` varchar(70) NOT NULL,
  `description` text NOT NULL,
  `item_category_id` int(10) NOT NULL,
  `certification_no` varchar(100) NOT NULL,
  `certification` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `treatment` varchar(200) NOT NULL,
  `shape` int(11) NOT NULL,
  `origin` int(11) NOT NULL,
  `item_type_id` int(5) NOT NULL COMMENT '1-purchased, 2-service, 3-manfactured,4-catelog_item',
  `addon_type_id` int(5) NOT NULL,
  `item_uom_id` int(5) NOT NULL,
  `item_uom_id_2` int(5) NOT NULL,
  `sales_excluded` int(5) NOT NULL,
  `purchases_excluded` int(5) NOT NULL,
  `purch_inv_ref` int(12) NOT NULL DEFAULT '0',
  `cost_material` double NOT NULL,
  `cost_stone` double NOT NULL,
  `cost_craftman` double NOT NULL,
  `image` text NOT NULL,
  `images` text NOT NULL,
  `videos` text NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `item_name`, `description`, `item_category_id`, `certification_no`, `certification`, `color`, `treatment`, `shape`, `origin`, `item_type_id`, `addon_type_id`, `item_uom_id`, `item_uom_id_2`, `sales_excluded`, `purchases_excluded`, `purch_inv_ref`, `cost_material`, `cost_stone`, `cost_craftman`, `image`, `images`, `videos`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, '100001', 'Multystone Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR1.jpg', '["BR1.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, '100002', 'Colored Stone Bracelets', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR2.jpg', '["BR2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, '100003', 'NJ Bracelets', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR3.jpg', '["BR3.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(4, '100004', 'Emerald Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR4.jpg', '["BR4.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, '100005', 'Ligghty Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR5.jpg', '["BR5.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, '100006', 'Bracelet Ocean look', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR6.jpg', '["BR6.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, '100007', 'Bracelet Charm', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR8.jpg', '["BR8.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(8, '100008', 'Earing Yellow ', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED7.jpg', '["ED7.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(9, '100009', 'Earing Moonstone', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED11.jpg', '["ED11.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(10, '100010', 'Earing Dangling', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED12.jpg', '["ED12.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(11, '100011', 'Stud', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES23.jpg', '["ES23.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(12, '100012', 'stud2', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES40.jpg', '["ES40.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(13, '100013', 'Stud Earing', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES53.jpg', '["ES53.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(14, '100014', 'Rose Gold Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND1.jpg', '["BAND1.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(15, '100015', 'Silver Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND9.jpg', '["BAND9.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(16, '100016', 'RoseGold Stoned Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND10.jpg', '["BAND10.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(17, '100017', 'Multystone ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR4.jpg', '["RSEMIPR4.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(18, '100018', 'Ring with Pair Stones', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR7.jpg', '["RSEMIPR7.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(19, '100019', 'Triple stone ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR9.jpg', '["RSEMIPR9.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(20, '100020', 'Triple stone ring White', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR10.jpg', '["RSEMIPR10.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(21, '100021', 'Two Stoned Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR11.jpg', '["RSEMIPR11.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(22, '100022', 'B Sapphire Rings', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSING1.jfif', '["RSING1.jfif"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(23, '100023', 'Emerald Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSING58.jpg', '["RSING58.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(24, '100024', 'Ruby Pendant', '', 1, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'facetzinspire-garnet-color-stone-pendant-medium_ab68bb970af094f459c677fc99811f3c.jpg', '["facetzinspire-garnet-color-stone-pendant-medium_ab68bb970af094f459c677fc99811f3c.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(25, '100025', 'Sapphire Pendant', '', 1, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'Siberian-Blue-Quartz-Magician-Stone-Pendant_379db3a9-deda-44a8-8030-8541787fa932_300x300.png', '["Siberian-Blue-Quartz-Magician-Stone-Pendant_379db3a9-deda-44a8-8030-8541787fa932_300x300.png"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(26, '100026', 'Heart Pendant', '', 1, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'facetzinspire-100-real-diamond-blue-color-stone-pendant-medium_51d73cd2999423514d74912d4bebbafd.jpg', '["facetzinspire-100-real-diamond-blue-color-stone-pendant-medium_51d73cd2999423514d74912d4bebbafd.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(27, '100027', 'Pendant Diomond', '', 1, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'c013483_1.jpg', '["c013483_1.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(28, '100028', 'Gold Bangle', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(29, '100029', 'Rose Gold Bangles', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(30, '100030', 'Tiny Bangle', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(31, '100031', 'Ruby Stoned Bangles', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(32, '100032', 'Emerald necklace', '', 2, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(33, '100033', 'gold necklace ', '', 2, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(34, '100034', 'box chain', '', 5, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(35, '100035', 'machine cut chain', '', 5, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(36, '100036', ' anklet belt  type', '', 10, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(37, '100037', 'gold bell anklet', '', 10, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(38, '100038', 'stone Cuff Links', '', 13, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(39, '100039', 'normal cufflinks', '', 13, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(40, '100040', 'flower brooch', '', 11, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(41, '100041', 'stone brooch', '', 11, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(42, '100042', 'white gold diamond rings', '', 9, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(43, '100043', 'gold flower diamond ring', '', 9, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(44, '100044', 'thumb ring diamond', '', 9, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '3.jpg', '["3.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(45, '100045', 'Crown', '', 12, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(46, '100046', 'puzzle ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '1.jpg', '[]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(47, '100047', 'classic ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, '2.jpg', '["2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(48, 'JWL-000001', 'Doublestone Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR1.jpg', '["BR1.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(49, 'JWL-000002', 'Charm Bracelets', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR2.jpg', '["BR2.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(50, 'JWL-000003', 'NJ21 Bracelets', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR3.jpg', '["BR3.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(51, 'JWL-000004', 'Pear shape Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR4.jpg', '["BR4.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(52, 'JWL-000005', 'Tiny Bracelet', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR5.jpg', '["BR5.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(53, 'JWL-000006', 'Bracelet V shaped', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR6.jpg', '["BR6.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(54, 'JWL-000007', 'Bracelet Charm Gold', '', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BR8.jpg', '["BR8.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(55, 'JWL-000008', 'Earing with Yellow Stone', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED7.jpg', '["ED7.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(56, 'JWL-000009', 'Earing Moonstone', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED11.jpg', '["ED11.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(57, 'JWL-000010', 'Earing Dangling RG', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ED12.jpg', '["ED12.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(58, 'JWL-000011', 'Stud td12', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES23.jpg', '["ES23.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(59, 'JWL-000012', 'stud td13', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES40.jpg', '["ES40.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(60, 'JWL-000013', 'Tiny Stud', '', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'ES53.jpg', '["ES53.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(61, 'JWL-000014', 'Rose Gold Stoned Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND1.jpg', '["BAND1.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(62, 'JWL-000015', 'Silver Groom Ring ', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND9.jpg', '["BAND9.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(63, 'JWL-000016', 'RoseGold Engagement Ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND10.jpg', '["BAND10.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(64, 'JWL-000017', 'Sapphire ring', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR4.jpg', '["RSEMIPR4.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(65, 'JWL-000018', 'Plane Ring Gold', '', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND9.jpg', '["BAND9.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(66, 'JWL-000019', 'Bangle 6.2 cm Plane', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'BAND10.jpg', '["BAND10.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(67, 'JWL-000020', 'Ruby Bangle Heart Shape', '', 8, '', '', '', '', 0, 0, 1, 0, 3, 1, 0, 1, 0, 0, 0, 0, 'RSEMIPR4.jpg', '["RSEMIPR4.jpg"]', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(68, 'NJ100001', 'Charm Bracelets', 'All Stones with Yellow Sapphires', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 1, 1, 0, 8000, 3500, 3500, '', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(69, 'NJ100002', 'NJ Bracelets', '22KT Gold ', 3, '', '', '', '', 0, 0, 1, 0, 3, 1, 1, 1, 0, 5000, 0, 3000, '', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(70, 'NJ100003', 'Two Stoned Ring', 'Need to attached Pink Stones', 6, '', '', '', '', 0, 0, 1, 0, 3, 1, 1, 1, 0, 5000, 1500, 1000, '', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(71, 'NJ100004', 'box chain', 'With Zig Zag Pattern Cat9192', 5, '', '', '', '', 0, 0, 1, 0, 3, 1, 1, 1, 0, 7000, 0, 2500, '', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(72, 'NJ100005', 'Earing Yellow ', 'Earing with saaphire stone', 4, '', '', '', '', 0, 0, 1, 0, 3, 1, 1, 1, 0, 10000, 3200, 2500, '', '', '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE IF NOT EXISTS `item_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `category_code` varchar(15) NOT NULL,
  `item_type_id` int(5) NOT NULL COMMENT '1-purchased, 2-service, 3-manfactured',
  `is_gem` int(2) NOT NULL,
  `parent_cat_id` int(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `item_uom_id` int(10) NOT NULL,
  `item_uom_id_2` int(5) NOT NULL,
  `addon_type_id` int(10) NOT NULL,
  `sales_excluded` int(5) NOT NULL,
  `purchases_excluded` int(5) NOT NULL,
  `cat_image` varchar(800) NOT NULL,
  `show_pos` int(2) NOT NULL,
  `order_by` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `category_name`, `category_code`, `item_type_id`, `is_gem`, `parent_cat_id`, `description`, `item_uom_id`, `item_uom_id_2`, `addon_type_id`, `sales_excluded`, `purchases_excluded`, `cat_image`, `show_pos`, `order_by`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Pendent', '', 1, 0, 0, 'Pendent all', 3, 1, 0, 0, 0, '1 (3).jpg', 1, 6, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(2, 'Necklace', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '10.jpg', 1, 5, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(3, 'Bracelets', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '3.jpg', 1, 8, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(4, 'Earings', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '2.jpg', 1, 7, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(5, 'Chains', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '4.jpg', 1, 9, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(6, 'Rings', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '13.jpg', 1, 10, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(7, 'Engagement Rings', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '7.jpg', 1, 10, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(8, 'Bangle', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '5.jpg', 1, 11, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(9, 'Diamond Jewelleries', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '8.jpg', 1, 12, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(10, 'Anklet', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '9.jpg', 1, 15, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(11, 'Brooch', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '6.jpg', 1, 99, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(12, 'Crown', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '11.jpg', 1, 99, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(13, 'Cuff Links', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '14.jpg', 1, 99, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(14, 'Other', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '12.jpg', 1, 14, 1, '2018-08-11', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(15, 'Gold Chains', '', 1, 0, 0, '', 3, 1, 0, 0, 0, '', 0, 99, 1, '2018-08-13', 1, '2018-10-12', 1, 0, '0000-00-00', 0),
(16, 'Gold Biscuts', 'GBISC', 1, 0, 0, '', 3, 2, 0, 0, 0, 'gold_niscuit.jpg', 0, 99, 1, '2018-09-04', 1, '2018-10-12', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_cat_links`
--

CREATE TABLE IF NOT EXISTS `item_cat_links` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_prices`
--

CREATE TABLE IF NOT EXISTS `item_prices` (
  `id` int(11) NOT NULL,
  `item_id` int(15) NOT NULL,
  `item_price_type` double NOT NULL COMMENT '1-purchasing price, 2- sales_price, 3-standard_price',
  `price_amount` double NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `sales_type_id` int(10) NOT NULL COMMENT 'temp used dropdown_list table',
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `supplier_unit` varchar(25) NOT NULL,
  `supplier_unit_conversation` int(11) NOT NULL,
  `note` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_prices`
--

INSERT INTO `item_prices` (`id`, `item_id`, `item_price_type`, `price_amount`, `currency_code`, `sales_type_id`, `supplier_id`, `supplier_unit`, `supplier_unit_conversation`, `note`, `status`, `deleted`) VALUES
(1, 1, 1, 8800, 'LKR', 0, 1, '', 1, '', 1, 0),
(2, 1, 2, 11000, 'LKR', 15, 0, '', 0, '', 1, 0),
(3, 2, 1, 11600, 'LKR', 0, 1, '', 1, '', 1, 0),
(4, 2, 2, 14500, 'LKR', 15, 0, '', 0, '', 1, 0),
(5, 3, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(6, 3, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(7, 4, 1, 16000, 'LKR', 0, 1, '', 1, '', 1, 0),
(8, 4, 2, 20000, 'LKR', 15, 0, '', 0, '', 1, 0),
(9, 5, 1, 9840, 'LKR', 0, 1, '', 1, '', 1, 0),
(10, 5, 2, 12300, 'LKR', 15, 0, '', 0, '', 1, 0),
(11, 6, 1, 12800, 'LKR', 0, 1, '', 1, '', 1, 0),
(12, 6, 2, 16000, 'LKR', 15, 0, '', 0, '', 1, 0),
(13, 7, 1, 10800, 'LKR', 0, 1, '', 1, '', 1, 0),
(14, 7, 2, 13500, 'LKR', 15, 0, '', 0, '', 1, 0),
(15, 8, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(16, 8, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(17, 9, 1, 14400, 'LKR', 0, 1, '', 1, '', 1, 0),
(18, 9, 2, 18000, 'LKR', 15, 0, '', 0, '', 1, 0),
(19, 10, 1, 7680, 'LKR', 0, 1, '', 1, '', 1, 0),
(20, 10, 2, 9600, 'LKR', 15, 0, '', 0, '', 1, 0),
(21, 11, 1, 14400, 'LKR', 0, 1, '', 1, '', 1, 0),
(22, 11, 2, 18000, 'LKR', 15, 0, '', 0, '', 1, 0),
(23, 12, 1, 13600, 'LKR', 0, 1, '', 1, '', 1, 0),
(24, 12, 2, 17000, 'LKR', 15, 0, '', 0, '', 1, 0),
(25, 13, 1, 12480, 'LKR', 0, 1, '', 1, '', 1, 0),
(26, 13, 2, 15600, 'LKR', 15, 0, '', 0, '', 1, 0),
(27, 14, 1, 25600, 'LKR', 0, 1, '', 1, '', 1, 0),
(28, 14, 2, 32000, 'LKR', 15, 0, '', 0, '', 1, 0),
(29, 15, 1, 2880, 'LKR', 0, 1, '', 1, '', 1, 0),
(30, 15, 2, 3600, 'LKR', 15, 0, '', 0, '', 1, 0),
(31, 16, 1, 11600, 'LKR', 0, 1, '', 1, '', 1, 0),
(32, 16, 2, 14500, 'LKR', 15, 0, '', 0, '', 1, 0),
(33, 17, 1, 10320, 'LKR', 0, 1, '', 1, '', 1, 0),
(34, 17, 2, 12900, 'LKR', 15, 0, '', 0, '', 1, 0),
(35, 18, 1, 16000, 'LKR', 0, 1, '', 1, '', 1, 0),
(36, 18, 2, 20000, 'LKR', 15, 0, '', 0, '', 1, 0),
(37, 19, 1, 6880, 'LKR', 0, 1, '', 1, '', 1, 0),
(38, 19, 2, 8600, 'LKR', 15, 0, '', 0, '', 1, 0),
(39, 20, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(40, 20, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(41, 21, 1, 2080, 'LKR', 0, 1, '', 1, '', 1, 0),
(42, 21, 2, 2600, 'LKR', 15, 0, '', 0, '', 1, 0),
(43, 22, 1, 3360, 'LKR', 0, 1, '', 1, '', 1, 0),
(44, 22, 2, 4200, 'LKR', 15, 0, '', 0, '', 1, 0),
(45, 23, 1, 3200, 'LKR', 0, 1, '', 1, '', 1, 0),
(46, 23, 2, 4000, 'LKR', 15, 0, '', 0, '', 1, 0),
(47, 24, 1, 6400, 'LKR', 0, 1, '', 1, '', 1, 0),
(48, 24, 2, 8000, 'LKR', 15, 0, '', 0, '', 1, 0),
(49, 25, 1, 4960, 'LKR', 0, 1, '', 1, '', 1, 0),
(50, 25, 2, 6200, 'LKR', 15, 0, '', 0, '', 1, 0),
(51, 26, 1, 7600, 'LKR', 0, 1, '', 1, '', 1, 0),
(52, 26, 2, 9500, 'LKR', 15, 0, '', 0, '', 1, 0),
(53, 27, 1, 5600, 'LKR', 0, 1, '', 1, '', 1, 0),
(54, 27, 2, 7000, 'LKR', 15, 0, '', 0, '', 1, 0),
(55, 28, 1, 7200, 'LKR', 0, 1, '', 1, '', 1, 0),
(56, 28, 2, 9000, 'LKR', 15, 0, '', 0, '', 1, 0),
(57, 29, 1, 6280, 'LKR', 0, 1, '', 1, '', 1, 0),
(58, 29, 2, 7850, 'LKR', 15, 0, '', 0, '', 1, 0),
(59, 30, 1, 2800, 'LKR', 0, 1, '', 1, '', 1, 0),
(60, 30, 2, 3500, 'LKR', 15, 0, '', 0, '', 1, 0),
(61, 31, 1, 14240, 'LKR', 0, 1, '', 1, '', 1, 0),
(62, 31, 2, 17800, 'LKR', 15, 0, '', 0, '', 1, 0),
(63, 32, 1, 11200, 'LKR', 0, 1, '', 1, '', 1, 0),
(64, 32, 2, 14000, 'LKR', 15, 0, '', 0, '', 1, 0),
(65, 33, 1, 5600, 'LKR', 0, 1, '', 1, '', 1, 0),
(66, 33, 2, 7000, 'LKR', 15, 0, '', 0, '', 1, 0),
(67, 34, 1, 8000, 'LKR', 0, 1, '', 1, '', 1, 0),
(68, 34, 2, 10000, 'LKR', 15, 0, '', 0, '', 1, 0),
(69, 35, 1, 11200, 'LKR', 0, 1, '', 1, '', 1, 0),
(70, 35, 2, 14000, 'LKR', 15, 0, '', 0, '', 1, 0),
(71, 36, 1, 14400, 'LKR', 0, 1, '', 1, '', 1, 0),
(72, 36, 2, 18000, 'LKR', 15, 0, '', 0, '', 1, 0),
(73, 37, 1, 10400, 'LKR', 0, 1, '', 1, '', 1, 0),
(74, 37, 2, 13000, 'LKR', 15, 0, '', 0, '', 1, 0),
(75, 38, 1, 20000, 'LKR', 0, 1, '', 1, '', 1, 0),
(76, 38, 2, 25000, 'LKR', 15, 0, '', 0, '', 1, 0),
(77, 39, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(78, 39, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(79, 40, 1, 8000, 'LKR', 0, 1, '', 1, '', 1, 0),
(80, 40, 2, 10000, 'LKR', 15, 0, '', 0, '', 1, 0),
(81, 41, 1, 6000, 'LKR', 0, 1, '', 1, '', 1, 0),
(82, 41, 2, 7500, 'LKR', 15, 0, '', 0, '', 1, 0),
(83, 42, 1, 20000, 'LKR', 0, 1, '', 1, '', 1, 0),
(84, 42, 2, 25000, 'LKR', 15, 0, '', 0, '', 1, 0),
(85, 43, 1, 15200, 'LKR', 0, 1, '', 1, '', 1, 0),
(86, 43, 2, 19000, 'LKR', 15, 0, '', 0, '', 1, 0),
(87, 44, 1, 14000, 'LKR', 0, 1, '', 1, '', 1, 0),
(88, 44, 2, 17500, 'LKR', 15, 0, '', 0, '', 1, 0),
(89, 45, 1, 16000, 'LKR', 0, 1, '', 1, '', 1, 0),
(90, 45, 2, 20000, 'LKR', 15, 0, '', 0, '', 1, 0),
(91, 46, 1, 5760, 'LKR', 0, 1, '', 1, '', 1, 0),
(92, 46, 2, 7200, 'LKR', 15, 0, '', 0, '', 1, 0),
(93, 47, 1, 3600, 'LKR', 0, 1, '', 1, '', 1, 0),
(94, 47, 2, 4500, 'LKR', 15, 0, '', 0, '', 1, 0),
(95, 48, 1, 8800, 'LKR', 0, 1, '', 1, '', 1, 0),
(96, 48, 2, 11000, 'LKR', 15, 0, '', 0, '', 1, 0),
(97, 49, 1, 11600, 'LKR', 0, 1, '', 1, '', 1, 0),
(98, 49, 2, 14500, 'LKR', 15, 0, '', 0, '', 1, 0),
(99, 50, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(100, 50, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(101, 51, 1, 16000, 'LKR', 0, 1, '', 1, '', 1, 0),
(102, 51, 2, 20000, 'LKR', 15, 0, '', 0, '', 1, 0),
(103, 52, 1, 9840, 'LKR', 0, 1, '', 1, '', 1, 0),
(104, 52, 2, 12300, 'LKR', 15, 0, '', 0, '', 1, 0),
(105, 53, 1, 12800, 'LKR', 0, 1, '', 1, '', 1, 0),
(106, 53, 2, 16000, 'LKR', 15, 0, '', 0, '', 1, 0),
(107, 54, 1, 10800, 'LKR', 0, 1, '', 1, '', 1, 0),
(108, 54, 2, 13500, 'LKR', 15, 0, '', 0, '', 1, 0),
(109, 55, 1, 12000, 'LKR', 0, 1, '', 1, '', 1, 0),
(110, 55, 2, 15000, 'LKR', 15, 0, '', 0, '', 1, 0),
(111, 56, 1, 14400, 'LKR', 0, 1, '', 1, '', 1, 0),
(112, 56, 2, 18000, 'LKR', 15, 0, '', 0, '', 1, 0),
(113, 57, 1, 7680, 'LKR', 0, 1, '', 1, '', 1, 0),
(114, 57, 2, 9600, 'LKR', 15, 0, '', 0, '', 1, 0),
(115, 58, 1, 14400, 'LKR', 0, 1, '', 1, '', 1, 0),
(116, 58, 2, 18000, 'LKR', 15, 0, '', 0, '', 1, 0),
(117, 59, 1, 13600, 'LKR', 0, 1, '', 1, '', 1, 0),
(118, 59, 2, 17000, 'LKR', 15, 0, '', 0, '', 1, 0),
(119, 60, 1, 12480, 'LKR', 0, 1, '', 1, '', 1, 0),
(120, 60, 2, 15600, 'LKR', 15, 0, '', 0, '', 1, 0),
(121, 61, 1, 25600, 'LKR', 0, 1, '', 1, '', 1, 0),
(122, 61, 2, 32000, 'LKR', 15, 0, '', 0, '', 1, 0),
(123, 62, 1, 2880, 'LKR', 0, 1, '', 1, '', 1, 0),
(124, 62, 2, 3600, 'LKR', 15, 0, '', 0, '', 1, 0),
(125, 63, 1, 11600, 'LKR', 0, 1, '', 1, '', 1, 0),
(126, 63, 2, 14500, 'LKR', 15, 0, '', 0, '', 1, 0),
(127, 64, 1, 10320, 'LKR', 0, 1, '', 1, '', 1, 0),
(128, 64, 2, 12900, 'LKR', 15, 0, '', 0, '', 1, 0),
(129, 65, 1, 6280, 'LKR', 0, 1, '', 1, '', 1, 0),
(130, 65, 2, 7850, 'LKR', 15, 0, '', 0, '', 1, 0),
(131, 66, 1, 6560, 'LKR', 0, 1, '', 1, '', 1, 0),
(132, 66, 2, 8200, 'LKR', 15, 0, '', 0, '', 1, 0),
(133, 67, 1, 12640, 'LKR', 0, 1, '', 1, '', 1, 0),
(134, 67, 2, 15800, 'LKR', 15, 0, '', 0, '', 1, 0),
(135, 68, 1, 15000, 'LKR', 0, 1, 'g', 1, '', 1, 0),
(136, 69, 1, 8000, 'LKR', 0, 1, 'g', 1, '', 1, 0),
(137, 70, 1, 7500, 'LKR', 0, 1, 'g', 1, '', 1, 0),
(138, 71, 1, 9500, 'LKR', 0, 1, 'g', 1, '', 1, 0),
(139, 72, 1, 15700, 'LKR', 0, 1, 'g', 1, '', 1, 0),
(140, 68, 2, 16000, 'LKR', 15, 0, '', 0, '', 1, 0),
(141, 69, 2, 9500, 'LKR', 15, 0, '', 0, '', 1, 0),
(142, 70, 2, 8200, 'LKR', 15, 0, '', 0, '', 1, 0),
(143, 71, 2, 10500, 'LKR', 15, 0, '', 0, '', 1, 0),
(144, 72, 2, 16500, 'LKR', 15, 0, '', 0, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE IF NOT EXISTS `item_stock` (
  `id` int(20) NOT NULL,
  `location_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `units_available` double NOT NULL,
  `uom_id_2` int(10) NOT NULL,
  `units_available_2` double NOT NULL,
  `units_on_order` double NOT NULL,
  `units_on_order_2` double NOT NULL,
  `units_on_reserve` double NOT NULL,
  `units_on_reserve_2` double NOT NULL,
  `units_on_consignee` double NOT NULL,
  `units_on_consignee_2` double NOT NULL,
  `units_on_demand` double NOT NULL,
  `units_reorder_level` double NOT NULL,
  `partial_invoiced` int(2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`id`, `location_id`, `item_id`, `uom_id`, `units_available`, `uom_id_2`, `units_available_2`, `units_on_order`, `units_on_order_2`, `units_on_reserve`, `units_on_reserve_2`, `units_on_consignee`, `units_on_consignee_2`, `units_on_demand`, `units_reorder_level`, `partial_invoiced`, `status`, `deleted`) VALUES
(1, 1, 1, 3, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(2, 1, 2, 3, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(3, 1, 3, 3, 15, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(4, 1, 4, 3, 14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(5, 1, 5, 3, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(6, 1, 6, 3, 17, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(7, 1, 7, 3, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(8, 1, 8, 3, 14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(9, 1, 9, 3, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(10, 1, 10, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(11, 1, 11, 3, 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(12, 1, 12, 3, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(13, 1, 13, 3, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(14, 1, 14, 3, 20, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(15, 1, 15, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(16, 1, 16, 3, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(17, 1, 17, 3, 77, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(18, 1, 18, 3, 50, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(19, 1, 19, 3, 25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(20, 1, 20, 3, 21, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(21, 1, 21, 3, 22, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(22, 1, 22, 3, 54, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(23, 1, 23, 3, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(24, 1, 24, 3, 45, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(25, 1, 25, 3, 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(26, 1, 26, 3, 12, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(27, 1, 27, 3, 20, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(28, 1, 28, 3, 15, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(29, 1, 29, 3, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(30, 1, 30, 3, 12, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(31, 1, 31, 3, 25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(32, 1, 32, 3, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(33, 1, 33, 3, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(34, 1, 34, 3, 25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(35, 1, 35, 3, 20, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(36, 1, 36, 3, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(37, 1, 37, 3, 17, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(38, 1, 38, 3, 30, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(39, 1, 39, 3, 40, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(40, 1, 40, 3, 20, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(41, 1, 41, 3, 15, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(42, 1, 42, 3, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(43, 1, 43, 3, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(44, 1, 44, 3, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(45, 1, 45, 3, 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(46, 1, 46, 3, 18, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(47, 1, 47, 3, 45, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(48, 2, 48, 3, 6.55, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(49, 2, 49, 3, 2.25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(50, 2, 50, 3, 15.47, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(51, 2, 51, 3, 14.57, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(52, 2, 52, 3, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(53, 2, 53, 3, 17.5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(54, 2, 54, 3, 5.2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(55, 2, 55, 3, 14.37, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(56, 2, 56, 3, 6.95, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(57, 2, 57, 3, 8.57, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(58, 2, 58, 3, 7.44, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(59, 2, 59, 3, 10.47, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(60, 2, 60, 3, 10.73, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(61, 2, 61, 3, 11.25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(62, 2, 62, 3, 11.25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(63, 2, 63, 3, 4.87, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(64, 2, 64, 3, 7.14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(65, 2, 65, 3, 5.54, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(66, 2, 66, 3, 11.5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(67, 2, 67, 3, 8.65, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(68, 1, 68, 3, 13.5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(69, 1, 69, 3, 11.21, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(70, 1, 70, 3, 5.83, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(71, 1, 71, 3, 17.61, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(72, 1, 72, 3, 8.14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_stock_transection`
--

CREATE TABLE IF NOT EXISTS `item_stock_transection` (
  `id` int(11) NOT NULL,
  `transection_type` int(20) NOT NULL COMMENT '1-purchased, 2-Sale, 3-location_change, 4-return, 5-damaged,6-Sales order, 20:purchase_return,30:sales_return,40:consignee_submission, 50:consignee_recieve',
  `trans_ref` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `units` double NOT NULL,
  `uom_id` int(10) NOT NULL,
  `units_2` double NOT NULL,
  `uom_id_2` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock_transection`
--

INSERT INTO `item_stock_transection` (`id`, `transection_type`, `trans_ref`, `item_id`, `units`, `uom_id`, `units_2`, `uom_id_2`, `location_id`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 1, 1, 1, 6, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 1, 1, 2, 2, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 1, 1, 3, 15, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(4, 1, 1, 4, 14, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 1, 1, 5, 5, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, 1, 1, 6, 17, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, 1, 1, 7, 5, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(8, 1, 1, 8, 14, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(9, 1, 1, 9, 6, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(10, 1, 1, 10, 8, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(11, 1, 1, 11, 7, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(12, 1, 1, 12, 10, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(13, 1, 1, 13, 10, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(14, 1, 1, 14, 20, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(15, 1, 1, 15, 11, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(16, 1, 1, 16, 4, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(17, 1, 1, 17, 77, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(18, 1, 1, 18, 50, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(19, 1, 1, 19, 25, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(20, 1, 1, 20, 21, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(21, 1, 1, 21, 22, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(22, 1, 1, 22, 54, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(23, 1, 1, 23, 11, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(24, 1, 1, 24, 45, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(25, 1, 1, 25, 7, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(26, 1, 1, 26, 12, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(27, 1, 1, 27, 20, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(28, 1, 1, 28, 15, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(29, 1, 1, 29, 10, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(30, 1, 1, 30, 12, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(31, 1, 1, 31, 25, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(32, 1, 1, 32, 10, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(33, 1, 1, 33, 6, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(34, 1, 1, 34, 25, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(35, 1, 1, 35, 20, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(36, 1, 1, 36, 10, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(37, 1, 1, 37, 17, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(38, 1, 1, 38, 30, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(39, 1, 1, 39, 40, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(40, 1, 1, 40, 20, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(41, 1, 1, 41, 15, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(42, 1, 1, 42, 5, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(43, 1, 1, 43, 8, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(44, 1, 1, 44, 4, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(45, 1, 1, 45, 3, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(46, 1, 1, 46, 18, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(47, 1, 1, 47, 45, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(48, 1, 2, 48, 6.55, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(49, 1, 2, 49, 2.25, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(50, 1, 2, 50, 15.47, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(51, 1, 2, 51, 14.57, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(52, 1, 2, 52, 5, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(53, 1, 2, 53, 17.5, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(54, 1, 2, 54, 5.2, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(55, 1, 2, 55, 14.37, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(56, 1, 2, 56, 6.95, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(57, 1, 2, 57, 8.57, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(58, 1, 2, 58, 7.44, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(59, 1, 2, 59, 10.47, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(60, 1, 2, 60, 10.73, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(61, 1, 2, 61, 11.25, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(62, 1, 2, 62, 11.25, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(63, 1, 2, 63, 4.87, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(64, 1, 2, 64, 7.14, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(65, 1, 2, 65, 5.54, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(66, 1, 2, 66, 11.5, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(67, 1, 2, 67, 8.65, 3, 1, 1, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(68, 2, 1, 15, 11, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(69, 2, 1, 10, 8, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(70, 1, 3, 68, 13.5, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(71, 1, 3, 69, 11.21, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(72, 1, 3, 70, 5.83, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(73, 1, 3, 71, 17.61, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(74, 1, 3, 72, 8.14, 3, 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_uom`
--

CREATE TABLE IF NOT EXISTS `item_uom` (
  `id` int(11) NOT NULL,
  `unit_abbreviation` varchar(15) NOT NULL,
  `unit_description` varchar(30) NOT NULL,
  `descimal_point` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_uom`
--

INSERT INTO `item_uom` (`id`, `unit_abbreviation`, `unit_description`, `descimal_point`, `status`, `deleted`) VALUES
(1, 'artcl', 'Articles', 0, 1, 0),
(2, 'pcs', 'Pieces', 0, 1, 0),
(3, 'g', 'Gram', 0, 1, 0),
(4, 'L', 'Liter', 0, 1, 0),
(5, 'Box', 'BOX', 0, 1, 0),
(6, 'Pack', 'Pack', 0, 1, 0),
(7, 'cts', 'Carat Weight', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `page_id` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `img_class` varchar(50) NOT NULL,
  `is_parent` int(5) NOT NULL COMMENT '1-first_level, 2- second_level',
  `show_below` int(5) NOT NULL,
  `hidden` int(5) NOT NULL,
  `user_permission_apply` int(5) NOT NULL,
  `menu_order` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `page_id`, `link`, `img_class`, `is_parent`, `show_below`, `hidden`, `user_permission_apply`, `menu_order`) VALUES
(1, 'Dashboard', 'dashboard', '', 'fa fa-dashboard', 1, 0, 0, 1, 10),
(2, 'Users', 'users', '', 'fa fa-user', 2, 3, 0, 1, 82),
(3, 'All Users', '#', '', 'fa fa-user', 0, 4, 0, 1, 81),
(4, 'Settings', '#', '', 'fa fa-gears', 1, 0, 0, 1, 80),
(5, 'Company Details', 'company', '', 'fa fa-building-o', 0, 4, 0, 1, 83),
(6, 'User Permission', 'userPermission', '', 'fa fa-lock', 0, 3, 0, 1, 84),
(7, 'Backup', 'backup', '', 'fa fa-hdd-o', 0, 4, 0, 1, 85),
(8, 'Reports', '#', '', 'fa fa-bar-chart', 1, 0, 0, 1, 40),
(9, 'Audit Trials', 'AuditTrials', '', 'fa fa-history', 0, 70, 0, 1, 41),
(10, 'CMS', '#', '', 'fa fa-desktop', 1, 0, 0, 1, 50),
(11, 'Banners', 'Banners', '', 'fa fa-image', 0, 10, 0, 1, 51),
(12, 'Featured_cms', 'Featured_cms', '', 'fa fa-list-ul', 0, 10, 1, 1, 52),
(13, 'Persons', '#', '', 'fa fa-users', 1, 0, 0, 1, 30),
(51, 'Purchasing Invoice', 'Purchasing_invoices', '', 'fa fa-list-ul', 0, 50, 0, 1, 22),
(27, 'Customers', 'Customers', '', 'fa fa-handshake-o', 0, 13, 0, 1, 31),
(52, 'Sales Invoices', 'Sales_invoices', '', 'fa fa-list-ul', 0, 44, 0, 1, 23),
(29, 'Addons', 'addons', '', 'fa fa-link', 0, 4, 0, 1, 32),
(50, 'Purchasing', '#', '', 'fa fa-download', 0, 66, 0, 1, 22),
(49, 'Suppliers', 'Suppliers', '', 'fa fa-download', 0, 13, 0, 1, 32),
(35, 'Drop Down lists', 'DropDownList', '', 'fa fa-list', 0, 60, 0, 1, 86),
(36, 'Customer Payments', 'Payments', '/add/10', 'fa fa-money', 0, 44, 0, 1, 24),
(37, 'Void Transection', 'Transections', '', 'fa fa-exchange', 0, 4, 0, 1, 81),
(38, 'Items & Inventory', '#', '', 'fa fa-cubes', 1, 0, 0, 1, 30),
(39, 'Item Management', 'Items', '', 'fa fa-cube', 0, 38, 0, 1, 31),
(40, 'Inventory Location', 'Inventory_location', '', 'fa fa-building', 0, 102, 0, 1, 33),
(41, 'Item Categories', 'Item_categories', '', 'fa fa-list', 0, 102, 0, 1, 32),
(42, 'Units of Measure', 'Item_UOM', '', 'fa  fa-balance-scale', 0, 102, 0, 1, 35),
(43, 'Supplier Payments', 'Supplier_payments', '', 'fa fa-money', 0, 0, 0, 1, 36),
(44, 'Sales', '#', '', 'fa fa-dollar', 0, 66, 0, 1, 21),
(45, 'Sales Invoice Garage', 'Invoices', '', 'fa fa-list-ul', 0, 44, 1, 1, 24),
(46, 'Sales Summary old', 'Invoice_list', '', 'fa fa-money', 0, 44, 1, 1, 25),
(47, 'Estimation & quotations ', 'Quotations', '', 'fa fa-file', 0, 44, 0, 1, 24),
(48, 'Customer Balance', 'CustomerBalance1', '', 'fa fa-history', 0, 67, 1, 1, 41),
(53, 'Sales Order', 'Sales_orders', '', 'fa fa-edit', 0, 44, 0, 1, 22),
(54, 'Consignee', 'Consignees', '', 'fa fa-user', 0, 59, 0, 1, 13),
(55, 'Order Take', 'Sales_order_items', '', 'fa fa-plus', 0, 44, 0, 1, 21),
(56, 'Upload CSV', 'Upload_csv', '', 'fa fa-upload', 0, 60, 0, 1, 87),
(57, 'Buy Items', 'Purchasing_items', '', 'fa fa-list-ul', 0, 50, 0, 1, 21),
(58, 'Purchase Return', 'Purchasing_returns', '', 'fa fa-reply', 0, 50, 0, 1, 25),
(59, 'Consignee', '#', '', 'fa fa-retweet', 0, 66, 0, 1, 23),
(60, 'Advance', 'advance', '', 'fa fa-wrench', 0, 4, 0, 1, 101),
(61, 'OC Website', 'Website_sync', '', 'fa fa-shopping-cart', 0, 60, 0, 1, 87),
(62, 'Sales Return', 'Sales_returns', '', 'fa fa-reply', 0, 44, 0, 1, 25),
(63, 'Submission', 'Consignee_submission', '', 'fa fa-upload', 0, 59, 0, 1, 14),
(64, 'Receive', 'Consignee_receive', '', 'fa fa-download', 0, 59, 0, 1, 15),
(65, 'Sales Summary', 'reports/Sales_summary', '', 'fa fa-clipboard', 0, 67, 0, 1, 42),
(66, 'Trades', '#', '', 'fa fa-retweet', 1, 0, 0, 1, 20),
(67, 'Sales Roports', '#', '', 'fa fa-file', 0, 8, 0, 1, 41),
(68, 'Purchasing Roports', '#', '', 'fa fa-file', 0, 8, 0, 1, 42),
(69, 'Stock Roports', '#', '', 'fa fa-file', 0, 8, 0, 1, 43),
(70, 'Other Roports', '#', '', 'fa fa-file', 0, 8, 0, 1, 45),
(72, 'Supplier Payments', 'Payments', '/add/20', 'fa fa-money', 0, 50, 0, 1, 25),
(73, 'Sales POS', 'Sales_pos', '/add', 'fa fa-desktop', 0, 44, 0, 1, 21),
(74, 'Customer Balance', 'reports/Customer_balance', '', 'fa fa-list', 0, 67, 0, 1, 43),
(75, 'Purchase Summary', 'reports/Purchase_summary', '', 'fa fa-clipboard', 0, 68, 0, 1, 46),
(76, 'Supplier Balance', 'reports/Supplier_balance', '', 'fa fa-list', 0, 68, 0, 1, 47),
(77, 'Location Transfer', 'Location_transfer', '', 'fa fa-retweet', 0, 38, 0, 1, 30),
(78, 'Stock Sheet', 'reports/Stock_sheet', '', 'fa fa-sitemap', 0, 69, 0, 1, 51),
(79, 'Location Transfers', 'reports/location_transfer_report', '', 'fa fa-truck', 0, 69, 0, 1, 52),
(80, 'Consignee Stock', 'reports/Consignee_stockcheck', '', 'fa fa-hourglass', 0, 67, 0, 1, 44),
(81, 'Barcode Print', 'reports/Barcode_print', '', 'fa fa-barcode', 0, 69, 0, 1, 53),
(82, 'Ledgers Accounts', 'General_ledgers', '', 'fa fa-table', 0, 85, 0, 1, 353),
(83, 'Ledgers', '#', '', 'fa fa-table', 1, 0, 0, 1, 35),
(84, 'Quick Entry Accounts', 'Quick_entry_accounts', '', 'fa fa-folder-open-o', 0, 85, 0, 1, 351),
(85, 'Ledg. Settings', '#', '', 'fa fa-gears', 0, 83, 0, 1, 355),
(86, 'Quick Entries', 'Quick_entries', '', 'fa fa-plus', 0, 83, 0, 1, 351),
(87, 'Ledger Reports', '#', '', 'fa fa-table', 0, 8, 0, 1, 44),
(88, 'Month Reports', 'reports/Ledger_reports', '/monthly_ledger', 'fa fa-clipboard', 0, 87, 0, 1, 461),
(89, 'Day Reports', 'reports/Ledger_reports', '/daily_ledger', 'fa fa-clipboard', 0, 87, 0, 1, 462),
(90, 'Buy Gold', 'Buy_gold', '', 'fa fa-plus', 0, 44, 0, 1, 23),
(91, 'WorkShop', '#', '', 'fa fa-gavel', 1, 0, 0, 1, 22),
(92, 'Craftmans', 'Craftmans', '', 'fa fa-plus', 0, 91, 0, 1, 215),
(93, 'Order Submission', 'Order_submissions', '', 'fa fa-envelope', 0, 91, 0, 1, 211),
(94, 'Receivable', 'Order_receivals', '', 'fa fa-inbox', 0, 91, 0, 1, 212),
(95, 'Reservations', 'Reservations', '', 'fa fa-tags', 0, 44, 0, 1, 26),
(96, 'Purchasing Gems', 'Purchasing_gemstones', '', 'fa fa-list-ul', 0, 50, 0, 1, 22),
(97, 'Gemstone Stock Check', 'reports/Stock_sheet_gemstones', '', 'fa fa-sitemap', 0, 69, 0, 1, 52),
(98, 'Customer Types', 'Customer_types', '', 'fa fa-list', 0, 13, 0, 1, 32),
(99, 'Currency Management', 'Currencies', '', 'fa fa-dollar', 0, 4, 0, 1, 33),
(100, 'Fiscal Years', 'Fiscal_years', '', 'fa fa-calendar', 0, 85, 0, 1, 352),
(101, 'Stock Check', 'Inventory_stock_check', '', 'fa fa-barcode', 0, 38, 0, 1, 32),
(102, 'Setting', '#', '', 'fa fa-gears', 1, 38, 0, 1, 38);

-- --------------------------------------------------------

--
-- Table structure for table `module_actions`
--

CREATE TABLE IF NOT EXISTS `module_actions` (
  `id` int(11) NOT NULL,
  `module_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=553 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_actions`
--

INSERT INTO `module_actions` (`id`, `module_id`, `name`, `action`, `status`) VALUES
(1, 1, 'index', 'index', 1),
(2, 4, 'index', 'index', 1),
(3, 3, 'index', 'index', 1),
(4, 6, 'index', 'index', 1),
(20, 6, 'index', 'index', 1),
(6, 5, 'index', 'index', 1),
(7, 5, 'Add', 'add', 1),
(8, 5, 'Validate', 'validate', 1),
(9, 5, 'Edit', 'edit', 1),
(10, 5, 'Search', 'search_company', 1),
(11, 5, 'View', 'view', 1),
(12, 5, 'Delete', 'delete', 1),
(13, 2, 'index', 'index', 1),
(14, 2, 'Add', 'add', 1),
(15, 2, 'Validate', 'validate', 1),
(16, 2, 'Edit', 'edit', 1),
(17, 2, 'Search', 'search_user', 1),
(18, 2, 'View', 'view', 1),
(19, 2, 'Delete', 'delete', 1),
(21, 6, 'Edit', 'edit', 1),
(22, 6, 'Validate', 'validate', 1),
(23, 5, 'Test', 'test', 1),
(24, 7, 'index', 'index', 1),
(25, 7, 'Backup Database', 'backup_db', 1),
(26, 8, 'index', 'index', 1),
(27, 9, 'index', 'index', 1),
(28, 9, 'Search System Log', 'search_audit_trials', 1),
(29, 9, 'View', 'view', 1),
(30, 10, 'index', 'index', 1),
(31, 11, 'index', 'index', 1),
(32, 12, 'index', 'index', 1),
(33, 11, 'Add', 'add', 1),
(34, 11, 'Validate', 'validate', 1),
(35, 11, 'Edit', 'edit', 1),
(36, 13, 'index', 'index', 1),
(252, 40, 'View Supplier', 'view', 1),
(251, 40, 'Validation', 'validate', 1),
(250, 40, 'Remove Supplier', 'delete', 1),
(249, 40, 'Edit Suppliers', 'edit', 1),
(149, 35, 'index', 'index', 1),
(148, 35, 'Validation', 'validate', 1),
(147, 35, 'View dropdown', 'view', 1),
(146, 35, 'Remove dropdown', 'delete', 1),
(145, 35, 'Edit dropdown', 'edit', 1),
(49, 5, 'test_upload', 'test_upload', 1),
(144, 35, 'Create dropdown', 'add', 1),
(143, 35, 'Search dropdown', 'search', 1),
(254, 51, 'index', 'index', 1),
(247, 40, 'Create Supplier', 'add', 1),
(187, 42, 'Index', 'index', 1),
(186, 41, 'Index', 'index', 1),
(253, 50, 'index', 'index', 1),
(184, 39, 'Index', 'index', 1),
(183, 38, 'Index', 'index', 1),
(182, 37, 'Validation', 'validate', 1),
(181, 37, 'View Transection', 'view', 1),
(180, 37, 'Remove Transection', 'delete', 1),
(179, 37, 'Edit Transection', 'edit', 1),
(178, 37, 'Create Transection', 'add', 1),
(177, 37, 'Search Transections', 'search', 1),
(176, 37, 'index', 'index', 1),
(175, 36, 'Validation', 'validate', 1),
(80, 11, 'Search', 'search', 1),
(174, 36, 'Add Payments', 'add_customer_payment', 1),
(173, 36, 'Customer Payments', 'index', 1),
(260, 51, 'View Purchasing Invoice', 'view', 1),
(259, 51, 'Validation', 'validate', 1),
(258, 51, 'Remove Purchasing Invoice', 'delete', 1),
(257, 51, 'Edit Purchasing Invoice', 'edit', 1),
(256, 51, 'Create Purchasing Invoice', 'add', 1),
(255, 51, 'Search Purchasing Invoice', 'search', 1),
(246, 40, 'Search Suppliers', 'search', 1),
(245, 40, 'index', 'index', 1),
(244, 49, 'View Supplier', 'view', 1),
(243, 49, 'Validation', 'validate', 1),
(242, 49, 'Remove Supplier', 'delete', 1),
(108, 27, 'index', 'index', 1),
(109, 27, 'Search Customer', 'search', 1),
(110, 27, 'Create Customer', 'add', 1),
(111, 27, 'Edit Customer', 'edit', 1),
(112, 27, 'Remove Customer', 'delete', 1),
(113, 27, 'Validation', 'validate', 1),
(114, 27, 'View Customer', 'view', 1),
(241, 49, 'Edit Suppliers', 'edit', 1),
(240, 49, 'Create Supplier', 'add', 1),
(239, 49, 'Search Suppliers', 'search', 1),
(238, 49, 'index', 'index', 1),
(122, 29, 'Index', 'index', 1),
(123, 29, 'Search Addons', 'search', 1),
(124, 29, 'Create Addons', 'add', 1),
(125, 29, 'Edit Addons', 'edit', 1),
(126, 29, 'Remove Addons', 'delete', 1),
(127, 29, 'View Addons', 'view', 1),
(128, 29, 'Validation', 'validate', 1),
(237, 39, 'Test Func', 'test', 1),
(236, 39, 'Item Ajax', 'fl_ajax', 1),
(188, 42, 'Search Unit of Measure', 'search', 1),
(189, 42, 'Create Unit of Measure', 'add', 1),
(190, 42, 'Edit Unit of Measure', 'edit', 1),
(191, 42, 'Remove Unit of Measure', 'delete', 1),
(192, 42, 'View Unit of Measure', 'view', 1),
(193, 42, 'Validation', 'validate', 1),
(194, 41, 'Search Item Category', 'search', 1),
(195, 41, 'Create Item Category', 'add', 1),
(196, 41, 'Edit Item Category', 'edit', 1),
(197, 41, 'Remove Item Category', 'delete', 1),
(198, 41, 'View Item Category', 'view', 1),
(199, 41, 'Validation', 'validate', 1),
(200, 39, 'Search Items', 'search', 1),
(201, 39, 'Create Items', 'add', 1),
(202, 39, 'Edit Items', 'edit', 1),
(203, 39, 'Remove Items', 'delete', 1),
(204, 39, 'View Items', 'view', 1),
(205, 39, 'Validation', 'validate', 1),
(206, 43, 'Supplier Payments', 'index', 1),
(207, 43, 'Add Payments Suppliers', 'add_supplier_payment', 1),
(208, 43, 'Validation', 'validate', 1),
(209, 39, 'Item Sales Price', 'update_sales_price', 1),
(210, 39, 'Item Purchasing Price', 'update_purchasing_price', 1),
(211, 39, 'Item Price Removal', 'remove_price', 1),
(212, 39, 'Item Price list view', 'load_purchasing_price', 1),
(213, 44, 'Index', 'index', 1),
(214, 45, 'test', 'test', 1),
(215, 45, 'Index', 'index', 1),
(216, 45, 'New Invoice', 'add', 1),
(217, 45, 'Search', 'search', 1),
(218, 45, 'Get Single Item', 'get_single_item', 1),
(219, 45, 'Validation', 'validate', 1),
(220, 45, 'Sales Invoice Print', 'sales_invoice_print', 1),
(221, 46, 'Index', 'index', 1),
(222, 45, 'View Invoice', 'view', 1),
(223, 7, 'Backup files', 'backup_folder', 1),
(224, 47, 'index', 'index', 1),
(225, 47, 'Search Estimation or Quot', 'search', 1),
(226, 47, 'Create Estimation or Quot ', 'add', 1),
(227, 47, 'Edit Estimation or Quot ', 'edit', 1),
(228, 47, 'Remove ', 'delete', 1),
(229, 47, 'View Estimation or Quot', 'view', 1),
(230, 47, 'Validation', 'validate', 1),
(231, 47, 'Print Estimate/quote', 'quote_print', 1),
(232, 48, 'index', 'index', 1),
(233, 48, 'Search', 'search', 1),
(234, 48, 'Print Report', 'print_result_report', 1),
(235, 45, 'Delete Invoice', 'delete', 1),
(261, 51, 'Ajax Permission', 'fl_ajax', 1),
(262, 52, 'Ajax Permission', 'fl_ajax', 1),
(263, 52, 'View Sales Invoice', 'view', 1),
(264, 52, 'Validation', 'validate', 1),
(265, 52, 'Remove Sales Invoice', 'delete', 1),
(266, 52, 'Edit Sales Invoice', 'edit', 1),
(267, 52, 'Create Sales Invoice', 'add', 1),
(268, 52, 'Search Sales Invoice', 'search', 1),
(269, 52, 'index', 'index', 1),
(270, 52, 'Test Dev', 'test', 1),
(271, 53, 'Ajax Permission', 'fl_ajax', 1),
(272, 53, 'View Sales Order', 'view', 1),
(273, 53, 'Validation', 'validate', 1),
(274, 53, 'Remove Sales Order', 'delete', 1),
(275, 53, 'Edit Sales Order', 'edit', 1),
(276, 53, 'Create Sales Order', 'add', 1),
(277, 53, 'Search Sales Order', 'search', 1),
(278, 53, 'index', 'index', 1),
(321, 58, 'index', 'index', 1),
(280, 27, 'Create Customer Branch', 'add_branch', 1),
(281, 27, 'Edit Customer Branch', 'edit_branch', 1),
(282, 27, 'Delete Customer Branch', 'delete_branch', 1),
(283, 27, 'View Customer Branch', 'view_branch', 1),
(284, 27, 'Validate Branch', 'validate_branch', 1),
(285, 53, 'Add Order Items', 'add_item_by_cat', 1),
(286, 53, 'Test Dev', 'test', 1),
(287, 53, 'Sales Order Print', 'print_sales_order', 1),
(288, 55, 'Ajax Permission', 'fl_ajax', 1),
(289, 55, 'View Sales Order', 'view', 1),
(290, 55, 'Validation', 'validate', 1),
(291, 55, 'Remove Sales Order', 'delete', 1),
(292, 55, 'Edit Sales Order', 'edit', 1),
(293, 55, 'Create Sales Order', 'add', 1),
(294, 55, 'Search Sales Order', 'search', 1),
(295, 55, 'index', 'index', 1),
(296, 55, 'Add Order Items', 'add_item_by_cat', 1),
(297, 55, 'Test Dev', 'test', 1),
(298, 55, 'Sales Order Print', 'print_sales_order', 1),
(299, 52, 'Print Invoice', 'sales_invoice_print', 1),
(300, 56, 'index', 'index', 1),
(301, 56, 'Upload Csv', 'upload_csv', 1),
(302, 56, 'Validate Upload', 'validate', 1),
(303, 56, 'Add Upload', 'add', 1),
(304, 27, 'Ajax', 'fl_ajax', 1),
(305, 57, 'index', 'index', 1),
(306, 57, 'Search Purchasing Invoice', 'search', 1),
(307, 57, 'Create Purchasing Invoice', 'add', 1),
(308, 57, 'Edit Purchasing Invoice', 'edit', 1),
(309, 57, 'Remove Purchasing Invoice', 'delete', 1),
(310, 57, 'Validation', 'validate', 1),
(311, 57, 'View Purchasing Invoice', 'view', 1),
(312, 57, 'Ajax Permission', 'fl_ajax', 1),
(313, 1, 'Ajax Permission', 'fl_ajax', 1),
(314, 54, 'View Consignee', 'view', 1),
(315, 54, 'Validation', 'validate', 1),
(316, 54, 'Remove Consignee', 'delete', 1),
(317, 54, 'Edit Consignee', 'edit', 1),
(318, 54, 'Create Consignee', 'add', 1),
(319, 54, 'Search Consignee', 'search', 1),
(320, 54, 'index', 'index', 1),
(322, 58, 'Ajax Permission', 'fl_ajax', 1),
(323, 58, 'View Purchase Return ', 'view', 1),
(324, 58, 'Validation', 'validate', 1),
(325, 58, 'Remove Purchase Return', 'delete', 1),
(326, 58, 'Edit Purchase Return', 'edit', 1),
(327, 58, 'Create Purchas Return', 'add', 1),
(328, 58, 'Search Purchase Return', 'search', 1),
(329, 59, 'index', 'index', 1),
(330, 60, 'index', 'index', 1),
(331, 61, 'index', 'index', 1),
(332, 61, 'Ajax Permission', 'fl_ajax', 1),
(333, 62, 'Search Sales Return', 'search', 1),
(334, 62, 'Create Sales Return', 'add', 1),
(335, 62, 'Edit Sales Return', 'edit', 1),
(336, 62, 'Remove Sales Return', 'delete', 1),
(337, 62, 'Validation', 'validate', 1),
(338, 62, 'View Sales Return ', 'view', 1),
(339, 62, 'Ajax Permission', 'fl_ajax', 1),
(340, 62, 'index', 'index', 1),
(341, 51, 'Supplier Invoice Print', 'supplier_invoice_print', 1),
(342, 63, 'Print Submission Note', 'submission_note_print', 1),
(343, 63, 'Test Dev', 'test', 1),
(344, 63, 'index', 'index', 1),
(345, 63, 'Search Consignee Submission', 'search', 1),
(346, 63, 'Create Consignee Submission', 'add', 1),
(347, 63, 'Edit Consignee Submission', 'edit', 1),
(348, 63, 'Remove Consignee Submission', 'delete', 1),
(349, 63, 'Validation', 'validate', 1),
(350, 63, 'View Consignee Submission', 'view', 1),
(351, 63, 'Ajax Permission', 'fl_ajax', 1),
(352, 64, 'index', 'index', 1),
(353, 65, 'index', 'index', 1),
(354, 66, 'index', 'index', 1),
(355, 67, 'index', 'index', 1),
(356, 68, 'index', 'index', 1),
(357, 69, 'index', 'index', 1),
(358, 70, 'index', 'index', 1),
(359, 65, 'Ajax Permission', 'fl_ajax', 1),
(366, 72, 'index', 'index', 1),
(365, 36, 'Add Payment', 'add', 1),
(364, 36, 'Ajax Permission', 'fl_ajax', 1),
(367, 72, 'Ajax Permission', 'fl_ajax', 1),
(368, 72, 'Add Payment', 'add', 1),
(369, 72, 'Validation', 'validate', 1),
(370, 65, 'Print Report', 'print_report', 1),
(371, 73, 'Delete Invoice', 'delete', 1),
(372, 73, 'View Invoice', 'view', 1),
(373, 73, 'Sales Invoice Print', 'sales_invoice_print', 1),
(374, 73, 'Validation', 'validate', 1),
(375, 73, 'Get Single Item', 'get_single_item', 1),
(376, 73, 'Search', 'search', 1),
(377, 73, 'New Invoice', 'add', 1),
(378, 73, 'Index', 'index', 1),
(379, 73, 'test', 'test', 1),
(380, 64, 'index', 'index', 1),
(381, 64, 'Ajax Permission', 'fl_ajax', 1),
(382, 64, 'View Returns', 'view', 1),
(383, 64, 'Validation', 'validate', 1),
(384, 64, 'Remove Consignee Recieve', 'delete', 1),
(385, 64, 'Edit Consignee Recieve', 'edit', 1),
(386, 64, 'Create Consignee Recieve', 'add', 1),
(387, 64, 'Search Consignee Recieve', 'search', 1),
(388, 73, 'Ajax Permission', 'fl_ajax', 1),
(389, 74, 'Print Report', 'print_report', 1),
(390, 74, 'Ajax Permission', 'fl_ajax', 1),
(391, 74, 'index', 'index', 1),
(392, 75, 'Print Report', 'print_report', 1),
(393, 75, 'Ajax Permission', 'fl_ajax', 1),
(394, 75, 'index', 'index', 1),
(395, 76, 'index', 'index', 1),
(396, 76, 'Ajax Permission', 'fl_ajax', 1),
(397, 76, 'Print Report', 'print_report', 1),
(398, 77, 'index', 'index', 1),
(399, 77, 'add', 'Add Transfer', 1),
(400, 77, 'Ajax Permission', 'fl_ajax', 1),
(401, 77, 'Validation', 'validate', 1),
(402, 78, 'index', 'index', 1),
(403, 78, 'Ajax Permission', 'fl_ajax', 1),
(404, 78, 'Print Report', 'print_report', 1),
(405, 79, 'index', 'index', 1),
(406, 79, 'Ajax Permission', 'fl_ajax', 1),
(407, 79, 'Print Report', 'print_report', 1),
(408, 80, 'Print Report', 'print_report', 1),
(409, 80, 'Ajax Permission', 'fl_ajax', 1),
(410, 80, 'index', 'index', 1),
(411, 81, 'Print Report', 'print_report', 1),
(412, 81, 'Ajax Permission', 'fl_ajax', 1),
(413, 81, 'index', 'index', 1),
(414, 11, 'Extended Display', 'extended_display', 1),
(429, 83, 'Index', 'index', 1),
(430, 84, 'Validation', 'validate', 1),
(431, 84, 'View Quick Entry Acc', 'view', 1),
(432, 84, 'Ajax Permission', 'fl_ajax', 1),
(421, 82, 'Index', 'index', 1),
(422, 82, 'Search Ledgers', 'search', 1),
(423, 82, 'Create Ledgers', 'add', 1),
(424, 82, 'Edit Ledgers', 'edit', 1),
(425, 82, 'Remove Ledgers', 'delete', 1),
(426, 82, 'Ajax Permission', 'fl_ajax', 1),
(427, 82, 'View Ledgers', 'view', 1),
(428, 82, 'Validation', 'validate', 1),
(433, 84, 'Remove Quick Entry Acc', 'delete', 1),
(434, 84, 'Edit Quick Entry Acc', 'edit', 1),
(435, 84, 'Create Quick Entry Acc', 'add', 1),
(436, 84, 'Search Quick Entry Acc', 'search', 1),
(437, 84, 'Index', 'index', 1),
(438, 85, 'Index', 'index', 1),
(439, 86, 'Validation', 'validate', 1),
(440, 86, 'View Quick Entry', 'view', 1),
(441, 86, 'Ajax Permission', 'fl_ajax', 1),
(442, 86, 'Remove Quick Entry', 'delete', 1),
(443, 86, 'Edit Quick Entry', 'edit', 1),
(444, 86, 'Create Quick Entry', 'add', 1),
(445, 86, 'Search Quick Entry', 'search', 1),
(446, 86, 'Index', 'index', 1),
(447, 87, 'Index', 'index', 1),
(448, 88, 'Index', 'monthly_ledger', 1),
(452, 88, 'Ajax Permission', 'fl_ajax', 1),
(451, 89, 'index', 'daily_ledger', 1),
(453, 89, 'Ajax Permission', 'fl_ajax', 1),
(454, 49, 'Ajax Permission', 'fl_ajax', 1),
(455, 62, 'Print Receipt', 'pos_sales_ret_print_direct', 1),
(456, 62, 'Sales Retuen Print', 'sales_return_print', 1),
(457, 62, 'Add Sales Pos', 'add_POS', 1),
(458, 62, 'View Sales Pos', 'view_POS', 1),
(468, 90, 'Add Old Gold ', 'add_POS', 1),
(460, 90, 'Ajax Permission', 'fl_ajax', 1),
(461, 90, 'View Buy Gold', 'view', 1),
(462, 90, 'Validation', 'validate', 1),
(463, 90, 'Remove Buy Gold', 'delete', 1),
(464, 90, 'Edit Buy Gold', 'edit', 1),
(465, 90, 'Create Buy Gold', 'add', 1),
(466, 90, 'Search Buy Gold', 'search', 1),
(467, 90, 'index', 'index', 1),
(469, 91, 'index', 'index', 1),
(470, 92, 'index', 'index', 1),
(471, 93, 'index', 'index', 1),
(472, 94, 'index', 'index', 1),
(473, 92, 'index', 'index', 1),
(474, 92, 'Search Crafrman', 'search', 1),
(475, 92, 'Create Crafrman', 'add', 1),
(476, 92, 'Edit Crafrman', 'edit', 1),
(477, 92, 'Remove Crafrman', 'delete', 1),
(478, 92, 'Validation', 'validate', 1),
(479, 92, 'Ajax Permission', 'fl_ajax', 1),
(480, 92, 'View Crafrman', 'view', 1),
(481, 93, 'View Sales Pos', 'view_POS', 1),
(482, 93, 'Add Sales Pos', 'add_POS', 1),
(483, 93, 'Order Submission Print', 'so_submission_print', 1),
(484, 93, 'Print Receipt', 'pos_sales_ret_print_direct', 1),
(486, 93, 'Ajax Permission', 'fl_ajax', 1),
(487, 93, 'View Order Submission ', 'view', 1),
(488, 93, 'Validation', 'validate', 1),
(489, 93, 'Remove Order Submission', 'delete', 1),
(490, 93, 'Edit Order Submission', 'edit', 1),
(491, 93, 'Create Order Submission', 'add', 1),
(492, 93, 'Search Order Submission', 'search', 1),
(494, 94, 'Search Craftman Receivals', 'search', 1),
(495, 94, 'Create Craftman Receivals', 'add', 1),
(496, 94, 'Edit Craftman Receivals', 'edit', 1),
(497, 94, 'Remove Craftman Receivals', 'delete', 1),
(498, 94, 'Validation', 'validate', 1),
(499, 94, 'View Craftman Receivals', 'view', 1),
(500, 94, 'Ajax Permission', 'fl_ajax', 1),
(501, 94, ' Craftman Receivals Print', 'craftman_receival_print', 1),
(502, 37, 'Delete POP Window', 'delete_so_pop', 1),
(503, 90, 'Remove Window POP', 'delete_so_pop', 1),
(504, 95, 'index', 'index', 1),
(505, 95, 'Search Reservations', 'search', 1),
(506, 95, 'Cancel Reservations', 'cancel_reservation', 1),
(507, 95, 'Recall Reservation', 'recall_reservation', 1),
(508, 89, 'index', 'index', 1),
(509, 88, 'Index', 'index', 1),
(510, 96, 'Supplier Gem Invoice Print', 'supplier_invoice_print', 1),
(511, 96, 'Ajax Permission', 'fl_ajax', 1),
(512, 96, 'View Purchasing Invoice', 'view', 1),
(513, 96, 'Validation', 'validate', 1),
(514, 96, 'Remove Purchasing Invoice', 'delete', 1),
(515, 96, 'Edit Purchasing Invoice', 'edit', 1),
(516, 96, 'Create Purchasing Invoice', 'add', 1),
(517, 96, 'Search Purchasing Invoice', 'search', 1),
(518, 96, 'index', 'index', 1),
(519, 35, 'Ajax Permission', 'fl_ajax', 1),
(520, 97, 'index', 'index', 1),
(521, 97, 'Ajax Permission', 'fl_ajax', 1),
(522, 97, 'Print Report', 'print_report', 1),
(523, 98, 'View Customer Type', 'view', 1),
(524, 98, 'Validation', 'validate', 1),
(525, 98, 'Remove Customer Type', 'delete', 1),
(526, 98, 'Edit Customer Type', 'edit', 1),
(527, 98, 'Create Customer Type', 'add', 1),
(528, 98, 'Search Customer Type', 'search', 1),
(529, 98, 'Ajax Permission', 'fl_ajax', 1),
(530, 98, 'index', 'index', 1),
(531, 99, 'Validation', 'validate', 1),
(532, 99, 'View Currence', 'view', 1),
(533, 99, 'Remove Currency', 'delete', 1),
(534, 99, 'Edit Currency', 'edit', 1),
(535, 99, 'Create Currency', 'add', 1),
(536, 99, 'Ajax Permission', 'fl_ajax', 1),
(537, 99, 'Search Currency', 'search', 1),
(538, 99, 'Index', 'index', 1),
(539, 100, 'Validation', 'validate', 1),
(540, 100, 'View Fiscal Year', 'view', 1),
(541, 100, 'Remove Fiscal Year', 'delete', 1),
(542, 100, 'Edit Fiscal Year', 'edit', 1),
(543, 100, 'Create Fiscal Year', 'add', 1),
(544, 100, 'Ajax Permission', 'fl_ajax', 1),
(545, 100, 'Search Fiscal Year', 'search', 1),
(546, 100, 'Index', 'index', 1),
(547, 101, 'Index', 'index', 1),
(548, 101, 'Ajax Permission', 'fl_ajax', 1),
(549, 101, 'Search Stocks', 'search', 1),
(550, 101, 'Print Stock Check', 'print_stock_check', 1),
(551, 102, 'Index', 'index', 1),
(552, 6, 'make_fresh_system', 'make_fresh_system', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_user_role`
--

CREATE TABLE IF NOT EXISTS `module_user_role` (
  `id` int(11) NOT NULL,
  `user_role_id` int(10) NOT NULL,
  `module_action_id` int(10) NOT NULL,
  `display_order` int(10) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3107 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_user_role`
--

INSERT INTO `module_user_role` (`id`, `user_role_id`, `module_action_id`, `display_order`, `status`) VALUES
(1, 1, 1, 101, 1),
(2, 1, 2, 401, 1),
(3, 1, 3, 301, 1),
(4, 1, 4, 303, 1),
(5, 1, 23, 601, 1),
(6, 1, 6, 303, 1),
(7, 1, 7, 502, 1),
(8, 1, 8, 502, 1),
(9, 1, 9, 502, 1),
(10, 1, 10, 502, 1),
(11, 1, 11, 502, 1),
(12, 1, 12, 502, 1),
(13, 1, 13, 202, 1),
(14, 1, 14, 202, 1),
(15, 1, 15, 202, 1),
(16, 1, 16, 202, 1),
(17, 1, 17, 202, 1),
(18, 1, 18, 202, 1),
(19, 1, 19, 202, 1),
(20, 1, 20, 601, 1),
(21, 1, 21, 601, 1),
(22, 1, 22, 601, 1),
(23, 1, 24, 701, 1),
(24, 1, 25, 702, 1),
(25, 1, 26, 702, 1),
(26, 1, 27, 702, 1),
(27, 1, 28, 702, 1),
(28, 1, 29, 702, 1),
(29, 1, 30, 102, 1),
(30, 1, 31, 102, 1),
(31, 1, 32, 102, 1),
(32, 1, 33, 102, 1),
(33, 1, 34, 102, 1),
(34, 1, 35, 102, 1),
(35, 1, 36, 102, 1),
(36, 1, 149, 101, 1),
(37, 1, 148, 101, 1),
(38, 1, 49, 101, 1),
(39, 1, 147, 101, 1),
(40, 1, 146, 101, 1),
(41, 1, 145, 101, 1),
(42, 1, 144, 101, 1),
(43, 1, 143, 101, 1),
(44, 1, 205, 101, 1),
(45, 1, 204, 101, 1),
(46, 1, 203, 101, 1),
(47, 1, 202, 101, 1),
(48, 1, 201, 101, 1),
(49, 1, 200, 101, 1),
(50, 1, 199, 101, 1),
(51, 1, 198, 101, 1),
(52, 1, 197, 101, 1),
(53, 1, 196, 101, 1),
(54, 1, 195, 101, 1),
(55, 1, 194, 101, 1),
(56, 1, 193, 101, 1),
(57, 1, 192, 101, 1),
(58, 1, 191, 101, 1),
(59, 1, 190, 101, 1),
(60, 1, 80, 101, 1),
(61, 1, 189, 101, 1),
(62, 1, 188, 101, 1),
(63, 1, 187, 101, 1),
(64, 1, 186, 101, 1),
(65, 1, 185, 101, 0),
(66, 1, 184, 101, 1),
(67, 1, 183, 101, 1),
(68, 1, 182, 101, 1),
(69, 1, 181, 101, 1),
(70, 1, 180, 101, 1),
(71, 1, 179, 101, 1),
(72, 1, 178, 101, 1),
(73, 1, 177, 101, 1),
(74, 1, 176, 101, 1),
(75, 1, 175, 101, 1),
(76, 1, 174, 101, 1),
(77, 1, 173, 101, 1),
(78, 1, 108, 101, 1),
(79, 1, 109, 101, 1),
(80, 1, 110, 101, 1),
(81, 1, 111, 101, 1),
(82, 1, 112, 101, 1),
(83, 1, 113, 101, 1),
(84, 1, 114, 101, 1),
(85, 1, 122, 101, 1),
(86, 1, 123, 101, 1),
(87, 1, 124, 101, 1),
(88, 1, 125, 101, 1),
(89, 1, 126, 101, 1),
(90, 1, 127, 101, 1),
(91, 1, 128, 101, 1),
(92, 1, 206, 101, 1),
(93, 1, 207, 101, 1),
(94, 1, 208, 101, 1),
(95, 1, 209, 101, 1),
(96, 1, 210, 101, 1),
(97, 1, 211, 101, 1),
(98, 1, 212, 212, 1),
(99, 1, 213, 110, 1),
(100, 1, 214, 101, 1),
(101, 1, 215, 101, 1),
(102, 1, 216, 101, 1),
(103, 1, 217, 101, 1),
(104, 1, 218, 101, 1),
(105, 1, 219, 101, 1),
(106, 1, 220, 101, 1),
(107, 1, 221, 101, 1),
(108, 1, 222, 101, 1),
(109, 1, 223, 101, 1),
(110, 1, 287, 101, 1),
(111, 1, 286, 101, 1),
(112, 1, 285, 101, 1),
(113, 1, 284, 101, 1),
(114, 1, 283, 101, 1),
(115, 1, 282, 101, 1),
(116, 1, 281, 101, 1),
(117, 1, 280, 101, 1),
(571, 1, 316, 101, 1),
(119, 1, 278, 101, 1),
(120, 1, 277, 101, 1),
(121, 1, 276, 101, 1),
(122, 1, 275, 101, 1),
(123, 1, 274, 101, 1),
(124, 1, 273, 101, 1),
(125, 1, 272, 101, 1),
(126, 1, 271, 101, 1),
(127, 1, 270, 101, 1),
(128, 1, 269, 101, 1),
(129, 1, 268, 101, 1),
(130, 1, 236, 101, 1),
(131, 1, 267, 101, 1),
(132, 1, 266, 101, 1),
(133, 1, 265, 101, 1),
(134, 1, 264, 101, 1),
(135, 1, 263, 101, 1),
(136, 1, 262, 101, 1),
(137, 1, 261, 101, 1),
(138, 1, 260, 101, 1),
(139, 1, 259, 101, 1),
(140, 1, 258, 101, 1),
(141, 1, 257, 101, 1),
(142, 1, 256, 101, 1),
(143, 1, 255, 101, 1),
(144, 1, 254, 101, 1),
(145, 1, 253, 101, 1),
(146, 1, 252, 101, 1),
(147, 1, 251, 101, 1),
(148, 1, 250, 101, 1),
(149, 1, 249, 101, 1),
(150, 1, 224, 101, 1),
(151, 1, 225, 101, 1),
(152, 1, 226, 101, 1),
(153, 1, 227, 101, 1),
(154, 1, 228, 101, 1),
(155, 1, 229, 101, 1),
(156, 1, 230, 101, 1),
(157, 1, 231, 101, 1),
(158, 1, 232, 101, 1),
(159, 1, 233, 101, 1),
(160, 1, 234, 101, 1),
(161, 1, 247, 101, 1),
(162, 1, 246, 101, 1),
(163, 1, 245, 101, 1),
(164, 1, 244, 101, 1),
(165, 1, 243, 101, 1),
(166, 1, 242, 101, 1),
(167, 1, 241, 101, 1),
(168, 1, 240, 101, 1),
(169, 1, 239, 101, 1),
(170, 1, 238, 101, 1),
(171, 1, 237, 101, 1),
(172, 1, 235, 101, 1),
(173, 1, 288, 101, 1),
(174, 1, 289, 101, 1),
(175, 1, 290, 101, 1),
(176, 1, 291, 101, 1),
(177, 1, 292, 101, 1),
(178, 1, 293, 101, 1),
(179, 1, 294, 101, 1),
(180, 1, 295, 101, 1),
(181, 1, 296, 101, 1),
(182, 1, 297, 101, 1),
(183, 1, 298, 101, 1),
(184, 1, 299, 101, 1),
(185, 2, 1, 101, 1),
(186, 2, 2, 401, 1),
(187, 2, 3, 301, 1),
(188, 2, 4, 303, 0),
(189, 2, 23, 601, 1),
(190, 2, 6, 303, 1),
(191, 2, 7, 502, 0),
(192, 2, 8, 502, 1),
(193, 2, 9, 502, 1),
(194, 2, 10, 502, 1),
(195, 2, 11, 502, 1),
(196, 2, 12, 502, 0),
(197, 2, 13, 202, 1),
(198, 2, 14, 202, 0),
(199, 2, 15, 202, 1),
(200, 2, 16, 202, 1),
(201, 2, 17, 202, 1),
(202, 2, 18, 202, 1),
(203, 2, 19, 202, 0),
(204, 2, 20, 601, 0),
(205, 2, 21, 601, 0),
(206, 2, 22, 601, 0),
(207, 2, 24, 701, 1),
(208, 2, 25, 702, 1),
(209, 2, 26, 702, 1),
(210, 2, 27, 702, 0),
(211, 2, 28, 702, 0),
(212, 2, 29, 702, 0),
(213, 2, 30, 102, 0),
(214, 2, 31, 102, 0),
(215, 2, 32, 102, 0),
(216, 2, 33, 102, 0),
(217, 2, 34, 102, 1),
(218, 2, 35, 102, 1),
(219, 2, 36, 102, 1),
(220, 2, 149, 101, 0),
(221, 2, 148, 101, 0),
(222, 2, 49, 101, 1),
(223, 2, 147, 101, 0),
(224, 2, 146, 101, 0),
(225, 2, 145, 101, 0),
(226, 2, 144, 101, 0),
(227, 2, 143, 101, 0),
(228, 2, 205, 101, 1),
(229, 2, 204, 101, 1),
(230, 2, 203, 101, 1),
(231, 2, 202, 101, 1),
(232, 2, 201, 101, 1),
(233, 2, 200, 101, 1),
(234, 2, 199, 101, 1),
(235, 2, 198, 101, 1),
(236, 2, 197, 101, 1),
(237, 2, 196, 101, 1),
(238, 2, 195, 101, 1),
(239, 2, 194, 101, 1),
(240, 2, 193, 101, 1),
(241, 2, 192, 101, 1),
(242, 2, 191, 101, 1),
(243, 2, 190, 101, 1),
(244, 2, 80, 101, 1),
(245, 2, 189, 101, 1),
(246, 2, 188, 101, 1),
(247, 2, 187, 101, 1),
(248, 2, 186, 101, 1),
(249, 2, 185, 101, 0),
(250, 2, 184, 101, 1),
(251, 2, 183, 101, 1),
(252, 2, 182, 101, 1),
(253, 2, 181, 101, 1),
(254, 2, 180, 101, 1),
(255, 2, 179, 101, 1),
(256, 2, 178, 101, 1),
(257, 2, 177, 101, 1),
(258, 2, 176, 101, 1),
(259, 2, 175, 101, 1),
(260, 2, 174, 101, 1),
(261, 2, 173, 101, 1),
(262, 2, 108, 101, 1),
(263, 2, 109, 101, 1),
(264, 2, 110, 101, 1),
(265, 2, 111, 101, 1),
(266, 2, 112, 101, 1),
(267, 2, 113, 101, 1),
(268, 2, 114, 101, 1),
(269, 2, 122, 101, 0),
(270, 2, 123, 101, 0),
(271, 2, 124, 101, 0),
(272, 2, 125, 101, 0),
(273, 2, 126, 101, 0),
(274, 2, 127, 101, 0),
(275, 2, 128, 101, 0),
(276, 2, 206, 101, 1),
(277, 2, 207, 101, 1),
(278, 2, 208, 101, 1),
(279, 2, 209, 101, 1),
(280, 2, 210, 101, 1),
(281, 2, 211, 101, 1),
(282, 2, 212, 212, 1),
(283, 2, 213, 110, 1),
(284, 2, 214, 101, 1),
(285, 2, 215, 101, 1),
(286, 2, 216, 101, 1),
(287, 2, 217, 101, 1),
(288, 2, 218, 101, 1),
(289, 2, 219, 101, 1),
(290, 2, 220, 101, 1),
(291, 2, 221, 101, 0),
(292, 2, 222, 101, 1),
(293, 2, 223, 101, 1),
(294, 2, 287, 101, 1),
(295, 2, 286, 101, 1),
(296, 2, 285, 101, 1),
(297, 2, 284, 101, 1),
(298, 2, 283, 101, 1),
(299, 2, 282, 101, 1),
(300, 2, 281, 101, 1),
(301, 2, 280, 101, 1),
(570, 1, 315, 101, 1),
(303, 2, 278, 101, 1),
(304, 2, 277, 101, 1),
(305, 2, 276, 101, 1),
(306, 2, 275, 101, 1),
(307, 2, 274, 101, 1),
(308, 2, 273, 101, 1),
(309, 2, 272, 101, 1),
(310, 2, 271, 101, 1),
(311, 2, 270, 101, 1),
(312, 2, 269, 101, 1),
(313, 2, 268, 101, 1),
(314, 2, 236, 101, 1),
(315, 2, 267, 101, 1),
(316, 2, 266, 101, 1),
(317, 2, 265, 101, 1),
(318, 2, 264, 101, 1),
(319, 2, 263, 101, 1),
(320, 2, 262, 101, 1),
(321, 2, 261, 101, 1),
(322, 2, 260, 101, 1),
(323, 2, 259, 101, 1),
(324, 2, 258, 101, 1),
(325, 2, 257, 101, 1),
(326, 2, 256, 101, 1),
(327, 2, 255, 101, 1),
(328, 2, 254, 101, 1),
(329, 2, 253, 101, 1),
(330, 2, 252, 101, 1),
(331, 2, 251, 101, 1),
(332, 2, 250, 101, 1),
(333, 2, 249, 101, 1),
(334, 2, 224, 101, 1),
(335, 2, 225, 101, 1),
(336, 2, 226, 101, 1),
(337, 2, 227, 101, 1),
(338, 2, 228, 101, 1),
(339, 2, 229, 101, 1),
(340, 2, 230, 101, 1),
(341, 2, 231, 101, 1),
(342, 2, 232, 101, 1),
(343, 2, 233, 101, 1),
(344, 2, 234, 101, 1),
(345, 2, 247, 101, 1),
(346, 2, 246, 101, 1),
(347, 2, 245, 101, 1),
(348, 2, 244, 101, 1),
(349, 2, 243, 101, 1),
(350, 2, 242, 101, 1),
(351, 2, 241, 101, 1),
(352, 2, 240, 101, 1),
(353, 2, 239, 101, 1),
(354, 2, 238, 101, 1),
(355, 2, 237, 101, 1),
(356, 2, 235, 101, 1),
(357, 2, 288, 101, 1),
(358, 2, 289, 101, 1),
(359, 2, 290, 101, 1),
(360, 2, 291, 101, 1),
(361, 2, 292, 101, 1),
(362, 2, 293, 101, 1),
(363, 2, 294, 101, 1),
(364, 2, 295, 101, 1),
(365, 2, 296, 101, 1),
(366, 2, 297, 101, 1),
(367, 2, 298, 101, 1),
(368, 2, 299, 101, 1),
(369, 4, 1, 101, 1),
(370, 4, 2, 401, 0),
(371, 4, 3, 301, 0),
(372, 4, 4, 303, 0),
(373, 4, 23, 601, 1),
(374, 4, 6, 303, 0),
(375, 4, 7, 502, 0),
(376, 4, 8, 502, 0),
(377, 4, 9, 502, 0),
(378, 4, 10, 502, 0),
(379, 4, 11, 502, 0),
(380, 4, 12, 502, 0),
(381, 4, 13, 202, 0),
(382, 4, 14, 202, 0),
(383, 4, 15, 202, 0),
(384, 4, 16, 202, 0),
(385, 4, 17, 202, 0),
(386, 4, 18, 202, 0),
(387, 4, 19, 202, 0),
(388, 4, 20, 601, 0),
(389, 4, 21, 601, 0),
(390, 4, 22, 601, 0),
(391, 4, 24, 701, 0),
(392, 4, 25, 702, 0),
(393, 4, 26, 702, 0),
(394, 4, 27, 702, 0),
(395, 4, 28, 702, 0),
(396, 4, 29, 702, 0),
(397, 4, 30, 102, 0),
(398, 4, 31, 102, 0),
(399, 4, 32, 102, 0),
(400, 4, 33, 102, 0),
(401, 4, 34, 102, 0),
(402, 4, 35, 102, 0),
(403, 4, 36, 102, 1),
(404, 4, 149, 101, 0),
(405, 4, 148, 101, 0),
(406, 4, 49, 101, 0),
(407, 4, 147, 101, 0),
(408, 4, 146, 101, 0),
(409, 4, 145, 101, 0),
(410, 4, 144, 101, 0),
(411, 4, 143, 101, 0),
(412, 4, 205, 101, 0),
(413, 4, 204, 101, 0),
(414, 4, 203, 101, 0),
(415, 4, 202, 101, 0),
(416, 4, 201, 101, 0),
(417, 4, 200, 101, 0),
(418, 4, 199, 101, 0),
(419, 4, 198, 101, 0),
(420, 4, 197, 101, 0),
(421, 4, 196, 101, 0),
(422, 4, 195, 101, 0),
(423, 4, 194, 101, 0),
(424, 4, 193, 101, 0),
(425, 4, 192, 101, 0),
(426, 4, 191, 101, 0),
(427, 4, 190, 101, 0),
(428, 4, 80, 101, 0),
(429, 4, 189, 101, 0),
(430, 4, 188, 101, 0),
(431, 4, 187, 101, 0),
(432, 4, 186, 101, 0),
(433, 4, 185, 101, 0),
(434, 4, 184, 101, 0),
(435, 4, 183, 101, 0),
(436, 4, 182, 101, 0),
(437, 4, 181, 101, 0),
(438, 4, 180, 101, 0),
(439, 4, 179, 101, 0),
(440, 4, 178, 101, 0),
(441, 4, 177, 101, 0),
(442, 4, 176, 101, 0),
(443, 4, 175, 101, 0),
(444, 4, 174, 101, 0),
(445, 4, 173, 101, 0),
(446, 4, 108, 101, 1),
(447, 4, 109, 101, 1),
(448, 4, 110, 101, 1),
(449, 4, 111, 101, 1),
(450, 4, 112, 101, 0),
(451, 4, 113, 101, 1),
(452, 4, 114, 101, 1),
(453, 4, 122, 101, 0),
(454, 4, 123, 101, 0),
(455, 4, 124, 101, 0),
(456, 4, 125, 101, 0),
(457, 4, 126, 101, 0),
(458, 4, 127, 101, 0),
(459, 4, 128, 101, 0),
(460, 4, 206, 101, 0),
(461, 4, 207, 101, 0),
(462, 4, 208, 101, 0),
(463, 4, 209, 101, 0),
(464, 4, 210, 101, 0),
(465, 4, 211, 101, 0),
(466, 4, 212, 212, 0),
(467, 4, 213, 110, 1),
(468, 4, 214, 101, 1),
(469, 4, 215, 101, 1),
(470, 4, 216, 101, 1),
(471, 4, 217, 101, 1),
(472, 4, 218, 101, 1),
(473, 4, 219, 101, 1),
(474, 4, 220, 101, 1),
(475, 4, 221, 101, 0),
(476, 4, 222, 101, 1),
(477, 4, 223, 101, 0),
(478, 4, 287, 101, 1),
(479, 4, 286, 101, 1),
(480, 4, 285, 101, 1),
(481, 4, 284, 101, 1),
(482, 4, 283, 101, 1),
(483, 4, 282, 101, 0),
(484, 4, 281, 101, 1),
(485, 4, 280, 101, 1),
(569, 1, 314, 101, 1),
(487, 4, 278, 101, 0),
(488, 4, 277, 101, 1),
(489, 4, 276, 101, 1),
(490, 4, 275, 101, 1),
(491, 4, 274, 101, 0),
(492, 4, 273, 101, 1),
(493, 4, 272, 101, 1),
(494, 4, 271, 101, 1),
(495, 4, 270, 101, 1),
(496, 4, 269, 101, 0),
(497, 4, 268, 101, 1),
(498, 4, 236, 101, 0),
(499, 4, 267, 101, 1),
(500, 4, 266, 101, 1),
(501, 4, 265, 101, 0),
(502, 4, 264, 101, 1),
(503, 4, 263, 101, 1),
(504, 4, 262, 101, 1),
(505, 4, 261, 101, 0),
(506, 4, 260, 101, 0),
(507, 4, 259, 101, 0),
(508, 4, 258, 101, 0),
(509, 4, 257, 101, 0),
(510, 4, 256, 101, 0),
(511, 4, 255, 101, 0),
(512, 4, 254, 101, 0),
(513, 4, 253, 101, 0),
(514, 4, 252, 101, 0),
(515, 4, 251, 101, 0),
(516, 4, 250, 101, 0),
(517, 4, 249, 101, 0),
(518, 4, 224, 101, 0),
(519, 4, 225, 101, 0),
(520, 4, 226, 101, 0),
(521, 4, 227, 101, 0),
(522, 4, 228, 101, 0),
(523, 4, 229, 101, 0),
(524, 4, 230, 101, 0),
(525, 4, 231, 101, 0),
(526, 4, 232, 101, 0),
(527, 4, 233, 101, 0),
(528, 4, 234, 101, 0),
(529, 4, 247, 101, 0),
(530, 4, 246, 101, 0),
(531, 4, 245, 101, 0),
(532, 4, 244, 101, 0),
(533, 4, 243, 101, 0),
(534, 4, 242, 101, 0),
(535, 4, 241, 101, 0),
(536, 4, 240, 101, 0),
(537, 4, 239, 101, 0),
(538, 4, 238, 101, 0),
(539, 4, 237, 101, 0),
(540, 4, 235, 101, 1),
(541, 4, 288, 101, 1),
(542, 4, 289, 101, 1),
(543, 4, 290, 101, 1),
(544, 4, 291, 101, 0),
(545, 4, 292, 101, 1),
(546, 4, 293, 101, 1),
(547, 4, 294, 101, 1),
(548, 4, 295, 101, 0),
(549, 4, 296, 101, 1),
(550, 4, 297, 101, 1),
(551, 4, 298, 101, 1),
(552, 4, 299, 101, 1),
(553, 1, 300, 101, 1),
(554, 1, 301, 101, 1),
(555, 1, 302, 101, 1),
(556, 1, 303, 101, 1),
(557, 1, 304, 101, 1),
(558, 4, 304, 101, 1),
(559, 2, 304, 101, 1),
(560, 1, 305, 101, 1),
(561, 1, 306, 101, 1),
(562, 1, 307, 101, 1),
(563, 1, 308, 101, 1),
(564, 1, 309, 101, 1),
(565, 1, 310, 101, 1),
(566, 1, 311, 101, 1),
(567, 1, 312, 101, 1),
(568, 1, 313, 101, 1),
(572, 1, 317, 101, 1),
(573, 1, 318, 101, 1),
(574, 1, 319, 101, 1),
(575, 1, 320, 101, 1),
(576, 1, 321, 101, 1),
(577, 1, 322, 101, 1),
(578, 1, 323, 101, 1),
(579, 1, 324, 101, 1),
(580, 1, 325, 101, 1),
(581, 1, 326, 101, 1),
(582, 1, 327, 101, 1),
(583, 1, 328, 101, 1),
(584, 1, 329, 101, 1),
(585, 1, 330, 101, 1),
(586, 1, 331, 101, 1),
(587, 1, 332, 101, 1),
(588, 1, 333, 101, 1),
(589, 1, 334, 101, 1),
(590, 1, 335, 101, 1),
(591, 1, 336, 101, 1),
(592, 1, 337, 101, 1),
(593, 1, 338, 101, 1),
(594, 1, 339, 101, 1),
(595, 1, 340, 101, 1),
(596, 1, 341, 101, 1),
(597, 1, 342, 101, 1),
(598, 1, 343, 101, 1),
(599, 1, 344, 101, 1),
(600, 1, 345, 101, 1),
(601, 1, 346, 101, 1),
(602, 1, 347, 101, 1),
(603, 1, 348, 101, 1),
(604, 1, 349, 101, 1),
(605, 1, 350, 101, 1),
(606, 1, 351, 101, 1),
(607, 1, 352, 101, 1),
(608, 1, 353, 101, 1),
(609, 1, 354, 101, 1),
(610, 1, 355, 101, 1),
(611, 1, 356, 101, 1),
(612, 1, 357, 101, 1),
(613, 1, 358, 101, 1),
(614, 1, 359, 101, 1),
(619, 1, 364, 101, 1),
(620, 1, 365, 101, 1),
(621, 1, 366, 101, 1),
(622, 1, 367, 101, 1),
(623, 1, 368, 101, 1),
(624, 1, 369, 101, 1),
(625, 1, 370, 101, 1),
(626, 1, 371, 101, 1),
(627, 1, 372, 101, 1),
(628, 1, 373, 101, 1),
(629, 1, 374, 101, 1),
(630, 1, 375, 101, 1),
(631, 1, 376, 101, 1),
(632, 1, 377, 101, 1),
(633, 1, 378, 101, 1),
(634, 1, 379, 101, 1),
(635, 1, 380, 101, 1),
(636, 1, 380, 101, 1),
(637, 1, 381, 101, 1),
(638, 1, 382, 101, 1),
(639, 1, 383, 101, 1),
(640, 1, 384, 101, 1),
(641, 1, 385, 101, 1),
(642, 1, 386, 101, 1),
(643, 1, 387, 101, 1),
(644, 1, 388, 101, 1),
(645, 1, 389, 101, 1),
(646, 1, 390, 101, 1),
(647, 1, 391, 101, 1),
(648, 1, 392, 101, 1),
(649, 1, 393, 101, 1),
(650, 1, 394, 101, 1),
(651, 1, 395, 101, 1),
(652, 1, 396, 101, 1),
(653, 1, 397, 101, 1),
(654, 1, 398, 101, 1),
(655, 1, 399, 101, 1),
(656, 1, 400, 101, 1),
(657, 1, 401, 101, 1),
(658, 1, 402, 101, 1),
(659, 1, 403, 101, 1),
(660, 1, 404, 101, 1),
(661, 1, 405, 101, 1),
(662, 1, 406, 101, 1),
(663, 1, 407, 101, 1),
(664, 2, 316, 101, 0),
(665, 2, 315, 101, 0),
(666, 2, 314, 101, 0),
(667, 2, 300, 101, 0),
(668, 2, 301, 101, 0),
(669, 2, 302, 101, 0),
(670, 2, 303, 101, 0),
(671, 2, 305, 101, 1),
(672, 2, 306, 101, 1),
(673, 2, 307, 101, 1),
(674, 2, 308, 101, 1),
(675, 2, 309, 101, 1),
(676, 2, 310, 101, 1),
(677, 2, 311, 101, 1),
(678, 2, 312, 101, 1),
(679, 2, 313, 101, 1),
(680, 2, 317, 101, 0),
(681, 2, 318, 101, 0),
(682, 2, 319, 101, 0),
(683, 2, 320, 101, 0),
(684, 2, 321, 101, 1),
(685, 2, 322, 101, 1),
(686, 2, 323, 101, 1),
(687, 2, 324, 101, 1),
(688, 2, 325, 101, 1),
(689, 2, 326, 101, 1),
(690, 2, 327, 101, 1),
(691, 2, 328, 101, 1),
(692, 2, 329, 101, 0),
(693, 2, 330, 101, 0),
(694, 2, 331, 101, 0),
(695, 2, 332, 101, 0),
(696, 2, 333, 101, 1),
(697, 2, 334, 101, 1),
(698, 2, 335, 101, 1),
(699, 2, 336, 101, 1),
(700, 2, 337, 101, 1),
(701, 2, 338, 101, 1),
(702, 2, 339, 101, 1),
(703, 2, 340, 101, 1),
(704, 2, 341, 101, 1),
(705, 2, 342, 101, 0),
(706, 2, 343, 101, 0),
(707, 2, 344, 101, 0),
(708, 2, 345, 101, 0),
(709, 2, 346, 101, 0),
(710, 2, 347, 101, 0),
(711, 2, 348, 101, 0),
(712, 2, 349, 101, 0),
(713, 2, 350, 101, 0),
(714, 2, 351, 101, 0),
(715, 2, 352, 101, 0),
(716, 2, 353, 101, 1),
(717, 2, 354, 101, 1),
(718, 2, 355, 101, 1),
(719, 2, 356, 101, 1),
(720, 2, 357, 101, 1),
(721, 2, 358, 101, 1),
(722, 2, 359, 101, 1),
(723, 2, 364, 101, 1),
(724, 2, 365, 101, 1),
(725, 2, 366, 101, 1),
(726, 2, 367, 101, 1),
(727, 2, 368, 101, 1),
(728, 2, 369, 101, 1),
(729, 2, 370, 101, 1),
(730, 2, 371, 101, 1),
(731, 2, 372, 101, 1),
(732, 2, 373, 101, 1),
(733, 2, 374, 101, 1),
(734, 2, 375, 101, 1),
(735, 2, 376, 101, 1),
(736, 2, 377, 101, 1),
(737, 2, 378, 101, 1),
(738, 2, 379, 101, 0),
(739, 2, 380, 101, 0),
(740, 2, 380, 101, 0),
(741, 2, 381, 101, 0),
(742, 2, 382, 101, 0),
(743, 2, 383, 101, 0),
(744, 2, 384, 101, 0),
(745, 2, 385, 101, 0),
(746, 2, 386, 101, 0),
(747, 2, 387, 101, 0),
(748, 2, 388, 101, 1),
(749, 2, 389, 101, 1),
(750, 2, 390, 101, 1),
(751, 2, 391, 101, 1),
(752, 2, 392, 101, 1),
(753, 2, 393, 101, 1),
(754, 2, 394, 101, 1),
(755, 2, 395, 101, 1),
(756, 2, 396, 101, 1),
(757, 2, 397, 101, 1),
(758, 2, 398, 101, 1),
(759, 2, 399, 101, 1),
(760, 2, 400, 101, 1),
(761, 2, 401, 101, 1),
(762, 2, 402, 101, 1),
(763, 2, 403, 101, 1),
(764, 2, 404, 101, 1),
(765, 2, 405, 101, 1),
(766, 2, 406, 101, 1),
(767, 2, 407, 101, 1),
(768, 3, 1, 101, 1),
(769, 3, 2, 101, 0),
(770, 3, 3, 101, 0),
(771, 3, 4, 101, 0),
(772, 3, 23, 101, 0),
(773, 3, 6, 101, 0),
(774, 3, 7, 101, 0),
(775, 3, 8, 101, 0),
(776, 3, 9, 101, 0),
(777, 3, 10, 101, 0),
(778, 3, 11, 101, 0),
(779, 3, 12, 101, 0),
(780, 3, 13, 101, 0),
(781, 3, 14, 101, 0),
(782, 3, 15, 101, 0),
(783, 3, 16, 101, 0),
(784, 3, 17, 101, 0),
(785, 3, 18, 101, 0),
(786, 3, 19, 101, 0),
(787, 3, 20, 101, 0),
(788, 3, 21, 101, 0),
(789, 3, 22, 101, 0),
(790, 3, 24, 101, 0),
(791, 3, 25, 101, 0),
(792, 3, 26, 101, 0),
(793, 3, 27, 101, 0),
(794, 3, 28, 101, 0),
(795, 3, 29, 101, 0),
(796, 3, 30, 101, 0),
(797, 3, 31, 101, 0),
(798, 3, 32, 101, 0),
(799, 3, 33, 101, 0),
(800, 3, 34, 101, 0),
(801, 3, 35, 101, 0),
(802, 3, 36, 101, 0),
(803, 3, 149, 101, 0),
(804, 3, 148, 101, 0),
(805, 3, 49, 101, 0),
(806, 3, 147, 101, 0),
(807, 3, 146, 101, 0),
(808, 3, 145, 101, 0),
(809, 3, 144, 101, 0),
(810, 3, 143, 101, 0),
(811, 3, 205, 101, 0),
(812, 3, 204, 101, 0),
(813, 3, 203, 101, 0),
(814, 3, 202, 101, 0),
(815, 3, 201, 101, 0),
(816, 3, 200, 101, 0),
(817, 3, 199, 101, 0),
(818, 3, 198, 101, 0),
(819, 3, 197, 101, 0),
(820, 3, 196, 101, 0),
(821, 3, 195, 101, 0),
(822, 3, 194, 101, 0),
(823, 3, 193, 101, 0),
(824, 3, 192, 101, 0),
(825, 3, 191, 101, 0),
(826, 3, 190, 101, 0),
(827, 3, 80, 101, 0),
(828, 3, 189, 101, 0),
(829, 3, 188, 101, 0),
(830, 3, 187, 101, 0),
(831, 3, 186, 101, 0),
(832, 3, 185, 101, 0),
(833, 3, 184, 101, 0),
(834, 3, 183, 101, 0),
(835, 3, 182, 101, 0),
(836, 3, 181, 101, 0),
(837, 3, 180, 101, 0),
(838, 3, 179, 101, 0),
(839, 3, 178, 101, 0),
(840, 3, 177, 101, 0),
(841, 3, 176, 101, 0),
(842, 3, 175, 101, 0),
(843, 3, 174, 101, 0),
(844, 3, 173, 101, 0),
(845, 3, 108, 101, 0),
(846, 3, 109, 101, 0),
(847, 3, 110, 101, 0),
(848, 3, 111, 101, 0),
(849, 3, 112, 101, 0),
(850, 3, 113, 101, 0),
(851, 3, 114, 101, 0),
(852, 3, 122, 101, 0),
(853, 3, 123, 101, 0),
(854, 3, 124, 101, 0),
(855, 3, 125, 101, 0),
(856, 3, 126, 101, 0),
(857, 3, 127, 101, 0),
(858, 3, 128, 101, 0),
(859, 3, 206, 101, 0),
(860, 3, 207, 101, 0),
(861, 3, 208, 101, 0),
(862, 3, 209, 101, 0),
(863, 3, 210, 101, 0),
(864, 3, 211, 101, 0),
(865, 3, 212, 101, 0),
(866, 3, 213, 101, 0),
(867, 3, 214, 101, 0),
(868, 3, 215, 101, 0),
(869, 3, 216, 101, 0),
(870, 3, 217, 101, 0),
(871, 3, 218, 101, 0),
(872, 3, 219, 101, 0),
(873, 3, 220, 101, 0),
(874, 3, 221, 101, 0),
(875, 3, 222, 101, 0),
(876, 3, 223, 101, 0),
(877, 3, 287, 101, 0),
(878, 3, 286, 101, 0),
(879, 3, 285, 101, 0),
(880, 3, 284, 101, 0),
(881, 3, 283, 101, 0),
(882, 3, 282, 101, 0),
(883, 3, 281, 101, 0),
(884, 3, 280, 101, 0),
(885, 3, 316, 101, 0),
(886, 3, 278, 101, 0),
(887, 3, 277, 101, 0),
(888, 3, 276, 101, 0),
(889, 3, 275, 101, 0),
(890, 3, 274, 101, 0),
(891, 3, 273, 101, 0),
(892, 3, 272, 101, 0),
(893, 3, 271, 101, 0),
(894, 3, 270, 101, 0),
(895, 3, 269, 101, 0),
(896, 3, 268, 101, 0),
(897, 3, 236, 101, 0),
(898, 3, 267, 101, 0),
(899, 3, 266, 101, 0),
(900, 3, 265, 101, 0),
(901, 3, 264, 101, 0),
(902, 3, 263, 101, 0),
(903, 3, 262, 101, 0),
(904, 3, 261, 101, 0),
(905, 3, 260, 101, 0),
(906, 3, 259, 101, 0),
(907, 3, 258, 101, 0),
(908, 3, 257, 101, 0),
(909, 3, 256, 101, 0),
(910, 3, 255, 101, 0),
(911, 3, 254, 101, 0),
(912, 3, 253, 101, 0),
(913, 3, 252, 101, 0),
(914, 3, 251, 101, 0),
(915, 3, 250, 101, 0),
(916, 3, 249, 101, 0),
(917, 3, 224, 101, 0),
(918, 3, 225, 101, 0),
(919, 3, 226, 101, 0),
(920, 3, 227, 101, 0),
(921, 3, 228, 101, 0),
(922, 3, 229, 101, 0),
(923, 3, 230, 101, 0),
(924, 3, 231, 101, 0),
(925, 3, 232, 101, 0),
(926, 3, 233, 101, 0),
(927, 3, 234, 101, 0),
(928, 3, 247, 101, 0),
(929, 3, 246, 101, 0),
(930, 3, 245, 101, 0),
(931, 3, 244, 101, 0),
(932, 3, 243, 101, 0),
(933, 3, 242, 101, 0),
(934, 3, 241, 101, 0),
(935, 3, 240, 101, 0),
(936, 3, 239, 101, 0),
(937, 3, 238, 101, 0),
(938, 3, 237, 101, 0),
(939, 3, 235, 101, 0),
(940, 3, 288, 101, 0),
(941, 3, 289, 101, 0),
(942, 3, 290, 101, 0),
(943, 3, 291, 101, 0),
(944, 3, 292, 101, 0),
(945, 3, 293, 101, 0),
(946, 3, 294, 101, 0),
(947, 3, 295, 101, 0),
(948, 3, 296, 101, 0),
(949, 3, 297, 101, 0),
(950, 3, 298, 101, 0),
(951, 3, 299, 101, 0),
(952, 3, 315, 101, 0),
(953, 3, 314, 101, 0),
(954, 3, 300, 101, 0),
(955, 3, 301, 101, 0),
(956, 3, 302, 101, 0),
(957, 3, 303, 101, 0),
(958, 3, 304, 101, 0),
(959, 3, 305, 101, 0),
(960, 3, 306, 101, 0),
(961, 3, 307, 101, 0),
(962, 3, 308, 101, 0),
(963, 3, 309, 101, 0),
(964, 3, 310, 101, 0),
(965, 3, 311, 101, 0),
(966, 3, 312, 101, 0),
(967, 3, 313, 101, 1),
(968, 3, 317, 101, 0),
(969, 3, 318, 101, 0),
(970, 3, 319, 101, 0),
(971, 3, 320, 101, 0),
(972, 3, 321, 101, 0),
(973, 3, 322, 101, 0),
(974, 3, 323, 101, 0),
(975, 3, 324, 101, 0),
(976, 3, 325, 101, 0),
(977, 3, 326, 101, 0),
(978, 3, 327, 101, 0),
(979, 3, 328, 101, 0),
(980, 3, 329, 101, 0),
(981, 3, 330, 101, 0),
(982, 3, 331, 101, 0),
(983, 3, 332, 101, 0),
(984, 3, 333, 101, 0),
(985, 3, 334, 101, 0),
(986, 3, 335, 101, 0),
(987, 3, 336, 101, 0),
(988, 3, 337, 101, 0),
(989, 3, 338, 101, 0),
(990, 3, 339, 101, 0),
(991, 3, 340, 101, 0),
(992, 3, 341, 101, 0),
(993, 3, 342, 101, 0),
(994, 3, 343, 101, 0),
(995, 3, 344, 101, 0),
(996, 3, 345, 101, 0),
(997, 3, 346, 101, 0),
(998, 3, 347, 101, 0),
(999, 3, 348, 101, 0),
(1000, 3, 349, 101, 0),
(1001, 3, 350, 101, 0),
(1002, 3, 351, 101, 0),
(1003, 3, 352, 101, 0),
(1004, 3, 353, 101, 0),
(1005, 3, 354, 101, 0),
(1006, 3, 355, 101, 0),
(1007, 3, 356, 101, 0),
(1008, 3, 357, 101, 0),
(1009, 3, 358, 101, 0),
(1010, 3, 359, 101, 0),
(1011, 3, 364, 101, 0),
(1012, 3, 365, 101, 0),
(1013, 3, 366, 101, 0),
(1014, 3, 367, 101, 0),
(1015, 3, 368, 101, 0),
(1016, 3, 369, 101, 0),
(1017, 3, 370, 101, 0),
(1018, 3, 371, 101, 0),
(1019, 3, 372, 101, 0),
(1020, 3, 373, 101, 0),
(1021, 3, 374, 101, 0),
(1022, 3, 375, 101, 0),
(1023, 3, 376, 101, 0),
(1024, 3, 377, 101, 0),
(1025, 3, 378, 101, 0),
(1026, 3, 379, 101, 0),
(1027, 3, 380, 101, 0),
(1028, 3, 380, 101, 0),
(1029, 3, 381, 101, 0),
(1030, 3, 382, 101, 0),
(1031, 3, 383, 101, 0),
(1032, 3, 384, 101, 0),
(1033, 3, 385, 101, 0),
(1034, 3, 386, 101, 0),
(1035, 3, 387, 101, 0),
(1036, 3, 388, 101, 0),
(1037, 3, 389, 101, 0),
(1038, 3, 390, 101, 0),
(1039, 3, 391, 101, 0),
(1040, 3, 392, 101, 0),
(1041, 3, 393, 101, 0),
(1042, 3, 394, 101, 0),
(1043, 3, 395, 101, 0),
(1044, 3, 396, 101, 0),
(1045, 3, 397, 101, 0),
(1046, 3, 398, 101, 0),
(1047, 3, 399, 101, 0),
(1048, 3, 400, 101, 0),
(1049, 3, 401, 101, 0),
(1050, 3, 402, 101, 0),
(1051, 3, 403, 101, 0),
(1052, 3, 404, 101, 0),
(1053, 3, 405, 101, 0),
(1054, 3, 406, 101, 0),
(1055, 3, 407, 101, 0),
(1056, 1, 408, 101, 1),
(1057, 1, 409, 101, 1),
(1058, 1, 410, 101, 1),
(1059, 2, 408, 101, 0),
(1060, 2, 409, 101, 0),
(1061, 2, 410, 101, 0),
(1062, 1, 411, 101, 1),
(1063, 1, 412, 101, 1),
(1064, 1, 413, 101, 1),
(1065, 2, 411, 101, 1),
(1066, 2, 412, 101, 1),
(1067, 2, 413, 101, 1),
(1068, 1, 414, 101, 1),
(1069, 2, 414, 101, 1),
(1070, 6, 1, 101, 0),
(1071, 6, 2, 101, 0),
(1072, 6, 3, 101, 0),
(1073, 6, 4, 101, 0),
(1074, 6, 23, 101, 0),
(1075, 6, 6, 101, 0),
(1076, 6, 7, 101, 0),
(1077, 6, 8, 101, 0),
(1078, 6, 9, 101, 0),
(1079, 6, 10, 101, 0),
(1080, 6, 11, 101, 0),
(1081, 6, 12, 101, 0),
(1082, 6, 13, 101, 0),
(1083, 6, 14, 101, 0),
(1084, 6, 15, 101, 0),
(1085, 6, 16, 101, 0),
(1086, 6, 17, 101, 0),
(1087, 6, 18, 101, 0),
(1088, 6, 19, 101, 0),
(1089, 6, 20, 101, 0),
(1090, 6, 21, 101, 0),
(1091, 6, 22, 101, 0),
(1092, 6, 24, 101, 0),
(1093, 6, 25, 101, 0),
(1094, 6, 26, 101, 0),
(1095, 6, 27, 101, 0),
(1096, 6, 28, 101, 0),
(1097, 6, 29, 101, 0),
(1098, 6, 30, 101, 0),
(1099, 6, 31, 101, 0),
(1100, 6, 32, 101, 0),
(1101, 6, 33, 101, 0),
(1102, 6, 34, 101, 0),
(1103, 6, 35, 101, 0),
(1104, 6, 36, 101, 0),
(1105, 6, 149, 101, 0),
(1106, 6, 148, 101, 0),
(1107, 6, 49, 101, 0),
(1108, 6, 147, 101, 0),
(1109, 6, 146, 101, 0),
(1110, 6, 145, 101, 0),
(1111, 6, 144, 101, 0),
(1112, 6, 143, 101, 0),
(1113, 6, 205, 101, 0),
(1114, 6, 204, 101, 0),
(1115, 6, 203, 101, 0),
(1116, 6, 202, 101, 0),
(1117, 6, 201, 101, 0),
(1118, 6, 200, 101, 0),
(1119, 6, 199, 101, 0),
(1120, 6, 198, 101, 0),
(1121, 6, 197, 101, 0),
(1122, 6, 196, 101, 0),
(1123, 6, 195, 101, 0),
(1124, 6, 194, 101, 0),
(1125, 6, 193, 101, 0),
(1126, 6, 192, 101, 0),
(1127, 6, 191, 101, 0),
(1128, 6, 190, 101, 0),
(1129, 6, 80, 101, 0),
(1130, 6, 189, 101, 0),
(1131, 6, 188, 101, 0),
(1132, 6, 187, 101, 0),
(1133, 6, 186, 101, 0),
(1134, 6, 185, 101, 0),
(1135, 6, 184, 101, 0),
(1136, 6, 183, 101, 0),
(1137, 6, 182, 101, 0),
(1138, 6, 181, 101, 0),
(1139, 6, 180, 101, 0),
(1140, 6, 179, 101, 0),
(1141, 6, 178, 101, 0),
(1142, 6, 177, 101, 0),
(1143, 6, 176, 101, 0),
(1144, 6, 175, 101, 0),
(1145, 6, 174, 101, 0),
(1146, 6, 173, 101, 0),
(1147, 6, 108, 101, 0),
(1148, 6, 109, 101, 0),
(1149, 6, 110, 101, 0),
(1150, 6, 111, 101, 0),
(1151, 6, 112, 101, 0),
(1152, 6, 113, 101, 0),
(1153, 6, 114, 101, 0),
(1154, 6, 122, 101, 0),
(1155, 6, 123, 101, 0),
(1156, 6, 124, 101, 0),
(1157, 6, 125, 101, 0),
(1158, 6, 126, 101, 0),
(1159, 6, 127, 101, 0),
(1160, 6, 128, 101, 0),
(1161, 6, 206, 101, 0),
(1162, 6, 207, 101, 0),
(1163, 6, 208, 101, 0),
(1164, 6, 209, 101, 0),
(1165, 6, 210, 101, 0),
(1166, 6, 211, 101, 0),
(1167, 6, 212, 101, 0),
(1168, 6, 213, 101, 0),
(1169, 6, 214, 101, 0),
(1170, 6, 215, 101, 0),
(1171, 6, 216, 101, 0),
(1172, 6, 217, 101, 0),
(1173, 6, 218, 101, 0),
(1174, 6, 219, 101, 0),
(1175, 6, 220, 101, 0),
(1176, 6, 221, 101, 0),
(1177, 6, 222, 101, 0),
(1178, 6, 223, 101, 0),
(1179, 6, 287, 101, 0),
(1180, 6, 286, 101, 0),
(1181, 6, 285, 101, 0),
(1182, 6, 284, 101, 0),
(1183, 6, 283, 101, 0),
(1184, 6, 282, 101, 0),
(1185, 6, 281, 101, 0),
(1186, 6, 280, 101, 0),
(1187, 6, 316, 101, 0),
(1188, 6, 278, 101, 0),
(1189, 6, 277, 101, 0),
(1190, 6, 276, 101, 0),
(1191, 6, 275, 101, 0),
(1192, 6, 274, 101, 0),
(1193, 6, 273, 101, 0),
(1194, 6, 272, 101, 0),
(1195, 6, 271, 101, 0),
(1196, 6, 270, 101, 0),
(1197, 6, 269, 101, 0),
(1198, 6, 268, 101, 0),
(1199, 6, 236, 101, 0),
(1200, 6, 267, 101, 0),
(1201, 6, 266, 101, 0),
(1202, 6, 265, 101, 0),
(1203, 6, 264, 101, 0),
(1204, 6, 263, 101, 0),
(1205, 6, 262, 101, 0),
(1206, 6, 261, 101, 0),
(1207, 6, 260, 101, 0),
(1208, 6, 259, 101, 0),
(1209, 6, 258, 101, 0),
(1210, 6, 257, 101, 0),
(1211, 6, 256, 101, 0),
(1212, 6, 255, 101, 0),
(1213, 6, 254, 101, 0),
(1214, 6, 253, 101, 0),
(1215, 6, 252, 101, 0),
(1216, 6, 251, 101, 0),
(1217, 6, 250, 101, 0),
(1218, 6, 249, 101, 0),
(1219, 6, 224, 101, 0),
(1220, 6, 225, 101, 0),
(1221, 6, 226, 101, 0),
(1222, 6, 227, 101, 0),
(1223, 6, 228, 101, 0),
(1224, 6, 229, 101, 0),
(1225, 6, 230, 101, 0),
(1226, 6, 231, 101, 0),
(1227, 6, 232, 101, 0),
(1228, 6, 233, 101, 0),
(1229, 6, 234, 101, 0),
(1230, 6, 247, 101, 0),
(1231, 6, 246, 101, 0),
(1232, 6, 245, 101, 0),
(1233, 6, 244, 101, 0),
(1234, 6, 243, 101, 0),
(1235, 6, 242, 101, 0),
(1236, 6, 241, 101, 0),
(1237, 6, 240, 101, 0),
(1238, 6, 239, 101, 0),
(1239, 6, 238, 101, 0),
(1240, 6, 237, 101, 0),
(1241, 6, 235, 101, 0),
(1242, 6, 288, 101, 0),
(1243, 6, 289, 101, 0),
(1244, 6, 290, 101, 0),
(1245, 6, 291, 101, 0),
(1246, 6, 292, 101, 0),
(1247, 6, 293, 101, 0),
(1248, 6, 294, 101, 0),
(1249, 6, 295, 101, 0),
(1250, 6, 296, 101, 0),
(1251, 6, 297, 101, 0),
(1252, 6, 298, 101, 0),
(1253, 6, 299, 101, 0),
(1254, 6, 315, 101, 0),
(1255, 6, 314, 101, 0),
(1256, 6, 300, 101, 0),
(1257, 6, 301, 101, 0),
(1258, 6, 302, 101, 0),
(1259, 6, 303, 101, 0),
(1260, 6, 304, 101, 0),
(1261, 6, 305, 101, 0),
(1262, 6, 306, 101, 0),
(1263, 6, 307, 101, 0),
(1264, 6, 308, 101, 0),
(1265, 6, 309, 101, 0),
(1266, 6, 310, 101, 0),
(1267, 6, 311, 101, 0),
(1268, 6, 312, 101, 0),
(1269, 6, 313, 101, 1),
(1270, 6, 317, 101, 0),
(1271, 6, 318, 101, 0),
(1272, 6, 319, 101, 0),
(1273, 6, 320, 101, 0),
(1274, 6, 321, 101, 0),
(1275, 6, 322, 101, 0),
(1276, 6, 323, 101, 0),
(1277, 6, 324, 101, 0),
(1278, 6, 325, 101, 0),
(1279, 6, 326, 101, 0),
(1280, 6, 327, 101, 0),
(1281, 6, 328, 101, 0),
(1282, 6, 329, 101, 0),
(1283, 6, 330, 101, 0),
(1284, 6, 331, 101, 0),
(1285, 6, 332, 101, 0),
(1286, 6, 333, 101, 0),
(1287, 6, 334, 101, 0),
(1288, 6, 335, 101, 0),
(1289, 6, 336, 101, 0),
(1290, 6, 337, 101, 0),
(1291, 6, 338, 101, 0),
(1292, 6, 339, 101, 0),
(1293, 6, 340, 101, 0),
(1294, 6, 341, 101, 0),
(1295, 6, 342, 101, 0),
(1296, 6, 343, 101, 0),
(1297, 6, 344, 101, 0),
(1298, 6, 345, 101, 0),
(1299, 6, 346, 101, 0),
(1300, 6, 347, 101, 0),
(1301, 6, 348, 101, 0),
(1302, 6, 349, 101, 0),
(1303, 6, 350, 101, 0),
(1304, 6, 351, 101, 0),
(1305, 6, 352, 101, 0),
(1306, 6, 353, 101, 0),
(1307, 6, 354, 101, 0),
(1308, 6, 355, 101, 0),
(1309, 6, 356, 101, 0),
(1310, 6, 357, 101, 0),
(1311, 6, 358, 101, 0),
(1312, 6, 359, 101, 0),
(1313, 6, 364, 101, 0),
(1314, 6, 365, 101, 0),
(1315, 6, 366, 101, 0),
(1316, 6, 367, 101, 0),
(1317, 6, 368, 101, 0),
(1318, 6, 369, 101, 0),
(1319, 6, 370, 101, 0),
(1320, 6, 371, 101, 0),
(1321, 6, 372, 101, 0),
(1322, 6, 373, 101, 0),
(1323, 6, 374, 101, 0),
(1324, 6, 375, 101, 0),
(1325, 6, 376, 101, 0),
(1326, 6, 377, 101, 0),
(1327, 6, 378, 101, 0),
(1328, 6, 379, 101, 0),
(1329, 6, 380, 101, 0),
(1330, 6, 380, 101, 0),
(1331, 6, 381, 101, 0),
(1332, 6, 382, 101, 0),
(1333, 6, 383, 101, 0),
(1334, 6, 384, 101, 0),
(1335, 6, 385, 101, 0),
(1336, 6, 386, 101, 0),
(1337, 6, 387, 101, 0),
(1338, 6, 388, 101, 0),
(1339, 6, 389, 101, 0),
(1340, 6, 390, 101, 0),
(1341, 6, 391, 101, 0),
(1342, 6, 392, 101, 0),
(1343, 6, 393, 101, 0),
(1344, 6, 394, 101, 0),
(1345, 6, 395, 101, 0),
(1346, 6, 396, 101, 0),
(1347, 6, 397, 101, 0),
(1348, 6, 398, 101, 0),
(1349, 6, 399, 101, 0),
(1350, 6, 400, 101, 0),
(1351, 6, 401, 101, 0),
(1352, 6, 402, 101, 0),
(1353, 6, 403, 101, 0),
(1354, 6, 404, 101, 0),
(1355, 6, 405, 101, 0),
(1356, 6, 406, 101, 0),
(1357, 6, 407, 101, 0),
(1358, 6, 408, 101, 0),
(1359, 6, 409, 101, 0),
(1360, 6, 410, 101, 0),
(1361, 6, 411, 101, 0),
(1362, 6, 412, 101, 0),
(1363, 6, 413, 101, 0),
(1364, 6, 414, 101, 1),
(1365, 1, 421, 101, 1),
(1366, 1, 422, 101, 1),
(1367, 1, 423, 101, 1),
(1368, 1, 424, 101, 1),
(1369, 1, 425, 101, 1),
(1370, 1, 426, 101, 1),
(1371, 1, 427, 101, 1),
(1372, 1, 428, 101, 1),
(1373, 1, 429, 101, 1),
(1374, 1, 430, 101, 1),
(1375, 1, 431, 101, 1),
(1376, 1, 432, 101, 1),
(1377, 1, 433, 101, 1),
(1378, 1, 434, 101, 1),
(1379, 1, 435, 101, 1),
(1380, 1, 436, 101, 1),
(1381, 1, 437, 101, 1),
(1382, 1, 438, 101, 1),
(1383, 1, 439, 101, 1),
(1384, 1, 440, 101, 1),
(1385, 1, 441, 101, 1),
(1386, 1, 442, 101, 1),
(1387, 1, 443, 101, 1),
(1388, 1, 444, 101, 1),
(1389, 1, 445, 101, 1),
(1390, 1, 446, 101, 1),
(1391, 2, 421, 101, 0),
(1392, 2, 422, 101, 0),
(1393, 2, 423, 101, 0),
(1394, 2, 424, 101, 0),
(1395, 2, 425, 101, 0),
(1396, 2, 426, 101, 0),
(1397, 2, 427, 101, 0),
(1398, 2, 428, 101, 0),
(1399, 2, 429, 101, 1),
(1400, 2, 430, 101, 1),
(1401, 2, 431, 101, 1),
(1402, 2, 432, 101, 1),
(1403, 2, 433, 101, 1),
(1404, 2, 434, 101, 1),
(1405, 2, 435, 101, 1),
(1406, 2, 436, 101, 1),
(1407, 2, 437, 101, 1),
(1408, 2, 438, 101, 0),
(1409, 2, 439, 101, 1),
(1410, 2, 440, 101, 1),
(1411, 2, 441, 101, 1),
(1412, 2, 442, 101, 1),
(1413, 2, 443, 101, 1),
(1414, 2, 444, 101, 1),
(1415, 2, 445, 101, 1),
(1416, 2, 446, 101, 1),
(1417, 1, 447, 101, 1),
(1418, 1, 448, 101, 1),
(1422, 1, 452, 101, 1),
(1423, 1, 453, 101, 1),
(1421, 1, 451, 101, 1),
(1424, 1, 454, 101, 1),
(1425, 1, 455, 101, 1),
(1426, 1, 456, 101, 1),
(1427, 1, 457, 101, 1),
(1428, 1, 458, 101, 1),
(1429, 4, 316, 101, 0),
(1430, 4, 315, 101, 0),
(1431, 4, 314, 101, 0),
(1432, 4, 300, 101, 0),
(1433, 4, 301, 101, 0),
(1434, 4, 302, 101, 0),
(1435, 4, 303, 101, 0),
(1436, 4, 305, 101, 0),
(1437, 4, 306, 101, 0),
(1438, 4, 307, 101, 0),
(1439, 4, 308, 101, 0),
(1440, 4, 309, 101, 0),
(1441, 4, 310, 101, 0),
(1442, 4, 311, 101, 0),
(1443, 4, 312, 101, 0),
(1444, 4, 313, 101, 1),
(1445, 4, 317, 101, 0),
(1446, 4, 318, 101, 0),
(1447, 4, 319, 101, 0),
(1448, 4, 320, 101, 0),
(1449, 4, 321, 101, 0),
(1450, 4, 322, 101, 0),
(1451, 4, 323, 101, 0),
(1452, 4, 324, 101, 0),
(1453, 4, 325, 101, 0),
(1454, 4, 326, 101, 0),
(1455, 4, 327, 101, 0),
(1456, 4, 328, 101, 0),
(1457, 4, 329, 101, 0),
(1458, 4, 330, 101, 0),
(1459, 4, 331, 101, 0),
(1460, 4, 332, 101, 0),
(1461, 4, 333, 101, 1),
(1462, 4, 334, 101, 1),
(1463, 4, 335, 101, 1),
(1464, 4, 336, 101, 0),
(1465, 4, 337, 101, 1),
(1466, 4, 338, 101, 1),
(1467, 4, 339, 101, 1),
(1468, 4, 340, 101, 1),
(1469, 4, 341, 101, 0),
(1470, 4, 342, 101, 0),
(1471, 4, 343, 101, 0),
(1472, 4, 344, 101, 0),
(1473, 4, 345, 101, 0),
(1474, 4, 346, 101, 0),
(1475, 4, 347, 101, 0),
(1476, 4, 348, 101, 0),
(1477, 4, 349, 101, 0),
(1478, 4, 350, 101, 0),
(1479, 4, 351, 101, 0),
(1480, 4, 352, 101, 0),
(1481, 4, 353, 101, 0),
(1482, 4, 354, 101, 1),
(1483, 4, 355, 101, 0),
(1484, 4, 356, 101, 0),
(1485, 4, 357, 101, 0),
(1486, 4, 358, 101, 0),
(1487, 4, 359, 101, 0),
(1488, 4, 364, 101, 0),
(1489, 4, 365, 101, 0),
(1490, 4, 366, 101, 0),
(1491, 4, 367, 101, 0),
(1492, 4, 368, 101, 0),
(1493, 4, 369, 101, 0),
(1494, 4, 370, 101, 0),
(1495, 4, 371, 101, 0),
(1496, 4, 372, 101, 1),
(1497, 4, 373, 101, 1),
(1498, 4, 374, 101, 1),
(1499, 4, 375, 101, 1),
(1500, 4, 376, 101, 1),
(1501, 4, 377, 101, 1),
(1502, 4, 378, 101, 1),
(1503, 4, 379, 101, 1),
(1504, 4, 380, 101, 0),
(1505, 4, 380, 101, 0),
(1506, 4, 381, 101, 0),
(1507, 4, 382, 101, 0),
(1508, 4, 383, 101, 0),
(1509, 4, 384, 101, 0),
(1510, 4, 385, 101, 0),
(1511, 4, 386, 101, 0),
(1512, 4, 387, 101, 0),
(1513, 4, 388, 101, 1),
(1514, 4, 389, 101, 0),
(1515, 4, 390, 101, 0),
(1516, 4, 391, 101, 0),
(1517, 4, 392, 101, 0),
(1518, 4, 393, 101, 0),
(1519, 4, 394, 101, 0),
(1520, 4, 395, 101, 0),
(1521, 4, 396, 101, 0),
(1522, 4, 397, 101, 0),
(1523, 4, 398, 101, 0),
(1524, 4, 399, 101, 0),
(1525, 4, 400, 101, 0),
(1526, 4, 401, 101, 0),
(1527, 4, 402, 101, 0),
(1528, 4, 403, 101, 0),
(1529, 4, 404, 101, 0),
(1530, 4, 405, 101, 0),
(1531, 4, 406, 101, 0),
(1532, 4, 407, 101, 0),
(1533, 4, 408, 101, 0),
(1534, 4, 409, 101, 0),
(1535, 4, 410, 101, 0),
(1536, 4, 411, 101, 0),
(1537, 4, 412, 101, 0),
(1538, 4, 413, 101, 0),
(1539, 4, 414, 101, 0),
(1540, 4, 421, 101, 0),
(1541, 4, 422, 101, 0),
(1542, 4, 423, 101, 0),
(1543, 4, 424, 101, 0),
(1544, 4, 425, 101, 0),
(1545, 4, 426, 101, 0),
(1546, 4, 427, 101, 0),
(1547, 4, 428, 101, 0),
(1548, 4, 429, 101, 0),
(1549, 4, 430, 101, 0),
(1550, 4, 431, 101, 0),
(1551, 4, 432, 101, 0),
(1552, 4, 433, 101, 0),
(1553, 4, 434, 101, 0),
(1554, 4, 435, 101, 0),
(1555, 4, 436, 101, 0),
(1556, 4, 437, 101, 0),
(1557, 4, 438, 101, 0),
(1558, 4, 439, 101, 0),
(1559, 4, 440, 101, 0),
(1560, 4, 441, 101, 0),
(1561, 4, 442, 101, 0),
(1562, 4, 443, 101, 0),
(1563, 4, 444, 101, 0),
(1564, 4, 445, 101, 0),
(1565, 4, 446, 101, 0),
(1566, 4, 447, 101, 0),
(1567, 4, 448, 101, 0),
(1568, 4, 452, 101, 0),
(1569, 4, 453, 101, 0),
(1570, 4, 451, 101, 0),
(1571, 4, 454, 101, 0),
(1572, 4, 455, 101, 1),
(1573, 4, 456, 101, 0),
(1574, 4, 457, 101, 1),
(1575, 4, 458, 101, 1),
(1576, 6, 421, 101, 0),
(1577, 6, 422, 101, 0),
(1578, 6, 423, 101, 0),
(1579, 6, 424, 101, 0),
(1580, 6, 425, 101, 0),
(1581, 6, 426, 101, 0),
(1582, 6, 427, 101, 0),
(1583, 6, 428, 101, 0),
(1584, 6, 429, 101, 0),
(1585, 6, 430, 101, 0),
(1586, 6, 431, 101, 0),
(1587, 6, 432, 101, 0),
(1588, 6, 433, 101, 0),
(1589, 6, 434, 101, 0),
(1590, 6, 435, 101, 0),
(1591, 6, 436, 101, 0),
(1592, 6, 437, 101, 0),
(1593, 6, 438, 101, 0),
(1594, 6, 439, 101, 0),
(1595, 6, 440, 101, 0),
(1596, 6, 441, 101, 0),
(1597, 6, 442, 101, 0),
(1598, 6, 443, 101, 0),
(1599, 6, 444, 101, 0),
(1600, 6, 445, 101, 0),
(1601, 6, 446, 101, 0),
(1602, 6, 447, 101, 0),
(1603, 6, 448, 101, 0),
(1604, 6, 452, 101, 0),
(1605, 6, 453, 101, 0),
(1606, 6, 451, 101, 0),
(1607, 6, 454, 101, 0),
(1608, 6, 455, 101, 0),
(1609, 6, 456, 101, 0),
(1610, 6, 457, 101, 0),
(1611, 6, 458, 101, 0),
(1612, 2, 447, 101, 1),
(1613, 2, 448, 101, 1),
(1614, 2, 452, 101, 1),
(1615, 2, 453, 101, 1),
(1616, 2, 451, 101, 1),
(1617, 2, 454, 101, 0),
(1618, 2, 455, 101, 0),
(1619, 2, 456, 101, 0),
(1620, 2, 457, 101, 0),
(1621, 2, 458, 101, 0),
(1622, 1, 459, 101, 1),
(1623, 1, 460, 101, 1),
(1624, 1, 461, 101, 1),
(1625, 1, 462, 101, 1),
(1626, 1, 463, 101, 1),
(1627, 1, 464, 101, 1),
(1628, 1, 465, 101, 1),
(1629, 1, 466, 101, 1),
(1630, 1, 467, 101, 1),
(1631, 1, 468, 101, 1),
(1632, 1, 469, 101, 1),
(1633, 1, 470, 101, 1),
(1634, 1, 471, 101, 1),
(1635, 1, 472, 101, 1),
(1636, 1, 473, 101, 1),
(1637, 1, 474, 101, 1),
(1638, 1, 475, 101, 1),
(1639, 1, 476, 101, 1),
(1640, 1, 477, 101, 1),
(1641, 1, 478, 101, 1),
(1642, 1, 479, 101, 1),
(1643, 1, 480, 101, 1),
(1644, 1, 481, 101, 1),
(1645, 1, 482, 101, 1),
(1646, 1, 483, 101, 1),
(1647, 1, 484, 101, 1),
(1656, 1, 495, 101, 1),
(1649, 1, 486, 101, 1),
(1650, 1, 487, 101, 1),
(1651, 1, 488, 101, 1),
(1652, 1, 489, 101, 1),
(1653, 1, 490, 101, 1),
(1654, 1, 491, 101, 1),
(1655, 1, 492, 101, 1),
(1657, 1, 496, 101, 1),
(1658, 1, 497, 101, 1),
(1659, 1, 498, 101, 1),
(1660, 1, 499, 101, 1),
(1661, 1, 500, 101, 1),
(1662, 1, 501, 101, 1),
(1663, 1, 493, 101, 1),
(1664, 1, 494, 101, 1),
(1665, 1, 503, 101, 1),
(1666, 1, 502, 101, 1),
(1667, 1, 504, 101, 1),
(1668, 1, 505, 101, 1),
(1669, 1, 506, 101, 1),
(1670, 1, 507, 101, 1),
(1671, 2, 459, 101, 0),
(1672, 2, 460, 101, 1),
(1673, 2, 461, 101, 1),
(1674, 2, 462, 101, 1),
(1675, 2, 463, 101, 1),
(1676, 2, 464, 101, 1),
(1677, 2, 465, 101, 1),
(1678, 2, 466, 101, 1),
(1679, 2, 467, 101, 1),
(1680, 2, 468, 101, 1),
(1681, 2, 469, 101, 1),
(1682, 2, 470, 101, 1),
(1683, 2, 471, 101, 1),
(1684, 2, 472, 101, 1),
(1685, 2, 473, 101, 1),
(1686, 2, 474, 101, 1),
(1687, 2, 475, 101, 1),
(1688, 2, 476, 101, 1),
(1689, 2, 477, 101, 1),
(1690, 2, 478, 101, 1),
(1691, 2, 479, 101, 1),
(1692, 2, 480, 101, 1),
(1693, 2, 481, 101, 1),
(1694, 2, 482, 101, 1),
(1695, 2, 483, 101, 1),
(1696, 2, 484, 101, 1),
(1697, 2, 495, 101, 1),
(1698, 2, 486, 101, 1),
(1699, 2, 487, 101, 1),
(1700, 2, 488, 101, 1),
(1701, 2, 489, 101, 1),
(1702, 2, 490, 101, 1),
(1703, 2, 491, 101, 1),
(1704, 2, 492, 101, 1),
(1705, 2, 496, 101, 1),
(1706, 2, 497, 101, 1),
(1707, 2, 498, 101, 1),
(1708, 2, 499, 101, 1),
(1709, 2, 500, 101, 1),
(1710, 2, 501, 101, 1),
(1711, 2, 493, 101, 0),
(1712, 2, 494, 101, 1),
(1713, 2, 503, 101, 1),
(1714, 2, 502, 101, 0),
(1715, 2, 504, 101, 1),
(1716, 2, 505, 101, 1),
(1717, 2, 506, 101, 1),
(1718, 2, 507, 101, 1),
(1719, 1, 508, 101, 1),
(1720, 1, 509, 101, 1),
(1721, 2, 509, 101, 1),
(1722, 2, 508, 101, 1),
(1723, 1, 510, 101, 1),
(1724, 1, 511, 101, 1),
(1725, 1, 512, 101, 1),
(1726, 1, 513, 101, 1),
(1727, 1, 514, 101, 1),
(1728, 1, 515, 101, 1),
(1729, 1, 516, 101, 1),
(1730, 1, 517, 101, 1),
(1731, 1, 518, 101, 1),
(1732, 1, 519, 101, 1),
(1733, 2, 519, 101, 1),
(1734, 1, 520, 101, 1),
(1735, 1, 521, 101, 1),
(1736, 1, 522, 101, 1),
(1737, 1, 523, 101, 1),
(1738, 1, 524, 101, 1),
(1739, 1, 525, 101, 1),
(1740, 1, 526, 101, 1),
(1741, 1, 527, 101, 1),
(1742, 1, 528, 101, 1),
(1743, 1, 529, 101, 1),
(1744, 1, 530, 101, 1),
(1745, 2, 510, 101, 1),
(1746, 2, 511, 101, 1),
(1747, 2, 512, 101, 1),
(1748, 2, 513, 101, 1),
(1749, 2, 514, 101, 1),
(1750, 2, 515, 101, 1),
(1751, 2, 516, 101, 1),
(1752, 2, 517, 101, 1),
(1753, 2, 518, 101, 1),
(1754, 2, 520, 101, 1),
(1755, 2, 521, 101, 1),
(1756, 2, 522, 101, 1),
(1757, 2, 523, 101, 1),
(1758, 2, 524, 101, 1),
(1759, 2, 525, 101, 1),
(1760, 2, 526, 101, 1),
(1761, 2, 527, 101, 1),
(1762, 2, 528, 101, 1),
(1763, 2, 529, 101, 1),
(1764, 2, 530, 101, 1),
(3105, 1, 551, 101, 1),
(3104, 1, 550, 101, 1),
(3103, 1, 549, 101, 1),
(3102, 1, 548, 101, 1),
(3101, 1, 547, 101, 1),
(3100, 1, 546, 101, 1),
(3099, 1, 545, 101, 1),
(3098, 1, 544, 101, 1),
(3097, 1, 543, 101, 1),
(3096, 1, 542, 101, 1),
(3095, 1, 541, 101, 1),
(3094, 1, 540, 101, 1),
(3093, 1, 539, 101, 1),
(3092, 1, 538, 101, 1),
(3091, 1, 537, 101, 1),
(3090, 1, 536, 101, 1),
(3089, 1, 535, 101, 1),
(3088, 1, 534, 101, 1),
(3087, 1, 533, 101, 1),
(3086, 1, 532, 101, 1),
(3085, 1, 531, 101, 1),
(3084, 7, 1, 101, 1),
(3083, 7, 2, 401, 1),
(3082, 7, 3, 301, 1),
(3081, 7, 4, 303, 0),
(3080, 7, 23, 601, 1),
(3079, 7, 6, 303, 1),
(3078, 7, 7, 502, 0),
(3077, 7, 8, 502, 1),
(3076, 7, 9, 502, 1),
(3075, 7, 10, 502, 1),
(3074, 7, 11, 502, 1),
(3073, 7, 12, 502, 0),
(3072, 7, 13, 202, 1),
(3071, 7, 14, 202, 0),
(3070, 7, 15, 202, 1),
(3069, 7, 16, 202, 1),
(3068, 7, 17, 202, 1),
(3067, 7, 18, 202, 1),
(3066, 7, 19, 202, 0),
(3065, 7, 20, 601, 0),
(3064, 7, 21, 601, 0),
(3063, 7, 22, 601, 0),
(3062, 7, 24, 701, 1),
(3061, 7, 25, 702, 1),
(3060, 7, 26, 702, 1),
(3059, 7, 27, 702, 0),
(3058, 7, 28, 702, 0),
(3057, 7, 29, 702, 0),
(3056, 7, 30, 102, 0),
(3055, 7, 31, 102, 0),
(3054, 7, 32, 102, 0),
(3053, 7, 33, 102, 0),
(3052, 7, 34, 102, 1),
(3051, 7, 35, 102, 1),
(3050, 7, 36, 102, 1),
(3049, 7, 149, 101, 0),
(3048, 7, 148, 101, 0),
(3047, 7, 49, 101, 1),
(3046, 7, 147, 101, 0),
(3045, 7, 146, 101, 0),
(3044, 7, 145, 101, 0),
(3043, 7, 144, 101, 0),
(3042, 7, 143, 101, 0),
(3041, 7, 205, 101, 1),
(3040, 7, 204, 101, 1),
(3039, 7, 203, 101, 1),
(3038, 7, 202, 101, 1),
(3037, 7, 201, 101, 1),
(3036, 7, 200, 101, 1),
(3035, 7, 199, 101, 1),
(3034, 7, 198, 101, 1),
(3033, 7, 197, 101, 1),
(3032, 7, 196, 101, 1),
(3031, 7, 195, 101, 1),
(3030, 7, 194, 101, 1),
(3029, 7, 193, 101, 1),
(3028, 7, 192, 101, 1),
(3027, 7, 191, 101, 1),
(3026, 7, 190, 101, 1),
(3025, 7, 80, 101, 1),
(3024, 7, 189, 101, 1),
(3023, 7, 188, 101, 1),
(3022, 7, 187, 101, 1),
(3021, 7, 186, 101, 1),
(3020, 7, 185, 101, 0),
(3019, 7, 184, 101, 1),
(3018, 7, 183, 101, 1),
(3017, 7, 182, 101, 1),
(3016, 7, 181, 101, 1),
(3015, 7, 180, 101, 1),
(3014, 7, 179, 101, 1),
(3013, 7, 178, 101, 1),
(3012, 7, 177, 101, 1),
(3011, 7, 176, 101, 1),
(3010, 7, 175, 101, 1),
(3009, 7, 174, 101, 1),
(3008, 7, 173, 101, 1),
(3007, 7, 108, 101, 1),
(3006, 7, 109, 101, 1),
(3005, 7, 110, 101, 1),
(3004, 7, 111, 101, 1),
(3003, 7, 112, 101, 1),
(3002, 7, 113, 101, 1),
(3001, 7, 114, 101, 1),
(3000, 7, 122, 101, 0),
(2999, 7, 123, 101, 0),
(2998, 7, 124, 101, 0),
(2997, 7, 125, 101, 0),
(2996, 7, 126, 101, 0),
(2995, 7, 127, 101, 0),
(2994, 7, 128, 101, 0),
(2993, 7, 206, 101, 1),
(2992, 7, 207, 101, 1),
(2991, 7, 208, 101, 1),
(2990, 7, 209, 101, 1),
(2989, 7, 210, 101, 1),
(2988, 7, 211, 101, 1),
(2987, 7, 212, 212, 1),
(2986, 7, 213, 110, 1),
(2985, 7, 214, 101, 0),
(2984, 7, 215, 101, 0),
(2983, 7, 216, 101, 0),
(2982, 7, 217, 101, 0),
(2981, 7, 218, 101, 0),
(2980, 7, 219, 101, 0),
(2979, 7, 220, 101, 0),
(2978, 7, 221, 101, 0),
(2977, 7, 222, 101, 0),
(2976, 7, 223, 101, 1),
(2975, 7, 287, 101, 1),
(2974, 7, 286, 101, 1),
(2973, 7, 285, 101, 1),
(2972, 7, 284, 101, 1),
(2971, 7, 283, 101, 1),
(2970, 7, 282, 101, 1),
(2969, 7, 281, 101, 1),
(2968, 7, 280, 101, 1),
(2967, 7, 278, 101, 0),
(2966, 7, 277, 101, 1),
(2965, 7, 276, 101, 1),
(2964, 7, 275, 101, 1),
(2963, 7, 274, 101, 1),
(2962, 7, 273, 101, 1),
(2961, 7, 272, 101, 1),
(2960, 7, 271, 101, 1),
(2959, 7, 270, 101, 1),
(2958, 7, 269, 101, 1),
(2957, 7, 268, 101, 1),
(2956, 7, 236, 101, 1),
(2955, 7, 267, 101, 1),
(2954, 7, 266, 101, 1),
(2953, 7, 265, 101, 1),
(2952, 7, 264, 101, 1),
(2951, 7, 263, 101, 1),
(2950, 7, 262, 101, 1),
(2949, 7, 261, 101, 1),
(2948, 7, 260, 101, 1),
(2947, 7, 259, 101, 1),
(2946, 7, 258, 101, 0),
(2945, 7, 257, 101, 0),
(2944, 7, 256, 101, 1),
(2943, 7, 255, 101, 1),
(2942, 7, 254, 101, 0),
(2941, 7, 253, 101, 1),
(2940, 7, 252, 101, 1),
(2939, 7, 251, 101, 1),
(2938, 7, 250, 101, 1),
(2937, 7, 249, 101, 1),
(2936, 7, 224, 101, 1),
(2935, 7, 225, 101, 1),
(2934, 7, 226, 101, 1),
(2933, 7, 227, 101, 1),
(2932, 7, 228, 101, 1),
(2931, 7, 229, 101, 1),
(2930, 7, 230, 101, 1),
(2929, 7, 231, 101, 1),
(2928, 7, 232, 101, 1),
(2927, 7, 233, 101, 1),
(2926, 7, 234, 101, 1),
(2925, 7, 247, 101, 1),
(2924, 7, 246, 101, 1),
(2923, 7, 245, 101, 1),
(2922, 7, 244, 101, 1),
(2921, 7, 243, 101, 1),
(2920, 7, 242, 101, 1),
(2919, 7, 241, 101, 1),
(2918, 7, 240, 101, 1),
(2917, 7, 239, 101, 1),
(2916, 7, 238, 101, 1),
(2915, 7, 237, 101, 1),
(2914, 7, 235, 101, 0),
(2913, 7, 288, 101, 0),
(2912, 7, 289, 101, 0),
(2911, 7, 290, 101, 0),
(2910, 7, 291, 101, 0),
(2909, 7, 292, 101, 0),
(2908, 7, 293, 101, 0),
(2907, 7, 294, 101, 0),
(2906, 7, 295, 101, 0),
(2905, 7, 296, 101, 0),
(2904, 7, 297, 101, 0),
(2903, 7, 298, 101, 0),
(2902, 7, 299, 101, 1),
(2901, 7, 304, 101, 1),
(2900, 7, 316, 101, 1),
(2899, 7, 315, 101, 1),
(2898, 7, 314, 101, 1),
(2897, 7, 300, 101, 0),
(2896, 7, 301, 101, 0),
(2895, 7, 302, 101, 0),
(2894, 7, 303, 101, 0),
(2893, 7, 305, 101, 0),
(2892, 7, 306, 101, 0),
(2891, 7, 307, 101, 0),
(2890, 7, 308, 101, 0),
(2889, 7, 309, 101, 0),
(2888, 7, 310, 101, 0),
(2887, 7, 311, 101, 0),
(2886, 7, 312, 101, 0),
(2885, 7, 313, 101, 1),
(2884, 7, 317, 101, 1),
(2883, 7, 318, 101, 1),
(2882, 7, 319, 101, 1),
(2881, 7, 320, 101, 1),
(2880, 7, 321, 101, 1),
(2879, 7, 322, 101, 1),
(2878, 7, 323, 101, 1),
(2877, 7, 324, 101, 1),
(2876, 7, 325, 101, 1),
(2875, 7, 326, 101, 1),
(2874, 7, 327, 101, 1),
(2873, 7, 328, 101, 1),
(2872, 7, 329, 101, 1),
(2871, 7, 330, 101, 0),
(2870, 7, 331, 101, 0),
(2869, 7, 332, 101, 0),
(2868, 7, 333, 101, 1),
(2867, 7, 334, 101, 1),
(2866, 7, 335, 101, 1),
(2865, 7, 336, 101, 1),
(2864, 7, 337, 101, 1),
(2863, 7, 338, 101, 1),
(2862, 7, 339, 101, 1),
(2861, 7, 340, 101, 1),
(2860, 7, 341, 101, 1),
(2859, 7, 342, 101, 1),
(2858, 7, 343, 101, 1),
(2857, 7, 344, 101, 1),
(2856, 7, 345, 101, 1),
(2855, 7, 346, 101, 1),
(2854, 7, 347, 101, 1),
(2853, 7, 348, 101, 1),
(2852, 7, 349, 101, 1),
(2851, 7, 350, 101, 1),
(2850, 7, 351, 101, 1),
(2849, 7, 352, 101, 1),
(2848, 7, 353, 101, 1),
(2847, 7, 354, 101, 1),
(2846, 7, 355, 101, 1),
(2845, 7, 356, 101, 1),
(2844, 7, 357, 101, 1),
(2843, 7, 358, 101, 1),
(2842, 7, 359, 101, 1),
(2841, 7, 364, 101, 1),
(2840, 7, 365, 101, 1),
(2839, 7, 366, 101, 1),
(2838, 7, 367, 101, 1),
(2837, 7, 368, 101, 1),
(2836, 7, 369, 101, 1),
(2835, 7, 370, 101, 1),
(2834, 7, 371, 101, 1),
(2833, 7, 372, 101, 1),
(2832, 7, 373, 101, 1),
(2831, 7, 374, 101, 1),
(2830, 7, 375, 101, 1),
(2829, 7, 376, 101, 1),
(2828, 7, 377, 101, 1),
(2827, 7, 378, 101, 1),
(2826, 7, 379, 101, 0),
(2825, 7, 380, 101, 1),
(2824, 7, 380, 101, 1),
(2823, 7, 381, 101, 1),
(2822, 7, 382, 101, 1),
(2821, 7, 383, 101, 1),
(2820, 7, 384, 101, 1),
(2819, 7, 385, 101, 1),
(2818, 7, 386, 101, 1),
(2817, 7, 387, 101, 1),
(2816, 7, 388, 101, 1),
(2815, 7, 389, 101, 1),
(2814, 7, 390, 101, 1),
(2813, 7, 391, 101, 1),
(2812, 7, 392, 101, 1),
(2811, 7, 393, 101, 1),
(2810, 7, 394, 101, 1),
(2809, 7, 395, 101, 1),
(2808, 7, 396, 101, 1),
(2807, 7, 397, 101, 1),
(2806, 7, 398, 101, 1),
(2805, 7, 399, 101, 1),
(2804, 7, 400, 101, 1),
(2803, 7, 401, 101, 1),
(2802, 7, 402, 101, 1),
(2801, 7, 403, 101, 1),
(2800, 7, 404, 101, 1),
(2799, 7, 405, 101, 1),
(2798, 7, 406, 101, 1),
(2797, 7, 407, 101, 1),
(2796, 7, 408, 101, 1),
(2795, 7, 409, 101, 1),
(2794, 7, 410, 101, 1),
(2793, 7, 411, 101, 1),
(2792, 7, 412, 101, 1),
(2791, 7, 413, 101, 1),
(2790, 7, 414, 101, 1),
(2789, 7, 421, 101, 0),
(2788, 7, 422, 101, 0),
(2787, 7, 423, 101, 0),
(2786, 7, 424, 101, 0),
(2785, 7, 425, 101, 0),
(2784, 7, 426, 101, 0),
(2783, 7, 427, 101, 0),
(2782, 7, 428, 101, 0),
(2781, 7, 429, 101, 1),
(2780, 7, 430, 101, 1),
(2779, 7, 431, 101, 1),
(2778, 7, 432, 101, 1),
(2777, 7, 433, 101, 1),
(2776, 7, 434, 101, 1),
(2775, 7, 435, 101, 1),
(2774, 7, 436, 101, 1),
(2773, 7, 437, 101, 1),
(2772, 7, 438, 101, 1),
(2771, 7, 439, 101, 1),
(2770, 7, 440, 101, 1),
(2769, 7, 441, 101, 1),
(2768, 7, 442, 101, 1),
(2767, 7, 443, 101, 1),
(2766, 7, 444, 101, 1),
(2765, 7, 445, 101, 1),
(2764, 7, 446, 101, 1),
(2763, 7, 447, 101, 1),
(2762, 7, 448, 101, 1),
(2761, 7, 452, 101, 1),
(2760, 7, 453, 101, 1),
(2759, 7, 451, 101, 1),
(2758, 7, 454, 101, 1),
(2757, 7, 455, 101, 1),
(2756, 7, 456, 101, 1),
(2755, 7, 457, 101, 1),
(2754, 7, 458, 101, 1),
(2753, 7, 459, 101, 0),
(2752, 7, 460, 101, 0),
(2751, 7, 461, 101, 0),
(2750, 7, 462, 101, 0),
(2749, 7, 463, 101, 0),
(2748, 7, 464, 101, 0),
(2747, 7, 465, 101, 0),
(2746, 7, 466, 101, 0),
(2745, 7, 467, 101, 0),
(2744, 7, 468, 101, 0),
(2743, 7, 469, 101, 0),
(2742, 7, 470, 101, 0),
(2741, 7, 471, 101, 0),
(2740, 7, 472, 101, 0),
(2739, 7, 473, 101, 0),
(2738, 7, 474, 101, 0),
(2737, 7, 475, 101, 0),
(2736, 7, 476, 101, 0),
(2735, 7, 477, 101, 0),
(2734, 7, 478, 101, 0),
(2733, 7, 479, 101, 0),
(2732, 7, 480, 101, 0),
(2731, 7, 481, 101, 0),
(2730, 7, 482, 101, 0),
(2729, 7, 483, 101, 0),
(2728, 7, 484, 101, 0),
(2727, 7, 495, 101, 0),
(2726, 7, 486, 101, 0),
(2725, 7, 487, 101, 0),
(2724, 7, 488, 101, 0),
(2723, 7, 489, 101, 0),
(2722, 7, 490, 101, 0),
(2721, 7, 491, 101, 0),
(2720, 7, 492, 101, 0),
(2719, 7, 496, 101, 0),
(2718, 7, 497, 101, 0),
(2717, 7, 498, 101, 0),
(2716, 7, 499, 101, 0),
(2715, 7, 500, 101, 0),
(2714, 7, 501, 101, 0),
(2713, 7, 493, 101, 0),
(2712, 7, 494, 101, 0),
(2711, 7, 503, 101, 0),
(2710, 7, 502, 101, 0),
(2709, 7, 504, 101, 1),
(2708, 7, 505, 101, 1),
(2707, 7, 506, 101, 1),
(2706, 7, 507, 101, 1),
(2705, 7, 509, 101, 1),
(2704, 7, 508, 101, 1),
(2703, 7, 519, 101, 1),
(2702, 7, 510, 101, 1),
(2701, 7, 511, 101, 1),
(2700, 7, 512, 101, 1),
(2699, 7, 513, 101, 1),
(2698, 7, 514, 101, 1),
(2697, 7, 515, 101, 1),
(2696, 7, 516, 101, 1),
(2695, 7, 517, 101, 1),
(2694, 7, 518, 101, 1),
(2693, 7, 520, 101, 1),
(2692, 7, 521, 101, 1),
(2691, 7, 522, 101, 1),
(2690, 7, 523, 101, 1),
(2689, 7, 524, 101, 1),
(2688, 7, 525, 101, 0),
(2687, 7, 526, 101, 1),
(2686, 7, 527, 101, 1),
(2685, 7, 528, 101, 1),
(2684, 7, 529, 101, 1),
(2683, 7, 530, 101, 1),
(3106, 1, 552, 101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `old_gold`
--

CREATE TABLE IF NOT EXISTS `old_gold` (
  `id` int(11) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `og_no` varchar(15) NOT NULL,
  `og_date` int(20) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `memo` varchar(80) NOT NULL,
  `payment_term_id` int(5) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `currency_value` double NOT NULL,
  `payment_settled` int(2) NOT NULL,
  `location_id` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `old_gold_desc`
--

CREATE TABLE IF NOT EXISTS `old_gold_desc` (
  `id` int(11) NOT NULL,
  `og_id` int(11) NOT NULL,
  `og_item_desc` varchar(30) NOT NULL,
  `og_unit` double NOT NULL,
  `og_unit_2` double NOT NULL,
  `og_unit_id` int(5) NOT NULL,
  `og_unit_id_2` int(5) NOT NULL,
  `og_unit_price` double NOT NULL,
  `og_item_subtotal` double NOT NULL,
  `location_id` int(3) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `old_gold_ref`
--

CREATE TABLE IF NOT EXISTS `old_gold_ref` (
  `id` int(11) NOT NULL,
  `og_id` int(15) NOT NULL,
  `ref_type` int(5) NOT NULL COMMENT '11:Sales_order,12:Sales_invoice',
  `ref_id` int(15) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(11) NOT NULL,
  `payment_term_name` varchar(25) NOT NULL,
  `days_after` int(10) NOT NULL,
  `payment_done` int(5) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `deleted` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_terms`
--

INSERT INTO `payment_terms` (`id`, `payment_term_name`, `days_after`, `payment_done`, `status`, `deleted`) VALUES
(1, 'Cash', 0, 1, 1, 0),
(2, 'One Month', 30, 0, 1, 0),
(3, 'Two Months', 60, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printer_profile`
--

CREATE TABLE IF NOT EXISTS `printer_profile` (
  `id` int(11) NOT NULL,
  `profile_name` varchar(20) NOT NULL,
  `printer_name` varchar(30) NOT NULL,
  `host` varchar(30) NOT NULL,
  `user` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `network` varchar(30) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `printer_profile`
--

INSERT INTO `printer_profile` (`id`, `profile_name`, `printer_name`, `host`, `user`, `pass`, `network`, `status`, `deleted`) VALUES
(1, 'Nveloop Pos Touch', 'FK80NV', 'nveloop-pos', 'Nveloop', '123', 'workgroup', 1, 0),
(2, 'FL Lap', 'FK80_ZV1', 'zoneventure', 'fahryy', 'fahrydgt', 'workgroup', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL,
  `quote_no` varchar(20) NOT NULL,
  `quotation_type` int(5) NOT NULL,
  `insurance_company` varchar(60) NOT NULL,
  `person_id` int(10) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `vehicle_model` varchar(60) NOT NULL,
  `chasis_no` varchar(50) NOT NULL,
  `comments` int(100) NOT NULL,
  `sales_type_id` int(10) NOT NULL,
  `quoted_date` int(15) NOT NULL,
  `quot_descreption` text NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE IF NOT EXISTS `sales_orders` (
  `id` int(11) NOT NULL,
  `sales_order_no` varchar(20) NOT NULL,
  `customer_id` int(20) NOT NULL,
  `customer_branch_id` int(20) NOT NULL,
  `price_type_id` int(20) NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  `currency_value` double NOT NULL,
  `order_date` int(20) NOT NULL,
  `required_date` int(20) NOT NULL,
  `location_id` int(20) NOT NULL,
  `delivery_address` varchar(400) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_reference` varchar(50) NOT NULL,
  `memo` varchar(400) NOT NULL,
  `invoiced` int(5) NOT NULL DEFAULT '0',
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`id`, `sales_order_no`, `customer_id`, `customer_branch_id`, `price_type_id`, `currency_code`, `currency_value`, `order_date`, `required_date`, `location_id`, `delivery_address`, `customer_phone`, `customer_reference`, `memo`, `invoiced`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'SO10180000001', 1, 1, 15, 'LKR', 1, 1539714600, 1539714600, 1, '123, Galle Road Kaluthara South', '0715889595', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'SO10180000002', 4, 4, 15, 'LKR', 1, 1539714600, 1539714600, 1, '123, Alwis Place Rathmalana', '0115456996', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'SO10180000003', 5, 5, 15, 'LKR', 1, 1539714600, 1539714600, 1, '145/55B, School Lane Dehiwela', '0115487558', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(4, 'SO10180000004', 6, 6, 15, 'LKR', 1, 1539714600, 1539714600, 1, '125A, Galle Road Colombo 6', '0112545585', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(5, 'SO10180000005', 7, 7, 15, 'LKR', 1, 1539714600, 1539714600, 1, '125, Main Street Kaluthara North', '0115458766', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(6, 'SO10180000006', 2, 2, 15, 'LKR', 1, 1539196200, 1539714600, 1, 'No 18, Main Street Kalutara', '7474665655', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(7, 'SO10180000007', 6, 6, 15, 'LKR', 1, 1538937000, 1539714600, 1, '125A, Galle Road Colombo 6', '0112545585', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(8, 'SO10180000008', 2, 2, 15, 'LKR', 1, 1538418600, 1539714600, 1, 'No 18, Main Street Kalutara', '7474665655', '', '', 0, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_description`
--

CREATE TABLE IF NOT EXISTS `sales_order_description` (
  `id` int(11) NOT NULL,
  `item_id` int(20) NOT NULL,
  `sales_order_id` int(20) NOT NULL,
  `item_desc` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `units` double NOT NULL,
  `unit_uom_id` int(20) NOT NULL,
  `secondary_unit` double NOT NULL,
  `secondary_unit_uom_id` int(20) NOT NULL,
  `unit_price` double NOT NULL,
  `discount_percent` double NOT NULL DEFAULT '0',
  `location_id` int(10) NOT NULL,
  `invoiced` int(2) NOT NULL,
  `craftman_status` int(2) NOT NULL COMMENT '0:open,1:Submitted:2:received',
  `so_craftman_submission_id` int(20) NOT NULL,
  `new_item_id` int(20) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order_description`
--

INSERT INTO `sales_order_description` (`id`, `item_id`, `sales_order_id`, `item_desc`, `description`, `units`, `unit_uom_id`, `secondary_unit`, `secondary_unit_uom_id`, `unit_price`, `discount_percent`, `location_id`, `invoiced`, `craftman_status`, `so_craftman_submission_id`, `new_item_id`, `status`, `deleted`) VALUES
(1, 29, 1, 'Rose Gold Bangles', '4cm diameter ', 15, 3, 1, 1, 7850, 0, 1, 0, 0, 0, 0, 1, 0),
(2, 46, 1, 'puzzle ring', '14.5mm Diameter with 22KT Gold', 6, 3, 1, 1, 7200, 0, 1, 0, 1, 2, 0, 1, 0),
(3, 49, 1, 'Charm Bracelets', 'All Stones with Yellow Sapphires', 12.5, 3, 1, 1, 14500, 0, 1, 0, 2, 1, 68, 1, 0),
(4, 20, 2, 'Triple stone ring White', '3 different color', 6.56, 3, 1, 1, 14500, 0, 1, 0, 1, 3, 0, 1, 0),
(5, 33, 2, 'gold necklace ', 'Flower Designed Head Necklace', 12, 3, 1, 1, 7000, 0, 1, 0, 0, 0, 0, 1, 0),
(6, 14, 3, 'Rose Gold Ring', '1.56mm Diameter', 6, 3, 1, 1, 9500, 0, 1, 0, 1, 3, 0, 1, 0),
(7, 3, 3, 'NJ Bracelets', 'Cat011 Design', 15, 3, 1, 1, 8200, 0, 1, 0, 1, 2, 0, 1, 0),
(8, 26, 3, 'Heart Pendant', 'Head Heart Saphe Cat 012', 8.65, 3, 1, 1, 9500, 0, 1, 0, 1, 2, 0, 1, 0),
(9, 35, 3, 'machine cut chain', '22KT Gold', 12, 3, 1, 1, 8700, 0, 1, 0, 1, 2, 0, 1, 0),
(10, 8, 3, 'Earing Yellow ', 'Earing with saaphire stone', 7, 3, 1, 1, 15000, 0, 1, 0, 2, 1, 72, 1, 0),
(11, 5, 4, 'Ligghty Bracelet', '38mm Diameter', 8, 3, 1, 1, 11000, 0, 1, 0, 1, 2, 0, 1, 0),
(12, 21, 4, 'Two Stoned Ring', 'Need to attached Pink Stones', 6, 3, 1, 1, 7000, 0, 1, 0, 2, 1, 70, 1, 0),
(13, 22, 5, 'B Sapphire Rings', '2 Carta Sapphire, 1.23mm diameter', 9, 3, 1, 1, 12000, 0, 1, 0, 1, 2, 0, 1, 0),
(14, 28, 5, 'Gold Bangle', 'Striped Design - 22KT Gold - CAT100291', 16, 3, 1, 1, 9000, 0, 1, 0, 1, 1, 0, 1, 0),
(15, 14, 6, 'Rose Gold Ring', '22Kt Gold', 6, 3, 1, 1, 12000, 0, 1, 0, 0, 0, 0, 1, 0),
(16, 34, 6, 'box chain', 'With Zig Zag Pattern Cat9192', 16, 3, 1, 1, 10000, 0, 1, 0, 2, 1, 71, 1, 0),
(17, 26, 6, 'Heart Pendant', 'F letter inside the heart', 16, 3, 1, 1, 11200, 0, 1, 0, 1, 3, 0, 1, 0),
(18, 3, 7, 'NJ Bracelets', '22KT Gold ', 12, 3, 1, 1, 9500, 0, 1, 0, 2, 1, 69, 1, 0),
(19, 15, 7, 'Silver Ring', 'Simple no stone', 6, 3, 1, 1, 3600, 0, 1, 0, 0, 0, 0, 1, 0),
(20, 15, 8, 'Silver Ring', 'Middle black Line ', 8, 3, 1, 1, 3600, 0, 1, 0, 1, 1, 0, 1, 0),
(21, 17, 8, 'Multystone ring', 'Middle line black', 8, 3, 1, 1, 12900, 0, 1, 0, 1, 3, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_item_temp`
--

CREATE TABLE IF NOT EXISTS `sales_order_item_temp` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `value` text NOT NULL,
  `og_data` text NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_persons`
--

CREATE TABLE IF NOT EXISTS `sales_persons` (
  `id` int(11) NOT NULL,
  `sales_person_name` varchar(50) NOT NULL,
  `sales_person_phone` int(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `provision` double NOT NULL,
  `turn_over_break` double NOT NULL,
  `provision_2` double NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_persons`
--

INSERT INTO `sales_persons` (`id`, `sales_person_name`, `sales_person_phone`, `email`, `provision`, `turn_over_break`, `provision_2`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Sales Person1', 0, '', 0, 0, 0, 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'Sales Person2', 0, '', 0, 0, 0, 1, '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_voucher`
--

CREATE TABLE IF NOT EXISTS `sales_voucher` (
  `id` int(11) NOT NULL,
  `voucher_name` varchar(30) NOT NULL,
  `voucher_amount` double NOT NULL,
  `status` int(2) NOT NULL,
  `deleted+` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_voucher`
--

INSERT INTO `sales_voucher` (`id`, `voucher_name`, `voucher_amount`, `status`, `deleted+`) VALUES
(1, 'Nveloop 5000 LKR', 5000, 1, 0),
(2, 'Nveloop 10000 LKR', 10000, 1, 0),
(3, 'Nveloop 15000 LKR', 15000, 1, 0),
(4, 'Nveloop 20000 LKR', 20000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `so_craftman_receivals`
--

CREATE TABLE IF NOT EXISTS `so_craftman_receivals` (
  `id` int(11) NOT NULL,
  `cm_receival_no` varchar(25) NOT NULL,
  `receival_date` int(20) NOT NULL,
  `location_id` int(5) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `status` int(2) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_craftman_receivals`
--

INSERT INTO `so_craftman_receivals` (`id`, `cm_receival_no`, `receival_date`, `location_id`, `memo`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'CMR10180000001', 1539714600, 1, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `so_craftman_receivals_desc`
--

CREATE TABLE IF NOT EXISTS `so_craftman_receivals_desc` (
  `id` int(11) NOT NULL,
  `cmr_no` varchar(25) NOT NULL,
  `order_id` int(15) NOT NULL,
  `order_desc_id` int(15) NOT NULL,
  `order_item_id` int(15) NOT NULL,
  `item_id` int(15) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `location_id` int(5) NOT NULL,
  `units` double NOT NULL,
  `uom_id` int(5) NOT NULL,
  `units_2` double NOT NULL,
  `uom_id_2` int(5) NOT NULL,
  `purch_unit_price` double NOT NULL,
  `sale_unit_price` double NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_craftman_receivals_desc`
--

INSERT INTO `so_craftman_receivals_desc` (`id`, `cmr_no`, `order_id`, `order_desc_id`, `order_item_id`, `item_id`, `item_description`, `location_id`, `units`, `uom_id`, `units_2`, `uom_id_2`, `purch_unit_price`, `sale_unit_price`, `status`, `deleted`) VALUES
(1, 'CMR10180000001', 1, 3, 49, 68, 'Charm Bracelets', 1, 13.5, 3, 1, 1, 15000, 16000, 1, 0),
(2, 'CMR10180000001', 7, 18, 3, 69, 'NJ Bracelets', 1, 11.21, 3, 1, 1, 8000, 9500, 1, 0),
(3, 'CMR10180000001', 4, 12, 21, 70, 'Two Stoned Ring', 1, 5.83, 3, 1, 1, 7500, 8200, 1, 0),
(4, 'CMR10180000001', 6, 16, 34, 71, 'box chain', 1, 17.61, 3, 1, 1, 9500, 10500, 1, 0),
(5, 'CMR10180000001', 3, 10, 8, 72, 'Earing Yellow ', 1, 8.14, 3, 1, 1, 15700, 16500, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `so_craftman_submission`
--

CREATE TABLE IF NOT EXISTS `so_craftman_submission` (
  `id` int(11) NOT NULL,
  `cm_submission_no` varchar(25) NOT NULL,
  `craftman_id` int(10) NOT NULL,
  `submission_date` int(20) NOT NULL,
  `return_date` int(20) NOT NULL,
  `memo` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_craftman_submission`
--

INSERT INTO `so_craftman_submission` (`id`, `cm_submission_no`, `craftman_id`, `submission_date`, `return_date`, `memo`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'CMS10180000001', 1, 1539714600, 1540319400, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'CMS10180000002', 3, 1539196200, 1539887400, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'CMS10180000003', 3, 1537986600, 1538505000, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `supplier_ref` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(40) NOT NULL,
  `reg_no` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_person` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `supp_account_no` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_account_no` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bank_account_name` varchar(100) NOT NULL,
  `bank_account_branch` varchar(60) NOT NULL,
  `currency_code` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_terms` int(11) DEFAULT NULL,
  `tax_included` tinyint(1) NOT NULL DEFAULT '0',
  `tax_group_id` int(11) DEFAULT NULL,
  `credit_limit` double NOT NULL DEFAULT '0',
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_ref`, `address`, `city`, `postal_code`, `state`, `country`, `reg_no`, `contact_person`, `phone`, `fax`, `email`, `supp_account_no`, `website`, `bank_account_no`, `bank_account_name`, `bank_account_branch`, `currency_code`, `payment_terms`, `tax_included`, `tax_group_id`, `credit_limit`, `description`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 'Nveloop Supplier', 'NVS-01', '467/1, Galle Road', 'Kaluthara', '12090', '1', 'LK', '', '', '0715889595', '', '', '', '', '', '', '', 'LKR', NULL, 0, NULL, 1000000, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 'Devi Jewellers Co', 'SUP02', '123, 2nd Cross Street', 'Colombo 11', '', '', 'LK', '', '', '011689655855', '', '', '', '', '', '', '', NULL, NULL, 0, NULL, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 'Raja Gold Supply', 'SUP03', 'No 18, Main Street', 'Negombo', '', '', 'LK', '', '', '7474665655', '', '', '', '', '', '', '', NULL, NULL, 0, NULL, 0, '', 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoice`
--

CREATE TABLE IF NOT EXISTS `supplier_invoice` (
  `id` int(11) NOT NULL,
  `supplier_id` int(15) NOT NULL,
  `supplier_invoice_no` varchar(25) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `comments` varchar(400) NOT NULL,
  `invoice_date` int(20) NOT NULL,
  `invoiced` int(5) NOT NULL,
  `payment_term_id` int(15) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `currency_value` double NOT NULL,
  `payment_settled` int(5) NOT NULL,
  `location_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(10) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(10) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_invoice`
--

INSERT INTO `supplier_invoice` (`id`, `supplier_id`, `supplier_invoice_no`, `reference`, `comments`, `invoice_date`, `invoiced`, `payment_term_id`, `currency_code`, `currency_value`, `payment_settled`, `location_id`, `status`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 1, 'SI10180000001', 'UPLOAD CSV', '', 0, 1, 2, '1', 0, 0, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(2, 2, 'SI10180000002', 'UPLOAD CSV', '', 0, 1, 2, '1', 0, 0, 2, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0),
(3, 1, 'SI10180000003', 'SO-STOCK-UPDATE181017', 'Craftman receive No:CMR10180000001', 1539714600, 1, 1, 'LKR', 1, 1, 1, 1, '2018-10-17', 1, '0000-00-00', 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoice_description`
--

CREATE TABLE IF NOT EXISTS `supplier_invoice_description` (
  `id` int(11) NOT NULL,
  `item_id` int(20) NOT NULL,
  `supplier_invoice_id` int(20) NOT NULL,
  `supplier_item_desc` varchar(200) NOT NULL,
  `purchasing_unit` double NOT NULL,
  `purchasing_unit_uom_id` int(10) NOT NULL,
  `secondary_unit` double NOT NULL,
  `secondary_unit_uom_id` int(100) NOT NULL,
  `purchasing_unit_price` double NOT NULL,
  `discount_persent` double NOT NULL,
  `location_id` int(20) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_invoice_description`
--

INSERT INTO `supplier_invoice_description` (`id`, `item_id`, `supplier_invoice_id`, `supplier_item_desc`, `purchasing_unit`, `purchasing_unit_uom_id`, `secondary_unit`, `secondary_unit_uom_id`, `purchasing_unit_price`, `discount_persent`, `location_id`, `status`, `deleted`) VALUES
(1, 1, 1, 'Multystone Bracelet', 6, 3, 1, 1, 8800, 0, 1, 1, 0),
(2, 2, 1, 'Colored Stone Bracelets', 2, 3, 1, 1, 11600, 0, 1, 1, 0),
(3, 3, 1, 'NJ Bracelets', 15, 3, 1, 1, 12000, 0, 1, 1, 0),
(4, 4, 1, 'Emerald Bracelet', 14, 3, 1, 1, 16000, 0, 1, 1, 0),
(5, 5, 1, 'Ligghty Bracelet', 5, 3, 1, 1, 9840, 0, 1, 1, 0),
(6, 6, 1, 'Bracelet Ocean look', 17, 3, 1, 1, 12800, 0, 1, 1, 0),
(7, 7, 1, 'Bracelet Charm', 5, 3, 1, 1, 10800, 0, 1, 1, 0),
(8, 8, 1, 'Earing Yellow ', 14, 3, 1, 1, 12000, 0, 1, 1, 0),
(9, 9, 1, 'Earing Moonstone', 6, 3, 1, 1, 14400, 0, 1, 1, 0),
(10, 10, 1, 'Earing Dangling', 8, 3, 1, 1, 7680, 0, 1, 1, 0),
(11, 11, 1, 'Stud', 7, 3, 1, 1, 14400, 0, 1, 1, 0),
(12, 12, 1, 'stud2', 10, 3, 1, 1, 13600, 0, 1, 1, 0),
(13, 13, 1, 'Stud Earing', 10, 3, 1, 1, 12480, 0, 1, 1, 0),
(14, 14, 1, 'Rose Gold Ring', 20, 3, 1, 1, 25600, 0, 1, 1, 0),
(15, 15, 1, 'Silver Ring', 11, 3, 1, 1, 2880, 0, 1, 1, 0),
(16, 16, 1, 'RoseGold Stoned Ring', 4, 3, 1, 1, 11600, 0, 1, 1, 0),
(17, 17, 1, 'Multystone ring', 77, 3, 1, 1, 10320, 0, 1, 1, 0),
(18, 18, 1, 'Ring with Pair Stones', 50, 3, 1, 1, 16000, 0, 1, 1, 0),
(19, 19, 1, 'Triple stone ring', 25, 3, 1, 1, 6880, 0, 1, 1, 0),
(20, 20, 1, 'Triple stone ring White', 21, 3, 1, 1, 12000, 0, 1, 1, 0),
(21, 21, 1, 'Two Stoned Ring', 22, 3, 1, 1, 2080, 0, 1, 1, 0),
(22, 22, 1, 'B Sapphire Rings', 54, 3, 1, 1, 3360, 0, 1, 1, 0),
(23, 23, 1, 'Emerald Ring', 11, 3, 1, 1, 3200, 0, 1, 1, 0),
(24, 24, 1, 'Ruby Pendant', 45, 3, 1, 1, 6400, 0, 1, 1, 0),
(25, 25, 1, 'Sapphire Pendant', 7, 3, 1, 1, 4960, 0, 1, 1, 0),
(26, 26, 1, 'Heart Pendant', 12, 3, 1, 1, 7600, 0, 1, 1, 0),
(27, 27, 1, 'Pendant Diomond', 20, 3, 1, 1, 5600, 0, 1, 1, 0),
(28, 28, 1, 'Gold Bangle', 15, 3, 1, 1, 7200, 0, 1, 1, 0),
(29, 29, 1, 'Rose Gold Bangles', 10, 3, 1, 1, 6280, 0, 1, 1, 0),
(30, 30, 1, 'Tiny Bangle', 12, 3, 1, 1, 2800, 0, 1, 1, 0),
(31, 31, 1, 'Ruby Stoned Bangles', 25, 3, 1, 1, 14240, 0, 1, 1, 0),
(32, 32, 1, 'Emerald necklace', 10, 3, 1, 1, 11200, 0, 1, 1, 0),
(33, 33, 1, 'gold necklace ', 6, 3, 1, 1, 5600, 0, 1, 1, 0),
(34, 34, 1, 'box chain', 25, 3, 1, 1, 8000, 0, 1, 1, 0),
(35, 35, 1, 'machine cut chain', 20, 3, 1, 1, 11200, 0, 1, 1, 0),
(36, 36, 1, ' anklet belt  type', 10, 3, 1, 1, 14400, 0, 1, 1, 0),
(37, 37, 1, 'gold bell anklet', 17, 3, 1, 1, 10400, 0, 1, 1, 0),
(38, 38, 1, 'stone Cuff Links', 30, 3, 1, 1, 20000, 0, 1, 1, 0),
(39, 39, 1, 'normal cufflinks', 40, 3, 1, 1, 12000, 0, 1, 1, 0),
(40, 40, 1, 'flower brooch', 20, 3, 1, 1, 8000, 0, 1, 1, 0),
(41, 41, 1, 'stone brooch', 15, 3, 1, 1, 6000, 0, 1, 1, 0),
(42, 42, 1, 'white gold diamond rings', 5, 3, 1, 1, 20000, 0, 1, 1, 0),
(43, 43, 1, 'gold flower diamond ring', 8, 3, 1, 1, 15200, 0, 1, 1, 0),
(44, 44, 1, 'thumb ring diamond', 4, 3, 1, 1, 14000, 0, 1, 1, 0),
(45, 45, 1, 'Crown', 3, 3, 1, 1, 16000, 0, 1, 1, 0),
(46, 46, 1, 'puzzle ring', 18, 3, 1, 1, 5760, 0, 1, 1, 0),
(47, 47, 1, 'classic ring', 45, 3, 1, 1, 3600, 0, 1, 1, 0),
(48, 48, 2, 'Doublestone Bracelet', 6.55, 3, 1, 1, 8800, 0, 2, 1, 0),
(49, 49, 2, 'Charm Bracelets', 2.25, 3, 1, 1, 11600, 0, 2, 1, 0),
(50, 50, 2, 'NJ21 Bracelets', 15.47, 3, 1, 1, 12000, 0, 2, 1, 0),
(51, 51, 2, 'Pear shape Bracelet', 14.57, 3, 1, 1, 16000, 0, 2, 1, 0),
(52, 52, 2, 'Tiny Bracelet', 5, 3, 1, 1, 9840, 0, 2, 1, 0),
(53, 53, 2, 'Bracelet V shaped', 17.5, 3, 1, 1, 12800, 0, 2, 1, 0),
(54, 54, 2, 'Bracelet Charm Gold', 5.2, 3, 1, 1, 10800, 0, 2, 1, 0),
(55, 55, 2, 'Earing with Yellow Stone', 14.37, 3, 1, 1, 12000, 0, 2, 1, 0),
(56, 56, 2, 'Earing Moonstone', 6.95, 3, 1, 1, 14400, 0, 2, 1, 0),
(57, 57, 2, 'Earing Dangling RG', 8.57, 3, 1, 1, 7680, 0, 2, 1, 0),
(58, 58, 2, 'Stud td12', 7.44, 3, 1, 1, 14400, 0, 2, 1, 0),
(59, 59, 2, 'stud td13', 10.47, 3, 1, 1, 13600, 0, 2, 1, 0),
(60, 60, 2, 'Tiny Stud', 10.73, 3, 1, 1, 12480, 0, 2, 1, 0),
(61, 61, 2, 'Rose Gold Stoned Ring', 11.25, 3, 1, 1, 25600, 0, 2, 1, 0),
(62, 62, 2, 'Silver Groom Ring ', 11.25, 3, 1, 1, 2880, 0, 2, 1, 0),
(63, 63, 2, 'RoseGold Engagement Ring', 4.87, 3, 1, 1, 11600, 0, 2, 1, 0),
(64, 64, 2, 'Sapphire ring', 7.14, 3, 1, 1, 10320, 0, 2, 1, 0),
(65, 65, 2, 'Plane Ring Gold', 5.54, 3, 1, 1, 6280, 0, 2, 1, 0),
(66, 66, 2, 'Bangle 6.2 cm Plane', 11.5, 3, 1, 1, 6560, 0, 2, 1, 0),
(67, 67, 2, 'Ruby Bangle Heart Shape', 8.65, 3, 1, 1, 12640, 0, 2, 1, 0),
(68, 68, 3, 'Charm Bracelets', 13.5, 3, 1, 1, 15000, 0, 1, 1, 0),
(69, 69, 3, 'NJ Bracelets', 11.21, 3, 1, 1, 8000, 0, 1, 1, 0),
(70, 70, 3, 'Two Stoned Ring', 5.83, 3, 1, 1, 7500, 0, 1, 1, 0),
(71, 71, 3, 'box chain', 17.61, 3, 1, 1, 9500, 0, 1, 1, 0),
(72, 72, 3, 'Earing Yellow ', 8.14, 3, 1, 1, 15700, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE IF NOT EXISTS `system_log` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  `action_id` varchar(50) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `date` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_log_detail`
--

CREATE TABLE IF NOT EXISTS `system_log_detail` (
  `id` int(11) NOT NULL,
  `system_log_id` int(15) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `data_new` text NOT NULL,
  `data_old` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_base`
--

CREATE TABLE IF NOT EXISTS `time_base` (
  `id` int(11) NOT NULL,
  `time_base_name` varchar(100) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `hours` double NOT NULL,
  `descreption` varchar(200) NOT NULL,
  `status` int(20) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_base`
--

INSERT INTO `time_base` (`id`, `time_base_name`, `short_name`, `hours`, `descreption`, `status`, `deleted`) VALUES
(1, 'Daily', 'DL', 24, 'Daily Tarriff calculation', 1, 0),
(2, 'Hourly', 'HR', 1, 'Hourly Tariff calculations', 1, 0),
(3, 'Weekly', 'WK', 168, 'Weekly (7 Days)', 1, 0),
(4, 'Visit / Round', 'WK', 2, 'Single Visit', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transection`
--

CREATE TABLE IF NOT EXISTS `transection` (
  `id` int(11) NOT NULL,
  `transection_type_id` int(5) NOT NULL,
  `payment_method` int(5) NOT NULL DEFAULT '1',
  `reference` varchar(100) NOT NULL,
  `person_type` int(5) NOT NULL COMMENT '10:customers,20:supplier,30:comsignee',
  `person_id` int(10) NOT NULL,
  `redeemed_inv_id` int(15) NOT NULL,
  `transection_amount` double NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `trans_date` int(15) NOT NULL,
  `trans_memo` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `deleted` int(5) NOT NULL DEFAULT '0',
  `deleted_by` int(10) NOT NULL,
  `deleted_on` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transection`
--

INSERT INTO `transection` (`id`, `transection_type_id`, `payment_method`, `reference`, `person_type`, `person_id`, `redeemed_inv_id`, `transection_amount`, `currency_code`, `trans_date`, `trans_memo`, `description`, `status`, `deleted`, `deleted_by`, `deleted_on`) VALUES
(1, 1, 2, '', 10, 3, 0, 69840, 'LKR', 1539714600, 'card', '', 1, 0, 0, '0000-00-00'),
(2, 3, 1, '', 20, 1, 0, 630998, 'LKR', 1539714600, 'Supplier Cash Invoice - ORDER CRAFTMAN RECEIVAL', '', 1, 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `transection_payment_method`
--

CREATE TABLE IF NOT EXISTS `transection_payment_method` (
  `id` int(11) NOT NULL,
  `payment_method_name` varchar(20) NOT NULL,
  `status` int(2) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transection_payment_method`
--

INSERT INTO `transection_payment_method` (`id`, `payment_method_name`, `status`, `deleted`) VALUES
(1, 'Cash', 1, 0),
(2, 'Card', 1, 0),
(3, 'Voucher Payment', 1, 0),
(4, 'Return Refund', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transection_ref`
--

CREATE TABLE IF NOT EXISTS `transection_ref` (
  `id` int(11) NOT NULL,
  `transection_id` int(20) NOT NULL,
  `reference_id` int(15) NOT NULL,
  `trans_reference` varchar(50) NOT NULL,
  `person_type` int(5) NOT NULL,
  `transection_ref_amount` double NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `deleted` int(5) NOT NULL DEFAULT '0',
  `deleted_by` int(10) NOT NULL,
  `deleted_on` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transection_ref`
--

INSERT INTO `transection_ref` (`id`, `transection_id`, `reference_id`, `trans_reference`, `person_type`, `transection_ref_amount`, `status`, `deleted`, `deleted_by`, `deleted_on`) VALUES
(1, 1, 1, 'NI10180000001', 10, 69840, 1, 0, 0, '0000-00-00'),
(2, 2, 3, 'SI10180000003', 20, 630998, 1, 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `transection_types`
--

CREATE TABLE IF NOT EXISTS `transection_types` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `calculation` int(10) NOT NULL COMMENT '1:addition,2:substracr',
  `person_type` int(5) NOT NULL,
  `cats` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transection_types`
--

INSERT INTO `transection_types` (`id`, `name`, `calculation`, `person_type`, `cats`, `status`, `deleted`) VALUES
(1, 'Customer payments', 2, 10, 'sales', 1, 0),
(2, 'Deposit amount', 2, 10, 'sales', 1, 0),
(3, 'Supplier payments', 2, 20, 'purchasing', 1, 0),
(4, 'Customer Settlements(-)', 1, 10, 'sales', 1, 0),
(5, 'Order Redeem', 1, 10, 'sales', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL,
  `user_role_id` int(10) NOT NULL,
  `sales_person_status` int(11) NOT NULL DEFAULT '1' COMMENT '1-sales person active',
  `user_name` varchar(30) NOT NULL,
  `user_password` text NOT NULL,
  `tmp_pwd` text NOT NULL,
  `tmp_pwd_req_date` date NOT NULL,
  `active_from` date NOT NULL,
  `active_to` date NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`id`, `user_role_id`, `sales_person_status`, `user_name`, `user_password`, `tmp_pwd`, `tmp_pwd_req_date`, `active_from`, `active_to`, `status`) VALUES
(1, 1, 1, 'fahry', 'I98FzpnFLhO2dBhAj0P6pROEu2zqWAq5gcvnvG/aPJrO9m+wNu+ryS9cfBVjDFUVU5S889QriWxf0a+Gw5NkCA==', '', '0000-00-00', '0000-00-00', '0000-00-00', 1),
(41, 4, 1, 'faheem', '2hYO5JkpSqpRxUpoNw1TMeACI0sxQ2Svc38Db23Doo5GidqlX7o039M9SYMivysmvjQ9dIuzRl0xB5zJXDaIAg==', '', '0000-00-00', '0000-00-00', '0000-00-00', 1),
(37, 2, 0, 'shafras', 'o+jRdO4m4hvxVjm9Ltqzzp/OiEFqNHX2cjmR4xyVrW9rRe3WOvtiHmcAQ07FzvMAXDQKb+r0bFRfgE6D5YcD7w==', '', '0000-00-00', '0000-00-00', '0000-00-00', 1),
(42, 7, 1, 'gems', 'h2VYSbR/ohZpMTiuiWxcqhCeCPdYHoKo+WLxCjh+gWOsKBpjgYVXIOtfrndb1tMsUZSxvDa3yIEPmJ7sH/ZMpQ==', '', '0000-00-00', '0000-00-00', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL,
  `auth_id` int(10) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `address` varchar(150) NOT NULL,
  `email` varchar(75) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `pic` text NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(5) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(5) NOT NULL,
  `deleted` int(5) NOT NULL,
  `deleted_on` date NOT NULL,
  `deleted_by` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `auth_id`, `first_name`, `last_name`, `company_id`, `address`, `email`, `tel`, `pic`, `added_on`, `added_by`, `updated_on`, `updated_by`, `deleted`, `deleted_on`, `deleted_by`) VALUES
(1, 1, 'Mohamed', 'Fahry', 1, '82, W. A. D. Ramanayake Mawatha, Colombo - 02', 'fahrydgt@gmail.com', '0775440889', 'default.png', '2016-01-13', 1, '2017-10-14', 1, 0, '0000-00-00', 0),
(33, 37, 'Shafras', 'Nawas', 1, '', 'shafras@nveloop.com', '0775440889', 'default.jpg', '2017-09-22', 1, '2018-08-08', 1, 0, '0000-00-00', 0),
(37, 41, 'Faheem', 'Farook', 1, '', '', '', 'default.jpg', '2018-04-10', 1, '2018-08-31', 1, 0, '0000-00-00', 0),
(38, 42, 'NVGems', 'admin', 1, '', 'sam@nveloop.com', '07745454545', 'default.jpg', '2018-10-10', 1, '2018-10-10', 1, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `role_cat` varchar(50) NOT NULL,
  `redirect` varchar(75) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `deleted` int(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_role`, `role_cat`, `redirect`, `status`, `deleted`) VALUES
(1, 'Administrator', 'ADMIN', 'Dashboard', 1, 0),
(3, 'Manager', 'MANAGER', 'Dashboard', 1, 0),
(4, 'Sales Person', 'STAFF', 'Sales_pos/add', 1, 0),
(2, 'System Administrator', 'SYSTEM_ADMIN', 'Dashboard', 1, 0),
(6, 'POS User', 'POS_STAFF', 'Dashboard', 1, 0),
(7, 'System Admin - GEM', 'SYSTEM_ADMIN_GM', 'Dashboard', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_calculation_included`
--
ALTER TABLE `addon_calculation_included`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_account_name` (`bank_account_name`),
  ADD KEY `bank_account_number` (`bank_account_number`),
  ADD KEY `account_code` (`account_code`);

--
-- Indexes for table `cms_banner`
--
ALTER TABLE `cms_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignees`
--
ALTER TABLE `consignees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee_commission`
--
ALTER TABLE `consignee_commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee_recieve`
--
ALTER TABLE `consignee_recieve`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee_recieve_description`
--
ALTER TABLE `consignee_recieve_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee_submission`
--
ALTER TABLE `consignee_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee_submission_description`
--
ALTER TABLE `consignee_submission_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_code` (`country_code`);

--
-- Indexes for table `country_cities`
--
ALTER TABLE `country_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cities_districts1_idx` (`district_id`);

--
-- Indexes for table `country_districts`
--
ALTER TABLE `country_districts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `country_states`
--
ALTER TABLE `country_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `craftmans`
--
ALTER TABLE `craftmans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes_desc`
--
ALTER TABLE `credit_notes_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_branches`
--
ALTER TABLE `customer_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropdown_list`
--
ALTER TABLE `dropdown_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropdown_list_names`
--
ALTER TABLE `dropdown_list_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_chart_classes`
--
ALTER TABLE `gl_chart_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_chart_master`
--
ALTER TABLE `gl_chart_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_code` (`account_code`);

--
-- Indexes for table `gl_chart_types`
--
ALTER TABLE `gl_chart_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_fiscal_year`
--
ALTER TABLE `gl_fiscal_year`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `begin` (`begin`),
  ADD UNIQUE KEY `end` (`end`);

--
-- Indexes for table `gl_quick_entries`
--
ALTER TABLE `gl_quick_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_quick_entry_accounts`
--
ALTER TABLE `gl_quick_entry_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_transections`
--
ALTER TABLE `gl_transections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_location`
--
ALTER TABLE `inventory_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_location_transfer`
--
ALTER TABLE `inventory_location_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_location_transfer_desc`
--
ALTER TABLE `inventory_location_transfer_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_addons`
--
ALTER TABLE `invoice_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_description`
--
ALTER TABLE `invoice_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_temp`
--
ALTER TABLE `invoice_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_type`
--
ALTER TABLE `invoice_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_cat_links`
--
ALTER TABLE `item_cat_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_prices`
--
ALTER TABLE `item_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_stock_transection`
--
ALTER TABLE `item_stock_transection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_uom`
--
ALTER TABLE `item_uom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_actions`
--
ALTER TABLE `module_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_user_role`
--
ALTER TABLE `module_user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_gold`
--
ALTER TABLE `old_gold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_gold_desc`
--
ALTER TABLE `old_gold_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_gold_ref`
--
ALTER TABLE `old_gold_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_terms`
--
ALTER TABLE `payment_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printer_profile`
--
ALTER TABLE `printer_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_description`
--
ALTER TABLE `sales_order_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_item_temp`
--
ALTER TABLE `sales_order_item_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_persons`
--
ALTER TABLE `sales_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_voucher`
--
ALTER TABLE `sales_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_craftman_receivals`
--
ALTER TABLE `so_craftman_receivals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_craftman_receivals_desc`
--
ALTER TABLE `so_craftman_receivals_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_craftman_submission`
--
ALTER TABLE `so_craftman_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_invoice`
--
ALTER TABLE `supplier_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_invoice_description`
--
ALTER TABLE `supplier_invoice_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_log`
--
ALTER TABLE `system_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_log_detail`
--
ALTER TABLE `system_log_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_base`
--
ALTER TABLE `time_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transection`
--
ALTER TABLE `transection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transection_payment_method`
--
ALTER TABLE `transection_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transection_ref`
--
ALTER TABLE `transection_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transection_types`
--
ALTER TABLE `transection_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role` (`user_role_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_auth` (`auth_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_cat` (`role_cat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `addon_calculation_included`
--
ALTER TABLE `addon_calculation_included`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_banner`
--
ALTER TABLE `cms_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `consignees`
--
ALTER TABLE `consignees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consignee_commission`
--
ALTER TABLE `consignee_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consignee_recieve`
--
ALTER TABLE `consignee_recieve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consignee_recieve_description`
--
ALTER TABLE `consignee_recieve_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consignee_submission`
--
ALTER TABLE `consignee_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consignee_submission_description`
--
ALTER TABLE `consignee_submission_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=248;
--
-- AUTO_INCREMENT for table `country_cities`
--
ALTER TABLE `country_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1847;
--
-- AUTO_INCREMENT for table `country_districts`
--
ALTER TABLE `country_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `country_states`
--
ALTER TABLE `country_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `craftmans`
--
ALTER TABLE `craftmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credit_notes_desc`
--
ALTER TABLE `credit_notes_desc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `customer_branches`
--
ALTER TABLE `customer_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `dropdown_list`
--
ALTER TABLE `dropdown_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `dropdown_list_names`
--
ALTER TABLE `dropdown_list_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `gl_chart_classes`
--
ALTER TABLE `gl_chart_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gl_chart_master`
--
ALTER TABLE `gl_chart_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `gl_chart_types`
--
ALTER TABLE `gl_chart_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `gl_fiscal_year`
--
ALTER TABLE `gl_fiscal_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gl_quick_entries`
--
ALTER TABLE `gl_quick_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gl_quick_entry_accounts`
--
ALTER TABLE `gl_quick_entry_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gl_transections`
--
ALTER TABLE `gl_transections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `inventory_location`
--
ALTER TABLE `inventory_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `inventory_location_transfer`
--
ALTER TABLE `inventory_location_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory_location_transfer_desc`
--
ALTER TABLE `inventory_location_transfer_desc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoice_addons`
--
ALTER TABLE `invoice_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoice_description`
--
ALTER TABLE `invoice_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice_temp`
--
ALTER TABLE `invoice_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `invoice_type`
--
ALTER TABLE `invoice_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `item_cat_links`
--
ALTER TABLE `item_cat_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_prices`
--
ALTER TABLE `item_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `item_stock_transection`
--
ALTER TABLE `item_stock_transection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `item_uom`
--
ALTER TABLE `item_uom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `module_actions`
--
ALTER TABLE `module_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=553;
--
-- AUTO_INCREMENT for table `module_user_role`
--
ALTER TABLE `module_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3107;
--
-- AUTO_INCREMENT for table `old_gold`
--
ALTER TABLE `old_gold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `old_gold_desc`
--
ALTER TABLE `old_gold_desc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `old_gold_ref`
--
ALTER TABLE `old_gold_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_terms`
--
ALTER TABLE `payment_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `printer_profile`
--
ALTER TABLE `printer_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sales_order_description`
--
ALTER TABLE `sales_order_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sales_order_item_temp`
--
ALTER TABLE `sales_order_item_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_persons`
--
ALTER TABLE `sales_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sales_voucher`
--
ALTER TABLE `sales_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `so_craftman_receivals`
--
ALTER TABLE `so_craftman_receivals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `so_craftman_receivals_desc`
--
ALTER TABLE `so_craftman_receivals_desc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `so_craftman_submission`
--
ALTER TABLE `so_craftman_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supplier_invoice`
--
ALTER TABLE `supplier_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supplier_invoice_description`
--
ALTER TABLE `supplier_invoice_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `system_log_detail`
--
ALTER TABLE `system_log_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `time_base`
--
ALTER TABLE `time_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transection`
--
ALTER TABLE `transection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transection_payment_method`
--
ALTER TABLE `transection_payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transection_ref`
--
ALTER TABLE `transection_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transection_types`
--
ALTER TABLE `transection_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
