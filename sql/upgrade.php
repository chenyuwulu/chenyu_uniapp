<?php

$installSql = <<<sql

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_user_mp_wx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `avatarUrl` varchar(255) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `openId` varchar(255) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `createtime` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

ALTER TABLE `ims_chenyu_uniapp_user_mp_wx` ADD `phone` varchar(15) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_user_mp_alipay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_user_mp_byte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL;
  `avatarUrl` varchar(255) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `openId` varchar(255) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `createtime` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_user_app_qq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `year` varchar(25) DEFAULT NULL,
  `figureurl_qq` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `openId` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_user_app_wx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `avatarUrl` varchar(255) DEFAULT NULL,
  `openId` varchar(255) DEFAULT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

sql;
$row = pdo_run($installSql);