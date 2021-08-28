-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2021 at 10:04 AM
-- Server version: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b2c`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_Id` int(11) NOT NULL,
  `game_GameId` int(11) DEFAULT NULL COMMENT 'this holds the allocated game id',
  `game_GameName` varchar(120) DEFAULT NULL,
  `game_Comments` longtext,
  `game_Message` longtext,
  `game_shortDescription` longtext,
  `game_longDescription` longtext,
  `game_Start_Date` datetime DEFAULT NULL,
  `game_End_Date` datetime DEFAULT NULL,
  `game_prise` varchar(120) DEFAULT NULL,
  `game_discount` varchar(120) DEFAULT NULL,
  `game_Image` varchar(120) DEFAULT NULL,
  `game_Elearning` varchar(60) DEFAULT NULL,
  `game_Category` varchar(60) DEFAULT NULL,
  `game_Redirect` varchar(120) DEFAULT NULL,
  `game_CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_purchase`
--

CREATE TABLE `game_purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_userId` int(11) DEFAULT NULL,
  `purchase_gameId` int(11) DEFAULT NULL COMMENT 'this is the game id which user has purchased',
  `purchase_transactionId` varchar(250) DEFAULT NULL COMMENT 'This holds the transaction id of game purchase',
  `purchase_gameStartDate` datetime DEFAULT NULL,
  `purchase_gameEndDate` datetime DEFAULT NULL,
  `purchase_createdOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_purchase`
--

