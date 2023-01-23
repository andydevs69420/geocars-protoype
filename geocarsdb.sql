-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2022 at 05:52 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geocarsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `ccd_id` int(11) NOT NULL,
  `booking_date` varchar(10) NOT NULL,
  `pickup_date` varchar(10) NOT NULL,
  `return_date` varchar(10) NOT NULL,
  `bsid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `booking`
--
DELIMITER $$
CREATE TRIGGER `booking_trigger` BEFORE UPDATE ON `booking` FOR EACH ROW BEGIN

	IF new.bsid = 5 THEN
    	INSERT INTO transaction(bid,tstart,tsid) VALUES(new.bid,new.pickup_date,1);
    END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `booking_trigger_before_delete` BEFORE DELETE ON `booking` FOR EACH ROW BEGIN
	DELETE FROM transaction WHERE bid = old.bid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking_status`
--

CREATE TABLE `booking_status` (
  `bsid` int(11) NOT NULL,
  `bstatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking_status`
--

INSERT INTO `booking_status` (`bsid`, `bstatus`) VALUES
(1, 'PENDING'),
(2, 'ACCEPTED'),
(3, 'CANCELED'),
(4, 'DECLINED'),
(5, 'PICKEDUP'),
(6, 'RETURNED');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `carid` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `plateno` varchar(20) NOT NULL,
  `rate_per_day` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

CREATE TABLE `car_images` (
  `carimg_id` int(11) NOT NULL,
  `carid` int(11) NOT NULL,
  `image_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `cid` int(11) NOT NULL,
  `cname` varchar(100) DEFAULT NULL,
  `cemail` varchar(100) NOT NULL,
  `caddress` varchar(255) DEFAULT NULL,
  `ccontactno` varchar(20) DEFAULT NULL,
  `cpassphrase` text NOT NULL,
  `clast_logind` varchar(10) DEFAULT NULL,
  `csign_time` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `company`
--
DELIMITER $$
CREATE TRIGGER `company_trigger` AFTER INSERT ON `company` FOR EACH ROW BEGIN
    INSERT INTO company_pic_details(cid) 			VALUES(new.cid);
    INSERT INTO company_pic(dp_link,cover_link) 
    VALUES ("N/A","N/A");
    UPDATE company_pic_details SET cpic_id = 		LAST_INSERT_ID() WHERE cid = new.cid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `company_car_details`
--

CREATE TABLE `company_car_details` (
  `ccd_id` int(11) NOT NULL,
  `cpland_id` int(11) NOT NULL,
  `carid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `company_car_details`
--
DELIMITER $$
CREATE TRIGGER `company_car_before_delete_trigger` BEFORE DELETE ON `company_car_details` FOR EACH ROW BEGIN
	DELETE FROM booking WHERE ccd_id = old.ccd_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `company_pic`
--

CREATE TABLE `company_pic` (
  `cpic_id` int(11) NOT NULL,
  `dp_link` text DEFAULT NULL,
  `cover_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_pic_details`
--

CREATE TABLE `company_pic_details` (
  `cpicd_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `cpic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `company_pic_details`
--
DELIMITER $$
CREATE TRIGGER `company_pic_details_trigger` AFTER INSERT ON `company_pic_details` FOR EACH ROW INSERT INTO company_plan_details(cpicd_id,pid) VALUES(new.cpicd_id,1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `company_plan_details`
--

CREATE TABLE `company_plan_details` (
  `cpland_id` int(11) NOT NULL,
  `cpicd_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `pid` int(11) NOT NULL,
  `pname` varchar(100) NOT NULL,
  `monthly_fee` double NOT NULL,
  `operation_hours` int(11) NOT NULL,
  `num_of_cars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`pid`, `pname`, `monthly_fee`, `operation_hours`, `num_of_cars`) VALUES
(1, 'FREEMIUM', 0, 8, 5),
(2, 'PRO', 3000, 14, 8),
(3, 'BUSINESS', 5000, 999, 999);

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

CREATE TABLE `renter` (
  `rid` int(11) NOT NULL,
  `rcontactno` varchar(20) DEFAULT NULL,
  `rfname` varchar(100) DEFAULT NULL,
  `rmname` varchar(100) DEFAULT NULL,
  `rlname` varchar(100) DEFAULT NULL,
  `raddress` varchar(255) DEFAULT NULL,
  `rpassphrase` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `tstart` varchar(10) DEFAULT NULL,
  `tend` varchar(10) DEFAULT NULL,
  `tammount` double DEFAULT NULL,
  `tsid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_status`
--

CREATE TABLE `transaction_status` (
  `tsid` int(11) NOT NULL,
  `tstatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_status`
--

INSERT INTO `transaction_status` (`tsid`, `tstatus`) VALUES
(1, 'ONGOING'),
(2, 'FINISHED');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `rid` (`rid`),
  ADD KEY `ccd_id` (`ccd_id`),
  ADD KEY `bsid` (`bsid`);

--
-- Indexes for table `booking_status`
--
ALTER TABLE `booking_status`
  ADD PRIMARY KEY (`bsid`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`carid`);

--
-- Indexes for table `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`carimg_id`),
  ADD KEY `carid` (`carid`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `company_car_details`
--
ALTER TABLE `company_car_details`
  ADD PRIMARY KEY (`ccd_id`),
  ADD KEY `cpland_id` (`cpland_id`),
  ADD KEY `company_car_details_ibfk_2` (`carid`);

--
-- Indexes for table `company_pic`
--
ALTER TABLE `company_pic`
  ADD PRIMARY KEY (`cpic_id`);

--
-- Indexes for table `company_pic_details`
--
ALTER TABLE `company_pic_details`
  ADD PRIMARY KEY (`cpicd_id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `cpic_id` (`cpic_id`);

--
-- Indexes for table `company_plan_details`
--
ALTER TABLE `company_plan_details`
  ADD PRIMARY KEY (`cpland_id`),
  ADD KEY `cpd_id` (`cpicd_id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `renter`
--
ALTER TABLE `renter`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `bid` (`bid`),
  ADD KEY `tsid` (`tsid`);

--
-- Indexes for table `transaction_status`
--
ALTER TABLE `transaction_status`
  ADD PRIMARY KEY (`tsid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `bsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `carid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `car_images`
--
ALTER TABLE `car_images`
  MODIFY `carimg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_car_details`
--
ALTER TABLE `company_car_details`
  MODIFY `ccd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_pic`
--
ALTER TABLE `company_pic`
  MODIFY `cpic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_pic_details`
--
ALTER TABLE `company_pic_details`
  MODIFY `cpicd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_plan_details`
--
ALTER TABLE `company_plan_details`
  MODIFY `cpland_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_status`
--
ALTER TABLE `transaction_status`
  MODIFY `tsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `renter` (`rid`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`ccd_id`) REFERENCES `company_car_details` (`ccd_id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`bsid`) REFERENCES `booking_status` (`bsid`);

--
-- Constraints for table `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`carid`) REFERENCES `car` (`carid`);

--
-- Constraints for table `company_car_details`
--
ALTER TABLE `company_car_details`
  ADD CONSTRAINT `company_car_details_ibfk_1` FOREIGN KEY (`cpland_id`) REFERENCES `company_plan_details` (`cpland_id`),
  ADD CONSTRAINT `company_car_details_ibfk_2` FOREIGN KEY (`carid`) REFERENCES `car` (`carid`);

--
-- Constraints for table `company_pic_details`
--
ALTER TABLE `company_pic_details`
  ADD CONSTRAINT `company_pic_details_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`),
  ADD CONSTRAINT `company_pic_details_ibfk_2` FOREIGN KEY (`cpic_id`) REFERENCES `company_pic` (`cpic_id`);

--
-- Constraints for table `company_plan_details`
--
ALTER TABLE `company_plan_details`
  ADD CONSTRAINT `company_plan_details_ibfk_1` FOREIGN KEY (`cpicd_id`) REFERENCES `company_pic_details` (`cpicd_id`),
  ADD CONSTRAINT `company_plan_details_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `plan` (`pid`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `booking` (`bid`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`tsid`) REFERENCES `transaction_status` (`tsid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
