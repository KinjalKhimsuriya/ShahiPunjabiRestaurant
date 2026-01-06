-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 05:32 PM
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
-- Database: `fosdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `otp_attempts` int(11) NOT NULL,
  `last_resend` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_token`
--

INSERT INTO `password_token` (`id`, `email`, `otp`, `created_at`, `expires_at`, `otp_attempts`, `last_resend`) VALUES
(3, 'admin@admin.com', 0, '2025-04-08 12:18:05', '2025-04-08 12:20:05', 0, '2025-04-24 14:30:44'),
(4, 'kinjal@gmail.com', 0, '2025-04-08 12:23:38', '2025-04-08 12:25:38', 0, '2025-04-08 06:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `no_of_guest` int(255) NOT NULL,
  `reservation_code` varchar(255) NOT NULL,
  `email` varchar(244) NOT NULL,
  `phone` int(10) NOT NULL,
  `date_res` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `suggestions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(11) NOT NULL,
  `AdminName` varchar(45) DEFAULT NULL,
  `UserName` varchar(45) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7894561238, 'test@gmail.com', 'Admin123', '2021-04-04 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(5) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `CreationDate`) VALUES
(1, 'Soup', '2025-04-08 07:11:11'),
(2, 'Sabji', '2025-04-08 07:11:24'),
(3, 'Roti', '2025-04-08 07:11:49'),
(4, 'Paratha', '2025-04-08 07:11:54'),
(5, 'Rice', '2025-04-08 07:11:57'),
(6, 'Salad', '2025-04-08 07:12:00'),
(7, 'Lassi', '2025-04-08 07:12:04'),
(9, 'naan', '2025-04-09 05:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `id` int(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` int(10) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(19, 'syadyuwy', 'shdfus@gmail.com', 2147483647, 'drtyui fawydhiwb', '2025-04-09 02:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `tblfood`
--

CREATE TABLE `tblfood` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `ItemName` varchar(120) DEFAULT NULL,
  `ItemPrice` varchar(120) DEFAULT NULL,
  `ItemDes` varchar(500) DEFAULT NULL,
  `Image` varchar(120) DEFAULT NULL,
  `ItemQty` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfood`
--

INSERT INTO `tblfood` (`ID`, `CategoryName`, `ItemName`, `ItemPrice`, `ItemDes`, `Image`, `ItemQty`) VALUES
(1, 'Soup', 'Veg Manchow Soup', '70', 'A spicy Indo-Chinese soup made with mixed vegetables, garlic, ginger, soy sauce, chili sauce, black pepper, and topped with crispy fried noodles for extra crunch.??', '4eb066f64155aa6dfd767aeab59814e8.jpg', '50'),
(2, 'Soup', 'Mixed Vegetable Soup', '80', 'A healthy and flavorful soup made with carrots, beans, peas, cabbage, tomatoes, garlic, and spices, simmered to perfection for a warm, comforting taste. ???', '6d5efdc93be4f23c7f99b8cdf0522728.jpg', '50'),
(3, 'Soup', 'Sweet Corn Veg Soup', '90', 'A comforting soup made with sweet corn, mixed vegetables, and a blend of spices like black pepper, ginger, and garlic, simmered to create a warm, flavorful dish. ??', '5272a2512f7d9dcccb3505a302f6a878.png', '50'),
(4, 'Soup', 'Carrot Tomato Soup', '75', 'A delicious blend of carrots, tomatoes, onions, garlic, and a hint of ginger simmered with spices like cumin and black pepper. It\'s smooth, flavorful, and nutritious!', '1a96c0d7baf20fb4d1bf0bd157958725.jpg', '50'),
(5, 'Soup', 'Tomato Soup', '60', 'A smooth, tangy soup made with ripe tomatoes, onions, garlic, and a blend of spices like cumin, black pepper, and a touch of cream. ??', 'dc83abc6c481b5f0b7b1c3484b10f00f.jpg', '50'),
(6, 'Sabji', 'Paneer Tikka', '250', 'A rich and creamy Punjabi dish featuring grilled paneer cubes cooked in a spicy, tangy tomato-based gravy, infused with aromatic spices and smoky flavors. Perfect with naan or rice! ??', '5017a6b038c7ea9b3d26cd9a61534a9a.jpg', '60'),
(7, 'Roti', 'Naan', '30', 'A soft, fluffy, and slightly chewy Punjabi bread made from refined flour, traditionally cooked in a tandoor. ??', '2f69f261adeaee824edcb53be80b2136.jpg', '50'),
(8, 'Sabji', 'Paneer Handi', '260', 'A rich and creamy Punjabi curry made with soft paneer cubes, cooked in a spiced tomato-based gravy with traditional handi-style flavors. ??', 'b75ed6ec1f39bd14f0351e1c4f2b3e94.jpg', '50'),
(10, 'Roti', 'Butter Naan', '20', 'Soft, fluffy bread made with refined flour, cooked in a tandoor, and brushed with butter. ?', 'af4a0e9693ad20fed058a95e7bc980c7.jpg', '50'),
(12, 'Rice', 'Paneer Pulao', '210', 'A fragrant Punjabi rice dish made with basmati rice, soft paneer cubes, and aromatic spices, cooked to perfection for a flavorful and mildly spiced meal. Served with raita or salad. ??', '0550c9cac5840c6200f2622079f61de1.jpg', '50'),
(13, 'Salad', 'Spinach Salad', '130', 'Fresh palak (spinach), onions, tomatoes, cucumbers, tossed with lemon juice, chaat masala, salt, and roasted jeera (cumin) for a tangy, refreshing taste! ?', 'c401b6e56e553b9c99b91852bd2dc33a.jpg', '50'),
(14, 'Lassi', 'Salted Lassi', '80', 'A refreshing, tangy yogurt-based drink made with yogurt, water, salt, cumin, and a pinch of black salt. Perfect for cooling off after a spicy meal! ?', 'f57e6679a059fb8e277977408692d973.jpg', '50'),
(15, 'naan', 'Naan', '30', 'cfajhjjh wgsuwu', '647eb7a980bd5ace8fd447c8ef5da7dc.jpg', '50');

-- --------------------------------------------------------

--
-- Table structure for table `tblfoodtracking`
--

CREATE TABLE `tblfoodtracking` (
  `ID` int(10) NOT NULL,
  `OrderId` char(50) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `status` char(50) DEFAULT NULL,
  `StatusDate` timestamp NULL DEFAULT current_timestamp(),
  `OrderCanclledByUser` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfoodtracking`
--

INSERT INTO `tblfoodtracking` (`ID`, `OrderId`, `remark`, `status`, `StatusDate`, `OrderCanclledByUser`) VALUES
(1, '111500378', 'Order Confrimed', 'Order Confirmed', '2021-06-05 12:31:01', NULL),
(2, '111500378', 'Food is preparing', 'Food being Prepared', '2021-06-05 12:31:38', NULL),
(3, '111500378', 'Food delivered sucessfully', 'Food Delivered', '2021-06-05 12:32:37', NULL),
(4, '700823696', 'i dont want this', 'Order Cancelled', '2025-03-21 08:26:10', 1),
(5, '179120542', 'done', 'Food Delivered', '2025-04-08 16:07:14', NULL),
(6, '548547835', 'ok', 'Order Cancelled', '2025-04-08 16:17:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblorderaddresses`
--

CREATE TABLE `tblorderaddresses` (
  `ID` int(11) NOT NULL,
  `UserId` char(100) DEFAULT NULL,
  `Ordernumber` char(100) DEFAULT NULL,
  `Flatnobuldngno` varchar(255) DEFAULT NULL,
  `StreetName` varchar(255) DEFAULT NULL,
  `Area` varchar(255) DEFAULT NULL,
  `Landmark` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `OrderTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `OrderFinalStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorderaddresses`
--

INSERT INTO `tblorderaddresses` (`ID`, `UserId`, `Ordernumber`, `Flatnobuldngno`, `StreetName`, `Area`, `Landmark`, `City`, `OrderTime`, `OrderFinalStatus`) VALUES
(1, '1', '409347008', 'H5534 ', 'XYZ Streer', 'ABC Area', 'test Landmark', 'New Delhi', '2021-06-04 16:34:14', NULL),
(2, '3', '111500378', 'H 52312', 'XYZ Street', 'New Delhi', 'ABC Landmark', 'New Delhi', '2021-06-05 12:29:51', 'Food Delivered'),
(3, '19', '700823696', '45', '4', 'rajkot', 'rajkot', 'rajkot', '2025-03-21 08:24:14', 'Order Cancelled'),
(4, '19', '495766986', '0', '0', '0', '0', '0', '2025-03-21 08:27:45', NULL),
(5, '66', '548547835', 'fdg', 'gdfg', 'grfg', 'gefg', 'egrg', '2025-04-03 10:19:28', 'Order Cancelled'),
(6, '71', '179120542', 'asdsa', 'asdddddd', 'asefsd', 'sdewewwe', 'rajkot', '2025-04-08 16:04:10', 'Food Delivered'),
(7, '68', '679865393', 'zbdhshdns ', 'jhasdhwe ', 'bhsjdwe ', 'sjudw', 'shbdw', '2025-04-24 14:33:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `ID` int(11) NOT NULL,
  `UserId` char(10) DEFAULT NULL,
  `FoodId` char(10) DEFAULT NULL,
  `FoodQty` int(11) DEFAULT NULL,
  `IsOrderPlaced` int(11) DEFAULT NULL,
  `OrderNumber` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`ID`, `UserId`, `FoodId`, `FoodQty`, `IsOrderPlaced`, `OrderNumber`) VALUES
(1, '1', '8', 1, 1, '409347008'),
(2, '1', '7', 1, 1, '409347008'),
(3, '3', '1', 1, 1, '111500378'),
(4, '3', '5', 2, 1, '111500378'),
(5, '6', '1', 1, NULL, NULL),
(7, '19', '5', 2, 1, '700823696'),
(8, '19', '2', 2, 1, '495766986'),
(9, '19', '6', 1, 1, '495766986'),
(10, '66', '6', 1, 1, '548547835'),
(13, '71', '12', 3, 1, '179120542'),
(14, '68', '1', 1, 1, '679865393'),
(15, '68', '2', 2, 1, '679865393');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `profile` varchar(300) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Inactive',
  `token` text NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FirstName`, `LastName`, `Email`, `MobileNumber`, `Password`, `profile`, `status`, `token`, `RegDate`) VALUES
(68, 'kinjal', 'khimsuriya', 'amandhat276@rku.ac.in', 9265741941, 'kinjal', 'news-4.jpg', 'Active', '67f4b78bdb81b1744091019', '2025-04-08 05:43:39'),
(70, 'alnur', 'mandhat', 'alnur@gmail.com', 1232123232, 'alnur12', 'events-bg.jpg', 'Inactive', '', '2025-04-08 15:39:33'),
(71, 'Alnur', 'Mandhat', 'amandhat276@rku.ac.in', 9265741941, 'Alnur123', '67f548a1dd585card.jpg', 'Active', '67f548a1dd58a1744128161', '2025-04-08 16:02:41'),
(73, 'janki', 'kansagra', 'janki.kansagra@rku.ac.in', 9265741941, 'janki@123', 'profile-img.jpg', 'Active', '67f603d45842f1744176084', '2025-04-09 05:21:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CategoryName` (`CategoryName`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblfood`
--
ALTER TABLE `tblfood`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfoodtracking`
--
ALTER TABLE `tblfoodtracking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`Ordernumber`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`FoodId`,`OrderNumber`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_token`
--
ALTER TABLE `password_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblfood`
--
ALTER TABLE `tblfood`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblfoodtracking`
--
ALTER TABLE `tblfoodtracking`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
