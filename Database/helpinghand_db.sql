-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 08:06 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpinghand_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(10, 'Old Age Home'),
(11, 'Pakistan Sweet Homes'),
(12, 'Human Shelters');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `Donation_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Center_ID` int(11) DEFAULT NULL,
  `Donation_Amount` decimal(10,2) DEFAULT NULL,
  `Donation_Type` varchar(20) DEFAULT NULL,
  `Donation_Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`Donation_ID`, `User_ID`, `Center_ID`, `Donation_Amount`, `Donation_Type`, `Donation_Date`) VALUES
(1, 2, 1, '1000.00', 'Hand', '2023-08-09 09:47:28'),
(2, 2, 1, '2000.00', 'Hand', '2023-08-09 09:50:14'),
(3, 2, 1, '2000.00', 'Online Payment', '2023-08-09 09:50:22'),
(4, 2, 1, '2000.00', 'Online Payment', '2023-08-09 09:51:27'),
(5, 2, 1, '300.00', 'Online Payment', '2023-08-09 10:43:36'),
(6, 2, 1, '300.00', 'Online Payment', '2023-08-09 10:44:48'),
(7, 2, 1, '300.00', 'Hand', '2023-08-09 10:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `donation_centers`
--

CREATE TABLE `donation_centers` (
  `Center_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Contact_Number` varchar(20) NOT NULL,
  `Description` text NOT NULL,
  `Picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation_centers`
--

INSERT INTO `donation_centers` (`Center_ID`, `Name`, `Category_ID`, `Location`, `Contact_Number`, `Description`, `Picture`) VALUES
(1, 'Pakistan Sweet Home', 11, 'Near Multan Road', '23332132', 'please donate', 'uploads/school.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text DEFAULT NULL,
  `sent_datetime` datetime DEFAULT current_timestamp(),
  `reply_text` text DEFAULT NULL,
  `reply_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `sent_datetime`, `reply_text`, `reply_datetime`) VALUES
(2, 1, 0, 'i want to purchase a car ', '2023-08-08 12:39:12', NULL, NULL),
(3, 2, 0, 'I want to buy some items', '2023-08-08 12:58:06', 'which one', '2023-08-08 12:59:36'),
(4, 2, 0, 'hy', '2023-08-09 09:30:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Center_ID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Review_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Review_Text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_ID`, `User_ID`, `Center_ID`, `Rating`, `Review_Date`, `Review_Text`) VALUES
(1, 2, 1, 3, '2023-08-09 04:58:44', 'You need to donate');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `age`) VALUES
(1, 'Twilight807', '$2y$10$mHPacTtbWMQ7SiCbvhyBEe.NKn1UOwuuHKXQRexlN3loD6HED4yTy', 'TwilightTales827@gmail.com', '123', 22),
(2, 'nasir', '$2y$10$he77bAAf5nZSyATs8POB7.6tRAEgcf4J4c/BZnN6qR2CS7EuVQDeC', 'nasir827@gmail.com', '12345', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`Donation_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Center_ID` (`Center_ID`);

--
-- Indexes for table `donation_centers`
--
ALTER TABLE `donation_centers`
  ADD PRIMARY KEY (`Center_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Center_ID` (`Center_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `Donation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `donation_centers`
--
ALTER TABLE `donation_centers`
  MODIFY `Center_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`Center_ID`) REFERENCES `donation_centers` (`Center_ID`);

--
-- Constraints for table `donation_centers`
--
ALTER TABLE `donation_centers`
  ADD CONSTRAINT `donation_centers_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`Center_ID`) REFERENCES `donation_centers` (`Center_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
