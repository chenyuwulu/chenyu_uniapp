<?php

$installSql = <<<sql

DROP TABLE IF EXISTS `ims_chenyu_uniapp_site`;
CREATE TABLE `ims_chenyu_uniapp_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chenyu_uniapp_user_mp_wx`;
CREATE TABLE `ims_chenyu_uniapp_user_mp_wx` (
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

sql;
$row = pdo_run($installSql);