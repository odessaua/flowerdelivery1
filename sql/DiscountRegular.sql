/*
Navicat MySQL Data Transfer

Source Server         : next
Source Server Version : 50638
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50638
File Encoding         : 65001

Date: 2018-10-31 14:11:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `DiscountRegular`
-- ----------------------------
DROP TABLE IF EXISTS `DiscountRegular`;
CREATE TABLE `DiscountRegular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `active` tinyint(1) DEFAULT NULL,
  `sum` varchar(10) DEFAULT '',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `price` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of DiscountRegular
-- ----------------------------
INSERT INTO `DiscountRegular` VALUES ('1', '7roses', '1', '10', '2018-10-25 13:40:07', '2018-10-31 13:40:07', '466');
INSERT INTO `DiscountRegular` VALUES ('2', '2', '1', '20', '2018-10-30 10:25:40', '2018-11-30 10:25:40', '3000');
