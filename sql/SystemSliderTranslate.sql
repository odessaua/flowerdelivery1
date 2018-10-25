/*
Navicat MySQL Data Transfer

Source Server         : next
Source Server Version : 50638
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50638
File Encoding         : 65001

Date: 2018-10-25 12:26:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `SystemSliderTranslate`
-- ----------------------------
DROP TABLE IF EXISTS `SystemSliderTranslate`;
CREATE TABLE `SystemSliderTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of SystemSliderTranslate
-- ----------------------------
