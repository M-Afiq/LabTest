-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 11:36 AM
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
-- Database: `labtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `posted_data` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `review` varchar(250) NOT NULL,
  `image` varchar(100) NOT NULL,
  `image_dir` varchar(100) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created` varchar(100) NOT NULL,
  `modified` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `category_id`, `posted_data`, `author`, `title`, `review`, `image`, `image_dir`, `status`, `created`, `modified`) VALUES
(1, '1', 'Moontoon', 'Moontoon', 'Mobile Legend : Bang Bang', 'Best game ever !', 'ML.png', 'uploads', 'active', '2025-07-08 10:27:40', '2025-07-08 10:44:59'),
(4, '5', 'Mark Zuckerberg', 'Mark Zuckerberg', 'WhatsApp', 'Chat with your friends online!', 'ws.png', 'uploads', 'active', '2025-07-08 11:04:16', '2025-07-08 11:04:16'),
(5, '2', 'Ai-gen.co', 'Ai-gen.co', 'ChatGpt', 'Best helper!', 'chatgpt.jpg', 'uploads', 'active', '2025-07-08 11:06:56', '2025-07-08 11:06:56'),
(6, '1', 'Riot Games', 'Riot Games', 'Valorant', 'Vest game ever!', 'valorant.png', 'uploads', 'active', '2025-07-08 11:08:28', '2025-07-08 11:08:28'),
(7, '1', 'NetEase Games', 'NetEase Games', 'Marvel Rivals', 'Best game ever!', 'marvel.png', 'uploads', 'active', '2025-07-08 11:09:32', '2025-07-08 11:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created` varchar(100) NOT NULL,
  `modified` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `status`, `created`, `modified`) VALUES
(1, 'Game', 'active', '2025-07-08 16:43:29', '2025-07-08 16:43:29'),
(2, 'Education', 'active', '2025-07-08 16:43:29', '2025-07-08 16:43:29'),
(3, 'Fitness', 'active', '2025-07-08 16:43:29', '2025-07-08 16:43:29'),
(4, 'Productivity', 'active', '2025-07-08 16:43:29', '2025-07-08 16:43:29'),
(5, 'Entertainment', 'active', '2025-07-08 16:43:29', '2025-07-08 16:43:29'),
(7, 'Books', 'active', '2025-07-08 11:09:46', '2025-07-08 11:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(100) NOT NULL,
  `application_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created` varchar(100) NOT NULL,
  `modified` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `application_id`, `name`, `comment`, `rating`, `status`, `created`, `modified`) VALUES
(2, '1', 'Muhammad Afiq', 'Best game ever!', '5', 'active', '2025-07-08 11:01:45', '2025-07-08 11:01:45'),
(3, '5', 'tung tung tung tung tung tung sahur', 'Very helpful !', '5', 'active', '2025-07-08 11:10:27', '2025-07-08 11:11:46'),
(4, '6', 'Tralarelo Tralala', 'Heh, not bad...I guess', '3', 'active', '2025-07-08 11:11:06', '2025-07-08 11:11:06'),
(5, '7', 'Bombardilo Corcodilo', 'Addicted><', '5', 'active', '2025-07-08 11:11:39', '2025-07-08 11:11:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
