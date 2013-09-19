/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : rygbi

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2013-09-19 20:44:45
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `members`
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `email` varchar(257) NOT NULL,
  `password` varchar(256) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `billing_address1` varchar(256) NOT NULL,
  `billing_address2` varchar(256) NOT NULL,
  `billing_town` varchar(256) NOT NULL,
  `billing_postcode` varchar(256) NOT NULL,
  `rhif_ffon` varchar(20) NOT NULL,
  `notes` text NOT NULL,
  `lang_pref` varchar(2) NOT NULL,
  `secret_key` varchar(32) NOT NULL,
  `created_on` datetime NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `membership_types`
-- ----------------------------
DROP TABLE IF EXISTS `membership_types`;
CREATE TABLE `membership_types` (
  `id` int(11) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `content_cy` varchar(2048) NOT NULL,
  `content_en` varchar(2048) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `time_period` int(11) NOT NULL COMMENT 'Measured in years',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `subs`
-- ----------------------------
DROP TABLE IF EXISTS `subs`;
CREATE TABLE `subs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `membership_type_id` int(11) NOT NULL,
  `method` varchar(255) NOT NULL COMMENT 'gocardless, cheque, cash etc',
  `resource_id` varchar(256) DEFAULT NULL,
  `resource_type` varchar(256) DEFAULT NULL,
  `resource_uri` varchar(512) DEFAULT NULL,
  `signature` varchar(512) DEFAULT NULL,
  `confirmed` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'for confirming gocardless'' return request. cash/cheque will always be confirmed and paid, GC will be confirmed and pending for a while',
  `status` varchar(10) NOT NULL DEFAULT 'none',
  `ends_on` datetime NOT NULL,
  `notes` text,
  `created_on` datetime NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;
