-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 03:08 PM
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
-- Database: `greenlife_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `email`, `service`, `date`, `time`, `user_id`) VALUES
(1, 'Adnan', 'adnan@greenlife.com', 'Wellness Coaching', '2025-06-30', '15:05:00', 0),
(7, 'adnan fazal', 'adnfaz@greenlife.com', 'Nutrition & Diet', '2025-06-29', '20:17:00', 2),
(8, 'adnan fazal', 'adnfaz@greenlife.com', 'Acupuncture', '2025-06-29', '22:18:00', 0),
(9, 'adnan fazal', 'adnfaz@greenlife.com', 'Ayurvedic Therapy', '2025-06-29', '18:27:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `message`, `date_sent`, `sent_at`, `reply`, `replied_at`, `name`) VALUES
(1, 'adnan@gmail.com', 'hi message', '2025-06-28 09:14:08', '2025-06-28 14:44:08', 'ok', '2025-06-28 11:31:39', NULL),
(2, 'adnan@gmail.com', 'hi', '2025-06-28 09:15:22', '2025-06-28 14:45:22', 'hi', '2025-06-28 10:47:12', NULL),
(3, 'fazal234@gmail.com', 'i want to see dr. jerome', '2025-06-28 11:17:13', '2025-06-28 16:47:13', 'ok ill make sure that', '2025-06-28 11:22:54', NULL),
(4, 'fazal111@gmail.com', 'hello', '2025-06-28 11:30:15', '2025-06-28 17:00:15', 'hello', '2025-06-28 11:33:46', 'adnan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('client','therapist','admin') DEFAULT 'client',
  `phone` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `bio`, `created_at`) VALUES
(1, 'Adnan', 'client@greenlife.com', '$2y$10$nvU157qQx2B0mMEjaeZEeenIUANl9cyXebgK3HO4Xa8E.Zux8HN6m', 'client', NULL, NULL, '2025-06-28 16:37:11'),
(2, 'mohammed', 'client1@greenlife.com', '$2y$10$GxMI7DScSMuCAJ5H5oMnh.o2XaehCSsmRVm0qtpDHYEBuD2qcmlKe', 'client', NULL, NULL, '2025-06-28 16:37:11'),
(3, 'adnan fazal', 'af@greenlife.com', '$2y$10$Dxzsm2y0EdQmL/c7HuHQo.UXYm0Kiq5Wy4uq9MCkWgw5XIPKla23G', 'client', NULL, NULL, '2025-06-28 16:37:11'),
(4, 'mohammed', 'therapist1@greenlife.com', '$2y$10$8.4nzCXwWgwxKnI30r2SPO51sIJNUke883qVdq8by/LD4wsdimIxm', 'client', NULL, NULL, '2025-06-28 16:37:11'),
(5, 'mohammed', 'therapist@greenlife.com', '$2y$10$4dz3prgO8efoSar3MTAujuUGkA6D.2KdDu9U6EccL3ZU0TgRDulV6', 'client', NULL, NULL, '2025-06-28 16:37:11'),
(6, 'mohammed adnan', 'therapist4@greenlife.com', '$2y$10$gXmiHjsC.ExoSefhUC3b9uJKBVJU3WRuVVX9YxDQlSZhoDsUpjHG6', 'therapist', '1234567890', 'i am a therapist studying at icbt', '2025-06-28 16:37:11'),
(7, 'Admin User', 'admin@greenlife.com', '$2y$10$B9di8Y.KYat5JxF3.nNreuhC0FRVFRkePfgvMwVN/RbgAbFpTM4oi', 'admin', NULL, NULL, '2025-06-28 16:37:11'),
(10, 'fazal moh', 'therapist10@greenlife.com', '$2y$10$KtMysWSV09hcl4K4Zmna7eOfTw3WCSZWeShj0JbpTIPFTrC6r34Ky', 'therapist', NULL, NULL, '2025-06-28 16:54:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
