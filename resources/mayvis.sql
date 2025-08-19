-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 09:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mayvis`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`) VALUES
(1, 'NAIT'),
(2, 'Alberta Health Services (AHS)'),
(4, 'ESPN'),
(5, 'Minnesota WIld'),
(7, 'Colorado Avalanche'),
(10, 'MAYVIS'),
(12, 'Edmonton Oilers'),
(16, 'Amazon'),
(17, 'Meta'),
(20, 'RBC'),
(21, 'Bank of Montreal'),
(24, 'TD Bank'),
(28, 'Ford Motor Company'),
(32, 'Adobe'),
(33, 'Uber Technologies, Inc'),
(34, 'General Electric Company'),
(35, '123 company'),
(36, 'Airbnb, Inc'),
(37, 'Starbucks'),
(38, 'Nintendo'),
(40, 'Test Compoany'),
(42, 'Nintendo'),
(45, 'My Test Company'),
(47, 'Xbox'),
(48, 'Xbox'),
(56, 'McTesters'),
(57, 'Playstation'),
(58, 'Evan Company 62'),
(59, 'Evan Company 62'),
(60, 'Evan Company 62'),
(61, 'Playstation'),
(62, 'Example Company 3'),
(63, 'Xbox'),
(64, 'Ubisoft'),
(65, 'Moon Company'),
(66, 'Playstation'),
(68, 'Test R Us'),
(69, 'Jeb\'s Company'),
(70, 'Jeb\'s Company 2'),
(71, 'Throw Away Corp');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `first_name`, `last_name`, `email`, `user_id`, `client_id`) VALUES
(1, 'Steve', 'C', 'steve@gmail.com', NULL, 1),
(2, 'Evan', 'Mah', 'test@gmail.com', NULL, NULL),
(3, 'Evan', 'Mah', 'test@gmail.com', NULL, 3),
(4, 'Matt', 'Duchene', 'md@gmail.com', NULL, 4),
(5, 'Kirill', 'Kaprizov', 'minwild@gmail.com', NULL, 5),
(7, 'Nathan', 'MacKinnon', 'avalanche@gmail.com', NULL, 7),
(8, 'Jeb', 'G', 'jebgallarde@gmail.com', NULL, 8),
(12, 'Connor', 'McDavid', 'edmontonoilers@gmail.com', NULL, 12),
(13, 'Evan', 'Mah', 'eee@gmail.com', NULL, 13),
(16, 'Jeff', 'Bezos', 'jeff@amazon.com', NULL, 16),
(17, 'Mark', 'Zuckerberg', 'mzuckberg@gmail.com', NULL, 17),
(20, 'David', 'Mckay', 'davidrbc@gmail.com', NULL, 20),
(21, 'Daryl2', 'White2', 'bmobank@gmail.com', 27, 21),
(22, 'Bharat', 'Masrani', 'bmasrani@gmail.com', NULL, 24),
(26, 'Jim', 'Farley', 'jfarley@gmail.com', NULL, 28),
(29, 'Shantanu ', 'Narayen', 'adobe@gmail.com', NULL, 31),
(31, 'Dara', 'Khosrowshahi', 'uber@email.com', NULL, 33),
(32, 'Michael', 'Client', 'michaeltestclient@gmail.com', 19, 34),
(33, 'David', 'Jones', 'dJones@hotmail.com', 29, 35),
(34, 'Brian', 'Chesky', 'airbnb@gmail.com', 28, 36),
(35, 'Kevin', 'Johnson', 'starbucks@hotmail.com', NULL, 37),
(36, 'Ash', 'Ketchum', 'pallet.town@yahoo.ca', NULL, 38),
(37, 'Jeb', 'G', 'jebgallarde@gmail.com', NULL, 39),
(39, 'Evan', 'Mah', 'evan@gmail.com', NULL, 40),
(41, 'Ash', 'Ketchum', 'pallet.town@nintendo.ca', NULL, 42),
(42, 'David', 'Jones', 'dJones@hotmail.com', NULL, 43),
(43, 'David', 'Jones', 'dJones@hotmail.com', NULL, 44),
(44, 'Test', 'Client1', 'testclient1@test.com', NULL, 45),
(45, 'Dave', 'Jones', 'dJones@hotmail.com', NULL, 46),
(46, 'Ara', 'Garcia', 'agarcia6@xbox.ca', NULL, 47),
(55, 'Larry', 'Test', 'larrytestdnu@gmail.com', NULL, 56),
(56, 'Ara', 'Garcia', 'jmagno@ps.ca', NULL, 57),
(57, 'Evan', 'Laine', 'emah@gmail.com', NULL, 58),
(58, 'Evan', 'Laine', 'emah@gmail.com', NULL, 59),
(59, 'Evan', 'Laine', 'emah@gmail.com', NULL, 60),
(60, 'Jason', 'Magno', 'jmagno@ps.ca', NULL, 61),
(61, 'Steve', 'C', 'exampleemail@gmail.com', NULL, 62),
(62, 'Ara', 'Garcia', 'agarcia6@xbox.ca', NULL, 63),
(63, 'Rasmus', 'Dahlin', 'rdahlin@gmail.com', NULL, 2),
(64, 'Melody', 'Miranda', 'pallet.town@yahoo.ca', NULL, 3),
(65, 'Ash', 'Ketchum', 'pallet.town@yahoo.ca', NULL, 3),
(66, 'Yves', 'Guillemot', 'yguillemot@ubisoft.com', NULL, 64),
(67, 'John', 'Doe', 'johnmoon@gmail.com', NULL, 65),
(68, 'Jason', 'Magno', 'jmagno@ps.ca', NULL, 66),
(69, 'Maya', 'Cabanilla', 'mcabanilla@ps.ca', NULL, 66),
(70, 'DNU', 'DNU', 'DNU@DNU.COM', NULL, 67),
(71, 'Test', 'Client', 'testdnuemail@gmail.com', NULL, 68),
(72, 'jebtest', 'test', 'jebtesttest@gmail.com', 30, 69),
(73, 'Jeb', 'Test', 'jebtest123@gmail.com', NULL, 11),
(74, 'Jeb', 'Gallarde', 'jebtesttest@gmail.com', NULL, 69),
(75, 'Jeb', 'Test', 'jebtesttest@gmail.com', NULL, 70),
(76, 'Throw', 'Thorton', 'throwawaythorton@gmail.com', 123, 71),
(77, 'Nelly', 'Miranda', 'nellym@yahoo.com', NULL, 16),
(78, 'Jason', 'Magno', 'mhel_2207@yahoo.com', NULL, 20),
(79, '', '', '', NULL, 72),
(80, '', '', '', NULL, 73),
(81, '', '', '', NULL, 74);

