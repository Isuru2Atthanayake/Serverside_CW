-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 07:10 AM
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
-- Database: `holiday`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `CommentBody` varchar(50) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentId`, `UserId`, `PostId`, `CommentBody`, `Timestamp`) VALUES
(1, 7, 7, 'ok i got it as grape', '2024-05-12 03:17:05'),
(2, 7, 10, 'it is a framework', '2024-05-12 03:40:11'),
(3, 7, 11, 'this is a commet about gram', '2024-05-12 08:23:48'),
(4, 7, 11, 'second comment about gram', '2024-05-12 08:58:20'),
(5, 7, 9, 'this is comment 1 about php', '2024-05-12 09:02:00'),
(6, 8, 11, 'this is from isuru2', '2024-05-12 09:07:07'),
(7, 8, 12, 'this is a comment about xml', '2024-05-12 11:44:41'),
(8, 7, 12, 'cvvbg', '2024-05-12 17:05:30'),
(9, 7, 18, 'backbone js is an javascript ', '2024-05-12 18:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `FollowId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `IsFollowing` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`FollowId`, `UserId`, `IsFollowing`, `Timestamp`) VALUES
(3, 7, 1, '2024-05-11 16:38:17'),
(4, 8, 5, '2024-05-12 04:06:14'),
(5, 7, 7, '2024-05-12 10:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `LikeId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`LikeId`, `UserId`, `PostId`, `Timestamp`) VALUES
(1, 7, 7, '2024-05-12 03:17:46'),
(2, 7, 9, '2024-05-12 05:52:18'),
(3, 7, 11, '2024-05-12 05:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationId` int(11) NOT NULL,
  `LocationName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationId`, `LocationName`) VALUES
(1, ''),
(2, 'CSS'),
(3, 'HTML'),
(4, 'JAVA'),
(5, 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `NotifId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `FromUser` int(11) NOT NULL,
  `PostId` int(11) DEFAULT NULL,
  `CommentBody` varchar(50) DEFAULT NULL,
  `Notification` varchar(100) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`NotifId`, `UserId`, `FromUser`, `PostId`, `CommentBody`, `Notification`, `Timestamp`) VALUES
(3, 1, 7, NULL, NULL, 'Followed you!', '2024-05-11 16:38:18'),
(4, 7, 7, 7, 'ok i got it as grape', 'Commented on your post!', '2024-05-12 03:17:06'),
(5, 7, 7, 7, NULL, 'Liked your post!', '2024-05-12 03:17:46'),
(6, 7, 7, 10, 'it is a framework', 'Commented on your post!', '2024-05-12 03:40:11'),
(7, 5, 8, NULL, NULL, 'Followed you!', '2024-05-12 04:06:14'),
(8, 7, 7, 9, NULL, 'Liked your post!', '2024-05-12 05:52:18'),
(9, 7, 7, 11, NULL, 'Liked your post!', '2024-05-12 05:52:30'),
(10, 7, 7, 11, 'this is a commet about gram', 'Commented on your post!', '2024-05-12 08:23:48'),
(11, 7, 7, 11, 'second comment about gram', 'Commented on your post!', '2024-05-12 08:58:20'),
(12, 7, 7, 9, 'this is comment 1 about php', 'Commented on your post!', '2024-05-12 09:02:00'),
(13, 7, 8, 11, 'this is from isuru2', 'Commented on your post!', '2024-05-12 09:07:07'),
(14, 7, 7, NULL, NULL, 'Followed you!', '2024-05-12 10:24:08'),
(15, 8, 8, 12, 'this is a comment about xml', 'Commented on your post!', '2024-05-12 11:44:41'),
(16, 8, 7, 12, 'cvvbg', 'Commented on your post!', '2024-05-12 17:05:31'),
(17, 7, 7, 18, 'backbone js is an javascript ', 'Commented on your post!', '2024-05-12 18:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `LocationId` int(11) NOT NULL DEFAULT 1,
  `Question` varchar(255) DEFAULT NULL,
  `Caption` varchar(100) DEFAULT '',
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `QuestionTags` varchar(255) NOT NULL DEFAULT 'No Tags'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostId`, `UserId`, `LocationId`, `Question`, `Caption`, `Timestamp`, `QuestionTags`) VALUES
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
(18, 7, 4, 'What is Backbone Js', 'about backbone', '2024-05-12 18:12:48', 'No Tags');

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
  `UserBio` varchar(120) DEFAULT '',
  `UserImage` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Name`, `Email`, `Password`, `UserBio`, `UserImage`) VALUES
(1, '@car', 'car', 'car@gmail.com', '$2y$10$1PTwVdsubvdMJWLjAyAH/.CkwEtZICQIhA9IfMuSlqMhIwoFktmaC', '', 'default.jpg'),
(2, '@rhaenyra', 'Rhaenyra Targaryen', 'rhaenyra@dragonstone.com', '$2y$10$ldz94NbF.DrRdy3k0djRd.4t9Xj/PCTn79xrv.hR1tIAMu.gRWuD.', 'Looking for a new family', 'rhane.jpg'),
(3, '@bellatrix ', 'Bellatrix Lestrange', 'bella@deatheaters.com', '$2y$10$ajhNva7pjn1pfPEeNee6xuVhTaxU/M5lkwBvx4Gt.MZ9dGxUPamNa', 'Pro death eater <3', 'bella.jpg'),
(4, '@ye', 'Kanye West', 'kanye@forpresi.com', '$2y$10$riEMXAWu3FYdCUQ0DGOihuO7ky6XWj/vXmqB/2fj78vs68OiEukQK', 'Kanye for president', 'kanye.jpg'),
(5, '@robbstark', 'Robb Stark', 'robb@winterfell.com', '$2y$10$Lk9AgZ4hKoCtJrj0bleTZeMH7IXkj.229gCc2Y/o5QZLTK9AFHPJS', 'Who kills people at weddings?', 'robb.jpg'),
(6, '@morticia', 'Morticia Addams', 'tish@addams.com', '$2y$10$KSbhBBpRqMjXFmfN1SxAmea03evwAaXWqwlwOHL6kIP8teRh3.BMq', '', 'default.jpg'),
(7, '@isuru', 'a', 'isuru.atthanayake@gmail.com', '$2y$10$oV.HA77BwTjNTcyndZGYAu3x95z0Qnitp/feagyys4w6zMiUFJLy2', '', 'default.jpg'),
(8, '@isuru2', 'b', 'isuru.atthanayake@gmail.com', '$2y$10$Z01F7wnNc3i9Zh4yCKE5Fuo8SorD333l0YLOmz.50ySYiqp/X9VgS', '', 'default.jpg');

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
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`FollowId`),
  ADD KEY `FK_FollowUser` (`UserId`),
  ADD KEY `FK_FollowIsFollowing` (`IsFollowing`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`LikeId`),
  ADD KEY `FK_LikeUser` (`UserId`),
  ADD KEY `FK_LikePost` (`PostId`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationId`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`NotifId`),
  ADD KEY `FK_NotifUser` (`UserId`),
  ADD KEY `FK_NotifFromUser` (`FromUser`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostId`),
  ADD KEY `FK_PostUser` (`UserId`),
  ADD KEY `FK_PostLocation` (`LocationId`);

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
  MODIFY `CommentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `FollowId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `LikeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `NotifId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `FK_FollowIsFollowing` FOREIGN KEY (`IsFollowing`) REFERENCES `users` (`UserId`),
  ADD CONSTRAINT `FK_FollowUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_LikePost` FOREIGN KEY (`PostId`) REFERENCES `posts` (`PostId`),
  ADD CONSTRAINT `FK_LikeUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_NotifFromUser` FOREIGN KEY (`FromUser`) REFERENCES `users` (`UserId`),
  ADD CONSTRAINT `FK_NotifUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_PostLocation` FOREIGN KEY (`LocationId`) REFERENCES `location` (`LocationId`),
  ADD CONSTRAINT `FK_PostUser` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
