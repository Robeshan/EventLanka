-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 06:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventlankadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `role` varchar(50) DEFAULT 'Administrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `userId`, `role`) VALUES
(1, 2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventId` int(11) NOT NULL,
  `eventName` varchar(100) NOT NULL,
  `eventType` varchar(50) DEFAULT NULL,
  `eventDescription` text DEFAULT NULL,
  `eventDate` date DEFAULT NULL,
  `eventVenue` varchar(255) DEFAULT NULL,
  `noOfGuests` int(11) DEFAULT NULL,
  `adminId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventId`, `eventName`, `eventType`, `eventDescription`, `eventDate`, `eventVenue`, `noOfGuests`, `adminId`) VALUES
(1, 'Wedding Reception', 'Wedding', 'A grand wedding reception', '2024-12-15', 'Colombo Hilton', 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comments` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `isRead` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `packageId` int(11) NOT NULL,
  `packageName` varchar(100) NOT NULL,
  `packageDetails` text NOT NULL,
  `serviceProviderId` int(11) NOT NULL,
  `packagePrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`packageId`, `packageName`, `packageDetails`, `serviceProviderId`, `packagePrice`) VALUES
(1, 'Wedding Bliss Package', 'A comprehensive wedding package that includes catering, decoration, and photography services.', 2, 150000.00),
(2, 'Corporate Event Package', 'Tailored packages for corporate events including venue, catering, and equipment rental.', 3, 100000.00),
(3, 'Party Celebration Package', 'Complete package for birthday parties, including food, decoration, and entertainment.', 4, 80000.00),
(18, 'Wedding Bliss Package', 'A comprehensive wedding package that includes catering, decoration, and photography services.', 2, 150000.00),
(19, 'Corporate Event Package', 'Tailored packages for corporate events including venue, catering, and equipment rental.', 3, 100000.00),
(20, 'Party Celebration Package', 'Complete package for birthday parties, including food, decoration, and entertainment.', 4, 80000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL,
  `paymentDate` date NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `userId` int(11) NOT NULL,
  `packageId` int(11) NOT NULL,
  `amount` float NOT NULL,
  `advanceAmount` float DEFAULT NULL,
  `dueAmount` float DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `exp_month` varchar(10) NOT NULL,
  `exp_year` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `otp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentId`, `paymentDate`, `paymentMethod`, `userId`, `packageId`, `amount`, `advanceAmount`, `dueAmount`, `first_name`, `last_name`, `email`, `city`, `zip_code`, `card_name`, `card_number`, `exp_month`, `exp_year`, `cvv`, `status`, `otp`) VALUES
(7, '0000-00-00', '', 19, 0, 100, NULL, NULL, 'kisho', 'jeyapragash ', 'kishojeyapragash@gmail.com', 'batticaloa', '30364', 'jeyapragash ', '123456789012', '12', '2024', '173', 'Pending', '$2y$10$hB2TMQxXGL5KA9VMropdL.I43iVvU6P9IuKDs3TzTjgA/mroEEY4i'),
(8, '0000-00-00', '', 19, 0, 100, NULL, NULL, 'kisho', 'jeyapragash ', 'kishojeyapragash@gmail.com', 'batticaloa', '30364', 'jeyapragash ', '123456789012', '12', '2024', '173', 'Pending', '$2y$10$3Tgo1IZpXZjixEqW1.BSd.peUL7WUO7SrN4p29rSw2dPOYbgIeaNa'),
(9, '0000-00-00', '', 19, 0, 100, NULL, NULL, 'kisho', 'jeyapragash ', 'kishojeyapragash@gmail.com', 'batticaloa', '30364', 'jeyapragash ', '123456789012', '12', '2024', '173', 'Pending', '$2y$10$EH.WIoLzBqsVm2NVmGwnl.esXW4Q5ODc2SNBknR0UMTKMKXLZyV3u');

-- --------------------------------------------------------

--
-- Table structure for table `registereduser`
--

CREATE TABLE `registereduser` (
  `userId` int(11) NOT NULL,
  `contactNumber` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `NICNumber` varchar(20) DEFAULT NULL,
  `NICFrontPhoto` varchar(255) DEFAULT NULL,
  `NICBackPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serviceprovider`
--

CREATE TABLE `serviceprovider` (
  `providerId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `providerName` varchar(100) NOT NULL,
  `contactInfo` varchar(50) NOT NULL,
  `serviceDetails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serviceprovider`
--

INSERT INTO `serviceprovider` (`providerId`, `userId`, `providerName`, `contactInfo`, `serviceDetails`) VALUES
(2, 4, 'catering ', '200003332332', 'hi hello'),
(3, 6, 'catering ', '200003332332', 'hi hello'),
(4, 10, 'robeash', '0745236542', 'hi iam rob'),
(5, 11, 'kanthan', '7896541230', 'this is vehicle hire services '),
(6, 18, 'play', '1234569870', 'hi how are you'),
(13, 20, 'catering ', '0752321456', 'this is catering service');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `serviceId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `serviceName` varchar(100) NOT NULL,
  `serviceDescription` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceId`, `userId`, `serviceName`, `serviceDescription`, `status`) VALUES
