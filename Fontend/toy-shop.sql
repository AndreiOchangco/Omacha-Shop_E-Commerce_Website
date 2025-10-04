/*
MySQL Data Transfer
Source Host: localhost
Source Database: toy-shop
Target Host: localhost
Target Database: toy-shop
Date: 10/4/2025 12:06:50 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `IDcomment` int(11) NOT NULL AUTO_INCREMENT,
  `commentText` text NOT NULL,
  `commentName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateComment` datetime NOT NULL,
  `replyText` text DEFAULT NULL,
  PRIMARY KEY (`IDcomment`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_subject` varchar(255) DEFAULT NULL,
  `c_message` text DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for discount
-- ----------------------------
DROP TABLE IF EXISTS `discount`;
CREATE TABLE `discount` (
  `d_id` int(20) NOT NULL AUTO_INCREMENT,
  `d_name` varchar(100) NOT NULL,
  `d_amount` int(20) NOT NULL,
  `d_description` varchar(255) NOT NULL,
  `d_start_date` date DEFAULT NULL,
  `d_end_date` date DEFAULT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for login
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `userID` int(50) NOT NULL AUTO_INCREMENT,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `loginpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `o_id` int(20) NOT NULL AUTO_INCREMENT,
  `u_id` int(20) NOT NULL,
  `p_id` int(11) NOT NULL,
  `o_price` int(20) NOT NULL,
  `o_quantity` int(10) NOT NULL,
  `o_status` int(2) NOT NULL,
  PRIMARY KEY (`o_id`),
  KEY `fk_u_id_user` (`u_id`),
  KEY `fk_p_id_product` (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `od_id` int(20) NOT NULL,
  `o_id` int(20) NOT NULL,
  `od_address` varchar(255) NOT NULL,
  `od_price` int(20) NOT NULL,
  PRIMARY KEY (`od_id`),
  KEY `fk_order_id` (`o_id`),
  CONSTRAINT `fk_order_id` FOREIGN KEY (`o_id`) REFERENCES `order` (`o_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL,
  `p_provider` varchar(225) NOT NULL,
  `p_age` varchar(100) NOT NULL,
  `p_description` text NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `r_id` int(50) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(50) NOT NULL,
  `r_star` varchar(225) NOT NULL,
  `r_email` varchar(100) NOT NULL,
  `r_description` varchar(500) NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table structure for wishlist
-- ----------------------------
DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `comments` VALUES ('13', 'sam oke ples', 'sam', 'sam@gmail.com', '2024-05-29 00:00:00', null);
INSERT INTO `comments` VALUES ('21', 'khách', 'khách', 'k@gmail.com', '2024-05-11 00:00:00', 'cảm ơn ạ');
INSERT INTO `comments` VALUES ('28', 'chao mot ngay moi', 'linh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', null);
INSERT INTO `comments` VALUES ('29', '123456', 'thuylinh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', 'hello ban');
INSERT INTO `comments` VALUES ('32', 'Đẹp quá à', 'Tran Huu Dat', 'huudat.lego@gmail.com', '2024-05-15 00:00:00', null);
INSERT INTO `contacts` VALUES ('1', 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', 'First Contact');
INSERT INTO `contacts` VALUES ('10', 'Huudat2004', 'huudat.lego@gmail.com', '10th May', 'Hello');
INSERT INTO `contacts` VALUES ('11', 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', '8:29PM');
INSERT INTO `discount` VALUES ('2', 'Wood toys for your kids', '20', 'Discount 20%', '2024-04-30', '2024-05-18');
INSERT INTO `login` VALUES ('1', 'admin', 'OmachaShop@gmail.com', '1234');
INSERT INTO `login` VALUES ('2', 'khanhne', 'Khanhne@gmail.com', '1234');
INSERT INTO `login` VALUES ('14', 'TranHuuDat', 'huudat.lego', 'huudat');
INSERT INTO `login` VALUES ('15', 'TranHuuDat123', 'huudat.mini', 'huudat');
INSERT INTO `login` VALUES ('16', 'DuongThiThuyLinh', 'DuongThiThuyLinh', '1234');
INSERT INTO `login` VALUES ('17', 'NguyenThuyKhanh', 'NguyenThuyKhanh', '1234');
INSERT INTO `login` VALUES ('19', 'TestA', 'TestA', '1234');
INSERT INTO `login` VALUES ('21', 'DaoMinhPhuc', 'DaoMinhPhuc@gmail.com', '1234');
INSERT INTO `login` VALUES ('23', 'huudat', 'huudat', 'huudat');
INSERT INTO `login` VALUES ('24', 'mini', 'mini', 'mini');
INSERT INTO `login` VALUES ('25', 'TranHuuDat', 'TranHuuDat@gmail.com', '123456');
INSERT INTO `login` VALUES ('26', 'Andrei Luise E. Ochangco', 'Andrei Luise E. Ochangco', 'O9Btwentie6@ALE0#');
INSERT INTO `order` VALUES ('70', '21', '3', '11', '5', '1');
INSERT INTO `order` VALUES ('79', '14', '6', '13', '5', '1');
INSERT INTO `order` VALUES ('84', '14', '4', '11', '1', '1');
INSERT INTO `order` VALUES ('86', '24', '2', '13', '1', '0');
INSERT INTO `order` VALUES ('87', '24', '3', '11', '1', '0');
INSERT INTO `order` VALUES ('94', '14', '5', '11', '3', '1');
INSERT INTO `order` VALUES ('95', '14', '1', '13', '3', '1');
INSERT INTO `order` VALUES ('96', '14', '21', '10', '3', '1');
INSERT INTO `product` VALUES ('1', 'LEGO 70365 Axl', 'LEGO_70365_1.png, LEGO_70365_2.png, LEGO_70365_3.png', 'Plastic', '12.99', 'LEGO', '0-12 months', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Charge into battle with an even bigger Axl and send the Stone monsters flying! Also includes a super-sized buildable axe. Accessory elements include a Combo NEXO Power shield and five scannable NEXO Powers.');
INSERT INTO `product` VALUES ('2', 'Rabit', 'rabit.png,About-Icon-1.webp,About-Icon-2.webp', 'Plastic', '12.99', 'dun dun dun', '3+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('3', 'Elephant Jelly Cat', 'Elephant.png', 'Cotton', '10.99', 'Cookie', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('4', 'Unicorn', 'unicorn.png', 'Cotton', '10.99', 'Baby Logo', '1-2 years', 'it is very pretty');
INSERT INTO `product` VALUES ('5', 'Barbie', 'barbie.png', 'Plastic', '10.99', 'BarBie', '3+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('6', 'Beach', 'beach.png', 'Plastic', '12.99', 'Cookie', '5+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('7', 'Frog Duck', 'frog.png', 'Cotton', '12.99', 'Frog Leaf', '1-2 years', 'it is very pretty');
INSERT INTO `product` VALUES ('8', 'Bear Jelly Cat', 'bearjellycat.png', 'Cotton', '10.99', 'DiNo', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('9', 'Giraffe Jelly Cat', 'giraffe.png', 'Cotton', '12.99', 'Frog Leaf', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('10', 'Bear Baby Tower', 'beartowel.png,,', 'Cotton', '12.99', 'Frog Leaf', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('11', 'Flower Jelly Cat', 'Jelly Cat Flower.png', 'Cotton', '10.99', 'Frog Leaf', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('12', 'Ring', 'ring.png', 'Wood', '8.49', 'dun dun dun', '0-12 months', 'it is very pretty');
INSERT INTO `product` VALUES ('13', 'Tiger Ring', 'tiger2.png', 'Cotton', '8.49', 'Baby Logo', '1-2 years', 'it is very pretty');
INSERT INTO `product` VALUES ('14', 'Duck', 'duck.png', 'Plastic', '5.25', 'dun dun dun', '1-2 years', 'it is very pretty');
INSERT INTO `product` VALUES ('15', 'Frog', 'frog1.png', 'Plastic', '8.49', 'Frog Leaf', '3+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('16', 'Barbie Cutie Reveal', 'barbie2.png', 'Rubberized Plastic', '5.25', 'BarBie', '5+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('17', 'Logic Matrix', 'logicmatrix.png', 'Metal', '5.25', 'Cookie', '5+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('18', 'Music', 'music1.png', 'Wood', '8.49', 'dun dun dun', '5+ years', 'it is very pretty');
INSERT INTO `product` VALUES ('21', 'LEGO 70362 Clay', 'LEGO_70362_1.png,70362.jpeg,19458_lego-nexo-chien-giap-clay-tuticare-2.jpg', 'Plastic', '9.99', 'LEGO', '5+ years', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Also includes a super-sized buildable sword. Accessory elements include a Combo NEXO Power shield and 5 scannable NEXO Powers. Download the free LEGO® NEXO KNIGHTS™: MERLOK 2.0 app to your smartphone or tablet.');
INSERT INTO `product` VALUES ('22', 'Sticker', 'StickerCookieRun 1.png,StickerCookieRun 2.png,StickerCookieRun 3.png', 'Plastic', '9.99', 'Cookie', '5+ years', 'Sticker Very Good');
INSERT INTO `product` VALUES ('23', 'LEGO 70363 Macy', 'Macy 1.jpg,Macy 2.jpg,Macy 3.jpg', 'Plastic', '9.99', 'LEGO', '5+ years', 'Đặc điểm nổi bật của Lego Nexo Knights 70363 - Chiến giáp Macy:\r\nGồm 66 miếng ghép thuộc chủ đề Lego Nexo Knights mới nhất năm 2017.\r\nKết hợp chơi xếp hình và lắp ráp mô hình trong bộ Lego Nexo Knights 70363 - Chiến giáp Macy cùng công nghệ hấp dẫn khi có thể chơi cả trên ứng dụng điện thoại và máy tính bảng.');
INSERT INTO `review` VALUES ('3', 'Justin Bieber', '7', 'justinbieber@gmail.com', 'Using cotton buckets regularly will help your skin become cleaner, softer and brighter. However, it should be noted that excessive use can cause damage to the skin, so use gently and only periodically.');
INSERT INTO `review` VALUES ('23', 'HuuDat', '5', 'HuuDat', 'Hello');
INSERT INTO `review` VALUES ('24', 'ThuyKhanh', '4', 'ThuyKhanh', 'Đẹp quá');
INSERT INTO `review` VALUES ('25', 'ThuyLinh', '0', 'ThuyLinh', 'Hay lắm mua ngay nha');
INSERT INTO `review` VALUES ('26', 'BInhQuyen', '0', 'BInhQuyen', 'Mua liền');
INSERT INTO `review` VALUES ('30', 'Zalo', '0', '', 'Mua thêm đi');