-- --------------------------------------------------------

--
-- Table structure for table `deliverables`
--

CREATE TABLE `deliverables` (
  `deliverable_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` text NOT NULL,
  `updated_date` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deliverables`
--

INSERT INTO `deliverables` (`deliverable_id`, `title`, `description`, `price`, `category`, `updated_date`, `visible`) VALUES
(1, 'Website Wireframe', 'Wireframing for website', 2500.00, 'WEB', '0000-00-00', 0),
(2, 'Branding Strategy', 'Old Brands and Old - This is just a place-holder for editing templates. Feel free to change anything here! ', 45.99, 'BRAND', '0000-00-00', 1),
(4, 'Portraits & Images', 'Photos of employees or staff and banners for websites or other uses. ', 699.00, 'PHOTOGRAPHY', '0000-00-00', 0),
(5, 'Media and Graphic Designs', 'One Pager | Brochure | Business Cards | PPT ..', 1600.00, 'GRAPHIC DESIGN', '0000-00-00', 1),
(10, 'No longer used, depreciated templates.', 'Expired sales products and packages', 0.00, 'INACTIVE', '0000-00-00', 1),
(12, 'Website Evaluation and Validation', 'We run your site through our system analysis and compare it against Google\'s standards to give you the best ways to enhance your site and is discover-ability.  ', 299.00, 'WEB', '0000-00-00', 0),
(23, 'Website SEO', 'Search Engine Optimization', 550.00, 'WEB', '2024-03-16', 0),
(30, '3D Rendering & Photoshop', 'These are our complex editing and rendering services. ', 2700.00, 'PHOTOGRAPHY', '2024-03-23', 1),
(54, 'Advertisement', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 500.00, 'Marketing', NULL, 1),
(59, 'My Videography Template', 'Lorem ipsum', 1000.00, 'DIGITAL VIDEOGRAPHY', NULL, 1),
(60, 'Add CHATBOT to the website', 'This web base service will empower your website to have a AI chatbot that will help the user about FAQs. ', 465.00, 'GRAPHIC DESIGN', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_first_name` text NOT NULL,
  `employee_last_name` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_first_name`, `employee_last_name`, `user_id`) VALUES
(1, 'Evan', 'Mah', 1),
(2, 'Trevor', 'S', 2),
(3, 'Jeb', 'Gallarde', 3),
(5, 'Kevin', 'Brooks', 5),
(7, 'Travis', 'Simmons', 7),
(9, 'James ', 'Cameron', 9),
(12, 'Nicole', 'P', 12),
(13, 'Melody', 'Miranda', 13);

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `favourite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deliverable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`favourite_id`, `user_id`, `deliverable_id`) VALUES
(1, 1, 21),
(2, 1, 2),
(5, 1, 21),
(6, 1, 21),
(10, 1, 10),
(12, 12, 2),
(16, 12, 53),
(18, 7, 53),
(20, 13, 60),
(24, 3, 2),
(25, 3, 5),
(26, 7, 2),
(27, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_deliverables`
--

CREATE TABLE `ordered_deliverables` (
  `order_id` int(11) NOT NULL,
  `deliverable_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ordered_deliverables`
--

INSERT INTO `ordered_deliverables` (`order_id`, `deliverable_id`, `proposal_id`, `quantity`) VALUES
(1, 1, 6, NULL),
(2, 1, 7, NULL),
(3, 2, 7, NULL),
(4, 1, 9, NULL),
(5, 2, 9, NULL),
(6, 1, 10, NULL),
(7, 2, 10, NULL),
(8, 1, 11, NULL),
(9, 2, 12, NULL),
(10, 1, 13, NULL),
(11, 3, 12, 2),
(12, 4, 12, 4),
(13, 2, 17, 2),
(14, 3, 17, 1),
(15, 2, 18, 1),
(16, 3, 1, 2),
(17, 2, 19, 1),
(18, 5, 19, 3),
(19, 10, 19, 2),
(20, 12, 19, 6),
(21, 1, 20, 1),
(22, 4, 20, 3),
(23, 10, 20, 2),
(24, 21, 20, 5),
(25, 2, 21, 1),
(26, 4, 21, 2),
(27, 2, 22, 1),
(28, 4, 22, 3),
(29, 5, 22, 1),
(30, 2, 23, 1),
(31, 4, 23, 2),
(32, 1, 24, 1),
(33, 2, 24, 2),
(34, 2, 25, 1),
(35, 4, 25, 2),
(36, 1, 26, 1),
(37, 4, 26, 1),
(38, 5, 26, 1),
(39, 2, 27, 1),
(40, 2, 28, 1),
(41, 4, 28, 2),
(42, 5, 29, 1),
(43, 4, 30, 1),
(44, 5, 30, 1),
(45, 4, 31, 1),
(46, 5, 31, 1),
(47, 2, 32, 1),
(48, 4, 32, 2),
(49, 4, 33, 1),
(50, 5, 33, 2),
(51, 4, 33, 1),
(52, 5, 33, 2),
(53, 2, 34, 2),
(54, 5, 34, 1),
(55, 2, 34, 2),
(56, 5, 34, 1),
(57, 2, 35, 2),
(58, 4, 35, 1),
(59, 5, 35, 1),
(60, 2, 35, 2),
(61, 4, 35, 1),
(62, 5, 35, 1),
(63, 4, 36, 1),
(64, 5, 36, 2),
(65, 4, 36, 1),
(66, 5, 36, 2),
(67, 4, 37, 1),
(68, 5, 37, 2),
(69, 4, 37, 1),
(70, 5, 37, 2),
(71, 1, 38, 2),
(72, 2, 38, 1),
(73, 1, 38, 2),
(74, 2, 38, 1),
(75, 2, 39, 2),
(76, 4, 39, 1),
(77, 2, 39, 2),
(78, 4, 39, 1),
(79, 5, 40, 2),
(80, 30, 40, 1),
(81, 5, 40, 2),
(82, 30, 40, 1),
(83, 5, 41, 1),
(84, 5, 41, 1),
(85, 1, 42, 2),
(86, 2, 42, 1),
(87, 4, 42, 1),
(88, 1, 43, 2),
(89, 4, 43, 1),
(90, 1, 44, 1),
(91, 2, 44, 1),
(92, 1, 44, 1),
(93, 2, 44, 1),
(94, 1, 45, 1),
(95, 2, 45, 1),
(96, 1, 45, 1),
(97, 2, 45, 1),
(98, 1, 46, 2),
(99, 4, 46, 1),
(100, 2, 47, 1),
(101, 4, 47, 1),
(102, 2, 47, 1),
(103, 4, 47, 1),
(104, 4, 48, 2),
(105, 5, 48, 1),
(106, 4, 48, 2),
(107, 5, 48, 1),
(108, 2, 49, 2),
(109, 12, 49, 1),
(110, 2, 49, 2),
(111, 12, 49, 1),
(112, 4, 50, 2),
(113, 5, 50, 1),
(114, 12, 51, 1),
(115, 21, 51, 2),
(116, 5, 52, 2),
(117, 23, 52, 1),
(118, 56, 53, 2),
(119, 56, 54, 4),
(120, 4, 55, 2),
(121, 29, 55, 1),
(122, 53, 55, 1),
(123, 4, 55, 2),
(124, 29, 55, 1),
(125, 53, 55, 1),
(126, 4, 56, 2),
(127, 29, 56, 1),
(128, 53, 56, 1),
(129, 4, 56, 2),
(130, 29, 56, 1),
(131, 53, 56, 1),
(132, 1, 57, 2),
(133, 2, 57, 1),
(134, 5, 57, 1),
(135, 1, 57, 2),
(136, 2, 57, 1),
(137, 5, 57, 1),
(138, 1, 58, 1),
(139, 5, 58, 1),
(140, 21, 58, 1),
(141, 4, 59, 2),
(142, 23, 59, 1),
(143, 4, 59, 2),
(144, 23, 59, 1),
(145, 1, 60, 1),
(146, 1, 60, 1),
(147, 1, 61, 1),
(148, 1, 61, 1),
(149, 23, 62, 2),
(150, 29, 62, 1),
(151, 23, 62, 2),
(152, 29, 62, 1),
(153, 1, 63, 1),
(154, 2, 63, 4),
(155, 4, 63, 1),
(156, 5, 63, 1),
(157, 29, 63, 1),
(158, 30, 63, 1),
(159, 54, 63, 1),
(160, 1, 63, 1),
(161, 2, 63, 4),
(162, 4, 63, 1),
(163, 5, 63, 1),
(164, 29, 63, 1),
(165, 30, 63, 1),
(166, 54, 63, 1),
(167, 1, 64, 1),
(168, 56, 64, 1),
(169, 57, 64, 1),
(170, 58, 64, 1),
(171, 59, 64, 1),
(172, 1, 64, 1),
(173, 56, 64, 1),
(174, 57, 64, 1),
(175, 58, 64, 1),
(176, 59, 64, 1),
(177, 1, 65, 1),
(178, 1, 65, 1),
(179, 1, 66, 1),
(180, 1, 66, 1),
(181, 23, 67, 1),
(182, 23, 67, 1),
(183, 53, 68, 1),
(184, 53, 68, 1),
(185, 29, 69, 1),
(186, 29, 69, 1),
(187, 29, 70, 1),
(188, 29, 70, 1),
(189, 21, 71, 1),
(190, 56, 72, 1),
(191, 56, 72, 1),
(192, 54, 73, 2),
(193, 54, 73, 2),
(194, 54, 74, 2),
(195, 2, 75, 1),
(196, 2, 75, 1),
(197, 4, 76, 2),
(198, 10, 76, 1),
(199, 4, 76, 2),
(200, 10, 76, 1),
(201, 4, 77, 1),
(202, 4, 77, 1),
(203, 12, 78, 1),
(204, 21, 78, 1),
(205, 12, 78, 1),
(206, 21, 78, 1),
(207, 54, 79, 1),
(208, 54, 79, 1),
(209, 10, 80, 1),
(210, 12, 80, 1),
(211, 10, 80, 1),
(212, 12, 80, 1),
(213, 4, 81, 1),
(214, 5, 81, 1),
(215, 12, 81, 1),
(216, 21, 81, 1),
(217, 4, 81, 1),
(218, 5, 81, 1),
(219, 12, 81, 1),
(220, 21, 81, 1),
(221, 1, 82, 1),
(222, 4, 82, 1),
(223, 5, 82, 1),
(224, 1, 82, 1),
(225, 4, 82, 1),
(226, 5, 82, 1),
(227, 12, 83, 1),
(228, 12, 83, 1),
(229, 1, 84, 1),
(230, 1, 84, 1),
(231, 5, 85, 1),
(232, 5, 85, 1),
(233, 2, 86, 1),
(234, 2, 86, 1),
(235, 30, 87, 1),
(236, 30, 87, 1),
(237, 2, 88, 1),
(238, 5, 88, 1),
(239, 2, 88, 1),
(240, 5, 88, 1),
(241, 59, 89, 1),
(242, 59, 89, 1),
(243, 4, 90, 2),
(244, 12, 90, 1),
(245, 4, 90, 2),
(246, 12, 90, 1),
(247, 4, 91, 1),
(248, 4, 91, 1),
(249, 4, 92, 1),
(250, 4, 92, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id_reset` int(11) NOT NULL,
  `reset_email` text NOT NULL,
  `reset_selector` text NOT NULL,
  `reset_token` longtext NOT NULL,
  `reset_expiry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id_reset`, `reset_email`, `reset_selector`, `reset_token`, `reset_expiry`) VALUES
