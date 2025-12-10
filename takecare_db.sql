-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 09:30 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(1, 'Sujan Basnet', 'admin@example.com', 'admin123'),
(2, 'Sujan Basnet', 'sujan@gmail.com', 'sujan7206');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_name`, `appointment_date`, `appointment_time`, `reason`, `created_at`) VALUES
(1, 1, 'Rojesh', '2025-07-19', '20:27:00', 'pet dukhyo', '2025-07-18 13:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `image`, `status`, `created_at`) VALUES
(1, 'स्वस्थ हृदयका लागि ५ सुझाव', 'हृदयलाई स्वस्थ राख्न नियमित व्यायाम, सन्तुलित आहार, तनाव व्यवस्थापन, पर्याप्त निद्रा, र धूम्रपानबाट टाढा रहनुहोस्।', 'heart_health.jpg', 'published', '2025-07-15 04:15:00'),
(2, 'मधुमेह नियन्त्रणका उपायहरू', 'मधुमेह नियन्त्रण गर्न कम चिनी भएको खाना, नियमित रगत जाँच, र डाक्टरको सल्लाह पालना गर्नुहोस्।', 'diabetes_tips.jpg', 'published', '2025-07-16 06:15:00'),
(3, 'रोग प्रतिरोधी क्षमता कसरी बढाउने?', 'प्रतिरोधी क्षमता बलियो बनाउन भिटामिन सी, जिंक, र प्रोबायोटिक्सयुक्त खाना खानुहोस्।', '687a74e83200c.png', 'published', '2025-07-17 08:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `status`, `created_at`) VALUES
(1, 'Rojesh Humagain', 'hmgrj061@gmail.com', 'hello', 'resolved', '2025-07-18 15:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education`)),
  `specializations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specializations`)),
  `languages` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `location`, `phone`, `email`, `about`, `education`, `specializations`, `languages`, `image`, `created_at`) VALUES
(1, 'Dr. Sarah Johnson', 'Cardiologist', '123 Medical Drive, Boston, MA 02101', '(555) 123-4567', 'sarah.johnson@takecare.com', 'Dr. Sarah Johnson is a board-certified cardiologist with over 15 years of experience in treating cardiovascular diseases. She specializes in preventive cardiology, heart failure management, and interventional procedures. Dr. Johnson is committed to providing personalized care and educating patients about heart health.', '[\"MD - Harvard Medical School (2008)\",\"Residency - Internal Medicine, Massachusetts General Hospital\",\"Fellowship - Cardiology, Brigham and Women\'s Hospital\",\"Board Certified - American Board of Internal Medicine (Cardiology)\"]', '[\"Preventive Cardiology\",\"Heart Failure Management\",\"Cardiac Catheterization\",\"Echocardiography\",\"Stress Testing\"]', 'English, Spanish', '688085f1d3b73_unnamed.png', '2025-07-18 13:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `description`, `image`, `pdf`, `created_at`) VALUES
(2, 'सिबिर आउने सम्बन्धि जानकारी (२०८२/०४/०२)', 'येही मिति २०८१/१०/१५ गते सिबिर आउदै छ पूर्ण जानकारीको लागि लालको प्द्फ़ हेर्नुहोश.', '687a550713066_Screenshot__3_.png', '687a3a0705e04_lab3output.pdf', '2025-07-18 12:11:51');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `name`, `email`, `address`, `issue_type`, `description`, `pdf_file`, `video_file`, `status`, `created_at`) VALUES
(1, 'राम शर्मा', 'ram.sharma@example.com', 'काठमाडौं, नेपाल', 'safety', 'अवैध कामदारको गतिविधि देखिएको छ। कृपया जाँच गर्नुहोस्।', 'report1.pdf', NULL, 'resolved', '2025-07-17 04:15:00'),
(2, 'सीता थापा', 'sita.thapa@example.com', NULL, 'technical', 'वेबसाइट लोड हुन ढिलो छ। कृपया समाधान गर्नुहोस्।', NULL, 'issue1.mp4', 'resolved', '2025-07-16 06:15:00'),
(3, 'हरि नेपाल', 'hari.nepal@example.com', 'ललितपुर, नेपाल', 'feedback', 'सेवा सुधारको लागि सुझाव: थप नेपाली भाषा समर्थन।', 'feedback1.jpg', NULL, 'resolved', '2025-07-18 03:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Rojesh', 'hmgrj061@gmail.com', '$2y$10$0BsLoj4gEbDHUiYmprqyfu8u1lHgiJ/fxPCa0ontH1nOy0I0ruudC', '2025-07-18 10:12:21'),
(2, 'sujan', 'sujan@gmail.com', '', '2025-07-18 14:31:44'),
(3, 'shyam', 'Shyam@gmail.com', '$2y$10$JfZrLXk1Mt/ePFDMBGzxl.4Xlekbtsb0x5tgY7LY74vbgsUvxBkUq', '2025-07-23 06:47:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
