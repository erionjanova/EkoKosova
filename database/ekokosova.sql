-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2026 at 10:49 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ekokosova`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Drin Berish', 'drin@gmail.com', 'Kontakti', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', '2026-02-01 19:33:30'),
(2, 'Filan Fisteku', 'filanfisteku@gmail.com', 'Kontakt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', '2026-02-01 19:37:41'),
(3, 'Test', 'test@gmail.com', 'Kontakt', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', '2026-02-01 19:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(255) NOT NULL,
  `thenje_text` varchar(255) NOT NULL,
  `autori` varchar(255) NOT NULL,
  `autor_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `thenje_text`, `autori`, `autor_img`) VALUES
(1, 'Higjiena eshte gjysma e shendetit!', 'Drin Berisha', 'uploads/697faa9d04bef.jpg'),
(2, 'Higjiena eshte gjysma e shendetit!', 'Filan Fisteku', 'uploads/697fabff2898c.png'),
(3, 'Higjiena eshte gjysma e shendetit!', 'Test', 'uploads/697face3b28bd.png');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `name`, `email`, `city`, `type`, `description`, `photo`, `created_at`) VALUES
(1, 1, 'Drin Berisha', 'drin@gmail.com', 'prishtina', 'ajri', 'Ka ndotje te ajrit', '1769974308_ajri-ndotur.jpg', '2026-02-01 19:31:48'),
(2, 2, 'Filan Fisteku', 'test@gmail.com', 'prizren', 'ujit', 'Uji eshte i ndotur', '1769974582_uji-ndotur.jpg', '2026-02-01 19:36:22'),
(3, 3, 'Test', 'test@gmail.com', 'mitrovice', 'tokes', 'Toka eshte e ndotur!', '1769974910_toka.jpeg', '2026-02-01 19:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `password_changed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_pic`, `username`, `password`, `is_admin`, `reset_token`, `reset_expires`, `password_changed_at`) VALUES
(1, 'Drin Berisha', 'drin@gmail.com', 'uploads/profile_1769974219.jpg', 'drin', '$2y$10$42pe2yEzIWw7o5N4XE8iIuGbM8870bPJ28U4vTAHZG2kkf0HFdY46', 1, NULL, NULL, NULL),
(2, 'Filan Fisteku', 'filanfisteku@gmail.com', 'uploads/member.png', 'filan', '$2y$10$Dg4amGSZbVUy5cvqCzjzfueH1/adUESCIEXs7kCdza7FI7EN0ULyG', 0, NULL, NULL, NULL),
(3, 'Test', 'test@gmail.com', 'uploads/member.png', 'test', '$2y$10$krR0NiF5NNhpVCvVhpl1xeg4iFH2bjgA9Y9zUd9fdLRgZKKOGvex2', 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
