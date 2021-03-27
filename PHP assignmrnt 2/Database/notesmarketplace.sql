-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2021 at 12:45 PM
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
  `IsActive` bit(10) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categorytable`
--

INSERT INTO `categorytable` (`CategoryID`, `Category`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'IT', 'IT', NULL, NULL, NULL, NULL, b'0000000001'),
(2, 'CA', 'CA', NULL, NULL, NULL, NULL, b'0000000001'),
(3, 'CS', 'CS', NULL, NULL, NULL, NULL, b'0000000001'),
(4, 'MBA', 'MBA', NULL, NULL, NULL, NULL, b'0000000001');

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

--
-- Dumping data for table `countrytable`
--

INSERT INTO `countrytable` (`CountryID`, `CountryName`, `CountryCode`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'India', '+91', NULL, NULL, NULL, NULL, b'0000000001'),
(2, 'USA', '+111', NULL, NULL, NULL, NULL, b'0000000001'),
(3, 'UK', '+1', NULL, NULL, NULL, NULL, b'0000000001');

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

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`DownloadID`, `NoteID`, `BuyerID`, `SellerID`, `RequestStatus`, `NotePrice`, `IsAttachmentDownloaded`, `AttachmentDownloadedDate`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 42, 27, 27, b'0000000001', 0, b'0000000001', '2021-03-23 11:21:21', '2021-03-05 10:34:38', 27, NULL, NULL, b'0000000001'),
(2, 42, 27, 27, b'0000000001', 0, b'0000000001', '2021-03-23 11:23:12', '2021-03-05 10:41:12', 27, NULL, NULL, b'0000000001'),
(5, 58, 27, 27, b'0000000001', 125, b'0000000000', NULL, '2021-03-05 10:54:23', 27, '2021-03-26 17:43:46', 27, b'0000000001'),
(6, 58, 27, 27, b'0000000000', 125, b'0000000000', NULL, '2021-03-05 11:10:33', 27, '0000-00-00 00:00:00', 27, b'0000000001'),
(7, 58, 27, 27, b'0000000000', 125, b'0000000000', NULL, '2021-03-05 11:13:53', 27, '2021-03-26 17:20:51', 27, b'0000000001'),
(8, 58, 27, 27, b'0000000001', 125, b'0000000000', NULL, '2021-03-05 11:23:27', 27, '2021-03-26 17:51:30', 27, b'0000000001'),
(9, 58, 26, 27, b'0000000001', 125, b'0000000000', NULL, '2021-03-05 12:52:07', 26, '2021-03-26 17:45:28', 27, b'0000000001'),
(10, 58, 27, 26, b'0000000000', 125, b'0000000000', NULL, '2021-03-21 15:37:24', 27, NULL, NULL, b'0000000001'),
(11, 58, 27, 26, b'0000000000', 125, b'0000000000', NULL, '2021-03-26 17:49:10', 27, NULL, NULL, b'0000000001');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `NoteID` int(11) NOT NULL,
  `NoteTitle` varchar(100) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DisplayPictureFile` varchar(100) NOT NULL,
  `NoteFile` varchar(255) NOT NULL,
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

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`NoteID`, `NoteTitle`, `CategoryID`, `DisplayPictureFile`, `NoteFile`, `TypeID`, `NotePage`, `Description`, `CountryID`, `InstituteName`, `CourseName`, `CourseCode`, `ProfessorName`, `SellType`, `NotePrice`, `PreviewFile`, `SellerID`, `NoteStatusID`, `PublishedDate`, `ActionedBy`, `AdminRemark`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'sdf', 1, 'dsfsa', 'sadfdsf', 2, 324, 'sadfsadf', NULL, NULL, NULL, NULL, NULL, b'0000000000', NULL, NULL, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(5, '', 1, '720210228155534', '720210228155534', 2, 0, '', 1, NULL, '', '', '', b'0000000000', 0, '720210228155534', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(6, '', 2, '720210228155811member.png', '720210228155811', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228155811', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(7, '', 2, '720210228155835member.png', '720210228155835', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228155835', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(8, '', 2, '720210228160023member.png', '720210228160023', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228160023', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(10, '', 2, '720210228160129', '720210228160129', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228160129', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(14, '', 2, '720210228160940member.png', '720210228160940', 2, 0, '', 3, NULL, '', '', '', b'0000000000', 0, '720210228160940', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(15, '', 2, '720210228161010', '720210228161010', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161010', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(16, '', 2, '', '720210228161115', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161115', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(17, '', 2, '', '720210228161224', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161224', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(18, '', 2, '', '720210228161242', 3, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161242', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(19, '', 1, '', '720210228161349', 2, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161349', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(20, '', 1, '', '720210228161406', 2, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '720210228161406', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(21, '', 1, '', '720210228161513', 2, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(22, '', 1, '', '720210228161610', 2, 0, '', 2, NULL, '', '', '', b'0000000000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(23, 'fghfr', 2, '', '720210228173507TSC Training Plan for Batch 2020-2021.pdf', 2, 0, 'dgfdsgf', 3, NULL, '', '', '', b'0000110000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(24, 'fghfr', 2, '', '720210228173702TSC Training Plan for Batch 2020-2021.pdf', 2, 0, 'dgfdsgf', 3, NULL, '', '', '', b'0000110000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(25, 'fghfr', 2, '', '720210228174041TSC Training Plan for Batch 2020-2021.pdf', 2, 0, 'dgfdsgf', 3, NULL, '', '', '', b'0000000000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(26, 'fghfr', 2, '', '720210228174106TSC Training Plan for Batch 2020-2021.pdf', 2, 0, 'dgfdsgf', 3, NULL, '', '', '', b'0000000001', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(27, 'ergrg', 2, '', '720210228182054LETTER_MAILMERGE.docx', 3, 4356, 'dfhsdfsh', 2, 'gdfsdfdg', 'dfgsdfhfg', 'dfhsdfh', '', b'0000000001', 345, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(28, 'gfhsfgh', 3, '', '720210228182546NotesMarketPlace-DataDictionary.xlsx', 3, 435, 'dfghfsgh', 3, NULL, '', '', '', b'0000000000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(29, 'sadfasd', 3, '', '720210228183905CE Elective Subject Selection for Sem-8-2021 (Responses) - Android Programming 2180715 (Dept Elec-III).pdf', 3, 0, 'sdfasdf', 3, NULL, '', '', '', b'0000000000', 0, '', 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(30, 'dfgvsdf', 3, '', '720210228184006170020107050_Practicals.ipynb - Colaboratory.pdf', 2, 0, 'sdafadsf', 2, NULL, '', '', '', b'0000000001', 453, '', 27, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(41, 'dfgsdafg', 2, '', '2720210304191500CE Elective Subject Selection for Sem-8-2021 (Responses) - Python Programming 2180711 (Dept Elec-III).pdf', 2, 345, 'dfgdsffg', 2, NULL, '', '', '', b'0000000001', 123, '2720210304191500TSC Training Plan for Batch 2020-2021.pdf', 27, 5, NULL, NULL, 'Chhagan is good person', '2021-03-03 15:25:33', 27, '2021-03-04 19:15:00', 27, b'0000000001'),
(42, 'Chhagan', 3, '', '2720210304155714170020107021_PythonAssignment1&2.pdf/2720210310002504ArticleIdCard.pdf/27202103111703226TH AND 8TH MSE Schedule.pdf/27202103231655172720210310002504ArticleIdCard (10).pdf', 2, 123, 'dfgsdgsrthfrg', 2, 'Ahmedabad institute of technology', 'ytjdydjtyjy', '', '', b'0000000000', 0, '', 27, 4, '2021-03-03 17:20:11', NULL, NULL, '2021-03-03 17:20:11', 27, '2021-03-04 15:57:14', 27, b'0000000001'),
(43, 'Chhagan', 3, '', '2720210304190623CE Elective Subject Selection for Sem-8-2021 (Responses) - Python Programming 2180711 (Dept Elec-III).pdf', 2, 123, 'dfgsdgsrthfrg', 2, NULL, '', '', '', b'0000000000', 0, '', 27, 2, NULL, NULL, NULL, '2021-03-03 17:20:31', 27, '2021-03-04 19:06:23', 27, b'0000000001'),
(44, 'dfgsdafg', 2, '', '2720210304190658TSC Training Plan for Batch 2020-2021.pdf/2720210305151516INS IMP.pdf/2720210305151516VC Final (2).pdf', 2, 345, 'dfgdsffg', 2, NULL, 'dfghgth rth rh', '', '', b'0000000000', 0, '', 27, 2, NULL, NULL, NULL, '2021-03-03 23:33:51', 27, '2021-03-04 19:06:58', 27, b'0000000001'),
(45, 'fdghhgdrh', 3, '', '2720210311164250ArticleIdCard.pdf', 2, 345, 'fghghghrstgghb b hhd t', 1, 'hrgfhr hrth th', 'dfghgth rth rh', 'dfgetyet', '', b'0000000001', 345, '2720210311164250TechEra vol1.pdf', 27, 1, NULL, NULL, NULL, '2021-03-04 00:00:59', 27, '2021-03-11 16:42:50', 27, b'0000000001'),
(46, 'sghrhtrs', 3, '', '2720210304013556170020107050_Practicals.ipynb - Colaboratory.pdf', 3, 5654, 'fgjhryjdtjtd', 3, 'tyjtdjt', 'ytjdydjtyjy', 'yjtdyjty', '', b'0000000000', 0, '', 27, 2, NULL, NULL, NULL, '2021-03-04 00:05:34', 27, '2021-03-04 01:35:56', 27, b'0000000001'),
(47, 'ghfxhfh', 4, '', '2720210304013044TSC Training Plan for Batch 2020-2021.pdf', 4, 456, 'gfhhrthrth h rhrthr th th th ', 1, 'yjyjdtyjdj yj yj', 'hhrthrh rt h th rh', 'rthrthrfgh ht hrh', 'fghrthr hrth thrt h', b'0000000001', 4545, '', 27, 2, NULL, NULL, NULL, '2021-03-04 00:07:44', 27, '2021-03-04 01:30:44', 27, b'0000000001'),
(48, 'sdfgdfg', 2, '', '2720210305151637INS IMP.pdf/2720210305151637VC Final (2).pdf', 3, 0, 'dfgdfgsdfg', 2, NULL, 'CS', '', '', b'0000000000', 0, '', 27, 2, NULL, NULL, NULL, '2021-03-04 16:13:15', 27, '2021-03-05 15:16:37', 27, b'0000000001'),
(58, 'Chhagan', 4, '720210228160023member.png', '2720210305151516INS IMP.pdf/2720210305151516VC Final (2).pdf/2720210310002504TechEra vol1.pdf', 1, 123, 'none none none none none none none none none none none none none none none none', 1, NULL, 'CS', '', '', b'0000000001', 125, '27202103231656342720210310002504ArticleIdCard(8).pdf', 27, 4, '2021-03-05 15:14:51', NULL, NULL, '2021-03-05 15:14:51', 27, '2021-03-05 15:15:16', 27, b'0000000001'),
(59, 'computer Science', 1, '', '2720210310002534ArticleIdCard.pdf/2720210310002534TechEra vol1.pdf', 2, 345, 'none', 1, 'Ahmedabad institute of technology', '', '07', '', b'0000000001', 342, '27202103100025346TH AND 8TH MSE Schedule.pdf', 27, 2, NULL, NULL, NULL, '2021-03-10 00:25:04', 27, '2021-03-10 00:25:34', 27, b'0000000001'),
(60, 'computer Science', 3, '2720210327153437IMG_20210113_185208.jpg', '2720210327153437Career Path and Campus Process 2021 @ TGC.pdf/27202103271534372720210310002504ArticleIdCard (13).pdf/272021032715343727202103111703226TH AND 8TH MSE Schedule.pdf', 2, 234, 'dwedwed', 1, 'Ahmedabad institute of technology', 'CS', '07', 'Dr. Ajay N Upadyaya', b'0000000000', 0, '27202103271534372720210310002504ArticleIdCard(12).pdf', 27, 4, '2021-03-27 15:35:47', NULL, NULL, '2021-03-11 16:50:01', 27, '2021-03-27 15:34:37', 27, b'0000000001'),
(61, 'computer Scienc', 4, '', '27202103111703226TH AND 8TH MSE Schedule.pdf', 1, 465, 'vfevgreger rt e tg e tyntyn', 3, NULL, '', '', '', b'0000000000', 0, '', 27, 2, NULL, NULL, NULL, '2021-03-11 17:02:00', 27, '2021-03-11 17:03:22', 27, b'0000000001'),
(62, 'dfgsdafgh', 2, '', '27202103231656342720210310002504ArticleIdCard (10).pdf/27202103231656342720210310002504ArticleIdCard (9).pdf/27202103231656342720210310002504ArticleIdCard (8).pdf', 2, 345, 'dfgdsffg', 2, '', '', '', '', b'0000000001', 123, '27202103231656342720210310002504ArticleIdCard (8).pdf', 27, 2, NULL, NULL, NULL, '2021-03-23 16:55:17', 27, '2021-03-23 16:56:34', 27, b'0000000001');

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

--
-- Dumping data for table `reviewnotes`
--

INSERT INTO `reviewnotes` (`ReviewID`, `Rating`, `Comments`, `NoteID`, `ReviewerID`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 4, 'cwdvc dcwe', 42, 27, '2021-03-21 23:34:56', 27, NULL, NULL, b'0000000001'),
(2, 1, 'Chhagan OK', 42, 27, '2021-03-21 23:40:18', 27, NULL, NULL, b'0000000001');

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

--
-- Dumping data for table `typetable`
--

INSERT INTO `typetable` (`TypeID`, `TypeName`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'Handwritten Notes', 'Handwritten Notes', NULL, NULL, NULL, NULL, b'0000000001'),
(2, 'University Notes', 'University Notes', NULL, NULL, NULL, NULL, b'0000000001'),
(3, 'Notebook', 'Notebook', NULL, NULL, NULL, NULL, b'0000000001'),
(4, 'Novel', 'Novel', NULL, NULL, NULL, NULL, b'0000000001');

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
  `Password` varchar(200) NOT NULL,
  `IsEmailVerified` bit(10) NOT NULL DEFAULT b'0',
  `BirthDate` date DEFAULT NULL,
  `Gender` tinyint(1) DEFAULT NULL COMMENT '0-Male 1-Female',
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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `RoleID`, `FirstName`, `LastName`, `EmailID`, `Password`, `IsEmailVerified`, `BirthDate`, `Gender`, `PhoneNo`, `ProfilePictureFile`, `Address1`, `Address2`, `City`, `State`, `Zipcode`, `CountryID`, `University`, `CollegeName`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(2, 3, 'Chhagan', 'Prajapati', 'chhagan123@gmail.com', 'chhagan123@gmail.com', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(3, 3, 'HARISHKUMAR', 'PRAJAPATI', 'prajapati.harish2320@gmail.com', '827ccb0eea8a706c4c34a168', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(4, 3, '  ', '  ', 'demo1@gmail.com', '81dc9bdb52d04dc20036dbd8', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(7, 3, 'Chhagan', 'prajapti', 'prajapatichhagan515@gmail.com', '6636325222e9555579ec527509b1e52b', b'0000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(8, 3, 'a', 's', 'ait@gmail.com', '0cc175b9c0f1b6a831c399e269772661', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(10, 3, 'aaaaaa', 'aaaaa', 'hod@gmail.com', 'baa7a52965b99778f38ef37f235e9053', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(11, 3, 'aza', 'axa', 'admin@gmail.com', 'baa7a52965b99778f38ef37f235e9053', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(12, 3, 'Chhagan', 'Prajapati', 'acaca@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(13, 3, 'Chhagan', 'Prajapati', 'acaca@gmail.co', 'a8f5f167f44f4964e6c998dee827110c', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(14, 3, 'asdf', 'asdf', 'asdf@gmail.com', '912ec803b2ce49e4a541068d495ab570', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(15, 3, 'asd', 'asd', 'asf@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(16, 3, 'asd', 'asd', 'asfdsd@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(17, 3, 'asd', 'asd', 'asdfss@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(18, 3, 'asd', 'asd', 'principle@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(19, 3, 'asd', 'asd', 'asdfsssss@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(20, 3, 'Chhagan', 'Prajapati', 'abcd@gmail.com', '7815696ecbf1c96e6894b779456d330e', b'0000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(21, 3, 'Chhagan', 'Prajapati', '170020107045ai@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(22, 3, 'Chhagan', 'Prajapati', '170020107045it@gmail.com', '7f7d458fb81eeb04a94e1437ab0b63fd', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(23, 3, 'Chhagan', 'Prajapati', '17002010705ait@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(24, 3, 'Chhagan', 'Prajapati', '17002010045ait@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(25, 3, 'Chhagan', 'Prajapati', '17002010704ait@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(26, 3, 'Chhagan', 'Prajapati', 'prajapatichhagan1515@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(27, 3, 'Chhaganlal', 'Prajapati', '170020107045ait@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000001', '2021-03-05', 0, '+91 7874209486', '', 'C/3 ,Simandhar residency -2', 'chandlodia', 'Ahmedabad', 'Gujarat', '382481', 1, 'GTU', 'AIT', NULL, NULL, '2021-03-26 22:09:54', 27, b'0000000001');

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
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`RoleID`, `RoleName`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'Super Admin', NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(2, 'Admin', NULL, NULL, NULL, NULL, NULL, b'0000000001'),
(3, 'Member', NULL, NULL, NULL, NULL, NULL, b'0000000001');

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
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countrytable`
--
ALTER TABLE `countrytable`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `DownloadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `notestatus`
--
ALTER TABLE `notestatus`
  MODIFY `NoteStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviewnotes`
--
ALTER TABLE `reviewnotes`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
