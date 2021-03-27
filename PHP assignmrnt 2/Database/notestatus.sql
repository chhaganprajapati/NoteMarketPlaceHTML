-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2021 at 12:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notesmarketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `notestatus`
--

CREATE TABLE `notestatus` (
  `NoteStatusID` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notestatus`
--

INSERT INTO `notestatus` (`NoteStatusID`, `Status`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'Draft', NULL, NULL, NULL, NULL, b'0000000001'),
(2, 'Submitted  for Review', NULL, NULL, NULL, NULL, b'0000000001'),
(3, 'InReview', NULL, NULL, NULL, NULL, b'0000000001'),
(4, 'Published', NULL, NULL, NULL, NULL, b'0000000001'),
(5, 'Rejected', NULL, NULL, NULL, NULL, b'0000000001'),
(6, 'Removed', NULL, NULL, NULL, NULL, b'0000000001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notestatus`
--
ALTER TABLE `notestatus`
  ADD PRIMARY KEY (`NoteStatusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notestatus`
--
ALTER TABLE `notestatus`
  MODIFY `NoteStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
