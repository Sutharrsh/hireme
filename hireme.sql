-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 20, 2024 at 01:47 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hireme`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `number_of_positions` int(11) DEFAULT NULL,
  `status` enum('verified','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `thumbnail`, `salary`, `position`, `description`, `post_date`, `number_of_positions`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'uploads/job-thumbnails/44b0a5f704676d4610f589180676b106.jpg', '36.00', 'Backend Developer', 'sddkvcnas', '2024-03-20 09:10:27', 5, 'pending', '2024-03-20 09:10:27', '2024-03-20 10:06:31'),
(2, 5, 'uploads/job-thumbnails/44b0a5f704676d4610f589180676b106.jpg', '36.00', '1', 'sddkvcnas', '2024-03-20 09:13:33', 5, 'pending', '2024-03-20 09:13:33', '2024-03-20 09:13:33'),
(3, 5, 'uploads/job-thumbnails/44b0a5f704676d4610f589180676b106.jpg', '36.00', 'Senior', 'sddkvcnas', '2024-03-20 09:14:21', 5, 'pending', '2024-03-20 09:14:21', '2024-03-20 10:06:48');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dp_path` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `career_objective` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `user_id`, `dp_path`, `full_name`, `career_objective`, `contact_number`, `experience_years`, `resume_path`) VALUES
(1, NULL, 'uploads/44b0a5f704676d4610f589180676b106.jpg', 'harsh', 'wqc', '11', 1, 'uploads/kindpng_1697903.png'),
(2, NULL, 'uploads/44b0a5f704676d4610f589180676b106.jpg', 'harsh', 'scsc', '123456', 1, 'uploads/44b0a5f704676d4610f589180676b106.jpg'),
(3, NULL, 'uploads/44b0a5f704676d4610f589180676b106.jpg', 'harsh', 'sd', '123456', 1, 'uploads/44b0a5f704676d4610f589180676b106.jpg'),
(4, 2, 'uploads/44b0a5f704676d4610f589180676b106.jpg', 'harsh', 'demo', '4431243', 1, 'uploads/Invoice.pdf'),
(5, 3, NULL, 'harsh', 'demo', '123456', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_requests`
--

CREATE TABLE `job_requests` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_requests`
--

INSERT INTO `job_requests` (`id`, `job_id`, `user_id`, `status`, `content`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'pending', 'demo', '2024-03-20 12:26:25', '2024-03-20 12:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Elian33', 'your.email+fakedata74252@gmail.com', '$2y$10$OuF5ixbfsMw2G/AGgYvoIu9HUnjwdTudaORYA7uv7TDx2Nn3FIUL.', 'user', '2024-03-20 03:54:52', '2024-03-20 03:54:52'),
(2, 'Demo', 'Demo@gmail.com', '$2y$10$jUFIrUTm1U7wmbleYEkf5eHM06flUdyWa2TK73u5KFTD4brjiGTPu', 'user', '2024-03-20 03:55:37', '2024-03-20 03:55:37'),
(3, 'newDemo', 'new@gmail.com', '$2y$10$.d71xl4CMCdyZ5tAESgRM.uaN3QpHnEzgRdRS2BrRIpV3mk1jfoeK', 'user', '2024-03-20 06:46:53', '2024-03-20 06:46:53'),
(5, 'Demo', 'Demo2@gmail.com', '$2y$10$jUFIrUTm1U7wmbleYEkf5eHM06flUdyWa2TK73u5KFTD4brjiGTPu', 'admin', '2024-03-20 03:55:37', '2024-03-20 08:38:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_requests`
--
ALTER TABLE `job_requests`
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
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_requests`
--
ALTER TABLE `job_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
