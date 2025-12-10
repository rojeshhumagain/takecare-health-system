-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 07:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `takecare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `issue_type` enum('technical','service','feedback','safety','other') NOT NULL,
  `description` text NOT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `name`, `email`, `address`, `issue_type`, `description`, `pdf_file`, `video_file`, `status`, `created_at`) VALUES
(1, 'राम शर्मा', 'ram.sharma@example.com', 'काठमाडौं, नेपाल', 'safety', 'अवैध कामदारको गतिविधि देखिएको छ। कृपया जाँच गर्नुहोस्।', 'report1.pdf', NULL, 'resolved', '2025-07-17 04:15:00'),
(2, 'सीता थापा', 'sita.thapa@example.com', NULL, 'technical', 'वेबसाइट लोड हुन ढिलो छ। कृपया समाधान गर्नुहोस्।', NULL, 'issue1.mp4', 'resolved', '2025-07-16 06:15:00'),
(3, 'हरि नेपाल', 'hari.nepal@example.com', 'ललितपुर, नेपाल', 'feedback', 'सेवा सुधारको लागि सुझाव: थप नेपाली भाषा समर्थन।', 'feedback1.jpg', NULL, 'resolved', '2025-07-18 03:45:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
