-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2019 at 01:31 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osadnicy`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `drewno` int(11) NOT NULL,
  `kamien` int(11) NOT NULL,
  `zboze` int(11) NOT NULL,
  `dnipremium` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `drewno`, `kamien`, `zboze`, `dnipremium`) VALUES
(1, 'adam', '$2y$10$HKDiQMK6mOQ7g4MppR5L1O1KyIB2l3/Yyqpjk7znwAvipmijbYO7e', 'adam@gmail.com', 213, 5675, 342, '2019-02-19 17:48:05'),
(2, 'marek', 'asdfg', 'marek@gmail.com', 324, 1123, 4325, '0000-00-00 00:00:00'),
(3, 'anna', 'zxcvb', 'anna@gmail.com', 4536, 17, 120, '0000-00-00 00:00:00'),
(4, 'andrzej', 'asdfg', 'andrzej@gmail.com', 5465, 132, 189, '0000-00-00 00:00:00'),
(5, 'justyna', 'yuiop', 'justyna@gmail.com', 245, 890, 554, '0000-00-00 00:00:00'),
(6, 'kasia', 'hjkkl', 'kasia@gmail.com', 267, 980, 109, '0000-00-00 00:00:00'),
(7, 'beata', 'fgthj', 'beata@gmail.com', 565, 356, 447, '0000-00-00 00:00:00'),
(8, 'jakub', 'ertyu', 'jakub@gmail.com', 2467, 557, 876, '0000-00-00 00:00:00'),
(9, 'janusz', 'cvbnm', 'janusz@gmail.com', 65, 456, 2467, '0000-00-00 00:00:00'),
(10, 'roman', 'dfghj', 'roman@gmail.com', 97, 226, 245, '0000-00-00 00:00:00'),
(11, 'ReznoR', '$2y$10$CQi2yA5EWqv8YMgJe2ce0.l0RFHKx7Dr28LIoESaxU68WeCYP6/gC', 'mic3arena@gmail.com', 100, 100, 100, '0000-00-00 00:00:00'),
(12, 'LittleBunny', '$2y$10$SBYInEVwFwuzhc4rkMk2QuPreVA8vUO1u7B86DwzQuc/JlK8LIv2K', 'little.bunny@narnia.com', 100, 100, 100, '0000-00-00 00:00:00'),
(13, 'Janek', '$2y$10$C94eklfcICvcHv4DK6awVuIOkrBOd8qY/jkfp7xAn56gSNAlgOQBC', 'kowalski@gmail.com', 100, 100, 100, '0000-00-00 00:00:00'),
(14, 'krzysztof', '$2y$10$h8vqab5iv5HeSFJiuRwco.VyInR2fFw99jQzKGWtFX8kh7CjWgSUO', 'krzysztof@gmail.com', 100, 100, 100, '2019-02-19 17:44:21'),
(15, 'reznor1', '$2y$10$1kIwM2VESt.9A5Jm2wnT5uEiFXB.n4jJAXQ0ajwOoPQUQPNAhZXna', 'reznor1@reznor.tech', 100, 100, 100, '2019-05-25 00:51:04'),
(16, 'reznor2', '$2y$10$EgxbZqH1jGluaf6p2iuGY.HKkOi4d.22mB2WCOAFG5dCos0B7.3NC', 'reznor2@reznor.tech', 100, 100, 100, '2019-05-25 00:56:31'),
(17, 'reznor3', '$2y$10$5AGmGzl9SXb2QwjP2eD7O.F/KJWdtaNRtXV9AdZmeIGqXf2HFmc0K', 'reznor3@reznor.tech', 100, 100, 100, '2019-05-25 01:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `drewno` int(11) NOT NULL,
  `kamien` int(11) NOT NULL,
  `zboze` int(11) NOT NULL,
  `dnipremium` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `user`, `pass`, `email`, `drewno`, `kamien`, `zboze`, `dnipremium`) VALUES
(1, 'adam', '$2y$10$HKDiQMK6mOQ7g4MppR5L1O1KyIB2l3/Yyqpjk7znwAvipmijbYO7e', 'adam@gmail.com', 213, 5675, 342, '2019-02-19 17:48:05'),
(2, 'marek', 'asdfg', 'marek@gmail.com', 324, 1123, 4325, '0000-00-00 00:00:00'),
(3, 'anna', 'zxcvb', 'anna@gmail.com', 4536, 17, 120, '0000-00-00 00:00:00'),
(4, 'andrzej', 'asdfg', 'andrzej@gmail.com', 5465, 132, 189, '0000-00-00 00:00:00'),
(5, 'justyna', 'yuiop', 'justyna@gmail.com', 245, 890, 554, '0000-00-00 00:00:00'),
(6, 'kasia', 'hjkkl', 'kasia@gmail.com', 267, 980, 109, '0000-00-00 00:00:00'),
(7, 'beata', 'fgthj', 'beata@gmail.com', 565, 356, 447, '0000-00-00 00:00:00'),
(8, 'jakub', 'ertyu', 'jakub@gmail.com', 2467, 557, 876, '0000-00-00 00:00:00'),
(9, 'janusz', 'cvbnm', 'janusz@gmail.com', 65, 456, 2467, '0000-00-00 00:00:00'),
(10, 'roman', 'dfghj', 'roman@gmail.com', 97, 226, 245, '0000-00-00 00:00:00'),
(11, 'ReznoR', '$2y$10$CQi2yA5EWqv8YMgJe2ce0.l0RFHKx7Dr28LIoESaxU68WeCYP6/gC', 'mic3arena@gmail.com', 100, 100, 100, '0000-00-00 00:00:00'),
(12, 'LittleBunny', '$2y$10$SBYInEVwFwuzhc4rkMk2QuPreVA8vUO1u7B86DwzQuc/JlK8LIv2K', 'little.bunny@narnia.com', 100, 100, 100, '0000-00-00 00:00:00'),
(13, 'Janek', '$2y$10$C94eklfcICvcHv4DK6awVuIOkrBOd8qY/jkfp7xAn56gSNAlgOQBC', 'kowalski@gmail.com', 100, 100, 100, '0000-00-00 00:00:00'),
(14, 'krzysztof', '$2y$10$h8vqab5iv5HeSFJiuRwco.VyInR2fFw99jQzKGWtFX8kh7CjWgSUO', 'krzysztof@gmail.com', 100, 100, 100, '2019-02-19 17:44:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
