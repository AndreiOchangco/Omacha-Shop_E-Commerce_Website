-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 04:53 PM
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
-- Database: `toy-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `IDcomment` int(11) NOT NULL,
  `commentText` text NOT NULL,
  `commentName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateComment` datetime NOT NULL,
  `replyText` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`IDcomment`, `commentText`, `commentName`, `email`, `dateComment`, `replyText`) VALUES
(13, 'sam oke ples', 'sam', 'sam@gmail.com', '2024-05-29 00:00:00', NULL),
(21, 'khách', 'khách', 'k@gmail.com', '2024-05-11 00:00:00', 'cảm ơn ạ'),
(28, 'chao mot ngay moi', 'linh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', NULL),
(29, '123456', 'thuylinh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', 'hello ban'),
(32, 'Đẹp quá à', 'Tran Huu Dat', 'huudat.lego@gmail.com', '2024-05-15 00:00:00', NULL),
(33, 'Testing', 'ReinFhaul', 'andreiluiseochangco123@gmail.com', '2025-11-08 00:00:00', NULL),
(34, '', 'ReinFhaul', 'andreiluiseochangco123@gmail.com', '0000-00-00 00:00:00', 'Testing reply');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_subject` varchar(255) DEFAULT NULL,
  `c_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`c_id`, `c_name`, `c_email`, `c_subject`, `c_message`) VALUES
(1, 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', 'First Contact'),
(10, 'Huudat2004', 'huudat.lego@gmail.com', '10th May', 'Hello'),
(11, 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', '8:29PM'),
(12, '', '', '', 'Hello Admin'),
(13, '', '', '', 'Hello Admin');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `d_id` int(20) NOT NULL,
  `d_name` varchar(100) NOT NULL,
  `d_amount` int(20) NOT NULL,
  `d_description` varchar(255) NOT NULL,
  `d_start_date` date DEFAULT NULL,
  `d_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`d_id`, `d_name`, `d_amount`, `d_description`, `d_start_date`, `d_end_date`) VALUES
