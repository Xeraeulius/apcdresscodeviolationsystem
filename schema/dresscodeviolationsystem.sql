-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2016 at 05:35 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dresscodeviolationsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `id_picture` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `last_name`, `first_name`, `middle_name`, `id_picture`, `username`, `password`) VALUES
(1, 'Dizon', 'Mark', 'Ernest', 'disciplinary_personnel/Dizon.jpg', 'medizon', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `appeal_ticket`
--

CREATE TABLE `appeal_ticket` (
  `id` int(11) NOT NULL,
  `vio_id` int(11) NOT NULL,
  `appeal_statement` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appeal_ticket`
--

INSERT INTO `appeal_ticket` (`id`, `vio_id`, `appeal_statement`, `created_at`, `updated_at`) VALUES
(4, 5, 'Hindi totoo Sir T_T Sobrang Biased Kasi', '2015-12-20 07:50:44', '2015-12-20 07:54:06'),
(5, 7, 'Nyawtsu? LeL?', '2015-12-20 07:54:19', NULL),
(6, 1, 'Not true biased', '2015-12-21 12:01:37', '2015-12-21 12:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary_personnels`
--

CREATE TABLE `disciplinary_personnels` (
  `id` int(11) NOT NULL,
  `dp_id` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `dp_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disciplinary_personnels`
--

INSERT INTO `disciplinary_personnels` (`id`, `dp_id`, `last_name`, `first_name`, `middle_name`, `dp_picture`, `created_at`, `updated_at`) VALUES
(1, '0016645472', 'Alcarde', 'Elijah', 'Mangaser', 'disciplinary_personnel/Elijah.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_type` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_type`, `body`) VALUES
('Appointment', 'Upon reviewing your application and interviewing you in person we are very pleased to appoint you as the new general manager for Miami Electronics in Miami Florida as of July 31 2014. Out of the 100 candidates that applied for this job your skills and experience stood out as exactly what this company needs to succeed.\r\n                                    -- Enter your Sentence Here --\r\nThe conditions of your appointment are included within this packet. If you wish to accept the enclosed conditions and this job please sign and date this letter below and return it to my by August 7 2014. If you no longer wish to accept this job please let me know as soon as possible so we can find someone else to fill the position. If we do not receive a response from you by August 72014 we will assume you are no longer interested in this job and this offer will automatically be withdrawn.\r\n\r\nIf you have any questions or concerns regarding the enclosed terms and conditions or anything related to your new position please do not hesitate to contact me as soon as possible to discuss them further. Looking forward to working with you.\r\nSincerely Yours,\r\n\r\nProf. Dizon, Mark Ernest		'),
('Suspension', 'This letter is to confirm that you are being suspended without pay from Click here to enter a date to Click here to enter a date.\r\n\r\nThis action is being taken due to Click here to enter reason for suspension.  In addition, you have previous disciplinary actions for Click here to enter information on previous discipline onClick here to enter a date.\r\n\r\nYou are expected to return to work at Click here to enter time on Click here to enter a date.  I expect that you will Click here to enter expectations for correcting the problem.\r\n\r\nSincerely Yours,\r\nProf. Dizon, Mark Ernest');

-- --------------------------------------------------------

--
-- Table structure for table `message_details`
--

CREATE TABLE `message_details` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `message_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schema_migrations`
--

INSERT INTO `schema_migrations` (`version`) VALUES
('20151126075032'),
('20151128081704'),
('20151128083952');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `card_id` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `id_picture` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `card_id`, `last_name`, `first_name`, `middle_name`, `department`, `course`, `email`, `gender`, `id_picture`, `username`, `password`, `created_at`, `updated_at`) VALUES
(2, '2013-100000', '0012255866', 'Almonte', 'Cyril', 'Mar', 'School of Computer Science', 'Digital Forensics', 'cyalmonte@student.apc.edu.ph', 'Male', 'student_images/Cyril.jpg', 'ctmalmonte', '5f4dcc3b5aa765d61d8327deb882cf99', '2015-11-26 23:20:38', '2015-11-26 23:20:38'),
(3, '2013-100001', '0012271385', 'Reyes', 'Herminia', '', 'School of Computer Science', 'Computer Networks', 'mcreyes@student.apc.edu.ph', 'Female', 'student_images/Hermie.jpg', 'mcreyes', '5f4dcc3b5aa765d61d8327deb882cf99', '2015-11-28 09:24:00', '2015-11-28 09:24:00'),
(4, '2013-100002', '22232326251', 'Lachica', 'Alianna', 'Rivera', 'School of Engineering', 'Computer Engineering', 'arlachica@student.apc.edu.ph', 'Female', 'student_images/Alianna.jpg', 'arlachica', '5f4dcc3b5aa765d61d8327deb882cf99', '2015-12-21 04:14:28', '2015-12-21 08:05:00'),
(5, '2013-100003', '23222123314', 'Abinal', 'Arianne', 'Wisdom', 'School of Multimedia Arts', '3D Animation', 'yanabinal@student.apc.edu.ph', 'Female', 'student_images/Yan.jpg', 'abinal', '5f4dcc3b5aa765d61d8327deb882cf99', '2015-12-21 12:30:30', '2015-12-21 06:28:25'),
(6, '2013-100004', '55568898988', 'Rivera', 'Mark', 'Pepito', 'School of Accounting and Business', 'Accountancy', 'mprivera@student.apc.edu.ph', 'Male', 'student_images/Mark.jpg', 'mprivera', '5f4dcc3b5aa765d61d8327deb882cf99', '2015-12-23 08:21:20', '2015-12-21 05:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `id` int(11) NOT NULL,
  `violation_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`id`, `violation_code`) VALUES
(1, 117),
(1, 118),
(2, 118),
(2, 119),
(2, 120),
(2, 127);

-- --------------------------------------------------------

--
-- Table structure for table `violation_code`
--

CREATE TABLE `violation_code` (
  `violation_code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` char(15) NOT NULL,
  `active` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `violation_code`
--

INSERT INTO `violation_code` (`violation_code`, `name`, `gender`, `active`) VALUES
(117, 'No ID', 'EVERYONE', 'YES'),
(118, 'No ID Lace', 'EVERYONE', 'YES'),
(119, 'Improper Shoes', 'MALE', 'YES'),
(120, 'Jeans', 'MALE', 'YES'),
(121, 'No Necktie', 'MALE', 'YES'),
(122, 'No Socks', 'MALE', 'NO'),
(123, 'Short Skirt', 'FEMALE', 'YES'),
(124, 'High Heels', 'FEMALE', 'YES'),
(125, 'Blazers', 'FEMALE', 'YES'),
(126, 'Improper Collar', 'FEMALE', 'NO'),
(127, 'Tattoo', 'EVERYONE', 'YES'),
(128, 'Ring Pierce', 'MALE', 'NO'),
(129, 'Sando', 'MALE', 'YES'),
(130, 'Wearing of Slippers', 'MALE', 'YES'),
(131, 'Haircut', 'MALE', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `violation_details`
--

CREATE TABLE `violation_details` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `dp_id` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `valid_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `violation_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `violation_details`
--

INSERT INTO `violation_details` (`id`, `student_id`, `dp_id`, `remarks`, `valid_date`, `status`, `violation_picture`, `created_at`) VALUES
(1, '2013-100000', '0016645472', 'Left Arm', '2016-01-23 12:21:52', 'Violated', 'violation_images/20160121051637.jpg', '2016-01-21 12:21:52'),
(2, '2013-100004', '0016645472', '', '2016-02-03 10:28:18', 'Violated', '', '2016-02-01 10:28:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appeal_ticket`
--
ALTER TABLE `appeal_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disciplinary_personnels`
--
ALTER TABLE `disciplinary_personnels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_type`);

--
-- Indexes for table `message_details`
--
ALTER TABLE `message_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD UNIQUE KEY `unique_schema_migrations` (`version`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`id`,`violation_code`);

--
-- Indexes for table `violation_code`
--
ALTER TABLE `violation_code`
  ADD PRIMARY KEY (`violation_code`);

--
-- Indexes for table `violation_details`
--
ALTER TABLE `violation_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `appeal_ticket`
--
ALTER TABLE `appeal_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `disciplinary_personnels`
--
ALTER TABLE `disciplinary_personnels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `message_details`
--
ALTER TABLE `message_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `violation_code`
--
ALTER TABLE `violation_code`
  MODIFY `violation_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `violation_details`
--
ALTER TABLE `violation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
