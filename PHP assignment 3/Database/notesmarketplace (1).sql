-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2021 at 05:59 PM
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
(6, 'IT', 'IT', '2021-04-11 01:15:59', 38, NULL, NULL, b'0000000001'),
(7, 'Computer', 'Computer', '2021-04-11 01:16:15', 38, NULL, NULL, b'0000000001'),
(8, 'Science', 'Science', '2021-04-11 01:16:30', 38, NULL, NULL, b'0000000001'),
(9, 'History', 'History', '2021-04-11 01:16:42', 38, NULL, NULL, b'0000000001'),
(10, 'Account', 'Account', '2021-04-11 01:16:53', 38, NULL, NULL, b'0000000001');

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
(5, 'India', '+91', '2021-04-11 01:11:39', 38, NULL, NULL, b'0000000001'),
(6, 'Austrlia', '24', '2021-04-11 01:11:53', 38, NULL, NULL, b'0000000001'),
(7, 'USA', '04', '2021-04-11 01:12:04', 38, NULL, NULL, b'0000000001'),
(8, 'United Kingdom', '12', '2021-04-11 01:12:19', 38, NULL, NULL, b'0000000001'),
(9, 'Canada', '13', '2021-04-11 01:12:28', 38, NULL, NULL, b'0000000001');

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
(14, 79, 39, 44, b'0000000001', 265, b'0000000000', NULL, '2021-04-11 19:40:53', 39, '2021-04-11 20:52:52', 44, b'0000000001'),
(15, 80, 39, 44, b'0000000001', 0, b'0000000001', '2021-04-11 19:58:25', '2021-04-11 19:58:25', 39, NULL, NULL, b'0000000001'),
(16, 79, 39, 44, b'0000000000', 265, b'0000000000', NULL, '2021-04-11 19:59:02', 39, NULL, NULL, b'0000000001'),
(17, 84, 43, 39, b'0000000001', 150, b'0000000000', NULL, '2021-04-11 20:48:10', 43, '2021-04-11 21:10:01', 39, b'0000000001'),
(18, 80, 43, 44, b'0000000001', 0, b'0000000001', '2021-04-11 20:48:33', '2021-04-11 20:48:33', 43, NULL, NULL, b'0000000001'),
(19, 74, 43, 39, b'0000000001', 25, b'0000000000', NULL, '2021-04-11 20:48:51', 43, '2021-04-11 21:07:49', 39, b'0000000001'),
(20, 73, 43, 39, b'0000000001', 0, b'0000000001', '2021-04-11 20:49:09', '2021-04-11 20:49:09', 43, NULL, NULL, b'0000000001'),
(21, 76, 44, 43, b'0000000000', 250, b'0000000000', NULL, '2021-04-11 20:53:24', 44, NULL, NULL, b'0000000001'),
(22, 77, 44, 43, b'0000000001', 0, b'0000000001', '2021-04-11 20:53:58', '2021-04-11 20:53:58', 44, NULL, NULL, b'0000000001'),
(23, 73, 44, 39, b'0000000001', 0, b'0000000001', '2021-04-11 20:54:19', '2021-04-11 20:54:19', 44, NULL, NULL, b'0000000001'),
(24, 74, 44, 39, b'0000000000', 25, b'0000000000', NULL, '2021-04-11 20:54:39', 44, NULL, NULL, b'0000000001'),
(25, 88, 39, 44, b'0000000001', 345, b'0000000000', NULL, '2021-04-11 21:07:33', 39, '2021-04-11 21:15:53', 44, b'0000000001'),
(26, 87, 39, 44, b'0000000001', 0, b'0000000001', '2021-04-11 21:09:04', '2021-04-11 21:09:04', 39, NULL, NULL, b'0000000001'),
(27, 88, 43, 44, b'0000000000', 345, b'0000000000', NULL, '2021-04-11 21:14:10', 43, NULL, NULL, b'0000000001');

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
(73, 'Compiler Design', 7, '39_20210411114554_3.jpg', '39_20210411114624_5.CD Lab Manual.pdf', 6, 75, 'A compiler translates the code written in one language to some other language without changing the meaning of the program. It is also expected that a compiler should make the target code efficient and optimized in terms of time and space.', 5, 'AIT', 'computer Science', '07', 'Dr. Ajay N Upadyaya', b'0000000000', 0, '', 39, 4, '2021-04-11 19:31:36', 41, NULL, '2021-04-11 11:14:46', 39, '2021-04-11 19:31:36', 41, b'0000000001'),
(74, 'Compiler Design - Paper Solution', 7, '39_20210411184851_4.jpg', '39_20210411185046_Ctechnical.pdf', 8, 10, 'It is also expected that a compiler should make the target code efficient and optimized in terms of time and space.', 6, 'University of Georgia', '', '', 'Chhagan Prajapati', b'0000000001', 25, '39_20210411184851_Ctechnical.pdf', 39, 4, '2021-04-11 19:43:19', 41, NULL, '2021-04-11 18:48:51', 39, '2021-04-11 19:43:19', 41, b'0000000001'),
(75, 'Web Developement full notes', 6, '', '39_20210411190022_Ctechnical.pdf/39_20210411190022_CPPtechnical 30July.pdf', 7, 125, 'Computers are a balanced mix of software and hardware. Hardware is just a piece of mechanical device and its functions are being controlled by a compatible software.', 7, 'University of California', 'WDP', 'A1S', '', b'0000000001', 150, '39_20210411185443_CPPtechnical30July.pdf', 39, 5, NULL, 41, 'It is not proper note', '2021-04-11 18:54:43', 39, '2021-04-11 19:32:18', 41, b'0000000001'),
(76, 'Computer Science', 8, '43_20210411190839_5.jpg', '43_20210411190914_CPPtechnical.pdf', 6, 100, 'We have learnt that any computer system is made of hardware and software. The hardware understands a language, which humans cannot understand.', 9, '', '', '', '', b'0000000001', 250, '43_20210411190839_CPPtechnical.pdf', 43, 4, '2021-04-11 19:31:41', 41, NULL, '2021-04-11 19:08:39', 43, '2021-04-11 19:31:41', 41, b'0000000001'),
(77, 'Laravel - Web', 6, '', '43_20210411191034_javatechnical.pdf', 9, 140, 'We have learnt that any computer system is made of hardware and software. The hardware understands a language, which humans cannot understand.', 6, '', '', '', '', b'0000000000', 0, '', 43, 4, '2021-04-11 20:47:31', 42, NULL, '2021-04-11 19:10:21', 43, '2021-04-11 20:47:31', 42, b'0000000001'),
(78, 'Microsoft Excel', 10, '43_20210411191317_6.jpg', '43_20210411191356_CPPtechnical 30July.pdf', 7, 145, 'It would be a difficult and cumbersome task for computer programmers to write such codes, which is why we have compilers to write such codes.', 9, 'Ahmedabad institute of technology', 'CS', '001', '', b'0000000001', 120, '43_20210411191317_CPPtechnical30July.pdf', 43, 4, '2021-04-11 21:17:35', 42, 'It is not proper note PLease review and submit again', '2021-04-11 19:13:17', 43, '2021-04-11 21:17:35', 42, b'0000000001'),
(79, 'Data Structure', 9, '44_20210411192116_3.jpg', '44_20210411192135_javatechnical.pdf', 9, 140, 'It would be a difficult and cumbersome task for computer programmers to write such codes, which is why we have compilers to write such codes.', 7, 'AIT', '', '', '', b'0000000001', 265, '44_20210411192116_javatechnical.pdf', 44, 4, '2021-04-11 19:31:44', 41, NULL, '2021-04-11 19:21:16', 44, '2021-04-11 19:31:44', 41, b'0000000001'),
(80, 'C++ notes', 8, '', '44_20210411192415_CPPtechnical.pdf/44_20210411192415_javatechnical.pdf', 8, 100, 'It would be a difficult and cumbersome task for computer programmers to write such codes, which is why we have compilers to write such codes.', 9, 'Canada college', 'CPP', '111A', '', b'0000000000', 0, '', 44, 4, '2021-04-11 19:57:24', 41, NULL, '2021-04-11 19:24:00', 44, '2021-04-11 19:57:24', 41, b'0000000001'),
(81, 'Operating System', 9, '44_20210411192639_5.jpg', '44_20210411192701_Ctechnical.pdf', 9, 115, 'We have learnt that any computer system is made of hardware and software. The hardware understands a language, which humans cannot understand.', 8, 'UK college', '', '', '', b'0000000001', 345, '44_20210411192639_Ctechnical.pdf', 44, 5, NULL, 41, 'It is not proper note', '2021-04-11 19:26:39', 44, '2021-04-11 19:34:30', 41, b'0000000001'),
(82, 'Web Developement new', 6, '', '39_20210411195500_CPPtechnical 30July.pdf', 7, 125, 'Computers are a balanced mix of software and hardware. Hardware is just a piece of mechanical device and its functions are being controlled by a compatible software.', 7, 'University of California', 'WDP', 'A1S', '', b'0000000001', 150, '39_20210411194839_CPPtechnical.pdf', 39, 4, '2021-04-11 20:37:35', 41, NULL, '2021-04-11 19:48:39', 39, '2021-04-11 20:37:35', 41, b'0000000001'),
(83, 'Microsoft Word', 10, '39_20210411201926_4.jpg', '39_20210411203419_', 8, 140, 'This tutorial requires no prior knowledge of compiler design but requires basic understanding of at least one programming language such as C, Java etc.', 5, 'AIT', 'CSA', '115', 'Kirtan patadiya', b'0000000001', 105, '39_20210411201926_javatechnical.pdf', 39, 5, NULL, 41, 'Inapproproate notes', '2021-04-11 20:19:26', 39, '2021-04-11 20:37:59', 41, b'0000000001'),
(84, 'CSS notes', 6, '39_20210411203517_4.jpg', '39_20210411203528_', 7, 125, 'Computers are a balanced mix of software and hardware. Hardware is just a piece of mechanical device and its functions are being controlled by a compatible software.', 7, 'University of California', 'WDP', 'A1S', '', b'0000000001', 150, '39_20210411203517_CPPtechnical.pdf', 39, 4, '2021-04-11 20:37:38', 41, NULL, '2021-04-11 20:35:17', 39, '2021-04-11 20:37:38', 41, b'0000000001'),
(85, 'Computer Graphics', 6, '39_20210411203647_5.jpg', '39_20210411203647_', 7, 125, 'Computers are a balanced mix of software and hardware. Hardware is just a piece of mechanical device and its functions are being controlled by a compatible software.', 7, 'University of California', 'WDP', 'A1S', '', b'0000000001', 150, '39_20210411203623_5.CDLabManual.pdf', 39, 3, NULL, 41, NULL, '2021-04-11 20:36:23', 39, '2021-04-11 20:36:47', 39, b'0000000001'),
(86, 'Microsoft Excel-basic', 10, '43_20210411204618_3.jpg', '43_20210411204625_', 7, 145, 'It would be a difficult and cumbersome task for computer programmers to write such codes, which is why we have compilers to write such codes.', 9, 'Ahmedabad institute of technology', 'CS', '001', '', b'0000000001', 120, '43_20210411204618_CPPtechnical.pdf', 43, 3, NULL, 42, NULL, '2021-04-11 20:46:18', 43, '2021-04-11 20:46:25', 43, b'0000000001'),
(87, '7 habits of best person', 9, '44_20210411205925_4.jpg', '44_20210411205934_', 6, 300, ' compiler translates the code written in one language to some other language without changing the meaning of the program. It is also expected that a compiler should make the target code efficient and optimized in terms of time and space.', 5, 'AIT', 'ICAI', '1230', 'Harish prajapati', b'0000000000', 0, '44_20210411205925_CPPtechnical30July.pdf', 44, 4, '2021-04-11 21:00:15', 42, NULL, '2021-04-11 20:59:25', 44, '2021-04-11 21:00:15', 42, b'0000000001'),
(88, 'Operating System - basics', 9, '44_20210411210048_5.jpg', '44_20210411210054_', 9, 115, 'We have learnt that any computer system is made of hardware and software. The hardware understands a language, which humans cannot understand.', 8, 'UK college', '', '', '', b'0000000001', 345, '44_20210411210048_5.CDLabManual.pdf', 44, 4, '2021-04-11 21:02:05', 42, NULL, '2021-04-11 21:00:48', 44, '2021-04-11 21:02:05', 42, b'0000000001'),
(89, 'OS architecture', 9, '', '44_20210411210307_', 9, 115, 'We have learnt that any computer system is made of hardware and software. The hardware understands a language, which humans cannot understand.', 8, 'UK college', '', '', '', b'0000000000', 0, '', 44, 2, NULL, NULL, NULL, '2021-04-11 21:02:56', 44, '2021-04-11 21:03:07', 44, b'0000000001'),
(90, 'Microsoft Word - basics cheats', 10, '', '39_20210411211041_CPPtechnical 30July.pdf', 8, 140, 'This tutorial requires no prior knowledge of compiler design but requires basic understanding of at least one programming language such as C, Java etc.', 5, 'AIT', 'CSA', '115', 'Kirtan patadiya', b'0000000000', 0, '', 39, 1, NULL, NULL, NULL, '2021-04-11 21:10:41', 39, NULL, NULL, b'0000000001');

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
(2, 'Submitted  for Review', NULL, NULL, NULL, NULL, b'0000000001'),
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
(5, 4, 'Good quality of notes', 73, 43, '2021-04-11 20:49:46', 43, NULL, NULL, b'0000000001'),
(6, 3, 'Notes pictures are not clear.', 80, 43, '2021-04-11 20:50:11', 43, NULL, NULL, b'0000000001'),
(7, 5, 'nice note', 73, 44, '2021-04-11 21:04:34', 44, NULL, NULL, b'0000000001'),
(8, 5, 'very good book', 87, 39, '2021-04-11 21:09:23', 39, NULL, NULL, b'0000000001'),
(9, 3, 'nice', 84, 43, '2021-04-11 21:11:48', 43, NULL, NULL, b'0000000001'),
(10, 2, 'not much good.', 74, 43, '2021-04-11 21:12:57', 43, NULL, NULL, b'0000000001'),
(11, 4, 'best work', 73, 43, '2021-04-11 21:13:29', 43, NULL, NULL, b'0000000001');

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

