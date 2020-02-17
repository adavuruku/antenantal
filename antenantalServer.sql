-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 23, 2001 at 03:52 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `antenantalServer`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactInfo`
--

CREATE TABLE `contactInfo` (
  `id` int(11) NOT NULL,
  `HID` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `officeAddress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `DailyTips`
--

CREATE TABLE `DailyTips` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `HospitalDocsInfo`
--

CREATE TABLE `HospitalDocsInfo` (
  `id` int(11) NOT NULL,
  `docId` varchar(100) NOT NULL,
  `nurseId` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contactAdd` text NOT NULL,
  `active` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hospitalNotice`
--

CREATE TABLE `hospitalNotice` (
  `id` int(11) NOT NULL,
  `noticeDate` datetime NOT NULL,
  `byId` varchar(100) NOT NULL,
  `NoticeDescription` text NOT NULL,
  `delStatus` int(5) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MonthlyTips`
--

CREATE TABLE `MonthlyTips` (
  `id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userDoctorInfo`
--

CREATE TABLE `userDoctorInfo` (
  `id` int(11) NOT NULL,
  `doctorId` varchar(100) NOT NULL,
  `nurseId` varchar(100) NOT NULL,
  `HID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userPregInfo`
--

CREATE TABLE `userPregInfo` (
  `id` int(11) NOT NULL,
  `pregDaysCount` int(11) NOT NULL,
  `pregStart` date NOT NULL,
  `babyGenderDescription` text NOT NULL,
  `pregExpectedEndDate` date NOT NULL,
  `HID` varchar(100) NOT NULL,
  `NoOfBaby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `HID` varchar(50) NOT NULL,
  `contactAddress` text NOT NULL,
  `officeAddress` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `illnesDescription` text NOT NULL,
  `state` varchar(200) NOT NULL,
  `localgovt` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userSchedule`
--

CREATE TABLE `userSchedule` (
  `id` int(11) NOT NULL,
  `HID` varchar(100) NOT NULL,
  `dateSchedule` datetime NOT NULL,
  `purpose` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `WeeklyTips`
--

CREATE TABLE `WeeklyTips` (
  `id` int(11) NOT NULL,
  `weekly` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactInfo`
--
ALTER TABLE `contactInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DailyTips`
--
ALTER TABLE `DailyTips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `HospitalDocsInfo`
--
ALTER TABLE `HospitalDocsInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitalNotice`
--
ALTER TABLE `hospitalNotice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MonthlyTips`
--
ALTER TABLE `MonthlyTips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userDoctorInfo`
--
ALTER TABLE `userDoctorInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userPregInfo`
--
ALTER TABLE `userPregInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`HID`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `userSchedule`
--
ALTER TABLE `userSchedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `WeeklyTips`
--
ALTER TABLE `WeeklyTips`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactInfo`
--
ALTER TABLE `contactInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `DailyTips`
--
ALTER TABLE `DailyTips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `HospitalDocsInfo`
--
ALTER TABLE `HospitalDocsInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitalNotice`
--
ALTER TABLE `hospitalNotice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MonthlyTips`
--
ALTER TABLE `MonthlyTips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userDoctorInfo`
--
ALTER TABLE `userDoctorInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userPregInfo`
--
ALTER TABLE `userPregInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userSchedule`
--
ALTER TABLE `userSchedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `WeeklyTips`
--
ALTER TABLE `WeeklyTips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
