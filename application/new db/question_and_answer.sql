-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 05:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `question_and_answer`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `CommentBody` varchar(150) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentId`, `UserId`, `PostId`, `CommentBody`, `Timestamp`) VALUES
(1, 7, 7, 'ok i got it as grape', '2024-05-12 03:17:05'),
(2, 7, 10, 'it is a framework', '2024-05-12 03:40:11'),
(3, 7, 11, 'this is a about gram', '2024-05-12 08:23:48'),
(4, 7, 11, 'second about gram', '2024-05-12 08:58:20'),
(5, 7, 9, 'this is 1 about php', '2024-05-12 09:02:00'),
(6, 8, 11, 'this is from isuru2', '2024-05-12 09:07:07'),
(7, 8, 12, 'this is a about xml', '2024-05-12 11:44:41'),
(8, 7, 12, 'cvvbg', '2024-05-12 17:05:30'),
(9, 7, 18, 'backbone js is an javascript ', '2024-05-12 18:16:03'),
(10, 7, 24, 'Steps to delete a database:\nConnect to MySQL: Open', '2024-05-15 05:51:22'),
(11, 7, 24, 'yes', '2024-05-15 09:11:52'),
(12, 7, 12, 'its a language', '2024-05-15 09:13:31'),
(13, 7, 26, 'create_db name ', '2024-05-15 13:54:20'),
(14, 7, 26, 'check for the tutorials', '2024-05-15 14:28:44'),
(15, 7, 24, 'no', '2024-05-15 16:47:26'),
(16, 7, 27, 'tr', '2024-05-15 16:48:48'),
(17, 7, 27, 'tags are used to open and close in between the htm', '2024-05-15 16:48:55'),
(18, 7, 27, 'yes', '2024-05-16 00:55:44'),
(19, 7, 27, 'its a tag', '2024-05-16 00:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `QuesttagId` int(11) NOT NULL DEFAULT 1,
  `Question` varchar(255) DEFAULT NULL,
  `Caption` varchar(100) DEFAULT '',
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `QuestionTags` varchar(255) NOT NULL DEFAULT 'No Tags'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostId`, `UserId`, `QuesttagId`, `Question`, `Caption`, `Timestamp`, `QuestionTags`) VALUES
(3, 7, 3, 'xczxc', 'sdkhfjlksjf', '2024-05-11 16:33:35', 'No Tags'),
(4, 7, 3, 'ddd', 'dds', '2024-05-11 16:35:01', 'No Tags'),
(5, 7, 3, 'zxcxc', 'card', '2024-05-11 17:54:53', 'No Tags'),
(6, 7, 2, 'ryy', 'tytu', '2024-05-12 03:10:14', 'No Tags'),
(7, 7, 4, 'grapes', 'this is grape', '2024-05-12 03:11:16', 'No Tags'),
(8, 7, 5, 'kpkp', 'ddd', '2024-05-12 03:28:05', 'No Tags'),
(9, 7, 5, 'What is PHP?', 'caption about php', '2024-05-12 03:31:36', 'No Tags'),
(10, 7, 3, NULL, 'What is LARAVEl', '2024-05-12 03:39:38', 'No Tags'),
(11, 7, 4, 'This is about Gram', 'Gram', '2024-05-12 03:50:30', 'No Tags'),
(12, 8, 3, 'What is XML', 'about xml', '2024-05-12 11:43:44', 'No Tags'),
(13, 7, 3, 'chn', 'bb', '2024-05-12 12:20:49', 'No Tags'),
(14, 7, 3, 'xml', 'dsf', '2024-05-12 17:11:22', 'No Tags'),
(15, 7, 5, 'ghjgj', 'nbnb', '2024-05-12 17:11:42', 'No Tags'),
(17, 7, 3, 'udemy', 'this is udemy', '2024-05-12 17:28:16', 'this is a manual tag'),
(18, 7, 4, 'What is Backbone Js', 'about backbone', '2024-05-12 18:12:48', 'No Tags'),
(24, 7, 6, 'How to delete a database?which is used to display a table and the related columns in it and how does it work ?', 'About How to delete a DB', '2024-05-15 05:49:08', 'No Tags'),
(25, 7, 2, 'test1', 'test1', '2024-05-15 06:46:01', 'No Tags'),
(26, 7, 6, 'How to create a db\n?', 'About How to create a db', '2024-05-15 09:58:18', 'No Tags'),
(27, 7, 3, 'what do you call for a tag in html ?', 'html codes', '2024-05-15 16:48:21', 'No Tags'),
(28, 7, 8, 'what is Nodejs?', 'about node', '2024-05-16 00:56:34', 'No Tags'),
(30, 7, 5, 'what are the generations of PHP?', NULL, '2024-05-16 02:47:03', 'No Tags'),
(31, 7, 7, 'gek', 'getx', '2024-05-16 02:48:50', 'No Tags');

-- --------------------------------------------------------

--
-- Table structure for table `questtag`
--

CREATE TABLE `questtag` (
  `QuesttagId` int(11) NOT NULL,
  `QuesttagName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questtag`
--

INSERT INTO `questtag` (`QuesttagId`, `QuesttagName`) VALUES
(1, ''),
(2, 'CSS'),
(3, 'HTML'),
(4, 'JAVA'),
(5, 'PHP'),
(6, 'DATABASES'),
(7, 'REACT'),
(8, 'NODEJS'),
(9, 'PYTHON'),
(10, 'ANGULAR'),
(11, 'JAVA'),
(12, 'C#'),
(13, 'RUBY'),
(14, 'PHP'),
(15, 'SWIFT');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RateId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`RateId`, `UserId`, `PostId`, `Timestamp`) VALUES
(3, 7, 11, '2024-05-12 00:22:30'),
(0, 7, 9, '2024-05-16 02:15:47'),
(0, 7, 7, '2024-05-16 02:17:12'),
(0, 7, 24, '2024-05-16 02:17:33'),
(0, 7, 27, '2024-05-16 02:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserImage` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Name`, `Email`, `Password`, `UserImage`) VALUES
(7, '@isuru', 'atthanayake1', 'isuru.atthanayake@gmail.com', '$2y$10$oV.HA77BwTjNTcyndZGYAu3x95z0Qnitp/feagyys4w6zMiUFJLy2', 'default.jpg'),
(8, '@isuru2', 'b', 'isuru.atthanayake@gmail.com', '$2y$10$Z01F7wnNc3i9Zh4yCKE5Fuo8SorD333l0YLOmz.50ySYiqp/X9VgS', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentId`),
  ADD KEY `FK_CommentUser` (`UserId`),
  ADD KEY `FK_CommentPost` (`PostId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostId`),
  ADD KEY `FK_PostUser` (`UserId`),
  ADD KEY `FK_PostQuesttag` (`QuesttagId`);

--
-- Indexes for table `questtag`
--
ALTER TABLE `questtag`
  ADD PRIMARY KEY (`QuesttagId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_CommentPost` FOREIGN KEY (`PostId`) REFERENCES `posts` (`PostId`),
  ADD CONSTRAINT `FK_CommentUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_PostQuesttag` FOREIGN KEY (`QuesttagId`) REFERENCES `questtag` (`QuesttagId`),
  ADD CONSTRAINT `FK_PostUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
