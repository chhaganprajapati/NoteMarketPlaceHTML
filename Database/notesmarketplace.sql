-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2021 at 12:44 PM
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
-- Table structure for table `categorytable`
--

CREATE TABLE `categorytable` (
  `CategoryID` int(11) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActi` bit(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `countrytable`
--

CREATE TABLE `countrytable` (
  `CountryID` int(11) NOT NULL,
  `CountryName` varchar(100) NOT NULL,
  `CountryCode` varchar(10) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `DownloadID` int(11) NOT NULL,
  `NoteID` int(11) NOT NULL,
  `BuyerID` int(11) NOT NULL,
  `SellerID` int(11) NOT NULL,
  `RequestStatus` bit(10) NOT NULL,
  `NotePrice` int(11) NOT NULL,
  `IsAttachmentDownloaded` bit(10) NOT NULL,
  `AttachmentDownloadedDate` datetime DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `NoteID` int(11) NOT NULL,
  `NoteTitle` varchar(100) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DisplayPictureFile` varchar(100) NOT NULL,
  `NoteFile` varchar(100) NOT NULL,
  `TypeID` int(11) NOT NULL,
  `NotePage` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CountryID` int(11) DEFAULT NULL,
  `InstituteName` varchar(200) DEFAULT NULL,
  `CourseName` varchar(100) DEFAULT NULL,
  `CourseCode` varchar(100) DEFAULT NULL,
  `ProfessorName` varchar(100) DEFAULT NULL,
  `SellType` bit(10) NOT NULL,
  `NotePrice` int(11) DEFAULT NULL,
  `PreviewFile` varchar(100) DEFAULT NULL,
  `SellerID` int(11) NOT NULL,
  `NoteStatusID` int(11) NOT NULL,
  `PublishedDate` datetime DEFAULT NULL,
  `ActionedBy` int(11) DEFAULT NULL,
  `AdminRemark` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `reviewnotes`
--

CREATE TABLE `reviewnotes` (
  `ReviewID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Comments` varchar(255) NOT NULL,
  `NoteID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spamnotes`
--

CREATE TABLE `spamnotes` (
  `SpamID` int(11) NOT NULL,
  `NoteID` int(11) NOT NULL,
  `Remark` varchar(255) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `systemtable`
--

CREATE TABLE `systemtable` (
  `SystemID` int(11) NOT NULL,
  `SupportEmail` varchar(100) NOT NULL,
  `SupportPhone` varchar(100) NOT NULL,
  `SubscriberEmails` varchar(255) DEFAULT NULL,
  `FacebookURL` varchar(100) DEFAULT NULL,
  `TwitterURL` varchar(100) DEFAULT NULL,
  `LinkedinURL` varchar(100) DEFAULT NULL,
  `DefaultProfilePicture` varchar(100) NOT NULL,
  `DefaultDisplayPicture` varchar(100) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `Modifiedby` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `typetable`
--

CREATE TABLE `typetable` (
  `TypeID` int(11) NOT NULL,
  `TypeName` varchar(100) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
  `Password` varchar(24) NOT NULL,
  `IsEmailVerified` bit(10) NOT NULL DEFAULT b'0',
  `BirthDate` date DEFAULT NULL,
  `Gender` tinyint(1) DEFAULT NULL,
  `PhoneNo` varchar(20) DEFAULT NULL,
  `ProfilePictureFile` varchar(100) DEFAULT NULL,
  `Address1` varchar(100) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `CountryID` int(11) DEFAULT NULL,
  `University` varchar(100) DEFAULT NULL,
  `CollegeName` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorytable`
--
ALTER TABLE `categorytable`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `countrytable`
--
ALTER TABLE `countrytable`
  ADD PRIMARY KEY (`CountryID`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`DownloadID`),
  ADD KEY `NoteID` (`NoteID`,`BuyerID`,`SellerID`),
  ADD KEY `BuyerID` (`BuyerID`),
  ADD KEY `SellerID` (`SellerID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`NoteID`),
  ADD KEY `CategoryID` (`CategoryID`,`TypeID`,`CountryID`,`SellerID`,`NoteStatusID`),
  ADD KEY `CountryID` (`CountryID`),
  ADD KEY `TypeID` (`TypeID`),
  ADD KEY `SellerID` (`SellerID`),
  ADD KEY `NoteStatusID` (`NoteStatusID`);

--
-- Indexes for table `notestatus`
--
ALTER TABLE `notestatus`
  ADD PRIMARY KEY (`NoteStatusID`);

--
-- Indexes for table `reviewnotes`
--
ALTER TABLE `reviewnotes`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `NoteID` (`NoteID`,`ReviewerID`),
  ADD KEY `ReviewerID` (`ReviewerID`);

--
-- Indexes for table `spamnotes`
--
ALTER TABLE `spamnotes`
  ADD PRIMARY KEY (`SpamID`),
  ADD KEY `NoteID` (`NoteID`);

--
-- Indexes for table `systemtable`
--
ALTER TABLE `systemtable`
  ADD PRIMARY KEY (`SystemID`);

--
-- Indexes for table `typetable`
--
ALTER TABLE `typetable`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `EmailID` (`EmailID`),
  ADD KEY `RoleID` (`RoleID`,`CountryID`),
  ADD KEY `CountryID` (`CountryID`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorytable`
--
ALTER TABLE `categorytable`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countrytable`
--
ALTER TABLE `countrytable`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `DownloadID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notestatus`
--
ALTER TABLE `notestatus`
  MODIFY `NoteStatusID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewnotes`
--
ALTER TABLE `reviewnotes`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spamnotes`
--
ALTER TABLE `spamnotes`
  MODIFY `SpamID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `systemtable`
--
ALTER TABLE `systemtable`
  MODIFY `SystemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typetable`
--
ALTER TABLE `typetable`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`NoteID`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`BuyerID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `downloads_ibfk_3` FOREIGN KEY (`SellerID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categorytable` (`CategoryID`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`CountryID`) REFERENCES `countrytable` (`CountryID`),
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`TypeID`) REFERENCES `typetable` (`TypeID`),
  ADD CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`SellerID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `notes_ibfk_5` FOREIGN KEY (`NoteStatusID`) REFERENCES `notestatus` (`NoteStatusID`);

--
-- Constraints for table `reviewnotes`
--
ALTER TABLE `reviewnotes`
  ADD CONSTRAINT `reviewnotes_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`NoteID`),
  ADD CONSTRAINT `reviewnotes_ibfk_2` FOREIGN KEY (`ReviewerID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `spamnotes`
--
ALTER TABLE `spamnotes`
  ADD CONSTRAINT `spamnotes_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`NoteID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `userroles` (`RoleID`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`CountryID`) REFERENCES `countrytable` (`CountryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
