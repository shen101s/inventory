-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2022 at 04:51 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vetclinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_library`
--

DROP TABLE IF EXISTS `tbl_library`;
CREATE TABLE IF NOT EXISTS `tbl_library` (
  `libid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(3) NOT NULL,
  `libdesc` text NOT NULL,
  `libstatus` int(2) NOT NULL COMMENT '0-inactive, 1-active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`libid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_library`
--

INSERT INTO `tbl_library` (`libid`, `sid`, `libdesc`, `libstatus`, `created_at`, `updated_at`) VALUES
(1, 6, 'Nutri chuncks', 1, '2022-02-25 12:34:23', '2022-02-25 12:34:23'),
(2, 6, 'sample', 1, '2022-02-25 12:35:29', '2022-02-25 12:35:29'),
(3, 6, 'ok na', 1, '2022-02-25 12:35:56', '2022-02-25 12:35:56'),
(4, 1, 'Bioflu', 1, '2022-02-25 12:38:51', '2022-02-25 12:38:51'),
(5, 7, 'Deworming', 1, '2022-02-25 12:39:37', '2022-02-25 12:39:37'),
(6, 3, 'Full Grooming', 1, '2022-02-25 12:40:41', '2022-02-25 12:40:41'),
(7, 4, 'Chain', 1, '2022-02-25 12:41:29', '2022-02-25 12:41:37'),
(8, 2, 'Laboratory', 1, '2022-02-25 12:42:38', '2022-02-25 12:42:38'),
(9, 5, '5in1', 1, '2022-02-25 12:44:09', '2022-02-25 12:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_library_desc`
--

DROP TABLE IF EXISTS `tbl_library_desc`;
CREATE TABLE IF NOT EXISTS `tbl_library_desc` (
  `libdescid` int(11) NOT NULL AUTO_INCREMENT,
  `libid` int(11) NOT NULL,
  `libdescitem` varchar(200) NOT NULL,
  `libdescstatus` int(2) NOT NULL DEFAULT '1' COMMENT '0-inactive, 1-active	',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`libdescid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_library_desc`
--

INSERT INTO `tbl_library_desc` (`libdescid`, `libid`, `libdescitem`, `libdescstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 'puppy', 1, '2022-02-25 12:35:20', '2022-02-25 12:35:20'),
(2, 4, '500mg', 1, '2022-02-25 12:39:01', '2022-02-25 12:39:01'),
(3, 5, 'Puppy', 1, '2022-02-25 12:40:02', '2022-02-25 12:40:02'),
(4, 6, 'Big', 1, '2022-02-25 12:40:52', '2022-02-25 12:40:52'),
(5, 7, '5meters long', 1, '2022-02-25 12:41:49', '2022-02-25 12:41:49'),
(6, 8, 'CBC', 1, '2022-02-25 12:42:46', '2022-02-25 12:42:46'),
(7, 8, 'Fecalysis', 1, '2022-02-25 12:43:20', '2022-02-25 12:43:20'),
(8, 9, 'small', 1, '2022-02-25 12:44:18', '2022-02-25 12:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_library_det`
--

DROP TABLE IF EXISTS `tbl_library_det`;
CREATE TABLE IF NOT EXISTS `tbl_library_det` (
  `libdid` int(11) NOT NULL AUTO_INCREMENT,
  `libdescid` int(11) NOT NULL,
  `libid_` int(11) NOT NULL,
  `libdbarcode` varchar(30) DEFAULT NULL,
  `libddesc_` timestamp NULL DEFAULT NULL,
  `unitid` int(11) NOT NULL,
  `libdprice` decimal(7,2) NOT NULL,
  `libdqty` int(6) NOT NULL,
  `libdqtyrem` int(6) NOT NULL,
  `libdexp` date DEFAULT NULL,
  `libdstatus` int(2) NOT NULL COMMENT '0-inactive, 1-active',
  `libddateadded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `libddateupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`libdid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_library_det`
--

INSERT INTO `tbl_library_det` (`libdid`, `libdescid`, `libid_`, `libdbarcode`, `libddesc_`, `unitid`, `libdprice`, `libdqty`, `libdqtyrem`, `libdexp`, `libdstatus`, `libddateadded`, `libddateupdated`) VALUES
(1, 1, 0, '22000001', NULL, 3, '90.00', 100, 100, '2022-03-19', 1, '2022-02-25 04:36:32', '2022-02-25 12:36:32'),
(2, 2, 0, '22000002', NULL, 4, '10.00', 100, 99, '2022-05-12', 1, '2022-02-25 04:39:21', '2022-02-25 12:47:43'),
(3, 3, 0, '22000003', NULL, 2, '600.00', 100, 100, '2022-09-15', 1, '2022-02-25 04:40:26', '2022-02-25 12:40:26'),
(4, 4, 0, '22000004', NULL, 2, '500.00', 0, -5, '2022-09-14', 1, '2022-02-25 04:41:11', '2022-03-05 04:29:31'),
(5, 5, 0, '22000005', NULL, 1, '150.00', 500, 500, NULL, 1, '2022-02-25 04:42:06', '2022-02-25 12:42:06'),
(6, 6, 0, '22000006', NULL, 2, '500.00', 0, -5, '2022-12-02', 1, '2022-02-25 04:43:10', '2022-02-25 14:07:23'),
(7, 7, 0, '22000007', NULL, 2, '500.00', 0, 0, NULL, 1, '2022-02-25 04:43:43', '2022-02-25 12:43:43'),
(8, 8, 0, '22000008', NULL, 2, '450.00', 500, 500, NULL, 1, '2022-02-25 04:44:39', '2022-02-25 12:44:39');

--
-- Triggers `tbl_library_det`
--
DROP TRIGGER IF EXISTS `before_tbllibrarydet_insert`;
DELIMITER $$
CREATE TRIGGER `before_tbllibrarydet_insert` BEFORE INSERT ON `tbl_library_det` FOR EACH ROW SET 
@cur_Year = CONCAT(DATE_FORMAT(CURDATE(), '%y')),
@max_ID = (SELECT SUBSTRING(libdbarcode, -2)
           FROM tbl_library_det 
           WHERE libdbarcode LIKE CONCAT(@cur_Year, '%')
           ORDER BY libdbarcode DESC 
           LIMIT 1),
@last_ID = CAST(RIGHT(IF(@max_ID IS NULL, 0, @max_ID), 6) AS SIGNED) + 1,
New.libdbarcode =   CONCAT(@cur_Year, LPAD(CAST(@last_ID AS CHAR(6)), 6, '0'))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lib_breed`
--

DROP TABLE IF EXISTS `tbl_lib_breed`;
CREATE TABLE IF NOT EXISTS `tbl_lib_breed` (
  `breedid` int(11) NOT NULL AUTO_INCREMENT,
  `specid` int(11) NOT NULL,
  `breeddesc` varchar(255) NOT NULL,
  `breedstatus` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`breedid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lib_breed`
--

INSERT INTO `tbl_lib_breed` (`breedid`, `specid`, `breeddesc`, `breedstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 'Shih Tzu', 'Active', '2022-02-25 10:15:46', '2022-02-25 10:15:46'),
(2, 1, 'Aspin', 'Active', '2022-02-25 10:16:03', '2022-02-25 10:16:03'),
(3, 1, 'American Bully', 'Active', '2022-02-25 10:16:56', '2022-02-25 10:16:56'),
(4, 1, 'Belgian Malinois', 'Active', '2022-02-25 10:17:56', '2022-02-25 10:17:56'),
(5, 1, 'German Shepherd', 'Active', '2022-02-25 10:18:14', '2022-02-25 10:18:14'),
(6, 1, 'Dachschund', 'Active', '2022-02-25 10:18:45', '2022-02-25 10:18:45'),
(7, 1, 'French Bulldog', 'Active', '2022-02-25 10:19:23', '2022-02-25 10:19:23'),
(8, 1, 'Great Dane', 'Active', '2022-02-25 10:19:52', '2022-02-25 10:19:52'),
(9, 1, 'Maltese', 'Active', '2022-02-25 10:20:16', '2022-02-25 10:20:16'),
(10, 1, 'Corgi', 'Active', '2022-02-25 10:20:31', '2022-02-25 10:20:31'),
(11, 2, 'Persian', 'Active', '2022-02-25 10:21:10', '2022-02-25 10:21:10'),
(12, 2, 'Puspin', 'Active', '2022-02-25 10:21:29', '2022-02-25 10:21:29'),
(13, 2, 'Siamese', 'Active', '2022-02-25 10:22:38', '2022-02-25 10:22:38'),
(14, 1, 'Poodle', 'Active', '2022-02-25 10:22:59', '2022-02-25 10:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lib_history`
--

DROP TABLE IF EXISTS `tbl_lib_history`;
CREATE TABLE IF NOT EXISTS `tbl_lib_history` (
  `histid` int(3) NOT NULL AUTO_INCREMENT,
  `histdesc` varchar(20) NOT NULL,
  `histstatus` varchar(8) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`histid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lib_species`
--

DROP TABLE IF EXISTS `tbl_lib_species`;
CREATE TABLE IF NOT EXISTS `tbl_lib_species` (
  `specid` int(11) NOT NULL AUTO_INCREMENT,
  `specdesc` varchar(255) NOT NULL,
  `specstatus` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`specid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lib_species`
--

INSERT INTO `tbl_lib_species` (`specid`, `specdesc`, `specstatus`, `created_at`, `updated_at`) VALUES
(1, 'Canine', 'Active', '2022-02-25 10:14:17', '2022-02-25 10:14:17'),
(2, 'Feline', 'Active', '2022-02-25 10:14:33', '2022-02-25 10:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

DROP TABLE IF EXISTS `tbl_login`;
CREATE TABLE IF NOT EXISTS `tbl_login` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `pword` char(65) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `privilege` int(1) NOT NULL COMMENT '1-admin, 99-superadmin',
  `status` int(1) NOT NULL COMMENT '0-inactive, 1active',
  `dateadded` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`lid`, `uname`, `pword`, `fname`, `mname`, `lname`, `privilege`, `status`, `dateadded`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$ueEk4r.jrMopdL2XJyRGPeAB53.FT6j6rzT95KbBowAaVvvltugU.', 'ADMIN', 'ADMIN', 'ADMIN', 99, 1, '2018-04-01 16:00:00', '2022-01-15 09:51:53', '2022-02-24 12:00:36'),
(2, 'sample', '$2y$10$.jj4nmlG4ZioNgtMngt8KONDUXutKucc.qRxOqNjxI4oY6hcLrYM.', 'SAMPLE', 'S', 'SAMPLE123', 1, 1, '0000-00-00 00:00:00', '2022-02-24 11:35:23', '2022-03-05 04:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_owner`
--

DROP TABLE IF EXISTS `tbl_owner`;
CREATE TABLE IF NOT EXISTS `tbl_owner` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `ofname` varchar(30) NOT NULL,
  `omname` varchar(30) NOT NULL,
  `olname` varchar(30) NOT NULL,
  `oaddress` varchar(100) NOT NULL,
  `ocontactnum` varchar(50) NOT NULL,
  `oemailadd` varchar(70) DEFAULT NULL,
  `odateadded` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_owner`
--

INSERT INTO `tbl_owner` (`oid`, `ofname`, `omname`, `olname`, `oaddress`, `ocontactnum`, `oemailadd`, `odateadded`, `created_at`, `updated_at`) VALUES
(1, 'ASMPLE', 'SAMPLE', 'SAMPLE', 'SAMPLE', '0909090', '', '2022-03-04 19:29:32', '2022-03-05 03:29:32', '2022-03-05 03:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

DROP TABLE IF EXISTS `tbl_pet`;
CREATE TABLE IF NOT EXISTS `tbl_pet` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `pname` varchar(20) NOT NULL,
  `pbday` date NOT NULL,
  `specid` int(11) NOT NULL,
  `breedid` int(11) NOT NULL,
  `pgender` varchar(10) NOT NULL,
  `phistory__` text NOT NULL,
  `pstatus` int(2) NOT NULL COMMENT '0-inactive, 1-active',
  `pdateadded` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pid`, `oid`, `pname`, `pbday`, `specid`, `breedid`, `pgender`, `phistory__`, `pstatus`, `pdateadded`, `created_at`, `updated_at`) VALUES
(1, 1, 'samsam', '2022-03-01', 1, 2, 'Male', '', 1, '2022-03-04 19:29:49', '2022-03-05 03:29:49', '2022-03-05 03:29:49'),
(2, 1, 'kokoko', '2022-03-02', 1, 2, 'Female', '', 0, '2022-03-04 19:32:19', '2022-03-05 03:32:19', '2022-03-05 03:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet_history`
--

DROP TABLE IF EXISTS `tbl_pet_history`;
CREATE TABLE IF NOT EXISTS `tbl_pet_history` (
  `phid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `phdesc` varchar(20) NOT NULL,
  `phdate` date NOT NULL,
  `phremarks` text NOT NULL,
  `phstatus` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`phid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pet_history`
--

INSERT INTO `tbl_pet_history` (`phid`, `pid`, `phdesc`, `phdate`, `phremarks`, `phstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 'Deworming', '2022-03-01', 'samplee', 'Inactive', '2022-03-05 03:30:04', '2022-03-05 03:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purpose`
--

DROP TABLE IF EXISTS `tbl_purpose`;
CREATE TABLE IF NOT EXISTS `tbl_purpose` (
  `purid` int(11) NOT NULL AUTO_INCREMENT,
  `tpdet` varchar(12) NOT NULL,
  `tpstatus` varchar(8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`purid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purpose`
--

INSERT INTO `tbl_purpose` (`purid`, `tpdet`, `tpstatus`, `created_at`, `updated_at`) VALUES
(1, 'Boarding', 'Active', '2022-01-15 09:54:24', '2022-01-15 09:54:24'),
(2, 'Checkup', 'Active', '2022-01-15 09:54:24', '2022-01-15 09:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

DROP TABLE IF EXISTS `tbl_service`;
CREATE TABLE IF NOT EXISTS `tbl_service` (
  `sid` int(3) NOT NULL AUTO_INCREMENT,
  `scode` varchar(5) NOT NULL,
  `sdescription` varchar(50) NOT NULL,
  `sstatus` int(2) NOT NULL COMMENT '0-inactive, 1-active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`sid`, `scode`, `sdescription`, `sstatus`, `created_at`, `updated_at`) VALUES
(1, 'DMMS', 'Drugs, Medicines and Medical Supplies', 1, '2022-01-15 09:54:51', '2022-02-25 12:29:54'),
(2, 'VS', 'Vet Services', 1, '2022-01-15 09:54:51', '2022-02-25 12:26:50'),
(3, 'GS', 'Grooming Services', 1, '2022-01-15 09:54:51', '2022-02-25 12:27:22'),
(4, 'OS', 'Other Supplies', 1, '2022-01-15 09:54:51', '2022-02-25 12:27:42'),
(5, 'VAX', 'Vaccine', 1, '2022-01-15 09:54:51', '2022-01-15 09:54:51'),
(6, 'DF', 'Dog Food', 1, '2022-01-15 09:54:51', '2022-02-25 12:26:21'),
(7, 'DW', 'Deworming', 1, '2022-02-25 12:30:22', '2022-02-25 12:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans`
--

DROP TABLE IF EXISTS `tbl_trans`;
CREATE TABLE IF NOT EXISTS `tbl_trans` (
  `transid` int(11) NOT NULL AUTO_INCREMENT,
  `tranyear` int(4) NOT NULL,
  `trancode` char(7) NOT NULL,
  `trantype` char(1) NOT NULL,
  `oid` int(11) NOT NULL,
  `pid__` int(11) NOT NULL,
  `purid__` int(2) DEFAULT NULL,
  `trandate` date NOT NULL,
  `trancash` decimal(7,2) NOT NULL,
  `remarks__` text,
  `lid` int(11) NOT NULL,
  `transtatus` int(11) NOT NULL COMMENT '0-active, 1-delete',
  `trandateadded` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_trans`
--

INSERT INTO `tbl_trans` (`transid`, `tranyear`, `trancode`, `trantype`, `oid`, `pid__`, `purid__`, `trandate`, `trancash`, `remarks__`, `lid`, `transtatus`, `trandateadded`, `updated_at`) VALUES
(1, 2022, '0000001', 'B', 0, 0, NULL, '2022-02-25', '1000.00', NULL, 1, 0, '2022-02-25 04:47:43', '2022-02-25 12:47:43'),
(2, 2022, '0000002', 'B', 0, 0, NULL, '2022-03-05', '1000.00', NULL, 1, 0, '2022-03-04 17:44:00', '2022-03-05 01:44:00'),
(3, 2022, '0000003', 'B', 0, 0, NULL, '2022-03-05', '1000.00', NULL, 1, 0, '2022-03-04 18:16:38', '2022-03-05 02:16:38'),
(4, 2022, '0000004', 'B', 0, 0, NULL, '2022-03-05', '500.00', NULL, 1, 0, '2022-03-04 18:27:02', '2022-03-05 02:27:02'),
(5, 2022, '0000005', 'B', 0, 0, NULL, '2022-03-05', '1000.00', NULL, 1, 0, '2022-03-04 20:27:37', '2022-03-05 04:27:37'),
(6, 2022, '0000006', 'B', 0, 0, NULL, '2022-03-05', '1000.00', NULL, 1, 0, '2022-03-04 20:29:31', '2022-03-05 04:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_serv`
--

DROP TABLE IF EXISTS `tbl_trans_serv`;
CREATE TABLE IF NOT EXISTS `tbl_trans_serv` (
  `transservid` int(11) NOT NULL AUTO_INCREMENT,
  `transid` int(11) NOT NULL,
  `tslibdid` int(11) NOT NULL,
  `tslibdqty` int(11) NOT NULL,
  `tsstatus` int(1) NOT NULL COMMENT '0-active, 1-delete',
  `lid` int(11) NOT NULL,
  `tsdiscount` decimal(5,2) DEFAULT NULL,
  `tsremarks` varchar(250) DEFAULT NULL,
  `tslocation` varchar(10) NOT NULL DEFAULT 'TRAN' COMMENT 'TRAN-Transaction, ADJ-adjustment',
  `tsdateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tsdateupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transservid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_trans_serv`
--

INSERT INTO `tbl_trans_serv` (`transservid`, `transid`, `tslibdid`, `tslibdqty`, `tsstatus`, `lid`, `tsdiscount`, `tsremarks`, `tslocation`, `tsdateadded`, `tsdateupdated`) VALUES
(1, 1, 2, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-02-25 12:47:43', '2022-02-25 12:47:43'),
(2, 1, 6, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-02-25 12:47:43', '2022-02-25 12:47:43'),
(3, 1, 6, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-02-25 06:04:02', '2022-02-25 14:04:02'),
(4, 1, 6, 3, 0, 1, '0.00', NULL, 'TRAN', '2022-02-25 06:07:23', '2022-02-25 14:07:23'),
(5, 2, 4, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-03-05 01:44:00', '2022-03-05 01:44:00'),
(6, 3, 4, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-03-05 02:16:38', '2022-03-05 02:16:38'),
(7, 4, 4, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-03-05 02:27:02', '2022-03-05 02:27:02'),
(8, 5, 4, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-03-05 04:27:37', '2022-03-05 04:27:37'),
(9, 6, 4, 1, 0, 1, '0.00', NULL, 'TRAN', '2022-03-05 04:29:31', '2022-03-05 04:29:31');

--
-- Triggers `tbl_trans_serv`
--
DROP TRIGGER IF EXISTS `after_tbltranserv_update`;
DELIMITER $$
CREATE TRIGGER `after_tbltranserv_update` AFTER UPDATE ON `tbl_trans_serv` FOR EACH ROW IF New.tsstatus = 1 THEN 
    	UPDATE tbl_library_det
        SET libdqtyrem=(libdqtyrem + New.tslibdqty)
        WHERE libdid=New.tslibdid;
    ELSEIF New.tsstatus = 0 AND Old.tslibdqty=New.tslibdqty THEN 
    	UPDATE tbl_library_det
        SET libdqtyrem=(libdqtyrem - New.tslibdqty)
        WHERE libdid=New.tslibdid;
    ELSEIF Old.tslibdqty < New.tslibdqty THEN 
    	UPDATE tbl_library_det
        SET libdqtyrem=(libdqtyrem - (New.tslibdqty-Old.tslibdqty))
        WHERE libdid=New.tslibdid;
    ELSEIF Old.tslibdqty > New.tslibdqty THEN 
    	UPDATE tbl_library_det
        SET libdqtyrem=(libdqtyrem + (Old.tslibdqty-New.tslibdqty))
        WHERE libdid=New.tslibdid;
    END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_tbltransserv_insert`;
DELIMITER $$
CREATE TRIGGER `after_tbltransserv_insert` AFTER INSERT ON `tbl_trans_serv` FOR EACH ROW UPDATE tbl_library_det
SET libdqtyrem=(libdqtyrem - New.tslibdqty)
WHERE libdid=New.tslibdid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE IF NOT EXISTS `tbl_unit` (
  `unitid` int(3) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(10) NOT NULL,
  `unitdesc` varchar(50) NOT NULL,
  `unitstatus` int(2) NOT NULL COMMENT '0-inactive, 1-active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`unitid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`unitid`, `unitcode`, `unitdesc`, `unitstatus`, `created_at`, `updated_at`) VALUES
(1, 'pcs', 'Pieces', 1, '2022-01-15 09:56:10', '2022-01-15 09:56:10'),
(2, 'srv', 'service', 1, '2022-01-15 09:56:10', '2022-01-15 09:56:10'),
(3, 'kl', 'Kilogram', 1, '2022-01-15 09:56:10', '2022-01-15 09:56:10'),
(4, 'tab', 'Tablet', 1, '2022-01-19 11:58:43', '2022-01-19 11:58:43'),
(5, 'bot', 'Bottle', 1, '2022-01-19 11:59:06', '2022-02-25 10:12:34'),
(6, 'day', 'Day', 1, '2022-02-03 13:52:11', '2022-02-25 10:12:44'),
(7, 'amp', 'Ampule', 1, '2022-02-25 10:11:42', '2022-02-25 10:12:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
