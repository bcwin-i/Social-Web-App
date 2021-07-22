-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2021 at 03:56 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `status` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `dob` text NOT NULL,
  `uid` text NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `name`, `dob`, `uid`, `password`, `status`) VALUES
(1, 'bcwin', '050917042', 'bcwin', '', 0),
(2, 'Ikenna', '050917051', 'Ikenna', '', 0),
(3, 'Javes', '050917030', 'Javes', '', 0),
(4, 'Alvin', '050917008', 'Alvin', '', 0),
(5, 'Kissi', '050917042', 'Kissi', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_details_id` int(11) NOT NULL,
  `is_type` enum('no','yes') NOT NULL,
  `last_activity` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`id`, `user_id`, `login_details_id`, `is_type`, `last_activity`) VALUES
(1, 1, 0, 'no', '2021-07-22 01:42:02'),
(2, 0, 0, 'no', '2021-07-22 01:42:02'),
(3, 4, 0, 'no', '2021-07-22 01:42:02'),
(4, 2, 0, 'no', '2021-07-22 01:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `message_request`
--

CREATE TABLE `message_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_request`
--

INSERT INTO `message_request` (`id`, `from_user_id`, `to_user_id`, `status`) VALUES
(1, 1, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pending_message`
--

CREATE TABLE `pending_message` (
  `pending_message_id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pending_message`
--

INSERT INTO `pending_message` (`pending_message_id`, `from_user_id`, `to_user_id`, `message`) VALUES
(1, 1, 4, 'P, how r u?');

-- --------------------------------------------------------

--
-- Table structure for table `profileimage`
--

CREATE TABLE `profileimage` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profileimage`
--

INSERT INTO `profileimage` (`id`, `userid`, `status`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(5, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(10) UNSIGNED NOT NULL,
  `contest_name` text NOT NULL,
  `countdown` timestamp NULL DEFAULT NULL,
  `status` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_desc` text NOT NULL,
  `contest_type` int(11) NOT NULL,
  `alternatives` int(11) NOT NULL,
  `security` text NOT NULL,
  `contest_code` text NOT NULL,
  `duration` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `contest_name`, `countdown`, `status`, `user_id`, `contest_desc`, `contest_type`, `alternatives`, `security`, `contest_code`, `duration`, `date`) VALUES
(1, 'Fred', '0000-00-00 00:00:00', 'inactive', 1, 'A voting name', 10, 4, 'opened', '', '5:00', '2020-06-24 20:20:49'),
(2, 'Final year', '2020-07-06 15:23:51', 'active', 1, 'Which supervisor do you guys prefer as your supervisor?', 4, 2, 'opened', '', '1:00', '2020-07-06 15:23:52'),
(3, 'president', '0000-00-00 00:00:00', 'inactive', 2, 'hvghgiuhhhihlijiljlkjokokokokklklk', 10, 2, 'opened', '', '2:30', '2020-07-10 18:55:29'),
(4, 'presido', '2020-07-10 20:30:33', 'active', 2, 'jhgkgkjhkljjkll;jl;kklkjlkkljkljk', 4, 2, 'opened', '', '2:30', '2020-07-10 19:00:33'),
(5, 'Coventry university level 6', '2020-07-22 18:05:00', 'active', 1, 'Who\\\'s your favourite supervisor', 4, 3, 'opened', '', '00:5', '2020-07-22 19:00:00'),
(7, 'Favorite supervisor', '0000-00-00 00:00:00', 'active', 2, 'Who\\\'s your favorite supervisor?', 4, 2, 'opened', '', '00:40', '2020-07-22 19:20:05'),
(8, 'Supervisor', '2020-07-22 19:54:36', 'active', 2, 'Favorite supervisor.?', 4, 2, 'opened', '', '1:30', '2020-07-22 19:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `vote_alternatives`
--

CREATE TABLE `vote_alternatives` (
  `id` int(10) UNSIGNED NOT NULL,
  `contest_id` int(11) NOT NULL,
  `option_number` int(11) NOT NULL,
  `file` text NOT NULL,
  `choice` text NOT NULL,
  `approval` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote_alternatives`
--

INSERT INTO `vote_alternatives` (`id`, `contest_id`, `option_number`, `file`, `choice`, `approval`) VALUES
(1, 1, 1, '', 'Alvin', ''),
(2, 1, 2, '', 'Ikenna', 'approved'),
(3, 1, 3, '', 'Javes', ''),
(4, 1, 4, '', 'Kissi', ''),
(5, 2, 1, '21.png', 'Mr. Vanderpuije', ''),
(6, 2, 2, '22.png', 'Mrs. Holms', ''),
(7, 3, 1, '', 'Alvin', ''),
(8, 3, 2, '', 'Kissi', ''),
(9, 4, 1, '', 'Alvin', ''),
(10, 4, 2, '', 'Kissi', ''),
(11, 5, 1, '51.png', 'Mr. Freeman', ''),
(12, 5, 2, '', 'Mrs. Sangeetha ', ''),
(13, 5, 3, '', 'Dr.Brown', ''),
(14, 6, 1, '61.png', 'Mr. Freeman', ''),
(15, 6, 2, '', 'Mrs. Sangeetha', ''),
(16, 7, 1, '71.png', 'Mr. Freeman', ''),
(17, 7, 2, '', 'Mrs. Sangeetha', ''),
(18, 8, 1, '81.png', 'Mr. Freeman', ''),
(19, 8, 2, '', 'Mrs. Sangeetha', '');

-- --------------------------------------------------------

--
-- Table structure for table `vote_choice`
--

CREATE TABLE `vote_choice` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `tries` int(11) NOT NULL,
  `choice_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote_choice`
--

INSERT INTO `vote_choice` (`id`, `user_id`, `contest_id`, `tries`, `choice_num`) VALUES
(1, 1, 2, 1, 1),
(2, 4, 2, 1, 2),
(3, 2, 4, 1, 1),
(4, 1, 5, 1, 2),
(5, 2, 6, 1, 2),
(6, 2, 8, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_request`
--
ALTER TABLE `message_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_message`
--
ALTER TABLE `pending_message`
  ADD PRIMARY KEY (`pending_message_id`);

--
-- Indexes for table `profileimage`
--
ALTER TABLE `profileimage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote_alternatives`
--
ALTER TABLE `vote_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote_choice`
--
ALTER TABLE `vote_choice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message_request`
--
ALTER TABLE `message_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pending_message`
--
ALTER TABLE `pending_message`
  MODIFY `pending_message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profileimage`
--
ALTER TABLE `profileimage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vote_alternatives`
--
ALTER TABLE `vote_alternatives`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vote_choice`
--
ALTER TABLE `vote_choice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