(1, 6, 'Wedding Catering', 'Providing traditional Sri Lankan wedding catering services including rice and curry, short eats, and desserts.', 'pending'),
(2, 8, 'Event Decoration', 'Full-service decoration for weddings, parties, and corporate events, featuring local flowers and traditional themes.', 'approved'),
(3, 10, 'Photography Services', 'Professional photography services for weddings and events, capturing moments with high-quality images.', 'pending'),
(4, 6, 'DJ Services', 'Experienced DJs providing music and entertainment for weddings, parties, and corporate events.', 'approved'),
(5, 8, 'Event Planning', 'Comprehensive event planning services to manage and execute weddings and corporate events seamlessly.', 'pending'),
(6, 10, 'Makeup Services', 'Professional makeup artists providing services for brides and special events, using high-quality products.', 'approved'),
(7, 10, 'Transport Services', 'Luxury vehicle rentals for weddings and events, including cars and vans for guest transport.', 'pending'),
(8, 10, 'Videography', 'High-definition videography services for capturing wedding events and creating memorable videos.', 'approved'),
(11, 11, 'dj', 'hi', 'pending'),
(12, 9, 'kalavu eduththal', 'hi iam shahnas', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `userType` enum('guest','registered','admin','serviceProvider') NOT NULL DEFAULT 'guest',
  `profilePicture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `email`, `userType`, `profilePicture`, `created_at`, `updated_at`) VALUES
(2, 'newusername', '$2y$10$yourhashedpassword', 'keanu@gmail.com', 'admin', NULL, '2024-09-30 03:00:00', '2024-10-01 14:41:10'),
(4, 'love', '$2y$10$771H5xXg8i6kSc2D8MvCTejTQmEwozm/nW1jCLiSoMfRu1XQwlN8O', 'll@gmail.com', 'serviceProvider', NULL, '2024-09-30 08:52:48', '2024-09-30 08:52:48'),
(6, 'pragash15', '$2y$10$dc1i2thLZDaHdsZKFQX9HOb37n6KWScYAQ5EmCm4URwFfzMFz9USC', 'pragash@gmail.com', 'serviceProvider', '../uploads/IMG_20230831_134206.jpg', '2024-09-30 09:35:27', '2024-10-02 06:49:56'),
(8, 'faiha', '$2y$10$6ELe36bwcKQwrfJCfyZuuu0ZEVQX2VSpLJyTDu/t5cvP7Uj6p/FFy', 'faiha@gmail.com', 'registered', NULL, '2024-09-30 11:33:24', '2024-09-30 11:33:24'),
(9, 'shahnasm', '$2y$10$N8ah6Ciho.B4O8tsyc2AsOnMTs213SORPe4kn85kwA5d.9TQ5d8gO', 'shahnas@gmail.com', 'registered', '../uploads/IMG-20230831-WA0054.jpg', '2024-10-01 01:57:18', '2024-10-02 05:16:54'),
(10, 'robeash1', '$2y$10$rcW0bWoFPtGoTyBPr5h7AOi83t9j7EpDjKKW3fYTXD2C7RRvpyMjO', 'robeash1@gmail.com', 'serviceProvider', NULL, '2024-10-01 03:34:14', '2024-10-01 03:34:14'),
(11, 'kanthan', '$2y$10$RB3gAMZQCiloYKOJ4Czp1.TwhHgruaBvjL5anTNVFeeGCeIRXeW/y', 'kanthan@gmail.com', 'serviceProvider', NULL, '2024-10-01 07:53:55', '2024-10-01 07:53:55'),
(16, 'event_admin', '$2y$10$yPak4tG7NSdNvLC4/JfkJ.DL5dCYPQKePBrK2ttnEp.8tQN6bu.5C', 'event_admin@example.com', 'admin', NULL, '2024-10-01 15:02:53', '2024-10-01 15:17:15'),
(17, 'yuvan', '$2y$10$SP3ZA8VfJR.pXKIFPcXduuJicH0Z1GR6x0qWiYM03ufttj0m0k.jK', 'yuvan@gmail.com', 'registered', NULL, '2024-10-02 12:54:06', '2024-10-02 12:54:06'),
(18, 'plays', '$2y$10$SOtstDKJ3eINtjTDnMGc8upysSnZypM1bfW6wQt0YUeomz7AYWw9W', 'kash@gmail.com', 'serviceProvider', '../uploads/IMG-20230706-WA0020.jpg', '2024-10-02 12:55:32', '2024-10-02 12:56:29'),
(19, 'Dkeerthikan', '$2y$10$e2SKp.4KaUbcZlox3AMMjeYJtLOeIntAMYMVPOVodmrtqoMw9uAVq', 'keerthikan@gmail.com', 'registered', '../uploads/IMG_20230831_134131.jpg', '2024-10-03 13:45:01', '2024-10-03 15:02:22'),
(20, 'catering ', '$2y$10$jZdXsxeiOIFAPV5kmu0Z4eTrHiuOmqMnH/vRoMphSXBrbZUXZNWuW', 'cat@gmail.com', 'serviceProvider', '../uploads/20221230_092134.jpg', '2024-10-03 13:48:46', '2024-10-03 14:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `usereventbooking`
--

CREATE TABLE `usereventbooking` (
  `bookingId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `bookingDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventId`),
  ADD KEY `adminId` (`adminId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`packageId`),
  ADD KEY `packages_ibfk_1` (`serviceProviderId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `registereduser`
--
ALTER TABLE `registereduser`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `serviceprovider`
--
ALTER TABLE `serviceprovider`
  ADD PRIMARY KEY (`providerId`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`serviceId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userName` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usereventbooking`
--
ALTER TABLE `usereventbooking`
  ADD PRIMARY KEY (`bookingId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `eventId` (`eventId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `packageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `serviceprovider`
--
ALTER TABLE `serviceprovider`
  MODIFY `providerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `serviceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `usereventbooking`
--
ALTER TABLE `usereventbooking`
  MODIFY `bookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`adminId`) ON DELETE SET NULL;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `registereduser` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `registereduser` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`serviceProviderId`) REFERENCES `serviceprovider` (`providerId`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `registereduser`
--
ALTER TABLE `registereduser`
  ADD CONSTRAINT `registereduser_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `serviceprovider`
--
ALTER TABLE `serviceprovider`
  ADD CONSTRAINT `serviceprovider_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `usereventbooking`
--
ALTER TABLE `usereventbooking`
  ADD CONSTRAINT `usereventbooking_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `registereduser` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `usereventbooking_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