INSERT INTO `game_purchase` (`purchase_id`, `purchase_userId`, `purchase_gameId`, `purchase_transactionId`, `purchase_gameStartDate`, `purchase_gameEndDate`, `purchase_createdOn`) VALUES
(1, 1, 129, '590222775', '2021-01-19 12:30:23', '2021-01-19 12:30:23', '2021-01-19 07:00:23'),
(2, 1, 91, '1305572443', '2021-01-19 12:30:23', '2021-01-19 12:30:23', '2021-01-19 07:00:23'),
(3, 1, 80, '139826121', '2021-01-19 12:30:23', '2021-01-19 12:30:23', '2021-01-19 07:00:23'),
(4, 1, 70, '904765531', '2021-01-19 12:30:23', '2021-01-19 12:30:23', '2021-01-19 07:00:23'),
(5, NULL, 75, '768828699', '2021-01-19 12:32:21', '2021-01-19 12:32:21', '2021-01-19 07:02:21'),
(6, NULL, 64, '1384635758', '2021-01-19 12:32:21', '2021-01-19 12:32:21', '2021-01-19 07:02:21'),
(7, 1, 64, '492011952', '2021-01-19 12:33:08', '2021-01-19 12:33:08', '2021-01-19 07:03:08'),
(8, 1, 75, '1271461425', '2021-01-19 12:33:08', '2021-01-19 12:33:08', '2021-01-19 07:03:08'),
(9, 1, 129, '461860087', '2021-01-19 12:35:11', '2021-01-19 12:35:11', '2021-01-19 07:05:11'),
(10, 1, 91, '316552219', '2021-01-19 12:35:12', '2021-01-19 12:35:12', '2021-01-19 07:05:12'),
(11, 1, 94, '1601792841', '2021-01-19 12:35:12', '2021-01-19 12:35:12', '2021-01-19 07:05:12'),
(12, 1, 89, '1236375861', '2021-01-19 12:35:12', '2021-01-19 12:35:12', '2021-01-19 07:05:12'),
(13, 1, 87, '2006451059', '2021-01-19 12:35:12', '2021-01-19 12:35:12', '2021-01-19 07:05:12'),
(14, 1, 73, '1644068236', '2021-01-19 12:35:12', '2021-01-19 12:35:12', '2021-01-19 07:05:12'),
(15, 2, 91, '723373497', '2021-01-19 13:37:52', '2021-01-19 13:37:52', '2021-01-19 08:07:52'),
(16, 2, 129, '1859526839', '2021-01-19 13:37:52', '2021-01-19 13:37:52', '2021-01-19 08:07:52'),
(17, 3, 129, '1689624503', '2021-01-20 20:48:42', '2021-01-20 20:48:42', '2021-01-20 15:18:42'),
(18, 3, 129, '1288701086', '2021-01-25 19:54:43', '2021-01-25 19:54:43', '2021-01-25 14:24:43'),
(19, 3, 77, '1579723367', '2021-03-01 11:00:42', '2021-03-01 11:00:42', '2021-03-01 05:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `game_users`
--

CREATE TABLE `game_users` (
  `user_Id` int(11) NOT NULL,
  `user_Fname` varchar(60) DEFAULT NULL,
  `user_Lname` varchar(60) DEFAULT NULL,
  `user_Email` varchar(120) DEFAULT NULL,
  `user_UserName` varchar(60) DEFAULT NULL,
  `user_Phone` varchar(60) DEFAULT NULL,
  `user_Pic` varchar(120) DEFAULT NULL,
  `user_Password` varchar(120) DEFAULT NULL,
  `user_PasswordEncrypt` varchar(255) DEFAULT NULL,
  `user_AccountVerification` tinyint(4) DEFAULT '0' COMMENT '0-Pending for email verification, 1-email verified',
  `user_CreatedBy` int(11) DEFAULT NULL COMMENT 'creator id or -21 for self creation',
  `user_CreatedMedium` varchar(120) DEFAULT NULL COMMENT 'user created by which medium like web(timestamp), csv(timestamp), api(timestamp) etc',
  `user_AccountDurationStart` datetime DEFAULT NULL COMMENT 'User account duration start date',
  `user_AccountDurationEnd` datetime DEFAULT NULL COMMENT 'User account duration end date',
  `user_CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'user account is created on this date',
  `user_UpdatedOn` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'this column will be update automatically, while the row is updated',
  `User_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-Active, 1-DeActive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_users`
--

INSERT INTO `game_users` (`user_Id`, `user_Fname`, `user_Lname`, `user_Email`, `user_UserName`, `user_Phone`, `user_Pic`, `user_Password`, `user_PasswordEncrypt`, `user_AccountVerification`, `user_CreatedBy`, `user_CreatedMedium`, `user_AccountDurationStart`, `user_AccountDurationEnd`, `user_CreatedOn`, `user_UpdatedOn`, `User_status`) VALUES
(1, 'Mohit', 'Sahu', 'mksahu@gmail.com', 'mohituser', '8882971414', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'registrationPage(1610976394)', NULL, NULL, '2021-01-18 13:26:34', NULL, 0),
(2, 'temp', 'user', 'tmpuser@hum.com', 'tmpuser', '9878765676', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'registrationPage(1611043632)', NULL, NULL, '2021-01-19 08:07:12', NULL, 0),
(3, 'Debasish', 'Das', 'debasish@humanlinks.in', 'richie1', '9871000692', NULL, 'richie1', '3db9d7eb2bd0b94930e453b16e93dd6f', 1, -21, 'registrationPage(1611155808)', NULL, NULL, '2021-01-20 15:16:48', NULL, 0),
(6, 'test', 'user', 'mksgtest@email.com', 'testmks', '8787616543', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'api(1611717837)', NULL, NULL, '2021-01-27 03:23:57', NULL, 0),
(7, 'Debasish', 'Das', 'das_debasish@hotmail.com', 'cherie2', '9871000693', NULL, 'richie11**', '6f97106300a7641fea57d28d36d6c219', 1, -21, 'registrationPage(1613992459)', NULL, NULL, '2021-02-22 11:14:19', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `cart_Id` int(11) NOT NULL,
  `cart_UserId` int(11) DEFAULT NULL,
  `cart_GameId` int(11) DEFAULT NULL,
  `cart_GameJson` longtext COMMENT 'this holds the game data which is requred',
  `cart_CretaedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_Id`);

--
-- Indexes for table `game_purchase`
--
ALTER TABLE `game_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `game_users`
--
ALTER TABLE `game_users`
  ADD PRIMARY KEY (`user_Id`);

--
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD PRIMARY KEY (`cart_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `game_purchase`
--
ALTER TABLE `game_purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `game_users`
--
ALTER TABLE `game_users`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_cart`
--
ALTER TABLE `user_cart`
  MODIFY `cart_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
