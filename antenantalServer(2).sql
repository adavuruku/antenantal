-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 01, 2001 at 12:49 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `antenantalServer`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactinfo`
--

CREATE TABLE `contactinfo` (
  `id` int(11) NOT NULL,
  `HID` varchar(100) NOT NULL,
  `contactname` varchar(255) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `officeAddress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contactinfo`
--

INSERT INTO `contactinfo` (`id`, `HID`, `contactname`, `relationship`, `phone`, `email`, `officeAddress`) VALUES
(3, 'ABUTH42639249', 'Aja Sophy Onuoya', 'Sister', '08021345678', 'aabdulraheemsherif@gmail.com', 'D46 Atabo Street Angwua Okene, Kogi State.');

-- --------------------------------------------------------

--
-- Table structure for table `dailytips`
--

CREATE TABLE `dailytips` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hospitaldocsinfo`
--

CREATE TABLE `hospitaldocsinfo` (
  `id` int(11) NOT NULL,
  `docId` varchar(100) NOT NULL,
  `doctype` varchar(100) NOT NULL,
  `docname` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contactAdd` text NOT NULL,
  `active` int(5) NOT NULL,
  `dateReg` datetime NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hospitaldocsinfo`
--

INSERT INTO `hospitaldocsinfo` (`id`, `docId`, `doctype`, `docname`, `phone`, `email`, `contactAdd`, `active`, `dateReg`, `gender`) VALUES
(1, 'ABUTH188087', 'Doctor', 'Abdulraheem Sherif Adavuruku', '08164377187', 'aabdulraheemsherif@gmail.com', 'D41 Inike Okene Kogi State', 0, '2020-02-19 10:17:59', 'Male'),
(2, 'ABUTH243538', 'Nurse', 'Ajinusi Ola Ronke T', '07089543126', 'olaronke@yahoo.com', 'Flat R52 Lagos Street, Lagos State.', 0, '2020-02-19 10:33:13', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `hospitalnotice`
--

CREATE TABLE `hospitalnotice` (
  `id` int(11) NOT NULL,
  `noticeDate` datetime NOT NULL,
  `byId` varchar(100) NOT NULL,
  `NoticeDescription` text NOT NULL,
  `delStatus` int(5) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hospitalnotice`
--

INSERT INTO `hospitalnotice` (`id`, `noticeDate`, `byId`, `NoticeDescription`, `delStatus`, `title`) VALUES
(1, '2020-02-20 13:22:06', 'ABUTH188087', 'Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum.', 0, 'Lorem Ipsum Comence'),
(2, '2020-02-20 13:22:56', 'ABUTH188087', 'Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum  Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum.', 0, 'Lorem Ipsum Comence');

-- --------------------------------------------------------

--
-- Table structure for table `monthlytips`
--

CREATE TABLE `monthlytips` (
  `id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userdoctorinfo`
--

CREATE TABLE `userdoctorinfo` (
  `HID` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `docid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userdoctorinfo`
--

INSERT INTO `userdoctorinfo` (`HID`, `id`, `docid`) VALUES
('ABUTH42639249', 13, 'ABUTH243538'),
('ABUTH42639249', 14, 'ABUTH188087');

-- --------------------------------------------------------

--
-- Table structure for table `userpreginfo`
--

CREATE TABLE `userpreginfo` (
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
  `patientName` varchar(255) NOT NULL,
  `patientPhone` varchar(20) NOT NULL,
  `patientEmail` varchar(100) NOT NULL,
  `HID` varchar(50) NOT NULL,
  `contactAddress` text NOT NULL,
  `officeAddress` text NOT NULL,
  `illnesDescription` text NOT NULL,
  `patientState` varchar(200) NOT NULL,
  `patientLocalGovt` varchar(255) NOT NULL,
  `dateReg` datetime NOT NULL,
  `createdBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `patientName`, `patientPhone`, `patientEmail`, `HID`, `contactAddress`, `officeAddress`, `illnesDescription`, `patientState`, `patientLocalGovt`, `dateReg`, `createdBy`) VALUES
(2, 'Muhibat O. Yusuf', '08021345678', 'yusufmuhibat@yahoo.com', 'ABUTH25415616', 'Flat 23A Ohio Estate, Area 3 Garki Abuja.', 'Flat 23A Ohio Estate, Area 3 Garki Abuja.', 'Lorem Ipsum Loresita Meta Mata Artum', 'Abuja', 'Abuja Municipal', '2020-02-19 15:21:43', 'ABUTH188087'),
(1, 'Aja Sophy Onuoya', '08021345678', 'ajahsophy@gmail.com', 'ABUTH42639249', 'Flat 32U Obodo Street, Enugu State', 'Flat 32U Obodo Street, Enugu State', 'Lorem Ipsum Loresita Meta Mata Artum', 'Enugu', 'Enugu-South', '2020-02-19 15:14:40', 'ABUTH188087');

-- --------------------------------------------------------

--
-- Table structure for table `userschedule`
--

CREATE TABLE `userschedule` (
  `id` int(11) NOT NULL,
  `HID` varchar(100) NOT NULL,
  `dateSchedule` datetime NOT NULL,
  `purpose` text NOT NULL,
  `byId` varchar(100) NOT NULL,
  `valid` int(5) NOT NULL,
  `timeSchedule` time NOT NULL,
  `docid` varchar(100) NOT NULL,
  `outcome` text,
  `dateReg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userschedule`
--

INSERT INTO `userschedule` (`id`, `HID`, `dateSchedule`, `purpose`, `byId`, `valid`, `timeSchedule`, `docid`, `outcome`, `dateReg`) VALUES
(1, 'ABUTH42639249', '2020-02-29 00:00:00', 'Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum Lorem Ipsum Loresita Meta Mata Artum', 'ABUTH42639249', 0, '18:07:00', 'ABUTH188087', NULL, '2020-03-25 15:32:24'),
(2, 'ABUTH42639249', '2020-04-21 00:00:00', 'Scanning And Healthy Check Ups', 'ABUTH42639249', 0, '14:34:00', 'ABUTH188087', NULL, '2020-03-25 15:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `weeklytips`
--

CREATE TABLE `weeklytips` (
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
-- Indexes for table `contactinfo`
--
ALTER TABLE `contactinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailytips`
--
ALTER TABLE `dailytips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitaldocsinfo`
--
ALTER TABLE `hospitaldocsinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitalnotice`
--
ALTER TABLE `hospitalnotice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthlytips`
--
ALTER TABLE `monthlytips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdoctorinfo`
--
ALTER TABLE `userdoctorinfo`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `userpreginfo`
--
ALTER TABLE `userpreginfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`HID`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `userschedule`
--
ALTER TABLE `userschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weeklytips`
--
ALTER TABLE `weeklytips`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactinfo`
--
ALTER TABLE `contactinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dailytips`
--
ALTER TABLE `dailytips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitaldocsinfo`
--
ALTER TABLE `hospitaldocsinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hospitalnotice`
--
ALTER TABLE `hospitalnotice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `monthlytips`
--
ALTER TABLE `monthlytips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdoctorinfo`
--
ALTER TABLE `userdoctorinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `userpreginfo`
--
ALTER TABLE `userpreginfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userschedule`
--
ALTER TABLE `userschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `weeklytips`
--
ALTER TABLE `weeklytips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
