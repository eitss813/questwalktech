-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 18, 2021 at 06:25 PM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `humanlinks`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_Id` int NOT NULL,
  `game_GameId` int DEFAULT NULL COMMENT 'this holds the allocated game id',
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
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `game_purchase`
--

CREATE TABLE `game_purchase` (
  `purchase_id` int NOT NULL,
  `purchase_userId` int DEFAULT NULL,
  `purchase_gameId` int DEFAULT NULL COMMENT 'this is the game id which user has purchased',
  `purchase_transactionId` varchar(250) DEFAULT NULL COMMENT 'This holds the transaction id of game purchase',
  `purchase_gameStartDate` datetime DEFAULT NULL,
  `purchase_gameEndDate` datetime DEFAULT NULL,
  `purchase_createdOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `game_users`
--

CREATE TABLE `game_users` (
  `user_Id` int NOT NULL,
  `user_Fname` varchar(60) DEFAULT NULL,
  `user_Lname` varchar(60) DEFAULT NULL,
  `user_Email` varchar(120) DEFAULT NULL,
  `user_UserName` varchar(60) DEFAULT NULL,
  `user_Phone` varchar(60) DEFAULT NULL,
  `user_Pic` varchar(120) DEFAULT NULL,
  `user_Password` varchar(120) DEFAULT NULL,
  `user_PasswordEncrypt` varchar(255) DEFAULT NULL,
  `user_AccountVerification` tinyint DEFAULT '0' COMMENT '0-Pending for email verification, 1-email verified',
  `user_CreatedBy` int DEFAULT NULL COMMENT 'creator id or -21 for self creation',
  `user_CreatedMedium` varchar(120) DEFAULT NULL COMMENT 'user created by which medium like web(timestamp), csv(timestamp), api(timestamp) etc',
  `user_AccountDurationStart` datetime DEFAULT NULL COMMENT 'User account duration start date',
  `user_AccountDurationEnd` datetime DEFAULT NULL COMMENT 'User account duration end date',
  `user_CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'user account is created on this date',
  `user_UpdatedOn` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'this column will be update automatically, while the row is updated',
  `User_status` tinyint NOT NULL DEFAULT '0' COMMENT '0-Active, 1-DeActive'
) ENGINE=InnoDB;

--
-- Dumping data for table `game_users`
--

INSERT INTO `game_users` (`user_Id`, `user_Fname`, `user_Lname`, `user_Email`, `user_UserName`, `user_Phone`, `user_Pic`, `user_Password`, `user_PasswordEncrypt`, `user_AccountVerification`, `user_CreatedBy`, `user_CreatedMedium`, `user_AccountDurationStart`, `user_AccountDurationEnd`, `user_CreatedOn`, `user_UpdatedOn`, `User_status`) VALUES
(1, 'Mohit', 'Sahu', 'mksahu23506@gmail.com', 'mohituser', '8882971414', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'registrationPage(1607121091)', NULL, NULL, '2020-12-05 04:01:31', '2020-12-23 12:44:24', 0),
(2, 'mohit', 'sahu', 'mksahu@gmail.com', 'mksahu', '7876545678', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'registrationPage(1608707767)', NULL, NULL, '2020-12-23 12:46:07', NULL, 0),
(3, 'ran', 'jana', 'rana@gmail.com', 'ranj', '8765456789', NULL, 'ranj123', '0b308fec066eb38389a7bb6ffde40371', 1, -21, 'registrationPage(1608708191)', NULL, NULL, '2020-12-23 12:53:11', NULL, 0),
(4, 'amar', 'singh', 'amar@gmail.com', 'amars', '8987654345', NULL, 'amars', '27bc28840b78cf67a6c7cb8a80f00658', 1, -21, 'registrationPage(1609306331)', NULL, NULL, '2020-12-30 11:02:11', NULL, 0),
(5, 'temp', 'user', 'tempuser@email.com', 'tempuser', '9879878979', NULL, '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, -21, 'registrationPage(1610098026)', NULL, NULL, '2021-01-08 14:57:06', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `cart_Id` int NOT NULL,
  `cart_UserId` int DEFAULT NULL,
  `cart_GameId` int DEFAULT NULL,
  `cart_GameJson` longtext COMMENT 'this holds the game data which is requred',
  `cart_CretaedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

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
  MODIFY `game_Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_purchase`
--
ALTER TABLE `game_purchase`
  MODIFY `purchase_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_users`
--
ALTER TABLE `game_users`
  MODIFY `user_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_cart`
--
ALTER TABLE `user_cart`
  MODIFY `cart_Id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