--
-- Dumping data for table `spamnotes`
--

INSERT INTO `spamnotes` (`SpamID`, `NoteID`, `Remark`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(6, 80, 'It is an average note.', '2021-04-11 20:50:50', 43, NULL, NULL, b'0000000001'),
(7, 77, 'very bad quality of note', '2021-04-11 21:05:01', 44, NULL, NULL, b'0000000001');

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

--
-- Dumping data for table `systemtable`
--

INSERT INTO `systemtable` (`SystemID`, `SupportEmail`, `SupportPhone`, `SubscriberEmails`, `FacebookURL`, `TwitterURL`, `LinkedinURL`, `DefaultProfilePicture`, `DefaultDisplayPicture`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `Modifiedby`, `IsActive`) VALUES
(1, 'notesmarketplace2021@gmail.com', '9898989898', 'prajapatichhagan1515@gmail.com,170020107045ait@gmail.com', 'https://www.facebook.com/TatvaSoft/', 'https://twitter.com/tatvasoft?lang=en', 'https://www.linkedin.com/company/tatvasoft/mycompany/', '38_20210411010854_reviewer-2.png', '38_20210411010854_computer-science.png', '2021-04-11 01:08:54', 38, '2021-04-11 21:27:18', 38, b'0000000001');

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
(6, 'handwritten books', 'handwritten books', '2021-04-11 01:17:31', 38, NULL, NULL, b'0000000001'),
(7, 'university note', 'university note', '2021-04-11 01:17:46', 38, NULL, NULL, b'0000000001'),
(8, 'self-write', 'self-write', '2021-04-11 01:18:03', 38, NULL, NULL, b'0000000001'),
(9, 'novel', 'novel', '2021-04-11 01:18:13', 38, NULL, NULL, b'0000000001');

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
  `SecondaryEmailID` varchar(100) DEFAULT NULL,
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

INSERT INTO `user` (`UserID`, `RoleID`, `FirstName`, `LastName`, `EmailID`, `Password`, `IsEmailVerified`, `SecondaryEmailID`, `BirthDate`, `Gender`, `PhoneNo`, `ProfilePictureFile`, `Address1`, `Address2`, `City`, `State`, `Zipcode`, `CountryID`, `University`, `CollegeName`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(38, 1, 'Admin', 'Admin', 'admin.notesmarketplace@gmail.com', 'bb97aba07e650b51b66fd7a1e257528a', b'0000000001', 'notesmarketplace.admin@gmail.com', NULL, NULL, '+91 9856478562', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-11 01:23:01', 38, b'0000000001'),
(39, 3, 'Chhagan', 'Prajapati', 'chhaganlal.prajapati1515@gmail.com', '431b5a8d980606553c7beefee18781b9', b'0000000001', NULL, '1970-01-01', 0, '+91 7874209486', '39_20210411121109_photo.jpg', 'C/3 simandhar residency 2', '', 'Ahmedabad', 'Gujarat', '382481', 5, 'GTU', 'AIT', '2021-04-11 01:04:48', NULL, '2021-04-11 18:51:58', 39, b'0000000001'),
(40, 2, 'Harish', 'Prajapati', 'prajapati.harish2320@gmail.com', '1c9c75640f3e0e3d41ad771c24af347c', b'0000000001', NULL, NULL, NULL, '+91 7600398532', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-11 01:13:01', 38, NULL, NULL, b'0000000001'),
(41, 2, 'Kirtan', 'Patadiya', '170020107045ait@gmail.com', 'b180f96ad0f68da7ba44d405d157b4f4', b'0000000001', '', NULL, NULL, '+91 9885698587', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-11 01:14:38', 38, '2021-04-11 19:29:26', 41, b'0000000001'),
(42, 2, 'Yash', 'Patel', 'prajapatichhagan1515@gmail.com', 'ddfe6310aca45207726841e35887717b', b'0000000001', NULL, NULL, NULL, '+91 9568745234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-11 01:15:16', 38, '2021-04-11 21:27:27', 38, b'0000000001'),
(43, 3, 'Mitesh', 'Desai', 'mitesh.desai@gmail.com', 'd6cd0d76854b4030b427a41aa3ec069c', b'0000000001', NULL, '1970-01-01', 0, '+91 9586847595', '', '5, Ambapur', 'Adalaj', 'Ahmedabad', 'Gujarat', '380001', 8, 'University of gorgia', 'GIT', '2021-04-11 19:04:00', NULL, '2021-04-11 19:06:57', 43, b'0000000001'),
(44, 3, 'HARISHKUMAR', 'PRAJAPATI', 'kisanramoliya1@gmail.com', 'b202c6424b9da98a0dd9d9282fdec3cb', b'0000000001', NULL, '1970-01-01', 0, '+91 8585858585', '44_20210411191935_photo1.jpg', 'C/3 SIMANDHAR RESIDENCY-2', 'chandlodia', 'AHMEDABAD', 'GUJARAT', '382481', 8, 'GTU', '', '2021-04-11 19:15:07', NULL, '2021-04-11 19:19:35', 44, b'0000000001');

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
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `countrytable`
--
ALTER TABLE `countrytable`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `DownloadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `notestatus`
--
ALTER TABLE `notestatus`
  MODIFY `NoteStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviewnotes`
--
ALTER TABLE `reviewnotes`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `spamnotes`
--
ALTER TABLE `spamnotes`
  MODIFY `SpamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `systemtable`
--
ALTER TABLE `systemtable`
  MODIFY `SystemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `typetable`
--
ALTER TABLE `typetable`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