(2, 'Wood toys for your kids', 20, 'Discount 20%', '2024-04-30', '2024-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `userID` int(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `loginpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`userID`, `userName`, `email`, `loginpassword`) VALUES
(1, 'admin', 'OmachaShop@gmail.com', '1234'),
(2, 'Omacha Shop', 'omachashopofficial@gmail.com', 'm5}$|bkr0HnwkM}1hNZ$'),
(14, 'TestA', 'TestA', '1234'),
(28, 'Louis', 'louis@gmail.com', '12345'),
(29, 'ReinFhaul', 'andreiluiseochangco123@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `o_id` int(20) NOT NULL,
  `u_id` int(20) NOT NULL,
  `p_id` int(11) NOT NULL,
  `o_price` int(20) NOT NULL,
  `o_quantity` int(10) NOT NULL,
  `o_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`o_id`, `u_id`, `p_id`, `o_price`, `o_quantity`, `o_status`) VALUES
(94, 14, 5, 11, 3, 1),
(95, 14, 1, 13, 1, 1),
(96, 14, 21, 10, 3, 1),
(105, 29, 1, 13, 1, 1),
(106, 29, 1, 13, 5, 1),
(107, 29, 3, 11, 1, 1),
(108, 29, 4, 11, 1, 1),
(109, 29, 6, 13, 2, 1),
(111, 29, 8, 11, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `od_id` int(20) NOT NULL,
  `o_id` int(20) NOT NULL,
  `od_address` varchar(255) NOT NULL,
  `od_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL,
  `p_provider` varchar(225) NOT NULL,
  `p_age` varchar(100) NOT NULL,
  `p_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_image`, `p_type`, `p_price`, `p_provider`, `p_age`, `p_description`) VALUES
(1, 'LEGO 70365 Axl', 'LEGO_70365_1.png, LEGO_70365_2.png, LEGO_70365_3.png', 'Plastic', 765.14, 'Frog Leaf', '3+ years', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Charge into battle with an even bigger Axl and send the Stone monsters flying! Also includes a super-sized buildable axe. Accessory elements include a Combo NEXO Power shield and five scannable NEXO Powers.'),
(2, 'Rabit', 'rabit.png,About-Icon-1.webp,About-Icon-2.webp', 'Plastic', 765.14, 'dun dun dun', '3+ years', 'it is very pretty'),
(3, 'Elephant Jelly Cat', 'Elephant.png', 'Cotton', 647.33, 'Cookie', '0-12 months', 'it is very pretty'),
(4, 'Unicorn', 'unicorn.png', 'Cotton', 647.33, 'Baby Logo', '1-2 years', 'it is very pretty'),
(5, 'Barbie', 'barbie.png', 'Plastic', 647.33, 'BarBie', '3+ years', 'it is very pretty'),
(6, 'Beach', 'beach.png', 'Plastic', 765.14, 'Cookie', '5+ years', 'it is very pretty'),
(7, 'Frog Duck', 'frog.png', 'Cotton', 765.14, 'Frog Leaf', '1-2 years', 'it is very pretty'),
(8, 'Bear Jelly Cat', 'bearjellycat.png', 'Cotton', 647.33, 'DiNo', '0-12 months', 'it is very pretty'),
(9, 'Giraffe Jelly Cat', 'giraffe.png', 'Cotton', 765.14, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(10, 'Bear Baby Tower', 'beartowel.png,,', 'Cotton', 765.14, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(11, 'Flower Jelly Cat', 'Jelly Cat Flower.png', 'Cotton', 647.33, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(12, 'Ring', 'ring.png', 'Wood', 500.08, 'dun dun dun', '0-12 months', 'it is very pretty'),
(13, 'Tiger Ring', 'tiger2.png', 'Cotton', 500.08, 'Baby Logo', '1-2 years', 'it is very pretty'),
(14, 'Duck', 'duck.png', 'Plastic', 309.24, 'dun dun dun', '1-2 years', 'it is very pretty'),
(15, 'Frog', 'frog1.png', 'Plastic', 500.08, 'Frog Leaf', '3+ years', 'it is very pretty'),
(16, 'Barbie Cutie Reveal', 'barbie2.png', 'Rubberized Plastic', 309.24, 'BarBie', '5+ years', 'it is very pretty'),
(17, 'Logic Matrix', 'logicmatrix.png', 'Metal', 309.24, 'Cookie', '5+ years', 'it is very pretty'),
(18, 'Music', 'music1.png', 'Wood', 500.08, 'dun dun dun', '5+ years', 'it is very pretty'),
(21, 'LEGO 70362 Clay', 'LEGO_70362_1.png,70362.jpeg,19458_lego-nexo-chien-giap-clay-tuticare-2.jpg', 'Plastic', 588.43, 'LEGO', '5+ years', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Also includes a super-sized buildable sword. Accessory elements include a Combo NEXO Power shield and 5 scannable NEXO Powers. Download the free LEGO® NEXO KNIGHTS™: MERLOK 2.0 app to your smartphone or tablet.'),
(22, 'Sticker', 'StickerCookieRun 1.png,StickerCookieRun 2.png,StickerCookieRun 3.png', 'Plastic', 588.43, 'Cookie', '5+ years', 'Sticker Very Good'),
(23, 'LEGO 70363 Macy', 'Macy 1.jpg,Macy 2.jpg,Macy 3.jpg', 'Plastic', 588.43, 'LEGO', '5+ years', 'Đặc điểm nổi bật của Lego Nexo Knights 70363 - Chiến giáp Macy:\r\nGồm 66 miếng ghép thuộc chủ đề Lego Nexo Knights mới nhất năm 2017.\r\nKết hợp chơi xếp hình và lắp ráp mô hình trong bộ Lego Nexo Knights 70363 - Chiến giáp Macy cùng công nghệ hấp dẫn khi có thể chơi cả trên ứng dụng điện thoại và máy tính bảng.');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `r_id` int(50) NOT NULL,
  `r_name` varchar(50) NOT NULL,
  `r_star` varchar(225) NOT NULL,
  `r_email` varchar(100) NOT NULL,
  `r_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`r_id`, `r_name`, `r_star`, `r_email`, `r_description`) VALUES
(3, 'Justin Bieber', '7', 'justinbieber@gmail.com', 'Using cotton buckets regularly will help your skin become cleaner, softer and brighter. However, it should be noted that excessive use can cause damage to the skin, so use gently and only periodically.'),
(23, 'HuuDat', '5', 'HuuDat', 'Hello'),
(24, 'ThuyKhanh', '4', 'ThuyKhanh', 'Đẹp quá'),
(25, 'ThuyLinh', '0', 'ThuyLinh', 'Hay lắm mua ngay nha'),
(26, 'BInhQuyen', '0', 'BInhQuyen', 'Mua liền'),
(30, 'Zalo', '0', '', 'Mua thêm đi');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`IDcomment`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `fk_u_id_user` (`u_id`),
  ADD KEY `fk_p_id_product` (`p_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `fk_order_id` (`o_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `IDcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `d_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `userID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `o_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `r_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`o_id`) REFERENCES `order` (`o_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
