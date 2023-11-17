-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2019 at 01:56 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DKBSS`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `acc_no` int(255) NOT NULL,
  `name` text NOT NULL,
  `father_or_husband_name` text NOT NULL,
  `mother_name` text NOT NULL,
  `gender` text NOT NULL,
  `age` int(255) NOT NULL,
  `nationality` text NOT NULL,
  `bcn_or_nid_no` text NOT NULL,
  `phone` int(255) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `occupation` text NOT NULL,
  `nomini_name` text NOT NULL,
  `nomini_relation` text NOT NULL,
  `acc_type` text NOT NULL,
  `client_photo` text NOT NULL,
  `note_book_page` text NOT NULL,
  `remark` text NOT NULL,
  `join_date` text NOT NULL,
  `a_o_s` int(255) NOT NULL,
  `client_status` tinyint(1) NOT NULL,
  `total_saving` int(255) NOT NULL,
  `loan_running` tinyint(1) NOT NULL,
  `s_w_r_n` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_calculation`
--

CREATE TABLE `daily_calculation` (
  `date` date NOT NULL,
  `debit` int(255) NOT NULL,
  `coming_in` int(255) NOT NULL,
  `total` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_history`
--

CREATE TABLE `daily_history` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `in_` int(255) NOT NULL,
  `out_` int(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(1) NOT NULL,
  `capital` int(255) NOT NULL,
  `loan_percentage` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `capital`, `loan_percentage`) VALUES
(1, 249, 20);

-- --------------------------------------------------------

--
-- Table structure for table `installment_deposit`
--

CREATE TABLE `installment_deposit` (
  `id` int(255) NOT NULL,
  `loan_no` int(255) NOT NULL,
  `date` date NOT NULL,
  `amount` int(255) NOT NULL,
  `due` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_list`
--

CREATE TABLE `loan_list` (
  `acc_no` int(255) NOT NULL,
  `loan_no` int(255) NOT NULL,
  `request_date` date NOT NULL,
  `paid_date` date NOT NULL,
  `amount` int(255) NOT NULL,
  `amount_with_charge` int(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `req_status` tinyint(1) NOT NULL,
  `due` int(255) NOT NULL,
  `loan_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `login_name` text NOT NULL,
  `login_pass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `login_name`, `login_pass`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `saving_deposit`
--

CREATE TABLE `saving_deposit` (
  `id` int(255) NOT NULL,
  `acc_no` int(255) NOT NULL,
  `date` date NOT NULL,
  `amount` int(255) NOT NULL,
  `total_saving` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_list`
--

CREATE TABLE `withdrawal_list` (
  `id` int(255) NOT NULL,
  `acc_no` int(255) NOT NULL,
  `req_status` tinyint(1) NOT NULL,
  `amount` int(255) NOT NULL,
  `request_date` date NOT NULL,
  `withdrawal_date` date NOT NULL,
  `available_balance` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawal_list`
--

INSERT INTO `withdrawal_list` (`id`, `acc_no`, `req_status`, `amount`, `request_date`, `withdrawal_date`, `available_balance`) VALUES
(1, 0, 0, 0, '0000-00-00', '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`acc_no`);

--
-- Indexes for table `daily_calculation`
--
ALTER TABLE `daily_calculation`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `daily_history`
--
ALTER TABLE `daily_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installment_deposit`
--
ALTER TABLE `installment_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_list`
--
ALTER TABLE `loan_list`
  ADD PRIMARY KEY (`loan_no`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saving_deposit`
--
ALTER TABLE `saving_deposit`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `withdrawal_list`
--
ALTER TABLE `withdrawal_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `acc_no` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_history`
--
ALTER TABLE `daily_history`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_deposit`
--
ALTER TABLE `installment_deposit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saving_deposit`
--
ALTER TABLE `saving_deposit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_list`
--
ALTER TABLE `withdrawal_list`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