(17, 'jebgallarde@gmail.com', '48a1d6e6ebb00633', '$2y$10$4QwyGCwt2aNaJ5CxIambVOImHy2sxpQVWZBOszA2hLyZQ1U.CxRS2', '1712362844'),
(20, 'mhel_2207@yahoo.com', '5e46564a84dacf9c', '$2y$10$0/ru1CK8N6YN7WfJoGycwOapyAz.4JG2Om3izKhxhMVuFNynnaBCK', '1712853103');

-- --------------------------------------------------------

--
-- Table structure for table `profile_pictures`
--

CREATE TABLE `profile_pictures` (
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `profile_pictures`
--

INSERT INTO `profile_pictures` (`user_id`, `filename`) VALUES
(1, 'tsukada-kazuhiro-DIWkjAowxSI-unsplash.jpg'),
(3, 'catavif.jpg'),
(7, 'triken160800029.jpg'),
(19, 'Michael-S-Guy-1174773287.jpg.jpg'),
(29, 'chopper.jpg'),
(123, 'triken160800029.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `proposal_id` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `proposal_title` text NOT NULL,
  `proposal_letter` text NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `approval_date` date DEFAULT NULL,
  `client_response` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `value` decimal(12,2) DEFAULT NULL,
  `employee_creator` text DEFAULT NULL,
  `seen` tinyint(1) DEFAULT 0,
  `sent_status` int(2) NOT NULL DEFAULT 0,
  `second_sig` int(11) NOT NULL DEFAULT 0 COMMENT '0: no sig, 1: needs another, 3: has both'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`proposal_id`, `creation_date`, `proposal_title`, `proposal_letter`, `employee_id`, `client_id`, `contact_id`, `status`, `approval_date`, `client_response`, `signature`, `value`, `employee_creator`, `seen`, `sent_status`, `second_sig`) VALUES
(1, '2024-01-30', 'NAIT Proposal', '<p>My <strong>Edited Letter</strong></p>', 1, 1, 38, 0, '2024-03-03', 'I like it', 'Evan', 42.98, 'Jeb', 1, 1, 0),
(2, '0000-00-00', 'Alberta Health Services', 'This is an example of a description of for a proposal.', 2, 2, NULL, 2, '2024-04-05', '', '', 999.00, 'Evan Mah', 0, 1, 0),
(3, '2024-02-29', 'Minnesota Wild Proposal', 'This is a letter to Kirill Kaprizov', 9, 5, NULL, 1, NULL, NULL, '', 339.22, NULL, 0, 1, 0),
(5, '2024-03-03', 'Colorado Proposal', 'Dear Nathan MacKinnon, this is my letter to you', 8, 7, NULL, 1, NULL, NULL, '', 1599.00, 'Travis', 0, 0, 0),
(6, '2024-03-08', 'Social Media Ad Campaign', 'A proposal designed to target the Instagram and Snapchat demographic. ', 7, 34, 69, 2, '2024-03-25', 'Blah blah ', 'mister tc', 899.00, NULL, 1, 1, 0),
(7, '2024-03-21', 'Web Page Redesign Package', 'This is a proposal where it a complete redesign for a client\'s website. ', 5, 5, NULL, 1, NULL, NULL, '', 699.00, NULL, 0, 1, 0),
(16, '2024-03-14', 'Proposal for RBC', '<p>Good evening, I am writing to you</p>', 1, 20, NULL, 2, NULL, NULL, '', 1398.00, 'Ash', 0, 0, 0),
(17, '2024-03-14', 'BMO Proposal', '<p>Hello Daryl White, I hope you are well</p>', 1, 21, NULL, 2, NULL, NULL, '', 6268.00, NULL, 0, 0, 0),
(18, '2024-03-14', 'TD Bank Proposal', '<p>Hello TD bank</p>', 7, 7, NULL, 1, NULL, NULL, '', 3198.00, 'EVan', 0, 1, 0),
(21, '2024-03-16', 'Ford Motor Company Proposal', '<h1 class=\"ql-align-justify\">Lorem ipsum </h1><p class=\"ql-align-justify\">dolor sit amet, consectetur adipiscing elit. In imperdiet congue bibendum. Vestibulum dignissim eleifend sapien, a dignissim orci ultricies vel. Duis vitae est imperdiet, auctor mauris et, rhoncus nunc. Curabitur vel magna non nulla consectetur viverra eget tincidunt tellus. Duis eleifend ante sit amet risus vehicula, a egestas ex cursus. Mauris pellentesque tempor mauris, non ullamcorper quam rhoncus et. Donec non velit velit. Donec nec nisi vitae leo euismod facilisis condimentum quis dui. Nunc faucibus aliquam rhoncus. Praesent ac viverra mi. Nam feugiat sollicitudin sollicitudin. Nullam placerat, augue a interdum tincidunt, felis nibh elementum lorem, eu blandit eros ipsum id odio. Sed nec augue nec lacus aliquet dignissim quis at lorem.</p><p class=\"ql-align-justify\"><strong>Fusce laoreet</strong> augue nec tellus lacinia, vitae sagittis metus blandit. Nulla mattis quis nibh a tempor. Phasellus ullamcorper, diam a auctor varius, enim ipsum commodo quam, sit amet laoreet lorem libero eu velit. Ut convallis urna eu felis pulvinar tempus. Quisque vulputate lectus non velit fermentum iaculis. Mauris gravida, libero sed commodo facilisis, mauris risus consectetur nunc, sed tincidunt tellus magna at nunc. Nulla porttitor erat quam, quis vehicula urna tristique quis. Nam venenatis ut tortor vel pharetra. Vestibulum non euismod nisi.</p><p class=\"ql-align-justify\">Pellentesque purus nibh, viverra nec purus vitae, vestibulum fermentum turpis. Ut sit amet porttitor arcu. Sed vel felis volutpat justo consequat volutpat quis eu arcu. Etiam sit amet mollis urna, non consectetur quam. Nulla malesuada in neque condimentum euismod. Vestibulum rutrum pretium commodo. Sed dui urna, dictum vitae leo vel, mattis auctor ex. Sed elementum mauris eu nisi consequat, vitae vestibulum magna bibendum. Etiam cursus vitae libero sit amet bibendum. Praesent lobortis at nibh in bibendum. Donec vitae consequat massa, sit amet posuere turpis. Aliquam ornare in mi eget facilisis.</p><p><br></p>', 1, 28, NULL, 0, '2024-03-18', '', '', 2798.00, 'Evan', 0, 0, 0),
(23, '2024-03-18', 'Proposal for Adobe', '<h2 class=\"ql-align-justify\"><strong>Lorem ipsum </strong></h2><p class=\"ql-align-justify\">dolor sit amet, consectetur adipiscing elit. Aliquam dapibus tellus non ex vulputate faucibus. Maecenas eleifend gravida nunc nec feugiat. Etiam nec cursus sem, a laoreet velit. Nam pretium maximus purus, eu mollis tellus lacinia at. In et cursus elit, vel imperdiet est. Ut pulvinar nulla ut est ornare, ac lacinia nibh fermentum. Aliquam ultrices ante vel pharetra rutrum. Nulla facilisi. Curabitur tristique dui quis mi placerat, eget convallis ex facilisis. Suspendisse ipsum velit, faucibus ac lacinia eu, congue a purus. Nunc sodales id metus sed placerat. <strong>Nunc </strong>in tincidunt ex. Nulla sagittis nisl felis, nec dignissim diam faucibus vitae. Morbi non arcu sem. Cras mollis pulvinar risus, vitae tincidunt metus elementum lobortis.</p><p class=\"ql-align-justify\">Pellentesque eget gravida erat. In convallis convallis nulla vitae consectetur. Integer tempus imperdiet nulla, ac malesuada ante tincidunt malesuada. Morbi volutpat volutpat nibh vel suscipit. Fusce ut urna mi. Nulla tempor erat malesuada tincidunt ultricies. Integer efficitur efficitur ligula sed euismod. Maecenas vel risus quis neque consectetur laoreet et a quam. Nunc ullamcorper urna ornare sem tempus convallis. Vestibulum sit amet purus ligula. Nam ornare laoreet tortor vel maximus.</p><p class=\"ql-align-justify\">Pellentesque suscipit nisi nec gravida scelerisque. Maecenas non mauris finibus, ultricies arcu sed, condimentum libero. Fusce lacinia ipsum sit amet ex facilisis, ut vulputate massa fringilla. Sed vitae justo porttitor, volutpat odio condimentum, venenatis lectus. Nam vel mi vitae diam faucibus mollis vel ac turpis. Donec auctor tellus sit amet interdum porttitor. Etiam pretium aliquet dignissim.</p><p><br></p>', 1, 32, NULL, 1, NULL, NULL, NULL, 3898.00, NULL, 0, 1, 0),
(24, '2024-03-18', 'Uber Proposal', '<h1 class=\"ql-align-justify\"><strong>Lorem ipsum</strong> </h1><p class=\"ql-align-justify\">dolor sit amet, consectetur adipiscing elit. Aliquam dapibus tellus non ex vulputate faucibus. Maecenas eleifend gravida nunc nec feugiat. Etiam nec cursus sem, a laoreet velit. Nam pretium maximus purus, eu mollis tellus lacinia at. In et cursus elit, vel imperdiet est. Ut pulvinar nulla ut est ornare, ac lacinia nibh fermentum. Aliquam ultrices ante vel pharetra rutrum. Nulla facilisi. Curabitur tristique dui quis mi placerat, eget convallis ex facilisis. Suspendisse ipsum velit, faucibus ac lacinia eu, congue a purus. Nunc sodales id metus sed placerat. Nunc in tincidunt ex. Nulla sagittis nisl felis, nec dignissim diam faucibus vitae. Morbi non arcu sem. Cras mollis pulvinar risus, vitae tincidunt metus elementum lobortis.</p><p class=\"ql-align-justify\">Pellentesque eget gravida erat. In convallis convallis nulla vitae consectetur. Integer tempus imperdiet nulla, ac malesuada ante tincidunt malesuada. Morbi volutpat volutpat nibh vel suscipit. Fusce ut urna mi. Nulla tempor erat malesuada tincidunt ultricies. Integer efficitur efficitur ligula sed euismod. Maecenas vel risus quis neque consectetur laoreet et a quam. Nunc ullamcorper urna ornare sem tempus convallis. Vestibulum sit amet purus ligula. Nam ornare laoreet tortor vel maximus.</p><p class=\"ql-align-justify\">Pellentesque suscipit nisi nec gravida scelerisque. Maecenas non mauris finibus, ultricies arcu sed, condimentum libero. Fusce lacinia ipsum sit amet ex facilisis, ut vulputate massa fringilla. Sed vitae justo porttitor, volutpat odio condimentum, venenatis lectus. Nam vel mi vitae diam faucibus mollis vel ac turpis. Donec auctor tellus sit amet interdum porttitor. Etiam pretium aliquet dignissim.</p><h1><br></h1>', 1, 33, NULL, 2, '2024-03-18', 'I quite like this estimate, thank u sir. ', 'Jim Bob', 7000.00, NULL, 0, 1, 0),
(25, '2024-03-18', 'Proposal for General Electric Company', 'This is a proposal for GENERAL ELECTRIC', 1, 34, NULL, 0, '2024-03-27', 'Please change the deliverables', 'Evan', 3898.00, NULL, 1, 0, 0),
(27, '2024-03-23', 'Proposal for Airbnb', '<p>Hello This is a <strong>letter</strong></p>', 1, 36, NULL, 1, NULL, NULL, NULL, 3898.00, 'Ash', 0, 0, 0),
(28, '2024-03-22', 'Starbucks Proposal', '<p>Hello good morning</p>', 1, 37, NULL, 1, NULL, NULL, NULL, 1642.98, 'Evan Mah', 0, 0, 0),
(29, '2024-03-23', 'My Test Proposal', '<p>My test proposal content</p>', 3, 39, NULL, 1, NULL, NULL, NULL, 1569.00, 'Jeb Gallarde', 0, 1, 0),
(32, '2024-03-25', 'Amazon Proposal Part 2', '<p>Hi Jeff Bezos</p>', 1, 16, NULL, 1, NULL, NULL, NULL, 699.00, 'Evan Mah', 0, 0, 0),
(33, '2024-03-25', 'Ford Motor Company Part 2', '<p>hello mr ford</p>', 1, 28, NULL, 1, NULL, NULL, NULL, 739.00, 'Evan Mah', 0, 0, 0),
(34, '2024-03-24', 'New product', '<p>Hello World</p>', 1, 16, NULL, 1, NULL, NULL, NULL, 2500.00, 'Ash', 0, 0, 0),
(35, '2024-03-25', 'VR', '<p>This is a proposal for <strong><em>Meta.</em></strong></p>', 1, 17, NULL, 0, '2024-04-03', 'My only response', 'Mark', 1697.00, 'Evan Mah', 0, 0, 0),
(36, '2024-03-26', 'Uber Proposal Part 2', '<p>This is my letter to uber, Hi!</p>', 1, 33, NULL, 0, '2024-04-03', 'First Response: HelloSecond Response: second response', 'Uber & second signature', 4000.00, 'Evan Mah', 0, 0, 3),
(37, '2024-03-25', 'General Electric Company Proposal Part 2', '<p>Hi</p>', 1, 34, NULL, 2, '2024-04-03', 'My response', 'Evan M', 3837.00, 'Evan Mah', 1, 0, 0),
(39, '2024-03-25', 'Carpool', 'Hello Client!', 1, 33, NULL, 1, NULL, NULL, NULL, 700.00, 'Evan Mah', 0, 0, 0),
(40, '2024-03-26', 'VR', '<p>Hello <strong><em>Client!</em></strong></p>', 1, 3, NULL, 1, NULL, NULL, NULL, 5800.00, 'Evan Mah', 0, 0, 0),
(41, '2024-03-20', 'Proposal part 2', '<p>my letter</p>', 1, 11, NULL, 1, NULL, NULL, NULL, 1569.00, 'Evan Mah', 0, 0, 0),
(50, '2024-04-02', 'First Proposal for Ubisoft', '<h1 class=\"ql-align-justify\">Lorem ipsum </h1><p class=\"ql-align-justify\">dolor sit <strong>amet</strong>, consectetur adipiscing elit. Quisque ultrices congue rutrum. In eu erat lacus. Vivamus eleifend felis purus, sed rutrum lectus commodo in. Fusce risus lacus, congue a leo ac, ornare eleifend justo. \"Vestibulum\" semper massa feugiat, ultrices enim in, volutpat nulla. Nam placerat neque quis nunc viverra varius. Curabitur ultricies ipsum eget nisi tempor, at sagittis lacus mattis. Vivamus mattis interdum tellus ut congue. Ut cursus, velit sed auctor blandit, quam lorem congue ipsum, eu iaculis dui ex ut nisl. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p><p class=\"ql-align-justify\">Proin sed quam massa. Praesent nec ornare mi. Suspendisse iaculis placerat sodales. Nam tempus sollicitudin ligula, sit amet luctus nibh dignissim nec. Donec a pretium purus. Fusce venenatis libero et auctor tincidunt. Quisque faucibus id quam eget vulputate. Aliquam euismod in nibh a porttitor. Cras id ornare sapien, ut viverra sem. Quisque sed pulvinar velit. Praesent feugiat mattis feugiat. Nunc pellentesque turpis eu suscipit pulvinar. Praesent egestas lorem id risus placerat blandit vitae convallis est.</p><p><br></p>', 1, 64, NULL, 1, NULL, NULL, NULL, 2967.00, 'Evan Mah', 0, 1, 0),
(51, '2024-04-03', 'Proposal for Moon', '<p>Hello, I hope you are well</p>', 1, 65, NULL, 2, '2024-04-03', '<p>First Response: Hi I really like this</p><p>Second Response: I also really like this</p>', 'Robert & Bobbington', 5497.00, 'Evan Mah', 0, 1, 3),
(52, '2024-04-04', 'Playstation update', '<p>Hello <strong>France</strong></p>', 13, 66, NULL, 1, NULL, NULL, NULL, 3600.00, 'Melody Miranda', 1, 1, 0),
(75, '2024-04-11', 'New Proposal Package', '<h1><strong>This is a fact prop</strong> ------- sfhlkjhlsfjulksfjk;lsjfkls;jf;sjfo;jf</h1>', 7, 71, NULL, 2, '2024-04-10', 'Great stuff!', 'ThrowT', 40.00, 'Travis Simmons', 1, 1, 0),
(76, '2024-04-12', 'Amazon', '<p>Hello</p>', 13, 16, NULL, 1, NULL, NULL, NULL, 1398.00, 'Melody Miranda', 1, 1, 0),
(88, '2024-04-14', 'April 14 Proposal', '<p>Hello this is my letter</p>', 1, 28, NULL, 1, NULL, NULL, NULL, 1642.98, 'Evan Mah', 0, 1, 0),
(92, '2024-04-04', 'PDF', '<p>ADADADA</p>', 7, 32, NULL, 1, NULL, NULL, NULL, 699.00, 'Travis Simmons', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `test_name` text NOT NULL,
  `test_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `test_name`, `test_description`) VALUES
(1, 'test', ''),
(2, 'test', ''),
(3, 'test', ''),
(4, 'test', '');

-- --------------------------------------------------------

--
-- Table structure for table `test_deliverables`
--

CREATE TABLE `test_deliverables` (
  `order_id` int(11) NOT NULL,
  `deliverable_id` int(7) DEFAULT NULL,
  `quantity` int(7) DEFAULT NULL,
  `proposal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `test_deliverables`
--

INSERT INTO `test_deliverables` (`order_id`, `deliverable_id`, `quantity`, `proposal_id`) VALUES
(1, 2, 2, 0),
(2, 3, 4, 0),
(3, 2, 2, 6),
(4, 3, 4, 6),
(5, 1, 4, 6),
(6, 2, 6, 6),
(7, 3, 2, 6),
(8, 1, 4, 6),
(9, 2, 6, 6),
(10, 3, 2, 6),
(11, 1, 4, 6),
(12, 2, 6, 6),
(13, 3, 2, 6),
(14, 1, 4, 7),
(15, 2, 6, 7),
(16, 3, 2, 7),
(17, 1, 4, 7),
(18, 2, 6, 7),
(19, 3, 2, 7),
(20, 1, 4, 7),
(21, 2, 6, 7),
(22, 3, 2, 7),
(23, 1, 4, 7),
(24, 2, 6, 7),
(25, 3, 2, 7),
(26, 1, 4, 7),
(27, 2, 6, 7),
(28, 3, 2, 7),
(29, 1, 4, 7),
(30, 2, 6, 7),
(31, 3, 2, 7),
(32, 1, 4, 7),
(33, 2, 6, 7),
(34, 3, 2, 7),
(35, 1, 4, 7),
(36, 2, 6, 7),
(37, 3, 2, 7),
(38, 1, 4, 7),
(39, 2, 6, 7),
(40, 3, 2, 7),
(41, 1, 4, 7),
(42, 2, 6, 7),
(43, 3, 2, 7),
(44, 1, 4, 7),
(45, 2, 6, 7),
(46, 3, 2, 7),
(47, 1, 4, 7),
(48, 2, 6, 7),
(49, 3, 2, 7),
(50, 1, 4, 12),
(51, 2, 6, 12),
(52, 3, 2, 12),
(53, 1, 4, 12),
(54, 2, 6, 12),
(55, 3, 2, 12),
(56, 1, 4, 12),
(57, 2, 6, 12),
(58, 3, 2, 12),
(59, 1, 4, 12),
(60, 2, 6, 12),
(61, 3, 2, 12),
(62, 1, 4, 12),
(63, 2, 6, 12),
(64, 3, 2, 12),
(65, 1, 4, 12),
(66, 2, 6, 12),
(67, 3, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) NOT NULL COMMENT 'user''s email, unique',
  `first_name` varchar(64) NOT NULL COMMENT 'user''s first name',
  `last_name` varchar(64) NOT NULL COMMENT 'user''s last name',
  `user_status` enum('0','1','2','') NOT NULL DEFAULT '0' COMMENT 'user''s permission levels.\r\n0 = client\r\n1 = employee\r\n2 = administrator',
  `notifications` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 = off, 1 = on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `first_name`, `last_name`, `user_status`, `notifications`) VALUES
(1, 'emah10', '$2y$10$0zACUN7Eo6kDR/YRpwJJeeHMIlIAt0jhnZoypu32HNya7gc9wdmpW', 'emah10@nait.ca', 'Evan', 'Mah', '2', '1'),
(3, 'jebg', '$2y$10$dh6dJqBnnPs/rWA786250ON1uHmh.ZFLHVChSYnpQMMz6MSWY3hB2', 'jebgallarde@gmail.com', 'Jeb', 'Gallarde', '2', '1'),
(7, 'TravisSimm', '$2y$10$asL5vYBHqCAup7ahqDfPHO9bfntevGAgFOEOEcHAxrbFAuAkDA/56', 'travisesimmons@gmail.com', 'Travis', 'Simmons', '2', '1'),
(9, 'memirand', '$2y$10$IZLurI0hzxsXbKcdKwo5Ru3PFcmfARxpiiKdNG9zRpAseFx2XcJv2', 'mhel_2207@gmail.com', 'Melody', 'Miranda', '2', '1'),
(12, 'Npoulette', '$2y$10$9XKoGIgztTpyUJOIOjxd5uHF2HX4mmrgEj.PURAAVnomwS3LF9Kl6', 'nicole@keencreative.ca', 'Nicole', 'Poulette', '2', '1'),
(13, 'mhelmiranda', '$2y$10$GK76/UskFtgZsVCnWtV3ZOZJo.BYDFCfUMl0GrR7a1MEbD4mDTfQS', 'mhel_2207@yahoo.com', 'Mel', 'Miranda', '2', '1'),
(19, 'Michael-TestClient', '$2y$10$pi0b4oQOfElZXMTfPPFG5.H8WEbDZ0cBn5NysFrmJy.gooOOh6bpO', 'michaeltestclient@gmail.com', 'Michael', 'Client', '0', '1'),
(20, 'jebclient', '$2y$10$XvTIF7pKNkl8wJlt/zUK.up/LROdHiXg96SvCJqMGfzpCdfthfRnS', 'jebclient@test.com', 'jebclient', 'jebclient', '0', '1'),
(23, 'NobodyTest', '$2y$10$elLtSJCElDidan5m7pRANecdLB3eCwmY0lC5pkZGu3gPRid/cdc1S', 'nobodytetemail@gmail.com', 'Nobody', 'Special', '0', '1'),
(27, 'darylwhite', '$2y$10$3lqFVk/iKlYSApZ5CSOBie7HCK5F.dD7xLTVUBMUY38nzXsxVOxBK', 'bmobank@gmail.com', 'Daryl2', 'White2', '0', '1'),
(28, 'brianchesky', '$2y$10$0MHIwsSviYwCo9HztPIxSOKq6JJyLaVcA2fKI8shnMYAxpl971WqS', 'airbnb@gmail.com', 'Brian', 'Chesky', '0', '1'),
(29, 'DavidJones', '$2y$10$735vVWnwDhEdqKD.shnx8ec0Rd/9rq80DClroUCdaHLpG5S4CL0w6', 'dJones@hotmail.com', 'David', 'Jones', '0', '1'),
(30, 'jebtesttest', '$2y$10$0YZT3eTXs5IC7eSmMfWhSe1pLOVGF.bsRNTH8s7lEU.0VC95vKufO', 'jebtesttest@gmail.com', 'jebtest', 'test', '0', '1'),
(123, 'ThrowAwayT', '$2y$10$Vjf2g5qw6lFx5wWX90RS.e6Sx67/YRmaPiCYbrPAxmHKnIOqjz8Ba', 'throwawaythorton@gmail.com', 'Throw', 'Thorton', '0', '1'),
(124, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@mayvis.com', '', '', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `deliverables`
--
ALTER TABLE `deliverables`
  ADD PRIMARY KEY (`deliverable_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`favourite_id`);

--
-- Indexes for table `ordered_deliverables`
--
ALTER TABLE `ordered_deliverables`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id_reset`);

--
-- Indexes for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`proposal_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `test_deliverables`
--
ALTER TABLE `test_deliverables`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `deliverables`
--
ALTER TABLE `deliverables`
  MODIFY `deliverable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `favourite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ordered_deliverables`
--
ALTER TABLE `ordered_deliverables`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_deliverables`
--
ALTER TABLE `test_deliverables`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
