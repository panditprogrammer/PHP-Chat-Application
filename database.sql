-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 09:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpwebrtc`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(255) NOT NULL,
  `fromUser` int(255) DEFAULT NULL,
  `sendTo` int(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `fromUser`, `sendTo`, `status`, `created_on`, `updated_on`) VALUES
(1, 5, 2, '', '2023-05-31 18:54:26', NULL),
(2, 3, 2, '', '2023-05-31 19:24:17', NULL),
(3, 2, 3, '', '2023-05-31 19:41:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chatting`
--

CREATE TABLE `chatting` (
  `id` int(255) NOT NULL,
  `fromUser` int(255) DEFAULT NULL,
  `sendTo` int(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatting`
--

INSERT INTO `chatting` (`id`, `fromUser`, `sendTo`, `message`, `created_on`, `updated_on`) VALUES
(44, 5, 2, 'hi', '2023-05-31 18:54:26', NULL),
(45, 3, 2, 'hi', '2023-05-31 19:24:17', NULL),
(46, 2, 3, 'Hello', '2023-05-31 19:41:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profileImg` varchar(255) DEFAULT NULL,
  `sessionId` varchar(255) DEFAULT NULL,
  `connectionId` varchar(255) DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `profileImg`, `sessionId`, `connectionId`, `last_seen`, `created_on`, `updated_on`) VALUES
(2, 'rakesh87', 'Rakesh', 'rakesh@gmail.com', '$2y$10$cworgCVcxfZJnUYqImhykerf2ZCl5P4qowOg0rqIio0jV8A3Xm/xS', 'avatar-2.jpg', 'jgp4a95ukoqc0r3tuv6odi63ml', '132', '2023-06-01 00:52:00', '2023-05-16 21:38:52', NULL),
(3, 'Ajay435', 'Ajay', 'ajay@gmail.com', '$2y$10$cworgCVcxfZJnUYqImhykerf2ZCl5P4qowOg0rqIio0jV8A3Xm/xS', 'default-user.png', '23p4r18llgcivlg855br9moru3', '132', '2023-06-01 01:01:39', '2023-05-16 21:39:42', NULL),
(5, 'admin', NULL, 'Panditprogrammer@gmail.com', '$2y$10$cworgCVcxfZJnUYqImhykerf2ZCl5P4qowOg0rqIio0jV8A3Xm/xS', NULL, 'eeqs0m0kbbdthu6r0ghbgt8582', NULL, '2023-05-31 23:08:53', '2023-05-25 10:10:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatting`
--
ALTER TABLE `chatting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`fromUser`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chatting`
--
ALTER TABLE `chatting`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatting`
--
ALTER TABLE `chatting`
  ADD CONSTRAINT `chatting_ibfk_1` FOREIGN KEY (`fromUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
